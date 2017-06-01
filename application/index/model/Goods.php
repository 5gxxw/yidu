<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/8
 * Time: 9:34
 */

namespace  home\index\model;
use think\Model;

class Goods extends  Model{
    public  function updates($data){
        if(!$data){ //数据对象创建错误
            return false;
        }
        /* 添加或更新数据 */
        if(empty($data['id'])){
//            if(!$validate->check($data)){
//                return $this->error=$validate->getError();
//            }
            $res = $this->insert($data);
        }else{
//            if(!$validate->scene('edit')->check($data)){
//                return $this->error=$validate->getError();
//            }
            $res = $this->update($data);
        }


        return $res;
    }


}