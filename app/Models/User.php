<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\UserInfo;

class User extends \Illuminate\Foundation\Auth\User implements JWTSubject,Authenticatable
{
    use Notifiable;

    public $table = 'user';

    protected $rememberTokenName = NULL;
    protected $primaryKey = "work_id";
    protected $guarded = [];

    protected $hidden = [
        'password',
    ];
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function getJWTIdentifier()
    {
        return self::getKey();
    }


    /**
     * 权限分配页面展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return array
     */
    Public static function adminSelectInfo(){
        try {
           $data = self::Join('user_info','user.work_id','=','user_info.user_id')
                ->Join('permissions','permissions.permission_id','=','user.permission_id')
                ->where('user.permission_id','!=',1)
                ->where('user.permission_id','!=',999)
                ->select('user.work_id','user_info.name','user_info.phone','user_info.email','permissions.type','user.status')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('获取用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 管理员新增账号
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int]$work_id,$permission_id,$status
     * @return array
     */
    Public static function adminNewAcc($work_id,$permission_id,$status){
        try {
            $data = User::create([
                     'work_id'=>$work_id,
                     'password'=>bcrypt(123456),
                     'permission_id'=>$permission_id,
                     'status'=>$status,
                    ]);
            return $data;
        } catch(\Exception $e){
            logError('新增用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 管理员搜索姓名页面展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $name
     * @return array
     */
    Public static function adminSeaechAcc($name){
        try {
            $data = self::Join('user_info','user.work_id','=','user_info.user_id')
                ->Join('permissions','permissions.permission_id','=','user.permission_id')
                ->where('user.permission_id','!=',1)
                ->where('user.permission_id','!=',999)
                ->where(function ($query) use($name){
                    if (!empty($name)){
                        $query->where('user_info.name','like','%'.$name.'%');
                    }
                })
                ->select('user.work_id','user_info.name','user_info.phone','user_info.email','permissions.type','user.status')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('搜索用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 管理员修改账号权限信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int] $work_id,$permission_id
     * @return array
     */
    Public static function adminModifyInfo($work_id,$permission_id){
        try {
            $data = self::where('work_id',$work_id)
                ->update(['permission_id' => $permission_id]);
            return $data;
        } catch(\Exception $e){
            logError('修改用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 管理员禁用账号信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int] $work_id,$status
     * @return array
     */
    Public static function adminDisInfo($work_id,$status){
        try {
            if($status==1){
                $data =  self::where('work_id',$work_id)
                    ->update(['status' => 0]);
            }else{
                $data =  self::where('work_id',$work_id)
                    ->update(['status' => 1]);
            }
            return $data;
        } catch(\Exception $e){
            logError('禁用用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 学生负责人页面展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return array
     */
    Public static function studentSelectInfo(){
        try {
            $data = self::Join('user_info','user.work_id','=','user_info.user_id')
                ->Join('permissions','permissions.permission_id','=','user.permission_id')
                ->where('user.permission_id',1)
                ->select('user.work_id','user_info.name','user_info.phone','user_info.email','user.status')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('获取用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 学生负责人新增账号
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int]$work_id,$permission_id,$status
     * @return array
     */
    Public static function studentNewAcc($work_id){
        try {
            $data = User::create([
                'work_id'=>$work_id,
                'password'=>bcrypt(123456),
                'permission_id'=>1,
                'status'=>1,
            ]);
            return $data;
        } catch(\Exception $e){
            logError('新增用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 学生负责人搜索姓名页面展示
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [String] $name
     * @return array
     */
    Public static function studentSeaechAcc($name){
        try {
            $data =  self::Join('user_info','user.work_id','=','user_info.user_id')
                ->where('user.permission_id',1)
                ->where(function ($query) use($name){
                    if (!empty($name)){
                        $query->where('user_info.name','like','%'.$name.'%');
                    }
                })
                ->where('user_info.name','like','%'.$name.'%')
                ->select('user.work_id','user_info.name','user_info.phone','user_info.email','user.status')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('搜索用户信息错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 学生负责人禁用账号信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int] $work_id,$status
     * @return array
     */
    Public static function studentDisInfo($work_id,$status){
        try {
            if($status==1){
                $data =  self::where('work_id',$work_id)
                    ->update(['status' => 0]);
            }else{
                $data =  self::where('work_id',$work_id)
                    ->update(['status' => 1]);
            }
            return $data;
        } catch(\Exception $e){
            logError('禁用用户信息错误',[$e->getMessage()]);
            return null;
        }
    }

    /**
     * 个人信息页
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @return array
     */
    Public static function getUserInfo(){
        try {
            $work_id = auth('api')->user()->work_id;
            $data = self::Join('user_info','user.work_id','=','user_info.user_id')
                ->Join('permissions','permissions.permission_id','=','user.permission_id')
                ->where('user.work_id',$work_id)
                ->select('user_info.name','permissions.type','user.work_id','user_info.email','user_info.phone')
                ->get();
            return $data;
        } catch(\Exception $e){
            logError('获取用户信息错误',[$e->getMessage()]);
            return null;
        }
    }
    /**
     * 修改用户电话信息
     * @author HuWeiChen <github.com/nathaniel-kk>
     * @param [int] $work_id, [String] old_password,new_password
     * @return array
     */
    Public static function updateUserPass($work_id,$old_password,$new_password){
        try {
            $data = self::where('work_id',$work_id)->select()->get();
            if (password_verify($old_password,$data[0] -> password) == 1){
                //修改密码
                $data = User::where('work_id',$work_id) -> update([
                    'password' => bcrypt($new_password)
                ]);
                return $data;
            }else{
                return null;
            }
        }catch (\Exception $e){
            logError("修改密码失败",[$e -> getMessage()]);
            return null;
}
      }



    public static function getPermi($id) {
        try {

            $data = self::select('permission_id')
                        ->where('work_id',$id)
                        ->get();
            $permi = $data[0]->permission_id;
            return $permi;
        } catch(Exception $e){
            logError('获取用户权限失败',[$e->getMessage()]);
            return null;
}
      }
    /**
     * 创建用户
     *
     * @param array $array
     * @return |null
     * @throws \Exception
     */
    public static function createUser($array = [])
    {
        try {
            return self::create($array) ?
                true :
                false;
        } catch (\Exception $e) {
            //\App\Utils\Logs::logError('添加用户失败!', [$e->getMessage()]);
            die($e->getMessage());
            return false;

        }
    }
}
