<?php

namespace App\Http\Controllers\OAuth\SAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $loginRequest)
    {

        try {
            $credentials = self::credentials($loginRequest);

            if (!$token = auth()->attempt($credentials)) {
                return json_fail('账号或者用户名错误!',null, 100 );
            }else{
                $id = auth('api')->user()->work_id;
                echo $id;
                $permission_id = auth()->user()->permission_id;
                if ($permission_id==999){
                    return self::respondWithToken($token, '登陆成功!');
                }else{
                    auth()->logout();
                    return json_fail('账号或者用户名错误!',null, 100 );
                }
            }

        } catch (\Exception $e) {
            return json_fail('登陆失败!',$e->getMessage(),500,   500);
        }
    }
    public function logout()
    {
        try {
            auth()->logout();
        } catch (\Exception $e) {

        }
        return auth()->check() ?
            json_fail('注销登陆失败!',null, 100 ) :
            json_success('注销登陆成功!',null,  200);
    }
    public function refresh()
    {
        try {
            $newToken = auth()->refresh();
        } catch (\Exception $e) {
        }
        return $newToken != null ?
            self::respondWithToken($newToken, '刷新成功!') :
            json_fail(100, null,'刷新token失败!');
    }

    protected function credentials($request)
    {
        return ['work_id' => $request['work_id'], 'password' => $request['password']];
    }

    protected function respondWithToken($token, $msg)
    {
        return json_success( $msg, array(
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ),200);
    }


    public function test(Request $request){
        $user  = auth('api')->user();

        echo $user->work_id;
    }

    public function registered(Request $registeredRequest)
    {
        return User::createUser(self::userHandle($registeredRequest)) ?
            json_success('注册成功!',null,200  ) :
            json_success('注册失败!',null,100  ) ;

    }
    protected function userHandle($request)
    {
        $registeredInfo = $request->except('password_confirmation');
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);
        $registeredInfo['work_id'] = $registeredInfo['work_id'];
        return $registeredInfo;
    }
}
