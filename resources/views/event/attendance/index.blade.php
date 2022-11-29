@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <a  class="btn btn-labeled  btn-info  text-white mb-4" type="button" href="/events/create-attendance/{{$event->_id}}">
            <i class="fa fa-qrcode"></i>    
            Generate QR Code
        </a>  
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Event List Attendance</h4>
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
                ajax: "{{ route('events.list.attendance.link',[$event->_id]) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'link', name: 'link', title: "Link"},
                    {data: 'status', name: 'status', title: "Status"},
                    {data: 'created_at', name: 'created_at', title: "Create On"},
                    {data: 'qrcode', name: 'qrcode', title: "QR Code"},
                    {data: 'action', name: 'action', title: "Attendance List"}
                ]
                    });
        });        
    </script>

@endsection