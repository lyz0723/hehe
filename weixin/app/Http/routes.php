<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//Route::get('/', 'Welcome');
//Route::post('/', 'WechatController@index');
Route::get('/', function () {
  return view('welcome');
});


//后台登录页面
Route::get('login','UserController@login');
//登录验证
Route::post('login_do','UserController@login_do');
//后台首页
Route::get('index','IndexController@show');
Route::get('welcome','IndexController@main');
Route::get('welcome1','IndexController@main1');
//公众号管理页面
Route::get('display','AccountController@display');
//添加公众号页面
Route::get('post','AccountController@post');
//添加公众号
Route::post('add','AccountController@add');
//切换公众号显示公众号的用户名
Route::get('nav','AccountController@nav');
//点击公众号用户名替换
Route::get('update','AccountController@update');
//文字回复和音乐回复
Route::get('rule','RuleController@index');

//自定义菜单
Route::get('menu','MenuController@menu');


Route::post('token','MenuController@token');

//添加规则
Route::get('add_rule','RuleController@add_rule');
//替换左侧菜单栏
Route::get('frame1','IndexController@frame1');
//删除公众账号
Route::get('del','AccountController@del');
//文字回复提交
Route::post('add_text','RuleController@add_text');
//验证服务器地址的有效性
Route::get('checkSignatures','AccountController@checkSignatures');

//如何在网页中通过js代码将内容分享到朋友圈
Route::get('weixin','WeixinController@index');
Route::get('shouquan','WeixinController@shouquan');