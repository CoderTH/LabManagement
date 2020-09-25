<?php

namespace App\Http\Controllers\OrdinAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Http\Requests\OrdinAdmin\GetFormListRequest;


class IndexController extends Controller
{
    /**
     * 获取主页各种表单数量
     * @author Liangjianhua <github.com/Varsion>
     * @return json
     */
    public function getIndexData() {
        //$work_id = Auth()->user_id();
        $permi = \get_permission('10086');


        return $permi;
        // return $res->count() ?
        //     \json_success('查询成功',$res,'200') :
        //     \json_fail('查询失败',null,'100');
    }

    /**
     * 根据ID搜索表单
     * @author Liangjianhua <github.com/Varsion>
     * @param SearchByIDRequest $request
     *      ['form_id']    => 表单编号
     *      ['form_group'] => 表单分组
     * @return json
     */
    public function SearchFormByid(SearchByIDRequest $request) {

    }

}
