<?php
/*namespace home\index\controller;
use home\controller\Initial;
use think\Session;
use think\Request;
use think\Cache;

class System extends Initial{
    //构造函数
    public function __construct(){
        //父级构造函数
        parent::__construct();
    }
    //系统设置
    public function index(){
        return view();
    }
    public function test(){
// 指明给谁推送，为空表示向所有在线用户推送
        $to_uid = "";
// 推送的url地址，使用自己的服务器地址
        $push_api_url = "http://www.yidu.com:2121/";
        $post_data = array(
            "type" => "publish",
            "content" => "这个是推送的测试数据",
            "to" => $to_uid,
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $push_api_url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        var_export($return);
        return view();
    }

}*/