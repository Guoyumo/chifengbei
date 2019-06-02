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


Route::group(['middleware' => ['web']], function () {
    // Route::get("inputInfo/{id}",'QRcodeController@inputInfo')->middleware('guest');
    Route::get("inputInfo/{id}",'QRcodeController@inputInfo');
    Route::get("changeQRcodeInfoList",'QRcodeController@changeQRcodeInfoList')->middleware('guest');
    Route::get("storeList","ShopController@index");
    Route::get("shop","ShopController@shop");
    Route::get("detail","ShopController@detail");

});



Route::get('/', function () {
    return view('welcome');
});


Route::get("signSuccess",function(){
    return view('signSuccess');
});
Route::any('get_return','CallBackController@index');


Route::auth();
Route::get('/home', 'HomeController@index');
Route::post('getMaterialList', 'CallBackController@getMaterialList');
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function() {
    Route::get('', ['as' => 'adminhome', function() {
        return redirect(url('admin/qRcodes'));
    }]);
    Route::get('orders/finish','OrderController@finish');
    Route::post('stores/upload','StoreController@upload');
    Route::post('images/upload','ImageController@upload');
    Route::resource('qRcodes','QRcodeController',['parameters'=>'singular']);
    Route::resource('stores','StoreController',['parameters'=>'singular']);
    Route::resource('orders','OrderController',['parameters'=>'singular']); 
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
Route::post("inputCarOwnerInfo",'QRcodeController@updateCarOwnerInfo');


Route::post("createOrder", 'OrderController@createOrder');
Route::get("getStore", 'StoreController@getStore');
Route::get("getStoreDetail", 'StoreController@getStoreDetail');
Route::get("wxLogin",'CallBackController@wxLogin');



