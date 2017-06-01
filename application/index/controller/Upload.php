<?php
namespace home\index\controller;
use home\controller\Initial;
use think\Session;
use think\Request;
use think\Cache;

class Upload extends Initial{
    //构造函数
    public function __construct(){
        //父级构造函数
        parent::__construct();
    }
    //上传单张图片
    public function thumb(){
        //判断是否上传图片方法
        if(request()->isPost()){
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('image');
            // 移动到框架应用根目录/home/uploads/ 目录下  验证上传文件的字节size  后缀名ext
            $info = $file->validate(['size'=>100000,'ext'=>'jpg,png,gif'])->move(UPLOAD_PATH);
            $id = input('param.id');
            if($info){
                // 成功上传后 获取上传信息
                $path = UPLOAD_PATH.$info->getSaveName();
                return "<script>parent.thumb_callback('".$path."',1,".$id.")</script>";
            /*    // 输出 jpg
                echo $info->getExtension();
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getSaveName();
                // 输出 42a79759f284b767dfcb2a0197904287.jpg
                echo $info->getFilename();*/
            }else{
                // 上传失败获取错误信息
                return "<script>parent.thumb_callback('".$file->getError()."',0,".$id.")</script>";
            }
        }else{
            return view();
        }
    }

    //上传多张图片
    public function lot(){

    }

    /**
     * 上传图片
     */
    /*
    public function uploadPicture()
    {
        $verifyToken = md5('unique_salt' . input('post.timestamp'));
        if (!empty(input('file.')) && input('post.token') == $verifyToken){
            // 获取表单上传文件
            $file = request()->file('download');
            //检测文件是否已经上传
            $Picture = model('Picture');
            $info = $Picture->upload($file,config('picture_upload'));

            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file
                ->validate(['ext'=>'jpg,png,gif','size'=>'50000000'])
                ->move(ROOT_PATH . 'home' . DS . 'uploads');

            if($info){
                // 成功上传后 获取上传信息
                $hash = $info->hash('md5');
                $fileName =  $info->getSaveName();
                //保存到数据库


            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }

    }*/

}