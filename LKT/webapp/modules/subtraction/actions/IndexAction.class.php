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
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=subtraction&action=Config');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=subtraction&action=Add');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=subtraction&action=Change');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=subtraction&action=Modify');
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=subtraction&action=Del');
        $button[5] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=subtraction&action=Record');

        $name = $request->getParameter('name'); // 活动名称
        $status = $request->getParameter('status'); // 活动状态

        $pageto = $request->getParameter('pageto');
        // 导出
        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : 10;
        // 每页显示多少条数据
        $page = $request->getParameter('page');

        // 页码
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }
        $time = date("Y-m-d H:i:s");
        $condition = " store_id = '$store_id' ";
        if($name != ''){
            $condition .= " and title like '%$name%'";
        }
        if($status != '' && $status != 0){
            $condition .= " and status = '$status'";
        }
        $sql0 = "select * from lkt_subtraction where $condition ";
        $r0 = $db->select($sql0);
        if ($r0) {
            $total = count($r0);
        } else {
            $total = 0;
        }

        $sql0_1 = "select * from lkt_subtraction where store_id = '$store_id' ";
        $r0_0 = $db->select($sql0_1);
        if($r0_0){
            foreach ($r0_0 as $k => $v){
                if($v->status == 1){
                    if($v->starttime <= $time){
                        $sql2 = "update lkt_subtraction set status = 2 where store_id = '$store_id' and id = " . $v->id;
                        $r2 = $db->update($sql2);
                    }
                }else if($v->status == 2 || $v->status == 3){
                    if($v->endtime <= $time){
                        $sql2 = "update lkt_subtraction set status = 4 where store_id = '$store_id' and id = " . $v->id;
                        $r2 = $db->update($sql2);
                    }
                }
            }
        }

        $sql1 = "select * from lkt_subtraction where $condition order by status asc,starttime asc limit $start,$pagesize";
        $r1 = $db->select($sql1);
        if(!empty($r1)){
            foreach ($r1 as $k => $v) {
                $v->subtraction = unserialize($v->subtraction);
                if ($v->subtraction_type == 1){
                    $v->subtraction_type = '阶梯满减';
                }else if ($v->subtraction_type == 2){
                    $v->subtraction_type = '循环满减';
                }else if ($v->subtraction_type == 3){
                    $v->subtraction_type = '满赠';
                }else if ($v->subtraction_type == 4){
                    $v->subtraction_type = '满件折扣';
                }
            }
        }

        $pager = new ShowPager($total, $pagesize, $page);
        
        $url = "index.php?module=subtraction&action=Index&pagesize=" . urlencode($pagesize) ."&name=".urldecode($name) ."&status=".urldecode($status);
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        $request->setAttribute('button', $button);

        $request->setAttribute("name", $name);
        $request->setAttribute("status", $status);
        $request->setAttribute("list", $r1);
        $request->setAttribute("pages_show", $pages_show);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>