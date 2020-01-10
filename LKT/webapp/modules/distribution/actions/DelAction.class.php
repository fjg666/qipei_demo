<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class DelAction extends Action{

    public function getDefaultView(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $id = intval($request->getParameter('id')); // id

        $log = new LaiKeLogUtils('common/distribution.log');// 日志

        // 根据产品id，删除产品信息
        $sql = "delete from lkt_user_distribution where store_id = '$store_id' and id = '$id'";
        $res = $db->delete($sql);
        if($res > 0){
            $log -> customerLog(__LINE__.":删除分销商详细信息成功！\r\n");
            $db->admin_record($store_id,$admin_name,'删除分销商详细信息id为'.$id,1);
        }else{
            $log -> customerLog(__LINE__.":删除分销商详细信息失败：$sql\r\n");
            $db->admin_record($store_id,$admin_name,'删除分销商详细信息id为'.$id.'失败',1);
        }
        echo json_encode(array('status' => $res));
        exit;
    }

    public function execute(){
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>