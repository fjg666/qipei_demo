<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $lktlog = new LaiKeLogUtils("common/Customer.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');

        $endtime = $request->getParameter('endtime'); // 结束时间
        $name= addslashes($request->getParameter('name'));
        $customer_number= addslashes($request->getParameter('customer_number'));
        $company= addslashes($request->getParameter('company'));
        $domain= addslashes($request->getParameter('domain'));
        $phone= addslashes($request->getParameter('phone'));
        $price= addslashes($request->getParameter('price'));
        $email= addslashes($request->getParameter('email'));
        $set_admin_name = addslashes(trim($request->getParameter('set_admin_name'))); // 管理员账号
        $password = addslashes(trim($request->getParameter('password'))); // 密码
        $status = $request->getParameter('status');
        $time = date("Y-m-d H:i:s");
        if(empty($name)){
            echo json_encode(array('status' => '请填写客户名称！'));exit;
        }
        if(empty($company)){
            echo json_encode(array('status' => '请填写公司名称！'));exit;
        }
        if(empty($domain)){
            echo json_encode(array('status' => '请填写商城根目录域名！'));exit;
        }
        if(empty($phone)){
            echo json_encode(array('status' => '请填写手机号！'));exit;
        }
        if(empty($price)){
            echo json_encode(array('status' => '请填写价格！'));exit;
        }
        if(empty($email)){
            echo json_encode(array('status' => '请填写邮箱！'));exit;
        }
        if(empty($endtime)){
            echo json_encode(array('status' => '请填写到期时间！'));exit;
        }else{
            $endtime = date("Y-m-d 23:59:59",strtotime($endtime));
        }

        $sql = "select id from lkt_admin where name = '$set_admin_name'";
        $r = $db->select($sql);
        if($r){
            echo json_encode(array('status' => '管理员账号已存在！'));exit;
        }
        if($status == 1){
            $status = 2;
        }
        if(preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $phone)){
            if($endtime < $time){
                echo json_encode(array('status' => '到期时间不正确！'));exit;
            }
            if(empty($name)){
                echo json_encode(array('status' => '管理员账号不能为空！'));exit;
            }
            if(empty($password)){
                echo json_encode(array('status' => '管理员密码不能为空！'));exit;
            }else{
                $password = MD5($password);
            }
            $ssql = "select * from lkt_customer where (email = '$email' OR name ='$name' OR customer_number = '$customer_number')";
            $sres = $db->select($ssql);
            if(!empty($sres)){
                echo json_encode(array('status' => '客户名称、客户编号和邮箱重复！'));exit;
            }
            // 生成session_id
            $access_token = session_id();
            //修改token
            $ip = $this->get_client_ip();

            // 活动开始时间大于当前时间,活动还没开始
            $sql = "INSERT INTO lkt_customer (`customer_number`,`admin_id`, `name`, `mobile`, `price`, `company`, `function`, `add_date`, `end_date`, `status`, `email`) VALUES ('$customer_number','0','$name','$phone','$price','$company',2,CURRENT_TIMESTAMP,'$endtime','$status','$email')";
            $rr = $db->insert($sql,'last_insert_id'); // 得到添加数据的id

            if($rr > 0){
                $sql0 = "select upserver from lkt_upload_set limit 1";
                $r0 = $db->select($sql0);
                if($r0){
                    $upserver = $r0[0]->upserver;
                }else{
                    $upserver = 2;
                }
                $sql = "INSERT INTO `lkt_config` (`store_id`, `company`,  `domain`,upserver, `modify_date`) VALUES( $rr, '$company',  '$domain','$upserver',  CURRENT_TIMESTAMP)";
                $db->insert($sql);
                $sql = "insert into lkt_admin(sid,name,password,permission,role,type,store_id,status,tel,token,ip,add_date,recycle) values('$admin_id','$set_admin_name','$password','','',1,'$rr',2,'$phone','$access_token','$ip',CURRENT_TIMESTAMP,0)";
                $admin_id1 = $db->insert($sql,'last_insert_id');

                $db->update("UPDATE `lkt_customer` SET `admin_id`='$admin_id1' WHERE (`id`='$rr') LIMIT 1 ");

                $Log_content = __METHOD__ . '->' . __LINE__ . ' 用户添加成功';
                $lktlog->customerLog($Log_content);
                $db->commit();
                echo json_encode(array('status' => '用户添加成功！','suc'=>'1'));exit;
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 未知原因，用户添加失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '未知原因，用户添加失败！'));exit;
            }
        }else{
            echo json_encode(array('status' => '手机号码格式不正确！'));exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    function get_client_ip($type = 0,$client=true)
    {
        $type = $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($client){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // 防止IP伪造
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }
}

?>