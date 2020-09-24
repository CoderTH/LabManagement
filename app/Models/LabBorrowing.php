<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class LabBorrowing extends Model
{
    protected $table = "lab_borrowing";
    public $timestamps = true;
    protected $primaryKey = "form_id";
    protected $guarded=[];

    /**
     * @author tangshengyou
     * 将填报的数据存入lab_borrowing表
     *
     */
    public static function tsy_save($adc){
//        dd($adc);
        try {
            LabBorrowing::create([
                'form_id'=>$adc['form_id'],
                'date'=>$adc['date'],
                'lab_name'=>$adc['lab_name'],
                'lab_id'=>$adc['lab_id'],
                'class_name'=>$adc['class_name'],
                'class'=>$adc['class'],
                'number'=>$adc['number'],
                'laboratory_purpose'=>$adc['laboratory_purpose'],
                'start_time'=>$adc['start_time'],
                'end_time'=>$adc['end_time'],
                'start_class'=>$adc['start_class'],
                'end_class'=>$adc['end_class'],
                'teacher_name'=>$adc['teacher_name'],
                'phone'=>$adc['phone']
            ]);
            return true;
        }catch (Exception $e){
            logger::Error('填报失败',[$e->getMessage()]);
        }
    }
    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            LabBorrowing::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
