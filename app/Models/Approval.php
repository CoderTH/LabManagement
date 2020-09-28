<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}

