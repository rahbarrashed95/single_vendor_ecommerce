@php
use App\Models\Information;
use App\Models\Category;
  $information = Information::first();
  $categories = Category::where('parent_id', null)->get();
@endphp

<style>
    .axil-product>.thumbnail .label-block .product-badget {
        padding: 6px 18px 5px;
    }
</style>

<header class="desktop header axil-header header-style-5">
        <!-- Start Mainmenu Area  -->
        <div id="axil-sticky-placeholder"></div>
        <div class="axil-mainmenu" style="background: #00276C;">
            <div class="container-fluid" style="padding-top: 10px;">
                <div class="row header-navbar">
                    <div class="col-4 d-flex justify-content-around">
                        <div>
                            <a href="{{ route('front.home')}}">
                                <img src="{{ asset('frontend/images/home_icon.png')}}" alt="Home" width="40" style="filter: brightness(0) invert(1);">
                            </a>
                        </div>
                        <div class="header-brand">
                            <a href="{{ route('front.home')}}" class="logo logo-dark">
                                <img src="{{ asset('uploads/img/'.$information->site_logo)}}" alt="Site Logo">
                            </a>
                            <a href="{{ route('front.home')}}" class="logo logo-light">
                                <img src="{{ asset('uploads/img/'.$information->site_logo)}}" alt="Site Logo">
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-4">
                        <form action="{{ route('front.products.index')}}">
                            <div class="header-top-dropdown dropdown-box-style">
                                
                                <div class="axil-search">
                                    <button type="submit" class="icon wooc-btn-search">
                                        <i class="far fa-search"></i>
                                    </button>
                                    <input type="search" class="placeholder product-search-input" name="q" id="search2" value="{{ request('q')??''}}" maxlength="128" placeholder="What are you looking for...." autocomplete="off">
                                </div>
                                
                            </div>
                        </form>
                    </div> 
                    <div class="col-2 text-end">
                    <!--    @guest-->
                    <!--        <a href="{{ route('login')}}" class="btn btn-light btn-lg rounded-0 col-12" style="width: 80px;">Login</a>-->
                    <!--    @else-->
                    <!--        <a href="{{ route('front.dashboard.index')}}" class="btn rounded-0 col-12">{{ auth()->user()->first_name ?auth()->user()->first_name.' '.auth()->user()->last_name:auth()->user()->mobile }}</a>-->
                    <!--    @endguest-->
                    </div>
                    <div class="more-dp text-light col-1">
                            <div class="text-light more-btn">More <i class="fas fa-angle-down"></i></div>
                            <ul class="mainmenu">
                                <li><a href="{{ route('front.home')}}">Home</a></li>
                                <li><a href="{{ route('front.categories')}}">Shop</a></li>
                                <li><a href="{{ route('front.free-shipping')}}">Free Shipping</a></li>
                                <li><a href="{{ route('front.brands')}}">brand</a></li>
                                <li><a href="{{ route('front.discountProduct')}}">All Offers</a></li>
                                
                                <li class="menu-item-has-children">
                                    <!--<a href="#">Account</a>-->
                                    <!--<ul class="axil-submenu">-->
                                    <!--    @guest-->
                                    <!--  	<li><a href="{{ route('front.sellerRegister')}}">Become A Seller</a></li>-->
                                    <!--    @else-->
                                    <!--    <li><a href=" {{ route('front.dashboard.index')}}">Dashboard</a></li>-->
                                    <!--    @endguest-->
                                    <!--</ul>-->
                                </li>
                                
                                <!--<li><a href="{{ route('front.contactUs')}}">Contact</a></li>                               -->
                                
                            </ul>
                            
                    </div>
                    <div class="col-1">
                        <div class="header-action">
                            <ul class="action-list">
                                    
                                
                                <li class="shopping-cart">
                                    <a href="{{ route('front.carts.index')}}?segment={{request()->segment(1)}}" class="cart-dropdown-btn">
                                        <span class="cart-count" style="background: #00276C !important;">{{ getTotalCart()}}</span>
                                        Cart <i class="flaticon-shopping-cart"></i> 
                                    </a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="desktopnav container-fluid" style="border-bottom: 1px solid #f2f2f2;background-color:#ededef">
                      
            </div>
            
            
        </div>
        <!-- End Mainmenu Area -->
    </header>
    <!-- End Header -->


    
    <!-- Start Header -->
    <header class="mobile header axil-header header-style-5">
        <!-- Start Mainmenu Area  -->
        <div id="axil-sticky-placeholder"></div>
        <div class="axil-mainmenu">
            <div class="container">
                <div class="row">
                    <div class="col-2">
                        <ul class="mainmenu">
                            <li class="axil-mobile-toggle">
                                <button class="menu-btn mobile-nav-toggler">
                                    <i class="flaticon-menu-2"></i>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="col-4">
                        <div class="header-brand">
                            <a href="{{ route('front.home')}}" class="logo logo-dark">
                                <img src="{{ asset('uploads/img/'.$information->site_logo)}}" alt="Site Logo">
                            </a>                            <a href="{{ route('front.home')}}" class="logo logo-light">
                                <img src="{{ asset('uploads/img/'.$information->site_logo)}}" alt="Site Logo">
                            </a>
                        </div>
                        
                    </div>
                    <div class="col-6">
                        <div class="header-action">
                            <ul class="action-list">
                                <li class="shopping-cart">
                                    <a href="{{ route('front.carts.index')}}?segment={{request()->segment(1)}}" class="cart-dropdown-btn">
                                        <span class="cart-count" style="background: #00276C !important;">{{ getTotalCart()}}</span>
                                        <i class="flaticon-shopping-cart"></i>
                                    </a>
                                </li>
                                <!--<li class="my-account">-->
                                <!--    <a href=" {{ route('login')}} ">-->
                                <!--        Login-->
                                <!--    </a>-->
                                    
                                <!--</li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="header-navbar">
                    
                    <div class="header-main-nav">
                        <!-- Start Mainmanu Nav -->
                        <nav class="mainmenu-nav">
                            <!--button class="mobile-close-btn mobile-nav-toggler"><i class="fas fa-times"></i></button-->
                            <div class="mobile-nav-brand">
                              
                                <ul class="action-list">
                                  
                                  <li class="my-account">
                                      
                                      @guest
<!--                                      <a href=" {{ route('login')}} ">-->
<!--                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">-->
<!--  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>-->
<!--</svg>-->
<!--                                        <span style="padding-left: 5px;"> Signin/Signup </span>-->
<!--                                      </a>-->
<!--                                    	<a href=" {{ route('front.sellerRegister')}} ">-->
<!--                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">-->
<!--  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>-->
<!--</svg>-->
<!--                                        <span style="padding-left: 5px;"> Become A Seller </span>-->
<!--                                      </a>-->
                                    
                                      @else
                                      <a href="{{ route('front.dashboard.index') }}">{{ auth()->user()->first_name ?auth()->user()->first_name.' '.auth()->user()->last_name:auth()->user()->mobile }}</a>  
                                      @endguest

                                  </li>
                                  
                                    <a href=" {{ route('front.home')}}" class="logo">
                                    <img src="{{ asset('uploads/img/'.$information->site_logo)}}" alt="Site Logo">
                                </a>
                                  
                              </ul>
                              
                            </div>                       
                          
                            <ul class="mainmenu">                                
                                @foreach($categories as $key=>$cat)                             
                              <p>
      						@if(($cat->subcats->count() > 0))                          
                           <a class="" data-bs-toggle="collapse" id="dropdownMenuButton1" href="{{ route('front.subCategories1',[$cat->url])}} #collapseExample_{{$key}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                              {{ $cat->name}} <i class="fas fa-arrow-down" style="float:right;"></i>
                           </a>
   							@else                                         
         					<a href="{{ route('front.subCategories1',[$cat->url])}}" >
                            {{ $cat->name}}
                          	</a>                                   
   							@endif              
                            </p>
                             <hr />
                          <div class="collapse" id="collapseExample_{{ $key }}">    
                          @if($cat->subcats->count())
                            <ul style="margin:0; padding:0">
                                @foreach($cat->subcats as $sub)
                                <li style="margin:0; padding:0">
                                  <a class="dropdown-item" style="font-size: 15px;" href="{{ route('front.subsubCategories',[$sub->url])}}">{{ $sub->name}}</a>
                                </li>
                              <hr/>  
                              @endforeach
                            </ul>  								
                            @endif  
                          </div>                                     
                        @endforeach
<!--                                <li>-->
<!--                                  <a href="{{ route('front.categories')}}">-->
<!--                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-3x3-gap-fill" viewBox="0 0 16 16">-->
<!--  <path d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V7zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2z"/>-->
<!--</svg>-->
<!--                                    <span style="padding-left: 5px;"> Shop</span> -->
<!--                                  </a>-->
<!--                              </li>-->
<!--                                <li><a href="{{ route('front.brands')}}">-->
<!--                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-fill" viewBox="0 0 16 16">-->
<!--  <path d="M6.375 7.125V4.658h1.78c.973 0 1.542.457 1.542 1.237 0 .802-.604 1.23-1.764 1.23H6.375zm0 3.762h1.898c1.184 0 1.81-.48 1.81-1.377 0-.885-.65-1.348-1.886-1.348H6.375v2.725z"/>-->
<!--  <path d="M4.002 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4h-8zm1.06 12V3.545h3.399c1.587 0 2.543.809 2.543 2.11 0 .884-.65 1.675-1.483 1.816v.1c1.143.117 1.904.931 1.904 2.033 0 1.488-1.084 2.396-2.888 2.396H5.062z"/>-->
<!--</svg>-->
<!--                                  <span style="padding-left: 5px;"> Brand</span> -->
<!--                                  </a></li>-->
<!--                                <li><a href="{{ route('front.discountProduct')}}">-->
<!--                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-exchange" viewBox="0 0 16 16">-->
<!--  <path d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z"/>-->
<!--</svg>-->
<!--                                  <span style="padding-left: 5px;"> Total Offers</span> -->
<!--                                  </a></li>-->
<!--                                <li class="menu-item-has-children">-->
<!--                                    <a href="#">-->
<!--                                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-bounding-box" viewBox="0 0 16 16">-->
<!--  <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>-->
<!--  <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>-->
<!--</svg>-->
<!--                                      <span style="padding-left: 5px;"> Accounts</span> -->
<!--                                        </a>-->
<!--                                    <ul class="axil-submenu">-->
<!--                                        @guest-->
<!--                                        <li style="padding-left: 25px;"><a href="{{ route('login')}}">Sign In / Sign Up</a></li>-->
<!--                                        @else-->
<!--                                        <li style="padding-left: 25px;"><a href=" {{ route('front.dashboard.index')}}">Dashboard</a></li>-->
<!--                                        @endguest-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                              <li class="shopping-cart">-->
<!--                                      <a href="{{ route('front.carts.index')}}?segment={{request()->segment(1)}}" class="cart-dropdown-btn">-->
<!--                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">-->
<!--  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>-->
<!--</svg>-->
<!--                                        <span style="padding-left: 5px;"> My Cart</span> -->
                                          <!--span class="cart-count">{{ getTotalCart()}}</span>
<!--                                          <i class="flaticon-shopping-cart"></i-->-->
<!--                                      </a>-->
<!--                                  </li>-->
<!--                                <li><a href="{{ route('front.contactUs')}}">-->
<!--                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pin-map-fill" viewBox="0 0 16 16">-->
<!--  <path fill-rule="evenodd" d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8l3-4z"/>-->
<!--  <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z"/>-->
<!--</svg>-->
<!--                                  <span style="padding-left: 5px;"> Contact</span> -->
<!--                                    </a></li>-->
                            </ul>
                        </nav>
                        <!-- End Mainmanu Nav -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Mainmenu Area -->
        <form action="{{ route('front.products.index')}}">
        <div class="mobilesearch col-12">
            <div class="header-top-dropdown dropdown-box-style">
                <div class="axil-search">
                    <button type="submit" class="icon wooc-btn-search">
                        <i class="far fa-search"></i>
                    </button>
                    <input type="search" class="placeholder product-search-input" name="q" id="search2" value="{{ request('q') ??''}}" maxlength="128" placeholder="What are you looking for...." autocomplete="off">
                </div>
            </div>
        </div>
        </form>
    </header>
    <!-- End Header -->
<a href="{{ route('front.carts.index')}}?segment={{request()->segment(1)}}" class="cart-dropdown-btn">
    <div class="fixed-cart-bottom">
        <p style="background: #00276C;border-top-left-radius: 12px;border-top-right-radius: 12px;">
            <i class="fas fa-shopping-cart" style="color: #ffffff !important;"></i>
        </p>
        <p style="color: white;font-size: 10px;background: #00276C;">
           @if(getTotalCart() > 1) {{ getTotalCart()}} items @else {{ getTotalCart()}} item @endif 
        </p>
        <p style="color: white;font-size: 10px;background: #F39305;border-bottom-left-radius: 12px;border-bottom-right-radius: 12px;">৳ {{ getTotalAmount() }}</p>
    </div>
</a>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>