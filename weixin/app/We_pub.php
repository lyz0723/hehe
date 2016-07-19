<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
class We_pub extends Model{
    public function show(){
        $arr=DB::table('we_pub')->get();
        return $arr;
    }
    //删除公众号
    public function del($id){
        $row=DB::table('we_pub')->where('p_id',$id)->delete();
        return $row;
    }
    //添加公众号
    public function add($name,$address,$key,$secret,$original,$account,$token,$p_rand){

       $arr=DB::table('we_pub')->insert(array(
            array('p_name' => $name,'address'=>$address,'appid'=>$key,'appsecret'=>$secret,'w_numone'=>$original,'w_num'=>$account
            ,'token'=>$token,'p_rand'=>$p_rand,'u_id'=>Session::get('uid')),
        ));
        return $arr;
    }
    //根据p_rand字段获取token
    public function api($do){
        $arr=DB::table('we_pub')->where('p_rand','=',$do)->first();
        return $arr->token;
    }
   public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($postStr)) {
            libxml_disable_entity_loader(true);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $keyword = trim($postObj->Content);
            $time = time();
           $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            if(!empty( $keyword ))
            {
                $msgType = "text";
                $contentStr='liyanzhao';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
           else{
             $msgType = "text";
                $contentStr ='欢迎关注';
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
            }
            //$this->logger("R ".$postStr);
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            /*//消息类型分离
            switch ($RX_TYPE)
            {
                case "event":
                    $result = $this->receiveEvent($postObj);
                    break;
               case "text":
                    $result = $this->receiveText($postObj);
                    break;
                case "image":
                   $result = $this->transmitText($postObj,'已收到您的图片信息，谢谢！');
                  break;
                case "voice":
                   $result = $this->transmitText($postObj,'已收到您的语音信息，谢谢！');
                    break;
               case "video":
                    $result = $this->transmitText($postObj,'已收到您的视频信息，谢谢！');
                    break;
                case "shortvideo":
                    $result = $this->transmitText($postObj,'已收到您的小视频信息，谢谢！');
                   break;
               case "location":
                    $result = $this->transmitText($postObj,'已收到您的地理位置信息，谢谢！');
                    break;case "link":
                    $result = $this->transmitText($postObj,'已收到您的链接信息，谢谢！');
                    break;
                default:
                    $result = $this->transmitText($postObj,'已收到您的'.$RX_TYPE.'信息，谢谢！');
                   break;
            }*/
            echo $result;
        }else {
            echo "adassd";
            exit;
        }
    }
}