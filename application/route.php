<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];

// think从thinkphp/library/目录下面找起
use think\Route;

//定义路由规则
//Route::get("login/[:id]",'admin/index/login');
Route::get("user/:id",'admin/index/user');
Route::get("logout",'admin/index/logout');

//定义网站根目录路由
Route::get('/','admin/index/index');
//后台首页路由
Route::get("top", 'admin/index/top');
Route::get("left", 'admin/index/left');
Route::get("main", 'admin/index/main');
//输出登录页面的路由
