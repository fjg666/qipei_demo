<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $m = $request->getParameter('m');
        if($m){
            $this -> $m();
            return;
        }
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
        $request->setAttribute('range_zfc', isset($range_zfc) ? $range_zfc : '');
        $request->setAttribute('position_zfc', isset($position_zfc) ? $position_zfc : '');
        $request->setAttribute("product", $product);
        $request->setAttribute("product_json", $product_json);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/subtraction.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $mch_id = $this->getContext()->getStorage()->read('mch_id');
        // 接收信息
        $title = $request->getParameter('title'); // 活动标题
        $name = $request->getParameter('name'); // 活动名称
        $subtraction_range = $request->getParameter('subtraction_range'); // 满减应用范围
        $menu_list = $request->getParameter('menu_list'); // 已选项
        $subtraction_type = $request->getParameter('subtraction_type'); // 满减类型

        $start_time = $request->getParameter('start_time'); // 开始时间
        $end_time = $request->getParameter('end_time'); // 结束时间
        $position_zfc = $request->getParameter('position_zfc'); // 显示位置
        $image = $request->getParameter('image');
        $time = date('Y-m-d H:i:s');

        if($title == ''){
            echo json_encode(array('status' =>'活动标题不能为空！' ));exit;
        }else{
            $sql0 = "select title from lkt_subtraction where store_id = '$store_id' and title = '$title'";
            $r0 = $db->select($sql0);
            if($r0){
                echo json_encode(array('status' =>'活动标题已存在！' ));exit;
            }
        }
        if($name == ''){
            echo json_encode(array('status' =>'活动名称不能为空！' ));exit;
        }else{
            $sql1 = "select name from lkt_subtraction where store_id = '$store_id' and name = '$name'";
            $r1 = $db->select($sql1);
            if($r1){
                echo json_encode(array('status' =>'活动名称已存在！' ));exit;
            }
        }
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

                    $subtraction_parameter = implode(',',$result);
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
        $sql2 = "insert into lkt_subtraction(store_id,mch_id,title,name,subtraction_range,subtraction_parameter,subtraction_type,subtraction,starttime,endtime,position_zfc,image,add_date) value ('$store_id','$mch_id','$title','$name','$subtraction_range','$subtraction_parameter','$subtraction_type','$subtraction','$start_time','$end_time','$position_zfc','$image',CURRENT_TIMESTAMP)";
        $r2 = $db->insert($sql2);
        if($r2 == -1 ){
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加满减活动失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加满减活动失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>'未知原因，满减活动添加失败！' ));exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加满减活动成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加满减活动成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' =>'满减活动添加成功！','suc'=>'1' ));exit;
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    public function fenlei(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $product_class = array();
        // 分类下拉选择
        $sql0 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc  ";
        $r0 = $db->select($sql0);
        if ($r0) {
            foreach ($r0 as $k => $v) {
                //循环第一层
                $sql1 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$v->cid' order by sort desc ";
                $r1 = $db->select($sql1);
                if ($r1) {
                    $product_class[] = array('id'=>$v->cid,'pId'=>0,'name'=>$v->pname,'open'=>true);
                    foreach ($r1 as $ke => $ve) {
                        //循环第二层
                        $sql2 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$ve->cid' order by sort desc ";
                        $r2 = $db->select($sql2);
                        if ($r2) {
                            $product_class[] = array('id'=>$ve->cid,'pId'=>$v->cid,'name'=>$ve->pname,'open'=>true);
                            $product_class[] = array('id'=>$r2[0]->cid,'pId'=>$ve->cid,'name'=>$r2[0]->pname);
                        }else{
                            $product_class[] = array('id'=>$ve->cid,'pId'=>$v->cid,'name'=>$ve->pname);
                        }
                    }
                }else{
                    $product_class[] = array('id'=>$v->cid,'pId'=>0,'name'=>$v->pname);
                }
            }
        }
        echo json_encode(array('product_class' => $product_class));
        exit;
    }

    public function pinpai(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $brand_class = array();
        //品牌下拉选择
        $sql0 = "select * from lkt_brand_class where store_id = '$store_id' and recycle = 0";
        $r1 = $db->select($sql0);
        if($r1){
            foreach ($r1 as $k => $v){
                $brand_class[] = array('id'=>$v->brand_id,'pId'=>0,'name'=>$v->brand_name);
            }
        }
        echo json_encode(array('brand_class' => $brand_class));
        exit;
    }

    public function shop_name(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $shop = array();

        $sql0 = "select * from lkt_mch where store_id = '$store_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $shop[] = array('id'=>$v->id,'pId'=>0,'name'=>$v->name);
            }
        }
        echo json_encode(array('shop' => $shop));
        exit;
    }
}

?>