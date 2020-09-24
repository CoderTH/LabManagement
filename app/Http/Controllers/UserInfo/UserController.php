<?php

namespace App\Http\Controllers\UserInfo;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfo\EmailCheckRequest;
use App\Models\CheckInfo;
use App\Models\EmailCheck;
use App\Models\UserInfo;
use http\Env;
use http\Env\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * 对邮箱进行验证
 * @author tangshengyou
 * Class UserController
 * @package App\Http\Controllers\UserInfo
 */
class UserController extends Controller
{
    //获取新老邮箱进行验证和发送验证
    public function emailFS(EmailCheckRequest $request)
    {
        $work_id = auth('api')->id();
//        $work_id =123123;
        $new_email = $request['new_email'];
        $request['work_id']=$work_id;
        $date = UserInfo::tsy_select($work_id);
//        dd($date);
        if ($request['old_email'] != $date['email']) {
            return json_fail('发送邮件失败老邮箱输入错误', 'null', 100);
        } else {
//            dd($request['old_email']);
            $res = EmailCheck::tsy_save($request);
//            dd($res);
            $email=$new_email; //用户邮箱
            $type_desc="激活邮箱";
//            $url='http://127.0.0.1:8000/api/userinfo/emailcheck'; //邮件激活地址
            $url=url()->previous().'/api/userinfo/emailcheck';
//            dd($url);
            $token=bcrypt($new_email); //邮件token
            try {
                Mail::raw(
                    '您好!您正在更换邮箱，请点击下面的链接完成验证:' . $url.'?work_id='.$work_id.'&verify='.$token.PHP_EOL. '如果不是您本人操作，请忽略此邮件。',
                    function ($msg) use ($email,$type_desc) {
                        $msg->from('t1577099712@163.com');
                        $msg->subject('激活邮箱');
                        $msg->to($email);
                    }
                );
                return json_fail('邮件发送成功',null,200);
            } catch (\Exception $e) {
                return json_fail('邮件发送失败',null,100);
            }
        }
        }

    public function emailCheck(Request $request){
//        dd($request['work_id']);
        $res = EmailCheck::tsy_select($request['work_id']);
//        dd($request['work_id']);
        $new = $res['email'];
//        dd($new);
//        dd(password_verify($new,$request['verify'])==1);
        if (password_verify($new,$request['verify']) == 1){
            UserInfo::tsy_update($request['work_id'],$new);
            EmailCheck::tsy_delete($request['work_id']);
            return json_fail('邮箱更换成功',null,200);
        }else{
            EmailCheck::tsy_delete($request['work_id']);
            return json_fail('邮箱更换失败',null,100);
        }
    }

}
