<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');;

class Product_seeAction extends Action {

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
            $scan = $r[0]->scan; // 条形码
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
            $sort = $r[0]->sort;
            $distributor_id = $r[0]->distributor_id;//分销层级id
            $freight_id = $r[0]->freight;
            $is_hexiao = $r[0]->is_hexiao;
            $active = $r[0]->active;
            $hxaddress = $r[0]->hxaddress;
            $shop_id = $r[0]->mch_id;
        }

        $arr = explode(',', $s_type);
        $freight_name = '';

        $sql = "select id,name from lkt_freight where store_id = '$store_id' and id = '$freight_id' ";
        $r_freight = $db->select($sql);
        if ($r_freight) {
            $freight_name = $r_freight[0]->name;
        }

        //绑定产品分类
        $sql = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 ";
        $r = $db->select($sql);
        $product_class_name = '';
        foreach ($r as $key => $value) {
            $c = '-' . $value->cid . '-';
            //判断所属类别 添加默认标签
            if ($product_class == $c) {
                $product_class_name = $value->pname;
            }
            //循环第一层
            $sql_e = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = $value->cid";
            $r_e = $db->select($sql_e);
            if ($r_e) {
                $hx = '-----';
                foreach ($r_e as $ke => $ve) {
                    $cone = $c . $ve->cid . '-';
                    //判断所属类别 添加默认标签
                    if ($product_class == $cone) {
                        $product_class_name = $ve->pname;
                    }
                    //循环第二层
                    $sql_t = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = $ve->cid";
                    $r_t = $db->select($sql_t);
                    if ($r_t) {
                        $hxe = $hx . '-----';
                        foreach ($r_t as $k => $v) {
                            $ctow = $cone . $v->cid . '-';
                            //判断所属类别 添加默认标签
                            if ($product_class == $ctow) {
                                $product_class_name = $v->pname;
                            }
                        }
                    }
                }
            }
        }

        //产品品牌
        $sql02 = "select brand_id ,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and brand_id = '$brand_id' order by brand_time desc";
        $brand_class = $db->select($sql02);
        if($brand_class){
            $brand_class_name = $brand_class[0]->brand_name;
        }else{
            $brand_class_name = '';
        }

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
        $size = "select * from lkt_configure where pid = '$id'";
        $res_size = $db->select($size);
        if ($res_size) {
            $attr_group_list = array();
            $checked_attr_list = array();
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
                                    $attr_list = array('attr_name' => $value,'status' => false);
                                }else{
                                    $attr_list = array('attr_name' => $value,'status' => true);
                                }
                                array_push($attr_group_list[$keya]['attr_list'], $attr_list);
                                array_push($attr_group_list[$keya]['attr_all'], $value);
                            }
                        }
                    }
                    $attr_lists[] = array('attr_id' => '', 'attr_group_name' => $key, 'attr_name' => $value);
                }
                $checked_attr_list[] = array('attr_list' => $attr_lists, 'costprice' => $v->costprice, 'yprice' => $v->yprice, 'price' => $v->price, 'num' => $v->total_num, 'unit' => $v->unit, 'img' => ServerPath::getimgpath($v->img, $store_id), 'cid' => $v->id);
            }
            foreach ($attr_group_list as $key => $value) {
                $attr_group_list[$key] = Tools::array_key_remove($attr_group_list[$key], 'attr_all');
            }
        }
        $attr_group_list = json_encode($attr_group_list);
        $checked_attr_list = json_encode($checked_attr_list);
        //-------查询规格数据
        $Plugin = new Plugin();
        $Plugin_arr = $Plugin->is_Plugin1($db, $store_id, 'product', $active, $distributor_id);
        $show_adr = $show_adr == 0 ? array(0) : explode(',', $show_adr);

        $sp_type = Tools::s_type($db, '商品类型', $arr);
        $show_adr = Tools::s_type($db, '商品展示位置', $show_adr);
        if($initial != ''){
            $initial = unserialize($initial);
        }else{
            $initial = array();
        }
        $unit = Tools::s_type($db, '单位',$initial);
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
        $request->setAttribute('scan', isset($scan) ? $scan : '');
        $request->setAttribute("product_class_name", $product_class_name);
        $request->setAttribute('brand_class_name', $brand_class_name);//所有品牌
        $request->setAttribute('imgurls', isset($imgurls) ? $imgurls : '');

        $request->setAttribute('initial', isset($initial) ? $initial : '');
        $request->setAttribute('status', isset($status) ? $status : '');
        $request->setAttribute('unit', $unit);
        $request->setAttribute('attr_group_list', $attr_group_list);
        $request->setAttribute('checked_attr_list', $checked_attr_list);

        $request->setAttribute('min_inventory', isset($min_inventory) ? $min_inventory : '');
        $request->setAttribute('freight_name', $freight_name);// 运费
        $request->setAttribute('sort', isset($sort) ? $sort : '');
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

    public function execute() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg'); // 图片上传路径
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号

        $id = addslashes(trim($request->getParameter('id'))); // 产品id
        $attribute_id = addslashes(trim($request->getParameter('attribute_id'))); // 属性id
        $num = $request->getParameter('num'); // 数量
        if(floor($num) == $num){
            if($num > 0){
                $sql = "update lkt_configure set num = '$num' where pid = '$id' and id = '$attribute_id'";
                $rr = $db->update($sql);

                $sql = "select num from lkt_configure where pid = '$id'";
                $r = $db->select($sql);
                if($r){
                    $znum = 0;
                    foreach ($r as $k => $v){
                        $znum += $v->num;
                    }
                    $sql = "update lkt_product_list set num = '$znum' where id = '$id'";
                    $db->update($sql);
                }
                if($rr == -1) {
                    $JurisdictionAction->admin_record($store_id,$admin_name,' 修改属性ID为 '.$attribute_id.' 的库存失败 ',2);

                    echo 0;
                    exit;
                } else {
                    $JurisdictionAction->admin_record($store_id,$admin_name,' 修改属性ID为 '.$attribute_id.' 的库存 ',2);

                    echo 1;
                    exit;
                }
            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,' 修改属性ID为 '.$attribute_id.' 的库存失败 ',2);

                echo 0;
                exit;
            }
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,' 修改属性ID为 '.$attribute_id.' 的库存失败 ',2);

            echo 0;
            exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>