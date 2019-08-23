<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Base;
class Index extends Base
{
    public function index()
    {
        $cateres=db('cate')->order('id asc')->select();
        $this->assign('cateres',$cateres);
        $articles=db('article')->paginate(2);
        $this->assign('articles',$articles);
        return $this->fetch('index');
    }




}