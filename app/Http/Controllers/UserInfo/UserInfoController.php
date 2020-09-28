<?php

namespace App\Http\Controllers\UserInfo;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfo\UpdateUserPassRequest;
use App\Http\Requests\UserInfo\UpdateUserPhoneRequest;
use App\Models\User;
use App\Models\UserInfo;


class UserInfoController extends Controller
{

    /**
     * 个人信息页
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return json
     */
    Public function getUserInfo(){
        $data = User::getUserInfo();
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }
    /**
     * 修改用户电话信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param UpdateUserPhoneRequest $request
     *      ['word_id'] => 工号 ['phone'] => 状态
     * @return json
     */
    Public function updateUserPhone(UpdateUserPhoneRequest $request){
        $work_id = $request->input('work_id');
        $phone = $request->input('phone');
        $data = UserInfo::updateUserPhone($work_id,$phone);
        return $data?
            json_success('成功!',null,200) :
            json_fail('失败!',null,100);
    }
    /**
     * 修改用户密码信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param UpdateUserPassRequest $request
     *      ['word_id'] => 工号 ['password'] => 状态
     * @return json
     */
    Public function updateUserPass(UpdateUserPassRequest $request){
        $work_id = $request->input('work_id');
        $old_password = $request->input('old_password');
        $new_password = $request->input('new_password');
        $data = User::updateUserPass($work_id,$old_password,$new_password);
        return $data?
            json_success('成功!',null,200) :
            json_fail('失败!',null,100);
    }
}
