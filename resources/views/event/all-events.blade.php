@extends('layouts.template.base')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('/css/event-card.css')}}">


@endsection

@section('content')
<a id="button"></a>
<div class="modal fade creat-event" id="create-event" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Registration Event</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-xl-7">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="m-t-20">TITLE</label>
                                <input type="text " class="form-control text-body title" placeholder="Music Awards" readonly>
                            </div>
                        </div>
                       
                        <div class="row">

                            <div class="col-md-6">
                                <label class="m-t-20 mt-4" for="exampleFormControlTextarea">DATE</label>
                                <div class="input-group clockpicker">
                                    <input type="text" class="form-control text-body date" value="15 June 2018" readonly>
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label class="m-t-20 mt-4" for="exampleFormControlTextarea">DURATION</label>
                                <div class="input-group clockpicker">
                                    <input type="text" class="form-control text-body duration" value="2 h 45 m" readonly>
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <label class="m-t-20 mt-4" for="exampleFormControlTextarea">LOCATION</label>
                                <div class="input-group clockpicker">
                                    <input type="text" class="form-control b-r-0 text-body location" value="New York City" readonly>
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-crosshairs"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-5">
                        <label class="m-t-20">PARTICIPANT NAME</label>
                        <form class="search-area" action="#" method="post">
                            <input type="text" class="form-control text-body username" placeholder="participant Name" readonly>
                            <i class="fa fa-user"></i>
                        </form>

                        <div class="row">

                            <div class="col-md-12">
                                <label class="m-t-20 mt-4" for="exampleFormControlTextarea">ADMISSION FEE</label>
                                <div class="input-group clockpicker">
                                    <input type="text" class="form-control b-r-0 text-body fee" value="Search location" readonly>
                                    <span class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fa fa-money"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <a id='confirmReg' class="btn btn-danger m-t-50 pull-right" href="#">CONFIRM</a>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

    
<div class="container-fluid ">

    <div class="fade-in">
        @if(count($events) >0)
        
        <div class="row py-4">


            <main class="col-md-12">

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
                                        <h5>Seat Left</h5>
                                        <p class="text-body">{{$event['seats']}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <ul>
                                    <li>
                                        @if($event['fee'] < 1)
                                        <p class="text-danger">Free</p>
                                        @else
                                        <p class="text-body">Fee : RM {{number_format($event['fee'], 2) }}</p>
                                        @endif
                                    </li>
                                </ul>
                                <div class="pull-right">
                                    <a class="btn btn-labeled btn-danger text-white {{is_numeric($event['seats']) ?  ($event['seats']  <= 0 ) ? 'disabled' : '' : '' }}"  data-href="/event/register/{{$event['id']}}/{{Auth::id()}}" 
                                        data-title="{{$event['name']}}" data-location="{{$event['location']}}" data-start="{{$event['start_date']}}"
                                        data-end="{{$event['end_date']}}" data-fee="RM {{number_format($event['fee'], 2) }}"
                                        data-toggle="modal" data-target="#create-event" >
                                        <i class="text-white fa fa-calendar-check-o" ></i>Register</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach                   
                </div>
            </main>
        </div>
        @else
                <div class="row">
                <div class="card-body">
                            <br><br><br>
                            <h2 class="text-center"> :(</h2>
                            <br>
                            <h2 class="text-center">There is no event for you to participate at the moment</h2>
                            <br>
                            <br><br><br>
                 </div>
                                    
            @endif
    </div>
</div>


@endsection

@section('javascript')
<script type="text/javascript" src="{{asset('/js/admire/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/js/admire/popper.min.js')}}"></script>


<script>
    var btn = $('#button');

    $( document ).ready(function() {
      $('.modal').on('show.bs.modal', function(e) { 
        var href = $(e.relatedTarget).data('href');
        var startDate = $(e.relatedTarget).data('start').toString().split("/");
        var endDate = $(e.relatedTarget).data('end').toString().split("/");
        var start_date = new Date(+startDate[2], startDate[1] - 1, +startDate[0]);
        var end_date = new Date(+endDate[2], endDate[1] - 1, +endDate[0]);
        var durationDay = ((end_date.getTime() - start_date.getTime()) / (1000 * 3600 * 24)) + 1;
        var date = start_date.toLocaleDateString('en-GB', {
                  day: 'numeric', month: 'short', year: 'numeric'
                }).replace(/ /g, ' '); 
        var fee = ''; if ($(e.relatedTarget).data('fee') != 'RM 0.00' ) fee = $(e.relatedTarget).data('fee'); else fee='Free';
        var location = $(e.relatedTarget).data('location');
        
        $('.title').attr('value', $(e.relatedTarget).data('title'));
        $('.username').attr('value', '{{ucwords(Auth::user()->details->fullName)}}');
        $('.date').attr('value', date);
        $('.duration').attr('value', durationDay.toString() + ' Days');
        $('.fee').attr('value', fee);
        $('.location').attr('value', location);
        $('#confirmReg').attr('href', href);

      });
    });




$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    btn.addClass('show');
  } else {
    btn.removeClass('show');
  }
});

btn.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});
</script>
@endsection