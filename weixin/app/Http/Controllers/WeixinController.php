<?php

namespace App\Http\Controllers;


class WeixinController extends Controller
{
    public function index(){
        echo $this->wx_get_token();
    }
    function wx_get_token() {
        $token = S('access_token');
        if (!$token) {
            $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx9036c924e93284c6&secret=b6ace35d7f3820f253b6c770d6a028e4');
            $res = json_decode($res, true);
            $token = $res['access_token'];
            S('access_token', $token, 3600);
        }
        return $token;
    }
}