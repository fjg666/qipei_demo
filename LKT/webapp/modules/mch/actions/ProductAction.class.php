<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class ProductAction extends Action
{


    public function getDefaultView()
    {
        $db = DBAction::getInstance();

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
        $button[5] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Product_shelves');
        $button[6] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Product_see');

        $mch_status = addslashes(trim($request->getParameter('mch_status'))); // 审核状态
        $product_title = addslashes(trim($request->getParameter('product_title'))); // 标题
        $mch_id = trim($request->getParameter('mch_id'));

        $pageto = $request->getParameter('pageto');
        // 导出
        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : 10;
        // 每页显示多少条数据
        $page = $request->getParameter('page');

        // 页码
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        $product_class_arr = array();
        //分类下拉选择
        $sql = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc  ";
        $rr = $db->select($sql);
        if($rr){
            foreach ($rr as $key => $value) {
                $c = '-' . $value->cid . '-';
                $product_class_arr[$c] = $value->pname;
                //循环第一层
                $sql_e = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$value->cid' order by sort desc ";
                $r_e = $db->select($sql_e);
                if ($r_e) {
                    $hx = '-----';
                    foreach ($r_e as $ke => $ve) {
                        $cone = $c . $ve->cid . '-';
                        //判断所属类别 添加默认标签
                        $product_class_arr[$cone] = $ve->pname;

                        //循环第二层
                        $sql_t = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$ve->cid' order by sort desc ";
                        $r_t = $db->select($sql_t);
                        if ($r_t) {
                            $hxe = $hx . '-----';
                            foreach ($r_t as $k => $v) {
                                $ctow = $cone . $v->cid . '-';
                                //判断所属类别 添加默认标签
                                $product_class_arr[$ctow] = $v->pname;
                            }
                        }
                    }
                }
            }
        }

        $brand_class_arr = array();
        //品牌下拉选择
        $sql = "select * from lkt_brand_class where store_id = '$store_id' and recycle = 0";
        $rr1 = $db->select($sql);
        if($rr1){
            foreach ($rr1 as $key => $value) {
                $brand_class_arr[$value->brand_id] = $value->brand_name;
            }
        }

        $condition = "a.store_id = '$store_id' and a.recycle = 0 ";
        if ($mch_status != 0) {
            $condition .= " and a.mch_status = '$mch_status' ";
        }else{
            $condition .= " and a.mch_status != 4 and a.mch_status != 2 ";
        }
        if ($product_title != '') {
            $condition .= " and a.product_title like '%$product_title%' ";
        }
        if(!empty($mch_id)){
            $condition .= " and a.mch_id = '$mch_id' ";
        }

        $sql = "select * from lkt_product_list as a where $condition and a.mch_id > 0 order by a.sort desc,status asc,a.add_date desc ";
        $r_pager = $db->select($sql);
        if ($r_pager) {
            $total = count($r_pager);
        } else {
            $total = 0;
        }
        $pager = new ShowPager($total, $pagesize, $page);

        $sql = "select a.* from lkt_product_list as a where $condition and a.mch_id > 0 order by a.mch_status asc,a.status asc,a.sort desc,a.add_date desc limit $start,$pagesize ";
        $r = $db->select($sql);
        $list = array();
        $status_num = 0;
        if($r){
            foreach ($r as $key => $value) {
                $pid = $value->id;
                $class = $value->product_class;
                $bid = $value->brand_id;
                $num = $value->num;
                $min_inventory = $value->min_inventory;
                $shop_id = $value->mch_id;
                if($shop_id == 0){
                    $value->shop_name = '自营';
                    $value->realname = '';
                }else{
                    $sql_0 = "select name,realname from lkt_mch where id = '$shop_id'";
                    $r_0 = $db->select($sql_0);
                    if($r_0){
                        $value->shop_name = $r_0[0]->name;
                        $value->realname = $r_0[0]->realname;
                    }else{
                        $value->shop_name = '';
                        $value->realname = '';
                    }
                }
                $value->s_type = explode(',', $value->s_type);
                $value->show_adr = explode(',', $value->show_adr);

                // 分类名称
                $pname = array_key_exists($class, $product_class_arr) ? $product_class_arr[$class]:'一级';
                // 品牌名称
                $brand_name = array_key_exists($bid, $brand_class_arr) ? $brand_class_arr[$bid]:'暂无';
                $sql = "select id,num,unit,price from lkt_configure where pid = '$pid'";
                $r_s = $db->select($sql);
                if ($r_s) {
                    $price = array();
                    $unit = $r_s[0]->unit;
                    foreach ($r_s as $k1 => $v1) {
                        $price[$k1] = $v1->price;

                    }
                    $min = min($price);
                    $present_price = $min;
                } else {
                    $unit = '';
                    $present_price = '';
                }
                $value->imgurl = ServerPath::getimgpath($value->imgurl,$store_id);
                $value->unit = $unit;
                $value->price = $present_price;
                $value->pname = $pname;
                $value->brand_name = $brand_name;
                $list[$key] = (object)$value;
            }
        }

        if ($status_num > 0) {
            $this->getDefaultView();
        }


        $url = "index.php?module=mch&action=Product&mch_status=" . urlencode($mch_status) . "&product_title=" . urlencode($product_title) . "&mch_id=" . urlencode($mch_id) . "&pagesize=" . urlencode($pagesize);
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        $request->setAttribute('button', $button);

        $request->setAttribute("mch_status", $mch_status);
        $request->setAttribute("product_title", $product_title);
        $request->setAttribute('mch_id', $mch_id);
        $request->setAttribute("list", $list);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute('pagesize', $pagesize);
        return View :: INPUT;
    }

    public function execute()
    {

    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }
}
?>