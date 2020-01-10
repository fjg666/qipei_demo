<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class SeeAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = $request->getParameter('id');

        $sql = "select * from lkt_taobao where store_id='$store_id' and id = '$id' ";
        $list = $db->select($sql);
        if($list){
            foreach ($list as $k => $v){
                $itemid = $v->itemid;
                $sql1 = "select id,product_title,imgurl,recycle from lkt_product_list where store_id='$store_id' and scan = '$itemid' ";
                $r1 = $db->select($sql1);
                if($r1){
                    $list[$k]->pid = $r1[0]->id;// 商品ID
                    $list[$k]->recycle = $r1[0]->recycle;// 是否回收0.否1.是
                    $list[$k]->product_title = $r1[0]->product_title;// 商品标题
                    $list[$k]->imgurl = ServerPath::getimgpath($r1[0]->imgurl,$store_id);// 商品主图
                }else{
                    $list[$k]->pid = '';
                    $list[$k]->recycle = 1;
                    $list[$k]->product_title = '';
                    $list[$k]->imgurl = '';
                }
            }
        }
        
        $request->setAttribute("list", $list);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}

?>