<?php

/**

 * 通用通知接口demo

 * ====================================================

 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，

 * 商户接收回调信息后，根据需要设定相应的处理流程。

 * 

 * 这里举例使用log文件形式记录回调信息。

*/

session_name("money_mojavi");

session_start();

date_default_timezone_set('Asia/Chongqing');

set_time_limit(0);

require_once(dirname(__FILE__)."/webapp/config.php");

require_once(MO_APP_DIR."/mojavi.php");

require_once(dirname(__FILE__).'/webapp/config/db_config.php');

require_once(dirname(__FILE__).'/webapp/lib/DBAction.class.php');

require_once(dirname(__FILE__).'/webapp/lib/WxPayPubHelper/WxPayPubHelper.php');

require_once(dirname(__FILE__).'/webapp/lib/WxPayPubHelper/log_.php');

require_once(dirname(__FILE__) . '/webapp/lib/SysConst.class.php');

require_once(dirname(__FILE__) . '/webapp/lib/order.class.php');

require_once(dirname(__FILE__) . '/webapp/lib/LKTConfigInfo.class.php');

    $db = DBAction::getInstance();

    //存储微信的回调 s

    $xml = PHP_VERSION <= 5.6 ? $GLOBALS['HTTP_RAW_POST_DATA']:file_get_contents('php://input');
    $notify = new Notify_pub();
    if (empty($xml)) {
        echo "error";exit;
    }
    $log_ = new Log_();

    $log_name='./notify_url.log';//log文件路径

//      $xml ='<xml><appid><![CDATA[wxf6e29bcc719cf499]]></appid>
// <bank_type><![CDATA[CFT]]></bank_type>
// <cash_fee><![CDATA[1]]></cash_fee>
// <fee_type><![CDATA[CNY]]></fee_type>
// <is_subscribe><![CDATA[N]]></is_subscribe>
// <mch_id><![CDATA[1516978921]]></mch_id>
// <nonce_str><![CDATA[g648sfqwb27epwdo95tt1n1wq8qj23z2]]></nonce_str>
// <openid><![CDATA[oIR3h0vN6X_8jVkvG3z69-6zJ51A]]></openid>
// <out_trade_no><![CDATA[DJ190909020311551038]]></out_trade_no>
// <result_code><![CDATA[SUCCESS]]></result_code>
// <return_code><![CDATA[SUCCESS]]></return_code>
// <sign><![CDATA[4F8F25BE2F3518668C07434EC6D4CA60]]></sign>
// <time_end><![CDATA[20190909140318]]></time_end>
// <total_fee>1</total_fee>
// <trade_type><![CDATA[APP]]></trade_type>
// <transaction_id><![CDATA[4200000401201909090001300261]]></transaction_id>
// </xml>
// ';

    $log_->log_result($log_name,"【微信接收到的notify通知】:\n".$xml."\r\n");

    $dxml = $notify->xmlToArray($xml);

    $trade_no = $dxml['out_trade_no'];
    $mch_id = $dxml['mch_id'];
    $appid = $dxml['appid'];
    $type = substr($trade_no,0,2);
    if($type == 'AC'){//竞拍押金
        $sql = "select store_id,type from lkt_auction_promise where trade_no = '$trade_no'";
        $r = $db->select($sql);
        $store_id = $r ? $r[0]->store_id : 0;
        $pay_type = $r ? $r[0]->pay_type : 0;
    }else if($type == 'CZ'){//会员充值
        $sql = "select data from lkt_order_data where trade_no = '$trade_no'";
        $r = $db->select($sql);
        $order_data = unserialize($r[0]->data);
        $store_id = $order_data ? $order_data['store_id'] : 0;
        $pay_type = $order_data ? $order_data['pay'] : 0 ;
    }else if($type == 'DJ'){//会员等级
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
   
    $config = LKTConfigInfo::getPayConfig($store_id,$pay_type);
    if (empty($config)) {
        $log_->log_result($log_name,$sql."执行日期：".date('Y-m-d H:i:s')."\n支付暂未配置".$store_id."，无法调起支付！\r\n");
        return 'file';
    }
    $notify = new Notify_pub($config);

    $notify->saveData($xml);

    //验证签名，并回应微信。

    //对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，

    //微信会通过一定的策略（如30分钟共8次）定期重新发起通知，

    //尽可能提高通知的成功率，但微信不保证通知最终能成功。
    if($notify->checkSign() == FALSE){

        $notify->setReturnParameter("return_code","FAIL");//返回状态码

        $notify->setReturnParameter("return_msg","签名失败");//返回信息

    }else{
        $notify->setReturnParameter("return_code","SUCCESS");//设置返回码

    }

    $returnXml = $notify->returnXml();

    echo $returnXml;

    //==商户根据实际情况设置相应的处理流程，此处仅作举例=======

    

    //以log文件形式记录回调信息

    // $log_ = new Log_();

    $log_name='./'.$appid.'_notify_url.log';//log文件路径

    $log_->log_result($log_name,"【接收到的notify通知】:\n".$xml."\n");

    if($notify->checkSign() == TRUE)

    {

        $log_->log_result($log_name,"【签名验证结果 succ】:\n".$notify->checkSign()."\n");

        if ($notify->data["return_code"] == "FAIL") {

            //此处应该更新一下订单状态，商户自行增删操作

            $log_->log_result($log_name,"【通信出错】:\n".$xml."\n");

        }

        elseif($notify->data["result_code"] == "FAIL"){

            //此处应该更新一下订单状态，商户自行增删操作

            $log_->log_result($log_name,"【业务出错】:\n".$xml."\n");

        }else{



            //此处应该更新一下订单状态，商户自行增删操作
            $trade_no = $notify->data["out_trade_no"];
            $total = floatval($notify->data["total_fee"])/100;

            $type = substr($trade_no,0,2);
            $log_->log_result($log_name,"【trade_no1】''''$trade_no:\n\n");

            if(($type != 'AC') &&($type != 'CZ') &&($type != 'DJ')  ){

                $sql = "select sNo from lkt_order where real_sno='$trade_no'";
                $r = $db->select($sql);
                $trade_no = $r[0]->sNo;
                $type = substr($trade_no,0,2);
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
                $z_price = $dres[0]->promise;
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
                $dsql = "select data from lkt_order_data where trade_no = '$trade_no'";
                $dres = $db->select($dsql);
                $data = unserialize($dres[0]->data);
                $rec = false;
                if($dres){
                    $order = new order;
                    $cmoney = $notify->data["total_fee"]/100;
                    $rec = $order -> cz($data,$cmoney,$trade_no); 
                }
                $log_->log_result($log_name,"【充值处理结果】:\n".$rec."\n");
            }else if($type == 'PT'){
                $dsql = "select o.*,d.p_id from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.sNo = '$trade_no'";

                $dres = $db->select($dsql);
                    $order = new order;
                    if($dres[0] -> pid =='kaituan'){
                        $order -> changeOrder((array)$dres[0],$trade_no);
                    }else{
                        $order -> changecanOrder((array)$dres[0],$trade_no);
                    }
                    $log_->log_result($log_name,"【拼团处理结果】:\n".$order."\n");

            }else if($type == 'HB'){//红包

                    $dsql = "select data from lkt_order_data where trade_no = '$trade_no'";
                    $dres = $db->select($dsql);
                    $data = unserialize($dres[0]->data);
                    $order = new order;
                    $ptres = $order -> red_packet_send($data,$trade_no);
                    $log_->log_result($log_name,"【红包处理结果】:\n".$ptres."\n");

            }else if($type == 'AC'){//竞拍押金
                    $order = new order;
                    $jpres = $order->acution_change($trade_no);
                    $log_->log_result($log_name,"【竞拍押金处理结果】:\n".$jpres."\n");
            }else if($type == 'JP'){//竞拍订单
                // var_dump($trade_no);
                $sql = "select * from lkt_order where sNo = '$trade_no'";
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
            }else if($type == 'DJ'){
                $sql = "select data from lkt_order_data where trade_no = '$trade_no'";
                $res = $db->select($sql);
                $data = unserialize($res[0]->data);
                $rec = false;
                if($res){
                    $order = new order;
                    $cmoney = $notify->data["total_fee"]/100;
                    $rec = $order -> dj($data,$cmoney,$trade_no); 
                }
                $log_->log_result($log_name,"【会员等级处理结果】:\n".$rec."\n");
            } else{
                
                $sql = "select * from lkt_order where sNo='$trade_no'";
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


        }



    }else{

        $log_->log_result($log_name,"【签名验证结果 fail】:\n".$notify->checkSign().'123123123'."\n");

    }

    

?>