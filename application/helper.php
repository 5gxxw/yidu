<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/3
 * Time: 9:25
 */
use think\Db;
/**
 * 检测是否含in.between
 */

//防注入，字符串处理，禁止构造数组提交
//字符过滤
function safe_replace($string) {
    if(is_array($string)){
        $string=implode('，',$string);
        $string=htmlspecialchars(str_shuffle($string));
    } else{
        $string=htmlspecialchars($string);
    }
    $string = str_replace('%20','',$string);
    $string = str_replace('%27','',$string);
    $string = str_replace('%2527','',$string);
    $string = str_replace('*','',$string);
    $string=str_replace("select","",$string);
    $string=str_replace("join","",$string);
    $string=str_replace("union","",$string);
    $string=str_replace("where","",$string);
    $string=str_replace("insert","",$string);
    $string=str_replace("delete","",$string);
    $string=str_replace("update","",$string);
    $string=str_replace("like","",$string);
    $string=str_replace("drop","",$string);
    $string=str_replace("create","",$string);
    $string=str_replace("modify","",$string);
    $string=str_replace("rename","",$string);
    $string=str_replace("alter","",$string);
    $string=str_replace("cas","",$string);
    $string = str_replace('"','&quot;',$string);
    $string = str_replace("'",'',$string);
    $string = str_replace('"','',$string);
    $string = str_replace(';','',$string);
    $string = str_replace('<','&lt;',$string);
    $string = str_replace('>','&gt;',$string);
    $string = str_replace("{",'',$string);
    $string = str_replace('}','',$string);

    return $string;
}





function upload(){
    $file = request()->file('image');
    $cout =count($file);
    if($cout > 1){
        $info1='';
        foreach($file as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $savename =$info->getFilename();
                $path['path'] ="/public/uploads/$savename";
                Db::name('picture')->insert($path);
                $pictureid = Db::name('picture')->getLastInsID();
                $info1.=$pictureid.",";

            }else{
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
        $picture['complex']=substr($info1,0,-1);

    }else{
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $savename= $info->getSaveName();
            $path['path'] ="/public/uploads/$savename";
            Db::name('picture')->insert($path);
            $picture['odd'] = Db::name('picture')->getLastInsID();


        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

}

function get_cover($cover_id, $field = null){
    if(empty($cover_id)){
        return false;
    }
    $picture = db('Picture')->getById($cover_id);
    if($field == 'path'){
        if(!empty($picture['url'])){
            $picture['path'] = $picture['url'];
        }else{
            $picture['path'] = __ROOT__.$picture['path'];
        }
    }
    return empty($field) ? $picture : $picture[$field];

}
/*
 * 获取房间价格
 * */
function get_hotel_price($id=null){
    $data=Db::name('hotel')->getbyId($id);
    return $data['price'];

}
/*
 * 获取房间价格
 * */
function get_deposit($id=null){
    $data=Db::name('hotel')->getbyId($id);
    $deposit= $data['price']*0.1;
    return  $deposit;

}
/*
 * 获取房间名称
 * */
function get_hotel_name($id=null){
    $data=Db::name('hotel')->getbyId($id);
    $deposit= $data['hotel_name'];
    return  $deposit;

}
/*
 * 获取用户name
 * */
function get_username($id=null){
    $data=Db::name('user')->getbyId($id);
    return $data['username'];
}
/*
 * 获取用户name
 * */
function get_user_phone($id=null){
    $data=Db::name('user')->getbyId($id);
    return $data['phone'];
}
/*
 * 获取房间封面图id
 * */
function get_cover_id($id=null){
    $data=Db::name('hotel')->getbyId($id);
    return $data['picture'];
}


function updata_status($id=null, $status=null, $database=null){
    if($status==1){
        $res= Db::name($database)->where('id='.$id)->setField('status',1);
    }elseif($status==2){
        $res= Db::name($database)->where('id='.$id)->setField('status',2);
    }
    if($res){
        $data['message']='成功';
    }else{
        $data['message']='失败';
    }
    return $data;

}

