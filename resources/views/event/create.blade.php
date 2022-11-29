
@extends('layouts.template.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{asset('/app-assets/vendors/css/forms/selects/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('/css/filter-style.css')}}">
<link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/pickers/daterange/daterangepicker.css">


@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="py-4">
        
            <div class="container">
                <form action="/create-events" method="POST" class="event_validator"  id="event_validator" enctype="multipart/form-data">
                    @csrf
                <div class="row">
                    <!-- Main Content -->
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
                                                    <input class="form-control " id="name" name="name" placeholder="Eg. Seminar" value="{{$event->get('name')}}" required>
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
                                                <input type="checkbox" id="unlimited" name="seats" value="-1"  {{($event->get('seats') == -1) ? 'checked' : 'unchecked' }}> Unlimited
                                                <div class="form-group">
                                                    <input class="form-control" id="seat" name="seats"   type="number" placeholder="100"  value="{{$event->get('seats')}}" required   {{($event->get('seats') == -1) ? 'disabled' : '' }}>
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
                                                    <select class="select2 form-control" id="sector" name="system_settings_id" required>
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
                                                <select name="participants[]" class="select2 form-control" multiple="multiple" id="participants">
                                                    <option value=""></option>
                                                @if($event->count())
                                                    @if(!($event->get('participants')->isEmpty()))
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
                                                    <input class="form-control date_start" name="date_start" value="{{$event->get('date_start')}}" type="text" id="date_start">
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
                                                    <input class="form-control date_end" name="date_end" type="text" value="{{$event->get('date_end')}}" id="date_end">
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
                                                    <input class="form-control register_before" name="register_before" type="text" value="{{$event->get('register_before')}}" id="register_before">
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
                                                    <input class="form-control" id="fee" name="fee" type="number" step="0.01" value="{{$event->get('fee')}}" placeholder="100" required>
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
                                                        <input class="form-check-input" type="radio" name="event_mode" id="event_mode1" value="physical" {{("physical" == $event->get('event_mode') ? 'checked' :'' )}} required>
                                                        <label class="form-check-label" for="physical">Physical</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="event_mode" id="event_mode2" value="online" {{("online" == $event->get('event_mode') ? 'checked' :'' )}} required>
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
                                                    <input class="form-control" id="location" name="location" value="{{$event->get('location')}}" required>
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
                                                    <!-- <input type="file" class="form-file-input button" name="bannerimg" onchange="readBannerImg(this);"> -->
                                                    
                                                    <input type="file" class="form-control" name="bannerimg" onchange="readBannerImg(this);" accept="image/*" {{$event->get('bannerImg') ? '' : 'required'}}/>  

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
                                                    <input type="file" class="form-control" name="logoimg" onchange="readLogoImg(this);" accept="image/*"  {{$event->get('logo') ? '' : 'required'}} />


                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div>
                                </div>
                            </div>
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
                                                    <input type="checkbox" id="eventcheckbox" name='isAward' value="1"  {{( $event->get('isAward') == 0 ? '' :'checked' )}} >
                                                </label>
                                            </div>
                                        </div>
                                        <!-- End Input -->
                                    </div>
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
                                                                    <input type="text" class="form-control penaziran" name="penazirans[]" value= "{{$penaziran}}" placeholder="Eg. Creativity, Presentation Performance" required>                     
                                                                    <button class="btn btn-upload btn-danger btn-remove" type="button">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                        <div class="penaziran-entry input-group upload-input-group">
                                                                <input type="text" class="form-control penaziran" name="penazirans[]" placeholder="Eg. Creativity, Presentation Performance" value='' {{empty($event->get('penaziran')) ? 'required' : ''}} >                     
                                                                <button class="btn btn-upload btn-success penaziran-add" type="button">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                        </div>
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
                                                        <select name="penazir[]" class="select2 form-control" multiple="multiple" id="penazir" required>
                                                            <option value=""></option>
                                                            @if($event->count())
                                                                @if($event->get('penazirs')->count())
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
                                </div>
                            </div>
                            <div class="border rounded bg-white col-md-auto mb-3 mt-3">
                                <div class="box-title border-bottom p-3">
                                <h6 class="m-0">Budget Details   <span class="text-danger">*</span>
                                </h6>
                                </div>
                                <div class="box-body p-3">      
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
                                            @foreach( $event->get('expenses') as $expensess)
                                                <div class="input-group col-sm-12 expenses-entry">
                                                    <select name="expenses-type[]" class="form-control input-group-prepend col-sm-4 expenses" required>
                                                        <option disabled selected hidden>Expenses Type</option>
                                                    @foreach ($expenses as $expense)
                                                        <option value="{{ $expense->_id }}"  {{($expense->_id == $expensess['type'] ? 'selected' :'' )}} >{{ ucfirst($expense->name)}}</option>
                                                    @endforeach
                                                    </select>

                                                    <select name="reasons-type[]" class="form-control input-group-prepend col-sm-4 expenses" required> 
                                                            <option disabled selected hidden>Payment Reason</option>
                                                    @foreach ($reasons as $reason)
                                                        <option value="{{ $reason->_id }}" {{($reason->_id == $expensess['reason'] ? 'selected' :'' )}}>{{ ucfirst($reason->name)}}</option>
                                                    @endforeach
                                                    </select>
                                                    <div class="input-group-prepend expenses">
                                                        <span class="input-group-text">RM </span>
                                                    </div>
                                                    <input class="form-control expenses" name="expenses-fee[]" type="number" step="0.01" placeholder="100.00" value="{{$expensess['value']}}" required>
                                                    <button class="btn btn-upload btn-danger btn-remove" type="button">
                                                        <i class="fa fa-trash"></i>
                                                    </button>  
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                            <div class="input-group col-sm-12 expenses-entry">
                                                <select name="expenses-type[]" class="form-control  col-sm-4 expenses" {{ $event->count() ? ($event->get('expenses')->isEmpty()) ? 'required' : ''  : 'required'}}>
                                                    <option  value="">Expenses Type</option>
                                                @foreach ($expenses as $expense)
                                                    <option value="{{ $expense->_id }}" >{{ ucfirst($expense->name)}}</option>
                                                @endforeach
                                                </select>
                                                <select name="reasons-type[]" class="form-control col-sm-4 expenses" {{ $event->count() ? ($event->get('expenses')->isEmpty()) ? 'required' : ''  : 'required'}}> 
                                                    <option value="">Payment Reason</option>
                                                    @foreach ($reasons as $reason)
                                                        <option value="{{ $reason->_id }}" >{{ ucfirst($reason->name)}}</option>
                                                    @endforeach
                                                </select>
                                                <div class="input-group-prepend expenses">
                                                    <span class="input-group-text">RM </span>
                                                </div>
                                                <input class="form-control expenses" name="expenses-fee[]" type="number" step="0.01" placeholder="100.00" {{ $event->count() ? ($event->get('expenses')->isEmpty()) ? 'required' : ''  : 'required'}}>
                                                <button class="btn btn-upload btn-success expenses-add" type="button">
                                                    <i class="fa fa-plus"></i>
                                                </button>                                             
                                            </div>
                                        
                                        <!-- End Input -->
                                        <input type="hidden" id='status' name="status" value="pending" />
                                        <input type='hidden' name="event_id" value="{{$event->get('_id')}}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 mt-3 ml-3">
                                <button class="font-weight-bold btn btn-success rounded p-3 pull-right" form="event_validator" type="submit" value="Submit">
                                    &nbsp;&nbsp;&nbsp;&nbsp;  Submit &nbsp;&nbsp;&nbsp;&nbsp;
                                </button>
                                <button class="font-weight-bold btn btn-info rounded p-3 pull-right mr-3" id='save' form="event_validator"  type="submit" value="Submit">
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
        //remove all required
        $('input').prop('required', false);
        $('select').prop('required', false);
        //only name event is required
        $('#name').prop('required', true);
    }); 


   

    $(document).on('click', '.penaziran-add', function (e) {
        e.preventDefault();
        var controlForm = $('.penaziran-controls:first'),
            currentEntry = $(this).parents('.penaziran-entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input[type=text]').val('');

        controlForm.find('.penaziran-entry:not(:last) .penaziran-add')
            .removeClass('penaziran-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fa fa-trash"></span>');
    }).on('click', '.btn-remove', function (e) {
        $(this).parents('.penaziran-entry:first').remove();

        e.preventDefault();
        return false;
    });

    $(document).on('click', '.expenses-add', function (e) {
        e.preventDefault();
        var controlForm = $('.expenses-controls:first'),
            currentEntry = $(this).parents('.expenses-entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
            newEntry.find('input[type=number]').val('');

        controlForm.find('.expenses-entry:not(:last) .expenses-add')
            .removeClass('expenses-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="fa fa-trash"></span>');
    }).on('click', '.btn-remove', function (e) {
        $(this).parents('.expenses-entry:first').remove();

        e.preventDefault();
        return false;
    });

    function readBannerImg(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#bannerimg')
                .attr('src', e.target.result)
                .width(400)
                .height(320);
        };

        reader.readAsDataURL(input.files[0]);
    }
} 

    function readLogoImg(input){
    if(input.files && input.files[0]){
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#logoimg')
                .attr('src', e.target.result)
                .width(50)
                .height(50);
        };

        reader.readAsDataURL(input.files[0]);
    } 
}
</script>
@endsection