<?php

namespace App\Http\Controllers\OrdinAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormSucController extends Controller
{
    /**
     * 获取失败表单详情
     * @author Liangjianhua <github.com/Varsion>
     * @param SucFormInfoRequest $request
     *      ['form_id'] => 表单编号
     * @return json
     */
    public function getSucFormInfo(SucFormInfoRequest $request) {
        return $res;
    }
}
