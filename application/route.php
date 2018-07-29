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


// 测试方法的路径
Route::get('admin/test/index','admin/test/index');
Route::get('admin/test/index','admin/test/model');

// 定义路由规则
// Route::get("login/[:id]",'admin/index/login');
Route::get("user/:id",'admin/index/user');
Route::get("logout",'admin/index/logout');

// 定义网站根目录路由
Route::get('/','admin/index/index');
// 后台首页路由
Route::get("top", 'admin/index/top');
Route::get("left", 'admin/index/left');
Route::get("main", 'admin/index/main');

//退出登录的路由
Route::get("logout",'admin/public/logout');

// 输出登录页面的路由
Route::get("login", "admin/public/login");
Route::post("login", "admin/public/login");

// 路由进行分组
//Route::group('admin', function(){
//    Route::any('test/model', 'admin/test/model');
//});

Route::group('admin',function(){

    Route::get("category/add", 'admin/category/add');
    Route::post("category/add", 'admin/category/add');
    // 分类列表
    Route::get("category/index", 'admin/category/index');
    Route::post("category/index", 'admin/category/index');
    //编辑分类
    Route::get("category/upd", 'admin/category/upd');
    Route::post("category/upd", 'admin/category/upd');
    //分类删除
    Route::get("category/ajaxDel", 'admin/category/ajaxDel');
    // 添加文章
    Route::get('article/add', "admin/article/add");
    Route::post('article/add', "admin/article/add");
    // 文章列表
    Route::get('article/index', "admin/article/index");
    // 文章编辑
    Route::get('article/upd', "admin/article/upd");// 回显页面
    Route::post('article/upd', "admin/article/upd");
    // 文章删除
    Route::get('article/del', "admin/article/del");
    //文章数据操作的相关路由
    Route::get("article/getContent",'admin/article/getContent'); //查看文章内容的路由

    // 测试路由
    Route::any("test/model",'admin/test/model');
});