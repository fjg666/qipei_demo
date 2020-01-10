<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class AddproductAction extends Action
{


    public function getDefaultView()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = $request->getParameter('m');
        if ($m != '') {
            $this->$m();
            exit;
        }
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $product_class = $request->getParameter('cid'); // 分类名称
        $brand_id = $request->getParameter('brand'); // 标题
        $product_title = $request->getParameter('pro_name'); // 标题

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

        //查询商品分类
        $sql01 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 ";
        $rr = $db->select($sql01);
        $res = '';
        foreach ($rr as $key => $value) {
            $c = '-' . $value->cid . '-';
            //判断所属类别 添加默认标签
            if ($product_class == $c) {
                $res .= '<option selected="selected" value="' . $c . '">' . $value->pname . '</option>';
            } else {
                $res .= '<option  value="' . $c . '">' . $value->pname . '</option>';
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
                        $res .= '<option selected="selected" value="' . $cone . '">' . $hx . $ve->pname . '</option>';
                    } else {
                        $res .= '<option  value="' . $cone . '">' . $hx . $ve->pname . '</option>';
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
                                $res .= '<option selected="selected" value="' . $ctow . '">' . $hxe . $v->pname . '</option>';
                            } else {
                                $res .= '<option  value="' . $ctow . '">' . $hxe . $v->pname . '</option>';
                            }
                        }
                    }
                }
            }
        }
        $arr = array();
        $condition = " a.store_id = '$store_id' and a.recycle = 0 and a.active like '%2%' ";
        if ($product_class != '') {
            $condition .= " and a.product_class like '%$product_class%' ";
        }
        if ($brand_id != '') {
            $condition .= " and a.brand_id=$brand_id ";
        }
        if ($product_title != '') {
            $condition .= " and a.product_title like '%$product_title%' ";
        }

        //根据条件查询商品
        $sql = "select  a.id,a.product_title,a.imgurl,product_class from lkt_product_list as a where $condition and a.status=2 and a.mch_status = 2 and is_distribution=0 and EXISTS(select * from lkt_configure as c where c.pid=a.id and c.num>0) and a.id not in (select product_id from lkt_group_product group by product_id having min(attr_id)) order by status asc,a.add_date desc,a.sort desc limit $start,$pagesize";
        $r = $db->select($sql);

        //分页
        $countsql = "select count(*) as count from lkt_product_list as a where $condition and a.status=2 and a.mch_status = 2 and is_distribution=0 and EXISTS(select * from lkt_configure as c where c.pid=a.id and c.num>0) and a.id not in (select product_id from lkt_group_product group by product_id having min(attr_id))";
        $count = $db->select($countsql);
        $total = intval($count[0]->count);

        $pager = new ShowPager($total, $pagesize, $page);
        $url = "index.php?module=go_group&action=addproduct&cid=" . urlencode($product_class) . "&product_title=" . urlencode($product_title) . "&pagesize=" . urlencode($pagesize);
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        $list = array();
        $status_num = 0;
        if (!empty($r)) {
            foreach ($r as $key => $value) {
                $pid = $value->id;
                $class = $value->product_class;
                $typestr = trim($class, '-');
                $typeArr = explode('-', $typestr);
                //  取数组最后一个元素 并查询分类名称
                $cid = end($typeArr);
                $sql_p = "select pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid ='" . $cid . "'";
                $r_p = $db->select($sql_p);
                if ($r_p) {
                    $pname = $r_p['0']->pname;
                } else {
                    $pname = '顶级';
                }


                foreach ($value as $k => $v) {
                    $arr[$k] = $v;
                }
                $arr['pname'] = $pname;

                $list[$key] = (object)$arr;
            }

            foreach ($list as $ke => $ve) {
                $list[$ke]->image = ServerPath::getimgpath($ve->imgurl, $store_id);
            }
        }
        //查询品牌
        $brandsql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0";
        $brandres = $db->select($brandsql);

        //查询当前可添加拼团的商品，并对数据做处理
        $prosql = "select b.num,b.min_inventory,a.attribute,a.price as prices ,MIN(a.price)as price,a.id as attr_id,b.id,b.product_title,b.imgurl,c.name 
                from lkt_configure as a 
                left join lkt_product_list as b on a.pid = b.id 
                left join lkt_mch as c on b.mch_id = c.id  
                where  b.active = 2 and b.status = 2 and b.recycle = 0  and b.id not in (SELECT product_id from lkt_group_product where store_id = 1 and is_delete = 0)
                group by b.id";
        $proattr = $db->select($prosql);
        //如果有数据
        if (!empty($proattr)) {
            //循环商品属性
            foreach ($proattr as $k => $v) {
                $attrtype1 = unserialize($v->attribute);
                $attrtype1 = array_values($attrtype1);
                $attrtype1 = implode(',', $attrtype1);

                $proattr[$k]->attrtype = $attrtype1;
                $proattr[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
                //查询是否有这个属性
                $sel_hava_attr_sql = "select * from lkt_group_product where store_id = $store_id and is_delete = 0 and attr_id = $v->attr_id";
                $sel_hava_attr_res = $db->select($sel_hava_attr_sql);
                if ($sel_hava_attr_res) {
                    $proattr[$k]->select = true;
                } else {
                    $proattr[$k]->select = false;
                }
            }
        }

        $request->setAttribute("proattr", $proattr);
        $request->setAttribute("arr", $list);
        $request->setAttribute("class", $res);
        $request->setAttribute("title", $product_title);
        $request->setAttribute("brand_id", $brand_id);
        $request->setAttribute("pages_show", $pages_show);
        $request->setAttribute("brandres", $brandres);
        return View :: INPUT;

    }

    /**
     * 查询商品分类
     */
    public function pro_brand1()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = $this->getContext()->getStorage()->read('store_id');
        $cid = addslashes(trim($request->getParameter('cid')));//产品分类id

        //根据产品分类 查询品牌数据
        $sql = "select b.brand_id,b.brand_name 
        from lkt_brand_class as b 
        right join lkt_product_list as p on p.brand_id=b.brand_id 
        where p.store_id='$store_id' and p.status=2 and p.active = 2 and p.product_class like '%$cid%' and p.id not in (SELECT product_id from lkt_group_product where store_id = 1 and is_delete = 0 )";

        $sql = "select brand_id,brand_name 
        from lkt_brand_class 
        where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%$cid%' 
        order by sort desc";
        echo $sql;
        $res = $db->select($sql);
        if (!empty($res)) {
            $arr = array();
            foreach ($res as $key => $value) {
                if (in_array($value->brand_id, $arr)) {
                    unset($res[$key]);
                } else {
                    $arr[] = $value->brand_id;
                }
            }
        }

        echo json_encode($res);
        exit;

    }

    // 获取品牌
    public function pro_brand(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $cid = $request->getParameter('cid');// 分类ID

        $cid = explode('-',$cid);
        $cids = '';
        foreach ($cid as $k => $v) {
            if(!empty($v)){
                $cids .= $v.',';
            }
        }

        // 查询此分类下品牌
        $sql = "select brand_id,brand_name 
        from lkt_brand_class 
        where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%$cids%' 
        order by sort desc";
        $res = $db -> select($sql);
        if(!empty($res)){
            $arr = array();
            foreach ($res as $key => $value) {
                if(in_array($value -> brand_id,$arr)){
                    unset($res[$key]);
                }else{
                    $arr[] = $value -> brand_id;
                }
            }
        }

        echo json_encode($res);exit;
    }

    /**
     * 查询出拼团商品
     */
    public function pro_query()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = $this->getContext()->getStorage()->read('store_id');
        $my_class = addslashes(trim($request->getParameter('my_class')));
        $my_brand = addslashes(trim($request->getParameter('my_brand')));
        $pro_name = addslashes(trim($request->getParameter('pro_name')));

        //拼接条件
        $condition = ' and b.recycle = 0 ';
        if ($my_class) {
            $condition .= " and b.product_class like '%{$my_class}%' ";
        }
        if ($my_brand) {
            $condition .= " and b.brand_id = '$my_brand' ";
        }
        if ($pro_name) {
            $condition .= " and b.product_title like '%{$pro_name}%' ";
        }

        //查询数据
        $sql = "select b.num,b.min_inventory,a.attribute,a.price,a.id as attr_id,b.id,b.product_title,b.imgurl,c.name 
                from lkt_configure as a 
                left join lkt_product_list as b on a.pid = b.id 
                left join lkt_mch as c on b.mch_id = c.id  
                where b.status = '2' and b.active = 2" . $condition . "
                and b.id not in (SELECT product_id from lkt_group_product where store_id = 1 and is_delete = 0 )
                group by b.id";
        $res = $db->select($sql);


        foreach ($res as $k => $v) {
            $v->image = ServerPath::getimgpath($v->imgurl, $store_id);
            $attr = unserialize($v->attribute);
            $attr = array_values($attr);
            if ($attr) {
                if (gettype($attr[0]) != 'string') unset($attr[0]);
            }
        }

        echo json_encode(array('res' => $res));
        exit;

    }

    public function execute()
    {

        $db = DBAction::getInstance();

        $request = $this->getContext()->getRequest();
        var_dump($request);
        exit;
    }


    public function getRequestMethods()
    {

        return Request :: NONE;

    }


}


?>