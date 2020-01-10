<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Subtraction_delAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/subtraction.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('$admin_name'); // 管理员

        $id = addslashes(trim($request->getParameter('id'))); // 满减记录id

        $sql1 = "delete from lkt_subtraction_record where id = '$id'";
        $r1 = $db->delete($sql1);
        if($r1 > 0){
            $JurisdictionAction->admin_record($store_id, $admin_name, '删除满减记录ID为'.$id.'成功' , 5);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除满减记录ID为'.$id.'成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => 1,'info' => '删除成功!'));exit;
        }else{
            $JurisdictionAction->admin_record($store_id, $admin_name, '删除满减记录ID为'.$id.'失败' , 5);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除满减记录ID为'.$id.'失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => 0,'info' => '删除失败!'));exit;
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