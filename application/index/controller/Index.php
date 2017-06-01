<?php
namespace home\index\controller;
use home\controller\Initial;
use think\Session;
use think\Request;
use think\Cache;
class Index extends Initial{
    //构造函数
    public function __construct(){
        //父级构造函数
        parent::__construct();
    }
    //首页控制器
    public function index(){
        $manager = Session::get('manager');
       // $this->assign('username',$manager['username']);
        //print_r($manager['username']);
        return view('index', [
            'name'  => $manager['username'],

        ]);
    }
    //初始加载右边的界面
    public function right(){
        $manager = Session::get('manager');
        return view('', [
            'name'  => $manager['username'],
        ]);
    }
    //退出
    public function logout(){
        Session::clear();
        return "<script>window.location.reload();</script>";
    }


}
