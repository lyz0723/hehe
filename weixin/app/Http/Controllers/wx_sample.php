<?php
/**
  * wechat php test
  */
//define your token
define("TOKEN", "$token");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
echo $wechatObj->responseMsg();
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
            header('content-type:text');
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
                //发送方账号(一个openid)
                $fromUsername = $postObj->FromUserName;
                //开发者微信号
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
//                //获取用户发送消息的类型
//                $msgType=$postObj->MsgType;
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
				if(!empty( $keyword )) {
                    $msgType = "text";
                    $contentStr = "Welcome to wechat world!";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }else{
                    /*
                     * 接入图灵机器人
                     * */
                    //定义回复类型
                    $msgType="text";
                    //定义URL链接操作
                    $url="http://www.tuling123.com/openapi/api?key=1f3a6c1438f6935ea3344fc678cc509c&info={$keyword}";
                    $str=file_get_contents($url);
                    $json=json_decode($str);
                    //定义回复内容
                    $contentStr=$json->text;
                    //格式化字符串
                    $result=sprintf($textTpl,$fromUsername,$toUsername, $contentStr, $time,$msgType);
                    //返回数据给客户端
                    echo $result;
                    /*
                     * end 图灵机器人结束
                     * */
                }

                }else{
                    echo "Input something...";
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