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

        // 接收信息
        $id = intval($request->getParameter('id')); // 插件id
 
        $sql = "delete from lkt_system_tell where id='$id'";
        $res = $db -> delete($sql);
		
        if($res > 0){
            $db->admin_record(0,$admin_name,'删除公告id为'.$id,2);

            echo json_encode(array('status' =>1));exit;
        }else{
            $db->admin_record(0,$admin_name,'删除公告id为'.$id.'失败',2);

            echo json_encode(array('status' =>0)); exit;
        }
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