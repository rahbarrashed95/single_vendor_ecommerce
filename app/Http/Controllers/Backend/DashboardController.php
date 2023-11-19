<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use DB;


class DashboardController extends Controller
{
    public function index(Request $request){
        
      	if(!auth()->user()->can('dashboard.access'))
        {
            abort(403, 'unauthorized');
        }
        
        $status=$request->status;
        $q=$request->q;
		$query=Order::whereHas('details.product', function($q){
          			$q->whereNotNull('name');
        	});
                if(!empty($q)){
                    $query->where(function($row) use ($q){
                        $row->where('invoice_no','Like','%'.$q.'%');
                    });
                }
                
                if(!empty($status)){
         
                    $query->where('status','Like','%'.$status.'%');
                    
                }
                
                if(Auth::user()->hasRole('worker'))
                {
                    $query->where('assign_user_id', Auth::id());
                }        
        
        $items=$query->latest()->take(20)->get();       
        $statuses=getOrderStatus();
        return view('backend.dashboard', compact('items','status','q','statuses'));
    }
  
  	public function getDashboardData(){
    	$data['products']=Product::count();
      	$data['orders']=Order::count();
      	$data['users']=User::with('roles')->count();
        $data['current_month_sell']=Order::whereMonth('created_at', date('m'))->sum('final_amount');
      	$data['today_sell']=Order::whereDate('created_at', date('Y-m-d'))->sum('final_amount');
        $data['prev_month_sell']=Order::whereBetween('created_at', 
                                    [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]
                                )->sum('final_amount');
     	return view('backend.partials.dashboard_data', $data);
	}
  
}
