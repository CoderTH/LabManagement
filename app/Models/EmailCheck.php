<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

/**
 * 临时存储邮箱
 * @author tangshengyou
 * Class EmailChick
 * @package App\Models
 */
class EmailCheck extends Model
{
    //
    protected $table = "email_check";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded=[];

    //将要修改邮箱的用户的id 和新邮箱email 插入表中
    public static function tsy_save($abc){
        try {
            EmailCheck::create([
                'work_id'=>$abc['work_id'],
                'email'=>$abc['new_email'],
                'date'=>$abc['time']
            ]);
            return true;
        }catch (Exception $e){
            logger::Error('插入失败',[$e->getMessage()]);
        }
    }
    //通过传入的workid 查找该用户的email
    public static function tsy_select($work_id){
        try {
            $date = EmailCheck::where('work_id',$work_id)->first();
//            $date = UserInfo::where('user_id',$work_id)->first();
//            dd($date);
            return $date;
        }catch (Exception $e){
            logger::Error('查找失败',[$e->getMessage()]);
        }
    }

    //使用完成后删除该条信息
    public static function tsy_delete($work_id){
        try {
            EmailCheck::where('work_id',$work_id)->delete();
            return true;
        }catch (Exception $e){
            logger::Error('删除失败',[$e->getMessage()]);
        }
    }

}
