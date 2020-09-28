<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;
    protected $guarded = [];

    public static function dc_getFrom($id){
        try {
            $rs = self::where('form_type_id',$id)
                ->select('form_id','created_at')
                ->get();
            return $rs;
        }catch (\Exception $e){
            logError('获取表单信息失败',$e->getMessage());
            return null;
        }

    }
    public static function dc_getFormByID($id){
        try {


            $id['id']?
                $rs = self::where('form_type_id',$id['type'])
                    ->where('form_id','like','%'.$id['id'].'%')
                    ->select('form_id','created_at')
                    ->get() :
                $rs = self::where('form_type_id',$id['type'])
                ->get();
            return $rs;
        }catch (\Exception $e){
            logError('搜索表单信息失败',$e->getMessage());
            return null;
        }
    }

}
