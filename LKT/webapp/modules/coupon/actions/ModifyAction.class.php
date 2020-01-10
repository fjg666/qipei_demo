<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $id = intval($request->getParameter("id")); // 优惠券id
        $m = $request->getParameter('m');
        if($m){
            $this -> $m();
            return;
        }

        $sql0 = "select limit_type,coupon_type from lkt_coupon_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $limit_type = $r0[0]->limit_type;
            $coupon_type = explode(",", $r0[0]->coupon_type); // 优惠券类型
            foreach ($coupon_type as $k => $v){
                if($v == '1'){
                    $coupon_type_list[$v] = '免邮券';
                }else if($v == '2'){
                    $coupon_type_list[$v] = '满减券';
                }else if($v == '3'){
                    $coupon_type_list[$v] = '折扣券';
                }else if($v == '4'){
                    $coupon_type_list[$v] = '会员赠券';
                }
            }
        }

        $sql1 = "select * from lkt_coupon_activity where id = '$id'";
        $r1 = $db->select($sql1);
        $activity_type = $r1[0]->activity_type; // 优惠券类型
        $name = $r1[0]->name; // 优惠券名称
        $grade_id = $r1[0]->grade_id; // 会员等级ID
        $money = $r1[0]->money; // 优惠券面值
        $discount = $r1[0]->discount; // 折扣值
        $z_money = $r1[0]->z_money; // 消费满多少
        $circulation = $r1[0]->circulation; // 发行数量
        $receive = $r1[0]->receive; // 领取限制
        $start_time = $r1[0]->start_time; // 开始时间
        $end_time = $r1[0]->end_time; // 结束时间
        $type = $r1[0]->type; // 优惠券使用范围 1：全部商品 2:指定商品 3：指定分类
        $product_class_id = $r1[0]->product_class_id; // 活动指定商品分类id
        $product_id = $r1[0]->product_id; // 活动指定商品id
        $skip_type = $r1[0]->skip_type; // 跳转方式 1.首页 2.自定义
        $url = $r1[0]->url; // 跳转路径
        $day = $r1[0]->day; // 有效时间
        $Instructions = $r1[0]->Instructions; // 使用说明

        if($activity_type == 4){
            if($money != '0' && $discount == '0'){
                $type_type = 1;
            }else{
                $type_type = 2;
            }
        }else{
            $type_type = 1;
        }
        $product_class_name = '';
        if($product_class_id != ''){
            $product_class_id = unserialize($product_class_id);
            $product_class_list = explode(',',$product_class_id);
            foreach ($product_class_list as $k => $v){
                $sql2 = "select pname from lkt_product_class where cid = '$v'";
                $r2 = $db->select($sql2);
                if($r2){
                    $product_class_name .= $r2[0]->pname . ',';
                }
            }
            $product_class_name = trim($product_class_name,',');
        }
        $product_name = '';
        if($product_id != ''){
            $product_id = unserialize($product_id);
            $product_id_list = explode(',',$product_id);
            foreach ($product_id_list as $k => $v){
                $sql2 = "select product_title from lkt_product_list where id = '$v'";
                $r2 = $db->select($sql2);
                if($r2){
                    $product_name .= $r2[0]->product_title . ',';
                }
            }
            $product_name = trim($product_name,',');
        }

        $sql = "select id,name from lkt_user_grade where store_id = '$store_id' order by rate desc ";
        $res = $db->select($sql);

        $request->setAttribute('id', $id);
        $request->setAttribute('coupon_type', isset($coupon_type_list) ? $coupon_type_list : '');
        $request->setAttribute('limit_type', isset($limit_type) ? $limit_type : '');
        $request->setAttribute("activity_type",$activity_type);
        $request->setAttribute("name",isset($name) ? $name : '');
        $request->setAttribute("grade_id",isset($grade_id) ? $grade_id : '');
        $request->setAttribute('money', isset($money) ? $money : '');
        $request->setAttribute('discount', isset($discount) ? $discount : '');
        $request->setAttribute('z_money', isset($z_money) ? $z_money : '');
        $request->setAttribute('circulation', isset($circulation) ? $circulation : '');
        $request->setAttribute('type', isset($type) ? $type : '');
        $request->setAttribute('skip_type', isset($skip_type) ? $skip_type : '');
        $request->setAttribute('url', isset($url) ? $url : '');
        $request->setAttribute('day', isset($day) ? $day : '');
        $request->setAttribute('Instructions', isset($Instructions) ? $Instructions : '');
        $request->setAttribute('start_time', isset($start_time) ? $start_time : '');
        $request->setAttribute('end_time', isset($end_time) ? $end_time : '');
        $request->setAttribute('receive', isset($receive) ? $receive : '');

        $request->setAttribute('product_class_name', isset($product_class_name) ? $product_class_name : '');
        $request->setAttribute('product_name', isset($product_name) ? $product_name : '');
        $request->setAttribute('res', isset($res) ? $res : '');
        $request->setAttribute('type_type', isset($type_type) ? $type_type : '');

        return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/coupon.log");
        // 1.开启事务
        $db->begin();

		$request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收数据
        $id = addslashes(trim($request->getParameter('id'))); // 活动id
        $activity_type = addslashes(trim($request->getParameter('activity_type'))); // 活动类型
//        $name = addslashes(trim($request->getParameter('name'))); // 活动名称
        $circulation = addslashes(trim($request->getParameter('circulation'))); // 发行数量
        $grade = addslashes(trim($request->getParameter('grade'))); // 会员等级
        $type_type = addslashes(trim($request->getParameter('type_type'))); // 类型
        $money = addslashes(trim($request->getParameter('money'))); // 优惠券面值
        $discount = addslashes(trim($request->getParameter('discount'))); // 折扣值
        $z_money = addslashes(trim($request->getParameter('z_money'))); // 满多少
        $type = $request->getParameter('type'); // 优惠券使用范围
        $skip_type = addslashes(trim($request->getParameter('skip_type'))); // 跳转方式
        $url = addslashes(trim($request->getParameter('url'))); // 跳转路径
        $start_time = $request->getParameter('start_time'); // 活动开始时间
        $end_time = $request->getParameter('end_time'); // 活动结束时间
        $receive = addslashes(trim($request->getParameter('receive'))); // 领取限制
        $menu_list = addslashes(trim($request->getParameter('menu_list'))); // 已选项
        $day  = addslashes(trim($request->getParameter('day'))); // 已选项
        $Instructions  = addslashes(trim($request->getParameter('Instructions'))); // 使用说明

        $time = date('Y-m-d H:i:s');

        if($activity_type == '' || $activity_type == 0){
            echo json_encode(array('status' =>'请选择优惠券类型！' ));exit;
        }else{
            if($activity_type == 1){
                $this->Verification($z_money);
                $arr = $this->circulation($db,$id,$circulation);
                $circulation = $arr['circulation'];
                $num = $arr['num'];
                $receive = $this->receive($db,$store_id,$receive);
                $money = 0;
                $discount = 0;
                $day = 0;
            }else if($activity_type == 2){
                if($money == ''){
                    echo json_encode(array('status' =>'优惠券面值不能为空！' ));exit;
                }else{
                    if(is_numeric($money)){
                        $money = round($money,2);
                        if($money <= 0){
                            echo json_encode(array('status' =>'优惠券面值不能小于等于0！' ));exit;
                        }
                    }else{
                        echo json_encode(array('status' =>'优惠券面值请填写数字！' ));exit;
                    }
                }
                $this->Verification($z_money,$money);
                $arr = $this->circulation($db,$id,$circulation);
                $circulation = $arr['circulation'];
                $num = $arr['num'];
                $receive = $this->receive($db,$store_id,$receive);
                $discount = 0;
                $day = 0;
            }else if($activity_type == 3){
                if($discount == ''){
                    echo json_encode(array('status' =>'折扣值不能为空！' ));exit;
                }else{
                    if(is_numeric($discount)){

                        $discount = round($discount,2);
                        if($discount <= 0 || $discount >= 10){
                            echo json_encode(array('status' =>'折扣值不能不正确！' ));exit;
                        }
                    }else{
                        echo json_encode(array('status' =>'折扣值请填写数字！' ));exit;
                    }
                }
                $this->Verification($z_money);
                $arr = $this->circulation($db,$id,$circulation);
                $circulation = $arr['circulation'];
                $num = $arr['num'];
                $receive = $this->receive($db,$store_id,$receive);
                $money = 0;
                $day = 0;
            }else if($activity_type == 4){
                if($grade == ''){
                    echo json_encode(array('status' =>'请选择会员等级！' ));exit;
                }
                if($type_type == 1){
                    if($money == ''){
                        echo json_encode(array('status' =>'优惠券面值不能为空！' ));exit;
                    }else{
                        if(is_numeric($money)){
                            $money = round($money,2);
                            if($money <= 0){
                                echo json_encode(array('status' =>'优惠券面值不能小于等于0！' ));exit;
                            }
                        }else{
                            echo json_encode(array('status' =>'优惠券面值请填写数字！' ));exit;
                        }
                    }
                    $this->Verification($z_money,$money);
                    $discount = 0;
                }else{
                    if($discount == ''){
                        echo json_encode(array('status' =>'折扣值不能为空！' ));exit;
                    }else{
                        if(is_numeric($discount)){
                            $discount = round($discount,2);
                            if($discount <= 0 || $discount >= 10){
                                echo json_encode(array('status' =>'折扣值不能不正确！' ));exit;
                            }
                        }else{
                            echo json_encode(array('status' =>'折扣值请填写数字！' ));exit;
                        }
                    }
                    $this->Verification($z_money);
                    $money = 0;
                }
                if($day == ''){
                    echo json_encode(array('status' =>'有效时间不能为空！' ));exit;
                }else{
                    if (floor($day) != $day){
                        echo json_encode(array('status' =>'有效时间请填写整数！' ));exit;
                    }else{
                        if($day <= 0){
                            echo json_encode(array('status' =>'有效时间请填写正整数！' ));exit;
                        }

                    }
                }
                $circulation = 999999999;
                $num = 999999999;
                $receive = 1;
            }
        }

        $product_id = '';
        $product_class_id = '';
        if($type == 2){
            if($menu_list == ''){
                echo json_encode(array('status' =>'请选择商品！' ));exit;
            }else{
                $list = explode(',',$menu_list);
                $productid_list = array();
                foreach ($list as $k => $v){
                    $sql1 = "select id from lkt_product_list where store_id = '$store_id' and recycle = 0 and product_title = '$v'";
                    $r1 = $db->select($sql1);
                    if($r1){
                        $productid_list[] = $r1[0]->id;
                    }
                }
                $productid = implode(',',$productid_list);
                $product_id = serialize($productid);
            }
        }else if($type == 3){
            if($menu_list == ''){
                echo json_encode(array('status' =>'请选择商品分类！' ));exit;
            }else{
                $list = explode(',',$menu_list);
                $product_classid_list = array();
                foreach ($list as $k => $v){
                    $sql1 = "select cid from lkt_product_class where store_id = '$store_id' and recycle = 0 and pname = '$v'";
                    $r1 = $db->select($sql1);
                    if($r1){
                        $product_classid_list[] = $r1[0]->cid;
                    }
                }
                $product_classid = implode(',',$product_classid_list);
                $product_class_id = serialize($product_classid);
            }
        }

        $time1 = $this->time($start_time,$end_time,$time,$activity_type);
        $start_time = $time1['start_time'];
        $end_time = $time1['end_time'];

        if($skip_type == 1){
            $url = '/pages/tabBar/home';
        }

        $sql0 = "select money,end_time from lkt_coupon_activity where store_id = '$store_id' and id = '$id'";
        $r0 = $db->select($sql0);
        $money1 = $r0[0]->money; // 原面值
        $end_time1 = $r0[0]->end_time; // 原到期时间
        $rew = ',status = 0';
        if($money1 != $money){
            $rew .= ",money = '$money'";
        }
        if($activity_type != 4){
            if($end_time1 != $end_time){
                $rew .= ",expiry_time = '$end_time'";
            }
        }

        if($start_time > $time){
            $sql = "update lkt_coupon_activity set activity_type = '$activity_type',grade_id = '$grade',money = '$money',discount = '$discount',z_money = '$z_money', circulation = '$circulation',num = '$num',receive = '$receive',start_time = '$start_time', end_time = '$end_time',type = '$type',product_class_id = '$product_class_id',product_id = '$product_id', add_time = CURRENT_TIMESTAMP,status = 0,skip_type = '$skip_type',url = '$url',day = '$day',Instructions = '$Instructions' where store_id = '$store_id' and id = '$id'";
        }else{
            $sql = "update lkt_coupon_activity set activity_type = '$activity_type',grade_id = '$grade',money = '$money',discount = '$discount',z_money = '$z_money', circulation = '$circulation',num = '$num',receive = '$receive',start_time = '$start_time', end_time = '$end_time',type = '$type',product_class_id = '$product_class_id',product_id = '$product_id', add_time = CURRENT_TIMESTAMP,status = 1,skip_type = '$skip_type',url = '$url',day = '$day',Instructions = '$Instructions' where store_id = '$store_id' and id = '$id'";
        }
        $r = $db->update($sql);

        $rew = ltrim($rew, ",");

        if($r == -1) {
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改优惠券活动id为 '.$id.' 失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改优惠券活动id为 '.$id.' 失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

			echo json_encode(array('status' => '未知原因，优惠券修改失败！'));exit;
        } else {
            if($rew != ''){
                $sql1 = "update lkt_coupon set $rew where store_id = '$store_id' and hid = '$id'";
                $r1 = $db->update($sql1);
                if($r1 == -1){
                    $JurisdictionAction->admin_record($store_id,$admin_name,'修改优惠券活动id为 '.$id.' 的优惠券失败',2);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改优惠券活动id为 '.$id.' 的优惠券失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('status' => '未知原因，优惠券修改失败！'));exit;
                }
            }
            // 根据商城id、类型为禁用中、活动id,查询优惠券信息
            $sql1 = "select id,expiry_time from lkt_coupon where store_id = '$store_id' and status = 1 and hid = '$id'";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    // 根据商城ID、优惠券ID,查询订单信息
                    $sql = "select id from lkt_order where store_id = '$store_id' and coupon_id = '$v->id'";
                    $rrr = $db->select($sql);
                    if(empty($rrr)){ // 没有数据，表示该优惠券还未使用
                        if($v->expiry_time <= $time){ // 优惠券有效期 <= 当前时间
                            $sql1 = "update lkt_coupon set type = 3 where store_id = '$store_id' and id = '$v->id'";
                        }else{
                            $sql1 = "update lkt_coupon set type = 1 where store_id = '$store_id' and id = '$v->id'";
                        }
                    }else{ // 有数据，表示该优惠券还已使用
                        $sql1 = "update lkt_coupon set type = 2 where store_id = '$store_id' and id = '$v->id'";
                    }
                    $db->update($sql1);
                }
            }
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改优惠券活动id为 '.$id.' 成功',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改优惠券活动id为 '.$id.' 成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

			echo json_encode(array('status' =>'优惠券修改成功！','suc'=>'1' ));exit;
        }
		return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
    // 验证使用门槛
    public function Verification($z_money,$money=''){
        if($money == ''){
            if($z_money == ''){
                echo json_encode(array('status' =>'优惠券使用门槛不能为空！' ));exit;
            }else{
                if(is_numeric($z_money)){
                    $z_money = round($z_money,2);
                    if($z_money < 0){
                        echo json_encode(array('status' =>'优惠券使用门槛数值不正确！' ));exit;
                    }
                }else{
                    echo json_encode(array('status' =>'优惠券使用门槛请填写数字！' ));exit;
                }
            }
        }else{
            if($z_money == ''){
                echo json_encode(array('status' =>'优惠券使用门槛不能为空！' ));exit;
            }else{
                if(is_numeric($z_money)){
                    $z_money = round($z_money,2);
                    if($z_money < 0 || $z_money != 0 && $z_money <= $money){
                        echo json_encode(array('status' =>'优惠券使用门槛数值不正确！' ));exit;
                    }
                }else{
                    echo json_encode(array('status' =>'优惠券使用门槛请填写数字！' ));exit;
                }
            }
        }
    }
    // 验证发行量
    public function circulation($db,$id,$circulation){
        if($circulation == ''){
            echo json_encode(array('status' =>'优惠券发行数量不能为空！' ));exit;
        }else{
            if(!is_numeric($circulation) || strpos($circulation,".")!==false){
                echo json_encode(array('status' =>'优惠券发行数量请填写整数！' ));exit;
            }else{
                $sql = "select id from lkt_coupon where hid = '$id'";
                $r_r = $db->select($sql);
                $receive_num = count($r_r);

                if($circulation == 0){
                    $num = 999999999 - $receive_num;
                }else{
                    if($circulation <= $receive_num){
                        echo json_encode(array('status' =>'优惠券发行数量请填写大于'.$receive_num.'的整数！' ));exit;
                    }
                    $num = $circulation - $receive_num;
                }
            }
        }
        $arr = array('circulation' => $circulation,'num' => $num);
        return $arr;
    }
    // 验证时间
    public function time($start_time,$end_time,$time,$activity_type){
        if($activity_type == 4){
            $start_time = $time;
            $end_time = date('Y-m-d H:i:s',strtotime('+10 year',strtotime($time)));
        }else{
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
        }
        $time = array('start_time' => $start_time,'end_time' => $end_time);
        return $time;
    }
    // 验证领取限制
    public function receive($db,$store_id,$receive){
        $sql2 = "select limit_type from lkt_coupon_config where store_id = '$store_id'";
        $r2 = $db->select($sql2);

        if($r2){
            if($r2[0]->limit_type == 0){
                $receive = 1;
            }else{
                if($receive == ''){
                    echo json_encode(array('status' =>'领取限制不能为空！' ));exit;
                }else{
                    if(!is_numeric($receive) || strpos($receive,".")!==false){
                        echo json_encode(array('status' =>'领取限制请填写整数！' ));exit;
                    }else{
                        if($receive <= 0){
                            echo json_encode(array('status' =>'领取限制请填写大于0的整数！' ));exit;
                        }
                    }
                }
            }
        }
        return $receive;
    }
}
?>