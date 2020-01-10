<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class CoupondelAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/coupon.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $id = intval($request->getParameter('id')); // 活动id

        $sql = "update lkt_coupon set recycle = 1 where store_id = '$store_id' and id = '$id' ";
        $r0 = $db->update($sql);

        if($r0 == -1){
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除优惠券id为 '.$id.' 的信息失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除优惠券id为 '.$id.' 的信息失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>0));
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除优惠券id为 '.$id.' 的信息成功',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除优惠券id为 '.$id.' 的信息成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' =>1));
        }
        return;
    }

    public function execute(){
        return $this->getDefaultView();
    }


    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>