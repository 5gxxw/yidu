<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/7
 * Time: 10:07
 */
namespace home\index\controller;
use think\Db;
use think\Request;
use think\Controller;
class Product extends Controller{

    /*
     * 淘厢房.列表
     * */
    public function product_hotel(){
        $hotel=Db::name('hotel')->order('id desc')->select();
        foreach($hotel as $k=>$v){
            $pic=explode(',',$v['images']);
            $hotel[$k]['images']=$pic;
        }//dump($hotel);
        $this->assign('hotel',$hotel);
       return $this->fetch('product_hotel');
    }
    
    /**
     * 淘厢房.新增
     * @return mixed|string
     */
    public function add(){
        if (request()->isPost()){
            if (!$data = input('post.')){
                $this->error('数据对象创建错误');
            }
            dump($data);exit;
            $hotel = model('Hotel');
            $result = $hotel->updates($data);
            if ($result == false){
                $this->error($hotel->getError());
            }else{
                $this->success($result);
            }
        }else{
            return $this->fetch();
        }
    }


    /* 编辑分类 */
    public function edit($id = null, $pid = 0){
        if (request()->isPost()){

        }else{
            //根据id获取数据
            $row = db('hotel')->where(['id'=>$id])->find();
            $row['picture_path'] = db('picture')->where(['id'=>$row['picture']])->value('path');
            $this->assign('row',$row);
            return $this->fetch('add');
        }





        if(request()->file('image')){//提交图片
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
        $infol='';
        if(request()->file('imagess')){//提交图片

            $files = request()->file('imagess');
            foreach($files as $file){
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->move(ROOT_PATH . 'home' . DS . 'uploads');
                if($info){
                    // 成功上传后 获取上传信息
                    $savename= $info->getSaveName();
                    $path['path'] ="/uploads/$savename";
                    // dump( $path['path']);die;
                    Db::name('picture')->insert($path);
                    $picture = Db::name('picture')->getLastInsID();
                    $infol.=$picture.",";
                }else{
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
            $info1=substr($infol,0,-1);
        }else{
            $info1 =request()->post('images');
        }



        $Category = model('Hotel');
        if(request()->isPost()){ //提交表单
            $data=request()->post();
            $data['picture']=$picture;
            $data['images']=$info1;
            if(false !== $Category->updates($data)){
                $this->success('编辑成功！', url('product_hotel'));
            } else {
                $error = $Category->getError();
                $this->error(empty($error) ? '未知错误！' : $error);
            }
        }else{
             $info=Db::name('hotel')->where('id='.$id)->find();
        }


         $this->assign('info',   $info);

            return $this->fetch();

    }

    /**
     * 上架、下架功能调换
     */
    public  function product_status(){
        if (request()->isPost()){
            $data = input('post.');
            if ($data['status'] == 1){
                $data['status'] = 0;
            }else{
                $data['status'] = 1;
            }
            //更新状态
            $result = db('hotel')->where(['id'=>$data['id']])->setField('status', $data['status']);
            if ($result){
                $this->success('更新成功');
            }else{
                $this->error('更新失败!');
            }
        }
    }

    /**
     *  淘厢房.删除
     */
    public  function product_delete(){
        $id = input('get.id');
        $res= db('hotel')->where(['id'=>$id])->delete();
        if($res){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }
    
    /**
     * 批量删除
     */
    public function  del(){
        $id=input('');
        dump($id);exit;
        $info=Db::name('hotel')->where('id='.$id)->delete();
        if($info){
            $this->success('删除成功！', url('product_hotel'));
        }else{
            $this->error(empty($error) ? '未知错误！' : $error);
        }
    }

    public function product_hotel_edit($id){
        $data=Db::name('hotel')->where('id='.$id)->find();
       $this->assign('edit',$data);
        return $this->fetch();

    }
    /*
        * 分类管理
        * */
    public function product_category(){
        return view('product_category');
    }

    public function product_category_add(){
        return view('product_category_add');
    }
    public function base(){
        //echo  111111;die;
        return view('base/common');
    }
    /*
    * 产品管理
    * */
    public  function  product_list(){
        return view('product_list');
    }
    /*
   *添加产品
   * */
    public  function  product_add(){
        return view('product_add');
    }

    /**
     * 淘厢房.类型列表
     */
    public function hotel_type_list()
    {
        $result = db('hotel_type')->select();
        dump($result);
        $this->assign('result',$result);
        $this->fetch('hotel_type_list');
    }

}