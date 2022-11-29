
<!DOCTYPE html>
<html>
<head>
    <title>Check-In | BUIPA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="shortcut icon" href="{{asset('/img/logo-pkink.png')}}"/>
    <!--Global styles -->
    <link type="text/css" rel="stylesheet" href="{{asset('/css/admire/components.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('/css/admire/custom.css')}}" />
    <!--End of Global styles -->
    <!--Plugin styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/bootstrapvalidator/css/bootstrapValidator.min.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('/vendor/admire/wow/css/animate.css')}}"/>
    <!--End of Plugin styles-->
    <link type="text/css" rel="stylesheet" href="{{asset('/css/admire/login.css')}}"/>
    <link href="{{ asset('css/buipa/custom.css') }}" rel="stylesheet">

</head>
<body>
{!! Notify::render() !!}
<div class="preloader" style=" position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 100000;
  backface-visibility: hidden;
  background: #ffffff;">
    <div class="preloader_img" style="width: 200px;
  height: 200px;
  position: absolute;
  left: 48%;
  top: 48%;
  background-position: center;
z-index: 999999">
        <img src="{{asset('/img/loader.gif')}}" style=" width: 40px;" alt="loading...">
    </div>
</div>
<div class="container-fluid">
    <div class="fade-in">
        <div class="container wow fadeInDown" data-wow-delay="0.5s" data-wow-duration="2s">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 login_top_bottom">
                <div class="row">
                    <div class="col-lg-5  col-md-8  col-sm-12 mx-auto">
                        <div class="login_logo card-header bg-pkink">
                            <h3 class="text-center">
                                <img src="{{asset('/img/logo-pkink.png')}}" alt="pkink logo" class="logo-img">
                                <br>
                                <span class="text-white">
                                Badan Usahawan, Industri & Perhubungan Antarabangsa
                                <br>
                                <br>
                                    Check-In Event
                                </span>
                            </h3>
                        </div>
                        <div class="bg-white card-body">
                            <br><br><br>
                            <h4 class="text-center"> Thank You For Joining Buipa Event</h4>
                            <br>
                            <p class="text-center">{{$message}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    </div>
</div>
</body>
<script type="text/javascript" src="{{asset('/js/admire/login.js')}}"></script>


</html>