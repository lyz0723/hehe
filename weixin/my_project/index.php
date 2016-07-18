<?php

function __autoload($class) {
    require_once $class.'.php';
}

require_once 'Wechat.php';

require_once 'phpqrcode.php';

// use Wechat;

$options = array(
    'token'=>'xJqP4GhKSpNThgdmz2TFxmp86z8Ju2l2', //填写你设定的key
    // 'encodingaeskey'=>'encodingaeskey', //填写加密用的EncodingAESKey
    'appid'=>'wx02136717f3b695df', //填写高级调用功能的app id
    'appsecret'=>'7347a885b67f79b92aab30d1f3469465' //填写高级调用功能的密钥
);
$weObj = new Wechat($options);

// $weObj->valid();

$url = $weObj->getOauthRedirect('http://40198555.ngrok.natapp.cn/wechat/');

QRcode::png($url);

echo $url;