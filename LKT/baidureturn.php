<?php

session_name("money_mojavi");

session_start();

date_default_timezone_set('Asia/Chongqing');

set_time_limit(0);

require_once(dirname(__FILE__)."/webapp/config.php");

require_once(MO_APP_DIR."/mojavi.php");

require_once(dirname(__FILE__).'/webapp/config/db_config.php');

require_once(dirname(__FILE__).'/webapp/lib/DBAction.class.php');

require_once(dirname(__FILE__).'/webapp/lib/WxPayPubHelper/log_.php');

require_once(dirname(__FILE__) . '/webapp/lib/SysConst.class.php');

require_once(dirname(__FILE__) . '/webapp/lib/order.class.php');

require_once(dirname(__FILE__) . '/webapp/lib/LKTConfigInfo.class.php');

require_once(dirname(__FILE__) . '/webapp/lib/Baidu_pay/NuomiRsaSign.php');

$db = DBAction::getInstance();

$log_ = new Log_();

$log_name='./bd_return.log';//log文件路径

$log_->log_result($log_name,"【baidu_pay接收到的退款验证】:\r\n".json_encode($_POST)."\r\n");

$dataa = $_POST;

if (empty($dataa)) {
    $dataa = $_GET;
}

// $data = (array)json_decode('{"unitPrice":"1","orderId":"81288776562801","payTime":"1570694806","dealId":"4060481370","tpOrderId":"GM191010040637024407","count":"1","totalMoney":"1","hbBalanceMoney":"0","userId":"1966186480","promoMoney":"0","promoDetail":"","hbMoney":"0","giftCardMoney":"0","payMoney":"1","payType":"1087","returnData":"","partnerId":"6000001","rsaSign":"Z5nALmexR3RPNiXI7XbqshUUFoYapQ2fJxlB8NZ6tut4n3zAIy87jTBBmINbMW9VML6mqbikwVeYn48w8nTFMGAJ1yEgWMGJ4lmzG5k1mBGKL9Dllsb3bNJZAtuW6\/4mzlLG19JdV6g9p5DEnTGrM3HU6mKMnH8KRWDcctRYNiE=","status":"2"}');

$trade_no = $dataa['tpOrderId'];

$sql = "select store_id,pay,offset_balance from lkt_order where (real_sno='$trade_no' or sNo='$trade_no') and status=4";
$r = $db->select($sql);
if (!$r) {
    return 'file';
}
$store_id = $r[0]->store_id;
$pay_type = $r[0]->pay;
$offset_balance = $r[0]->offset_balance;

$config = LKTConfigInfo::getPayConfig($store_id,$pay_type);
if (empty($config) || $pay_type != 'baidu_pay') {
    $log_->log_result($log_name,$sql."执行日期：".date('Y-m-d H:i:s')."\n支付暂未配置".$store_id."，无法调起支付！\r\n");
    return 'file';
}

$log_->log_result($log_name,$pay_type."【baidu_pay接收到的退款验证】:\r\n".json_encode($dataa)."\r\n");

$dataa['sign'] = $dataa['rsaSign'];
unset($dataa['rsaSign']);

$rsaPublicKeyStr = $config['rsaPublicKey'];
$rsaPublicKeyStr = NuomiRsaSign::convertRSAKeyStr2Pem($rsaPublicKeyStr);
$result = NuomiRsaSign::checkSignWithRsa($dataa, $rsaPublicKeyStr);

if($result) {//验证成功

    $log_->log_result($log_name,"【baidu_pay接收到的退款验证】success:\r\n".json_encode($result)."\r\n");

    $refundid = $dataa['refundBatchId'];

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

    //组合支付
    if ($offset_balance > 0) {
        $return_user_money = number_format($offset_balance / $z_price * $price, 2, ".", "");
        $t1t = false;
        $price = number_format(($price - $return_user_money) / $z_price * $price, 2, ".", "");
    }  

    $resdata = array();
    if ($price > 0) {

        $data = (object)array(
            'auditStatus' => 1,
            'calculateRes' => '{"refundPayMoney":'.intval($price*100).'}'
        );

        $resdata = array(
            'errno' => 0,
            'msg' => 'success',
            'data' => $data
        );
    }

    $log_->log_result($log_name,"【baidu_pay接收到的退款验证】success:通过退款\r\n".json_encode($resdata)."\r\n");

    return $resdata;

}else {
    $log_->log_result($log_name,"【baidu_pay接收到的退款验证】error:\r\n".json_encode($result)."\r\n");
    //验证失败
    echo "fail";    //请不要修改或删除

}

?>

