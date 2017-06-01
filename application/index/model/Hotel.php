<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/3
 * Time: 15:49
 */

namespace  home\index\model;
use think\Model;
class Hotel extends Model{

    public function updates($data){
        //验证数据
        $validate = validate('Hotel');
        if(!$validate->check($data)){
            $this->error = $validate->getError();
            return false;
        }

        /* 添加或更新数据 */
        if (empty($data['id'])){
            $this->insert($data);
            return '添加成功！';
        }else{
            $this->update($data);
            return '更新成功!';
        }

    }

}