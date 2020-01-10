<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/wxpayv3/index.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');
require_once(MO_LIB_DIR . '/Plugin/mch.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/alipay/return.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');


class testAction extends LaiKeAction
{
    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-28T18:50:54+0800
     * @return  批量处理入口
     */

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $this->db = $db;
        $request = $this->getContext()->getRequest();
        $tres = $db->select("select store_id from lkt_config");
        // 处理优惠券问题
        $coupon = new coupon();
        $coupon_arr = $coupon->timing();

        // 提取码修改
        $coupon = new mch();
        $coupon -> up_extraction_code();
        LaiKeLogUtils::lktLog(__METHOD__.":".__LINE__."定时任务开启");
        foreach ($tres as $tkey => $tvalue) {

            $this->store_id = $tvalue->store_id;

            //竞拍处理
            $this->jp();

            //签到处理
            $this->sign();

            //拼团处理
            $this->pt();

            // 删除过期订单
            $this->order_failure();

            //自动收货
            $this->ok_Order();
            // 修改买家能否提醒发货按钮
            $this->remind_deliver();

            //自动满减活动
            $this -> subtraction();

            // 检查商品状态
            $this -> product_status();

            // 砍价状态修改
            $this -> KJ_order_status();

            // 消息定时清除
            $this -> message_day();

            //会员等级过期降级处理
            $this -> grade();

            //淘宝助手任务抓取
            $this -> taobao();

            //积分过期
            $this -> score_end();

            //秒杀处理
            $this->ms();

        }
        LaiKeLogUtils::lktLog(__METHOD__.":".__LINE__."定时任务结束");
        exit;
    }


    public function order_ship()
    {
        $db = $this->db;
        //查询运单配置
        $sql = "SELECT store_id,order_ship FROM lkt_order_config";
        $cfg_res = $db->select($sql);

        if ($cfg_res) {
            foreach ($cfg_res as $k => $v) {
                //设置时限：
                $set_hour = $v->order_ship;
                if($set_hour != 0){
                    //运行条件（多久之前）
                    $time = time() - ($set_hour * 60 * 60);
                    $riqi = date("Y-m-d H:i:s", $time);
                    $nowtime = date("Y-m-d H:i:s", time());
                    $store_id = $v->store_id;
                    $sql = "SELECT o.*,d.*
                FROM lkt_order as o 
                LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo 
                LEFT JOIN lkt_order as oo on o.sNo = oo.p_sNo 
                where o.status = 8 and o.pay_time > '2019-04-28 10:19:21' AND o.pay_time < '$riqi' and o.store_id = $store_id and o.p_sNo = '' and oo.status = 1 and oo.p_sNo != ''";
                    $ship_res = $db->select($sql);
//                echo $sql;
//                var_dump($ship_res);
                    if($ship_res){
                        foreach ($ship_res as $k2 => $v2) {

//                        $order_id = $v2->sNo;//押金表id
                            $money = $v2->z_price;//押金金额
                            $pay_type = $v2->pay;//支付类型
                            $user_id = $v2->user_id;//退款用户id
                            $order_no = $v2->sNo;//押金订单号
                            $p_order_no = $v2->p_sNo;//押金父级订单号
//                        echo $pay_type;
                            if($pay_type == 'app_wechat'){//退款--钱包支付

                                //查出原操作金额
                                $sql_3 = "select money from lkt_user where store_id = '$store_id' and user_id = '%user_id'";
                                $res_3 = $db->select($sql_3);
                                $oldmoney = $res_3[0]->money;//原金额

                                $sql_4 = "update lkt_order set status = 12 where store_id = '$store_id' and sNo = '$order_no' and user_id = '$user_id'  and pay =  'app_wechat'";
                                $res_4 = $db->update($sql_4);//退款状态   1

                                $sql_44 = "update lkt_order_details set r_status = 12,re_type = 2,re_money = '$money',re_time = '$nowtime' where store_id = '$store_id' and r_sNo = '$order_no' and user_id = '$user_id' and pay =  'app_wechat'";
                                $res_44 = $db->update($sql_44);//退款状态   1


                                $sql_5 = "update lkt_user set money = money + '$money' where store_id = '$store_id' and user_id = '$user_id'";
                                $res_5 = $db->update($sql_5);

//                            $sql_6 = "insert into lkt_record(store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','$promise_user','$promise','$oldmoney','$now','退款竞拍押金',27)";
                                $sql_6 = "insert into lkt_record(store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','$user_id','money','$oldmoney','','发货超时退款',28)";
                                $res_6 = $db->insert($sql_6);

                                if($res_4 < 0 || $res_5 < 0 || $res_6 < 0 || $res_44 < 0){
                                    $code = false;
                                    break;
                                }

                            }else if($pay_type == 'wallet_pay' || $pay_type == 'mini_wechat'){//退款--微信支付

                                //退款代码
                                $pay = 'mini_wechat';
                                $pay_config = Tools::get_pay_config($db,$pay);

                                if($pay_config){
                                    $appid = $pay_config->appid;
                                }else{
                                    $appid = '';
                                }

                                require_once(MO_LIB_DIR .'/wxpayv3/'.$appid.'_WxPay.Config.php');
//
//                            echo $p_order_no;
//                            echo '--------';
//                            echo $order_no;
//                            echo '--------';
                                $wxtk_res = wxpay::wxrefundapi($order_no,$order_no.mt_rand(0,9),$money,$money);
//                            echo var_dump($wxtk_res);

                                if ($wxtk_res['result_code'] != 'SUCCESS') {//退款失败
                                    $db->rollback();
                                    echo 8;
                                    return false;
                                }

//                            $sql_1 = "update lkt_auction_promise set is_back = 1 where store_id = '$store_id' and id = '$user_id' and user_id = '$promise_user' and type = 1";
                                $sql_4 = "update lkt_order set status = 12 where store_id = '$store_id' and sNo = '$order_no' and user_id = '$user_id'  and pay =  'wallet_pay'";
                                $res_4 = $db->update($sql_4);//退款状态   1

                                $sql_sel_son_order = "SELECT * FROM `lkt_order` WHERE p_sNo = '$order_no'";
                                $son_order_res = $db->select($sql_sel_son_order);
                                $isok = 1;
                                if($son_order_res){
                                    foreach ($son_order_res as $kz => $vz){
                                        $return_order = $vz->sNo;
                                        $sql_44 = "update lkt_order_details set r_status = 12,re_type = 2,re_money = '$money',re_time = '$nowtime' where store_id = '$store_id' and r_sNo = '$return_order'";
                                        $res_44 = $db->update($sql_44);//退款状态
                                        if(!$res_44){
                                            $isok = 0;
                                        }
                                    }
                                }


//                            echo '-------';
//                            echo $res_44;
//                            echo '-------';
//                            echo $sql_44;
//                            echo $res_4;
//                            echo '-------';
                                if($res_4 < 0 || $isok < 0){
                                    $db->rollback();
                                    echo 1;
//                                echo $res_4;
//                                echo $isok;
                                    return false;
                                }

                                //退款成功则发送消息推送

                                $template_id = 'refund_res';//退款模板
                                //退款商家名称
                                $sql_t = "select company from lkt_config where store_id = '$store_id'";
                                $res_t = $db->select($sql_t);
                                $title = $res_t[0]->company;

                                $keyword1 = array('value' => $order_no, "color" => "#173177");
                                $keyword2 = array('value' => $title, "color" => "#173177");
                                $keyword3 = array('value' => $nowtime, "color" => "#173177");
                                $keyword4 = array('value' => '退款成功', "color" => "#173177");
                                $keyword5 = array('value' => $money . '元', "color" => "#173177");
                                $keyword6 = array('value' => '退还购物金额', "color" => "#173177");
                                $keyword7 = array('value' => '微信钱包', "color" => "#173177");

                                //组成微信消息模板规定格式
                                $o_data = array('keyword1' => $keyword1, 'keyword2' => $keyword2, 'keyword3' => $keyword3, 'keyword4' => $keyword4, 'keyword5' => $keyword5, 'keyword6' => $keyword6, 'keyword7' => $keyword7);
                                //消息发送
                                $Tools = new Tools($db, $store_id, '');

                                $data = array();
                                $data['page'] = 'pages/index/index';
                                $data['template_id'] = $template_id;
                                $data['openid'] = Tools::get_openid($db, $store_id, $user_id);
                                $data['o_data'] = $o_data;
                                $tres = $Tools->send_notice($data, 'wx');
                            }
                        }
                    }
                }

            }


        }
    }

    /**
     * 砍价定时任务
     */
    public function KJ_order_status(){
        $db = $this->db;
        $store_id = $this->store_id;

        $sql = "select * from lkt_bargain_config where 1";
        $r = $db->select($sql);
        $show_time = 0;
        $buy_time = 0;
        if ($r) {
            $show_time = $r[0]->show_time; // 活动结束显示的时间
            $buy_time = $r[0]->buy_time; // 砍价成功，购买的时间
        }

        $now = date('Y-m-d H:i:s',time());
        $now2 = date("Y-m-d H:i:s",strtotime("-$show_time hour"));

        //修改活动状态为进行中
        $db->update("update lkt_bargain_goods set status=1 where begin_time<='$now' and is_delete=0");
        //修改活动状态为结束并不显示
        $db->update("update lkt_bargain_goods set status=2 where end_time<='$now' and is_delete=0");
        $db->update("update lkt_bargain_goods set is_show=0 where end_time<='$now2' and is_delete=0");
        //修改砍价成功的订单状态
        $sql = "select id,goods_id,user_id from lkt_bargain_order where status=0 and original_price=0";
        $order = $db->select($sql);
        if (!empty($order)) {

            foreach ($order as $k => $v) {

                $user_id_ = $v->user_id;

                $sql = "SELECT product_title from lkt_product_list where id = " . $v->goods_id;
                $pro_res = $db->select($sql);

                $msg_title = "砍价成功！";
                $msg_content = "恭喜您！您参与的【".$pro_res[0]->product_title."】已经砍价成功，快去付款带回家吧！";

                //给用户发送消息
                $pusher = new LaikePushTools();
                $pusher->pushMessage($user_id_, $db, $msg_title, $msg_content,$store_id,'');

                $db->update("update lkt_bargain_order set status=1 where id=".$v->id);
            }
        }
        //修改付款成功的订单状态
        $sql = "select id,goods_id,user_id,order_no from lkt_bargain_order where status=1";
        $order = $db->select($sql);
        if (!empty($order)) {
            foreach ($order as $k => $v) {

                $sql = "SELECT id,status from lkt_order where status != '0' and status != '6' and status != '7' and status != '8' and  p_sNo = '$v->order_no'";
                $ishas = $db->select($sql);
                if ($ishas) {
                    $db->update("update lkt_bargain_order set status=2 where id=".$v->id);
                }
            }
        }

        $sql = "select id from lkt_bargain_goods where status=2";
        $over = $db->select($sql);
        if (!empty($over)) {
            foreach ($over as $k => $v) {
                $db->update("update lkt_bargain_order set status=-1 where bargain_id='".$v->id."' and status=0 and original_price>0");
            }
        }

        //隐藏库存为0活动
        // $sql = "select a.id from lkt_bargain_goods a left join lkt_configure b on a.attr_id=b.id WHERE a.is_show=1 and a.status=1 and b.num=0";
        // $null = $db->select($sql);
        // foreach ($null as $k => $v) {
        //     $db->update("update lkt_bargain_goods set is_show=0 where id='".$v->id."' and is_show=1");
        // }

        //查询所有砍价的物品
        $sql = 'SELECT * from lkt_bargain_goods';
        $bg_res = $db->select($sql);
        if($bg_res){
            foreach ($bg_res as $k => $v){

                if ($show_time > 0 && $v->status==2) {
                    $stime = $show_time * 3600;
                    $show = strtotime($v->end_time)+$stime;

                    if ($show > time()) {
                        //修改活动为显示
                        $db->update("update lkt_bargain_goods set is_show=1 where id='".$v->id."'");
                    }else{
                        //修改活动为隐藏
                        $db->update("update lkt_bargain_goods set is_show=0 where id='".$v->id."'");
                    }
                }
            }
        }

        if ($buy_time > 0) {//当结算时间有限制时
            $stime = $buy_time * 3600;//转换设置购买时间为秒
            $jztime = time()-$stime;
            $sql = "select id,order_no,attr_id from lkt_bargain_order where status=1 and achievetime < '$jztime'";
            $orders = $db->select($sql);
            foreach ($orders as $k => $v) {
                $sql = "UPDATE lkt_bargain_order SET status = -1 where id=".intval($v->id);
                $db->update($sql);

                $sql = "update lkt_order SET status = 6 where p_sNo='".$v->order_no."' and status=0";
                $db->update($sql);

                // 库存返还
                $sql = "update lkt_configure set num=num+1 where id = '".$v->attr_id."' ";
                $db->update($sql);

                $sql = "select sNo from lkt_order where p_sNo='".$v->order_no."'";
                $ooo = $db->select($sql);
                if (count($ooo) > 0) {
                    foreach ($ooo as $key => $value) {
                        $db->update("update lkt_order_details set r_status = 6 where r_sNo='".$value->sNo."'");
                    }
                }
            }
        }
    }

    public function product_status(){
        $db = $this->db;
        // 查询所有商品信息
        $sql0 = "select id,store_id,num,min_inventory,status from lkt_product_list where recycle = 0 ";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $pid = $v->id; // 商品id
                $store_id = $v->store_id; // 商城id
                $num = $v->num; // 商品库存
                $min_inventory = $v->min_inventory; // 预警数量
                $status = $v->status; // 状态
                if ($num == 0 && $status == 0) { // 当库存为0 并且商品还为上架状态
                    // 根据商品id，修改商品状态（下架）
                    $sql1 = "update lkt_product_list set status = 3 where id = '$pid'";
                    $db->update($sql1);
                }
                // 根据商品id,查询属性信息
                $sql3 = "select id,num from lkt_configure where pid = '$pid'";
                $r_s = $db->select($sql3);
                if ($r_s) {
                    foreach ($r_s as $k1 => $v1) {
                        $configure_id = $v1->id; // 属性id
                        if ($v1->num <= $min_inventory) { // 当该属性剩余库存低于等于预警数量
                            // 根据商品id、属性id、预警类型，查询库存记录表
                            $sql4 = "select id from lkt_stock where type = 2 and product_id = '$pid' and attribute_id = '$configure_id'";
                            $r4 = $db->select($sql4);
                            if(empty($r4)){ // 不存在，表示还没有添加预警信息
                                $sql5 = "insert into lkt_stock (store_id,product_id,attribute_id,type,add_date) values ('$store_id','$pid','$configure_id',2,CURRENT_TIMESTAMP)";
                                $db->insert($sql5);
                            }
                        }
                    }
                }
            }
        }
    }

    // 确认收货
    public function ok_Order(){
        $db = $this->db;
        $db->begin();
        $code = true;
        $time = date('Y-m-d H:i:s');
        $store_id = $this->store_id;

        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $auto_the_goods = $r[0]->auto_the_goods;
        }else{
            $auto_the_goods = 7;
        }

        $sql01 = "select id,r_sNo,deliver_time,user_id,store_id 
        from lkt_order_details 
        where store_id = '$store_id' and r_status = '2' and date_add(deliver_time, interval $auto_the_goods day) < now()";
        
        $rew = $db->select($sql01);


        if($rew){

            foreach ($rew as $key => $value) {
                $user_id = $value->user_id;
                $sNo = $value->r_sNo;

                $sql_1 = "update lkt_order_details set r_status = 3, arrive_time = '$time' where store_id = '$store_id' and r_sNo = '$sNo' and r_status = '2'";

                $r_1 = $db->update($sql_1);
                if($r_1 < 0){
                    $code = false;
                    break;
                }


                $sql_2 = "update lkt_order set status = 3 where store_id = '$store_id' and sNo = '$sNo'";
                $r_2 = $db->update($sql_2);
                if($r_2 < 0){
                    $code = false;
                    break;
                }


                $this->db = $db;
                $this->user_id = $user_id;
                $this->store_id = $store_id;
                $aaa = $this->check_invitation($user_id);

            }
        }

        if($code){                     //如果批量执行没出错则提交，否则就回滚
            $db->commit();
        }else{
            $db->rollback();
        }
    }
    // 修改买家能否提醒发货按钮
    public function remind_deliver(){
        $db = $this->db;
        $store_id = $this->store_id;
        $time = date('Y-m-d H:i:s');

        $sql0 = "select id,delivery_status,readd,remind from lkt_order where store_id = '$store_id'  and delivery_status = 1 and readd = 1";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $id = $v->id; // 订单ID
                $delivery_status = $v->delivery_status; // 是否提醒发货
                $readd = $v->readd; // 是否已读
                $remind = $v->remind; // 提醒发货时间间隔
                if($remind != '' || $remind != null){
                    if($remind <= $time){ // 当买家提醒过发货 并且 卖家已查看 并且 当前时间大于等于 提醒发货时间间隔
                        $sql02 = "update lkt_order set delivery_status=0,readd = 0,remind = null where store_id = '$store_id' and id = '$id'";
                        $up = $db->update($sql02);
                    }
                }
            }
        }
    }
    /**
     * [check_invitation description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-29T15:58:30+0800
     * @return  校验邀请有奖完成资格
     */
    public function check_invitation($user_id = 'user50')
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $time =  date('Y-m-d h:i:s',time());
        $request = $this->getContext()->getRequest();
        $store_type = trim($request->getParameter('store_type')) ? $request->getParameter('store_type'):0;
        $this->store_type = $store_type;

        //查询是否开启邀请有奖功能and `store_type` = '$store_type'
        $sql = "select order_time,payment_amount from lkt_invitation where store_id = '$store_id'  and status = '1' ";
        $invitation = $db->select($sql);
        if($invitation){
            $payment_amount = $invitation[0]->payment_amount;
            $shixiao_time = $invitation[0]->order_time;
            $gq_time = date("Y-m-d H:i:s", strtotime("-$shixiao_time days")); // 失效时间

            //查询是否有优惠券-推荐人
            $sql_c = "select id from lkt_coupon_activity where store_id = '$store_id' and activity_type = '8'";
            $res_c = $db->select($sql_c);

            if($res_c){
                $hs = '';
                foreach ($res_c as $keyc => $valuec) {
                    $hs .= $valuec->id.',';
                }

                $hid = trim($hs, ',');

                //查询是否领取过优惠券
                $sql_lc = "select id from lkt_coupon where store_id = '$store_id' and hid in ($hid)";
                $res_lc = $db->select($sql_lc);

                if(!$res_lc){
                    $sql_u = "select o.spz_price,u.Referee,u.Register_data,u.user_id,u.user_name,o.sNo,o.z_price,o.status from lkt_user as u left join lkt_order as o on u.user_id=o.user_id where u.Register_data >= '$gq_time' and o.add_time >= '$gq_time' and u.Referee !='' and u.store_id = '$store_id' and u.user_id = '$user_id' and o.status =3 ORDER BY u.Register_data desc";

                    $res_u = $db->select($sql_u);

                    // var_dump($res_u,$sql_u);
                    if($res_u){
                        foreach ($res_u as $key => $value) {
                            //防止多个子订单不同状态-计算整个订单实付
                            $cprice = $this->calculate_order($db,$value->sNo,$value->z_price,$value->spz_price);
                            if($cprice >= $payment_amount){
                                // 推荐人发放
                                $Referee = $value->Referee;
                                break;
                            }
                        }
                    }
                }
            }

        }
    }

    /**
     * [calculate_order description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-29T18:17:40+0800
     * @param   计算整个订单实付
     */
    public function calculate_order($db,$sNo,$z_price,$spz_price)
    {
        //判断单个商品退款是否有使用优惠
        $sql_id = "select m.num,m.p_price from lkt_order_details AS m where m.r_sNo = '$sNo' and m.r_status = '3' ";
        $variable = $db->select($sql_id);
        $price = 0;
        foreach ($variable as $key => $value) {
            $num = $value->num;
            $p_price = $value->p_price*$num;
            //计算实际支付金额
            $price += number_format($z_price / $spz_price * $p_price, 2,".","");
        }
        return $price;
    }


    public function message_day()
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $message_day = $r[0]->message_day;  // 消息保留天数
            if ($message_day > 0) {
                
                $nowtime=date("Y-m-d H:i:s");//当前时间
                $todata=date('Y-m-d H:i:s',strtotime($nowtime . '- '.intval($message_day).'day'));//到期时间

                $sql = "delete from lkt_system_message where store_id = '$store_id' and time<'$todata'";
                $db->delete($sql);
            }
        }
    }


    public function wxss($user_id,$cdata)
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $time =  date('Y-m-d h:i:s',time());

        $sql_openid = "select wx_id,user_name from lkt_user where store_id = '$this->store_id' and user_id = '$user_id'";
        $res_openid = $this->db->select($sql_openid);
        $openid = $res_openid[0]->wx_id;
        $user_name = $res_openid[0]->user_name;

        //实例化
        $Tools = new Tools($db,$store_id,$store_type);
        $data = [];

        $data['page'] = 'pages/coupon/index?currentTab=1';
        $data['template_id'] = 'receive';
        $data['openid'] = $openid;

        $o_data = [];
        //设置消息数组
        $o_data['keyword1'] = array('value' => $user_name, "color" => "#173177");
        $o_data['keyword2'] = array('value' => '系统', "color" => "#173177");
        $o_data['keyword3'] = array('value' => $cdata->name, "color" => "#173177");
        $o_data['keyword4'] = array('value' => '我的优惠券', "color" => "#173177");
        $o_data['keyword5'] = array('value' => $cdata->add_time, "color" => "#173177");
        $o_data['keyword6'] = array('value' => $cdata->end_time, "color" => "#173177");
        $o_data['keyword7'] = array('value' => $cdata->money, "color" => "#173177");
        $o_data['keyword8'] = array('value' => $cdata->limit, "color" => "#173177");

        $data['o_data'] = $o_data;
        $tres = $Tools->send_notice($data,'wx');

        return $tres? ($tres->errcode == 'ok' ? true:false):false;

    }

    /**
     * [jp description]
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  凌烨棣
     * @version 2.2
     * @date    2019-01-28T19:39:50+0800
     * @return  竞拍定时处理执行文件
     */
    public function jp(){

        $db = $this->db;
        $store_id = $this->store_id;
        $now = date("Y-m-d H:i:s");//当前时间戳
        //实例化日志记录
        $log = new LaiKeLogUtils('JP/JP_Time.log');

        //开始和结束竞拍代码
        $sql = "select id,title,starttime,endtime,status,invalid_time,pepole,low_pepole from lkt_auction_product where store_id = '$store_id' and status in (0,1)";
        $res = $db->select($sql);

        if($res){
            foreach ($res as $k => $v){
                $id = $v->id;
                $status = $v->status;
                $starttime = $v->starttime;
                $endtime = $v->endtime;
                $invalid_time = $v->invalid_time;
                $pepole = $v->pepole;
                $low_pepole = $v->low_pepole;
                $title = $v->title;

                if($status == 0 && ($now >= $starttime)){//开始竞拍活动

                    $sql_s = "update lkt_auction_product set status = 1 where store_id = '$store_id' and id = '$id'";
                    $res_s = $db->update($sql_s);
                }else if($status == 1 && ($now >= $endtime)){//结束竞拍活动 status = 2 (已完成) status = 3 (流拍)

                     //活动是否有出价
                    $sql_2 = "select id from lkt_auction_record where store_id = '$store_id' and auction_id = '$id'";
                    $res_2 = $db->selectrow($sql_2);
                    if(($pepole >= $low_pepole) && ($res_2 > 0)){ //竞拍结束，人数达标

                        //正常竞拍，取最高价为得主
                        $sql_h = "SELECT user_id ,price FROM lkt_auction_record WHERE store_id = '$store_id' and auction_id = '$id' ORDER BY price DESC,add_time DESC,id DESC  LIMIT 1 ";
                        $res_h = $db->select($sql_h);//最高价及用户id
                        if($res_h){
                            $user_id = $res_h[0]->user_id;
                            $price = $res_h[0]->price;
                            $db->begin();
                            $sql_e = "update lkt_auction_product set status = 2,current_price = '$price',user_id = '$user_id' where store_id = '$store_id' and id = '$id' and pepole >= low_pepole";
                            $res_e = $db->update($sql_e);//更新得主
                            if($res_e < 0){
                                $log -> customerLog(__LINE__.':更新得主失败，sql为：'.$sql_e."\r\n");
                            }

                            //竞拍押金置为，暂不退款，只有付款后，才置为可退款，并进行退款
                            $sql_f = "update lkt_auction_promise set allow_back = 0 where store_id = '$store_id' and a_id = '$id' and user_id = '$user_id'";
                            $res_f = $db->update($sql_f);
                            if($res_f < 0){
                                $log -> customerLog(__LINE__.':更新竞拍押金退款状态失败，sql为：'.$sql_f."\r\n");
                            }
                            
                            /**竞拍得主领先通知*/
                            $msg_title = '尊敬的会员,恭喜你竞拍'.$title.'成功！';
                            $msg_content = '请在规定时间内付款';
                            $pusher = new LaikePushTools();
                            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,'');

                        }else{//不存在最高价，则流拍
                            $sql_l = "update lkt_auction_product set status = 3 where store_id = '$store_id' and id = '$id' and pepole < low_pepole";
                            $res_l = $db->update($sql_l);
                        }

                    }else{ //流拍代码 -- 人数不足

                        $sql_l = "update lkt_auction_product set status = 3 where store_id = '$store_id' and id = '$id' and pepole < low_pepole";
                        $res_l = $db->update($sql_l);
                    }

                }else if($status == 2 && $now >= $invalid_time){//对活动已失效，得主未付款，置为流拍
                    $sql = "update lkt_auction_product set status = 3 where store_id = '$store_id' and id = '$id' and user_id != '' and is_buy != 1";
                    $res = $db->update($sql);
                }
            }
        }

        //关闭失效竞拍订单代码
        $sql = "select id,trade_no from lkt_auction_product where  store_id = '$store_id' and status = 2 and trade_no is not null and is_buy = 0 and invalid_time < '$now'";
        $res = $db->select($sql);

        if($res){
            foreach($res as $k => $v){
                $sNo = $v->trade_no;
                $sql_1 = "update lkt_order_details set r_status = 7 where store_id = '$store_id' and r_sNo = '$sNo'";
                $res_1 = $db->update($sql_1);
                $sql_2 = "update lkt_order set status = 7 where store_id = '$store_id' and sNo = '$sNo'";
                $res_2 = $db->update($sql_2);

                if($res_1 < 0 || $res_2 < 0){
                    echo json_encode(array('status'=>0,'info'=>'未删除失效活动订单！'));
                    return false;
                }
            }
        }

        //退款代码 -- 符合退款标准
        $sql_2 = "select a.id,a.promise,a.type,a.user_id,a.trade_no from lkt_auction_promise as a left join lkt_auction_product as b on a.a_id = b.id  where a.store_id = '$store_id' and a.store_id = b.store_id and a.is_pay = 1 and (a.is_back is NULL OR  a.is_back = 1) and a.allow_back = 1 and (b.status = 2 or b.status = 3)";
        $res_2 = $db->select($sql_2);
        if(!empty($res_2)){

            foreach ($res_2 as $k2 => $v2) {
                 sleep(0.01);
                //对每个订单单独进行事务开启
                $db->begin();//开启事务
                $code = true;//事务回滚标识
                $promise_id = $v2->id;//押金表id
                $promise = $v2->promise;//押金金额
                $pay_type = $v2->type;//支付类型
                $promise_user = $v2->user_id;//退款用户id
                $trade_no = $v2->trade_no;//押金订单号
                $log -> customerLog('查询出可退款定单号为：'.$trade_no);

                if($pay_type == 'wallet_pay'){//退款--钱包支付
                    //查出原操作金额
                    $sql_3 = "select money from lkt_user where store_id = '$store_id' and user_id = '$promise_user'";
                    $res_3 = $db->select($sql_3);

                    $oldmoney = $res_3[0]->money;//原金额

                    $sql_4 = "update lkt_auction_promise set is_back = 0,allow_back = 0 where store_id = '$store_id' and id = '$promise_id' and user_id = '$promise_user' and type = '$pay_type'";
                    $res_4 = $db->update($sql_4);//退款状态   1
                    if($res_4 < 0){
                        $log -> customerLog(__LINE__.':更新用户竞拍押金失败，sql为：'.$sql_4."\r\n");
                        $code = false;
                        $db->rollback();
                        continue;
                    }

                    $sql_5 = "update lkt_user set money = money + '$promise' where store_id = '$store_id' and user_id = '$promise_user'";
                    $res_5 = $db->update($sql_5);
                    if($res_5 < 0){
                        $log -> customerLog(__LINE__.':更新用户余额失败失败，sql为：'.$sql_5."\r\n");
                        $code = false;
                        $db->rollback();
                        continue;
                    }

                    $sql_6 = "insert into lkt_record(store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','$promise_user','$promise','$oldmoney','$now','退款竞拍押金',27)";
                    $res_6 = $db->insert($sql_6);

                }else{//退款--微信或支付宝支付

                    //退款代码
                    $pay = $pay_type;
                    $pay_config = Tools::get_pay_config($db,$pay);

                    if($pay_config){
                        $appid = $pay_config->appid;
                    }else{
                        $code = false;
                        $log -> customerLog(__LINE__.':获取支付配置失败'."\r\n");
                        $db->rollback();
                        continue;

                    }


                    //$log -> customerLog('竞拍退款appid为'.$appid);
                    if($pay == 'aliPay'){
                        $zfb_res = Alipay::refund($trade_no,$promise,$appid,$store_id,$pay);
                        if ($zfb_res != 'success') {
                            $log -> customerLog(__LINE__.':支付宝退款失败，订单号为：'.$trade_no);
                            $log -> customerLog(__LINE__.':支付宝退款失败原因:'.json_encode($zfb_res));
                            $code = false;
                            $db->rollback();
                            continue;
                        }else{
                            $sql = "update lkt_auction_promise set is_back = 0,allow_back = 0 where store_id = '$store_id' and trade_no = '$trade_no'";
                            $res = $db->update($sql);
                            if($res < 0){
                                $log -> customerLog(__LINE__.':处理退款sql失败，订单号为：'.$trade_no);
                                $code = false;
                                $db->rollback();
                                continue;

                            }
                        }

                    }else{
                       
                        $wxtk_res = wxpay::wxrefundapi($trade_no,$trade_no.mt_rand(0,9),$promise,$promise,$store_id,$pay);
                        
                        if($wxtk_res['return_code'] != 'SUCCESS') {//退款失败
                            $log -> customerLog(__LINE__.':微信退款失败原因'.json_encode($wxtk_res));
                            $log -> customerLog(__LINE__.':微信退款失败，订单号为：'.$trade_no);
                            $code = false;
                            $db->rollback();
                            continue;
                        }else{
                            $sql = "update lkt_auction_promise set is_back = 0,allow_back = 0 where store_id = '$store_id' and trade_no = '$trade_no'";
                            $res = $db->update($sql);
                            if($res  < 0){
                               $log -> customerLog(__LINE__.':处理退款sql失败，订单号为：'.$trade_no);
                               $code = false;
                               $db->rollback();
                               continue;

                            }
                        }
                    }

                    //http://xiaochengxu.laiketui.com/V2.7/index.php?module=app&action=test

                }

                //
              if($code){                     //如果批量执行没出错则提交，否则就回滚
                    $log -> customerLog('事务提交');

                    $db->commit();
              }else{
                      $log -> customerLog('事务回滚');
                    $db->rollback();
              }


            }
        }

        //退款
      
    }


    /**
     * [jp description]
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  熊孔钰
     * @version 2.2
     * @date    2019-09-04T19:39:50+0800
     * @return  积分等级过期处理执行文件
     */
    public function score_end(){

        $db = $this->db;
        $store_id = $this->store_id;

        $log = new LaiKeLogUtils('common/user.log');

        // 查询积分过期配置
        $sql = "select score from lkt_user_rule where store_id = '$store_id' ";
        $res = $db->select($sql);
        $days = $res?$res[0]->score:0;

        if ($days > 0) {

            $end_ = date("Y-m-d H:i:s",strtotime("-$days day"));//有效日期
            // 查询积分大于0并且未被冻结的用户
            $sql = "select user_id,score from lkt_user where store_id='$store_id' and score>0 and is_lock=0";
            $users = $db->select($sql);
            foreach ($users as $k => $v) {

                $user_id = $v->user_id;// 用户id
                $old_score = $v->score;// 原积分

                // 1.查询出上次计算过期积分是什么时候
                $sql = "select * from lkt_score_over where store_id='$store_id' and user_id='$user_id' order by add_time desc limit 0,1";
                $r1 = $db->select($sql);
                $c1 = '';
                $last_pay = !empty($r1)?$r1[0]->last_pay:0;// 已计算花费积分
                if (!empty($r1)) {
                    $c1 = " and sign_time>'".$r1[0]->count_time."' ";
                }

                // 2.查询出上次计算到这次计算过期的积分
                $sql = "select sum(sign_score) as sum from lkt_sign_record where store_id='$store_id' and user_id='$user_id' and sign_time<'$end_' $c1 and type in (0,2,4,6,8,9)";
                $r2 = $db->select($sql);
                $end_sum = $r2?intval($r2[0]->sum):0;

                // 3.查询累计花费积分
                $sql = "select sum(sign_score) as sum from lkt_sign_record where store_id='$store_id' and user_id='$user_id' and type in (1,3,5,7)";
                $r3 = $db->select($sql);
                $pay_sum = $r3?intval($r3[0]->sum):0;

                //4.待计算花费积分 = 累计花费积分-已计算花费积分
                $can_pay = intval($pay_sum)-intval($last_pay);

                // 5.如果过期积分大于零 进行后续操作
                if ($end_sum > 0) {

                    // 6.可过期积分 = 过期积分-待计算花费积分  最小为0
                    $can_end = intval($end_sum)-intval($can_pay);
                    $real_end = $can_end>0?$can_end:$end_sum; // 当可过期积分小于或等于0时  可过期积分为过期积分
                    if ($can_end>0){ // 当可过期积分大于0时 说明过期积分可以抵消待计算花费积分
                        $new_last_pay = intval($last_pay) + intval($can_pay); // 新的已计算花费积分 = 已计算花费积分+待计算花费积分
                    }else{// 反之说明说明过期积分无法抵消待计算花费积分 只能抵消过期积分相应的花费积分
                        $new_last_pay = intval($last_pay) + intval($end_sum); // 新的已计算花费积分 = 已计算花费积分+过期积分
                    }

                    $db->begin();

                    if ($real_end > 0){
                        $real_end = $real_end>$old_score?$old_score:$real_end;
                        // 7.用户积分减少
                        $r = $db->update("update lkt_user set score=score-$real_end where store_id='$store_id' and user_id='$user_id' and score>=$real_end");
                        if ($r <= 0) {
                            $log -> customerLog("\r\n会员【".$user_id."】积分过期处理失败:".$sql."！过期积分：".$real_end."\r\n");
                            $db->rollback();
                            continue;
                        }

                        // 8.插入积分记录
                        $event = "会员" . $user_id . "有" . $real_end . "积分已过期！";
                        $sql = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$real_end','$event',CURRENT_TIMESTAMP,10)";
                        $r = $db->insert($sql);
                        if ($r <= 0) {
                            $log -> customerLog("\r\n会员【".$user_id."】积分过期记录失败:".$sql."！过期积分：".$real_end."\r\n");
                            $db->rollback();
                            continue;
                        }
                    }
                    // 9.插入积分过期记录
                    $now_score = intval($old_score)-intval($real_end);
                    $sql = "insert into lkt_score_over (store_id,user_id,old_score,now_score,last_pay,count_time,add_time) values ('$store_id','$user_id','$old_score','$now_score','$new_last_pay','$end_',CURRENT_TIMESTAMP)";
                    $r = $db->insert($sql);
                    if ($r <= 0) {
                        $log -> customerLog("\r\n会员【".$user_id."】积分过期记录失败:".$sql."！过期积分：".$real_end."\r\n");
                        $db->rollback();
                        continue;
                    }
                    $db->commit();

                    // 10.发送消息给用户
                    $msg_title = "您有积分已经过期！";
                    $msg_content = "您有".$real_end."积分已经过期了！";
                    // 11.给用户发送消息
                    $pusher = new LaikePushTools();
                    $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,'');
                    // 12.插入记录
                    $log -> customerLog("\r\n会员【".$user_id."】积分过期处理成功！过期积分：".$end_sum."\r\n");
                }
            }
        }
        return;
    }


    /**
     * [jp description]
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  凌烨棣
     * @version 2.2
     * @date    2019-07-28T19:39:50+0800
     * @return  会员等级过期处理执行文件
     */
    public function grade(){
        $db = $this->db;
        $store_id = $this->store_id;
        $now = date("Y-m-d H:i:s");
        //实例化日志记录
        $log = new LaiKeLogUtils('USER/user.log');
        //查询出到期的会员
        $sql = "select user_id from lkt_user where store_id = $store_id and grade != 0 and grade_end < '$now'";
        $res = $db->select($sql);
        if($res){
            foreach($res as $k => $v){
                $db->begin();
                $user_id = $v->user_id;//到期的user_id
                $sql_1 = "update lkt_user set grade = 0,grade_end = NULL,is_box = 1 where store_id = $store_id and user_id = '$user_id'";
                $res_1 = $db->update($sql_1);
                if($res_1 < 0){
                    $log -> customerLog('取消用户会员等级失败,user_id为'.$user_id);
                    $db->rollback();
                    continue;
                }else{
                    $db->commit();
                }

            }
        }
    }

    /**
     * [sign description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  段洪波
     * @version 2.0
     * @date    2018-12-28T18:39:50+0800
     * @return  签到定时处理执行文件
     */
    public function sign(){
        $db = $this->db;
        $store_id = $this->store_id;
        $time = date("Y-m-d H:i:s");
        // 查询签到参数
        $sql = "select * from lkt_sign_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $endtime = $r[0]->endtime; // 结束时间
            if($time >= $endtime){
                $sql = "update lkt_sign_config set is_status = 0 where store_id = '$store_id'";
                $db->update($sql);
            }
        }
    }


    /**
     * [pt description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  lm
     * @version 2.0
     * @date    2018-12-28T18:38:43+0800
     * @return 秒杀定时处理执行文件
     */
    public function ms()
    {

        $db = $this->db;
        $store_id = $this->store_id;
        $db->begin();

        //自动开启 、 结束活动
        $time = date('Y-m-d 00:00:00', time());

        $code = true;
        //查询时间到，未开始的活动
        $sql = "SELECT * FROM lkt_seconds_activity WHERE starttime <= '$time' and status = 1 AND store_id = $store_id AND is_delete = 0";
        $res = $db->select($sql);
        if(!empty($res)){
            foreach ($res as $k => $v){
                $up_sql1 = "update lkt_seconds_activity set status = 2 where store_id = '$store_id' and id='$v->id'";
                $up_res1 = $db->update($up_sql1);
                if($up_res1 <= 0){
                    $code = false;
                    break;
                }
            }
        }
        //查询时间到，未结束的活动
        $sql = "SELECT * FROM lkt_seconds_activity WHERE endtime < '$time' and status = 2 AND store_id = $store_id AND is_delete = 0";
        $res = $db->select($sql);
        if(!empty($res)){
            foreach ($res as $k => $v){
                $up_sql2 = "update lkt_seconds_activity set status = 3 where store_id = '$store_id' and id='$v->id'";
                $up_res2 = $db->update($up_sql2);
                if($up_res2 <= 0){
                    $code = false;
                    break;
                }
            }
        }

        //库存补充

        //秒杀数量 存入redis
        $redis = new RedisClusters();
        $re     = $redis->connect();

        //查询 活动没有结束 ，补仓日期不是今天的商品
        $sel_pro_sql = "SELECT sp.* 
from lkt_seconds_pro as sp
LEFT JOIN lkt_seconds_activity as sa on sa.id = sp.activity_id
WHERE 1 and sp.store_id = $store_id and sp.is_delete = 0 and sa.starttime <= '$time' and sa.endtime >= '$time' and  sp.add_time !=  '$time' and sp.is_delete = 0";


        $pro_res = $db->select($sel_pro_sql);
        if(!empty($pro_res)){
            foreach ($pro_res as $k => $v){

                $redis_name = "seconds_".$v->activity_id."_".$v->time_id."_".$v->pro_id;
                $redis->remove($redis_name);
                $num = $v->max_num;
                for($i = 0;$i<$num;$i++){

                    $aa = $redis->lpush($redis_name,1);

                }
                $up_add_time_sql = "update lkt_seconds_pro set add_time = '$time',num=max_num where store_id = '$store_id' and id='$v->id'";
                $upres = $db->update($up_add_time_sql);
                if($upres <= 0){
                    $code = false;
                    echo 3;
                    break;
                }
            }
        }

        //清除之前的库存缓存

        //查询所有活动是不是已结束 ，如果已结束则关闭秒杀入口
        $sql_1 = "SELECT * FROM `lkt_seconds_activity` WHERE 1 and is_delete = 0 and status = 2 and store_id = $store_id";
        $res_1 = $db->select($sql_1);
        //如果想开启秒杀 查询时段是否大于5个 否则关闭入口
        $sel_time_num_sql = "SELECT COUNT(*) as sum FROM lkt_seconds_time WHERE is_delete = 0 and store_id = $store_id";
        $time_num_res = $db->select($sel_time_num_sql);
        $is_close = false;
        if(!empty($time_num_res)){
            $sum = $time_num_res[0]->sum;
            if($sum < 5){
                $is_close = true;
            }
        }else{
            $is_close = true;
        }
        if(empty($res_1) || $is_close){
            //如果没有数据 则关闭秒杀入口
            $up_config_sql = "update lkt_seconds_config set is_open = '0' where store_id = '$store_id'";
            $up_config__res = $db->update($up_config_sql);
        }else{
            $up_config_sql = "update lkt_seconds_config set is_open = '1' where store_id = '$store_id'";
            $up_config__res = $db->update($up_config_sql);
        }

        $redis->close();
        //时间段经过 搜索是否有生成订单，未支付的订单 如果有 则关闭订单
        if($code){
            $db->commit();
        }else{
            $db->rollback();
        }
    }



    /**
     * [pt description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  周文
     * @version 2.0
     * @date    2018-12-28T18:38:43+0800
     * @return 拼团定时处理执行文件
     */
    public function pt()
    {

        $db = $this->db;
        $store_id = $this->store_id;
        $db->begin();
        $code = true;     //状态值
        $now = time();
        $nowstr =  date('Y-m-d H:i:s', $now);
        //根据开团信息数据的结束时间查询结束的团
        $ktsql = "select ptcode,uid from lkt_group_open where store_id = '$store_id' and endtime < '$nowstr' and ptstatus=1";
        $ktres = $db->select($ktsql);
    
        $config = $db->select("select * from lkt_group_config where store_id = '$store_id'");
        if (!empty($config)) $config = $config[0]->refunmoney;

        //查询拼团时限
        $cfg_sql = "select * from lkt_group_config where store_id = $store_id";
        $cfg_res = $db->select($cfg_sql);

        //如果有结束的团，执行
        if (!empty($ktres)) {
            foreach ($ktres as $k => $v) {
                $ordersql = "select m.*,u.wx_id as uid 
                            from (
                            select o.id,o.user_id,o.ptcode,o.sNo,o.z_price,o.add_time,o.pay,o.trade_no,o.real_sno,o.offset_balance,d.p_name,d.p_price,d.num,d.sid 
                            from lkt_order as o 
                            left join lkt_order_details as d on o.sNo=d.r_sNo 
                            where o.store_id = '$store_id' and o.ptcode='$v->ptcode' and o.status=9
                            ) as m 
                            left join lkt_user as u on m.user_id=u.user_id";
                $orderres = $db->select($ordersql);
                $fromarr = array();
                //根据开团信息查询下面的开参团数据
                foreach ($orderres as $key => $value) {
                    // $fromidres = $this->get_fromid($store_id,$value->uid);
                    // $fromarr[0] = (object)$fromidres;
                    $refund = $ordernum = date('Ymd') . mt_rand(10000, 99999) . substr(time(), 5);
                    $modifysql = "update lkt_order set ptstatus=3,status=11,refundsNo='$refund' where store_id = '$store_id' and sNo='$value->sNo'";          //修改订单状态

                    $modres = $db->update($modifysql);
                    if($modres < 0){
                        $code = false;
                        break;
                    }
                    $modd = "update lkt_order_details set r_status=11 where store_id = '$store_id' and r_sNo='$value->sNo' and r_status=9";          //修改订单详情状态

                    $moddres = $db->update($modd);
                    if($moddres < 0){
                        $code = false;
                        break;
                    }
                    $sql_33 = "select money from lkt_user where store_id = '$store_id' and user_id='$value->user_id'";
                        $oldmoney = $db->select($sql_33);
                        $oldmoney = $oldmoney[0]->money;
                        if ($value->pay == 'wallet_pay') {     //订单余额支付
                            $sql = "update lkt_user set money=money+$value->z_price where store_id = '$store_id' and user_id='$value->user_id'";           //退款到用户余额
                            $res = $db->update($sql);

                            if($res < 0){
                                $code = false;
                                break;
                            }
                            $date = date('Y-m-d H:i:s');
                            $recordsql = "insert into lkt_record(store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','$value->user_id',$value->z_price,$oldmoney,'$date','" . $value->user_id . "拼团失败退款',5)";
                            $db->insert($recordsql);

                            // $fromres1 = $this->get_fromid($store_id,$value->uid);
                            // $fromid = $fromres1['fromid'];
                            // $sql = "select * from lkt_notice where store_id = '$store_id'";
                            // $r = $db->select($sql);
                            // $template_id = $r[0]->refund_success;
                            // $this->Send_fail($store_id,$value->uid, $fromid, $value->sNo, $value->p_name, $value->z_price,$template_id, 'pages/user/user');    //发送退款模板消息
                            // if ($fromid == $fromidres['fromid']) {
                            //     $fromidres = $this->get_fromid($store_id,$value->uid, $fromid);
                            //     $fromarr[0] = (object)$fromidres;
                            // }

                        } else if($value->pay == 'wallet_pay' || $value->pay == 'mini_wechat' || $value->pay == 'jsapi_wechat'){//退款--微信支付
                            $offset_balance = floatval($value->offset_balance);  //余额抵扣
                            if($offset_balance > 0){   //说明有余额抵扣，用户用的是组合支付
                                $sql = "update lkt_user set money=money+$offset_balance where store_id = '$store_id' and user_id='$value->user_id'";           //退款到用户余额

                                $res = $db->update($sql);
                                if($res < 0){
                                    $code = false;
                                    break;
                                }
                                $date = date('Y-m-d H:i:s');
                                $recordsql = "insert into lkt_record(store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','$value->user_id',$offset_balance,$oldmoney,'$date','" . $value->user_id . "拼团失败退款',5)";

                                $db->insert($recordsql);
                            }
                            $pay = $value->pay;   //支付方式
                            $pay_config = Tools::get_pay_config($db,$pay);

                            $appid = '';
                            if($pay_config){
                                $appid = $pay_config->appid;
                            }

                            if($appid != ''){
//                                echo '/wxpayv3/'.$appid.'_WxPay.Config.php';
                                require_once(MO_LIB_DIR .'/wxpayv3/'.$appid.'_WxPay.Config.php');
                                $price = floatval($value->z_price-$offset_balance);   //减去余额抵扣
                                $res = wxpay::wxrefundapi($value->real_sno, $refund, $price, $price,$store_id,$pay);
                                if($res['return_code'] != 'SUCCESS'){     //微信退款不成功
                                    $code = false;
                                    break;
                                }
                            }else{
                                $code = false;
                                break;
                            }

                        }

                        $prosql = "update lkt_configure set num=num+$value->num where id=$value->sid";
                        $updres = $db->update($prosql);      //释放产品内存

                        if($updres < 0){
                            $code = false;
                            break;
                        }
                }

                // foreach ($orderres as $ke => $va) {
                //     if ($va->uid != $fromarr[0]->fromid) {
                //         $fromidres = $this->get_fromid($store_id,$va->uid);
                //         $fromarr[0] = (object)$fromidres;
                //     }

                //     foreach ($fromarr as $key => $val) {
                //         if ($val->openid == $va->uid) {
                //             $orderres[$ke]->fromid = $val->fromid;
                //         }
                //     }
                // }
                // $sql = "select * from lkt_notice where store_id = '$store_id'";
                // $r = $db->select($sql);
                // $template_id = $r[0]->group_fail;
                // $this->Send_success($store_id,$orderres, $template_id);    //群发拼团失败消息


                $uptsql = "update lkt_group_open set ptstatus=3 where store_id = '$store_id' and ptcode='$v->ptcode'";                     //修改团状态
                $uptres = $db->update($uptsql);
                if($uptres < 0){
                    $code = false;
                    break;
                }
                if ($config == 2) {        //配置是手动退款
                    $uptres = $db->update("update lkt_order set ptstatus=3,status=10 where store_id = '$store_id' and ptcode='$v->ptcode' and status!=6");
                    if($uptres < 0){
                        $code = false;
                        break;
                    }
                }
            }
        }

        $prosql = "select min(g.id),g.product_id,g.group_data ,g.activity_no
                    from lkt_group_product as g 
                    where g.store_id='$store_id' and is_delete = 0 and EXISTS(
                    select status 
                    from lkt_product_list as l 
                    where l.id=g.product_id and l.status=2
                    ) 
                    group by g.activity_no";
        $prores = $db -> select($prosql);
        //自动开始活动产品和自动结束活动到期产品
        if(!empty($prores)){
            foreach($prores as $k => $v) {
                $group_data = unserialize($v -> group_data);
                $time_over = strtotime($group_data -> endtime);
                $starttime = strtotime($group_data -> starttime);
                $activity_no = $v->activity_no;
                if($starttime <= time() && $starttime>0){
//                    and starttime != '0000-00-00 00:00:00' and endtime != '0000-00-00 00:00:00'
                    $updsql = "update lkt_group_product set g_status=2 where g_status=1 and is_delete = 0   and activity_no = $activity_no and store_id='$store_id'";
                    $updres = $db -> update($updsql);
                }
                if($time_over <= time()){
                    $updsql = "update lkt_group_product set g_status=3 where activity_no = $activity_no and is_delete = 0   and store_id='$store_id' and starttime != '0000-00-00 00:00:00' and endtime != '0000-00-00 00:00:00'";
                    $updres = $db -> update($updsql);
                }
            }
        }
        // $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and UNIX_TIMESTAMP(lifetime) < '$now'";
        // $delres = $db->delete($delsql);
        // if($delres < 0){
        //     $code = false;
        // }

        if($code){                     //如果批量执行没出错则提交，否则就回滚
            $db->commit();
        }else{
            $db->rollback();
        }
    }

    /**
     * [twelve_draw description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-28T18:42:27+0800
     * @return  删除订单过期
     */
    public function order_failure()
    {
        $db = $this->db;
        $store_id = $this->store_id;

        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $r = $db->select($sql);
        $order_failure = $r ? $r[0]->order_failure:1; // 未付款订单保留时间
        $unit = $r? $r[0]->unit:1; // 未付款订单保留时间单位
        if ($order_failure != 0) {
            $time01 = date("Y-m-d H:i:s", strtotime("-$order_failure hour")); // 订单过期删除时间
            // 根据用户id，订单为未付款，订单添加时间 小于 未付款订单保留时间,查询订单表
            $sql = "select * from lkt_order where store_id = '$store_id' and status = 0 and add_time < '$time01' ";
            $r_c = $db->select($sql);
            // 有数据，循环查询优惠券id,修改优惠券状态
            if ($r_c) {
                foreach ($r_c as $key => $value) {
                    $coupon_id = $value->coupon_id;  // 优惠券id
                    if ($coupon_id != 0) {
                        // 根据优惠券id,查询优惠券信息
                        $sql = "select * from lkt_coupon where store_id = '$store_id' and id = '$coupon_id' ";
                        $r_c = $db->select($sql);
                        if($r_c){
                            $expiry_time = $r_c[0]->expiry_time; // 优惠券到期时间
                            $time = date('Y-m-d H:i:s'); // 当前时间
                            if ($expiry_time <= $time) {
                                // 根据优惠券id,修改优惠券状态(已过期)
                                $sql = "update lkt_coupon set type = 3 where store_id = '$store_id' and id = '$coupon_id'";
                                $db->update($sql);
                            } else {
                                // 根据优惠券id,修改优惠券状态(未使用)
                                $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and id = '$coupon_id'";
                                $db->update($sql);
                            }
                        }

                    }

                    $sNo = $value->sNo;
                    $type = substr($sNo,0,2);//获取订单号前两位字母（类型）
                    if($type == 'JP'){
                        $sql_0 = "update lkt_auction_product set trade_no = NULL where store_id = '$store_id' and trade_no = '$sNo'";
                        $res_0 = $db->update($sql_0);
                        if($res_0 < 0){
                            echo json_encode(array('code'=>110,'message'=>'更新竞拍订单失败'));
                            exit;
                        }
                        $sql01 = "update lkt_order set status = 7 where store_id = '$store_id' and status = 0 and add_time < '$time01' and sNo = '$sNo'";
                        $re01 = $db->update($sql01);
                        // 根据用户id、订单未付款、添加时间小于前天时间,就删除订单详情信息
                        $sql02 = "update lkt_order_details set r_status = 7 where store_id = '$store_id' and r_status = 0 and add_time < '$time01' and sNo = '$sNo'";
                        $re02 = $db->update($sql02);
                    }
                }
            }

            $sql01 = "update lkt_order set status = 6 where store_id = '$store_id' and status = 0 and add_time < '$time01' ";
            $re01 = $db->update($sql01);
            // 根据用户id、订单未付款、添加时间小于前天时间,就删除订单详情信息
            $sql02 = "update lkt_order_details set r_status = 6 where store_id = '$store_id' and r_status = 0 and add_time < '$time01' ";
            $re02 = $db->update($sql02);


        }

    }

    public function subtraction(){
        $db = $this->db;
        $store_id = $this->store_id;
        $now = date('Y-m-d H:i:s');
        $sql = "update lkt_subtraction set status=1 where store_id = '$store_id' and status=3 and startdate>='$now'";
        $db -> update($sql);

        $sql = "update lkt_subtraction set status=2 where store_id = '$store_id' and status=1 and enddate<'$now'";
        $db -> update($sql);
    }

    public function Send_fail($store_id,$uid, $fromid, $sNo, $p_name, $price, $template_id, $page)
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret
            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

        }

        $data = array();
        $data['access_token'] = $AccessToken;
        $data['touser'] = $uid;
        $data['template_id'] = $template_id;
        $data['form_id'] = $fromid;
        $data['page'] = $page;
        $price = $price . '元';
        $minidata = array('keyword1' => array('value' => $sNo, 'color' => "#173177"), 'keyword2' => array('value' => $p_name, 'color' => "#173177"), 'keyword3' => array('value' => $price, 'color' => "#173177"), 'keyword4' => array('value' => '退回到钱包', 'color' => "#FF4500"), 'keyword5' => array('value' => '拼团失败--退款', 'color' => "#FF4500"));
        $data['data'] = $minidata;

        $data = json_encode($data);

        $da = $this->httpsRequest($url, $data);
        $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and open_id='$uid' and fromid='$fromid'";
        $db->delete($delsql);
    }

    /*
     * 发送请求
     @param $ordersNo string 订单号　
     @param $refund string 退款单号
     @param $price float 退款金额
     return array
     */
    private function wxrefundapi($store_id,$ordersNo, $refund, $total_fee, $price)
    {
        //通过微信api进行退款流程
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        //$store_id = trim($request->getParameter('store_id'));

        $sql = "select mch_id from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $mch_id = $r[0]->mch_id; // 商户mch_id

            require_once(MO_LIB_DIR . '/WxPayPubHelper/'.$mch_id.'_WxPay.pub.config.php');
            $this->SSLCERT_PATH = WxPayConf_pub::SSLCERT_PATH;
            $this->SSLKEY_PATH = WxPayConf_pub::SSLKEY_PATH;
            $this->APPID = WxPayConf_pub::APPID;
            $this->MCHID = WxPayConf_pub::MCHID;
            $this->APPSECRET = WxPayConf_pub::APPSECRET;
            $this->KEY = WxPayConf_pub::KEY;

            $appid = WxPayConf_pub::APPID;
            $appsecret = WxPayConf_pub::APPSECRET;
            $mch_key = WxPayConf_pub::KEY;
        }

        $parma = array('appid' => $appid, 'mch_id' => $mch_id, 'nonce_str' => $this->createNoncestr(), 'out_refund_no' => $refund, 'out_trade_no' => $ordersNo, 'total_fee' => $total_fee, 'refund_fee' => $price, 'op_user_id' => $appid);
        $parma['sign'] = $this->getSign($parma, $mch_key);
        $xmldata = $this->arrayToXml($parma);

        $xmlresult = $this->postXmlSSLCurl($xmldata, 'https://api.mch.weixin.qq.com/secapi/pay/refund');
        $result = $this->xmlToArray($xmlresult);
        return $result;
    }

    /*
     * 生成随机字符串方法
     */
    protected function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /*
     * 对要发送到微信统一下单接口的数据进行签名
     */
    protected function getSign($Obj, $mch_key)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $mch_key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    /*
     *排序并格式化参数方法，签名时需要使用
     */
    protected function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = '';
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    //数组转字符串方法
    protected function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    protected function xmlToArray($xml)
    {
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }


    //需要使用证书的请求
    private function postXmlSSLCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, $this->SSLCERT_PATH);
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, $this->SSLKEY_PATH);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
            curl_close($ch);
            return false;
        }
    }

    public function Send_success($store_id,$arr, $template_id)
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret

            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

        }
        foreach ($arr as $k => $v) {
            $data = array();
            $data['access_token'] = $AccessToken;
            $data['touser'] = $v->uid;
            $data['template_id'] = $template_id;
            $data['form_id'] = $v->fromid;
            $data['page'] = "pages/order/detail?orderId=$v->id";
            $p_price = $v->p_price . '元';
            $z_price = $v->z_price . '元';
            $minidata = array('keyword1' => array('value' => $v->p_name, 'color' => "#173177"), 'keyword2' => array('value' => $p_price, 'color' => "#173177"), 'keyword3' => array('value' => $z_price, 'color' => "#173177"), 'keyword4' => array('value' => $v->sNo, 'color' => "#173177"), 'keyword5' => array('value' => '拼团失败', 'color' => "#FF4500"), 'keyword6' => array('value' => $v->add_time, 'color' => "#173177"));
            $data['data'] = $minidata;

            $data = json_encode($data);

            $da = $this->httpsRequest($url, $data);
            $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and open_id='$v->uid' and fromid='$v->fromid'";
            $re2 = $db->delete($delsql);
        }

    }

    public function get_fromid($store_id,$openid, $type = '')
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();


        if (empty($type)) {
            $fromidsql = "select fromid,open_id from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and id=(select max(id) from lkt_user_fromid where open_id='$openid')";
            $fromidres = $db->select($fromidsql);
            if ($fromidres) {
                $fromid = $fromidres[0]->fromid;
                $arrayName = array('openid' => $openid, 'fromid' => $fromid);
                return $arrayName;
            } else {
                return array('openid' => $openid, 'fromid' => '123456');
            }
        } else {
            $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and fromid='$type'";
            $re2 = $db->delete($delsql);
            $fromidsql = "select fromid,open_id from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and id=(select max(id) from lkt_user_fromid where store_id = '$store_id' and open_id='$openid')";
            $fromidres = $db->select($fromidsql);
            if ($fromidres) {
                $fromid = $fromidres[0]->fromid;
                $arrayName = array('openid' => $openid, 'fromid' => $fromid);
                return $arrayName;
            } else {
                return array('openid' => $openid, 'fromid' => '123456');
            }

        }

    }

    public function taobao()
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $request = $this->getContext()->getRequest();

        $sql = "select * from lkt_taobao where store_id='$store_id' and status=0 order by creattime asc";
        $list = $db->select($sql);
        foreach ($list as $k => $v) {
            $t_id = $v->id;
            $res = $this->gettaobao($v);
            if ($res == 1) {
                $db->update("update lkt_taobao set status=2,add_date=CURRENT_TIMESTAMP where store_id='$store_id' and status=0 and id='$t_id'");
            }else{
                $db->update("update lkt_taobao set status='-1',msg='$res',add_date=CURRENT_TIMESTAMP where store_id='$store_id' and status=0 and id='$t_id'");
            }
        }
        return;
    }


    public function gettaobao($list)
    {

        $db = $this->db;
        $store_id = $this->store_id;
        $request = $this->getContext()->getRequest();
        $admin_name = 'test';
        $JurisdictionAction = new JurisdictionAction();

        $itemid = $list->itemid;
        $cid = $list->cid;
        $brand_id = $list->brand_id;
        // $link = $list->link;
        $link = 'https://item.taobao.com/item.htm?id='.$itemid;

        preg_match('|\.(.*).com|isU',$link, $type);
        $type = $type[1];
        if ($type != 'taobao') {
            return '链接非淘宝网址！'.$link;
        }

        $data = $this->curl_https($link);

        if (!$data) {
            return '抓取失败，链接有误！'.$link;
        }

        $db->begin();

        $i = 0;
        $goods = array();
        $goods['weight'] = 0;           // 重量
        $goods['scan'] = $itemid;       // 条形码 暂用淘宝id
        $goods['product_class'] = $cid;    // 商品类别
        $goods['brand_id'] = $brand_id;         // 品牌

        //商品详情
        $detail_url = 'https://world.taobao.com/item/'.$itemid.'.htm';
        $detail = $this->curl_https($detail_url);
        preg_match('|class=\"detail-box\">(.*)</div>|isU',$detail, $det);
        $goods['content'] = $det[1];

        preg_match('|sellerId         : \'(.*)\',|isU',$data, $sell);
        $sellerId = $sell[1];

        preg_match('|idata            : {(.*)ler: {|isU',$data, $pic);
        preg_match('|item: {(.*)seller: {|isU',$pic[0], $xx);
        $arr = explode(':', $xx[1]);
        // 淘宝ID
        preg_match_all('/(\d+(\.\d+)?)/is',$arr[1],$itemId);
        $goods['taobaoid'] = $itemId[1][0];
        // 产品标题
        preg_match_all('|\'(.*)\'|isU',$arr[2],$title);
        $title = $this->getjson($title[1][0]);
        $goods['product_title'] = $title;
        // 关键词
        preg_match('|<meta name="keywords" content="(.*)"/>|isU',$data, $keywords);
        $goods['keyword'] = $this->tozhongwen($keywords[1]);
        // 产品主图
        preg_match('|\'(.*)\',|isU',$arr[3], $pic);
        $path = 'http:'.$pic[1];
        $goods['imgurl'] = $this->downlode($path,$itemid,$i);

        //轮播图
        preg_match('|auctionImages    : \[(.*)\]|isU',$xx[1], $imgs);
        $imgs = explode(',', $imgs[1]);
        foreach ($imgs as $k => $v) {
            if ($k > 0) {
                preg_match('|:(.*)"|isU',$v, $img);
                if (empty($img)) {
                    $img = substr($v, 1, -1);
                }else{
                    $img = $img[1];
                }
                $i++;
                $imgurls[] = $this->downlode('http:'.$img,$itemid,$i);
            }
        }
        //轮播图  end
        
        preg_match('|<input type="hidden" name="current_price" value=(.*)/>|isU',$data, $price);
        preg_match('|"(.*)"|isU',$price[1], $pricc);
        $goods['initial']['cbj'] = floatval($pricc[1]); // 成本价
        $goods['initial']['yj'] = floatval($pricc[1]);  // 原价
        $goods['initial']['sj'] = floatval($pricc[1]);  // 售价
        $goods['initial']['unit'] = '件';               // 单位初始值
        $goods['initial']['kucun'] = 0;                 // 库存
        $initial = serialize($goods['initial']);
        $mch_id = 1;//商户id
        $min_inventory = 10;// 库存预警
        //属性
        $attributes = array();// 属性
        $att1 = array();//基础属性1
        $att2 = array();//基础属性2
        preg_match('|id="J_isku"(.*)class="tb-extra"|isU',$data, $sku);
        $sku2 = explode("<dl",$sku[1]);
        foreach ($sku2 as $k => $v) {
            preg_match('|"tb-property-type">(.*)</dt>|isU',$v, $title);
            if (!empty($title)) {
                $tit1 = $this->tozhongwen($title[1]);
                $li = explode("</li>",$v);
                if (count($li) > 1) {
                    foreach ($li as $key => $value) {
                        preg_match('|<span>(.*)</span>|isU',$value, $title);
                        preg_match('|data-value="(.*)"|isU',$value, $id);
                        preg_match('|background:url\((.*)_30x30.jpg\)|isU',$value, $img);
                        if (!empty($title) && !empty($id)) {
                            $att1[$id[1]]['name'][$tit1] = $this->tozhongwen($title[1]);
                            if (!empty($img)) {
                                $i++;
                                $att1[$id[1]]['img'] = $this->downlode('http:'.$img[1],$itemid,$i);
                            }
                        }
                    }
                }
            }
        }
        $z_num = 0;
        preg_match('|skuMap     : {(.*)}}|isU',$data, $sku);
        if (!empty($sku)) {
            $sku2 = explode("},",$sku[1]);
            $attributt = array();
            foreach ($sku2 as $k => $v) {

                preg_match('|"price":"(.*)","|isU',$v, $sub2);
                $attributt['costprice'] = floatval($sub2[1]);
                $attributt['yprice'] = floatval($sub2[1]);
                $attributt['price'] = floatval($sub2[1]);

                preg_match('|"stock":"(.*)","|isU',$v, $sub2);
                $attributt['num'] = floatval($sub2[1]);
                $attributt['total_num'] = floatval($sub2[1]);
                $z_num += $attributt['num'];
                $attributt['unit'] = '件';

                preg_match('|";(.*);"|isU',$v, $sub1);
                $att = explode(";",$sub1[1]);
                $attribute = array();
                foreach ($att as $key => $value) {
                    $attribute = array_merge($attribute, $att1[$value]['name']);
                    if (array_key_exists('img',$att1[$value])) {
                        $attributt['img'] = $att1[$value]['img'];
                    }
                }
                $attributt['attribute'] = serialize($attribute);

                $attributes[] = $attributt;
            }
        }
        if (count($attributes)==0) {
            $attributt = array(
                'costprice' => $goods['initial']['cbj'], 
                'yprice' => $goods['initial']['cbj'], 
                'price' => $goods['initial']['cbj'], 
                'num' => $goods['initial']['cbj'], 
                'total_num' => $goods['initial']['kucun'], 
                'unit' => $goods['initial']['unit'], 
                'img' => $goods['imgurl'], 
                'attribute' => serialize(array()),
            );
            $attributes[] = $attributt;
        }
        //属性 end
        $sort_sql = "select MAX(sort) as sort from lkt_product_list where store_id = '$store_id' and recycle = 0";
        $sort_r = $db->select($sort_sql);
        $sort = $sort_r[0]->sort +1 ;

        // 发布产品
        $sql = "insert into lkt_product_list(store_id,product_title,subtitle,scan,product_number,product_class,brand_id,keyword,weight,imgurl,sort,content,num,min_inventory,s_type,add_date,is_distribution,distributor_id,freight,is_hexiao,hxaddress,active,mch_id,mch_status,show_adr,initial,publisher) " .
            "values('$store_id','".$goods['product_title']."','".$goods['product_title']."','".$goods['scan']."','$itemid','".$goods['product_class']."','8','".$goods['keyword']."','".$goods['weight']."','".$goods['imgurl']."','$sort','".$goods['content']."','$z_num','$min_inventory','1',CURRENT_TIMESTAMP,'0','0','0','0','','0','$mch_id',2,'0','$initial','$admin_name')";

        $id1 = $db->insert($sql, 'last_insert_id'); // 得到添加数据的id

        if ($id1) {
            if ($imgurls) {
                $arrimg = [];
                $f_img = "select product_url from lkt_product_img where product_id = '$id1'";
                $rf = $db->select($f_img);
                if ($rf) {
                    foreach ($rf as $key => $fs) {
                        $arrimg[$fs->product_url] = $fs->product_url;
                    }
                }
                $arr_eimg = [];

                foreach ($imgurls as $key => $file) {
                    $imgsURL_name = preg_replace('/.*\//', '', $file);
                    if (array_key_exists($imgsURL_name, $arrimg)) {
                        unset($arrimg[$imgsURL_name]);
                    }
                    if ($key < 5) {
                        $sql_img = "insert into lkt_product_img(product_url,product_id,add_date) " . "values('$imgsURL_name','$id1',CURRENT_TIMESTAMP)";
                        $r = $db->insert($sql_img);
                        if ($r < 1) {
                            $db->rollback();
                            return '未知原因，商品抓取失败！！';
                        }
                    }
                }
                if (!empty($arrimg)) {
                    foreach ($arrimg as $keys => $fss) {
                        $ql_img = "delete from lkt_product_img  where product_url = '$fss'";
                        $r = $db->delete($ql_img);
                    }
                }
            }

            foreach ($attributes as $ke => $va) {
                $va['pid'] = $id1;
                $va['bar_code'] = $itemid;
                $va['total_num'] = $va['num'];
                $total_num = $va['num'];
                $va['ctime'] = 'CURRENT_TIMESTAMP';
                if (empty($va['img'])) {
                    $va['img'] = $goods['imgurl'];
                }
                // ctime = CURRENT_TIMESTAMP
                $r_attribute = $db->insert_array($va, 'lkt_configure', '', 1);
                if ($r_attribute < 1) {
                    $db->rollback();
                    return '未知原因，商品抓取失败！！！';
                }
                $num = $va['num'];
                // 在库存记录表里，添加一条入库信息
                $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id1','$r_attribute','$total_num','$num',0,CURRENT_TIMESTAMP)";
                $db->insert($sql);

                if ($min_inventory >= $num) { // 当属性库存低于等于预警值
                    // 在库存记录表里，添加一条预警信息
                    $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id1','$r_attribute','$total_num','$num',2,CURRENT_TIMESTAMP)";
                    $db->insert($sql);
                }
            }
            $db->commit();
            $JurisdictionAction->admin_record($store_id, $admin_name, '添加商品' . $goods['product_title'], 1);

            $sql = "update lkt_product_number set status = 1 where store_id = '$store_id' and mch_id = '$mch_id' and operation = '$admin_name' and product_number = '$itemid'";
            $db->update($sql);

            return 1;
        } else {
            $db->rollback();
            $JurisdictionAction->admin_record($store_id, $admin_name, '添加商品' . $goods['product_title'] . '失败', 1);
            return '未知原因，商品抓取失败！！！！';
        }
        return;

    }

    //乱码中文转码
    function tozhongwen($string){
        return mb_convert_encoding($string,'UTF-8','gbk');
    }
    /** curl 获取 https 请求 
    * @param String $url        请求的url 
    * @param Array  $data       要發送的數據 
    * @param Array  $header     请求时发送的header 
    * @param int    $timeout    超时时间，默认30s 
    */  
    function curl_https($url, $data=array(), $header=array(), $timeout=30){  

        // $header = array('user-agent:'.$_SERVER['HTTP_USER_AGENT']);

        $ip = "100.100.".rand(1, 255).".".rand(1, 255);
        $headers = array("X-FORWARDED-FOR:$ip");

        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在  
        curl_setopt($ch, CURLOPT_URL, $url);  
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_POST, true);  
        //curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
       
        $response = curl_exec($ch);  
       
        if($error=curl_error($ch)){  
            return false;
        }
       
        curl_close($ch);  

        return $response;

    }

    function getjson($title){

        // 转换编码，将Unicode编码转换成可以浏览的utf-8编码  
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';  
        preg_match_all($pattern, $title, $matches);  
        if (!empty($matches))  
        {  
            $title = '';  
            for ($j = 0; $j < count($matches[0]); $j++)  
            {  
                $str = $matches[0][$j];  
                if (strpos($str, '\\u') === 0)  
                {  
                    $code = base_convert(substr($str, 2, 2), 16, 10);  
                    $code2 = base_convert(substr($str, 4), 16, 10);  
                    $c = chr($code).chr($code2);  
                    $c = iconv('UCS-2', 'UTF-8', $c);  
                    $title .= $c;  
                }  
                else  
                {  
                    $title .= $str;  
                }  
            }  
        }  
        return $title;  
    }

    function downlode($url,$id,$i) {

        $db = $this->db;
        $store_id = $this->store_id;

        $upserver = '1';
        $sql0 = "select upserver from lkt_upload_set limit 1";
        $r0 = $db->select($sql0);
        if($r0){
            //1本地存储  2阿里云存储
            $upserver = $r0[0]->upserver;
        }

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $uploadImg = $r[0]->uploadImg; // 图片上传位置
        }
        $imgname = 'a'.$id . $i . strrchr($url,'.');
        $imgDir = 'image_'.$store_id.'/';
        $file = $uploadImg . $imgDir . $imgname;

        $dir = iconv("UTF-8", "GBK", $uploadImg . $imgDir);
        if (!file_exists($dir)){
            mkdir ($dir,0777,true);
        }

        $state = @file_get_contents($url,0,null,0,1);//获取网络资源的字符内容
        if($state){
            ob_start();//打开输出
            readfile($url);//输出图片文件
            $img = ob_get_contents();//得到浏览器输出
            ob_end_clean();//清除输出并关闭
            $size = strlen($img);//得到图片大小
            $fp2 = @fopen($file, "a");
            fwrite($fp2, $img);//向当前目录写入图片文件，并重新命名
            fclose($fp2);

            $group = '-1';

            if ($upserver == '2' && is_file($file)) {

                $ossClient = OSSCommon::getOssClient();
                $common = LKTConfigInfo::getOSSConfig();
                $dir = $store_id . '/0/'.$imgname;
                $ossClient->uploadFile($common['bucket'], $dir, $file);
                $group = $store_id;

                unlink ($file);
            }

            $sql = "insert into `lkt_files_record` (`store_id`, `group`, `upload_mode`, `image_name`, `add_time`) VALUES ('$store_id', '$group', '$upserver', '$imgname', CURRENT_TIMESTAMP)";
            $db->insert($sql);
        }

        return $imgname;
    }

    function httpsRequest($url, $data = null)
    {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($data)) {
            // 发送post请求
            curl_setopt($ch, CURLOPT_POST, 1);
            // 设置发送post请求参数数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // 3.执行会话; $result是微信服务器返回的JSON字符串
        $result = curl_exec($ch);
        // 4.关闭会话
        curl_close($ch);
        return $result;
    }

    function getAccessToken($appID, $appSerect)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appSerect;
        // 时效性7200秒实现
        // 1.当前时间戳
        $currentTime = time();
        // 2.修改文件时间
        $fileName = "accessToken"; // 文件名
        if (is_file($fileName)) {
            $modifyTime = filemtime($fileName);
            if (($currentTime - $modifyTime) < 7200) {
                // 可用, 直接读取文件的内容
                $accessToken = file_get_contents($fileName);
                return $accessToken;
            }
        }
        // 重新发送请求
        $result = $this->httpsRequest($url);
        $jsonArray = json_decode($result, true);
        // 写入文件
        $accessToken = $jsonArray['access_token'];
        file_put_contents($fileName, $accessToken);
        return $accessToken;
    }

    public function execute()
    {
        $this->getDefaultView();
        exit();
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}
?>