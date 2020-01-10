<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');

class AjaxAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

        $cid = $request->getParameter("v"); // 分类id

        // 根据上级id为0,查询产品分类id、上级id、分类名称
        $sql = "select cid,sid,pname from lkt_product_class where recycle = 0 and store_id = '$store_id' and sid = '$cid' order by sort desc";
        $r = $db->select($sql);
        $asd = '<option selected="true" value="0">请选择</option>';
        foreach($r as $k=>$v){
            $cid_1 = $v->cid; // 分类id
            $pname_1 = $v->pname; // 分类名称
            $asd .=  "<option  value='$cid_1'>$pname_1</option>";
        }
        echo json_encode($asd);
        return;
    }

    public function execute(){
        return;
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>