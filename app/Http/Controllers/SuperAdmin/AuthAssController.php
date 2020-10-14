<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\AdminDisInfoRequest;
use App\Http\Requests\SuperAdmin\AdminModifyInfoRequest;
use App\Http\Requests\SuperAdmin\AdminNewAccRequest;
use App\Http\Requests\SuperAdmin\AdminSeaechAccRequest;
use App\Http\Requests\SuperAdmin\StudentDisInfoRequest;
use App\Http\Requests\SuperAdmin\StudentNewAccRequest;
use App\Http\Requests\SuperAdmin\StudentSeaechAccRequest;
use App\Models\User;
use App\Models\UserInfo;

class AuthAssController extends Controller
{
    /**
     * 权限分配页面展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return json
     */
	Public function adminSelectInfo(){
	    header("Access-Control-Allow-Origin: *");
	    $data = User::adminSelectInfo();
	    return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 管理员新增账号
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param AdminNewAccRequest $request
     *  word_id	int	人员编号
     *  name	  string	人员姓名
     *  phone	int	联系电话
     *  email	string	邮箱
     *  permission_id	int	权限 (2：普通老师，3：借用部门负责人，4：实验室借用管理员，5：实验室中心主任，6：设备管理员，7：实验室教学检查记录员)
     *  status	int	状态 (0：禁用，1：启用)
     * @return json
     */
	Public function adminNewAcc(AdminNewAccRequest $request){
	    	    header("Access-Control-Allow-Origin: *");

        $work_id = $request->input('work_id');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $permission_id = $request->input('permission_id');
        $status = $request->input('status');
        $date = UserInfo::adminNewAcc($work_id,$name,$phone,$email);
        $data = User::adminNewAcc($work_id,$permission_id,$status);
        return $data&&$date?
            json_success('成功!',null,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 管理员搜索姓名页面展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param AdminSeaechAccRequest $request
     *      ['name'] => 用户姓名
     * @return Json
     */
    Public function adminSeaechAcc(AdminSeaechAccRequest $request){
        	    header("Access-Control-Allow-Origin: *");

	    $name = $request->input('name');
	    $data = User::adminSeaechAcc($name);
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 管理员修改账号权限信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param AdminModifyInfoRequest $request
     *      ['word_id'] => 工号 ['permission_id'] => 权限编号
     * @return Json
     */
    Public function adminModifyInfo(AdminModifyInfoRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $work_id = $request->input('work_id');
        $permission_id = $request->input('permission_id');
        $data = User::adminModifyInfo($work_id,$permission_id);
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 管理员禁用账号信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param AdminDisInfoRequest $request
     *      ['word_id'] => 工号 ['status'] => 状态
     * @return Json
     */
    Public function adminDisInfo(AdminDisInfoRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $work_id = $request->input('work_id');
        $status = $request->input('status');
        $data = User::adminDisInfo($work_id,$status);
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 学生负责人页面展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     */
    Public function studentSelectInfo(){
        	    header("Access-Control-Allow-Origin: *");

        $data = User::studentSelectInfo();
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 学生负责人新增账号
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param StudentNewAccRequest $request
     *  word_id	int	人员编号
     *  name	  string	人员姓名
     *  phone	int	联系电话
     *  email	string	邮箱
     */
    Public function studentNewAcc(StudentNewAccRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $work_id = $request->input('work_id');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $date = UserInfo::studentNewAcc($work_id,$name,$phone,$email);
        $data = User::studentNewAcc($work_id);
        return $data&&$date?
            json_success('成功!',null,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 学生负责人搜索姓名页面展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param StudentSeaechAccRequest $request
     *      ['name'] => 用户姓名
     * @return Json
     */
    Public function studentSeaechAcc(StudentSeaechAccRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $name = $request->input('name');
        $data = User::studentSeaechAcc($name);
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }

    /**
     * 学生负责人禁用账号信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param StudentDisInfoRequest $request
     *      ['word_id'] => 工号 ['status'] => 状态
     * @return Json
     */
    Public function studentDisInfo(StudentDisInfoRequest $request){
                	    header("Access-Control-Allow-Origin: *");

        $work_id = $request->input('work_id');
        $status = $request->input('status');
        $data = User::studentDisInfo($work_id,$status);
        return $data?
            json_success('成功!',$data,200) :
            json_fail('失败!',null,100);
    }
}
