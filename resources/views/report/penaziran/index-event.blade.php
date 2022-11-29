@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')


<div class="container-fluid ">
    <div class="fade-in">        
        <div id="accordion-2" role="tablist" aria-multiselectable="true" class="o-accordion">
            <div class="card multi">
                <div class="card-header pull-left" >
                    <h4 class="card-title" >
                            List Participants
                    </h4>
                </div>
                <div class="card-body accordion-body">
                    <div class="row">
                        <div class="col s12" style="overflow: auto">
                            <table id="table" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;"></table>
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
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/jquery-toast/jquery.toast.min.js')}}"></script>
    <script>
  
        $(function () {
                var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event.penaziran.attendees.list',[$id]) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'name', title: "Name"},
                    {data: 'nric', name: 'nric', title: "Identity Number"},
                    {data: 'role', name: 'role', title: "Category"},
                    {data: 'email', name: 'email', title: "Email"},
                    {data: 'phone', name: 'phone', title: "Phone Number"},
                    {data: 'last_updated', name: 'last_updated', title: "Last Updated On"},
                    {data: 'action', name: 'action', title: "Action"}

                ]
                    });
        });    

    </script>

@endsection