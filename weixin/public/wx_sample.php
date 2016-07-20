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
                    $pdo=new PDO('mysql:host=127.0.0.1;dbname=weixin','root','root');
                    //设置字符集
                    $pdo->exec('set names utf8');
                    $sql="select * from we_rule INNER  JOIN  we_img ON  we_rule.r_id=we_img.rid where r_key='$keyword'";
                    $list=$pdo->query($sql);
                    $row=$list->fetchAll();
                    if($keyword==$row[0]['r_key']){
                        $contentStr = $row[0]['r_content'];
                      
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }else{
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