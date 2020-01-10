<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  17:50
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $log = new LaiKeLogUtils('common/message.log');

        // 接收信息
        $id = $request->getParameter('id'); //id

        $sql = "delete from lkt_message_list where id = '$id'";
        $r = $db->delete($sql);
        if($r){
            $db->admin_record($store_id,$admin_name,' 删除短信ID为 '.$id.'成功',3);
            $log -> customerLog(__LINE__.":删除短信成功： 删除短信ID为 ".$id."成功\r\n");
            $res = array('status' => '1','info'=>'删除成功！');
            echo json_encode($res);exit;
        }else{
            $db->admin_record($store_id,$admin_name,' 删除短信ID为 '.$id.'失败',3);
            $log -> customerLog(__LINE__.":添加短信模版失败：短信模板名称不能为空！\r\n");
            $res = array('status' => '0','info'=>'删除失败！');
            echo json_encode($res);exit;
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