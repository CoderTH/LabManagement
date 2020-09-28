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
            return null;
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
            return null;
        }
    }


    /**
     * 取消申请
     * @author Liangjianhua <github.com/Varsion>
     * @param [type] $form_id
     * @return void
     */
    public static function cancelApp($form_id) {
        try{
            $changeStatus = self::where('form_id',$form_id)
                                ->update(['status' => 12]);

            $getApp = self::select('approval_id')
                            ->where('form_id',$form_id)
                            ->get();
            //var_dump($getApp);


            $appID = $getApp[0]->approval_id;


            $res = DB::insert('insert into reasons (approval_id, reason,created_at) values (?, ?, ?)', [$appID, '用户取消申请',now()]);

            return $res;
        } catch(Exception $e){
            logError('表单'.$form_id.'取消失败',[$e->getMessage()]);
            return null;
        }
    }
}
