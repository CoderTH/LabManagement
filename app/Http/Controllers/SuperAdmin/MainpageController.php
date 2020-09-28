<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use Illuminate\Http\Request;

class MainpageController extends Controller
{
    /**
     * 获取开发实验室使用申请通过和未通过的数量
     */
    public function getFormOpenNum(){
         $rs = Approval::dc_getOpenNum();
         $rs = ['yes' => $rs[0],'no'=>$rs[1]];
        return $rs ?
         json_success('成功',$rs,200):
         json_fail('失败',null,100);

    }

    /**
     * 获取实验教学检查表通过和未通过的数量
     */
    public function getFormCheckNum(){
        $rs = Approval::dc_getCheckNum();
        $rs = ['yes' => $rs[0],'no'=>$rs[1]];
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);

    }

    /**
     * 获取实验室借用申请表通过和未通过的数量
     */
    public function getFormLendNum(){
        $rs = Approval::dc_getLendNum();
        $rs = ['yes' => $rs[0],'no'=>$rs[1]];
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }
    /**
     * 获取实验仪器设备借用表通过和未通过的数量
     */
    public function getFormInstrumentNum(){
        $rs = Approval::dc_InstrumentNum();
        $rs = ['yes' => $rs[0],'no'=>$rs[1]];
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }

    /**
     * 获取实验室运行记录通过和未通过的数量
     */
    public function getFormRunNum(){
        $rs = Approval::dc_getRunNum();
        $rs = ['yes' => $rs[0],'no'=>$rs[1]];
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }
}
