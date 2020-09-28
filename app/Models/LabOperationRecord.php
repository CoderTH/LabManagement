<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabOperationRecord extends Model
{
    protected $table = "lab_operation_records";
    public $timestamps = true;
    protected $primaryKey = "form_id";

    public static function dc_getLabOperationInfo($id){
        try {
            $rs = self::where('form_id','$id')
                ->get();
            return $rs;
        }catch (\Exception $e){
            logError('获取设备借用表信息错误',$e->getMessage());
            return null;
        }
    }
}
