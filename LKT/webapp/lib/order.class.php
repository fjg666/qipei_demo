<?php
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/Plugin_order.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');

class order
{
    public function acution_change($trade_no){//竞拍押金

         $db = DBAction::getInstance();
         $db->begin();
         $sql = "update lkt_auction_promise set is_pay = 1,allow_back = 1 where trade_no = '$trade_no'";
         $res = $db->update($sql);

         if($res < 1){
            $db->rollback();
            echo json_encode(array('status' => 0, 'err' => '修改竞拍押金失败'));
            exit;
         }  
         
		//查询相应竞拍商品数据
		$sql_1 = "select a_id,store_id from lkt_auction_promise where trade_no = '$trade_no' and is_pay = 1";
		$res_1 = $db->select($sql_1);
        
		
		if($res_1){
			
			$store_id = $res_1[0]->store_id;
			$a_id = $res_1[0]->a_id;
			$sql_4 = "update lkt_auction_product set pepole = pepole+1 where store_id = '$store_id' and id = '$a_id'";
			$res_4 = $db->update($sql_4);
			
			if($res_4 < 1){
                $db->rollback();
				echo json_encode(array('status'=>0,'err'=>'修改竞拍参与人数失败'));
				exit;
			}
		}
        $db->commit();
        //在redis中自增参与人数
       
        $sql_5 = "select current_price,pepole,invalid_time from lkt_auction_product where store_id = $store_id and id = $a_id";
        $res_5 = $db->select($sql_5);
        if($res_5){
            $redis = new RedisClusters();
            $re = $redis->connect();
            $redis->incr('AC'.$a_id.'pepole');
            $redis->close();//关闭句柄
        }
       
        $sql_1 = "select user_id from lkt_auction_promise where trade_no = '$trade_no' and is_pay = 1";
        $res_1 = $db->select($sql_1);
        $user_id = $res_1[0]->user_id;

         return $user_id;

    }
    public function acution_order($data){//竞拍订单，付款后修改订单状态，并修改库存

        $db = DBAction::getInstance();
        //1.开启事务
        $db->begin();

         //2.数据准备
        $coupon_id = $data['coupon_id']; // 优惠券id
        
        $order_id = $data['sNo']; // 订单号
        $user_id = $data['user_id']; // 微信id
        $z_price = $data['z_price']; // 订单金额
        $trade_no = $data['trade_no']; // 微信支付单号
        $pay = $data['pay'];

        $offset_balance = $data['offset_balance']; //是否开启组合支付


        //支付方式判断combined_pay
        if($offset_balance > 0){
            $total = $z_price+$offset_balance;
            //写入日志
            $sqll = "insert into lkt_combined_pay (weixin_pay,balance_pay,total,order_id,add_time,user_id) values ('$z_price','$offset_balance','$total','$order_id',CURRENT_TIMESTAMP,'$user_id')";
            $rr = $db->insert($sqll);
            if($rr < 1) {
                $db->rollback();
                // echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
                exit;
            }
            // 根据修改支付方式
            $sql_combined = "update lkt_order set pay = 'combined_pay',z_price = '$total' where sNo = '$order_id' and user_id = '$user_id' ";
            $r_combined = $db->update($sql_combined);
            if($r_combined < 1) {
                $db->rollback();
                // echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
                exit;
            }
        }

        //修改订单，修改库存
        $sql_u = "update lkt_order set status = 1,pay = '$pay',trade_no='$trade_no',pay_time=CURRENT_TIMESTAMP where sNo = '$order_id' and user_id = '$user_id' ";
        $r_u = $db->update($sql_u);

        if ($r_u < 1) {
            $db->rollback();
            echo json_encode(array('status' => 0, 'err' => '1修改失败!'));
            exit;
        }

        $sql = "update lkt_coupon set type = 2 where user_id = '$user_id' and id = '$coupon_id'";
        $beres = $db->update($sql);
        // if ($beres < 1) {
        //     $db->rollback();
        //     echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
        //     exit;
        // }
        
        // 根据订单号,修改订单详情状态(未发货)
        $sql_d = "update lkt_order_details set r_status = 1 where r_sNo = '$order_id' ";
        $r_d = $db->update($sql_d);

        //修改竞拍商品的支付状态
        $sql_a = "update lkt_auction_product set is_buy = 1 where user_id = '$user_id' and trade_no = '$order_id'";
        $r_a = $db->update($sql_a);
        if($r_a < 1 || $r_d < 1){
            $db->rollback();
            echo json_encode(array('status'=>0,'err'=>'修改竞拍商品是否支付状态失败！'));
            exit;
        }

        //查询付款成功的竞拍得主信息
        $sql_1 = "select id,user_id,store_id from lkt_auction_product where trade_no = '$order_id' and user_id = '$user_id'";
        $res_1 = $db->select($sql_1);
        $a_id = $res_1[0]->id;//竞拍商品id
        $store_id = $res_1[0]->store_id;//商户id

        //修改竞拍押金退款标准为可退款
        $sql_2 = "update lkt_auction_promise set allow_back = 1 where store_id = '$store_id' and a_id = '$a_id' and user_id = '$user_id' and allow_back = 0";
        $res_2 = $db->update($sql_2);
        if($res_2 < 1){
            $db->rollback();
            echo json_encode(array('status'=>0,'err'=>'修改竞拍押金退款标准失败'));
            exit;
        }

        // 根据订单号,查询商品id、商品名称、商品数量
        $sql_o = "select p_id,num,p_name,sid from lkt_order_details where r_sNo = '$order_id' ";
        $r_o = $db->select($sql_o);


        foreach ($r_o as $key => $value) {
            $pid = $value->p_id; // 商品id
            $num = $value->num; // 商品数量
            $sid = $value->sid; // 商品属性id
            // 根据商品id,修改商品数量
            $sql_p = "update lkt_configure set  num = num - $num where id = $sid";
            $beres = $db->update($sql_p); 
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
                exit;
            }
            // 根据商品id,修改卖出去的销量
            $sql_x = "update lkt_product_list set volume = volume + $num,num = num-$num where id = $pid";
            $beres = $db->update($sql_x); 
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
                exit;
            }
        }

        // $grade= new Plugin_order($store_id);
        // $grade->jifen($db,$user_id,$order_id,$store_id,0);注释，后期有用

        $db->commit();
        return true;


    }

    public function red_packet_send($data,$trade_no){//添加发红包记录
        $db = DBAction::getInstance();
        $user_id = $data['user_id'];//用户
        $money = $data['money'];//金额
        $num = $data['num'];//数量
        $show = $data['show'];//1.随机红包  2. 普通红包
        $paytype = $data['paytype'] ;//支付类型 wallet_Pay 钱包支付  wxPay  微信支付
        $remarks = $data['remarks']?$data['remarks']:"恭喜发财 大吉大利";//备注
        $store_id = $data['store_id'];
        //现在时间
        $datetime = date('Y-m-d H:i:s',time());
        if($show == 2){
            $tes = $this->putong_redpacket($money,$num);
        }else{
            $tes = $this->redpacket($money,$num);
        }
        if(!empty($tes)){
            $red = implode(',',$tes);
        }else{
            $red = '';
        }

        $sql01 = "select * from lkt_red_packet_config where store_id = '$store_id'";//红包参数
        $r_1 = $db->select($sql01);
        if (!empty($r_1)) {
            $ordinary = unserialize($r_1[0]->ordinary);
            $rand = unserialize($r_1[0]->rand);
        }else{
            $ordinary['shixiao_time']=$rand['shixiao_time']=24;
        }
        //红包类型决定失效时间
        $type = $show;
        $shixiao_time = $type > 1 ? $ordinary['shixiao_time']:$rand['shixiao_time'];
        $dd = date("Y-m-d H:i:s", strtotime($datetime) + $shixiao_time * 3600);


        $sql = "insert into lkt_red_packet_send(store_id,user_id,money,num,remarks,time,detailed,type,expire_date,trade_no) " .
            "values('$store_id','$user_id','$money','$num','$remarks','$datetime','$red','$show','$dd','$trade_no')";
        $packet_send_id = $db->insert($sql, 'last_insert_id');

        return $packet_send_id;
    }

    function putong_redpacket($money,$num){//普通红包
        $total = $money;//总金额
        $min = 0.01;//单个红包最小金额数
        $res = array();
        for ($i=1;$i<$num;$i++) 
        { 
            $res[] = $total;
        }
        $res[] = $total;
        return $res;
    }

    function redpacket($money,$num){//添加红包信息时随机获取每个红包的金额

        $total = $money;//总金额
        $min = 0.01;//单个红包最小金额数
        $res = array();
        for ($i=1;$i<$num;$i++) 
        { 
         $safe_total=($total-($num-$i)*$min)/($num-$i);//随机安全上限 
         $money=mt_rand($min*100,$safe_total*100)/100; 
         $res[] = $money;
         $total=$total-$money; 
        }
        $res[] = $total;
        return $res;
    }


    // 付款后修改订单状态,并修改商品库存-----计算分销
    function up_order($data){
        $file  = 'log.txt';
        file_put_contents($file, '开始修改订单',FILE_APPEND);
        $db = DBAction::getInstance();
        //1.开启事务
        $db->begin();

        //2.数据准备
        $coupon_id = $data['coupon_id']; // 优惠券id
        
        $order_id = $data['sNo']; // 订单号
        $user_id = $data['user_id']; // 微信id
        $z_price = $data['z_price']; // 订单金额
        $trade_no = $data['trade_no']; // 微信支付单号
        $pay = $data['pay'];

        $offset_balance = $data['offset_balance'];

        //支付方式判断combined_pay
        if($offset_balance > 0){
            $total = $z_price+$offset_balance;
            //写入日志
            $sqll = "insert into lkt_combined_pay (weixin_pay,balance_pay,total,order_id,add_time,user_id) values ('$z_price','$offset_balance','$total','$order_id',CURRENT_TIMESTAMP,'$user_id')";
            $rr = $db->insert($sqll);
            if($rr < 1) {
                $db->rollback();
                // echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
                exit;
            }
            // 根据修改支付方式
            $sql_combined = "update lkt_order set pay = 'combined_pay',z_price = '$total' where sNo = '$order_id' and user_id = '$user_id' ";
            file_put_contents($file, 'sql1:'.$sql_combined,FILE_APPEND);

            $r_combined = $db->update($sql_combined);

            if($r_combined < 1) {
                $db->rollback();
                // echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
                exit;
            }
        }


        $sql_u = "update lkt_order set status = 1,pay = '$pay',trade_no='$trade_no',pay_time=CURRENT_TIMESTAMP where sNo = '$order_id' and user_id = '$user_id' ";
        file_put_contents($file, 'sql2:'.$sql_u,FILE_APPEND);

        $r_u = $db->update($sql_u);

        if ($r_u < 1) {
            $db->rollback();
            echo json_encode(array('status' => 0, 'err' => '1修改失败!'));
            exit;
        }

        $sql = "update lkt_coupon set type = 2 where user_id = '$user_id' and id = '$coupon_id'";
        $beres = $db->update($sql);
        // if ($beres < 1) {
        //     $db->rollback();
        //     echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
        //     exit;
        // }
        
        // 根据订单号,修改订单详情状态(未发货)
        $sql_d = "update lkt_order_details set r_status = 1 where r_sNo = '$order_id' ";
        $r_d = $db->update($sql_d);

        // 根据订单号,查询商品id、商品名称、商品数量
        $sql_o = "select p_id,num,p_name,sid from lkt_order_details where r_sNo = '$order_id' ";
        $r_o = $db->select($sql_o);

        foreach ($r_o as $key => $value) {
            $pid = $value->p_id; // 商品id
            $num = $value->num; // 商品数量
            $sid = $value->sid; // 商品属性id
            // 根据商品id,修改商品数量
            $sql_p = "update lkt_configure set  num = num - $num where id = $sid";
            $beres = $db->update($sql_p); 
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
                exit;
            }
            // 根据商品id,修改卖出去的销量
            $sql_x = "update lkt_product_list set volume = volume + $num,num = num-$num where id = $pid";
            $beres = $db->update($sql_x); 
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '2修改失败!'));
                exit;
            }
        }

        $db->commit();

        $sql_id = "select * from lkt_order where sNo = '$order_id' ";
        $r_id = $db->select($sql_id);
        $id = $r_id['0']->id; // 订单id
        $this->store_id = $r_id['0']->store_id;
        $otype = $r_id[0]->otype;//订单类型
        //分销结算 NEW
        $sql = "select * from lkt_distribution_config where store_id = '".$this->store_id."' ";
        $r = $db->select($sql);
        if ($r) {
            $sets = unserialize($r[0]->sets);
            $c_pay = $sets['c_pay'];
            if ($c_pay == 1) {
                //分销
                require_once('Commission.class.php');
                $comm=new Commission();
                $comm->uplevel($db,$this->store_id,$user_id);
                $comm->putcomm($db,$this->store_id,$order_id,$z_price);
                //不是会员赠送商品
                // if($otype != 'vipzs'){
                //     $grade= new Plugin_order($store_id);
                //     $grade->jifen($db,$user_id,$sNo,$store_id,0);
                // }注释，后期有用

            }
        }

    }

    //消费金变现
    public function realization_consumer($db, $consumer_id, $user_id, $from_id, $sNo, $price)
    {
        $store_id = $this->store_id;

        $qsqlc = "select g.transfer_balance from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id where d.store_id = '$store_id' and d.user_id = '$consumer_id' ";
        $qresq = $db->select($qsqlc);
        if ($qresq) {
            $zh_money = $qresq[0]->transfer_balance;
            //消费金变现 查询消费金
            $qsqlu = "select money,consumer_money from lkt_user where store_id = '$store_id' and user_id = '$user_id' ";
            $qresu = $db->select($qsqlu);
            //推荐人的消费金余额
            $consumer_money = $qresu[0]->consumer_money;
            $oldmoney = $qresu[0]->money;

            if ($zh_money) {
                //如果推荐人的消费金余额减去购买人购买返回抵用的消费金大于等于零时
                if ($consumer_money - $zh_money >= 0) {
                    $sql = "update lkt_user set money = money+'$zh_money',consumer_money = consumer_money-'$zh_money' where store_id = '$store_id' and user_id = '$user_id'";
                    $beres = $db->update($sql);
                    //事务
                    if ($beres < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:06', 'sql' => $sql));
                        exit;
                    }

                    $event = $user_id . '抵扣了' . $zh_money . '元消费金2';
                    $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$zh_money','$sNo','0','$event','4',CURRENT_TIMESTAMP)";
                    $beres2 = $db->insert($sqlldr);
                    //事务
                    if ($beres2 < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:07', 'sql' => $sqlldr));
                        exit;
                    }

                    $event = "会员" . $user_id . "消费金解封转入余额" . $zh_money . "元";
                    $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$zh_money','$sNo','0','$event','1',CURRENT_TIMESTAMP)";
                    $beres3 = $db->insert($sqlldr);

                    //事务
                    if ($beres3 < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:07', 'sql' => $sqlldr));
                        exit;
                    }

                } else if ($consumer_money - $zh_money < 0) {
                    if ($consumer_money > 0) {
                        $sql = "update lkt_user set money = money+'$consumer_money',consumer_money = consumer_money-'$consumer_money' where store_id = '$store_id' and user_id = '$user_id'";
                        $beres = $db->update($sql);
                        //事务
                        if ($beres < 1) {
                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '参数错误 code:09', 'sql' => $sql));
                            exit;
                        } else {
                            $event = $user_id . '获得了' . $consumer_money . '元推荐人消费金解封code:10';
                            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$consumer_money','$sNo','0','$event','7',CURRENT_TIMESTAMP)";
                            $beres1 = $db->insert($sqlldr);
                            //事务
                            if ($beres1 < 1) {
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '参数错误 code:11', 'sql' => $sqlldr));
                                exit;
                            }

                            $event = $user_id . '抵扣了' . $consumer_money . '元消费金2';
                            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$consumer_money','$sNo','0','$event','4',CURRENT_TIMESTAMP)";
                            $beres2 = $db->insert($sqlldr);
                            //事务
                            if ($beres2 < 1) {
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '参数错误 code:07', 'sql' => $sqlldr));
                                exit;
                            }
                        }
                    }
                }
                //消费金发放完成
            }
        }
    }

    // 对比等级发放佣金和消费金 *高推低按低  低推高按照本等级*-------------05
    public function contrast_rating($db, $contrast_id, $user_id, $from_id, $sNo, $r_f, $qid, $paixu, $price)
    {
        $store_id = $this->store_id;
        //查找等级比例
        $r_d = $this->find_fenxiao($db, $contrast_id);
        if ($r_d) {
            $cmoneys = [];
            //会员佣金
            $member_proportion_str = $r_d->member_proportion;
            $member_Arr = explode(',', $member_proportion_str);
            if ($member_Arr) {
                foreach ($member_Arr as $ka => $va) {
                    if ($va > 1) {
                        $cmoney = $va;
                    } else {
                        $cmoney = $price * $va;
                    }
                    $cmoneys[$ka] = $cmoney;
                }
            } else {
                $cmoneys[0] = $member_proportion_str;
            }

            

            $cmoney = $cmoneys[0];//佣金
            $shaosje = $cmoneys[0];


            //如果是分销商的话 就设置id
            if ($r_f->level == $qid) {
                $this->find_partner('区域管理佣金', $db, $sNo, $user_id, $user_id, $qid, $cmoney, 0.1);
            }

            $sql = "update lkt_user set money = money+'$cmoney' where store_id = '$store_id' and user_id = '$user_id'";
            $db->update($sql);

            //写日志
            $event = $user_id . '获得了' . $cmoney . '元推荐人佣金--- code:12';
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$cmoney','$cmoney','$event',7)";
            $beres = $db->insert($sqll);
            //事务
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:13'));
                exit;
            }
            //佣金表
            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$cmoney','$sNo','1','$event','1',CURRENT_TIMESTAMP)";
            $beres = $db->insert($sqlldr);
            //事务
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:14'));
                exit;
            }

            $shangji_id2 = $r_f->pid;
            $r_ff = $this->find_fenxiao($db, $shangji_id2);
            if ($r_ff) {
                $sort02 = $r_ff->sort;
                $cmoney_users = '';
                //判断购买人和上级的等级
                if ($sort02 > $paixu) {
                    $cmoney_users = $from_id;
                } else {
                    $cmoney_users = $shangji_id2;
                }
                //推荐人上级佣金发放
                if ($shangji_id2) {
                    $this->contrast_fating($db, $cmoney_users, $shangji_id2, $from_id, $sNo, $r_ff, $qid, $paixu);
                }
            }

        }
    }

    //等级升级
    public function grade_upgrading($db, $distributorid, $user_id, $sNo, $info_user, $order_detail, $qid, $price)
    {
        $store_id = $this->store_id;
        //检查是否该用户是否是分销商
        if ($info_user) {
            $tj_id = $info_user->pid;//推荐人id
            $sets = unserialize($info_user->sets); //反序列化出提成比例数组
            $lt = $info_user->lt;
            $rt = $info_user->rt;
            $uplevel = $info_user->uplevel;// 分销层级
            $num = [$sets['b_yi'], $sets['b_er'], $sets['b_san']];// 三级的比例

            //------------------------------------关键部分------------------------------------

            //送消费金,积分-------02
            
            $integral = $info_user->integral;
            if ($integral > 0) {
                $sql = "update lkt_user set score = score+'$integral' where store_id = '$store_id' and user_id = '$user_id'";
                $beres = $db->update($sql);
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:41', 'sql' => $sql));
                    exit;
                }
                $event = "会员" . $user_id . "充值了" . $integral . "积分";
                //类型 1:转入(收入) 2:提现 3:管理佣金 4:使用消费金 5收入消费金 6 系统扣款 7:充值积分 8使用积分
                $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$user_id','$integral','$sNo','0','$event','8',CURRENT_TIMESTAMP)";
                $beres = $db->insert($sqlldr);
                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:42', 'sql' => $sqlldr));
                    exit;
                }

                $sqll = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$integral','$event',CURRENT_TIMESTAMP,6)";
                $beres = $db->insert($sqll);                              //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:43', 'sql' => $sqll));
                    exit;
                }

            }
        } else {
            //不是分销商
            $db->rollback();
            echo json_encode(array('status' => 0, 'err' => '参数错误 不是分销商 code:47'));
            exit;
        }
        //消费金转余额------------05

    }


    //充值成功金额增加
    public function cz($data,$cmoney,$trade_no){
       
        $db = DBAction::getInstance();
        //开启事务
        $db->begin();

        $user_id = $data['user_id'];
        $store_id = $data['store_id'];

        // 根据微信id,修改用户余额
        $sql = "update lkt_user set money = money+'$cmoney' where store_id = '$store_id' and user_id = '$user_id' ";
        $r = $db->update($sql);

        $event = $user_id.'充值了'.$cmoney.'元';
        $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$cmoney','$cmoney','$event',1)";
        $rr = $db->insert($sqll);

        $msg_title = "充值成功！";
        $msg_content = "您充值的".$cmoney."元已到账，快去购物吧！";

        /**佣金到账通知*/
        $pusher = new LaikePushTools();
        $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,'');

        $db->commit();
        $db->delete("DELETE FROM `lkt_order_data` WHERE (`trade_no`='$trade_no')");

        return $r;
    }
    //会员等级充值
    public function dj($data,$cmoney,$trade_no){
        $db = DBAction::getInstance();
        $log = new LaiKeLogUtils('app/recharge.log');
        $user_id = $data['user_id'];
        $store_id = $data['store_id'];
        $grade_id = $data['grade_id'];//会员等级id
        $method = $data['method'];//充值时长 1-包月 2-包季 3-包年
        $flag = $data['flag'];//等级订单处理标识 1-充值 2-续费 3升级
        $datetime = date("Y-m-d H:i:s");//
        $tui_id = $data['tui_id'];//推荐人id
          //开启事务
        $db->begin();
        $code = true;//事务回滚标识

        //查询用户单前会员结束时间
        $sql_0 ="select grade_end,tui_id from lkt_user where store_id = $store_id and user_id = '$user_id'"; 
        $res_0 = $db->select($sql_0);
        if($res_0){
            $grade_end_last = $res_0[0]->grade_end ? $res_0[0]->grade_end : ''; 
            $have_tui = $res_0[0]->tui_id ? 1 : 0;
        }
        //根据选择充值时长，计算到期时间
        if($flag == 1){//充值
            if($method == 1){//包月
                $grade_end = date("Y-m-d H:i:s",strtotime("+1 months"));
            }else if($method == 2){//包季
                $grade_end = date("Y-m-d H:i:s",strtotime("+3 months"));
            }else if($method == 3){//包年
                $grade_end = date("Y-m-d H:i:s",strtotime("+1 years"));
            }
        }else if($flag == 2){//续费
            if($method == 1){//包月
                $grade_end = date("Y-m-d H:i:s",strtotime("$grade_end_last +1 months"));
            }else if($method == 2){//包季
                $grade_end = date("Y-m-d H:i:s",strtotime("$grade_end_last +3 months"));
            }else if($method == 3){//包年
                $grade_end = date("Y-m-d H:i:s",strtotime("$grade_end_last +1 years"));
            }
        }else if($flag == 3){//升级
            //升级时间不会改变
        }
       
        if($flag == 1){//充值
            if($tui_id && $have_tui == 0){
                $sql_2 = "update lkt_user set grade = $grade_id,grade_add = '$datetime',grade_end = '$grade_end',grade_m = $method,is_box = 1,tui_id = '$tui_id' where store_id = $store_id and user_id = '$user_id' ";
            }else{
                $sql_2 = "update lkt_user set grade = $grade_id,grade_add = '$datetime',grade_end = '$grade_end',grade_m = $method,is_box = 1 where store_id = $store_id and user_id = '$user_id' "; 
            }
        }else if($flag == 2){//续费
            $sql_2 = "update lkt_user set grade = $grade_id,grade_add = '$datetime',grade_end = '$grade_end',grade_m = $method,is_box = 1 where store_id = $store_id and user_id = '$user_id' ";
        }else if($flag == 3){//升级
            $sql_2 = "update lkt_user set grade = $grade_id,grade_add = '$datetime',grade_m = $method,is_box = 1 where store_id = $store_id and user_id = '$user_id' ";
        }

        //会员首次开通，或者升级 记录处理
        $sql1 = "select is_product from lkt_user_rule where store_id = $store_id";
        $res1 = $db->select($sql1);
        if($res1){
            $is_product = $res1[0]->is_product;
        }else{
            $is_product = 0;//0-不开启会员赠送商品 1-开启
        }
        //会员首次开通，或者升级 记录处理
        if($flag != 2){
            //判断用户是否为第一次开通或者升级该会员等级
            $sql_33 = "select id from lkt_user_first where store_id = $store_id and level = '$grade_id' and user_id = '$user_id'";
            $res_33 = $db->select($sql_33);
            if(!$res_33){//未开通过
                //优惠券
                $coupon = new coupon();
                $coupon->Coupons($store_id,$user_id,$grade_id);
                if( $is_product == 1){
                    //商品兑换券
                    $sql_3 = "select valid from lkt_user_rule where store_id = $store_id";
                    $res_3 = $db->select($sql_3);
                    if(!$res_3){//默认七天失效
                        $end_time = date("Y-m-d",strtotime("+ 7 days",time()));
                    }else{
                        $valid = $res_3[0]->valid;
                        $end_time = date("Y-m-d",strtotime("+ $valid days",time()));
                    }

                    //查询出赠送商品的信息入库，并预先减少库存
                    $sql1 = "select pro_id from lkt_user_grade where store_id = $store_id and id = $grade_id";
                    $res1 = $db->select($sql1);
                    if($res1){
                        $pro_id = $res1[0]->pro_id;
                        $sql2 = "select a.id as attr_id,b.id,b.product_title,a.num from lkt_configure as a left join lkt_product_list as b on a.pid = b.id left join lkt_mch as c on b.mch_id = c.id  where b.store_id = '$store_id' and c.store_id = '$store_id' and b.active = 1 and b.status = 2  and a.num > 0 and b.id = '$pro_id' group by b.id ";
                        $res2 = $db->select($sql2);
                        if($res2){
                            $attr_id = $res2[0]->attr_id;
                            $num = $res2[0]->num;
                            if(($num-1) >= 0){//库存足够
                                $sql3 = "update lkt_configure set num = num - 1 where pid = '$pro_id' and id = '$attr_id'";
                                $res3 = $db->update($sql3);
                                if($res3){
                                    $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id,attr_id) values ('$user_id','$grade_id','$grade_id','$end_time','$store_id','$attr_id')";
                                }else{
                                    $log -> customerLog(__LINE__.':更新库存失败，sql为：'.$sql3."\r\n");
                                    $code = false;
                                    $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id) values ('$user_id','$grade_id','$grade_id','$end_time','$store_id')";
                                }
                            }else{//库存不足
                                $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id) values ('$user_id','$grade_id','$grade_id','$end_time','$store_id')";
                                $log -> customerLog(__LINE__.':预减的库存不足'."\r\n");
                            }
                        }else{//库存不足也没有赠送商品
                            $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id) values ('$user_id','$grade_id','$grade_id','$end_time','$store_id')";
                            $log -> customerLog(__LINE__.':库存不足，sql为：'.$sql2."\r\n");
                        }
                    }else{//没有赠送商品
                        $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id) values ('$user_id','$grade_id','$grade_id','$end_time','$store_id')";
                        $log -> customerLog(__LINE__.':没有设置会员赠送商品'."\r\n");
                    }
                    $res_4 = $db->insert($sql_4);
                    if($res_4 < 0){
                        $log -> customerLog(__LINE__.':插入会员兑换券失败，sql为：'.$sql_4."\r\n");
                        $code = false;
                    }
                }
                //会员赠送商品逻辑
            }else{//开通过
              
            }
        }
         
        $res_2 = $db->update($sql_2);
        if($res_2 < 0){
            $log -> customerLog(__LINE__.':开通会员失败，sql为：'.$sql_2."\r\n");
            $code = false;
        }
        //给用户发送消息
        $sql = "select name from lkt_user_grade where store_id = $store_id and id = $grade_id";
        $res = $db->select($sql);
        if($res){
            $name = $res[0]->name;//会员等级名称
        }
         
        if($flag == 1){//充值
            $msg_title = '充值会员成功';
            $msg_content = '您已开通'.$name.'成功，快去享受特权吧';
        }else if($flag == 2){//续费
            $msg_title = '续费会员成功';
            $msg_content = '您已续费'.$name.'成功，快去享受特权吧';
        }else if($flag == 3){//生级
            $msg_title = '升级会员成功';
            $msg_content = '您已升级'.$name.'成功，快去享受特权吧';
        }

        if($code == true){//事务提交
            $db->commit();
            /**会员等级通知*/
            $pusher = new LaikePushTools();
            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,'');
            $db->delete("DELETE FROM `lkt_order_data` WHERE (`trade_no`='$trade_no')");
            
        }else{//事务回滚
            $db->rollback();
            echo json_encode(array('status'=>0,'err'=>'支付失败'));
            exit;
        }

        return 'success';

    }

    //开团

    //修改订单创建,创建开团记录
    public function changeOrder($data,$trade_no)
    {   
        $db = DBAction::getInstance();
        $log = new LaiKeLogUtils('app/group.log');
        
        $ptcode = '';
        //开启事务
        $db->begin();

        $user_id = $data['user_id'];
        $store_id = $data['store_id'];
        $groupman = $data['groupman'];
        $sNo = $data['sNo'];
        $pro_id = $data['p_id'];
        $z_price = $data['z_price']; // 订单金额
        
        $pay = $data['pay'];
        $offset_balance = $data['offset_balance'];

        $creattime = date('Y-m-d H:i:s');
        $grouptime = $db -> select("select group_data,group_level from lkt_group_product where product_id=$pro_id and store_id = '$store_id' and is_delete = 0");

        $group_level = $grouptime[0] -> group_level;
        $grouptime = unserialize($grouptime[0] -> group_data);
        $endtime = $grouptime -> endtime;     
        $time_over = $grouptime -> timehour;
        $time_over = ($time_over * 3600 + time()) > strtotime($endtime)?strtotime($endtime):($time_over * 3600 + time());
        $time_over = date('Y-m-d H:i:s', $time_over);

        $gsNo = 'KT' . substr(time(), 5) . mt_rand(10000, 99999);
        $ptcode = $gsNo;
        //写入日志
        $sqll = "insert into lkt_combined_pay (weixin_pay,balance_pay,total,order_id,add_time,user_id) values ('$z_price','$offset_balance','$z_price','$sNo',CURRENT_TIMESTAMP,'$user_id')";
        $rr = $db->insert($sqll);
        if($rr < 1) {
            $db->rollback();
            exit;
        }

        $creattime = date('Y-m-d H:i:s');
        $sqll = "select group_data,group_level,group_title,activity_no
			from lkt_group_product 
			where product_id=$pro_id and is_delete = 0 and store_id = '$store_id'
			order by case 
            when g_status='2' then 1
            when g_status='3' then 2
            when g_status='1' then 3
			end";
        $grouptime = $db->select($sqll);
        $group_level = $grouptime[0]->group_level;
        $group_data = $grouptime[0]->group_data;
        $activity_no = $grouptime[0]->activity_no;
        $group_title = $grouptime[0]->group_title;

        //查询订单 获取团人数
        $g_sql = "select * from lkt_order where store_id = '$store_id' and sNo = '$sNo'";
        $g_res = $db->select($g_sql);
        $man_num = $g_res[0]->groupman;

        //查询拼团配置
        $sel_group_cfg = "select * from lkt_group_config where store_id = $store_id";
        $group_cfg = $db->select($sel_group_cfg);
        $time_over = $group_cfg[0]->group_time; //最多参团数量
        $time_over = ($time_over * 3600 + time()) > strtotime($endtime) ? strtotime($endtime) : ($time_over * 3600 + time());
        $time_over = date('Y-m-d H:i:s', $time_over);
        $istsql1 = "insert into lkt_group_open(store_id,uid,ptgoods_id,ptcode,ptnumber,groupman,addtime,endtime,ptstatus,group_title,group_level,group_data,activity_no) values('$store_id','$user_id',$pro_id,'$gsNo',1,$man_num,'$creattime','$time_over',1,'$group_title','$group_level','$group_data','$activity_no')";
        $res1 = $db->insert($istsql1);
        $log -> customerLog(__LINE__.':开团！！！！！！！'.$man_num.'，sql为：'.$istsql1."\r\n");

        if ($res1 < 1) {         
            $db->rollback();
            exit;
        }
        
        $sql_o = "update lkt_order set status=9,ptstatus=1,pay='$pay',ptcode='$gsNo',trade_no='$trade_no',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
        $res2 = $db->update($sql_o);
        if ($res2 < 1) {     
            $db->rollback();           
            exit;
        }
    
        $sql_o = "update lkt_order_details set r_status=9 where store_id = '$store_id' and r_sNo = '$sNo'";
        $res3 = $db->update($sql_o);

        //会员积分返现处理
        // $grade= new Plugin_order($store_id);
        // $grade->jifen($db,$user_id,$sNo,$store_id,0);注释，后期有用

        if ($res3 < 1) {
            $db->rollback();           
            exit;
        }
        $db->commit();
    }

    //参团

    //参团订单处理逻辑
    public function changecanOrder($data,$trade_no)
    {   
        $db = DBAction::getInstance();
        $log = new LaiKeLogUtils('app/group.log');
        //开启事务
        $db->begin();

        $user_id = $data['user_id'];
        $store_id = $data['store_id'];
        $groupman = $data['groupman'];
        $sNo = $data['sNo'];
        $pro_id = $data['p_id'];
        $z_price = $data['z_price']; // 订单金额
        
        $pay = $data['pay'];
        $ptcode = $data['ptcode'];
        $offset_balance = $data['offset_balance'];

        $selsql = "select ptnumber,groupman,ptstatus,endtime from lkt_group_open where store_id = '$store_id' and ptcode='$ptcode'";
        $selres = $db->select($selsql);

        $ptnumber = $selres[0]->ptnumber;
        $groupman = $selres[0]->groupman;
        $endtime = strtotime($selres[0]->endtime);
        
        //写入日志
        $sqll = "insert into lkt_combined_pay (weixin_pay,balance_pay,total,order_id,add_time,user_id) values ('$z_price','$offset_balance','$z_price','$sNo',CURRENT_TIMESTAMP,'$user_id')";
        $rr = $db->insert($sqll);
        if($rr < 1) {
            $db->rollback();
            exit;
        }

        if ($endtime >= time()) {

            if (($ptnumber + 1) < $groupman) {     //团人数没满
               $sql_o = "update lkt_order set status=9,ptstatus=1,pay='$pay',trade_no='$trade_no',ptcode='$ptcode',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
                $r = $db->update($sql_o);
                if ($r < 1) {
                    $db->rollback();
                    exit;
                }
                $sql_o = "update lkt_order_details set r_status=9 where store_id = '$store_id' and r_sNo = '$sNo'";
                $r = $db->update($sql_o);
                if ($r < 1) {
                    $db->rollback();
                    exit;
                }
                $updsql = "update lkt_group_open set ptnumber=ptnumber+1 where store_id = '$store_id' and ptcode='$ptcode'";
                $updres = $db->update($updsql);
                if ($updres < 1) {
                    $db->rollback();
                    exit;
                }
            }else if(((int)$ptnumber + 1) == (int)$groupman){
                    $sql_me = "update lkt_order set status=1,ptstatus=2,pay='$pay',trade_no='$trade_no',ptcode='$ptcode',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
                    $me = $db->update($sql_me);
                    if ($me < 1) {
                        $db->rollback();
                        exit;
                    }
                    $sql_o = "update lkt_order set status=1,ptstatus=2,pay='$pay',ptcode='$ptcode',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and ptcode = '$ptcode' and status=9";
                    $r = $db->update($sql_o);
                    if ($r < 1) {
                        $db->rollback();
                        exit;
                    }
                    $gsNosql = "select sNo from lkt_order where store_id = '$store_id' and ptcode = '$ptcode' and status=1";
                    $sNores = $db -> select($gsNosql);
                    $str = '';
                    foreach($sNores as $v){
                        $str .= '"' . $v->sNo . '",';
                    }
                    $str = rtrim($str,",");
                    $sql_d = "update lkt_order_details set r_status=1 where store_id = '$store_id' and r_sNo in($str)";
                    $r = $db->update($sql_d);
                    if ($r < 1) {
                        $db->rollback();
                        exit;
                    }
                    $updsql = "update lkt_group_open set ptnumber=ptnumber+1,ptstatus=2 where store_id = '$store_id' and ptcode='$ptcode'";
                    $updres = $db->update($updsql);
                    if ($updres < 1) {
                        $db->rollback();
                        exit;
                    }
            }else{  //团人数已满，拼团失败
                $sql_o = "update lkt_order set status=1,pay='$pay',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
                $r = $db->update($sql_o);
                if ($r < 1) {
                    $db->rollback();
                    exit;
                }
            }
        }else{     //已过参团期限，拼团失败
                $sql_o = "update lkt_order set status=1,pay='$pay',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
                $r = $db->update($sql_o);
                if ($r < 1) {
                    $db->rollback();
                    exit;
                }
        }
        $log -> customerLog(__LINE__.':拼团！！！！！！！，sql为：'.$sql_o."\r\n");

        //会员积分返现处理
        // $grade= new Plugin_order($store_id);
        // $grade->jifen($db,$user_id,$sNo,$store_id,0);
        
        $db->commit();
        
    }

    public function Send_success($store_id,$arr, $endtime, $template_id, $pro_name)
    {
        $db = DBAction::getInstance();
        
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
            $z_price = $v->z_price . '元';
            $p_price = $v->p_price . '元';
            $minidata = array('keyword1' => array('value' => $pro_name, 'color' => "#173177"), 'keyword2' => array('value' => $z_price, 'color' => "#173177"), 'keyword3' => array('value' => $v->sNo, 'color' => "#173177"), 'keyword4' => array('value' => '拼团成功', 'color' => "#FF4500"), 'keyword5' => array('value' => $p_price, 'color' => "#FF4500"), 'keyword6' => array('value' => $endtime, 'color' => "#173177"));
            $data['data'] = $minidata;

            $data = json_encode($data);
            $da = $this->httpsRequest($url, $data);
            $delsql = "delete from lkt_user_fromid where open_id='$v->uid' and fromid='$v->fromid'";
            $db->delete($delsql);

        }


    }
    
    public function getAccessToken($appID, $appSerect)
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

    public function httpsRequest($url, $data = null)
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
}

?>