
@extends('layouts.template.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/pickers/daterange/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">



@endsection
@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="py-4">
        
            <div class="container">
                <div class="rounded btn-group btn-group-toggle bg-white" data-toggle="buttons">
                    <button class="btn btn-ghost-primary" id="buttonEvent" onclick="showData(1)" style>
                    Event
                    </button>
                    <button class="btn btn-ghost-primary" id="buttonPenaziran" onclick="showData(2)">
                    Penaziran
                    </button>
                    <button class="btn btn-ghost-primary" id="buttonBudget" onclick="showData(3)">
                    Budget Expenses
                    </button>
                    <button class="btn btn-ghost-primary" id="buttonAttendance" onclick="showData(4)">
                    Attendance Summary
                    </button>
                </div>

                <div class="row" id="event">
                    <div class="col-12">
                        <div class="border rounded bg-white col-md-auto">
                            <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Event Details</h6>
                            </div>
                            <div class="box-body p-3">                                        
                                <div class="row">
                                    <!-- Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                        <div class="form-group">
                                            <label for="title" class="form-label font-weight-bold">
                                            Title
                                            <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input class="form-control " id="name" name="name" placeholder="Eg. Seminar" value="{{$event->get('name')}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                    <!-- Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                        <div class="form-group">
                                            <label for="seat" class="form-label font-weight-bold">
                                            Participants Seat 
                                            <span class="text-danger">*</span>
                                            </label>
                                            <input type="checkbox" id="unlimited" name="seats" value="-1"  {{($event->get('seats') == -1) ? 'checked' : 'unchecked' }} disabled> Unlimited
                                            <div class="form-group">
                                                <input class="form-control" id="seat" name="seats"   placeholder="100"  value="{{($event->get('seats') == -1) ? 'Unlimited' : $event->get('seats') }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                </div>
                                <div class="row">
                                    <!-- Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                        <div class="form-group">
                                            <label id="lblsector" class="form-label font-weight-bold">
                                            Program Category
                                            <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <select class="select2 form-control" id="sector" name="system_settings_id" disabled>
                                                    <option value=""></option>
                                                    @foreach ($programs as $program)
                                                        <option value="{{ $program->_id }}"  {{($program->_id == $event->get('system_settings_id') ? 'selected' :'' )}} >{{ ucfirst($program->name)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                        <label id="established" class="form-label font-weight-bold">
                                        Participants
                                        <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-group">
                                            <select name="participants[]" class="select2 form-control" multiple="multiple" id="participants" disabled>
                                                <option value=""></option>
                                            @if(!empty($event->get('participants')))
                                                @foreach ($participants as $index => $participant)
                                                @if(in_array($participant->_id, $event->get('participants')->toArray()))
                                                                
                                                                <option value="{{ $participant->_id }}"  selected>
                                                                {{ ucfirst($participant->name)}}</option>
                                                                @else
                                                                <option value="{{ $participant->_id }}" >
                                                                {{ ucfirst($participant->name)}}</option>
                                                @endif
                                                @endforeach
                                            @else
                                                @foreach ($participants as $index => $participant)
                                                    <option value="{{ $participant->_id }}" >
                                                        {{ ucfirst($participant->name)}}</option>
                                                @endforeach
                                            @endif
                                            </select>
                                        </div>
                                        </div>
                        
                                    </div>
                                    <!-- End Input -->
                                </div>
                                <div class="row">
                                    <!-- Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                            <label for="start_date" class="form-label font-weight-bold">
                                                Start Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input class="form-control date_start" name="date_start" value="{{$event->get('date_start')}}" type="text" id="date_start" disabled>
                                            </div>
                                            </div>
                                    </div>
                                    <!-- End Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                            <div class="form-group">
                                            <label for="end_date" class="form-label font-weight-bold">
                                                End Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input class="form-control date_end" name="date_end" type="text" value="{{$event->get('date_end')}}" id="date_end" disabled>
                                            </div>
                                            </div>
                                    </div>
                                    <!-- End Input -->
                                </div>    
                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label for="register_before" class="form-label font-weight-bold">
                                                Registration Before
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input class="form-control register_before" name="register_before" type="text" value="{{$event->get('register_before')}}" id="register_before" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                    
                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label for="fee" class="form-label font-weight-bold">
                                                Registration Fee
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RM </span>
                                                </div>
                                                <input class="form-control" id="fee" name="fee" type="number" step="0.01" value="{{$event->get('fee')}}" placeholder="100" readonly>
                                            </div>
                                        </div>                               
                                    </div>
                                    <!-- End Input -->
                                </div> 
                                <div class="row">
                                    <!-- Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                        <div class="form-group">
                                            <label for="event_mode" class="form-label font-weight-bold">
                                            Event Mode
                                            <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="event_mode" id="event_mode1" value="physical" {{("physical" == $event->get('event_mode') ? 'checked' :'' )}} disabled>
                                                    <label class="form-check-label" for="physical">Physical</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="event_mode" id="event_mode2" value="online" {{("online" == $event->get('event_mode') ? 'checked' :'' )}} disabled>
                                                    <label class="form-check-label" for="online">Online </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                    <div class="col-sm-6 mb-2">
                                        <div class="form-group">
                                            <label for="location" class="form-label font-weight-bold">
                                                Location/URL
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input class="form-control" id="location" name="location" value="{{$event->get('location')}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                </div>
                                <div class="row">
                                    <!-- Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                        <div class="form-group">
                                            <label id="email" class="form-label font-weight-bold">
                                            Banner
                                            <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <div class="p-3 d-flex align-items-center">
                                                    @if($event->get('bannerImg'))
                                                    <img src="{{asset('storage/'. $event->get('bannerImg'))}}" id='bannerimg' class="img" width="400" height="320">
                                                    @else
                                                    <img src="{{asset('img/banner.jpg')}}" id='bannerimg' class="img-fluid" width="400" height="320">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                    <div class="col-md-6 mb-3 mb-sm-6">
                                        <div class="form-group">
                                            <label id="email" class="form-label font-weight-bold">
                                                Logo/Icon
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <div class="p-3 d-flex align-items-center">
                                                    @if($event->get('logo'))
                                                    <img src="{{asset('storage/'. $event->get('logo'))}}" id='logoimg' class="img" width="50" height="50">
                                                    @else
                                                    <img src="{{asset('img/logo.png')}}" id='logoimg' class="img-fluid" width="50" height="50">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Input -->
                                </div>
                            </div>
                        </div>
                    </div>               
                </div>

                <div class="row" id="penaziran">
                    <div class="col-12 ">
                        <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                            <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Anugerah Details</h6>
                            </div>
                            <div class="box-body p-3">                                        
                                    <div class="row">
                                        <!-- Input -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="checkbox-inline font-weight-bold">
                                                Anugerah Event?
                                                    <input type="checkbox" id="eventcheckbox" name='isAward' value="1"  {{( $event->get('isAward') == 0 ? '' :'checked' )}} disabled>
                                                </label>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div>
                                    @if($event->get('isAward'))
                                    <div id="penaziran_form">
                                     <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">
                                                    Penaziran List
                                                    <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="penaziran-controls">
                                                        @if($event->get('penaziran'))
                                                            @foreach( $event->get('penaziran') as $penaziran)
                                                                <div class="penaziran-entry input-group upload-input-group">
                                                                    <input type="text" class="form-control penaziran" name="penazirans[]" value= "{{$penaziran}}" placeholder="Eg. Creativity, Presentation Performance" readonly>                     
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-label font-weight-bold">
                                                    Penazir
                                                    <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="form-group">
                                                        <select name="penazir[]" class="select2 form-control" multiple="multiple" id="penazir" disabled>
                                                            <option value=""></option>
                                                            @if(!empty($event->get('penazirs')))
                                                                @foreach ($penazirs as $penazir)
                                                                    @if(in_array($penazir->_id, $event->get('penazirs')->toArray()))
                                                                  
                                                                    <option value="{{ $penazir->_id }}"  selected>
                                                                        {{ ucfirst($penazir->details->fullName)}}</option>
                                                                    @else
                                                                    <option value="{{ $penazir->_id }}" >
                                                                        {{ ucfirst($penazir->details->fullName)}}</option>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                @foreach ($penazirs as $penazir)
                                                                    <option value="{{ $penazir->_id }}" >{{ ucfirst($penazir->details->fullName)}}</option>
                                                                @endforeach
                                                             @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                        </div>
                    </div> 
                    <div class="col-12 mt-3">
                        <div class="border rounded bg-white col-md-auto">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">List Penazir Information</h6>
                            </div>
                           
                            <div class="card-body ">                     
                                <div class="row mt-2">
                                    <div class="col s12" style="overflow: auto">
                                        <table id="table1" class="table table-striped table-bordered dataTable no-footer" style="width: 100% !important;"></table>
                                    </div>
                                </div>  
                            </div>
                        </div>

                        <div class="border rounded bg-white col-md-auto mt-4">
                            <div class="box-title border-bottom p-3">
                                <h6 class="m-0">List Penaziran Report Information</h6>
                            </div>
                           
                            <div class="card-body ">                     
                                <div class="row mt-2">
                                    <div class="col s12" style="overflow: auto">
                                        <table id="table2" class="table table-striped table-bordered dataTable no-footer" style="width: 100% !important;"></table>
                                    </div>
                                </div>  
                            </div>
                        </div>  

                        
                    </div> 
                                
                </div>

                    <div class="row" id="budget">
                        <div class="col-12 ">
                            <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                                <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Budget Report</h6>
                                </div>
                                <div class="box-body p-3">
                                <p class="mb-1">
                                    
                                    <br>
                                        <div class="row">
                                            <label class="control-label col font-weight-bold" for="field1"> Expenses Type :
                                            </label>
                                            <label class="control-label col font-weight-bold" for="field1"> Payment Reason :
                                            </label>
                                            <label class="control-label col font-weight-bold" for="field1"> Budget Amount :
                                            </label>
                                        </div>                                        
                                        <div class="row expenses-controls">
                                            <!-- Input -->
                                            @if($event->get('expenses'))
                                                @foreach( $event->get('expenses') as $index => $expensess)
                                                    <div class="input-group mt-5 col-sm-12 expenses-entry">
                                                        <select name="expenses-type[]" class="form-control input-group-prepend col-sm-4 expenses" disabled>
                                                            <option disabled selected hidden>Expenses Type</option>
                                                        @foreach ($expenses as $expense)
                                                            <option value="{{ $expense->_id }}"  {{($expense->_id == $expensess['type'] ? 'selected' :'' )}} >{{ ucfirst($expense->name)}}</option>
                                                        @endforeach
                                                        </select>

                                                        <select name="reasons-type[]" class="form-control input-group-prepend col-sm-4 expenses" disabled> 
                                                                <option disabled selected hidden>Payment Reason</option>
                                                        @foreach ($reasons as $reason)
                                                            <option value="{{ $reason->_id }}" {{($reason->_id == $expensess['reason'] ? 'selected' :'' )}}>{{ ucfirst($reason->name)}}</option>
                                                        @endforeach
                                                        </select>
                                                        <div class="input-group-prepend expenses">
                                                            <span class="input-group-text">RM </span>
                                                        </div>
                                                        <input class="form-control expenses" name="expenses-fee[]" id="fee-{{$index}}" type="number" step="0.01"  value="{{$expensess['value']}}" disabled>
                                                    </div>
                                                    <div class="input-group col-sm-12">
                                                            <div class="col"></div>
                                                            <div class="col">
                                                                <label class="form-label font-weight-bold pull-right mt-2"> Used Amount
                                                                <span class="text-danger">*</span> :
                                                                </label> 
                                                            </div>                                                   
                                                            <div class="input-group-prepend mt-2">
                                                                <span class="input-group-text">RM </span>
                                                            </div>
                                                            <input class="form-control mt-2 text-body" name="expenses_used[]"  id="exUsed_{{$index}}" type="number" step="0.01" value="{{$budget['expenses_used'][$index]}}"  readonly> 
                                                    </div>
                                                    <div class="input-group col-sm-12">
                                                            <div class="col"></div>
                                                            <div class="col">
                                                                <label class="form-label font-weight-bold pull-right mt-2"> Over Budget Amount :
                                                                </label> 
                                                            </div>                                                   
                                                            <div class="input-group-prepend mt-2">
                                                                <span class="input-group-text">RM </span>
                                                            </div>
                                                            <input class="form-control mt-2 text-body" name="overBudget[]" id="over_{{$index}}" type="number" step="0.01"  value="{{$budget['overBudget'][$index]}}"  readonly> 
                                                    </div>
                                                    <input type="hidden" name="expenses_id[]" value="{{$expensess['type']}}" />

                                                @endforeach
                                            @endif
                                        </div> 
                                        @if($event->get('expenses'))
                                        <div class="row">
                                            <div class="input-group col-sm-12">
                                                <div class="col"></div>
                                                <div class="col"></div>                                                   
                                                <div class="col-6 p-3" style="border-bottom: 3px solid;color: grey;"></div>
                                            </div>
                                            <div class="input-group col-sm-12">
                                                <div class="col"></div>
                                                <div class="col">
                                                    <label class="form-label font-weight-bold pull-right mt-2"> Total Used Amount
                                                    <span class="text-danger">*</span> :
                                                    </label> 
                                                </div>                                                   
                                                <div class="input-group-prepend mt-2">
                                                    <span class="input-group-text">RM </span>
                                                </div>
                                                <input class="form-control mt-2 text-body" id="total" type="number" step="0.01" placeholder="100.00" value="0" readonly> 
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                            </div>
                        </div>                                 
                    </div>
                    
                    <div class="row" id="attendance">
                        <div class="col-12 ">
                            <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                                <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Attendance Report</h6>
                                </div>
                                <div class="box-body p-3">
                                    <p class="mb-1">
                                        
                                    
                                            <div class="column">
                                                <label class="control-label col font-weight-bold" for="field1"> Event Duration : {{$records->get('event_duration')}} Days
                                                </label>
                                                <label class="control-label col font-weight-bold" for="field1"> Total Participants : {{$records->get('total_participant')}} participants
                                                </label>
                                            </div>
                                    </p>
                                 </div>

                                
                                        
                                    <div class="card-body ">                     
                                                <div class="row mt-2">
                                                    <div class="col s12" style="overflow: auto">
                                                        <table id="table3" class="table table-striped table-bordered dataTable no-footer" style="width: 100% !important;"></table>
                                                    </div>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>



<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script type="text/javascript" src="{{asset('js/admire/components.js')}}"></script>

<script type="text/javascript" src="{{asset('/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>

<script src="{{asset('/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/app-assets/vendors/js/pickers/daterange/daterangepicker.js')}}"></script>

<script>


$(document).ready(function() {
calcTotal();

function calcTotal(){
    let count =Number("{{count($event->get('expenses'))}}");
        var total = 0.00;
        for(let i=0 ;i <count;i++){
            var item = $('#exUsed_'+String(i)).val();
            var item2 = $('#over_'+String(i)).val();
            if(item != "") total += parseFloat(item);
            if(item2 !="") total += parseFloat(item2);
        }
        $('#total').val(total.toFixed(2));
}
  

   
$('#assign-penazir').on('show.bs.modal', function(e) {
        var name = $(e.relatedTarget).data('value');
        $('.name').val(name);
        
        $(this).find('#modal_form').attr('action', $(e.relatedTarget).data('href'));
});
var table = $('#table1').DataTable({
        paging: true, 
        processing: true,
        serverSide: true,
        dom: 'lBfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ],
        processing: true,
        serverSide: true,
        ajax: "{{ route('event.list.penazir.progress',$event->get('_id')) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
            {data: 'name', name: 'name', title: "Name"},
            {data: 'nric', name: 'nric', title: "NRIC"},
            {data: 'role', name: 'role', title: "Category"},
            {data: 'email', name: 'email', title: "Email"},
            {data: 'phone', name: 'phone', title: "Phone Number"},
        ]
});

var table = $('#table2').DataTable({
        paging: true, 
        processing: true,
        serverSide: true,
        dom: 'lBfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ],
        processing: true,
        serverSide: true,
        ajax: "{{ route('event.report.mark.list',$event->get('_id')) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
            {data: 'name', name: 'name', title: "Name"},
            {data: 'nric', name: 'nric', title: "NRIC"},
            {data: 'role', name: 'role', title: "Category"},
            {data: 'email', name: 'email', title: "Email"},
            {data: 'mark', name: 'mark', title: "Overall Marks"},
            {data: 'action', name: 'action', title: "Action"},

        ]
});


var table = $('#table3').DataTable({
        paging: true, 
        processing: true,
        serverSide: true,
        dom: 'lBfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ],
        ajax: "{{ route('event.report.attendance.list',$event->get('_id')) }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', title: "#", searchable: false, orderable: false},
            {data: 'name', name: 'name', title: "Name"},
            {data: 'nric', name: 'nric', title: "NRIC"},
            {data: 'role', name: 'role', title: "Category"},
            {data: 'email', name: 'email', title: "Email"},
            {data: 'phoneNumber', name: 'phoneNumber', title: "Phone Number"},
            {data: 'present', name: 'present', title: "Total Present"},
            {data: 'absent', name: 'absent', title: "Total Absent"},

        ]
});
});

   $(".select2").select2({
        closeOnSelect: false
    });

    showData(1);

        function showData($selected) {
            if($selected == 1){
            $("#event").show();
            $("#penaziran").hide();
            $("#budget").hide();
            $('#attendance').hide();
            $("#buttonEvent").button('toggle');
            $("#buttonPenaziran").removeClass("active");
            $("#buttonBudget").removeClass("active");
            $("#buttonAttendance").removeClass("active");

    
            }
            else if($selected == 2){
            $("#event").hide();
            $("#penaziran").show();
            $("#budget").hide();
            $('#attendance').hide();
            $('#buttonPenaziran').button('toggle');
            $("#buttonEvent").removeClass("active");
            $("#buttonBudget").removeClass("active");
            $("#buttonAttendance").removeClass("active");


            }else if($selected == 3){
            $("#event").hide();
            $("#penaziran").hide();
            $("#budget").show();
            $('#attendance').hide();
            $("#buttonEvent").removeClass("active");
            $("#buttonPenaziran").removeClass("active");
            $("#buttonBudget").button('toggle');
            $("#buttonAttendance").removeClass("active");

            
            }else if($selected == 4){
                $("#event").hide();
                $("#penaziran").hide();
                $("#budget").hide();
                $('#attendance').show();
                $("#buttonEvent").removeClass("active");
                $("#buttonPenaziran").removeClass("active");
                $("#buttonBudget").removeClass("active");
                $("#buttonAttendance").button('toggle');
            }
        }


    
</script>
@endsection