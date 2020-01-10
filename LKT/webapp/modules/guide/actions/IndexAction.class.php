<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $top_type = $this->getContext()->getStorage()->read('store_type');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=guide&action=Add');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=guide&action=Modify');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=guide&action=Del');

        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        // 查询轮播图表，根据sort顺序排列
        $sql = "select * from lkt_guide where store_id = '$store_id' and source = '$top_type' order by sort";
        $r = $db->select($sql);
        $total = count($r);

        $sql = "select * from lkt_guide where store_id = '$store_id' and source = '$top_type' order by sort limit $start,$pagesize";
        $r = $db->select($sql);
        if($r){
            foreach ($r as $k => $v) {
                $v->image = ServerPath::getimgpath($v->image,$store_id);
            }
        }
        $pager = new ShowPager($total,$pagesize,$page);
        $url = "index.php?module=guide&action=Index";
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$r);
        $request -> setAttribute('pages_show', $pages_show);
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