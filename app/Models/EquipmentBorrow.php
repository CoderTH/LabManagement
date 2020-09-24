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
    protected $guarded=[];

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
            logger::Error('填报失败',[$e->getMessage()]);
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
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
