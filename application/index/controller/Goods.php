<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/4
 * Time: 14:24
 */
namespace  home\index\controller;
use think\Controller;
use think\Db;

class  Goods extends  Controller{
    public function index($type=null){
        $data=Db::name('goods')->where('type='.$type)->order('id desc')->select();
        $this->assign('goods',$data);
        return $this->fetch();
    }
    public function add(){

        if(request()->file()){//提交图片
            $file = request()->file('image');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'home' . DS . 'uploads');
            if($info){
                $savename= $info->getSaveName();
                $path['path'] ="/uploads/$savename";
                // dump( $path['path']);die;
                Db::name('picture')->insert($path);
                $picture = Db::name('picture')->getLastInsID();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
        $Category = model('Goods');
        if(request()->isPost()){ //提交表单
            $data=request()->post();
            $data['picture']=$picture;
            if(false !== $Category->updates($data)){
                $this->success('新增成功！', url('index','type=1'));
            } else {
                $error = $Category->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        }
        return $this->fetch('');
    }

    public function edit($id=null){
        if(request()->file()){//提交图片
            $file = request()->file('image');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'home' . DS . 'uploads');
            if($info){
                $savename= $info->getSaveName();
                $path['path'] ="/uploads/$savename";
                // dump( $path['path']);die;
                Db::name('picture')->insert($path);
                $picture = Db::name('picture')->getLastInsID();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }else{
            $picture =request()->post('picture');
        }

        $Category = model('Goods');
        if(request()->isPost()){ //提交表单
            $data=request()->post();
            $data['picture']=$picture;
            if(false !== $Category->updates($data)){
                $this->success('编辑成功！', url('index','type=1'));
            } else {
                $error = $Category->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        }else{
            $info=Db::name('goods')->where('id='.$id)->find();
        }


        $this->assign('info',   $info);

        return $this->fetch();
    }

    public function  del(){
        $id=$_GET['id'];
        $info=Db::name('goods')->where('id='.$id)->delete();
        if($info){
            $this->success('删除成功！', url('product_hotel'));
        }else{
            $this->error(empty($error) ? '未知错误！' : $error);
        }
    }


    public function goods_status(){
        $id=$_GET['id'];
        $status=$_GET['status'];
        $database=$_GET['database'];
       $data= updata_status($id,$status,$database);
        return json_encode($data);
    }
}
