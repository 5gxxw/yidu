<?php
namespace home\index\controller;
use think\Controller;
use think\Session;
use think\Request;
class Login extends Controller{
    //登录页面
    public function index(){
        //判断是否有SESSION值
        $manager = Session::get('manager');
        if(!empty($manager)) $this->redirect('Index/index');
        $this->assign('username',$manager);
        return view();
    }
    //AJAX登录
    public function ajax_login(){
        //判断是否AJAX请求
        if(!request()->isAjax())  return json(array('status'=>0,'message'=>'请求错误'));
        $data = input('param.');
        $data = $data['data'];
        $return = model('User')->login($data);
        return json($return);
    }



}
