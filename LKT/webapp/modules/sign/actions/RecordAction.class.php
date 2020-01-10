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

        $user_id = addslashes(trim($request->getParameter('user_id'))); // 用户id
        $starttime = addslashes(trim($request->getParameter('starttime'))); // 开始时间
        $endtime = addslashes(trim($request->getParameter('endtime'))); // 结束时间
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

        $condition = " b.store_id = '$store_id' and a.user_id = '$user_id' and a.type = 0 and a.recovery = 0";
        if($starttime != ''){
            $condition .= " and a.sign_time >= '$starttime'";
        }
        if($endtime != ''){
            $condition .= " and a.sign_time <= '$endtime'";
        }

        $sql = "select a.*,b.user_name from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where $condition ";
        $r_pager = $db->select($sql);
        $total = count($r_pager);
        $pager = new ShowPager($total,$pagesize,$page);

        $sql = "select a.*,b.user_name from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where $condition order by sign_time desc limit $start,$pagesize";
        $r = $db->select($sql);
        if($r){
            $list = $r;
        }else{
            $list = array();
        }
        $url = "index.php?module=sign&action=Record&starttime=".urlencode($starttime)."&user_id=".urlencode($user_id)."&endtime=".urlencode($endtime)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("starttime",$starttime);
        $request->setAttribute("user_id",$user_id);
        $request->setAttribute("endtime",$endtime);
        $request->setAttribute("list",$list);
        $request -> setAttribute('pages_show', $pages_show);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>