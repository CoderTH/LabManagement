<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Monolog\Logger;

use Monolog\Logger;
use mysql_xdevapi\Exception;

use Exception;
use DB;


class Form extends Model
{
    protected $table = "form";
    public $timestamps = true;

    protected $guarded = [];

    public static function dc_getFrom($id){
        try {
            $rs = self::where('form_type_id',$id)
                ->select('form_id','created_at')
                ->get();
            return $rs;
        }catch (\Exception $e){
            logError('获取表单信息失败',$e->getMessage());
            return null;
        }

    }
    public static function dc_getFormByID($id){
        try {


            $id['id']?
                $rs = self::where('form_type_id',$id['type'])
                    ->where('form_id','like','%'.$id['id'].'%')
                    ->select('form_id','created_at')
                    ->get() :
                $rs = self::where('form_type_id',$id['type'])
                ->get();
            return $rs;
        }catch (\Exception $e){
            logError('搜索表单信息失败',$e->getMessage());

          }
      }

    protected $primaryKey = "form_id";
    protected $guarded=[];

    /**
     * 将存入的实验室借用表的信息存入 form 表中
     * @author tangshengyou
     * @param $adc
     */
    public static function tsy_save($adc){
//        dd($adc);
        try {
            Form::create([
                'form_id'=>$adc['form_id'],
                'work_id'=>$adc['work_id'],
                'form_type_id'=>$adc['form_type_id']
            ]);
            return true;
        }catch (\Exception $e){
            logger::Error('填报失败',[$e->getMessage()]);
}
      }
    //protected $primaryKey = "form_id";

    /**
     * 获取需要审批的表单
     * @author Liangjianhua <github.com/Varsion>
     * @param [String] $work 工号
     * @param [int] $class   类别
     * @return array
     */
    public static function getApproFormList($work,$class) {
        try {
        $permi = \get_app_status($work);

        if($class != 0){
            $res = self::join('approval','form.form_id','approval.form_id')
                        ->join('user_info','form.work_id','user_info.user_id')
                        ->join('form_type as type','form.form_type_id','type.form_type_id')
                        ->select('form.form_id','user_info.name','type.form_type','form.created_at')
                        ->where('form.form_type_id',$class)
                        ->where('approval.status',$permi)
                        ->where('form.work_id','<>',$work)
                        ->paginate();
        } else {
            $res = self::join('approval','form.form_id','approval.form_id')
                        ->join('user_info','form.work_id','user_info.user_id')
                        ->join('form_type as type','form.form_type_id','type.form_type_id')
                        ->select('form.form_id','user_info.name','type.form_type','form.created_at')
                        ->where('approval.status',$permi)
                        ->where('form.work_id','<>',$work)
                        ->paginate();
        }

        return $res;
        } catch(Exception $e){
            logError('表单列表查询失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 获取表单信息存放表
     * @author Liangjianhua <github.com/Varsion>
     * @param [String] $form_id
     * @return void
     */
    public static function getFrom_Type($form_id) {
        try {
            $res = self::select('form_type_id')
                        ->where('form_id',$form_id)
                        ->get();

            return $res[0]->form_type_id;

        } catch(Exception $e){
            logError('表单信息存放表查询失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 模糊搜索搜索表单列表
     * @author Liangjianhua <github.com/Varsion>
     * @param [String] $value
     * @return void
     */
    public static function SearchFormApp($work,$value) {
        try {
            $permi = \get_app_status($work);

            $res = self::join('approval','form.form_id','approval.form_id')
                        ->join('user_info','form.work_id','user_info.user_id')
                        ->join('form_type as type','form.form_type_id','type.form_type_id')
                        ->select('form.form_id','user_info.name','type.form_type','form.created_at')
                        ->where('form.form_id',$value)
                        ->orWhere('form.form_id','like','%'.$value.'%')
                        ->where('user_info.name',$value)
                        ->orWhere('user_info.name','like','%'.$value.'%')
                        ->where('approval.status',$permi)
                        ->where('form.work_id','<>',$work)
                        ->get();
            return $res;
        } catch(Exception $e){
            logError('搜索表单失败，搜索参数为:'.$value,[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 模糊搜索失败表单列表
     * @author Liangjianhua <github.com/Varsion>
     * @param [String] $value
     * @return void
     */
    public static function SearchFormFail($work,$value) {
        try {

            $res = self::join('approval','form.form_id','approval.form_id')
                        ->join('user_info','form.work_id','user_info.user_id')
                        ->join('form_type as type','form.form_type_id','type.form_type_id')
                        ->select('form.form_id','user_info.name','type.form_type','form.created_at')
                        ->where('form.form_id',$value)
                        ->orWhere('form.form_id','like','%'.$value.'%')
                        ->whereIn('approval.status',[2,4,6,8,10,12])
                        ->where('form.work_id',$work)
                        ->get();

            return $res;

        } catch(Exception $e){
            logError('搜索表单失败，搜索参数为:'.$value,[$e->getMessage()]);
            return null;
        }
    }


    /**
     * 获取失败表单列表
     * @author Liangjianhua <github.com/Varsion>
     * @param [type] $class
     * @return void
     */
    public static function FailFormList($work,$class) {
        try {
            if(!$class){
                $res = self::join('approval','form.form_id','approval.form_id')
                            ->join('user_info','form.work_id','user_info.user_id')
                            ->join('form_type as type','form.form_type_id','type.form_type_id')
                            ->select('form.form_id','type.form_type','form.created_at')
                            ->where('form.work_id',$work)
                            ->whereIn('approval.status',[2,4,6,8,10,12])
                            ->paginate();
            } else {
                $res = self::join('approval','form.form_id','approval.form_id')
                            ->join('user_info','form.work_id','user_info.user_id')
                            ->join('form_type as type','form.form_type_id','type.form_type_id')
                            ->select('form.form_id','type.form_type','form.created_at')
                            ->where('form.form_type_id',$class)
                            ->where('form.work_id',$work)
                            ->whereIn('approval.status',[2,4,6,8,10,12])
                            ->paginate();
            }

            return $res;
            } catch(Exception $e){
                logError('错误表单列表查询失败',[$e->getMessage()]);
                return null;
            }
    }

    /**
     * 获取成功表单列表
     * @author Liangjianhua <github.com/Varsion>
     * @param [int] $class
     * @param [string] $work
     * @return void
     */
    public static function getSucFormList($class,$work) {
        try {

            if(!$class){
                $res = self::join('approval','form.form_id','approval.form_id')
                            ->join('user_info','form.work_id','user_info.user_id')
                            ->join('form_type as type','form.form_type_id','type.form_type_id')
                            ->select('form.form_id','type.form_type','form.created_at')
                            ->where('form.work_id',$work)
                            ->where('approval.status',11)
                            ->paginate();
            } else {
                $res = self::join('approval','form.form_id','approval.form_id')
                            ->join('user_info','form.work_id','user_info.user_id')
                            ->join('form_type as type','form.form_type_id','type.form_type_id')
                            ->select('form.form_id','type.form_type','form.created_at')
                            ->where('form.form_type_id',$class)
                            ->where('form.work_id',$work)
                            ->where('approval.status',11)
                            ->paginate();
            }

            return $res;
        } catch(Exception $e){
            logError('成功表单列表获取失败',[$e->getMessage()]);
            return null;

        }
    }

    /**

     * 当关联的表插入失败是 删除 对应的 关联的表
     * @param $work_id
     */
    public static function tsy_delete($form_id){
        try {
            Form::where('form_id',$form_id)->delete();
        }catch (Exception $e){
            Logger::Error('删除失败',[$e->getMessage()]);
        }
    }
     * 搜索成功表单
     * @author Liangjianhua <github.com/Varsion>
     * @param [type] $work
     * @param [type] $value
     * @return void
     */
    public static function SearchFormSuc($work,$value) {
        try {
            $res = self::join('approval','form.form_id','approval.form_id')
                        ->join('user_info','form.work_id','user_info.user_id')
                        ->join('form_type as type','form.form_type_id','type.form_type_id')
                        ->select('form.form_id','user_info.name','type.form_type','form.created_at')
                        ->where('form.form_id',$value)
                        ->orWhere('form.form_id','like','%'.$value.'%')
                        ->where('approval.status',11)
                        ->where('form.work_id',$work)
                        ->get();
            return $res;
        } catch(Exception $e){
            logError('搜索表单失败，搜索参数为:'.$value,[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 获取待审批表单列表
     * @author Liangjianhua <github.com/Varsion>
     * @param [int] $class
     * @param [string] $work
     * @return void
     */
    public static function getViewFormList($class,$work) {
        try {

            if(!$class){
                $res = self::join('approval','form.form_id','approval.form_id')
                            ->join('user_info','form.work_id','user_info.user_id')
                            ->join('form_type as type','form.form_type_id','type.form_type_id')
                            ->select('form.form_id','type.form_type','form.created_at')
                            ->where('form.work_id',$work)
                            ->whereIn('approval.status',[1,3,5,7,9])
                            ->paginate();
            } else {
                $res = self::join('approval','form.form_id','approval.form_id')
                            ->join('user_info','form.work_id','user_info.user_id')
                            ->join('form_type as type','form.form_type_id','type.form_type_id')
                            ->select('form.form_id','type.form_type','form.created_at')
                            ->where('form.form_type_id',$class)
                            ->where('form.work_id',$work)
                            ->whereIn('approval.status',[1,3,5,7,9])
                            ->paginate();
            }

            return $res;
        } catch(Exception $e){
            logError('待审批表单列表获取失败',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 搜索待审批表单列表
     * @author Liangjianhua <github.com/Varsion>
     * @param [type] $work
     * @param [type] $value
     * @return void
     */
    public static function SearchFormView($work,$value) {
        try {
            $res = self::join('approval','form.form_id','approval.form_id')
                        ->join('user_info','form.work_id','user_info.user_id')
                        ->join('form_type as type','form.form_type_id','type.form_type_id')
                        ->select('form.form_id','user_info.name','type.form_type','form.created_at')
                        ->where('form.form_id',$value)
                        ->orWhere('form.form_id','like','%'.$value.'%')
                        ->whereIn('approval.status',[1,3,5,7,9])
                        ->where('form.work_id',$work)
                        ->get();
            return $res;
        } catch(Exception $e){
            logError('搜索表单失败，搜索参数为:'.$value,[$e->getMessage()]);
            return null;
        }
    }
}
