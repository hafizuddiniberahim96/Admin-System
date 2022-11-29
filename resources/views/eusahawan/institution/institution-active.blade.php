@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="card">
            <div class="card-body">
                <form id="form-filters" class="form form-horizontal form-bordered">
                    <div class="form-body">
                        <div class="form-group row mx-auto">
                            <label class="col-sm-3 label-control" for="roles">School / Institution</label>
                            <div class="col-sm-9">
                                <div class="position-relative">
                                    <input type="text" class = "form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-1">
                                <button class="btn mt-1 btn-info float-right" onclick="saveFilter()"
                                        type="button"><i class="la la-filter"></i> Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List</h4>
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col s12" style="overflow: auto">
                    <table id="table" class="table table-striped table-bordered dataTable no-footer"></table>
                </div>
                </div>  
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script type="text/javascript" src="{{asset('js/admire/components.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/extensions/dropzone.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/jquery-toast/jquery.toast.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>

    
    <script>
        $(".select2").select2({
            closeOnSelect: false
        });
         
        $(function () {
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('myeusahawan.institution.active.list') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'name', title: "Name"},
                    {data: 'type', name: 'type', title: "Type"},
                    {data: 'postcode', name: 'postcode', title: "Postcode"},
                    {data: 'region', name: 'region', title: "Region"},
                    {data: 'state', name: 'state', title: "State"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
        });        
    </script>

@endsection