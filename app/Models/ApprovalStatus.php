<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalStatus extends Model
{
    protected $table = "approval_status";
    public $timestamps = true;
    protected $primaryKey = "id";

    /**
     * 获取审批流
     * @author Liangjianhua <github.com/Varsion>
     * @param [boolen]] $e 是否是设备借用申请表
     * @return array
     */
    public static function getStream($e) {
        try {
            if($e){
                //非设备借用申请表
                $res = self::select('id as approval_id','status')
                            ->whereIn('id',[1,3,5,11])
                            ->get();
            } else {
                $res = self::select('id as approval_id','status')
                            ->whereIn('id',[1,3,5,7,9,11])
                            ->get();
            }

            return $res;
        } catch(Exception $e){
            logError('状态流获取失败',[$e->getMessage()]);
        }
    }
}
