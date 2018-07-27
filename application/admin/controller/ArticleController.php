<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Category;
use app\admin\model\Article;

class ArticleController extends Controller{
    /**
     * 文章列表
     */
    public function index(){
        echo 'article.index called..';
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
            //验证上传
            if($file = request()->file('img')){
                //上传文件目录(相对于入口文件index.php而言)
                $uploadDir = './uplodad';
                // 验证规则
                $condition = [
                    'size' => 1024*1024*2,
                    'ext'  => 'png,jpg,gif,jpeg',
                ];
                $info = $file->validate($condition)->move($uploadDir);
                if($info){
                    $postData['ori_img'] = $info->getSaveName();
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