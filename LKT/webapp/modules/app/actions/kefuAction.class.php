<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');

class kefuAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 熊孔钰
     * @date 2019/03/20  15:07
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员id
        $store_id = intval(trim($request->getParameter('store_id'))); // 商城id

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $customer_service = $r[0]->customer_service;  // 客服
            $request->setAttribute("customer_service",$customer_service);
        }
        
        return View :: INPUT;
    }

    public function execute(){

        return;
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>