<?php

namespace App\Http\Controllers;
use Hash;

use Illuminate\Http\Request;
use App\Models\User;


class LockController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest')->except([
            'locked',
            'unlock'
        ]);
        
    }

    public function locked(){

        session(['lock-expires-at' => now()]);

        return view('auth.lockScreen');
    }

    public function unlock(Request $request){
        
        $request->validate([
            'password' => 'required',
        ]);

        $check = Hash::check($request->input('password'), $request->user()->password);

        if(!$check){
            return redirect()->route('login.locked')->withErrors([
                'Your password does not match your profile.'
            ]);
        }
        
        if (session('lock-expires-at')) {
            session()->forget('lock-expires-at');
        }

        return redirect('/');
    }
}
