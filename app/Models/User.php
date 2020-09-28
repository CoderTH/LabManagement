<?php

namespace App\Models;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
