<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentBorrow extends Model
{
    protected $table = "equipment_borrow";
    public $timestamps = true;
    //protected $primaryKey = "form_id";

    public static function getFormInfo_l($form_id) {
        try {
            //借用信息
            $borrow_info = self::select('*')
                                ->where('equipment_borrow.form_id',$form_id)
                                ->first();
            //设备列表
            $euqipment_list = self::join('equipment_borrow_list as list','equipment_borrow.form_id','list.equipment_borrow_id')
                                    ->select('list.*')
                                    ->where('equipment_borrow.form_id',$form_id)
                                    ->get();
            //审批信息
            $approval_info =  self::join('approval as app','equipment_borrow.form_id','app.form_id')
                                    ->join('approval_status as sta','app.status','sta.id')
                                    ->join('reasons','app.approval_id','reasons.approval_id')
                                    ->select('sta.id as status_id','sta.status','reasons.reason','app.updated_at')
                                    ->where('equipment_borrow.form_id',$form_id)
                                    ->get();

            //设备申请表专用审批流
            $stream = getStream(0);

            $res = [
                "borrow_info"=>$borrow_info,
                "euqipment_list"=>$euqipment_list,
                "approval_info" => $approval_info,
                "approval_stream" => $stream

                    ];
            return $res;

        } catch(Exception $e){
            logError('表单:'.$form_id.'详情查询失败',[$e->getMessage()]);
        }
    }

}
