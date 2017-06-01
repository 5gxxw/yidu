<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/8
 * Time: 11:43
 */
namespace  home\index\controller;
use think\Controller;
use think\Db;

class  User extends Controller{
  public function  index(){
      $data=Db::name('admin')->select();
      $this->assign('info',$data);
      return $this->fetch();
  }
}