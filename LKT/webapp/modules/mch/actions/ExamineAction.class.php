<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');

require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ExamineAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = trim($request->getParameter('id'));

        $sql1 = "select m.*,u.user_name from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where m.store_id = '$store_id' and m.id = '$id'";
        $res = $db -> select($sql1);
        if($res){
            foreach ($res as $k => $v){
                $v->logo = ServerPath::getimgpath($v->logo,$store_id);
                $v->business_license = ServerPath::getimgpath($v->business_license,$store_id);
            }
        }
        $list = $res ? $res[0]:array();

        $request->setAttribute('list',(object)$list);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/mch.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = trim($request->getParameter('id'));
        $user_id = trim($request->getParameter('user_id'));
        $review_status = trim($request->getParameter('review_status'));
        $review_result = trim($request->getParameter('review_result'));
        $deposit = trim($request->getParameter('deposit')); //保证金

        $sql0 = "select * from lkt_mch_config where store_id = '$store_id'";
        $r0 = $db -> select($sql0);
        if($r0){
            $logo = $r0[0]->logo;
        }else{
            $logo = '';
        }

        $rew = " deposit = '$deposit',logo = '$logo',review_status = '$review_status',review_result = '$review_result',review_time = CURRENT_TIMESTAMP ";
        if($review_status == 1){
            $res = '通过';
        }else{
            $res = '拒绝';
        }

        $sql = "update lkt_mch set $rew where id = '$id'";
        $r = $db->update($sql);
        if($r == -1){
            $JurisdictionAction->admin_record($store_id,$admin_name,$res.$user_id.' 开店请求 ',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . $res.$user_id.' 开店请求 ';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '未知原因，修改失败！'));
            exit;
        }else{

            $sql = "select user_id,name from lkt_mch where id={$id}";
            $reee = $db->select($sql);

            if ($review_status == 1) {
                $msg_title = "店铺申请通过审核！";
                $msg_content = "您店铺【 ".$reee[0]->name."】 已经通过审核，快去看看吧！";
            }else{
                $msg_title = "店铺申请未通过审核！";
                $msg_content = "您店铺【 ".$reee[0]->name."】 未通过审核！驳回原因：".$review_result;
            }

            $JurisdictionAction->admin_record($store_id,$admin_name,$res.$user_id.' 开店请求 ',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . $res.$user_id.' 开店请求 ';
            $lktlog->customerLog($Log_content);
            $db->commit();

            /**店铺申请通知*/
            $pusher = new LaikePushTools();
            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);

            echo json_encode(array('status' => '修改成功！', 'suc' => '1'));
            exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>