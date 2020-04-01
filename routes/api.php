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
Route::post('/form/flow/list',
    [
        'as' => 'api.form.flow.list' ,
        'uses' => 'API\FormController@flowList'
    ]);
Route::post('/form/flow/get',
    [
        'as' => 'api.form.flow.get' ,
        'uses' => 'API\FormController@flowGet'
    ]);
Route::post('/form/flow/add',
    [
        'as' => 'api.form.flow.add' ,
        'uses' => 'API\FormController@flowAdd'
    ]);
Route::post('/form/flow/edit',
    [
        'as' => 'api.form.flow.edit' ,
        'uses' => 'API\FormController@flowEdit'
    ]);
Route::post('/form/flow/delete',
    [
        'as' => 'api.form.flow.delete' ,
        'uses' => 'API\FormController@flowDelete'
    ]);

/**
 * ===================================================================
 */


/**
 * 表單申請 審核相關 =====================================================
 */
Route::post('/form/apply',
  [
    'as' => 'api.form.apply' ,
    'uses' => 'API\FormController@apply'
  ]);

Route::post('/form/apply/fail',
    [
        'as' => 'api.form.apply.fail' ,
        'uses' => 'API\FormController@applyFail'
    ]);

Route::post('/form/apply/check',
    [
        'as' => 'api.form.apply.check' ,
        'uses' => 'API\FormController@applyCheck'
    ]);

/**
 * ===================================================================
 */

