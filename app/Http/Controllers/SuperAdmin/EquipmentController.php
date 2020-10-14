<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\addEquipmentRequest;
use App\Http\Requests\SuperAdmin\deleteEquipmentRequest;
use App\Http\Requests\SuperAdmin\getInfoByIDRequest;
use App\Http\Requests\SuperAdmin\getInfoByNameRequest;
use App\Http\Requests\SuperAdmin\ModifyRequest;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{

    /**
     *获取设备信息
     */
    public function getEquipmentInfo(){
       header("Access-Control-Allow-Origin: *");
       $date =  Equipment::dc_getInfo();
        return $date?
            json_success('成功',$date,200):
            json_fail('失败',null,100);
    }

    /**
     * 新增设备
     * @param addEquipmentRequest $request
     * ['name'] => 姓名，不为空是Srting
     * ['model'] => 设备型号，不为空是String
     * ['attachment'] => 附件，不为空是String
     */
    public function addEquipment(addEquipmentRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = Equipment::dc_addInfo($request);
        return $rs?
            json_success('成功',null,200):
            json_fail('失败',null,100);
    }

    /**
     * 修改的回显信息
     * @param getInfoByIDRequest $request
     * ['id']=>设备编号
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfoByID(getInfoByIDRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = Equipment::dc_getInfoByID($request);
        return $rs?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }

    /**
     * 设备修改信息
     * @param ModifyRequest $request
     * ['name'] => 姓名，不为空是Srting
     * ['model'] => 设备型号，不为空是String
     * ['attachment'] => 附件，不为空是String
     * ['id] => 设备编号
     */
    public function modify(ModifyRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = Equipment::dc_modify($request);
        return $rs ?
            json_success('成功',null,200):
            json_fail('失败',null,100);
    }


    /**
     * 删除设备
     * @param deleteEquipmentRequest $request
     * ['id'] => 设备编号
     */
    public function deleteEquipment(deleteEquipmentRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = Equipment::dc_deleteByID($request);
        return $rs ?
            json_success('成功',null,200):
            json_fail('失败',null,100);
    }


    /**
     * 搜索设备信息
     * @param getInfoByNameRequest $request
     * @return \Illuminate\Http\JsonResponse
     * ['name'] => 搜索的名字
     */
    public function getInfoByName(Request $request){
        	    header("Access-Control-Allow-Origin: *");

            $rs = Equipment::dc_getInfoByName($request);
                return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }
}
