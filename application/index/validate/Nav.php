<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/22
 * Time: 13:04
 */

namespace home\index\validate;


use think\Validate;

class Nav extends Validate
{
    protected $rule = [
        'name' => 'require|max:20',
        'parent_id' => 'require|number',
        'url' => 'require|max:30',
    ];

    protected $message = [
        'name.require' => '请填写导航名称',
        'name.max' => '导航名称不能超过10个字符',
        'parent_id.require' => '请选择上级导航',
        'url.require' => '请填写导航地址',
        'url.max' => '导航地址不超过30个字符',
    ];
}