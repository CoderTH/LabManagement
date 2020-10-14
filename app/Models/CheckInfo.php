<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class CheckInfo extends Model
{
    protected $table = "check_info";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded=[];

    public static function tsy_save($date,$id){
        try {

            for ($i=0;$i<count($date);$i++) {
                CheckInfo::create([
                        'inspection_id' => $id,
                        'lab_id' => $date[$i]['lab_id'],
                        'lab_name' =>$date[$i]['lab_name'],
                        'class_name' =>$date[$i]['class_name'],
                        'teacher_name' =>$date[$i]['teacher_name'],
                        'teaching_operation' =>$date[$i]['teaching_operation'],
                        'open_lab_operation' => $date[$i]['open_lab_operation'],
                        'note' =>$date[$i]['note'],
                    ]
                );
            }
            return true;
        }catch (Exception $e){
            LogError('填报错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($inspection_id){
        try {
            CheckInfo::where('inspection_id',$inspection_id)->delete();
        }catch (Exception $e){
            LogError('删除失败',[$e->getMessage()]);
            return null;
        }
    }
}
