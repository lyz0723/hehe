<?php
/**
  * wechat php test
  */

//define your token
$do=$_GET['do'];
//使用pdo连接数据库
$pdo=new PDO('mysql:host=127.0.0.1;dbname=weixin','root','root');
//设置字符集
$pdo->exec('set names utf8');
//查询数据库查询
$sql="select * from we_pub where p_rand='$do'";
//执行sql语句
$arr=$pdo->query($sql);
$obj=$arr->fetchAll(PDO::FETCH_ASSOC);
//获取该公众账号的token值
$token=$obj[0]['token'];
$appID=$obj[0]['appid'];
$appsecret=$obj[0]['appsecret'];
define("TOKEN", "$token");
define("appID", "$appID");
define("appsecret", "$appsecret");
$wechatObj = new wechatCallbackapiTest();

$echoStr = $_GET["echostr"];
if($echoStr)
{
    $wechatObj->valid();
}
else
{
    $wechatObj->responseMsg();
}


class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            //header('content-type:text');
        	echo $echoStr;
            //echo $this->getAccesstoken();
            echo $this->createMenu();
        	exit;
        }
    }

    public function responseMsg()
    {
        // 获取微信推送过来post数据（xml格式）
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];// 处理消息类型，并设置回复类型
        $postObj = simplexml_load_string( $postStr );
        // 扫码 推送
        if ( strtolower($postObj -> Event) == 'scan' ) {
            // 临时二维码
            if ( $postObj -> EventKey == 2000 ) {
                $tmp = '欢迎使用临时二维码 再次关注 勿忘初心丶funs';
            }
            // 永久二维码
            if ( $postObj -> EventKey == 3000 ) {
                $tmp = '欢迎使用永久二维码 再次关注 勿忘初心丶funs';
            }
            $toUser   = $postObj -> FromUserName;
            $fromUser = $postObj -> ToUserName;
            $arr      = array(
                array(
                    'title'       => $tmp,
                    'description' => '欢迎你使用勿忘初心丶funs',
                    'picUrl'      => 'http://img0.imgtn.bdimg.com/it/u=3480443286,3729707680&fm=206&gp=0.jpg',
                    'url'         => 'http://www.biubiubiu.pub',
                ),
            );
            $template = "<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>". count($arr) ."</ArticleCount>
                            <Articles>";
            foreach ($arr as $k => $v) {
                $template .="<item>
                            <Title><![CDATA[". $v['title'] ."]]></Title>
                            <Description><![CDATA[". $v['description'] ."]]></Description>
                            <PicUrl><![CDATA[". $v['picUrl'] ."]]></PicUrl>
                            <Url><![CDATA[". $v['url'] ."]]></Url>
                            </item>";
            }
            $template .="</Articles>
                            </xml>";

            $info     = sprintf($template, $toUser, $fromUser, time(), 'news' );
            echo $info;
        }

        //extract post data
		if (!empty($postStr)){
                /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
                   the best way is to check the validity of xml by yourself */
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                //获取用户发送消息的类型
                $msgType  = $postObj->MsgType;
                 //定义发送文字消息的接口
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";

            if($msgType=="text"){
                if(!empty( $keyword ))
                {
                    $pdo=new PDO('mysql:host=127.0.0.1;dbname=weixin','root','root');
                    //设置字符集
                    $pdo->exec('set names utf8');
                    $sql="select * from we_rule inner JOIN  we_img ON  we_rule.r_id=we_img.rid where r_key='$keyword'";
                    $list=$pdo->query($sql);
                    $row=$list->fetchAll(PDO::FETCH_ASSOC);
                   // print_r($row);
                    if($keyword==$row[0]['r_key']){
                        $contentStr = $row[0]['r_content'];

                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }

                    else{
                        /*
                         * 图灵机器人
                         * */
                            //定义URL链接操作
                           $url="http://www.tuling123.com/openapi/api?key=1f3a6c1438f6935ea3344fc678cc509c&info=".$keyword;
                            $str=file_get_contents($url);
                           $json=json_decode($str,true);
                            //定义回复内容类型
                            $contentStr=$json['text'];
                            //格式化字符串
                            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                                echo $resultStr;
                        /*
                         * 图灵结束
                         * */
                    }
                }else{
                    echo "Input something...";
                }
            }
        }else {
        	echo "";
        	exit;
        }
    }
        //获取access_token
    private function getAccesstoken()
    {
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.appID.'&secret='.appsecret.'";
        $file=file_get_contents($url);
        $data=json_decode($file,true);
        $Accesstoken=$data['access_token'];
       return $Accesstoken;
    }
    //创建自定义菜单

    //微信POST接值
    private function weixinPost($url,$data,$method){
        $ch = curl_init();	 //1.初始化
        curl_setopt($ch,CURLOPT_URL, $url); //2.请求地址
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$method);//3.请求方式
        //4.参数如下
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0'); //指定请求方式（浏览器）
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_AUTOREFERER,1);
        if($method=="POST"){//5.post方式的时候添加数据
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
//        if($setcooke==true){
//            //把生成的cookie保存在指定的文件中
//            curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie_file);
//        }else{
//            //直接从文件中读取cookie信息
//            curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie_file);
//        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        $tmpInfo = curl_exec($ch);

        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>