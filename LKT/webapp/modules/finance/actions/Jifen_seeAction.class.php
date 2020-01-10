<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once (MO_LIB_DIR . '/DBAction.class.php');
require_once (MO_LIB_DIR . '/ShowPager.class.php');
require_once (MO_LIB_DIR . '/Tools.class.php');

class Jifen_seeAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this -> getContext() -> getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name=$this->getContext()->getStorage()->read('admin_name');
        // 接收参数
        $type = $request->getParameter('otype');// 查询类型
        $user_id = $request->getParameter('user_id'); // 用户ID
        $startdate = $request->getParameter('startdate');//开始时间
        $enddate = $request -> getParameter('enddate');//结束时间
        $pageto = $request->getParameter('pageto');// 导出
        $pagesize = $request -> getParameter('pagesize');// 每页显示多少条数据
        $pagesize = $pagesize ? $pagesize:'10';
        $page = $request -> getParameter('page');// 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $condition = " b.store_id = '$store_id' and a.store_id = '$store_id' and b.user_id = '$user_id' ";

        if($type == ''){
            $type = 'all';
        }else{
            if($type != 'all'){
                $condition .= " and a.type = '$type' ";
            }
        }
        if($startdate){
            $condition .= " and a.sign_time >= '$startdate' ";
        }
        if($enddate){
            $condition .= " and a.sign_time <= '$enddate' ";
        }

        // 查询记录总数
        $sql1 = "select a.*,b.user_name,b.mobile,b.source from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where $condition ";
        $r_total = $db -> select($sql1);
        $total = 0;
        if($r_total){
            $total = count($r_total);
        }
        // 页码调整
        if ($start > $total) {$page = 1;$start = 0;}
        $pager = new ShowPager($total,$pagesize,$page);
        $offset = $pager->offset;

        if($pageto == 'whole') { // 导出全部

            $db->admin_record($store_id,$admin_name,' 导出全部积分详情记录 ',4);
            $sql = "select a.*,b.user_name,b.mobile,b.source from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where b.store_id = '$store_id' and a.store_id = '$store_id' and b.user_id = '$user_id' order by a.sign_time desc";

        }else if($pageto == 'inquiry'){//导出查询

            $db->admin_record($store_id,$admin_name,' 导出积分详情记录全部查询数据！ ',4);
            $sql = "select a.*,b.user_name,b.mobile,b.source from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where $condition order by a.sign_time desc";
        }else if($pageto == 'This_page'){//导出当前页

            $db->admin_record($store_id,$admin_name,' 导出当前页积分详情记录 ',4);
            $sql = "select a.*,b.user_name,b.mobile,b.source from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where $condition order by a.sign_time desc limit $offset,$pagesize";

        }else{
            $sql = "select a.*,b.user_name,b.mobile,b.source from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where $condition order by a.sign_time desc limit $offset,$pagesize";
        }
        $r = $db->select($sql);


        $url = "index.php?module=finance&action=Jifen_see&user_id=".urlencode($user_id)."&otype=".urlencode($type)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&pagesize=".urlencode($pagesize);

        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("user_id",$user_id);
        $request->setAttribute("type",$type);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute('pageto',$pageto);
        $request->setAttribute("list",$r);
        $request -> setAttribute('pages_show', $pages_show);

        return View::INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods() {
        return Request::NONE;
    }

}
?>