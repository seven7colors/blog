<?php
namespace app\index\controller;
use think\Controller;
use app\index\controller\Base;
class Cate extends Base
{
    public function index()
    {   //返回所有栏目
        $cateres=db('cate')->order('id asc')->select();
        $this->assign('cateres',$cateres);
        //返回所属栏目的文章
        $cid=input('cateid');
        $articles=db('article')->where('cateid','=',$cid)->paginate(3);
        $this->assign('articles',$articles);
        //返回该栏目名称
        $c_name=db('cate')->where('id','=',$cid)->find();
        $this->assign('c_name',$c_name);
        
        return $this->fetch('cate');
    }
//     <div class="hotmenu">
// 	<div class="con">热门标签：
//     <a href="http://www.chuanke.com/s2260700.html" target="_blank" style="color:#f00;">ThinkPHP视频教程下载</a>
//     {volist name="tagres" id="vo"}
//     <a href='http://127.0.0.1/tp5/public/index.php/index/search/index?keywords={$vo.tagname}'>{$vo.tagname}</a>
//     {/volist}
//     </div>
// </div> 


 
}
