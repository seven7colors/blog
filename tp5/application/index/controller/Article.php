<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Base;
class Article extends Base
{
    public function index()
    {   //返回栏目名字
        $cateres=db('cate')->order('id asc')->select();
        $this->assign('cateres',$cateres);
        //返回特定文章
        $arid=input('Arid');
        $article=db('article')->find($arid);
        $this->assign('article',$article);
        //返回文章所属栏目
        $cate=db('cate')->find($article['cateid']);
        $this->assign('cate',$cate);
        //返回相关阅读,是指keywords类似的文章，后期做处理
        $relates=$this->relate($article['keywords'],$article['id']);
        $this->assign('relates',$relates);
        //返回频道推荐
        $tuijian=db('article')->where(array('state'=>1))->limit(8)->order('id desc')->select();
        $this->assign('tuijian',$tuijian);
        //点击量每次访问自加1
        db('article')->where('id', $arid)->setInc('click');
        return $this->fetch('article');
    }

    //模糊配备keywords
    public function relate($keywords,$id){
            $arr=explode(',',$keywords);
            static $relates=array();
            foreach($arr as $k=>$v){
                $map['keywords']=['like','%'.$v.'%'];
                //去除相同文章
                $map['id']=['neq',$id];
                $relate=db('article')->where($map)->order('click desc')
                         ->limit(8)->select();
                $relates=array_merge($relates,$relate);
            }
            //去重
            if($relates){
                $relates=arr_unique($relates);
                return $relates;
            }
           
    }




}