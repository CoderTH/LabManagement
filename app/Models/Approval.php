<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpKernel\Log\Logger;

class Approval extends Model
{
    protected $table = "approval";
    public $timestamps = true;
    protected $primaryKey = "approval_id";
    protected $guarded=[];

    /**
     * 表单填报后将表单插入审批列表中
     * @author tangshengyou
     */
    public static function tsy_save($form_id){
        try{
            Approval::create([
                'form_id'=>$form_id,
                'status'=>1
            ]);
            return true;
        }catch(Exception $e){
            logger::Error('插入失败'.[$e->getMessage()]);
        }
    }

    /**
     * 当三个表中插入失败时当前表如果被插入成功的 将其删除
     * @author tangshengyou
     */
    public static function tsy_delete($form_id){
        try{
            Approval::where('form_id',$form_id);
        }catch(Exception $e){
            logger::Error('删除失败',[$e->getMessage()]);
        }
    }
}
