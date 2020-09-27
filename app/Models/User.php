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
}
