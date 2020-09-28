<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabBorrowing extends Model
{
    protected $table = "lab_borrowing";
    public $timestamps = true;
    protected $primaryKey = "form_id";

    public static function dc_getLabBorrowingInfo($id){
        try {
            $rs = self::where('lab_borrowing.form_id',$id)
                ->get();
            return $rs;

        }catch (\Exception $e){
            logError('获取设备借用表信息错误',$e->getMessage());
            return null;
        }
    }
}
