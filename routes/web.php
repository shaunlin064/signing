<?php


    use App\Http\Controllers\API\FormController;

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
    Route::get(
        '/test', function () {
        //    api/form/depend
        $api  = new FormController();
        $data = newRequest(
            [
                'form_id'         => 5,
                'apply_member_id' => 157
            ]
        );
        $api->depend($data);
    }
    );
    Route::get(
        '/check', function () {
        //    api/form/depend
        $api  = new FormController();
        $data = newRequest(
            [
                'member_id' => 157,
                'id'        => 1,
                'status'    => 2
            ]
        );
        $api->check($data);
    }
    );

    Route::get(
        '/depend', function () {
        //    api/form/depend
        $api  = new FormController();
        $data = newRequest(
            [
                'member_id' => 157,
                'form_id'   => 5
            ]
        );
        $api->depend($data);
    }
    );
    Route::get(
        '/apply', function () {
        $api  = new FormController();
        $data = newRequest(
            [
                'member_id' => 157,
                'form_id'   => 5
            ]
        );
        dd($api->checkList($data));
    });
    Route::group([
                     'middleware' => ['apiCheck']
                 ], function() {
//        Route::get(
//            '/apply', function () {
//            dd(
//                session()->all(), Cache::store('memcached')->get('login_user_log'), $_SERVER['REMOTE_ADDR'],
//                $localIP = getHostByName(getHostName())
//            );
//
//
//            $data = [
//                'apply_attachment'    => "[]",
//                'apply_department_id' => "41",
//                'apply_member_id'     => "157",
//                'apply_subject'       => "test",
//                'form_id'             => "6",
//                'form_pair_data_id'   => "1",
//                'items'               => [
//                    'id'               => "0",
//                    'meet_type'        => "1",
//                    'agenda'           => "1",
//                    'charge_user'      => "157",
//                    'customer_company' => "1",
//                    'customer_name'    => "1",
//                    'date'             => "2020-05-07",
//                    'fee_items'        => '{"0":{"id":"0","type":"交通","currency":"TWD","fee":"3"}}',
//                ],
//            ];
//            $api  = new FormController();
//            $data = newRequest(
//                $data
//            );
//            $api->apply($data);
//
//        }
//        );
    });
    // Route Authentication Pages
    Route::get('/login', 'AuthenticationController@view')->name('login');
    Route::post('/remoteLogin', 'AuthenticationController@login')->name('remoteLogin');
    Route::get('/keyAccessLogin', 'AuthenticationController@keyAccessLogin')->name('keyAccessLogin');

    Route::group(
        [ 'middleware' => [ 'checkLogin' ] ], function () {
        Route::view(
            '/', 'pages.customer.form-list', [
                   'breadcrumbs' => [
                       [ 'name' => "User" ],
                       [
                           'link' => "form-list",
                           'name' => "簽核狀態"
                       ]
                   ]
               ]
        )->name('index');
        //  User
        Route::view(
            '/form-new', 'pages.customer.form-new', [
                           'breadcrumbs' => [
                               [ 'name' => "User" ],
                               [
                                   'link' => "form-new",
                                   'name' => "申請簽核"
                               ]
                           ]
                       ]
        );
        Route::view(
            '/form-list', 'pages.customer.form-list', [
                            'breadcrumbs' => [
                                [ 'name' => "User" ],
                                [
                                    'link' => "form-list",
                                    'name' => "簽核狀態"
                                ]
                            ]
                        ]
        );
        Route::view(
            '/signature', 'pages.customer.signatrue', [
                            'breadcrumbs' => [
                                [ 'name' => "User" ],
                                [
                                    'link' => "form-list",
                                    'name' => "設定簽名檔"
                                ]
                            ]
                        ]
        );

        //  Signinger
        Route::view(
            '/form-pending', 'pages.customer.form-pending', [
                               'breadcrumbs' => [
                                   [ 'name' => "Signinger" ],
                                   [
                                       'link' => "form-new",
                                       'name' => "待審簽核"
                                   ]
                               ]
                           ]
        );
        Route::view(
            '/form-all', 'pages.customer.form-all', [
                           'breadcrumbs' => [
                               [ 'name' => "Signinger" ],
                               [
                                   'link' => "form-new",
                                   'name' => "所有簽核"
                               ]
                           ]
                       ]
        );

        //  Executor
        Route::view(
            '/form-action', 'pages.customer.form-action', [
                              'breadcrumbs' => [
                                  [ 'name' => "Executor" ],
                                  [
                                      'link' => "form-new",
                                      'name' => "待執行簽核"
                                  ]
                              ]
                          ]
        );
        Route::view(
            '/form-allAction', 'pages.customer.form-allAction', [
                                 'breadcrumbs' => [
                                     [ 'name' => "Executor" ],
                                     [
                                         'link' => "form-new",
                                         'name' => "所有已執行簽核"
                                     ]
                                 ]
                             ]
        );

        //    form Edit
        Route::view(
            '/form-edit', 'pages.customer.form-edit', [
                            'breadcrumbs' => [
                                [ 'name' => "User" ],
                                [
                                    'link' => "form-edit",
                                    'name' => "簽核檢視"
                                ]
                            ]
                        ]
        )->name('form-edit');
    }
    );
    /*error*/
    Route::any(
        '/404', function () {
        abort(404);
    }
    );
    Route::any(
        '/500', function () {
        abort(500);
    }
    );


    //    Auth::routes();

    //    Route::post('/login/validate', 'Auth\LoginController@validate_api');

    //Session Handle
    Route::post(
        '/session/put', [
                          'as'   => 'session.put',
                          'uses' => 'SessionController@put'
                      ]
    );
    Route::post(
        '/session/get', [
                          'as'   => 'session.get',
                          'uses' => 'SessionController@get'
                      ]
    );
    Route::any(
        '/session/release', [
                              'as'   => 'session.release',
                              'uses' => 'SessionController@release'
                          ]
    );
