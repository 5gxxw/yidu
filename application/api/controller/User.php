<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/9
 * Time: 9:29
 */
namespace  home\api\controller;
use home\api\model\UserMember;
use think\Controller;
use think\Db;
use think\Validate;
use think\Session;

class User extends  Controller{

    //需要返回的格式
    public $returnData = [
        'code' => 0,    //状态码
        'msg' => '',    //提示信息
        'data' => '',   //需要返回的数据
    ];

    /**
     * 用户注册
     */
    public function  register($username='',$password='',$repassword='',$phone='',$age=''){
        $username = safe_replace($username);//过滤
        $result=Db::name('user')->where('phone='.$phone)->count();
        if($result){
            $this->returnData['msg'] = '手机号码已注册';
            return $this->returnData;
        }

        if($password != $repassword){
            $this->returnData['msg'] = '两次密码不一致！';
            return $this->returnData;
        }
        if(empty($username)){
            $username = 'yidu_'.date('YmdHis').mt_rand(1,100);
        }
        $data=array(
            'username' => $username,
            'password' => $password,
            'create_time' => time(),
            'phone' => $phone,
            'age' => $age,
        );
        //验证
        $result = $this->validate($data,'Verification');
        if(true !== $result){
            // 验证失败 输出错误信息
            $returnData['code'] = 0;
        //    $returnData['message'] = $this->showRegError($user);
            $returnData['msg'] =$result;
            $returnData['data'] = (object)array();
            exit(json_encode($returnData));
        }
        $user=model('UserMember')->register($username,$password,$phone,$age);
        if($user){
            //$this->login($username, $password,"",'注册成功',1);
            $returnData['code'] = 0;
            $returnData['msg'] = '注册成功';
            $returnData['data'] = $_REQUEST;//(object)array();
            exit(json_encode($returnData));
        }else{
            $returnData['code'] = 0;
            $returnData['msg'] ='注册失败' ;
            $returnData['data'] = (object)array();
            exit(json_encode($returnData));
        }


    }
      /*
       * 用户登录
       * */
    public function  login($data){
        $ruslte=model('UserMember');
        $uid=$ruslte->login($data);
        if($uid>=1){
            $whereData['id'] = $uid;
            $userinfo=Db::name('user')->where($whereData)->select();
            $returnData['flag'] = 1;
            $returnData['message'] ='登录成功';
            $returnData['responseList'] = $userinfo;
            exit(json_encode($returnData));
        }else{
            $returnData['flag'] = 0;
            $returnData['message'] =$ruslte->getError();
            $returnData['responseList'] = (object)array();
            exit(json_encode($returnData));
        }


    }
/*
 * 退出登录
 * */
    public function outlogin(){
        Session::clear();
        $returnData['flag'] = 0;
        $returnData['message'] ='退出成功';
        $returnData['responseList'] = (object)array();
        exit(json_encode($returnData));
    }





















    /**
     * 获取用户注册错误信息
     * @param  integer $code 错误编码
     * @return string        错误信息
     */
    private function showRegError($code = 0){
        switch ($code) {
            case -1:  $error = "用户名长度必须在16个字符以内！"; break;
            case -2:  $error = "用户名被禁止注册！"; break;
            case -3:  $error = "用户名被占用！"; break;
            case -4:  $error = "密码长度必须在6-30个字符之间！"; break;
            case -5:  $error = "邮箱格式不正确！"; break;
            case -6:  $error = "邮箱长度必须在1-32个字符之间！"; break;
            case -7:  $error = "邮箱被禁止注册！"; break;
            case -8:  $error = "邮箱被占用！"; break;
            case -9:  $error = "手机格式不正确！"; break;
            case -10: $error = "手机被禁止注册！"; break;
            case -11: $error = "手机号被占用！"; break;
            default:  $error = "未知错误";
        }
        return $error;
    }
}