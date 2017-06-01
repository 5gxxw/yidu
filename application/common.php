<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Session;
//缓存php文件  $data 缓存的数据  $filename 缓存的文件名
function F($filename,$operate='get',$data=null){
    switch($operate){
        //存缓存
        case 'put':
            if(!$filename) return null;
            $filename = Cache_PATH.$filename;
            $dir = preg_replace('/(.*)\/{1}([^\/]*)/i', '$1', $filename);
            if(!is_dir($dir)) mkdir($dir);
            $open = fopen($filename,'w');
            fwrite($open,serialize($data));
            fclose($open);
            break;
        //取缓存
        case 'get':
            $filename = Cache_PATH.$filename;
            if(!file_exists($filename)) return null;
            $return = file_get_contents($filename);
            $return = unserialize($return);
            return $return;
            break;
        default:
            return null;
        break;
    }
}
