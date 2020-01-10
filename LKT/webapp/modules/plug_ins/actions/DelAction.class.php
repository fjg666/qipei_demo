<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/plug_ins.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收信息
        $id = intval($request->getParameter('id')); // 插件id

        // 根据轮播图id，删除轮播图信息
        $sql = "delete from lkt_plug_ins where id = '$id'";
        $res = $db->delete($sql);
        if($res > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除插件id为 '.$id.'成功',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除插件id为 '.$id.'成功';
            $lktlog->customerLog($Log_content);
            $db->commit();
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除插件id为 '.$id.' 失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除插件id为 '.$id.' 失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();
        }
		echo json_encode(array('status' =>$res));exit;
    }

    public function execute(){
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>