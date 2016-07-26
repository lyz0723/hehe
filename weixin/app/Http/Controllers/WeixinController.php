<?php

namespace App\Http\Controllers;

class WeixinController extends Controller
{
    public function receipt(){
        return view('admin/weixin/receipt');
    }
}