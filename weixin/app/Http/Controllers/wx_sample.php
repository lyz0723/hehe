<?php
/**
  * wechat php test
  */
//define your token
define("TOKEN", "$token");
$wechatObj = new wechatCallbackapiTest();
//$wechatObj->valid();
//开启自动回复功能
 $wechatObj->responseMsg();
class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        //valid signature , option
        //验证成功，退出
        if($this->checkSignature()){
            header('content-type:text');
            echo $echoStr;
            exit;
        }
    }
    //公众平台发送给用户的信息
    public function responseMsg()
    {
        //get post data, May be due to the different environments
        //接受用户发给公众平台的信息，相当于$_POST,能传输xml格式
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        //extract post data
        if (!empty($postStr)){
            /* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
            //直解析xml主体部分，防止攻击
            libxml_disable_entity_loader(true);
            //通过simplexml_load_string解析xml数据
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            //和获取手机用户的openID
            $fromUsername = $postObj->FromUserName;
            //开发者微信号
            $toUsername = $postObj->ToUserName;
            //发送文本信息的关键字
            $keyword = trim($postObj->Content);
            //获取用户发送消息的类型
            $msgType=$postObj->MsgType;
            $time = time();
            //发送文本信息的字符串模板
            $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
			  				<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            //发送图文信息的的字符串模板
            $imageTpl="<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                            </Image>
                            </xml>";
            //发送图文消息的字符串模板
            $newsTpl="<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[%s]]></MsgType>
                            <ArticleCount>%s</ArticleCount>
                            <Articles>
                                 %s
                            </Articles>
                            </xml> ";
            //回复音乐消息
            $musicTpl="<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Music>
                    <Title><![CDATA[宋冬野民谣集合]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <MusicUrl><![CDATA[%s]]></MusicUrl>
                    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                    </Music>
                    </xml>";
            if($msgType=='text'){
                if(!empty( $keyword ))
                {

                    if($keyword=='图片'){
                        $msgType='image';
                        $contentStr="http://liyanzhao.applinzi.com/1.jpg";
                        $resultStr = sprintf($imageTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                        die;
                    }elseif($keyword=='单图文'){
                        $msgType='news';
                        $count=1;
                        $contentStr="<item>
                            <Title><![CDATA[欢迎大家来涉县]]></Title>
                            <Description><![CDATA[涉善涉美]]></Description>
                            <PicUrl><![CDATA[http://liyanzhao.applinzi.com/1.jpg]]></PicUrl>
                            <Url><![CDATA[http://liyanzhao.applinzi.com/1.jpg]]></Url>
                            </item>";
                        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $contentStr);
                        echo $resultStr;
                        die;
                    }elseif($keyword=='多图文'){
                        $msgType='news';
                        $count=4;
                        $contentStr='';
                        for($i=0;$i<=$count;$i++){
                            $contentStr.="<item>
                            <Title><![CDATA[欢迎大家来涉县]]></Title>
                            <Description><![CDATA[涉善涉美]]></Description>
                            <PicUrl><![CDATA[http://liyanzhao.applinzi.com/{$i}.jpg]]></PicUrl>
                            <Url><![CDATA[http://liyanzhao.applinzi.com/1.jpg]]></Url>
                            </item>";
                        }
                        $resultStr = sprintf($newsTpl, $fromUsername, $toUsername, $time, $msgType,$count, $contentStr);
                        echo $resultStr;
                        die;
                    }elseif($keyword=='音乐') {

                        $msgType='text';
                        $contentStr = "欢迎来到在线点歌系统\r\n\r\n 1.安河桥北\r\n\r\n 2.董小姐";
                        //格式话字符串
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                        echo $resultStr;
                    }elseif(preg_match('/^[1-9](\d)(0,2)$/',$keyword)){
                        if($keyword=='1'){
                            $Description='最好不要爱我';
                        }elseif($keyword=='2'){
                            $Description='宋冬野-董小姐';
                        }else{
                            $Description='宋冬野-董小姐';
                            $keyword=2;
                        }
                        $msgType='music';

                        //音乐地址
                        $MusicUrl="http://liyanzhao.applinzi.com/{$keyword}.mp3";
                        $HQMusicUrl="http://liyanzhao.applinzi.com/2.mp3";
                        $resultStr = sprintf($musicTpl, $fromUsername, $toUsername, $time, $msgType,$Description, $MusicUrl,$HQMusicUrl);
                        echo $resultStr;
                        die;
                    }

                    //文本类型
                    $msgType = "text";
                    $url="http://www.niurenqushi.com/app/simsimi/ajax.aspx";
                    include 'curl.php';
                    $txt=array('txt'=>$keyword);
                    $contentStr=curl($url,$txt,'POST');

                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }else{
                    echo "Input something...";
                }
            }elseif($msgType=='image'){
                //文本类型
                $msgType = "text";
                //文本主要内容
                $contentStr = "图片好漂亮啊";
                //格式话字符串
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                die;
            }elseif($msgType=='voice'){
                //文本类型
                $msgType = "text";
                //文本主要内容
                $contentStr = "听您说话就有个有本事的人";
                //格式话字符串
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                die;
            }elseif($msgType=='video'){
                //文本类型
                $msgType = "text";
                //文本主要内容
                $contentStr = "这片子挺好看的";
                //格式话字符串
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                die;
            }elseif($msgType=='text'){
                //文本类型
                $msgType = "text";
                //文本主要内容
                $contentStr = "欢迎关注公众微信号";
                //格式话字符串
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }elseif($msgType=='location'){
                $msgType="text";
                //获取经纬度
                $Location_X=$postObj->Location_X;
                $Location_Y=$postObj->Location_Y;
                $contentStr = "您好，我们已经获取到您的地理位置信息\r\n 经度($Location_Y)\r\n 纬度($Location_X)\r\n 请输入您关心的地方名称";
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr,$Location_X,$Location_Y);
                echo $resultStr;
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