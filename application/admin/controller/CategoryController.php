<?php
namespace app\admin\controller;

//use think\Validate;
use think\Controller;
use app\admin\model\Category;
use app\admin\model\Article;

class CategoryController extends Controller{
    /**
     * 分类列表
     */
    public function index(){
        $catModel = new Category();
        $data = $catModel
            ->field('t1.*, t2.cat_name p_name')
            ->alias('t1')
            ->join("tp_category t2", 't1.pid=t2.cat_id','left')
            ->select();
        $cats = $catModel->getSonsCat($data);

        return $this->fetch('',['cats'=>$cats]);
    }
    /**
     * 添加分类
     * @return mixed|void
     */
    public function add(){
        $catModel = new Category();
        // halt($catModel->select());//数组
        // 判断
        if(request()->isPost()){
            // 接收数据
            $postData = input('post.');
//            $rules = [
//                'cat_name'  => 'require|unique:category',
//                'pid'       => 'require',
//            ];
//            $message = [
//                'cat_name.require' => '分类名称必填',
//                'cat_name.unique' => '分类名称重复',
//                'pid.require' => '必须选择一个分类',
//            ];
//            $validate = new Validate($rules,$message);
//            $result = $validate->batch()->check($rules,$message);
            //验证的数据 验证器名称 提示信息 验证多条不写true验证单条
            $result = $this->validate($postData,'Category.add',[],true);

            //成功true 失败[error1,error2]
            if($result !== true){
                //return $this->error( implode(',',$validate->getError()) );
                $this->error( implode(',',$result ) );
            }
            //通过验证入库
            if($catModel->save($postData)){
                $this->success('入库成功', url('admin/category/index'));
            }else{
                $this->error('入库失败');
            }

        }

        // 取出所有的分类，分配到模板中
        $data = $catModel->select();//->toArray()

        $cats = $catModel->getSonsCat($data); //$catModel调用自己模型中的getSonsCat方法 没毛病
//         halt($cats);
        return $this->fetch('', ['cats'=>$cats]);
    }

    /**
     * 编辑分类
     */
    public function upd(){
        $catModel = new Category();
        // 判断是否是post请求
        if(request()->isPost()){
            // 1、接收参数
            $postData = input('post.');
            //2、验证器验证(后面单独抽离出来)
            //3、判断是否验证成功
            //4、判断编辑入库是否成功
            if($catModel->update($postData)){
                $this->success('编辑成功',url('admin/category/index'));
            }else{
                $this->error('编辑失败');
            }
        }
        $cat_id = input('cat_id');
        $catInfo = $catModel->find($cat_id);

        $data = $catModel->select();
        $cats = $catModel->getSonsCat($data);
        return $this->fetch('',[
            'cats' => $cats,
            'catInfo' => $catInfo,
        ]);

    }
    // ajax删除
    public function ajaxDel(){
        if(request()->isAjax()){
            //接收参数
            $cat_id = input('cat_id');
            $where = [
                'pid'=>$cat_id,
            ];
            //条件一
            $result1 = Category::where($where)->find();//只要有一个也算有所可用find()
            //halt($result1);
            if($result1){
                $response = ['code'=>-1, 'message'=>'分类下有子分类，无法删除'];
                return json($response);die;
            }
            // 条件二
            $result2 = Article::where(['cat_id'=>$cat_id])->find();//条件为数组

            if($result2){
                $response = ['code'=>-2, 'message'=>'分类下有文章，无法删除'];
                return json($response);die;//等价于 json_encode($response);die;
            }
            //上面两个条件都不满足时
            if(Category::destroy($cat_id)){
                $response = ['code'=>200, 'message'=>'删除成功'];
                return json($response);die;//等价于 json_encode($response);die;
            }else{
                $response = ['code'=>-3,  'message'=>'删除失败'];
                return json($response);die;
            }
        }


    }

}