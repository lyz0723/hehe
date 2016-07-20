<?php
namespace App\Http\Controllers;
use App\We_rule;
use DB;
use Request;
use Session;
use Input,Response;

class RuleController extends Controller{
    //文字回复页面和音乐回复页面
   public function index(){
       $p_id=Session::get('p_id');
       $arr=DB::table('we_rule')->where('p_id',$p_id)->get();
       //print_r($arr);
       return view('admin/rule/display',['arr'=>$arr]);
   }
    //添加规则
    public function add_rule(){
        $arr=DB::table('we_type')->get();
        return view('admin/rule/ins',['arr'=>$arr]);
    }
    //文字回复提交
    public function add_text(){

        $name=Request::input('name');
       // echo $name;
        $type=Request::input('module');
        $content= Request::input('content');
            $key=Request::input('keywords');
        $title=Request::input('tit');
        $image=Request::input('pic');
        $i_content=Request::input('nei');
        $url=Request::input('lian');
        //echo $title,$image,$i_content,$url;
//            $p_id=Session::get('p_id');
//            $uid=Session::get('uid');
        //实例化对象
        $arr=new We_rule();
        $arr->add($name,$type,$content,$key,$title,$image,$i_content,$url);
        return redirect('rule');
    }

}
?>