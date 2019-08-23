<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Admin extends Model
{
	//在添加和更新数据的操作下，自动完成数据处理
	protected $auto = ['password'];
    
    protected function setPasswordAttr($value)
    {
        return md5($value);
    }
    
    public function login($data){
        $captcha = new \think\captcha\Captcha();
        if(!captcha_check($data['code'])){
             return 4;//验证码不正确
           };
        $user=Db::name('admin')->where('username','=',$data['username'])->find();
        if($user){
            if($user['password']==md5($data['password'])){
                session('uid',$user['id']);
                session('username',$user['username']);
                return 3;//信息正确，登录成功
            }else{
                return 2;//密码不正确
            }
        }else{
            return 1;//用户不存在
        }
           
    }

}
