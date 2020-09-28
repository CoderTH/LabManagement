<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;
    protected $primaryKey = "form_id";
    protected $guarded=[];

    /**
     * 将存入的实验室借用表的信息存入 form 表中
     * @author tangshengyou
     * @param $adc
     */
    public static function tsy_save($adc){
//        dd($adc);
        try {
            Form::create([
                'form_id'=>$adc['form_id'],
                'work_id'=>$adc['work_id'],
                'form_type_id'=>$adc['form_type_id']
            ]);
            return true;
        }catch (\Exception $e){
            logger::Error('填报失败',[$e->getMessage()]);
        }
    }

    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            Form::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
