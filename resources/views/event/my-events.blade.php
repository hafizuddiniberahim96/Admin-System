@extends('layouts.template.base')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/event-card.css')}}">
@endsection

@section('content')

<div class="container-fluid ">
    <div class="fade-in">
        <div class="row py-4">

            <main class="col-md-12">
            @if(count($events) >0)
                <div class="row">
                    @foreach($events as $event)
                    <div class="col-xl-4">
                        <div class="card event-card">
                            <div class="card-header">
                                <div class="media">
                                    <img class="mr-3" src="{{asset('storage/' . $event['logo'])}}" alt="logo " height="50" layout="fixed-height">
                                    <div class="media-body">
                                        <h3 class="mt-0">{{$event['name']}}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="event-card-img">
                                <img class="img" src="{{asset('storage/' . $event['banner'])}}" alt="banner" height="320" layout="fixed-height">
                                <h4>{{$event['name']}}</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                <div class="col-auto">
                                        <h5>Date</h5>
                                        <p class="text-body">{{$event['start_date']}} - {{$event['end_date']}}</p>
                                    </div>
                                    <div class="col-auto">
                                        <h5>Location</h5>
                                        <p class="text-body">{{$event['location']}}</p>
                                    </div>
                                    <div class="col-auto">
                                        <h5>Fee</h5>
                                        @if($event['fee'] < 1)
                                        <p class="text-danger">Free</p>
                                        @else
                                        <p class="text-body">Fee : RM {{number_format($event['fee'], 2) }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
            @else
                <div class="row">
                <div class="card-body">
                            <br><br><br>
                            <h2 class="text-center"> :(</h2>
                            <br>
                            <h2 class="text-center">There is no event you participate at the moment</h2>
                            <br>
                            <p class="text-center">
                                You can update join events on event page.
                               
                            </p>
                            <br><br><br>
                 </div>
                                    
            @endif

                    


                </div>
            </main>
        </div>
    </div>
</div>

@endsection

@section('javascript')
@endsection