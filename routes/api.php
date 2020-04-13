<?php

use Illuminate\Http\Request;

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

Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('login', 'AuthController@login');
  Route::post('register', 'AuthController@register');

  Route::group([
    'middleware' => 'auth:api'
  ], function() {
      Route::get('logout', 'AuthController@logout');
      Route::get('user', 'AuthController@user');
  });

});


/**
 * 表單流程設定相關 ========================================================
 */
//流程列表
Route::post('/form/flow/list',
    [
        'as' => 'api.form.flow.list' ,
        'uses' => 'API\FormFlowController@listist'
    ]);
//取得流程內容
Route::post('/form/flow/get',
    [
        'as' => 'api.form.flow.get' ,
        'uses' => 'API\FormFlowController@get'
    ]);
//新增流程
Route::post('/form/flow/add',
    [
        'as' => 'api.form.flow.add' ,
        'uses' => 'API\FormFlowController@add'
    ]);
//編輯流程
Route::post('/form/flow/edit',
    [
        'as' => 'api.form.flow.edit' ,
        'uses' => 'API\FormFlowController@edit'
    ]);
//刪除流程
Route::post('/form/flow/delete',
    [
        'as' => 'api.form.flow.delete' ,
        'uses' => 'API\FormFlowController@delete'
    ]);

/**
 * ===================================================================
 */


/**
 * 表單申請 審核相關 =====================================================
 */
//送出申請表單
Route::post('/form/apply',
  [
    'as' => 'api.form.apply' ,
    'uses' => 'API\FormController@apply'
  ]);
//申請表單內容
Route::post('/form/get',
    [
        'as' => 'api.form.get' ,
        'uses' => 'API\FormController@get'
    ]);
//申請表單編輯
Route::post('/form/edit',
    [
        'as' => 'api.form.edit' ,
        'uses' => 'API\FormController@edit'
    ]);
//申請表單作廢
Route::post('/form/fail',
    [
        'as' => 'api.form.fail' ,
        'uses' => 'API\FormController@fail'
    ]);
//申請表單簽核
Route::post('/form/check',
    [
        'as' => 'api.form.check' ,
        'uses' => 'API\FormController@check'
    ]);
//待簽核列表
Route::post('/form/check/list',
    [
        'as' => 'api.form.check.list' ,
        'uses' => 'API\FormController@checkList'
    ]);
//送簽列表
Route::post('/form/user/list',
    [
        'as' => 'api.form.user.list' ,
        'uses' => 'API\FormController@userList'
    ]);
//已簽核/已執行列表
Route::post('/form/all',
    [
        'as' => 'api.form.all' ,
        'uses' => 'API\FormController@all'
    ]);

/**
 * ===================================================================
 */

/**
 * 系統處理相關 =====================================================
 */
//系統登入
Route::post('/system/login',
    [
        'as' => 'api.system.login' ,
        'uses' => 'API\SystemController@login'
    ]);
//系統登出
Route::post('/system/logout',
    [
        'as' => 'api.system.logout' ,
        'uses' => 'API\SystemController@logout'
    ]);
//檔案上傳
Route::post('/system/upload',
    [
        'as' => 'api.system.upload' ,
        'uses' => 'API\SystemController@upload'
    ]);
//系統訊息列表
Route::post('/system/message/list',
    [
        'as' => 'api.system.message.list' ,
        'uses' => 'API\SystemController@messageList'
    ]);
//取得系統訊息
Route::post('/system/message/get',
    [
        'as' => 'api.system.message.get' ,
        'uses' => 'API\SystemController@messageGet'
    ]);
//設定系統訊息已讀取
Route::post('/system/message/setRead',
    [
        'as' => 'api.system.message.setRead' ,
        'uses' => 'API\SystemController@messageSetRead'
    ]);

/**
 * ===================================================================
 */

