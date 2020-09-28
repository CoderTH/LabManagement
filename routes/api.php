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

Route::prefix('stuadmin')->namespace('StuAdmin')->group(function (){

    Route::get('/insert','StuLeaderController@insert');
    Route::get('/getall','StuLeaderController@getAll');
    Route::get('/getbyid','StuLeaderController@getById');
    Route::get('/getupdateinfo','StuLeaderController@getUpdateInfo');
    Route::get('/update','StuLeaderController@update');
    Route::get('/index','StuLeaderController@index');

});

