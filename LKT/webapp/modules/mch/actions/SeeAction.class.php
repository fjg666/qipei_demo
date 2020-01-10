<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class SeeAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = trim($request->getParameter('id'));

        $sql1 = "select m.*,u.user_name from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where m.store_id = '$store_id' and m.id = '$id'";
        $res = $db -> select($sql1);

        if($res){
            foreach ($res as $k => $v){
                $v->logo = ServerPath::getimgpath($v->logo,$store_id);
                $v->business_license = ServerPath::getimgpath($v->business_license,$store_id);
            }
        }
        $list = $res ? $res[0]:array();

        $request->setAttribute('list',(object)$list);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>