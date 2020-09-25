<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprPermi extends Model
{
    protected $table = "approval_permission";
    public $timestamps = false;

    /**
     * 根据权限编号获取需要处理的表单状态
     * @author Liangjianhua <github.com/Varsion>
     * @param [int] $permi
     * @return int
     */
    public static function get_code($permi) {
    try {
            $appcode = self::select('approval_id')
                            ->where('permission_id',$permi)
                            ->get();
            $res = $appcode[0]->approval_id;
            return $res;
        } catch(Exception $e){
            logError('权限审批状态对照失败',[$e->getMessage()]);
        }
    }
}
