<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class EquipmentBorrowList extends Model
{
    protected $table = "equipment_borrow_list";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded=[];


    /**
     * 将借用的所有的设备填入设备借用表中
     * @author tangshengyou
     * $date (传入的是借用设备的数组)
     */
    public static function tsy_save($date,$id){
        try {
            for ($i=0;$i<count($date);$i++){
                EquipmentBorrowList::create([
                    'equipment_borrow_id'=>$id,
                    'equipment_name'=>$date[$i]['equipment_name'],
                    'equipment_model'=>$date[$i]['equipment_model'],
                    'number'=>$date[$i]['number'],
                    'attachment'=>$date[$i]['attachment'],
                ]);
            }
            return true;
        }catch (Exception $e){
            logger::Error('插入设备信息失败',[$e->getMessage()]);
        }
    }

    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($id){
        try {
            EquipmentBorrowList::where('equipment_borrow_id',$id)->delete();
        }catch (Exception $e){
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }

}
