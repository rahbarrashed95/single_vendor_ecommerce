  <!-- Start Footer Area  -->
@php
use App\Models\Information;
$info = Information::first();

@endphp
 

 
 
  <footer class="axil-footer-area footer-style-2" style="background-color: #ededef;"> 
      <!-- Start Footer Top Area  -->
      <div class="pt--20 pb--20">
          <div class="container">
              <div class="row footer-top pt-4"> 
                  
                  <div class="col-lg-4 ml-5 col-sm-6">
                      <div class="axil-footer-widget" style="margin-bottom: 0px;">
                          <h5 class="m-0 widget-title">Best Categories</h5> 
                          <div class="inner">
                              <ul>
                                  @foreach(DB::table('categories')->whereNull('parent_id')->take(5)->get() as $cat)
                                  <p class="m-0"><a href="{{ route('front.products.index')}}?category_id={{$cat->id}}"> {{ $cat->name}}</a></p>
                                  @endforeach
                              </ul>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Widget  -->
                  <!-- Start Single Widget  -->
                    <div class="col-lg-4 ml-5 col-sm-6">
                        <div class="axil-footer-widget" style="margin-bottom: 0px;">
                        <h5 class="m-0 widget-title">Our Pages</h5>
                          <div class="inner">
                              <ul>
                                  <p class="m-0"><a href=" {{ route('front.aboutUs')}} ">About us</a></p>
                                  <p class="m-0"><a href="{{ route('front.termCondition')}}">Terms and conditions</a></p>
                                  <p class="m-0"><a href="{{ route('front.privacyPolicy')}}">Privacy policy</a></p>
                                  <p class="m-0"><a href="{{ route('front.returnPolicy')}}">Return policy</a></p>
                              </ul>
                          </div>
                      </div>  
                  </div>
                  <div class="desktop-foot-last col-lg-4 ml-5 col-sm-6" style="margin-bottom:-27px"> 
                    <div class="last-foot axil-footer-widget">
                      <h5 class="m-0 widget-title">Contact Us</h5>
                      
                      <div class="inner">
                          <p class="m-0">{{ $info->site_name }} <br>
                            
                          <ul class="support-list-item mt-1">
                            <p class="m-0">Address: <span> {{ $info->address }} </span><br>
                              <p class="m-0">Email us: <a href="mailto:{{ $info->owner_email }}"><span>{{ $info->owner_email }}</span> </a></p>
                              <p class="m-0">Call us: <a href="tel:{{ $info->owner_phone }}"><span>{{ $info->owner_phone }}</span> </a></p>
                              
                          </ul>
                      </div>
                      
                      
                  </div>
                </div>
                <div class="mobile-foot-last col-lg-4 ml-5 col-sm-6" style="margin-bottom:-27px"> 
                  <div class="axil-footer-widget">
                      <h5 class="m-0 widget-title">Contact Us</h5>
                      
                      <div class="inner">
                          <p class="m-0">{{ $info->site_name }}<br>
                          </p>
                          <ul class="support-list-item mt-1">
                            	<p class="m-0">Address: <span> {{ $info->address }} </span><br>
                              <p class="m-0">Email us: <a href="mailto:{{ $info->owner_email }}"><span>{{ $info->owner_email }}</span> </a></p>
                              <p class="m-0">Call us: <a href="tel:{{ $info->owner_phone }}"><span>{{ $info->owner_phone }}</span> </a></p>
                              
                          </ul>
                      </div>
                      
                     
                  </div>
                </div>
                  
              </div>
          </div>
      </div>
      <!-- End Footer Top Area  -->
      <!-- Start Copyright Area  -->
      <div class="copyright-area copyright-default separator-top">
          <div class="container-fluid">
              <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                      <div class="tex-center">
                        
                      </div>
                    </div>
                    
                    <div class="col-xl-12 col-lg-12">                        
                        <div class="copyright-left d-flex flex-wrap justify-content-center">
                            <div class="social-share" style="">
                              <a href="{{ $info->facebook }}" blank="_target"><i style="color: #ffffff;" class="fab fa-facebook-f"></i></a>
                              <a href="{{ $info->instagram }}"><i style="color: #ffffff;" class="fab fa-instagram"></i></a>
                              <a href="{{ $info->youtube }}"><i style="color: #ffffff;" class="fab fa-youtube"></i></a>
                            </div>                            
                        </div>
                      <ul class="quick-link" style="display: block;text-align: center;">
                              <li style="color: #ffffff;">{!! $info->copyright !!} <a style="color: #ffffff;" href="https://softitglobal.com/">SoftitGlobal.com</a></li>
                            </ul>
                    </div>
                    
              </div>
          </div>
      </div>
      <!-- End Copyright Area  -->
  </footer>
  <!-- End Footer Area  -->

  


<div class="cart-dropdown" id="cart-dropdown">
    
</div>

    
@include('frontend.partials.js')

</body>

<html>