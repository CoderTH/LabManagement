<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class FinalLabTeach extends Model
{
    protected $table = "final_laboratory_teaching_inspection";
    public $timestamps = true;
    protected $primaryKey = "form_id";

    protected $guarded=[];

    /**
     * @author tangshengyou
     * 将填报的数据存入final_laboratory表
     */
    public static function tsy_save($adc){
        try {
            FinalLabTeach::create([
                'form_id'=>$adc['form_id'],
                'recorder_name'=>$adc['user_name'],
                'recorder_id'=>$adc['work_id'],
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
    public static function tsy_delete($work_id){
        try {
            FinalLabTeach::where('work_id',$work_id)->delete();
        }catch (Exception $e){
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
