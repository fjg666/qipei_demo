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

        // 根据优惠券活动ID，删除优惠券活动
        $sql0 = "update lkt_coupon_activity set recycle = 1 where id = '$id' ";
        $r0 = $db->update($sql0);
        if($r0 > 0){
            // 删除未使用优惠券
            $sql1 = "update lkt_coupon set recycle = 1 where hid = '$id' and (type = 0 or type = 2 or type = 3)";
            $r1 = $db->update($sql1);
            if($r1 == -1){
                $JurisdictionAction->admin_record($store_id,$admin_name,'删除优惠券活动id为 '.$id.' 的信息失败',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除优惠券活动id为 '.$id.' 的信息失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>2,'info'=>'删除失败'));
                exit;
            }
            // 根据优惠券活动ID，查询使用中的优惠券
            $sql2 = "select id from lkt_coupon where hid = '$id' and type = 1";
            $r2 = $db->select($sql2);
            if($r2){
                foreach ($r2 as $k => $v){
                    $coupon_id = $v->id;
                    $sql3 = "select id from lkt_order where store_id = '$store_id' and coupon_id = '$coupon_id' and status = 0";
                    $r3 = $db->select($sql3);
                    if(empty($r3)){
                        // 删除未使用优惠券
                        $sql4 = "update lkt_coupon set recycle = 1 where hid = '$id' and id = '$coupon_id'";
                        $r4 = $db->update($sql4);
                        if($r4 == -1){
                            $JurisdictionAction->admin_record($store_id,$admin_name,'删除优惠券活动id为 '.$id.' 的信息失败',3);
                            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除优惠券活动id为 '.$id.' 的信息失败';
                            $lktlog->customerLog($Log_content);
                            $db->rollback();

                            echo json_encode(array('status' =>2,'info'=>'删除失败'));
                            exit;
                        }
                    }
                }
            }
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除优惠券活动id为 '.$id.' 的信息成功',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除优惠券活动id为 '.$id.' 的信息成功';
            $lktlog->customerLog($Log_content);

            $db->commit();

            echo json_encode(array('status' =>1,'info'=>'删除成功'));
            exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除优惠券活动id为 '.$id.' 的信息失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除优惠券活动id为 '.$id.' 的信息失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>2,'info'=>'删除失败'));
            exit;
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