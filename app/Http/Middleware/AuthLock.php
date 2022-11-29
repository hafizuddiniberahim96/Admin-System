<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Traits\LockableTrait;

use Closure;
use Illuminate\Http\Request;


class AuthLock 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)    
    {   
        

        
        if(!$request->user()){
           return $next($request);
        }    

        // If the user does not have this feature enabled, then just return next.
        if (!$request->user()->hasLockoutTime()) {

            // Check if previous session was set, if so, remove it because we don't need it here.
            if (session('lock-expires-at')) {
                session()->forget('lock-expires-at');
            }
           
            return $next($request);
        }
       
        if ($lockExpiresAt = session('lock-expires-at')) {
            if ($lockExpiresAt < now()) {
                
                return redirect('lock-screen');
            }
        }
        //auto-lock 
        session(['lock-expires-at' => now()->addMinutes(15)]);
    
        return $next($request);
    }
}
