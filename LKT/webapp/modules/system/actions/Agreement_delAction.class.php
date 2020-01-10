<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Agreement_delAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $id = addslashes(trim($request->getParameter('id'))); // id

        $log = new LaiKeLogUtils('common/system.log');// 日志

        $sql = "delete from lkt_agreement where store_id = '$store_id' and id = '$id'";
        $r = $db->delete($sql);
        if ($r > 0) {
            $db->admin_record($store_id,$admin_name,' 删除协议id为 '.$id.' 的信息成功！',3);
            $log -> customerLog(__LINE__.":删除协议成功！ \r\n");
            echo json_encode(array('status' =>1));
        }else{
            $db->admin_record($store_id,$admin_name,' 删除协议id为 '.$id.' 的信息失败！',3);
            $log -> customerLog(__LINE__.":删除协议失败：$sql \r\n");
            echo json_encode(array('status' =>0));
        }

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