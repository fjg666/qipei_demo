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
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $id = intval($request->getParameter('id')); //id
        // 根据id删除信息
        $sql = "delete from lkt_background_color where store_id = '$store_id' and id = '$id'";
        $res = $db->delete($sql);

        $db->admin_record($store_id,$admin_name,'删除前台背景颜色id为'.$id,3);

        echo json_encode(array('status'=>'1')); exit;
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