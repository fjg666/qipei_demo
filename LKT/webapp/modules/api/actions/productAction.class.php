<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once('Apimiddle.class.php');

class productAction extends Apimiddle
{
    /*
    时间2018年03月15日
    修改内容：所有商品购买付款下订单等操作API请求
    修改人：苏涛
    主要功能：处理商品数据，返回购物请求结果
    备注：api-JSON
     */
    public function getDefaultView()
    {
        $this->execute();
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
//        if ($m == 'index') {
//            $this->index();
//        } else if ($m == 'add_cart') {
//            $this->add_cart();
//        } else if ($m == 'listdetail') {
//            $this->listdetail();
//        } else if ($m == 'get_more') {
//            $this->get_more();
//        }else if ($m == 'Shopping') {
//            $this->Shopping();
//        } else if ($m == 'delcart') {
//            $this->delcart();
//        } else if ($m == 'delAll_cart') {
//            $this->delAll_cart();
//        } else if ($m == 'to_Collection') {
//            $this->to_Collection();
//        } else if ($m == 'up_cart') {
//            $this->up_cart();
//        } else if ($m == 'comment') {
//            $this->comment();
//        } else if ($m == 't_comment') {
//            $this->t_comment();
//        } else if ($m == 'new_product') {
//            $this->new_product();
//        }else if ($m == 'select_size') {
//            //属性选择
//            $this->select_size();
//        } else if ($m == 'save_formid') {
//            //普通商品储存from_id 用于发货 退款等操作信息推送
//            $this->save_formid();
//        }
        $this->$m();

        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    // 获取产品详情
    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取产品id
        $id = trim($request->getParameter('pro_id'));
        $openid = trim($request->getParameter('openid'));

        // 根据微信id,查询用户id
        $type1 = $request->getParameter('type1');
        $choujiangid = $request->getParameter('choujiangid');
        $wx_id = $request->getParameter('wx_id');
        $t_user_id = $request->getParameter('userid');
        $price01 = '';
        $type01 = '';

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名

        $type = 0;
        $collection_id = '';
        if ($openid) {

            $sql = "select * from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
            $r = $db->select($sql);
            $user_id = $r[0]->user_id;

            if ($t_user_id != $user_id) {
                $sqlu = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
                $resu = $db->select($sqlu);
                if (!$resu) {
                    if ($t_user_id) {
                        //  2018-09-10 添加防止不是具有分销等级的会员绑定同样不是分销等级的会员关系
                        $qsql = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = '1' ";
                        $qres = $db->select($qsql);
                        //普通等级 id 没有权限进入分销 和绑定关系
                        if ($qres) {
                            $qtid = $qres[0]->id;
                        } else {
                            $qtid = 0;
                        }
                        $sqlc = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$t_user_id' and level != '$qtid' ";
                        $resc = $db->select($sqlc);
                        //-----控制结束
                        //分销推荐
                        if ($resc) {
                            $sqlqw = "select user_id from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
                            $resqw = $db->select($sqlqw);
                            if (!$resqw) {
                                $rt = $resc[0]->rt;
                                $level = $qtid;
                                $uplevel = $resc[0]->uplevel + 1;
                                $ups01 = "update lkt_user_distribution set lt = lt + 2 where store_id = '$store_id' and lt>='$rt'";
                                $ups02 = "update lkt_user_distribution set rt = rt + 2 where store_id = '$store_id' and rt>='$rt'";
                                $lrt = $rt + 1;
                                $ups03 = "INSERT INTO lkt_user_distribution ( `store_id`,`user_id`, `pid`, `level`, `lt`, `rt`, `uplevel`, `add_date`) VALUES ( '$store_id','$user_id', '$t_user_id', '$level', '$rt', '$lrt', '$uplevel', CURRENT_TIMESTAMP)";
                                $db->update($ups01);
                                $db->update($ups02);
                                $db->insert($ups03);
                            }
                        }
                    }
                }
            }


            // 根据用户id、产品id,获取收藏表信息
            $sql = "select * from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and p_id = '$id'";
            $rr = $db->select($sql);
            if ($rr) {
                $type = 1;
                $collection_id = $rr['0']->id;
            } else {
                $type = 0;
                $collection_id = '';
            }
            $time = date("Y-m-d");
            // 根据用户id,在足迹表里插入一条数据
            $sql_collection = "select * from lkt_user_footprint where store_id = '$store_id' and user_id = '$user_id' and p_id = '$id' and add_time like '$time%' ";
            $rr_collection = $db->select($sql_collection);

            if (empty($rr_collection)) {
                $sql = "insert into lkt_user_footprint(store_id,user_id,p_id,add_time) values('$store_id','$user_id','$id',CURRENT_TIMESTAMP)";
                $rrr = $db->insert($sql);
            }
            $zhekou = '';
        }


        // 根据产品id,查询产品数据
        $sql = "select a.*,c.price,c.yprice,c.attribute,c.img from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = '$id' and a.status = 0 and a.recycle = 0";
        $res = $db->select($sql);
        if (!$res) {
            echo json_encode(array('status' => 0, 'err' => '该商品已下架！'));
            exit();
        } else {
            $img_arr = [];
            $sql_img = "select product_url,id from lkt_product_img where product_id = '$id'";
            $r = $db->select($sql_img);
            if ($r) {
                foreach ($r as $key => $value) {
                    $img_arr[$key] = ServerPath::getimgpath($value->product_url);
                }
            } else {
                $img_arr['0'] = ServerPath::getimgpath($res['0']->imgurl);
            }
            $class = $res['0']->product_class;
            $typestr = trim($class, '-');
            $typeArr = explode('-', $typestr);
            //  取数组最后一个元素 并查询分类名称
            $cid = end($typeArr);
            $sql_p = "select pname from lkt_product_class where store_id = '$store_id' and cid ='" . $cid . "'";
            $r_p = $db->select($sql_p);
            $pname = '自营';
            if ($r_p) {
                $pname = $r_p['0']->pname;
            }
            $pname = $r_p['0']->pname;
            $product = [];
            $imgurl = ServerPath::getimgpath($res['0']->img);
            $content = $res['0']->content;

            // $newa = substr($uploadImg_domain, 0, strrpos($uploadImg_domain, '/'));
            // if ($newa == 'http:/' || $newa == 'https:/') {
            //     $newa = $uploadImg_domain;
            // }
            //$new_content = preg_replace('/(<img.+?src=")(.*?)/', "$1$newa$2", $content);
            $new_content = $content;
            $freight_id = $res[0]->freight;
            $sql = "select * from lkt_freight where store_id = '$store_id' and id = '$freight_id'";
            $r_freight = $db->select($sql);
            if ($r_freight) {
                $freight = unserialize($r_freight[0]->freight); // 属性
                foreach ($freight as $k => $v) {
                    foreach ($v as $k1 => $v1) {
                        $freight_list[$k]['freight'] = $v['two'];
                        $freight_list[$k]['freight_name'] = $v['name'];
                    }
                }
                $product['freight'] = $freight[0]['two'];
            } else {
                $product['freight'] = 0.00;
            }
            $s_type = explode(',', $res['0']->s_type);
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
            $product['xp'] = $xp;
            $product['rexiao'] = $rexiao;
            $product['tuijian'] = $tuijian;

            $product['id'] = $res['0']->id;
            $product['shop_id'] = $res['0']->id;
            $product['name'] = $res['0']->product_title;
            $product['intro'] = $res['0']->product_title;
            $product['num'] = $res['0']->num;
            $product['price'] = $res['0']->yprice;
            $product['price_yh'] = $res['0']->price;
            $product['price11'] = $price01 ? $price01 : '';
            $product['type01'] = $type01 ? $type01 : '';
            $product['photo_x'] = $imgurl;
            $product['photo_d'] = $res['0']->img;
            $product['content'] = $new_content;
            $product['pro_number'] = $res['0']->id;
            $product['company'] = '件';
            $product['cat_name'] = $pname;
            $product['brand'] = '来客推';
            $product['img_arr'] = $img_arr;
            $product['choujiangid'] = $choujiangid ? '' : $choujiangid;
            $product['volume'] = $res['0']->volume;
            $product['is_zhekou'] = $res['0']->is_zhekou;
            if ($type1 == 1) {
                $product['type111'] = 1;
                $wx_id = $wx_id;
            } else {
                $product['type111'] = 2;
                $wx_id = '';
            }

            if (!empty($res[0]->brand_id)) {
                $b_id = $res[0]->brand_id;
                $sql01 = "select brand_name from lkt_brand_class where store_id = '$store_id' and brand_id = '$b_id'";
                $r01 = $db->select($sql01);
            }
            if (!empty($r01)) {
                $product['brand_name'] = $r01[0]->brand_name;
            } else {
                $product['brand_name'] = '无';
            }

            $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.size,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id where a.store_id = '$store_id' and a.pid = '$id'";
            $r_c = $db->select($sql_c);
            $arr = [];
            foreach ($r_c as $key => $value) {
                $va = (array)$value;
                $va['time'] = substr($va['add_time'], 0, 10);
                //-------------2018-05-03  修改  作用:返回评论图片
                $comments_id = $va['id'];
                $comments_sql = "select comments_url from lkt_comments_img where comments_id = '$comments_id' ";
                $comment_res = $db->select($comments_sql);
                $va['images'] = '';
                if ($comment_res) {
                    $va['images'] = $comment_res;
                    $array_c = [];
                    foreach ($comment_res as $kc => $vc) {
                        $url = $vc->comments_url;
                        $array_c[$kc] = array('url' => ServerPath::getimgpath($url));
                    }
                    $va['images'] = $array_c;
                }
                //-------------2018-07-27  修改
                $ad_sql = "select content from lkt_reply_comments where store_id = '$store_id' and cid = '$comments_id' and uid = 'admin' ";
                $ad_res = $db->select($ad_sql);
                if ($ad_res) {
                    $reply_admin = $ad_res[0]->content;
                } else {
                    $reply_admin = '';
                }

                $va['reply'] = $reply_admin;

                $obj = (object)$va;
                $arr[$key] = $obj;
            }
            $commodityAttr = [];
            $sql_size = "select * from lkt_configure where pid = '$id' AND num > 0";
            $r_size = $db->select($sql_size);
            $array_price = [];
            $array_yprice = [];
            $skuBeanList = [];
            $attrList = [];
            if ($r_size) {

                $attrList = [];
                $a = 0;
                $attr = [];
                foreach ($r_size as $key => $value) {
                    $array_price[$key] = $value->price;
                    $array_yprice[$key] = $value->yprice;
                    $attribute = unserialize($value->attribute);
                    $attnum = 0;
                    $arrayName = [];
                    foreach ($attribute as $k => $v) {
                        if (!in_array($k, $arrayName)) {
                            array_push($arrayName, $k);
                            $kkk = $attnum++;
                            $attrList[$kkk] = array('attrName' => $k, 'attrType' => '1', 'id' => md5($k), 'attr' => [], 'all' => []);
                        }
                    }
                }


                foreach ($r_size as $key => $value) {
                    $attribute = unserialize($value->attribute);
                    $attributes = [];
                    $name = '';
                    foreach ($attribute as $k => $v) {
                        $attributes[] = array('attributeId' => md5($k), 'attributeValId' => md5($v));
                        $name .= $v;
                    }

                    $cimgurl = ServerPath::getimgpath($value->img);

                    $skuBeanList[$key] = array('name' => $name, 'imgurl' => $cimgurl, 'cid' => $value->id, 'price' => $value->price, 'count' => $value->num, 'attributes' => $attributes);


                    for ($i = 0; $i < count($attrList); $i++) {
                        $attr = $attrList[$i]['attr'];
                        $all = $attrList[$i]['all'];
                        foreach ($attribute as $k => $v) {
                            if ($attrList[$i]['attrName'] == $k) {
                                $attr_array = array('attributeId' => md5($k), 'id' => md5($v), 'attributeValue' => $v, 'enable' => false, 'select' => false);

                                if (empty($attr)) {
                                    array_push($attr, $attr_array);
                                    array_push($all, $v);
                                } else {
                                    if (!in_array($v, $all)) {
                                        array_push($attr, $attr_array);
                                        array_push($all, $v);
                                    }
                                }

                            }
                        }
                        $attrList[$i]['all'] = $all;
                        $attrList[$i]['attr'] = $attr;
                    }

                }
            }
            //排序
            asort($array_price);
            asort($array_yprice);
            //获取价格区间并返回
            $qj_price = reset($array_price) == end($array_price) ? reset($array_price) : reset($array_price) . '-' . end($array_price);
            $qj_yprice = reset($array_yprice) == end($array_yprice) ? reset($array_yprice) : reset($array_yprice) . '-' . end($array_yprice);
            //返回JSON             $skuBeanList = []; $attrList = [];
            $share = array('friends' => true, 'friend' => true);
            echo json_encode(array('status' => 1, 'pro' => $product, 'qj_price' => $qj_price, 'qj_yprice' => $qj_yprice, 'attrList' => $attrList, 'skuBeanList' => $skuBeanList, 'collection_id' => $collection_id, 'comments' => $arr, 'type' => $type, 'wx_id' => $wx_id, 'share' => $share, 'zhekou' => $zhekou));
            exit();
        }
    }

    //普通商品储存from_id 用于发货 退款等操作信息推送
    public function save_formid()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $uid = addslashes(trim($request->getParameter('userid')));
        $formid = addslashes(trim($request->getParameter('from_id')));
        $lifetime = date('Y-m-d H:i:s', time() + 7 * 24 * 3600);
        if ($formid != 'the formId is a mock one' && $formid != '') {
            $addsql = "insert into lkt_user_fromid(store_id,open_id,fromid,lifetime) values('$store_id','$uid','$formid','$lifetime')";
            $addres = $db->insert($addsql);
            echo json_encode(array('status' => 1, 'succ' => $addres));
        }
    }

    // 加入购物车
    public function add_cart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $Uid = trim($request->getParameter('uid')); //  '微信id',
        $Goods_id = trim($request->getParameter('pid')); //  '产品id',
        $Goods_num = trim($request->getParameter('num')); //  '数量',
        $size_id = trim($request->getParameter('sizeid')); //  '商品属性id',
        $pro_type = trim($request->getParameter('pro_type')); //  '点击类型',
        if (empty($Uid) || empty($Goods_id) || empty($Goods_id) || empty($size_id)) {
            echo json_encode(array('status' => 0, 'info' => '添加失败请重新提交!!'));
        } else {
            $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$Uid'";
            $r_1 = $db->select($sql);
            if($r_1){
                $user_id = $r_1[0]->user_id;
            }else{
                echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
                exit();
            }

            $sql_k = "select num from lkt_configure where pid = '$Goods_id' and num > 0";
            $res_k = $db->select($sql_k);
            if($res_k){
                $num = $res_k[0]->num;
            }else{
                echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
                exit();
            }
            if ($num >= $Goods_num) {
                //查询购物车是否有过改商品，有则修改 无则新增
                $sql_c = "select Goods_num,id from lkt_cart where store_id = '$store_id' and Uid = '$Uid' and Goods_id = '$Goods_id' and Size_id = '$size_id'";
                $res = $db->select($sql_c);
                if ($res) {
                    //根据点击的类型进行修改
                    if ($pro_type == 'buynow') {
                        $sql_u = "update lkt_cart set Goods_num = '$Goods_num' where store_id = '$store_id' and Uid = '$Uid' and Goods_id = '$Goods_id' and Size_id = '$size_id'";
                        $r_u = $db->update($sql_u);
                    } else {
                        $Goods_num1 = $res[0]->Goods_num;
                        if($Goods_num + $Goods_num1 > $num){
                            $sql_u = "update lkt_cart set Goods_num = '$num' where store_id = '$store_id' and Uid = '$Uid' and Goods_id = '$Goods_id' and Size_id = '$size_id'";
                        }else{
                            $sql_u = "update lkt_cart set Goods_num = Goods_num+'$Goods_num' where store_id = '$store_id' and Uid = '$Uid' and Goods_id = '$Goods_id' and Size_id = '$size_id'";
                        }
                        $r_u = $db->update($sql_u);
                    }
                    echo json_encode(array('status' => 1, 'cart_id' => $res['0']->id));
                } else {
                    $sql = "insert into lkt_cart (store_id,user_id,Uid,Goods_id,Goods_num,Create_time,Size_id) values('$store_id','$user_id','$Uid','$Goods_id','$Goods_num',CURRENT_TIMESTAMP,$size_id) ";
                    $r = $db->insert($sql, 'last_insert_id');
                    if ($r) {
                        echo json_encode(array('status' => 1, 'cart_id' => $r));
                    } else {
                        echo json_encode(array('status' => 0, 'err' => '添加失败请重新提交!'));
                    }
                }
            } else {
                echo json_encode(array('status' => 0, 'err' => '库存不足！'));
            }
        }
        exit;
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
            $select = 'c.price';
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
        $end = $paegr * 10;
        $sql = 'select a.id,a.product_title,volume,c.price,c.yprice,c.img,a.s_type,c.id AS sizeid from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = \'' . $store_id . '\' and a.product_class like \'%-' . $id . "-%' and a.status = 0 and a.recycle = 0 order by $select $sort LIMIT $start,$end ";
        $r = $db->select($sql);
        if ($r) {
            $product = [];
            foreach ($r as $k => $v) {
                $imgurl = ServerPath::getimgpath($v->img);/* end 保存*/
                $product[$k] = array('id' => $v->id, 'name' => $v->product_title, 'price' => $v->yprice, 'price_yh' => $v->price, 'imgurl' => $imgurl, 'size' => $v->sizeid, 'volume' => $v->volume, 's_type' => $v->s_type);
            }
            echo json_encode(array('status' => 1, 'pro' => $product));
            exit;
        } else {
            echo json_encode(array('status' => 0, 'err' => '没有了！'));
            exit;
        }
    }

    // 加载更多商品
    public function get_more()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $id = trim($request->getParameter('cid')); //  '分类ID'
        $paegr = trim($request->getParameter('page')); //  '分页显示'

        if (!$paegr) {
            $paegr = 1;
        }
        $start = ($paegr - 1) * 10;
        $end = $paegr * 10;
        $sql = 'select a.id,a.product_title,a.volume,c.price,c.yprice,c.img,c.id AS sizeid from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = \'' . $store_id . '\' and a.product_class like \'%-' . $id . '-%\' and c.num >0 and a.recycle = 0 order by a.sort LIMIT $start,$end';
        $r = $db->select($sql);
        if ($r) {
            $product = [];
            foreach ($r as $k => $v) {
                $imgurl = ServerPath::getimgpath($v->img);/* end 保存*/
                $product[$k] = array('id' => $v->id, 'name' => $v->product_title, 'price' => $v->yprice, 'size' => $v->sizeid, 'price_yh' => $v->price, 'imgurl' => $imgurl, 'volume' => $v->volume);
            }
            echo json_encode(array('status' => 1, 'pro' => $product));
            exit;
        } else {
            echo json_encode(array('status' => 0, 'pro' => ''));
            exit;
        }
    }

    public function freight($freight, $num, $address, $db)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select * from lkt_freight where store_id = '$store_id' and id = '$freight'";
        $r_1 = $db->select($sql);
        if ($r_1) {
            $rule = $r_1[0];
            $yunfei = 0;
            if (empty($address)) {
                return 0;
            } else {
                $sheng = $address['sheng'];
                $sql2 = "select G_CName from admin_cg_group where GroupID = '$sheng'";
                $r_2 = $db->select($sql2);
                if ($r_2) {
                    $city = $r_2[0]->G_CName;
                    $rule_1 = $r_1[0]->freight;
                    $rule_2 = unserialize($rule_1);

                    foreach ($rule_2 as $key => $value) {
                        $citys_str = $value['name'];
                        $citys_array = explode(',', $citys_str);
                        $citys_arrays = [];
                        foreach ($citys_array as $k => $v) {
                            $citys_arrays[$v] = $v;
                        }
                        if (array_key_exists($city, $citys_arrays)) {
                            if ($num > $value['three']) {
                                $yunfei += $value['two'];
                                $yunfei += ($num - $value['three']) * $value['four'];
                            } else {
                                $yunfei += $value['two'];
                            }
                        }
                    }
                    return $yunfei;
                } else {
                    return 0;
                }
            }
        } else {
            return 0;
        }
    }

    // 显示购物车列表
    public function Shopping()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $arr = [];
        $uid = trim($request->getParameter('user_id')); //  微信id
        $sql_c = 'select a.*,m.imgurl,c.price,c.attribute,c.img,c.num as pnum,m.product_title,c.id AS sizeid from lkt_cart AS a LEFT JOIN lkt_product_list AS m  ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c ON a.Size_id = c.id where m.store_id = \'' . $store_id . '\' and c.num >0 and a.Uid = \'' . $uid . '\' and m.recycle = 0 order by a.Create_time desc ';
        $r_c = $db->select($sql_c);
        if($r_c){
            foreach ($r_c as $key => $value) {
                $imgurl = ServerPath::getimgpath($value->imgurl);/* end 保存*/
                if(!empty($value->attribute)){
                    $attribute = unserialize($value->attribute);
                    $size = '';
                    foreach ($attribute as $ka => $va) {
                        $size .= ' ' . $va;
                    }

                    $arr[$key] = array('id' => $value->id, 'uid' => $uid, 'pnum' => $value->pnum, 'sizeid' => $value->sizeid, 'pid' => $value->Goods_id, 'size' => $size, 'price' => $value->price, 'num' => $value->Goods_num, 'pro_name' => $value->product_title, 'imgurl' => $imgurl);
                }
            }
            echo json_encode(array('status' => 1, 'cart' => $arr));
            exit;
        }else{
            echo json_encode(array('status' => 1, 'cart' => $arr));
            exit;
        }
    }

    // 清空购物车
    public function delAll_cart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $user_id = addslashes(trim($request->getParameter('user_id')));
        $sql = 'delete from lkt_cart where store_id = \'' . $store_id . '\' and Uid="' . $user_id . '"';
        $res = $db->delete($sql);
        if ($res) {
            echo json_encode(array('status' => 1, 'succ' => '操作成功!'));
            exit;
        } else {
            echo json_encode(array('status' => 0, 'err' => '操作失败!'));
            exit;
        }
    }


    // 删除购物车指定商品
    public function delcart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $carts = addslashes(trim($request->getParameter('carts')));

        $cartstr = trim($carts, ','); // 移除两侧的逗号
        $cartArr = explode(',', $cartstr); // 字符串打散为数组
        //循环删除指定的购物车商品
        foreach ($cartArr as $key => $value) {
            $sql = 'delete from lkt_cart where store_id = \'' . $store_id . '\' and id="' . $value . '"';
            $res = $db->delete($sql);
        }

        if ($res) {
            echo json_encode(array('status' => 1, 'succ' => '操作成功!'));
            exit;
        } else {
            echo json_encode(array('status' => 0, 'err' => '操作失败!'));
            exit;
        }
    }

    // 移动购物车指定商品去收藏
    public function to_Collection()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        //购物车商品
        $carts = $request->getParameter('carts');
        //用户id
        $userid = addslashes(trim($request->getParameter('user_id')));

        $cartstr = trim($carts, ','); // 移除两侧的逗号
        $cartArr = explode(',', $cartstr); // 字符串打散为数组
        //循环移动并删除指定的购物车商品
        foreach ($cartArr as $key => $value) {
            //查询商品id
            $csql = "select Goods_id from lkt_cart where store_id = '$store_id' and id='$value' ";
            $cres = $db->select($csql);
            $pid = $cres[0]->Goods_id;
            //添加至收藏
            $this->addFavorites($userid, $pid);
            //删除指定购物车id
            $sql = 'delete from lkt_cart where store_id = \'' . $store_id . '\' and id="' . $value . '"';
            $res = $db->delete($sql);
        }

        if ($res) {
            echo json_encode(array('status' => 1, 'succ' => '操作成功!'));
            exit;
        } else {
            echo json_encode(array('status' => 0, 'err' => '操作失败!'));
            exit;
        }
    }

    public function addFavorites($openid, $pid)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r = $db->select($sql);
        $user_id = $r[0]->user_id;
        // 根据用户id,产品id,查询收藏表
        $sql = "select * from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and p_id = '$pid'";
        $r = $db->select($sql);
        if (!$r) {
            // 在收藏表里添加一条数据
            $sql = "insert into lkt_user_collection(store_id,user_id,p_id,add_time) values('$store_id','$user_id','$pid',CURRENT_TIMESTAMP)";
            $r = $db->insert($sql);
        }
    }

    // 用户修改购物车数量操作
    public function up_cart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $cart_id = trim($request->getParameter('cart_id'));
        $num = trim($request->getParameter('num'));
        $user_id = trim($request->getParameter('user_id'));

        $sql_num = "select c.num from lkt_cart as a LEFT JOIN lkt_configure AS c ON a.Size_id = c.id where a.store_id = '$store_id' and a.id = '$cart_id'";
        $r_num = $db->select($sql_num);
        $pnum = $r_num[0]->num;

        if ($pnum > $num) {
            $sql_u = "update lkt_cart set Goods_num = '$num' where store_id = '$store_id' and id = '$cart_id' and Uid = '$user_id'";
            $r_u = $db->update($sql_u);
            if ($r_u) {
                echo json_encode(array('status' => 1, 'succ' => '操作成功!'));
                exit;
            } else {
                echo json_encode(array('status' => 0, 'err' => '操作失败!'));
                exit;
            }
        } else {
            echo json_encode(array('status' => 0, 'err' => '库存不足!'));
            exit;
        }
    }

    // 发送评论数据
    public function comment()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $order_id = trim($request->getParameter('order_id')); // 订单号
        $user_id = trim($request->getParameter('user_id')); // 微信id
        $pid = trim($request->getParameter('pid')); // 商品id
        $attribute_id = trim($request->getParameter('attribute_id')); // 属性id

        $sql_user = 'select user_id from lkt_user where store_id = \''.$store_id.'\' and wx_id=\'' . $user_id . '\'';
        $r_user = $db->select($sql_user);

        if ($r_user) {
            if ($pid && $attribute_id) {
                $sql_o = "select a.p_id as commodityId,m.img,a.size,a.sid from lkt_order_details AS a LEFT JOIN lkt_configure AS m ON a.sid = m.id  where a.store_id = '$store_id' and a.r_sNo = '$order_id' and a.p_id = '$pid' and a.sid = '$attribute_id' and a.r_status = 3 ";
            } else {
                $sql_o = "select a.p_id as commodityId,m.img,a.size,a.sid from lkt_order_details AS a LEFT JOIN lkt_configure AS m ON a.sid = m.id  where a.store_id = '$store_id' and a.r_sNo = '$order_id' and (a.r_status = 3 or a.r_status = 1 or a.r_status = -1)";
            }
            $r_o = $db->select($sql_o);

            if ($r_o) {
                foreach ($r_o as $key => $value) {
                    $arr = (array)$value;
                    $imgurl = $arr['img'];/* end 保存*/
                    $arr['commodityIcon'] = ServerPath::getimgpath($imgurl);
                    $obj = (object)$arr;
                    $res[$key] = $obj;
                }
                echo json_encode(array('status' => 1, 'commentList' => $res));
                exit;
            }
        }
    }

    //添加评论
    public function t_comment()
    {
        $db = DBAction::getInstance();
        $db->begin();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $type = trim($request->getParameter('type'));
        if ($type == 'file') {
            //处理评论图片
            $id = trim($request->getParameter('id'));//评论ID
            // 查询配置表信息
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
            $uploadImg = $r[0]->uploadImg.'image_'.$store_id.'/';
            $upserver = $r[0]->upserver;
            // 图片上传位置
            if ($upserver == '2') {         //阿里云上传
                $this->OSSupload($id);
                return;
            }

            if (empty($uploadImg)) {
                $uploadImg = "./images";
            }

            $imgURL = ($_FILES['imgFile']['tmp_name']);
            $type = str_replace('image/', '.', $_FILES['imgFile']['type']);
            $imgURL_name = time() . mt_rand(1, 1000) . $type;
            move_uploaded_file($imgURL, $uploadImg . $imgURL_name);


            $sql = "insert into lkt_comments_img(comments_url,comments_id,add_time) VALUES ('$imgURL_name','$id',CURRENT_TIMESTAMP)";
            $res = $db->insert($sql);

            //软件类型
            $store_type = $this->getContext()->getStorage()->read('store_type');
            // //用户id
            $store_id = $this->getContext()->getStorage()->read('store_id');

            $store_id = $store_id != null ? $store_id : 1;
            $store_type = $store_type != null ? $store_type : 'app';
            $fsql = " INSERT INTO `lkt_files_record` ( `store_id`, `store_type`, `group`, `upload_mode`, `image_name`) VALUES ('$store_id', '$store_type', '1', '1', '$imgURL_name') ";
            $db->insert($fsql);

            if ($res) {
                $db->commit();
                echo json_encode(array('status' => 1, 'err' => '修改成功', 'sql' => $sql));
                exit;
            } else {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '修改失败'));
                exit;
            }
        } else {
            //接收评论JSON数据
            $json = json_decode(file_get_contents('php://input'));
            $comments = $json->comments;
            $r_d = 0;
            $oid = '';

            // 查询配置表信息
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
            $uploadImg = $r[0]->uploadImg;
            // 图片上传位置
            if (empty($uploadImg)) {
                $uploadImg = "../LKT/images";
            }
            //敏感词表
            require('badword.src.php');

            foreach ($comments as $key => $value) {
                $oid = $value->orderId; // 订单号
                $uid = $value->userid; // 微信id
                $pid = $value->commodityId; // 商品id
                $images = $value->images; // 商品id
                $size = $value->size; // 属性名称
                $attribute_id = $value->attribute_id; // 属性id
                $content = $value->content; // 评论内容
                $badword1 = array_combine($badword, array_fill(0, count($badword), '*'));
                $time = date('Y-m-d H:i:s');
                $content = preg_replace("/\s(?=\s)/", "\\1", $this->strtr_array($content, $badword1));

                //特殊字符处理
                $content = htmlentities($content);

                $CommentType = $value->score; // 评论类型

                $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$uid'";
                $r_name = $db->select($sql);
                $user_id = $r_name[0]->user_id;

                $arr = array();
                if ($content != '' || count($images) != 0) {
                    $sql_c = "select oid from lkt_comments where store_id = '$store_id' and oid = '$oid' and pid = '$pid' and attribute_id = '$attribute_id' ";
                    $r_c = $db->select($sql_c);
                    if (empty($r_c['0'])) {
                        $sql_d = 'insert into lkt_comments(store_id,oid,uid,pid,attribute_id,size,content,CommentType,add_time) VALUES ' . "('$store_id','$oid','$user_id','$pid','$attribute_id','$size','$content','$CommentType',CURRENT_TIMESTAMP)";
                        $lcid = $db->insert($sql_d, 'last_insert_id');
                        $cid[$value->pingid] = $lcid;
                        if ($lcid > 0) {
                            $sql02 = "update lkt_order set status = 5,arrive_time = '$time' where store_id = '$store_id' and sNo = '$oid'";
                            $r_2 = $db->update($sql02);

                            $sql_d = "update lkt_order_details set r_status = 5 where store_id = '$store_id' and r_sNo = '$oid' and sid = '$attribute_id'";
                            $r_d = $db->update($sql_d);

                        } else {
                            echo json_encode(array('status' => 0, 'err' => '修改失败'));
                            exit;
                        }
                    } else {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '亲!评论过了1'));
                        exit;
                    }
                } else {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '修改失败'));
                    exit;
                }

            }

            $db->commit();
            echo json_encode(array('status' => 1, 'succ' => '评论成功!', 'arrid' => $cid));
            exit;
        }
    }

    public function OSSupload($id)
    {
        $db = DBAction::getInstance();
        $db->begin();
        //软件类型
        $store_type = $this->getContext()->getStorage()->read('store_type');
        // //用户id
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $store_id = $store_id != null ? $store_id : 1;
        $store_type = $store_type != null ? $store_type : 'app';
        $dir = $store_id . '/' . $store_type . '/';

        require_once(MO_LIB_DIR . '/aliyun-oss-php-sdk-2.3.0/samples/Object.php');
        $ossClient = Common::getOssClient();


        if (!empty($_FILES)) {
            $name = '';
            foreach ($_FILES as $key => $value) {
                $name = $key;
            }
            $error = $_FILES[$name]['error'];
            switch ($_FILES[$name]['error']) {
                case 0:
                    $msg = '';
                    break;
                case 1:
                    $msg = '超出了php.ini中文件大小';
                    break;
                case 2:
                    $msg = '超出了MAX_FILE_SIZE的文件大小';
                    break;
                case 3:
                    $msg = '文件被部分上传';
                    break;
                case 4:
                    $msg = '没有文件上传';
                    break;
                case 5:
                    $msg = '文件大小为0';
                    break;
                default:
                    $msg = '上传失败';
                    break;
            }

            $imgURL = $_FILES[$name]['tmp_name'];

            $type = str_replace('image/', '.', $_FILES[$name]['type']);
            $imgURL_name = time() . mt_rand(1, 1000) . $type;
            $path = $dir . $imgURL_name;

            $sql = "insert into lkt_comments_img(comments_url,comments_id,add_time) VALUES ('$imgURL_name','$id',CURRENT_TIMESTAMP)";
            $res = $db->insert($sql);
            $fsql = " INSERT INTO `lkt_files_record` ( `store_id`, `store_type`, `group`, `upload_mode`, `image_name`) VALUES ('$store_id', '$store_type', '1', '2', '$imgURL_name') ";
            $db->insert($fsql);

            try {
                $ossClient->uploadFile(Common::bucket, $path, $imgURL);
            } catch (OssException $e) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '修改失败'));
                exit;
            }
            $db->commit();
            echo json_encode(array('status' => 1, 'err' => '修改成功', 'sql' => $sql));
            return;

        }
    }

    //替换
    function strtr_array($str, $replace_arr)
    {
        $maxlen = 0;
        $minlen = 1024 * 128;
        if (empty($replace_arr)) return $str;
        foreach ($replace_arr as $k => $v) {
            $len = strlen($k);
            if ($len < 1) continue;
            if ($len > $maxlen) $maxlen = $len;
            if ($len < $minlen) $minlen = $len;
        }
        $len = strlen($str);
        $pos = 0;
        $result = '';
        while ($pos < $len) {
            if ($pos + $maxlen > $len) $maxlen = $len - $pos;
            $found = false;
            $key = '';
            for ($i = 0; $i < $maxlen; ++$i) $key .= $str[$i + $pos];
            for ($i = $maxlen; $i >= $minlen; --$i) {
                $key1 = substr($key, 0, $i);
                if (isset($replace_arr[$key1])) {
                    $result .= $replace_arr[$key1];
                    $pos += $i;
                    $found = true;
                    break;
                }
            }
            if (!$found) $result .= $str[$pos++];
        }
        return $result;
    }

    //显示新产品
    public function new_product()
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

        $sql = "select a.id,a.product_title,a.imgurl,a.volume,min(c.price) as price,c.yprice,c.img,a.s_type,c.id AS sizeid from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.s_type like '%$id%' and a.status = 0 and a.recycle = 0 and a.num >0 group by c.pid order by $select $sort LIMIT $start,$end ";
        $r = $db->select($sql);
        if ($r) {
            $product = [];
            $subarr = $this -> getsubactive($store_id);     //查询当前是否有满减活动
            foreach ($r as $k => $v) {
                $imgurl = ServerPath::getimgpath($v->imgurl);/* end 保存*/
                $pid = $v->id;
                $sql_ttt = "select price,yprice from lkt_configure where pid ='$pid' order by price asc ";
                $r_ttt = $db->select($sql_ttt);
                $price = $r_ttt[0]->yprice;
                $price_yh = $r_ttt[0]->price;
                if(!empty($subarr) && in_array($v->id,$subarr)){       //判断是否是满减产品
                    $issub = true;
                }else{
                    $issub = false;
                }
                $product[$k] = array('id' => $v->id, 'name' => $v->product_title, 'price' => $price, 'price_yh' => $price_yh, 'imgurl' => $imgurl, 'volume' => $v->volume, 's_type' => $v->s_type, 'issub' => $issub);
            }
            echo json_encode(array('status' => 1, 'pro' => $product));
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