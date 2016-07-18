<?php
/**
  * wechat php test
  */
//define your token
define("TOKEN", "$token");
$wechatObj = new wechatCallbackapiTest();
file_put_contents('/home/wwwroot/default/liyanzhao/hehe/weixin/storage/logs/1.log','abc');
//$wechatObj->valid();
//开启自动回复功能
$wechatObj->responseMsg();
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        if($this->checkSignature()){
            header('content-type:text');
        	echo $echoStr;
            $this->responseMsg();
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
            $msgType=$postObj->MsgType;
            $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";

            if($msgType=='text'){

                if(!empty( $keyword ))
                {
                    if($keyword=='杨云昊'){
                        $contentStr = "李彦钊";
                    }elseif($keyword=='于娜'){
                        $contentStr ="于娜";
                    }
                    file_put_contents("1.txt",$contentStr);
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                   //file_put_contents("1.txt",$resultStr);
                    echo $resultStr;
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