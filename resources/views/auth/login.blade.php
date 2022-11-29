
<!DOCTYPE html>
<html>
<head>
    <title>Login | BUIPA</title>
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
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
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
        <img src="img/loader.gif" style=" width: 40px;" alt="loading...">
    </div>
</div>
    <div class="container wow fadeInDown" data-wow-delay="0.5s" data-wow-duration="2s">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top:10%;">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12 mx-auto" >
                        <div class="login_logo login_border_radius1 bg-pkink">
                            <h3 class="text-center" >
                                <img src="{{asset('/img/logo-pkink.png')}}" alt="pkink logo" class="logo-img"> 
                                <br>
                                <span class="text-white">
                                Badan Usahawan, Industri & Perhubungan Antarabangsa
                                <br>
                                <br>
                                Log In
                                </span>
                            </h3>
                        </div>
                        <div class="bg-white login_content login_border_radius">
                            <form action="/login" id="login_validator" method="post" class="login_validator">
                                @csrf
                                     <div class="form-group">
                                    <label for="nric" class="col-form-label"> NRIC</label>
                                    <div class="input-group input-group-prepend">
                                        <span class="input-group-text border-right-0 rounded-left input_email"><i
                                                class="fa fa-credit-card text-danger"></i></span>
                                        <input type="text" class="form-control form-control-md" id="nric" name="nric" placeholder="NRIC">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="roles" class="col-form-label">Category *</label>
                                    <div class="input-group input-group-prepend">
                                    <span class="input-group-text border-right-0 rounded-left">
                                        <i class="fa fa-universal-access text-danger"></i>
                                    </span>
                                        <select class="form-control" id="roles" name="roles">
                                            <option ></option>
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->_id }}">{{ ucfirst($role->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-form-label">Password</label>
                                    <div class="input-group input-group-prepend">
                                        <span class="input-group-text border-right-0 rounded-left addon_password"><i
                                                class="fa fa-lock text-danger"></i></span>
                                        <input type="password" class="form-control form-control-md" id="password"   name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" value="{{url()->previous()}}" name='previous'>
                                            <input type="submit" value="Log In" class="btn bg-pkink btn-block login_button text-white">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6 forgot_pwd">
                                        <a href="/forgot-password" class="custom-control-description text-danger">Forgot password?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label">Don't you have an Account? </label>
                                <a href='/sign-up' class="text-danger"><b>Sign Up</b></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
    <!-- global js -->
    <script type="text/javascript" src="{{asset('/js/admire/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/admire/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/admire/bootstrap.min.js')}}"></script>
    <!-- end of global js-->
    <!--Plugin js-->
    <script type="text/javascript" src="{{asset('/vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/vendor/admire/wow/js/wow.min.js')}}"></script>
    <!--End of plugin js-->
    <script type="text/javascript" src="{{asset('/js/admire/login.js')}}"></script>
</body>


</html>