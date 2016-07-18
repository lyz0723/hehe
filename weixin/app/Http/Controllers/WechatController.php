<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Request;
use Session;
use App\Libraries\Wechat;

class WechatController extends Controller
{
    public $wechatConfig = [
        'token'=>'xJqP4GhKSpNThgdmz2TFxmp86z8Ju2l2', //填写你设定的key
        'encodingaeskey'=>'xJqP4GhKSpNThgdmz2TFxmp86z8Ju2l2', //填写加密用的EncodingAESKey
        'appid'=>'wx02136717f3b695df', //填写高级调用功能的app id
        'appsecret'=>'7347a885b67f79b92aab30d1f3469465' //填写高级调用功能的密钥
    ];

    public $wechatObj;

    public function __construct()
    {
        $this->wechatObj = new Wechat($this->wechatConfig);

        $this->wechatObj->getRev();

    }

    public function index()
    {
        $this->wechatObj->text('hello word')->reply();
    }
}