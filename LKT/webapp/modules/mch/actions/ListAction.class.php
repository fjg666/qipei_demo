<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class ListAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $this->db = $db;
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=List');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Set');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Product');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Withdraw');
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Withdraw_list');
        $button[5] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Examine');
        $button[6] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=See');

        $review_status = trim($request->getParameter('review_status'));
        $name = trim($request->getParameter('name'));

        $pageto = $request -> getParameter('pageto');

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

        $condition = " m.store_id = '$store_id' and u.store_id = '$store_id' and (m.review_status = 0 or m.review_status = 2)";
        $condition1 = " m.store_id = '$store_id' and u.store_id = '$store_id' and (m.review_status = 0 or m.review_status = 2)";
        if($review_status != ''){
            $condition .= " and m.review_status = '$review_status'";
        }
        if(!empty($name)){
            $condition .= " and (m.user_id = '$name' OR m.name like '%$name%')";
        }

        $sql0 = "select m.*,u.user_name from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where $condition order by m.add_time desc";
        $r0 = $db -> select($sql0);
        $total = count($r0);

        if($pageto == 'whole') { // 导出全部
            $db->admin_record($store_id,$admin_name,' 导出店主全部提现待审核列表 ',4);
            $sql1 = "select m.*,u.user_name from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where $condition1 order by m.add_time desc ";
        }else if($pageto == 'inquiry'){//导出查询
            $db->admin_record($store_id,$admin_name,' 导出店主提现待审核列表全部查询数据！ ',4);
            $sql1 = "select m.*,u.user_name from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where $condition order by m.add_time desc ";
        }else if($pageto == 'This_page'){//导出当前页
            $db->admin_record($store_id,$admin_name,' 导出店主当前页提现待审核列表 ',4);
            $sql1 = "select m.*,u.user_name from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where $condition order by m.add_time desc limit $start,$pagesize";
        }else{
            $sql1 = "select m.*,u.user_name from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where $condition order by m.add_time desc limit $start,$pagesize";
        }
        $r1 = $db -> select($sql1);
        foreach ($r1 as $k => $v){
            $v->logo = ServerPath::getimgpath($v->logo,$store_id);
        }

        $pager = new ShowPager($total,$pagesize,$page);
        $url = "index.php?module=mch&action=List&review_status=".urlencode($review_status)."&name=".urlencode($name)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute('button', $button);

        $request->setAttribute('pageto',$pageto);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute('list', $r1);
        $request->setAttribute('review_status', $review_status);
        $request->setAttribute('name', $name);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>