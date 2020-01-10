<?php
require_once(MO_CONFIG_DIR . '/db_config.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class coupon
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=coupon&action=Index',
//            'index.php?module=coupon&action=Add',
//            'index.php?module=coupon&action=Config',
//            'index.php?module=coupon&action=Coupon',
//            'index.php?module=coupon&action=Coupondel',
//            'index.php?module=coupon&action=Del',
//            'index.php?module=coupon&action=Modify'
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select is_status from lkt_coupon_config where store_id = '$store_id' ";
        $r0 = $db->select($sql0);
        if($r0){
            $is_display = $r0[0]->is_status;
        }else{
            $is_display = 2;
        }
        return $is_display;
    }
    // 添加插件设置
    public function add($store_id){
        $db = DBAction::getInstance();
        $sql0 = "insert into lkt_coupon_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_coupon_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    // 前端首页
    public function test($store_id){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间

        $sql0 = "select is_status from lkt_coupon_config where store_id = '$store_id' ";
        $r0 = $db->select($sql0);
        if($r0){
            $is_status = $r0[0]->is_status;
        }else{
            $is_status = 0;
        }
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
        return $is_status;
    }

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

                    $Log_content = '开启优惠券活动，ID为'.$id.'！';
                    $this->couponLog($id,$Log_content);
                }
            }
        }
        // 根据活动为开启状态,查询活动列表,根据开始时间降序排列
        $sql = "select id,name,activity_type,money,discount,z_money,circulation,receive,num,url,start_time,end_time,Instructions from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status = 1 and activity_type != 4 order by start_time desc";
        $r = $db->select($sql);
        $arr = array();
        if($r){
            foreach ($r as $k => $v){
                $activity_id = $v->id; // 优惠券活动id
                $activity_type = $v->activity_type; // 优惠券类型
                $z_money = floatval($v->z_money); // 满多少
                $v->money = floatval($v->money); // 面值
                $v->discount = floatval($v->discount); // 折扣值
                $v->z_money = floatval($v->z_money); // 满多少
                $receive = $v->receive; // 领取限制
                $num = $v->num; // 剩余个数
                $end_time = $v->end_time; // 活动结束时间
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
                    if($user_id == ''){
                        $v->point = '立即领取';
                        $v->point_type = 1;
                        $arr[$k] = (array)$v;
                    }else{
                        // 根据优惠券活动id、用户id，查询用户领取的优惠券
                        $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and recycle = 0 and hid = '$activity_id' ";
                        $r1 = $db->select($sql);
                        if($r1){ // 已领取
                            if($r1[0]->type == 2){
                                $v->point = '';
                                $v->point_type = 4;
                            }else{
                                $sql2 = "select * from lkt_order where store_id = '$store_id' and status != 6 and status != 7 and coupon_id = " . $r1[0]->id;
                                $r2 = $db->select($sql2);
                                if($r2){
                                    $v->point = '';
                                    $v->point_type = 4;
                                }else{
                                    $sql3 = "select count(id) as num from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and recycle = 0 and hid = '$activity_id'";
                                    $r3 = $db->select($sql3);
                                    if($receive > $r3[0]->num){
                                        if($num > 0){
                                            $v->point = '立即领取';
                                            $v->point_type = 1;

                                        }else{
                                            $v->point = '去使用';
                                            $v->point_type = 2;
                                        }
                                    }else{
                                        $v->point = '去使用';
                                        $v->point_type = 2;
                                    }
                                }
                            }

                            $arr[$k] = (array)$v;
                        }else{
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
        // 1.开启事务
        $db->begin();
        // 根据商城ID、优惠券ID、活动状态，查询优惠券活动
        $sql0 = "select * from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and id = '$id'";
        $r0 = $db->select($sql0);
        if($r0){
            $name = $r0[0]->name; // 优惠券名称
            $receive = $r0[0]->receive; // 领取限制
            $num = $r0[0]->num; // 剩余数量
            $end_time = $r0[0]-> end_time; // 活动结束时间
            $status = $r0[0]-> status; // 活动状态

            $sql0_0 = "select count(id) as num from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and hid = '$id'";
            $r0_0 = $db->select($sql0_0);
            $num0_0 = $r0_0[0]->num;
            if($receive > $num0_0){ // 当领取限制 大于 当前领取数量
                if($status == 1){
                    if($num > 0){
                        // 根据活动id,修改活动信息
                        $sql1 = "update lkt_coupon_activity set num='$num'-1 where store_id = '$store_id' and recycle = 0 and id = '$id'";
                        $r1 = $db->update($sql1);
                        if($r1 == -1){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id.'时，修改优惠券活动剩余量失败！';
                            $this->couponLog($id,$Log_content);
                            $db->rollback();

                            echo json_encode(array('code' => 115, 'message' => '参数错误！'));
                            exit;
                        }
                        // 在优惠券表里添加一条数据
                        $sql2 = "insert into lkt_coupon(store_id,user_id,add_time,expiry_time,hid) values('$store_id','$user_id',CURRENT_TIMESTAMP,'$end_time','$id')";
                        $r2 = $db->insert($sql2);
                        if($r2 == -1){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id.'时，添加失败！';
                            $this->couponLog($id,$Log_content);
                            $db->rollback();

                            echo json_encode(array('code' => 115, 'message' => '参数错误！'));
                            exit;
                        }
                        $res = '您领取了'.$name.'优惠券！';

                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id;
                        $this->couponLog($id,$Log_content);
                    }else{
                        $res = '您来晚了！';

                        $Log_content =  __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id.'时,来晚了！';
                        $this->couponLog($id,$Log_content);
                    }
                    $db->commit();
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id.'时，活动已结束！';
                    $this->couponLog($id,$Log_content);
                    $db->rollback();

                    echo json_encode(array('code' => 222, 'message' => '该活动已结束！'));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id.'时，已达领取限制！';
                $this->couponLog($id,$Log_content);
                $db->rollback();

                echo json_encode(array('code' => 115, 'message' => '参数错误！'));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id.'时，ID参数错误！';
            $this->couponLog($id,$Log_content);
            $db->rollback();

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
    public function mycoupon($store_id,$user_id,$type){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s',time()); // 当前时间
        $list1 = array();
        $list2 = array();
        $list3 = array();
        // 根据用户id,查询优惠券表
        $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and status = 0 and recycle = 0 order by type,add_time";
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
                    $v->activity_type = $r0[0]->activity_type; // 类型
                    $v->money = floatval($r0[0]->money);
                    $v->url = $r0[0]->url;
                    $v->discount = floatval($r0[0]->discount);
                    $v->Instructions = $r0[0]->Instructions;
                    $z_money = floatval($r0[0]->z_money);

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

        //查询出用户未使用的会员等级赠送商品
        $sql = "select attr_id,end_time,is_use as flag ,level from lkt_user_first  where store_id = $store_id and user_id = '$user_id' and attr_id is not NULL";
        $res = $db->select($sql);
        if($res){
            foreach($res as $k => $v){
                //查询配置有效天数
                $sql01 = "select valid from lkt_user_rule where store_id = $store_id";
                $res01 = $db->select($sql01);
                if($res01){
                    $v->valid = $res01[0]->valid;   
                }else{
                    $v->valid = 7;
                }
                $attr_id = $v->attr_id;
                $is_use = $v->flag;
                $end_time = date("Y-m-d",strtotime($v->end_time));
                $sql_1 = "select a.id as attr_id,b.id,b.product_title,b.imgurl from lkt_configure as a left join lkt_product_list as b on a.pid = b.id left join lkt_mch as c on b.mch_id = c.id  where b.store_id = '$store_id' and c.store_id = '$store_id' and b.active = 1 and b.status = 2  and a.num > 0 and a.id = '$attr_id' and b.id = a.pid ";
                $res_1 = $db->select($sql_1);
                if($res_1){//但该商品处于上架且库存足够才可使用
                    $v->product_title = $res_1[0]->product_title;
                    $v->imgurl =  ServerPath::getimgpath($res_1[0]->imgurl,$store_id);
                    $v->order_list =  json_encode(array(array('pid'=>$res_1[0]->id),array('cid'=>$res_1[0]->attr_id),array('num'=>1)));
                    $v->activity_type = '5';//兑换券
                    $v->Instructions = '1、本券可用于购买会员特惠商品，也可用于正价商品，不能与其它优惠一起使用\n2、本券一次使用一张，自领取日起有效期'.$v->valid.'天';
                    $v->expiry_time =  $end_time;
                    $now = time();
                    $expiry = strtotime($v->end_time);

                    if($is_use == 1){//已使用
                        $v->point = '已使用';
                        $v->type = 2;
                        array_push($list2, $v);
                    }else{//未使用
                        if($now < $expiry){//待使用
                            $v->point = '去兑换';
                            $v->type = 0;
                            array_push($list1, $v);
                        }else{//已过期
                            $v->point = '已过期';
                            $v->type = 3;
                            array_push($list3,$v);
                        }

                    }
                }else{

                }
                
               
            }
        }
        if($type == '0'){
            $list = $list1;
        }else if($type == '1'){
            $list = $list2;
        }else if($type == '2'){
            $list = $list3;
        }

        return $list;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/25  17:24
     * @version 1.0
     */
    // 进入结算页面
    public function Settlement($store_id, $user_id, $zong, $product_class, $product_id,$canshu,$yunfei)
    {
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间
        // 1.开启事务
        $db->begin();
        $arr = array();
        $arr1 = array();
        $arr2 = array();
        $arr2['coupon_name'] = '';
        // 根据用户id,查询优惠券状态为 (使用中)
        $sql = "select id,hid,expiry_time from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 1 and status = 0 and recycle = 0";
        $r = $db->select($sql);
        if ($r) { // 存在 使用中 的优惠券
            foreach ($r as $k => $v) { // 循环判断 优惠券是否绑定
                $id = $v->id; // 优惠券id
                $hid = $v->hid; // 活动id
                $expiry_time = $v->expiry_time; // 优惠券到期时间
                // 根据优惠券id,查询订单表(查看优惠券是否绑定)
                $sql = "select id from lkt_order where store_id = '$store_id' and status not in(6,7) and coupon_id = '$id' ";
                $rr = $db->select($sql);
                if (empty($rr)) { // 没有数据,表示优惠券没绑定
                    if($expiry_time <= $time){ // 当前时间 >= 优惠券到期时间
                        $sql = "update lkt_coupon set type = 3 where id = '$id'";
                        $r_coupon = $db->update($sql);
                        if($r_coupon == -1){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为已过期失败！';
                            $this->couponLog($id,$Log_content);
                        }else{
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为已过期成功！';
                            $this->couponLog($id,$Log_content);
                        }
                    }else{
                        $sql = "select name,activity_type,money,discount,z_money,type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                        $rr1 = $db->select($sql);

                        $activity_type = $rr1[0]->activity_type; // 优惠券类型
                        $arr2['activity_type'] = $rr1[0]->activity_type; // 优惠券类型
                        $money = $rr1[0]->money; // 面值
                        $discount = floatval($rr1[0]->discount); // 折扣值
                        $z_money = $rr1[0]->z_money; // 满多少
                        $type = $rr1[0]->type; // 优惠券使用范围
                        $product_class_id = $rr1[0]->product_class_id; // 分类id
                        $product_id1 = $rr1[0]->product_id; // 商品id
                        $zong_money = round(floor($zong * $discount*100)/100/10,2);
                        if($zong_money == 0){
                            $zong_money1 = 0;
                        }else{
                            $zong_money1 = $zong - $zong_money;
                        }
                        if($activity_type == 1){ // 免邮券
                            $arr2['coupon_name'] = $rr1[0]->name;
                            $arr2['money'] = '0';
                        }else if($activity_type == 2){ // 满减券
                            $arr2['coupon_name'] = '';
                        }else if($activity_type == 3){ // 折扣券
                            $arr2['coupon_name'] = '(' . $discount . '折)';
                            $arr2['money'] = $zong_money1;
                        }

                        if($activity_type == 4){
                            if($money == 0 && $discount != 0){ // 当会员赠券为折扣时
                                $res1 = $this->in_use($db,$id,3,$type,$zong,$z_money,$money,$discount,$zong_money1,$product_id1,$product_id,$product_class_id,$product_class);
                            }else{
                                $res1 = $this->in_use($db,$id,2,$type,$zong,$z_money,$money,$discount,$zong_money1,$product_id1,$product_id,$product_class_id,$product_class);
                            }
                        }else{
                            $res1 = $this->in_use($db,$id,$activity_type,$type,$zong,$z_money,$money,$discount,$zong_money1,$product_id1,$product_id,$product_class_id,$product_class);
                        }
                        if($res1 != array()){
                            if($yunfei == 0 && $activity_type == 1){ // 原本运费为0 并且 在使用中的优惠券为免邮券
                                // 改变免邮券状态（使用中改为未使用）
                                $sql = "update lkt_coupon set type = 0 where id = '$id'";
                                $r_coupon1 = $db->update($sql);
                                if($r_coupon1 == -1){
                                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为未使用失败！';
                                    $this->couponLog($id,$Log_content);
                                }else{
                                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为未使用成功！';
                                    $this->couponLog($id,$Log_content);
                                }
                            }else{
                                $arr2['coupon_id'] = $res1['coupon_id']; // 优惠券id
                                $arr2['money'] = $res1['money'];
                            }
                        }
                    }
                    break;
                }
            }
            if(!empty($arr2['coupon_id']) ){
                $arr = $arr2;
                $arr['coupon_status'] = true;
            }else{
                // 根据商城id、用户id、状态为未使用，查询优惠券信息，以到期时间顺序、金额倒序排列
                $sql = "select * from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 0 and status = 0 and recycle = 0 order by expiry_time asc,money desc ";
                $rr = $db->select($sql);

                if ($rr) { // 有 未使用 的优惠券
                    foreach ($rr as $k => $v) {
                        $id = $v->id; // 优惠券id
                        $hid = $v->hid; // 活动id
                        $expiry_time = $v->expiry_time; // 优惠券到期时间
                        if($expiry_time <= $time){
                            $sql = "update lkt_coupon set type = 3 where id = '$id'";
                            $r_coupon2 = $db->update($sql);
                            if($r_coupon2 == -1){
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为已过期失败！';
                                $this->couponLog($id,$Log_content);
                            }else{
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为已过期成功！';
                                $this->couponLog($id,$Log_content);
                            }
                        }else{
                            // 根据优惠券活动id，查询活动
                            $sql = "select name,activity_type,money,discount,z_money,type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                            $rr1 = $db->select($sql);
                            if($rr1){
                                $name = $rr1[0]->name; // 优惠券名称
                                $activity_type = $rr1[0]->activity_type; // 优惠券类型
                                $v->activity_type = $rr1[0]->activity_type; // 优惠券类型
                                $money = $rr1[0]->money; // 面值
                                $v->money = $rr1[0]->money; // 面值
                                $discount = floatval($rr1[0]->discount); // 折扣值
                                $z_money = $rr1[0]->z_money; // 满多少
                                $type = $rr1[0]->type; // 优惠券使用范围
                                $product_class_id = $rr1[0]->product_class_id; // 分类id
                                $product_id1 = $rr1[0]->product_id; // 商品id
                                $zong_money = round(floor($zong * $discount*100)/100/10,2);
                                if($zong_money == 0){
                                    $zong_money1 = 0;
                                }else{
                                    $zong_money1 = $zong - $zong_money;
                                }
                                if($activity_type == 1){ // 免邮券
                                    $v->money = '0';
                                    $v->coupon_name = $name;
                                }else if($activity_type == 2){ // 满减券
                                    $v->coupon_name = '';
                                }else if($activity_type == 3){ // 折扣券
                                    $v->coupon_name = '(' . $discount . '折)';
                                    $v->money = $zong_money1;
                                }
                                if($activity_type == 4){
                                    if($money == 0 && $discount != 0){ // 当会员赠券为折扣时
                                        $v->coupon_name = '(' . $discount . '折)';
                                        $v->money = $zong_money1;
                                        $list = $this->coupin_list(3,$type,$zong,$z_money,$money,$v,$product_id1,$product_id,$product_class_id,$product_class);
                                    }else{
                                        $v->coupon_name = '';
                                        $list = $this->coupin_list(2,$type,$zong,$z_money,$money,$v,$product_id1,$product_id,$product_class_id,$product_class);
                                    }
                                }else{

                                    if($yunfei == 0 && $activity_type == 1) { // 原本运费为0
                                        $list = '';
                                    }else{
                                        $list = $this->coupin_list($activity_type,$type,$zong,$z_money,$money,$v,$product_id1,$product_id,$product_class_id,$product_class);
                                    }
                                }
                                if($list != ''){
                                    $arr1[] = $list;
                                }
                            }
                        }
                    }
                    $arr1 = isset($arr1) ? $arr1:array();
                    if ($arr1 != array()) {
                        if($canshu == 'true'){
                            // 设置默认优惠券
                            $sql = "update lkt_coupon set type = 1 where store_id = '$store_id' and id = " . $arr1[0]['id'];
                            $r_coupon3 = $db->update($sql);
                            if($r_coupon3 == -1){
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为使用中失败！';
                                $this->couponLog($id,$Log_content);
                            }else{
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为使用中成功！';
                                $this->couponLog($id,$Log_content);
                            }
                            $arr['activity_type'] = $arr1[0]['activity_type'];
                            $arr['money'] = $arr1[0]['money'];
                            $arr['coupon_id'] = $arr1[0]['id'];
                            $arr['coupon_name'] = $arr1[0]['coupon_name'];
                            $arr['coupon_status'] = true;
                        }else{
                            $arr['activity_type'] = 0;
                            $arr['money'] = 0;
                            $arr['coupon_id'] = 0;
                            $arr['coupon_name'] = '';
                            $arr['coupon_status'] = true;
                        }
                    } else {
                        $arr['activity_type'] = 0;
                        $arr['money'] = 0;
                        $arr['coupon_id'] = 0;
                        $arr['coupon_name'] = '';
                        $arr['coupon_status'] = false;
                    }
                } else { // 没有 未使用 的优惠券
                    $arr['activity_type'] = 0;
                    $arr['money'] = 0;
                    $arr['coupon_id'] = 0;
                    $arr['coupon_name'] = '';
                    $arr['coupon_status'] = false;
                }
            }
        } else { // 当进入结算页面，没有优惠券在使用中
            // 根据商城id、用户id、状态为未使用，查询优惠券信息，以到期时间顺序、金额倒序排列
            $sql = "select id,money,hid,expiry_time from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 0 and status = 0 and recycle = 0 order by money desc,expiry_time asc ";
            $rr = $db->select($sql);
            if ($rr) { // 有 未使用 的优惠券
                foreach ($rr as $k => $v) {
                    $id = $v->id; // 优惠券id
                    $hid = $v->hid; // 活动id
                    $expiry_time = $v->expiry_time; // 优惠券到期时间
                    if($expiry_time <= $time){
                        $sql = "update lkt_coupon set type = 3 where id = '$id'";
                        $r_coupon2 = $db->update($sql);
                        if($r_coupon2 == -1){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为已过期失败！';
                            $this->couponLog($id,$Log_content);
                        }else{
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为已过期成功！';
                            $this->couponLog($id,$Log_content);
                        }
                    }else{
                        // 根据优惠券活动id，查询活动
                        $sql = "select name,activity_type,money,discount,z_money,type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                        $rr1 = $db->select($sql);
                        if($rr1){
                            $name = $rr1[0]->name; // 优惠券名称
                            $activity_type = $rr1[0]->activity_type; // 优惠券类型
                            $v->activity_type = $rr1[0]->activity_type; // 优惠券类型
                            $money = $rr1[0]->money; // 面值
                            $v->money = $rr1[0]->money; // 面值
                            $discount = floatval($rr1[0]->discount); // 折扣值
                            $z_money = $rr1[0]->z_money; // 满多少
                            $type = $rr1[0]->type; // 优惠券使用范围
                            $product_class_id = $rr1[0]->product_class_id; // 分类id
                            $product_id1 = $rr1[0]->product_id; // 商品id
                            $zong_money = round(floor($zong * $discount*100)/100/10,2);
                            if($zong_money == 0){
                                $zong_money1 = 0;
                            }else{
                                $zong_money1 = $zong - $zong_money;
                            }
                            if($activity_type == 1){
                                $v->money = '0'; // 优惠券金额
                                $v->coupon_name = $name;
                            }else if($activity_type == 2){
                                $v->coupon_name = '';
                            }else if($activity_type == 3){
                                $v->coupon_name = '(' . $discount . '折)';
                                $v->money = $zong_money1;
                            }
                            if($activity_type == 4){
                                if($money == 0 && $discount != 0){ // 当会员赠券为折扣时
                                    $v->coupon_name = '(' . $discount . '折)';
                                    $v->money = $zong_money1;
                                    $list = $this->coupin_list(3,$type,$zong,$z_money,$money,$v,$product_id1,$product_id,$product_class_id,$product_class);
                                }else{
                                    $v->coupon_name = '';

                                    $list = $this->coupin_list(2,$type,$zong,$z_money,$money,$v,$product_id1,$product_id,$product_class_id,$product_class);
                                }
                            }else{
                                if($yunfei == 0 && $activity_type == 1){ // 原本运费为0 并且 在使用中的优惠券为免邮券
                                    $list = '';
                                }else{
                                    $list = $this->coupin_list($activity_type,$type,$zong,$z_money,$money,$v,$product_id1,$product_id,$product_class_id,$product_class);
                                }
                            }
                            if($list != ''){
                                $arr1[] = $list;
                            }
                        }
                    }
                }

                $arr1 = isset($arr1) ? $arr1:array();
                if ($arr1 != array()) {
                    if($canshu == 'true'){
                        // 设置默认优惠券
                        $sql = "update lkt_coupon set type = 1 where store_id = '$store_id' and id = " . $arr1[0]['id'];
                        $r_coupon3 = $db->update($sql);
                        if($r_coupon3 == -1){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为使用中失败！';
                            $this->couponLog($id,$Log_content);
                        }else{
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为使用中成功！';
                            $this->couponLog($id,$Log_content);
                        }
                        $arr['activity_type'] = $arr1[0]['activity_type'];
                        $arr['money'] = $arr1[0]['money'];
                        $arr['coupon_id'] = $arr1[0]['id'];
                        $arr['coupon_name'] = $arr1[0]['coupon_name'];
                        $arr['coupon_status'] = true;
                    }else{
                        $arr['activity_type'] = 0;
                        $arr['money'] = 0;
                        $arr['coupon_id'] = 0;
                        $arr['coupon_name'] = '';
                        $arr['coupon_status'] = true;
                    }
                } else {
                    $arr['activity_type'] = 0;
                    $arr['money'] = 0;
                    $arr['coupon_id'] = 0;
                    $arr['coupon_name'] = '';
                    $arr['coupon_status'] = false;
                }
            } else { // 没有 未使用 的优惠券
                $arr['activity_type'] = 0;
                $arr['money'] = 0;
                $arr['coupon_id'] = 0;
                $arr['coupon_name'] = '';
                $arr['coupon_status'] = false;
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
    public function my_coupon($store_id,$user_id,$zong,$product_id,$product_class){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间
        $rew_1 = 0;
        $arr = array();
        $coupon_hid = 0;
        // 根据用户id,查询优惠券状态为使用中的数据
        $sql = "select id,hid,expiry_time from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 1 and status = 0 and recycle = 0";
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
                $activity_type = $rr1[0]->activity_type; // 优惠券类型
                $v->activity_type = $rr1[0]->activity_type; // 优惠券类型
                $money = $rr1[0]->money; // 面值
                $discount = floatval($rr1[0]->discount); // 折扣值
                $v->name = $rr1[0]->name; // 活动名称
                $v->money = $rr1[0]->money; // 面值
                $zong_money = round(floor($zong * $discount*100)/100/10,2);
                if($zong_money == 0){
                    $zong_money1 = 0;
                }else{
                    $zong_money1 = $zong - $zong_money;
                }
                // 根据优惠券id,查询订单
                $sql = "select id from lkt_order where store_id = '$store_id' and status not in(6,7) and coupon_id = '$id' ";
                $r_1 = $db->select($sql);

                if(empty($r_1)){ // 没有数据,表示该优惠券没绑定
                    if($expiry_time <= $time){ // 优惠券有效期 <= 当前时间
                        // 修改优惠券状态（已过期）
                        $sql = "update lkt_coupon set type = 3 where store_id = '$store_id' and coupon_id = '$id'";
                        $r_coupon2 = $db->update($sql);
                        if($r_coupon2 == -1){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为已过期失败！';
                            $this->couponLog($id,$Log_content);
                        }else{
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$id.'修改为已过期成功！';
                            $this->couponLog($id,$Log_content);
                        }
                    }else{
                        $v->point = '正在使用';
                        $v->coupon_status = 1; // 按钮状态 可以点击
                        if($activity_type == 1){
                            $v->money = 0;
                            $v->coupon_name = '';
                            $arr[$rew_1] = (array)$v;
                        }else if($activity_type == 2){
                            $v->coupon_name = '';
                            $arr[$rew_1] = (array)$v;
                        }else if($activity_type == 3){
                            $v->coupon_name = '(' . $discount . '折)';
                            $v->money = $zong_money1;
                            $arr[$rew_1] = (array)$v;
                        }else if($activity_type == 4){
                            if($v->money != 0){
                                $v->coupon_name = '';
                            }else{
                                $v->coupon_name = '(' . $discount . '折)';
                                $v->money = $zong_money1;
                            }
                            $arr[$rew_1] = (array)$v;
                        }
                    }
                }
            }
        }
        // 根据用户id,查询优惠券状态为(未使用),以优惠券过期时间顺序排列
        $sql = "select id,hid,expiry_time from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and type = 0 and status = 0 and recycle = 0 order by expiry_time";
        $rr = $db->select($sql);
        if($rr){
            foreach ($rr as $k => $v) {
                $rew_2 = ++$rew_1;
                $hid = $v->hid;
                // 根据优惠券活动id，查询活动
                $sql = "select * from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                $rr1 = $db->select($sql);
                if($rr1){
                    $v->name = $rr1[0]->name; // 活动名称
                    $activity_type = $rr1[0]->activity_type; // 优惠券类型
                    $v->activity_type = $rr1[0]->activity_type; // 优惠券类型
                    $money = $rr1[0]->money; // 面值
                    $v->money = $rr1[0]->money; // 面值
                    $discount = floatval($rr1[0]->discount); // 折扣值
                    $z_money = $rr1[0]->z_money; // 满多少
                    $type = $rr1[0]->type; // 优惠券使用范围
                    $product_class_id = $rr1[0]->product_class_id; // 分类id
                    $product_id1 = $rr1[0]->product_id; // 商品id
                    $zong_money = round(floor($zong * $discount*100)/100/10,2);
                    if($zong_money == 0){
                        $zong_money1 = 0;
                    }else{
                        $zong_money1 = $zong - $zong_money;
                    }
                    $v->coupon_status = 1; // 按钮状态 可以点击
                    if($activity_type == 4){
                        if($money == 0 && $discount != 0){ // 当会员赠券为折扣时
                            $list = $this->coupin_list1(3,$type,$zong,$z_money,$v,$discount,$zong_money1,$product_id1,$product_id,$product_class_id,$product_class);
                        }else{
                            $list = $this->coupin_list1(2,$type,$zong,$z_money,$v,$discount,$zong_money1,$product_id1,$product_id,$product_class_id,$product_class);
                        }
                    }else{
                        $list = $this->coupin_list1($activity_type,$type,$zong,$z_money,$v,$discount,$zong_money1,$product_id1,$product_id,$product_class_id,$product_class);
                    }
                    if($list != '' && $list != array()){
                        $arr[$rew_2] = $list;
                    }
                }
            }
        }else{
            $rew_2 = $rew_1;
        }
        $arr = $this->array_orderby($arr,'money', SORT_DESC, 'expiry_time', SORT_ASC);

        $rew_3 = $rew_2 + 1;
        $arr[$rew_3] = array('id'=>0,'activity_type'=>0,'money'=>0,'coupon_name'=>'','hid'=>0,'expiry_time'=>0,'name'=>'不使用优惠券','coupon_status'=>1);
        return $arr;
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
        $arr['coupon_name'] = '未使用优惠券';
        $arr['activity_type'] = 0; // 优惠券类型

        // 根据用户id、优惠劵状态为使用中，查询没绑定的优惠劵
        $sql = "select a.id from lkt_coupon as a where (select count(1) AS num from lkt_order as b where b.store_id = '$store_id' and a.id = b.coupon_id and b.status not in (6,7)) = 0 and a.user_id = '$user_id' and a.type = 1 and a.status = 0";
        $r = $db->select($sql);

        if($r){ // 有没绑定的优惠劵id
            foreach ($r as $k => $v){
                // 改原状态为(使用中 变为 未使用)
                $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and user_id = '$user_id' and id = '$v->id'";
                $r_coupon2 = $db->update($sql);
                if($r_coupon2 == -1){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$v->id.'修改为未使用失败！';
                    $this->couponLog($v->id,$Log_content);
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$v->id.'修改为未使用成功！';
                    $this->couponLog($v->id,$Log_content);
                }
            }
        }

        if($coupon_id == '' || $coupon_id == 0){ // 没有选择优惠券

        }else{ // 选择优惠券
            $coupon_id1 = explode(',',$coupon_id);
            foreach ($coupon_id1 as $k => $v){
                $sql = "select hid from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and id = '$v'";
                $r = $db->select($sql);

                $hid = $r[0]->hid;
                $sql = "select name,activity_type,money,discount,z_money from lkt_coupon_activity where store_id = '$store_id' and id = '$hid'";
                $r1 = $db->select($sql);
                $name = $r1[0]->name; // 优惠券名称
                $activity_type = $r1[0]->activity_type; // 优惠券类型
                $arr['activity_type'] = $r1[0]->activity_type; // 优惠券类型
                $money = $r1[0]->money; // 面值
                $discount = floatval($r1[0]->discount); // 折扣值
                $zong_money = round(floor($zong * $discount*100)/100/10,2);
                if($zong_money == 0){
                    $zong_money1 = 0;
                }else{
                    $zong_money1 = $zong - $zong_money;
                }
                if($activity_type == 1) {
                    $arr['coupon_name'] = $name;
                    $arr['money'] = '0';
                }else if($activity_type == 2){
                    $arr['coupon_name'] = '';
                    if($zong > $money){
                        $arr['money'] = $money; // 优惠券金额
                    }else{
                        $arr['money'] = $zong; // 优惠券金额
                    }
                }else if($activity_type == 3){
                    $arr['coupon_name'] = '(' . $discount . '折)';
                    $arr['money'] = $zong_money1;
                }else if($activity_type == 4){
                    if($money != 0){
                        $arr['coupon_name'] = '';
                        if($zong > $money){
                            $arr['money'] = $money; // 优惠券金额
                        }else{
                            $arr['money'] = $zong; // 优惠券金额
                        }
                    }else{
                        $arr['coupon_name'] = '(' . $discount . '折)';
                        $arr['money'] = $zong_money1;
                    }
                }
                $arr['id'] = $v;
            }
            $sql = "update lkt_coupon set type = 1 where store_id = '$store_id' and user_id = '$user_id' and id = '$coupon_id'";
            $r_coupon = $db->update($sql);
            if($r_coupon == -1){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$coupon_id.'修改为使用中失败！';
                $this->couponLog($coupon_id,$Log_content);
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'优惠券ID为'.$coupon_id.'修改为使用中成功！';
                $this->couponLog($coupon_id,$Log_content);
            }
        }
        return $arr;
    }

    // 验证商品是否符合条件
    public function product_accord($product_id1,$product_id){
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
        return $product_status;
    }
    // 验证商品分类是否符合条件
    public function calss_accord($product_class_id,$product_class){
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
        return $calss_status;
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

    // 获取商品可用优惠券活动
    public function pro_coupon($store_id,$user_id,$pro_id){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间
        $arr = array();
        $sql0 = "select product_class from lkt_product_list where store_id = '$store_id' and id = '$pro_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $product_class = $r0[0]->product_class;

            $sql1 = "select id,name,activity_type,money,discount,z_money,receive,num,url,start_time,end_time,type,product_id,product_class_id from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status = 1 order by start_time desc";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    $activity_id = $v->id; // 优惠券活动id
                    $activity_type = $v->activity_type; // 优惠券类型
                    $z_money = floatval($v->z_money); // 满多少
                    $receive = $v->receive; // 领取限制
                    $num = $v->num; // 剩余个数
                    $end_time = $v->end_time; // 活动结束时间
                    $v->start_time = date("Y.m.d",strtotime($v->start_time));
                    $v->end_time = date("Y.m.d",strtotime($v->end_time));

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
                        if($user_id == ''){
                            $v->point = '立即领取';
                            $v->point_type = 1;
                        }else{
                            $sql3 = "select count(id) as num from lkt_coupon where store_id = '$store_id' and user_id = '$user_id' and hid = '$activity_id'";
                            $r3 = $db->select($sql3);
                            if($r3[0]->num > 0){ // 已领取
                                if($receive > $r3[0]->num){
                                    if($num > 0) {
                                        $v->point = '立即领取';
                                        $v->point_type = 1;
                                    }else{
                                        $v->point = '可用商品';
                                        $v->point_type = 2;
                                    }
                                }else{
                                    $v->point = '可用商品';
                                    $v->point_type = 2;
                                }
                            }else{
                                if($num > 0){ // 还有剩下优惠券没领取
                                    $v->point = '立即领取';
                                    $v->point_type = 1;
                                }else{
                                    $v->point = '已抢光';
                                    $v->point_type = 3;
                                }
                            }
                        }
                    }
                    if($activity_type != 4){
                        if($v->type == 1){
                            if($v->point != '已抢光'){
                                $arr[] = (array)$v;
                            }
                        }else if($v->type == 2){
                            $product_list = unserialize($v->product_id);
                            $product_list = explode(',',$product_list);
                            if(in_array($pro_id,$product_list)){
                                if($v->point != '已抢光'){
                                    $arr[] = (array)$v;
                                }
                            }
                        }else if($v->type == 3){
                            $product_class_list = unserialize($v->product_class_id);
                            $product_class_list = explode(',',$product_class_list);
                            foreach ($product_class_list as $key => $val){
                                if(strpos($product_class,$val) !== false){
                                    if($v->point != '已抢光'){
                                        $arr[] = (array)$v;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }
    // 定时处理
    public function timing(){
        $db = DBAction::getInstance();
        $time = date('Y-m-d H:i:s');  // 当前时间
        // 查询优惠券设置
        $sql0_0 = "select * from lkt_coupon_config ";
        $r0_0 = $db->select($sql0_0);
        if($r0_0){
            foreach ($r0_0 as $k => $v){
                $store_id = $v->store_id; // 商城ID
                $coupon_del = $v->coupon_del; // 优惠券删除
                $coupon_day = $v->coupon_day; // 优惠券删除天数
                $activity_del = $v->activity_del; // 优惠券活动删除
                $activity_day = $v->activity_day; // 优惠券活动删除天数
                if($coupon_del == 1){
                    $del1 = date('Y-m-d H:i:s',strtotime("-$coupon_day day",time()));

                    $sql0_1 = "update lkt_conpon set recycle = 1 where store_id = '$store_id' and type = 3 and expiry_time <= '$del1'";
                    $db->update($sql0_1);
                }
                if($activity_del == 1){
                    $del2 = date('Y-m-d H:i:s',strtotime("-$activity_day day",time()));

                    $sql0_1 = "update lkt_coupon_activity set recycle = 1 where store_id = '$store_id' and status = 3 and end_time <= '$del2'";
                    $db->update($sql0_1);
                }
            }
        }
        $sql0 = "select id,status,start_time,end_time from lkt_coupon_activity where status != 3";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                if($v->status == 0){
                    if($v->start_time <= $time){
                        $sql1 = "update lkt_coupon_activity set status = 1 where id = " . $v->id;
                        $r1 = $db->update($sql1);
                    }
                }else if($v->status == 1 || $v->status == 2){
                    if($v->end_time <= $time){
                        $sql2 = "update lkt_coupon_activity set status = 3 where id = " . $v->id;
                        $r2 = $db->update($sql2);

                        $sql3 = "update lkt_conpon set type = 3 where hid = " . $v->id;
                        $r3 = $db->update($sql3);
                    }
                }
            }
        }

        $sql4 = "select id,expiry_time from lkt_coupon where type in (0,1)";
        $r4 = $db->select($sql4);
        if($r4){
            foreach ($r4 as $ke => $va){
                if($va->expiry_time <= $time){
                    $sql5 = "update lkt_coupon set type = 3 where id = " . $va->id;
                    $r5 = $db->update($sql5);
                }
            }
        }
        return;
    }
    // 优惠券日志
    public function couponLog($id,$Log_content){
        $lktlog = new LaiKeLogUtils("app/coupon.log");
        if($id != 0){
            $lktlog->customerLog($Log_content);
        }
        return;
    }
    // 验证正在使用中
    public function in_use($db,$id,$activity_type,$type,$zong,$z_money,$money,$discount,$zong_money1,$product_id1,$product_id,$product_class_id,$product_class){
        $arr = array();
        if($activity_type == 1){
            if($type == 1) { // 全部商品
                if($z_money == 0){
                    $arr['coupon_id'] = $id; // 优惠券id
                    $arr['money'] = '0';
                }else{
                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                        $arr['coupon_id'] = $id; // 优惠券id
                        $arr['money'] = '0';
                    }else{
                        $sql0 = "update lkt_coupon set type = 0 where id = '$id'";
                        $db->update($sql0);
                    }
                }
            }else if($type == 2){
                $product_status = $this->product_accord($product_id1,$product_id);
                if($product_status  != 0){ // 符合
                    if($z_money == 0){
                        $arr['coupon_id'] = $id; // 优惠券id
                        $arr['money'] = '0';

                    }else{
                        if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                            $arr['coupon_id'] = $id; // 优惠券id
                            $arr['money'] = '0'; // 优惠券金额
                        }else{
                            $sql = "update lkt_coupon set type = 0 where id = '$id'";
                            $db->update($sql);
                        }
                    }
                }else{
                    $sql = "update lkt_coupon set type = 0 where id = '$id'";
                    $db->update($sql);
                }
            }else if($type == 3){
                $calss_status = $this->calss_accord($product_class_id,$product_class);
                if($calss_status  != 0){ // 符合
                    if($z_money == 0){
                        $arr['coupon_id'] = $id; // 优惠券id
                        $arr['money'] = '0'; // 优惠券金额
                    }else{
                        if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                            $arr['coupon_id'] = $id; // 优惠券id
                            $arr['money'] = '0'; // 优惠券金额
                        }else{
                            $sql = "update lkt_coupon set type = 0 where id = '$id'";
                            $db->update($sql);
                        }
                    }
                }else{
                    $sql = "update lkt_coupon set type = 0 where id = '$id'";
                    $db->update($sql);
                }
            }
        }else if($activity_type == 2){
            if($type == 1){ // 全部商品
                if($z_money == 0){
                    $arr['coupon_id'] = $id; // 优惠券id
                    if($zong > $money){
                        $arr['money'] = floatval($money); // 优惠券金额
                    }else{
                        $arr['money'] = $zong; // 优惠券金额
                    }
                }else{
                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                        $arr['coupon_id'] = $id; // 优惠券id
                        if($money > $zong){
                            $arr['money'] = floatval($zong); // 优惠券金额
                        }else{
                            $arr['money'] = floatval($money); // 优惠券金额
                        }
                    }else{
                        $sql = "update lkt_coupon set type = 0 where id = '$id'";
                        $db->update($sql);
                    }
                }
            }else if($type == 2){
                $product_status = $this->product_accord($product_id1,$product_id);
                if($product_status != 0){ // 符合
                    if($z_money == 0){
                        $arr['coupon_id'] = $id; // 优惠券id
                        if($zong > $money){
                            $arr['money'] = floatval($money); // 优惠券金额
                        }else{
                            $arr['money'] = $zong; // 优惠券金额
                        }
                    }else{
                        if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                            $arr['coupon_id'] = $id; // 优惠券id
                            $arr['money'] = floatval($money); // 优惠券金额
                        }else{
                            $sql = "update lkt_coupon set type = 0 where id = '$id'";
                            $db->update($sql);
                        }
                    }
                }else{
                    $sql = "update lkt_coupon set type = 0 where id = '$id'";
                    $db->update($sql);
                }
            }else if($type == 3){
                $calss_status = $this->calss_accord($product_class_id,$product_class);
                if($calss_status  != 0){ // 符合
                    if($z_money == 0){
                        $arr['coupon_id'] = $id; // 优惠券id
                        if($zong > $money){
                            $arr['money'] = floatval($money); // 优惠券金额
                        }else{
                            $arr['money'] = $zong; // 优惠券金额
                        }
                    }else{
                        if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                            $arr['coupon_id'] = $id; // 优惠券id
                            $arr['money'] = floatval($money); // 优惠券金额
                        }else{
                            $sql = "update lkt_coupon set type = 0 where id = '$id'";
                            $db->update($sql);
                        }
                    }
                }else{
                    $sql = "update lkt_coupon set type = 0 where id = '$id'";
                    $db->update($sql);
                }
            }
        }else if($activity_type == 3){
            if($type == 1){ // 全部商品
                if($z_money == 0){
                    $arr['coupon_id'] = $id; // 优惠券id
                    $arr['money'] = $zong_money1;
                }else{
                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                        $arr['coupon_id'] = $id; // 优惠券id
                        $arr['money'] = floatval($zong_money1); // 优惠券金额
                    }else{
                        $sql = "update lkt_coupon set type = 0 where id = '$id'";
                        $db->update($sql);
                    }
                }
            }else if($type == 2){
                $product_status = $this->product_accord($product_id1,$product_id);
                if($product_status  != 0){ // 符合
                    if($z_money == 0){
                        $arr['coupon_id'] = $id; // 优惠券id
                        $arr['money'] = $zong_money1;
                    }else{
                        if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                            $arr['coupon_id'] = $id; // 优惠券id
                            $arr['money'] = floatval($zong_money1); // 优惠券金额
                        }else{
                            $sql = "update lkt_coupon set type = 0 where id = '$id'";
                            $db->update($sql);
                        }
                    }
                }else{
                    $sql = "update lkt_coupon set type = 0 where id = '$id'";
                    $db->update($sql);
                }
            }else if($type == 3){
                $calss_status = $this->calss_accord($product_class_id,$product_class);
                if($calss_status  != 0){ // 符合
                    if($z_money == 0){
                        $arr['coupon_id'] = $id; // 优惠券id
                        $arr['money'] = floatval($zong_money1);
                    }else{
                        if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                            $arr['coupon_id'] = $id; // 优惠券id
                            $arr['money'] = floatval($zong_money1); // 优惠券金额
                        }else{
                            $sql = "update lkt_coupon set type = 0 where id = '$id'";
                            $db->update($sql);
                        }
                    }
                }else{
                    $sql = "update lkt_coupon set type = 0 where id = '$id'";
                    $db->update($sql);
                }
            }
        }
        return $arr;
    }
    // 验证优惠券是否符合（进入确认订单页面）
    public function coupin_list($activity_type,$type,$zong,$z_money,$money,$v,$product_id1,$product_id,$product_class_id,$product_class){
        $list = '';
        if($type == 1){ // 全部商品
            if($z_money == 0){
                if($activity_type == 2){
                    if($zong > $money){
                        $v->money = $v->money; // 优惠券金额
                    }else{
                        $v->money = $zong; // 优惠券金额
                    }
                }
                $list = (array)$v;
            }else{
                if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                    $list = (array)$v;
                }
            }
        }else if($type == 2){
            $product_status = $this->product_accord($product_id1,$product_id);
            if($product_status  != 0){ // 符合
                if($z_money == 0){
                    if($zong > $money){
                        $v->money = $v->money; // 优惠券金额
                    }else{
                        $v->money = $zong; // 优惠券金额
                    }
                    $list = (array)$v;
                }else{
                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                        $list = (array)$v;
                    }
                }
            }
        }else if($type == 3){
            $calss_status = $this->calss_accord($product_class_id,$product_class);
            if($calss_status  != 0){ // 符合
                if($z_money == 0){
                    if($zong > $money){
                        $v->money = $v->money; // 优惠券金额
                    }else{
                        $v->money = $zong; // 优惠券金额
                    }
                    $list = (array)$v;
                }else{
                    if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                        $list = (array)$v;
                    }
                }
            }
        }
        return $list;
    }
    // 验证优惠券是否符合（确认订单页面，弹窗优惠券选择）
    public function coupin_list1($activity_type,$type,$zong,$z_money,$v,$discount,$zong_money1,$product_id1,$product_id,$product_class_id,$product_class){
        $res = '';
        if($activity_type == 1){
            $v->money = 0;
            $v->coupon_name = $v->name;
            if($type == 1){ // 全部商品
                $res = $this->coupin_list2($zong,$z_money,$v);
            }else if($type == 2){
                $product_status = $this->product_accord($product_id1,$product_id);
                if($product_status != 0){ // 符合
                    $res = $this->coupin_list2($zong,$z_money,$v);
                }
            }else if($type == 3){
                $calss_status = $this->calss_accord($product_class_id,$product_class);
                if($calss_status != 0){ // 符合
                    $res = $this->coupin_list2($zong,$z_money,$v);
                }
            }
        }else if($activity_type == 2){
            $v->coupon_name = '';
            if($type == 1){ // 全部商品
                $res = $this->coupin_list2($zong,$z_money,$v);
            }else if($type == 2){
                $product_status = $this->product_accord($product_id1,$product_id);
                if($product_status != 0){ // 符合
                    $res = $this->coupin_list2($zong,$z_money,$v);
                }
            }else if($type == 3){
                $calss_status = $this->calss_accord($product_class_id,$product_class);
                if($calss_status != 0){ // 符合
                    $res = $this->coupin_list2($zong,$z_money,$v);
                }
            }
        }else if($activity_type == 3){
            $v->coupon_name = '(' . $discount . '折)';
            $v->money = $zong_money1;

            if($type == 1){ // 全部商品
                $res = $this->coupin_list2($zong,$z_money,$v);
            }else if($type == 2){
                $product_status = $this->product_accord($product_id1,$product_id);
                if($product_status != 0){ // 符合
                    $res = $this->coupin_list2($zong,$z_money,$v);
                }
            }else if($type == 3){
                $calss_status = $this->calss_accord($product_class_id,$product_class);
                if($calss_status != 0){ // 符合
                    $res = $this->coupin_list2($zong,$z_money,$v);
                }
            }
        }
        return $res;
    }

    public function coupin_list2($zong,$z_money,$v){
        $list = array();
        if($z_money == 0){
            $list = (array)$v;
        }else{
            if($zong >= $z_money){ // 商品总价 >= 优惠券满多少
                $list = (array)$v;
            }
        }
        return $list;
    }
    // 赠券
    public function Coupons($store_id,$user_id,$grade_id){
        $db = DBAction::getInstance();
        $db->begin();
        // 根据商城ID、会员等级，查询优惠券活动为开启且未回收的数据
        $sql0 = "select * from lkt_coupon_activity where store_id = '$store_id' and status = 1 and recycle = 0 and grade_id = '$grade_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id; // 优惠券活动ID
            $name = $r0[0]->name; // 优惠券名称
            $day = $r0[0]->day; // 天数
            $end_time = date('Y-m-d H:i:s',strtotime("+$day day",time())); // 优惠券有效期

            // 在优惠券表里添加一条数据
            $sql1 = "insert into lkt_coupon(store_id,user_id,add_time,expiry_time,hid) values('$store_id','$user_id',CURRENT_TIMESTAMP,'$end_time','$id')";
            $r1 = $db->insert($sql1);
            if($r1 == -1){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id.'时，添加失败！';
                $this->couponLog($id,$Log_content);
                $db->rollback();

                echo json_encode(array('code' => 115, 'message' => '参数错误！'));
                exit;
            }
            $res = '您领取了'.$name.'优惠券！';

            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'领取优惠券活动ID为'.$id;
            $this->couponLog($id,$Log_content);
            $db->commit();
        }
        return;
    }
}

?>