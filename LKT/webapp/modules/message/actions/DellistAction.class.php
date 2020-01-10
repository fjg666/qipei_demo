<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');

class DellistAction extends Action {
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

        // 接收信息
        $id = $request->getParameter('id'); //id

        $sql = "select id from lkt_message_list where store_id = '$store_id' and Template_id = '$id'";
        $r = $db->select($sql);
        if($r){
            $db->admin_record($store_id,$admin_name,' 删除短信模板ID为 '.$id.'失败',3);

            $res = array('status' => '2','info'=>'该模板正在使用！');
            echo json_encode($res);exit;
        }else{
            $sql = "delete from lkt_message where id = '$id'";
            $db->delete($sql);

            $db->admin_record($store_id,$admin_name,' 删除短信模板ID为 '.$id.'成功',3);

            $res = array('status' => '1','info'=>'删除成功！');
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