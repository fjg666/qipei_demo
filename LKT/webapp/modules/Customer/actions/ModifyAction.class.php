<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $id = intval($request->getParameter("id")); // 商城id

        // 根据新闻id，查询新闻新闻信息
        $sql = "select * from lkt_customer where id = '$id'";
        $r = $db->select($sql);
        if ($r) {
            $sql = "select * from lkt_admin where store_id = '$id' and type = 1";
            $rr = $db->select($sql);
            if ($rr) {
                $r[0]->set_admin_name = $rr[0]->name;
                $r[0]->password = $rr[0]->password;
            }
            $customer = $r[0];
        } else {
            $customer = array();
        }
        $sql2 = "select domain from lkt_config where store_id = '$id'";
        $r2 = $db->select($sql2);
        if($r2){
            $domain = $r2[0]->domain;
        }
        $request->setAttribute("customer", $customer);
        $request->setAttribute('id', $id);
        $request->setAttribute('domain', isset($domain) ? $domain : '');
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $lktlog = new LaiKeLogUtils("common/Customer.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();

        $endtime1 = $request->getParameter('endtime');

        $name = addslashes($request->getParameter('name'));
        $customer_number= addslashes($request->getParameter('customer_number'));
        $company = addslashes($request->getParameter('company'));
        $domain= addslashes($request->getParameter('domain'));
        $phone = addslashes($request->getParameter('phone'));
        $price = addslashes($request->getParameter('price'));
        $email = addslashes($request->getParameter('email'));
        $set_admin_name = addslashes(trim($request->getParameter('set_admin_name'))); // 管理员账号
        $password = addslashes(trim($request->getParameter('password'))); // 密码
        $status = $request->getParameter('status');
        $id = $request->getParameter('id');
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

        if(empty($endtime1)){
            echo json_encode(array('status' => '请填写到期时间！'));exit;
        }else{
            $endtime = date("Y-m-d 23:59:59",strtotime($endtime1));
        }
        if(empty($set_admin_name)){
            echo json_encode(array('status' => '管理员账号不能为空！'));exit;
        }
        if(empty($password)){
            echo json_encode(array('status' => '管理员密码不能为空！'));exit;
        }
        // 根据商城id和类型为客户，查询管理员id
        $sql = "select * from lkt_admin where store_id = '$id' and type = 1";
        $r = $db->select($sql);
        if ($r) {
            $adminid = $r[0]->id;
            // 根据商城id、类型为客户、管理员账号、管理员id不同，查询管理员id
            $sql = "select id from lkt_admin where name = '$set_admin_name' and id != '$adminid' and type = 1";
            $r_1 = $db->select($sql);
            if($r_1){
                echo json_encode(array('status' => '管理员账号已存在！'));exit;
            }
            $password1 = $r[0]->password;
            if ($password1 == $password) {
                $password = $password1;
            } else {
                $password = MD5($password);
            }
        }
        if($status == 1){
            $status = 2;
        }
        if (preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $phone)) {

            if ($endtime < $time) {
                echo json_encode(array('status' => '到期时间不正确！'));exit;
            }
            $ssql = "select 1 from lkt_customer where (email = '$email' OR name ='$name' OR customer_number = '$customer_number' ) and id <> '$id' and recycle = 0";
            $sres = $db->select($ssql);
            if (!empty($sres)) {
                echo json_encode(array('status' => '客户名称、客户编号和邮箱重复！'));exit;
            }

            $sql = "update lkt_customer set name = '$name',customer_number = '$customer_number', mobile = '$phone', price = '$price',email='$email' , company = '$company', end_date = '$endtime', status = '$status' where id = '$id' and recycle = 0";
            $r = $db->update($sql);

            if ($r == -1) {
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 未知原因，用户修改失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '未知原因，用户修改失败！'));exit;
            } else {
                // 生成session_id
                $access_token = session_id();
                //修改token
                $ip = $this->get_client_ip();

                $sql = "update lkt_admin set name = '$set_admin_name', password = '$password', tel = '$phone',token = '$access_token',ip = '$ip' where store_id = '$id' and id = '$adminid'";
                $db->update($sql);

                $sql2_0 = "select b.store_id from lkt_customer as a left join lkt_admin as b on a.admin_id = b.id where a.id = '$id'";
                $r2_0 = $db->select($sql2_0);
                $store_id = $r2_0[0]->store_id;
                $sql2 = "update lkt_config set domain = '$domain' where store_id = '$store_id' ";
                $db->update($sql2);

                $Log_content = __METHOD__ . '->' . __LINE__ . ' 用户修改成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '用户修改成功！','suc'=>'1'));exit();
            }
        } else {
            echo json_encode(array('status' => '手机号码格式不正确！'));exit;
        }
    }

    public function getRequestMethods()
    {
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