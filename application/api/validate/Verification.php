<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/9
 * Time: 16:24
 */
namespace home\api\validate;
use think\Validate;
use think\Db;
class Verification extends Validate{

    protected $rule = [
        'username'  =>  'require|max:25',
        'password'  =>  'require|max:16',
        'age'   => 'number|between:1,120',
        'email' =>  'email',
        'phone' =>  ['regex'=>'/^1[3|4|5|8|7][0-9]\d{8}$/']
    ];

    protected $message  =   [
        'username.require' => '名称必须',
        'username.max'     => '名称最多不能超过25个字符',
        'password.require' => '密码必须',
        'password.max'     => '密码最多不能超过16个字符',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',
        'phone.require'       =>'手机号码必须',
        'phone.regex'       =>'手机号码格式不正确'
    ];

    protected $scene = [
        'add'   =>  ['name','email'],
        'edit'  =>  ['email'],
    ];
}

