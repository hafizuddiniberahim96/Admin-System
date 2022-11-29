
@extends('layouts.template.base')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="py-4">
            <div class="container">
                <div class="col-md-12">
                @if(Auth::user()->institution || !empty($institution))

                <!-- Has school registered -->
                
                    @if($institution->status->isApproved == 1)
                    <div class="border rounded bg-white mb-3" id="profile">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">My Institution</h6>
                            @if(Auth::user()->institution)
                            <a  class="btn btn-labeled btn-info pull-right text-white" type="button" data-toggle="tooltip" data-placement="top" title="Certificate">Download Certificates</a> 
                            @endif
                        </div>
                        <div class="box-body p-3">
                            @if(!Auth::user()->institution)
                            <!-- If registered institution has been approved but the teacher did not registered in account setting yet. -->
                                <p class="text-center">
                                    Your registered institution has been <span class="badge bg-success text-white">approved</span> by administrator. 
                                    You can view your institution 
                                    <a  class="btn btn-labeled btn-info " type="button" href="/mye-usahawan/institution/{{$institution->_id}}">here</a> 
                                    .
                                </p>
                                <p class="text-center">
                                    You dont have any institution registered yet. Please select your institution below.
                                </p>
                            @else
                            <div class="card mt-5 ">
                                <div class="card-header">
                                    <h4 class="card-title" ></i> 
                                        List Teacher And  Students
                                    </h4>
                                </div>
                            <div >
                            <div class="card-body accordion-body">
                                    <div class="row">
                                        <div class="col s12" style="overflow: auto">
                                            <table id="table2" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;"></table>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                    
                    @else

                    <div class="border rounded bg-white mb-3" id="profile">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">My Institution</h6>
                        </div>
                        <div class="box-body p-3">
                            <p class="text-center">
                                Your institution 
                                @if($institution->status->isApproved == -1)
                                has been rejected. Please 
                                <a  class="btn btn-labeled btn-info " type="button" data-toggle="tooltip" data-placement="top" title="Update" href="/mye-usahawan/update-institution/{{$institution->_id}}">Update</a> 
                                
                                your institution for further action.
                                @else
                                is currently in                             
                                <a  class="btn btn-labeled btn-warning " type="button" data-toggle="tooltip" data-placement="top" title="Review" href="/mye-usahawan/institution/{{$institution->_id}}">Review</a> 
                                by administrator.
                                @endif
                            </p> 

                            <p class="text-center">
                                If your institution has been registered,please select your institution below.
                            </p>
                        </div>
                    </div>
                    @endif             
                @else
                <!-- Dont have school registered -->
                <div class="border rounded bg-white mb-3" id="profile">
                    <div class="box-title border-bottom p-3">
                        <h6 class="m-0">My Institution</h6>
                    </div>
                    <div class="box-body p-3">
                        <p class="text-center">
                            You dont have any institution registered yet. Please select your institution below.
                        </p>
                        <p class="text-center">
                            If your institution is not listed,  
                            <a  class="btn btn-labeled btn-info " type="button" data-toggle="tooltip" data-placement="top" title="Register" href="/mye-usahawan/register-institution">Register</a> 
                            here.
                        </p> 
                    </div>
                </div>
                @endif

                @if(!Auth::user()->institution)

                <div class="border rounded bg-white mb-3 mt-0">
                    <form action="/mye-usahawan/select-institution/{{Auth::user()->id}}" method="POST" class="institution_form"  id="institution_form">
                        @csrf
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Institution</h6>
                        </div>
                        <div class="box-body p-3">                        
                        <div class="col">
                            <div class="form-group">
                                <label id="name" class="form-label">
                                Name
                                </label>
                                @can('isTutor')
                                <select class="form-control custom-select" id="institution_id" name="institution_id" >
                                        <option value=""></option>
                                        @if(count($institutions) > 0)
                                            @foreach ($institutions as $institution)
                                                <option value="{{ $institution->institution->_id }}">{{ ucfirst($institution->institution->name)}}</option>
                                            @endforeach
                                        @endif
                                </select>

                                @endcan
                            </div>
                        </div>
                        <div class="mb-3 text-right">
                            <button class="font-weight-bold btn btn-success rounded p-3" form="institution_form" type="submit" value="Submit">
                            &nbsp;&nbsp;&nbsp;&nbsp;  Submit &nbsp;&nbsp;&nbsp;&nbsp;
                            </button>
                        </div>

                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>\
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

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
                  }
               });
      }
      

      var table = $('#table2').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('myeusahawan.institution.students.list',[($institution) ? $institution->_id : 0]) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'fullName', title: "FullName"},
                    {data: 'nric', name: 'nric', title: "Identity Number"},
                    {data: 'role', name: 'role', title: " Category"},
                    {data: 'email', name: 'email', title: "Email"},
                    {data: 'phone', name: 'phone', title: "Phone Number"},
                    {data: 'state', name: 'state', title: "State"},
                    {data: 'region', name: 'region', title: "Region"},

                ]
                    });

   });
</script>

@endsection