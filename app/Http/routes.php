<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', function () {
    return view('welcome');
});


Route::any('get_return','CallBackController@index');


Route::auth();
Route::get('/home', 'HomeController@index');
Route::post('getMaterialList', 'CallBackController@getMaterialList');
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function() {
    Route::get('', ['as' => 'adminhome', function() {
        return redirect(url('admin/qRcodes'));
    }]);
    Route::resource('qRcodes','QRcodeController',['parameters'=>'singular']);
    Route::get('qRcodes/{qRcode}/download','QRcodeController@download');
    Route::resource('menus','MenuController',['parameters'=>'singular']);
    Route::get('getMenu','MenuController@getMenu');

    Route::resource('autoReplys','AutoReplyController',['parameters'=>'singular']);
    Route::resource('subscribeReplys','SubscribeReplyController',['parameters'=>'singular']);

});

Route::get('/checkFollow', 'TemporaryQRcodeController@index');
Route::get('/syncDataFromWechat', 'AutoReplyController@syncDataFromWechat');
Route::get('/callCRMApi', 'CallBackController@callCRMApi');
/*
Route::group(['middleware' => ['api'], 'prefix' => 'api'], function() {
    Route::any('get_return','CallBackController@index');
});
*/
Route::get('getWechatToken', 'CallBackController@getWechatToken')->middleware('authbasic');


