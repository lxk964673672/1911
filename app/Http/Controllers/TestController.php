<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function hellow(){
        echo 'hellow';
    }
    public function getWxToken(){
        $appid='wxc5e4dd173db22e83';
        $appsecret='3f6e9d296e9d11116e38acb2c037e346';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $cont=file_get_contents($url);
        echo $cont;
    }
    public function getWxToken2(){
        $appid='wxc5e4dd173db22e83';
        $appsec='3f6e9d296e9d11116e38acb2c037e346';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsec;

        //创建一个新的curl资源
        $ch = curl_init();
        //设置url和相应的选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//将返回结果通过变量接收
        //抓取url并把它传递给浏览器
        $response=curl_exec($ch);
        //关闭curl资源 并且释放系统资源
        curl_close($ch);
        echo $response;
    }
    public function getWxToken3(){
        $appid='wxc5e4dd173db22e83';
        $appsec='3f6e9d296e9d11116e38acb2c037e346';
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsec;
        $client=new Client();
        $response=$client->request('GET',$url);
        $data=$response->getBody();
        echo $data;
    }
    public function getAccessToken(){
        $token=Str::random(32);
        $data=[
            'token' => $token,
            'expire_in' => 7200
        ];
        echo json_encode($data);
    }
    public function userInfo(){
        echo 'api-userinfo';
    }
    public function test2(){
        $url='http://www.130.com/test2';
        $response=file_get_contents($url);
        var_dump($response);
    }
}
