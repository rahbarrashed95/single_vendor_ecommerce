
@php
$data=getProductInfo($product);
use App\Models\Information;
use App\Models\BanglaText;
$info = Information::first();
$bangla_text = BanglaText::first();
@endphp

<style>
    @media only screen and (min-width: 568px) and (max-width: 768px) {
        .axil-product {
            max-height: 455px !important;
        }
    }
    
    @media only screen and (min-width: 478px) and (max-width: 567px) {
        .axil-product {
            max-height: 412px !important;
        }
    }
  
    /*@media only screen and (min-width: 1850px) and (max-width: 2600px) {*/
    /*    .axil-product {*/
    /*        max-height: 407px !important;*/
    /*    }*/
    /*}*/
  
  @media only screen and (min-width: 1024px) and (max-width: 1155px) {
        .axil-product {
            max-height: 407px !important;
        }
    }
    
</style>


<div class="axil-product product-style-one" style="padding: 0px !important;">
    <div class="thumbnail" style="padding: 10px !important">
        <a href="{{ route('front.products.show',[$product->id])}}">
            <img src="{{ getImage('thumb_products', $product->image)}}" class="product_img" alt="Product Images">
        </a>

        @if($product->discount_type)
        <div class="label-block label-right">
            <div class="product-badget" style="background: #00276C;color: #FFC610;">
                {{$product->discount_type=='fixed'?'':''}}
                {{(int)$product->dicount_amount}} 
                {{$product->discount_type=='fixed'?'TK':'%'}} Off</div>
        </div>
        @endif
        <div class="product-hover-action">
            <ul class="cart-action d-none">
                <li class="quickview">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#quick-view-modal"><i class="far fa-eye"></i></a>
                </li>
                <li class="wishlist">
                    <a href="wishlist.php"><i class="far fa-heart"></i></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="product-content" style="padding: 10px !important;">
        <div class="inner">
            <h5 class="title text-start"><a href="{{ route('front.products.show',[$product->id])}}">{{ \Illuminate\Support\Str::limit($product->name, 15) }}</a></h5>
            <div class="product-price-variant text-start">
                <span class="price current-price" style="color: #00276C">
                  
                  @php  
                    $curr = $info->currency;                   
                  @endphp
                  
                  @if($curr == 'BDT')
                    ৳ {{ (int)$data['price'] }}
                  @elseif ($curr == 'Dollar') 
                    $ {{ $data['price'] }}
                  @elseif ($curr == 'Euro') 
                     {{ $data['price'] }}
                  @elseif ($curr == 'Rupee') 
                     {{ $data['price'] }}
                  @else
                  
                  @endif                   
                  
              </span>
                @if($data['discount_amount'] > 0 && $data['old_price'])
                <span class="price old-price" style="color: #c2050b">
                   @php  
                    $curr = $info->currency;                   
                  @endphp
                  
                  @if($curr == 'BDT')
                     {{ (int)$data['old_price'] }}
                  @elseif ($curr == 'Dollar') 
                    $ {{ $data['old_price'] }}
                  @elseif ($curr == 'Euro') 
                     {{ $data['old_price'] }}
                  @elseif ($curr == 'Rupee') 
                     {{ $data['old_price'] }}                 
                  @else
                  
                   @endif
              </span>
                @endif
            </div>
        </div>
    </div>
   @if($product->type=="single")
            <form method="POST" action="{{ route('front.carts.store')}}" id="cart_form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id}}">
                @if($product->after_discount != '0')
                <input type="hidden" name="price" value="{{ $product->after_discount}}">
                @else
                <input type="hidden" name="price" value="{{ $product->sell_price}}">
                @endif
                <input type="hidden" name="variation_id" value="{{ $product->variation->id}}">
                <input type="hidden" name="is_stock" value="{{ $product->is_stock }}">
                <div class="desktop-cart cart-count" style="padding-bottom: 0px;">
                    <div class="product-add-to-cart col-12">
                        <ul class="cart-action col-12">
                            <li class="select-option col-12" style="margin-bottom: 0px;">
                                <button type="submit" class="btn p-0 button m-auto text-light col-12" style="background: #FFC610 !important;"> 
                                      
                                      
                                      @if($product->is_free_shipping == 0)
                                     
                                             <p><b>
                                          <i class="fas fa-shopping-cart" style="color: #00276C;"></i>
                                          
                                         &nbsp; {{ $bangla_text->order_text }} </b></p>
                                         
                                      @else
                                      
                                        <p><b>
                                          <i class="fas fa-shopping-cart" style="color: #00276C;"></i>
                                          
                                         &nbsp; {{ $bangla_text->fshipping_text }} </b></p>
                                          
                                    @endif      
                                          
                                        <span>
                                            <i class="fas fa-shopping-cart" style="color: #00276C;"></i>
                                        </span>                                    
                                </button>                                
                            </li>
                        </ul>
                    </div>
                </div>
            </form>
            @else
            <div class="desktop-cart cart-count">
                    <div class="product-add-to-cart">
                        <ul class="cart-action">
                            <li class="col-12 reg text-center" style="background: #FFC610; padding: 7px;border-radius: 4px;text-align: center;">                                
                                <a type="submit" style="color:#00276C;font-size: 13px;font-weight: 900;" href="{{ route('front.products.show',[$product->id])}}" ><i class="fas fa-shopping-cart" style="color: #00276C;"></i> &nbsp;  {{ $bangla_text->order_text }} </a>                                
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            
         
  
</div>

