<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;


class TestController extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
     public function model(){

         echo '1115';
         echo '1115677';
         echo '111';
         echo '11166';

     	echo md5("123456".config('password_salt')); die;
//     	$catModel = new Category();
//     	$data = ['cat_name'=>'溜溜球','pid'=>10];
//     	dump( $catModel->save($data) );

     }

}
