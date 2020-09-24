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

    /**
     * 将对应的插入检查详情表中
     * @author tangshengyou
     * $abc 传入的参数
     */
    public static function tsy_save($abc){
        try {
            CheckInfo::create([
                'inspection_id'=>$abc['inspection_id'],
                'lab_id'=>$abc['lab_id'],
                'lab_name'=>$abc['lab_name'],
                 'class_name'=>$abc['class_name'],
                 'teacher_name'=>$abc['teacher_name'],
                  'teaching_operation'=>$abc['teaching_operation'],
                 'open_lab_operation'=>$abc['open_lab_operation'],
                    'note'=>$abc['note'],
            ]
            );
            return true;
        }catch (Exception $e){
            logger::Error('填报错误',[$e->getMessage()]);
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
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
