<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
