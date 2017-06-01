<?php
// +----------------------------------------------------------------------
// | TwoThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.twothink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 艺品网络
// +----------------------------------------------------------------------
namespace home\index\controller;
use think\Controller;

/**
 * 文件控制器
 * 主要用于下载模型的文件上传和下载
 */
class File extends Controller {
    /* 文件上传 */
    public function upload(){
		  $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
      //TODO: 用户登录检测
      /* 调用文件上传组件上传文件 */
      $file = request()->file('download');
      if (empty($file)) {
        $this->error('请选择上传文件');
      }
      $File = model('file');
      $info = $File->upload($file,config('download_upload'));
      /* 记录文件信息 */
      if($info){
        $return['data'] = $info;
      } else {
        $return['status'] = 0;
        $return['info']   = $File->getError();
      }
      /* 返回JSON数据 */
      return json_encode($return);
    }

    /* 下载文件 */
    public function download($id = null){
        if(empty($id) || !is_numeric($id)){
            $this->error('参数错误！');
        }

        $logic = model('Download', 'Logic');
        if(!$logic->download($id)){
            $this->error($logic->getError());
        }

    }

    /**
     * 上传图片
     */
    public function uploadPicture(){
        /* 返回标准数据 */
        $return  = array('status' => 1, 'info' => '上传成功', 'data' => '');
        $verifyToken = md5('unique_salt' . input('post.timestamp'));
        if (!empty(input('file.')) && input('post.token') == $verifyToken){
            //获取上传文件
            $file = request()->file('download');
            $Picture = model('Picture');
            $info = $Picture->upload($file,config('picture_upload'));
            //TODO:上传到远程服务器
            /* 记录图片信息 */
            if($info){
                $return['data'] = $info;
            } else {
                $return['status'] = 0;
                $return['info']   = $Picture->getError();
            }
            /* 返回JSON数据 */
            return json_encode($return);
        }else{
            return '图片上传失败';
        }
    }
}
