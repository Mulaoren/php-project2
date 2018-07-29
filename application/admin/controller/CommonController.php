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

    //封装通用的文件上传的方法
    public function uploadImg($fileName){
        $ori_img = ''; //存储原图的路径
        $thumb_img = ''; //存储缩略图的路径
        //判断是否有文件上传
        if($file = request()->file($fileName)){
            //定义上传文件的目录(./相对于入口文件index.php)
            $uploadDir = "./upload/";
            //定义文件上传的验证规则
            $condition = [
                // 1kb = 1024byte    1m = 1024 kb
                'size' => 1024*1024*2,
                'ext'  => 'png,jpg,gif,jpeg'
            ];
            //上传验证并进行上传文件
            $info = $file->validate($condition)->move($uploadDir);
            //判断是否上传成功
            if($info){
                //成功，获取上传的目录文件信息，用于存储到数据库中
                $ori_img = $info->getSaveName();
                //进行缩略图生成
                //$postData['ori_img']  20180728/gfsdgfsgffg.png
                //$postData['ori_img']  20180728/thumb_gfsdgfsgffg.png
                //1.实例化图像类，打开出来处理的原图图片路径
                $image = \think\Image::open("./upload/".$ori_img);
                $arr_path = explode('\\',$ori_img);// [20180726,452345.png]
                //保存缩略图的路径到数据库表字段
                $thumb_img =$arr_path[0].'/thumb_'.$arr_path[1];
                //2.生成缩略图并进行保存起来
                $image->thumb(150,150,2)->save('./upload/'.$thumb_img);
                return ['ori_img'=>$ori_img,'thumb_img'=>$thumb_img];
            }else{
                //上传失败，提示上传的错误的信息
                $this->error( $file->getError() );
            }
        }
    }

}
