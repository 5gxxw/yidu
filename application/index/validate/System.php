<?php
/**
 * 系统设置-验证器
 */

namespace home\index\validate;

use think\Validate;

class System extends Validate
{
    protected $rule = [
        'name' => 'require|max:25',
        'keyword' => 'max:100',
        'intro' => 'max:160',
        'copyright' => 'require|max:30',
        'record' => 'max:16',
    ];

    protected $message = [
        'name.require' => '请填写网站名称',
        'name.max' => '网站名称不能超过25个字符',
        'keyword.max' => '关键字不能超过100个字符',
        'intro.max' => '描述不能超过160个字符',
        'copyright.require' => '请填写底部版权',
        'copyright.max' => '底部版权不能超过30个字符',
        'record.max' => '备案号长度不超过16个字符'
    ];
}