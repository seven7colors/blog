<?php
namespace app\index\controller;
use think\Controller;
class Base extends Controller  
{
    public function _initialize(){
        //返回推荐点击量高的文章
        $tjres=db('article')->where('state',1)
        ->order('click desc')->limit(5)->select();
        $this->assign('tjres',$tjres);
        //返回文章点击量高的文章
        $clickres=db('article')->order('click desc')->limit(5)->select();
        $this->assign('clickres',$clickres);
        
    }
}

?>