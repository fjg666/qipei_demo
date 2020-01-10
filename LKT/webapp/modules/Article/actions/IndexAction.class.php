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
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');

        $button[0] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=Article&action=add');
        $button[1] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=Article&action=modify');
        $button[2] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=Article&action=del');
        $button[3] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=Article&action=view');
        $button[4] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=Article&action=amount');

        $sql = "select * from lkt_article where store_id = '$store_id' order by sort ";
        $r = $db->select($sql);
        if(!empty($r)){
            foreach ($r as $k => $v) {
                $v -> Article_imgurl = ServerPath::getimgpath($v->Article_imgurl,$store_id);
            }
        }
        $request->setAttribute("list",$r);
        $request->setAttribute("uploadImg",$uploadImg);
        $request->setAttribute("button",$button);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>