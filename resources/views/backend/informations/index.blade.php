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
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>
            <h4 class="page-title">Settings</h4>
        </div>
    </div>
</div>   
<!-- end page title --> 

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <a href="{{route('admin.roles.index')}}" class="btn btn-secondary">Back</a><br><br>
                 @if(Session::has('msg'))
                    <div class="alert alert-success">
                        <strong >{{Session::get('msg')}}</strong>
                    </div>
                 @endif
                <form action="{{route('admin.settings.update', [$information->id])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong for="role">Site Name</strong>
                                <input type="text" id="site_name" class="form-control" name="site_name" placeholder="Site name..." value="{{ $information->site_name }}">
                            </div>
                            @error('site_name')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                       <div class="col-md-6">
                        <div class="form-group">
                            <strong for="role">Site Logo</strong>
                            <input type="file" id="site_logo" class="form-control" name="site_logo" placeholder="Site logo...">
                        </div>
                        <div class="mt-2">
                            <img src="{{ asset('uploads/img/'.$information->site_logo) }}" height="100" width="100" id="preview_img"/>
                        </div>
                            @error('site_logo')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                    </div>  
                    </div>   
                     <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong for="role">Site Phone</strong>
                                <input type="text" id="owner_phone" class="form-control" name="owner_phone" placeholder="Site phone..." value="{{ $information->owner_phone }}">
                            </div>
                             @error('owner_phone')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong for="role">Site Email</strong>
                                <input type="email" id="owner_email" class="form-control" name="owner_email" placeholder="Site email..." value="{{ $information->owner_email }}">
                            </div>
                             @error('owner_email')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>   
                    </div>   
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong for="role">Site Address</strong>
                                <textarea name="address" id="address" rows="5" class="form-control" placeholder="Address...">{{$information->address}}</textarea>
                            </div>
                             @error('address')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <strong for="role">Site Tracking Code</strong>
                                <textarea name="tracking_code" id="tracking_code" rows="5" class="form-control" placeholder="Site tracking code...">{{$information->tracking_code}}</textarea>
                            </div>
                             @error('address')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                      <div class="col-md-6">
                            <div class="form-group">
                                <strong for="copyright">Copyright Text</strong>
                                <textarea name="copyright" id="copyright" rows="5" class="form-control" placeholder="Copyright">{{$information->copyright}}</textarea>
                            </div>
                             @error('copyright')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                      <div class="col-md-6">
                            <div class="form-group">
                                <strong for="facebook">Facebook Link</strong>
                                <textarea name="facebook" id="facebook" rows="3" class="form-control" placeholder="Facebook Link">{{$information->facebook}}</textarea>
                            </div>
                             @error('facebook')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                      <div class="col-md-6">
                            <div class="form-group">
                                <strong for="instagram">Instagram Link</strong>
                                <textarea name="instagram" id="instagram" rows="3" class="form-control" placeholder="Instagram Link">{{$information->instagram}}</textarea>
                            </div>
                             @error('instagram')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                      <div class="col-md-6">
                            <div class="form-group">
                                <strong for="youtube">Youtube Link</strong>
                                <textarea name="youtube" id="youtube" rows="3" class="form-control" placeholder="Youtube Link">{{$information->youtube}}</textarea>
                            </div>
                             @error('youtube')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                      
                      <div class="col-md-4">
                            <div class="form-group">
                                <strong for="role">Recommend Product Show</strong>
                                <input type="text" id="recommend_num" class="form-control" name="recommend_num" placeholder="" value="{{ $information->recommend_num }}">
                            </div>
                             @error('recommend_num')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                     <div class="col-md-4">
                            <div class="form-group">
                                <strong for="role">Best Offer Product Show</strong>
                                <input type="text" id="discount_num" class="form-control" name="discount_num" placeholder="" value="{{ $information->discount_num }}">
                            </div>
                             @error('discount_num')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                      
                      <div class="col-md-4">
                            <div class="form-group">
                                <strong for="role">New Arrival Product Show</strong>
                                <input type="text" id="newarrival_num" class="form-control" name="newarrival_num" placeholder="" value="{{ $information->newarrival_num }}">
                            </div>
                             @error('newarrival_num')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                      
                      
                    </div>
                  
                  <div class="row mb-2">
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">BKash Number</strong>-->
                    <!--           <input type="text" id="bkash_number" class="form-control" name="bkash_number" placeholder="Site phone..." value="{{ $information->bkash_number }}"> -->
                    <!--         </div>-->
                    <!--         @error('bkash_number')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">Nogod Number</strong>-->
                    <!--           <input type="text" id="nogod_number" class="form-control" name="nogod_number" placeholder="Site phone..." value="{{ $information->nogod_number }}"> -->
                    <!--         </div>-->
                    <!--         @error('nogod')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">Rocket Number</strong>-->
                    <!--           <input type="text" id="rocket_number" class="form-control" name="rocket_number" placeholder="Site phone..." value="{{ $information->rocket_number }}"> -->
                    <!--         </div>-->
                    <!--         @error('rocket')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">Paypal Account</strong>-->
                    <!--           <input type="text" id="paypal_account" class="form-control" name="paypal_account" placeholder="Site phone..." value="{{ $information->paypal_account }}"> -->
                    <!--         </div>-->
                    <!--         @error('paypal')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">Stripe Account</strong>-->
                    <!--           <input type="text" id="stripe_account" class="form-control" name="stripe_account" placeholder="Site phone..." value="{{ $information->stripe_account }}"> -->
                    <!--         </div>-->
                    <!--         @error('stripe_account')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    
                  </div>
                  
                  
                  
                   <div class="row mb-2">
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">BKash Number</strong>-->
                    <!--            <select class="form-select" name="bkash">-->
                    <!--            <option value="1" {{$information->bkash == 1 ?'selected':''}} >On</option>                               -->
                    <!--            <option value="0" {{$information->bkash == 0 ?'selected':''}} >Off</option>                                -->
                    <!--           </select>-->
                    <!--         </div>-->
                    <!--         @error('bkash')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">Nogod</strong>-->
                    <!--            <select class="form-select" name="nogod">-->
                    <!--            <option value="1" {{$information->nogod == 1 ?'selected':''}} >On</option>                               -->
                    <!--            <option value="0" {{$information->nogod == 0 ?'selected':''}} >Off</option>                                -->
                    <!--           </select>-->
                    <!--        </div>-->
                    <!--         @error('nogod')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">Rocket</strong>-->
                    <!--            <select class="form-select" name="rocket">-->
                    <!--            <option value="1" {{$information->rocket == 1 ?'selected':''}}>On</option>                               -->
                    <!--            <option value="0" {{$information->rocket == 0 ?'selected':''}}>Off</option>                                -->
                    <!--           </select>-->
                    <!--        </div>-->
                    <!--         @error('rocket')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                    <!--<div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">Paypal</strong>-->
                    <!--            <select class="form-select" name="paypal">-->
                    <!--            <option value="1" {{$information->paypal == 1 ?'selected':''}} >On</option>                               -->
                    <!--            <option value="0" {{$information->paypal == 0 ?'selected':''}} >Off</option>                                -->
                    <!--           </select>-->
                    <!--        </div>-->
                    <!--         @error('paypal')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                     
                    <!-- <div class="col-md-3">-->
                    <!--        <div class="form-group">-->
                    <!--           <strong for="role">Stripe</strong>-->
                    <!--            <select class="form-select" name="stripe">-->
                    <!--            <option value="1" {{$information->stripe == 1 ?'selected':''}} >On</option>                               -->
                    <!--            <option value="0" {{$information->stripe == 0 ?'selected':''}} >Off</option>                                -->
                    <!--           </select>-->
                    <!--        </div>-->
                    <!--         @error('stripe')-->
                    <!--         <p class="text-danger">-->
                    <!--             {{$message}}-->
                    <!--         </p>-->
                    <!--        @enderror-->
                    <!--    </div>-->
                     <div class="col-md-3">
                            <div class="form-group">
                               <strong for="role">Currency</strong>
                                <select class="form-select" name="currency">
                                <option value="BDT" {{$information->currency == 'BDT' ?'selected':''}} >BDT</option>   
                                <option value="Dollar" {{$information->currency == 'Dollar' ?'selected':''}} >Dollar</option>                               
                                <option value="Euro" {{$information->currency == 'Euro' ?'selected':''}} >Euro</option>  
                                <option value="Rupee" {{$information->currency == 'Rupee' ?'selected':''}} >Rupee</option>
                               </select>
                            </div>
                             @error('stripe')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                  </div>
                  
                  <div class="row mb-2">
                    <div class="col-md-3">
                            <div class="form-group">
                               <strong for="role">Support Number 1</strong>
                               <input type="text" id="supp_num1" class="form-control" name="supp_num1" placeholder="Site phone..." value="{{ $information->supp_num1 }}">
                             </div>
                             @error('bkash')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                    <div class="col-md-3">
                            <div class="form-group">
                               <strong for="role">Support Number 2</strong>
                                <input type="text" id="supp_num2" class="form-control" name="supp_num2" placeholder="Site phone..." value="{{ $information->supp_num2 }}">
                             </div>
                             @error('bkash')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                    <div class="col-md-3">
                            <div class="form-group">
                               <strong for="role">Support Number 3</strong>
                                <input type="text" id="supp_num3" class="form-control" name="supp_num3" placeholder="Site phone..." value="{{ $information->supp_num3 }}">
                             </div>
                             @error('bkash')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                        </div>
                    <div class="col-md-3">
                            <div class="form-group">
                               <strong for="role">Number Visible</strong>
                                <input type="text" id="number_visibility" class="form-control" name="number_visibility" placeholder="Visible Number..." value="{{ $information->number_visibility }}">
                             </div>
                             @error('bkash')
                             <p class="text-danger">
                                 {{$message}}
                             </p>
                            @enderror
                    </div>
                    
                    <h5 class="text-danger mt-3">These fields only for Redx Courier Service</h5>
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong for="redx_api_base_url">Redx API Base URL</strong>
                        <textarea name="redx_api_base_url" id="redx_api_base_url" rows="1" class="form-control" placeholder="https://sandbox.redx.com.bd/v1.0.0-beta">{{$information->redx_api_base_url}}</textarea>
                      </div>
                      @error('redx_api_base_url')
                      <p class="text-danger">
                        {{$message}}
                      </p>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong for="redx_api_access_token">Redx API Access Token</strong>
                        <textarea name="redx_api_access_token" id="redx_api_access_token" rows="4" class="form-control" placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI3Nzc2MjAiLCJpYXQiOjE2NzI4MTgyMDIsImlzcyI6IkVyeEZSY2VuemNOMkZrcmdyYXBUM1p6ZXN4emx2NnBOIiwic2hvcF9pZCI6Nzc3NjIwLCJ1c2VyX2lkIjoxNjQzNDY0fQ.1PO9zwZ-Wgy7bgzMfJ414EiEdqVCnSDJoodNXe1NNOU">{{$information->redx_api_access_token}}</textarea>
                      </div>
                      @error('redx_api_access_token')
                      <p class="text-danger">
                        {{$message}}
                      </p>
                      @enderror
                    </div>
               </div> 
                 <h5 class="text-danger mt-3">These fields only for Pathao Courier Service</h5>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong for="pathao_api_base_url">Pathao API Base URL</strong>
                        <textarea name="pathao_api_base_url" id="pathao_api_base_url" rows="1" class="form-control" placeholder="https://sandbox.redx.com.bd/v1.0.0-beta">
                          {{$information->pathao_api_base_url}}
                        </textarea>
                      </div>
                      @error('pathao_api_base_url')
                      <p class="text-danger">
                        {{$message}}
                      </p>
                      @enderror
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong for="pathao_api_access_token">Pathao API Access Token</strong>
                        <textarea name="pathao_api_access_token" id="pathao_api_access_token" rows="4" class="form-control" placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI3Nzc2MjAiLCJpYXQiOjE2NzI4MTgyMDIsImlzcyI6IkVyeEZSY2VuemNOMkZrcmdyYXBUM1p6ZXN4emx2NnBOIiwic2hvcF9pZCI6Nzc3NjIwLCJ1c2VyX2lkIjoxNjQzNDY0fQ.1PO9zwZ-Wgy7bgzMfJ414EiEdqVCnSDJoodNXe1NNOU">
                          {{$information->pathao_api_access_token}}
                        </textarea>
                      </div>
                      @error('pathao_api_access_token')
                      <p class="text-danger">
                        {{$message}}
                      </p>
                      @enderror
                    </div>                    
                    <div class="col-md-6">
                      <div class="form-group">
                        <strong for="pathao_store_id">Pathao API Store ID</strong>
                        <input type="text" name="pathao_store_id" id="pathao_store_id" value="{{$information->pathao_store_id}}" class="form-control" placeholder="Pathao store id">
                      </div>
                      @error('pathao_store_id')
                      <p class="text-danger">
                        {{$message}}
                      </p>
                      @enderror
                    </div>
               </div>
               
               <h5 class="text-danger mt-3">These fields only for Stead-Fast Courier Service</h5>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <strong for="pathao_api_base_url">Stead Fast API Base URL</strong>
                        <textarea name="steadfast_api_base_url" id="steadfast_api_base_url" rows="2" class="form-control" placeholder="https://sandbox.redx.com.bd/v1.0.0-beta">{{$information->steadfast_api_base_url}}</textarea></div>
                      @error('steadfast_api_base_url')
                      <p class="text-danger">
                        {{$message}}
                      </p>
                      @enderror
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <strong for="pathao_api_access_token">Stead Fast API Key</strong>
                        <textarea name="steadfast_api_key" id="steadfast_api_key" rows="2" class="form-control" placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI3Nzc2MjAiLCJpYXQiOjE2NzI4MTgyMDIsImlzcyI6IkVyeEZSY2VuemNOMkZrcmdyYXBUM1p6ZXN4emx2NnBOIiwic2hvcF9pZCI6Nzc3NjIwLCJ1c2VyX2lkIjoxNjQzNDY0fQ.1PO9zwZ-Wgy7bgzMfJ414EiEdqVCnSDJoodNXe1NNOU">{{$information->steadfast_api_key}}</textarea>
                      </div>
                      @error('pathao_api_access_token')
                      <p class="text-danger">
                        {{$message}}
                      </p>
                      @enderror
                    </div>                    
                    <div class="col-md-4">
                      <div class="form-group">
                        <strong for="pathao_api_access_token">Stead Fast Secret Key</strong>
                        <textarea name="steadfast_secret_key" id="steadfast_secret_key" rows="2" class="form-control" placeholder="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI3Nzc2MjAiLCJpYXQiOjE2NzI4MTgyMDIsImlzcyI6IkVyeEZSY2VuemNOMkZrcmdyYXBUM1p6ZXN4emx2NnBOIiwic2hvcF9pZCI6Nzc3NjIwLCJ1c2VyX2lkIjoxNjQzNDY0fQ.1PO9zwZ-Wgy7bgzMfJ414EiEdqVCnSDJoodNXe1NNOU">{{$information->steadfast_secret_key}}</textarea>
                      </div>
                      @error('steadfast_secret_key')
                      <p class="text-danger">
                        {{$message}}
                      </p>
                      @enderror
                    </div> 
               </div>
      
                    <hr>
                    <br>
                    <input type="submit" value="Update" class="btn btn-success">
                    <hr>
                </form>
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection 

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    
    $(document).ready(function(){
       $("#site_logo").change(function(e){
          let file = e.target.files[0];
          let temp = URL.createObjectURL(file);
          $("#preview_img").attr('src', temp);
       });
    });
  
</script>

@endpush