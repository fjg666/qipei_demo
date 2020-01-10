<?php
/**
 * Alipay.com Inc.
 * Copyright (c) 2004-2014 All Rights Reserved.
 */

require_once "AopClient.php";
require_once "AlipayTradeAppPayRequest.php";
require_once "AlipayTradeCreateRequest.php";
require_once "AlipaySystemOauthTokenRequest.php";
require_once "AlipayOpenAppQrcodeCreateRequest.php";
require_once "AlipayTools.class.php";
require_once "./webapp/lib/LKTConfigInfo.class.php";
require_once './webapp/lib/LaiKeLogUtils.class.php';

/**
 * 支付宝
 * @author axiu
 * @version $Id: Test.hp, v 0.1 Aug 6, 2014 4:20:17 PM yikai.hu Exp $
 */
class TestImage{

    /**
     * @param $sNo
     * @param $total
     * @param $title
     * @param $appid
     * @param $store_id
     * @param string $type
     * @return string
     */
	public static function load($sNo, $total, $title, $appid,$store_id,$type='alipay') {
        $config = LKTConfigInfo::getPayConfig($store_id,$type);
        $log = new LaiKeLogUtils('alipay/app.log');
        if (empty($config)) {
            $log -> customerLog("执行日期：".date('Y-m-d H:i:s')."\n支付暂未配置，无法调起支付！\n\n");
            return 'file';
        }
        $aop = new AopClient;
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = $config['appid'];
        $aop->rsaPrivateKey = $config['rsaPrivateKey'];
        $aop->alipayrsaPublicKey = $config['alipayrsaPublicKey'];
        $aop->format = "json";
        $aop->charset="UTF-8";
        $aop->signType = $config['signType'];
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizcontent = "{\"subject\": \"".$title."\","
                        . "\"out_trade_no\": \"".$sNo."\","
                        . "\"total_amount\": \"".$total."\","
                        . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                        . "}";
        $request->setNotifyUrl($config['notify_url']);
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request,$aop);
        $log -> customerLog("【APP调用支付】执行日期：".date('Y-m-d H:i:s')."\n".json_encode($response)."\n\n");
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        return $response;//就是orderString 可以直接给客户端请求，无需再做处理。
	}

    /**
     * @param $out_trade_no
     * @param $total_amount
     * @param $subject
     * @param $appid
     * @param $store_id
     * @param string $type
     * @return mixed|SimpleXMLElement|string|提交表单HTML文本
     */
    public static function mobile_web($out_trade_no, $total_amount, $subject, $appid,$store_id,$type='alipay') {
        $config = LKTConfigInfo::getPayConfig($store_id,$type);
        require_once('AlipayTradeService.php');
        require_once('AlipayTradeWapPayContentBuilder.php');
        $log = new LaiKeLogUtils('alipay/h5.log');
        if (empty($config)) {
            $log -> customerLog("执行日期：".date('Y-m-d H:i:s')."\n支付暂未配置，无法调起支付！\n\n");
            return 'file';
        }
        $body = "";
        $timeout_express="1m";
        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);//商品描述，可空
        $payRequestBuilder->setSubject($subject);//订单名称，必填
        $payRequestBuilder->setOutTradeNo($out_trade_no);//商户订单号，商户网站订单系统中唯一订单号，必填
        $payRequestBuilder->setTotalAmount($total_amount);//付款金额，必填
        $payRequestBuilder->setTimeExpress($timeout_express);//超时时间
        $payResponse = new AlipayTradeService();
        $payResponse->gateway_url = "https://openapi.alipay.com/gateway.do";
        $aop = new AopClient;
        $aop->appId = $config['appid'];
        $aop->private_key = $config['rsaPrivateKey'];
        $aop->alipay_public_key = $config['alipayrsaPublicKey'];
        $aop->signtype = $config['signType'];
        $aop->charset="UTF-8";
        $payResponse->notify_url = $config['notify_url'];
        $result=$payResponse->wapPay($payRequestBuilder,"",$config['notify_url']);
        $log -> customerLog("【H5调用支付】执行日期：".date('Y-m-d H:i:s')."\n".json_encode($result)."\n\n");
        return $result;//就是orderString 可以直接给客户端请求，无需再做处理。
    }

    /**
     * 支付宝小程序支付
     * @param $sNo
     * @param $total
     * @param $title
     * @param $appid
     * @param $store_id
     * @param string $type
     * @throws Exception
     */
    public static function loadMPAlipay($sNo, $total, $title, $appid,$store_id,$type='alipay_minipay',$alimp_auth_code) {
        $config = LKTConfigInfo::getPayConfig($store_id,$type);
        $log = new LaiKeLogUtils('alipay/aliminipay.log');
        if (empty($config)) {
            $log -> customerLog("执行日期：".date('Y-m-d H:i:s')."\n支付暂未配置，无法调起支付！\n\n");
            return 'file';
        }
        $aop = new AopClient ();
        //小程序appid
        $aop->appId = $config["appid"];
        //私钥 PKCS1,2048位
        $aop->rsaPrivateKey = $config['rsaPrivateKey'];
        //支付宝公钥对应的 支付宝公钥从开放平台获取 （非应用公钥）
        $aop->alipayrsaPublicKey = $config['alipayrsaPublicKey'];
        $aop->format = "json";
        $aop->charset="UTF-8";
        $aop->signType = "RSA2";
        $aop->apiVersion = '1.0';

        $buyerid = null;
        $log->customerLog("支付宝小程序授权码为".$alimp_auth_code);
        if(!empty($alimp_auth_code)){
            $request1 = new AlipaySystemOauthTokenRequest();
            $request1->setGrantType("authorization_code");
            $request1->setCode($alimp_auth_code);
            $result1 = $aop->execute($request1);
            $buyerid = $result1->alipay_system_oauth_token_response->user_id;
            $log->customerLog("获取用户userid成功:".$buyerid."行号:".__LINE__);
        }else{
            $log->customerLog("支付宝小程序授权码为空！".__LINE__);
            return null;
        }

        $request = new AlipayTradeCreateRequest ();
        $request->setBizContent("{" .
            "\"out_trade_no\":\"".$sNo."\"," .
            "\"total_amount\": \"".$total."\",".
            "\"buyer_id\":\"".$buyerid."\"," .
            "\"subject\":\"".$title."\"" .
            "  }");
        //设置回调地址
        $request->setNotifyUrl($config['notify_url']);
        $result = $aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $log->customerLog("支付宝小程序支付结果:".json_encode($result));
        return $result->$responseNode;
    }

    public static function getcode($url,$query_param, $uploadImg,$store_id,$describe=''){

        $config = LKTConfigInfo::getPayConfig($store_id,'alipay_minipay');
        $log = new LaiKeLogUtils('alipay/aliminipay.log');
        if (empty($config)) {
            $log -> customerLog("执行日期：".date('Y-m-d H:i:s')."\n支付暂未配置，无法调起支付！\n\n");
            return 'file';
        }

        $aop = new AopClient ();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $config["appid"];
        $aop->rsaPrivateKey = $config['rsaPrivateKey'];
        $aop->alipayrsaPublicKey=$config['alipayrsaPublicKey'];
        $aop->apiVersion = '1.0';
        $aop->signType = 'RSA2';
        $aop->postCharset='UTF-8';
        $aop->format='json';
        $request = new AlipayOpenAppQrcodeCreateRequest ();
        $request->setBizContent("{" .
        "\"url_param\":\"".$url."\"," .
        "\"query_param\":\"".$query_param."\"," .
        "\"describe\":\"".$describe."\"" .
        "  }");
        $result = $aop->execute ( $request); 

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            return $result->$responseNode->qr_code_url;
        } else {
            return 'file';
        }
    }


}



