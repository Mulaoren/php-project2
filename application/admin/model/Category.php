<?php
namespace app\admin\model;
use think\Model;

class Category extends Model{

    // 指定当前模型表的主键字段, 若不指定则框架会自动识别。
    protected $pk = "cat_id";
    //时间戳自动维护
    protected $autoWriteTimestamp = true;

    // @@ThinkPHP 5过滤[忽略]数据表中不存在的字段
    // protected $field = true;

    //当时间字段不为create_time和update_time，通过以下属性指定 相当于替换
     protected $createTime = "create_at"; //这里tp_category表中故意使用create_id字段测试此功能
    //protected $updateTime = "create_at";

    public function getSonsCat($data, $pid=0, $level=1){
        static $result = [];
        foreach($data as $v){
            if($v['pid'] == $pid){
                $v['level'] = $level;// 加一个层级关系
                $result[] = $v;
                // $this谁调用指向谁
                $this->getSonsCat($data, $v['cat_id'], $level+1);
            }

        }
        // 返回递归处理好的数据
        return $result;

    }

}