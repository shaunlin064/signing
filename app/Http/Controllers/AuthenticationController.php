<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuthenticationController extends Controller
{

    protected static $pageConfigs = [
        'bodyClass' => "bg-full-screen-image",
        'blankPage' => true
    ];

    // Login
    public function view(){

        return view('/pages/auth-login', [
            'pageConfigs' => self::$pageConfigs
        ]);
    }
    public function login(Request $request){

        $validatedData = $request->validate([
            'account' => 'required',
            'password' => 'required',
        ]);

        $request = newRequest(['password' => md5($request->password) , 'account' => $request->account]);
        $systemController = New \App\Http\Controllers\API\SystemController();
        $result = $systemController->login($request);

        if($result['status'] != 1){
            return view('/pages/auth-login', [
                'pageConfigs' => self::$pageConfigs,
                'error' => $result['message']
            ]);
        }

        SessionController::store($result['data']);

        if(session('return_url')){
            return Redirect::to(session('return_url'));
        }
        return Redirect::route('index');
    }

    // Lock Screen
    public function lock_screen(){
      $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
      ];

      return view('/pages/auth-lock-screen', [
          'pageConfigs' => $pageConfigs
      ]);
    }
}
