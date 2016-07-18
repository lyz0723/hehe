<?php

    require_once 'phpqrcode.php';
    
    $redirect_uri = 'http://40198555.ngrok.natapp.cn/wechat/';

    $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx02136717f3b695df&redirect_uri='.$redirect_uri.'&response_type=code&scope=snsapi_userinfo#wechat_redirect';

    QRcode::png($url);