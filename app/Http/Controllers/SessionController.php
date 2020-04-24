<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Route;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{
    //
    /**
     * @param $data
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public static function store ( $data ): void
    {
        $loginUser = &$data['login_user'];
        $loginUser['last_login'] = Carbon::now()->format('Y-m-d h:i:s');
        $member = $data['member'];
        $department = $data['department'];

        if ( Cache::store('memcached')->has('login_user_log') )
        {
            $cacheLoginser = collect(Cache::store('memcached')
                                         ->get('login_user_log'))->map(function ( $v, $k ) use ( $loginUser ) {
                if ( $v['id'] == $loginUser['id'] )
                {
                    $v = $loginUser;
                }
                return $v;
            });
        } else
        {
            $cacheLoginser[$loginUser['id']] = $loginUser;
        }
        session(['js_signing' =>  $data]);
        Cache::store('memcached')->forever('login_user_log', $cacheLoginser);
        Cache::store('memcached')->forever('member', $member);
        Cache::store('memcached')->forever('department', $department);
    }

    /**
     * @param $dataKey 'login_user' ,'member' , 'department'
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getSession($dataKey){

        if ( !Cache::store('memcached')->has($dataKey) ){
            $this->getRemoteData();
        }

        return Cache::store('memcached')->get($dataKey);

    }
    public function getRemoteData(){
        $request = new Request(['account'=>'shaun','password'=>'495200aac2f182eaca03d02df7887e06']);
        $systemController = New \App\Http\Controllers\API\SystemController();
        $systemController->login($request);
    }

    public function put( Request $request){
        session(['js_signing' => $request->get('value')]);

        return null;
    }

    public function get(Request $request){

        $key = $request->get('key');
        if(session('js_signing.'.$key) == NULL){
            $request->replace(['account'=>'shaun','password'=>'495200aac2f182eaca03d02df7887e06']);
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
