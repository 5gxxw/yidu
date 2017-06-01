<?php
namespace home\controller;
use think\Controller;
use think\Session;
class Initial extends Controller{
    public function __construct(){
        //判断是否有SESSION值
        $manager = Session::get('manager');
        if(empty($manager)) $this->redirect('Login/index');
    }
}
