<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/wxpayv3/index.php');
require_once(MO_LIB_DIR . '/alipay/test.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');
require_once(MO_LIB_DIR . '/lktpay/ttpay/TTUtils.php');
require_once(MO_LIB_DIR . '/Commission.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/LKTConfigInfo.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/Plugin_order.class.php');
require_once(MO_LIB_DIR . '/Baidu_pay/NuomiRsaSign.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 *
 * [wallet_pay description]
 * <p>Copyright (c) 2018-2019</p>
 * <p>Company: www.laiketui.com</p>
 * @Author  苏涛
 * @version 2.0
 * @date    2019-01-18T22:22:09+0800
 * @return  调起支付
 */
class payAction extends Action
{

    public $appid;
    public $mch_id;
    public $appsecret;
    public $ip = '120.76.189.152';
    public $mch_key;

    public function getDefaultView()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');

        $this->execute();
        exit;
        return;
    }

    public function execute()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id')); // 商城ID
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $type = addslashes(trim($request->getParameter('type')));
        LaiKeLogUtils::lktLog("支付类型：".$type);
        $title = addslashes(trim($request->getParameter('title')));
        $remarks = addslashes(trim($request->getParameter('remarks')));//订单备注
        $grade_l = addslashes($request->getParameter('grade_l'));//会员特惠 兑换券级别

        $order_list = addslashes(trim($request->getParameter('order_list')));
        $order_list = htmlspecialchars_decode($order_list);
        $order_list = json_decode($order_list,true);
        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                echo json_encode(array('code' => 230, 'message' => '请登录！'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 230, 'message' => '请登录！'));
            exit;
        }

        //m指向具体操作方法
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))) : 'getDefaultView';

        $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if ($r) {
            $this->db = $db;
            $this->user = $r[0];
            $this->store_id = $store_id;
            $this->order_list = $order_list;
            if(!empty($order_list)) {
                $sNo = $order_list['sNo'];
            }else{
                $sNo = addslashes(trim($request->getParameter('sNo'))); // 订单sNo
            }
            //付款金额
            $payment_money = trim($request->getParameter('total')); // 余额抵扣金额
            $payment_money = $payment_money ? $payment_money : trim($request->getParameter('payment_money'));
           
            if ($payment_money && !$grade_l) {
                if (!is_numeric($payment_money) || $payment_money < 0) {
                    echo json_encode(array('code' => 0, 'message' => '金额错误!'));
                    exit;
                }
            }
           
            if ($type) {
                $type2 = $type;
                if ($type == 'H5_wechat') {
                    $type2 = 'app_wechat';
                } else if($type == 'alipay_mobile' || $type == 'alipay_minipay'
                    || $type == 'aliPay' || $type == 'tt_alipay'){
                    $type2 = 'alipay';
                }

                $sql2 = "select config_data from lkt_payment as p left join lkt_payment_config as c on c.pid = p.id where c.status = 1  and p.status = 0 and p.class_name = '$type2' and  c.store_id = '$store_id' ";
                $res2 = $db->select($sql2);

                $sNo_type = substr($sNo,0,2); //订单类型
                if (($sNo_type != 'AC') && ($sNo_type != 'CZ') && ($sNo_type != 'DJ')) {
                    $real_sno = Tools::order_number($sNo_type);
                    $up_orderType_Sql = "update lkt_order set pay='$type',real_sno='$real_sno',remarks = '$remarks' where store_id = '$store_id' and sNo = '$sNo'";
                    $up_orderType_Res = $db->update($up_orderType_Sql);
                }else{
                    $real_sno = $sNo;

                }
                if ($res2) {
                    $total = 1000000;
                    $order_types = substr($sNo, 0, 2);
                    $this->order_types = $order_types;
                    $this->sNo = $sNo;
                    if ($sNo) {
                        switch ($order_types) {
                            case 'CZ'://余额充值 和 会员等级充值
                                // $sNo = Tools::order_number($order_types);
                                $this->sNo = $sNo;
                                $total = $payment_money;
                                $array = array('order_id' => $sNo, 'user_id' => $this->user->user_id, 'trade_no' => $real_sno, 'pay' => $type, 'total' => $total, 'store_id' => $store_id);
                                $data = serialize($array);
                                $sql = "insert into lkt_order_data(trade_no,data,addtime) values('$sNo','$data',CURRENT_TIMESTAMP)"; 
                                $rid = $db->insert($sql);
                                break;
                            case 'DJ':
                                $total = $payment_money;
                                break;    
                            case 'PT':

                                $total = $payment_money;
                                # code...
                                break;
                            case 'HB':
                                echo json_encode(array('code' => 0, 'message' => '支付方式未设置!'));
                                exit;
                                # code...
                                break;
                            case 'JP'://竞拍订单
                                $total = $payment_money;
                                break;
                            case 'AC'://竞拍押金
                                $total = $payment_money;
                                break;
                            case 'MS'://秒杀订单

                                $total = $payment_money;
                                break;
                            default:
                                $total = $payment_money;
                                break;

                        }
                    } else {
                        echo json_encode(array('code' => 0, 'message' => '缺少订单编号！'));
                        exit;
                    }

                    //查找支付方式数据
                    $this->config_data = json_decode($res2[0]->config_data);

                    //具体执行支付方式
                    $this->$type($total,$title,$real_sno,$type);
                } else {
                    if ($type == 'wallet_pay') {



                        $sNo = addslashes(trim($request->getParameter('sNo'))); // 订单sNo
                        if(empty($sNo)){//若没有订单号，则去订单列表订单号
                            $sNo = $order_list['sNo'];
                        }

                        $order_types = substr($sNo, 0, 2);


                        $this->order_types = $order_types;
                        $this->$type($payment_money,$title);

                    } else {
                        echo json_encode(array('code' => 0, 'message' => '支付方式参数未设置!'));
                        exit;
                    }
                }
            } else {
                echo json_encode(array('code' => 0, 'message' => '未开通的支付方式!'));
                exit;
            }
        } else {
            echo json_encode(array('status' => false, 'err' => '缺少重要参数！'));
            exit;
        }
    }

    // 付款成功
    public function gndd($db, $store_id, $payment_money, $sNo, $user_id)
    {
        $sql = "select * from lkt_order where store_id = '$store_id' and sNo = '$sNo' and user_id = '$user_id'";
        $r2 = $db->select($sql);
        if ($r2) {
            $coupon_id = $r2[0]->coupon_id;
            $z_price = $r2[0]->z_price;
            $spz_price = $r2[0]->spz_price;
            $self_lifting = $r2[0]->self_lifting;
            $otype = $r2[0]->otype;//订单类型
        } else {
            $db->rollback();
            echo json_encode(array('code' => 0, 'message' => '参数错误'));
            exit;
        }
        if ($z_price == $payment_money) {
             //不是会员赠送商品
            // if($otype != 'vipzs'){
            //     $grade= new Plugin_order($store_id);
            //     $grade->jifen($db,$user_id,$sNo,$store_id,0);
            // }注释，后期有用
            $sql_oo = '';
            if($self_lifting == '1'){
                $sql_oo = "update lkt_order set z_price=offset_balance+$z_price,status=2,pay='wallet_pay',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";

                $r = $db->update($sql_oo);
            }else{
                $sql_oo = "update lkt_order set z_price = offset_balance + $z_price , status = 1 , pay = 'wallet_pay' , pay_time = CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
                $r = $db->update($sql_oo);
            }
            $sql_s = "SELECT spz_price,mch_id FROM `lkt_order` WHERE store_id = '$store_id' and sNo = '$sNo'";
            $s_res = $db->select($sql_s);
            $mch_id = $s_res[0]->mch_id;
            if($s_res[0]->spz_price > $payment_money){
                $sql_o1 = "update lkt_order set offset_balance=$payment_money + offset_balance where store_id = '$store_id' and sNo = '$sNo'";
                $o1 = $db->update($sql_o1);
            }


            if ($r < 1) {
                //回滚删除已经创建的订单
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                $db->rollback();
                exit;
            }

            if($self_lifting == '1'){
                $sql_o = "update lkt_order_details set r_status=2 where store_id = '$store_id' and r_sNo = '$sNo'";
            }else{
                $sql_o = "update lkt_order_details set r_status=1 where store_id = '$store_id' and r_sNo = '$sNo'";
            }
            $r = $db->update($sql_o);
            if ($r < 1) {
                //回滚删除已经创建的订单
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }
            if ($coupon_id) {
                $sql = "update lkt_coupon set type = 2 where store_id = '$store_id' and id = '$coupon_id'";
                $db->update($sql);
                if ($r < 1) {
                    //回滚删除已经创建的订单
                    $db->rollback();
                    echo json_encode(array('code' => 0, 'err' => '优惠券修改失败!'));
                    exit;
                }
            }

            $sql = "select * from lkt_distribution_config where store_id = '$store_id' ";
            $r = $db->select($sql);
            if ($r) {
                $sets = unserialize($r[0]->sets);
                $c_pay = $sets['c_pay'];
                if ($c_pay == 1) {
                    //分销
                    $comm=new Commission();
                    $comm->uplevel($db,$store_id,$user_id);
                    $comm->putcomm($db,$store_id,$sNo,$spz_price);
                   
                }
            }

        } else {
            $sql_o = "update lkt_order set offset_balance=$payment_money + offset_balance,z_price=z_price-$payment_money,pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo' and z_price > '$payment_money' ";
            $r = $db->update($sql_o);
            if ($r == -1) {
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }
        }
    }

    //修改订单创建,创建开团记录
    public function changeOrder($db, $store_id, $payment_money, $pro_id, $man_num, $sNo, $user_id,$grade_rate)
    {
        $sql = "select * from lkt_order where store_id = '$store_id' and sNo = '$sNo' and user_id = '$user_id'";
        $r2 = $db->select($sql);

        if ($r2) {
            $z_price = $r2[0]->z_price;
            $offset_balance = floatval($r2[0]->offset_balance);
//            $z_price = $z_price-$offset_balance;
        } else {
            $db->rollback();
            echo json_encode(array('code' => 0, 'message' => '参数错误'));
            exit;
        }
        $ptcode = '';
        //$payment_money = floatval($payment_money);
        $z_price = (string)$z_price;
        $sdf = bccomp($z_price,$payment_money,2);    //比较两个数字大小
        if ($sdf == 0) {
            //支付完成
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
            $grouptime = unserialize($grouptime[0]->group_data);
            $endtime = $grouptime->endtime;
            //查询拼团配置
            $sel_group_cfg = "select * from lkt_group_config where store_id = $store_id";
            $group_cfg = $db->select($sel_group_cfg);
            $time_over = $group_cfg[0]->group_time; //最多参团数量
            $time_over = ($time_over * 3600 + time()) > strtotime($endtime) ? strtotime($endtime) : ($time_over * 3600 + time());
            $time_over = date('Y-m-d H:i:s', $time_over);
            $gsNo = 'KT' . substr(time(), 5) . mt_rand(10000000, 99999999);
            $ptcode = $gsNo;
            $istsql1 = "insert into lkt_group_open(store_id,uid,ptgoods_id,ptcode,ptnumber,groupman,addtime,endtime,ptstatus,group_title,group_level,group_data,activity_no) values('$store_id','$user_id',$pro_id,'$gsNo',1,$man_num,'$creattime','$time_over',1,'$group_title','$group_level','$group_data','$activity_no')";
            $res1 = $db->insert($istsql1);
            if ($res1 < 1) {

                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }
            $z_price = sprintf("%.2f", $z_price + $offset_balance);
            $sql_o = "update lkt_order set z_price=$z_price,grade_rate=$grade_rate,status=9,ptstatus=1,pay='wallet_pay',ptcode='$gsNo',offset_balance=offset_balance+$payment_money,pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
            $r = $db->update($sql_o);
            if ($r < 1) {

                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }

            $sql_o = "update lkt_order_details set r_status=9 where store_id = '$store_id' and r_sNo = '$sNo'";
            $r = $db->update($sql_o);
            if ($r < 1) {
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }

        } else {
            //部分支付
            $sql_o = "update lkt_order set offset_balance=offset_balance+$payment_money,grade_rate=$grade_rate,z_price = z_price - $payment_money ,pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo' and z_price >= '$payment_money' ";
            $r = $db->update($sql_o);
            if ($r < 1) {
                //回滚删除已经创建的订单
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }
        }
        return $ptcode;
    }

    //参团订单处理逻辑
    public function changecanOrder($db, $store_id, $payment_money, $sNo, $ptcode, $user_id,$grade_rate)
    {
        $sql = "select * from lkt_order where store_id = '$store_id' and sNo = '$sNo' and user_id = '$user_id'";
        $r2 = $db->select($sql);

        if ($r2) {
            $z_price = $r2[0]->z_price;
            $offset_balance = floatval($r2[0]->offset_balance);

            if($payment_money == $z_price){
                $z_price = $payment_money +$offset_balance;
            }else{
                $z_price = $z_price-$payment_money;
            }
        } else {
            $db->rollback();
            echo json_encode(array('code' => 0, 'message' => '参数错误'));
            exit;
        }
        //$payment_money = floatval($payment_money);
        $sdf = bccomp($z_price,$payment_money,2);    //比较两个数字大小
        if ($sdf == 0) {
            $selsql = "select ptnumber,groupman,ptstatus,endtime from lkt_group_open where store_id = '$store_id' and ptcode='$ptcode'";
            $selres = $db->select($selsql);

            if (!empty($selres)) {
                $ptnumber = $selres[0]->ptnumber;
                $groupman = $selres[0]->groupman;
                $endtime = strtotime($selres[0]->endtime);
            }

            if ($endtime >= time()) {
                if (($ptnumber + 1) < $groupman) {     //团人数没满
                    $sql_o = "update lkt_order set status=9,ptstatus=1,grade_rate=$grade_rate,pay='wallet_pay',z_price = '$z_price',ptcode='$ptcode',offset_balance=offset_balance+$payment_money,pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
                    $r = $db->update($sql_o);
                    if ($r < 1) {
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                        exit;
                    }
                    $sql_o = "update lkt_order_details set r_status=9 where store_id = '$store_id' and r_sNo = '$sNo'";
                    $r = $db->update($sql_o);
                    if ($r < 1) {
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => $sql_o));
                        exit;
                    }
                    $updsql = "update lkt_group_open set ptnumber=ptnumber+1 where store_id = '$store_id' and ptcode='$ptcode'";
                    $updres = $db->update($updsql);
                    if ($updres < 1) {
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                        exit;
                    }
                } else if (($ptnumber + 1) == $groupman) {
                    $sql_me = "update lkt_order set status=1,ptstatus=2,grade_rate=$grade_rate,pay='wallet_pay',z_price = '$z_price',ptcode='$ptcode',offset_balance=offset_balance+$payment_money,pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
                    $r_me = $db->update($sql_me);
                    if ($r_me < 1) {
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => $sql_me));
                        exit;
                    }
                    $sql_o = "update lkt_order set status=1,ptstatus=2,pay='wallet_pay',ptcode='$ptcode',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and ptcode = '$ptcode' and status=9";
                    $r = $db->update($sql_o);
                    if ($r < 1) {
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => $sql_o));
                        exit;
                    }else{
                        $sql = "select * from lkt_order where store_id = $store_id and ptcode = '$ptcode'";
                        $group_res = $db->select($sql);
                        if($group_res){
                            foreach ($group_res as $k => $v){
                                $sNo = $v->sNo;
                                $user_id_ = $v->user_id;
                                $msg_title = "拼团已完成！";
                                $msg_content = "您订单号".$sNo."的拼团已经完成了!";

                                $JurisdictionAction = new JurisdictionAction();
                                $JurisdictionAction->admin_record($store_id,'System',' '.$sNo.' 的订单已完成拼团 ',8);

                                /**发货成功通知*/
                                $pusher = new LaikePushTools();
                                $pusher->pushMessage($user_id_, $db, $msg_title, $msg_content, $store_id, '');
                            }
                        }
                    }
                    $gsNosql = "select sNo from lkt_order where store_id = '$store_id' and ptcode = '$ptcode' and status=1";
                    $sNores = $db->select($gsNosql);
                    $str = '';
                    foreach ($sNores as $v) {
                        $str .= '"' . $v->sNo . '",';
                    }
                    $str = rtrim($str, ",");
                    $sql_d = "update lkt_order_details set r_status=1 where store_id = '$store_id' and r_sNo in($str)";
                    $r = $db->update($sql_d);
                    if ($r < 1) {
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => $sql_d));
                        exit;
                    }

                    $updsql = "update lkt_group_open set ptnumber=ptnumber+1,ptstatus=2 where store_id = '$store_id' and ptcode='$ptcode'";
                    $updres = $db->update($updsql);
                    if ($updres < 1) {
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => $updsql));
                        exit;
                    }
                } else {  //团人数已满，拼团失败
                    $db->rollback();
                    echo json_encode(array('code' => 0, 'err' => '此团已满，参团失败!'));
                    exit;
                }
            } else {     //已过参团期限，拼团失败
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }
        } else {
            $sql_o = "update lkt_order set offset_balance=offset_balance+$payment_money,z_price='$z_price',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo' and z_price > '$payment_money' ";
            $r = $db->update($sql_o);
            if ($r < 1) {
                //回滚删除已经创建的订单
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }
        }

    }

    /**
     * [wallet_pay description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-18T22:22:09+0800
     * @return  余额支付
     */
    public function wallet_pay($total)
    {

        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $user_id = $this->user->user_id;

        $db->begin();

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $parameter = trim($request->getParameter('parameter')); // 参数
        $grade_l = addslashes($request->getParameter('grade_l'));//会员特惠 兑换券级别
        if(!empty($this->order_list)){
            $sNo = $this->order_list['sNo'];
        }else{
            $sNo = trim($request->getParameter('sNo')); // 订单sNo
        }
        $payment_money = $total; // 余额抵扣金额

        if ($payment_money && !$grade_l) {
            if (!is_numeric($payment_money) || $payment_money < 0) {
                echo json_encode(array('code' => 0, 'message' => '金额错误!'));
                exit;
            }
        }

        $user_money = $this->user->money; // 用户余额
        if ($user_money >= $payment_money) { // 用户余额 大于 余额抵扣金额

            // 根据微信id,修改用户余额
            $sql = "update lkt_user set money = money-'$payment_money' where store_id = '$store_id' and user_id = '$user_id' and money > 0";
            $r = $db->update($sql);
            if ($r == -1) {
                //回滚删除已经创建的订单
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败!','line'=>__LINE__));
                exit;
            }

            $event = $user_id . '使用了' . $payment_money . '元余额';
            // 添加一条记录
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$payment_money','$user_money','$event',4)";
            $rr = $db->insert($sqll);
            switch ($this->order_types) {
                case 'CZ':
                    $db->rollback();
                    echo json_encode(array('code' => 0, 'message' => '操作有误！'));
                    exit;
                    break;
                case 'PT':
                    $pro_id = trim($request->getParameter('pro_id')); // 产品id,拼团订单用
                    $page = trim($request->getParameter('page')); // 开团还是参团,拼团订单用
                    $man_num = trim($request->getParameter('man_num')); // 所选开团人数
                    $grade_rate = trim($request->getParameter('grade_rate')); // 会员折扣

                    //查询活动过期事件
                    $sql_cx = 'SELECT group_data,g_status ,endtime
                    FROM lkt_group_product 
                    WHERE store_id = '.$request->getParameter('store_id').' AND is_delete = 0 and g_status = 2 and product_id = '.$request->getParameter('pro_id').'';

                    $gqRes = $db->select($sql_cx);
                    $isopen = false;
                    if($gqRes[0]->g_status == 2){
                        $isopen = true;
                    }
                    if($gqRes){
                        //活动结束日期
                        $endtime = strtotime($gqRes[0]->endtime);
                        //当前时间戳
                        $time = time();
                        //如果过期，回滚事件，退出循环
                        if ($time > $endtime){ //判断是否超时
                            $db->rollback();
                            echo json_encode(array('code' => 115, 'message' => '拼团活动已结束！'));
                            exit;
                            break;
                        }
                        if (!$isopen){ //判断是否关闭
                            $db->rollback();
                            echo json_encode(array('code' => 115, 'message' => '拼团活动已结束！'));
                            exit;
                            break;
                        }
                    }

                    if ($page == 'kaituan') {
                        $ptcode = $this->changeOrder($db, $store_id, $payment_money, $pro_id, $man_num, $sNo, $user_id,$grade_rate);
                    } else {
                        $ptcode = trim($request->getParameter('ptcode')); // 团订单号
                        $this->changecanOrder($db, $store_id, $payment_money, $sNo, $ptcode, $user_id,$grade_rate);
                    }
                    $db->commit();
                    echo json_encode(array('code' => 200, 'message' => '成功', 'ptcode' => $ptcode));
                    exit;
                    break;
                case 'HB':
                    $db->rollback();
                    echo json_encode(array('code' => 0, 'message' => '支付方式未设置!'));
                    exit;
                    exit;
                    # code...
                    break;
                case 'KJ':
                    $oId = trim($request->getParameter('order_no')); //

                    $this->gndd($db, $store_id, $payment_money, $sNo, $user_id);
                    $sql = "SELECT * FROM `lkt_order` WHERE p_sNo = '$oId'";
                    $order_res = $db->select($sql);

                    if($payment_money == $order_res[0]->z_price){
                        $sql = "UPDATE lkt_bargain_order SET status = 2 where order_no = '$oId'";

                        $_up_bargain_O = $db->update($sql);
                    }
                    $db->commit();
                    echo json_encode(array('code' => 200, 'message' => '成功！'));

                    exit;
                    # code...
                    break;
                case 'JP':
                    //订单总价 == 支付余额 更新状态
                    $sql_s = "select z_price ,offset_balance from lkt_order where store_id = '$store_id' and sNo = '$sNo' and user_id = '$user_id' ";
                    $res_s = $db->select($sql_s);
                    if($res_s[0]->z_price == $payment_money){
                        $sql_jp = "update lkt_auction_product set is_buy = 1 where user_id = '$user_id' and trade_no = '$sNo'";
                        $res_jp = $db->update($sql_jp);

                        $sql_jp1 = "select id from lkt_auction_product where trade_no = '$sNo' and store_id = '$store_id'";
                        $res_jp1 = $db->select($sql_jp1);
                        if($res_jp1){
                             $a_id = $res_jp1[0]->id;//竞拍商品id
                        }

                        //修改竞拍押金退款标准为可退款
                         $sql_2 = "update lkt_auction_promise set allow_back = 1 where store_id = '$store_id' and a_id = '$a_id' and user_id = '$user_id' and allow_back = 0 and is_pay = 1";
                        $res_2 = $db->update($sql_2);
                        if($res_jp < 0 || $res_2 < 0) {
                            $db->rollback();
                            echo json_encode(array('code' => 0, 'message' => '修改竞拍商品是否支付状态失败！'));
                            exit;
                        }
                    }
                    $this->gndd($db, $store_id, $payment_money, $sNo, $user_id);
                    
                    break;
                case 'MS':

                    //查询订单数据
                    $sel_order = "select o.*,od.p_id from lkt_order as o
                    LEFT JOIN lkt_order_details as od on o.sNo = od.r_sNo
                    where o.sNo = '$sNo' and o.store_id = $store_id";
                    $order_res = $db->select($sel_order);
                    $payment_money_ = $order_res[0]->spz_price;
                    $num_ = $order_res[0]->num;
                    $pro_id = $order_res[0]->p_id;
                    $add_time = time();

                    if(!empty($order_res)){

                        $this->gndd($db, $store_id, $payment_money, $sNo, $user_id);

                    }else{

                        $db->rollback();
                        echo json_encode(array('code' => 0, 'message' => '异常！'));
                        exit;
                    }

                    break;
                default:

                    $this->gndd($db, $store_id, $payment_money, $sNo, $user_id);
                    break;
            }
            $type__ = trim($request->getParameter('type_'));



            $db->commit();
            echo json_encode(array('code' => 200, 'message' => '成功'));
        } else {
            $db->rollback();
            echo json_encode(array('code' => 0, 'message' => '余额不足！'));
        }
        exit;

    }

    /**
     * [app_wechat description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-18T22:22:50+0800
     * @return  APP支付
     */
    public function app_wechat($total,$title,$real_sno,$type)
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $user_id = $this->user->user_id;
        $sNo = $this->sNo;

        $appid = $this->config_data->appid;
        //hg

        $data = wxpay::payment_APP($real_sno, $total, $title,$store_id,$type);

        echo json_encode($data);
        exit;

    }

    /**
     * [app_wechat description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  熊孔钰
     * @version 2.0
     * @date    2019-04-22T22:22:50+0800
     * @return  H5支付
     */
    public function jsapi_wechat($total,$title,$real_sno,$type)
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $user_id = $this->user->user_id;
        $sNo = $this->sNo;
        // $total = addslashes(trim($request->getParameter('total')));
        // $title = addslashes(trim($request->getParameter('title')));
        $appid = $this->config_data->appid;
        LaiKeLogUtils::lktLog("jsapi_wechat::::::".$sNo);

        $appid = $this->config_data->appid;
        $appsecret = $this->config_data->appsecret;

        $code = trim($request->getParameter('code'));


        if ($code) {
            $uurl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$appid."&secret=".$appsecret."&code=".$code."&grant_type=authorization_code";

            $res = $this->getOpenid($uurl);
            $refresh_token = $res['refresh_token'];

            $uuurl = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=".$appid."&grant_type=refresh_token&refresh_token=".$refresh_token;

            $res2 = $this->getOpenid($uuurl);
            $myfile = './webapp/log/wechat/app.log';
            $text = "=================!!!!!!!!!!!!===============";
            $fp = fopen($myfile,"a");
            flock($fp, LOCK_EX) ;

            fwrite($fp,mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($text)));
            fwrite($fp,mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($uurl)));
            fwrite($fp,mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($uuurl)));
            fwrite($fp,mb_convert_encoding($text, 'UTF-8', mb_detect_encoding(json_encode($res2))));
            fwrite($fp,mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($text)));

            flock($fp, LOCK_UN);
            fclose($fp);


//            echo $uurl;
//            echo '=======';
//            echo $uuurl;
//            echo '=======';
//            var_dump($res2);exit;

            $openid = $res2['openid'];
        } else {
            echo json_encode(array('code' => 108, 'message' => 'code参数错误'));
            exit;
        }

        $myfile = './webapp/log/wechat/app.log';
        $text = "\r\n【code！！！】".$store_id.$type."\r\n\r\n";
        $fp = fopen($myfile,"a");
        flock($fp, LOCK_EX) ;
        fwrite($fp,mb_convert_encoding($text, 'UTF-8', mb_detect_encoding($text)));
        flock($fp, LOCK_UN);
        fclose($fp);

        $data = wxpay::payment_JSAPI($real_sno, $total, $openid, $title,$appid , $store_id, $type);

        echo json_encode($data);
        exit;
    }

    /**
     *  作用：通过curl向微信提交code，以获取openid
     */
    public function getOpenid($url)
    {
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        $data = json_decode($res,true);

        return $data;
    }

    /**
     * [app_wechat description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  熊孔钰
     * @version 2.0
     * @date    2019-04-22T22:22:50+0800
     * @return  H5支付
     */
    public function H5_wechat($total,$title,$real_sno,$type)
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $user_id = $this->user->user_id;
        $sNo = $this->sNo;
        $appid = $this->config_data->appid;
        $data = wxpay::payment_H5($real_sno, $total, $title);

        $code = '0617f2eZ1DnXKS04sieZ12AWdZ17f2ed';
        if ($code) {
            $code_open = Tools::code_open($appid, $appsecret, $code); // 微信id
            if (!isset($code_open['openid'])) {
                echo json_encode(array('code' => 108, 'message' => $code_open));
                exit;
            }
            $openid = $code_open['openid'];
        } else {
            echo json_encode(array('code' => 108, 'message' => 'code参数错误'));
            exit;
        }

        $data = wxpay::payment_JSAPI($real_sno, $total, $openid, $title, $appid, $store_id, $type);


        echo json_encode($data);
        exit;

    }

    /**
     * [mini_wechat description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-18T22:23:07+0800
     * @return  小程序支付 --JSAPI
     */
    public function mini_wechat($total,$title,$real_sno,$type)
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $user_id = $this->user->user_id;
        $sNo = $this->sNo;
        LaiKeLogUtils::lktLog("mini_wechat::::::".$sNo);
        $title = addslashes(trim($request->getParameter('title')));
        $code = addslashes(trim($request->getParameter('code')));
        $appid = $this->config_data->appid;
        $appsecret = $this->config_data->appsecret;

        $code = addslashes(trim($request->getParameter('code'))); // 微信code
        if ($code) {
            $code_open = Tools::code_open($appid, $appsecret, $code); // 微信id
            if (!isset($code_open['openid'])) {
                echo json_encode(array('code' => 108, 'message' => $code_open));
                exit;
            }
            $openid = $code_open['openid'];
        } else {
            echo json_encode(array('code' => 108, 'message' => 'code参数错误'));
            exit;
        }

        $data = wxpay::payment_JSAPI($real_sno, $total, $openid, $title, $appid, $store_id, $type);

        echo json_encode($data);
        exit;

    }


    public function wap_unionpay()
    {
        echo json_encode(array('code' => 0, 'message' => '未开通的支付宝支付!'));
        exit;
    }

    public function alipay($total,$title,$real_sno,$type)
    {
        $data = $this->preAlipay($total, $title, $real_sno, $type);
        echo json_encode($data);
        exit;
    }

    public function alipay_mobile($total,$title,$real_sno,$type)
    {
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $user_id = $this->user->user_id;
        $sNo = $this->sNo;
        LaiKeLogUtils::lktLog("alipay_mobile::::::".$sNo);
        $appid = $this->config_data->appid;
        $data = TestImage::mobile_web($real_sno, $total, $title, $appid,$store_id,$type);
        echo json_encode($data);
        exit;
    }

    /**
     * 支付宝小程序支付
     * @param $total
     * @param $title
     * @param $real_sno
     * @param $type
     */
    public function alipay_minipay($total,$title,$real_sno,$type)
    {
        LaiKeLogUtils::lktLog("###alipay_minipay###");
        $store_id = $this->store_id;
        $sNo = $this->sNo;
        LaiKeLogUtils::lktLog("alipay_minipay::".$sNo);
        $appid = $this->config_data->appid;
        $request = $this->getContext()->getRequest();
        $alimp_authcode = addslashes(trim($request->getParameter('alimp_authcode')));//阿里授权code
        LaiKeLogUtils::lktLog("支付宝授权码：".$alimp_authcode);
        $data = TestImage::loadMPAlipay($real_sno, $total, $title, $appid,$store_id, $type,$alimp_authcode);
        LaiKeLogUtils::lktLog("支付宝支付：".json_encode($data));
        $tno = $this->trimall($data->trade_no);
        echo json_encode("s".$tno);
        exit;
    }

    public function trimall($str){
        $qian=array(" ","　","\t","\n","\r");
        return str_replace($qian, '', $str);
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    /**
     * 支付宝预支付
     * @param $total
     * @param $title
     * @param $real_sno
     * @param $type
     * @return string
     */
    public function preAlipay($total, $title, $real_sno, $type){

        $store_id = $this->store_id;
        $user_id = $this->user->user_id;
        $sNo = $this->sNo;
        LaiKeLogUtils::lktLog("alipay::::::".$sNo);
        $appid = $this->config_data->appid;
        $data = TestImage::load($real_sno, $total, $title, $appid, $store_id, $type);
        return $data;
    }

    // 生成订单号
    private function order_number($type)
    {
        if($type == 'PT'){
            $pay = 'PT';
        }else if($type == 'HB'){
            $pay = 'HB';
        }else if($type == 'JP'){
            $pay = 'JP';
        }else{
            $pay = 'GM';
        }
        return $pay.date("ymdhis").rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }

    /**
     * 头条小程序之支付宝app支付
     */
    public function tt_alipay($total,$title,$real_sno,$type){

        $store_id = $this->store_id;
        $config = LKTConfigInfo::getPayConfig($store_id,$type);
		
		if(empty($config)){
			LaiKeLogUtils::lktLog( __METHOD__ . '->' . __LINE__ . " 头条小程序支付暂未配置，无法调起支付！" );
            echo json_encode(array("code"=>"502","msg"=>"头条小程序支付暂未配置，无法调起支付！"));
            exit;
		}

        $ttAppid = $config['ttAppid'];
        $ttAppSecret = $config['ttAppSecret'];
        $ttshid = $config['ttshid'];
        $ttpayappid = $config['ttpayappid'];
        $ttpaysecret = $config['ttpaysecret'];
        $ttzfbnotifycburl = $config['notify_url'];

        $riskIp = '120.76.189.152';
        $riskIp = '127.0.0.1';
        $valid_time = "7200";

        $request = $this->getContext()->getRequest();
        $tt_authcode = addslashes(trim($request->getParameter('tt_authcode')));//授权code
        //1.获取openid
        $tt_openid = TTUtils::getTTOpenId($ttAppid, $ttAppSecret, $tt_authcode);

        //2:请求头条
        $result = TTUtils::ttCreatOrder($total, $title, $real_sno, $tt_openid, $ttshid, $valid_time, $ttzfbnotifycburl, $riskIp, $ttpayappid, $ttpaysecret);
        LaiKeLogUtils::lktLog( __METHOD__ . '->' . __LINE__ . " 头条响应结果:" . $result);
        $ttResultObj =  json_decode($result);
        $ttResponseObj = $ttResultObj->response;
        $ttPayCode = $ttResponseObj->code;
        if( $ttPayCode != '10000' ) {
            LaiKeLogUtils::lktLog( __METHOD__ . '->' . __LINE__ . " 支付失败:" . $result);
            echo json_encode(array("code"=>"502","msg"=>$ttResultObj->msg));
            exit;
        }
        $tttradeno = $ttResponseObj->trade_no;
        LaiKeLogUtils::lktLog( __METHOD__ .'->' . __LINE__." 头条响应订单号码" . $tttradeno );

        //3:支付宝信息
        $zfbAPPurl = $this->preAlipay($total,$title,$real_sno,"alipay");
        LaiKeLogUtils::lktLog( __METHOD__ .'->' . __LINE__." 支付宝响应头条支付结果" . $zfbAPPurl);

        //4:组织结果给前端
        $responseToFrontData = TTUtils::getTTPayCondition($total, $ttpayappid, $tttradeno, $ttshid, $tt_openid, $zfbAPPurl,$ttpaysecret);
        echo  json_encode(array("data"=>$responseToFrontData,"msg"=>"下单成功","code"=>200));
        exit;
    }

    /**
     * 百度小程序支付
     */
    public function baidu_pay($total,$title,$real_sno,$type){

        $store_id = $this->store_id;
        $config = LKTConfigInfo::getPayConfig($store_id,$type);
        
        if(empty($config)){
            LaiKeLogUtils::lktLog( __METHOD__ . '->' . __LINE__ . " 百度小程序支付暂未配置，无法调起支付！" );
            echo json_encode(array("code"=>"502","msg"=>"百度小程序支付暂未配置，无法调起支付！"));
            exit;
        }

        $requestParamsArr['dealId'] = $config['dealId'];
        $requestParamsArr['appKey'] = $config['appkey'];
        $requestParamsArr['totalAmount'] = intval(floatval($total)*100);// 精确到分
        $requestParamsArr['tpOrderId'] = $real_sno;
        // $requestParamsArr['bizInfo'] = '';

        $rsaPrivateKeyStr = $config['rsaPrivateKey'];
        $rsaPublicKeyStr = $config['rsaPublicKey'];

        /**
         * 第一部分：生成签名
         */
        $rsaSign = NuomiRsaSign::genSignWithRsa($requestParamsArr, $rsaPrivateKeyStr);
        $requestParamsArr['sign'] = $rsaSign;
        LaiKeLogUtils::lktLog( __METHOD__ . '->' . __LINE__ . " 百度支付签名获取:" . $rsaSign);

        $requestParamsArr['rsaSign'] = $rsaSign;
        $requestParamsArr['dealTitle'] = $title;
        $requestParamsArr['signFieldsRange'] = 1;// 对appKey+dealId+tpOrderId+totalAmount进行RSA加密后的签名，防止订单被伪造

        /**
         * 第二部分：组织结果给前端
         */
        echo  json_encode(array("data"=>$requestParamsArr,"msg"=>"下单成功","code"=>200));
        exit;
    }

}

?>