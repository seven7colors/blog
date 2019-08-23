<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\Admin as AdminModel;
use app\admin\validate\Admin as AdminValidate;
class Admin extends Base
{
    protected $need_login=['*'];

    public function add(){
        return  $this->fetch();
    } 

    public function save(){
        if(request()->isPost()){
            $data=input();
            //$validate= \think\Loader::validate('Admin');
            $validate=new AdminValidate();
            //使用admin验证器定义的add场景
            $result   = $validate->scene('add')->check($data);
            if($result){
                $user =new AdminModel($data);
                $info=$user->save();
                if($info){
                    return $this->success('管理员添加成功','add');
                }else{
                    return $this->error('管理员添加失败');
                }
            }else{
               $this->error($validate->getError());
            }
            
        }
    }

    public function edit(){
        $id=input('id');
        $data=AdminModel::get($id);
        $this->assign('admins',$data);
        return  $this->fetch();
    }

    public function update(){
        //1.密码为空表示不修改密码
        $id=input('id');
        $data=AdminModel::get($id);
        $update=[];
        if(request()->isPost()){
            $update['username']=input('username');
            $password=input('password');
            if($password){
                //启用模型事务
                $update['password']=$password;
                //2.验证提交的数据
                $validate=new AdminValidate();
                $result=$validate->scene('edit')->check($update);
                if($result){
                $admin=new AdminModel();
                $info=$admin->save($update, ['id' => $id]);
                    if($info){
                        $this->success('修改管理员成功','lst');
                    }else{
                        $this->error('修改管理员失败');
                    }
                }else{
                    $this->error($validate->getError());
                }
            }else{
                //不启用模型的处理事务
                $update['password']=$data['password'];
                //2.验证提交的数据
                $validate=new AdminValidate();
                $result=$validate->scene('edit')->check($update);
                if($result){
                //无法启用模型的事物处理
                $admin=new AdminModel();
                $info=$admin->where('id', $id)->update($update);
                    if($info){
                        $this->success('修改管理员成功','lst');
                    }else{
                        $this->error('修改管理员失败');
                    }
                }else{
                    $this->error($validate->getError());
                }
            }
        }
        
        
    }

    public function del(){
        $id=input('id');
        $admin = AdminModel::get($id);
        $admin->delete();
        $this->success('删除成功','lst');
    }

    public function lst(){
        $admin=new AdminModel();
        $list=$admin::paginate(4);
        $this->assign('list',$list);
        return  $this->fetch();
    }
    
    public function logout(){
        session(null);
    }


}

?>