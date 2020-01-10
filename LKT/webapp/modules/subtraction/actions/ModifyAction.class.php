<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = addslashes(trim($request->getParameter('id'))); // 活动id
        $range_zfc = array();
        $position_zfc = array();
        $product = array();
        $sql0 = "select * from lkt_subtraction_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $range_zfc = $r0[0]->range_zfc;
            $pro_id = $r0[0]->pro_id;
            $position_zfc = $r0[0]->position_zfc;

            $range_zfc = explode(',',$range_zfc);
            $pro_id = explode(',',$pro_id);
            $position_zfc = explode(',',$position_zfc);
            foreach ($pro_id as $k => $v){
                $sql1 = "select id,product_title from lkt_product_list where store_id = '$store_id' and id = '$v' and num > 0";
                $r1 = $db->select($sql1);
                if($r1){
                    $product[] = $r1[0];
                }
            }
        }
        $product_json = json_encode($product);

        $sql1 = "select * from lkt_subtraction where store_id='$store_id' and id = $id";
        $r1 = $db->select($sql1);
        $title = $r1[0]->title;
        $name = $r1[0]->name;
        $subtraction_range = $r1[0]->subtraction_range;
        $subtraction_parameter = explode(',',$r1[0]->subtraction_parameter);
        $subtraction_type = $r1[0]->subtraction_type;
        $subtraction = json_encode(unserialize($r1[0]->subtraction));
        $starttime = $r1[0]->starttime;
        $endtime = $r1[0]->endtime;
        $position_zfc1 = $r1[0]->position_zfc;
        $image = $r1[0]->image;
        $list = array();
        foreach ($subtraction_parameter as $k => $v){
            if($subtraction_range == 1){
                $sql3 = "select pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$v'";
                $r3 = $db->select($sql3);
                if($r3){
                    $list[] = $r3[0]->pname;
                }
            }else if($subtraction_range == 3){
                $sql3 = "select brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and brand_id = '$v'";
                $r3 = $db->select($sql3);
                if($r3){
                    $list[] = $r3[0]->brand_name;
                }
            }else if($subtraction_range == 4){
                $sql3 = "select name from lkt_mch where store_id = '$store_id' and id = '$v'";
                $r3 = $db->select($sql3);
                if($r3){
                    $list[] = $r3[0]->name;
                }
            }
        }
        $subtraction_parameter = implode(',',$list);

        $request->setAttribute("id", $id);
        $request->setAttribute("range_zfc", $range_zfc);
        $request->setAttribute("position_zfc", $position_zfc);
        $request->setAttribute("product", $product);
        $request->setAttribute("product_json", $product_json);

        $request->setAttribute("title", $title);
        $request->setAttribute("name", $name);
        $request->setAttribute("subtraction_range", $subtraction_range);
        $request->setAttribute("subtraction_parameter", $subtraction_parameter);
        $request->setAttribute("subtraction_type", $subtraction_type);
        $request->setAttribute("subtraction", $subtraction);
        $request->setAttribute("starttime", $starttime);
        $request->setAttribute("endtime", $endtime);
        $request->setAttribute("position_zfc1", $position_zfc1);
        $request->setAttribute("image", $image);
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/subtraction.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        // 接收信息
        $id = addslashes(trim($request->getParameter('id'))); // 活动id
        $subtraction_range = $request->getParameter('subtraction_range'); // 满减应用范围
        $menu_list = $request->getParameter('menu_list'); // 已选项
        $subtraction_type = $request->getParameter('subtraction_type'); // 满减类型

        $start_time = $request->getParameter('start_time'); // 开始时间
        $end_time = $request->getParameter('end_time'); // 结束时间
        $position_zfc = $request->getParameter('position_zfc'); // 显示位置
        $image = $request->getParameter('image');
        $time = date('Y-m-d H:i:s');

        if($subtraction_range == ''){
            echo json_encode(array('status' =>'满减应用范围不能为空！' ));exit;
        }else{
            if($subtraction_range != 2){
                if($menu_list == ''){
                    echo json_encode(array('status' =>'满减应用范围不能为空！' ));exit;
                }else{
                    $menu_list = explode(',',$menu_list);
                    $list = array();
                    foreach ($menu_list as $k => $v){
                        if($subtraction_range == 1){
                            $sql3 = "select cid from lkt_product_class where store_id = '$store_id' and recycle = 0 and pname = '$v'";
                            $r3 = $db->select($sql3);
                            if($r3){
                                $list[] = $r3[0]->cid;
                            }
                        }else if($subtraction_range == 3){
                            $sql3 = "select brand_id from lkt_brand_class where store_id = '$store_id' and recycle = 0 and brand_name = '$v'";
                            $r3 = $db->select($sql3);
                            if($r3){
                                $list[] = $r3[0]->brand_id;
                            }
                        }else if($subtraction_range == 4){
                            $sql3 = "select id from lkt_mch where store_id = '$store_id' and name = '$v'";
                            $r3 = $db->select($sql3);
                            if($r3){
                                $list[] = $r3[0]->id;
                            }
                        }
                    }
                    $result = array_unique($list);
                    $subtraction_parameter = implode(',',$list);
                }
            }else{
                $subtraction_parameter = '';
            }
        }
        if($subtraction_type == '' || $subtraction_type == '0'){
            echo json_encode(array('status' =>'满减类型不能为空！' ));exit;
        }

        if($start_time == ''){
            echo json_encode(array('status' =>'优惠券生效开始时间不能为空！' ));exit;
        }else{
            if($start_time == date("Y-m-d 00:00:00")){
                $start_time = $start_time;
            }else{
                $start_time = $start_time;
            }
        }
        if($end_time == ''){
            echo json_encode(array('status' =>'优惠券生效结束时间不能为空！' ));exit;
        }else{
            if($end_time == date("Y-m-d 00:00:00",strtotime($end_time))){
                $end_time = date("Y-m-d 23:59:59",strtotime($end_time));
            }else{
                $end_time = $end_time;
            }
        }

        if($start_time >= $end_time){
            echo json_encode(array('status' =>'优惠券生效时间不正确！' ));exit;
        }
        if($time >= $end_time){
            echo json_encode(array('status' => '请设置优惠券生效结束时间！'));exit;
        }
        if($start_time <= $time && $time < $end_time){
            $status = 2;
        }else if($time < $start_time){
            $status = 1;
        }else if($end_time <= $time){
            $status = 4;
        }
        $subtraction = array();
        if($subtraction_type == 1){
            $full = $request->getParameter('full'); // 单笔订单满
            $reduce = $request->getParameter('reduce'); // 立减
            foreach ($full as $k => $v){
                $full[$k] = round($full[$k],2);
                $reduce[$k] = round($reduce[$k],2);
                if($full[$k] > 0 && $reduce[$k] > 0){
                    $subtraction[$full[$k]] = $reduce[$k];
                }else{
                    echo json_encode(array('status' =>'单笔订单满或立减不正确！' ));exit;
                }
            }
        }else if($subtraction_type == 2){
            $purchase_man = $request->getParameter('purchase_man'); // 购物每满
            $discount = $request->getParameter('discount'); // 优惠

            $purchase_man = round($purchase_man,2);
            $discount = round($discount,2);
            if($purchase_man > 0 && $discount > 0){
                $subtraction[$purchase_man] = $discount;
            }else{
                echo json_encode(array('status' =>'购物每满或优惠不正确！' ));exit;
            }
        }else if($subtraction_type == 3){
            $purchase = $request->getParameter('purchase'); // 单笔订单满
            $product = $request->getParameter('product'); // 赠送商品

            foreach ($purchase as $k => $v){
                $purchase[$k] = round($purchase[$k],2);
                $product[$k] = round($product[$k],2);
                if($purchase[$k] > 0){
                    $subtraction[$purchase[$k]] = $product[$k];
                }else{
                    echo json_encode(array('status' =>'单笔订单满不正确！' ));exit;
                }
            }
        }else if($subtraction_type == 4){
            $purchase_jian = $request->getParameter('purchase_jian'); // 购买
            $fracture = $request->getParameter('fracture'); // 享受
            $fracture = round($fracture,2);
            if($fracture <= 0 || $fracture >= 10){
                echo json_encode(array('status' =>'折扣值不能不正确！' ));exit;
            }
            if((floor($purchase_jian)- $purchase_jian) == 0){
                if($purchase_jian > 0){
                    $subtraction[$purchase_jian] = $fracture;
                }else{
                    echo json_encode(array('status' =>'折扣值不正确！' ));exit;
                }
            }else{
                echo json_encode(array('status' =>'件数不正确！' ));exit;
            }
        }
        $subtraction = serialize($subtraction);

        $sql0 = "update lkt_subtraction set  subtraction_range = '$subtraction_range',subtraction_parameter = '$subtraction_parameter',subtraction_type = '$subtraction_type',subtraction = '$subtraction',starttime = '$start_time',endtime = '$end_time',position_zfc = '$position_zfc',image = '$image',status = '$status',add_date = CURRENT_TIMESTAMP where store_id = '$store_id' and id = '$id'";
        $r0 = $db->update($sql0);
        if($r0 == -1){
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改满减活动id为 '.$id.' 失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改满减活动id为 '.$id.' 失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '未知原因，满减活动修改失败！'));exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改满减活动id为 '.$id.' 成功',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改满减活动id为 '.$id.' 成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' =>'满减活动修改成功！','suc'=>'1' ));exit;
        }
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>