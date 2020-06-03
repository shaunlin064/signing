<?php

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */


    // Route::middleware('auth:api')->get('/user', function (Request $request) {
    //     return $request->user();
    // });

    Route::group(
        [
            'prefix' => 'auth'
        ], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');

        Route::group(
            [
                'middleware' => 'auth:api'
            ], function () {
            Route::get('logout', 'AuthController@logout');
            Route::get('user', 'AuthController@user');
        }
        );

    }
    );
    Route::group(
        [
            'middleware' => 'auth:api',
            'prefix' => 'signature'
        ], function () {
        Route::post('/getUserSignatures', [
            'as' => 'api.signature.getUserSignatures',
            'uses' => 'API\SignatureController@getUserSignatures']);
        Route::post('/add', [
            'as' => 'api.signature.add',
            'uses' => 'API\SignatureController@add']);
        Route::post('/resetFavorite', [
            'as' => 'api.signature.resetFavorite',
            'uses' => 'API\SignatureController@resetFavorite']);
        Route::post('/delete', [
            'as' => 'api.signature.delete',
            'uses' => 'API\SignatureController@delete']);


    });

    Route::group(
        [
            'middleware' => 'auth:api',
            'prefix'     => '/form'
        ], function () {
        /**
         * 表單申請 審核相關 =====================================================
         */
        //送出申請表單
        Route::post(
            '/apply', [
                        'as'   => 'api.form.apply',
                        'uses' => 'API\FormController@apply'
                    ]
        );
        //申請表單內容
        Route::post(
            '/get', [
                      'as'   => 'api.form.get',
                      'uses' => 'API\FormController@get'
                  ]
        );
        //申請表單編輯
        Route::post(
            '/edit', [
                       'as'   => 'api.form.edit',
                       'uses' => 'API\FormController@edit'
                   ]
        );
        //申請表單作廢
        Route::post(
            '/fail', [
                       'as'   => 'api.form.fail',
                       'uses' => 'API\FormController@fail'
                   ]
        );
        //申請表單簽核
        Route::post(
            '/check', [
                        'as'   => 'api.form.check',
                        'uses' => 'API\FormController@check'
                    ]
        );
        //待簽核列表

        Route::post(
            '/check/list', [
                             'as'   => 'api.form.check.list',
                             'uses' => 'API\FormController@checkList'
                         ]
        );
        Route::any(
            '/user/list', [
                            'as'   => 'api.form.user.list',
                            'uses' => 'API\FormController@userList'
                        ]
        );
        //送簽列表

        //已簽核/已執行列表
        Route::post(
            '/all', [
                      'as'   => 'api.form.all',
                      'uses' => 'API\FormController@all'
                  ]
        );
        //上層依賴表單
        Route::post(
            '/depend', [
                         'as'   => 'api.form.depend',
                         'uses' => 'API\FormController@depend'
                     ]
        );

        //取pairDatas 關係資料表單
        Route::post(
            '/getPairData', [
                              'as'   => 'api.form.getPairData',
                              'uses' => 'API\FormController@getPairData'
                          ]
        );

    }
    );
    /**
     * 表單流程設定相關 ========================================================
     */
    Route::group(
        [
            'middleware' => 'auth:api',
            'prefix'     => '/form/flow'
        ], function () {
        //流程列表
        Route::post(
            '/list', [
                       'as'   => 'api.form.flow.list',
                       'uses' => 'API\FormFlowController@listist'
                   ]
        );
        //取得流程內容
        Route::post(
            '/get', [
                      'as'   => 'api.form.flow.get',
                      'uses' => 'API\FormFlowController@get'
                  ]
        );
        //新增流程
        Route::post(
            '/add', [
                      'as'   => 'api.form.flow.add',
                      'uses' => 'API\FormFlowController@add'
                  ]
        );
        //編輯流程
        Route::post(
            '/edit', [
                       'as'   => 'api.form.flow.edit',
                       'uses' => 'API\FormFlowController@edit'
                   ]
        );
        //批量儲存
        Route::post(
            '/saveAll', [
                          'as'   => 'api.form.flow.saveAll',
                          'uses' => 'API\FormFlowController@saveAll'
                      ]
        );
        //刪除流程
        Route::post(
            '/delete', [
                         'as'   => 'api.form.flow.delete',
                         'uses' => 'API\FormFlowController@delete'
                     ]
        );
    }
    );
    /**
     * ===================================================================
     */

    /**
     * 系統處理相關 =====================================================
     */

    Route::group(
        [ 'middleware' => 'auth:api' ], function () {
        //系統登出
        Route::post(
            '/system/logout', [
                                'as'   => 'api.system.logout',
                                'uses' => 'API\SystemController@logout'
                            ]
        );
        //檔案上傳
        Route::post(
            '/system/upload', [
                                'as'   => 'api.system.upload',
                                'uses' => 'API\SystemController@upload'
                            ]
        );
        //系統訊息列表
        Route::post(
            '/system/message/list', [
                                      'as'   => 'api.system.message.list',
                                      'uses' => 'API\SystemController@messageList'
                                  ]
        );
        //取得系統訊息
        Route::post(
            '/system/message/get', [
                                     'as'   => 'api.system.message.get',
                                     'uses' => 'API\SystemController@messageGet'
                                 ]
        );
        //設定系統訊息已讀取
        Route::post(
            '/system/message/setRead', [
                                         'as'   => 'api.system.message.setRead',
                                         'uses' => 'API\SystemController@messageSetRead'
                                     ]
        );
        //設定所有系統訊息已讀取
        Route::post(
            '/system/message/setReadAll', [
                                            'as'   => 'api.system.message.setReadAll',
                                            'uses' => 'API\SystemController@messageSetReadAll'
                                        ]
        );
    }
    );

    /**
     * ===================================================================
     */

