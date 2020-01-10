<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class modifyAction extends Action
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
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $serverURL = $this->getContext()->getStorage()->read('serverURL');

        // 接收信息
        $id = intval($request->getParameter("id")); // 产品id

        //商城id
        // 根据产品id，查询产品产品信息
        $sql = "select * from lkt_product_list where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);

        if ($r) {
            $product_title = $r[0]->product_title; // 产品标题
            $subtitle = $r[0]->subtitle; // 副标题
            $product_number = $r[0]->product_number; // 编码
            $product_class = $r[0]->product_class; // 产品类别
            $brand_id = $r[0]->brand_id; // 产品品牌
            $keyword = $r[0]->keyword; // 关键词
            $weight = $r[0]->weight; // 重量
            $status = $r[0]->status; // 上下架状态
            $min_inventory = $r[0]->min_inventory; // 库存预警
            $content = $r[0]->content; // 产品内容
            $imgurl = ServerPath::getimgpath($r[0]->imgurl, $store_id); //图片

            $initial = $r[0]->initial;
            $s_type = $r[0]->s_type;
            $show_adr = $r[0]->show_adr;
            $distributor_id = $r[0]->distributor_id;//分销层级id
            $freight_id = $r[0]->freight;
            $is_hexiao = $r[0]->is_hexiao;
            $active = $r[0]->active;
            $hxaddress = $r[0]->hxaddress;
            $shop_id = $r[0]->mch_id;
        }

        $arr = explode(',', $s_type);

        $freight_list = "";
        $sql = "select id,name from lkt_freight where store_id = '$store_id' order by id ";
        $r_freight = $db->select($sql);
        if ($r_freight) {
            foreach ($r_freight as $k => $v) {
                $freight_ids = $v->id; // 运费规则id
                $freight_name = $v->name; // 运费规则
                if ($freight_id == $freight_ids) {
                    $freight_list .= "<option selected='selected' value='{$freight_ids}'>{$freight_name}</option>";
                } else {
                    $freight_list .= "<option value='{$freight_ids}'>{$freight_name}</option>";
                }
            }
        }
        // 商品分类
        $class = array();
        $res = explode('-',trim($product_class,'-'));
        $class_id0 = $res[0]; //  商品所属分类的顶级
        $shuliang = count($res)-1;
        $class_id1 = $res[$shuliang]; // 商品所属分类
        foreach ($res as $k => $v){
            $sql = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$v' ";
            $r = $db->select($sql);
            $class[] = $r[0];
        }

        // 产品品牌
        $brand_list1 = array('brand_id'=>'0','brand_name'=>'请选择商品品牌');
        $brand_sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%,$class_id0,%' order by sort desc";
        $brand_list = $db->select($brand_sql);
        array_unshift($brand_list,(object)$brand_list1);

        $imgs_sql = "select * from lkt_product_img where product_id = '$id'";
        $imgurls = $db->select($imgs_sql);
        if ($imgurls) {
            foreach ($imgurls as $k => $v) {
                $v->product_url = ServerPath::getimgpath($v->product_url, $store_id);
                $imgurls[$k]->is_center = $imgurl == $v->product_url ? 1 : 0;
            }
        }

        $imgurls1 = array('product_url'=>$imgurl,'is_center'=>1);
        array_unshift($imgurls, (object)$imgurls1);
        //-----查询规格数据
        $size = "select * from lkt_configure where pid = '$id' and recycle = 0";
        $res_size = $db->select($size);
        $attr_group_list = array();
        $checked_attr_list = array();
        if ($res_size) {
            if($res_size[0]->attribute != ''){
                $arrar_t = unserialize($res_size[0]->attribute);
                foreach ($arrar_t as $key => $value) {
                    $attr_group_list[] = array('attr_group_name' => $key, 'attr_list' => [], 'attr_all' => []);
                }
                foreach ($res_size as $k => $v) {
                    $attribute = unserialize($v->attribute); // 属性
                    $attr_lists = array();
                    //列出属性名
                    foreach ($attribute as $key => $value) {
                        foreach ($attr_group_list as $keya => $valuea) {
                            if ($key == $valuea['attr_group_name']) {
                                ;
                                if (!in_array($value, $attr_group_list[$keya]['attr_all'])) {
                                    if($status == 1){
                                        $attr_list = array('attr_name' => $value,'status' => true);
                                    }else{
                                        $attr_list = array('attr_name' => $value,'status' => false);
                                    }
                                    array_push($attr_group_list[$keya]['attr_list'], $attr_list);
                                    array_push($attr_group_list[$keya]['attr_all'], $value);
                                }
                            }
                        }
                        $attr_lists[] = array('attr_id' => '', 'attr_group_name' => $key, 'attr_name' => $value);
                    }
                    $checked_attr_list[] = array('attr_list' => $attr_lists, 'cbj' => $v->costprice, 'yj' => $v->yprice, 'sj' => $v->price, 'kucun' => $v->total_num, 'unit' => $v->unit,'bar_code' => $v->bar_code, 'img' => ServerPath::getimgpath($v->img, $store_id), 'cid' => $v->id);
                }
                foreach ($attr_group_list as $key => $value) {
                    $attr_group_list[$key] = Tools::array_key_remove($attr_group_list[$key], 'attr_all');
                }
            }
        }
        $attr_group_list = json_encode($attr_group_list);
        $checked_attr_list = json_encode($checked_attr_list);
        //-------查询规格数据
        $Plugin = new Plugin();
        $Plugin_arr = $Plugin->product_plugin($db, $store_id, 'product', $active, $distributor_id);
        $show_adr = $show_adr == 0 ? array(0) : explode(',', $show_adr);

        $sp_type = Tools::s_type($db, '商品类型', $arr);
        $show_adr = Tools::s_type($db, '商品展示位置', $show_adr);
        if($initial != ''){
            $initial = unserialize($initial);
        }else{
            $initial = array();
        }
        $unit = Tools::s_type($db, '单位',$initial);
        $initial = (object)$initial;
        //保存商品时，要跳转首页页面参数
        $del_str = $this->getContext()->getStorage()->read('del_str');//写入缓存

        $request->setAttribute('serverURL', $serverURL);
        $request->setAttribute('id', $id);
        $request->setAttribute("mch_id", $shop_id ? $shop_id : 0);
        $request->setAttribute('product_title', isset($product_title) ? $product_title : '');
        $request->setAttribute('subtitle', isset($subtitle) ? $subtitle : '');
        $request->setAttribute('keyword', isset($keyword) ? $keyword : '');
        $request->setAttribute('weight', isset($weight) ? $weight : '');
        $request->setAttribute('product_number', isset($product_number) ? $product_number : '');
        $request->setAttribute("class_id", $class_id1);
        $request->setAttribute("ctypes", $class);
        $request->setAttribute('brand_class', $brand_list);//所有品牌
        $request->setAttribute('brand_id', isset($brand_id) ? $brand_id : '');//品牌ID
        $request->setAttribute('imgurls', isset($imgurls) ? $imgurls : '');

        $request->setAttribute('initial', isset($initial) ? $initial : '');
        $request->setAttribute('status', isset($status) ? $status : '');
        $request->setAttribute('unit', $unit);
        $request->setAttribute('attr_group_list', $attr_group_list);
        $request->setAttribute('checked_attr_list', $checked_attr_list);

        $request->setAttribute('min_inventory', isset($min_inventory) ? $min_inventory : '');
        $request->setAttribute('freight_list', $freight_list);// 运费
        $request->setAttribute('sp_type', $sp_type);
        $request->setAttribute('active', $active);  //s_type
        $request->setAttribute("Plugin_arr", $Plugin_arr);
        $request->setAttribute('show_adr', $show_adr);
        $request->setAttribute('is_hexiao', $is_hexiao);// 运费
        $request->setAttribute('hxaddress', $hxaddress);

        $request->setAttribute('content', isset($content) ? $content : '');

        $request->setAttribute('del_str', $del_str);
    
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/product.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号

        $id = intval($request->getParameter("id")); // 产品id
        $mch_id = intval($request->getParameter("mch_id")); // 店铺id

        $product_title = addslashes(trim($request->getParameter('product_title'))); // 产品标题

        $subtitle = addslashes(trim($request->getParameter('subtitle'))); // 小标题
        $keyword = addslashes(trim($request->getParameter('keyword'))); // 关键词
        $weight = addslashes(trim($request->getParameter('weight'))); // 重量
        $product_number = addslashes(trim($request->getParameter('product_number'))); // 商品编码

        $product_class = addslashes(trim($request->getParameter('product_class'))); // 产品类别
        $brand_id = addslashes(trim($request->getParameter('brand_class'))); // 品牌
        $imgurls = $request->getParameter('imgurls'); // 产品展示图
        $initial = $request->getParameter('initial'); // 初始值
        $attr = $request->getParameter('attr'); // 属性

        $min_inventory = addslashes(trim($request->getParameter('min_inventory'))); // 库存预警
        $freight = $request->getParameter('freight'); // 运费
        $s_type = $request->getParameter('s_type'); // 显示类型
        $show_adr = $request->getParameter('show_adr'); // 展示位置
        $active = $request->getParameter('active'); // 支持活动
        $distributor_id = trim($request->getParameter('distributor_id')); //关联的分销层级id
        $is_hexiao = $request->getParameter('is_hexiao'); // 是否支持线下核销
        $hxaddress = $request->getParameter('hxaddress'); // 核销地址
        $content = addslashes(trim($request->getParameter('content'))); // 产品内容

        if (empty($product_title)) {
            echo json_encode(array('status' => '商品标题不能为空！'));
            exit;
        } else {
            if (strlen($product_title) > 60) {
                echo json_encode(array('status' => '商品标题不能超过20个中文字长度！'));
                exit;
            } else {
                $sql_0 = "select id from lkt_product_list where store_id = '$store_id' and recycle = 0 and product_title = '$product_title' and mch_id = '$mch_id' and id != '$id'";
                $r_0 = $db->select($sql_0);
                if ($r_0) {
                    echo json_encode(array('status' => '您有存在该商品,请勿重复添加！'));
                    exit;
                }
            }
        }
        if (empty($keyword)) {
            echo json_encode(array('status' => '关键词不能为空！'));
            exit;
        }
        if (is_numeric($weight)) {
            if ($weight < 0) {
                echo json_encode(array('status' => '重量不能为负数！'));
                exit;
            } else {
                $weight = number_format($weight, 2, ".", "");
            }
        } else {
            echo json_encode(array('status' => '重量请填写数字！'));
            exit;
        }

        if (empty($product_class)) {
            echo json_encode(array('status' => '商品类别不能为空！'));
            exit;
        }else{
            $Tools = new Tools($db, $store_id, 1);
            $product_class = $Tools->str_option( $product_class);
        }
        if (empty($brand_id)) {
            echo json_encode(array('status' => '品牌不能为空！'));
            exit;
        }
        if (array_key_exists('center', $imgurls)) {
            $image = preg_replace('/.*\//', '', $imgurls['center']);
            unset($imgurls['center']);
        } else {
            if (!empty($imgurls)) {
                $image = preg_replace('/.*\//', '', $imgurls['0']);
                if($image == ''){
                    echo json_encode(array('status' => '产品展示图不能为空！'));
                    exit;
                }
                unset($imgurls['0']);
            } else {
                echo json_encode(array('status' => '产品展示图不能为空！'));
                exit;
            }
        }
        //五张轮播图
        if ($imgurls) {
            $arrimg = array();
            $f_img = "select id,product_url from lkt_product_img where product_id = '$id'";
            $rf = $db->select($f_img);
            if ($rf) {
                foreach ($rf as $key => $fs) {
                    $arrimg[$fs->id] = $fs->product_url;
                }
            }

            if (count($imgurls) > 5) {
                $db->rollback();
                echo json_encode(array('status' => '产品展示图数量超出限制！'));
                exit;
            }

            foreach ($imgurls as $key => $file) {
                $imgsURL_name = preg_replace('/.*\//', '', $file);
                $key1 = array_search($imgsURL_name, $arrimg);
                if ($key1) {
                    unset($arrimg[$key1]);
                } else {
                    $sql_img = "insert into lkt_product_img(product_url,product_id,add_date) " . "values('$imgsURL_name','$id',CURRENT_TIMESTAMP)";
                    $r = $db->insert($sql_img);
                    if ($r < 1) {
                        $JurisdictionAction->admin_record($store_id,$admin_name,'产品展示图上传失败',1);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 产品展示图上传失败';
                        $lktlog->customerLog($Log_content);
                        $db->rollback();
                        echo json_encode(array('status' => '产品展示图上传失败，请稍后再试！'));
                        exit;
                    }
                }
            }

            if (!empty($arrimg)) {
                foreach ($arrimg as $keys => $fss) {
                    $ql_img = "delete from lkt_product_img  where id = '$keys'";
                    $r = $db->delete($ql_img);
                }
            }
        }else{
            $ql_img = "delete from lkt_product_img  where product_id = '$id'";
            $r = $db->delete($ql_img);
        }
        if($initial){
            foreach ($initial as $k => $v){
                if($k == 'cbj' && $v == ''){
                    echo json_encode(array('status' => '成本价初始值不能为空！'));
                    exit;
                }else if($k == 'yj' && $v == ''){
                    echo json_encode(array('status' => '原价初始值不能为空！'));
                    exit;
                }else if($k == 'sj' && $v == ''){
                    echo json_encode(array('status' => '售价初始值不能为空！'));
                    exit;
                }else if($k == 'unit' && $v == '0'){
                    echo json_encode(array('status' => '单位初始值不能为空！'));
                    exit;
                }else if($k == 'kucun' && $v == ''){
                    echo json_encode(array('status' => '库存初始值不能为空！'));
                    exit;
                }
            }
            $initial = serialize($initial);
        }else{
            echo json_encode(array('status' => '初始值不能为空！'));
            exit;
        }
        $z_num = 0;
        $attributes = array();
        //处理属性
        if (count($attr ? $attr : array()) == 0 || empty($attr)) {
            echo json_encode(array('status' => '请填写属性！'));
            exit;
        } else {
            foreach ($attr as $key => $value) {
                $attr_list = $value['attr_list'];
                $attr_list_arr = array();
                $attr_list_srt = '';
                foreach ($attr_list as $k => $v) {
                    $attr_list_arr[$v['attr_group_name']] = $v['attr_name'];
                    $attr_list_srt .= $v['attr_group_name'] . '-' . $v['attr_name'];
                }
                $cid = $value['cid'];
                if($cid != 0 && $cid != '' ){
                    // 根据属性ID，查询总库存和剩余数量
                    $sql0_0 = "select total_num,num from lkt_configure where id = '$cid' and recycle = 0";
                    $r0_0 = $db->select($sql0_0);
                    $total_num = $r0_0[0]->total_num; // 总库存数
                    $num = $r0_0[0]->num; // 剩余数量
                    if($total_num == $value['num']){ // 当传过来的数量 等于 总库存数，表示没有改变了数量
                        $value['total_num'] = $value['num'];
                        $value['num'] = $num;
                    }else{ // 表示改变了数量
                        $total_num1 = $total_num - $value['num']; // 总库存数 - 传过来的数量
                        if($total_num1 > 0){ // 大于0，表示减少总库存
                            if($num - $total_num1 < 0){ // 小于0，表示剩余库存低于0
                                echo json_encode(array('status'=>'属性为'.$attr_list[0]['attr_group_name'].':值为'.$attr_list[0]['attr_name'].'的商品数量低于库存数！'));
                                exit;
                            }else{ // 大于0，表示剩余库存大于0
                                $value['total_num'] = $value['num'];
                                $value['num'] = $num - $total_num1;
                            }
                        }else{ // 小于0，表示增加总库存
                            $value['total_num'] = $value['num'];
                            $value['num'] = $num - $total_num1;
                        }
                    }
                }else{
                    $value['total_num'] = $value['num'];
                }
                $z_num += $value['num'];
                if ($value['img'] == '') {
                    echo json_encode(array('status' => "$attr_list_srt 的属性图片未上传！"));
                    exit;
                }

                //价格判断
                foreach ($value as $cvkey => $cvvalue) {
                    if (!is_array($cvvalue)) {
                        if (empty($cvvalue) &&  $cvvalue != 0 && $cvkey != 'cid' && $cvkey != 'num') {
                            echo json_encode(array('status' => "请完善属性！"));
                            exit;
                        }
                    }
                }

                $costprice = $value['costprice'];
                $price = $value['price'];
                if ($costprice > $price) {
                    echo json_encode(array('status' => "成本价不能大于售价！"));
                    exit;
                }

                $value['img'] = preg_replace('/.*\//', '', $value['img']);
                $value['attribute'] = serialize($attr_list_arr);
                $value = Tools::array_key_remove($value, 'attr_list');
                $attributes[] = $value;
            }
        }

        //--处理属性
        if (!is_numeric($min_inventory) || strpos($min_inventory, ".") !== false) {
            echo json_encode(array('status' => '库存预警请输入整数！'));
            exit;
        } else {
            if ($min_inventory <= 0) {
                echo json_encode(array('status' => '库存预警请输入大于0的整数！'));
                exit;
            }
        }
        if ($freight == 0) {
            echo json_encode(array('status' => '请选择运费模板名称！'));
            exit;
        }
        $s_type = $s_type ? $s_type : array();
        if (count($s_type) == 0) {
            $type = 0;
        } else {
            $type = implode(",", $s_type);
        }

        if (empty($active)) {
            echo json_encode(array('status' => '请选择支持活动类型！'));
            exit;
        } else {
            if($active == 1){
                if(!empty($show_adr)){
                    $show_adr = implode(",", $show_adr);
                }
                $is_distribution = 0;
            }else if($active == 5){
                $show_adr = 0;
                $is_distribution = 1;
            }else{
                $show_adr = 0;
                $is_distribution = 0;
            }
        }

        // 根据产品id，查询原来的数据
        $sql = "select * from lkt_product_list where store_id = '$store_id' and recycle = 0 and id = '$id'";
        $r_arr = $db->select($sql);
        // 根据产品id,修改产品信息
        $sql_1 = "update lkt_product_list set product_title='$product_title',product_number='$product_number',product_class='$product_class',brand_id ='$brand_id',keyword='$keyword',weight='$weight',s_type='$type',num='$z_num',min_inventory='$min_inventory',content='$content',imgurl='$image',distributor_id='$distributor_id',is_distribution='$is_distribution',subtitle='$subtitle',freight='$freight',is_hexiao='$is_hexiao',hxaddress='$hxaddress',show_adr='$show_adr',active='$active',initial='$initial' where store_id = '$store_id' and mch_id = '$mch_id' and id = '$id'";
        $r_update = $db->update($sql_1);
        if ($r_update == -1) {
            $rew1 = 0; // 修改失败
        } else {
            $rew1 = 1; // 修改成功
        }

        $cids = array();
        if ($attributes) {
            $sql = "select id from lkt_configure where pid = '$id' and recycle = 0";
            $rcs = $db->select($sql);
            if ($rcs) {
                foreach ($rcs as $keyc => $valuec) {
                    $cids[$valuec->id] = $valuec->id;
                }
            }
        }

        foreach ($attributes as $ke => $va) {
            $num = $va['num'];
            $cid = $va['cid'];
            $total_num = $va['total_num'];
            $va['min_inventory'] = $min_inventory;
            $va['ctime'] = 'CURRENT_TIMESTAMP';
            $va = Tools::array_key_remove($va, 'cid');

            if ($cid) {
                if (array_key_exists($cid, $cids)) {
                    unset($cids[$cid]);
                }
                // 查询剩余数量
                $ccc = $db->select("select num from lkt_configure where id = '$cid' and recycle = 0 ");
                $cnums = $ccc ? $ccc[0]->num : 0;
                $z_num1 = $num - $cnums; // 传过来的剩余数量 - 数据库里的剩余数量

                $r_attribute = $db->modify($va, 'lkt_configure', " `id` = '$cid'");

                $attribute_id = $cid;
                if ($r_attribute < 1) {
                    $r_attribute = $db->modify($va, 'lkt_configure', " `id` = '$cid'", 1);

                    $JurisdictionAction->admin_record($store_id,$admin_name,'商品ID为'.$id.'属性数据修改失败',2);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为'.$id.'属性数据修改失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('status' => '属性数据修改失败，请稍后再试！'));
                    exit;
                }
            } else {
                $va['pid'] = $id;
                $r_attribute = $db->insert_array($va, 'lkt_configure', '', 1);
                $z_num1 = $num;
                $attribute_id = $r_attribute;
                if ($r_attribute < 1) {
                    $JurisdictionAction->admin_record($store_id,$admin_name,'商品ID为'.$id.'属性数据添加失败',1);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为'.$id.'属性数据添加失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();
                    echo json_encode(array('status' => '属性数据添加失败，请稍后再试！'));
                    exit;
                }
            }
            if ($z_num1 > 0) { // 增加
                // 在库存记录表里，添加一条入库信息
                $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id','$attribute_id','$total_num','$z_num1',0,CURRENT_TIMESTAMP)";
                $db->insert($sql);
                if ($min_inventory >= $z_num1) { // 当属性库存低于等于预警值
                    // 在库存记录表里，添加一条预警信息
                    $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id','$attribute_id','$total_num','$z_num1',2,CURRENT_TIMESTAMP)";
                    $db->insert($sql);
                }
            }else if($z_num1 == 0){

            }else{ // 减少
                $j_num = $cnums - $num; // 传过来的剩余数量 - 数据库里的剩余数量
                // 在库存记录表里，添加一条入库信息
                $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id','$attribute_id','$total_num','$j_num',1,CURRENT_TIMESTAMP)";
                $db->insert($sql);
            }
        }
        //删除属性
        if (!empty($cids)) {
            foreach ($cids as $keyds => $valueds) {
                $db->delete("DELETE FROM `lkt_configure` WHERE (`id`='$valueds')");
            }
        }

        $JurisdictionAction = new JurisdictionAction();

        if ($rew1 == 1) {

            $JurisdictionAction->admin_record($store_id,$admin_name,'修改商品ID为' . $id.'成功',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品ID为' . $id.'成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '产品修改成功！', 'suc' => '1'));
            exit;
        } else {
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改商品ID为' . $id . '失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品ID为' . $id . '失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '未知原因，产品修改失败！'));
            exit;
        }
        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}

?>