<?php
namespace app\admin\model;
use think\Model;
class User extends Model{

    /**
     * 检测用户名和密码是否匹配的方法
     * @param  [type] $username 用户名
     * @param  [type] $password 密码（明文）
     * @return [type] 成功 返回 true, 失败返回false
     */
    public function checkUser($username,$password){
        $where=[
            'username' => $username,
            'password' => md5($password.config('password_salt')),
        ];
        $userInfo = $this->where($where)->find(); //1.$userInfo是一个数据对象 2.失败为null 3.$this 为谁调用就是谁
        if($userInfo ){
            //用户信息存储到session中去
            session('user_id',$userInfo['user_id']);
            session('username',$userInfo['username']);
            return true;
        }else{
            return false;
        }
    }
}
