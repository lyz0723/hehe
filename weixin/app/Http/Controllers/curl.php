<?php
 //var_dump($_SERVER);EXIT;
 $cookie_file = tempnam('./temp','cookie');  //创建cookie文件保存的位置
 //echo $cookie_file;exit;
function  curl($url,$data,$method,$setcooke=false,$cookie_file=false){
		$ch = curl_init();	 //1.初始化
		curl_setopt($ch,CURLOPT_URL, $url); //2.请求地址
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$method);//3.请求方式
		//4.参数如下	
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);



    //配置curl解压缩
   // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept-Encoding:gzip'));
   // curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    //如果请求网站做了防盗处理
    //curl_setopt($ch, CURLOPT_REFERER,"http://wthrcdn.etouch.cn");





    curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0'); //指定请求方式（浏览器）
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch,CURLOPT_AUTOREFERER,1);
		if($method=="POST"){//5.post方式的时候添加数据	
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		}
		if($setcooke==true){
			 //把生成的cookie保存在指定的文件中
			curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie_file);
		}else{
			//直接从文件中读取cookie信息
			curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie_file);
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$output = curl_exec($ch);

		if (curl_errno($ch)) {
			return curl_error($ch);
		}
		curl_close($ch);
		return $output;
	}
 //get请求
 /*
  $url="https://www.jd.com/";
  $str=curl($url,array(),'GET',false,false);
  echo $str;
 */
 /*
 //post请求
  $url="http://www.study.com/seven7/1408phpC/20160311/1.php";
  $data=array('username'=>'123');
  $str=curl($url,$data,'POST',false,false);
  echo $str;
 */
 //模拟登陆
   /*$url1="http://www.123.com/user.php";
   $data=array('username'=>'ecshop','password'=>'ecshop','remember'=>1,'act'=>'act_login','back_act'=>'./index.php','submit'=>'');
    //登陆，把登陆后的用户信息保存在文件
   curl($url1,$data,'POST',true,$cookie_file);
   $url2="http://www.123.com/user.php?act=order_list";
   $str=curl($url2,array(),'GET',false,$cookie_file);
   echo $str*/
