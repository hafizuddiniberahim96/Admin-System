
@extends('layouts.template.base')
@section('css')
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
<link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>
@endsection

@section('content')


<div class="container-fluid">
    <div class="fade-in">
        <div class="py-4">
            <div class="container">
                <div class="col-md-12">
                <form action="/mye-usahawan/update-institution/{{$institution->_id}}" method="POST" class="institution_validator"  id="institution_validator">
                    @csrf
                    <div class="border rounded bg-white mb-3" id="profile">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Institution Registration Form</h6>
                            <p class="mb-0 mt-0 small">This information will be used to register your school/institution.
                                 </p>
                        </div>
                        <div class="box-body p-3">
                            <div class="row">
                                <!-- Input -->
                                <div class="col-sm-12 mb-2">
                                <div class="form-group">
                                    <label id="name" class="form-label font-weight-bold">
                                    Institution Name
                                    <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" id="name" value="{{$institution->name}}" >
                                    </div>
                                </div>
                                </div>
                                <!-- End Input -->
                            </div>
                            <div class="row">
                                  <!-- Input -->
                                  <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label id="postcode" class="form-label font-weight-bold">
                                            Institution Type
                                            <span class="text-danger">*</span>
                                            {{$institution->type}}
                                        </label>
                                        <div class="form-group">
                                        <select class="form-control custom-select" id="type" name="type">
                                                <option value="JPN" {{ $institution->type === 'JPN' ? 'selected' : '' }}>JPN</option>
                                                <option value="YIK" {{ $institution->type === 'YIK' ? 'selected' : '' }}>YIK</option>
                                                <option value="Others" {{ $institution->type === 'Others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Input -->
                                <!-- Input -->
                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label id="postcode" class="form-label font-weight-bold">
                                            Postcode
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="postcode" id="postcode" value="{{$institution->postcode}}" >
                                        </div>
                                    </div>
                                </div>
                                <!-- End Input -->
                               
                            </div>  
                            <div class="row">
                                <!-- Input -->
                                <div class="col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label id="address" class="form-label font-weight-bold">
                                        Address
                                        <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-group">
                                            <textarea rows=5 class="form-control"  name="address" id="address" value="{{$institution->address}}" required>{{$institution->address}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Input -->
                            </div>
                            <div class="row">
                                       <!-- Input -->
                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label id="lblstate" class="form-label font-weight-bold">
                                        State
                                        <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-group">
                                        <select class="form-control custom-select" id="state" name="state_id" required>
                                            <option value=""></option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->_id }}" {{($state->_id == $institution->state_id ? 'selected' :'' )}}>{{ ucfirst($state->name)}}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Input -->
                                <!-- Input -->
                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label id="lblregion" class="form-label font-weight-bold">
                                        Region
                                        <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-group">
                                        <select class="form-control custom-select" id="region" name="region_id" required>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Input -->
                            </div>
                         
                           
                        </div>
                    </div>
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="mb-3 text-right">
                        <button class="font-weight-bold btn btn-success rounded p-3" form="institution_validator" type="submit" value="Submit">
                        &nbsp;&nbsp;&nbsp;&nbsp;  Submit &nbsp;&nbsp;&nbsp;&nbsp;
                        </button>
                    </div>
                </form>
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
<script type="text/javascript" src="{{asset('/js/admire/institution.js')}}"></script>

<script>
   
   $(document).ready(function() {
      get_region();

      $('#state').change(function(){
         get_region();
      }); 

      function get_region(){
         var state = $('#state').val();
            var $select = $('#region');
            var option;
            $select.empty();
            $.get( "/get-region", { state_id : state} )
               .done(function( data ) {
                  for (var index in data) {
                     $option = $("<option value='" + data[index]._id + "'>" + data[index].name + '</option>'); 
                     $select.append($option);
                     if(data[index]._id == '{{$institution->region_id}}')
                     $('option[value='+data[index]._id+']').attr('selected','selected');
                  }
               });
      }

   });
</script>

@endsection