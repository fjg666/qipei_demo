<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action
{

    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018年12月12日
     * @version 2.0
     */
    public function add($obj = '')
    {
        $res1 = "L18";
        $res2 = "K";
        $res3 = "T";
        if ($obj == '') {
            $product_number = $res1 . '-' . $res2 . '001-' . $res3 . '001';
        } else {
            $arr = explode("-", $obj);
            $arr[1] = substr($arr[1], 1);
            $arr[2] = substr($arr[2], 1);
            $bit = 3;//产生7位数的数字编号

            if ((int)$arr[2] == 999) {
                $rew2 = (int)$arr[1] + 1;
                $rew3 = "001";
                $num_len = strlen($rew2);
                $zero = '';
                for ($i = $num_len; $i < $bit; $i++) {
                    $zero .= "0";
                }
                $real_num = $zero . $rew2;
                $product_number = $res1 . '-' . $res2 . $real_num . '-' . $res3 . $rew3;
            } else {
                $rew3 = (int)$arr[2] + 1;
                $num_len = strlen($rew3);
                $zero = '';
                for ($i = $num_len; $i < $bit; $i++) {
                    $zero .= "0";
                }
                $real_num = $zero . $rew3;
                $product_number = $res1 . '-' . $res2 . $arr[1] . '-' . $res3 . $real_num;
            }
        }
        return $product_number;
    }

    public function mch()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        $logo = addslashes(trim($request->getParameter('logo'))); // logo
        $name = addslashes(trim($request->getParameter('name'))); // 店铺名称
        $confines = addslashes(trim($request->getParameter('confines'))); // 经营范围
        $shop_information = addslashes(trim($request->getParameter('shop_information'))); // 店铺信息

        if (!empty($logo)) {
            $logo = preg_replace('/.*\//', '', $logo);
        } else {
            echo json_encode(array('status' => '店铺logo不能为空！'));
            exit;
        }


        $sql0 = "select name from lkt_admin where store_id = '$store_id' and type = 1";
        $r0 = $db->select($sql0);
        $user_id = $r0[0]->name; // 客户账号
        $sql1 = "insert into lkt_mch(store_id,user_id,name,shop_information,logo,review_status,add_time) values ('$store_id','$user_id','$name','$shop_information','$logo',1,CURRENT_TIMESTAMP)";
        $res_data = $db->insert($sql1, 'last_insert_id'); // 得到添加数据的id

        if ($res_data > 0) {
            $sql2 = "update lkt_admin set shop_id = '$res_data' where store_id = '$store_id'";
            $db->update($sql2);
            $JurisdictionAction->admin_record($store_id, $admin_name, '设置自营店铺成功', 1);

            $this->getContext()->getStorage()->write('mch_id', $res_data);

            echo json_encode(array('status' => '设置自营店铺成功！', 'suc' => '1'));
            exit;
        } else {
            $JurisdictionAction->admin_record($store_id, $admin_name, '设置自营店铺失败', 1);
            echo json_encode(array('status' => '未知原因，设置自营店铺失败！'));
            exit;
        }
    }

    public function del(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $mch_id = $this->getContext()->getStorage()->read('mch_id'); //店铺id

        $sql = "update lkt_product_number set status = 2 where store_id = '$store_id' and mch_id = '$mch_id' and operation = '$admin_name' and max(id)";
        $db->update($sql);

        echo json_encode(array('status' => '', 'suc' => '1'));
        exit;
    }

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $mch_id = $this->getContext()->getStorage()->read('mch_id'); //店铺id
        $m = addslashes(trim($request->getParameter('m'))); // 参数
        if ($m) {
            $this->$m();
        }
        // 查询最新一条已使用的商品编码
        $sql0 = "select product_number from lkt_product_number where store_id = '$store_id' and status = 1 order by addtime desc limit 1";
        $r0 = $db->select($sql0);
        if ($r0) {
            $product_number1 = $r0[0]->product_number;
            $product_number = $this->add($product_number1); // 获取商品编码
        } else {
            $product_number = $this->add(); // 获取商品编码
        }
        // 添加一条商品编码记录
        $sql1 = "insert into lkt_product_number(store_id,mch_id,operation,product_number,addtime) values ('$store_id','$mch_id','$admin_name','$product_number',CURRENT_TIMESTAMP)";
        $r1 = $db->insert($sql1);

        // 运费
        $sql = "select id,name from lkt_freight where store_id = '$store_id' order by add_time desc";
        $rr = $db->select($sql);
        $freight = array();
        $freight_num = 0;
        if ($rr) {
            foreach ($rr as $k1 => $v1) {
                $freight_num++;
                $freight[$freight_num] = (object)array('id' => $v1->id, 'name' => $v1->name);
            }
        }
        $Plugin = new Plugin();
        $Plugin_arr = $Plugin->product_plugin($db, $store_id, 'product', '');
        $sp_type = Tools::s_type($db, '商品类型');
        $show_adr = Tools::s_type($db, '商品展示位置');
        $unit = Tools::s_type($db, '单位');

        $request->setAttribute("product_number", $product_number);
        $request->setAttribute("Plugin_arr", $Plugin_arr);
        $request->setAttribute("freight", $rr);
        $request->setAttribute('sp_type', $sp_type);
        $request->setAttribute('show_adr', $show_adr);
        $request->setAttribute('unit', $unit);
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
        $mch_id = $this->getContext()->getStorage()->read('mch_id'); //店铺id
        // 接收数据
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
            if(strlen($product_title) > 60){
                echo json_encode(array('status' => '商品标题不能超过20个中文字长度！'));
                exit;
            }else{
                $sql_0 = "select id from lkt_product_list where store_id = '$store_id' and recycle = 0 and product_title = '$product_title' and mch_id = '$mch_id'";
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
        // 检查键名 "center" 是否存在于数组中：
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
                unset($imgurls[0]);
            } else {
                echo json_encode(array('status' => '产品展示图不能为空！'));
                exit;
            }
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
        if (count($attr) == 0) {
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
                $z_num += $value['num'];
                $value['total_num'] = $value['num'];
                if ($value['img'] == '') {
                    echo json_encode(array('status' => "$attr_list_srt 的属性图片未上传！"));
                    exit;
                }
                //价格判断
                foreach ($value as $cvkey => $cvvalue) {
                    if (!is_array($cvvalue)) {
                        if(empty($cvvalue) &&  $cvvalue != 0){
                            echo json_encode(array('status' => "请完善属性！"));
                            exit;
                        }
                    }
                }
                $costprice = $value['costprice'];
                $yprice = $value['yprice'];
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
        $sort_sql = "select MAX(sort) as sort from lkt_product_list where store_id = '$store_id' and recycle = 0";
        $sort_r = $db->select($sort_sql);
        $sort= $sort_r[0]->sort +1 ;

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
                if($show_adr){
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

        // 发布产品
        $sql = "insert into lkt_product_list(store_id,product_title,subtitle,product_number,product_class,brand_id,keyword,weight,imgurl,sort,content,num,min_inventory,s_type,add_date,is_distribution,distributor_id,freight,is_hexiao,hxaddress,active,mch_id,mch_status,show_adr,initial,publisher) " .
            "values('$store_id','$product_title','$subtitle','$product_number','$product_class','$brand_id','$keyword','$weight','$image','$sort','$content','$z_num','$min_inventory','$type',CURRENT_TIMESTAMP,'$is_distribution','$distributor_id','$freight','$is_hexiao','$hxaddress','$active','$mch_id',2,'$show_adr','$initial','$admin_name')";
        $id1 = $db->insert($sql, 'last_insert_id'); // 得到添加数据的id

        if ($id1) {
            if ($imgurls) {
                $arrimg = array();
                $f_img = "select product_url from lkt_product_img where product_id = '$id1'";
                $rf = $db->select($f_img);
                if ($rf) {
                    foreach ($rf as $key => $fs) {
                        $arrimg[$fs->product_url] = $fs->product_url;
                    }
                }
                if (count($imgurls) > 5) {
                    $db->rollback();
                    echo json_encode(array('status' => '产品展示图数量超出限制！'));
                    exit;
                }

                foreach ($imgurls as $key => $file) {
                    $imgsURL_name = preg_replace('/.*\//', '', $file);
                    if (array_key_exists($imgsURL_name, $arrimg)) {
                        unset($arrimg[$imgsURL_name]);
                    }
                    $sql_img = "insert into lkt_product_img(product_url,product_id,add_date) " . "values('$imgsURL_name','$id1',CURRENT_TIMESTAMP)";
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
                if (!empty($arrimg)) {
                    foreach ($arrimg as $keys => $fss) {
                        $ql_img = "delete from lkt_product_img  where product_url = '$fss'";
                        $r = $db->delete($ql_img);
                    }
                }
            }
            foreach ($attributes as $ke => $va) {
                $va['pid'] = $id1;
                $va['total_num'] = $va['num'];
                $total_num = $va['num'];
                $va['min_inventory'] = $min_inventory;
                $va['ctime'] = 'CURRENT_TIMESTAMP';
                $r_attribute = $db->insert_array($va, 'lkt_configure', '', 1);
                if ($r_attribute < 1) {
                    $JurisdictionAction->admin_record($store_id,$admin_name,'属性数据添加失败',1);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 属性数据添加失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('status' => '属性数据添加失败，请稍后再试！'));
                    exit;
                }
                $num = $va['num'];
                // 在库存记录表里，添加一条入库信息
                $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id1','$r_attribute','$total_num','$num',0,CURRENT_TIMESTAMP)";
                $db->insert($sql);

                if ($min_inventory >= $num) { // 当属性库存低于等于预警值
                    // 在库存记录表里，添加一条预警信息
                    $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id1','$r_attribute','$total_num','$num',2,CURRENT_TIMESTAMP)";
                    $db->insert($sql);
                }
            }

            $sql = "update lkt_product_number set status = 1 where store_id = '$store_id' and mch_id = '$mch_id' and operation = '$admin_name' and product_number = '$product_number'";
            $db->update($sql);

            $JurisdictionAction->admin_record($store_id,$admin_name,'添加商品' . $product_title.'成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商品' . $product_title.'成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '产品发布成功！', 'suc' => '1'));
            exit;
        } else {
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加商品' . $product_title . '失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商品' . $product_title . '失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '未知原因，产品发布失败！'));
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
