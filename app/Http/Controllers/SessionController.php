<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;

class SessionController extends Controller
{
    //
    public function put(Request $request){
        session(['js_signing' => $request->get('value')]);

        return null;
    }

    public function get(Request $request){

        $key = $request->get('key');
        if(session('js_signing.'.$key) == NULL){
            $request->replace(['account'=>'alvin','password'=>'36f2dac921a160f180d06d2c59b3d0de']);
            $api_request = Request::create('api/system/login', 'POST');
            $api_request = $api_request->replace($request->input());
            $response = Route::dispatch($api_request)->getOriginalContent();
        }
        return session('js_signing.'.$key);
    }

    public function release(){
        session::forget('js_signing');
        session::forget('return_url');

        return null;
    }
}
