<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpKernel\Log\Logger;
use DB;


class Approval extends Model
{
    protected $table = "approval";
    public $timestamps = true;
    protected $primaryKey = "approval_id";

    protected $guarded = [];

    /**
     * 获取获取开发实验室使用申请通过和未通过的数量
     */
    public static function dc_getOpenNum(){
        try {
            $yes = self::where('form_id','like','E'.'%')
                ->where('status',11)
                ->count('approval_id');


            $no = self::where('form_id','like','E'.'%')
                ->where('status','!=',11)
                ->count('approval_id');
           return $Num = [$yes,$no];
        }catch (\Exception $e){
        logError('获取数量信息错误',$e->getMessage());
            return null;
        }


    }

    /**
     * 获取实验教学检查表通过和未通过的数量
     */
    public static function dc_getCheckNum(){

        try {
            $yes = self::where('form_id','like','B'.'%')
                ->where('status',11)
                ->count('approval_id');


            $no = self::where('form_id','like','B'.'%')
                ->where('status','!=',11)
                ->count('approval_id');
            return $Num = [$yes,$no];
        }catch (\Exception $e){
            logError('获取数量信息错误',$e->getMessage());
            return null;
        }

    }
    /**
     * 获取实验室借用申请表通过和未通过的数量
     */
    public static function dc_getLendNum(){
        try {
            $yes = self::where('form_id','like','A'.'%')
                ->where('status',11)
                ->count('approval_id');


            $no = self::where('form_id','like','A'.'%')
                ->where('status','!=',11)
                ->count('approval_id');
            return $Num = [$yes,$no];
        }catch (\Exception $e){
            logError('获取数量信息错误',$e->getMessage());

          }
      }


    /**
     * 表单填报后将表单插入审批列表中
     * @author tangshengyou
     */
    public static function tsy_save($form_id,$id){
        try{
            Approval::create([
                'form_id'=>$form_id,
                'status'=>$id
            ]);
            return true;
        }catch(Exception $e){
            LogError('插入失败'.[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 当三个表中插入失败时当前表如果被插入成功的 将其删除
     * @author tangshengyou
     */
    public static function tsy_delete($form_id){
        try{
            Approval::where('form_id',$form_id);
            return true;
        }catch(Exception $e){
            LogError('删除失败',[$e->getMessage()]);
            return null;
        }
    }

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

     * 获取实验仪器设备借用表通过和未通过的数量
     */
    public static function dc_InstrumentNum(){
        try {
            $yes = self::where('form_id','like','C'.'%')
                ->where('status',11)
                ->count('approval_id');


            $no = self::where('form_id','like','C'.'%')
                ->where('status','!=',11)
                ->count('approval_id');
            return $Num = [$yes,$no];
        }catch (\Exception $e){
            logError('获取数量信息错误',$e->getMessage());
            return null;
        }
    }
    /**
     * 获取实验室运行记录通过和未通过的数量
     */
    public static function dc_getRunNum(){
        try {
            $yes = self::where('form_id','like','D'.'%')
                ->where('status',11)
                ->count('approval_id');


            $no = self::where('form_id','like','D'.'%')
                ->where('status','!=',11)
                ->count('approval_id');
            return $Num = [$yes,$no];
        }catch (\Exception $e){
            logError('获取数量信息错误',$e->getMessage());
            return null;

        }
}
/***
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

