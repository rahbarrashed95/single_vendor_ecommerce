@extends('frontend.app')
@section('content')

<style>
  .stripe-button-el {
	display: none;

}    
  input[type='text'], input[type='number'], #selectCourier {
      border: 1px solid #00276C;
    }
</style>  

@php
use App\Models\Information;
use App\Models\BanglaText;
$info = Information::first();
$bangla_text = BanglaText::first();
$coupon_visibility = $info->coupon_visibility;
@endphp

<main class="main-wrapper">
  
  <section class="section-content padding-y bg slidetop" style="margin-top:60px">
        <div class="container">
            <div class="row">
                <div class="col-md-6">                   
                  <form action="{{ route('front.checkouts.store')}}" method="POST" id="checkout_form">
                	@csrf
                    <aside class="card mb-4">

                        <article class="card-body">
                            <header class="" style="padding: 3px;
    margin-bottom: 25px;                        
    padding-top: 8px;
    padding-right: 5px;
    padding-left: 5px;
    border-width: 1px;
    border-style: solid;
    border-color: rgba(238, 238, 238, 1);
    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);">
                                                                 <p style="margin-bottom: 20px;">{{ $bangla_text->checkout_form_top_text }}</p>
                            </header>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                     <label>{{ $bangla_text->name_text }}</label>
                                    <input type="text" name="first_name" placeholder="" class="form-control">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>{{ $bangla_text->mobile_text }}</label>
                                    <input type="text" maxlength="11" name="mobile" placeholder=""
                                           class="form-control">
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>{{ $bangla_text->address_text }}</label>
                                    <input type="text"  name="shipping_address" class="form-control"
                                           placeholder="">
                                </div>
                                
                                <!-- ip address -->
                                  <input type="hidden" name="ip_address" id="ip_address" value="">


                                   <?php
                                   
                                     $shipping_value = [];
                                     
                                     foreach($cart as $key=>$item) {
                                       $shipping_value[] = $item['is_free_shipping'];
                                     }
                                     
                                   if(in_array(null, $shipping_value)) {
                                         ?>
                                         
                                         <div class="form-group col-sm-12">
                                    <label>
								{{ $bangla_text->delivery_text }}</label>
                                    <select required name="delivery_charge_id" id="selectCourier" class="form-control" style="font-size:12px !important;">
                                       <option value="" disabled selected>{{ $bangla_text->select_text }}</option>	
                                      @foreach($charges as $key=>$charge)
                                        	<option value="{{ $charge->id}}" data-charge="{{ $charge->amount}}">{{ $charge->title }}</option>
                                        @endforeach  
                                    </select>
                                </div>
                                         
                                          
                                         
                                         <?php
                                     } else {
                                         ?>
                                         <div class="form-group col-sm-12">
                                        <label> ফ্রী শিপিং  </label>     
                                        <select name="delivery_charge_id" class="form-control">
                                            <option value="0"> ফ্রী শিপিং </option>
                                        </select>
                                         </div>
                                         <?php
                                     }
                                     
                                   ?>
                                
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" id="chk_btn"
                                            class="checkout-btn btn btn-lg btn-info btn-base-1 btn-block btn-icon-left strong-500 hov-bounce hov-shaddow buy-now"
                                            style="font-size:20px !important; background:#FFC610 !important; color:#00276C !important">{{ $bangla_text->order_confirm_text }}</button>
                                </div>
                            </div>
                        </article> <!-- card-body.// -->
                    </aside>
                </div>
                <div class="col-md-6 orderDetails">
                    @include('frontend.cart.details')
                  <form>
                </div>

            </div>
        </div>
    </section>
    <!-- Start Checkout Area  -->
    <div class="axil-checkout-area axil-section-gap">
        <div class="container">
            <form action="{{ route('front.checkouts.store')}}" method="POST" id="">
                @csrf

                <div class="row">
                    <div class="col-lg-5">
                         <div class="axil-checkout-notice" style="display: {{ ($coupon_visibility == '1') ? 'block' : 'none' }}"> 
                            
                             <div class="axil-toggle-box">
                                <div class="toggle-bar"><i class="fas fa-pencil"></i> Have a coupon? <a href="javascript:void(0)" class="toggle-btn">Click here to enter your code <i class="fas fa-angle-down"></i></a>
                                </div>

                                <div class="axil-checkout-coupon toggle-open">
                                    <p>If you have a coupon code, please apply it below.</p>
                                    <div class="input-group">
                                        <input placeholder="Enter coupon code" type="text" id="coupon_code">
                                        <div class="apply-btn">
                                            <button type="button" class="axil-btn btn-bg-primary" id="coupon_apply">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         </div> 
                        <div class="axil-checkout-billing d-none">
                            <h4 class="title mb--30">Billing details</h4>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label style="color: black;">আ  <span>*</span></label>
                                        <input type="text" id="first_name" class="first_name" placeholder="Adam" value="" name="">
                                        <span id="errfirst_name" style="color: red;"></span>
                                        <span id="errfirst_name1" style="color: red;" class="text-danger">{{ $errors->first('first_name')  }}</span>
                                    </div>
                                </div>
                               
                            </div>

                            <div class="form-group">
                                <label style="color: black;">   <span>*</span></label>
                                <input type="tel" id="mobile" class="mobile" name="" value="">
                                <span id="errmobile" style="color: red;"></span>
                              <span id="errmobile1" style="color: red;" class="text-danger">{{ $errors->first('mobile')  }}</span>
                            </div>
                          
                          <tr class="order-shipping">
                                            <td colspan="2">    
                                              
                                              <!--
                                                <div class="shipping-amount" style="margin-bottom: 10px;">
                                                    <span class="title" style="color: black;">Shipping Method</span>
                                                    <span style="margin-left: 20px;color: black;" class="amount" id="charge">0.00</span>
                                                </div>

                                               -->
                                              
                                              	@foreach($charges as $key=>$charge)
                                                <div class="input-group">
                                                    <input type="radio" value="{{ $charge->id}}" class="charge_radio" id="{{ $charge->id}}" {{ $charge->id==2 ?'checked':''}}  name="" data-charge="{{ $charge->amount}}">
                                                    <label style="color: black;" for="{{ $charge->id}}">{{ $charge->title}} {{ $charge->amount}}</label>
                                                  <span id="errshipping_address1" style="color: red;" class="text-danger">{{ $errors->first('delivery_charge_id')  }}</span>
                                                </div>
                                                @endforeach                                             
                                              
                                            </td>
                                        </tr>                            

                            <div class="form-group" style="margin-top: 35px;">
                                <label style="color: black;">  র া <span>*</span></label>
                                <textarea name="" id="shipping_address" class="shipping_address" placeholder="Shipping Address"></textarea>
                                <span id="errshipping_address" style="color: red;"></span>
                                <span id="errshipping_address1" style="color: red;" class="text-danger">{{ $errors->first('shipping_address')  }}</span>
                            </div>                         
                            
                            
                        </div>
                    </div>
                    <div class="col-lg-7 d-none">
                        <div class="axil-order-summery order-checkout-summery" style="padding: 0px !important;background: none;">
                            <h5 class="title mb--20">Your Order</h5>
                            <div class="summery-table-wrap" style="padding: 0px !important;">
                                <table class="table table-bordered table-responsive">
                                    <thead>
                                        <tr style="border: none;">
                                            <th style="width: 46%;border-left: 0px;border-right: 0px;padding: 10px 0px;">Product</th>
                                           <th style="width: 18%;border-left: 0px;border-right: 0px;padding: 10px 0px;">Price</th>
                                          <th style="width: 18%;border-left: 0px;border-right: 0px;padding: 10px 0px;">Quantity</th>
                                            <th style="width: 18%;border-left: 0px;border-right: 0px;padding: 10px 0px;">Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @php
                                            $total=0;
                                      		$discount=0;
                                        @endphp
                                        
                                        @foreach($cart as $key=>$item)
                                        @php
                                        $price=$item['price']*$item['quantity'];
                                        $total +=$price;
                                      	$discount +=$item['discount']*$item['quantity'];
                                        @endphp
                                        <tr class="order-product">                                          
                                            <td style="padding: 10px 0px;">{{ $item['name']}}</td>
                                            <td style="padding: 10px 0px;"> {{ priceFormate($item['price'])}}</td> 
                                            <td style="padding: 10px 0px;"> {{ $item['quantity'] }}</td> 
                                            <td style="padding: 10px 0px;"> {{ priceFormate($price)}}</td>
                                        </tr>
                                        @endforeach
                                         
                                      
                                      	<tr class="order-total" style="border-bottom: none;">
                                            <td style="font-size: 17px;padding: 10px 0px;">Sub Total</td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-size: 15px;padding: 10px 0px;" class="">{{ priceFormate($total+$discount)}}</td>
                                        </tr>
                                      
                                      	
                                      	@if($discount>0)
                                        <tr class="order-total">
                                            <td style="font-size: 17px;"> Discount </td>
                                            <td class="">- {{ priceFormate($discount)}}</td>
                                        </tr>
                                      	@endif
                                      	
                                      	@if(getCouponDiscount()>0)
                                        <tr class="order-total">
                                            <td>Coupon Discount</td>
                                            <td class="">- {{ priceFormate(getCouponDiscount())}}</td>
                                        </tr>
                                      	@endif    
                                      
                                      
                                      <tr class="order-total" style="border-bottom: none;border-top: none;">
                                            <td style="font-size: 17px;padding: 10px 0px;">Total</td>
                                            <td></td>
                                            <td></td>
                                            <td style="font-size: 15px;padding: 10px 0px;" rowspan="2" class="order-total-amount">{{ priceFormate($total - getCouponDiscount())}}</td>
                                        </tr>
                                      
                                      @php 

                                        $total = $total - getCouponDiscount();
                                        $chr_amount = $charge->amount;
                                        $gr_total = $total + $chr_amount;
                                             
                                        @endphp
                                            <input type="hidden" value="{{ $gr_total }}" name="amount">
                                    </tbody>
                                </table>
                              
                            </div>
                            <div class="order-payment-method">
                                
                                <div class="single-payment">
                                 
                                    <div class="input-group" style="display: {{ $info->bkash == 0 ? 'none' : 'block' }} ">
                                        <input type="radio" id="radio6" name="payment_method" value="bkash">
                                        <label for="radio6" onclick="paymentInput('bkash')">Bkash ({{ $info->bkash_number}})</label>
                                    </div>                                      
                                  <div class="input-group" style="display: {{ $info->rocket == 0 ? 'none' : 'block' }} ">
                                        <input type="radio" id="radio7" name="payment_method" value="rocket">
                                        <label for="radio7" onclick="paymentInput('rocket')">Rocket ({{ $info->rocket_number}})</label>
                                  </div> 
                                  
                                  <div class="input-group" style="display: {{ $info->nogod == 0 ? 'none' : 'block' }} ">
                                        <input type="radio" id="radio8" name="payment_method" value="nogod">
                                        <label for="radio8" onclick="paymentInput('nogod')" class="payment-online">Nogod ({{ $info->nogod_number}})</label>
                                  </div> 
                                  
                                   <div class="input-group" style="display: {{ $info->paypal == 0 ? 'none' : 'block' }} ">
                                        <input type="radio" id="radio13" name="payment_method" value="paypal">
                                        <label for="radio13" onclick="paymentInput('paypal')" class="payment-online">Paypal ({{ $info->paypal_account}})</label>
                                  </div> 
                                  
                                  <div class="input-group" style="display: {{ $info->stripe == 0 ? 'none' : 'block' }} ">
                                        <input type="radio" id="radio16" name="payment_method" value="stripe">
                                        <label for="radio16" onclick="paymentInput('stripe')" class="payment-online">Stripe ({{ $info->stripe_account}})</label>
                                  </div>
                                  
                                   <div class="input-group">
                                        <input type="radio" id="radio5" name="payment_method"  value="cash" checked>
                                        <label for="radio5" style="font-size: 18px;" onclick="paymentInput('cash')" class="payment-online">Cash on delivery</label>
                                        
                                    </div>
                                  	<div id="payment_input" style="display:none">
                                       <label for="pay_num">Account Number</label>
                                      <input type="text" name="pay_num" placeholder="Enter account number" id="pay_num"><br/>
                                      <label for="tnx_id">Transaction Number</label>
                                      <input type="text" name="tnx_id" placeholder="Enter trx number" id="tnx_id"><br/>
                                  </div>
                                </div>
                                 
                            </div>
                            <button type="button" id="chk_btn" class="axil-btn checkout-btn" style="background: #c2050b !important;color: white;">র র </button>
                            <div id="paypal-button-container" style="display: none;"></div>
                          
                          <script
                              src="https://checkout.stripe.com/checkout.js"
                              class="stripe-button"
                              data-key="pk_test_51MqweQJRdIwi69uLBsb2pvAJXY9HUOVEiQRtkqK8YwkNdBDuBNRDXPPQa2qgt6M99jhlKoX5TLwAuLI89KBgwptf00bUlFLfC0"
                              data-name="Pay Here"
                              data-description="Pay With Stripe"
                              data-amount=""
                              data-currency="usd">
                            </script>
                          
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Checkout Area  -->
</main>

@endsection

@push('js')
<script src="{{ asset('frontend/js/checkout.js')}}"></script>


<script>
    // Fetch user's IP address using a third-party API
    fetch('https://api.ipify.org?format=json', {
        headers: {
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('ip_address').value = data.ip;
        })
        .catch(error => {
            console.error('Error fetching IP address:', error);
        });
</script>

    
<script type="text/javascript">

    $(document).ready(function(){
        getCharge();
      $(document).on('click', 'a.remove_item', function(e){
         e.preventDefault();
         let url = $(this).attr('data-href');
         let method = "DELETE";
         let segment = "checkouts";
         if(confirm('Are you sure?'))
         {
			$.ajax({
              url,
              method,
              data: {segment},
              success: function(res)
              {
               	if(res.success)
                {
                  toastr.success(res.msg);
                   $('div#cart-dropdown').html(res.html);
                   $(document).find('div.orderDetails').html(res.html2);
                   $(document).find('div.cart_other_details').html(res.html3);
                  if(res.item <= 0)
                  {
                    document.location.href = res.url;
                  }
                }
                else{
                 	toastr.error('Someting went wrong!'); 
                }
                
                calculate_total();
              }
              
            });
         }
     
      });
      
      document.getElementsByClassName('stripe-button-el')[0].disabled = true;

      
        $('.charge_radio').click(function(){
            getCharge();
        });


        function getCharge(){

            var testval = $('input:radio:checked.charge_radio').map(function(){
                return Number($(this).data('charge')); }).get().join(",");
            $('span#charge').text(Number(testval).toFixed(2));
            let sub_total='{{$total - getCouponDiscount()}}';
            let total=Number(testval)+Number(sub_total);
            $('td.order-total-amount').text(total.toFixed(2));
        }
      
      $("#selectCourier").change(function(e){
			calculate_total();
      });
    });
  
  function paymentInput(type)
      {
        if(type == 'cash'){
        document.getElementById('payment_input').style.display = 'none';
        document.getElementById('paypal-button-container').style.display = 'none';
        document.getElementById('chk_btn').style.display = 'block';
          document.getElementsByClassName('stripe-button-el')[0].style.display = 'none';
          document.getElementsByClassName('stripe-button-el')[0].disabled = true;
        }
		else if(type == 'bkash')
        {
          document.getElementById('payment_input').style.display = 'block';
          document.getElementById('paypal-button-container').style.display = 'none';
          document.getElementById('chk_btn').style.display = 'block';
          document.getElementsByClassName('stripe-button-el')[0].style.display = 'none';

        } else if(type == 'stripe')
        {
          document.getElementById('payment_input').style.display = 'none';
          document.getElementById('paypal-button-container').style.display = 'none';
          document.getElementById('chk_btn').style.display = 'none';           
          document.getElementsByClassName('stripe-button-el')[0].style.display = 'block';	
          document.getElementsByClassName('stripe-button-el')[0].disabled = false;
        }  else if(type == 'rocket')
        {
          document.getElementById('payment_input').style.display = 'block';
          document.getElementById('paypal-button-container').style.display = 'none';
          document.getElementById('chk_btn').style.display = 'block';
          document.getElementsByClassName('stripe-button-el')[0].style.display = 'none';

        } else if(type == 'nogod')
        {
          document.getElementById('payment_input').style.display = 'block';
          document.getElementById('paypal-button-container').style.display = 'none';
          document.getElementById('chk_btn').style.display = 'block';
          document.getElementsByClassName('stripe-button-el')[0].style.display = 'none';
        }
        
        else{
          document.getElementById('payment_input').style.display = 'none';
          document.getElementById('paypal-button-container').style.display = 'block';
          document.getElementById('chk_btn').style.display = 'none';  
          document.getElementsByClassName('stripe-button-el')[0].style.display = 'none';
        }
      }
    
    
</script>


<script>  
  
    paypal.Buttons({
      onClick(){     
        var first_name = document.getElementById("first_name").value;
        var mobile = document.getElementById("mobile").value;
        var shipping_address = document.getElementById("shipping_address").value;     
        
        $('#errfirst_name').text("");  
        $('#errmobile').text("");          
        $('#errshipping_address').text("");  
        $('#errfirst_name1').text("");  
        $('#errmobile1').text("");          
        $('#errshipping_address1').text("");  
        
        
        if(first_name.length == 0) {
            $('#errfirst_name').text("First Name Is Required!!");              
          } 
        
        if(mobile.length == 0) {
            $('#errmobile').text("Mobile Is Required!!");              
          } 
        
        if(shipping_address.length == 0) {
            $('#errshipping_address').text("Shipping Address Is Required!!");              
          } 
        
        if(first_name.length == 0 || mobile.length == 0 || shipping_address.length == 0){
        	return false;
        }
        
      },
      
      // Sets up the transaction when a payment button is clicked
      createOrder: (data, actions) => {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '{{ $gr_total }}' // Can also reference a variable or function
            }
          }]
        });
      },
      // Finalize the transaction after payer approval
      onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
          // Successful capture! For dev/demo purposes:
         // console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
          const transaction = orderData.purchase_units[0].payments.captures[0];
         // alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
          // When ready to go live, remove the alert and show a success message within this page. For example:
          // const element = document.getElementById('paypal-button-container');
          // element.innerHTML = '<h3>Thank you for your payment!</h3>';
          // Or go to another URL:  actions.redirect('thank_you.html');

          var firstname = $('.first_name').val();
          var lastname = $('.last_name').val();  
          var mobile = $('.mobile').val();  
          var email = $('.email').val();  
          var shipping_address = $('.shipping_address').val();
          var note = $('.note').val();
          var delivery_charge_id = $('.delivery_charge_id').val();
          var tnx_id = transaction.id

          $.ajax({
            method: "POST",
            url: "{{ route('front.store.checkout') }}",
            data: {
                'firstname': firstname,
                'lastname': lastname,
                'mobile': mobile,
                'email': email,               
                'shipping_address': shipping_address,
                'note': note,
                'delivery_charge_id': delivery_charge_id,
                'tnx_id': tnx_id
            },
            success: function(response){
            window.location.href = response.url    
            }
        }); 

        });
      }
    }).render('#paypal-button-container');
  </script>

@endpush