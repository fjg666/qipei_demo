<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class ShipmentAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  17:50
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $pageto = $request -> getParameter('pageto'); // 导出
        $product_number = addslashes(trim($request->getParameter('product_number'))); // 商品编码
        $product_title = addslashes(trim($request->getParameter('product_title'))); // 商品名称
        $startdate = $request -> getParameter("startdate");
        $enddate = $request -> getParameter("enddate");
        // 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        $JurisdictionAction = new JurisdictionAction();
        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=stock&action=Index');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=stock&action=Warning');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=stock&action=Enter');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=stock&action=Shipment');

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $condition = "a.store_id = '$store_id' and a.recycle = 0 and b.type = 1";
        $excel_condition = $condition;
        if ($product_number != '') {
            $condition .= " and a.product_number = '$product_number' ";
        }
        if ($product_title != '') {
            $condition .= " and a.product_title like '%$product_title%' ";
        }
        if ($startdate != '') {
            $condition .= " and b.add_date >= '$startdate 00:00:00' ";
        }
        if ($enddate != '') {
            $condition .= " and b.add_date <= '$enddate 23:59:59' ";
        }

        $sql0 = "select a.product_number,a.product_title,a.imgurl,a.status,a.status,a.mch_id,c.id,c.pid,c.price,c.attribute,b.total_num,b.flowing_num,b.user_id,b.add_date from lkt_stock as b left join lkt_product_list as a on b.product_id = a.id left join lkt_configure as c on b.attribute_id = c.id where $condition order by b.add_date desc";
        $r0 = $db->select($sql0);
        $total = count($r0);

        $sql1 = "select a.product_number,a.product_title,a.imgurl,a.status,a.status,a.mch_id,c.id,c.pid,c.price,c.attribute,b.total_num,b.flowing_num,b.user_id,b.add_date from lkt_stock as b left join lkt_product_list as a on b.product_id = a.id left join lkt_configure as c on b.attribute_id = c.id where $condition order by b.add_date desc limit $start,$pagesize";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $attribute = unserialize($v->attribute);

                $specifications = '';
                if($attribute){
                    foreach ($attribute as $ke => $va){
                        $specifications .= $ke .':'.$va.',';
                    }
                }
                $v->specifications = rtrim($specifications, ",");

                $sql2 = "select add_date from lkt_stock where product_id = '$v->pid' and attribute_id = '$v->id' order by add_date desc limit 1";
                $r2 = $db->select($sql2);
                if($r2){
                    $v->add_date = $r2[0]->add_date;
                }
            }
        }
        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=stock&action=Shipment&pagesize=".urlencode($pagesize)."&product_number=".urlencode($product_number)."&product_title=".urlencode($product_title)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $excel_sql = '';
        if($pageto == 'This_page'){ // 导出本页
            $excel_condition = $condition;
            $excel_sql = "where $excel_condition order by a.add_date desc limit $start,$pagesize";
        }else if($pageto == 'whole'){ // 导出全部
            $excel_condition = $excel_condition;
            $excel_sql = "where $excel_condition order by a.add_date desc";

        }else if($pageto == 'inquiry'){ // 导出查询
            $excel_condition = $condition;
            $excel_sql = "where $excel_condition order by a.add_date desc";
        }
        if($excel_sql != ''){
            $sql2 = "select a.product_number,a.product_title,a.status,a.status,a.mch_id,c.id,c.pid,c.price,c.attribute,b.total_num,b.flowing_num,b.user_id,b.add_date from lkt_stock as b left join lkt_product_list as a on b.product_id = a.id left join lkt_configure as c on b.attribute_id = c.id $excel_sql";
        }else{
            $sql2 = "select a.product_number,a.product_title,a.status,a.status,a.mch_id,c.id,c.pid,c.price,c.attribute,b.total_num,b.flowing_num,b.user_id,b.add_date from lkt_stock as b left join lkt_product_list as a on b.product_id = a.id left join lkt_configure as c on b.attribute_id = c.id $condition";
        }
        $r2 = $db->select($sql2);

        $request->setAttribute('button', $button);
        $request->setAttribute("list",$r1);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('product_number', $product_number);
        $request -> setAttribute('product_title', $product_title);
        $request -> setAttribute('startdate', $startdate);
        $request -> setAttribute('enddate', $enddate);

        $request->setAttribute("excel",$r2);
        $request->setAttribute("pageto",$pageto);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>