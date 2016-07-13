<?php
namespace App\Http\Controllers;
use DB;
use Request;
use Input,Response;
use Session;
class UserController extends Controller{
	//显示登录页面
    public function login(){

       return view('admin/site/login');
    }
    //验证登录
    public function login_do(){
    	$username=Request::input('username');
    	$password=Request::input('password');
    	// echo $password;
    	//实例化模型对象
        $row=DB::table('we_user')->where('user_name',$username)->first();
        if($row){
            //获取用户名名称
            $name=$row->user_name;
            //获取用户密码
            $pwd=$row->user_pwd;
            //获取用户名的id
            $user_id=$row->user_id;
            if($name==$username){
                if($pwd==md5($password)){
                    Session::put('uid',$user_id);
                    return redirect('index');
                    //echo 2;
                }else{

                    return redirect('login');
                }
            }else{
                return redirect('login');
            }
        }else{
            return redirect('login');
        }

    }
}
