<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Links as LinksModel;
use app\admin\validate\Links as LinksValidate;
class Links extends Controller  
{
    public function lst(){
        $link=new LinksModel();
        $list=$link::paginate(3);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add(){
        return $this->fetch();
    }

    public function save(){
        if(request()->isPost()){
            $data=input();
            $validate=new LinksValidate();
            $result   = $validate->scene('add')->check($data);
            if(!$result){
                echo $validate->getError();
            }else{
                $link=new LinksModel($data);
                $info=$link->save();
                if($info){
                    return $this->success('添加链接成功','lst');
                }else{
                    return $this-error('添加链接失败');
                }
            }
            
        }
    }

    public function edit(){
        $id=input('id');
        $links=LinksModel::get($id);
        $this->assign('Links',$links);
        return $this->fetch();
    }

    public function update(){
        $data=input();
        $id=input('id');
        if(request()->isPost()){
            $validate=new LinksValidate();
            $result=$validate->scene('edit')->check($data);
            if(!$result){
                echo $validate->getError();
            }else{
                $link=new LinksModel();
                $info=$link->allowField(true)->save($data,['id' => $id]);
                if($info){
                    $this->success('修改链接成功','lst');
                }else{
                    $this->error('修改链接失败');
                }
            }
            
        }
    }

    public function del(){
        $id=input('id');
        $info=LinksModel::destroy($id);
        if($info){
            $this->success('删除链接成功','lst');
        }else{
            $this->error('删除链接失败');
        }
    }
}

?>