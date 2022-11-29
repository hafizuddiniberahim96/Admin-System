@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')


<div class="container-fluid ">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Program Category
                    <a  class="btn btn-labeled btn-success pull-right text-white" type="button"  data-placement="top" data-title="Program Category" data-category="Program Name"   data-toggle="modal" data-target="#confirm-add"  data-href="#">Add</a>  

                    </h4>
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
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Service Sector
                    <a  class="btn btn-labeled btn-success pull-right text-white" type="button"  data-placement="top" data-title="Service Sector" data-category="Sector Name"   data-toggle="modal" data-target="#confirm-add"  data-href="#">Add</a>  
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col s12" style="overflow: auto">
                            <table id="table-service" class="table table-striped table-bordered dataTable no-footer"></table>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">State
                        <a  class="btn btn-labeled btn-success pull-right text-white" type="button"  data-placement="top" data-title="State" data-category="State Name"   data-toggle="modal" data-target="#confirm-add"  data-href="#">Add</a>  

                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12" style="overflow: auto">
                                <table id="table-state" class="table table-striped table-bordered dataTable no-footer"></table>
                            </div>
                        </div>  
                    </div>
                </div>
        </div>
        <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Region
                        <a  class="btn btn-labeled btn-success pull-right text-white" type="button"  data-placement="top" data-title="Region" data-category="Region Name"   data-toggle="modal" data-target="#confirm-add-state"  data-href="#">Add</a>  

                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col s12" style="overflow: auto">
                                <table id="table-region" class="table table-striped table-bordered dataTable no-footer"></table>
                            </div>
                        </div>  
                    </div>
                </div>
        </div>
    </div>
    <div class="modal fade" id="confirm-add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">   
        <form action="system-settings" method="POST" class="modal_form"  id="modal_form">
            @csrf
            <div class="modal-content">
            
                <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
            
                <div class="modal-body">
                    <div class="form-group">
                        <label class="debug-url" data-error="wrong" data-success="right" for="defaultForm-email"></label>
                        <input type="text" name="name" class="form-control validate" required>
                        <input type="text" name="tableName" id='InputCategory' class="form-control validate" hidden>
                    </div>                   
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="modal_form" class="btn btn-success btn-ok text-white">Confirm</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    <div class="modal fade" id="confirm-add-state" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">   
        <form action="system-settings" method="POST" class="modal_form2"  id="modal_form2">
            @csrf
            <div class="modal-content">
            
                <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Region</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
            
                <div class="modal-body">
                <div class="form-group">
                        <label  data-success="right" for="defaultForm-email">State</label>
                        <select class="form-control custom-select" id="state" name="state_id" required>
                         <option value=""></option>
                         @foreach ($states as $state)
                             <option value="{{ $state->_id }}">{{ ucfirst($state->name)}}</option>
                          @endforeach                       
                        </select>
                    </div>    
                    <div class="form-group">
                        <label  data-success="right" for="defaultForm-email">Region</label>
                        <input type="text" name="name" class="form-control validate" required>
                        <input type="text" name="tableName" id='InputCategory'  value='Region' class="form-control validate" hidden>
                    </div>                   
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" form="modal_form2" class="btn btn-success btn-ok text-white">Confirm</button>
                </div>
            </div>
        </form>
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

        $(document).ready(function() {
            $('#confirm-add').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('value', $(e.relatedTarget).data('category'));
               var category= $(this).find('.btn-ok').attr('value');
               var tableName =$(e.relatedTarget).data('title');
               $("#myModalLabel").html(tableName);
               $('#InputCategory').val(tableName);
             $('.debug-url').html(category);
    });
        });
         
        $(function () {
            var table = $('#table').DataTable({
                pageLength: 3,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.settings.system.list',['Program Category']) }}",
                columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                            {data: 'name', name: 'name', title: "Name"},
                            {data: 'created_at', name: 'created_at', title: "Created On"},
                            {data: 'action', name: 'action', title: "Action"}
                        ]
                });

             var table2 = $('#table-service').DataTable({
                pageLength: 3,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.settings.system.list',['Service Sector']) }}",
                columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                            {data: 'name', name: 'name', title: "Name"},
                            {data: 'created_at', name: 'created_at', title: "Created On"},
                            {data: 'action', name: 'action', title: "Action"}
                        ]
                });

                var table3 = $('#table-state').DataTable({
                pageLength: 3,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.settings.system.list',['state']) }}",
                columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                            {data: 'name', name: 'name', title: "Name"},
                            {data: 'created_at', name: 'created_at', title: "Created On"},
                            {data: 'action', name: 'action', title: "Action"}
                        ]
                });

                var table4 = $('#table-region').DataTable({
                pageLength: 3,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.settings.system.list',['region']) }}",
                columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                            {data: 'state', name: 'state', title: "State Name"},
                            {data: 'name', name: 'name', title: "Region Name"},
                            {data: 'action', name: 'action', title: "Action"}
                        ]
                });
        });        
    </script>

@endsection