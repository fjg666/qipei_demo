<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action
{
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018年12月12日
     * @version 2.0
     */

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $mch_id = $this->getContext()->getStorage()->read('mch_id');

        //商城id
        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=product&action=Add');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=product&action=Modify');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=product&action=Del');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=product&action=See');
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=product&action=Operation');
        $button[5] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=product&action=Shelves');
        $button[6] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=product&action=Copy');
        $button[7] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=product&action=Stick');

        $product_class = addslashes(trim($request->getParameter('cid'))); // 分类名称
        $brand_id = addslashes(trim($request->getParameter('brand_id'))); // 品牌id
        $status = addslashes(trim($request->getParameter('status'))); // 上下架
        $active = addslashes(trim($request->getParameter('active'))); // 商品类型
        $product_title = addslashes(trim($request->getParameter('product_title'))); // 标题
        $mch_name = addslashes(trim($request->getParameter('mch_name'))); // 标题
        $show_adr = addslashes(trim($request->getParameter('show_adr'))); // 显示位置
        // 导出
        $pageto = $request->getParameter('pageto');

        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

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
                        $product_class_arr[$cone] = $ve->pname;

                        //循环第二层
                        $sql_t = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$ve->cid' order by sort desc ";
                        $r_t = $db->select($sql_t);
                        if ($r_t) {
                            $hxe = $hx . '-----';
                            foreach ($r_t as $k => $v) {
                                $ctow = $cone . $v->cid . '-';
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

        $condition = "a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 ";
        $condition1 = "a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 ";

        $class_list = array();
        $brand_list1 = array('brand_id'=>'0','brand_name'=>'请选择商品品牌');
        if ($product_class != 0) {
            $Tools = new Tools($db, $store_id, 1);
            $product_class1 = $Tools->str_option( $product_class);
            $condition .= " and a.product_class like '%$product_class1%' ";
            $res = explode('-',trim($product_class,'-'));
            $class_id0 = $res[0]; //  商品所属分类的顶级
            $shuliang = count($res)-1;
            $class_id1 = $res[$shuliang]; // 商品所属分类
            foreach ($res as $k => $v){
                $sql = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$v' ";
                $r = $db->select($sql);
                $class_list[] = $r[0];
            }
            // 产品品牌
            $brand_sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%,$class_id0,%' order by sort desc";
            $brand_list = $db->select($brand_sql);
            array_unshift($brand_list,(object)$brand_list1);
        }else{
            $brand_list[] = (object)$brand_list1;
        }
        if ($brand_id != 0) {
            $condition .= " and a.brand_id like '$brand_id' ";
        }
        if($status != ''){
            $condition .= " and status = $status ";
        }

        if($active != 0){
            $condition .= " and active like '%$active%' ";
        }
        if ($product_title != '') {
            if(strpos($product_title," ")){
                $product_title1 = explode(' ',$product_title);
                $condition1 = ' and (';
                foreach ($product_title1 as $k => $v){
                    if($v){
                        $condition1 .= " a.product_title like '%$v%' or ";
                    }
                }
                $condition1 = substr($condition1,0,strlen($condition1)-3);
                $condition1 .= ' )';
                $condition .= $condition1;
            }else{
                $condition .= " and a.product_title like '%$product_title%' ";
            }
        }
        if($mch_name != ''){
            $condition .= " and b.name like '%$mch_name%' ";
        }

        if($show_adr != 0 && $active == 1){
            $condition .= " and a.show_adr like '%$show_adr%' ";
        }
        $sql0 = "select a.* from lkt_product_list as a left join lkt_mch as b on a.mch_id = b.id where $condition" . " order by a.sort desc ";
        $r_pager = $db->select($sql0);
        if ($r_pager) {
            $total = count($r_pager);
        } else {
            $total = 0;
        }
        $pager = new ShowPager($total, $pagesize, $page);
        $sql1 = "select a.*,b.name as shop_name from lkt_product_list as a left join lkt_mch as b on a.mch_id = b.id where ";
        if($pageto == 'This_page'){ // 导出本页
            $sql1 .= "$condition order by a.sort desc limit $start,$pagesize ";
        }else if($pageto == 'whole'){ // 导出全部
            $sql1 .= "$condition1 order by a.sort desc ";
        }else if($pageto == 'inquiry'){ // 导出查询
            $sql1 .= "$condition order by a.sort desc ";
        }else{
            $sql1 .= "$condition order by a.sort desc limit $start,$pagesize ";
        }
        $r = $db->select($sql1);
        $list = array();
        $status_num = 0;
        if($r){
            $total1 = count($r);
            foreach ($r as $key => $value) {
                $pid = $value->id;
                $class = $value->product_class;
                $bid = $value->brand_id;
                $shop_id = $value->mch_id;
                // 获取上一条数据的ID
                if($key == 0){ // 为当前页面第一条时
                    if ($page) { // 有页码
                        $start1 = $start-1; // 上一页最后一条数据
                        if($start1 < 0){
                            $upper_id = '';
                        }else{
                            // 查询上一页最后一条数据
                            $sql2 = "select id from lkt_product_list as a where $condition order by a.sort desc limit $start1,1";
                            $r2 = $db->select($sql2);
                            $upper_id = $r2[0]->id;
                        }
                    }else {
                        $upper_id = '';
                    }
                    $value->upper_status = false; // 下移
                }else{
                    $key1 = $key-1;
                    $upper_id = $r[$key1]->id; // 上条数据ID
                    $value->upper_status = true;
                }
                // 获取下一条数据的ID
                if($key == $total1-1){  // 为当页面最后一条时
                    if ($page) {  // 有页码
                        if($page == 1){
                            $sql3 = "select id from lkt_product_list as a where $condition order by a.sort desc limit $pagesize,1";
                        }else{
                            $start2 = $start + $pagesize;
                            $sql3 = "select id from lkt_product_list as a where $condition order by a.sort desc limit $start2,1";
                        }
                    }else{
                        $sql3 = "select id from lkt_product_list as a where $condition order by a.sort desc limit $pagesize,1";
                    }
                    $r3 = $db->select($sql3);
                    if($r3){
                        $underneath_id = $r3[0]->id; // 下条数据ID
                    }else{
                        $underneath_id = '';
                    }
                }else{
                    $key2 = $key+1;
                    $underneath_id = $r[$key2]->id; // 下条数据ID

                }
                $value->upper_id = $upper_id;
                $value->underneath_id = $underneath_id;

                $min_inventory = $value->min_inventory;
                $value->s_type = explode(',', $value->s_type);
                $value->show_adr = explode(',', $value->show_adr);
                //查询商品库存
                $sql = "select SUM(num) as num from lkt_configure where pid = '$pid' and recycle = 0";
                $res_n = $db->select($sql);
                $value->num = $res_n[0]->num;

//                $sql = " update lkt_product_list set num = '$value->num' where store_id = '$store_id' and id = '$pid'";
//                $db-> update($sql);
                // 分类名称
                $pname = array_key_exists($class, $product_class_arr) ? $product_class_arr[$class]:'顶级';
                // 品牌名称
                $brand_name = array_key_exists($bid, $brand_class_arr) ? $brand_class_arr[$bid]:'暂无';

                $sql = "select id,num,unit,price from lkt_configure where pid = '$pid' and recycle = 0";
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
        $Plugin = new Plugin();
        $Plugin_arr = $Plugin->product_activity_type($db, $store_id, 'activity_type', $active);

        $select2 = Tools::data_dictionary($db,'商品状态',$status);
        $select3 = Tools::data_dictionary($db,'商品展示位置',$show_adr);

        $url = "index.php?module=product&action=Index&cid=" . urlencode($product_class) . "&brand_id=" . urlencode($brand_id) . "&status=" . urlencode($status) . "&active=" . urlencode($active) . "&product_title=" . urlencode($product_title) ."&mch_name=". urlencode($mch_name)."&show_adr=" . urlencode($show_adr) . "&pagesize=" . urlencode($pagesize);
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');
        
        //删除后跳转参数
        if(empty($page)){
            $page = 1;
        }
        $del_arr = array();
        $del_arr['cid'] = $product_class;
        $del_arr['brand_id'] = $brand_id;
        $del_arr['status'] = $status;
        $del_arr['product_title'] = $product_title;
        $del_arr['show_adr'] = $show_adr;
        $del_arr['page'] = $page;
        $del_arr['pagesize'] = $pagesize;

        $del_str = json_encode($del_arr);
      
        $this->getContext()->getStorage()->write('del_str',$del_str);//写入缓存

        $request->setAttribute("mch_id", $mch_id);
        $request->setAttribute("store_id", $store_id);
        $request->setAttribute("class_id", $product_class);
        $request->setAttribute("ctypes", $class_list);

        $request->setAttribute('brand_class', $brand_list);//所有品牌
        $request->setAttribute('brand_id', isset($brand_id) ? $brand_id : '');//品牌ID

        $request->setAttribute("product_title", $product_title);
        $request->setAttribute("mch_name", $mch_name);
        $request->setAttribute("active", $active);
        $request->setAttribute("status", $status);
        $request->setAttribute("list", $list);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute('pagesize', $pagesize);
        $request->setAttribute('select2', $select2);
        $request->setAttribute('select3', $select3);
        $request->setAttribute('select4', $Plugin_arr);
        $request->setAttribute("pageto",$pageto);
        $request->setAttribute('button', $button);
        $request->setAttribute('show_adr', $show_adr);
        $request->setAttribute('del_str', $del_str);

        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id_list = addslashes(trim($request->getParameter('id_list'))); // id字符串
        $list = explode(',',$id_list);
        $status = true;
        $xp = true;
        $rx = true;
        $tj = true;
        foreach ($list as $k => $v){
            $sql0 = "select status,s_type from lkt_product_list where store_id = '$store_id' and recycle = 0 and mch_status = 2 and id = '$v' ";
            $r0 = $db->select($sql0);
            if($r0){
                if($r0[0]->status == 2){
                    $status = false;
                }
                $s_type = explode(',',$r0[0]->s_type);
                if(in_array(1,$s_type)){
                    $xp = false;
                }
                if(in_array(2,$s_type)){
                    $rx = false;
                }
                if(in_array(3,$s_type)){
                    $tj = false;
                }
            }
        }
        echo json_encode(array('status'=>$status,'xp'=>$xp,'rx'=>$rx,'tj'=>$tj));
        exit;

    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}

?>