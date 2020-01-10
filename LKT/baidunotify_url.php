<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。

 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */

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

$log_name='./notify_url.log';//log文件路径

$log_->log_result($log_name,"【baidu_pay接收到的notify通知】:\r\n".json_encode($_POST)."\r\n");

$data = $_POST;

if (empty($data)) {
    $data = $_GET;
}
if (empty($data)) {
    echo "error";exit;
}
// $data = (array)json_decode('{"unitPrice":"1","orderId":"81288776562801","payTime":"1570694806","dealId":"4060481370","tpOrderId":"GM191010040637024407","count":"1","totalMoney":"1","hbBalanceMoney":"0","userId":"1966186480","promoMoney":"0","promoDetail":"","hbMoney":"0","giftCardMoney":"0","payMoney":"1","payType":"1087","returnData":"","partnerId":"6000001","rsaSign":"Z5nALmexR3RPNiXI7XbqshUUFoYapQ2fJxlB8NZ6tut4n3zAIy87jTBBmINbMW9VML6mqbikwVeYn48w8nTFMGAJ1yEgWMGJ4lmzG5k1mBGKL9Dllsb3bNJZAtuW6\/4mzlLG19JdV6g9p5DEnTGrM3HU6mKMnH8KRWDcctRYNiE=","status":"2"}');

$trade_no = $data['tpOrderId'];
$type = substr($trade_no,0,2);
if($type == 'AC'){
    $sql = "select store_id,type from lkt_auction_promise where trade_no = '$trade_no'";
    $r = $db->select($sql);
    $store_id = $r ? $r[0]->store_id : 0;
    $pay_type = $r ? $r[0]->pay_type : 0;
}else if($type == 'CZ'){
    $sql = "select data from lkt_order_data where trade_no = '$trade_no'";
    $r = $db->select($sql);
    $order_data = unserialize($r[0]->data);
    $store_id = $order_data ? $order_data['store_id'] : 0;
    $pay_type = $order_data ? $order_data['pay'] : 0 ;
}else if($type == 'DJ'){
    $sql = "select data from lkt_order_data where trade_no = '$trade_no'";
    $r = $db->select($sql);
    $order_data = unserialize($r[0]->data);
    $store_id = $order_data ? $order_data['store_id'] : 0;
    $pay_type = $order_data ? $order_data['pay'] : 0 ;
}else{
    $sql = "select store_id,pay from lkt_order where (real_sno='$trade_no' or sNo='$trade_no')";
    $r = $db->select($sql);
    if ($r) {
        $orderId = $data['orderId'];
        $baiduId = $data['userId'];
        $db->update("UPDATE lkt_order SET orderId = '$orderId',baiduId = '$baiduId' where (real_sno='$trade_no' or sNo='$trade_no')");
    }
    $store_id = $r?$r[0]->store_id:0;
    $pay_type = $r?$r[0]->pay:0;
}
if (!$r || empty($trade_no)) {
    echo 'error';exit;
}

$config = LKTConfigInfo::getPayConfig($store_id,$pay_type);
if (empty($config) || $pay_type != 'baidu_pay') {
    $log_->log_result($log_name,$sql."执行日期：".date('Y-m-d H:i:s')."\n支付暂未配置".$store_id."，无法调起支付！\r\n");
    return 'file';
}

$log_name='./bd_'.$config['appid'].'_notify_url.log';//log文件路径

$log_->log_result($log_name,$pay_type."【baidu接收到的notify通知】:\r\n".json_encode($data)."\r\n");

$dataa = (array)$data;
$dataa['sign'] = $data['rsaSign'];
unset($dataa['rsaSign']);

$rsaPublicKeyStr = $config['rsaPublicKey'];
$rsaPublicKeyStr = NuomiRsaSign::convertRSAKeyStr2Pem($rsaPublicKeyStr);
$result = NuomiRsaSign::checkSignWithRsa($dataa, $rsaPublicKeyStr);

/* 实际验证过程建议商户添加以下校验。
1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
4、验证app_id是否为该商户本身。
*/
if($result) {//验证成功
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //请在这里加上商户的业务逻辑程序代
    $log_->log_result($log_name,"【接收到的notify通知】success:\r\n".json_encode($result)."\r\n");

    //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

    //商户订单号

    $out_trade_no = $data['tpOrderId'];
    $total = floatval($data["payMoney"])/100;

    //支付宝交易号

    $trade_no = $data['orderId'];

    //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    $type = substr($out_trade_no,0,2);
    if(($type != 'AC') && ($type != 'CZ') && ($type != 'DJ')){
        $sql = "select sNo from lkt_order where real_sno='$out_trade_no'";
        $r = $db->select($sql);
        $out_trade_no = $r[0]->sNo;
        $z_price = $r[0]->z_price;
        if (floatval($z_price) != floatval($total)) {
            $db->update("update lkt_order set z_price='$total' where real_sno='$trade_no'");
            $log_->log_result($log_name,"【付款金额有误】:\n 应付金额为$z_price \n");
        }
    }else if(($type == 'CZ') && ($type == 'DJ')){
        $dsql = "select data from lkt_order_data where trade_no = '$trade_no'";
        $dres = $db->select($dsql);
        $data = unserialize($dres[0]->data);
        $z_price = $data['total'];
        if (floatval($z_price) != floatval($total)) {
            $data['total'] = $total;
            $data = serialize($data);
            $db->update("update lkt_order_data set data='$data' where trade_no='$trade_no'");
            $log_->log_result($log_name,"【付款金额有误】:\n 应付金额为$z_price \n");
        }
    }else if($type == 'AC'){
        $dsql = "select promise from lkt_auction_promise where trade_no = '$trade_no'";
        $dres = $db->select($dsql);
        $z_price = $dres[0]->z_price;
        if (floatval($z_price) != floatval($total)) {
            $db->update("update lkt_order set promise='$total' where trade_no='$trade_no'");
            $log_->log_result($log_name,"【付款金额有误】:\n 应付金额为$z_price \n");
        }
    }
    
    if($type == "KJ"){
        $sql = "SELECT z_price,p_sNo from lkt_order where sNo = '$sNo'";
        $o_res = $db->select($sql);
        if($o_res[0]->z_price == $total){
            $p_sNo = $o_res[0]->p_sNo;
            $sql = "UPDATE lkt_bargain_order SET status = 2 where order_no = '$p_sNo'";
            $_up_bargain_O = $db->update($sql);
        }
    }

    if($type == 'CZ'){
        $dsql = "select data from lkt_order_data where trade_no = '$out_trade_no'";
        $dres = $db->select($dsql);
        $data = unserialize($dres[0]->data);
        $rec = false;
        if($dres){
            $order = new order;
            $cmoney = $data['total'];
            $rec = $order -> cz($data,$cmoney,$out_trade_no);
        }

        $log_->log_result($log_name,"【充值处理结果】:\n".$rec."\n");
    }else if($type == 'PT'){
        $dsql = "select o.*,d.p_id from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.sNo = '$out_trade_no'";
        $dres = $db->select($dsql);
        $order = new order;

        if($dres[0] -> pid =='kaituan'){
            $order -> changeOrder((array)$dres[0],$out_trade_no);
        }else{
            $order -> changecanOrder((array)$dres[0],$out_trade_no);
        }
        $log_->log_result($log_name,"【拼团处理结果】:\n".$ptres."\n");

    }else if($type == 'HB'){//红包

        $dsql = "select data from lkt_order_data where trade_no = '$out_trade_no'";
        $dres = $db->select($dsql);
        $data = unserialize($dres[0]->data);
        $order = new order;
        $ptres = $order -> red_packet_send($data,$out_trade_no);
        $log_->log_result($log_name,"【红包处理结果】:\n".$ptres."\n");

    }else if($type == 'AC'){//竞拍押金
        $order = new order;
        $jpres = $order->acution_change($out_trade_no);
        $log_->log_result($log_name,"【竞拍押金处理结果】:\n".$jpres."\n");
    }else if($type == 'JP'){//竞拍订单

        $sql = "select * from lkt_order where sNo = '$out_trade_no'";
        $r = $db->select($sql);
        if($r){
            $status = $r[0]->status;
            $sNo = $r[0]->sNo;
            if($status < 1){
                $order = new order;
                $order->acution_order((array)$r[0]);
                $log_->log_result($log_name,"【竞拍订单处理结果】:\n".json_encode((array)$r[0])."\n");
            }
        }
    } else if($type == 'DJ'){
        $sql = "select data from lkt_order_data where trade_no = '$out_trade_no'";
        $res = $db->select($sql);
        $data = unserialize($res[0]->data);
        $rec = false;
        if($res){
            $order = new order;
            $cmoney = $notify->data["total_fee"]/100;
            $rec = $order -> dj($data,$cmoney,$out_trade_no);
        }
        $log_->log_result($log_name,"【会员等级处理结果】:\n".$rec."\n");
    } else{
        $sql = "select * from lkt_order where sNo='$out_trade_no'";
        $r = $db->select($sql);
        if($r){
            $status = $r[0]->status;
            $sNo = $r[0]->sNo;
            if($status < 1){
                $order = new order;
                $order -> up_order((array)$r[0]);
                $log_->log_result($log_name,"【data】:\n".json_encode((array)$r[0])."\n");
            }
        }

    }

    $res = array(
        'errno' => 0,
        'msg' => 'success',
        'data' => array(
            'isConsumed' => 2
        )
    );

    return $res;

}else {
    $log_->log_result($log_name,"【接收到订单".$trade_no."的notify通知】error:\r\n".json_encode($result)."\r\n");
    //验证失败
    echo "fail";    //请不要修改或删除

}

?>

