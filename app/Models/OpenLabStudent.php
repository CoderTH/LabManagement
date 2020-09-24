<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class OpenLabStudent extends Model
{
    protected $table = "open_laboratory_student";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded=[];

    /**
     * 将填报的信息插入open_laboratory_student 表中
     * @author tangshengyou
     * 传入$abc
     */

    public static function tsy_save($abc,$id){
        try{
            for ($i = 0;$i<count($abc);$i++){
                OpenLabStudent::create([
                    'open_laboratory_id'=>$id,
                    'student_name'=>$abc[$i]['student_name'],
                    'student_id'=>$abc[$i]['student_id'],
                    'student_phone'=>$abc[$i]['student_phone'],
                    'take_work'=>$abc[$i]['take_work'],
                ]);
            }
            return true;
        }catch (Exception $e){
            logger::Error('填报学生信息失败',[$e->getMessage()]);
        }

    }
    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            OpenLabStudent::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
