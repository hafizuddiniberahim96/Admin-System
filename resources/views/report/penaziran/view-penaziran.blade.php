
@extends('layouts.template.base')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="py-4">
            <div class="container">
                <div class="row">
                    <!-- Main Content -->
                        <div class="col-12">
                        <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                                <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Auditor Details</h6>
                                </div>
                                <div class="box-body p-3">                                        
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label font-weight-bold">
                                                Name
                                                </label>
                                                <div class="form-group">
                                                    <input class="form-control " id="name" value="{{$attandee->auditStatus->auditor->details->fullName}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label for="nric" class="form-label font-weight-bold">
                                                Identity Number
                                                </label>
                                                <div class="form-group">
                                                    <input class="form-control" id="nric"  value="{{substr($attandee->auditStatus->auditor->nric,0,6)}}-{{substr($attandee->auditStatus->auditor->nric,6,2)}}-{{substr($attandee->auditStatus->auditor->nric,8,4) }}" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div>
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label font-weight-bold">
                                                Email
                                                </label>
                                                <div class="form-group">
                                                    <input class="form-control " id="email"  value="{{$attandee->auditStatus->auditor->email}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label for="category" class="form-label font-weight-bold">
                                                Category
                                                </label>
                                                <div class="form-group">
                                                    <input class="form-control" id="category" value="{{$attandee->auditStatus->auditor->role->name}}" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div> 
                                </div>
                            </div>
                            
                            <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                                <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Participant Details</h6>
                                </div>
                                <div class="box-body p-3">                                        
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label font-weight-bold">
                                                Name
                                                </label>
                                                <div class="form-group">
                                                    <input class="form-control " id="name" value="{{$attandee->participant->details->fullName}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label for="nric" class="form-label font-weight-bold">
                                                Identity Number
                                                </label>
                                                <div class="form-group">
                                                    <input class="form-control" id="nric"  value="{{substr($attandee->participant->nric,0,6)}}-{{substr($attandee->participant->nric,6,2)}}-{{substr($attandee->participant->nric,8,4) }}" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div>
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label for="email" class="form-label font-weight-bold">
                                                Email
                                                </label>
                                                <div class="form-group">
                                                    <input class="form-control " id="email"  value="{{$attandee->participant->email}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                        <!-- Input -->
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label for="category" class="form-label font-weight-bold">
                                                Category
                                                </label>
                                                <div class="form-group">
                                                    <input class="form-control" id="category"   value="{{$attandee->participant->role->name}}" required readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div> 
                                </div>
                            </div>
                            <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                                <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Marking Details</h6>
                                </div>
                                <div class="box-body p-3">
                                    <div id="penaziran_form">
                                    <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">
                                                    Penaziran List
                                                    </label>
                                                    <div class="row penaziran-controls">
                                                        <div class="input-group col-sm-12">
                                                        @if($attandee->event->audit_item)
                                                            @foreach( $attandee->event->audit_item as $index => $penaziran )
                                                                <div class="col-sm-6 mt-2">
                                                                    <input type='hidden' value="{{$penaziran->_id}}" name="audit_item_id[]">
                                                                    
                                                                    <input type="text" class="form-control penaziran" value="{{$penaziran->name}}" readonly>                     
                                                                </div>
                                                                <div class="col-sm-6 mt-2">
                                                                    @if(!empty($audit->get('mark')))
                                                                        <input type="number" id="mark-{{$index}}" class="form-control penaziran" name="mark[]" value="{{$audit->get('mark')[$index]}}" placeholder="100" disabled>                     
                                                                    @else
                                                                    <input type="number" id ="mark-{{$index}}" class="form-control penaziran" name="mark[]" value="" placeholder="100" disabled>                     
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                                <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Penaziran Uploaded Attachment</h6>
                                </div>
                                <div class="box-body p-3">
                                    <div class="col s12" style="overflow: auto">
                                        <table id="table" class="table table-striped table-bordered dataTable no-footer" style="width:100%;"></table>
                                    </div>
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
<script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script>
   $(".select2").select2({
        closeOnSelect: false
    });
    
    $( document ).ready(function() {
       
                var table = $('.table').DataTable({
                        searching: false, 
                        paging: false, 
                        info: false,
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('list.document.download',['private','audit_mark',$audit->get('_id') ? $audit->get('_id') : 'none']) }}",
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                            {data: 'name', name: 'DocumentName', title: "File Name"},
                            {data: 'desc', name: 'desc', title: "Description"},
                            {data: 'created_at.display', name: 'created_at', title: "Created On"},
                            {data: 'action', name: 'action', title: "Action"}
                        ]
                }); 
    });
</script>
@endsection