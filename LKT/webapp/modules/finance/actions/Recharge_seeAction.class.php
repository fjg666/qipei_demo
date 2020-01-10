<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class Recharge_seeAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $user_id = addslashes(trim($request->getParameter('user_id'))); // 账号
        $startdate = $request->getParameter('startdate');//开始时间
        $enddate = $request -> getParameter('enddate');//结束时间

        $pageto = $request -> getParameter('pageto');
        // 导出
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


		$condition = " a.store_id = '$store_id' and a.user_id = '$user_id' and (a.type = 1 or a.type = 14)";
        if($startdate){
            $condition .= " and a.add_tate >= '$startdate' ";
        }
        if($enddate){
            $condition .= " and a.add_tate <= '$enddate' ";
        }
        $sql = "select a.*,b.user_name from lkt_record as a LEFT JOIN lkt_user as b ON a.user_id = b.user_id where $condition";
        $r = $db->select($sql);
        $list = array();
        $total = 0;
        if($r){
            $total = count($r);

            if($pageto == 'whole') { // 导出全部

                $db->admin_record($store_id,$admin_name,' 导出'.$user_id.'的全部充值记录 ',4);
                $sql = "select a.*,b.user_name from lkt_record as a LEFT JOIN lkt_user as b ON a.user_id = b.user_id where a.store_id = '$store_id' and a.user_id = '$user_id' and (a.type = 1 or a.type = 14) order by a.add_date desc";

            }else if($pageto == 'inquiry'){//导出查询

                $db->admin_record($store_id,$admin_name,' 导出'.$user_id.'的全部查询充值记录 ',4);
                $sql = "select a.*,b.user_name from lkt_record as a LEFT JOIN lkt_user as b ON a.user_id = b.user_id where $condition order by a.add_date desc";

            }else if($pageto == 'This_page'){//导出当前页

                $db->admin_record($store_id,$admin_name,' 导出'.$user_id.'的当前页充值记录 ',4);
                $sql = "select a.*,b.user_name from lkt_record as a LEFT JOIN lkt_user as b ON a.user_id = b.user_id where $condition order by a.add_date desc limit $start,$pagesize";

            }else{
                $sql = "select a.*,b.user_name from lkt_record as a LEFT JOIN lkt_user as b ON a.user_id = b.user_id where $condition order by a.add_date desc limit $start,$pagesize";
            }
            $list = $db->select($sql);
        }

        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=finance&action=Recharge&user_id=".urlencode($user_id)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("user_id",$user_id);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("list",$list);
        $request->setAttribute('pageto',$pageto);
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