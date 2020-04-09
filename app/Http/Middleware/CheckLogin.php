<?php

namespace App\Http\Middleware;

use Closure;

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
        if(session('js_signing') == null)
        {
            session(['return_url'=> $request->fullUrl()]);
            return Redirect::to('/login');
        }

        return $next($request);
    }
}
