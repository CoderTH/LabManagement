<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\checkEquipmentFormRequest;
use App\Http\Requests\SuperAdmin\checkFinalFormRequest;
use App\Http\Requests\SuperAdmin\checkLab_operationFormRequest;
use App\Http\Requests\SuperAdmin\checkLabFormRequest;
use App\Http\Requests\SuperAdmin\checkOpenFormRequest;
use App\Http\Requests\SuperAdmin\getAllFromRequest;
use App\Http\Requests\SuperAdmin\selectFromByIDRequest;
use App\Models\Equipment;
use App\Models\EquipmentBorrow;
use App\Models\FinalLabTeach;
use App\Models\Form;
use App\Models\LabBorrowing;
use App\Models\LabOperationRecord;
use App\Models\OpenLaboratory;
use Illuminate\Http\Request;

class CheckFormController extends Controller
{
    /**
     * 获取对应类型的表单
     * @param getAllFromRequest $request
     * ['type'] => 表单类型编号
     */
    public function getAllform(getAllFromRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $id = $request->input('type');
        $rs = Form::dc_getFrom($id);
            return $rs ?
                json_success('成功',$rs,200):
                json_fail('失败',null,100);

    }


    /**
     * @param selectFromByIDRequest $request
     * @return \Illuminate\Http\JsonResponse
     * ['id'] => 表单编号
     * ['type'] => 表单类型编号
     */
    public function selectFormByID(selectFromByIDRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = Form::dc_getFormByID($request);
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }


    /**
     * 查看开放实验室表的详细信息
     * @param checkOpenFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     * ['id'] => 表单编号
     */
    public function checkOpenlform(checkOpenFormRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = OpenLaboratory::dc_getOpenForm($request);
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }

    /**
     * 查看设备借用表信息
     */
    public function checkEquipmentForm(checkEquipmentFormRequest $request){
        	    header("Access-Control-Allow-Origin: *");

            $rs = EquipmentBorrow::dc_getEquipmentInfo($request['id']);
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }

    /**
     * 查看期末检查表单信息
     */
    public function checkFinalForm(checkFinalFormRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = FinalLabTeach::dc_getFinal_laboratoryInfo($request['id']);
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }

    /**
     * 查看实验室借用表信息
     */
    public function checkLabForm(checkLabFormRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = LabBorrowing::dc_getLabBorrowingInfo($request['id']);
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);

    }

    /**
     * 查看实验室运行记录信息
     */
    public function  checkLab_operationForm(checkLab_operationFormRequest $request){
        	    header("Access-Control-Allow-Origin: *");

        $rs = LabOperationRecord::dc_getLabOperationInfo($request['id']);
        return $rs ?
            json_success('成功',$rs,200):
            json_fail('失败',null,100);
    }
}
