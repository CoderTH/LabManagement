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

    /**
     * @author tangshengyou
     * 通过work_id 查找该用户的姓名
     */

    public static function tsy_select($work_id){
        try {
            $date = UserInfo::where('user_id',$work_id)->first();
           return $date;
        }catch(Exception $e){
            logger::Error('查找失败',[$e->getMessage()]);
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
            logger::ERROR('修改失败',[$e->getMessage()]);
        }
    }
}
