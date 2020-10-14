<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;
use mysql_xdevapi\Exception;

class LabBorrowing extends Model
{
    protected $table = "lab_borrowing";
    public $timestamps = true;
    protected $primaryKey = "form_id";

    public static function dc_getLabBorrowingInfo($id){
        try {
            $rs = self::where('lab_borrowing.form_id',$id)
                ->get();
            return $rs;

        }catch (\Exception $e){
            logError('获取设备借用表信息错误',$e->getMessage());

        }
    }
    protected $guarded=[];

    /**
     * @author tangshengyou
     * 将填报的数据存入lab_borrowing表
     *
     */
    public static function tsy_save($adc){
//        dd($adc);
        try {
            LabBorrowing::create([
                'form_id'=>$adc['form_id'],
                'date'=>$adc['date'],
                'lab_name'=>$adc['lab_name'],
                'lab_id'=>$adc['lab_id'],
                'class_name'=>$adc['class_name'],
                'class'=>$adc['class'],
                'number'=>$adc['number'],
                'laboratory_purpose'=>$adc['laboratory_purpose'],
                'start_time'=>$adc['start_time'],
                'end_time'=>$adc['end_time'],
                'start_class'=>$adc['start_class'],
                'end_class'=>$adc['end_class'],
                'teacher_name'=>$adc['teacher_name'],
                'phone'=>$adc['phone']
            ]);
            return true;
        }catch (Exception $e){
            LogError('填报失败',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            LabBorrowing::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            LogError('删除失败',[$e->getMessage()]);
            return null;
        }
    }
    //protected $primaryKey = "form_id";

    /**
     * 获取表单的详情
     * @author Liangjianhua <github.com/Varsion>
     * @param [string] $form_id
     * @return void
     */
    public static function getFormInfo_l($form_id) {
        try {
            $app_info = self::join('approval as app','lab_borrowing.form_id','app.form_id')
                            ->join('approval_status as sta','app.status','sta.id')
                            ->join('reasons','app.approval_id','reasons.approval_id')
                            ->select('sta.id as status_id','sta.status','reasons.reason','app.updated_at')
                            ->where('lab_borrowing.form_id',$form_id)
                            ->get();

            $form_info = self::select('*')
                                ->where('form_id',$form_id)
                                ->get();

            $stream = getStream(1);

            $res = [
                "form_info"=>$form_info,
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
