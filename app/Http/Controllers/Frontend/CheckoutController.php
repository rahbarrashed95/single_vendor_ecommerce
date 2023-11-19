<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderDetails;
use App\Models\DeliveryCharge;
use App\Utils\ModulUtil;
use App\Utils\Util;
use App\Models\CouponCode;
use App\Models\User;
use App\Models\Product;
use App\Models\Variation;

class CheckoutController extends Controller
{
    public $modulutil;
    public $util;

    public function __construct(ModulUtil $modulutil, Util $util){

        $this->util=$util;
        $this->modulutil=$modulutil;
    }
    
    public function index(){
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('front.home');
        }
      
      	$charges=DeliveryCharge::whereNotNull('status')->get();
      	
      	$coupon=session()->get('coupon_discount');
 		$coupn_item=CouponCode::where('amount', $coupon)->first();
      	
 
        $cart = session()->get('cart');
        $total=getCouponDiscount();

        if($cart){
            foreach($cart as $id=>$item){
                $total +=$item['price'] * $item['quantity'];
            }
        }
      
      if(($coupn_item) && ($coupon >0) && ($coupn_item->minimum_amount > $total)){
        	session()->put('coupon_discount',null);
        	session()->put('discount_type',null);
        
      }
      
        return view('frontend.cart.checkout', compact('cart','charges'));
    }
    
     public function storelandData(Request $request) {
         
        $data=$request->validate([
            'mobile' => 'digits_between:11,11',
            'first_name' => 'required',
            'payment_method' => '',
            'shipping_address' => 'required',
            'note' => '',
          	'delivery_charge_id' => 'required|numeric',
            'final_amount' => '',
            'amount'  => ''
        ]);
       
        
        if(empty(auth()->user()->id)){
        	$user = User::create([
              'first_name' => $request->first_name,
              'mobile' => $request->mobile,
              'shipping_address' => $request->shipping_address,
              'note' => $request->note
            ]);
          $data['user_id']=$user->id;

        } else {
        	$data['user_id']=auth()->user()->id;
        }

        $product = Product::with('variations')->where('id', $request->prd_id)->first();
        // $v_id = Variation::where('product_id', $product->id)->first()->id;
        
        $quantity = $request->quantity;
        
        if($quantity == null || $quantity == '')
        {
            $proQty = 1;
        } else {
            $proQty = $quantity;
        }
        
        $total_discount_val = $proQty * $product['discount'];
        
            $pr_data = [
                'product_id' => $request->prd_id,
                'quantity' => $proQty,
                'unit_price' => $request['amount'],
                'discount' => $product['discount'],
                'is_stock' => $product['is_stock'],
                'variation_id' => $request['variation_id']
            ];
       

      	$charge=DeliveryCharge::where('id', $data['delivery_charge_id'])->first();      	;
      	$charge=$charge?$charge->amount:0;
        $data['date']=date('Y-m-d');

        // Order Assign Among Users Start

        $usrs = DB::table('model_has_roles')->where('role_id', 8)->get();
        $verified_users = [];

        foreach($usrs as $user) {
           $test = DB::table('users')->where('id', $user->model_id)->first();

            if ($test->status == 1) {
                $verified_users[] = $user->model_id;
            }
        }

        $keyValue = array_rand($verified_users);
        $data['assign_user_id'] = $verified_users[$keyValue];
       
        // Order Assign Among Users End

        //$data['invoice_no']=time();
        $data['invoice_no']=rand(111111,999999);
        $data['discount']= $total_discount_val;
        $data['shipping_charge']= $charge;
        $data['courier_id']=3;
        
        DB::beginTransaction();
        try {

            unset($data['payment_method']);       

            $order=Order::create($data);

            if (!empty($pr_data)) {

			  $order->details()->create($pr_data);

            }

            $this->modulutil->orderPayment($order, $request->all());
            $this->modulutil->orderstatus($order);
            $url=route('front.confirmOrderlanding',[$order->id]);
            session()->put('cart',[]);
            session()->put('coupon_discount',null);
            session()->put('discount_type',null);
            $msg='You Got An Order';
          	$number=$order->mobile;
        // 	$success=SendSms($number ,$msg);
            $success = 'test';
            DB::commit();
            return response()->json([
                'success' => true,
                'msg'    => 'Checkout Successfully..!!',
                'url'     => $url
            ]);

        } catch (\Exception $e) {

            DB::rollback();

            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function store(Request $request){
       
        $data=$request->validate([
            'mobile' => 'digits_between:11,11',
            'first_name' => 'required',            
            'payment_method' => 'required',
            'shipping_address' => 'required',  
          	'ip_address' => 'required',
            'note' => '',
          	'delivery_charge_id' => 'required|numeric',          
        ]);
      
        if(empty(auth()->user()->id)){
        	$user = User::create([
              'first_name' => $request->first_name,
              'mobile' => $request->mobile,
              'shipping_address' => $request->shipping_address,
              'note' => $request->note
            ]);
          $data['user_id']=$user->id;
          
        } else {
        	$data['user_id']=auth()->user()->id;
        }

        $carts=session()->get('cart',[]);
      	$coupn_discount=getCouponDiscount();
   
        $product=[];
        if ($carts) {
            $total=0;
            $total_discount=0;
            foreach($carts as $key=>$item){
                $total +=$item['quantity'] * $item['price'];
                $total_discount +=$item['quantity'] * $item['discount'];
                $product[]=[
                    'product_id'=>$item['product_id'],
                    'quantity'=>$item['quantity'],
                    'unit_price'=>$item['price'],
                    'variation_id'=>$item['variation_id'],
                    'discount'=>$item['discount'],
                    'is_stock'=>$item['is_stock'],
                ];

            }
            
           
        } 
      
      	$charge=DeliveryCharge::find($data['delivery_charge_id']);
      	$charge=$charge?$charge->amount:0;
        $data['date']=date('Y-m-d');
        
        // Order Assign Among Users Start
       
        $usrs = DB::table('model_has_roles')->where('role_id', 8)->get();
        $verified_users = [];
        
        foreach($usrs as $user) {
           $test = DB::table('users')->where('id', $user->model_id)->first();
           
            if ($test->status == 1) {
                $verified_users[] = $user->model_id;
            }
        }
        
        $keyValue = array_rand($verified_users);
        $data['assign_user_id'] = $verified_users[$keyValue];
        
        // Order Assign Among Users End
        
        //$data['invoice_no']=time();
        $data['invoice_no']=rand(111111,999999);
        $data['discount']=$total_discount+$coupn_discount;
        $data['amount']=$total_discount+$total;
        $data['shipping_charge']=$charge;
      	$data['final_amount']=$total + $charge-$coupn_discount;		
      	
        DB::beginTransaction();
        try {
            
            unset($data['payment_method']);
            $order=Order::create($data);

            if (!empty($product)) {    
              
                foreach ($product as $key => $item) {                  
                  if($item['is_stock'] != 0) {
                  		$stock=$this->util->checkProductStock($item['product_id'], $item['variation_id']);
                        if($stock < $item['quantity']){
                            return response()->json(['success'=>false,'msg'=>' Stock Note Available!']);
                        }
                    	$this->util->decreaseProductStock($item['product_id'], $item['variation_id'],$item['quantity']);
                  }                 
                  
                }             
              
			  $order->details()->createMany($product);
        
            }    
          
            $this->modulutil->orderPayment($order, $request->all());
            $this->modulutil->orderstatus($order);
    	    DB::commit();            
            session()->put('cart',[]);
            session()->put('coupon_discount',null);
            session()->put('discount_type',null); 
            
            $msg = 'You Got An Order';
          	$number=$order->mobile;
        	$success=SendSms($number ,$msg);  
                  
            $url=route('front.confirmOrder',[$order->id]);
            return response()->json(['success'=>true,'msg'=>'Order Create successfully!','url'=>$url]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
    
    public function storeData(Request $request)
    {

        $data=$request->validate([
            'mobile' => 'digits_between:11,11',
            'first_name' => 'required',
            'payment_method' => '',
            'shipping_address' => 'required',
            'note' => '',
          	'delivery_charge_id' => 'required|numeric',
        ]);

        if(empty(auth()->user()->id)){
        	$user = User::create([
              'first_name' => $request->first_name,
              'mobile' => $request->mobile,
              'shipping_address' => $request->shipping_address,
              'note' => $request->note
            ]);
          $data['user_id']=$user->id;

        } else {
        	$data['user_id']=auth()->user()->id;
        }

        $product = Product::with('variations')->where('id', $request->prd_id)->first();
        $v_id = Variation::where('product_id', $product->id)->first()->id;
        
        $pr_data = [
            'product_id' => $product['id'],
            'quantity' => 1,
            'unit_price' => $product['sell_price'],
            'discount' => $product['discount'],
            'is_stock' => $product['is_stock'],
            'variation_id' => $v_id
        ];

      	$charge=DeliveryCharge::find($data['delivery_charge_id']);
      	$charge=$charge?$charge->amount:0;
        $data['date']=date('Y-m-d');

        // Order Assign Among Users Start

        $usrs = DB::table('model_has_roles')->where('role_id', 8)->get();
        $verified_users = [];

        foreach($usrs as $user) {
           $test = DB::table('users')->where('id', $user->model_id)->first();

            if ($test->status == 1) {
                $verified_users[] = $user->model_id;
            }
        }

        $keyValue = array_rand($verified_users);
        $data['assign_user_id'] = $verified_users[$keyValue];

        // Order Assign Among Users End


        //$data['invoice_no']=time();
        $data['invoice_no']=rand(111111,999999);
        $data['discount']= $product['discount'];
        $data['amount']= $product['sell_price'];
        $data['shipping_charge']= $charge;
      	$data['final_amount']=$product['sell_price'];

        DB::beginTransaction();
        try {

            unset($data['payment_method']);            

            $order=Order::create($data);

            if (!empty($pr_data)) {

			  $order->details()->create($pr_data);

            }

            $this->modulutil->orderPayment($order, $request->all());
            $this->modulutil->orderstatus($order);
            
      	    $url=route('front.confirmOrder',[$order->id]);
            session()->put('cart',[]);
            session()->put('coupon_discount',null);
            session()->put('discount_type',null);
            
            $msg='You Got An Order';
          	$number=$order->mobile;
        // 	$success=SendSms($number ,$msg);
            $success = 'test';
            
            DB::commit();
            return response()->json([
                'success' => true,
                'msg'    => 'Checkout Successfully..!!'
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }
  
    public function StoreChk(Request $request){
      
      $this->validate($request, [
    		'first_name' => 'required',
            'mobile' => 'required',
            'shipping_address' => 'required',
           'delivery_charge_id' => 'required'
      ]);
      
       $user = User::create([
            'first_name' => $request->input('firstname'),
            'last_name' => $request->input('lastname'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),            
            'note' => $request->input('note'),
        ]);


        $carts=session()->get('cart',[]);
      	$coupn_discount=getCouponDiscount();
   
        $product=[];
        if ($carts) {
            $total=0;
            $total_discount=0;
            foreach($carts as $key=>$item){
                $total +=$item['quantity'] * $item['price'];
                $total_discount +=$item['quantity'] * $item['discount'];
                $product[]=[
                    'product_id'=>$item['product_id'],
                    'quantity'=>$item['quantity'],
                    'unit_price'=>$item['price'],
                    'variation_id'=>$item['variation_id'],
                    'discount'=>$item['discount'],
                ];
            }
        }


        $data = array();       
        $delivery_charge_id = $request->input('delivery_charge_id');        
        $charge=DeliveryCharge::find($delivery_charge_id);        
      	$charge=$charge?$charge->amount:0;

          $data['date']=date('Y-m-d');
          $data['user_id']=$user->id;
          $user = DB::table('model_has_roles')->where('role_id', 8)->inRandomOrder()->first();
          if($user)
          {
               $data['assign_user_id'] = $user->model_id;
          }
          else  $data['assign_user_id'] = 1;          
          $data['invoice_no']=time();
          $data['discount']=$total_discount+$coupn_discount;
          $data['amount']=$total_discount+$total;
          $data['delivery_charge_id']=$request->input('delivery_charge_id');
          $data['shipping_charge']=$charge;
          $data['final_amount']=$total + $charge-$coupn_discount;

          $data['first_name']=$request->input('firstname');
          $data['last_name']=$request->input('lastname');
          $data['email']=$request->input('email');
          $data['shipping_address']=$request->input('shipping_address');
          $data['mobile']=$request->input('mobile');
          $data['note']=$request->input('note');

          DB::beginTransaction();
          try {
             unset($data['payment_method']);
             $order=Order::create($data);
  
              if (!empty($product)) {
                  
                  foreach ($product as $key => $item) {
                      $stock=$this->util->checkProductStock($item['product_id'], $item['variation_id']);
                    
                      if($stock <$item['quantity']){                        
                          return response()->json(['success'=>false,'msg'=>' Stock Note Available!']);
                      }
                    
                      $this->util->decreaseProductStock($item['product_id'], $item['variation_id'],$item['quantity']);
                    
                  }
                  $order->details()->createMany($product);
              }
              $this->modulutil->orderPayment($order, $request->all());
              $this->modulutil->orderstatus($order);

               OrderPayment::create([
                'order_id' => $order->id,
                'amount'=> $order->final_amount,
                'account_no'=> $request->input('mobile'),
                'tnx_id'=> $request->input('tnx_id'),
                'method'=> 'paypal',
                'date'=> date('Y-m-d'),
                'note'=> ''
            ]);          
 
            
            $order->payment_status = 'Paypal Completed';
            $order->save();
  
            DB::commit();  
              
            session()->put('cart',[]);
            session()->put('coupon_discount',null);
            session()->put('discount_type',null);
            
            
            $url=route('front.confirmOrder',[$order->id]);
            return response()->json(['success'=>true,'msg'=>'Order Create successfully!','url'=>$url]);
  
          } catch (\Exception $e) {
              
              DB::rollback();
  
              return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
          }

        
    }
  
  	public function getCouponDiscount(Request $request){
        
        $data=$request->validate([
            'code' => 'required'
        ]);
        
        $cart = session()->get('cart');
        $total=0;
        if($cart){
            foreach($cart as $id=>$item){
                $total +=$item['price'] * $item['quantity'];
            }
        }
        
        $item=CouponCode::where('code',$request->code)
                    ->where(function($row) use($total){
                        $row->where('minimum_amount','0')
                            ->orWhereNull('minimum_amount')
                            ->orWhere('minimum_amount','<=',$total);
                    })
                    ->whereDate('start','<=', date('Y-m-d'))
                    ->whereDate('end','>=', date('Y-m-d'))->first();
        
        if($item){
            session()->put('coupon_discount', $item->amount);
            session()->put('discount_type', $item->discount_type);
            return response()->json(['success'=>true,'msg'=>'You Got Coupon Discount!']);
        }else{
            return response()->json(['success'=>false,'msg'=>'Not Found Any Coupon Discount!']);
        }
    }

}
