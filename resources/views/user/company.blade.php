
@extends('layouts.template.base')
@section('css')
    <link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/pickers/daterange/daterangepicker.css">

@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="py-4">
        
            <div class="container">
                <div class="rounded btn-group btn-group-toggle bg-white" data-toggle="buttons">
                    <button class="btn btn-ghost-primary" id="buttonCompany" onclick="showData(1)">
                    Company
                    </button>
                    @if(Auth::user()->company)
                        <button class="btn btn-ghost-primary" id="buttonFile" onclick="showData(2)">
                        File
                        </button>
                        <button class="btn btn-ghost-primary" id="buttonProduct" onclick="showData(3)">
                        Product
                        </button>
                    @endif
                </div>
                <form action="/company" method="POST" class="company_validator"  id="company_validator" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Main Content -->
                            <div class="col-12">
                                <div class="border rounded bg-white col-md-auto">
                                    <div class="box-title border-bottom p-3">
                                    <h6 class="m-0">Company Profile</h6>
                                    </div>
                                    <div class="box-body p-3">
                                    @csrf
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label id="name" class="form-label font-weight-bold">
                                                Name
                                                <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name" id="name" value="{{$company->get('name')}}" placeholder="Company Name" >            
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div>
                                        
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label id="nossm" class="form-label font-weight-bold">
                                                No SSM
                                                <span class="text-danger">*</span>
                                            </label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="SSMNo" value="{{$company->get('SSMNo')}}" placeholder="202101XXXXXX" >
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                        
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                            <label  class="form-label font-weight-bold">
                                            Established Date
                                            <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="dateEstablished" id="established" value="{{$company->get('dateEstablished')}}" placeholder="01/01/2020">
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
                                                <textarea class="form-control" rows=5  name="address" value="{{$company->get('address')}}" required>{{$company->get('address')}}</textarea>
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
                                                            <option value="{{ $state->_id }}" {{($state->_id == $company->get('state_id') ? 'selected' :'' )}}>{{ ucfirst($state->name)}}</option>
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
                                                <input type="text" class="form-control" name="postcode" id="postcode" value="{{$company->get('postcode')}}" place>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label id="lblsector" class="form-label font-weight-bold">
                                                Service Sector
                                                <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-group">
                                                    <select class="form-control custom-select" id="sector" name="system_settings_id" required>
                                                        <option value=""></option>
                                                        @foreach ($sectors as $sector)
                                                            <option value="{{ $sector->_id }}" {{( $sector->_id == $company->get('system_settings_id') ? 'selected' :'' )}}>{{ ucfirst($sector->name)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div>
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                                <div class="form-group">
                                                <label id="email" class="form-label font-weight-bold">
                                                Email Address
                                                <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="email" value="{{$company->get('email')}}">
                                                </div>
                                                </div>
                                        </div>
                                        <!-- End Input -->
                                        
                                        <div class="col-sm-6 mb-2">
                                            <div class="form-group">
                                            <label id="phoneNumber" class="form-label font-weight-bold">
                                            Phone Number
                                            <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" value="{{$company->get('phoneNumber')}}" >
                                            </div>
                                            </div>
                            
                                        </div>
                                        <!-- End Input -->
                                    </div>
                                    </div>
                                </div>
                                <div class="mb-3 mt-3 ml-3">
                                    <button class="font-weight-bold btn btn-success rounded p-3 pull-right" form="company_validator" type="submit" value="Submit">
                                    &nbsp;&nbsp;&nbsp;&nbsp;  Submit &nbsp;&nbsp;&nbsp;&nbsp;
                                    </button>
                                </div>

                            </div>               
                    </div>
                </form>  

                <div class="row" id="file_upload">
                    <div class="col-12 ">
                        <div class="border rounded bg-white col-md-auto">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">File Upload</h6>
                            </div>
                            <div class="box-body p-3">
                                <form action="/company-uploads" method="post" enctype="multipart/form-data"  class="company_uploads"  id="company_uploads">   
                                    @csrf
                                <div class="row">
                                    <!-- Input -->
                                    <div class="col-sm-12 mb-2">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="control-label font-weight-bold col" for="field1"> File  
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <label class="control-label font-weight-bold col mr-5" for="field1"> Description  
                                                    <span class="text-danger">*</span>
                                                </label>
                                            </div>
                                            <div class="controls">
                                                <div class="entry input-group upload-input-group">
                                                    <input type="hidden"  name="id" value="{{$company->get('_id')}}">            
                                                    <input class="form-control" name="fields[]" type="file" accept="application/pdf" required>
                                                    <input class="form-control ml-4 mr-2"   name="fields_desc[]" type="text" placeholder="Description" >
                                                    <button class="btn btn-upload btn-success btn-add" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button class="btn btn-info pull-right mt-4" form="company_uploads" type="submit">Upload</button>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                </div>
                                </form> 
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div> 
                    <div class="col-12 mt-3">
                        <div class="border rounded bg-white col-md-auto">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">File List</h6>
                            </div>
                           
                            <div class="card-body">
                                <div class="row">
                                    <div class="col s12" style="overflow: auto">
                                        <table id="table" class="table table-striped table-bordered dataTable no-footer" style="width: 100% !important;"></table>
                                    </div>
                                </div>  
                            </div>
                        </div>

                        
                    </div> 
                                
                </div>
                        
                <div class="row" id="product">
                    <div class="col-12">
                        <div class="border rounded bg-white col-md-auto">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Product</h6>
                            </div>
                            <div class="box-body p-3">
                                <form action="/company/create-product" method="post" enctype="multipart/form-data" class="form-horizontal" >   
                                @csrf
                                <div class="row">
                                    <!-- Input -->
                                    <div class="col-sm-12 mb-2">
                                        <div class="form-group">
                                            <label class="form-label font-weight-bold">
                                            Product
                                            </label>
                                            <div class="product-controls">
                                                <div class="product-entry input-group upload-input-group">
                                                    <input type="text" class="form-control product" name="products[]" placeholder="Product Name" required>   
                                                    <input type="hidden"  name="id" value="{{$company->get('_id')}}">                     
                                                    <button class="btn btn-upload btn-success product-add" type="button">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                                </div>
                                            <button class="btn btn-info pull-right mt-4">Submit</button>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                </div>
                                </form> 
                            </div>
                        </div>
                    </div>  
                    <div class="col-12 mt-3">
                        <div class="border rounded bg-white col-md-auto">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Product List</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col s12" style="overflow: auto">
                                        <table id="table2" class="table table-striped table-bordered dataTable no-footer" style="width: 100% !important;"></table>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admire/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/wow/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admire/company.js')}}"></script>
<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/pickers/daterange/daterangepicker.js')}}"></script>

<script>
    $(document).ready(function() {

        $('#established').daterangepicker({
            locale: {
                format: 'DD/MM/YYYY'
            },
            singleDatePicker: true
        });
       
        var table = $('#table').DataTable({
                
                processing: true,
                serverSide: true,
                ajax: "{{ route('list.document',['private','company', $company->get('_id') ?? 'none']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'DocumentName', title: "File Name"},
                    {data: 'desc', name: 'desc', title: "Description"},
                    {data: 'created_at.display', name: 'created_at', title: "Created On"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
        });

        var table = $('#table2').DataTable({
                
                processing: true,
                serverSide: true,
                ajax: "{{ route('company.product.list',[$company->get('_id') ?? 'none']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'DocumentName', title: "File Name"},
                    {data: 'created_at.display', name: 'created_at', title: "Created On"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
        });
       
       
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
                   option = $("<option value='" + data[index]._id + "'>" + data[index].name + '</option>'); 
                   $select.append(option);
                   if(data[index]._id == '{{$company->get("region_id")}}')
                        $('option[value='+data[index]._id+']').attr('selected','selected');
                  
                }
             });
    }
    });


    showData(1);

    function showData($selected) {
        if($selected == 1){
           $("#company_validator").show();
           $("#file_upload").hide();
           $("#product").hide();
           $("#buttonCompany").addClass("active");
           $("#buttonFile").removeClass("active");
           $("#buttonProduct").removeClass("active");
  
        }
        else if($selected == 2){
           $("#company_validator").hide();
           $("#file_upload").show();
           $("#product").hide();
           $("#buttonCompany").removeClass("active");
           $("#buttonFile").addClass("active");
           $("#buttonProduct").removeClass("active");
        }else{
           $("#company_validator").hide();
           $("#file_upload").hide();
           $("#product").show();
           $("#buttonCompany").removeClass("active");
           $("#buttonFile").removeClass("active");
           $("#buttonProduct").addClass("active");
        }
     }
   
   

</script>
@endsection