<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/coupon_pluginAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once('Apimiddle.class.php');

class testAction extends Apimiddle
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

            //自动结束过期满减活动
            $this -> subtraction();

            // 检查商品状态
            $this -> product_status();

        }
        exit;

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
                    $sql1 = "update lkt_product_list set status = 1 where id = '$pid'";
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

        $sql01 = "select id,r_sNo,deliver_time,user_id,store_id from lkt_order_details where store_id = '$store_id' and r_status = '2' and date_add(deliver_time, interval $auto_the_goods day) < now()";

        $rew = $db->select($sql01);

        // var_dump($sql01,$rew);

        if($rew){
            foreach ($rew as $key => $value) {
                
                $user_id = $value->user_id;
                $sNo = $value->r_sNo;
                

                $sql_1 = "update lkt_order_details set r_status = 3, arrive_time = '$time' where store_id = '$store_id' and r_sNo = '$sNo' and r_status = '2'";
                $r_1 = $db->update($sql_1);
                if($r_1 < 1){
                    $code = false;
                    break;
                }


                // if($rew[0]->otype == 'pt') $r_1 = 1;
                $sql_2 = "update lkt_order set status = 3 where store_id = '$store_id' and sNo = '$sNo'";
                $r_2 = $db->update($sql_2);
                if($r_2 < 1){
                    $code = false;
                    break;
                }

                $coupon = new coupon_pluginAction();
                $coupon_list = $coupon->give($store_id,$user_id,'shopping',$sNo);

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
                               $coupon = new coupon_pluginAction();
                               $coupon_list = $coupon->give($store_id,$Referee,'invitation');
                               if(!empty($coupon_list)){
                                    foreach ($coupon_list as $keyl => $valuel) {
                                        $ww = $this->wxss($Referee,(object)$valuel);
                                        // var_dump($ww);
                                    }
                               }
                               // var_dump($coupon_list);
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

        //自动开始和结束到时间的竞拍活动
        $sql = "select id,title,starttime,endtime,status,invalid_time from lkt_auction_product where store_id = '$store_id' and status in (0,1)";
        $res = $db->select($sql);
        if($res){
            foreach ($res as $k => $v){
                $id = $v->id;
                $status = $v->status;
                $starttime = $v->starttime;
                $endtime = $v->endtime;
                $invalid_time = $v->invalid_time;

              
                if($status == 0 && ($now >= $starttime)){//开始竞拍活动
                  
                    $sql_s = "update lkt_auction_product set status = 1 where store_id = '$store_id' and id = '$id'";
                    $res_s = $db->update($sql_s);
                }else if($status == 1 && ($now >= $endtime)){//结束竞拍活动 status = 2 (已完成) status = 3 (流拍)

                    //流拍代码 -- 人数不足
                    $sql_l = "update lkt_auction_product set status = 3 where store_id = '$store_id' and id = '$id' and pepole < low_pepole";
                    $res_l = $db->update($sql_l);


                    //正常竞拍，取最高价为得主
                    $sql_h = "SELECT user_id ,price FROM lkt_auction_record WHERE store_id = '$store_id' AS auction_id = '$id' ORDER BY price DESC LIMIT 1 ";
                    $res_h = $db->select($sql_h);//最高价及用户id

                    $user_id = $res_h[0]->user_id;
                    $price = $v->price;


                    
                    if($user_id != '' || $price != ''){
                        $sql_e = "update lkt_auction_product set status = 2,current_price = '$price',user_id = '$user_id' where store_id = '$store_id' and id = '$id' and pepole > low_pepole";
                        $res_e = $db->update($sql_e);//更新得主
                    }    
                }else if($status == 2 && $now >=$invalid_time){//对活动已失效，得主未付款，置为流拍

                    $sql = "select id,user_id from lkt_auction_product where store_id = '$store_id' and user_id != '' and is_buy != 1 and invalid_time < '$now'";
                    $res = $db->select($sql);

                    if($res){
                        foreach($res as $k1 => $v1){
                            $a_id = $v1->id;
                            $a_user_id = $v1->user_id;

                            $sql_0 = "update lkt_auction_promise set allow_back = 0  where a_id = '$a_id' and user_id = '$a_user_id'";
                            $res_0 = $db->update($sql_0); //对不满足退款要求的user，置为不退款
                        }
                    }

                    $sql = "update lkt_auction_product set status = 3 where store_id = '$store_id' and id = '$id' and user_id != '' and is_buy != 1";
                    $res = $db->update($sql);
                }
            }
        }
        
        $db->begin();//开启事务
        $code = true;//事务回滚标识

        //退款代码 -- 竞拍成功  
        $sql_2 = "select id,promise,type,user_id,trade_no from lkt_auction_promise where store_id = '$store_id' and is_pay = 1 and is_back = 0 and allow_back = 1";
        $res_2 = $db->select($sql_2);

        if(!empty($res_2)){

            foreach ($res_2 as $k2 => $v2) {
                
               $promise_id = $v2->id;//押金表id
                $promise = $v2->promise;//押金金额
                $pay_type = $v2->type;//支付类型
                $promise_user = $v2->user_id;//退款用户id
                $trade_no = $v2->trade_no;//押金订单号

                if($pay_type == 2){//退款--钱包支付

                    //查出原操作金额
                    $sql_3 = "select money from lkt_user where store_id = '$store_id' and user_id = '$promise_user'";
                    $res_3 = $db->select($sql_3);

                    $oldmoney = $res_3[0]->money;//原金额

                    $sql_4 = "update lkt_auction_promise set is_back = 1 where store_id = '$store_id' and id = '$promise_id' and user_id = '$promise_user' and type = 2";
                    $res_4 = $db->update($sql_4);//退款状态   1

                    $sql_5 = "update lkt_user set money = money + '$promise' where store_id = '$store_id' and user_id = '$promise_user'";
                    $res_5 = $db->update($sql_5);

                    $sql_6 = "insert into lkt_record(store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','$promise_user','$promise','$oldmoney','$now','退款竞拍押金',27)";
                    $res_6 = $db->insert($sql_6);

                    if($res_4 < 0 || $res_5 < 0 || $res_6 < 0){
                        $code = false;
                        break;
                    } 

                }else if($pay_type == 1){//退款--微信支付

 
                    //退款代码
                    $pay = 'mini_wechat';
                    $pay_config = Tools::get_pay_config($db,$pay);

                    if($pay_config){
                       $mch_id = $pay_config->mch_id;
                    }else{
                        $mch_id = ''; 
                    }

                    require_once(MO_LIB_DIR .'/wxpayv3/'.$mch_id.'_WxPay.Config.php');
                    $wxtk_res = wxpay::wxrefundapi($trade_no,$trade_no.mt_rand(0,9),$promise,$promise);

                    if ($wxtk_res['result_code'] != 'SUCCESS') {//退款失败
                       $db->rollback();
                        echo 0;
                        exit;
                    }

                    $sql_1 = "update lkt_auction_promise set is_back = 1 where store_id = '$store_id' and id = '$promise_id' and user_id = '$promise_user' and type = 1";
                    $res_1 = $db->update($sql_1);
                    if($res_1 < 0){
                        $db->rollback();
                        echo 0;
                        exit;
                    }

                    //退款成功则发送消息推送
                    
                    $template_id = 'refund_res';//退款模板
                    //退款商家名称
                    $sql_t = "select company from lkt_config where store_id = '$store_id'";
                    $res_t = $db->select($sql_t);
                    $title = $res_t[0]->company; 

                    $keyword1 = array('value' => $trade_no, "color" => "#173177");
                    $keyword2 = array('value' => $title, "color" => "#173177");
                    $keyword3 = array('value' => $now, "color" => "#173177");
                    $keyword4 = array('value' => '退款成功', "color" => "#173177");
                    $keyword5 = array('value' => $promise . '元', "color" => "#173177");
                    $keyword6 = array('value' => '退还竞拍押金', "color" => "#173177");
                    $keyword7 = array('value' => '微信钱包', "color" => "#173177");

                    //组成微信消息模板规定格式
                    $o_data = array('keyword1' => $keyword1, 'keyword2' => $keyword2, 'keyword3' => $keyword3, 'keyword4' => $keyword4, 'keyword5' => $keyword5, 'keyword6' => $keyword6, 'keyword7' => $keyword7);
                    //消息发送
                    $Tools = new Tools($db, $store_id, '');

                    $data = array();
                    $data['page'] = 'pages/index/index';
                    $data['template_id'] = $template_id;
                    $data['openid'] = Tools::get_openid($db, $store_id, $promise_user);
                    $data['o_data'] = $o_data;
                    $tres = $Tools->send_notice($data, 'wx');

                }


            }
        }  

        //退款


        //
        if($code){
            $db->commit();
        }else{
            $db->rollback();
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
        $ktsql = "select ptcode,uid from lkt_group_open where store_id = '$store_id' and UNIX_TIMESTAMP(endtime) < $now and ptstatus=1";
        $ktres = $db->select($ktsql);

        $config = $db->select("select * from lkt_group_config where store_id = '$store_id'");
        if (!empty($config)) $config = $config[0]->refunmoney;

        if (!empty($ktres)) {
            foreach ($ktres as $k => $v) {
                $ordersql = "select m.*,u.wx_id as uid from (select o.id,o.user_id,o.ptcode,o.sNo,o.z_price,o.add_time,o.pay,o.trade_no,d.p_name,d.p_price,d.num,d.sid from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and o.ptcode='$v->ptcode' and o.status!=6) as m left join lkt_user as u on m.user_id=u.user_id";
                $orderres = $db->select($ordersql);

                $fromarr = array();
                foreach ($orderres as $key => $value) {
                    $fromidres = $this->get_fromid($store_id,$value->uid);
                    $fromarr[0] = (object)$fromidres;
                    $refund = $ordernum = date('Ymd') . mt_rand(10000, 99999) . substr(time(), 5);
                    $modifysql = "update lkt_order set ptstatus=3,status=11,refundsNo='$refund' where store_id = '$store_id' and sNo='$value->sNo'";          //修改订单状态
                    $modres = $db->update($modifysql);

                    if($modres < 0){
                        $code = false;
                        break;
                    }
                    if ($config == 1) {                        //后台配置是自动退款
                        if ($value->pay == 'wallet_Pay') {     //订单余额支付
                            $oldmoney = $db->select("select money from lkt_user where store_id = '$store_id' and user_id='$value->user_id'");
                            $oldmoney = $oldmoney[0]->money;
                            $sql = "update lkt_user set money=money+$value->z_price where store_id = '$store_id' and user_id='$value->user_id'";           //退款到用户余额
                            $res = $db->update($sql);

                            if($res < 0){
                                $code = false;
                                break;
                            }
                            $date = date('Y-m-d H:i:s');
                            $recordsql = "insert into lkt_record(store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','$value->user_id',$value->z_price,$oldmoney,'$date','" . $value->user_id . "拼团失败退款',5)";
                            $db->insert($recordsql);

                            $fromres1 = $this->get_fromid($store_id,$value->uid);
                            $fromid = $fromres1['fromid'];
                            $sql = "select * from lkt_notice where store_id = '$store_id'";
                            $r = $db->select($sql);
                            $template_id = $r[0]->refund_success;
                            $this->Send_fail($store_id,$value->uid, $fromid, $value->sNo, $value->p_name, $value->z_price,$template_id, 'pages/user/user');    //发送退款模板消息
                            if ($fromid == $fromidres['fromid']) {
                                $fromidres = $this->get_fromid($store_id,$value->uid, $fromid);
                                $fromarr[0] = (object)$fromidres;
                            }

                        } else if ($value->pay == 'wxPay') {         //订单微信支付
                            $price = $value->z_price * 100;
                            $res = $this->wxrefundapi($store_id,$value->trade_no, $refund, $price, $price);
                            if($res['return_code'] != 'SUCCESS'){     //微信退款不成功
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
                }

                foreach ($orderres as $ke => $va) {
                    if ($va->uid != $fromarr[0]->fromid) {
                        $fromidres = $this->get_fromid($store_id,$va->uid);
                        $fromarr[0] = (object)$fromidres;
                    }

                    foreach ($fromarr as $key => $val) {
                        if ($val->openid == $va->uid) {
                            $orderres[$ke]->fromid = $val->fromid;
                        }
                    }
                }
                $sql = "select * from lkt_notice where store_id = '$store_id'";
                $r = $db->select($sql);
                $template_id = $r[0]->group_fail;
                $this->Send_success($store_id,$orderres, $template_id);    //群发拼团失败消息
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

        $prosql = "select min(g.id),g.product_id,g.group_data from lkt_group_product as g where g.store_id='$store_id' and EXISTS(select status from lkt_product_list as l where l.id=g.product_id and l.status=0) group by g.product_id";
        $prores = $db -> select($prosql);
        //自动开始活动产品和自动结束活动到期产品
        if(!empty($prores)){
            foreach($prores as $k => $v) {
                $group_data = unserialize($v -> group_data);
                $time_over = strtotime($group_data -> endtime);
                $starttime = strtotime($group_data -> starttime);
                if($starttime <= time()){
                    $updsql = "update lkt_group_product set g_status=2 where product_id=$v->product_id and store_id='$store_id'";
                    $updres = $db -> update($updsql);
                }
                if($time_over <= time()){
                    $updsql = "update lkt_group_product set g_status=3 where product_id=$v->product_id and store_id='$store_id'";
                    $updres = $db -> update($updsql);
                }
            }
        }
        $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and UNIX_TIMESTAMP(lifetime) < '$now'";
        $delres = $db->delete($delsql);
        if($delres < 0){
            $code = false;
        }

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