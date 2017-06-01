<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/18
 * Time: 9:28
 */

namespace home\index\model;


use think\Model;
use think\Validate;

class System extends Model
{

    /**
     * 新增或更新
     * @param $data
     */
    public function updates($data){
        //验证数据
        $validate = validate('System');
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