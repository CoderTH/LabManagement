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

Route::prefix('superadmin')->namespace('SuperAdmin')->group(function (){
    Route::get('getformopennum','MainpageController@getFormOpenNum');
    Route::get('getformchecknum','MainpageController@getFormCheckNum');
    Route::get('getformlendnum','MainpageController@getFormLendNum');
    Route::get('getforminstrumentnum','MainpageController@getFormInstrumentNum');
    Route::get('getformrunnum','MainpageController@getFormRunNum');

    Route::get('getequipmentinfo','EquipmentController@getEquipmentInfo');
    Route::post('addequipment','EquipmentController@addEquipment');
    Route::post('getinfobyid','EquipmentController@getInfoByID');
    Route::post('modify','EquipmentController@modify');
    Route::post('deleteequipment','EquipmentController@deleteEquipment');
    Route::post('getinfobyname','EquipmentController@getInfoByName');

    Route::get('getallform','CheckFormController@getAllform');
    Route::post('selectformbyid','CheckFormController@selectFormByID');
    Route::post('checkopenform','CheckFormController@checkOpenlform');
    Route::post('checkequipmentform','CheckFormController@checkEquipmentForm');
    Route::post('checkfinalform','CheckFormController@checkFinalForm');
    Route::post('checklabform','CheckFormController@checkLabForm');
    Route::post('checklab_operationform','CheckFormController@checkLab_operationForm');




});
