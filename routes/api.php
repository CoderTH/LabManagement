<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('stuadmin')->namespace('StuAdmin')->group(function (){

    Route::get('/insert','StuLeaderController@insert');
    Route::get('/getall','StuLeaderController@getAll');
    Route::get('/getbyid','StuLeaderController@getById');
    Route::get('/getupdateinfo','StuLeaderController@getUpdateInfo');
    Route::get('/update','StuLeaderController@update');
    Route::get('/index','StuLeaderController@index');

});



/**
 * @author HuWeiChen <github.com/nathaniel-kk>
 */
Route::prefix('superadmin')->namespace('SuperAdmin')->group(function () {
    Route::get('adminselectinfo', 'AuthAssController@adminSelectInfo'); //权限分配页面展示
    Route::post('adminnewacc', 'AuthAssController@adminNewAcc'); //管理员新增账号
    Route::get('adminseaechacc', 'AuthAssController@adminSeaechAcc'); //管理员搜索姓名
    Route::post('adminmodifyinfo', 'AuthAssController@adminModifyInfo'); //管理员修改账号信息
    Route::post('admindisinfo', 'AuthAssController@adminDisInfo'); //管理员禁用账号信息
    Route::get('studentselectinfo', 'AuthAssController@studentSelectInfo'); //学生负责人页面展示
    Route::post('studentnewacc', 'AuthAssController@studentNewAcc'); //学生负责人新增账号
    Route::get('studentseaechacc', 'AuthAssController@studentSeaechAcc'); //学生负责人搜索姓名
    Route::post('studentdisinfo', 'AuthAssController@studentDisInfo'); //学生负责人禁用账号信息
});

/**
 * @author HuWeiChen <github.com/nathaniel-kk>
 */
Route::prefix('userinfo')->namespace('UserInfo')->group(function () {
    Route::get('getuserinfo', 'UserInfoController@getUserInfo'); //权限分配页面展示
    Route::post('updateuserphone', 'UserInfoController@updateUserPhone'); //管理员新增账号
    Route::post('updateuserpass', 'UserInfoController@updateUserPass'); //管理员修改账号信息
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
        Route::get('cancel','FormViewController@cancelApp');
});

Route::prefix('oAuth/sAdmin')->namespace('OAuth\SAdmin')->group(function () {
    Route::post('login', 'AuthController@login'); //登陆
    Route::post('logout', 'AuthController@logout'); //退出登陆
    Route::post('refresh', 'AuthController@refresh'); //刷新token
});
Route::prefix('oAuth/admin')->namespace('OAuth\Admin')->group(function () {
    Route::post('login', 'AuthController@login'); //登陆
    Route::post('logout', 'AuthController@logout'); //退出登陆
    Route::post('refresh', 'AuthController@refresh'); //刷新token
});
Route::prefix('oAuth/user')->namespace('OAuth\User')->group(function () {
    Route::post('login', 'AuthController@login'); //登陆
    Route::post('logout', 'AuthController@logout'); //退出登陆
    Route::post('refresh', 'AuthController@refresh'); //刷新token
});





