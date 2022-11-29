<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    //

    public function __construct(){
         
       
    }

    public function signout(){
        Auth::logout();
        Session::flush(); 
        return redirect('login');
    }
}
