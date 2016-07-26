<?php

namespace App\Http\Controllers;


class WeixinController extends Controller
{
    //获取Access_token值
    function wx_get_token() {
            $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9036c924e93284c6&secret=b6ace35d7f3820f253b6c770d6a028e4');
            $res = json_decode($res, true);
            $token = $res['access_token'];
            return $token;
    }
    //获取jsapi_ticket
    function jsapi_ticket(){
        $Access_token=$this->wx_get_token();
       $url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$Access_token&type=jsapi";
        $file=file_get_contents($url);
        $data=json_decode($file,true);
        $ticket=$data['ticket'];
        echo $ticket;
    }
}