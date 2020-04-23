<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */
    Route::any('/reset',function (){
       $formApply = new \App\FormApply();
       $data = $formApply->find(1);
        $data->status = 1;
        $data->now = 1;
        $data->next = 2;
        $data->checkPoint->map(function($v,$k){
            $v->status =1 ;
            $v->signed_at = null;
            $v->remark = '';
            $v->replace_signed_member_id = null;
            $v->update();
            return $v;
        });
    });
    Route::view('/', 'pages.index',
                [ 'breadcrumbs' => [ [ 'name' => "User" ], [ 'link' => "form-new", 'name' => "申請簽核" ] ] ]);
    //  User
    Route::view('/form-new', 'pages.customer.form-new',
                [ 'breadcrumbs' => [ [ 'name' => "User" ], [ 'link' => "form-new", 'name' => "申請簽核" ] ] ]);
    Route::view('/form-list', 'pages.customer.form-list',
                [ 'breadcrumbs' => [ [ 'name' => "User" ], [ 'link' => "form-list", 'name' => "簽核狀態" ] ] ]);
    Route::view('/signature', 'pages.customer.signatrue',
                [ 'breadcrumbs' => [ [ 'name' => "User" ], [ 'link' => "form-list", 'name' => "設定簽名檔" ] ] ]);

    //  Signinger
    Route::view('/form-pending', 'pages.customer.form-pending',
                [ 'breadcrumbs' => [ [ 'name' => "Signinger" ], [ 'link' => "form-new", 'name' => "待審簽核" ] ] ]);
    Route::view('/form-all', 'pages.customer.form-all',
                [ 'breadcrumbs' => [ [ 'name' => "Signinger" ], [ 'link' => "form-new", 'name' => "所有簽核" ] ] ]);

    //  Executor
    Route::view('/form-action', 'pages.customer.form-action',
                [ 'breadcrumbs' => [ [ 'name' => "Executor" ], [ 'link' => "form-new", 'name' => "待執行簽核" ] ] ]);
    Route::view('/form-allAction', 'pages.customer.form-allAction',
                [ 'breadcrumbs' => [ [ 'name' => "Executor" ], [ 'link' => "form-new", 'name' => "所有已執行簽核" ] ] ]);

//    form Edit
    Route::view('/form-edit', 'pages.customer.form-edit',
                [ 'breadcrumbs' => [ [ 'name' => "User" ], [ 'link' => "form-edit", 'name' => "簽核檢視" ] ] ]);
    /*error*/
    Route::any('/404', function(){
        abort(404);
    });
    Route::any('/500', function(){
        abort(500);
    });
    // Route Authentication Pages
    Route::view('/login',  'pages.auth-login');

//    Auth::routes();

//    Route::post('/login/validate', 'Auth\LoginController@validate_api');

    //Session Handle
    Route::post('/session/put',
        [
            'as' => 'session.put' ,
            'uses' => 'SessionController@put'
        ]);
    Route::post('/session/get',
        [
            'as' => 'session.get' ,
            'uses' => 'SessionController@get'
        ]);
    Route::post('/session/release',
        [
            'as' => 'session.release' ,
            'uses' => 'SessionController@release'
        ]);
