<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = "equipment";
    public $timestamps = true;
    protected $primaryKey = "equipment_id";
    protected $guarded=[];
    /*
     * 获取设备信息
     */
    public static function dc_getInfo(){
        try {
            $rs = self::all();
            return $rs;
        }catch (\Exception $e){
            logError('获取设备信息失败',$e->getMessage());
            return null;
        }
    }
    public static function dc_addInfo($date){
        try {
            $rs = self::create([
                'equipment_name' =>$date['name'],
                'equipment_model' => $date['model'],
                'attachment'=> $date['attachment']
            ]);
           return $rs;
        }catch (\Exception $e){
            logError('添加设备信息失败',$e->getMessage());
            return null;
        }
    }

    public static function dc_getInfoByID($id){

        try {
            $rs = self::where('equipment_id',$id['id'])
                ->get();
            return $rs;
        }catch (\Exception $e){
            logError('获取设备信息失败',$e->getMessage());
            return null;
        }
    }
    public static function dc_modify($date){
        try {
            $rs = Equipment::where('equipment_id',$date['id'])
                ->update([
                    'equipment_name'=>$date['name'],
                    'equipment_model'=>$date['model'],
                    'attachment'=> $date['attachment']
                ]);
            return $rs;
        }catch (\Exception $e){
            logError('修改设备信息失败',$e->getMessage());
            return null;
        }
    }

    public static function dc_deleteByID($id){
        try {
            $rs = Equipment::where('equipment_id',$id['id'])
                ->delete();
            return $rs;
        }catch (\Exception $e){
            logError('删除设备信息失败',$e->getMessage());
            return null;
        }
    }

    public static function dc_getInfoByName($name){
        try {
            $name['name']?
            $rs = self::where('equipment_name','like','%'.$name['name'].'%')
                ->get():
            $rs = self::all();
            return $rs;



        }catch (\Exception $e){
            logError('搜索设备信息失败',$e->getMessage());
            return null;
        }

    }
}
