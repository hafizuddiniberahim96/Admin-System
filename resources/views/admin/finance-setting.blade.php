@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')


<div class="container-fluid ">
    <div class="row">
        
        <div class="col-lg mb-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Budget Expenses Type
                    <a  class="btn btn-labeled btn-success pull-right text-white" type="button"  data-placement="top" data-title="Budget Expenses Type" data-category="Budget Expenses Type"   data-toggle="modal" data-target="#confirm-add"  data-href="#">Add</a>  
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
        <div class="col-lg mb-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Payment Reason
                        <a  class="btn btn-labeled btn-success pull-right text-white" type="button"  data-placement="top" data-title="Payment Reason" data-category="Payment Reason"   data-toggle="modal" data-target="#confirm-add"  data-href="#">Add</a>  

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
        <form action="finance-settings" method="POST" class="modal_form"  id="modal_form">
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
             var table2 = $('#table-service').DataTable({
                pageLength: 5,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.finance.system.list',['Budget Expenses Type']) }}",
                columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                            {data: 'name', name: 'name', title: "Name"},
                            {data: 'created_at', name: 'created_at', title: "Created On"},
                            {data: 'action', name: 'action', title: "Action"}
                        ]
                });

                var table4 = $('#table-region').DataTable({
                pageLength: 5,
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.finance.system.list',['Payment Reason']) }}",
                columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                            {data: 'name', name: 'region', title: "Region Name"},
                            {data: 'created_at', name: 'created_at', title: "Created On"},
                            {data: 'action', name: 'action', title: "Action"}
                        ]
                });
        });        
    </script>

@endsection