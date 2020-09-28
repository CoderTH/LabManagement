<?php
use App\Models\User;
use App\Models\ApprPermi;
use App\Models\ApprovalStatus;

if (!function_exists('get_permission')) {

    /**
     * 根据用户工号获取其权限
     * @param $id  work_id
     * @return int
     */
    function get_permission($id)
    {
        return User::getPermi($id);
    }
}

if (!function_exists('get_app_status')) {

    /**
     * 获取当前用户要处理的表单的状态
     * @param $id  work_id
     * @return int
     */
    function get_app_status($id)
    {
        $permi = User::getPermi($id);
        return ApprPermi::get_code($permi);
    }
}


if (!function_exists('getStream')) {

    /**
     * 获取审批流
     * @param $e  0为设备审批表 1为其他表
     * @return array
     */
    function getStream($e)
    {
        return ApprovalStatus::getStream($e);
    }
}
