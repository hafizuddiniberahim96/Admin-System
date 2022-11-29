<?php

namespace App\Http\Controllers\Auth;


use Hash;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User_roles as Roles;
use App\Models\User;
use Helmesvs\Notify\Facades\Notify;

class LoginController extends Controller
{
    //
    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){

        $roles = Roles::select('_id as id', 'name')->where('name', '<>', 'admin')->get();
        return view('auth.login')->with('roles',$roles);;
    }

    public function Login(Request $request)
    {
        $request->validate([
            'nric' => 'required',
            'password' => 'required',
            'roles' => 'required',
        ]);

        $request->merge(['roles_id'=>$request->roles]);
        $credentials = $request->only('nric','roles_id', 'password');

        if(Auth::validate($credentials)){
            $user = Auth::getLastAttempted();
            if($user->isActive){
                Auth::attempt($credentials);
                Notify::success("Successfully login.", "Success",["closeButton" => true]);
                return redirect('home');
            }
            else if(!($user->isActive)){
                return redirect('/verify-email/'.$user->_id);
            }
        }

        Notify::error("Credential is invalid.", "Error",["closeButton" => true]);
        return redirect("login");

    }


    public function adminLogin()
    {
        return view('auth.loginAdmin');
    } 
    
    public function LoginAdmin(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
       
     
        $credentials = $request->only('email', 'password');
        $credentials['roles_id'] = Roles::select('_id')->where('name', 'admin')->first()['id'];
       
        if (Auth::attempt($credentials)) {
            Notify::success("Successfully login", "Success",["closeButton" => true]);
            if(!Auth::User()->registerComplete){
                return redirect('profile');
            }
            else return redirect('home');
        }
        Notify::error("Credential is invalid.", "Error",["closeButton" => true]);
        return redirect("login");
    }

    
}
