
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
       
                <div class="row">
                    <div class="col-12">
                        
                        <div class="border rounded bg-white col-md-auto">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Participant Details</h6>
                            </div>
                            <div class="box-body p-3 ">                                        
                                <div class="column">
                                    <!-- Input -->
                                    <div class="col-md-6 m-0 p-0 mb-sm-6 ">
                                            <label for="name" class="form-label font-weight-bold">
                                            Name :
                                            </label>
                                            <label class="form-label ml-5 pl-5">
                                            {{ucwords($attandees[0]->auditee->participant->details->fullName)}}
                                            </label>   
                                            <br>                                                
                                            <label for="nric" class="form-label font-weight-bold">
                                            Identity Number :
                                            </label>
                                            <label class="form-label ml-3 pl-2">
                                                    {{substr($attandees[0]->auditee->participant->nric,0,6)}}-{{substr($attandees[0]->auditee->participant->nric,6,2)}}-{{substr($attandees[0]->auditee->participant->nric,8,4) }}
                                            </label>
                                    </div>
                                </div>
                            </div>
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Marking Details</h6>
                            </div>
                            @foreach($attandees as $no => $attandee)
                                <div class="box-body p-3">                                        
                                    <div class="column">
                                        <!-- Input -->
                                        <div class="col-md-6 mb-0 mb-sm-6">
                                            <div class="form-group">
                                                <label for="name" class="form-label font-weight-bold">
                                                Penaziran Name :
                                                </label>
                                                <label class="form-label ml-4 p-0">
                                                    {{ucwords($attandee->auditor->details->fullName)}} 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-0 mb-sm-6">
                                            <div class="form-group">
                                                <label for="nric" class="form-label font-weight-bold">
                                                Category :
                                                </label>
                                                <label class="form-label ml-2 ">
                                                    {{ucwords($attandee->auditor->role->name)}}
                                                </label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                                <label class="form-label ml-3 font-weight-bold">
                                                        Penaziran List
                                                </label>
                                                <div class="row penaziran-controls">
                                                    <div class="input-group col-sm-12">
                                                        @foreach(  $attandee->event->audit_item as $index => $penaziran )
                                                        <div class="col-sm-6 mt-2">
                                                            <input type="text" class="form-control text-body" value="{{$penaziran->name}}" readonly>  
                                                        </div>
                                                        <div class="col-sm-6 mt-2">
                                                            <input type="number" class="form-control text-body"  value="{{ $attandee->mark[$index]}}"  readonly>             
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-0 mb-sm-6">
                                            <label class="form-label ml-3 font-weight-bold">
                                                    Penaziran Attachment
                                            </label>
                                            <div class="col s12" style="overflow: auto">
                                                    <table id="table-{{$no}}" class="table table-striped table-bordered dataTable no-footer" style="width:100%;"></table>
                                            </div>
                                        </div>
                                    
                                    </div>
                                </div>
                                <div class="col-12 p-3" style="border-bottom: 3px solid;color: grey;"></div>
                            @endforeach

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
<script type="text/javascript" src="{{asset('/vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/vendor/admire/wow/js/wow.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admire/event.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
<script>
   $(".select2").select2({
        closeOnSelect: false
    });
    

    $('#save').on("click",function() {
        //change event status to draft
        $('#status').val("draft");
        $('input').prop('required', false);
        $('#mark-0').prop('required', true);
    
    });
    $( document ).ready(function() {
        <?php
            for ($i = 0; $i < $attandees->count(); $i++){
        ?>
            $('#table-'+ <?php echo $i ?>).DataTable({
                                searching: false, 
                                paging: false, 
                                info: false,
                                processing: true,
                                serverSide: true,
                                ajax: "{{ route('list.document.download',['private','audit_mark', $attandees[$i]->_id]) }}",
                                columns: [
                                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
                                    {data: 'name', name: 'name', title: "File Name"},
                                    {data: 'action', name: 'action', title: "Action"}
                                ]
             });
        <?php
        }
        ?>
        
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