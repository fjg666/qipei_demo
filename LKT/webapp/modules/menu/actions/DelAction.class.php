<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/menu.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收信息
        $id = $request->getParameter('id'); //id
        $num = 0;
        $status = 0;
        // 根据id,查询他的下级
        $sql = "select id from lkt_core_menu where s_id = '$id' and recycle = 0";
        $r = $db->select($sql);
        if($r){ // 有下级
            $status = 1;
        }
        if($status == 0){
            $sql = "update lkt_core_menu set recycle = 1 where id = '$id'";
            $db->update($sql);

            $JurisdictionAction->admin_record($store_id,$admin_name,'删除菜单id为 '.$id.' 成功 ',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除菜单id为 '.$id.' 成功 ';
            $lktlog->customerLog($Log_content);
            $db->commit();

            $res = array('status' => 1,'info'=>'删除成功！');
            echo json_encode($res);
            return;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除菜单id为 '.$id.' 失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除菜单id为 '.$id.' 失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            $res = array('status' => 0,'info'=>'删除失败！');
            echo json_encode($res);
            return;
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