<?php
/**
  * wechat php test
  */

//define your token
$do=$_GET['do'];
$pdo=new PDO('mysql:host=127.0.0.1;dbname=weixin','root','root');
$pdo->exec('set names utf8');
$sql="select * from we_pub where p_rand='$do'";
$arr=$pdo->query($sql);
$obj=$arr->fetchAll(PDO::FETCH_ASSOC);

$token=$obj[0]['token'];

define("TOKEN", "$token");
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
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

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
                    if($keyword=="哈喽"){
                        $contentStr = "Welcome to wechat world!";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }else{
                        $contentStr="欢迎关注公众号";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
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