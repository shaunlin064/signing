<?php


    use Carbon\Carbon;
    use Illuminate\Http\Request;
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

    Route::any('flowAdd' , function(){
//        $table->char('name',64)->comment('簽核關卡名稱');
//        $table->unsignedTinyInteger('form_id')->comment('簽核表單ID');
//        $table->unsignedTinyInteger('review_order')->comment('簽核順位');
//        $table->unsignedTinyInteger('review_type')->comment('簽核人類型 1:指定人 2:指定位階');
//        $table->unsignedInteger('reviewer_id')->comment('指定簽核人ID or 簽核位階 1:一階主管 2:二階主管 3:三階主管');
//        $table->unsignedTinyInteger('overwrite')->comment('是否可被上層簽核取代 0:不可 1:可');
//        $table->unsignedTinyInteger('replace')->comment('是否有代簽 0:不可 1:可');
//        $table->unsignedTinyInteger('role')->comment('角色 1:簽核 2:執行');
//        @input replace_type : 簽核類型 1:指定人 2:指定位階
//        * @input replace_id : 指定簽核人ID or 簽核位階 1:一階主管 2:二階主管 3:三階主管
        $obj = new \App\Http\Controllers\API\FormFlowController();
        $data = [
            [
                'name' => '執行長室',
                'review_type' => 1,
                'reviewer_id' => 106, //雨涵
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '部級主管',
                'review_type' => 2,
                'reviewer_id' => 1, //一階主管
                'overwrite' => 1,
                'replace' => 1,
                'role' => 1,
            ],
            [
                'name' => '單位最高主管',
                'review_type' => 2,
                'reviewer_id' => 3, //最高主管
                'overwrite' => 1,
                'replace' => 1,
                'role' => 1,
            ],
            [
                'name' => '財務長',
                'review_type' => 1,
                'reviewer_id' => 17, //van
                'overwrite' => 1,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '執行長',
                'review_type' => 1,
                'reviewer_id' => 15, //老大
                'overwrite' => 0,
                'replace' => 0,
                'role' => 1,
            ],
            [
                'name' => '總務',
                'review_type' => 1,
                'reviewer_id' => 190, //Ann
                'overwrite' => 0,
                'replace' => 1,
                'role' => 2,
                'replace_type' => [1],
                'replace_id' => [106]
            ],
        ];

        foreach($data as $k => $item){

            $item['form_id'] = 2;
            $item['review_order'] = $k+1;
            $obj->add(newRequest($item));
        }

    });
    Route::any('/formnew',function (){

        $request = new Request(['form_id' => 2 , 'apply_member_id' => 157]);
        $obj = new \App\Http\Controllers\API\FormController();

        $obj->apply($request);
    });
    Route::any('/formList',function (){

        $request = new Request(['member_id' => 17 , 'role' => 1]);

        $obj = new \App\Http\Controllers\API\FormController();
        $obj->checkList($request);
    });
    Route::any('/formget',function (){

        $request = new Request(['id' => 3 ,'member_id' => 17 ]);
        $obj = new \App\Http\Controllers\API\FormController();

        $obj->get($request);
    });
Route::any('/test',function (){

   $request = newRequest(['member_id' => 157]);
   $obj = new \App\Http\Controllers\API\SystemController();

    $obj->messageSetReadAll($request);
});
    // Route Authentication Pages
    Route::get('/login',  'AuthenticationController@view')->name('login');
    Route::post('/remoteLogin','AuthenticationController@login')->name('remoteLogin');

    Route::group(['middleware' => ['checkLogin']], function () {
        Route::view('/', 'pages.index',
                    [ 'breadcrumbs' => [ [ 'name' => "home" ]] ])->name('index');
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
                    [ 'breadcrumbs' => [ [ 'name' => "User" ], [ 'link' => "form-edit", 'name' => "簽核檢視" ] ] ])->name('form-edit');
    });
    /*error*/
    Route::any('/404', function(){
        abort(404);
    });
    Route::any('/500', function(){
        abort(500);
    });


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
    Route::any('/session/release',
        [
            'as' => 'session.release' ,
            'uses' => 'SessionController@release'
        ]);
