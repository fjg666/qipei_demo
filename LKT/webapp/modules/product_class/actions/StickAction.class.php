<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');

class StickAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

        $cid = $request->getParameter("cid"); // 分类id
        $sid = $request->getParameter("sid"); // 上级分类sid
        $sql = "select MAX(sort) as sort from lkt_product_class where recycle = 0 and store_id = '$store_id' and sid = '$sid' ";
        $rr = $db->select($sql);
        $sort = $rr[0]->sort;
        $sort= $sort +1 ;

        $sql = "update lkt_product_class set sort = '$sort' where recycle = 0 and store_id = '$store_id' and cid = '$cid'";
        $r = $db->update($sql);
        echo $r;
        exit;
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>