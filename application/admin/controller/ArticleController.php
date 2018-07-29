<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Category;
use app\admin\model\Article;

class ArticleController extends CommonController{
    //定义getContent方法获取文章content字段的内容
    public function getContent(){
        if(request()->isAjax()){
            //1.接收参数article_id
            $article_id = input('article_id');
            //2.获取内容 (获取content字段的值)
            $content = Article::where(['article_id'=>$article_id])->value('content');
            //3.返回json格式数据
            return json(['content'=>$content]);
        }
    }
    //删除文章
    public function del(){
        $article_id = input('article_id');
        $oldObj = Article::get($article_id);
        //删除原图的路径和缩略图
        if($oldObj['ori_img']){
            unlink("./upload/".$oldObj['ori_img']);
            unlink("./upload/".$oldObj['thumb_img']);
        }
        if($oldObj->delete()){
            $this->success('删除成功',url('/admin/article/index'));
        }else{
            $this->error('删除失败');
        }
    }
    /**
     * 文章编辑
     * @return mixed
     */
    public function upd(){
        $artModel = new Article();
        //编辑入库
        if(request()->isPost()){
            //1.接收post参数
            $postData = input('post.');
            //2.验证器验证
            $result = $this->validate($postData,"Article.upd",[],true);
            if($result!==true){
                $this->error( implode(',',$result) );
            }
            //验证成功之后，进行文件上传和缩略图的缩放
            $path = $this->uploadImg('img');
            if($path){
                //删除原来文章的原图和缩略图
                //获取到图片的原图路径和缩略图路径
                $oldData= $artModel->find($postData['article_id']);
                if($old['ori_img']){
                    unlink('./upload/'.$oldData['ori_img']);
                    unlink('./upload/'.$oldData['thumb_img']);
                }
                $postData['ori_img'] = $path['ori_img'];
                $postData['thumb_img'] = $path['thumb_img'];
            }
            //3.编辑入库
            if($artModel->update($postData)){
                $this->success("编辑成功",url('/admin/article/index'));
            }else{
                $this->error('编辑失败');
            }
        }
        $catModel = new Category();
        $article_id = input('article_id');
        // 取出当前文章的数据
        $art = $artModel->find($article_id);
        //取出所有分类（无限极）
        $cats = $catModel->getSonsCat($catModel->select());
        return $this->fetch('',['art'=>$art,'cats'=>$cats]);
    }
    /**
     * 文章列表
     */
    public function index(){
        $arts = Article::alias('a')
            ->field('a.*,c.cat_name')
            ->join('tp_category c','a.cat_id = c.cat_id','left')
//            ->select();
            ->paginate(3);
        return $this->fetch('', ['arts'=>$arts]);
    }
    /**
     * 添加文章 文件上传
     * @return mixed
     */
    public function add(){
        $catModel = new Category();
        $artModel = new Article();
        if(request()->isPost()){
            $postData = input('post.');
            //验证
            $result = $this->validate($postData, 'Article.add',[],true);
            //验证不通过
            if($result !== true ){
                //提示错误信息
                $this->error( implode(',', $result) );
            }
            //验证上传 @img为表单name
            if($file = request()->file('img')){
                //上传文件目录(相对于入口文件index.php而言)
                $uploadDir = './upload';
                // 验证规则
                $condition = [
                    'size' => 1024*1024*2,
                    'ext'  => 'png,jpg,gif,jpeg',
                ];
                $info = $file->validate($condition)->move($uploadDir);
                if($info){
                    // 保存文件的目录和文件名
                    $postData['ori_img'] = $info->getSaveName();
                    // 1. 实例化图像类,并进行保存起来
                    $image = \think\Image::open("./upload/".$postData['ori_img']);
                    // 定义路径
                    $arr_path = explode('\\',$postData['ori_img']);// [20180728,452345.png]
                    $thumb_path = $arr_path[0].'/thumb_'.$arr_path[1]; // 给缩略图加前缀 thumb_
                    // 2.按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
                    $image->thumb(150,150,2)->save('./upload/'.$thumb_path);//将以thumb前缀的缩略图存放到新目录
                    $postData['thumb_img'] = $thumb_path;

                }else{
                    $this->error( $file->getError() );
                }
            }
            // 判断入库
            if($artModel->save($postData)){
                $this->success('入库成功',url('admin/article/index'));
            }else{
                $this->error('入库失败');
            }
        }

        $cats = $catModel->getSonsCat( $catModel->select() );
        return $this->fetch('', ['cats'=>$cats]);
    }

}