<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

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



    /**
     * 将填报的借用设备信息插入equipment_borrow 表中
     * @author tangshengyou
     * $abc 传入所有参数
     */
    public static function tsy_save($abc){
        try {
            EquipmentBorrow::create([
                'form_id'=>$abc['form_id'],
                'department'=>$abc['department'],
                'useinfo'=>$abc['useinfo'],
                'start_time'=>$abc['start_time'],
                'expect_time'=>$abc['expect_time'],
                'borrow_name'=>$abc['borrow_name'],
                'phone'=>$abc['phone']
            ]);
            return true;
        }catch (Exception $e){
            LogError('填报失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            EquipmentBorrow::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            LogError('删除失败',[$e->getMessage()]);
        }
    }

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
            return null;
        }
    }

}
