@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        @can('isAdmin')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <div class="card">
                <div class="card-header">
                    <div class="float-left"><strong>Upload in Multi Selection</strong> </div>
                </div>
                <div class="card-body card-block">
                    <form action="general-uploads" method="post" enctype="multipart/form-data" class="form-horizontal">   
                        @csrf
                    <div class="row form-group">
                        <div class="col-12 col-md-12">
                            <div class="control-group" id="fields">
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
                                        <input type='hidden' name="type" value='general'>
                                        <input class="form-control" name="fields[]" type="file" accept="application/pdf" required>
                                        <input class="form-control ml-4 mr-2"   name="fields_desc[]" type="text" placeholder="Description" >
                                        <button class="btn btn-upload btn-success btn-add" type="button">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button class="btn btn-info pull-right mt-4">Upload</button>
                            </div>

                        </div>
                    </div>
                        
                    
                    </form>
                </div>
            </div>
        @endcan
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
                ajax: "{{ route('list.document',['general','none','none']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'DocumentName', title: "File Name"},
                    {data: 'desc', name: 'desc', title: "Description"},

                    {data: 'created_at.display', name: 'created_at', title: "Created On"},

                    {data: 'action', name: 'action', title: "Action"}
                ]
            });
          

            $(document).on('click', '.btn-add', function (e) {
                e.preventDefault();
                var controlForm = $('.controls:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);
                    newEntry.find('input[type=file]').val('');

                controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
        });        
    </script>

@endsection