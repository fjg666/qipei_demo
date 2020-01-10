<?php
require_once(MO_LIB_DIR .'/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR.'/Tools.class.php');
require_once(MO_LIB_DIR.'/DBAction.class.php');
require_once(MO_LIB_DIR .'/freightAction.class.php');
require_once(MO_LIB_DIR.'/ServerPath.class.php');
/**
 * LKT 插件订单处理类
 * 方法一：JP_setment 竞拍订单确认
 * 方法二：JP_payment 竞拍订单生成
 *
 */
class Plugin_order
{
    function __construct($store_id){
        $this->db = DBAction::getInstance();
        $this->store_id = $store_id;
    }
    /**
     * 竞拍订单确认
     * $store_id    商城id
     * $auction_id  竞拍商品id
     */
    public  function JP_setment($store_id,$auction_id,$user_id,$address_id){
        $db = $this->db;
        $products = Tools::products_JP_list($db,$store_id,$auction_id);//商品数组（pid,cid,num)
        // 查询默认地址
        $address = Tools::find_address($db,$store_id,$user_id,$address_id);
        $addemt = $address ? 1:0; //收货地址状态
        // 3.列出商品数组-计算总价,运费
        $products_data = Tools::get_products_data($db,$store_id,$products,$products_total=0,$product_type = 'JP');
        $product_id = $products_data['product_id'];
        $product_class = $products_data['product_class'];
        $products_freight = $products_data['products_freight'];
        $products = $products_data['products'];
        //计算竞拍商品的价格
        $sql = "select current_price,title,id,imgurl,market_price from lkt_auction_product where store_id = '$store_id' and id = '$auction_id'";
        $res = $db->select($sql);
        $products_total = $res[0]->current_price;
        $a_title = $res[0]->title;
        $a_id = $res[0]->id;
        $market_price = $res[0]->market_price;
        $imgurl = ServerPath::getimgpath($res[0]->imgurl);
        //4.计算运费
        $freight = Tools::get_freight($products_freight,$products, $address,$db,$store_id,$product_type);
        $products = $freight['products'];
        $yunfei = $freight['yunfei'];
        //计算会员特惠
        $grade = $this->user_grade('JP',$products_total,$user_id,$store_id);
        $grade_rate = floatval($grade['rate']);
        //计算竞拍价+运费
        $total = $products_total*$grade_rate + $yunfei; //竞拍商品不支持，优惠券，满减，红包
        return array('status'=>1,'goods_type'=>'JP','products' => $products,'products_total'=>$products_total,'freight' => $yunfei, 'total' => $total, 'address' => $address,'addemt' => $addemt,'a_title'=>$a_title,'a_id'=>$a_id,'market_price'=>$market_price,'imgurl'=>$imgurl,'grade_rate'=>$grade_rate);
    }

     /**
     * 竞拍订单生成
     * $store_id    商城id
     * $auction_id  竞拍活动id
     * $info 生成订单必备字段
     */
    public function JP_payment($store_id,$auction_id,$products,$user_id,$products_total,$yunfei,$info){
        $type ='JP';
        $db = $this->db;
        $log = new LaiKeLogUtils('app/auction.log'); 
        $z_num = 0;
         //判断同一竞拍商品是否重复生成订单
         $sql = "select trade_no from lkt_auction_product where store_id = '$store_id' and id = '$auction_id' and trade_no is not null";
         $res = $db->select($sql);
         if($res){
             echo json_encode(array('status' => 0, 'err' => '您已生成待付款订单，请前往支付！','line'=>__LINE__));
             exit;
         }
         //生成子订单
         $sNo = $this->order_number($type,'sNo'); // 生成订单号
         $real_sno = $this->order_number($type,'real_sno'); // 生成支付订单号
         foreach ($products as $key => $value) {
             $pdata = (object)$value;
             $pid = $value['pid'];
             $cid = $value['cid'];
             $num = $value['num'];
             $freight_price = isset($value['freight_price']) ? $value['freight_price']:0;

             // 循环插入订单附表
             $sql_d = 'insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,unit,r_sNo,add_time,r_status,size,sid,freight) VALUES ' . "('$store_id','$user_id','$pdata->pid','$pdata->product_title','$pdata->price','$pdata->num','$pdata->unit','$sNo',CURRENT_TIMESTAMP,0,'$pdata->size','$pdata->cid','$freight_price')";
             $beres = $db->insert($sql_d,"last_insert_id");
             if ($beres < 0) {
                 $log->customerLog(__LINE__.':插入订单详情表失败，sql为：'.$sql_d."\r\n");
                 $db->rollback();
                 echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!','line'=>__LINE__));
                 exit;
             }
             $z_num += $pdata->num;
             $sql = "update lkt_product_list set num = num - $num where id = '$pid'";
             $res_del1 = $db->update($sql);
             if($res_del1 < 0){
                 $log->customerLog(__LINE__.':更新商品总库存失败，sql为：'.$sql."\r\n");
                 $db->rollback();
                 echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!','line'=>__LINE__));
                 exit;
             }
             $sql = "update lkt_configure set num = num - $num where pid = '$pid' and id = '$cid'";
             $res_del2 = $db->update($sql);
             if($res_del2 < 0){
                 $log->customerLog(__LINE__.':更新规格库存失败，sql为：'.$sql."\r\n");
                 $db->rollback();
                 echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!','line'=>__LINE__));
                 exit;
             }
         }
         //计算会员特惠

         $grade = $this->user_grade('JP',$products_total,$user_id,$store_id);
         $grade_rate = floatval($grade['rate']);
        
         if($type == 'JP'){
             $total = $products_total*$grade_rate +$yunfei;//竞拍商品不支持优惠券
         }

         if ($total < 0){
             //回滚删除已经创建的订单
             $log->customerLog(__LINE__.':订单金额小于0，竞拍活动id为：'.$auction_id."\r\n");
             $db->rollback();
             echo json_encode(array('status' => 0, 'err' => '订单金额有误!'));
             exit;
         }
         if($type == 'JP'){
             $otype = 'JP';
         }
         //如果为竞拍商品则查出对应商铺
         $sql_1 = "select mch_id from lkt_auction_product where store_id = '$store_id' and id = '$auction_id'";
         $res_1 = $db->select($sql_1);
         if($res_1){
            $mch_id = $res_1[0]->mch_id;
            $mch_id = rtrim($mch_id,',');
            $mch_id = ','.$mch_id.',';
         }
         //反序列化插入订单必须的值
         $info = json_decode($info);
         $name = $info->name;
         $mobile = $info->mobile;
         $sheng = $info->sheng;
         $shi = $info->shi;
         $xian = $info->xian;
         $address_xq = $info->address_xq;
         $pay_type = $info->pay_type;
         $coupon_id = $info->coupon_id;
         $allow = $info->allow;
         $store_type = $info->store_type;
         $remarks = $info->remarks;
         // 在订单表里添加一条数据
         $sql_o = 'insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,remark,pay,add_time,status,coupon_id,consumer_money,spz_price,source,otype,mch_id,remarks,real_sno,grade_rate) VALUES ' .
             "('$store_id','$user_id','$name','$mobile','$z_num','$total','$sNo','$sheng','$shi','$xian','$address_xq',' ','$pay_type',CURRENT_TIMESTAMP,0,'$coupon_id','$allow','$products_total','$store_type','$otype','$mch_id','$remarks','$real_sno','$grade_rate')";
         $r_o = $db->insert($sql_o, "last_insert_id");
         if($type == 'JP'){
             $sql_jp = "update lkt_auction_product set trade_no = '$sNo',is_buy = 0 where store_id = '$store_id' and id = '$auction_id' and user_id = '$user_id'";
             $res_jp = $db->update($sql_jp);
         }//如果为竞拍商品，更新竞拍商品动态
         $arr = array('sNo' => $sNo, 'total' => $total,'order_id' => $r_o);
         if($type == 'JP'){
             $arr = array('sNo' => $sNo, 'total' => $total,'order_id' => $r_o,'product_type'=>'JP');
             if($res_jp < 0){
                 $log->customerLog(__LINE__.':更新竞拍商品活动状态失败，sql为：'.$sql_jp."\r\n");
                 $db->rollback();
                 echo json_encode(array('status'=>0,'err'=>'添加竞拍订单失败！'));
                 exit;
             }
         }
         if ($r_o > 0 && $res_jp >= 0) {
             //返回
             $db->commit();
             echo json_encode(array('status' => 1, 'data' => $arr));
             exit;
         }else {
             $log->customerLog('插入订单失败，sql为：'.$sql_o."\r\n");
             //回滚删除已经创建的订单
             $db->rollback();
             echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!','line'=>__LINE__));
             exit;
         }
     }

    /**
     * 会员特惠折扣计算
     * $type    订单类型
     * $product_total 原商品价
     * $store_id 商城id
     */
    public function user_grade ($type,$product_total,$user_id,$store_id){

        $db = $this->db;
        //会员特惠支持商品标识
        $flag = '';
        $log = new LaiKeLogUtils('app/recharge.log');
        //商品
        if($type == 'GM'){//普通
            $flag = 1;
        }else if($type == 'PT'){//拼团
            $flag = 2;
        }else if($type == 'KJ'){//砍价
            $flag = 3;
        }else if($type == 'JP'){//竞拍
            $flag = 4;
        }else if($type == 'FX'){//分销
            $flag = 5;
        }else if($type == 'MS'){//秒杀
            $flag = 6;
        }else if($type == 'TH'){//会员特惠
            $flag = 7;
        }

        $active = array();
        //插叙可支持的特惠商品或活动
        $sql  = "select active from lkt_user_rule where store_id = $store_id ";
        $res = $db->select($sql);
        if($res){
            $active = explode(',',$res[0]->active);//可支持活动数组
        }

        $can = false;//能否支持会员特惠
        if($flag){
            if(in_array($flag,$active)){
                $can = true;
            }else{
                $can = false;
            }

        }else{
            $can = false;
        }

        $now = date("Y-m-d H:i:s");
        if($can == true){//可以使用会员特惠
            $sql_0 = "select grade from lkt_user where store_id = $store_id and user_id = '$user_id' and grade_end > '$now'";
            $res_0 = $db->select($sql_0);
            if($res_0){
                $grade = $res_0[0]->grade ;
                $sql_1 = "select rate from lkt_user_grade where store_id = $store_id and id = $grade";
                $res_1 = $db->select($sql_1);
                if($res_1){
                    $rate =  floatval($res_1[0]->rate);
                }else{
                    $log->customerLog('查询会员级别失败,sql为：'.$sql_1."\r\n");
                    $rate = 10;
                }
            }else{
                $log->customerLog('查询用户的会员等级失败,sql为：'.$sql_0."\r\n");
                $rate = 10;//折扣
            }
            $total = $product_total*$rate;

        }else{//不可以使用会员特惠
            $rate = 10;
            $total = $product_total;
        }
        
        $arr = array();
        $arr['total'] = $total;
        $arr['rate'] = $rate/10;
        //放回打折后商品总价
        return $arr;

    }

     /**
     * 会员生日积分三倍赠送
     * $user_id    用户id
     * $sNo 订单编号
     * $store_id 商城id
     * $type 积分发送规则 0 - 付款后 1 - 确认收货后
     */
    public function jifen($db,$user_id,$sNo,$store_id,$type){
    
        $sql = "select g.is_distribution from lkt_product_list g left join lkt_order_details o on g.id=o.p_id where g.store_id = '$store_id' and o.r_sNo='$sNo' and g.is_distribution=1";
        $count = $db->selectrow($sql);
        if ($count > 0) {
            return;
        }
        $log = new LaiKeLogUtils('app/recharge.log');
        //判断是否是会员生日
        $now = date("m-d"); //单天月日
        $sql = "select birthday from lkt_user where store_id = $store_id and user_id = '$user_id'";
        $res = $db->select($sql);

        //判断该用户是否为会员
        $sql_11 = "select id from lkt_user where store_id = $store_id and user_id = '$user_id' and grade != 0";
        $res_11  = $db->select($sql_11);
        if(!$res_11){//不是会员,则不送积分
            return 9;
        }
        $db->begin();

        //判断积分发送规则
        $sql_00 = "select jifen_m,is_jifen from lkt_user_rule where store_id = $store_id";
        $res_00 = $db->select($sql_00);
        if($res_00){
            $jifen_m = $res_00[0]->jifen_m;
            $is_jifen = $res_00[0]->is_jifen;
            //判断是否满足积分发放规则
            if($jifen_m != $type){//收货后处理
                return 8;
            }
        }else{
            return 7;
        }

        $send_type = $type;//0 - 付款后 1 - 确认收货后
        if($res){
            //返现处理
            $birth = $res[0]->birthday;
            $bir_stmp = strtotime("$birth");//时间戳
            $birthday = date("m-d",$bir_stmp);
            if($now == $birthday){//是会员生日,翻倍发放积分计算
                //判断会员积分翻倍是否开启
                $sql_1 = "select is_birthday,bir_multiple from lkt_user_rule where store_id = $store_id";
                $res_1 = $db->select($sql_1);
                if($res_1){
                    $is_birthday = $res_1[0]->is_birthday;
                    $bir_multiple = $res_1[0]->bir_multiple;
                    if($is_birthday == 1){
                        //根据订单号赠送会员积分
                        $type = substr($sNo,0,2);//获取订单号前两位字母（类型）
                        if($type == 'GM'){//只支持正价商品
                            $sql_2 = "select z_price from lkt_order where store_id = $store_id and sNo = '$sNo'  and zhekou in(0,1) ";
                            $res_2 = $db->select($sql_2);//非分销

                            if(!$res_2){
                                return 1;
                            }
                            $sql_3 = "select b.active from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id where a.store_id = $store_id and b.store_id = $store_id and a.r_sNo = '$sNo' ";
                            $res_3 = $db->select($sql_3);
                            if($res_3){
                                if($res_3[0]->active == 6){
                                    return 2;
                                }
                            }

                            $z_price = $res_2[0]->z_price;
                            //添加积分
                            $m_score = round($z_price*$bir_multiple);
                            if($send_type == 1){
                                $sql_3 = "update lkt_user set score = score + $m_score where store_id = $store_id and user_id = '$user_id'";
                            }else{//付款后 -- 添加冻结积分
                                $sql_3 = "update lkt_user set score = score + $m_score,lock_score = lock_score + $m_score where store_id = $store_id and user_id = '$user_id'";
                            }
                            $res_3 = $db->update($sql_3);
                            if($res_3 < 0){
                                $log->customerLog('修改用户积分失败，sql为：'.$sql_3."\r\n");
                            }
                            //积分记录
                            $event = "会员" . $user_id . "购物获得了" . $m_score . "积分.";
                            if($send_type == 1){
                                $sql_4 = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$m_score','$event',CURRENT_TIMESTAMP,8)";
                            }else{//付款后 -- 添加订单编号
                                $sql_4 = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type,sNo) values ('$store_id','$user_id','$m_score','$event',CURRENT_TIMESTAMP,8,'$sNo')";
                            }
                            $res_4 = $db->insert($sql_4);
                            if($res_4 < 0){
                                $log->customerLog('添加会员购物积分记录失败,sql为：'.$sql_4."\r\n");
                            }
                            //消息推送
                            $msg_title = "尊敬的会员今天您生日，积分为你翻倍!";
                            $msg_content = "特别赠送您".$m_score."积分！";
                            //给用户发送消息
                            $sql_5 = "insert into `lkt_system_message` (`store_id`, `senderid`, `recipientid`, `title`, `content`, `time`) values ('".$store_id."', '', '".$user_id."', '".$msg_title."', '".$msg_content."', CURRENT_TIMESTAMP)";
                            $res_5 = $db->insert($sql_5);
                            if($res_5 < 0){
                                $log->customerLog('系统消息推送失败，sql为：'.$sql_5."\r\n".'res_5为:'.$res_5."\r\n");
                            }
                            //订单表会员积分更新
                            $sql_6 = "update lkt_order set grade_score = $m_score where store_id = $store_id and sNo = '$sNo'";
                            $res_6 = $db->update($sql_6);
                            if($res_6 < 0){
                                $log->customerLog('订单表更新积分失败，sql为：'.$sql_6."\r\n");
                            }

                            if($res_3 < 0 || $res_4 < 0 || $res_5 < 0 || $res_6 < 0){
                                $db->rollback();
                            }

                        }else{
                            return 3;
                        }
                        
                    }else{
                        return 4;
                    }

                }else{
                    return 5;
                }
            }else{//不是会员生日等比例发放积分，任何商品
                //判断等比例积分是否开启
                if($is_jifen != 1){
                    return 12;
                }
                $sql_2 = "select z_price from lkt_order where store_id = $store_id and sNo = '$sNo' ";
                $res_2 = $db->select($sql_2);
                $z_price = $res_2[0]->z_price;
                $z_price = round($z_price);
                //添加积分
                
                if($send_type == 1){
                    $sql_3 = "update lkt_user set score = score + $z_price where store_id = $store_id and user_id = '$user_id'";
                }else{
                    $sql_3 = "update lkt_user set score = score + $z_price,lock_score = lock_score +$z_price where store_id = $store_id and user_id = '$user_id'";
                }
                $res_3 = $db->update($sql_3);
                if($res_3 < 0){
                    $log->customerLog('修改用户积分失败，sql为：'.$sql_3."\r\n");
                }
                //积分记录
                $event = "会员" . $user_id . "购物获得了" . $z_price . "积分.";
                if($send_type == 1){
                    $sql_4 = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$z_price','$event',CURRENT_TIMESTAMP,8)";
                }else{
                    $sql_4 = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type,sNo) values ('$store_id','$user_id','$z_price','$event',CURRENT_TIMESTAMP,8,'$sNo')";
                }
                $res_4 = $db->insert($sql_4);
                if($res_4 < 0){
                    $log->customerLog('添加会员购物积分记录失败,sql为：'.$sql_4."\r\n");
                }
                //消息推送
                $msg_title = "尊敬的会员,恭喜你购买商品成功!";
                $msg_content = "特别赠送您".$z_price."积分！";
                //给用户发送消息
                $sql_5 = "insert into `lkt_system_message` (`store_id`, `senderid`, `recipientid`, `title`, `content`, `time`) values ('".$store_id."', '', '".$user_id."', '".$msg_title."', '".$msg_content."', CURRENT_TIMESTAMP)";
                $res_5 = $db->insert($sql_5);

                if($res_5 < 0){
                    $log->customerLog('系统消息推送失败，sql为：'.$sql_5."\r\n".'res_5为：'.$res_5."\r\n");
                }
                //订单表会员积分更新
                $sql_6 = "update lkt_order set grade_score = $z_price where store_id = $store_id and sNo = '$sNo'";
                $res_6 = $db->update($sql_6);
                if($res_6 < 0){
                    $log->customerLog('订单表更新积分失败，sql为：'.$sql_6."\r\n");
                }
                if($res_3 < 0 || $res_4 < 0 || $res_5 < 0 || $res_6 < 0){
                    $db->rollback();
                }

                
            }

        }else{
            return 7;
        }
    }
    /**
     * 解除冻结积分
     * $user_id    用户id
     * $sNo 订单编号
     * $store_id 商城id
     */
    public function unlock_jifen($db,$user_id,$sNo,$store_id){
        $sql01 = "select sign_score from lkt_sign_record where store_id = $store_id and sNo = '$sNo'";
        $res01 = $db->select($sql01);
        if($res01){
            $log = new LaiKeLogUtils('app/recharge.log');
            $sign_score = $res01[0]->sign_score;
            //更新用户积分
            $sql02 = "update lkt_user set lock_score = lock_score -$sign_score where store_id = $store_id and user_id = '$user_id'";
            $res02 = $db->update($sql02);
            if($res02 < 0){
                $log->customerLog(__LINE__.'解除用户冻结积分失败，sql为：'.$sql02."\r\n");
            }
            //将积分记录置为已收货（sNo存在则为已收货）
            $sql03 = "update lkt_sign_record set sNo = NULL where store_id = $store_id and sNo = '$sNo'";
            $res03 = $db->update($sql03);
            if($res03 < 0){
                $log->customerLog(__LINE__.'更新购物积分状态为已收货失败，sql为：'.$sql02."\r\n");
            }

        }else{
            //
        }
    }
     /**
     * 会员购物返现处理
     * $user_id    用户id
     * $sNo 订单编号
     * $store_id 商城id
     * $type 积分发送规则 0 - 付款后 1 - 收货后
     */
    public function back($db,$user_id,$sNo,$store_id,$type){//所有商品
        $log = new LaiKeLogUtils('app/recharge.log');
        $now = date("Y-m-d H:i:s");
        //会员返现按收货后处理
        if($type != 1){
         return 2;
        }
       
        //是会员且有推荐人
        $sql1 = "select tui_id from lkt_user where store_id = $store_id and grade != 0 and tui_id is not NUll and user_id = '$user_id'";
        $res1 = $db->select($sql1);
        if(!$res1){
            return 1;
        }else{
            $tui_id = $res1[0]->tui_id;
        }

        //是否返现，返现比
        $sql = "select back,back_scale from lkt_user_rule where store_id = $store_id";
        $res = $db->select($sql);
        if($res){
            $back = $res[0]->back;//0-不返现 1-返现
            $back_scale = $res[0]->back_scale;//返现比例
            if($back_scale == '0.00'){
                return ;
            }
        }else{
            return '请配置好会员基础设置';
        }
        if($back == 0){
            return ;
        }
        $back_scale = round($back_scale/100,2);
        //

        //订单总价
        $sql1 = "select z_price from lkt_order where store_id = $store_id and sNo = '$sNo' ";
        $res1 = $db->select($sql1);
        $z_price = $res1[0]->z_price;
        $back_money = round($z_price*$back_scale,2);//返现总金额

        //更新用户余额
        $sql2 = "update lkt_user set money = money + '$back_money' where store_id = $store_id and user_id = '$tui_id'";
        $res2 = $db->update($sql2);
        if($res2 < 0){
            $log->customerLog('更新用户余额失败，sql为：'.$sql2."\r\n");
        }
        //更新记录
        $sql3 = "select money from lkt_user where store_id = $store_id and user_id = '$tui_id'";
        $res3 = $db->select($sql3);
        $oldmoney = $res3[0]->money;

        $sql4 = "insert into lkt_record (store_id,user_id,money,oldmoney,add_date,event,type) values ('$store_id','$tui_id','$back_money','$oldmoney','$now','会员返现',30)";
        $res4 = $db->insert($sql4);
        if($res4 < 0){
            $log->customerLog('插入会员返现记录失败，sql为：'.$sql4."\r\n");
        }
        //订单表更新返现记录
        $sql5 = "update lkt_order set grade_fan = '$back_money' where store_id = $store_id and sNo = '$sNo'";
        $res5 = $db->update($sql5);
        if($res5 < 0){
             $log->customerLog('更新订单返现金额失败，sql为：'.$sql5."\r\n");
        }
        if($res2 < 0 || $res4 < 0 || $res5 < 0){
            $db->rollback();
        }

    }

    // 生成订单号
    private function order_number($type,$text='sNo')
    {
        $db = DBAction::getInstance();
        if($type == 'PT'){
            $pay = 'PT';
        }else if($type == 'HB'){
            $pay = 'HB';
        }else if($type == 'JP'){
            $pay = 'JP';
        }else if($type == 'KJ'){
            $pay = 'KJ';
        }else{
            $pay = 'GM';
        }
        $sNo = $pay.date("ymdhis").rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        $sql = "select * from lkt_order where $text = '$sNo'";
        $res = $db->select($sql);
        if($res){
            $this->order_number($pay,$text);
        }else{
            return $sNo;
        }

    }

}