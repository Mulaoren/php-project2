<?php 
namespace app\admin\model;
use think\Model;
class Article extends Model{
	protected $pk = 'article_id';
    // 设置时间自动维护
    protected $autoWriteTimestamp = true;
}