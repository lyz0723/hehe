
<html xmlns="http://www.w3.org/1999/xhtml"><head>
    <title>OneTeam微信管理系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="{{URL::asset('/')}}common/js/jq.js"></script>
    <script type="text/javascript" src="{{URL::asset('/')}}common/js/login.js"></script>
    <link href="{{URL::asset('/')}}common/css/login2.css" rel="stylesheet" type="text/css" />

</head>
<body>
<h1>OneTeam微信管理系统<sup>2016</sup></h1>
<div class="login" style="margin-top:50px;">
    <div class="header">
        <div class="switch" id="switch"><a class="switch_btn_focus" id="switch_qlogin" href="javascript:void(0);" tabindex="7">快速登录</a>
            <a class="switch_btn" id="switch_login" href="javascript:void(0);" tabindex="8">忘记密码</a><div class="switch_bottom" id="switch_bottom" style="position: absolute; width: 64px; left: 0px;"></div>
        </div>
    </div>
    <div class="web_qr_login" id="web_qr_login" style="display: block; height: 235px;">
        <!--登录-->
        <div class="web_login" id="web_login">
            <div class="login-box">
                <div class="login_form">
                    <form action="{{URL('login_do')}}" name="loginform" accept-charset="utf-8" id="login_form" class="loginForm" method="post">
                        <input type="hidden" name="did" value="0"/>
                        <input type="hidden" name="to" value="log"/>
                        <div id="userGue" class="gue"></div>
                        <div class="uinArea" id="uinArea">
                            <div class="inputOuter" id="uArea">
                                <input type="text" id="u" name="username" class="inputstyle" placeholder="支持用户名/邮箱/手机号登录"/>
                            </div>
                        </div>
                        <div class="pwdArea" id="pwdArea">
                            <div class="inputOuter" id="pArea">
                                <input type="password" id="p" name="password" class="inputstyle" placeholder="密码"/>
                            </div>
                        </div>
                        <input type="hidden" name="_token"         value="<?php echo csrf_token() ?>"/>
                        <div id="cod" style="display: none">
                            <input type="text" id="code" class="inputstyle" placeholder="请输入验证码" style="width: 125px;float: left"/>
                            <img title="点击更换" src="" alt="CAPTCHA" title="" id="gb_version" class="gb_version" style="cursor: pointer;" />
                        </div>
                        <div style="padding-left:50px;margin-top:20px;"><input type="submit" value="登 录" id="btn" style="width:150px;" class="button_blue"/></div>
                    </form>
                </div>
            </div>
        </div>
        <!--登录end-->
    </div>

    <!--注册-->
    <div class="qlogin" id="qlogin" style="display: none; ">

        <div class="web_login"><form name="form2" id="regUser" accept-charset="utf-8"  action="" method="post">
                <input type="hidden" name="to" value="reg"/>
                <input type="hidden" name="did" value="0"/>
                <ul class="reg_form" id="reg-ul">
                    <div id="userCue" class="cue">快速注册请注意格式</div>
                    <li>

                        <label for="user"  class="input-tips2">用户名：</label>
                        <div class="inputOuter2">
                            <input type="text" id="user" name="user" maxlength="16" class="inputstyle2"/>
                        </div>

                    </li>

                    <li>
                        <label for="passwd" class="input-tips2">密码：</label>
                        <div class="inputOuter2">
                            <input type="password" id="passwd"  name="passwd" maxlength="16" class="inputstyle2"/>
                        </div>

                    </li>
                    <li>
                        <label for="passwd2" class="input-tips2">确认密码：</label>
                        <div class="inputOuter2">
                            <input type="password" id="passwd2" name="" maxlength="16" class="inputstyle2" />
                        </div>

                    </li>

                    <li>
                        <label for="qq" class="input-tips2">QQ：</label>
                        <div class="inputOuter2">

                            <input type="text" id="qq" name="qq" maxlength="10" class="inputstyle2"/>
                        </div>

                    </li>

                    <li>
                        <div class="inputArea">
                            <input type="button" id="reg"  style="margin-top:10px;margin-left:85px;" class="button_blue" value="同意协议并注册"/> <a href="#" class="zcxy" target="_blank">注册协议</a>
                        </div>

                    </li><div class="cl"></div>
                </ul>
            </form>
        </div>
    </div>
    <!--注册end-->
</div>
<div class="jianyi">本项目最终解释权归OneTeam微信开发团队所有</div>
</body></html>