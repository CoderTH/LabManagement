<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Approval extends Model
{
    protected $table = "approval";
    public $timestamps = true;
    protected $primaryKey = "approval_id";

    /**
     * 表单通过审批
     * @author Liangjianhua <github.com/Varsion>
     * @param [String] $form_id
     * @return void
     */
    public static function apprSuc($form_id) {
        try{
            $judge = self::where('form_id',$form_id)
                        ->increment('status',2);
            if($judge){
                $res = self::select('approval_id')
                                ->where('form_id',$form_id)
                                ->get();
                return $res[0]->approval_id;
            }
            return $judge;

        } catch(Exception $e){
            logError('更改成功表单'.$form_id.'状态时失败',[$e->getMessage()]);
        }
    }

    /**
     * 表单不通过审批
     * @author Liangjianhua <github.com/Varsion>
     * @param [String] $form_id
     * @return void
     */
    public static function apprFail($form_id) {
        try{

            $judge = self::where('form_id',$form_id)
                        ->increment('status');
            if($judge){
                $res = self::select('approval_id')
                                ->where('form_id',$form_id)
                                ->get();
                return $res[0]->approval_id;
            }
            return $judge;

        } catch(Exception $e){
            logError('更改失败表单'.$form_id.'状态时失败',[$e->getMessage()]);
        }
    }


    public static function test() {
        $res = DB::select('select * from approval where status%2 = 0');
        return $res;
    }
}
