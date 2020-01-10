<?php
require_once(MO_CONFIG_DIR . '/db_config.php');

class subtraction
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=subtraction&action=Index',
//            'index.php?module=subtraction&action=Add',
//            'index.php?module=subtraction&action=Modify',
//            'index.php?module=subtraction&action=Config',
//            'index.php?module=subtraction&action=Change',
//            'index.php?module=subtraction&action=Record',
//            'index.php?module=subtraction&action=Del',
//            'index.php?module=subtraction&action=Subtraction_del',
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select is_subtraction from lkt_subtraction_config where store_id = '$store_id' ";
        $r0 = $db->select($sql0);
        if($r0){
            $is_display = $r0[0]->is_subtraction;
        }else{
            $is_display = 2;
        }
        return $is_display;
    }
    // 添加插件设置
    public function add($store_id){
        $db = DBAction::getInstance();
        $sql0 = "insert into lkt_subtraction_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_subtraction_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    // 结算页面/生成订单时计算自动满减金额
    public function auto_jian($db,$store_id,$products,$address)
    {
        if($address != array()){
            $address_id1 = $address['id'];
        }else{
            $address_id1 = 0;
        }
        $zong = 0;
        $num = 0;
        $give_id = 0;
        foreach ($products as $k => $v) {
            foreach ($v['list'] as $ke => $va){
                $zong += $va['price'] * $va['num'];
                $num += $va['num'];
            }
        }

        $sql0_0 = "select is_subtraction,is_shipping,z_money,address_id from lkt_subtraction_config where store_id = '$store_id'";
        $r0_0 = $db->select($sql0_0);

        if($r0_0){
            $is_subtraction = $r0_0[0]->is_subtraction; // 是否开启满减 0.否 1.是
            $is_shipping = $r0_0[0]->is_shipping; // 满减包邮设置 0.否 1.是
            $z_money = $r0_0[0]->z_money;
            $address_id = $r0_0[0]->address_id;
            if($is_shipping == 1){ // 满减包邮设置开启
                $arr = explode(',',$address_id);
                if($address_id1 != 0){ // 存在地址
                    if(in_array($address_id1,$arr)){ // 验证收货地址是否存在包邮地址里
                        $res = array('subtraction_id'=>0,'reduce_money'=>0,'products'=>$products,'reduce_name_array'=>'','reduce_name'=>'','give_id'=>0);
                    }else{
                        $is_shipping = 0;
                        if($is_subtraction == 1){
                            $res = $this->subtraction_list($store_id,$products);
                        }
                    }
                }else{
                    $is_shipping = 0;
                    if($is_subtraction == 1){
                        $res = $this->subtraction_list($store_id,$products);
                    }
                }
            }else{ // 关闭
                if($is_subtraction == 1){
                    $res = $this->subtraction_list($store_id,$products);
                }
            }
        }else{
            $is_subtraction = 0;
            $is_shipping = 0;
        }

        $res['is_subtraction'] = $is_subtraction;
        $res['is_shipping'] = $is_shipping;

        return $res;
    }
    // 添加满减记录
    public function subtraction_record($db,$store_id,$user_id,$sNo){
        //1.开启事务
        $db->begin();

        $sql00 = "select coupon_activity_name from lkt_order where store_id = '$store_id' and sNo = '$sNo'";
        $r00 = $db->select($sql00);
        $coupon_activity_name = $r00[0]->coupon_activity_name;

        $sql0 = "select id from lkt_subtraction where store_id = '$store_id' and name = '$coupon_activity_name'";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id;
            $content = '会员'.$user_id.'的订单号为'.$sNo.'参与满减活动'.$coupon_activity_name;
            $sql1 = "insert into lkt_subtraction_record(h_id,sNo,user_id,content,add_date) value ('$id','$sNo','$user_id','$content',CURRENT_TIMESTAMP)";
            $r1 = $db->insert($sql1);
            if($r1){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'生成订单号'.$sNo.'参与满减活动'.$coupon_activity_name.'添加记录成功！';
                $this->subtractionLog($id,$Log_content);
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'生成订单号'.$sNo.'参与满减活动'.$coupon_activity_name.'添加记录失败！';
                $this->subtractionLog($id,$Log_content);

                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '添加满减记录失败!'));
                exit;
            }
        }
        $db->commit();
        return;
    }
    // 订单列表
    public function subtraction_order($db,$store_id,$sNo){

        $subtraction_list = array();

        $sql0 = "select subtraction_id,coupon_activity_name,spz_price from lkt_order where sNo = '$sNo'";
        $r0 = $db->select($sql0);
        if($r0){
            $subtraction_id = $r0[0]->subtraction_id;
            $coupon_activity_name = $r0[0]->coupon_activity_name;
            $spz_price = $r0[0]->spz_price;
            if($coupon_activity_name != ''){
                $sql1 = "select * from lkt_subtraction where store_id = '$store_id' and id = '$subtraction_id'";
                $r1 = $db->select($sql1);
                if($r1){
                    $subtraction_type = $r1[0]->subtraction_type;
                    if($subtraction_type == 3){
                        $subtraction = unserialize($r1[0]->subtraction); // 满减参数
                        foreach ($subtraction as $ke => $va){
                            if($spz_price >= $ke){
                                $sql2 = "select product_title,imgurl,product_number from lkt_product_list where store_id = '$store_id' and status = 2 and mch_status = 2 and recycle = 0 and id = '$va'";
                                $r2 = $db->select($sql2);
                                if($r2){
                                    $subtraction_list['product_title'] = $r2[0]->product_title;
                                    $subtraction_list['product_number'] = $r2[0]->product_number;
                                    $subtraction_list['imgurl'] = ServerPath::getimgpath($r2[0]->imgurl,$store_id);
                                    $subtraction_list['num'] = 1;
                                    $sql3 = "select price from lkt_configure where pid = '$va'";
                                    $r3 = $db->select($sql3);
                                    if($r3){
                                        $price = array();
                                        foreach ($r3 as $k1 => $v1) {
                                            $price[$k1] = $v1->price;
                                        }
                                        $min = min($price);
                                        $subtraction_list['price'] = $min;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $subtraction_list;
    }
    // 修改赠品库存问题
    public function give_num($db,$store_id,$sNo){
        //开启事务
        $db->begin();
        $pid = array();
        $sql = "select z_price,mch_id,subtraction_id from lkt_order where sNo = '$sNo'";
        $r = $db->select($sql);
        $z_price = $r[0]->z_price;
        $mch_id = $r[0]->mch_id;
        $subtraction_id = $r[0]->subtraction_id;

        $sql0 = "select subtraction_type,subtraction from lkt_subtraction where store_id = '$store_id' and id = '$subtraction_id' ";
        $r0 = $db->select($sql0);

        if($r0){
            $subtraction_type = $r0[0]->subtraction_type;
            $subtraction = $r0[0]->subtraction;
            if($subtraction_type == 3){
                $subtraction = unserialize($subtraction);
                foreach ($subtraction as $ke => $va){
                    if($z_price >= $ke){
                        $pid[] = $va;
                    }
                }
                if($pid != array()){
                    $num = count($pid) - 1;
                    $pid1 = $pid[$num];
                    // 根据商品id,修改商品数量
                    $sql1 = "update lkt_configure set num = num + 1 where pid = '$pid1' order by id limit 1";
                    $r1 = $db->update($sql1);
                    if($r1 < 1){
                        $subtraction_Log_content = __METHOD__ . '->' . __LINE__ . '店主ID为'.$mch_id.'同意订单号为'.$sNo.'退货时，修改赠品商品属性库存问题！';
                        $this->subtractionLog($subtraction_id,$subtraction_Log_content);
                        $db->rollback();
                        return 2;
                    }
                    // 根据商品id,修改卖出去的销量
                    $sql2 = "update lkt_product_list set num = num + 1 where store_id = '$store_id' and id = '$pid1'";
                    $r2 = $db->update($sql2);
                    if($r2 < 1){
                        $subtraction_Log_content = __METHOD__ . '->' . __LINE__ . '店主ID为'.$mch_id.'同意订单号为'.$sNo.'退货时，修改赠品商品库存问题！';
                        $this->subtractionLog($subtraction_id,$subtraction_Log_content);
                        $db->rollback();
                        return 2;
                    }
                }
            }
        }
        $subtraction_Log_content = __METHOD__ . '->' . __LINE__ . '店主ID为'.$mch_id.'同意订单号为'.$sNo.'退货成功！';
        $this->subtractionLog($subtraction_id,$subtraction_Log_content);

        $db->commit();
        return 1;
    }
    // 满减日志
    public function subtractionLog($id,$content){
        $lktlog = new LaiKeLogUtils("app/subtraction.log");
        if($id != 0){
            $lktlog->customerLog($content);
        }
        return;
    }
    // 查询满减活动
    public function subtraction_list($store_id,$products){
        $db = DBAction::getInstance();

        $shop_id = array(); // 店铺ID数组
        $product_class = array(); // 商品分类ID数组
        $brand_id = array(); // 品牌ID数组
        $list = array(); // 可用满减活动
        $reduce_name_array = '';
        $subtraction_id = 0;
        $reduce_money = 0;
        $reduce_name = '';
        $zong = 0;
        $num = 0;
        $give_id = 0;

        foreach ($products as $k => $v) {
            $shop_id[] = $v['shop_id'];
            foreach ($v['list'] as $ke => $va){
                $zong += $va['price'] * $va['num'];
                $num = $va['num'];
                $product_class[] = explode('-',trim($va['product_class'],'-'));
                $brand_id[] = $va['brand_id'];
            }
        }
        /* 根据满减范围挑选可使用的满减活动 开始 */
        // 查询自动满减设置
        $sql0 = "select * from lkt_subtraction where store_id = '$store_id' and status = 2";
        $r0 = $db->select($sql0);
        if(!empty($r0)){ // 当前有满减活动

            foreach ($r0 as $k => $v){
                $subtraction_range = $v->subtraction_range; // 满减应用范围
                $subtraction_parameter = explode(',',$v->subtraction_parameter); // 满减范围参数
                $subtraction_status = true; // 满足满减
                if($subtraction_range == 1){ // 指定分类
                    foreach ($product_class as $ke => $va){
                        foreach ($va as $key => $val){
                            if(in_array($val,$subtraction_parameter)){ // 判断店铺名称，是否存在满减范围参数数组
                                $subtraction_status = true; // 满足满减
                            }else{
                                $subtraction_status = false; // 不满足满减
                            }
                        }
                        if(!$subtraction_status){
                            break;
                        }
                    }
                }else if($subtraction_range == 3){ // 品牌
                    foreach ($brand_id as $ke => $va){
                        if(!in_array($va,$subtraction_parameter)){ // 判断店铺名称，是否存在满减范围参数数组
                            $subtraction_status = false; // 不满足满减
                            break;
                        }
                    }
                }else if($subtraction_range == 4){ // 商家
                    foreach ($shop_id as $ke => $va){
                        if(!in_array($va,$subtraction_parameter)){ // 判断店铺名称，是否存在满减范围参数数组
                            $subtraction_status = false; // 不满足满减
                            break;
                        }
                    }
                }
                if($subtraction_status == true){
                    $list[] = (array)$v;
                }
            }
        }
        /* 根据满减范围挑选可使用的满减活动 结束 */
        /* 根据满减类型计算优惠的价格 开始 */
        if(count($list) > 0){
            $subtraction_list = array();
            foreach ($list as $k => $v){
                $subtraction_type = $v['subtraction_type']; // 满减类型 1.阶梯满减 2.循环满减 3.满赠 4.满件折扣
                $subtraction = unserialize($v['subtraction']); // 满减参数
                if($subtraction_type == 1){
                    foreach ($subtraction as $ke => $va){
                        if($zong >= $ke){
                            $v['discount'] = $va;
                            $subtraction_list[] = $v;
                        }
                    }
                }else if($subtraction_type == 2){
                    $keys = array_keys($subtraction);
                    $values = array_values($subtraction);
                    if($zong >= $keys[0]){
                        $number = intval($zong/$keys[0]);
                        $v['discount'] = $number * $values[0];
                        $subtraction_list[] = $v;
                    }
                }else if($subtraction_type == 3){
                    foreach ($subtraction as $ke => $va){
                        if($zong >= $ke){
                            $sql2 = "select id,product_title,num from lkt_product_list where store_id = '$store_id' and status = 2 and mch_status = 2 and recycle = 0 and id = '$va'";
                            $r2 = $db->select($sql2);
                            if($r2){
                                $num1 = $r2[0]->num;
                                $v['give_id'] = $r2[0]->id;
                                $v['product_title'] = $r2[0]->product_title;
                                $v['num'] = $r2[0]->num;
                                $sql1 = "select price from lkt_configure where pid = '$va'";
                                $r1 = $db->select($sql1);
                                if($r1){
                                    $price = array();
                                    foreach ($r1 as $k1 => $v1) {
                                        $price[$k1] = $v1->price;
                                    }
                                    $min = min($price);
                                    $v['discount'] = $min;
                                    foreach ($products as $k0 => $v0) {
                                        foreach ($v0['list'] as $ke0 => $va0){
                                            if($va0['pid'] ==  $va){
                                                $num1 = $r2[0]->num - $va0['num'];
                                            }
                                        }
                                    }

                                    if($num1 > 0){
                                        $subtraction_list[] = $v;
                                    }
                                }
                            }
                        }
                    }
                }else if($subtraction_type == 4){
                    $keys = array_keys($subtraction);
                    $values = array_values($subtraction);
                    if($num >= $keys[0]){
                        $v['discount'] = $zong - $zong * $values[0] / 10;
                        $subtraction_list[] = $v;
                    }
                }
            }

            if(count($subtraction_list) > 0){
                $last_names = array_column($subtraction_list,'discount');
                array_multisort($last_names,SORT_DESC,$subtraction_list);
                $subtraction_id = $subtraction_list[0]['id'];
                $reduce_name_array = $subtraction_list[0]['name'];
                if($subtraction_list[0]['subtraction_type'] == 3){
                    if($subtraction_list[0]['num'] > 0){
                        $give_id = $subtraction_list[0]['give_id'];
                        $reduce_name = '赠送商品(' . $subtraction_list[0]['product_title'] . ')';
                    }else{
                        $reduce_name = '赠送商品（已赠完）';
                    }
                }else{
                    $reduce_money += $subtraction_list[0]['discount'];
                }
            }
        }
        /* 根据满减类型计算优惠的价格 结束 */
        $reduce_name_array = trim($reduce_name_array,',');

        $arr = array('subtraction_id'=>$subtraction_id,'reduce_money'=>$reduce_money,'products'=>$products,'reduce_name_array'=>$reduce_name_array,'reduce_name'=>$reduce_name,'give_id'=>$give_id);

        return $arr;
    }
    // 查询满减活动
    public function subtraction_list1($store_id,$product_id,$user_id,$sNo,$brand_id,$product_class,$shop_id){
        $db = DBAction::getInstance();

        $list = array(); // 可用满减活动
        $arr = array();

        /* 根据满减范围挑选可使用的满减活动 开始 */
        // 查询自动满减设置
        $sql0 = "select * from lkt_subtraction where store_id = '$store_id' and status = 2";
        $r0 = $db->select($sql0);
        if(!empty($r0)){ // 当前有满减活动
            foreach ($r0 as $k => $v){
                $subtraction_range = $v->subtraction_range; // 满减应用范围
                $subtraction_parameter = explode(',',$v->subtraction_parameter); // 满减范围参数
                $subtraction_status = true; // 满足满减
                if($subtraction_range == 1){ // 指定分类
                    foreach ($product_class as $ke => $va){
                        foreach ($va as $key => $val){
                            if(in_array($val,$subtraction_parameter)){ // 判断店铺名称，是否存在满减范围参数数组
                                $subtraction_status = true; // 满足满减
                            }else{
                                $subtraction_status = false; // 不满足满减
                            }
                        }
                        if(!$subtraction_status){
                            break;
                        }
                    }
                }else if($subtraction_range == 3){ // 品牌
                    foreach ($brand_id as $ke => $va){
                        if(!in_array($va,$subtraction_parameter)){ // 判断店铺名称，是否存在满减范围参数数组
                            $subtraction_status = false; // 不满足满减
                            break;
                        }
                    }
                }else if($subtraction_range == 4){ // 商家
                    foreach ($shop_id as $ke => $va){
                        if(!in_array($va,$subtraction_parameter)){ // 判断店铺名称，是否存在满减范围参数数组
                            $subtraction_status = false; // 不满足满减
                            break;
                        }
                    }
                }
                if($subtraction_status == true){
                    $list[] = (array)$v;
                }
            }
        }
        /* 根据满减范围挑选可使用的满减活动 结束 */

        $zong = 0;
        /* 根据满减类型计算优惠的价格 开始 */
        if(count($list) > 0){
            foreach ($product_id as $k0 => $v0) {
                $zong += $k0['p_price'] * $v0['num'];
                $num = $v0['num'];
                $subtraction_list = array();
                foreach ($list as $k => $v){
                    $subtraction_type = $v['subtraction_type']; // 满减类型 1.阶梯满减 2.循环满减 3.满赠 4.满件折扣
                    $subtraction = unserialize($v['subtraction']); // 满减参数
                    if($subtraction_type == 1){
                        foreach ($subtraction as $ke => $va){
                            if($zong >= $ke){
                                $v['discount'] = $va;
                                $subtraction_list[] = $v;
                            }
                        }
                    }else if($subtraction_type == 2){
                        $keys = array_keys($subtraction);
                        $values = array_values($subtraction);
                        if($zong >= $keys[0]){
                            $number = intval($zong/$keys[0]);
                            $v['discount'] = $number * $values[0];
                            $subtraction_list[] = $v;
                        }
                    }else if($subtraction_type == 3){
                        foreach ($subtraction as $ke => $va){
                            if($zong >= $ke){
                                $sql1 = "select price from lkt_configure where pid = '$va'";
                                $r1 = $db->select($sql1);
                                if($r1){
                                    $price = array();
                                    foreach ($r1 as $k1 => $v1) {
                                        $price[$k1] = $v1->price;
                                    }
                                    $min = min($price);
                                    $v['discount'] = $min;
                                    $subtraction_list[] = $v;
                                }
                            }
                        }
                    }else if($subtraction_type == 4){
                        $keys = array_keys($subtraction);
                        $values = array_values($subtraction);
                        if($num >= $keys[0]){
                            $v['discount'] = $zong - $zong * $values[0] / 10;
                            $subtraction_list[] = $v;
                        }
                    }
                }
                if(count($subtraction_list) > 0){
                    $last_names = array_column($subtraction_list,'discount');
                    array_multisort($last_names,SORT_DESC,$subtraction_list);
                    $subtraction_id = $subtraction_list[0]['id'];
                    $arr['subtraction_id'] = $subtraction_list[0]['id'];
                    $arr['name'] = $subtraction_list[0]['name'];
                    $arr['reduce_money'] = $subtraction_list[0]['discount'];

                    $content = '会员'.$user_id.'的订单号为'.$sNo.'参与满减活动'.$arr['name'];
                    $sql1 = "insert into lkt_subtraction_record(h_id,sNo,user_id,content,add_date) value ('$subtraction_id','$sNo','$user_id','$content',CURRENT_TIMESTAMP)";
                    $r1 = $db->insert($sql1);
                    if($r1){

                    }else{
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '添加满减记录失败!'));
                        exit;
                    }
                }else{
                    $arr['subtraction_id'] = 0;
                    $arr['name'] = '';
                    $arr['reduce_money'] = 0;
                }
            }
        }else{
            $arr['subtraction_id'] = 0;
            $arr['name'] = '';
            $arr['reduce_money'] = 0;
        }
        /* 根据满减类型计算优惠的价格 结束 */

        return $arr;
    }
}
?>