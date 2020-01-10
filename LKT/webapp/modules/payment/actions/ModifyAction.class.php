<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $pid = addslashes($request->getParameter("pid")); // id
        $class_name = addslashes(trim($request->getParameter('class_name'))); // 原图片路径带名称

        $sql = "select * from lkt_payment_config where pid = '$pid' and store_id = '$store_id' ";
        $r = $db->select($sql);
        $status = $r?$r[0]->status:0;

        $sql = "select domain from lkt_config where store_id = '$store_id'";
        $r_db = $db->select($sql);
        $mrnotify_url = '';
        if ($r_db) {
            if ($pid==1||$pid==7||$pid==8) {
                $mrnotify_url = $r_db[0]->domain . '/zfbnotify_url.php';
            }else if ($pid==4||$pid==5||$pid==6) {
                $mrnotify_url = $r_db[0]->domain . '/notify_url.php';
            }
        }

        $value = $r ? $r[0]:[];
        if ($value) {
            if ($pid != 9) {
                $list = json_decode($value->config_data);
                $list->cert_pem = @file_get_contents($list->sslcert_path);
                $list->key_pem = @file_get_contents($list->sslkey_path);
            }else{
                $list = (object)unserialize($value->config_data);
            }
            $list->status = $status;
            $request->setAttribute("list",$list);
        }

        $request->setAttribute("pid",$pid);
        $request->setAttribute("class_name",$class_name);
        $request->setAttribute("mrnotify_url",$mrnotify_url);
        return View :: INPUT;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $pid = addslashes($request->getParameter("pid")); // pid
        $class_name = addslashes(trim($request->getParameter('class_name'))); // 支付类型

        if($class_name == 'mini_wechat' || $class_name == 'app_wechat' || $class_name == 'jsapi_wechat'){
            $this->wx_save_data();
        }else if($class_name == 'wallet_pay'){
            echo json_encode(array('code' => 0,'msg'=>'钱包支付暂时不需要设置！'));exit;
        }else if($class_name == 'alipay' || $class_name == 'alipay_minipay'){
            $this->zfb_save_data();
        }else if ($class_name == 'tt_alipay'){
            $this->save_tt_alipay();
        }else if ($class_name == 'baidu_pay'){
            $this->save_baidu_pay();
        }else{
            echo json_encode(array('code' => 0,'msg'=>'其他支付暂未开放！'));exit;
        }
        exit;
    }

    /**
     * 百度小程序支付配置信息保存
     */
    public function  save_baidu_pay(){

        $log = new LaiKeLogUtils('common/payment.log');
        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $pid = addslashes($request->getParameter("pid")); // pid
        $class_name = addslashes(trim($request->getParameter('class_name'))); // 支付类型
        $status = addslashes(trim($request->getParameter('status'))); // 是否显示 0否 1是

        $data = $request->getParameter($class_name);
        $appid = addslashes(trim($data['appid']));
        $appkey = addslashes(trim($data['appkey']));
        $dealId = addslashes(trim($data['dealId']));
        $rsaPublicKey = addslashes(trim($data['rsaPublicKey']));
        $rsaPrivateKey = addslashes(trim($data['rsaPrivateKey']));

        $bdmpappid = addslashes(trim($data['bdmpappid']));
        $bdmpappsk = addslashes(trim($data['bdmpappsk']));

        $db_config['appid'] = $appid;
        $db_config['appkey'] = $appkey;
        $db_config['dealId'] = $dealId;
        $db_config['rsaPublicKey'] = $rsaPublicKey;
        $db_config['rsaPrivateKey'] = $rsaPrivateKey;
        $db_config['bdmpappid'] = $bdmpappid;
        $db_config['bdmpappsk'] = $bdmpappsk;

        $sql = "select * from lkt_payment_config where store_id = '$store_id' and `pid` = '$pid' ";
        $pconfig = $db->select($sql);
        $config_data = serialize($db_config);

        $log -> customerLog(__LINE__.":修改".$class_name."支付配置：".$config_data."！\r\n");

        if ($pconfig) {
            $modify['`config_data`'] = $config_data;
            $modify['`status`'] = $status;
            $db->modify($modify, 'lkt_payment_config', " `pid` ='$pid' and `store_id` = '$store_id' ");
        } else {
            $insert['`pid`'] = $pid;
            $insert['store_id'] = $store_id;
            $insert['`config_data`'] = $config_data;
            $insert['`status`'] = $status;
            $db->insert_array($insert, 'lkt_payment_config');
        }

        $log -> customerLog(__METHOD__.'->'.__LINE__.":修改".$class_name."支付配置成功！\r\n");
        echo json_encode(array('code' => 1, 'msg' => '修改成功！'));exit();
    }

    /**
     * 头条支付宝app支付配置信息保存
     */
    public function  save_tt_alipay(){

        $log = new LaiKeLogUtils('common/payment.log');
        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $pid = addslashes($request->getParameter("pid")); // pid
        $class_name = addslashes(trim($request->getParameter('class_name'))); // 支付类型
        $status = addslashes(trim($request->getParameter('status'))); // 是否显示 0否 1是

        $data = $request->getParameter($class_name);
        $ttAppid = addslashes(trim($data['ttAppid']));
        $ttAppSecret = addslashes(trim($data['ttAppSecret']));
        $notify_url = addslashes(trim($data['notify_url']));
        $ttshid = addslashes(trim($data['ttshid']));
        $ttpayappid = addslashes(trim($data['ttpayappid']));
        $ttpaysecret= addslashes(trim($data['ttpaysecret']));

        $db_config['ttAppid'] = $ttAppid;
        $db_config['ttAppSecret'] = $ttAppSecret;
        $db_config['notify_url'] = $notify_url;
        $db_config['ttshid'] = $ttshid;
        $db_config['ttpayappid'] = $ttpayappid;
        $db_config['ttpaysecret'] = $ttpaysecret;

        $sql = "select * from lkt_payment_config where store_id = '$store_id' and `pid` = '$pid' ";
        $pconfig = $db->select($sql);
        $config_data = json_encode($db_config);

        $log -> customerLog(__LINE__.":修改".$class_name."支付配置：".$config_data."！\r\n");

        if ($pconfig) {
            $modify['`config_data`'] = $config_data;
            $modify['`status`'] = $status;
            $db->modify($modify, 'lkt_payment_config', " `pid` ='$pid' and `store_id` = '$store_id' ");
        } else {
            $insert['`pid`'] = $pid;
            $insert['store_id'] = $store_id;
            $insert['`config_data`'] = $config_data;
            $insert['`status`'] = $status;
            $db->insert_array($insert, 'lkt_payment_config');
        }

        $log -> customerLog(__METHOD__.'->'.__LINE__.":修改".$class_name."支付配置成功！\r\n");
        echo json_encode(array('code' => 1, 'msg' => '修改成功！'));exit();
    }

    /**
     * 钱包支付
     */
    public function save_data_wallet_pay()
    {
        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $pid = addslashes($request->getParameter("pid")); // pid
        $class_name = addslashes(trim($request->getParameter('class_name'))); // 支付类型
        $status = addslashes(trim($request->getParameter('status'))); // 是否显示 0否 1是
        //取得参数

        $data = $request->getParameter($class_name);
        $mch_key = addslashes($data['mch_key']);
        $mch_id = addslashes(trim($data['mch_id'])); // 商户id

        $cert_pem = addslashes(trim($data['cert_pem']));
        $key_pem = addslashes(trim($data['key_pem']));

        $appid = addslashes(trim($data['appid']));
        $appsecret = addslashes(trim($data['appsecret']));

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    // 微信支付
    public function wx_save_data()
    {
        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $pid = addslashes($request->getParameter("pid")); // pid
        $class_name = addslashes(trim($request->getParameter('class_name'))); // 支付类型
        $status = addslashes(trim($request->getParameter('status'))); // 是否显示 0否 1是
        //取得参数

        $data = $request->getParameter($class_name);
        $mch_key = addslashes($data['mch_key']);
        $mch_id = addslashes(trim($data['mch_id'])); // 商户id

        $cert_pem = addslashes(trim($data['cert_pem']));
        $key_pem = addslashes(trim($data['key_pem']));

        $appid = addslashes(trim($data['appid']));
        $appsecret = addslashes(trim($data['appsecret']));
        $notify_url = addslashes(trim($data['notify_url']));

        $log = new LaiKeLogUtils('common/payment.log');

        if ($mch_key == '') {
            $log -> customerLog(__LINE__.":修改".$class_name."支付配置失败：信息未填写完整,请完善后在提交！\r\n");
            echo json_encode(array('code' => 0,'msg'=>'信息未填写完整,请完善后在提交！'));exit;
        }
        if (is_numeric($mch_id) == false) {
            $log -> customerLog(__LINE__.":修改".$class_name."支付配置失败：商户id请输入数字！\r\n");
            echo json_encode(array('code' => 0,'msg'=>'商户id请输入数字！'));exit;
        }

        //异步通知配置文件
        $sql = "select domain from lkt_config where store_id = '$store_id'";
        $r_db = $db->select($sql);
        $db_config = [];

        $wx_config_path = MO_LIB_DIR . '/wxpayv3/';
        $cert_path = $wx_config_path . 'cert/';

        $upload_file = $cert_path. md5($store_id . $appid) . '/'; // 文件上传位置
        if (!is_dir($upload_file)) {

            mkdir($upload_file);
        }

        if ($class_name == 'app_wechat') {

            $sslcert_path = './webapp/lib/wxpayv3/cert/'.md5($store_id . $appid) . '/apiclient_cert.pem';
            $sslkey_path = './webapp/lib/wxpayv3/cert/'.md5($store_id . $appid) . '/apiclient_key.pem';

        }else{

            $sslcert_path = str_replace('\\', '/', $upload_file . 'apiclient_cert.pem');
            $sslkey_path = str_replace('\\', '/', $upload_file . 'apiclient_key.pem');

        }


        $db_config['appid'] = $appid;
        $db_config['appsecret'] = $appsecret;
        $db_config['mch_id'] = $mch_id;
        $db_config['mch_key'] = $mch_key;
        $db_config['js_api_call_url'] = $r_db[0]->domain . '/js_api_call.php';
        // $db_config['cert_pem'] = $cert_pem;
        // $db_config['key_pem'] = $key_pem;
        $db_config['sslcert_path'] = $sslcert_path;
        $db_config['sslkey_path'] = $sslkey_path;
        $db_config['notify_url'] = $notify_url;

        if (!is_file($sslcert_path)) {
            fopen($sslcert_path, "w");
        }
        if(!empty($cert_pem)){
            @file_put_contents($sslcert_path, $cert_pem);
        }

        if (!is_file($sslkey_path)) {
            fopen($sslkey_path, "w");
        }
        if(!empty($key_pem)){
            @file_put_contents($sslkey_path, $key_pem);
        }

        $sql = "select * from lkt_payment_config where store_id = '$store_id' and `pid` = '$pid' ";
        $pconfig = $db->select($sql);
        $config_data = json_encode($db_config);
        if ($pconfig) {
            $modify['`config_data`'] = $config_data;
            $modify['`status`'] = $status;
            $theme_data = $db->modify($modify, 'lkt_payment_config', " `pid` ='$pid' and `store_id` = '$store_id' ");
        } else {
            $insert['`pid`'] = $pid;
            $insert['store_id'] = $store_id;
            $insert['`config_data`'] = $config_data;
            $insert['`status`'] = $status;
            $theme_data = $db->insert_array($insert, 'lkt_payment_config');
        }
        $log -> customerLog(__LINE__.":修改".$class_name."支付配置成功！\r\n");
        echo json_encode(array('code' => 1, 'msg' => '修改成功！'));exit();
    }

    // 支付宝支付
    public function zfb_save_data()
    {
        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $pid = addslashes($request->getParameter("pid")); // pid
        $class_name = addslashes(trim($request->getParameter('class_name'))); // 支付类型
        $status = addslashes(trim($request->getParameter('status'))); // 是否显示 0否 1是

        $data = $request->getParameter($class_name);
        $appid = addslashes($data['appid']);
        $encryptKey = "";
        if(isset($data['encryptKey'])){
            $encryptKey = addslashes(trim($data['encryptKey']));
        }
        $signType = addslashes(trim($data['signType']));
        $rsaPrivateKey = addslashes(trim($data['rsaPrivateKey']));
        $alipayrsaPublicKey = addslashes(trim($data['alipayrsaPublicKey']));
        $notify_url = addslashes(trim($data['notify_url']));

        $log = new LaiKeLogUtils('common/payment.log');// 日志

        if (is_numeric($appid) == false) {
            $log -> customerLog(__LINE__.":修改".$class_name."支付配置失败：appid请输入数字！\r\n");
            echo json_encode(array('code' => 0,'msg'=>'appid请输入数字！'));exit;
        }

        $zfb_config_path = MO_LIB_DIR . '/alipay/';
        $cert_path = $zfb_config_path . 'cert/';

        //异步通知配置文件
        $sql = "select domain from lkt_config where store_id = '$store_id'";
        $r_db = $db->select($sql);
        $r_db[0]->domain = preg_replace('/https/', 'http',$r_db[0]->domain);

        $upload_file = $cert_path. md5($store_id . $appid) . '/'; // 文件上传位置
        if (!is_dir($upload_file)) {
            mkdir($upload_file);
        }

        $Private_path = str_replace('\\', '/', $upload_file . 'rsaPrivateKey.pem');
        $Public_path = str_replace('\\', '/', $upload_file . 'alipayrsaPublicKey.pem');

        $db_config = array();

        $db_config['appid'] = $appid;
        $db_config['encryptKey'] = empty($encryptKey)?"":$encryptKey;
        $db_config['signType'] = $signType;
        $db_config['rsaPrivateKey'] = $rsaPrivateKey;
        $db_config['alipayrsaPublicKey'] = $alipayrsaPublicKey;
        $db_config['js_api_call_url'] = $r_db[0]->domain . '/js_api_call.php';
        $db_config['rsaPrivateKeyFilePath'] = $Private_path;
        $db_config['rsaPublicKeyFilePath'] = $Public_path;
        $db_config['notify_url'] = $notify_url;
        $db_config['encryptType'] = "AES";

        if (!is_file($Public_path)) {
            fopen($Public_path, "w");
        }
        if(!empty($rsaPublicKey)){
            @file_put_contents($Public_path, $rsaPublicKey);
        }

        if (!is_file($Private_path)) {
            fopen($Private_path, "w");
        }
        if(!empty($rsaPrivateKey)){
            @file_put_contents($Private_path, $rsaPrivateKey);
        }

        $sql = "select * from lkt_payment_config where store_id = '$store_id' and `pid` = '$pid' ";
        $pconfig = $db->select($sql);
        $config_data = json_encode($db_config);
        if ($pconfig) {
            $modify['`config_data`'] = $config_data;
            $modify['`status`'] = $status;
            $theme_data = $db->modify($modify, 'lkt_payment_config', " `pid` ='$pid' and `store_id` = '$store_id' ");
        } else {
            $insert['`pid`'] = $pid;
            $insert['store_id'] = $store_id;
            $insert['`config_data`'] = $config_data;
            $insert['`status`'] = $status;
            $theme_data = $db->insert_array($insert, 'lkt_payment_config');
        }
        $log -> customerLog(__LINE__.":修改".$class_name."支付配置成功！\r\n");
        echo json_encode(array('code' => 1, 'msg' => '修改成功！'));exit();
    }
}

?>