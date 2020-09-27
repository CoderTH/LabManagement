<?php

namespace App\Http\Controllers\OrdinAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\OrdinAdmin\GetFormListRequest;
use App\Http\Requests\OrdinAdmin\GetFormInfoRequest;
use App\Http\Requests\OrdinAdmin\SearchFormBySrcRequest;

use App\Models\Form;
use App\Models\LabBorrowing;
use App\Models\EquipmentBorrow;
use App\Models\OpenLaboratory;

class FormSucController extends Controller
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
        $class = $request['class_id'];
        $work_id = '10086';
            //$work_id = auth('api')->user()->work_id;
        $res = Form::getSucFormList($class,$work_id);


        return $res ?
                \json_success('表单列表查询成功',$res,'200') :
                \json_fail('该表单列表查询失败',null,'100');
    }

    /**
     * 获取成功表单详情
     * @author Liangjianhua <github.com/Varsion>
     * @param GetFormInfoRequest $request
     *      ['form_id'] => 表单编号
     * @return void
     */
    public function getSucFormInfo(GetFormInfoRequest $request) {
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
     *      ['value'] => 表单编号
     * @return json
     */
    public function searchFormBySrc(SearchFormBySrcRequest $request) {
        $value = $request['value'];
        $work_id = '10086';
            //$work_id = auth('api')->user()->work_id
        $res = Form::SearchFormView($work_id,$value);

        return $res ?
                \json_success('参数'.$value.'搜索成功',$res,'200') :
                \json_fail('参数'.$value.'搜索失败',null,'100');
    }


}
