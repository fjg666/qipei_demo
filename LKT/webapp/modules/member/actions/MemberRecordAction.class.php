<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class MemberRecordAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=member&action=MemberRecordDel');

        $name = $request->getParameter('name'); // 管理员账号
        $startdate = $request->getParameter("startdate");
        $enddate = $request->getParameter("enddate");

        $pageto = $request -> getParameter('pageto');
        // 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');
        $page = $page ? $page:1;
        // 页码
        if($page){
            $start = ($page-1)*10;
        }else{
            $start = 0;
        }
        // 根据管理员id,查询管理员信息(是否是客户或商城管理员)
        $sql = "select * from lkt_admin where id = '$admin_id'";
        $r0 = $db->select($sql);
        $store_type = 0; // 允许查看该商城所有管理员
        if($r0[0]->type == 0 || $r0[0]->type == 1){ // 允许查看该商城所有管理员
            $store_type = 0; // 允许查看该商城所有管理员
        }else{
            $store_type = 1; // 不允许查看该商城所有管理员
        }


        $condition = " store_id = '$store_id' ";
        $condition1 = " store_id = '$store_id' ";
        if($startdate != ''){
            $condition .= " and add_date >= '$startdate' ";
        }
        if($enddate != ''){
            $enddate = date("Y-m-d 23:59:59",strtotime($enddate));
            $condition .= " and add_date <= '$enddate' ";
        }
        if($name != ''){
            $condition .= " and admin_name = '$name' ";
        }
        $sql = "select * from lkt_admin_record where $condition order by add_date desc";
        $r = $db->select($sql);
        $total = count($r);
        $pager = new ShowPager($total,$pagesize,$page);

        $sql = "select * from lkt_admin_record where ";
        if($pageto == 'This_page'){ // 导出本页
            $JurisdictionAction->admin_record($store_id,$admin_name,'导出管理员记录表第'.$page.'数据',4);
            $sql .= "$condition order by add_date desc limit $start,$pagesize ";
        }else if($pageto == 'whole'){ // 导出全部
            $JurisdictionAction->admin_record($store_id,$admin_name,'导出管理员记录表全部数据',4);

            $sql .= "$condition1 order by add_date desc ";
        }else if($pageto == 'inquiry'){ // 导出查询
            $JurisdictionAction->admin_record($store_id,$admin_name,'导出管理员记录表查询数据,查询条件'.$condition,4);

            $sql .= "$condition order by add_date desc ";
        }else{
            $sql .= "$condition order by add_date desc limit $start,$pagesize ";
        }
        $r = $db->select($sql);

        $url = "index.php?module=member&action=MemberRecord&name=".urlencode($name)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$r);
        $request->setAttribute("name",$name);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute('pageto',$pageto);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('pagesize', $pagesize);
        $request -> setAttribute('store_type', $store_type);
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