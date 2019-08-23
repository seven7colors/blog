<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
class Base extends Controller  
{
    protected $need_login=[]; 
    protected function  _initialize(){
       
        $request = Request::instance();
        if(!$this->is_login() && (in_array($request->action(),$this->need_login)
        ||$this->need_login[0]=='*' )){
            $this->error('请先登录系统','login/index');
        }
    }
    public function is_login(){
        return session('?username');
    }
}

?>