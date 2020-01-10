<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Withdraw_examineAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/mch.log");

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $id = intval($request->getParameter('id')); // 提现id
        $m = intval($request->getParameter('m')); // 参数
        $user_id = $request->getParameter('user_id'); // 用户id
        $money = $request->getParameter('money'); // 提款金额
        $s_charge = $request->getParameter('s_charge'); // 手续费
        $refuse = $request->getParameter('reason'); // 拒绝原因

        $sql = "select id,account_money from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r = $db->select($sql);
        $shop_id = $r[0]->id; // 店铺id
        $yaccount_money = $r[0]->account_money; // 原有店铺金额

        $sql = "select money,add_date from lkt_record where store_id = '$store_id' and id = '$id'";
        $res = $db->select($sql);
        // 根据提现id，修改状态信息
        if($m == 1){
            $event = '店主'.$user_id . "提现了" . $money;
            // 在操作列表里添加一条数据
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type,is_mch) values ('$store_id','$user_id','$money','$yaccount_money','$event',21,1)";
            $r = $db->insert($sqll);

            $sql2 = "insert into lkt_mch_account_log(store_id,mch_id,price,account_money,status,type,addtime) values ('$store_id','$shop_id','$money','$yaccount_money',2,3,CURRENT_TIMESTAMP)";
            $db->insert($sql2);
            // 根据id,修改提现列表中数据的状态
            $sql = "UPDATE lkt_withdraw SET status=1 WHERE store_id = '$store_id' and id = '$id'";
            $db->update($sql);

            $msg_title = "店铺提现成功！";
            $msg_content = "您提现的".$money."元已到账，快去看看吧！";

            $JurisdictionAction->admin_record($store_id,$admin_name,' 通过id为 '.$id.' 的提现信息 ',6);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 通过id为 '.$id.' 的提现信息';
            $lktlog->customerLog($Log_content);

            /**店铺提现通知*/
            $pusher = new LaikePushTools();
            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);
            echo 1;
            return;
        }else{
            $sql = "update lkt_mch set account_money = account_money + '$money' where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
            $r = $db->update($sql);

            $event = '店主'.$user_id . "提现" . $money . "被拒绝";
            // 在操作列表里添加一条数据
            $sql = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type,is_mch) values('$store_id','$user_id','$money','$yaccount_money','$event',22,1)";
            $r = $db->insert($sql);

            $sql = "UPDATE lkt_withdraw SET status=2,refuse='$refuse' WHERE store_id = '$store_id' and id = '$id'";
            $db->update($sql);

            $msg_title = "店铺提现失败！";
            $msg_content = "您".$res[0]->add_date."申请的提现被驳回！驳回原因：".$refuse;

            $JurisdictionAction->admin_record($store_id,$admin_name,' 拒绝id为 '.$id.' 的提现信息 ',6);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 拒绝id为 '.$id.' 的提现信息';
            $lktlog->customerLog($Log_content);
            /**店铺提现通知*/
            $pusher = new LaikePushTools();
            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);
            echo 1;
            return;
        }

    }

    public function execute() {
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}



?>