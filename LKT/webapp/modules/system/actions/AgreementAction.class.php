<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class AgreementAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Config');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Agreement');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Aboutus');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Agreement_add');
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Agreement_modify');
        $button[5] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Agreement_del');

        $sql = "select * from lkt_agreement where store_id = '$store_id'";
        $r = $db->select($sql);
       

        $request->setAttribute('list', $r);
        $request->setAttribute('button', $button);

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