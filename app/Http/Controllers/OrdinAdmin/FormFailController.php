<?php

namespace App\Http\Controllers\OrdinAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\OrdinAdmin\GetFormListRequest;
use App\Http\Requests\OrdinAdmin\GetFormInfoRequest;
use App\Http\Requests\OrdinAdmin\SearchFormBySrcRequest;

use App\Models\Approval;
use App\Models\Form;
use App\Models\LabBorrowing;
use App\Models\OpenLaboratory;

class FormFailController extends Controller
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

        try {
            $class = $request['class_id'];
            //$work_id = auth('api')->user()->work_id;
            $work_id = '123123';
            $res = Form::FailFormList($work_id,$class);

           return $res ?
           \json_success('表单列表获取成功',$res,'200') :
           \json_fail('该表单列表获取失败',null,'100');

        } catch(Exception $e){
            logError('FormFailController\getFormList接口调用失败',[$e->getMessage()]);
        }
    }

    /**
     * 获取失败表单详情
     * @author Liangjianhua <github.com/Varsion>
     * @param GetFormInfoRequest $request
     *      ['form_id'] => 表单编号
     * @return void
     */
    public function getFailFormInfo(GetFormInfoRequest $request) {
                        	    header("Access-Control-Allow-Origin: *");

        $form_id = $request['form_id'];
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
        return $res ?
                \json_success('表单'.$form_id.'信息查询成功',$res,'200') :
                \json_fail('表单'.$form_id.'信息查询失败',null,'100');
    }

    /**
     * 根据参数模糊搜索表单
     * @author Liangjianhua <github.com/Varsion>
     * @param SearchFormBySrcRequest $requesut
     *      ['value'] => 表单编号
     * @return json
     */
    public function searchFormBySrc(SearchFormBySrcRequest $request) {
                        	    header("Access-Control-Allow-Origin: *");

        //$work_id = auth('api')->user()->work_id;
        $work_id = '123123';
        $value = $request['value'];
        $res = Form::SearchFormFail($work_id,$value);

        return  $res ?
                \json_success('参数'.$value.'查询成功',$res,'200') :
                \json_fail('没有查到与'.$value.'相关的记录',null,'100');
    }



}
