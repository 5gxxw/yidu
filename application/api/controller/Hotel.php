<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/16
 * Time: 13:41
 */
namespace  home\api\controller;
use  think\Controller;
class Hotel extends Controller{
    public function  hotel_list(){
        $model=model('Hotel');
        $where=array(
            'status'=>1,
        );
        $data =$model->getLists($where,10);
        foreach($data as $k=>$v){
            $pic=explode(',',$v['images']);
            foreach($pic as $ke=>$ve){
                $image[$ke]=get_cover($ve,'path');
            }
            $res[$k]['id']=$v['id'];
            $res[$k]['hotel_name']=$v['hotel_name'];
            $res[$k]['price']=$v['price'];
            $res[$k]['picture']=get_cover($v['picture'],'path');
            $res[$k]['images']=$image;
            $res[$k]['descript']=$v['descript'];
        }
        $returnData['code'] = 1;
        $returnData['msg'] = '成功';
        $returnData['data'] = $res;
        exit(json_encode($returnData));
    }
}
