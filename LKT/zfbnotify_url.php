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

require_once(dirname(__FILE__).'/webapp/lib/alipay/AopClient.php');

require_once(dirname(__FILE__).'/webapp/lib/WxPayPubHelper/log_.php');

require_once(dirname(__FILE__) . '/webapp/lib/SysConst.class.php');

require_once(dirname(__FILE__) . '/webapp/lib/order.class.php');

require_once(dirname(__FILE__) . '/webapp/lib/LKTConfigInfo.class.php');

$db = DBAction::getInstance();

$log_ = new Log_();

$log_name='./notify_url.log';//log文件路径

$log_->log_result($log_name,"【接收到的notify通知】:\r\n".json_encode($_POST)."\r\n");

$log_->log_result($log_name,"【接收到的notify通知】:\r\n".json_encode($_GET)."\r\n");

$data = $_POST;

if (empty($data)) {
    $data = $_GET;
}
if (empty($data)) {
    echo "error";exit;
}

// $data = (array)json_decode('{"gmt_create":"2019-09-09 14:37:46","charset":"UTF-8","seller_email":"18974896358@163.com","subject":"\u767d\u94f6\u4f1a\u5458\u5145\u503c","sign":"ROXoCTeLhHQXpevQUgUNTvvAuVByDQUW5+CGHjIa6M45hQDyuFcb0uoUzfRXWb4pYHiSZKk9n8sleombIrOee4bh0BTF7Pc53wQxQebijHfZqPxscbY\/pBhGE2GGYfWTxxFMygFW6jnQVOQuyh8i\/GKBkAdGjP9F6tSQYQbTdz8Th3B1Q5GUuz\/0wxoD11zInLX\/zCZEP+r7\/FL+8hmVCf6NhuMFiHExHX0qdO4TV+h1ZwOaVwpMU9y9xmOvU64W7vENXOUQVPRGvFRoNpcTsKSW\/nOjuVEISIRSZ2cPphVfwsTw9gq087ieKu5dMJ5FNikMLPIYTHUd2GgoG3dO5w==","buyer_id":"2088122044571909","invoice_amount":"0.01","notify_id":"2019090900222143747071900579678098","fund_bill_list":"[{\"amount\":\"0.01\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","notify_type":"trade_status_sync","trade_status":"TRADE_SUCCESS","receipt_amount":"0.01","app_id":"2019030763497116","buyer_pay_amount":"0.01","sign_type":"RSA2","seller_id":"2088031650461695","gmt_payment":"2019-09-09 14:37:47","notify_time":"2019-09-09 14:37:47","version":"1.0","out_trade_no":"DJ190909023742335713","total_amount":"0.01","trade_no":"2019090922001471900598056472","auth_app_id":"2019030763497116","buyer_logon_id":"137****7740","point_amount":"0.00"}');

$trade_no = $data['out_trade_no'];
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
    $store_id = $r?$r[0]->store_id:0;
    $pay_type = $r?$r[0]->pay:0;
}
if (!$r || empty($trade_no)) {
    echo 'error';exit;
}

if($pay_type == 'tt_alipay'){
    $pay_type = 'alipay';
}

$config = LKTConfigInfo::getPayConfig($store_id,$pay_type);
if (empty($config)) {
    $log_->log_result($log_name,$sql."执行日期：".date('Y-m-d H:i:s')."\n支付暂未配置".$store_id."，无法调起支付！\r\n");
    return 'file';
}

$log_name='./'.$config['appid'].'_notify_url.log';//log文件路径

$log_->log_result($log_name,"【接收到的notify通知】:\r\n".json_encode($data)."\r\n");

$aop = new AopClient;
$aop->alipayrsaPublicKey = $config['alipayrsaPublicKey'];
$aop->appId = $config['appid'];
$aop->private_key = $config['rsaPrivateKey'];
$aop->alipay_public_key = $config['alipayrsaPublicKey'];
$aop->signtype = $config['signType'];
//此处验签方式必须与下单时的签名方式一致
$result = $aop->rsaCheckV1($data, $aop->alipayrsaPublicKey, "RSA2");

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

    $out_trade_no = $data['out_trade_no'];
    $total = $data["total_amount"];
    //支付宝交易号

    $trade_no = $data['trade_no'];

    //交易状态
    $trade_status = $data['trade_status'];


    if($data['trade_status'] == 'TRADE_FINISHED') {

        //判断该笔订单是否在商户网站中已经做过处理
        //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
        //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
        //如果有做过处理，不执行商户的业务程序

        //注意：
        //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
    }
    else if ($data['trade_status'] == 'TRADE_SUCCESS') {
        //判断该笔订单是否在商户网站中已经做过处理
        //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
        //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
        //如果有做过处理，不执行商户的业务程序
        //注意：
        //付款完成后，支付宝系统发送该交易状态通知
    }
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


    echo "success";     //请不要修改或删除

}else {
    $log_->log_result($log_name,"【接收到的notify通知】error:\r\n".json_encode($result)."\r\n");
    //验证失败
    echo "fail";    //请不要修改或删除

}

?>

