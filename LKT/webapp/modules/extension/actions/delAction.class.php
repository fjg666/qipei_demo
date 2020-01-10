<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');

class delAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收信息
        $id = intval($request->getParameter('id')); // 轮播图id
        // 根据轮播图id，删除轮播图信息
        $sql = "delete from lkt_extension where store_id = '$store_id' and id = '$id'";
        $db->delete($sql);

        $db->admin_record($store_id,$admin_name,'修改推广图id为'.$id,2);

        echo json_encode(array('status' =>"1"));
        return;
    }

    public function execute(){
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>