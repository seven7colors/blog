<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Base;
class Search extends Base 
{
    public function index(){
        //返回栏目名字
        $cateres=db('cate')->order('id asc')->select();
        $this->assign('cateres',$cateres);
        //获取搜索关键词进行模糊配备
        $keywords=input('keywords');
        if($keywords){
            $map['title']=['like','%'.$keywords.'%'];
            $searches=db('article')->where($map)->order('id desc')
            ->paginate($listRows=3,$simple=false,$config=[
                'query'=>array('keywords'=>$keywords),
            ]);
            $this->assign(array(
                'keywords'=>$keywords,
                'searchres'=>$searches
            ));
        }else{
            $map['title']=['like','%'.$keywords.'%'];
            $searches=db('article')->where($map)->order('id desc')
            ->paginate($listRows=3,$simple=false,$config=[
                'query'=>array('keywords'=>$keywords),
            ]);
            $this->assign(array(
                'keywords'=>'暂无相关文章',
                'searchres'=>$searches
            ));
        }
        
        return $this->fetch('search');
    }
}

?>