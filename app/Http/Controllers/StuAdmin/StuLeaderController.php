<?php

namespace App\Http\Controllers\StuAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InsertRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\LabOperationRecord;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use PHPUnit\Framework\Warning;

class StuLeaderController extends Controller
{
   /* public function index(){
        echo 'E'.date("ymdis");
    }*/
    //
    public function insert(InsertRequest  $request)
    {
        $info = $request->all();
        $res = LabOperationRecord::ysx_insert($info);
        return $res==true?
            \json_success('插入成功',$res):
            \json_fail('插入失败',null);
    }
    public function getAll(Request $request)
    {
        $form_id = $request->input('form_id');
        $res = LabOperationRecord::ysx_getAll($form_id);
        return $res!=null?
            \json_success('获取成功',$res):
            \json_fail('获取失败',null);

    }

    public function getById(Request $request)
    {
        $form_id = $request->input('form_id');
        $res = LabOperationRecord::ysx_getById($form_id);
        return $res!=null?
            \json_success('获取成功',$res):
            \json_fail('获取失败',null);

    }

    public function getUpdateInfo(Request $request){
        $form_id = $request->input('form_id');
        $res=LabOperationRecord::ysx_getById($form_id);
        return $res!=null?
            \json_success('成功',$res):
            \json_fail('失败',null);
    }

    public function update(UpdateRequest $request){
        $info=$request->all();
        $res=LabOperationRecord::ysx_update($info);
        return $res!=null?
            \json_success('修改成功',$res):
            \json_fail('修改失败',null);

    }


}
