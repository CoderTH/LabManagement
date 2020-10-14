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
                        	    header("Access-Control-Allow-Origin: *");

        $work_id = auth('api')->id();
//        $work_id = 10086;
        $request['time'] = date("Y-m-d",time());
        $new_email = $request['new_email'];
        $request['work_id']=$work_id;
        $date = UserInfo::tsy_select($work_id);
        if ($request['old_email'] != $date['email']) {
            return json_fail('发送邮件失败老邮箱输入错误', 'null', 100);
        } else {
            $res = EmailCheck::tsy_save($request);
            $email=$new_email; //用户邮箱
            $type_desc="激活邮箱";
            $url=url()->previous().'/api/userinfo/emailcheck';
            $token=bcrypt($new_email); //邮件token
            try {
                Mail::raw(
                    '您好!您正在更换邮箱请在'.$request['time'] .'日内点击,，请点击下面的链接完成验证:' . $url.'?work_id='.$work_id.'&verify='.$token.PHP_EOL. '如果不是您本人操作，请忽略此邮件。',
                    function ($msg) use ($email,$type_desc) {
                        $msg->from('t1577099712@163.com');
                        $msg->subject($type_desc);
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
                        	    header("Access-Control-Allow-Origin: *");

        $res = EmailCheck::tsy_select($request['work_id']);
        $new = $res['email'];
        $time =date("Y-m-d",time());;
        if (password_verify($new,$request['verify']) == 1 && $res['date']==$time){
            UserInfo::tsy_update($request['work_id'],$new);
            EmailCheck::tsy_delete($request['work_id']);
            return json_fail('邮箱更换成功',null,200);
        }else{
            EmailCheck::tsy_delete($request['work_id']);
            return json_fail('邮箱更换失败',null,100);
        }
    }

}
