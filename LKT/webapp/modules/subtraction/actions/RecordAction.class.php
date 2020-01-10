<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');

class RecordAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = addslashes(trim($request->getParameter('id'))); // 活动id
        $sNo = $request->getParameter('sNo'); // 订单编号
        $user_id = $request->getParameter('user_id'); // 会员编号

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

        $condition = " b.store_id = '$store_id' and b.id = '$id' ";
        if($sNo != ''){
            $condition .= " and a.sNo like '%$sNo%'";
        }
        if($user_id != ''){
            $condition .= " and a.user_id = '$user_id'";
        }

        $sql0 = "select a.*,b.name from lkt_subtraction_record as a left join lkt_subtraction as b on a.h_id = b.id where $condition ";
        $r0 = $db->select($sql0);
        if ($r0) {
            $total = count($r0);
        } else {
            $total = 0;
        }
        $sql1 = "select a.*,b.name from lkt_subtraction_record as a left join lkt_subtraction as b on a.h_id = b.id where $condition order by a.add_date desc limit $start,$pagesize";
        $r1 = $db->select($sql1);

        $pager = new ShowPager($total, $pagesize, $page);

        $url = "index.php?module=subtraction&action=Record&pagesize=" . urlencode($pagesize) ."&sNo=".urldecode($sNo) ."&user_id=".urldecode($user_id);
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');


        $request->setAttribute("id", $id);
        $request->setAttribute("sNo", $sNo);
        $request->setAttribute("user_id", $user_id);
        $request->setAttribute("list", $r1);
        $request->setAttribute("pages_show", $pages_show);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>