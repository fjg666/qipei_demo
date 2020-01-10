<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class SetAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql1 = "select * from lkt_user_address where store_id = '$store_id' and uid = 'admin'";
        $r = $db->select($sql1);
        if($r){
            $r = $r[0];
        }

        $request->setAttribute("list",$r);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $name = trim($request -> getParameter('name'));
        $tel = trim($request -> getParameter('tel'));
        $lktlog = new LaiKeLogUtils("common/return.log");

        if(strlen($tel) >15){
        	echo json_encode(array('status' =>'手机号码格式错误！' ));exit;
        }
        
        $address = trim($request -> getParameter('address'));
        $sql1 = "select * from lkt_user_address where store_id = '$store_id' and uid = 'admin'";
        
        $r = $db->select($sql1);
        if($r){
            $sql = "update lkt_user_address set name = '$name', tel = '$tel',address_xq = '$address' where store_id = '$store_id' and uid = 'admin'";
            $r = $db->update($sql);
            if ($r > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改用户地址成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改用户地址失败！sql:" . $sql);
            }
        }else{
            $sqll = "insert into lkt_user_address (store_id,name,tel,address_xq,uid) values ('$store_id','$name','$tel','$address','admin')";
            $r = $db -> insert($sqll);
            if ($r > 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加用户地址成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加用户地址失败！sql:" . $sqll);
            }
        }

        if($r == -1) {
        	echo json_encode(array('status' =>'未知原因，修改失败！' ));exit;
        } else {
        	echo json_encode(array('status' => '修改成功！','suc'=>'1'));exit;
        }

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>