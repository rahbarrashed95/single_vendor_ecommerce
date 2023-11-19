<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use App\Models\Courier;
use Illuminate\Http\Request;
use DB;
use App\Exports\OrderReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function orderReport()
    {
        $details = OrderDetails::with(['order', 'product', 'variation'])
          ->whereHas('order', function($q){
            $q->whereNotNull('invoice_no');
          })          
          ->whereHas('product', function($q){
            $q->whereNotNull('name');
          })
          ->latest()->paginate(100);
        
        $users = User::with('roles')->get();
        
        $users = User::with("roles")->whereHas("roles", function($q) {
                    $q->whereIn("name", ["admin", "worker"]);
                })->get();
 
        $couriers = Courier::all();
        
        return view('backend.reports.order', compact('details', 'users', 'couriers'));
    }
    
    public function filterOrder(Request $request)
    {     
      /*
      $details = OrderDetails::join('orders as o', 'order_details.order_id', 'o.id')
                                ->join('products as p', 'order_details.product_id', 'p.id')
                                ->join('variations as v', 'order_details.variation_id', 'v.id')
                                ->select('o.*', 'order_details.*', 'p.*', 'v.*')
                                ->where('o.date', '2023-03-15')
                                ->where('status', 'on_the_way')
                                ->paginate(20);
                                */
    
        $details = OrderDetails::join('orders as o', 'order_details.order_id', 'o.id')
                                ->join('products as p', 'order_details.product_id', 'p.id')
                                ->join('variations as v', 'order_details.variation_id', 'v.id')
                                ->select('o.*', 'order_details.*', 'p.*', 'v.*')
                                ->where(function($query){
                                   if(!empty(request()->status))
                                    {
                                        $query->where('o.status', request()->status);
                                    }  
                                    
                                    if(!empty(request()->input('query')))
                                    {
                                        $query->where('o.invoice_no', 'like', '%'.request()->input('query').'%')
                                                ->orWhere('p.name', 'like', '%'.request()->input('query').'%');
                                    }        
                                    
                                    if(!empty(request()->from && request()->to))
                                    {
                                         $query->whereBetween('o.date', [request()->from, request()->to]);
                                    }        
                                    
                                    if(!empty(request()->assign))
                                    {
                                        $query->where('o.assign_user_id', request()->assign);
                                    }                                    
                                    
                                    if(!empty(request()->courier))
                                    {
                                        $query->where('o.courier_id', request()->courier);
                                    }
                                })
                                ->paginate(100)
                                ->appends($request->all());      
  
        
        $users = User::with('roles')->get();
        
        $users = User::with("roles")->whereHas("roles", function($q) {
                    $q->whereIn("name", ["admin", "worker"]);
                })->get();
                
        $couriers = Courier::all();
        
        return view('backend.reports.order', compact('details', 'users', 'couriers'));        
      
    }
  
  public function productReport()
    {
    	$details = OrderDetails::Leftjoin("products as p", "order_details.product_id","p.id")  
                              ->Leftjoin("orders as o","o.id","order_details.order_id")              
                              ->select("p.id","p.name","order_details.unit_price",DB::raw("SUM(quantity) as total_qty"))
                              ->groupBy('p.id','p.name','order_details.unit_price')    
                              ->get();
      $users = User::with('roles')->get();
        
        $users = User::with("roles")->whereHas("roles", function($q) {
                    $q->whereIn("name", ["admin", "worker"]);
                })->get();
 
        $couriers = Courier::all();
        
        return view('backend.reports.product', compact('details', 'users', 'couriers'));
      
    }
  
  public function filterProduct(Request $request){  
      
      $details = OrderDetails::Leftjoin("products as p", "order_details.product_id","p.id")  
                              ->Leftjoin("orders as o","o.id","order_details.order_id")              
                              ->select("p.id","p.name","order_details.unit_price",DB::raw("SUM(quantity) as total_qty"))
                               ->where(function($query){
                                 if(!empty(request()->status))
                                 {
                                   $query->where('o.status', request()->status);
                                 }
                                 if(!empty(request()->from && request()->to))
                                    {
                                         $query->whereBetween('o.date', [request()->from, request()->to]);
                                    }        
                                    
                                    if(!empty(request()->assign))
                                    {
                                        $query->where('o.checked_by', request()->assign);
                                    }                                    
                                    
                                    if(!empty(request()->courier))
                                    {
                                        $query->where('o.courier_id', request()->courier);
                                    }
                               })
                               ->groupBy('p.id','p.name','order_details.unit_price')       
                              ->get();    
      
        $users = User::with('roles')->get();
        
        $users = User::with("roles")->whereHas("roles", function($q) {
                    $q->whereIn("name", ["admin", "worker"]);
                })->get();
 
        $couriers = Courier::all();
        
        return view('backend.reports.product', compact('details', 'users', 'couriers'));
    }
  
    public function exportOrderReport()
    {
      	$details = OrderDetails::join('orders as o', 'order_details.order_id', 'o.id')
                                ->join('products as p', 'order_details.product_id', 'p.id')
                                ->join('variations as v', 'order_details.variation_id', 'v.id')
                                ->select('o.*', 'order_details.*', 'p.*', 'v.*')
                                ->where(function($query){
                                   if(!empty(request()->status))
                                    {
                                        $query->where('o.status', request()->status);
                                    }  
                                    
                                    if(!empty(request()->input('query')))
                                    {
                                        $query->where('o.invoice_no', 'like', '%'.request()->input('query').'%')
                                                ->orWhere('p.name', 'like', '%'.request()->input('query').'%');
                                    }        
                                    
                                    if(!empty(request()->from && request()->to))
                                    {
                                         $query->whereBetween('o.date', [request()->from, request()->to]);
                                    }        
                                    
                                    if(!empty(request()->assign))
                                    {
                                        $query->where('o.assign_user_id', request()->assign);
                                    }                                    
                                    
                                    if(!empty(request()->courier))
                                    {
                                        $query->where('o.courier_id', request()->courier);
                                    }
                                })
                                ->orderBy('order_details.created_at', 'desc')->get();
      
         	return Excel::download(new OrderReportExport($details), 'order_report.xlsx');
    }
  
}


