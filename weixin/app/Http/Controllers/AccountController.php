<?php
namespace App\Http\Controllers;
use App\We_pub;
use DB;
use Request;
use Session;
use Input,Response;
class AccountController extends Controller
{
    //公众号管理
    public function display()
    {
        //实例化模型层
        $arr=new We_pub();
        $list=$arr->show();
        return view('admin/account/display',['list'=>$list]);
    }
    //添加公众号页面
    public function post()
    {
        return view('admin/account/post');
    }
    //添加公众号
    public function add()
    {
        //当前公众好号id
        $p_id=Session::get('p_id');
        //公众号名称
        $name=Request::input('name');
        //公众号AppId
        $key=Request::input('key');
        //公众号AppSecret
        $secret=Request::input('secret');
        //微信号
        $account=Request::input('account');
        //原始帐号
        $original=Request::input('original');
        //
//        $url="localhost".Request::getRequestUri();
//        echo $url;
//       $host=$_SERVER['SERVER_NAME'];
//        $url=$_SERVER['REQUEST_URI'];
        $data=rand(1,999)."123yanzhao";
        $token1=base64_encode($data);
        $token=substr($token1,1,-2);
        $p_rand=substr($token1,1,-4);
       // print_r($_SERVER);die;
        $str=$_SERVER['SCRIPT_NAME'];
        $a=strrpos($str,'/');
      $c=substr($str,0,$a+1);
        //$url=substr('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],0,strpos('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'?'))."?do=$p_rand";$p_rand;
        $url="http://".$_SERVER['HTTP_HOST'].$c."checkSignatures?do=$p_rand";
        //echo $url;die;
        $arr=new We_pub();
        $arr->add($name,$url,$key,$secret,$original,$account,$token,$p_rand);
        return redirect('display');
    }
    //切换公众号显示公众号的用户名
    public function nav()
    {

        $users = DB::table('we_pub')->get();
        $li="";
        foreach($users as $v){
            //$url="";
            $li.='<li><a href="javascript:void(0)" onclick="check('."{$v->p_id}".')">'."{$v->p_name}".'</a></li>';
        }
        echo $li;
    }
    //点击公众号用户名替换
    public function update()
    {
        $p_id=Request::input('p_id');
        Session::put('p_id',$p_id);
        $row= DB::table('we_pub')->where('p_id',$p_id)->lists('p_name');
        $p_name=$row[0];
        echo $p_name;

    }
    //删除公众号
    public function del(){
        $id=Request::input('id');
        $arr=new We_pub();
        $arr->del($id);
        return redirect('display');
    }
    //验证服务器地址的有效性
    public function checkSignatures(){
        $do=$_GET['do'];
        $arr=new We_pub();
        //$arr->responseMsg();
       // $token=$arr->api($do);
        //include"wx_sample.php";
        //echo $do;die;
       // $arr=new We_pub();
        if(isset($_GET["echostr"])) {
            $echoStr=$_GET["echostr"];
            $signature = $_GET["signature"];
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];
            $token=$arr->api($do);
            $tmpArr = array($token, $timestamp, $nonce);
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );
            if($tmpStr == $signature){
                $arr->responseMsg();
                header('content-type:text');
                echo $echoStr;
                exit;
            }else{
                echo '';
            }
        }else{
            $arr->responseMsg();
        }

    }

}
?>