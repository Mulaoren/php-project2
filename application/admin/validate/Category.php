<?php
namespace app\admin\validate;
use think\Validate;

class Category extends Validate{
    // 定义验证规则(必需为$rule)
    protected $rule    = [
        'cat_name'  => 'require|unique:category',
        'pid'       => 'require',
    ];
    protected $message  = [
        'cat_name.require' => '分类名称必填',
        'cat_name.unique' => '分类名称重复',
        'pid.require' => '必须选择一个分类',
    ];
    protected $scene    = [
        'add' => ['cat_name','pid'],
        'upd' => ['cat_name'=>'require','pid']
    ];

}
