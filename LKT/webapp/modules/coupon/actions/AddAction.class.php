<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/21 14:48
     * @version 1.
     *
     */
	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $m = $request->getParameter('m');
        if($m){
            $this -> $m();
            return;
        }

        $sql = "select limit_type,coupon_type from lkt_coupon_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        if($r_1){
            $limit_type = $r_1[0]->limit_type;
            $coupon_type = explode(",", $r_1[0]->coupon_type); // 优惠券类型
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
        $sql = "select id,name from lkt_user_grade where store_id = '$store_id' order by rate desc ";
        $res = $db->select($sql);

        $request->setAttribute('coupon_type', isset($coupon_type_list) ? $coupon_type_list : '');
        $request->setAttribute('limit_type', isset($limit_type) ? $limit_type : '');
        $request->setAttribute('res', isset($res) ? $res : '');
        return View :: INPUT;
	}
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/21 14:48
     * @version 1.
     *
     */
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
        $activity_type = addslashes(trim($request->getParameter('activity_type'))); // 活动类型
        $name = addslashes(trim($request->getParameter('name'))); // 活动名称
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
                $circulation = $this->circulation($circulation);
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
                $circulation = $this->circulation($circulation);
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
                $circulation = $this->circulation($circulation);
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
                        $this->Verification($z_money,$money);
                    }
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
                    $money = 0;
                    $this->Verification($z_money);
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
                $receive = 1;
            }
        }
        if($name == ''){
        	echo json_encode(array('status' =>'优惠券名称不能为空！' ));exit;
        }

        // 检查产品标题是否重复
        $sql0 = "select 1 from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and name = '$name' ";
        $r0 = $db->select($sql0);
        if ($r0 && count($r0) > 0) {
        	echo json_encode(array('status' =>'优惠券名称已经存在！' ));exit;
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

        if($start_time > $time){
            $sql = "insert into lkt_coupon_activity(store_id,name,activity_type,grade_id,money,discount,z_money,circulation,num,receive,start_time,end_time,type,product_class_id,product_id,add_time,status,skip_type,url,day,Instructions) values('$store_id','$name','$activity_type','$grade','$money','$discount','$z_money','$circulation','$circulation','$receive','$start_time','$end_time','$type','$product_class_id','$product_id',CURRENT_TIMESTAMP,0,'$skip_type','$url','$day','$Instructions')";
        }else{
            $sql = "insert into lkt_coupon_activity(store_id,name,activity_type,grade_id,money,discount,z_money,circulation,num,receive,start_time,end_time,type,product_class_id,product_id,add_time,status,skip_type,url,day,Instructions) values('$store_id','$name','$activity_type','$grade','$money','$discount','$z_money','$circulation','$circulation','$receive','$start_time','$end_time','$type','$product_class_id','$product_id',CURRENT_TIMESTAMP,1,'$skip_type','$url','$day','$Instructions')";
        }
        $rr = $db->insert($sql);

        if($rr == -1 ){
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加优惠券活动失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加优惠券活动失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

			echo json_encode(array('status' =>'未知原因，优惠券添加失败！' ));exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加优惠券活动成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加优惠券活动成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

			echo json_encode(array('status' =>'优惠券添加成功！','suc'=>'1' ));exit;
        }
	    return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
    // 分类
    public function fenlei(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $product_class = array();
        $product_class1 = array();
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
        if(count($product_class) != 0){
            foreach ($product_class as $k => $v){
                if($k<10){
                    $product_class1[] = $v;
                }
            }
        }
        echo json_encode(array('product_class' => $product_class1));
        exit;
    }
    // 商品
    public function product(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
		
        $product_title = $request->getParameter('name'); // 活动结束时间
        $page = $request->getParameter('page'); // 活动结束时间
        // 页码
        if($page){
            $start = ($page-1)*10;
        }else{
            $start = 0;
        }
        $list = array();
		if($product_title !=''){
			$sql0 = "select id,product_title from lkt_product_list where store_id = '$store_id' and recycle = 0 and mch_status = 2 and active = 1 and status = 2 and product_title like '%$product_title%' order by sort desc limit $start,10";
		}else{
			$sql0 = "select id,product_title from lkt_product_list where store_id = '$store_id' and recycle = 0 and mch_status = 2 and active = 1 and status = 2 order by sort desc limit $start,10";
		}
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $list[] = array('id'=>$v->id,'pId'=>0,'name'=>$v->product_title);
            }
        }
        echo json_encode(array('product_class' => $list));
        exit;
    }
    // 商品
    public function cha_product(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $product_title = $request->getParameter('name'); // 活动结束时间
        $page = $request->getParameter('page'); // 活动结束时间
        // 页码
        if($page){
            $start = ($page-1)*10;
        }else{
            $start = 0;
        }

        $list = array();
        $sql0 = "select id,product_title from lkt_product_list where store_id = '$store_id' and recycle = 0 and mch_status = 2 and active = 1 and status = 2 and product_title like '%$product_title%' order by sort desc limit $start,10";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $list[] = array('id'=>$v->id,'pId'=>0,'name'=>$v->product_title);
            }
        }
        echo json_encode(array('product_class' => $list));
        exit;
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
    public function circulation($circulation){
        if($circulation == ''){
            echo json_encode(array('status' =>'优惠券发行数量不能为空！' ));exit;
        }else{
            if(!is_numeric($circulation) || strpos($circulation,".")!==false){
                echo json_encode(array('status' =>'优惠券发行数量请填写整数！' ));exit;
            }else{
                if($circulation < 0){
                    echo json_encode(array('status' =>'优惠券发行数量请填写大于等于0的整数！' ));exit;
                }else if($circulation == 0){
                    $circulation = 999999999;
                }
            }
        }
        return $circulation;
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