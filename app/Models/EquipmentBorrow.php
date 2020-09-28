<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentBorrow extends Model
{
    protected $table = "equipment_borrow";
    public $timestamps = true;
    protected $primaryKey = "form_id";
    protected $guarded = [];

    public static function dc_getEquipmentInfo($id){
        try {
            $rs = self::where('equipment_borrow.form_id',$id)
                ->Join('equipment_borrow_list','equipment_borrow_list.equipment_borrow_id','=','equipment_borrow.form_id')
                ->select('equipment_borrow.useinfo','equipment_borrow.department','equipment_borrow.start_time','equipment_borrow.expect_time','equipment_borrow.borrow_name','equipment_borrow.phone'
                ,'equipment_borrow_list.equipment_name','equipment_borrow_list.equipment_model','equipment_borrow_list.number','equipment_borrow_list.attachment')
                ->get();
            return $rs;

        }catch (\Exception $e){
            logError('获取设备借用表信息错误',$e->getMessage());
            return null;
        }
    }
}
