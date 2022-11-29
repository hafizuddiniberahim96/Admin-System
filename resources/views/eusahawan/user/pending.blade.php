@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
        
            <div class="modal-body">
                <p class="debug-url"></p>
                <p>You are about to you are about to <a id='message'><a> user permanently, this procedure is irreversible.</p>
                <p>Do you want to proceed?</p>
                
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok" >Proceed</a>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid ">
    <div class="fade-in">
        <div class="card">
            <div class="card-body">
                <form id="form-filters" class="form form-horizontal form-bordered" >
                    <div class="form-body">
                        <div class="form-group row mx-auto">
                            <label class="col-sm-3 label-control" for="roles">User Category</label>
                            <div class="col-sm-9">
                                <div class="position-relative">
                                    <select name="roles" class="select2 form-control" multiple="multiple"
                                            id="roles">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}">{{ ucfirst($role->name)}}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 mb-1">
                                <button class="btn mt-1 btn-info float-right" id='filterbtn' 
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
    <script type="text/javascript" src="{{asset('/js/admire/user/list-pending.js')}}"></script>


    
    <script>
        $(".select2").select2({
            closeOnSelect: false
        });
         
        $(function () {
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('myeusahawan.user-pending') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'fullName', name: 'fullName', title: "Name"},
                    {data: 'nric', name: 'nric', title: "NRIC"},
                    {data: 'email', name: 'email', title: "Email"},
                    {data: 'roles', name: 'roles', title: "Category"},
                    {data: 'region', name: 'region', title: "Region"},
                    {data: 'state', name: 'state', title: "State"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
        });        
    </script>

@endsection