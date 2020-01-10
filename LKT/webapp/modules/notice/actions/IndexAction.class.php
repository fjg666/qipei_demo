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
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=notice&action=Add');
        $button[1] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=notice&action=Modify');
        $button[2] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=notice&action=Del');

        // 查询插件表
        $sql = "select * from lkt_set_notice where store_id = '$store_id'";
        $r = $db->select($sql);
        if(!empty($r)){
            foreach ($r as $k => $v) {
                if($v->img_url == ''){
                    $v->img_url = 'nopic.jpg';
                }else{
                    $v->img_url = ServerPath::getimgpath($v->img_url,$store_id);
                }
            }
        }
        $request->setAttribute("uploadImg",$uploadImg);
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