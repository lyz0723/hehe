<?php

namespace App\Http\Controllers;
use Request;

use Input,Response;

class WeixinController extends Controller
{

    function index() {
        $appId="wx9036c924e93284c6";
        $appsecret = "b6ace35d7f3820f253b6c770d6a028e4";
           //获取Access_token值
        $res = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appsecret");
        $res = json_decode($res, true);

        $token = $res['access_token'];
        //临时二维码
        /*
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;
        $postArr = array(
            'expire_seconds' => 604800, // 24*60*60*7
            'action_name'    => 'QR_SCENE',
            'action_info'    => array(
                'scene' => array('scene_id' => 2000),
            ),
        );
        $postJson = json_encode( $postArr );
        $res      = $this -> http_curl( $url, 'post', 'json', $postJson );
        // 获取ticket
        $ticket   = $res['ticket'];
        $url      = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket;
        echo '临时二维码';
        echo "<img src='".$url."'>";die;
        */
        //永久二维码
        /*
        $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$token;
        $postArr = array(

            'action_name'    => 'QR_LIMIT_SCENE',
            'action_info'    => array(
                'scene' => array('scene_id' => 3000),
            ),
        );
        $postJson = json_encode( $postArr );
        $res      = $this -> http_curl( $url, 'post', 'json', $postJson );
        // 获取ticket
        $ticket   = $res['ticket'];
        $url      = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
        echo '永久二维码';
        echo "<img src='".$url."'>";
        */

        //微信网页授权
        $redirect_uri = urlencode( "http://120.25.150.44/liyanzhao/hehe/weixin/public/shouquan" );
        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$appId."&redirect_uri=".$redirect_uri."&response_type=code&scope=SCOPE&state=123#wechat_redirect";
        header( 'location:'. $url);

           //获取jsapi_ticket
        $url="https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=$token&type=jsapi";
        $file=file_get_contents($url);
        $data=json_decode($file,true);

        $jsapi_ticket=$data['ticket'];
        //生成签名随机字符串
        $length=16;
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        $nonceStr=$str;
        //生成签名的时间戳
        $timestamp=time();

        $url = "http://120.25.150.44/liyanzhao/hehe/weixin/";
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=".$jsapi_ticket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;
        $signature = sha1( $string );
        $signPackage = array(
            "appId"     => $appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return view('admin/weixin/weixin',['signPackage'=>$signPackage]);
    }
    //
    public function shouquan(){
        $appId="wx9036c924e93284c6";
        $appsecret = "b6ace35d7f3820f253b6c770d6a028e4";
        //接受网页授权的code值
        $code=Request::input('code');
        //获取微信网页的Access_token;
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appId."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";
        $res       = $this -> http_curl($url, 'get');
        $access_token=$res['access_token'];
        $oppenid=$res['openid'];
        //拉去用户信息
        $url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$oppenid."&lang=zh_CN ";
        $data=$this -> http_curl($url, 'get');
        print_r($data);
    }
    //curl 的POST
    function http_curl($url, $type = 'get', $res = 'json', $arr = ''){
        // 1. 初始化 curl
        $ch = curl_init();
        // 2. 设置 curl 参数
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ( $type == 'post') {
            curl_setopt($ch, CURLOPT_POST, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        // 3. 采集
        $output = curl_exec( $ch );
        // 4. 关闭
        //curl_close( $ch );
        if ( $res == 'json' ) {
            if ( curl_errno( $ch ) ) {
                // 请求失败
                return curl_error( $ch );
            } else {
                // 请求成功
                return json_decode( $output, true );
            }
        }

    }

}