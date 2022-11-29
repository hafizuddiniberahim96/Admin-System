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
                <div class="card-header pull-left" data-bs-toggle="collapse" data-bs-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">
                    <h4 class="card-title" > <i class="fa fa-angle-down"></i> 
                            List Pending Participants
                    </h4>
                </div>
                <div class="collapse multi-collapse show" id="multiCollapseExample2">
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
                <div class="card-header" data-bs-toggle="collapse" data-bs-target="#collapseApprove" aria-expanded="false" aria-controls="collapseApprove">
                    <h4 class="card-title" > <i class="fa fa-angle-down"></i> 
                        List Approve Participants
                    </h4>
                </div>
                <div id="collapseApprove" class="collapse multi-collapse" >
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
                <div class="card-header mb-0" data-bs-toggle="collapse" data-bs-target="#collapseReject" aria-expanded="false" aria-controls="collapseReject">
                    <h4 class="card-title" > <i class="fa fa-angle-down"></i> 
                        List Reject Participants
                    </h4>
                </div>
                <div id="collapseReject" class="collapse multi-collapse" role="tabpanel" aria-labelledby="headingReject">
                    <div class="card-body accordion-body">
                            <div class="row">
                                <div class="col s12" style="overflow: auto">
                                    <table id="table3" class="table table-striped table-bordered dataTable no-footer" style="width: 100%;"></table>
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
    <script type="text/javascript" src="{{asset('/js/admire/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/admire/popper.min.js')}}"></script>
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
                ajax: "{{ route('events.register.attendees.approval',['pending']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'event', name: 'event', title: "Event Name"},
                    {data: 'name', name: 'fullName', title: "Participant Name"},
                    {data: 'nric', name: 'nric', title: "Identity Number"},
                    {data: 'role', name: 'role', title: " Category"},
                    {data: 'email', name: 'email', title: "Email"},
                    {data: 'phone', name: 'phone', title: "Phone Number"},
                    {data: 'action', name: 'action', title: "Action"}
                ]
                    });
                
                var table = $('#table2').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('events.register.attendees.approval',['approve']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'event', name: 'event', title: "Event Name"},
                    {data: 'name', name: 'fullName', title: "Participant Name"},
                    {data: 'nric', name: 'nric', title: "Identity Number"},
                    {data: 'role', name: 'role', title: " Category"},
                    {data: 'email', name: 'email', title: "Email"},
                    {data: 'phone', name: 'phone', title: "Phone Number"},
                    ]
                    });

                var table = $('#table3').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('events.register.attendees.approval',['reject']) }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                    {data: 'event', name: 'event', title: "Event Name"},
                    {data: 'name', name: 'fullName', title: "Participant Name"},
                    {data: 'nric', name: 'nric', title: "Identity Number"},
                    {data: 'role', name: 'role', title: " Category"},
                    {data: 'email', name: 'email', title: "Email"},
                    {data: 'phone', name: 'phone', title: "Phone Number"},
                ]
                    });
        });    

       


    </script>

@endsection