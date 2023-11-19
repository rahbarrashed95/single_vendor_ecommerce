@extends('backend.app')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                    <li class="breadcrumb-item active">Detached Sidenav</li>
                </ol>
            </div>
            <h4 class="page-title">Hello  {{ auth()->user()->first_name.' '.auth()->user()->last_name}}</h4>
        </div>
    </div>
</div>   
<!-- end page title --> 
<div class="row d-none" id="loader">
    <div class="col-12">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
</div> 

<div id="dashboard_data">

</div>

<style>
    .btn.btn-sm{
        font-size: 12px;
    }
</style>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-xl-5">
                        <form class="row gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between" id="filter_form">
                            <div class="col-4">
                                <label for="inputPassword2" class="visually-hidden">Search</label>
                                <input type="search" class="form-control" id="inputPassword2" placeholder="Search..." name="q" value="{{ $q??''}}">
                            </div>
                            <div class="col-5">
                                <div class="d-flex align-items-center">
                                    <label for="status-select" class="me-2">Status</label>
                                    <select class="form-select" id="status-select" name="status">
                                        <option selected value="">Choose...</option>
                                        {{--<option value="pending" {{$status=='pending' ?'selected':''}}>Pending</option>
                                        <option value="Processing" {{$status=='Processing' ?'selected':''}}>Processing</option>
                                        <option value="complete" {{$status=='complete' ?'selected':''}}>Complete</option>--}}
                                        @foreach(getOrderStatus() as $key=>$value)
                                            <option value="{{$key}}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-auto">
                                <label for="submit" class="visually-hidden">Submit</label>
                                <input type="submit" class="form-control btn btn-sm btn-primary" id="submit" value="Submit">
                                
                            </div>
                        </form>                            
                    </div>
                    <div class="col-xl-7 text-left">
                        <div class="#" style="">
                            @can('product.create')
                                <a href="{{ route('admin.orders.create')}}" class="btn btn-sm btn-danger mb-1"><i class="mdi mdi-basket me-1"></i> Add New Order</a>
                            @endcan
                            
                            @can('orderStatusUPdate')
                            <a class="btn_modal btn btn-sm btn-info mb-1" href="{{ route('admin.assignUser')}}"><i class="mdi mdi-plus me-1"></i>
                                Assign User
                            </a>
                            @endcan
                            
                            <a class="btn_modal btn btn-sm btn-info mb-1" href="{{ route('admin.orderStatusUpdateMulti')}}"><i class="mdi mdi-plus me-1"></i>
                               Status Change
                            </a>
                            @can('product.delete')
                            <a class="multi_order_delete btn btn-sm btn-danger mb-1" href="{{ route('admin.deleteAllOrder')}}"><i class="mdi mdi-plus me-1"></i>
                                Delete All
                            </a>
                            @endcan
                            @php $isPending = \App\Models\Order::where(['status' => 'pending'])->first(); @endphp
                            <a class="multi_order_delete btn btn-sm btn-success mb-1 {{$isPending ? 'disabled' : ''}}" href="javascript: void(0);"><i class="mdi mdi-plus me-1"></i>
                                Print
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-4 d-none">
                        <div class="text-xl-end mt-xl-0 mt-2">
                        
                            <a type="button" href="{{ route('admin.orderExport')}}" class="btn btn-light mb-2">Export</a>
                        </div>
                    </div><!-- end col-->
                </div>
              
              
              <style>
                table tr th,td {
                  color: black;
                }
                
              </style>  
              
                
              <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-centered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input check_all" value="">
                                      </label>
                                    </div>
                                </th>

                              	<th style="width:7%">Action</th>
                                <th>Invoice ID</th>
                                <th>Date Order</th>
                                <th>Customers</th>
                                <th>Product SKU</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Assign User</th>
                                <th>Courier</th>
                                <th>Amount</th>

                              <!--  <th>Discount</th> -->
                               
                              <!--  <th>Due</th> -->
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    <input type="checkbox" class="order_checkbox" value="{{ $item->id}}">
                                    
                                </td>

                              	<td>
                                     <a href="{{$item->status === 'pending' ? 'javascript:void(0)' : route('admin.orders.show',[$item->id])}}" target="{{$item->status === 'pending' ? '' : '_blank'}}" class="action-icon " title="{{$item->status === 'pending' ? 'pending invoice will not be printed' : 'Print Invoice'}}"> <i class="fa fa-print" aria-hidden="true"></i></a>
                                    <a href="{{ route('admin.orders.edit',[$item->id])}}" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                    @can('order.delete')
                                    <a href="{{ route('admin.orders.destroy',[$item->id])}}" class="delete action-icon"> <i class="mdi mdi-delete"></i></a>
                                    @endcan
                                </td>
                                <td>#{{$item->invoice_no}}</td>
                              	<td>{{ dateFormate($item->date)}}</td>
                                <td>
                                    {{$item->first_name.' '.$item->last_name}}<br>
                                    {{$item->shipping_address}}<br>
                                    {{$item->mobile}}
                                </td>
                              <td>
                                  
                                  <?php
                                    foreach($item->details as $detail)
                                    {
                                        if(!isset($detail->product['sku']) || $detail->product['sku'] == '')
                                        {
                                            ?> <span style="color: red;">Unavailable</span> <?php
                                            
                                        } else 
                                        {
                                            echo $detail->product['sku'];
                                        }
                                    }
                                  ?>
                                
                                </td>
                                <td><a class="btn_modal" href="{{ route('admin.orderStatus', $item->id)}}">
                                        <h5 class="my-0"><span class="badge badge-info-lighten">{{$item->status}}</span></h5>
                                    </a>
                                </td>
                                <td><a class="btn_modal" href="{{ route('admin.order_payments.edit', $item->id)}}">
                                        <h5 class="my-0"><span class="badge badge-danger-lighten">{{$item->payment_status}}</span></h5>    
                                    </a>
                                </td>

                                <td>{{ $item->assign?$item->assign->username:''}}</td>
                                <td>{{ $item->courier?$item->courier->name:''}}</td>

                                <td style="color: #000;">
                                  @php 
                                    $final_amount = $item->final_amount;                                    
                                    $fa = intval($final_amount);                                    
                                   echo $fa;                                    
                                  @endphp                             
                              </td> 
                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                  	 </div>
                </div>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div> <!-- end row -->




@endsection

@push('js')

<script src="{{ asset('backend/js/order.js')}}"></script>
<script>
$(document).ready(function(){

    $(".check_all").on('change',function(){
      $(".order_checkbox").prop('checked',$(this).is(":checked"));
    });

    $(document).on('submit', 'form#order_status_update_form', function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var method = $(this).attr('method');
        let status=$(document).find('select#multi_status').val();
    
        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();
        
        if(order_ids.length ==0){
            toastr.error('Please Select An Order First !');
            return ;
        }
        
        $.ajax({
           type:'GET',
           url:url,
           data:{status,order_ids},
           success:function(res){
               if(res.status==true){
                toastr.success(res.msg);
                window.location.reload();
                
            }else if(res.status==false){
                toastr.error(res.msg);
            }
           }
        });
    
    });

    $(document).on('submit', 'form#order_assign_form', function(e){
        e.preventDefault();
        var url = $(this).attr('action');
        var method = $(this).attr('method');
        let assign_user_id=$(document).find('select#assign_user_id').val();
    
        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();
        
        if(order_ids.length ==0){
            toastr.error('Please Select An Order First !');
            return ;
        }
        
        $.ajax({
           type:'GET',
           url:url,
           data:{assign_user_id,order_ids},
           success:function(res){
               if(res.status==true){
                toastr.success(res.msg);
                window.location.reload();
                
            }else if(res.status==false){
                toastr.error(res.msg);
            }
           }
        });
    
    });

    $(document).on('click', 'a.multi_order_delete', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
    
        var order = $('input.order_checkbox:checked').map(function(){
          return $(this).val();
        });
        var order_ids=order.get();
        
        if(order_ids.length ==0){
            toastr.error('Please Select An Order First !');
            return ;
        }
        
        $.ajax({
           type:'GET',
           url:url,
           data:{order_ids},
           success:function(res){
               if(res.status==true){
                toastr.success(res.msg);
                window.location.reload();
                
            }else if(res.status==false){
                toastr.error(res.msg);
            }
           }
        });
    
    });

    

    

})
  
</script>

<script>


	
$(document).ready(function(){
	let url="{{ route('admin.getDashboardData')}}";
  	$.ajax({
      type: 'GET',
      url: url,
      data: {},
      beforeSend: function() {
			$('#loader').show();
      },
      success: function(res) {
			$('#dashboard_data').html(res);
      },
      error: function(xhr) { // if error occured

      },
      complete: function() {
			$('#loader').hide();
      },
      dataType: 'html'
  	});    

    
});
</script>
@endpush
                        