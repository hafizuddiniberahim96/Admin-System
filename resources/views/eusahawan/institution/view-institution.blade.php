
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
                    <div class="border rounded bg-white mb-3" id="profile">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Institution Registration Form</h6>
                            <p class="mb-0 mt-0 small">This information will be used to register your school/institution.
                            </p>
                            @if($institution->status->isApproved == 1)
                                <a  class="btn btn-labeled btn-info pull-right text-white" type="button" data-toggle="tooltip" data-placement="top" title="Certificate">Download Certificates</a> 
                            @endif
                        </div>
                        <div class="box-body p-3">
                            <br>
                            <div class="row">
                                <!-- Input -->
                                <div class="col-sm-12 mb-2">
                                <div class="form-group">
                                    <label id="name" class="form-label font-weight-bold">
                                    Institution Name
                                    <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="name" id="name" value="{{$institution->name}}" disabled>
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
                                        </label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="type" id="type" value="{{$institution->type}}" disabled>
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
                                            <input type="text" class="form-control" name="postcode" id="postcode" value="{{$institution->postcode}}" disabled>
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
                                            <textarea rows=5 class="form-control"  name="address" id="address" value="{{$institution->address}}" disabled>{{$institution->address}}</textarea>
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
                                            <input type="text" class="form-control" name="state" id="state" value="{{$institution->state->name}}" disabled>
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
                                            <input type="text" class="form-control" name="region" id="region" value="{{$institution->region->name}}" disabled>

                                        </div>
                                    </div>
                                </div>
                                <!-- End Input -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </dv>
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