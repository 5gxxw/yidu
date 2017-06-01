<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 后台入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');
//缓存文件夹
define('CACHE_PATH', __DIR__ . '/../application/cache/');
//图片文件夹
define('UPLOAD_PATH',__DIR__ . '/../home/upload/');
// 定义__ROOT__
if (!defined('__ROOT__')) {
    $_root = rtrim(dirname(rtrim($_SERVER['SCRIPT_NAME'], '/')), '/');
    define('__ROOT__', (('/' == $_root || '\\' == $_root) ? '' : $_root));
}

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
