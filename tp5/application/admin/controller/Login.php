<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admin as AdminModel;
class Login extends Controller  
{
    public function index(){
        if(request()->isPost()){
            $admin=new AdminModel();
            $data=input();
            $num=$admin->login($data);
            if($num==4){
                $this->error('验证码错误');
            }else if($num==3){
                $this->success('登录成功','admin/lst');
            }else{
                $this->error('密码错误或用户不存在');
            }
        }else{
            return $this->fetch('login');
        }
        
         
    }
}

?>