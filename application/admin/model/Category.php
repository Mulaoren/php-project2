<?php
namespace app\admin\model;
use think\Model;

class Category extends Model{

    // 指定当前模型表的主键字段, 若不指定则框架会自动识别。
    protected $pk = 'cat_id';

}