<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class FinalLabTeach extends Model
{
    protected $table = "final_laboratory_teaching_inspection";
    public $timestamps = true;
    protected $primaryKey = "form_id";


    public static function dc_getFinal_laboratoryInfo($id){
        try {
            $rs = self::where('final_laboratory_teaching_inspection.form_id',$id)
                ->Join('check_info','check_info.inspection_id','=','final_laboratory_teaching_inspection.form_id')
                ->select('final_laboratory_teaching_inspection.recorder_name','final_laboratory_teaching_inspection.recorder_id',
                    'check_info.lab_id','check_info.lab_name','check_info.class_name','check_info.teacher_name','check_info.teaching_operation','check_info.open_lab_operation','check_info.note')
                ->get();
            return $rs;
        }catch (\Exception $e){
            logError('获取设备借用表信息错误',$e->getMessage());
            return null;
        }
      }



    /**
     * @author tangshengyou
     * 将填报的数据存入final_laboratory表
     */
    public static function tsy_save($adc){
        try {
            FinalLabTeach::create([
                'form_id'=>$adc['form_id'],
                'recorder_name'=>$adc['user_name'],
                'recorder_id'=>$adc['work_id'],
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
            FinalLabTeach::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
