<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class OpenLaboratory extends Model
{
    protected $table = "open_laboratory";
    public $timestamps = true;


    protected $guarded = [];

    public static function dc_getOpenForm($id){
        try {

            $rs = self::where('open_laboratory.form_id',$id['id'])
                ->Join('open_laboratory_student','open_laboratory_student.open_laboratory_id','=','open_laboratory.form_id')
                ->select('open_laboratory.use_reason','open_laboratory.project_name','open_laboratory.start_time','open_laboratory.end_time','open_laboratory_student.student_name','open_laboratory_student.student_id',
                    'open_laboratory_student.student_phone','open_laboratory_student.take_work','open_laboratory.applicant_name','open_laboratory_student.date')
                ->get();

            return $rs;
        }catch (\Exception $e){
            logError('获取开发实验室信息失败',$e->getMessage());
            return null;
        }
    }
    protected $primaryKey = "form_id";

    /**
     * @author tangshengyou
     * 将填报的数据插入开放实验室申请表中
     *
     */

    public static function tsy_save($abc){
        try {
            OpenLaboratory::create([
                'form_id'=>$abc['form_id'],
                'use_reason'=>$abc['use_reason'],
                'project_name'=>$abc['project_name'],
                'start_time'=>$abc['start_time'],
                'end_time'=>$abc['end_time'],
                'applicant_name'=>$abc['applicant_name'],
                'date'=>$abc['date']
            ]);
            return true;
        }catch (Exception $e){
            LogError('填报错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            OpenLaboratory::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            LogError('删除失败',[$e->getMessage()]);
            return null;
        }
    }
    //protected $primaryKey = "form_id";

    /**
     * 获取审批失败表单的详情
     * @author Liangjianhua <github.com/Varsion>
     * @param [string] $form_id
     * @return void
     */
    public static function getFormInfo_l($form_id) {
        try {
            $app_info = self::join('approval as app','open_laboratory.form_id','app.form_id')
                            ->join('approval_status as sta','app.status','sta.id')
                            ->join('reasons','app.approval_id','reasons.approval_id')
                            ->select('sta.id as status_id','sta.status','reasons.reason','app.updated_at')
                            ->where('open_laboratory.form_id',$form_id)
                            ->get();

            $form_info = self::select('*')
                                ->where('form_id',$form_id)
                                ->get();

            $stream = getStream(1);
            $stu_list = self::join('open_laboratory_student as stu','open_laboratory.form_id','stu.open_laboratory_id')
                            ->select('stu.*')
                            ->get();

            $res = [
                "form_info"=>$form_info,
                "student_list" => $stu_list,
                "approval_info"=>$app_info,
                "approval_stream" => $stream
                    ];

            return $res;

        } catch(Exception $e){
            logError('失败表单:'.$form_id.'信息查询失败',[$e->getMessage()]);
            return null;
        }
    }
}
