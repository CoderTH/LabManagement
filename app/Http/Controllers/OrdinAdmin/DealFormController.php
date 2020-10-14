<?php

namespace App\Http\Controllers\OrdinAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrdinAdmin\FormIdRequest;
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
use Monolog\Handler\IFTTTHandler;

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
        header("Access-Control-Allow-Origin: *");
        $request['work_id']=auth('api')->user()->work_id;
        $request['form_id'] = 'A'.date("ymdis");
        $request['form_type_id'] = 1;
        $date=UserInfo::tsy_select($request['work_id']);
        $request['teacher_name']=$date['name'];
        $abc = $request;
        $res = LabBorrowing::tsy_save($abc);
        $res1 = Form::tsy_save($abc);
        $res2 = Approval::tsy_save($request['form_id'],1);
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
        header("Access-Control-Allow-Origin: *");
        $date1 = $request['finallan'];
        for ($i=0;$i<count($date1);$i++){
            $validator = Validator::make($date1[$i],[
                'lab_id'=>'required|max:18',
                'lab_name'=>'required|max:200',
                'class_name'=>'required',
                'teacher_name'=>'required',
                'teaching_operation'=>'required|max:200',
                'open_lab_operation'=>'required|max:200',
                'note'=>'required|max:200',
            ]);
            if ($validator->fails()){
                throw(new HttpResponseException(json_fail('参数错误!','null' , 422)));
            }
        }
        $request['work_id']=auth('api')->user()->work_id;

        if ($request['form_id']){
            Form::tsy_delete($request['form_id']);
            CheckInfo::tsy_delete($request['form_id']);
            FinalLabTeach::tsy_delete($request['form_id']);
        }else{
            $request['form_id'] = 'B'.date("ymdis");
        }
        $request['inspection_id']=$request['form_id'];
        $request['form_type_id']=2;
        $date=UserInfo::tsy_select($request['work_id']);
        $request['user_name']=$date['name'];
        $abc = $request;
        $res = FinalLabTeach::tsy_save($abc);
        $res1 =Form::tsy_save($abc);
        $res2 =CheckInfo::tsy_save($date1,$request['inspection_id']);
        $res3 = Approval::tsy_save($request['form_id'],9);
        if ($res==true && $res1 == true && $res2==true && $res3 == true){
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
    public function addOpenLab(OpenLabRequest $request){
        header("Access-Control-Allow-Origin: *");
        $date1 = $request['student'];
        for ($i=0;$i<count($date1);$i++){
            $validator = Validator::make($date1[$i],[
                'student_name'=>'required|max:18',
                'student_id'=>'required|max:200',
                'student_phone'=>'required|between:11,11',
                'take_work'=>'required|max:200'
            ]);
            if ($validator->fails()){
                throw(new HttpResponseException(json_fail('参数错误!','null' , 422)));
            }
        }
        $request['work_id']=auth('api')->user()->work_id;
        $date=UserInfo::tsy_select($request['work_id']);
        $request['applicant_name']=$date['name'];
        $request['form_id'] = 'E'.date("ymdis");
        $request['form_type_id']=5;
        $date = $request['student'];
        $res = Form::tsy_save($request);
        $res1 = OpenLaboratory::tsy_save($request);
        $res2 = OpenLabStudent::tsy_save($date,$request['form_id']);
        $res3 = Approval::tsy_save($request['form_id'],1);
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
        header("Access-Control-Allow-Origin: *");
        $date1 = $request['queipmentarray'];
        for ($i=0;$i<count($date1);$i++){
            $validator = Validator::make($date1[$i],[
                'equipment_name'=>'required|max:18',
                'equipment_model'=>'required|max:200',
                'number'=>'required|max:10',
                'attachment'=>'required|max:200'
            ]);
            if ($validator->fails()){
                throw(new HttpResponseException(json_fail('参数错误!','null' , 422)));
            }
        }
        $request['work_id']=auth('api')->user()->work_id;
        $request['form_id'] = 'C'.date("ymdis");
        $request['form_type_id']=3;
        $res=Form::tsy_save($request);
        $res1 = EquipmentBorrow::tsy_save($request);
        $res2 = EquipmentBorrowList::tsy_save($date1,$request['form_id']);
        $res3 = Approval::tsy_save($request['form_id'],1);
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

    /**
     * 返回所有的期末检测表
     * @return \Illuminate\Http\JsonResponse
     */
    public function allFinal(){
        header("Access-Control-Allow-Origin: *");
        $date =FinalLabTeach::tsy_select();
        for($i = 0;$i<count($date);$i++){
            $date[$i]['form_type_id']=2;
        }
        if ($date){
            return json_fail('成功',$date,200);
        }else{
            return json_fail('失败',null,100);
        }

    }
    /**
     * 返回对应form_id表单的数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function select(FormIdRequest $request){
        header("Access-Control-Allow-Origin: *");
        $date =FinalLabTeach::tsy_select_id($request['form_id']);
        for($i = 0;$i<count($date);$i++){
            $date[$i]['form_type_id']=2;
        }
        if ($date){
            return json_fail('成功',$date,200);
        }else{
            return json_fail('失败',null,100);
        }
    }

    /**
     * 返回指定id的表中的所有数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function lookfinal(FormIdRequest $request){
        header("Access-Control-Allow-Origin: *");
        $id = $request['form_id'];
        $rs = FinalLabTeach::tsy_lookFinal($id);
        $date = $rs;
        return $rs ?
            json_success('成功',$date,200):
            json_fail('失败',null,100);
    }


}
