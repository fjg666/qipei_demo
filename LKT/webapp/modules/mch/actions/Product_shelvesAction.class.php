<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Product_shelvesAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/mch.log");
        // 1.开启事务
        $db->begin();

        header('Content-Type:application/json; charset=utf-8');
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号

        $id = intval($request->getParameter("id")); // 商品id
        $mch_status = intval($request->getParameter("mch_status")); // 审核状态
        $refuse_reasons = $request->getParameter("reason"); // 审核状态

        $sql = "select status,num,mch_id from lkt_product_list where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $msg_title = "商品通过审核！";
        $msg_content = "您ID为 ".$id." 的商品已经通过审核！";
        if($r){
            $mch_id = $r[0]->mch_id;
            $sql = "select user_id from lkt_mch where id={$mch_id}";
            $res = $db->select($sql);
            if($mch_status == 1){
                $sql = "update lkt_product_list set status = 2,mch_status=2 where store_id = '$store_id' and mch_id = '$mch_id' and id = '$id'";
                $rr = $db->update($sql);
                if($rr != -1){
                    $sql3 = "update lkt_mch set is_open = 1 where store_id = '$store_id' and id = '$mch_id'";
                    $db->update($sql3);

                    /**商品审核通过*/
                    $pusher = new LaikePushTools();
                    $pusher->pushMessage($res[0]->user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);

                    $JurisdictionAction->admin_record($store_id,$admin_name,'通过店铺ID: '.$mch_id .' 商品ID为 '.$id.' 审核',3);
                    $Log_content = __METHOD__ . '->' . __LINE__ . '通过店铺ID: '.$mch_id .' 商品ID为 '.$id.' 审核成功';
                    $lktlog->customerLog($Log_content);
                    $db->commit();

                    echo json_encode(array('msg' => '通过审核成功!','status' => 1)); exit;
                }else{
                    $JurisdictionAction->admin_record($store_id,$admin_name,'通过店铺ID: '.$mch_id .' 商品ID为 '.$id.' 审核失败',3);
                    $Log_content = __METHOD__ . '->' . __LINE__ . '通过店铺ID: '.$mch_id .' 商品ID为 '.$id.' 审核失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    $msg_title = "您ID为 ".$id." 的商品未通过审核！";
                    $msg_content = "拒绝原因：".$refuse_reasons;
                    /**商品审核通过*/
                    $pusher = new LaikePushTools();
                    $pusher->pushMessage($res[0]->user_id, $db, $msg_title, $msg_content,$store_id,'');
                    echo json_encode(array('msg' => '通过审核失败!','status' => 0)); exit;
                }
            }else{
                if(empty($refuse_reasons)){
                    echo json_encode(array('status' => '请填写拒绝原因！'));
                    exit;
                }
                $sql = "update lkt_product_list set mch_status=3,refuse_reasons='$refuse_reasons' where id = '$id'";
                $rr = $db->update($sql);
                if($rr != -1){

                    $msg_title = "您ID为 ".$id." 的商品未通过审核！";
                    $msg_content = "拒绝原因：".$refuse_reasons;

                    /**商品审核未通过*/
                    $pusher = new LaikePushTools();
                    $pusher->pushMessage($res[0]->user_id, $db, $msg_title, $msg_content,$store_id,$admin_name);

                    $JurisdictionAction->admin_record($store_id,$admin_name,'拒绝店铺ID: '.$mch_id .' 商品ID为 '.$id.' 审核成功',3);
                    $Log_content = __METHOD__ . '->' . __LINE__ . '拒绝店铺ID: '.$mch_id .' 商品ID为 '.$id.' 审核成功';
                    $lktlog->customerLog($Log_content);
                    $db->commit();

                    echo 1;
                    exit;
                    echo json_encode(array('msg' => '拒绝审核成功!','status' => 1)); exit;
                }else{
                    $JurisdictionAction->admin_record($store_id,$admin_name,'拒绝店铺ID: '.$mch_id .' 商品ID为 '.$id.' 审核失败',3);
                    $Log_content = __METHOD__ . '->' . __LINE__ . '拒绝店铺ID: '.$mch_id .' 商品ID为 '.$id.' 审核失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    echo 0;
                    exit;
                    echo json_encode(array('msg' => '拒绝审核成功!','status' => 0)); exit;
                }
            }
        }else{
            echo json_encode(array('msg' => '参数错误!','status' => 0)); exit;
        }

    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>