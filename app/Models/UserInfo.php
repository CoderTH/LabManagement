<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class UserInfo extends Model
{
    protected $table = "user_info";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];

    /**
     * @author tangshengyou
     * 通过work_id 查找该用户的姓名
     */

    public static function tsy_select($work_id){
        try {
//            var_dump((string)$work_id);
//            die();
            $date = UserInfo::where('user_id',$work_id)->first();
//            var_dump($date);
            return $date;
        }catch(Exception $e){
            LogError('查找失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * @author tangshengyou
     * 用于邮箱验证，发送邮件时保存新邮箱，用户点击验证后修改邮箱为新邮箱。
     */
    public static function tsy_update($work_id,$new_email){
        try{
            UserInfo::where('user_id',$work_id)->update([
                'email'=>$new_email
            ]);
            return true;
        }catch (Exception $e){
            LogError('修改失败',[$e->getMessage()]);
            return null;
        }
    }
      /**
     * 管理员新增账号
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int]$work_id,[String]$name,[int]$phone,[String]$email
     * @return array
     */
    Public static function adminNewAcc($work_id,$name,$phone,$email){
        try {
            $date = UserInfo::create([
                'user_id'=>$work_id,
                'name'=>$name,
                'phone'=>$phone,
                'email'=>$email,
            ]);
            return $date;
        } catch(\Exception $e){
            logError('新增用户信息错误',[$e->getMessage()]);
            return null;
        }
    }

      /**
     * 学生负责人新增账号
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int]$work_id,[String]$name,[int]$phone,[String]$email
     * @return array
     */
    Public static function studentNewAcc($work_id,$name,$phone,$email){
        try {
            $date = UserInfo::create([
                'user_id'=>$work_id,
                'name'=>$name,
                'phone'=>$phone,
                'email'=>$email,
            ]);
            return $date;
        } catch(\Exception $e){
            logError('新增用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 修改用户电话信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int] $work_id, $phone
     * @return array
     */
    Public static function updateUserPhone($work_id,$phone){
        try {
            $data = self::where('user_id',$work_id)
                ->update(['phone' => $phone]);
            return $data;
        } catch(\Exception $e){
            logError('修改用户信息错误',[$e->getMessage()]);
            return null;

        }
    }
}
