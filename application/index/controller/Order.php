<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/4
 * Time: 9:12
 */
namespace home\index\controller;
use think\Controller;
use think\Db;

class  Order extends  Controller{

    /*
     * 酒店订单管理
     *
     * **/
    public function hotel_order(){
        $data= Db::name('HotelOrder')->select();
        $this->assign('hotelorder',$data);
        return $this->fetch();
    }

    public function  hotel_del ($id=null){
        $info= Db::name('HotelOrder')->where('id='.$id)->delete();
        if($info){
            $this->success('删除成功！', url('hotel_order'));
        }else{
            $this->error(empty($error) ? '未知错误！' : $error);
        }
    }

    /*
     * 商品订单管理
     *
     * **/
    public function goods_order(){
        $data = Db::name('goodsOrder')->select();

    }


}