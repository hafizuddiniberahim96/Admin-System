@extends('layouts.template.base')

@section('css')
    
@endsection

@section('content')
<div class="container-fluid ">
    <div class="fade-in">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Register Attendance
                            <a  class="btn btn-primary text-white pull-right" title="Print" type="button" href="/events/print-qrcode-attendance/{{$link->event_id}}">
                                <i class="fa fa-print"></i>
                            </a>  
                        </h4>
                        
                    </div>
                    <div class="card-body text-center">
                    {!! QrCode::size(300)->generate(url('events/attendance/'.$link->event_id.'/'.$link->token)) !!}
                    </div>
                    <div class="card-footer">
                        Link: <a href="{{url('events/attendance/'.$link->event_id.'/'.$link->token)}}">{{url('events/attendance/'.$link->event_id.'/'.$link->token)}}</a>

                    </div>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-12">
                        <div class="border rounded bg-white col-md-auto">
                            <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Event Details</h6>
                            </div>
                            <div class="box-body p-3">                                        
                                <div class="row">
                                    <div class="col mb-3 mb-sm-6">
                                        <div class="form-group">
                                            <label for="title" class="form-label font-weight-bold">
                                            Event Name
                                            </label>
                                            <div class="form-group">
                                                <span class = "label label-default">{{$link->event_name}}</span>
                                            </div>
                                        </div>
                
                                            <div class="form-group">
                                                <label for="title" class="form-label font-weight-bold">
                                                QR Link created at
                                                </label>
                                                <div class="form-group">
                                                    <span class = "label label-default">{{$link->created_at->format('d/m/Y H:i A')}}</span>
                                                </div>
                                            </div>
                            
                                        @if($link->expires_in > date('Y-m-d H:i:s') )
                                            <div class="form-group">
                                                <label for="title" class="form-label font-weight-bold">
                                                QR Link expired at
                                                </label>
                                                <div class="form-group">
                                                    <span class = "label label-default">{{$link->expires_in->format('d/m/Y H:i A')}}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="title" class="form-label font-weight-bold">
                                            QR Link Status
                                            </label>
                                            <h4 class="form-group">
                                            @if($link->expires_in > date('Y-m-d H:i:s') )
                                                <span class = "badge  badge-success">Active</h3>
                                            @else
                                                <span class = "badge  badge-danger">Expired</h3>
                                            @endif
                                            </h4>
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
</div>

@endsection

@section('javascript')
    

@endsection