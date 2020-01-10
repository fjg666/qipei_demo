<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');

class is_defaultAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收信息
        $id = $request->getParameter('id'); // 产品id

        $sql = "update lkt_service_address set is_default = 0 where store_id = '$store_id' and uid = 'admin'";
        $db->update($sql);

        $sql = "update lkt_service_address set is_default = 1 where store_id = '$store_id' and uid = 'admin' and id = '$id'";
        $r = $db->update($sql);

        $db->admin_record($store_id,$admin_name,' 修改售后地址id为 '.$id.' 为默认 ',2);

        $res = array('status' => '1','info'=>'成功！');
        echo json_encode($res);
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