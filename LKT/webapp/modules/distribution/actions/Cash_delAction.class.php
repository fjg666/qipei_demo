<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Cash_delAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
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

        $log = new LaiKeLogUtils('common/distribution.log');

        $sql = "select * from lkt_distribution_withdraw where store_id = '$store_id' and id = '$id'";
        $res = $db->select($sql);
        if ($res) {
            
            // 根据提现id，修改状态信息
            if($m == 1){
                $event = $user_id . "佣金提现" . $money."元成功！";
                // 在操作列表里添加一条数据
                $sql = "insert into lkt_distribution_record (store_id,user_id,money,event,type) values('$store_id','$user_id','$money','$event',2)";
                $r = $db->insert($sql);

                // 根据id,修改提现列表中数据的状态
                $sql = "UPDATE lkt_distribution_withdraw SET status=1 WHERE store_id = '$store_id' and id = '$id'";
                $db->update($sql);

                $msg_title = "佣金提现成功！";
                $msg_content = "您提现的".$res[0]->money."元佣金已到账，快去看看吧！";

                $db->admin_record($store_id,$admin_name,' 通过id为 '.$id.' 的佣金提现信息',6);
                $log -> customerLog(__LINE__.":批准id为 ".$id." 的提现\r\n");

                /**佣金提现通知*/
                $pusher = new LaikePushTools();
                $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);
                echo 1;
                return;
            }else{
                // 根据微信昵称,修改会员列表里的金额
                $sql = "update lkt_user_distribution set commission = commission+'$money' where store_id = '$store_id' and user_id = '$user_id'";
                $r = $db->update($sql);

                $event = $user_id . "佣金提现" . $money . "被拒绝";
                // 在操作列表里添加一条数据
                $sql = "insert into lkt_distribution_record (store_id,user_id,money,event,type) values('$store_id','$user_id','$money','$event',2)";
                $r = $db->insert($sql);

                $sql = "UPDATE lkt_distribution_withdraw SET status=2,refuse='$refuse' WHERE store_id = '$store_id' and id = '$id'";
                $db->update($sql);

                $msg_title = "佣金提现失败！";
                $msg_content = "您".$res[0]->add_date."申请的提现被驳回！驳回原因：".$refuse;

                $db->admin_record($store_id,$admin_name,' 拒绝id为 '.$id.' 的佣金提现信息',6);
                $log -> customerLog(__LINE__.":拒绝id为 ".$id." 的提现：驳回原因：".$refuse." \r\n");

                /**佣金提现通知*/
                $pusher = new LaikePushTools();
                $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);
                echo 1;
                return;
            }

        }else{
            echo "订单不存在！";
            return;
        }
       
    }

    public function execute(){
        return $this->getDefaultView();
    }


    public function getRequestMethods(){
        return Request :: NONE;
    }
}

?>