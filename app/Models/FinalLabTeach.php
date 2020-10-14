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
    protected $guarded = [];

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
//          //  var_dump($adc);
//            die($adc);
            FinalLabTeach::create([
                'form_id'=>$adc['form_id'],
                'recorder_name'=>$adc['user_name'],
                'recorder_id'=>$adc['work_id'],
            ]);
            return true;
        }catch (Exception $e){
            LogError('填报失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @author tangshengyou
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            FinalLabTeach::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            LogError('删除失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     *
     * @author tangshengyou
     * 获取所有的期末检查表 表ID 和创建时间
     * @author tangshengyou
     */
    public static function tsy_select(){
        try{
            $date = self::select("form_id","created_at")
                ->get();
            return $date;
        }catch (Exception $e){
            LogError('查找失败',[$e->getMessage()]);
            return null;
        }
    }

    public static function tsy_select_id($form_id){
        try{
            $date = self::where("form_id",$form_id)
                ->select("form_id","created_at")
                ->get();
            return $date;
        }catch (Exception $e){
            LogError('查找失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 查找指定form_id表的所有信息
     * @author tangshengyou
     * @param $id
     * @return |null
     */
    public static function tsy_lookFinal($id){

        try {
            $rs = self::where('final_laboratory_teaching_inspection.form_id',$id)
                ->Join('check_info','check_info.inspection_id','=','final_laboratory_teaching_inspection.form_id')
                ->select('check_info.lab_id','check_info.lab_name','check_info.class_name','check_info.teacher_name','check_info.teaching_operation','check_info.open_lab_operation','check_info.note')
                ->get();
            return $rs;
        }catch (\Exception $e){
            LogError('获取实验室记录表信息错误',$e->getMessage());
            return null;
        }
    }
}
