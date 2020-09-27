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
Route::prefix('ordinadmin/approval')->namespace('OrdinAdmin')->group(
    function () {
        Route::get('formlist','ApprovalController@getFormList');
        Route::get('forminfo','ApprovalController@getFormInfo');
        Route::get('search','ApprovalController@searchFormBySrc');
        Route::post('approval','ApprovalController@approveForm');
});

/**
 * @author Liangjianhua <github.com/Varsion>
 */
Route::prefix('ordinadmin/failform')->namespace('OrdinAdmin')->group(
    function () {
        Route::get('formlist','FormFailController@getFormList');
        Route::get('forminfo','FormFailController@getFailFormInfo');
        Route::get('search','FormFailController@searchFormBySrc');
});

/**
 * @author Liangjianhua <github.com/Varsion>
 */
Route::prefix('ordinadmin/sucform')->namespace('OrdinAdmin')->group(
    function () {
        Route::get('formlist','FormSucController@getFormList');
        Route::get('forminfo','FormSucController@getSucFormInfo');
        Route::get('search','FormSucController@searchFormBySrc');
});

/**
 * @author Liangjianhua <github.com/Varsion>
 */
Route::prefix('ordinadmin/viewform')->namespace('OrdinAdmin')->group(
    function () {
        Route::get('formlist','FormViewController@getFormList');
        Route::get('forminfo','FormViewController@getViewFormInfo');
        Route::get('search','FormViewController@searchFormBySrc');
        Route::get('cancelapp','FormViewController@cancelApp');
});
