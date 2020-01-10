<?php
require_once(MO_CONFIG_DIR . '/db_config.php');

class coupon_pluginAction
{
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    // 优惠券领取中心
    public function index($store_id,$user_id){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间
        // 查询该商城所有未开启的优惠券
        $sql = "select id,start_time from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status = 0 order by start_time desc";
        $rr = $db->select($sql);
        if($rr){
            foreach ($rr as $k => $v){
                $id = $v->id; // 优惠券活动id
                $start_time1 = $v->start_time; // 活动开始时间
                if($start_time1 <= $time){ // 当优惠券活动开始时间 <= 当前时间
                    // 修改优惠券活动状态(开启状态)
                    $sql = "update lkt_coupon_activity set status = 1 where store_id = '$store_id' and recycle = 0 and id = '$id'";
                    $db->update($sql);
                }
            }
        }
        // 根据活动为开启状态,查询活动列表,根据开始时间降序排列
        $sql = "select id,name,activity_type,money,z_money,num,start_time,end_time,qualifications from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status = 1 order by start_time desc";
        $r = $db->select($sql);
        $arr = [];
        if($r){
            foreach ($r as $k => $v){
                $activity_id = $v->id; // 优惠券活动id
                $activity_type = $v->activity_type; // 优惠券类型
                $z_money = $v->z_money; // 满多少
                $num = $v->num; // 剩余个数
                $end_time = $v->end_time; // 活动结束时间
                $qualifications = unserialize($v->qualifications); // 资格
                $v->start_time = date('Y-m-d',strtotime($v->start_time));
                $v->end_time = date('Y-m-d',strtotime($v->end_time));
                if($z_money != 0){
                    $v->limit = '满'.$z_money.'可用'; // 限制
                }else{
                    $v->limit = '无限制'; // 限制
                }

                // 判断活动是否过期
                if($end_time <= $time){
                    // 过期,根据活动id修改活动状态
                    $sql = "update lkt_coupon_activity set status = 3 where store_id = '$store_id' and recycle = 0 and id = '$activity_id'";
                    $db->update($sql);
                }else{
                    if($activity_type != 3 && $activity_type != 7){ // 当优惠券为赠券
                        if(is_array($qualifications)){ // 是数组
                            if(count($qualifications) != 0){ // 不是空数组
                                if(in_array($user_id,$qualifications)){ // 检查用户id是否存在数组里
                                    if($num > 0){ // 还有剩下优惠券没领取
                                        $v->point = '立即领取';
                                        $v->point_type = 1;
                                    }else{
                                        $v->point = '已抢光';
                                        $v->point_type = 3;
                                    }
                                    $arr[$k] = (array)$v;
                                }
                            }else{  // 是空数组
                                // 根据优惠券活动id、用户id，查询用户领取的优惠券
                                $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and hid = '$activity_id' ";
                                $r1 = $db->select($sql);
                                if($r1){ // 已领取
                                    $v->point = '去使用';
                                    $v->point_type = 2;
                                    $arr[$k] = (array)$v;
                                }else{
                                    $v->point = '立即领取';
                                    $v->point_type = 1;
                                    $arr[$k] = (array)$v;
                                }
                            }
                        }
                    }else{  // 当优惠券为领券
                        // 根据优惠券活动id、用户id，查询用户领取的优惠券
                        $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and hid = '$activity_id' ";
                        $r1 = $db->select($sql);
                        if($r1){ // 已领取
                            $v->point = '去使用';
                            $v->point_type = 2;
                        }else{ // 未领取
                            if($num > 0){ // 还有剩下优惠券没领取
                                $v->point = '立即领取';
                                $v->point_type = 1;
                            }else{
                                $v->point = '已抢光';
                                $v->point_type = 3;
                            }
                        }
                        $arr[$k] = (array)$v;
                    }
                }
            }
        }
        return $arr;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    // 点击立即领取
    public function receive($store_id,$user_id,$id){
        $db = DBAction::getInstance();

        $sql = "select * from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and id = '$id'";
        $r = $db->select($sql);
        if($r){
            $money = $r[0]->money; // 优惠券面值
            $num = $r[0]->num; // 剩余数量
            $end_time = $r[0]-> end_time; // 活动结束时间
            $status = $r[0]-> status; // 活动状态
            if($status == 1){
                $qualifications = unserialize($r[0]->qualifications); // 资格
                if(is_array($qualifications)){ // 判断是否为数组
                    if(count($qualifications) != 0){ // 是数组，并且不为空
                        foreach ($qualifications as $k => $v){
                            if($user_id == $v){ // 删除资格
                                unset($qualifications[$k]);
                            }
                        }
                    }
                }
                $qualifications = serialize($qualifications);
                if($num > 0){
                    // 根据活动id,修改活动信息
                    $sql = "update lkt_coupon_activity set num='$num'-1,qualifications='$qualifications' where store_id = '$store_id' and recycle = 0 and id = '$id'";
                    $db->update($sql);

                    // 在优惠券表里添加一条数据
                    $sql = "insert into lkt_coupon(store_id,user_id,money,add_time,expiry_time,hid) values('$store_id','$user_id','$money',CURRENT_TIMESTAMP,'$end_time','$id')";
                    $db->insert($sql);

                    $res = '您领取了'.$money.'！';
                }else{
                    $res = '您来晚了！';
                }
            }else{
                echo json_encode(array('code' => 222, 'message' => '该活动已结束！'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115, 'message' => '参数错误！'));
            exit;
        }
        return $res;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    // 我的优惠券
    public function mycoupon($store_id,$user_id){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s',time()); // 当前时间
        $list1 = [];
        $list2 = [];
        $list3 = [];
        // 查询优惠券插件配置
        $sql = "select * from lkt_coupon_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $coupon_overdue = $r[0]->coupon_overdue; // 优惠券过期删除时间
        }else{
            $coupon_overdue = 0;
        }
        // 根据用户id,查询优惠券表
        $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' order by type,add_time";
        $rr = $db->select($sql);
        if($rr){
            foreach ($rr as $k => $v) {
                $id = $v->id; // 优惠券id
                $hid = $v->hid; // 活动id
                $expiry_time = $v->expiry_time; // 优惠券到期时间
                $v->add_time = date('Y-m-d',strtotime($v->add_time));
                $v->expiry_time = date('Y-m-d',strtotime($v->expiry_time));

                // 根据活动id,查询活动信息
                $sql = "select * from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                $r0 = $db->select($sql);
                if($r0){
                    $v->name = $r0[0]->name; // 活动名称
                    $activity_type = $r0[0]->activity_type; // 类型
                    $z_money = $r0[0]->z_money;
                    if($z_money != 0){
                        $v->limit = '满'.$z_money.'可用'; // 限制
                    }else{
                        $v->limit = '无限制'; // 限制
                    }
                }
                if($expiry_time < $time && $v->type != 2){ // 已过期
                    // 根据用户id,修改优惠券表的状态
                    $sql = "update lkt_coupon set type = 3 where store_id = '$store_id' and user_id = '$user_id' and id = '$id' and type != 2 ";
                    $db->update($sql);
                    $v->type =3;
                }
                if($coupon_overdue !=0){
                    $time_r = date("Y-m-d H:i:s",strtotime("$expiry_time   +$coupon_overdue   day")); // 优惠券过期删除时间
                    // 过期时间超过 $coupon_overdue 天,删除这条信息
                    if($time_r < $time && $v->type != 2){
                        // 根据用户id、优惠券id、优惠券类型为过期,删除这条信息
                        $sql = "delete from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and id = '$id'";
                        $db->delete($sql);
                    }
                }

                if($v->type == 0){
                    $v->point = '去使用';
                    $list1[] = $v;
                }else if($v->type == 1){
                    $sql = "select * from lkt_order where store_id = '$store_id' and user_id = '$user_id' and status not in(6,7) and coupon_id = '$v->id'";
                    $r_1 = $db->select($sql);
                    if($r_1){
                        $v->point = '已使用';
                        $list2[] = $v;
                    }else{
                        $v->point = '去使用';
                        $list1[] = $v;
                    }
                }else if($v->type == 2){
                    $v->point = '已使用';
                    $list2[] = $v;
                }else if($v->type == 3){
                    $v->point = '已过期';
                    $list3[] = $v;
                }
            }
        }
        $list = array($list1,$list2,$list3);
        return $list;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    // 立即使用
    public function immediate_use($store_id,$user_id,$id){
        $db = DBAction::getInstance();
        // 根据用户id,查询优惠券表里在使用中的优惠券
        $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 1";
        $r = $db->select($sql);
        if($r){
            foreach ($r as $k => $v) {
                $coupon_id = $v->id; // 优惠券id
                $hid = $v->hid; // 活动id
                // 根据优惠券id,查询订单表
                $sql = "select id from lkt_order where store_id = '$store_id' and status not in(6,7) and coupon_id = '$coupon_id' ";
                $rr = $db->select($sql);
                if(empty($rr)){
                    // 优惠券没有绑定
                    if($coupon_id == $id){ // 传过来的优惠券id 与 查询没绑定的优惠券id 相等
                        // 根据优惠券id,修改优惠券状态(未使用)
                        $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and id = '$id'";
                        $db->update($sql);
                    }else{ // 传过来的优惠券id 与 查询没绑定的优惠券id 不相等
                        // 根据查询没绑定的优惠券id,修改优惠券状态(未使用)
                        $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and id = '$coupon_id'";
                        $db->update($sql);
                        // 根据传过来的优惠券id,修改优惠券状态(未使用)
                        $sql = "update lkt_coupon set type = 1 where store_id = '$store_id' and id = '$id'";
                        $db->update($sql);
                    }
                }
            }
        }else{
            // 没有数据,就直接把优惠券状态改成(使用中)
            $sql = "update lkt_coupon set type = 1 where store_id = '$store_id' and id = '$id'";
            $db->update($sql);
        }
        return;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    // 进入结算页面
    public function coupon($store_id, $user_id, $zong, $product_class, $product_id)
    {
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间

        $arr = array();
        $arr1 = array();
        $arr2 = array();
        // 根据用户id,查询优惠券状态为 (使用中)
        $sql = "select id,hid,money,expiry_time from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 1";
        $r = $db->select($sql);
        if ($r) { // 存在 使用中 的优惠券
            foreach ($r as $k => $v) { // 循环判断 优惠券是否绑定
                $id = $v->id; // 优惠券id
                $hid = $v->hid; // 活动id
                $money = $v->money; // 优惠券金额
                $expiry_time = $v->expiry_time; // 优惠券到期时间
                // 根据优惠券id,查询订单表(查看优惠券是否绑定)
                $sql = "select id from lkt_order where store_id = '$store_id' and status not in(6,7) and coupon_id = '$id' ";
                $rr = $db->select($sql);

                if (empty($rr)) { // 没有数据,表示优惠券没绑定
                    if($expiry_time <= $time){ // 当前时间 >= 优惠券到期时间
                        $sql = "update lkt_coupon set type = 3 where id = '$id'";
                        $db->update($sql);
                    }else{
                        $sql = "select z_money,type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                        $rr1 = $db->select($sql);

                        $z_money = $rr1[0]->z_money; // 满多少
                        $type = $rr1[0]->type; // 优惠券使用范围
                        $product_class_id = $rr1[0]->product_class_id; // 分类id
                        $product_id1 = $rr1[0]->product_id; // 商品id
                        if($type == 1){ // 全部商品
                            if($z_money == 0){
                                $arr2['coupon_id'] = $v->id; // 优惠券id
                                if($zong > $money){
                                    $arr2['money'] = $money; // 优惠券金额
                                }else{
                                    $arr2['money'] = $zong; // 优惠券金额
                                }
                            }else{
                                if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                                    $arr2['coupon_id'] = $v->id; // 优惠券id
                                    $arr2['money'] = $v->money; // 优惠券金额
                                }else{
                                    $sql = "update lkt_coupon set type = 0 where id = '$id'";
                                    $db->update($sql);
                                }
                            }
                        }else if($type == 2){
                            $product_id1 = unserialize($product_id1);
                            $product_id1 = rtrim($product_id1, ','); // 去除字符串最后一个逗号
                            $product_id_list = explode(",", $product_id1); // 字符串转数组
                            $product_status = 1; // 商品状态 1:代表购买商品 符合 优惠券指定 商品
                            foreach ($product_id as $va) {
                                if (in_array($va, $product_id_list)) {
                                    continue;
                                }else {
                                    $product_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                    break;
                                }
                            }
                            if($product_status){ // 符合
                                if($z_money == 0){
                                    $arr2['coupon_id'] = $v->id; // 优惠券id
                                    if($zong > $money){
                                        $arr2['money'] = $money; // 优惠券金额
                                    }else{
                                        $arr2['money'] = $zong; // 优惠券金额
                                    }
                                }else{
                                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                                        $arr2['coupon_id'] = $v->id; // 优惠券id
                                        $arr2['money'] = $v->money; // 优惠券金额
                                    }else{
                                        $sql = "update lkt_coupon set type = 0 where id = '$id'";
                                        $db->update($sql);
                                    }
                                }
                            }
                        }else if($type == 3){
                            $product_class_id = unserialize($product_class_id);
                            $product_class_id = rtrim($product_class_id, ','); // 去除字符串最后一个逗号
                            $product_class_list = explode(",", $product_class_id); // 字符串转数组
                            $calss_status = 1; // 商品属于优惠券指定的分类
                            foreach ($product_class as $va) {
                                foreach ($product_class_list as $ke1 => $va1){
                                    $count = count($product_class_list) - 1;
                                    if(strpos($va,$va1) !== false){
                                        $calss_status = 1;
                                        break;
                                    }else{
                                        if($count <= $ke1){
                                            $calss_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                            break 2;
                                        }
                                    }
                                }
                            }
                            if($calss_status){ // 符合
                                if($z_money == 0){
                                    $arr2['coupon_id'] = $v->id; // 优惠券id
                                    if($zong > $money){
                                        $arr2['money'] = $money; // 优惠券金额
                                    }else{
                                        $arr2['money'] = $zong; // 优惠券金额
                                    }
                                }else{
                                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                                        $arr2['coupon_id'] = $v->id; // 优惠券id
                                        $arr2['money'] = $v->money; // 优惠券金额
                                    }else{
                                        $sql = "update lkt_coupon set type = 0 where id = '$id'";
                                        $db->update($sql);
                                    }
                                }
                            }
                        }
                    }
                    break;
                }
            }

            if(!empty($arr2['coupon_id']) && !empty($arr2['money'])){
                $arr = $arr2;
            }else{
                // 根据商城id、用户id、状态为未使用，查询优惠券信息，以到期时间顺序、金额倒序排列
                $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 0 order by expiry_time asc,money desc ";
                $rr = $db->select($sql);
                if ($rr) { // 有 未使用 的优惠券
                    foreach ($rr as $k => $v) {
                        $id = $v->id; // 优惠券id
                        $hid = $v->hid; // 活动id
                        $expiry_time = $v->expiry_time; // 优惠券到期时间
                        if($expiry_time <= $time){
                            $sql = "update lkt_coupon set type = 3 where id = '$id'";
                            $db->update($sql);
                        }else{
                            // 根据优惠券活动id，查询活动
                            $sql = "select z_money,type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                            $rr1 = $db->select($sql);
                            if($rr1){
                                $z_money = $rr1[0]->z_money; // 满多少
                                $type = $rr1[0]->type; // 优惠券使用范围
                                $product_class_id = $rr1[0]->product_class_id; // 分类id
                                $product_id1 = $rr1[0]->product_id; // 商品id
                                if($type == 1){ // 全部商品
                                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                                        $arr1[] = (array)$v;
                                    }
                                }else if($type == 2){
                                    $product_id1 = unserialize($product_id1);
                                    $product_id1 = rtrim($product_id1, ','); // 去除字符串最后一个逗号
                                    $product_id_list = explode(",", $product_id1); // 字符串转数组
                                    $product_status = 1; // 商品状态 1:代表购买商品 符合 优惠券指定 商品
                                    foreach ($product_id as $va) {
                                        if (in_array($va, $product_id_list)) {
                                            continue;
                                        }else {
                                            $product_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                            break;
                                        }
                                    }
                                    if($product_status){ // 符合
                                        if ($z_money < $zong) { // 商品总价 >= 优惠券满多少
                                            $arr1[] = (array)$v;
                                        }
                                    }
                                }else if($type == 3){
                                    $product_class_id = unserialize($product_class_id);
                                    $product_class_id = rtrim($product_class_id, ','); // 去除字符串最后一个逗号
                                    $product_class_list = explode(",", $product_class_id); // 字符串转数组
                                    $calss_status = 1; // 商品属于优惠券指定的分类
                                    foreach ($product_class as $va) {
                                        if (in_array($va, $product_class_list)) {
                                            continue;
                                        }else {
                                            $calss_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                            break;
                                        }
                                    }
                                    if($calss_status){ // 符合
                                        if ($z_money <= $zong) { // 商品总价 >= 优惠券满多少
                                            $arr1[] = (array)$v;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $arr1 = isset($arr1) ? $arr1:[];
                    if ($arr1 != []) {
                        // 设置默认优惠券
                        $sql = "update lkt_coupon set type = 1 where store_id = '$store_id' and id = " . $arr1[0]['id'];
                        $db->update($sql);
                        $arr['money'] = $arr1[0]['money'];
                        $arr['coupon_id'] = $arr1[0]['id'];
                    } else {
                        $arr['money'] = 0;
                        $arr['coupon_id'] = 0;
                    }
                } else { // 没有 未使用 的优惠券
                    $arr['money'] = 0;
                    $arr['coupon_id'] = 0;
                }
            }
        } else { // 当进入结算页面，没有优惠券在使用中
            // 根据商城id、用户id、状态为未使用，查询优惠券信息，以到期时间顺序、金额倒序排列
            $sql = "select id,money,hid,expiry_time from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 0 order by money desc,expiry_time asc ";
            $rr = $db->select($sql);
            if ($rr) { // 有 未使用 的优惠券
                foreach ($rr as $k => $v) {
                    $id = $v->id; // 优惠券id
                    $hid = $v->hid; // 活动id
                    $money = $v->money; // 活动id
                    $expiry_time = $v->expiry_time; // 优惠券到期时间
                    if($expiry_time <= $time){
                        $sql = "update lkt_coupon set type = 3 where id = '$id'";
                        $db->update($sql);
                    }else{
                        // 根据优惠券活动id，查询活动
                        $sql = "select z_money,type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                        $rr1 = $db->select($sql);
                        if($rr1){
                            $z_money = $rr1[0]->z_money; // 满多少
                            $type = $rr1[0]->type; // 优惠券使用范围
                            $product_class_id = $rr1[0]->product_class_id; // 分类id
                            $product_id1 = $rr1[0]->product_id; // 商品id
                            if($type == 1){ // 全部商品
                                if($z_money == 0){
                                    if($zong > $money){
                                        $v->money = $v->money; // 优惠券金额
                                    }else{
                                        $v->money = $zong; // 优惠券金额
                                    }
                                    $arr1[] = (array)$v;
                                }else{
                                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                                        $arr1[] = (array)$v;
                                    }
                                }
                            }else if($type == 2){
                                $product_id1 = unserialize($product_id1);
                                $product_id1 = rtrim($product_id1, ','); // 去除字符串最后一个逗号
                                $product_id_list = explode(",", $product_id1); // 字符串转数组
                                $product_status = 1; // 商品状态 1:代表购买商品 符合 优惠券指定 商品
                                foreach ($product_id as $va) {
                                    if (in_array($va, $product_id_list)) {
                                        continue;
                                    }else {
                                        $product_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                        break;
                                    }
                                }
                                if($product_status){ // 符合
                                    if($z_money == 0){
                                        if($zong > $money){
                                            $v->money = $v->money; // 优惠券金额
                                        }else{
                                            $v->money = $zong; // 优惠券金额
                                        }
                                        $arr1[] = (array)$v;
                                    }else{
                                        if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                                            $arr1[] = (array)$v;
                                        }
                                    }
                                }
                            }else if($type == 3){
                                $product_class_id = unserialize($product_class_id);
                                $product_class_id = rtrim($product_class_id, ','); // 去除字符串最后一个逗号
                                $product_class_list = explode(",", $product_class_id); // 字符串转数组
                                $calss_status = 1; // 商品属于优惠券指定的分类
                                foreach ($product_class as $va) {
                                    if (in_array($va, $product_class_list)) {
                                        continue;
                                    }else {
                                        $calss_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                        break;
                                    }
                                }
                                if($calss_status){ // 符合
                                    if($z_money == 0){
                                        if($zong > $money){
                                            $v->money = $v->money; // 优惠券金额
                                        }else{
                                            $v->money = $zong; // 优惠券金额
                                        }
                                        $arr1[] = (array)$v;
                                    }else{
                                        if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                                            $arr1[] = (array)$v;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                $arr1 = isset($arr1) ? $arr1:[];
                if ($arr1 != []) {
                    // 设置默认优惠券
                    $sql = "update lkt_coupon set type = 1 where store_id = '$store_id' and id = " . $arr1[0]['id'];
                    $db->update($sql);
                    $arr['money'] = $arr1[0]['money'];
                    $arr['coupon_id'] = $arr1[0]['id'];
                } else {
                    $arr['money'] = 0;
                    $arr['coupon_id'] = 0;
                }
            } else { // 没有 未使用 的优惠券
                $arr['money'] = 0;
                $arr['coupon_id'] = 0;
            }
        }
        return $arr;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    // 我的优惠券(可以使用的)
    public function my_coupon($store_id,$user_id,$zong,$product_id,$product_class,$coupon_id=''){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间
        $rew_1 = 0;
        $arr = array();
        $coupon_hid = 0;
        $coupon_user_num = 0; // 使用限制
        if($coupon_id != ''){
            $coupon_id = explode(',',$coupon_id);
        }
        // 根据用户id,查询优惠券状态为使用中的数据
        $sql = "select id,money,hid,expiry_time from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 1";
        $r = $db->select($sql);
        if($r){ // 存在优惠券（使用中）
            foreach ($r as $k => $v) {
                $id = $v->id; // 优惠券id
                $hid = $v->hid;
                $expiry_time = $v->expiry_time; // 优惠券到期时间
                $rew_1 = ++$rew_1;

                // 根据优惠券活动id，查询活动
                $sql = "select * from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                $rr1 = $db->select($sql);
                $v->name = $rr1[0]->name; // 活动名称
                $coupon_user_num = $rr1[0]->use_num; // 使用限制
                if($coupon_id != ''){
                    foreach ($coupon_id as $ke => $va){
                        if($id == $va){
                            $coupon_hid = $hid;
                            $v->point = '正在使用';
                            $v->coupon_status = 1; // 按钮状态 可以点击
                            $arr[$rew_1] = (array)$v;
                        }
                    }
                }else{
                    // 根据优惠券id,查询订单
                    $sql = "select id from lkt_order where store_id = '$store_id' and status not in(6,7) and coupon_id = '$id' ";
                    $r_1 = $db->select($sql);
                    if(empty($r_1)){ // 没有数据,表示该优惠券没绑定
                        if($expiry_time <= $time){ // 优惠券有效期 <= 当前时间
                            // 修改优惠券状态（已过期）
                            $sql = "update lkt_coupon set type = 3 where store_id = '$store_id' and coupon_id = '$id'";
                            $db->select($sql);
                        }else{
                            $coupon_hid = $hid;
                            $v->point = '正在使用';
                            $v->coupon_status = 1; // 按钮状态 可以点击
                            $arr[$rew_1] = (array)$v;
                        }
                    }
                }
            }
        }

        $num = count($arr);
        // 根据用户id,查询优惠券状态为(未使用),以优惠券过期时间顺序排列
        $sql = "select id,money,hid,expiry_time from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 0 order by expiry_time";
        $rr = $db->select($sql);
        if($rr){
            foreach ($rr as $k => $v) {
                $rew_2 = ++$rew_1;
                $id = $v->id;
                $hid = $v->hid;
                $money = $v->money; // 优惠券金额
                // 根据优惠券活动id，查询活动
                $sql = "select * from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                $rr1 = $db->select($sql);
                if($rr1){
                    $v->name = $rr1[0]->name; // 活动名称
                    $z_money = $rr1[0]->z_money; // 满多少
                    $type = $rr1[0]->type; // 优惠券使用范围
                    $product_class_id = $rr1[0]->product_class_id; // 分类id
                    $product_id1 = $rr1[0]->product_id; // 商品id

                    if($type == 1){ // 全部商品
                        if($z_money == 0){
                            $v->point = '立即使用';
                            $v->coupon_status = 1; // 按钮状态 可以点击
                            $arr[$rew_2] = (array)$v;
                        }else{
                            if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                                $v->point = '立即使用';
                                $v->coupon_status = 1; // 按钮状态 可以点击
                                $arr[$rew_2] = (array)$v;
                            }else{
                                $v->point = '不可使用';
                                $v->coupon_status = 0; // 按钮状态 不可以点击
                            }
                        }
                    }else if($type == 2){
                        $product_id1 = unserialize($product_id1);
                        $product_id1 = rtrim($product_id1, ','); // 去除字符串最后一个逗号
                        $product_id_list = explode(",", $product_id1); // 字符串转数组
                        $product_status = 1; // 商品状态 1:代表购买商品 符合 优惠券指定 商品
                        foreach ($product_id as $va) {
                            if (in_array($va, $product_id_list)) {
                                continue;
                            }else {
                                $product_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                break;
                            }
                        }

                        if($product_status){ // 符合
                            if($z_money == 0) {
                                $v->point = '立即使用';
                                $v->coupon_status = 1; // 按钮状态 可以点击
                                $arr[$rew_2] = (array)$v;
                            }else{
                                if ($z_money < $zong) { // 商品总价 >= 优惠券满多少
                                    $v->point = '立即使用';
                                    $v->coupon_status = 1; // 按钮状态 可以点击
                                    $arr[$rew_2] = (array)$v;
                                }else{
                                    $v->point = '不可使用';
                                    $v->coupon_status = 0; // 按钮状态 不可以点击
                                }
                            }
                        }else{
                            $v->point = '不可使用';
                            $v->coupon_status = 0; // 按钮状态 不可以点击
                        }
                    }else if($type == 3){
                        $product_class_id = unserialize($product_class_id);
                        $product_class_id = rtrim($product_class_id, ','); // 去除字符串最后一个逗号
                        $product_class_list = explode(",", $product_class_id); // 字符串转数组

                        $calss_status = 1; // 商品属于优惠券指定的分类
                        foreach ($product_class as $ke => $va) {
                            foreach ($product_class_list as $ke1 => $va1){
                                $count = count($product_class_list) - 1;
                                if(strpos($va,$va1) !== false){
                                    $calss_status = 1;
                                    break;
                                }else{
                                    if($count <= $ke1){
                                        $calss_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                        break 2;
                                    }
                                }
                            }
                        }

                        if($calss_status){ // 符合
                            if($z_money == 0) {
                                $v->point = '立即使用';
                                $v->coupon_status = 1; // 按钮状态 可以点击
                                $arr[$rew_2] = (array)$v;
                            }else{
                                if ($z_money <= $zong) { // 商品总价 >= 优惠券满多少
                                    $v->point = '立即使用';
                                    $v->coupon_status = 1; // 按钮状态 可以点击
                                    $arr[$rew_2] = (array)$v;

                                }else{
                                    $v->point = '不可使用';
                                    $v->coupon_status = 0; // 按钮状态 不可以点击
                                }
                            }

                        }else{
                            $v->point = '不可使用';
                            $v->coupon_status = 0; // 按钮状态 不可以点击
                        }
                    }
                }
            }
        }else{
            $rew_2 = $rew_1;
        }

        $arr = $this->array_orderby($arr,'money', SORT_DESC, 'expiry_time', SORT_ASC);

        $rew_3 = $rew_2 + 1;
        $arr[$rew_3] = array('id'=>0,'money'=>0,'hid'=>0,'expiry_time'=>0,'name'=>'不使用优惠券','coupon_status'=>1);
        return $arr;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    function array_orderby(){
        $args = func_get_args();
        $data = array_shift($args);
        foreach ($args as $n => $field) {
            if (is_string($field)) {
                $tmp = array();
                foreach ($data as $key => $row)
                    $tmp[$key] = $row[$field];
                $args[$n] = $tmp;
            }
        }
        $args[] = &$data;
        call_user_func_array('array_multisort', $args);
        return array_pop($args);
    }

    public function getvou1($store_id,$user_id,$x_coupon_id){
        $db = DBAction::getInstance();
        $arr = array();

        // 根据优惠券id,查询优惠券信息
        $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and id = '$x_coupon_id'";
        $r = $db->select($sql);
        if($r){
            $type = $r[0]->type;
            if($type == 1){
                $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and user_id = '$user_id' and id = '$x_coupon_id'";
            }else if($type == 0){
                $sql = "update lkt_coupon set type = 1 where store_id = '$store_id' and user_id = '$user_id' and id = '$x_coupon_id'";
            }
            $db->update($sql);
        }
        return 1;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    // 选择优惠券
    public function getvou($store_id,$user_id,$coupon_id,$zong){
        $db = DBAction::getInstance();
        $arr = array();
        $arr['id'] = 0;
        $arr['money'] = 0;
        if($coupon_id == '' || $coupon_id == 0){ // 没有选择优惠券
            // 根据用户id、优惠劵状态为使用中，查询没绑定的优惠劵
            $sql = "select a.id from lkt_coupon as a where (select count(1) AS num from lkt_order as b where b.store_id = '$store_id' and a.id = b.coupon_id) = 0 and a.user_id = '$user_id' and a.type = 1";
            $r = $db->select($sql);
            if($r){ // 有没绑定的优惠劵id
                foreach ($r as $k => $v){
                    // 改原状态为(使用中 变为 未使用)
                    $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and user_id = '$user_id' and id = '$v->id'";
                    $db->update($sql);
                }
            }
        }else{ // 选择优惠券
            $coupon_id1 = explode(',',$coupon_id);
            foreach ($coupon_id1 as $k => $v){
                $sql = "select money,hid from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and id = '$v'";
                $r = $db->select($sql);

                $hid = $r[0]->hid;
                $sql = "select z_money from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                $r1 = $db->select($sql);
                $z_money = $r1[0]->z_money;
                if($z_money == 0){
                    $arr['money'] += $zong;
                }else{
                    $arr['money'] += $r[0]->money;
                }
            }
            $arr['id'] = $coupon_id;
        }
        return $arr;
    }
    // 赠送券
    public function give($store_id,$user_id,$coupon_type,$sNo=''){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间
        // 查询该商城所有未开启的优惠券
        $sql = "select id,start_time from lkt_coupon_activity where store_id = '$store_id' and status = 0 and recycle = 0 order by start_time desc";
        $r = $db->select($sql);
        if($r){
            foreach ($r as $k => $v){
                $id = $v->id; // 优惠券活动id
                $start_time1 = $v->start_time; // 活动开始时间
                if($start_time1 <= $time){ // 当优惠券活动开始时间 >= 当前时间
                    // 修改优惠券活动状态(开启状态)
                    $sql = "update lkt_coupon_activity set status = 1 where store_id = '$store_id' and recycle = 0 and id = '$id'";
                    $db->update($sql);
                }
            }
        }

        // 查询该商城所有启用/禁用的优惠券
        $sql = "select id,end_time from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status = in(1,2) order by start_time desc";
        $rr = $db->select($sql);
        if($rr){
            $id = $v->id; // 优惠券活动id
            $end_time = $v->end_time; // 活动结束时间
            if($end_time <= $time){
                // 过期,根据活动id修改活动状态
                $sql = "update lkt_coupon_activity set status = 3 where store_id = '$store_id' and recycle = 0 and id = '$id'";
                $db->update($sql);
            }
        }
        if($coupon_type == 'start'){ // 一进入就赠送券
            $list = $this->start($db,$store_id,$user_id);
        }else if($coupon_type == 'shopping'){ // 购物赠券
            $list = $this->shopping($db,$store_id,$user_id,$sNo);
        }else if($coupon_type == 'invitation'){ // 邀请有奖赠券
            $list = $this->invitation($db,$store_id,$user_id);
        }else if($coupon_type == 'task'){ // 任务赠券
            $list = $this->task($db,$store_id,$user_id);
        }
        return $list;
    }
    /**
     * @return array
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2019/1/2 0002  16:59
     * @version 1.0
     */
    // 一进入就赠送券
    public function start($db,$store_id,$user_id){
        // 根据商城id、用户id，查询用户注册时间
        $sql = "select Register_data from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
        $r = $db->select($sql);
        $Register_data = $r[0]->Register_data; // 注册时间
        $list = [];

        // 根据活动为开启状态,查询活动列表(新人赠券、全场赠券),根据开始时间降序排列
        $sql = "select id as hid,name,activity_type,money,z_money,num,start_time,end_time from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status = 1 and activity_type in(1,3,5,7) order by start_time desc";
        $r0 = $db->select($sql);
        if($r0){
            foreach ($r0 as $k => $v){
                $activity_id = $v->hid; // 优惠券活动id
                $activity_type = $v->activity_type; // 优惠券类型
                $z_money = $v->z_money; // 满多少
                $num = $v->num; // 剩余个数
                if($activity_type == 1){ // 当优惠券为新手注册类型
                    if($Register_data >= $v->start_time){ // 当注册时间 >= 新人注册券有效开始时间
                        if($num > 0){ // 还有剩下优惠券没领取
                            // 根据优惠券活动id、用户id，查询用户领取的优惠券
                            $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and hid = '$activity_id' ";
                            $r1 = $db->select($sql);
                            if(empty($r1)){ // 当没有领取
                                if($z_money != 0){
                                    $v->limit = '满'.$z_money.'可用'; // 限制
                                }else{
                                    $v->limit = '无限制'; // 限制
                                }
                                $this->qualifications($db,$store_id,$user_id,$activity_id);
                                $list[] = $v;
                            }
                        }
                    }
                }else{
                    if($num > 0){ // 还有剩下优惠券没领取
                        // 根据优惠券活动id、用户id，查询用户领取的优惠券
                        $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and hid = '$activity_id' ";
                        $r1 = $db->select($sql);
                        if(empty($r1)){ // 当没有领取
                            if($z_money != 0){
                                $v->limit = '满'.$z_money.'可用'; // 限制
                            }else{
                                $v->limit = '无限制'; // 限制
                            }
                            $this->qualifications($db,$store_id,$user_id,$activity_id);
                            $list[] = $v;
                        }
                    }
                }
            }
        }
        return $list;
    }
    /**
     * @return array
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2019/1/2 0002  19:28
     * @version 1.0
     */
    // 购物赠券
    public function shopping($db,$store_id,$user_id,$sNo){
        $list = [];

        $sql = "select z_price,spz_price from lkt_order where store_id = '$store_id' and user_id = '$user_id' and sNo = '$sNo'";
        $r = $db->select($sql);
        if($r){

            $order_price = $r[0]->z_price; // 订单总价
            $spz_price = $r[0]->spz_price; // 商品总价

            $product_id = array();
            $product_class = array();
            $sql = "select p_id,p_price,num,freight,express_id from lkt_order_details where store_id = '$store_id' and user_id = '$user_id' and r_sNo = '$sNo'";
            $rr = $db->select($sql);
            if($rr){

                foreach ($rr as $k => $v){
                    $p_price = $v->p_price * $v->num; // 某个商品总价
                    $freight = $v->freight; // 运费
                    $p_id = $v->p_id; // 商品id
                    $product_id[] = $v->p_id; // 商品id
                    $express_id = $v->express_id; // 快递公司id
                    //判断是否发货
                    if ($freight && $express_id) {
                        $order_price = $order_price - $freight;
                        $p_price = $p_price - $freight;
                        $spz_price = $spz_price - $freight;
                    }
                    //计算实际支付金额
                    $price = number_format($order_price / $spz_price * $p_price, 2,".", "");

                    $sql = "select product_class from lkt_product_list where id = '$v->p_id'";
                    $rrr = $db->select($sql);
                    if($rrr){
                        $product_class[] = $rrr[0]->product_class;
                    }
                }
            }

            $sql = "select id as hid,name,money,z_money,shopping,num,receive,start_time,end_time,type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status = 1 and activity_type = 2 order by start_time desc";
            $r0 = $db->select($sql);
            if($r0){

                foreach ($r0 as $k => $v) {
                    $activity_id = $v->hid; // 优惠券活动id
                    $shopping = $v->shopping; // 满多少赠券
                    $num = $v->num; // 剩余个数
                    $type = $v->type; // 优惠券使用范围
                    $product_class_id = $v->product_class_id; // 活动指定商品类型id
                    $product_id1 = $v->product_id; // 活动指定商品id
                    if($num > 0) { // 还有剩下优惠券没领取
                        // 根据优惠券活动id、用户id，查询用户领取的优惠券
                        $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and hid = '$activity_id' ";
                        $r1 = $db->select($sql);
                        if(empty($r1)) { // 当没有领取
                            if($type == 1){ // 当优惠券使用范围为全部商品时
                                if($order_price >= $shopping){ // 消费金额 >= 满多少赠券
                                    $this->qualifications($db,$store_id,$user_id,$activity_id);
                                    $list[] = $v;
                                }
                            }else if($type == 2){
                                $product_id1 = unserialize($product_id1);
                                $product_id1 = rtrim($product_id1, ','); // 去除字符串最后一个逗号
                                $product_id_list = explode(",", $product_id1); // 字符串转数组
                                foreach ($product_id as $va) {
                                    if (in_array($va, $product_id_list)) {
                                        $this->qualifications($db,$store_id,$user_id,$activity_id);
                                        $list[] = $v;
                                    }
                                }
                            }else if($type == 3){
                                $product_class_id = unserialize($product_class_id);
                                $product_class_id = rtrim($product_class_id, ','); // 去除字符串最后一个逗号
                                $product_class_list = explode(",", $product_class_id); // 字符串转数组

                                $calss_status = 1;
                                foreach ($product_class as $va) {
                                    foreach ($product_class_list as $ke1 => $va1){
                                        $count = count($product_class_list) - 1;
                                        if(strpos($va,$va1) !== false){
                                            $calss_status = 1;
                                            break;
                                        }else{
                                            if($count <= $ke1){
                                                $calss_status = 0; // 商品状态 0:代表购买商品 不符合 优惠券指定 商品
                                                break 2;
                                            }
                                        }
                                    }
                                }
                                if($calss_status){ // 符合
                                    $this->qualifications($db,$store_id,$user_id,$activity_id);
                                    $list[] = $v;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $list;
    }
    /**
     * @return array
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2019/1/3 0008  18:30
     * @version 1.0
     */
    // 邀请有奖赠券
    public function invitation($db,$store_id,$user_id){
        $list = array();
        $sql = "select id as hid,name,money,z_money,num,receive,start_time,end_time from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status = 1 and activity_type = 8 order by start_time desc";
        $r0 = $db->select($sql);
        if($r0){
            foreach ($r0 as $k => $v){
                $activity_id = $v->hid; // 优惠券活动id
                $num = $v->num; // 剩余个数
                if($num > 0){ // 还有剩下优惠券没领取
                    $this->qualifications($db,$store_id,$user_id,$activity_id);
                    $list[] = $v;
                }
            }
        }
        return $list;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2019/2/25  10:18
     * @version 1.0
     */
    // 添加领取资格
    public function qualifications($db,$store_id,$user_id,$activity_id){
        $sql0 = "select qualifications from lkt_coupon_activity where store_id = '$store_id' and id = '$activity_id'";
        $r0 = $db->select($sql0);
        if($r0){

            if($r0[0]->qualifications == ''){
                $qualifications[] = $user_id;
            }else{
                $qualifications1 = unserialize($r0[0]->qualifications);
                if(count($qualifications1) == 0){
                    $qualifications[] = $user_id;
                }else{
                    if(in_array($user_id,$qualifications1)){
                        $qualifications = $qualifications1;
                    }else{
                        $qualifications = array_push($qualifications1,$user_id);
                    }
                }
            }
            $qualifications = serialize($qualifications);
            $sql1 = "update lkt_coupon_activity set qualifications = '$qualifications' where store_id = '$store_id' and id = '$activity_id'";
            $db->update($sql1);
        }
        return;
    }
}

?>