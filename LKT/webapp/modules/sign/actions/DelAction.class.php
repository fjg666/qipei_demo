<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {

    public function getDefaultView() {
        return;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/sign.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收信息
        $user_id = $request->getParameter('user_id'); // 用户id

        $sql = "update lkt_sign_record set recovery = 1 where store_id = '$store_id' and user_id = '$user_id' and type = 0";
        $r = $db->update($sql);
        if($r > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除用户 '.$user_id.'的签到信息成功',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除用户 '.$user_id.'的签到信息成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '1','info'=>'成功！'));
            exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除用户 '.$user_id.'的签到信息失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除用户 '.$user_id.'的签到信息失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '1','info'=>'失败！'));
            exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>