<?php


    use App\Http\Controllers\API\FormController;
	use App\Http\Controllers\API\SystemController;
	use Illuminate\Http\Client\Request;
	
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
            '/signature', 'pages.signature.setting', [
                            'breadcrumbs' => [
                                [ 'name' => "User" ],
                                [
                                    'link' => "signature",
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
