<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ConfigAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $m = addslashes($request->getParameter('m')); // 参数
        if ($m) {
            $this->$m();
            return;
        }

        $sql0 = "select * from lkt_subtraction_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $is_subtraction = $r0[0]->is_subtraction;
            $range_zfc = explode(',',$r0[0]->range_zfc);
            $pro_id = $r0[0]->pro_id;
            $position_zfc = $r0[0]->position_zfc;
            $is_shipping = $r0[0]->is_shipping;
            $z_money = $r0[0]->z_money;
            $address_id = $r0[0]->address_id;
        }
        $request->setAttribute('is_subtraction', isset($is_subtraction) ? $is_subtraction : '');
        $request->setAttribute('range_zfc', isset($range_zfc) ? $range_zfc : array());
        $request->setAttribute('pro_id', isset($pro_id) ? $pro_id : '');
        $request->setAttribute('position_zfc', isset($position_zfc) ? $position_zfc : '');
        $request->setAttribute('is_shipping', isset($is_shipping) ? $is_shipping : '');
        $request->setAttribute('z_money', isset($z_money) ? $z_money : '');
        $request->setAttribute('address_id', isset($address_id) ? $address_id : '');

        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/subtraction.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $is_subtraction = addslashes($request->getParameter('is_subtraction')); // 是否开启满减
        $range_zfc = $request->getParameter('range_zfc'); // 满减应用范围
        $pro_id = addslashes($request->getParameter('pro_id')); // 满赠商品
        $position_zfc = addslashes($request->getParameter('position_zfc')); // 满减图片显示位置
        $is_shipping = addslashes($request->getParameter('is_shipping')); // 满减包邮设置
        $z_money = addslashes($request->getParameter('z_money')); // 单笔满多少
        $address_id = addslashes($request->getParameter('address_id')); // 包邮地址

        if($range_zfc == ''){
            echo json_encode(array('status' => '请填写满减应用范围！'));
            exit;
        }else{
            $range_zfc = implode(",", $range_zfc);
            $range_zfc = trim($range_zfc,',');
            $list = explode(',',$range_zfc);
            $sql00 = "select subtraction_range from lkt_subtraction where store_id = '$store_id'";
            $r00 = $db->select($sql00);
            if($r00){
                foreach ($r00 as $k => $v){
                    if(!in_array($v->subtraction_range,$list)){
                        echo json_encode(array('status' => '满减应用范围正参与活动，不能取消！'));
                        exit;
                    }
                }
            }
        }
        if($pro_id == ''){
            echo json_encode(array('status' => '请选中满赠商品！'));
            exit;
        }else{
            $pro_id = trim($pro_id,',');
        }
        $position_zfc = trim($position_zfc,',');
        if($is_shipping == 1){
            if($z_money == ''){
                echo json_encode(array('status' =>'单笔订单满多少不能为空！' ));exit;
            }else{
                if(is_numeric($z_money)){
                    $z_money = round($z_money,2);
                }else{
                    echo json_encode(array('status' =>'单笔订单满多少请填写数字！' ));exit;
                }
            }
            if($address_id == ''){
                echo json_encode(array('status' =>'包邮地址不能为空！' ));exit;
            }
        }

        $sql0 = "select id from lkt_subtraction_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $sql1 = "update lkt_subtraction_config set is_subtraction = '$is_subtraction',range_zfc = '$range_zfc',pro_id = '$pro_id',position_zfc = '$position_zfc',is_shipping = '$is_shipping',z_money = '$z_money',address_id = '$address_id',add_date = CURRENT_TIMESTAMP where store_id = '$store_id'";
            $r1 = $db->update($sql1);
            if($r1 == -1){
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改满减设置失败',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改满减设置失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'未知原因，满减设置修改失败！' ));exit;
            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改加满减设置成功',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改加满减设置成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '满减设置修改成功！','suc'=>'1'));exit;
            }
        }else{
            $sql1 = "insert into lkt_subtraction_config (store_id,is_subtraction,range_zfc,pro_id,position_zfc,is_shipping,z_money,address_id,add_date) value ('$store_id','$is_subtraction','$range_zfc','$pro_id','$position_zfc','$is_shipping','$z_money','$address_id',CURRENT_TIMESTAMP)";
            $r1 = $db->insert($sql1);
            if($r1 <= 0) {
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加满减设置失败',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加满减设置失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '未知原因，满减设置添加失败！'));exit;
            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加满减设置',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加满减设置';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' =>'满减设置添加成功！','suc'=>'1'));exit;
            }
        }

        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
    // 查询商品
    public function chaxun()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $mch_id = $this->getContext()->getStorage()->read('mch_id');

        $class_id = addslashes(trim($request->getParameter('class_id'))); // 商品分类id
        $brand_class_id = addslashes(trim($request->getParameter('brand_class_id'))); // 品牌id
        $title = addslashes(trim($request->getParameter('title'))); // 商品名称

        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : '3';
        // 每页显示多少条数据
        $page = $request->getParameter('page');

        // 页码
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        $condition = "a.store_id = '$store_id' and a.recycle = 0 and a.mch_id = '$mch_id' and a.mch_status = 2 and a.active = 1 and a.status = 2 and a.num > 0";
        if ($class_id != 0) {
            $condition .= " and a.product_class like '%$class_id%' ";
        }
        if ($brand_class_id != 0) {
            $condition .= " and a.brand_id like '$brand_class_id' ";
        }
        if ($title != '') {
            $condition .= " and a.product_title like '%$title%' ";
        }
        $sql0 = "select a.id,a.product_title,a.imgurl,a.num from lkt_product_list as a where $condition" . " order by a.status asc,a.add_date desc,a.sort desc ";
        $r0 = $db->select($sql0);
        $total = count($r0);

        $sql = "select a.id,a.product_title,a.imgurl,a.num,a.mch_id from lkt_product_list as a where $condition" . " order by a.status asc,a.add_date desc,a.sort desc limit $start,$pagesize";
        $rrr = $db->select($sql);
        foreach ($rrr as $k => $v) {
            $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);

            $sql1 = "select id,price,attribute from lkt_configure where pid = '$v->id'";
            $r1 = $db->select($sql1);

            if ($r1) {
                $price = array();
                foreach ($r1 as $k1 => $v1) {
                    $price[$k1] = $v1->price;
                }
                $min = min($price);
                $present_price = $min;

            } else {
                $present_price = '';
            }
            $v->present_price = $present_price;

            $sql2 = "select name from lkt_mch where store_id = '$store_id' and id = " . $v->mch_id;
            $r2 = $db->select($sql2);
            if ($r2) {
                $v->mch_name = $r2[0]->name;
            }
        }
        $list2 = $rrr;

        $pager = new ShowPager($total, $pagesize, $page);
        $url = "index.php?module=subtraction&action=config&class_id=" . urlencode($class_id) . "&brand_class_id=" . $brand_class_id . "&title=" . $title . "&pagesize=" . urlencode($pagesize) . "&m=chaxun";
        $pages_show = $pager->multipage1($url, $total, $page, $pagesize, $start, $para = '');

        echo json_encode(array('product_list' => $list2, 'pages_show' => $pages_show));
        exit;
    }
    // 商品确认
    public function commodity_confirm()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $productid = addslashes(trim($request->getParameter('productid'))); // 商品分类id
        $productid = trim($productid, ',');

        $arr = explode(',', $productid);
        $arr1 = array();
        $list = array();
        foreach ($arr as $k => $v) {
            $sql0 = "select a.id,a.product_title,a.imgurl,a.num,a.mch_id from lkt_product_list as a where a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 and a.active = 1 and a.status = 2 and a.id = '$v'";
            $r0 = $db->select($sql0);
            if($r0){
                $r0[0]->imgurl = ServerPath::getimgpath($r0[0]->imgurl,$store_id);

                $sql1 = "select name from lkt_mch where store_id = '$store_id' and id = " . $r0[0]->mch_id;
                $r1 = $db->select($sql1);
                if ($r1) {
                    $r0[0]->mch_name = $r1[0]->name;
                }
                //查询商品库存
                $sql3 = "select SUM(num) as num from lkt_configure where pid = '$v' and recycle = 0";
                $r3 = $db->select($sql3);
                $r0[0]->num = $r3[0]->num;

                $sql2 = "select id,price,attribute from lkt_configure where pid = '$v'";
                $r2 = $db->select($sql2);

                if ($r2) {
                    $price = array();
                    foreach ($r2 as $k2 => $v2) {
                        $price[$k2] = $v2->price;
                    }
                    $min = min($price);
                    $present_price = $min;

                } else {
                    $present_price = '';
                }
                $r0[0]->present_price = $present_price;

                $list[] = $r0[0];
                $arr1[] = $v;
            }
        }
        $productid = implode(',',$arr1);

        echo json_encode(array('product_list' => $list, 'pro_id' => $productid));
        exit;
    }
    // 删除商品
    public function del(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = addslashes(trim($request->getParameter('id'))); // 商品id
        $pro_id = addslashes(trim($request->getParameter('pro_id'))); // 商品分类id字符串

        $status = 0;
        $sql00 = "select subtraction from lkt_subtraction where store_id = '$store_id' and status in (1,2,3)";
        $r00 = $db->select($sql00);
        if($r00){
            foreach ($r00 as $k => $v){
                $subtraction = unserialize($v->subtraction);
                if(in_array($id,$subtraction)){
                    $status = 1;
                    break;
                }
            }
        }
        $pro_list = array();
        if($status){
            $pro_list = explode(',', $pro_id);
        }else{
            $arr = explode(',', $pro_id);
            foreach ($arr as $k => $v) {
                if ($id != $v) {
                    $pro_list[] = $v;
                }
            }
        }


        $pro_zfc = implode(",", $pro_list);
        $list = array();
        foreach ($pro_list as $k => $v) {
            $sql0 = "select a.id,a.product_title,a.imgurl,a.num,a.mch_id from lkt_product_list as a where a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 and a.active = 1 and a.status = 2 and a.id = '$v'";
            $r0 = $db->select($sql0);
            $r0[0]->imgurl = ServerPath::getimgpath($r0[0]->imgurl,$store_id);

            $sql1 = "select name from lkt_mch where store_id = '$store_id' and id = " . $r0[0]->mch_id;
            $r1 = $db->select($sql1);
            if ($r1) {
                $r0[0]->mch_name = $r1[0]->name;
            }

            $sql2 = "select id,price,attribute from lkt_configure where pid = '$v'";
            $r2 = $db->select($sql2);

            if ($r2) {
                $price = array();
                foreach ($r2 as $k2 => $v2) {
                    $price[$k2] = $v2->price;
                }
                $min = min($price);
                $present_price = $min;

            } else {
                $present_price = '';
            }
            $r0[0]->present_price = $present_price;

            $list[] = $r0[0];
        }
        echo json_encode(array('status'=>$status,'product_list' => $list, 'pro_id' => $pro_zfc));
        exit;
    }
    // 获取省市县
    public function province()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $address_id = $request->getParameter('address_id');
        $res = array();
        $list = array();
        $sql = "select GroupID,G_CName from admin_cg_group where G_ParentID = 0";
        $r = $db->select($sql);
        if($address_id){ // 有运费信息
            $arr = explode(',',$address_id);
            foreach ($r as $k => $v){
                $v->status = false;
                foreach ($arr as $k1 => $v1){
                    if($v->GroupID == $v1){
                        $v->status = true;
                    }
                }
            }
        }else{
            foreach ($r as $k => $v){
                $v->status = false;
            }
        }
        $list = $r;

        $res = array('status' => '1','list'=>$list,'info'=>'成功！');
        echo json_encode($res);
        return;
    }
    // 显示省名称
    public function add_province()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $data = $request->getParameter('data');
        $res = '';
        $rew = '';
        foreach ($data as $k => $v){
            $sql0 = "select GroupID,G_CName from admin_cg_group where G_ParentID = 0 and GroupID = '$v'";
            $r0 = $db->select($sql0);
            if($r0){
                $res .= $r0[0]->GroupID . ',';
                $rew .= $r0[0]->G_CName . ',';

            }
        }

        $res = trim($res,',');
        $rew = trim($rew,',');

        $data = array('address_id' => $res,'address'=>$rew);
        echo json_encode($data);
        return;
    }
}
?>