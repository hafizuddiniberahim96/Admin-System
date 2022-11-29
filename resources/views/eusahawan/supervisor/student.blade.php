
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
                @if(Auth::user()->institution)
                    <div class="border rounded bg-white mb-3" id="profile">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">{{ucwords(Auth::user()->institution->name)}}</h6>
                        </div>
                        <div class="box-body p-3">
                            <div class="card mt-5 ">
                                <div class="card-header">
                                    <h4 class="card-title" ></i> 
                                        List Students
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
                            
                        </div>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admire/institution.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/wow/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>

<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

<script>
   
   $(document).ready(function() {
    
      

      var table = $('#table2').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('myeusahawan.institution.supervisor.list',['student']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'fullName', title: "FullName"},
                    {data: 'nric', name: 'nric', title: "Identity Number"},
                    {data: 'email', name: 'email', title: "Email"},
                    {data: 'phone', name: 'phone', title: "Phone Number"},
                    {data: 'state', name: 'state', title: "State"},
                    {data: 'region', name: 'region', title: "Region"},
                    {data: 'action', name: 'action', title: " Action"},


                ]
                    });

   });
</script>

@endsection