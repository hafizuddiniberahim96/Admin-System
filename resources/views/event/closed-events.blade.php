@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">List Closed Event</h4>
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

    
    <script>
         
        $(function () {
            var table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event.list.closed') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'name', title: "Name"},
                    {data: 'anugerah', name: 'anuerage', title: "Anugerah"},
                    {data: 'category', name: 'category', title: "Program Category"},
                    {data: 'type', name: 'type', title: "Type"},
                    {data: 'location', name: 'location', title: "Location"},
                    {data: 'create_by', name: 'create_by', title: "Created By"},
                    {data: 'approve_by', name: 'approve_by', title: "Approved By"},
                    {data: 'start_date', name: 'start_date', title: "Event Start"},
                    {data: 'end_date', name: 'end_date', title: "Event End"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
        });        
    </script>

@endsection