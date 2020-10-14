<?php

namespace App\Http\Controllers\OrdinAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OrdinAdmin\GetFormListRequest;
use App\Http\Requests\OrdinAdmin\GetFormInfoRequest;
use App\Http\Requests\OrdinAdmin\SearchFormBySrcRequest;
use App\Http\Requests\OrdinAdmin\ApproveFormRequest;


use App\Models\Form;
use App\Models\LabBorrowing;
use App\Models\EquipmentBorrow;
use App\Models\OpenLaboratory;
use App\Models\Approval;
use App\Models\Reason;

class ApprovalController extends Controller
{

    /**
     * 根据表单种类获取表单列表
     * @author Liangjianhua <github.com/Varsion>
     * @param GetFormListRequest $requesut
     *      ['class_id']   => 表单类型编号
     *          [
     *              '0' => 全部表单
     *              '1' => 实验室借用申请表单
     *              '3' => 实验室仪器设备借用单
     *              '5' => 开放实验室使用申请单
     *          ]
     * @return json
     */
    public function getFormList(GetFormListRequest $request) {
                        	    header("Access-Control-Allow-Origin: *");

            $class = $request['class_id'];

            $work_id = '10086';
            //$work_id = auth('api')->user()->work_id;

            $res = Form::getApproFormList($work_id,$class);

           return $res?
           \json_success('表单列表查询成功',$res,'200') :
           \json_fail('表单列表获取失败',null,'100');
    }

    /**
     * 获取表单详情
     * @author Liangjianhua <github.com/Varsion>
     * @param GetFormInfoRequest $requesut
     *      ['form_id'] => 表单编号
     * @return json
     */
    public function getFormInfo(GetFormInfoRequest $requesut) {
                        	    header("Access-Control-Allow-Origin: *");

        $form_id = $requesut['form_id'];
        $type_id = Form::getFrom_Type($form_id);

        switch ($type_id) {
            case 1:
                $res = LabBorrowing::getFormInfo_l($form_id);
                break;
            case 3:
                $res = EquipmentBorrow::getFormInfo_l($form_id);
                break;
            case 5:
                $res = OpenLaboratory::getFormInfo_l($form_id);
                break;

            default:
               $res = null;
                break;
        }
        return  $res ?
           \json_success('查询成功',$res,'200') :
           \json_fail('表单'.$form_id.'信息查询失败',null,'100');
    }

    /**
     * 根据参数模糊搜索表单
     * @author Liangjianhua <github.com/Varsion>
     * @param SearchFormBySrcRequest $requesut
     *      ['value'] => 表单编号 或者 申请人
     * @return json
     */
    public function searchFormBySrc(SearchFormBySrcRequest $request) {
                        	    header("Access-Control-Allow-Origin: *");

        //$work_id = auth('api')->user()->work_id;
        $work_id = '10086';

        $value = $request['value'];
        $res = Form::SearchFormApp($work_id,$value);

        return  $res ?
        \json_success('参数'.$value.'查询成功',$res,'200') :
        \json_fail('没有查到与'.$value.'相关的记录',null,'100');
    }

    /**
     * 审批表单
     * @author Liangjianhua <github.com/Varsion>
     * @param ApproveFormRequest $requesut
     *      ['form_id]  => 表单id
     *      ['judge']   => 0不通过 或者 1通过
     *      ['message'] => 不通过的原因 通过的为空
     * @return json
     */
    public function approveForm(ApproveFormRequest $request) {
                        	    header("Access-Control-Allow-Origin: *");

        $form_id = $request['form_id'];

        if($request['judge']){
            $res = Approval::apprSuc($form_id);
        } else {
            if($request['message'] == null) {
                return \json_fail('未填写表单不通过的原因',null,'100');
            }

            $res = self::failMessage($request['message'],$form_id);

            if(!$res) {
                return \json_fail('表单'.$form_id.'不通过原因记录失败',null,'100');
            }
        }

        return $res ?
                \json_success('表单'.$form_id.'处理成功',null,'200') :
                \json_fail('表单'.$form_id.'处理失败',null,'100');
    }


    /**
     * 不通过原因
     * @author Liangjianhua <github.com/Varsion>
     * @param [String]    $mes 处理信息
     * @param [String] $id  表单编号
     * @return void
     */
    protected function failMessage($mes,$id) {
                        	    header("Access-Control-Allow-Origin: *");

        $app_id = Approval::apprFail($id);
        $res = Reason::failMes($app_id,$mes);
        return $res;
    }

}
