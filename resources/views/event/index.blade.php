@extends('layouts.template.base')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">

@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <a  class="btn btn-labeled  btn-info  text-white mb-4" type="button" href="/create-events">
            <i class="fa fa-plus"></i>    
            New Event
        </a>  
        <div id="accordion-2" role="tablist" aria-multiselectable="true" class="o-accordion">
            <div class="card multi">
                <div class="card-header pull-left" data-bs-toggle="collapse" data-bs-target="#draftEvents" aria-expanded="false" aria-controls="draftEvents">
                    <h4 class="card-title" > <i class="fa fa-angle-down"></i> 
                            List Draft Events
                    </h4>
                </div>
                <div class="collapse multi-collapse show" id="draftEvents">
                <div class="card-body accordion-body">
                        <div class="row">
                            <div class="col s12" style="overflow: auto">
                                <table id="table" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;"></table>
                            </div>
                        </div>  
                     </div>
                </div>
            </div>

            <div class="card multi">
                <div class="card-header" data-bs-toggle="collapse" data-bs-target="#pendingEvents" aria-expanded="false" aria-controls="pendingEvents">
                    <h4 class="card-title" > <i class="fa fa-angle-down"></i> 
                        List Pending Events
                    </h4>
                </div>
                <div id="pendingEvents" class="collapse multi-collapse" >
                <div class="card-body accordion-body">
                        <div class="row">
                            <div class="col s12" style="overflow: auto">
                                <table id="table2" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;"></table>
                            </div>
                        </div>  
                     </div>
                </div>
            </div>

            <div class="card multi">
                <div class="card-header mb-0" data-bs-toggle="collapse" data-bs-target="#approveEvents" aria-expanded="false" aria-controls="approveEvents">
                    <h4 class="card-title" > <i class="fa fa-angle-down"></i> 
                        List Approve Events
                    </h4>
                </div>
                <div id="approveEvents" class="collapse multi-collapse">
                    <div class="card-body accordion-body">
                            <div class="row">
                                <div class="col s12" style="overflow: auto">
                                    <table id="table3" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;"></table>
                                </div>
                            </div>  
                        </div>
                    </div>
                  
            </div>
            <div class="card multi">
                <div class="card-header mb-0" data-bs-toggle="collapse" data-bs-target="#rejectEvents" aria-expanded="false" aria-controls="rejectEvents">
                    <h4 class="card-title" > <i class="fa fa-angle-down"></i> 
                        List Reject/Cancel Events
                    </h4>
                </div>
                <div id="rejectEvents" class="collapse multi-collapse">
                    <div class="card-body accordion-body">
                            <div class="row">
                                <div class="col s12" style="overflow: auto">
                                    <table id="table4" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;"></table>
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
    <script type="text/javascript" src="{{asset('js/admire/components.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('/app-assets/vendors/js/jquery-toast/jquery.toast.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

    
    <script>

        $(document).ready(function(){
            // Add minus icon for collapse element which is open by default
            $(".collapse.show").each(function(){
                $(this).prev(".card-header").find(".fa").addClass("fa-angle-up").removeClass("fa-angle-down");
            });
            
            // Toggle plus minus icon on show hide of collapse element
            $(".collapse").on('show.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-angle-down").addClass("fa-angle-up");
            }).on('hide.bs.collapse', function(){
                $(this).prev(".card-header").find(".fa").removeClass("fa-angle-up").addClass("fa-angle-down");
            });
        });
         
        $(function () {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event.list.draft') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'fullName', title: "Name"},
                    {data: 'type', name: 'company', title: "Type"},
                    {data: 'category', name: 'sector', title: "Program Category"},
                    {data: 'create_by', name: 'year', title: "Created By"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
            
                var table = $('#table2').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event.list.pending') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'fullName', title: "Name"},
                    {data: 'anugerah', name: 'anugerah', title: "Anugerah"},
                    {data: 'category', name: 'sector', title: "Program Category"},
                    {data: 'type', name: 'type', title: "Type"},
                    {data: 'location', name: 'location', title: "Location"},
                    {data: 'start_date', name: 'start_date', title: "Event Start"},
                    {data: 'end_date', name: 'end_date', title: "Event End"},
                    {data: 'fee', name: 'fee', title: "Fee"},
                    {data: 'create_by', name: 'create_by', title: "Created By"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
                
                var table = $('#table3').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event.list.approve') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'fullName', title: "Name"},
                    {data: 'category', name: 'sector', title: "Program Category"},
                    {data: 'type', name: 'company', title: "Type"},
                    {data: 'location', name: 'location', title: "Location"},
                    {data: 'create_by', name: 'year', title: "Created By"},
                    {data: 'approve_by', name: 'year', title: "Approved By"},
                    {data: 'start_date', name: 'start_date', title: "Event Start"},
                    {data: 'end_date', name: 'end_date', title: "Event End"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });

                    var table = $('#table4').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('event.list.reject') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'name', name: 'fullName', title: "Name"},
                    {data: 'type', name: 'type', title: "Type"},
                    {data: 'fee', name: 'fee', title: "Fee"},
                    {data: 'category', name: 'sector', title: "Program Category"},
                    {data: 'location', name: 'location', title: "Location"},
                    {data: 'status', name: 'fee', title: "Status"},
                    {data: 'create_by', name: 'year', title: "Created By"},
                    {data: 'reject_by', name: 'reject_by', title: "Rejected/Cancel By"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
        });      

    </script>

@endsection