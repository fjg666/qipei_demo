<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ConfigAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_coupon_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $is_status = $r[0]->is_status;
            $coupon_del = $r[0]->coupon_del;
            $coupon_day = $r[0]->coupon_day;
            $activity_del = $r[0]->activity_del;
            $activity_day = $r[0]->activity_day;
            $limit_type = $r[0]->limit_type;
            $coupon_type = explode(',',$r[0]->coupon_type);
        }

        $request->setAttribute('is_status', isset($is_status) ? $is_status : '');
        $request->setAttribute('coupon_del', isset($coupon_del) ? $coupon_del : '');
        $request->setAttribute('coupon_day', isset($coupon_day) ? $coupon_day : '');
        $request->setAttribute('activity_del', isset($activity_del) ? $activity_del : '');
        $request->setAttribute('activity_day', isset($activity_day) ? $activity_day : '');
        $request->setAttribute('limit_type', isset($limit_type) ? $limit_type : '');
        $request->setAttribute('coupon_type', isset($coupon_type) ? $coupon_type : '');

        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/coupon.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $is_status = addslashes(trim($request->getParameter('is_status'))); // 是否开启优惠券
        $coupon_del = addslashes($request->getParameter('coupon_del')); // 是否自动清除过期优惠券
        $coupon_day = addslashes($request->getParameter('coupon_day')); // 优惠券删除天数
        $activity_del = addslashes($request->getParameter('activity_del')); // 是否自动清除过期活动
        $activity_day = addslashes($request->getParameter('activity_day')); // 优惠券活动删除天数
        $limit_type = addslashes($request->getParameter('limit_type')); // 限领设置
        $coupon_type = $request->getParameter('coupon_type'); // 优惠券类型设置
        $coupon_type = implode(",", $coupon_type);
        if($coupon_del == 1){
            if($coupon_day <= 0){
                echo json_encode(array('status' =>'优惠券过期删除天数不正确！' ));exit;
            }
        }
        if($activity_del == 1){
            if($activity_day <= 0){
                echo json_encode(array('status' =>'优惠券活动过期删除天数不正确！' ));exit;
            }
        }

        $sql = "select * from lkt_coupon_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $sql = "update lkt_coupon_config set is_status = '$is_status',coupon_del = '$coupon_del',coupon_day = '$coupon_day',activity_del = '$activity_del',activity_day = '$activity_day',limit_type = '$limit_type',coupon_type = '$coupon_type',modify_date = CURRENT_TIMESTAMP where store_id = '$store_id'";
            $r_1 = $db->update($sql);
            if($r_1 == -1) {
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改优惠券设置失败',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改优惠券设置失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'未知原因，优惠券设置修改失败！' ));exit;
            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改优惠券设置成功',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改优惠券设置成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '优惠券设置修改成功！','suc'=>'1'));exit;
            }
        }else{
            $sql = "insert into lkt_coupon_config(store_id,is_status,coupon_del,coupon_day,activity_del,activity_day,limit_type,coupon_type,modify_date) values('$store_id','$is_status','$coupon_del','$coupon_day','$activity_del','$activity_day','$limit_type','$coupon_type',CURRENT_TIMESTAMP)";
            $r_1 = $db->insert($sql);
            if($r_1 == -1) {
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加优惠券设置失败',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加优惠券设置失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '未知原因，优惠券设置添加失败！'));exit;
            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加优惠券设置成功',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加优惠券设置成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' =>'优惠券设置添加成功！','suc'=>'1'));exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>