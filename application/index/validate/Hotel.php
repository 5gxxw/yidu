<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/19
 * Time: 14:16
 */

namespace home\index\validate;


use think\Validate;

class Hotel extends Validate
{
    //验证规则
    protected $rule = [
        'hotel_name' => 'require|max:30',
        'price' => 'require',
        //'descript' => '',
        //'picture' => '',

        /*'start_time' => '',
        'end_time' => '',
        'status' => '',
        'images' => '',
        'file' => '',*/
    ];


    //提示信息
    protected $message = [
        'hotel_name' => '请填写房间名称',
        'price' => '请填写房间价格',
    ];
}