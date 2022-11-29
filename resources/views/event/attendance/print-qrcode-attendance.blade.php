
<!DOCTYPE html>
<html>
<head>
    <title>Register Event | BUIPA</title>
    <style>
        .center{text-align: center;}
    </style>
</head>
<body>
    <div class="container">
        <br><br>
        <div class="login_logo login_border_radius1 ">
            <h3 class="center">
                <img src="{{asset('/img/logo-pkink.png')}}" alt="buipa logo" class="img" width="100" height="100"> 
                <br>
                BUIPA EVENT ATTENDANCE
            </h3>
        </div>
        <br><br>
        <div class="card center">
            <div class="card-header">
                <h2> Attendance <br>
                     {{$event->name}}
                </h2>
            </div>
            <div class="card-body">
                <br><br>
                <br><br>
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('svg')->size(400)->errorCorrection('H')->generate(url('events/attendance/'.$event->_id.'/'.$qrlink->token))) !!}">
            </div>
        </div>
        <br>
        <br>
        <br>
        <br>
        <p class="center">
            Please scan using your camera or QR code reader
        </p>
    </div>
</body>


</html>