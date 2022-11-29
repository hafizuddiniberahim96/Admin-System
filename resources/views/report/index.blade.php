@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')


<div class="container-fluid ">
    <div class="fade-in">
        <div class="py-4">
            <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                <div class="box-title border-bottom p-3">
                <h6 class="m-0">Report Attachment</h6>
                </div>
                <div class="box-body p-3">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <form action="/reports" method="post" enctype="multipart/form-data" class="form-horizontal">   
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
                                        <div class="entry input-group upload-input-group mt-1">
                                            <input class="form-control"   name="report_doc[]" type="file" accept="application/pdf" required>
                                            <input class="form-control ml-4 mr-2"   name="report_desc[]" type="text" placeholder="Description" >
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
            <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                <div class="box-title border-bottom p-3">
                <h6 class="m-0">Upload Report</h6>
                </div>
                <div class="box-body p-3">
                    <div class="row">
                        <div class="col s12" style="overflow: auto">
                            <table id="table" class="table table-striped table-bordered dataTable no-footer" style="width:100%;"></table>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    <script type="text/javascript" src="{{asset('js/admire/components.js')}}"></script> 
    <script type="text/javascript" src="{{asset('/js/admire/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/admire/popper.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/jquery-toast/jquery.toast.min.js')}}"></script>  
    <script>


  
        $(function () {
       
            
                var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('list.document',['private','report_user', Auth::id()]) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'DocumentName', title: "Name"},
                    {data: 'desc', name: 'desc', title: "Description"},
                    {data: 'created_at.display', name: 'created_at', title: "Created On"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
        });   
        
        $(document).on('click', '.btn-add', function (e) {
            e.preventDefault();
            var controlForm = $('.controls:first'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);
                newEntry.find('input[type=file]').val('');
                newEntry.find('input[type=text]').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="fa fa-trash"></span>');
        }).on('click', '.btn-remove', function (e) {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });
    </script>

@endsection