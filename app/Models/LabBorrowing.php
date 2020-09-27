<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabBorrowing extends Model
{
    protected $table = "lab_borrowing";
    public $timestamps = true;
    //protected $primaryKey = "form_id";

    /**
     * 获取表单的详情
     * @author Liangjianhua <github.com/Varsion>
     * @param [string] $form_id
     * @return void
     */
    public static function getFormInfo_l($form_id) {
        try {
            $app_info = self::join('approval as app','lab_borrowing.form_id','app.form_id')
                            ->join('approval_status as sta','app.status','sta.id')
                            ->join('reasons','app.approval_id','reasons.approval_id')
                            ->select('sta.id as status_id','sta.status','reasons.reason','app.updated_at')
                            ->where('lab_borrowing.form_id',$form_id)
                            ->get();

            $form_info = self::select('*')
                                ->where('form_id',$form_id)
                                ->get();

            $stream = getStream(1);

            $res = [
                "form_info"=>$form_info,
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
