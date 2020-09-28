<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Exception;

class LabOperationRecord extends Model
{
    protected $table = "lab_operation_records";
    public $timestamps = true;

    protected $primaryKey = "form_id";

    public static function dc_getLabOperationInfo($id){
        try {
            $rs = self::where('form_id','$id')
                ->get();
            return $rs;
        }catch (\Exception $e){
            logError('获取设备借用表信息错误',$e->getMessage());
            return null;
        }
    }

    //protected $primaryKey = "form_id";


    public static function ysx_insert($info){
        try {
            $formid = 'D' . date("ymdis");
            //$workid = auth('api')->user()->id();
            $work_id=1;
            $weeks = $info['weeks'];//周次
            $created_at = $info['created_at'];//时间
            $profession_classes = $info['professional_classes'];//专业班级
            $student_name = $info['student_name'];//学生姓名
            $number = $info['number'];//人数
            $class_name = $info['class_name'];//课程名
            $class_type = $info['class_type'];//课程类型
            $teacher_name = $info['teacher_name'];//任课教师
            $device_run_condition = $info['device_run_condition'];//运行情况
            $note = $info['note'];//备注
            $data = [
                'form_id' => $formid,
                'work_id' => $work_id,
                'weeks' => $weeks,
                'created_at' => $created_at,
                'professional_classes' => $profession_classes,
                'student_name' => $student_name,
                'number' => $number,
                'class_name' => $class_name,
                'class_type' => $class_type,
                'teacher_name' => $teacher_name,
                'device_run_condition' => $device_run_condition,
                'note' => $note

            ];
            $res = self::insert($data);
            return $res;
        } catch (\Exception $e) {
            logError("表单插入异常",$e->getMessage());
            return null;
        }

        //echo $weeks;

    }

    public static function ysx_getAll($form_id){
        try {
            if($form_id==null){
                return self::select('form_id','teacher_name','class_name','created_at')->get();
            }else{
                return self::where('form_id','=',$form_id)->select('form_id','teacher_name','class_name','created_at')->get();
            }
        }catch (Exception $e){
            logError("查询表单错误",$e->getMessage());
            return  null;
        }


    }

    public static function ysx_getById($form_id){
        try {
            return self::where('form_id','=',$form_id)->select('*')->get();

        }catch (Exception $e) {
            logError("查询表单错误", $e->getMessage());
            return null;
        }


    }

    public static function ysx_update($info){
        try {
            $formid = $info['form_id'];//表单编号
            $weeks = $info['weeks'];//周次
            $created_at = $info['created_at'];//时间
            $profession_classes = $info['professional_classes'];//专业班级
            $student_name = $info['student_name'];//学生姓名
            $number = $info['number'];//人数
            $class_name = $info['class_name'];//课程名
            $class_type = $info['class_type'];//课程类型
            $teacher_name = $info['teacher_name'];//任课教师
            $device_run_condition = $info['device_run_condition'];//运行情况
            $note = $info['note'];//备注
            $data = [
                'weeks' => $weeks,
                'created_at' => $created_at,
                'professional_classes' => $profession_classes,
                'student_name' => $student_name,
                'number' => $number,
                'class_name' => $class_name,
                'class_type' => $class_type,
                'teacher_name' => $teacher_name,
                'device_run_condition' => $device_run_condition,
                'note' => $note
            ];
            //$res = self::update($data)->where('form_id','=',$formid);
            $res = self::where('form_id',$formid)->update($data);
            return $res;
        } catch (\Exception $e) {
            logError("修改表单异常",$e->getMessage());
            return null;
        }


    }



}
