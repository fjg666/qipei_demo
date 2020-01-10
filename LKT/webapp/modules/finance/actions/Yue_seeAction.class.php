<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class Yue_seeAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收参数
        $type = $request->getParameter('otype'); // 入账/支出
        $user_id = $request->getParameter('user_id'); // 用户id
        $starttime = $request->getParameter('startdate');// 开始时间
        $group_end_time = $request->getParameter('enddate');// 结束时间
        $pageto = $request->getParameter('pageto');// 导出
        $pagesize = $request->getParameter('pagesize');// 每页显示数量
        $pagesize = $pagesize ? $pagesize:'10';
        $page = $request->getParameter('page');// 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        
        $condition = " b.store_id = '$store_id' and b.user_id = '$user_id' and a.type !=0 and a.type !=6 and a.type !=7 and a.type !=8 and a.type !=9 and a.type !=10 and a.type !=15 and a.type !=16 and a.type !=17 and a.type !=18 ";
        if($type && $type != 0){
            $condition .= " and a.type = '$type' ";
        }
        if($starttime){
            $condition .= " and a.add_date >= '$starttime' ";
        }
        if($group_end_time){
            $condition .= " and a.add_date <= '$group_end_time' ";
        }
        $sql = "select a.*,b.user_name,b.mobile,b.source from lkt_record as a left join lkt_user as b on a.user_id = b.user_id where $condition order by a.add_date desc ";
        $r_total = $db->select($sql);
        $total = count($r_total);
        // 页码调整
        if ($start > $total) {$page = 1;$start = 0;}
        $pager = new ShowPager($total,$pagesize,$page);

        $sql = "select a.*,b.user_name,b.mobile,b.source from lkt_record as a left join lkt_user as b on a.user_id = b.user_id where $condition order by a.add_date desc limit $start,$pagesize";

        $list = $db->select($sql);

        $url = "index.php?module=finance&action=Yue_see&user_id=".urlencode($user_id)."&otype=".urlencode($type)."&starttime=".urlencode($starttime)."&group_end_time=".urlencode($group_end_time)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$list);
        $request->setAttribute("type",$type);
        $request->setAttribute('pageto', $pageto);
        $request->setAttribute("user_id",$user_id);
        $request->setAttribute("starttime",$starttime);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute("group_end_time",$group_end_time);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
         return Request :: POST;
    }

}

?>