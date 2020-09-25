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

/**
 * @author Liangjianhua <github.com/Varsion>
 */
Route::prefix('ordinadmin')->namespace('OrdinAdmin')->group(
    function () {
        Route::get('indexdata','IndexController@getIndexData');
});

/**
 * @author Liangjianhua <github.com/Varsion>
 */
Route::prefix('ordinadmin/approval')->namespace('OrdinAdmin')->group(
    function () {
        Route::get('formlist','ApprovalController@getFormList');
        Route::get('forminfo','ApprovalController@getFormInfo');
        Route::get('search','ApprovalController@searchFormBySrc');
        Route::get('approval','ApprovalController@approveForm');

        Route::get('test','ApprovalController@test');
});

/**
 * @author Liangjianhua <github.com/Varsion>
 */
Route::prefix('ordinadmin/failform')->namespace('OrdinAdmin')->group(
    function () {
        Route::get('formlist','FormFailController@getFormList');
        Route::get('forminfo','FormFailController@getFailFormInfo');
        Route::get('search','ApprovalController@searchFormBySrc');
        Route::get('approval','ApprovalController@approveForm');

        Route::get('test','FormFailController@test');
});
