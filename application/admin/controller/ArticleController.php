<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Category;
use app\admin\model\Article;

class ArticleController extends Controller{
    /**
     * 文章列表
     */
    public function add(){
        $catModel = new Category();
        $artModel = new Article();

        $cats = $catModel->getSonsCat( $artModel->select() );
        return $this->fetch('', ['$cats'=>$cats]);
    }

}