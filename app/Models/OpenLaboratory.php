<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class OpenLaboratory extends Model
{
    protected $table = "open_laboratory";
    public $timestamps = true;
    protected $primaryKey = "form_id";

    protected $guarded=[];
    /**
     * @author tangshengyou
     * 将填报的数据插入开放实验室申请表中
     *
     */

    public static function tsy_save($abc){
        try {
            OpenLaboratory::create([
                'form_id'=>$abc['form_id'],
                'use_reason'=>$abc['use_reason'],
                'project_name'=>$abc['project_name'],
                'start_time'=>$abc['start_time'],
                'end_time'=>$abc['end_time'],
                'applicant_name'=>$abc['applicant_name'],
                'date'=>$abc['date']
            ]);
            return true;
        }catch (Exception $e){
            logger::Error('填报错误',[$e->getMessage()]);
        }
    }
    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            OpenLaboratory::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
