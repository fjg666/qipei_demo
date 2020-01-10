<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');

class DelAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收信息
        $id = intval($request->getParameter('id'));                 // 提现id
        $m = intval($request->getParameter('m'));                   // 参数 1.通过 2.拒绝
        $user_id = trim($request->getParameter('user_id'));         // 用户id
        $money = floatval(trim($request->getParameter('money')));   // 提款金额
        $refuse = trim($request->getParameter('reason'));           // 拒绝原因

        $log = new LaiKeLogUtils('common/finance.log');             // 日志

        // 查询提现人信息
        $sql = "select * from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
        $r = $db->select($sql);
        $ymoney = $r[0]->money; // 原有金额

        // 查询记录
        $sql = "select money,add_date from lkt_record where store_id = '$store_id' and id = '$id'";
        $res = $db->select($sql);


        // 开始事物
        $db->begin();

        if($m == 1){ // 通过

            $event = $user_id . "提现了" . $money;
            // 在操作列表里添加一条数据
            $sql = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values('$store_id','$user_id','$money','$ymoney','$event',21)";
            $r = $db->insert($sql);
            if ($r < 1) {
               $db->rollback();
               $log -> customerLog(__LINE__.":【".$id."】提现审核通过失败：$sql \r\n");
               echo 2;exit;
            }

            // 根据id,修改提现列表中数据的状态
        	$sql = "UPDATE lkt_withdraw SET status=1 WHERE store_id = '$store_id' and id = '$id' and status=0";
	        $r = $db->update($sql);
            if ($r < 0) {
               $db->rollback();
               $log -> customerLog(__LINE__.":【".$id."】提现审核通过失败：$sql \r\n");
               echo 2;exit;
            }

            $msg_title = "余额提现申请审批通过！";
            $msg_content = "您的提现申请已通过审核，提现金额将会在1-3个工作日到账。";

            $db->admin_record($store_id,$admin_name,' 通过id为 '.$id.' 的提现信息',6);
            $log -> customerLog(__LINE__.":【".$id."】提现审核通过成功！ \r\n");
            /**余额提现成功通知*/
            $pusher = new LaikePushTools();
            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);

        }else{ // 拒绝

            // 根据微信昵称,修改会员列表里的金额
            $sql = "update lkt_user set money = money+'$money' where store_id = '$store_id' and user_id = '$user_id'";
            $r = $db->update($sql);
            if ($r < 0) {
               $db->rollback();
               $log -> customerLog(__LINE__.":【".$id."】提现审核拒绝失败：$sql \r\n");
               echo 2;exit;
            }

            $event = $user_id . "提现" . $money . "被拒绝";
            // 在操作列表里添加一条数据
            $sql = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values('$store_id','$user_id','$money','$ymoney','$event',22)";
            $r = $db->insert($sql);
            if ($r < 0) {
               $db->rollback();
               $log -> customerLog(__LINE__.":【".$id."】提现审核拒绝失败：$sql \r\n");
               echo 2;exit;
            }

        	$sql = "UPDATE lkt_withdraw SET status=2,refuse='$refuse' WHERE store_id = '$store_id' and id = '$id' and status=0";
	        $r = $db->update($sql);
            if ($r < 0) {
               $db->rollback();
               $log -> customerLog(__LINE__.":【".$id."】提现审核拒绝失败：$sql \r\n");
               echo 2;exit;
            }

            $msg_title = "余额提现失败！";
            $msg_content = "您申请的提现被驳回！驳回原因：".$refuse;

            $db->admin_record($store_id,$admin_name,' 拒绝id为 '.$id.' 的提现信息',6);
            $log -> customerLog(__LINE__.":【".$id."】提现审核拒绝成功！ \r\n");

            /**余额提现失敗通知*/
            $pusher = new LaikePushTools();
            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);

        }
        $db->commit();
        echo 1;exit;
       
    }

    public function execute(){
        return $this->getDefaultView();
    }


    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>