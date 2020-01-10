<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/wxpayv3/index.php');
require_once(MO_LIB_DIR . '/alipay/return.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Plugin/subtraction.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/Baidu_pay/return.php');

/**
 * [examineAction description]
 * <p>Copyright (c) 2018-2019</p>
 * <p>Company: www.laiketui.com</p>
 * @Author  苏涛
 * @return  [type] 处理退货信息 [description]
 * @version 2.0
 * @date    2018-12-14T15:29:28+0800
 */
class ExamineAction extends Action
{
    public $store_type;

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $this->db = $db;
        $this->store_id = $store_id;

        $id = intval($request->getParameter('id'));
        echo $this->get_order_price($id);
        exit;
    }

    /**
     * 获取订单价格
     * @param $id
     * @return string
     */
    public function get_order_price($id)
    {
        $db = $this->db;
        $store_id = $this->store_id;
        //判断单个商品退款是否有使用优惠
        $sql_id = "select a.id,m.freight,a.trade_no,m.num,a.sNo,a.pay,a.z_price,a.user_id,a.spz_price,m.p_price,a.consumer_money,m.express_id ,m.re_apply_money
                    from lkt_order as a 
                    LEFT JOIN lkt_order_details AS m ON a.sNo = m.r_sNo 
                    where a.store_id = '$store_id' and m.id = '$id' and m.r_status = '4' ";
        $order_res = $db->select($sql_id);
        $re_apply_money = $order_res[0]->re_apply_money;
        $pay = $order_res[0]->pay;
        $num = $order_res[0]->num;
        $p_price = $order_res[0]->p_price * $num;
        $express_id = $order_res[0]->express_id;
        $consumer_money = $order_res[0]->consumer_money;
        $spz_price = $order_res[0]->spz_price;

        //运费
        $freight = $order_res[0]->freight;
        $z_price = $order_res[0]->z_price;

        //判断是否发货
        if ($freight && $express_id) {
            $z_price = $z_price - $freight;
        }

        //计算实际支付金额
        $price = number_format($z_price / $spz_price * $p_price, 2, ".", "");

        if ($price <= 0 && $pay == 'consumer_pay' && $consumer_money > 0) {
            $price = $consumer_money;
        }
        if ($re_apply_money * 100 < $price * 100 && $re_apply_money * 10 / 10 > 0) {
            $price = $re_apply_money;
        }


        return $price;
    }


    /**
     * 退款金额
     * @param $user_id
     * @param $price
     * @return int
     */
    public function return_user_money($user_id, $price)
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $lktlog = new LaiKeLogUtils("common/return.log");

        // 根据商城ID、买家用户ID，查询买家余额
        $sql1 = "select money from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
        $r1 = $db->select($sql1);
        $money = $r1[0]->money;
        // 修改买家用户余额
        $sql2 = "update lkt_user set money = money + '$price' where store_id = '$store_id' and user_id = '$user_id'";
        $res = $db->update($sql2);

        //判断是否添加成功
        if ($res > 0) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改金额成功！");
        } else {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改金额失败！sql:" . $sql2);
        }
        // 添加买家退款日志
        $event = $user_id . '退款' . $price . '元余额';
        $sqll3 = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$price','$money','$event',5)";
        $rr = $db->insert($sqll3);

        if ($rr > 0) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "新增记录成功！");
        } else {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "新增记录失败！sql:" . $sqll3);
        }
        return 1;
    }

    public function execute()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $this->db = $db;
        $this->store_id = $store_id;
        $lktlog = new LaiKeLogUtils("common/return.log");

        //判断是否设置售后地址
        $sql = "select address_xq,name,tel from lkt_service_address where store_id = '$store_id' and uid = 'admin' and is_default=1";
        $r_1 = $db->select($sql);
        if (empty($r_1)) {
            //给出提示设置售后地址
            echo 3;
            exit;
        }

        //开启事务
        $db->begin();

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid;
            // 小程序唯一标识
            $appsecret = $r[0]->appsecret;
            // 小程序的 app secret
            $company = $r[0]->company;
            $mch_key = $r[0]->mch_key; // 商户key
            $mch_id = $r[0]->mch_id; // 商户mch_id
        }
        $user_id = 0;
        $time = date("Y-m-d h:i:s", time());
        $id = intval($request->getParameter('id'));
        // 订单详情id
        $m = intval($request->getParameter('m'));
        // 参数
        $text = trim($request->getParameter('text'));

        $price = trim($request->getParameter('price'));

        /*-----------进入订单详情把未读状态改成已读状态，已读状态的状态不变-------*/
        $sql01 = "select readd,a.id,m.r_sNo,a.p_sNo,a.status,a.real_sno from lkt_order as a ,lkt_order_details AS m where a.store_id = '$store_id' and a.sNo = m.r_sNo and m.id = '$id'";
        $r01 = $db->select($sql01);
        if ($r01[0]->readd == 0) {
            $id01 = $r01[0]->id;
            $sql02 = "update lkt_order set readd = 1 where id = $id01";
            $up = $db->update($sql02);

            if ($up > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改失败！sql:" . $sql02);
            }
        }
        /*--------------------------------------------------------------------------*/

        $sNo = $r01[0]->r_sNo;
        if (intval($r01[0]->status) != 8) {
            $p_sNo = $r01[0]->p_sNo ? $r01[0]->p_sNo : $sNo;
        } else {
            $p_sNo = $sNo;
        }
        $p_sNo = $r01[0]->real_sno;

        //退款模板
        $template_id = 'refund_res';

        $res = 1;

        if ($m == 1 || $m == 4 || $m == 9) {
            $sql = "update lkt_order_details set r_type = '$m',real_money = '$price' where id = '$id'";
            $res = $db->update($sql);

            if ($res > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单详情成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单详情失败！sql:" . $sql);
            }
            if ($m == 9 || $m == 4) {
                $sql_id = "select a.baiduId,a.orderId,a.offset_balance,m.id as oid,a.id,a.trade_no,m.num,a.sNo,a.pay,a.z_price,a.user_id,a.coupon_id,a.allow,a.spz_price,a.reduce_price,a.coupon_price,a.coupon_id,a.subtraction_id,a.p_sNo,m.p_price,a.consumer_money,a.mch_id,m.express_id,m.freight,a.real_sno,m.re_apply_money 
                            from lkt_order as a 
                            LEFT JOIN lkt_order_details AS m ON a.sNo = m.r_sNo 
                            where a.store_id = '$store_id' and m.id = '$id' and m.r_status = '4' ";
                $order_res = $db->select($sql_id);
                if ($order_res) {
                    $pay = $order_res[0]->pay;
                    $user_id = $order_res[0]->user_id;
                    $coupon_id = $order_res[0]->coupon_id;
                    $subtraction_id = $order_res[0]->subtraction_id; // 满减活动ID
                    $consumer_money = $order_res[0]->consumer_money;
                    $express_id = $order_res[0]->express_id;
                    $freight = $order_res[0]->freight;
                    $o_d_id = $order_res[0]->oid;
                    $offset_balance = $order_res[0]->offset_balance;
                    $p_sNo = $order_res[0]->real_sno; // 支付订单号
                    $orderId = $order_res[0]->orderId; // 支付平台单号
                    $baiduId = $order_res[0]->baiduId; // 百度用户id
                    $mch_id = $order_res[0]->mch_id;
                    $t1t = true;
                    $z_price = $order_res[0]->z_price;

                    $w_pay = $z_price - $offset_balance;
                    $re_apply_money = $order_res[0]->re_apply_money; // 用户填写退款金额
                    $spz_price = $order_res[0]->spz_price; // 商品总价
                    $p_price = $order_res[0]->p_price * $order_res[0]->num; // 该商品总价
                    //填写金额
                    if (empty($price)) {
                        $price = $this->get_order_price($o_d_id);
                    }

                    //组合支付
                    if ($offset_balance > 0) {
                        $return_user_money = number_format($offset_balance / $z_price * $price, 2, ".", "");
                        $t1t = false;
                        $price = number_format(($price - $return_user_money) / $z_price * $price, 2, ".", "");
                    }

                    $appid = '';
                    $pay_config = Tools::get_pay_config($db, $pay);
                    if ($pay_config) {
                        $appid = $pay_config->appid;
                    } else {
                        $mch_id = '';
                    }

                    if($pay == 'tt_alipay'){
                        $pay = 'aliPay';
                    }

                    if ($pay == 'baidu_pay') {
                        $pay = 'wallet_pay';
                    }
                    //不同支付方式判断
                    switch ($pay) {
                        case 'wallet_pay' :
                            //钱包
                            if ($t1t) {
                                $res = $this->return_user_money($user_id, $price, $sNo);
                            }
                            break;
                        case 'aliPay' :
                            //支付宝手机支付
                            $zfb_res = Alipay::refund($p_sNo, $price, $appid, $store_id, $pay,$id);
                            if ($zfb_res != 'success') {
                                $db->rollback();
                                echo 0;
                                exit;
                            }
                            break;
                        case 'alipay' :
                            //支付宝手机支付
                            $zfb_res = Alipay::refund($p_sNo, $price, $appid, $store_id, $pay,$id);
                            if ($zfb_res != 'success') {
                                $db->rollback();
                                echo 0;
                                exit;
                            }
                            break;
                        case 'alipay_minipay' :
                            // 支付宝小程序退款
                            $zfb_res = Alipay::refund($p_sNo, $price, $appid, $store_id, "alipay_minipay",$id);
                            if ($zfb_res != 'success') {
                                $db->rollback();
                                echo 0;
                                exit;
                            }
                            break;
                        case 'wap_unionpay' :
                            // 中国银联手机支付

                            break;
                        case 'app_wechat' :
                            //微信APP支付.
                            $wxtk_res = wxpay::wxrefundapi($p_sNo, $p_sNo . $o_d_id, $price, $w_pay, $store_id, $pay);
                            if ($wxtk_res['result_code'] != 'SUCCESS') {
                                $db->rollback();
                                if ($wxtk_res['err_code_des'] == '基本账户余额不足，请充值后重新发起') {
                                    echo 2;
                                }
                                exit;
                            }
                            break;
                        case 'mini_wechat' :
                            //微信小程序支付
                            $wxtk_res = wxpay::wxrefundapi($p_sNo, $p_sNo . $o_d_id, $price, $w_pay, $store_id, $pay);
                            if ($wxtk_res['result_code'] != 'SUCCESS') {
                                $db->rollback();
                                if ($wxtk_res['err_code_des'] == '基本账户余额不足，请充值后重新发起') {
                                    echo 2;
                                }
                                exit;
                            }
                            break;
                        case 'jsapi_wechat' :
                            //微信小程序支付
                            $wxtk_res = wxpay::wxrefundapi($p_sNo, $p_sNo . $o_d_id, $price, $w_pay, $store_id, $pay);
                            if ($wxtk_res['result_code'] != 'SUCCESS') {
                                $db->rollback();
                                if ($wxtk_res['err_code_des'] == '基本账户余额不足，请充值后重新发起') {
                                    echo 2;
                                }
                                exit;
                            }
                            break;
                        case 'baidu_pay' :
                            //百度支付
                            // $res = Baidupay::refund($orderId,$baiduId,$p_sNo, $price, $appid, $store_id, $pay);
                            // if ($res != 'success') {
                            //     $db->rollback();
                            //     echo 0;
                            //     exit;
                            // }
                            // break;
                        default:
                            echo $pay . '支付方式不存在！';
                            exit;
                    }

                    //组合支付余额退款
                    if ($offset_balance > 0) {
                        $res = $this->return_user_money($user_id, $return_user_money);
                    }

                    $should_price = number_format($z_price / $spz_price * $p_price, 2, ".", "");
                    if ($should_price > $price) { // 当应退款金额 大于 店家输入的金额
                        $s_money = $should_price - $price; // 剩余未退款金额
                        // 根据商城ID、店铺ID，查询店铺余额
                        $sql4 = "select user_id,account_money from lkt_mch where store_id = '$store_id' and id = '$mch_id'";
                        $r4 = $db->select($sql4);
                        $account_money = $r4[0]->account_money + $s_money; // 店铺余额+剩余未退款金额

                        // 修改店铺金额
                        $sql5 = "update lkt_mch set account_money = '$account_money' where store_id = '$store_id' and id = '$mch_id'";
                        $r5 = $db->update($sql5);
                        if ($r5 > 0) {
                            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改店铺金额成功！");
                        } else {
                            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改店铺金额失败！sql:" . $sql5);
                        }
                        // 添加一条退款记录
                        $sql6 = "insert into lkt_mch_account_log (store_id,mch_id,price,account_money,status,type,addtime) values ('$store_id','$mch_id','$s_money','$account_money',1,2,CURRENT_TIMESTAMP)";
                        $r6 = $db->insert($sql6);
                        if ($r6 > 0) {
                            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "新增退款记录成功！");
                        } else {
                            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "新增退款记录失败！sql:" . $sql6);
                        }
                    }

                    // 根据订单号,查询商品id、商品名称、商品数量
                    $sql_o = "select p_id,num,p_name,sid from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' ";
                    $r_o = $db->select($sql_o);
                    //退款后还原商品数量
                    foreach ($r_o as $key => $value) {
                        $pname = $value->p_name;
                        $pid = $value->p_id;
                        // 商品id
                        $num = $value->num;
                        // 商品数量
                        $sid = $value->sid;
                        // 根据商品id,修改商品数量
                        $sql_p = "update lkt_configure set  num = num + $num where id = $sid";
                        $r_p = $db->update($sql_p);
                        if ($r_p > 0) {
                            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改商品数量成功！");
                        } else {
                            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改商品数量失败！sql:" . $sql_p);
                        }
                        // 根据商品id,修改卖出去的销量
                        $sql_x = "update lkt_product_list set num = num+$num where store_id = '$store_id' and id = $pid";
                        $r_x = $db->update($sql_x);
                        if ($r_x > 0) {
                            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改商品销量成功！");
                        } else {
                            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改商品销量失败！sql:" . $sql_x);
                        }
                        if ($r_x < 1 || $r_p < 1) {
                            $db->rollback();
                            echo 0;
                            exit;
                        }
                        //判断是否有积分需要扣除
                        $sql01 = "select sign_score from lkt_sign_record where store_id = $store_id and sNo = '$sNo'";
                        $res01 = $db->select($sql01);
                        if ($res01) {
                            $log = new LaiKeLogUtils('app/recharge.log');
                            $sign_score = $res01[0]->sign_score;
                            $sql02 = "update lkt_user set score = score - $sign_score ,lock_score = lock_score -$sign_score where store_id = $store_id and user_id = '$user_id'";
                            $res02 = $db->update($sql02);
                            if ($res02 > 0) {
                                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改用户积分成功！");
                            } else {
                                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改用户积分失败！sql:" . $sql02);
                            }
                            if ($res02 < 0) {
                                $log->customerLog('扣除用户积分失败，sql为：' . $sql02 . "\r\n");
                            }
                            $sql03 = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$sign_score','$event',CURRENT_TIMESTAMP,5)";
                            $res03 = $db->insert($sql03);
                            if ($res03 < 0) {
                                $log->customerLog('添加用户扣除积分失败，sql为：' . $sql03 . "\r\n");
                                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加用户扣除积分失败！sql:" . $sql03);
                            }else{
                                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加用户扣除积分成功！");
                            }

                            if ($res02 < 0 || $res03 < 0) {
                                $db->rollback();
                                echo json_encode(array('code' => 109, 'errmsg' => '扣除用户积分失败'));
                                exit;
                            }
                        }

                        $keyword1 = array('value' => $sNo, "color" => "#173177");
                        $keyword2 = array('value' => $pname, "color" => "#173177");
                        $keyword3 = array('value' => $time, "color" => "#173177");
                        $keyword4 = array('value' => '退款成功', "color" => "#173177");
                        $keyword5 = array('value' => $price . '元', "color" => "#173177");
                        $keyword6 = array('value' => '预计24小时内到账', "color" => "#173177");
                        $keyword7 = array('value' => '原支付方式', "color" => "#173177");
                        //拼成规定的格式
                        $o_data = array('keyword1' => $keyword1, 'keyword2' => $keyword2, 'keyword3' => $keyword3, 'keyword4' => $keyword4, 'keyword5' => $keyword5, 'keyword6' => $keyword6, 'keyword7' => $keyword7);
                        //发信息
                        $Tools = new Tools($db, $store_id, '');
                        $data = array();
                        $data['page'] = 'pages/index/index';
                        $data['template_id'] = $template_id;
                        $data['openid'] = Tools::get_openid($db, $store_id, $user_id);
                        $data['o_data'] = $o_data;
                        $tres = $Tools->send_notice($data, 'wx');

                    }

                    //修改订单状态为关闭
                    $sql = "update lkt_order_details set r_status = '6' where store_id = '$store_id' and id = '$id'";
                    $res1 = $db->update($sql);
                    if ($res1 > 0) {
                        $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单成功！");
                    } else {
                        $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单失败！sql:" . $sql);
                    }

                    $sql_o = "select id,r_status from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                    $res_o = $db->select($sql_o);
                    if (!empty($res_o)) {
                        $v_status = '';
                        $status_identical = true;
                        foreach ($res_o as $k2 => $v2) {
                            if ($v_status == '') {
                                $v_status = $v2->r_status;
                            } else {
                                if ($v_status != $v2->r_status) {
                                    $status_identical = false;
                                } else {
                                }
                            }
                        }

                        // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                        if ($status_identical) {
                            $ss = $res_o[0]->r_status;
                            $sql_u = "update lkt_order set status = '$ss' where store_id = '$store_id' and sNo = '$sNo' ";
                            $r_u = $db->update($sql_u);
                            if ($r_u > 0) {
                                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单状态成功！");
                            } else {
                                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单状态失败！sql:" . $sql_u);
                            }
                        } else {
//                            $sql_u = "update lkt_order set status = '6' where store_id = '$store_id' and sNo = '$sNo' ";
//                            $r_u = $db->update($sql_u);
                        }

                    } else {

                    }


                    if ($coupon_id != 0) {
                        $time = date("Y-m-d H:i:s");
                        $sql0 = "select expiry_time from lkt_coupon where store_id = '$store_id' and id = '$coupon_id'";
                        $r0 = $db->select($sql0);
                        if ($r0) {
                            $expiry_time = $r0[0]->expiry_time;
                            if ($expiry_time < $time) {
                                $sql1 = "update lkt_coupon set type = 3 where store_id = '$store_id' and id = '$coupon_id'";
                            } else {
                                $sql1 = "update lkt_coupon set type = 0 where store_id = '$store_id' and id = '$coupon_id'";
                            }
                            $res_1 = $db->update($sql1);
                            if ($res_1 > 0) {
                                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改优惠卷状态成功！");
                            } else {
                                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改优惠卷状态失败！sql:" . $sql1);
                            }
                        }
                    }
                    if ($subtraction_id != 0) {
                        // 满减--插件
                        $auto_jian = new subtraction();
                        $auto = $auto_jian->give_num($db, $store_id, $sNo);
                        if ($auto != 1) {
                            $db->rollback();
                            echo 0;
                            exit;
                        }
                    }
                    $res = 1;

                } else {
                    $res = 0;

                }


            }

        } else if ($m == 11) {

            //售后店家寄回商品
            $id = intval($request->getParameter('sNo'));//详情订单id
            $express = intval($request->getParameter('express'));//快递公司编号
            $courier_num = $request->getParameter('courier_num');//快递单号

            //快递添加一条数据
            $sel_user_info = "SELECT o.user_id,o.name,o.mobile
                                FROM lkt_order_details as od
                                LEFT JOIN lkt_order as o on o.sNo = od.r_sNo
                                where od.id = $id and od.store_id = $store_id";
            $user_info = $db->select($sel_user_info);
            $lxr = $user_info[0]->name;
            $lxdh = $user_info[0]->mobile;
            $userid = $user_info[0]->user_id;

            //查询快递名称
            $sel_express = "SELECT * FROM `lkt_express` WHERE id = $express";
            $express_res = $db->select($sel_express);
            $kdname = $express_res[0]->kuaidi_name;

            $sql = "insert into lkt_return_goods(store_id,name,tel,express,express_num,user_id,oid,add_data) 
                    values('$store_id','$lxr','$lxdh','$kdname','$courier_num','$userid','$id',CURRENT_TIMESTAMP)";
            $rid = $db->insert($sql, 'last_insert_id');
            if ($rid > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "新增售后记录成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "新增售后记录失败！sql:" . $sql);
            }
            $up_order_d_sql = "update lkt_order_details set express_id='$express',courier_num='$courier_num',r_type = 11,r_status = 4 where store_id = '$store_id' and id = $id";
            $res = $db->update($up_order_d_sql);
            if ($res > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "订单物流信息成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "订单物流信息失败！sql:" . $up_order_d_sql);
            }
            if ($res && $rid) {
                //执行成功
                $db->commit();
                echo json_encode(array('succ' => '发货成功！', 'status' => 1));
                exit;
                exit();
            } else {
                //执行失败
                $db->rollback();
                echo json_encode(array('err' => '发货失败！', 'status' => 0));
                exit;
                exit();

            }
        } else {
            $sql_id = "select a.id,a.trade_no,a.sNo,a.pay,a.z_price,a.user_id,a.source 
            from lkt_order as a 
            LEFT JOIN lkt_order_details AS m ON a.sNo = m.r_sNo 
            where a.store_id = '$store_id' and m.id = '$id' and m.r_status = '4' ";
            $order_res = $db->select($sql_id);
            $sNo = $order_res[0]->sNo;
            $z_price = $order_res[0]->z_price;
            $user_id = $order_res[0]->user_id;

            //查询出最新的一条售后记录
            $sel_record_sql = "select id from lkt_return_record where store_id = '$store_id' and p_id = '$id' order by id desc";
            $record_res = $db->select($sel_record_sql);
            $record_id = $record_res[0]->id;
            //编辑 售后记录 lkt_return_record
            $up_record_sql = "update lkt_return_record set r_type = '$m',content = '$text' where store_id = '$store_id' and p_id = '$id' and id = '$record_id' ";
            $up_record_res = $db->update($up_record_sql);
            if ($up_record_res > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改售后记录数据成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改售后记录数据失败！sql:" . $up_record_sql);
            }
            //  判断订单来源
            if ($order_res[0]->source == 1) {

                $keyword1 = array('value' => $sNo, "color" => "#173177");
                $keyword2 = array('value' => $company, "color" => "#173177");
                $keyword3 = array('value' => $time, "color" => "#173177");
                $keyword4 = array('value' => '退款失败', "color" => "#173177");
                $keyword5 = array('value' => $z_price . '元', "color" => "#173177");
                $keyword6 = array('value' => $text, "color" => "#173177");
                $keyword7 = array('value' => '系统已还原订单状态', "color" => "#173177");
                //拼成规定的格式
                $o_data = array('keyword1' => $keyword1, 'keyword2' => $keyword2, 'keyword3' => $keyword3, 'keyword4' => $keyword4, 'keyword5' => $keyword5, 'keyword6' => $keyword6, 'keyword7' => $keyword7);

                //发信息
                $Tools = new Tools($db, $store_id, $this->store_type);
                $data = [];
                $data['page'] = 'pages/index/index';
                $data['template_id'] = $template_id;
                $data['openid'] = Tools::get_openid($db, $store_id, $user_id);
                $data['o_data'] = $o_data;
                $tres = $Tools->send_notice($data, 'wx');
            } else {

                // $sql = "insert into lkt_system_message(store_id,senderid,recipientid,title,content,time)values('$store_id','1','$user_id','退款拒绝通知','$text',CURRENT_TIMESTAMP)";
                // $res = $db->insert($sql);

            }

            $text = htmlentities($request->getParameter('text'));
            // //回退订单状态

            //查询出最新的一条售后记录
            $sel_record_sql = "select id from lkt_return_record where store_id = '$store_id' and p_id = '$id' order by id desc";
            $record_res = $db->select($sel_record_sql);
            $record_id = $record_res[0]->id;
            //编辑 售后记录 lkt_return_record
            $up_record_sql = "update lkt_return_record set r_type = '$m',content = '$text' where store_id = '$store_id' and p_id = '$id' and id = '$record_id' ";
            $up_record_res = $db->update($up_record_sql);
            if ($up_record_res > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改售后记录数据成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改售后记录数据失败！sql:" . $up_record_sql);
            }
            // 根据订单号,修改订单详情状态------------还原子订单状态
            $sql_d = "update lkt_order_details set r_type = '$m',r_content = '$text' where store_id = '$store_id' and id = '$id' ";

            $res = $db->update($sql_d);
            if ($res > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "还原订单成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "还原订单失败！sql:" . $sql_d);
            }
        }

        if ($res) {

            if (!empty($text)) {
                $msg_title = "退货/退款失败！";
                $msg_content = "您的申请被驳回！驳回原因：" . $text;
                $sel_d_o = "select * from lkt_order_details where id = $id";
                $d_o_Res = $db->select($sel_d_o);
                $r_sNo = $d_o_Res[0]->r_sNo;


                //改回订单状态
                $sel_sql = "select * from lkt_record where store_id = $store_id and event like '%$r_sNo%' order by id desc";
                $old_o = $db->select($sel_sql);
                $old_event = $old_o[0]->event;
                $_status = json_decode($old_event);
                $status = $_status->r_status;
                $sql_d = "update lkt_order_details set r_status = '$status'where store_id = '$store_id' and r_sNo = '$r_sNo' and id = $id ";
                $res = $db->update($sql_d);
                if ($res > 0) {
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单详情成功！");
                } else {
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单详情失败！sql:" . $sql_d);
                }
                //售后需要改动
                $sql_dd = "update lkt_order set status = '$status' where store_id = '$store_id' and sNo = '$r_sNo' ";
                $ress = $db->update($sql_dd);
                if ($ress > 0) {
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单成功！");
                } else {
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单失败！sql:" . $sql_dd);
                }
            } else {
                $msg_title = "退货/退款成功！";
                $msg_content = "您的退货/退款申请已通过！";
            }

            /**退货/退款通知 /GETUI/LaikePushTools.class.php */
            $pusher = new LaikePushTools();
            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content, $store_id, $admin_name);

            $db->admin_record($store_id, $admin_name, ' 批准订单详情id为 ' . $id . ' 退货 ', 9);
            $db->commit();
            echo 1;
        } else {
            $db->admin_record($store_id, $admin_name, ' 批准订单详情id为 ' . $id . ' 退货失败 ', 9);
            $db->rollback();
            echo 0;
        }

        exit;

    }

    public function getRequestMethods()
    {
        return Request::POST;
    }

}

?>