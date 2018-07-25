<?php

namespace app\admin\controller;

use think\Controller;


class CommonController extends Controller
{

    //控制器的初始化方法(调用每个方法之前，都会触发此方法)
    public function _initialize(){
        if(!session('user_id')){
            //没有则提示用户登录之后才操作
            $this->success("登录后再试",url('/login'));
        }
    }

}
