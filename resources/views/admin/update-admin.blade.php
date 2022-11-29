
@extends('layouts.template.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>

@endsection

@section('content')
<div class="container-fluid">
            <div class="fade-in">
               <div class="py-4">
                  <div class="container">
                  <form action="{{Route('admin.update.admin')}}" method="POST" class="update_user_form_validator"  id="update_user_form_validator" enctype="multipart/form-data">
                     @csrf
                     <div class="row">
                        <!-- Main Content -->
                        <aside class="col-md-3">
                           <div class="mb-3 border rounded bg-white profile-box text-center w-10">
                              <div class="p-3 d-flex align-items-center">
                                 <img src="{{asset('storage/'. $user->get('profileImg'))}}" id='profileimg' class="img-fluid rounded-circle" width="500" height="500">
                              </div>
                           </div>
                           <div class="form-group" {{($action == 'readonly') ? 'hidden' : ''}}>
                              <div class="form-file">
                                    <input type="file" class="form-file-input" name="profileImg" id="profilefile01" onchange="readImg(this);" >
                                    <label class="form-file-label" for="profilefile01" aria-describedby="inputGroupFileAddon02">
                              </div>
                           </div> 
                           
                        </aside>

                        <main class="col-md-8">
                           <div class="border rounded bg-white mb-3">
                              <div class="box-title border-bottom p-3">
                                 <h6 class="m-0">Admin Profile</h6>
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
                                             <input type="text" class="form-control" name="name" id="name" value="{{$user->get('fullName')}}" placeholder="Full Name"  {{$action}}>
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
                                             <input type="text" class="form-control nric" name="nric" id="nric" value="{{$user->get('nric')}}" onChange="DobAutoFill()"  readonly>
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
                                                <input type="text" class="form-control" name="name" value="admin" readonly>
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
                                                <input type="text" class="form-control" name="dateofbirth" id="dob" readonly>
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
                                                <input type="email" class="form-control" name="email" id="email" value="{{$user->get('email')}}" placeholder="Email" {{$action}}>
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
                                             <input type="text" class="form-control" type="tel" name="phoneNumber" id="phoneNumber" value="{{$user->get('phoneNumber')}}" {{$action}} >
                                          </div>
                                       </div>
                                    </div>
                                    <!-- End Input -->
                                 
                                 </div>
                                 <div class="row">
                                    <!-- Input -->
                                    <div class="col-sm-6 mb-2">
                                       <div class="form-group" {{($action == '') ? 'hidden' : ''}} >
                                             <label id="password" class="form-label font-weight-bold">
                                             Password
                                             </label>
                                             <div class="form-group">
                                                <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                                             </div>
                                          </div>
                                    </div>
                                    <!-- End Input -->
                                    <!-- Input -->
                                    <div class="col-sm-6 mb-2">
                                       <div class="form-group" {{($action == '') ? 'hidden' : ''}} >
                                          <label id="confirmpassword" class="form-label font-weight-bold">
                                          Confirm Password
                                          </label>
                                          <div class="form-group">
                                             <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" value="" placeholder="Confim Password"  required>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- End Input -->
                                 
                                 </div>
                               
                              </div>
                           </div>
                           <div class="mb-3 text-right" >
                              <button class="font-weight-bold btn btn-success rounded p-3" form="update_user_form_validator" type="submit" value="Submit">
                              &nbsp;&nbsp;&nbsp;&nbsp;  Submit &nbsp;&nbsp;&nbsp;&nbsp;

                              </button>
                           </div>

                        </main>
                     </div>
                  </form>
                  
                  </div>
               </div>
      </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/wow/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admire/update-user-form.js')}}"></script>

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

   });
</script>
@endsection