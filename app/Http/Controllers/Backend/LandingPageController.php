<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LandingPage;
use App\Models\LandingPageSlider;
use App\Models\DeliveryCharge;
use App\Models\Product;
use App\Models\Variation;
use DB;
use App\Utils\ModulUtil;
use App\Utils\Util;
use App\Models\Order;

class LandingPageController extends Controller
{

    public function index()
    {
        $items=LandingPage::all();
        return view('backend.landing_pages.index', compact('items'));
    }

    public function create()
    {
        return view('backend.landing_pages.create');
    }

    public function store(Request $request)
    {

        $data=$request->validate([
             'title1'=> 'required',
             'title2'=> 'required',
             'video_url'=> '',
             'des1' => 'required',
             'feature' => 'required',
             'old_price' => '',
             'new_price' => '',
             'phone' => '',
             'des3' => '',
             'pay_text' => '',
             'product_id' => ''
        ]);

            $landPage = LandingPage::create($data);
            if(isset($request->sliderimage)) {

            $image_data=[];
            $fileName='';
            foreach ($request->sliderimage as $key => $image) {
                $originName = $image->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                $fileName =$fileName.time().'.'.$extension;

                $image->move(public_path('landing_sliders'), $fileName);
                $image_data[]=['image'=>$fileName];
            }

            if (!empty($image_data)) {
                   $landPage->images()->createMany($image_data);
            }
        }

        return response()->json([
            'status' => true,
            'msg'    => 'Landing Page Created Successfully..!!'
        ]);

    }

    public function edit($id)
    {
        $item=LandingPage::find($id);
        $single_product = Product::with('variation')->find($item->product_id);
        return view('backend.landing_pages.edit', compact('item','single_product'));
    }

    public function delete_slider($id)
    {
        $item = LandingPageSlider::find($id);
        deleteImage('landing_sliders', $item->image);
        $item->delete();
        return back();
    }

    public function update(Request $request, $id)
    {

        $updatePage = LandingPage::find($id);
        $data=$request->validate([
            'title1'=> 'required',
             'title2'=> 'required',
             'video_url'=> '',
             'des1' => 'required',
             'feature' => 'required',
             'old_price' => '',
             'new_price' => '',
             'phone' => '',
             'des3' => '',
             'pay_text' => '',
             'product_id' => ''
       ]);
       
       if($request->new_product_id != null)
      {
          $data['product_id'] = $request->new_product_id;
      }

           if(isset($request->sliderimage)) {

           $image_data=[];
           $fileName='';
           foreach ($request->sliderimage as $key => $image) {
               $originName = $image->getClientOriginalName();
               $fileName = pathinfo($originName, PATHINFO_FILENAME);
               $extension = $image->getClientOriginalExtension();
               $fileName =$fileName.time().'.'.$extension;

               $image->move(public_path('landing_sliders'), $fileName);
               $image_data[]=['image'=>$fileName];
           }

           if (!empty($image_data)) {
                $updatePage->images()->createMany($image_data);
           }

       }

       $updatePage->update($data);

       return response()->json([
        'status' => true,
        'msg'    => 'Landing Page Updated Successfully..!!'
       ]);

    }


    public function landing_page($id)
    {
        $ln_pg = LandingPage::with('images')->find($id);
        $charges=DeliveryCharge::whereNotNull('status')->get();
        return view('backend.landing_pages.land_page', compact('ln_pg','charges'));
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

            if($request->payment_method == 'nogod' || $request->payment_method == 'bkash' || $request->payment_method == 'rocket')
              {
                   $order->payments()->create([
                    'amount'=> $order->final_amount,
                    'account_no'=> $request->pay_num,
                    'tnx_id'=> $request->tnx_id,
                    'method'=> $request->payment_method,
                    'date'=> date('Y-m-d'),
                    'note'=> '',
                  ]);

                  $order->payment_status = $request->payment_method.'_pending';
                  $order->save();

                  /* send sms */

                  DB::commit();

                  session()->put('cart',[]);
                  session()->put('coupon_discount',null);
                  session()->put('discount_type',null);

                  $url=route('front.confirmOrder',[$order->id]);
                  return response()->json(['success'=>true,'msg'=>'Order Create successfully!','url'=>$url]);
                 }  else if($request->payment_method == 'stripe')

                     {
                             \Stripe\Stripe::setApiKey('sk_test_51MqweQJRdIwi69uLqYCCskJ2yEzljmB9gKECTX8Oq69ypKPRnFi4eGQ2aukb0fROFpwqavigEt2OcJRBqlngI6AV00vgFvfpqr');
                              $charge = \Stripe\Charge::create([
                                  'source' => $_POST['stripeToken'],
                                  'description' => "10 cucumbers from Roger's Farm",
                                  'amount' => $request->input('amount'),
                                  'currency' => 'usd'
                              ]);

                                if($charge->status == 'succeeded'){
                            OrderPayment::create([
                                'order_id' => $order->id,
                                'amount'=> $order->final_amount,
                                'account_no'=> $request->input('mobile'),
                                'tnx_id'=> '123',
                                'method'=> 'Stripe',
                                'date'=> date('Y-m-d'),
                                'note'=> ''
                            ]);

                            $order->payment_status = 'Stripe Completed';
                            $order->save();

                            DB::commit();
                            session()->put('cart',[]);
                            session()->put('coupon_discount',null);
                            session()->put('discount_type',null);

                            return redirect()->route('front.confirmOrder',[$order->id]);
                  }
            }
              else
            {
            	  $url=route('front.confirmOrder',[$order->id]);
                  session()->put('cart',[]);
                  session()->put('coupon_discount',null);
                  session()->put('discount_type',null);
                  $msg='প ('.$order->first_name.'),Demo1 ডা ('.$order->invoice_no.') সলভ  য়ছ
            প  কে আ ঘ নে ক  ব ।  ত া 09696801173 ব    ধ';
          	$number=$order->mobile;
        // 	$success=SendSms($number ,$msg);
        $success = 'test';
            DB::commit();
            return response()->json(['success'=>true,'msg'=>'Order Create successfully!','url'=>$url]);
            }


        } catch (\Exception $e) {

            DB::rollback();

            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        $single_page = LandingPage::with('images')->find($id);

        if($single_page)
        {
            deleteImage('landing_pages', $single_page->image);
        }

        if ($single_page->images()->count() >= 1) {
            foreach ($single_page->images as $key => $slider_image) {
               deleteImage('landing_sliders', $slider_image);
            }
        }

        $single_page->delete();

        return response()->json([
            'status' => true,
            'msg'     => 'Landing Page Deleted Successfully..!!!'
        ]);

    }

}
