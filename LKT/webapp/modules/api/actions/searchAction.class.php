<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once('Apimiddle.class.php');

class searchAction extends Apimiddle
{

    public function getDefaultView()
    {
        return;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $m = addslashes(trim($request->getParameter('m')));

        $this->$m();

//        if ($m == 'index') {
//            $this->index();
//        } else if ($m == 'search') {
//            $this->search();
//        } else if ($m == 'listdetail') {
//            $this->listdetail();
//        }
        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        //查询商品并分类显示返回JSON至小程序
        $sql_c = 'select cid,pname,img,bg from lkt_product_class where store_id = \''.$store_id.'\' and recycle = 0 and sid=0 order by sort desc';
        $r_c = $db->select($sql_c);
        $twoList = [];
        $abc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $st = 0;
        $icons = [];
        if($r_c){
            foreach ($r_c as $key => $value) {
                $sql_e = 'select cid,pname,img from lkt_product_class where store_id = \''.$store_id.'\' and recycle = 0 and sid=\'' . $value->cid . '\' order by sort ';
                $r_e = $db->select($sql_e);
                $son = [];
                if ($r_e) {
                    foreach ($r_e as $ke => $ve) {
                        $imgurl = ServerPath::getimgpath($ve->img);
                        $son[$ke] = array('child_id' => $ve->cid, 'name' => $ve->pname, 'picture' => $imgurl);
                    }
                    $type = true;
                } else {
                    $type = false;
                }
                if ($value->bg) {
                    $cimgurl = ServerPath::getimgpath($value->bg);
                } else {
                    $cimgurl = '';
                }

                $icons[$key] = array('cate_id' => $value->cid, 'cate_name' => $value->pname, 'ishaveChild' => $type, 'children' => $son, 'cimgurl' => $cimgurl);

            }
        }

        $list = [];
        $sql = "select keyword from lkt_product_list where store_id = '$store_id' and keyword != '' and num > 0 and status = 0 order by volume desc,add_date desc limit 6";
        $r = $db->select($sql);
        if($r){
            foreach ($r as $k => $v){
                if($v->keyword){
                    $list[] = $v->keyword;
                }
            }
        }
        $list = array_unique($list);
        echo json_encode(array('status' => 1, 'List' => $icons, 'hot' => $list));
        exit;
    }

    public function search()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $keyword = trim($request->getParameter('keyword')); // 关键词
        $num = trim($request->getParameter('num')); //  '次数'
        $select = trim($request->getParameter('select')); //  选中的方式 0 默认  1 销量   2价格
        $sort = trim($request->getParameter('sort')); // 排序方式  1 asc 升序   0 desc 降序

        if ($select == 0) {
            $select = 'a.add_date';
        } elseif ($select == 1) {
            $select = 'a.volume';
        } else {
            $select = 'price';
        }
        if ($sort) {
            $sort = ' asc ';
        } else {
            $sort = ' desc ';
        }

        //查出所有产品分类
        $sql = 'select pname,cid from lkt_product_class where store_id = \''.$store_id.'\' and recycle = 0 ';
        $res = $db->select($sql);
        if($res){
            foreach ($res as $key => $value) {
                $types[$value->pname] = $value->cid;
            }
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        //判断如果关键词是产品分类名称，如果是则查出该类里所有商品
        if (array_key_exists($keyword, $types)) {
            $type = 0;
            $cid = $types[$keyword];
            $start = 10 * ($num - 1);
            $end = 10;
            $sqlb = "select a.id,product_title,a.imgurl,a.volume,a.s_type,c.id as cid,c.yprice,c.img,c.name,c.color,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.product_class like '%-$cid-%' and a.status = 0 group by c.pid order by $select $sort  LIMIT $start,$end";
            $data = $db->select($sqlb);

        } else {   //如果不是商品分类名称，则直接搜产品
            $type = 1;
            $keyword = addslashes($keyword);
            $sqlb = "select a.id,a.product_title,a.product_class,a.imgurl,a.volume,a.s_type,c.id as cid,c.yprice,c.img,c.name,c.color,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.product_title like '%$keyword%' and a.status = 0 group by c.pid order by $select $sort";
            $data = $db->select($sqlb);
        }
        if (!empty($data)) {
            $product = array();
            $subarr = $this -> getsubactive($store_id);     //查询当前是否有满减活动
            foreach ($data as $k => $v) {
                $imgurl = ServerPath::getimgpath($v->imgurl);/* end 保存*/
                if ($type == 1) {
                    $cid = $v->product_class;
                } else {
                    $cid = $cid;
                }
                $s_type = explode(',', $v->s_type);
                $xp = 0;
                $rexiao = 0;
                $tuijian = 0;
                foreach ($s_type as $k1 => $v1) {
                    if ($v1 == 1) {
                        $xp = 1;
                    } else if ($v1 == 2) {
                        $rexiao = 1;
                    } else if ($v1 == 3) {
                        $tuijian = 1;
                    }
                }
                if(!empty($subarr) && in_array($v->id,$subarr)){       //判断是否是满减产品
                    $issub = true;
                }else{
                    $issub = false;
                }
                $product[$k] = array('id' => $v->id, 'name' => $v->product_title, 'price' => $v->yprice, 'price_yh' => $v->price, 'imgurl' => $imgurl, 'size' => $v->cid, 'volume' => $v->volume, 's_type' => $v->s_type, 'xp' => $xp, 'rexiao' => $rexiao, 'tuijian' => $tuijian, 'issub' => $issub);
            }
            echo json_encode(array('list' => $product, 'cid' => $cid, 'code' => 1, 'type' => $type));
            exit();
        } else {
            echo json_encode(array('status' => 0, 'err' => '没有更多商品了！'));
            exit();
        }
    }

    public function listdetail()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $id = trim($request->getParameter('cid')); //  '分类ID'
        $paegr = trim($request->getParameter('page')); //  '页面'
        $select = trim($request->getParameter('select')); //  选中的方式 0 默认  1 销量   2价格
        if ($select == 0) {
            $select = 'a.add_date';
        } elseif ($select == 1) {
            $select = 'a.volume';
        } else {
            $select = 'price';
        }

        $sort = trim($request->getParameter('sort')); // 排序方式  1 asc 升序   0 desc 降序
        if ($sort) {
            $sort = ' asc ';
        } else {
            $sort = ' desc ';
        }
        if (!$paegr) {
            $paegr = 1;
        }
        $start = ($paegr - 1) * 10;
        $end = 10;
        $bg = '';
        $sql_c = "select bg from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid='$id' ";
        $r_c = $db->select($sql_c);
        if ($r_c) {
            $bg = ServerPath::getimgpath($r_c[0]->bg);
        }

        $sql = "select a.id,a.product_title,a.imgurl,a.volume,min(c.price) as price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.product_class like '%$id%' and c.num >0 and a.status = 0 group by c.pid  order by $select $sort LIMIT $start,$end ";
        $r = $db->select($sql);

        if ($r) {
            $product = [];
            $subarr = $this -> getsubactive($store_id);     //查询当前是否有满减活动
            foreach ($r as $k => $v) {
                $imgurl = ServerPath::getimgpath($v->imgurl);/* end 保存*/
                $names = ' ' . $v->name . $v->color;
                if ($v->name == $v->color || $v->name == '默认') {
                    $names = '';
                }
                $s_type = explode(',', $v->s_type);
                $xp = 0;
                $rexiao = 0;
                $tuijian = 0;
                foreach ($s_type as $k1 => $v1) {
                    if ($v1 == 1) {
                        $xp = 1;
                    } else if ($v1 == 2) {
                        $rexiao = 1;
                    } else if ($v1 == 3) {
                        $tuijian = 1;
                    }
                }
                if(!empty($subarr) && in_array($v->id,$subarr)){       //判断是否是满减产品
                    $issub = true;
                }else{
                    $issub = false;
                }
                $product[$k] = array('id' => $v->id, 'name' => $v->product_title . $names, 'price' => $v->yprice, 'price_yh' => $v->price, 'imgurl' => $imgurl, 'size' => $v->sizeid, 'volume' => $v->volume, 's_type' => $v->s_type, 'xp' => $xp, 'rexiao' => $rexiao, 'tuijian' => $tuijian, 'issub' => $issub);
            }
            echo json_encode(array('status' => 1, 'pro' => $product, 'bg' => $bg));
            exit;
        } else {
            echo json_encode(array('status' => 0, 'err' => '没有了！'));
            exit;
        }
    }

    public function getsubactive($store_id){
        $db = DBAction::getInstance();
        $subsql = "select goods from lkt_subtraction where store_id = '$store_id' and status = 1";
        $subres = $db -> select($subsql);     //查询当前是否有满减活动
        if(!empty($subres)){
            $subarr = explode(',',$subres[0] -> goods);
        }else{
            $subarr = array();
        }
        return $subarr;
    }
}

?>