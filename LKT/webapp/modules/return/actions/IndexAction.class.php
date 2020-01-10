<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $button[0] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=return&action=View');
        $button[1] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=return&action=Examine');

        $p_name = addslashes(trim($request->getParameter('p_name'))); // 产品名称
        $startdate = $request->getParameter("startdate");
        $enddate = $request->getParameter("enddate");
        $pageto = $request->getParameter('pageto'); // 导出
        $mch_id = $request->getParameter('mch_id'); // 店铺ID

        $r_type = trim($request->getParameter('r_type'));

        $condition = " b.store_id = '$store_id' and (b.r_status = 4 OR b.r_type > 0) and  b.r_type != 12 ";

        if($mch_id != ''){
            $condition .= " and a.mch_id like '%$mch_id%' ";
        }
        if($p_name != ''){
            $condition .= " and b.r_sNo like '%$p_name%' ";
        }

        if($r_type){
            if($r_type ==1){
                $condition .= " and b.r_type = '0' ";
            }else if($r_type ==2){
                $condition .= " and (b.r_type = '1' OR b.r_type = '6') ";
            }else if($r_type ==3){
                $condition .= " and (b.r_type = '2' OR b.r_type = '8') ";
            }else if($r_type ==4){
                $condition .= " and b.r_type = '3' ";
            }else if($r_type ==5){
                $condition .= " and (b.r_type = '4' OR b.r_type = '9') ";
            }else{
                $condition .= " and b.r_type = '5' ";
            }
        }

        if($startdate != ''){
            $condition .= "and b.add_time >= '$startdate' ";
        }
        if($enddate != ''){
            $condition .= "and b.add_time <= '$enddate' ";
        }

        $condition.=" and b.r_type != 100";
        $con = '';
        foreach ($_GET as $key => $value001) {
            $con .= "&$key=$value001";
        }
        // 查询表
        $sql1 = "select b.* from lkt_order_details as b left join lkt_order as a on b.r_sNo = a.sNo where $condition ";
        $total = $db->selectrow($sql1);
        // 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? ($pagesize=='undefined' ? 10:$pagesize):10;
        // 页码
        $page = $request -> getParameter('page');
        $page = $page ? $page:1;
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $pager = new ShowPager($total,$pagesize,$page);
        $url = 'index.php?module=return'.$con;
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');


        if($pageto == 'all') { // 导出全部
            $sql = "select b.* ,lm.name as shop_name  from lkt_order_details as b 
                    left join lkt_order as a on b.r_sNo = a.sNo 
                    LEFT JOIN lkt_product_list as lpl on lpl.id = b.p_id
                    LEFT JOIN lkt_mch as lm on lm.id = lpl.mch_id
                    where $condition order by b.re_time desc,b.r_type asc ";
            $r = $db->select($sql);
        }else if($pageto == 'ne'){// 导出本页
            $sql = "select b.* ,lm.name as shop_name from lkt_order_details as b 
                    left join lkt_order as a on b.r_sNo = a.sNo 
                    where $condition 
                    LEFT JOIN lkt_product_list as lpl on lpl.id = b.p_id
                    LEFT JOIN lkt_mch as lm on lm.id = lpl.mch_id
                    order by b.re_time desc,b.r_type asc limit $start,$pagesize ";
            $r = $db->select($sql);
        }else{
            $sql = "select b.* ,lm.name as shop_name,a.pay from lkt_order_details as b 
                    left join lkt_order as a on b.r_sNo = a.sNo 
                    LEFT JOIN lkt_product_list as lpl on lpl.id = b.p_id
                    LEFT JOIN lkt_mch as lm on lm.id = lpl.mch_id
                    where $condition order by b.re_time desc,b.r_type asc limit $start,$pagesize ";
            $r = $db->select($sql);
        }
        $sql02 = "select * from lkt_express ";
        $r02 = $db->select($sql02);


        $r_type_str = Tools::data_dictionary($db,'退货状态',$r_type);

        $request->setAttribute("express", $r02);
        $request->setAttribute("pageto",$pageto);
        $request->setAttribute("pages_show",$pages_show);
        $request->setAttribute("r_type",$r_type);
        $request->setAttribute("p_name",$p_name);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("list",$r);
        $request->setAttribute('button',$button);
        $request->setAttribute('r_type_str',$r_type_str);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>