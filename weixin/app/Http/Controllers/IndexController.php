<?php
namespace App\Http\Controllers;
use App\We_menu;
use App\We_pub;
use DB;
use Request;
use Session;
use Input,Response;
class IndexController extends Controller{
    function show(){
        if(Session::get('uid')){
            $arr=new We_menu();
            $obj=$arr->main();
            $list=$arr->cai();
            return view('admin/user/frame',['obj'=>$obj,'list'=>$list]);
        }else{
            return redirect('login');
        }

    }
    //welcome
    public function main()
    {
//        $b_id=Request::input('id');
        //实例化模型层
        $arr=new We_pub();
        $list=$arr->show();
        //print_r($list);
        return view('admin/user/welcome',['list'=>$list]);
    }
    //
    public function frame1(){
        $arr=new We_menu();
        $obj=$arr->main();
        return view('admin/user/frame1',['obj'=>$obj]);
    }
    public function main1(){
        return view('admin/user/welcome1');
    }


}
?>