<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        //查询询价列表
        $sql = "SELECT * FROM `lkt_enquiry` order by create_date asc";
        $res = $db->select($sql);
        $res_str = json_encode($res);
        $request->setAttribute("list",$res_str);
        $request->setAttribute("pages_show",1);
        return View :: INPUT;
    }
    
    public function execute() {
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>