<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenLaboratory extends Model
{
    protected $table = "open_laboratory";
    public $timestamps = true;

    protected $guarded = [];

    public static function dc_getOpenForm($id){
        try {

            $rs = self::where('open_laboratory.form_id',$id['id'])
                ->Join('open_laboratory_student','open_laboratory_student.open_laboratory_id','=','open_laboratory.form_id')
                ->select('open_laboratory.use_reason','open_laboratory.project_name','open_laboratory.start_time','open_laboratory.end_time','open_laboratory_student.student_name','open_laboratory_student.student_id',
                    'open_laboratory_student.student_phone','open_laboratory_student.take_work','open_laboratory_student.applicant_name','open_laboratory_student.date')
                ->get();

            return $rs;
        }catch (\Exception $e){
            logError('获取开发实验室信息失败',$e->getMessage());
            return null;
        }
    }
}
