<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=sale&action=add');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=sale&action=modify');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=sale&action=del');

        $sql = "select * from lkt_service_address where store_id = '$store_id' and uid = 'admin' ";
        $r = $db->select($sql);
        $request->setAttribute("list",$r);
        $request->setAttribute('button', $button);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>