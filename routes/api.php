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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace'=>'OrdinAdmin','prefix'=>'ordinadmin'],function (){
    //填报实验室借用
   Route::post('addlabborrowing','DealFormController@addLabBorrowing');
   //填报期末检查表
   Route::post('addfinallab','DealFormController@addFinalLab');
   //填报开放实验室申请
   Route::post('addopenlab','DealFormController@addOpenLab');
   //填报仪器借用表
   Route::post('addequipment','DealFormController@addEquipment');
});

Route::group(['namespace'=>'UserInfo','prefix'=>'userinfo'],function (){
    //获取新老邮箱发送邮件
    Route::post('emailfs','UserController@emailFS');

//用户点击链接进行验证
    Route::get('emailcheck','UserController@emailCheck');
});

