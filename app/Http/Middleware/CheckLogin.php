<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	
        if(auth()->user() === null)
        {
            session(['return_url' => $request->fullUrl()]);
            return Redirect::to('login');
        }
        
        if(auth()->user()->api_token === null){
	        session(['return_url' => $request->fullUrl()]);
	        return Redirect::to('login');
        }
        
        /*update session token*/
	    session(['js_signing.login_user.api_token' => auth()->user()->api_token]);
	    
        return $next($request);
    }
}
