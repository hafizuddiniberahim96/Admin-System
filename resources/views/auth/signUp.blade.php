
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up | BUIPA</title>
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
        <img src="img/loader.gif" style=" width: 40px;" alt="loading...">
    </div>
</div>
    
    <div class="container wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.5s">
        <div class="row">
            <div class="col-12 mx-auto" style="margin-top:10%;">
                <div class="row">
                    <div class="col-lg-5 col-sm-12  col-md-8 mx-auto">
                        <div class="login_logo login_border_radius1 bg-pkink">
                            <h3 class="text-center" >
                                <img src="{{asset('/img/logo-pkink.png')}}" alt="pkink logo" class="logo-img"> 
                                <br>
                                <span class="text-white">
                                Badan Usahawan, Industri & Perhubungan Antarabangsa
                                <br>
                                <br>
                                Sign Up
                                </span>
                            </h3>
                        </div>
                        

                        <div class="bg-white login_content login_border_radius">
                             <!-- <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-nric-tab" data-bs-toggle="tab" data-bs-target="#nav-nric" type="button" role="tab" aria-controls="nav-nric" aria-selected="true">NRIC</button>
                                    <button class="nav-link" id="nav-passport-tab" data-bs-toggle="tab" data-bs-target="#nav-passport" type="button" role="tab" aria-controls="nav-passport" aria-selected="false">Passport Number</button>
                                </div>
                            </nav> -->
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-nric" role="tabpanel" aria-labelledby="nav-nric-tab">
                                    
                                    <form class="form-horizontal login_validator m-b-20" id="register_valid_nric"
                                        action="/register" method="post">
                                        @csrf
                                        <div class="form-group row" >
                                            <div class="col-sm-12" id="identity-form">
                                                <label for="nric" class="col-form-label">NRIC *</label>
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text border-right-0 rounded-left">
                                                        <i class="fa fa-credit-card text-danger"></i></span>
                                                    <input type="text" class="form-control" id="nric" name="nric" placeholder="NRIC">
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <label for="email" class="col-form-label">Email *</label>
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text border-right-0 rounded-left">
                                                        <i class="fa fa-envelope text-danger"></i>
                                                    </span>
                                                    <input type="text" placeholder="Email Address"  name="email" id="email" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
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
                                            <div class="col-sm-12">
                                                <label for="password" class="col-form-label text-sm-right">Password *</label>
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text border-right-0 rounded-left">
                                                        <i class="fa fa-key text-danger"></i>
                                                    </span>
                                                    <input type="password" placeholder="Password"  id="password" name="password" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="confirmpassword" class="col-form-label">Confirm Password *</label>
                                                <div class="input-group input-group-prepend">
                                                <span class="input-group-text border-right-0 rounded-left">
                                                    <i class="fa fa-key text-danger"></i>
                                                </span>
                                                    <input type="password" placeholder="Confirm Password" name="confirmpassword" id="confirmpassword" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                    
                                
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="submit" value="Submit" class="btn bg-pkink text-white"/>
                                                    <button type="reset" class="btn btn-warning">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    
                                </div>
                                <!-- <div class="tab-pane fade" id="nav-passport" role="tabpanel" aria-labelledby="nav-passport-tab">
                                    <form class="form-horizontal login_validator m-b-20" id="register_valid_passport"
                                        action="/register" method="post">
                                        @csrf
                                        <div class="form-group row" >
                                            <div class="col-sm-12" id="identity-form">
                                                <label for="passport" class="col-form-label">Passport Number *</label>
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text border-right-0 rounded-left">
                                                        <i class="fa fa-credit-card text-danger"></i></span>
                                                    <input type="text" class="form-control" id="passport" name="passport" placeholder="Passport Number">
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-12">
                                                <label for="email" class="col-form-label">Email *</label>
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text border-right-0 rounded-left">
                                                        <i class="fa fa-envelope text-danger"></i>
                                                    </span>
                                                    <input type="text" placeholder="Email Address"  name="email" id="email" class="form-control"/>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
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
                                            <div class="col-sm-12">
                                                <label for="password" class="col-form-label text-sm-right">Password *</label>
                                                <div class="input-group input-group-prepend">
                                                    <span class="input-group-text border-right-0 rounded-left">
                                                        <i class="fa fa-key text-danger"></i>
                                                    </span>
                                                    <input type="password" placeholder="Password"  id="password" name="password" class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <label for="confirmpassword" class="col-form-label">Confirm Password *</label>
                                                <div class="input-group input-group-prepend">
                                                <span class="input-group-text border-right-0 rounded-left">
                                                    <i class="fa fa-key text-danger"></i>
                                                </span>
                                                    <input type="password" placeholder="Confirm Password" name="confirmpassword" id="confirmpassword" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <input type="submit" value="Submit" class="btn bg-pkink text-white"/>
                                                    <button type="reset" class="btn btn-warning">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>                                     

                                </div> -->
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- global js -->
    <script type="text/javascript" src="js/admire/jquery.min.js"></script>
    <script type="text/javascript" src="js/admire/popper.min.js"></script>
    <script type="text/javascript" src="js/admire/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <!-- end of global js-->
    <!--Plugin js-->
    <script type="text/javascript" src="vendor/admire/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
    <script type="text/javascript" src="vendor/admire/wow/js/wow.min.js"></script>
    <!--End of plugin js-->
    <script type="text/javascript" src="js/admire/register.js"></script>
</body>


</html>