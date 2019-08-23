<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Article as ArticleModel;
use app\admin\validate\Article as ArticleValidate;
class Article extends Controller
{
    public function lst(){
        $Article=new ArticleModel();
        $list=$Article::paginate(5);
        $this->assign('list',$list);
        return  $this->fetch();
    }

    public function add(){
        $Articles=db('cate')->select();
        $this->assign('cateres',$Articles);
        return $this->fetch();
    }

    public function save(){ 
        if(request()->isPost()){
            $data=input();
            //使用input拿到所有的post值，再对$data['status']和$data['pic']进行修改;
            //$data['time']自动生成时间戳
            //使用模型进行添加
            $data['keywords']=str_replace('，',',',input('keywords'));
           if(input('state')== 'on'){
                $data['state']=1;
           }

           $file = request()->file('pic');
    
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($info){
                    // 成功上传后 获取上传信息
                   
                    // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                     $photo=$info->getSaveName();
                     if($photo){
                        $image = \think\Image::open(ROOT_PATH.'/public/uploads/'.$photo);
                        $pic = './uploads/'.$photo;
                        $image->thumb(150, 150)->save($pic);
                        $data['pic']=$pic;
                    }
                   
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
            $validate=new ArticleValidate();
            $result=$validate->scene('add')->check($data);
            if($result){
                $Article=new ArticleModel($data);
                $info=$Article->save();
                if($info){
                    $this->success('文章添加成功','lst');
                }else{
                    $this->error('文章添加失败');
                }
            }else{
                echo $validate->getError();
            }
            
        }
    }

    public function edit(){
        $id=input('id');
        $Article=new ArticleModel();
        $articles=$Article::get($id);
        $cateres=db('cate')->select();
        $this->assign('cateres',$cateres);
        $this->assign('articles',$articles);
        return $this->fetch();
    }

    public function update(){
        if(request()->isPost()){
            $data=input();
            $data['keywords']=str_replace('，',',',input('keywords'));
            $id=input('id');
            $Article=ArticleModel::get($id);
            //使用input拿到所有的post值，再对$data['status']和$data['pic']进行修改;
            //$data['time']自动生成时间戳
            //使用模型进行添加
           if(input('state')== 'on'){
                $data['state']=1;
           }else{
                $data['state']=0;
           }
           $file = request()->file('pic');
    
            // 移动到框架应用根目录/public/uploads/ 目录下
            if($file){
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
    
                if($info){
                    // 成功上传后 获取上传信息
                   
                    // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                     $photo=$info->getSaveName();
                     if($photo){
                        //删除旧图片
                        $picurl='.'.$Article['pic'];
                        unlink($picurl);
                        $image = \think\Image::open(ROOT_PATH.'/public/uploads/'.$photo);
                        $pic = './uploads/'.$photo;
                        $image->thumb(150, 150)->save($pic);
                        //unlink(ROOT_PATH.'/public/uploads/'.$photo);
                        $data['pic']=$pic;
                    }
                   
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
            $validate=new ArticleValidate();
            $result=$validate->scene('edit')->check($data);
            if($result){
                $Article=new ArticleModel();
                $info=$Article->save($data,['id'=>$id]);
                if($info){
                    $this->success('文章修改成功','lst');
                }else{
                    $this->error('文章修改失败');
                }
            }else{
                echo $validate->getError();
            }
            
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