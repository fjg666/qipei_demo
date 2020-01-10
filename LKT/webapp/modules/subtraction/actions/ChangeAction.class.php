<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class ChangeAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/subtraction.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('$admin_name'); // 管理员

        $id = $request->getParameter('id'); // 满减活动ID

        $time = date("Y-m-d H:i:s");
        $sql0 = "select starttime,endtime,status from lkt_subtraction where store_id = '$store_id' and id = '$id'";
        $r0 = $db->select($sql0);
        if($r0){
            $starttime = $r0[0]->starttime; // 开始时间
            $endtime = $r0[0]->endtime; // 结束时间
            $status = $r0[0]->status; // 状态
            if($status == 1){ // 当为 未开始 时
                if($starttime > $time){ // 当 开始时间 > 当前时间
                    echo json_encode(array('status' => 2,'info' => '还未到开始时间!'));exit;
                }else{
                    // 修改满减活动状态(开始)
                    $sql1 = "update lkt_subtraction set status = 2 where store_id = '$store_id' and id = '$id'";
                    $r1 = $db->update($sql1);
                    if($r1 == -1){
                        $JurisdictionAction->admin_record($store_id, $admin_name, '开启满减活动ID为'.$id.'失败' , 5);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 开启满减活动ID为'.$id.'失败';
                        $lktlog->customerLog($Log_content);
                        $db->rollback();

                        echo json_encode(array('status' => 0,'info' => '操作失败!'));exit;
                    }
                }
                $JurisdictionAction->admin_record($store_id, $admin_name, '开启满减活动ID为'.$id , 5);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 开启满减活动ID为'.$id.'成功';
                $lktlog->customerLog($Log_content);
            }else{
                if($endtime > $time){ // 当 结束时间 > 当前时间
                    if($status == 2){
                        // 修改满减活动状态(禁止)
                        $sql1 = "update lkt_subtraction set status = 3 where store_id = '$store_id' and id = '$id'";
                        $r1 = $db->update($sql1);
                    }else{
                        // 修改满减活动状态(禁止)
                        $sql1 = "update lkt_subtraction set status = 2 where store_id = '$store_id' and id = '$id'";
                        $r1 = $db->update($sql1);
                    }
                }else{
                    // 修改满减活动状态(结束)
                    $sql1 = "update lkt_subtraction set status = 4 where store_id = '$store_id' and id = '$id'";
                    $r1 = $db->update($sql1);
                }
                if($r1 == -1){
                    $JurisdictionAction->admin_record($store_id, $admin_name, '结束满减活动ID为'.$id.'失败' , 5);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 结束满减活动ID为'.$id.'失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('status' => 0,'info' => '操作失败!'));exit;
                }
                $JurisdictionAction->admin_record($store_id, $admin_name, '结束满减活动ID为'.$id , 5);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 结束满减活动ID为'.$id.'成功';
                $lktlog->customerLog($Log_content);
            }
            $db->commit();
            echo json_encode(array('status' => 1,'info' => '操作成功!'));exit;
        }
    }

    public function execute() {
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>