<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $table = "reasons";
    public $timestamps = true;
    //protected $primaryKey = "approval_id";

    /**
     * 写入不通过原因
     * @author Liangjianhua <github.com/Varsion>
     * @param [int] $app_id
     * @param [String] $mes
     * @return void
     */
    public static function failMes($app_id,$mes) {
        try {
            if (self::where('approval_id', $app_id)->exists()) {
                $res = self::where('approval_id', $app_id)
                            ->update(['reason'=>$mes]);
            } else {
                $reson = new Reason;
                $reson->approval_id = $app_id;
                $reson->reason = $mes;
                $res = $reson ->save();
            }

            return $res;

        } catch(Exception $e){
            logError('插入或更新'.$form_id.'不通过信息失败',[$e->getMessage()]);
            return null;
        }
    }
}
