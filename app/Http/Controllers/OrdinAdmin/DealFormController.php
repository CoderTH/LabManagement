<?php

namespace App\Http\Controllers\OrdinAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\OrdinAdmin\EquipmentRequest;
use App\Http\Requests\OrdinAdmin\FinalLabRequest;
use App\Http\Requests\OrdinAdmin\LabBorrowingRequest;
use App\Http\Requests\OrdinAdmin\OpenLabRequest;
use App\Models\Approval;
use App\Models\CheckInfo;
use App\Models\EquipmentBorrow;
use App\Models\EquipmentBorrowList;
use App\Models\FinalLabTeach;
use App\Models\LabBorrowing;
use App\Models\Form;
use App\Models\OpenLaboratory;
use App\Models\OpenLabStudent;
use App\Models\UserInfo;
use Illuminate\Http\Exceptions\HttpResponseException;
//use Illuminate\Support\Facades\Validator;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;

/**
 * 填报 开放实验室申请表
 * 填报设备借用表
 * 填报期末检查表
 * 填报实验室借用表
 * Class DealFormController
 * @author tangshengyou
 * @package App\Http\Controllers\OrdinAdmin
 */
class DealFormController extends Controller
{
    //填报实验室借用表
    public function addLabBorrowing(LabBorrowingRequest $request){

        $request['work_id']=auth('api')->id();
//        $request['work_id']=1;
        $request['form_id'] = 'A'.date("ymdis");
        $request['form_type_id'] = 1;
        $abc = $request;
        $res = LabBorrowing::tsy_save($abc);
        $res1 = Form::tsy_save($abc);
        $res2 = Approval::tsy_save($request['form_id']);
        if ($res==true && $res1 == true && $res2){
            return json_fail('成功',null,200);
        }else{
            if (!$res){
                LabBorrowing::tsy_delete($request['form_id']);
            }
            if (!$res1){
                Form::tsy_delete($request['form_id']);
            }
            if (!$res2){
                Approval::tsy_delete($request['form_id']);
            }
            return json_fail('失败',null,100);
        }
    }
    //填报期末检查表
    public function addFinalLab(FinalLabRequest $request){
        $request['work_id']=auth('api')->id();
//        $request['work_id']=123123;
        $request['form_id'] = 'B'.date("ymdis");
        $request['inspection_id']=$request['form_id'];
        $request['form_type_id']=2;
        $date=UserInfo::tsy_select($request['work_id']);
        $request['user_name']=$date['name'];

        $abc = $request;
        $res = FinalLabTeach::tsy_save($abc);
        $res1 =Form::tsy_save($abc);
        $res2 =CheckInfo::tsy_save($abc);
        $res3 = Approval::tsy_save($request['form_id']);
        if ($res==true && $res1 == true && $res2==true && $res3){
            return json_fail('成功',null,200);
        }else{
            if (!$res){
                FinalLabTeach::tsy_delete($request['form_id']);
            }
            if (!$res1){
                Form::tsy_delete($request['form_id']);
            }
            if (!$res2){
                CheckInfo::tsy_delete($request['form_id']);
            }
            if (!$res3){
                Approval::tsy_delete($request['form_id']);
            }
            return json_fail('失败',null,100);
        }
    }
    //填报开放实验室申请表
//OpenLab
    public function addOpenLab(OpenLabRequest $request){
//        dd($request);
        $date1 = $request['student'];
//        dd($date1);
        for ($i=0;$i<count($date1);$i++){
            $validator = Validator::make($date1[$i],[
//                dd($date1[$i]['student_name']),
                'student_name'=>'required|max:18',
                'student_id'=>'required|max:200',
                'student_phone'=>'required|between:11,11',
                'take_work'=>'required|max:200'
            ]);
//            dd($validator->fails());
            if ($validator->fails()){
                throw(new HttpResponseException(json_fail('参数错误!','null' , 422)));
            }
        }
        $request['work_id']=auth('api')->id();
//        $request['work_id']=123123;
        $request['form_id'] = 'E'.date("ymdis");
        $request['form_type_id']=5;
        $date = $request['student'];
        $res = Form::tsy_save($request);
        $res1 = OpenLaboratory::tsy_save($request);
        $res2 = OpenLabStudent::tsy_save($date,$request['form_id']);
        $res3 = Approval::tsy_save($request['form_id']);
        if ($res3==true && $res1 == true && $res2==true && $res){
            return json_fail('成功',null,200);
        }else{
            if (!$res){
                Form::tsy_delete($request['form_id']);
            }
            if (!$res1){
                OpenLaboratory::tsy_delete($request['form_id']);
            }
            if (!$res2){
                OpenLabStudent::tsy_delete($request['form_id']);
            }
            if (!$res3){
                Approval::tsy_delete($request['form_id']);
            }
            return json_fail('失败',null,100);
        }
    }
    //借用申请表
    public function addEquipment(EquipmentRequest $request){
        $date1 = $request['queipmentarray'];
//        var_dump($date1[1]['number']);
//        dd($date1);
        for ($i=0;$i<count($date1);$i++){
            $validator = Validator::make($date1[$i],[
                'equipment_name'=>'required|max:18',
                'equipment_model'=>'required|max:200',
                'number'=>'required|max:10',
                'attachment'=>'required|max:200'
//            'equipment_name'=>'required',
//                'equipment_model'=>'required',
//                'number'=>'required',
//                'attachment'=>'required'
            ]);
//            dd($validator->fails());
            if ($validator->fails()){
                throw(new HttpResponseException(json_fail('参数错误!','null' , 422)));
            }
        }
        $request['work_id']=auth('api')->id();
        $request['form_id'] = 'C'.date("ymdis");
//        $request['work_id']=123123;
        $request['form_type_id']=3;
        $res=Form::tsy_save($request);
        $res1 = EquipmentBorrow::tsy_save($request);
        $res2 = EquipmentBorrowList::tsy_save($date1,$request['form_id']);
        $res3 = Approval::tsy_save($request['form_id']);
        if ($res==true && $res1 == true && $res2==true && $res3){
            return json_fail('成功',null,200);
        }else{
            if (!$res){
                Form::tsy_delete($request['form_id']);
            }
            if (!$res1){
                EquipmentBorrow::tsy_delete($request['form_id']);
            }
            if (!$res2){
                EquipmentBorrowList::tsy_delete($request['form_id']);
            }
            if (!$res3){
                Approval::tsy_delete($request['form_id']);
            }
            return json_fail('失败',null,100);
        }
    }
}
