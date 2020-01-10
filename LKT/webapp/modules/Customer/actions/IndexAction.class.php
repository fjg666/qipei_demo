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
        $admin_id = $this->getContext()->getStorage()->read('admin_id');

        $name = addslashes(trim($request->getParameter('name'))); // 姓名
        $startdate = $request->getParameter('startdate'); // 开始时间
        $enddate = $request->getParameter('enddate'); // 结束日期


        $pageto = $request -> getParameter('pageto');
        // 每页显示多少条数据
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 页码
        $page = $request -> getParameter('page');
        if($page){
            $page = $page;
            $start = ($page-1)*10;
        }else{
            $page = 1;
            $start = 0;
            
        }
        $condition = ' recycle = 0 ';
        $condition1 = ' recycle = 0 ';
        if($name != ''){
            $condition .= " and name like '%$name%'";
        }
        if($startdate != ''){ // 查询开始日期不为空
            $condition .= " and add_date >= '$startdate' ";
        }
        if($enddate != ''){ // 查询结束日期不为空
            if($enddate == date("Y-m-d 00:00:00",strtotime($enddate))){
                $enddate = date("Y-m-d 23:59:59",strtotime($enddate));
            }else{
                $enddate = $enddate;
            }
            $condition .= " and add_date <= '$enddate' ";
        }
        // 查询所有
        $sql = "select * from lkt_customer ";
        $r = $db->select($sql);
        $time = date("Y-m-d H:i:s"); // 当前时间
        foreach ($r as $k => $v) {
            $asd['id'] = $v->id;
            $asd['end_date'] = $v->end_date; // 到期时间
            $id = $v->id;
            $end_date = $v->end_date; // 到期时间
            $time1 = date("Y-m-d",strtotime("$end_date +1 week")); // 过期延期一周
            if($asd['end_date'] < $time){ // 到期时间小于当前时间
                $sql = "update lkt_customer set status = 1 where id = " . $asd['id'];
                $rr = $db->update($sql);
            }
            if($time >= $time1){
                $sql = "update lkt_customer set recycle = 1 where id = '$id'";
                $db->update($sql);
            }
        }

        $sql = "select * from lkt_customer where $condition ";
        $r1 = $db->select($sql);
        $total = count($r1);

        $pager = new ShowPager($total, $pagesize, $page);
        $sql01 = "select * from lkt_customer where  ";
        if($pageto == 'This_page'){ // 导出本页
            $sql01 .= "$condition order by add_date asc limit $start,$pagesize ";
        }else if($pageto == 'whole'){ // 导出全部
            $sql01 .= "$condition1 order by add_date asc ";
        }else if($pageto == 'inquiry'){ // 导出查询
            $sql01 .= "$condition order by add_date asc ";
        }else{
            $sql01 .= "$condition order by add_date asc limit $start,$pagesize ";
        }
        $r01 = $db->select($sql01);

        $new = array();
        foreach ($r01 as $key => $value) {
            //在每个商户的字段中添加该管理员的login_num
            $id=$value->admin_id;
            $sql="select shop_id,login_num from lkt_admin where id = '$id'";
            $r=$db->select($sql);
            if($r){
                $value->shop_id=$r[0]->shop_id; // 店铺ID
                $login_num=$r[0]->login_num;
                $new[$key] = $value;
                $new[$key]->login_num = $login_num;
            }
        }

        $url = "index.php?module=Customer&action=Index&name=".urlencode($name)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("name",$name);
        $request->setAttribute("list",$new);
        $request -> setAttribute('pageto', $pageto);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('pagesize', $pagesize);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $mch_id = addslashes(trim($request->getParameter('mch_id'))); // 店铺id

        $this->getContext()->getStorage()->write('store_id',$store_id);
        $this->getContext()->getStorage()->write('mch_id',$mch_id);

        echo 1;
        exit;
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>