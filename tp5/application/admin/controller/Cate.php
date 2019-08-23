<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Cate as CateModel;
use app\admin\validate\Cate as CateValidate;
class Cate extends Controller
{
    public function lst(){
        $cate=new CateModel();
        $list=$cate::paginate(5);
        $this->assign('list',$list);
        return  $this->fetch();
    }

    public function add(){
        return $this->fetch();
    }

    public function save(){ 
        if(request()->isPost()){
            $data=input();
            $validate=new CateValidate();
            $result=$validate->scene('add')->check($data);
            if(!$result){
                echo $validate->getError();
            }else{
                $cate=new CateModel($data);
                $info=$cate->save();
                if($info){
                    $this->success('添加栏目成功','lst');
                }else{
                    $this->error('栏目添加失败');
                }
            }
            
        }
    }

    public function edit(){
        $id=input('id');
        $cates=CateModel::get($id);
        $this->assign('cates',$cates);
        return $this->fetch();
    }

    public function update(){
        $data=input();
        $id=input('id');
        $validate=new CateValidate();
        $result=$validate->scene('edit')->check($data);
        if($result){
            $cate=new CateModel();
            $info=$cate->allowField(true)->save($data,['id' => $id]);
            if($info){
                $this->success('更新栏目成功','lst');
            }else{
                $this->error('更新栏目失败');
            }
        }else{
            echo $validate->getError();
        }
    }

    public function del(){
        $id=input('id');
        $info=CateModel::destroy($id);
        if($info){
            $this->success('栏目删除成功','lst');
        }else{
            $this->error('栏目删除失败');
        }
    }
}

?>