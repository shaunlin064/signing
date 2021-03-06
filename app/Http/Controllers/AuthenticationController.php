<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Help\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class AuthenticationController extends Controller
{
    public static $encrypt = "FAA2C53CA77AEF2F77C6E3C83C81B798";

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

    public function keyAccessLogin ( Request $request ) {

        if( $request->key == null ){
            return view('pages.auth-login');
        }else{
            $result = $this->doRemoteLogin('','',$request->key);

            if($result['status'] != 1){
                return view('/pages/auth-login', [
                    'pageConfigs' => self::$pageConfigs,
                    'error' => $result['message'],
                    'form_data' => [ $request->account, $request->password]
                ]);
            }

            return Redirect::route('index');
        }
    }

    public function login(Request $request){

        $request->validate([
            'account' => 'required',
            'password' => 'required',
        ]);
	
        $result = $this->doRemoteLogin($request->account, $request->password);
	    
        if($result['status'] != 1){
            return view('/pages/auth-login', [
                'pageConfigs' => self::$pageConfigs,
                'error' => $result['message'],
                'form_data' => [ $request->account, $request->password]
            ]);
        }

        $userObj = User::where('name',$request->account)->first();

        if(empty($userObj)){
            $request->merge(['password'=>Hash::make($request->get('password'))]);
            $request->merge(['erp_user_id'=>$result['login_user']['id']]);
            $userObj = User::create($request->toArray());
        }
	    Auth::loginUsingId($userObj->id);
        
        if($request->return_url){
            return Redirect::to($request->return_url);
        }
        
        return Redirect::to('/form-list');
    }
	
    public function logout(Request $request){
    	$user = User::where('api_token',$request->api_token)->get()->first();
	    $user->api_token = null;
	    $user->update([
		    'api_token' => null
	    ]);
    }
    
	public function lockScreenLogin ( Request $request ) {
		$request->validate([
			'account' => 'required',
			'password' => 'required',
		]);
		
		return $this->doRemoteLogin($request->account, $request->password);
    }
    
    public function doRemoteLogin ($account,$password,$accessKey = null) {
        $systemController = New \App\Http\Controllers\API\SystemController();
        if($accessKey){
            $remoteRequest = newRequest(['key' => $accessKey]);
        }else{
            $remoteRequest = newRequest(['password' => md5($password) , 'account' => $account]);
        }
        if(env('APP_ENV')){
	        $remoteRequest = newRequest(['password' => $password , 'account' => $account]);
        }

        $result = $systemController->login($remoteRequest);
			
        return $result;
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
