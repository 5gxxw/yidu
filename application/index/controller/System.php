<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/17
 * Time: 14:25
 */

namespace home\index\controller;


use think\Controller;
use think\Db;
use think\Loader;
use think\Request;

class System extends Controller
{
    public function category(){

        return $this->fetch();
    }

    /**
     * 系统设置 - 网站设置
     */
    public function siteSetting(){
        if (request()->isPost()){
            if (!$data = input('post.')){
                return '数据对象创建错误';
            }
            $system = model('System');
            //添加或更新，失败返回false，成功返回提示信息
            $result = $system->updates($data);
            if ($result == false){
                return $this->error($system->getError());
            }
            return $this->success($result);
        }else{
            $data = Db::name('system')->find();
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
}