<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class delAction extends Action {

    public function getDefaultView() {

    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/comments.log");
        // 1.开启事务
        $db->begin();
        // 接收信息
        $id = intval($request->getParameter('id'));
        $sql = "delete from lkt_comments where store_id = '$store_id' and id = '$id'";
        $res = $db->delete($sql);
        if($res > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除评论id为'.$id.'的信息成功',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除评论id为'.$id.'的信息成功';
            $lktlog->customerLog($Log_content);

            $db->commit();
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除评论id为'.$id.'的信息失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除评论id为'.$id.'的信息失败';
            $lktlog->customerLog($Log_content);

            $db->rollback();
        }
        echo json_encode(array('status'=>$res));
        exit;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>