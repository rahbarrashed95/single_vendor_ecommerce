@extends('backend.app')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
@endpush
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">SIS</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                    <li class="breadcrumb-item active">Purchase Edit</li>
                </ol>
            </div>
            <h4 class="page-title">Purchase Edit</h4>
        </div>
    </div>
</div>   
<!-- end page title --> 

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.purchase.update', $item->id)}}" id="ajax_form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-lg-12 row">
                            
                            <div class="col-md-4">
                                <label class="form-label">Pick a Date</label>
                                <input type="date" class="form-control" value="{{$item->date}}" required name="date" />
                            </div>
                            <div class="col-md-4">
                                <label for="validationDefault02" class="form-label">Reference Number</label>
                                <input type="text" class="form-control" id="validationDefault02" value="{{ $item->ref}}" name="ref" />
                            </div>                            
                            <div class="col-md-4">
                                <label  class="form-label">Order Status</label>
                                <select class="form-select" required name="status">
                                    <option selected disabled value="">Choose...</option>
                                    <option value="pending" @if($item->status == 'pending') selected @endif>Pending</option>
                                    <option value="received" @if($item->status == 'received') selected @endif>Received</option>
                                    <option value="ordered" @if($item->status == 'ordered') selected @endif>Ordered</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>

                        <div class="col-lg-12">
                            <div class="row height d-flex justify-content-center align-items-center">

                                <div class="col-md-8">
                                    <div class="search">
                                        <input type="text" id="search" class="form-control" placeholder="product search here">
                                    </div>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-lg-12 mt-2">
                            <table class="table table-centered table-nowrap mb-0" id="product_table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Size</th>
                                        <th>Color</th>
                                        <th>Quantity</th>
                                        <th>Sell Price</th>
                                        <th>Subtotal</th>
                                        <th style="width: 125px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="data">
                                    @foreach($item->lines as $line)
                                        <tr>
                                            <td>{{$line->products->name}}</td>
                                            <td>{{$line->variation->size->title}}</td>
                                            <td>{{$line->variation->color->name}}</td>
                                            <td>
                                                <input class="form-control quantity" name="quantity[]" type="number" value="{{$line->quantity}}" required min="1"/>
                                                <input type="hidden" name="product_id[]" value="{{$line->product_id}}" required/>
                                                <input type="hidden" name="variation_id[]" value="{{$line->variation_id}}"/>
                                                <input type="hidden" name="purchase_line_id[]" value="{{$line->id}}"/>
                                            </td>
                                            <td><input class="form-control unit_price" name="unit_price[]" type="number" value="{{$line->products->purchase_price}}" required/></td>
                                            <td class="row_total">{{$line->products->purchase_price}}</td>
                                            <td><a class="remove btn btn-sm btn-danger"> - 
                                        </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        <div class="col-lg-12 row mt-3">
                            <div class="col-md-6">
                                <label  class="form-label"> Note</label>
                                <textarea class="form-control" name="note" placeholder="note">{{$item->note}}</textarea>
                            </div> 

                            <div class="col-md-3">
                                <label  class="form-label">Purchase Total</label>
                                <input type="text" class="form-control" value="00" name="amount" id="purchase_total" />
                            </div> 
                            <hr>
                        </div>



                        <div class="col-12 mt-2">
                            <button class="btn btn-success" type="submit">Update Purchase</button>
                        </div>
                    </div>

                </form>
       
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection 

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    var path = "{{ route('admin.getPurchaseProduct') }}";
    const products=[];
    calculateSum();
    $( "#search" ).autocomplete({
        selectFirst: true, //here
        minLength: 2,
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
                
                if (data.length ==0) {
                    toastr.error('Product Not Found');
                }
                else if (data.length ==1) {

                    if(products.indexOf(data[0].id) ==-1){
                        productEntry(data[0]);
                        products.push(data[0].id);
                    }
                    
                    $('#search').val('');


                    
                }else if (data.length >1) {
                    response(data);
                }
            }
          });
        },
        select: function (event, ui) {
           
           if(products.indexOf(ui.item.id) ==-1){
                productEntry(ui.item);
                products.push(ui.item.id);
            }

           $('#search').val('');
           return false;
        }
      });

    function productEntry(item){

        $.ajax({
            url: '{{ route("admin.purchaseProductEntry")}}',
            type: 'GET',
            dataType: "json",
            data: {id:item.id},
            success: function( res ) {
                    
                if (res.html) {
                    $('tbody#data').append(res.html);
                    calculateSum();
                }
                
            }
          });
    }

    $(document).on('click',".remove",function(e) {
        var whichtr = $(this).closest("tr");
        whichtr.remove();  
        calculateSum();    
    });


    $(document).on('blur',".quantity, .unit_price",function(e) {

        calculateSum();    
    });


    function calculateSum() {
        let tblrows = $("#product_table tbody tr");

        let sub_total=0;
        tblrows.each(function (index) {
            let tblrow = $(this);

            let qty=Number(tblrow.find('td input.quantity').val());
            let amount=Number(tblrow.find('td input.unit_price').val());

            let row_total=(qty *amount);
            tblrow.find('td.row_total').text(row_total.toFixed(2));
            sub_total+=row_total;
         
            
        });

        $('input#purchase_total').val(sub_total.toFixed(2));
    }

  
</script>

@endpush