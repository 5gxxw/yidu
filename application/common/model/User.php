<?php
namespace home\common\model;
use think\Model;
use think\Validate;
use think\Session;
class User extends Model{
    public $table = 'admin';
    //构造函数
    public function __construct(){

    }
    //用户登录
    public function login($data){
        //判断验证码
        //if(!captcha_check($data['verify'])) return array('status'=>0,'message'=>'验证码错误');
        //验证规则
        $rule = [
            'username'  => 'require|max:10|min:2',
            'password'   => 'require',
        ];
        $msg = [
            'username.require' => '请填写用户名',
            'username.max'     => '用户名只能在2-10个字符之间',
            'username.min'     => '用户名只能在2-10个字符之间',
            'password.require'   => '请填写密码',
        ];
        //验证方法
        $validate = new Validate($rule, $msg);
        $validate->check($data);
        if($validate->getError()){
            return array('status'=>0,'message'=>$validate->getError());
        }else{
            //调取数据库数据
            $where = array(
                'username' => $data['username'],
                'password' => sha1('xq_'.md5($data['password']).'cms'),
            );
            $result = db($this->table)->where($where)->find();
            unset($result['password']);
            Session::set('manager',$result);
            return empty($result) ? array('status'=>0,'message'=>'用户名或者密码错误') : array('status'=>1,'message'=>'登录成功');
        }
    }





}
