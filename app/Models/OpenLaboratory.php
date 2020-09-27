<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpenLaboratory extends Model
{
    protected $table = "open_laboratory";
    public $timestamps = true;
    //protected $primaryKey = "form_id";

    /**
     * 获取审批失败表单的详情
     * @author Liangjianhua <github.com/Varsion>
     * @param [string] $form_id
     * @return void
     */
    public static function getFormInfo_l($form_id) {
        try {
            $app_info = self::join('approval as app','open_laboratory.form_id','app.form_id')
                            ->join('approval_status as sta','app.status','sta.id')
                            ->join('reasons','app.approval_id','reasons.approval_id')
                            ->select('sta.id as status_id','sta.status','reasons.reason','app.updated_at')
                            ->where('open_laboratory.form_id',$form_id)
                            ->get();

            $form_info = self::select('*')
                                ->where('form_id',$form_id)
                                ->get();

            $stream = getStream(1);
            $stu_list = self::join('open_laboratory_student as stu','open_laboratory.form_id','stu.open_laboratory_id')
                            ->select('stu.*')
                            ->get();

            $res = [
                "form_info"=>$form_info,
                "student_list" => $stu_list,
                "approval_info"=>$app_info,
                "approval_stream" => $stream
                    ];

            return $res;

        } catch(Exception $e){
            logError('失败表单:'.$form_id.'信息查询失败',[$e->getMessage()]);
            return null;
        }
    }
}
