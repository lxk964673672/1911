<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use App\Model\TokenModel;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    //接口测试 注册
    public function reg(Request $request)
    {
        $user_name = $request->post('user_name');
        $user_email = $request->post('user_email');
        $pass1 = $request->post('pass1');
        $pass2 = $request->post('pass2');

        //  todo 验证用户名 email 密码

        $pass = password_hash($pass1, PASSWORD_BCRYPT);

        $user_info = [
            'user_name' => $user_name,
            'user_email' => $user_email,
            'password' => $pass,
            'reg_time' => time()
        ];

        $uid = UserModel::insertGetId($user_info);
        $response = [
            'error' => 0,
            'msg' => 'ok'
        ];
        return $response;
        }

    //接口测试 登录
    public function login(Request $request){
        $user_name=$request->post('user_name');
        $pass=$request->post('pass');

        //验证登录信息
        $u=UserModel::where(['user_name'=>$user_name])->first();
        if($u) {
            //验证密码
            if (password_verify($pass,$u->password)) {
                //生成token
                $token=Str::random(32);

                $expire_seconds=3600; //token的有效期
                $data= [
                    'token'=>$token,
                    'uid'=>$u->user_id,
                    'expire_at'=>time()+$expire_seconds
                ];
                 //入库
               $tid=TokenModel::insertGetId($data);

                $response = [
                    'error' => 0,
                    'msg' => 'ok',
                    'data'=>[
                        'token'=>$token,
                        'expire_in'=>$expire_seconds
                    ]
                ];
            } else {
                $response = [
                    'error' => 500001,
                    'msg' => '密码错误'
                ];
            }
        }else{
            $response = [
                'error' => 400001,
                'msg' => '用户不存在'
            ];
        }
        return $response;
    }
    public function center(Request $request){
       //验证是否有token
        $token=$request->get('token');
        if(empty($token)){
            $response=[
                'error'=>'40003',
                'msg'=>'未授权'
            ];
            return $response;
        }
        //验证token是否有效
        $t=TokenModel::where(['token'=>$token])->first();
        //未找到token信息
        if(empty($t)){
            $response=[
                'error'=>'40003',
                'msg'=>'token无效'
            ];
            return $response;
        }
        $user_info=UserModel::find($t->uid);
        $response=[
            'error'=>0,
            'msg'=>'ok',
            'data'=>[
                'user_info'=>$user_info
            ]
        ];
        return $response;
    }
}