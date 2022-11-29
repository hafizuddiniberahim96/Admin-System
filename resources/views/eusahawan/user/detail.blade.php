
@extends('layouts.template.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')


<div class="container-fluid">
            <div class="fade-in">
               <div class="py-4">
                  <div class="container">
                     <div class="row">
                        <!-- Main Content -->
                        <aside class="col-md-2">
                           <div class="mb-3 border rounded bg-white profile-box text-center w-10">
                              <div class="p-3 d-flex align-items-center">
                                 @if($user->get('profileImg'))
                                 <img src="{{asset('storage/'. $user->get('profileImg'))}}" id='profileimg' class="img-fluid rounded-circle" width="500" height="500">
                                 @else
                                 <img src="{{ url('/assets/img/avatars/profile.png') }}" class="img-fluid rounded-circle" width="500" height="500">
                                 @endif
                              </div>
                              
                           </div>                      
                        </aside>

                        <main class="col-md-10">
                           <div class="rounded btn-group btn-group-toggle bg-white" data-toggle="buttons">
                                 <button class="btn btn-ghost-primary" id="buttonProfile" onclick="showData(1)">
                                    Profile
                                 </button>
                                 <button class="btn btn-ghost-primary" id="buttonReport" onclick="showData(2)">
                                    Report
                                 </button>
                                 @if(in_array($user->get('role'),['student','entrepreneur']))
                                 <button class="btn btn-ghost-primary" id="buttonPenaziran" onclick="showData(3)">
                                    Penaziran
                                 </button>
                                 @endif

                              </div>
                           <div class="row">

                           <div class="border rounded bg-white col-sm-8" id="profile">
                              <div class="box-title border-bottom p-3">
                                 <h6 class="m-0">Update Basic Information</h6>
                                 <p class="mb-0 mt-0 small">This information will be used to contact you.
                                 </p>
                              </div>
                              <div class="box-body p-3">
                                 <div class="row">
                                    <!-- Input -->
                                    <div class="col-sm-6 mb-2">
                                       <div class="form-group">
                                          <label id="name" class="form-label font-weight-bold">
                                          Full Name
                                          <span class="text-danger">*</span>
                                          </label>
                                          <div class="form-group">
                                             <input type="text" class="form-control" name="name" id="name" value="{{$user->get('fullName')}}" disabled>
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
                                             <input type="text" class="form-control nric" name="nric" id="nric" value="{{substr($user->get('nric'),0,6)}}-{{substr($user->get('nric'),6,2)}}-{{substr($user->get('nric'),8,4) }}"disabled>
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
                                                <input type="text" class="form-control" name="name" value="{{$user->get('role')}}" disabled>
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
                                             <input type="text" class="form-control" name="dob" id="dob" disabled>
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
                                                <input type="email" class="form-control" name="email" id="email" value="{{$user->get('email')}}" disabled>
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
                                             <input type="text" class="form-control" type="tel" name="phoneNumber" id="phoneNumber" value="{{$user->get('phoneNumber')}}" disabled>
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
                                             <textarea rows=5 class="form-control"  name="address" value="" disabled>{{$user->get('address')}}</textarea>
                                          </div>
                                       </div>
                                       
                                    </div>
                                    <!-- End Input -->
                                 
                                 </div>
                                 <div class="row">
                                    <!-- Input -->
                                    <div class="col-sm-6 mb-2">
                                       <div class="form-group">
                                          <label id="state" class="form-label font-weight-bold">
                                          State
                                          <span class="text-danger">*</span>
                                          </label>
                                          <div class="form-group">
                                          <input type="text" class="form-control" name="state" id="state" value="{{$user->get('state_name')}}" disabled >
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
                                          <input type="text" class="form-control" name="region" id="region" value="{{$user->get('region_name')}}" disabled >
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
                                             <input type="text" class="form-control" name="postcode" id="postcode" value="{{$user->get('postcode')}}" disabled>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- End Input -->
                                    <!-- Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                       <div class="form-group">
                                       <label id="uploadNRIC" class="form-label font-weight-bold">
                                          NRIC Document
                                          <span class="text-danger">*</span>
                                          </label>
                                          <div class="form-group input-group mb-3">
                                             <a href="/download/{{$nric_file->get('path')}}">{{$nric_file->get('name')}}</a>
                                          </div>
                                       </div>
                                    </div>
                                    <!-- End Input -->
                                 </div>
                              </div>
                           </div>
                           <div class=" rounded  col-sm-4" id="education">
                              <div class="border rounded bg-white mb-3 mt-0">
                                 <div class="box-title border-bottom p-3">
                                    <h6 class="m-0">Education</h6>
                                 </div>
                                 <div class="box-body p-3">
                                    <div class="col">

                                       @if(in_array($user->get('role'),['student','entrepreneur']))
                                       <div class="form-group">
                                          <label id="name" class="form-label">
                                          Institution Name
                                          </label>
                                          <div class="form-group">
                                             <input type="text" class="form-control" name="institution" id="institution" value="{{$user->get('institution')}}" disabled >
                                          </div>
                                       </div>
                                       @else
                                       <form action="/mye-usahawan/select-institution/{{$user->get('_id')}}" method="POST" class="institution_form"  id="institution_form">
                                          @csrf
                                          <div class="form-group">
                                             <label id="name" class="form-label">
                                             Institution Name
                                             </label>
                                             <div class="form-group">
                                                <select class="form-control custom-select" id="institution" name="institution_id" >
                                                         <option value=""></option>
                                                         @if(count($institutions) > 0)
                                                            @foreach ($institutions as $institution)
                                                               <option value="{{ $institution->institution->_id }}" {{($institution->institution->_id == $user->get('institution_id') ? 'selected' :'' )}}>{{ ucfirst($institution->institution->name)}}</option>
                                                            @endforeach
                                                         @endif
                                                </select>
                                             </div>
                                             @if ($errors->any())
                                                <div class="alert alert-danger">
                                                   <ul>
                                                      @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                      @endforeach
                                                   </ul>
                                                </div>
                                             @endif
                                             <button class="font-weight-bold btn btn-success rounded " form="institution_form" type="submit" value="Submit">
                                             &nbsp;&nbsp;&nbsp;&nbsp;  Submit &nbsp;&nbsp;&nbsp;&nbsp;
                                             </button>
                                             </div>
                                       </form>
                                       
                                       @endif


                                    </div>

                                 </div>
                              </div>

                              @if(in_array($user->get('role'),['student','entrepreneur']))
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
                              @endif
                              
                              <div class="border rounded bg-white mb-3">
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
                                             <input type="text" class="form-control" name="eduLevel" id="eduLevel" value="{{$user->get('eduLevel')}}" disabled >
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div class="form-group">
                                          <label id="name" class="form-label">
                                          Occupation
                                          </label>
                                          <div class="form-group">
                                             <input type="text" class="form-control" name="occupation" id="occupation" value="" disabled >
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div class="form-group">
                                          <label id="name" class="form-label">
                                          Postion
                                          </label>
                                          <div class="form-group">
                                             <input type="text" class="form-control" name="position" id="position" value="{{$user->get('position')}}" disabled >
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div class="form-group">
                                          <label id="name" class="form-label">
                                          Expertise
                                          </label>
                                          <div class="form-group">
                                             <input type="text" class="form-control" name="expertise" id="expertise" value="{{$user->get('expertise')}}" disabled >
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div class="form-group">
                                          <label id="name" class="form-label">
                                          Start Year
                                          </label>
                                          <div class="form-group">
                                             <input type="text" class="form-control" name="start_year" id="start_year" value="{{$user->get('start_year')}}" disabled >
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div class="form-group">
                                          <label id="name" class="form-label">
                                          End Year
                                          </label>
                                          <div class="form-group">
                                             <input type="text" class="form-control" name="end_year" id="end_year" value="{{$user->get('end_year')}}" disabled >
                                          </div>
                                       </div>
                                    </div>
                                   
                                 </div>
                              </div>
                          
                           </div>
                           </div>

                           <div class="border rounded bg-white" id="report">
                              <div class="box-title border-bottom p-3">
                                 <h6 class="m-0">Reports</h6>
                                 <p class="mb-0 mt-0 small">List of {{$user->get('role')}} activity reports.
                                 </p>
                              </div>
                              <div class="box-body p-3">
                                 <div class="row">
                                       <div class="col s12" style="overflow: auto">
                                          @if(in_array($user->get('role'),['student','entrepreneur']))
                                          <table id="table" class="table table-striped table-bordered dataTable no-footer" style="width:100%;"></table>
                                          @else
                                          <table id="table-penaziran" class="table table-striped table-bordered dataTable no-footer" style="width:100%;"></table>
                                          @endif
                                       </div>  
                                 </div>
                              </div>
                           </div>
                           @if(in_array($user->get('role'),['student','entrepreneur']))
                           <div class="border rounded bg-white" id="penaziran">
                           <div class="box-title border-bottom p-3">
                              <h6 class="m-0">Penaziran Reports</h6>
                              <p class="mb-0 mt-0 small">List of {{$user->get('role')}} penaziran reports.
                              </p>
                           </div>
                           <div class="box-body p-3">
                           <div class="row">
                                 <div class="col s12" style="overflow: auto">
                                    <table id="table-ditazir" class="table table-striped table-bordered dataTable no-footer" style="width:100%;"></table>
                                 </div>  
                              </div>
                           </div>
                           </div>
                           @endif
                        </main>
                     </div>
                  </div>
               </div>
      </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>

<script type="text/javascript" src="{{asset('/vendor/admire/wow/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admire/account-setting.js')}}"></script>
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

<script>
   function showData($selected) {
      if($selected == 1){
         $("#profile").show();
         $("#education").show();
         $("#report").hide();
         $("#penaziran").hide();
         $("#buttonProfile").addClass("active");
         $("#buttonReport").removeClass("active");
         $("#buttonPenaziran").removeClass("active");

      }
      else if($selected == 2){
         $("#profile").hide();
         $("#education").hide();
         $("#report").show();
         $("#penaziran").hide();
         $("#buttonProfile").removeClass("active");
         $("#buttonReport").addClass("active");
         $("#buttonPenaziran").removeClass("active");
      }else{
         $("#profile").hide();
         $("#education").hide();
         $("#report").hide();
         $("#penaziran").show();
         $("#buttonProfile").removeClass("active");
         $("#buttonReport").removeClass("active");
         $("#buttonPenaziran").addClass("active");
      }
   }

   $(document).ready(function() {
      
      showData(1);


   });

   $(function () {
       var table = $('#table').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{ route('list.document.download',['private','report_user', $user->get('_id') ? $user->get('_id') : 'None' ]) }}",
       columns: [
           {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
           {data: 'name', name: 'DocumentName', title: "Name"},
           {data: 'desc', name: 'desc', title: "Description"},
           {data: 'created_at.display', name: 'created_at', title: "Created On"},
           {data: 'action', name: 'action', title: "Action"}
       ]
           });

      var table1 = $('#table-penaziran').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{ route('myeusahawan.penaziran.report.list',[$user->get('_id') ? $user->get('_id') : 'None']) }}",
       columns: [
           {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
           {data: 'event_name', name: 'event_name', title: "Event Name"},
           {data: 'attandance_name', name: 'attandance_name', title: "Auditee Name"},
           {data: 'attandance_nric', name: 'attandance_nric', title: "Auditee NRIC"},
           {data: 'attandance_role', name: 'attandance_role', title: "Auditee Role"},
           {data: 'action', name: 'action', title: "Action"}
       ]
      });

      var table2 = $('#table-ditazir').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{ route('myeusahawan.ditazir.report.list',[$user->get('_id') ? $user->get('_id') : 'None']) }}",
       columns: [
           {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
           {data: 'event_name', name: 'event_name', title: "Event Name"},
           {data: 'auditor_name', name: 'auditor_name', title: "Auditor Name"},
           {data: 'auditor_nric', name: 'auditor_nric', title: "Auditor NRIC"},
           {data: 'auditor_role', name: 'auditor_role', title: "Auditor Role"},
           {data: 'action', name: 'action', title: "Action"}
       ]
      });
}); 
</script>

@endsection