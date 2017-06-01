<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/22
 * Time: 13:29
 */

namespace home\index\model;


use think\Model;

class Nav extends Model
{
    public function updates($data)
    {
        $validate = validate('Nav');
        if (!$validate->check($data)){
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