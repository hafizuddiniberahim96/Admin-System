
@extends('layouts.template.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>


@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="py-4">
        
            <div class="container">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{route('event.penaziran.mark.post')}}" method="POST" class="penaziran_event_validator"  id="penaziran_event_validator" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Main Content -->
                            <div class="col-12">
                                
                                <div class="border rounded bg-white col-md-auto">
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
                                                    <span class="text-danger">*</span>
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
                                                    <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="form-group">
                                                        <input class="form-control" id="nric"  value="{{substr($attandee->participant->nric,0,6)}}-{{substr($attandee->participant->nric,6,2)}}-{{substr($attandee->participant->nric,8,4) }}" readonly>
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
                                                    <span class="text-danger">*</span>
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
                                                    <label for="phone" class="form-label font-weight-bold">
                                                    Phone Number
                                                    <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="form-group">
                                                        <input class="form-control" id="phone"   value="{{$attandee->participant->details->phoneNumber}}" readonly>
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
                                                        <span class="text-danger">*</span>
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
                                                                            <input type="number" id="mark-{{$index}}" class="form-control penaziran" name="mark[]" value="{{$audit->get('mark')[$index]}}" placeholder="100" >                     
                                                                        @else
                                                                            <input type="number" id ="mark-{{$index}}" class="form-control penaziran" name="mark[]" value="" placeholder="100" >                     
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
                                    <input type="hidden" name="auditor_id" value="{{Auth::id()}}">
                                    <input type='hidden' id='status' name="status" value='complete'>
                                    <input type='hidden' name="type" value='private'>
                                    <input type='hidden' name="event_id" value='{{$attandee->event_id}}'>
                                     <input type="hidden" name="attendees_id" value="{{$attandee->_id}}">
                                      @if(count($audit)>0 )
                                            <input type="hidden" name="audit_id" value="{{$audit->get('_id')}}">
                                       @endif
                                <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                                    <div class="box-title border-bottom p-3">
                                    <h6 class="m-0">Penaziran Attachment</h6>
                                    </div>
                                    <div class="box-body p-3">
                                        <div class="row form-group">
                                            <div class="col-12 col-md-12">
                                                <div class="control-group">
                                                    <div class="row">
                                                        <label class="control-label col" > File
                                                        <span class="text-danger">*</span>
                                                        </label>
                                                        <label class="control-label col mr-5"> Description
                                                        <span class="text-danger">*</span>
                                                        </label>
                                                    </div>
                                                    <div class="controls">
                                                        <div class="entry input-group upload-input-group mt-1">
                                                   
                                                            <input class="form-control" name="penaziran_doc[]" type="file" accept="application/pdf" >

                                                            <input class="form-control ml-4 mr-2" name="penaziran_desc[]" type="text" placeholder="Description">
                                                       
                                                             <button class="btn btn-upload btn-success btn-add" type="button">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Uploaded Document</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                        <div class="col s12" style="overflow: auto">
                                            <table id="table" class="table table-striped table-bordered dataTable no-footer" style="width:100%;"></table>
                                        </div>
                                        </div>  
                                    </div>
                                </div>
                                <div class="mb-3 mt-3 ml-3">
                                    <button class="font-weight-bold btn btn-success rounded p-3 pull-right" id="send" form="penaziran_event_validator" type="submit" value="Submit">
                                        &nbsp;&nbsp;&nbsp;&nbsp;  Submit &nbsp;&nbsp;&nbsp;&nbsp;
                                    </button>
                                    <button class="font-weight-bold btn btn-info rounded p-3 pull-right mr-3" id='save' form="penaziran_event_validator"  type="submit" value="Submit">
                                        &nbsp;&nbsp;&nbsp;
                                        <i class="fa fa-save"></i>
                                        &nbsp;  
                                        Save &nbsp;&nbsp;&nbsp;&nbsp;
                                    </button>
                                </div>

                            </div>               
                    </div>
                </form>

               
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/wow/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/buipa/create-penaziran.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

<script>   

    $('#save').on("click",function() {
        //change event status to draft
        $('#status').val("draft");

        $('#penaziran_event_validator')
        .bootstrapValidator('enableFieldValidators',
        'mark[]', false, 'notEmpty');
        $('#penaziran_event_validator')
        .bootstrapValidator('enableFieldValidators',
        'penaziran_doc[]', false, 'notEmpty');
        $('#penaziran_event_validator')
        .bootstrapValidator('enableFieldValidators',
        'penaziran_desc[]', false, 'notEmpty');
    
    });

    $('#send').on("click",function() {
        var rows= $('#table tbody tr .dataTables_empty').length;
        if(rows == 0){
            $('#penaziran_event_validator')
            .bootstrapValidator('enableFieldValidators',
            'penaziran_doc[]', false, 'notEmpty');
            $('#penaziran_event_validator')
            .bootstrapValidator('enableFieldValidators',
            'penaziran_desc[]', false, 'notEmpty');
        }
    
    });

    $( document ).ready(function() {
       
                var table = $('.table').DataTable({
                        searching: false, 
                        paging: false, 
                        info: false,
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('list.document',['private','audit_mark',$audit->get('_id') ? $audit->get('_id') : 'none']) }}",
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                            {data: 'name', name: 'DocumentName', title: "File Name"},
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