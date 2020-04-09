<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    //
    public function put(Request $request){
        session(['js_signing' => $request->get('value')]);

        return null;
    }

    public function get(Request $request){

        return session('js_signing.'.$request->get('key'));
    }

    public function release(){
        session::forget('js_signing');
        session::forget('return_url');

        return null;
    }
}
