<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class delAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/banner.log");
        // 1.开启事务
        $db->begin();
        // 接收信息
        $id = intval($request->getParameter('id')); // 轮播图id

        $sql = "select * from lkt_guide where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $image = ServerPath::getimgpath($r[0]->image,$store_id); // 轮播图
        // 根据轮播图id，删除轮播图信息
        $sql = "delete from lkt_guide where store_id = '$store_id' and id = '$id'";
        $r1 = $db->delete($sql);
        if($r1 > 0){
            @unlink ($image);

            $JurisdictionAction->admin_record($store_id,$admin_name,'删除引导图ID为'.$id,3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除引导图ID为'.$id.'成功,类型为 '.$store_type;
            $lktlog->customerLog($Log_content);

            $db->commit();
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除引导图ID为'.$id.'失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除引导图ID为'.$id.'失败,类型为 '.$store_type;
            $lktlog->customerLog($Log_content);

            $db->rollback();
        }

        echo json_encode(array('status' =>1));
    }

    public function execute(){
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}

?>