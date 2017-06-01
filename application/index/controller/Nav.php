<?php
/**
 * 导航管理
 */

namespace home\index\controller;


use think\Controller;
use think\Db;

class Nav extends Controller
{
    /**
     * 导航列表
     */
    public function index()
    {
        //查询出所有导航
        $model = Db::name('nav')->select();

        $model = json_encode($model);
        $this->assign('model',$model);
        return $this->fetch();
    }

    /**
     * 添加导航
     * @return mixed
     */
    public function add()
    {
        if (request()->isPost()){
            //验证
            $data = input('post.');
            //保存导航信息
            $nav = model('Nav');
            $result = $nav->updates($data);
            if ($result){
                $this->success($result,'Nav/index',$data);
            }else{
                $this->error($nav->getError());
            }
        }else{
            $parent_id = input('get.id');
            $this->assign('parent_id',$parent_id);
            return $this->fetch();
        }
    }
}