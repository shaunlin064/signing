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
    Route::any(
        '/output', function(){
        $signing = New \App\Http\Controllers\API\FormController();
        $signing = $signing->get(
            newRequest(
                [
                    'id'        => $_GET['id'],
//                    'member_id' => 157
                ]
            )
        )['data'];
        $config = config('form')[$signing['form_id']];
        if($signing['form_id'] === 6){
            $signing['column']['items'] = collect($signing['column']['items'])->values();
            $signing['fee_items_total'] = $signing['column']['items']->pluck('fee_items')->map(function($v,$k) use(&$signing){
                $signing['column']['items'][$k]['fee_items'] = json_decode($v,true);
                return json_decode($v,true);
            })->flatten(1);
        }
        $html = $config['html_name'];
        $pdf = PDF::loadView('pages.outPut.'.$html,['pdf' => true,'type'=>'payment','signing' => $signing,'config'=>$config]);
        return $pdf->stream('test.pdf');

    });
    Route::post('form/print','PrintController@print');
    Route::post('pdf','PrintController@pdf');

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

    Route::get('/test-formapply',function(){
       $data = json_decode('{"form_id":"6","apply_member_id":"157","apply_department_id":"41","apply_subject":"1","form_pair_data_id":"4","items":[{"id":"3","date":"2020-05-27","customer_name":"111","customer_company":"111","meet_type":"11","agenda":"11","charge_user":"157","fee_items":"\"{\\\"0\\\":{\\\"id\\\":\\\"0\\\",\\\"type\\\":\\\"交通\\\",\\\"currency\\\":\\\"TWD\\\",\\\"fee\\\":\\\"1\\\"},\\\"1\\\":{\\\"id\\\":\\\"1\\\",\\\"type\\\":\\\"交際\\\",\\\"currency\\\":\\\"TWD\\\",\\\"fee\\\":\\\"1\\\"},\\\"2\\\":{\\\"id\\\":\\\"2\\\",\\\"type\\\":\\\"漫遊\\\",\\\"currency\\\":\\\"TWD\\\",\\\"fee\\\":\\\"10\\\"},\\\"3\\\":{\\\"id\\\":\\\"3\\\",\\\"type\\\":\\\"其他\\\",\\\"currency\\\":\\\"TWD\\\",\\\"fee\\\":\\\"1\\\"}}\""},null,null,{"id":"3","date":"2020-05-27","customer_name":"111","customer_company":"111","meet_type":"11","agenda":"11","charge_user":"157","fee_items":"\"{\\\"0\\\":{\\\"id\\\":\\\"0\\\",\\\"type\\\":\\\"交通\\\",\\\"currency\\\":\\\"TWD\\\",\\\"fee\\\":\\\"1\\\"},\\\"1\\\":{\\\"id\\\":\\\"1\\\",\\\"type\\\":\\\"交際\\\",\\\"currency\\\":\\\"TWD\\\",\\\"fee\\\":\\\"1\\\"},\\\"2\\\":{\\\"id\\\":\\\"2\\\",\\\"type\\\":\\\"漫遊\\\",\\\"currency\\\":\\\"TWD\\\",\\\"fee\\\":\\\"10\\\"},\\\"3\\\":{\\\"id\\\":\\\"3\\\",\\\"type\\\":\\\"其他\\\",\\\"currency\\\":\\\"TWD\\\",\\\"fee\\\":\\\"1\\\"}}\""}],"remark":"","apply_attachment":"[]","created_at":"2020/5/27"}',true);
        $obj  = new \App\Http\Controllers\API\FormController();
        dd($data);
        $obj->apply(newRequest($data));
    });
    Route::get(
        '/test', function () {
        //    api/form/depend
        $obj  = new \App\Http\Controllers\API\FormFlowController();
        $data =
            json_decode(
                '{"1":{"id":1,"name":"表單驗證","form_id":1,"review_order":1,"review_type":1,"reviewer_id":106,"overwrite":0,"replace":0,"role":1,"replace_id":[],"component":"signatory"},"2":{"id":2,"name":"部級主管","form_id":1,"review_order":2,"review_type":2,"reviewer_id":1,"overwrite":1,"replace":0,"role":1,"replace_id":[],"component":"signatory"},"3":{"id":3,"name":"單位最高主管","form_id":1,"review_order":3,"review_type":2,"reviewer_id":3,"overwrite":1,"replace":0,"role":1,"replace_id":[],"component":"signatory"},"4":{"id":4,"name":"財務長","form_id":1,"review_order":4,"review_type":1,"reviewer_id":17,"overwrite":1,"replace":0,"role":1,"replace_id":[],"component":"signatory"},"5":{"id":5,"name":"執行長","form_id":1,"review_order":5,"review_type":1,"reviewer_id":15,"overwrite":0,"replace":0,"role":1,"replace_id":[],"component":"signatory"},"6":{"id":6,"name":"財務","form_id":1,"review_order":6,"review_type":1,"reviewer_id":202,"overwrite":0,"replace":1,"role":2,"replace_id":[63,178,203],"component":"signatory"}}',true)
        ;
        sort($data);
        dd($obj->saveAll(newRequest($data)));
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

        //    flow
        Route::prefix('system')->group(function () {
            Route::view(
                '/form-flow-setting', 'pages.system.form-flow-setting', [
                                               'breadcrumbs' => [
                                                   [ 'name' => "System" ],
                                                   [
                                                       'link' => "system-form-flow-setting",
                                                       'name' => "簽核關卡設定"
                                                   ]
                                               ],
                                               'pageConfigs' => [
                                                   'pageHeader'    => true,
                                                   'contentLayout' => "content-left-sidebar",
                                                   'bodyClass'     => 'todo-application',
                                               ]
                                           ]
            )->name('system.form-flow-setting');
        });
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
