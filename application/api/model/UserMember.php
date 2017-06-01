<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/9
 * Time: 13:16
 */
namespace  home\api\model;
use think\Db;
use think\Model;
use think\Session;
class  UserMember extends  Model{
    protected $table = 'yidu_user';

    public function register($username,$password,$phone){
        $data=array(
            'username'=>$username,
            'password'=>sha1('xq_'.md5($password).'cms'),
            'phone'=>$phone,
            'create_time'=>time(),

        );
        if($user=$this->create($data)){
          //  $uid=$user->id;
          //  return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
            return true;

        }else {
            return $this->getError(); //错误详情见自动验证注释
        }


    }


    public function login($data){
        $where = array(
            'username' => $data['username'],
            'password' => sha1('xq_'.md5($data['password']).'cms'),
        );
        $result=Db::name('user')->where($where)->find();
        if(!$result){
            $this->error='信息错误';
            return false;

        }elseif($result['status']!=1){
            $this->error='用户已被禁用';
            return false;
        }else{
            Session::set('manager',$result);
            return $result['id'];

        }

    }

}