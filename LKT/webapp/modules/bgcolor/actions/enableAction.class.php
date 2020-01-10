<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');

class enableAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $id = intval($request->getParameter('id')); // id
        $sql = "update lkt_background_color set status = 0 where store_id = '$store_id'";
        $r = $db->update($sql);
        $sql = "update lkt_background_color set status = 1 where store_id = '$store_id' and id = '$id'";
        $r = $db->update($sql);
       
        if($r == 1){
            $db->admin_record($store_id,$admin_name,'启用前台背景颜色id为'.$id,5);

            echo json_encode(array('status'=>'1')); exit;
        }else{
            $db->admin_record($store_id,$admin_name,'启用前台背景颜色id为'.$id.'失败',5);

            echo json_encode(array('status'=>'0')); exit;
        }
    }

    public function execute(){
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>