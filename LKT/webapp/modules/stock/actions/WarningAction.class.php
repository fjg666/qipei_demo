<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class WarningAction extends Action {
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
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=stock&action=Add');
        $button[5] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=stock&action=Seewarning');

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $condition = "a.store_id = '$store_id' and a.recycle = 0 and c.num <= a.min_inventory ";
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
        $sql0 = "select a.product_number,a.product_title,a.imgurl,a.status,a.mch_id,c.id,c.pid,c.price,c.attribute,c.total_num,c.num,b.add_date from lkt_configure as c left join lkt_product_list as a on c.pid = a.id left join (select max(add_date) as add_date,type,attribute_id from lkt_stock where type = 2 group by attribute_id) as b on c.id = b.attribute_id where $condition order by a.sort,c.id ";
        $r0 = $db->select($sql0);
        $total = count($r0);

        $sql1 = "select a.product_number,a.product_title,a.imgurl,a.status,a.mch_id,c.id,c.pid,c.price,c.attribute,c.total_num,c.num,b.add_date from lkt_configure as c left join lkt_product_list as a on c.pid = a.id left join (select max(add_date) as add_date,type,attribute_id from lkt_stock where type = 2 group by attribute_id) as b on c.id = b.attribute_id where $condition and c.num <= a.min_inventory order by a.sort,c.id limit $start,$pagesize";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $mch_id = $v->mch_id;
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $attribute = unserialize($v->attribute);
                $specifications = '';
                foreach ($attribute as $ke => $va){
                    $specifications .= $ke .':'.$va.',';
                }
                $v->specifications = rtrim($specifications, ",");

                $sql0_0 = "select name from lkt_mch where store_id = '$store_id' and id = '$mch_id' and review_status = 1";
                $r0_0 = $db->select($sql0_0);
                if($r0_0){
                    $v->shop_name = $r0_0[0]->name;
                }else{
                    $v->shop_name = '';
                }
            }
        }
        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=stock&action=Warning&pagesize=".urlencode($pagesize)."&product_number=".urlencode($product_number)."&product_title=".urlencode($product_title)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $excel_sql = '';
        if($pageto == 'This_page'){ // 导出本页
            $excel_condition = $condition;
            $excel_sql = "where $excel_condition order by a.sort,c.id limit $start,$pagesize";
        }else if($pageto == 'whole'){ // 导出全部
            $excel_condition = $excel_condition;
            $excel_sql = "where $excel_condition order by a.sort,c.id";

        }else if($pageto == 'inquiry'){ // 导出查询
            $excel_condition = $condition;
            $excel_sql = "where $excel_condition order by a.sort,c.id";
        }
        if($excel_sql != ''){
            $sql2 = "select a.product_number,a.product_title,a.imgurl,a.status,a.mch_id,c.id,c.pid,c.price,c.attribute,c.total_num,c.num,b.add_date from lkt_configure as c left join lkt_product_list as a on c.pid = a.id left join (select max(add_date) as add_date,type,attribute_id from lkt_stock where type = 2 group by attribute_id) as b on c.id = b.attribute_id $excel_sql";
        }else{
            $sql2 = "select a.product_number,a.product_title,a.imgurl,a.status,a.mch_id,c.id,c.pid,c.price,c.attribute,c.total_num,c.num,b.add_date from lkt_configure as c left join lkt_product_list as a on c.pid = a.id left join (select max(add_date) as add_date,type,attribute_id from lkt_stock where type = 2 group by attribute_id) as b on c.id = b.attribute_id $condition";
        }
        $r2 = $db->select($sql2);
        if($r2){
            foreach ($r2 as $k => $v){
                $mch_id = $v->mch_id;
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $sql0_0 = "select name from lkt_mch where store_id = '$store_id' and id = '$mch_id' and review_status = 1";
                $r0_0 = $db->select($sql0_0);
                if($r0_0){
                    $v->shop_name = $r0_0[0]->name;
                }else{
                    $v->shop_name = '';
                }
            }
        }
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