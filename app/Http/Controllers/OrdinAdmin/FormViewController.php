<?php

namespace App\Http\Controllers\OrdinAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormViewController extends Controller
{
    /**
     * 获取待审批表单详情
     * @author Liangjianhua <github.com/Varsion>
     * @param ViewFormInfoRequest $request
     *      ['form_id'] => 表单编号
     * @return void
     */
    public function getViewFormInfo(ViewFormInfoRequest $request) {
        return $res;
    }

    /**
     * 获取表单审批情况
     * @author Liangjianhua <github.com/Varsion>
     * @param [type] $form_id
     * @return void
     */
    protected function getApprovalInfo($form_id) {

    }
}
