<?php
namespace App\Http\Controllers;

use DB;
use Session;
use Illuminate\Support\Facades\Request;
class MenuController extends Controller{
    public function menu(){
        $arr=DB::table('we_type')->get();
        return view('admin/menu/designer',['arr'=>$arr]);
    }



    public function token(){

       $arr=Request::all();
        $id=$arr['id'];
        // var_dump($arr);die;
        $data1= DB::table('we_pub')->where('p_id', $id)->first();
         //print_r($data);die();
        $appid=$data1->appid;
        $appsecret=$data1->appsecret;
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret."";
        $file=file_get_contents($url);
        $data=json_decode($file,true);
        $Accesstoken=$data['access_token'];
        echo $Accesstoken;die;
        $url="https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$Accesstoken;
        $data=$arr['aa'];
        $this->weixinPost($url,"POST",$data);
    }

    //微信curl提交
    public function weixinPost($url,$method,$data){
        $ch = curl_init();   //1.初始化
        curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);//3.请求方式
        //4.参数如下
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//https
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');//模拟浏览器
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Accept-Encoding: gzip, deflate'));//gzip解压内容
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

        if($method=="POST"){//5.post方式的时候添加数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);//6.执行

        if (curl_errno($ch)) {//7.如果出错
            return curl_error($ch);
        }
        return $tmpInfo;
        curl_close($ch);//8.关闭
    }
}