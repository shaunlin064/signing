<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class CheckToken
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
	    
	    if (!isset($request->api_token)) {
		    throw new AuthenticationException('require api_token.');
	    }
    	
    	if(!User::where('api_token',$request->api_token)->exists()){
		    return 'Unauthorized';
	    }
	    unset($request['api_token']);
    	
	    return $next($request);
	    
    }
}
