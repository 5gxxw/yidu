<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/16
 * Time: 13:43
 */
namespace home\api\model;
use think\Model;
use think\Db;
class Hotel extends Model{
    public function getLists($where,$listrows='',$order=''){
        $list = $this
            ->where($where)
            ->order($order)
            ->paginate($listrows);
        return $list;

    }

}