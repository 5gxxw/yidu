<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 14:56
 */
namespace home\index\controller;
use think\Controller;
use think\request;
use think\Db;

class Member extends  Controller{

    /*
     *
     * 会员列表
     * **/
    public function Member_list(){
        $data =Db::name('user')->select();
        $this->assign('data',$data);
        return view('Member_list');
    }

    /*
 * 添加会员页面
 * */
    public function Member_add(request $request){

        return view('member');
    }



    public function add (){
         $data =$_POST;
        $data['create_time']=time();
        $data['password']=sha1('xq_'.md5($_POST['password']).'cms');
       $res = Db::name('user')->insert($data);
        if(!$res){
            $this->error('出错啦！！！');
        }else{
            $this->success('新增成功');
        }
    }


    /*
     * 删除的会员
     * */
    public function Member_del(){
        return view('member-del');
    }
}