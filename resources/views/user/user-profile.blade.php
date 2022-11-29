
@extends('layouts.template.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid">
            <div class="fade-in">
               <div class="py-4">
                  <form action="/update-profile/{{Auth::user()->_id}}" method="POST" class="account_setting_validator"  id="account_setting_validator" enctype="multipart/form-data">

                     <div class="row">
                        <!-- Main Content -->
                        <aside class="col-md-2">
                           <div class="mb-3 border rounded bg-white profile-box text-center w-10">
                              <div class="p-3 d-flex align-items-center">
                                 @if($user->get('profileImg'))
                                 <img src="{{asset('storage/'. $user->get('profileImg'))}}" id='profileimg' class="img-fluid rounded-circle" width="500" height="500">
                                 @else
                                 <img src="{{asset('assets/img/avatars/profile.png')}}" id='profileimg' class="img-fluid rounded-circle" width="500" height="500">
                                 @endif
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="form-file">
                                    <input type="file" class="form-file-input" name="profileImg" id="profilefile01" onchange="readImg(this);">
                                    <label class="form-file-label" for="profilefile01" aria-describedby="inputGroupFileAddon02">
                              </div>
                           </div>  
                      

                        </aside>
                        <main class="col-md-10">
                           <div class=" row">
                              <div class="border rounded bg-white col-sm-8">
                                 <div class="box-title border-bottom p-3">
                                    <h6 class="m-0">User Profile</h6>
                                    <p class="mb-0 mt-0 small">This information will be used to contact you.
                                    </p>
                                 </div>
                                 <div class="box-body p-3">
                                    @csrf
                                    <div class="row">
                                       <!-- Input -->
                                       <div class="col-sm-6 mb-2">
                                          <div class="form-group">
                                             <label id="name" class="form-label font-weight-bold">
                                             Full Name
                                             <span class="text-danger">*</span>
                                             </label>
                                             <div class="form-group">
                                                   <input type="text" class="form-control" name="fullName" id="fullName" value="{{$user->get('fullName')}}" placeholder="Full Name" {{Auth::user()->isApproved && Auth::user()->registerComplete ? 'readonly' : 'required'}}>            
                                                <small class="form-text text-muted">Full Name same in the IC</small>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- End Input -->
                                       <!-- Input -->
                                       <div class="col-sm-6 mb-2">
                                          <div class="form-group">
                                             <label id="nric" class="form-label font-weight-bold">
                                             NRIC
                                             <span class="text-danger">*</span>
                                             </label>
                                             <div class="form-group">
                                                <input type="text" class="form-control nric"  value="{{substr(Auth::user()->nric,0,6)}}-{{substr(Auth::user()->nric,6,2)}}-{{substr(Auth::user()->nric,8,4) }}" readonly>
                                             </div>
                                          </div>
                                       </div>                                          
                                    <!-- End Input -->
                                    </div>
                                       
                                    <div class="row">
                                       <!-- Input -->
                                       <div class="col-md-6 mb-3 mb-sm-6">
                                             <div class="form-group">
                                                <label id="nameLabel" class="form-label font-weight-bold">
                                                Category
                                                <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-group">
                                                   <input type="text" class="form-control" name="name" value="{{Auth::user()->role->name}}" readonly>
                                                </div>
                                             </div>
                                       </div>
                                       <!-- End Input -->
                                       
                                       <div class="col-sm-6 mb-2">
                                          <div class="form-group">
                                                <label id="bod" class="form-label font-weight-bold">
                                                Date of Birth
                                                <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-group">
                                                   <input type="text" class="form-control" name="dateofbirth" id="dob" value="{{$user->get('birthofdate')}}" readonly>
                                                </div>
                                             </div>
                              
                                          </div>
                                           <!-- End Input -->
                                       </div>
                                    <div class="row">
                                       <!-- Input -->
                                       <div class="col-sm-6 mb-2">
                                          <div class="form-group">
                                                <label id="email" class="form-label font-weight-bold">
                                                Email address
                                                <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-group">
                                                   @if(($user->get('isApproved') == 0) || ($user->get('registerComplete') == 0))
                                                   <input type="email" class="form-control" value="{{Auth::user()->email}}" placeholder="Email" disabled>
                                                   <input type="hidden" class="form-control" name="email" id="email" value="{{Auth::user()->email}}" placeholder="Email">
                                                   @else
                                                   <input type="email" class="form-control" name="email" id="email" value="{{Auth::user()->email}}" placeholder="Email">
                                                   @endif
                                                </div>
                                             </div>
                                       </div>
                                       <!-- End Input -->
                                       <!-- Input -->
                                       <div class="col-sm-6 mb-2">
                                          <div class="form-group">
                                             <label id="phoneNumber" class="form-label font-weight-bold">
                                             Phone Number
                                             <span class="text-danger">*</span>
                                             </label>
                                             <div class="form-group">
                                                <input type="text" class="form-control" type="tel" name="phoneNumber" id="phoneNumber" value="{{$user->get('phoneNumber')}}" >
                                             </div>
                                          </div>
                                       </div>
                                       <!-- End Input -->
                                    
                                    </div>
                                    <div class="row">
                                       <!-- Input -->
                                       <div class="col-sm-12 mb-2">
                                          <div class="form-group">
                                             <label id="address" class="form-label font-weight-bold">
                                             Address
                                             <span class="text-danger">*</span>
                                             </label>
                                             <div class="form-group">
                                                <textarea class="form-control" rows=5  name="address" value="{{$user->get('address')}}" required>{{$user->get('address')}}</textarea>
                                             </div>
                                          </div>
                                          
                                       </div>
                                       <!-- End Input -->
                                    
                                    </div>
                                    <div class="row">
                                       <!-- Input -->
                                       <div class="col-sm-6 mb-2">
                                       <div class="form-group">
                                             <label id="lblstate" class="form-label font-weight-bold">
                                             State
                                             <span class="text-danger">*</span>
                                             </label>
                                             <div class="form-group">
                                                <select class="form-control custom-select" id="state" name="state_id" required>
                                                   <option value=""></option>
                                                   @foreach ($states as $state)
                                                      <option value="{{ $state->_id }}" {{($state->_id == $user->get('state_id') ? 'selected' :'' )}}>{{ ucfirst($state->name)}}</option>
                                                   @endforeach
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- End Input -->
                                       <!-- Input -->
                                       <div class="col-sm-6 mb-2">
                                          <div class="form-group">
                                             <label id="lblregion" class="form-label font-weight-bold">
                                             Region
                                             <span class="text-danger">*</span>
                                             </label>
                                             <div class="form-group">
                                                <select class="form-control custom-select" id="region" name="region_id" required>
                                                      <option></option>
                                                   </select>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- End Input -->
                                    </div>
                                    <div class="row">
                                       <!-- Input -->
                                       <div class="col-sm-6 mb-2">
                                          <div class="form-group">
                                             <label id="postcode" class="form-label font-weight-bold">
                                             Postcode
                                             <span class="text-danger">*</span>
                                             </label>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="postcode" id="postcode" value="{{$user->get('postcode')}}" >
                                             </div>
                                          </div>
                                       </div>
                                       <!-- End Input -->
                                       <!-- Input -->
                                       <div class="col-md-6 mb-3 mb-sm-6">
                                          <div class="form-group">
                                          <label id="uploadNRIC" class="form-label font-weight-bold">
                                             Uploaded NRIC
                                             <span class="text-danger">*</span>
                                             </label>
                                             <div class="form-group input-group mb-3">
                                                <div class="form-file">
                                                @if(!(Auth::user()->isApproved && Auth::user()->registerComplete))
                                                   <input type="file" class="form-control-file" id="uploadNRIC" name="uploadNRIC" {{(count($nric_file)>0) ? '' : 'required'}}> 
                                                @endif   
                                                <a href="/download/{{$nric_file->get('path')}}">{{$nric_file->get('name')}}</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- End Input -->
                                    </div>
                                 </div>
                              </div>
                              @if(url()->current() == Route('account-setting'))
                              <div class=" rounded  col-sm-4">
                             
                              <div class="border rounded bg-white mb-3 mt-0">
                                 <div class="box-title border-bottom p-3">
                                    <h6 class="m-0">Education</h6>
                                 </div>
                                 <div class="box-body p-3">
                                   
                                    <div class="col">
                                       <div class="form-group">
                                          <label id="name" class="form-label">
                                          Institution Name
                                          </label>
                                          @can('isUser')
                                          <select class="form-control custom-select" id="institution" name="institution_id" >
                                                   <option value=""></option>
                                                   @if(count($institutions) > 0)
                                                      @foreach ($institutions as $institution)
                                                         <option value="{{ $institution->institution->_id }}" {{($institution->institution->_id == $user->get('institution_id') ? 'selected' :'' )}}>{{ ucfirst($institution->institution->name)}}</option>
                                                      @endforeach
                                                   @endif
                                          </select>
                                          @endcan
                                          @can('isTutor')
                                          @if(count($institutions) > 0)
                                             @foreach ($institutions as $institution)
                                                @if($institution->institution->_id == $user->get('institution_id'))
                                                <input type="text" class="form-control" value="{{ ucfirst($institution->institution->name) }}" disabled>
                                                @endif
                                             @endforeach
                                          @endif

                                          @if(!$user->get('institution_id'))
                                             <input type="text" class="form-control" value="" disabled>
                                          @endif

                                          @endcan
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              

                              @can('isUser')
                              <div class="border rounded bg-white mb-3 mt-0">
                                 <div class="box-title border-bottom p-3">
                                    <h6 class="m-0">Supervisor</h6>
                                 </div>
                                 <div class="box-body p-3">
                                   
                                    <div class="col">
                                       <div class="form-group">
                                          <label id="name" class="form-label">
                                          Name
                                          </label>
                                          <input type="text" class="form-control" value="{{$mentor->get('fullName')}}" disabled>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              @endcan

                                 
                                 <div class="border rounded bg-white">
                                    <div class="box-title border-bottom p-3">
                                       <h6 class="m-0">Experience</h6>
                                    </div>
                                    <div class="box-body p-3">
                                    <div class="col">
                                          <div class="form-group">
                                             <label id="name" class="form-label">
                                             Highest Education Level
                                             </label>
                                             <div class="form-group">
                                                <!-- <input type="text" class="form-control" name="eduLevel" id="eduLevel" value="{{$user->get('eduLevel')}}" placeholder="Ex. Diploma" > -->
                                                <select class="form-control custom-select" id="eduLevel" name="eduLevel" >
                                                   <option value=""></option>
                                                   <option value="SPM" {{($user->get('eduLevel') == "SPM" ? 'selected' :'' )}}>SPM</option>
                                                   <option value="Diploma" {{($user->get('eduLevel') == "Diploma" ? 'selected' :'' )}}>Diploma</option>
                                                   <option value="Degree" {{($user->get('eduLevel') == "Degree" ? 'selected' :'' )}}>Degree</option>
                                                   <option value="Master" {{($user->get('eduLevel') == "Master" ? 'selected' :'' )}}>Master</option>
                                                   <option value="Phd" {{($user->get('eduLevel') == "Phd" ? 'selected' :'' )}}>Phd</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col">
                                          <div class="form-group">
                                             <label id="name" class="form-label">
                                             Occupation
                                             </label>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="occupation" id="occupation" value="" placeholder="Ex. Software Developer" >
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col">
                                          <div class="form-group">
                                             <label id="name" class="form-label">
                                             Postion
                                             </label>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="position" id="position" value="{{$user->get('position')}}" placeholder="Ex. Junior" >
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col">
                                          <div class="form-group">
                                             <label id="name" class="form-label">
                                             Expertise
                                             </label>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="expertise" id="expertise" value="{{$user->get('expertise')}}" placeholder="Ex. Developer" >
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col">
                                          <div class="form-group">
                                             <label id="name" class="form-label">
                                             Start Year
                                             </label>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="start_year" id="start_year" value="{{$user->get('start_year')}}" placeholder="2020" >
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col">
                                          <div class="form-group">
                                             <label id="name" class="form-label">
                                             End Year
                                             </label>
                                             <div class="form-group">
                                                <input type="text" class="form-control" name="end_year" id="end_year" value="{{$user->get('end_year')}}" placeholder="2021" >
                                             </div>
                                          </div>
                                       </div>
                                    
                                    </div>
                                 </div>
                          
                              </div>
                              @endif

                           
                           </div>
                           <div class="mb-3 mt-3 text-right col-md-8 ml-3">
                              <button class="font-weight-bold btn btn-success rounded p-3" form="account_setting_validator" type="submit" value="Submit">
                              &nbsp;&nbsp;&nbsp;&nbsp;  Submit &nbsp;&nbsp;&nbsp;&nbsp;

                              </button>
                           </div>

                        </main>
                       
                        
                     </div>
                  </form>
                  
                  
               </div>
      </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/wow/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admire/account-setting.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>

<script>
   
   $(document).ready(function() {
      get_region();

      $('#state').change(function(){
         get_region();
      }); 

      function get_region(){
         var state = $('#state').val();
            var $select = $('#region');
            var option;
            $select.empty();
            $.get( "/get-region", { state_id : state} )
               .done(function( data ) {
                  for (var index in data) {
                     $option = $("<option value='" + data[index]._id + "'>" + data[index].name + '</option>'); 
                     $select.append($option);
                     if(data[index]._id == '{{$user->get("region_id")}}')
                        $('option[value='+data[index]._id+']').attr('selected','selected');
                  }
               });
      }

   var dp= $("#start_year").datepicker({
         format: "yyyy",
         viewMode: "years", 
         minViewMode: "years",
         autoclose:true
      }); 
   
      var dp= $("#end_year").datepicker({
         format: "yyyy",
         viewMode: "years", 
         minViewMode: "years",
         autoclose:true
      }); 

   });
</script>
@endsection