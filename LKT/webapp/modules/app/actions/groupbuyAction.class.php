<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 * @author 周文
 * @date 2018年12月10日
 * @version 2.0
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/Plugin_order.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class groupbuyAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //接受参数
        $store_id = addslashes(trim($request->getParameter('store_id')));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = addslashes(trim($request->getParameter('access_id')));
        $m = addslashes(trim($request->getParameter('m')));
        $m = $m ? $m : 'getDefaultView';

        if (!empty($access_id)) { // 存在
            $getPayload_test = Tools::verifyToken($db, $store_id, $store_type, $access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if ($getPayload_test == false && $m != 'cangroup' && $m != 'grouphome' && $m != 'getgoodsdetail') { // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }

        //查用户基本信息
        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $res = $db->select($sql);
        if ($res) {
            $user_id = $res[0]->user_id;
            $this->login = true;

        } else {
            $user_id = '';
            $arr = array('grouphome', 'getgoodsdetail', 'cangroup');
            if (!in_array($m, $arr)) {
                echo json_encode(array('code' => 0, 'msg' => '参数缺少1！', 'status' => 1));
                exit;
            } else {
                $this->login = false;
            }
        }

        //增加该类中的公共属性，调用到各方法
        $this->db = $db;
        $this->request = $request;
        $this->store_id = $store_id;
        $this->user_id = $user_id;
        $this->access_id = $access_id;

        $this->$m();
        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    /**
     * 拼团首页列表数据
     */
    public function grouphome()
    {
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;

        $paegr = trim($request->getParameter('page')); //  '页面'
        $navType = trim($request->getParameter('navType')); //  '类型'

        if (!$paegr) {
            $paegr = 1;
        }
        $start = ($paegr - 1) * 10;
        $end = $paegr * 10;

        $gsta = "";

        //查询拼团活动

        if ($navType == 1) {
            //查询已经结束和进行中的活动
            $gsta .= " and p.g_status!=1 ";
        } else {
            //不查询结束、进行中 未编辑的复制活动
            $gsta .= " and p.g_status=1 and starttime !='0000-00-00 00:00:00' and endtime !='0000-00-00 00:00:00'";
        }
        $sql = "select p.id,min(p.attr_id) as attr_id,p.product_id,p.group_level,g_status,p.group_data,s.sum,c.img as image,c.price as market_price,p.group_title as pro_name,l.product_title as pro_name1 ,l.imgurl as imageurl ,p.activity_no
                from lkt_group_product as p 
                left join (
                select sum(o.num) as sum,d.p_id 
                from lkt_order as o 
                left join lkt_order_details as d on o.sNo=d.r_sNo 
                where o.store_id = '$store_id' and o.status>0 and o.status != 6 and o.otype='pt' 
                group by d.p_id
                ) as s on p.product_id=s.p_id 
                left join lkt_configure as c on p.attr_id=c.id 
                left join lkt_product_list as l on p.product_id=l.id 
                where p.store_id = '$store_id' and p.is_show=1 $gsta and l.status=2 and p.is_delete = 0
                group by p.activity_no 
                order by p.id asc limit $start,$end";
        $res = $db->select($sql);
        //判断是否又拼团商品
        if (!empty($res)) {
            //如果有
            foreach ($res as $k => $v) {
                //查询活动库存
                $sel_num_sql = "select c.num from ( select min(id) as id,attr_id,product_id from lkt_group_product where store_id = '$store_id' and product_id=" . $v->product_id . ") as m left join lkt_configure as c on m.attr_id=c.id";
                $num_res = $db->select($sel_num_sql);
                $res[$k]->num = $num_res[0]->num;

                //查询活动时间
                $product_data = unserialize($v->group_data);
                $g_status = $v->g_status;
                $end_time = strtotime($product_data->endtime);
                $start_time = strtotime($product_data->starttime);
                //判断活动是否结束，是否有库存
                $res[$k]->g_status = $g_status;
                if (time() < $start_time) {
                    //活动未开启
                    $res[$k]->product_status = 4;
                } else if (time() > $end_time || $g_status == 3) {
                    //活动结束

                    $res[$k]->product_status = 3;
                } else if ($v->num == 0) {
                    //没有库存
                    $res[$k]->product_status = 2;
                } else {
                    //正常下单
                    $res[$k]->product_status = 1;
                }

                $res[$k]->imgurl = ServerPath::getimgpath($v->imageurl);
                if ($v->sum === null) $res[$k]->sum = 0;
                $level = unserialize($v->group_level);
                list($first_key, $first) = (reset($level) ? each($level) : each($level));    //取第一层级的参数
                $zekou = explode('~', $first)[1];    //获取折扣
                //查询属性里最低的金额
                $sel_min_price = "SELECT * FROM lkt_configure where pid = $v->product_id order by price";
                $min_price_res = $db->select($sel_min_price);
                if (!empty($min_price_res)) {
                    $v->market_price = $min_price_res[0]->price;
                }
                $kaiprice = floatval($v->market_price) * intval($zekou) / 100;
                $v->kaiprice = sprintf("%.2f", $kaiprice);
                $v->groupnum = $first_key;

                $group_data = unserialize($v->group_data);

                //设置时间 初始值
                $stime = strtotime($group_data->starttime);
                $v->leftTime = $stime > time() ? ($stime - time()) : 0;
                $v->hour = '00';
                $v->mniuate = '00';
                $v->second = '00';

                //查询活动商品属性数据
                $sel_attr_sql = "select c.price
                from lkt_configure as c 
                left join lkt_product_list as p on c.pid=p.id 
                where c.pid=$v->product_id";
                $min_price = '';
                $sel_attr_Res = $db->select($sel_attr_sql);
                foreach ($sel_attr_Res as $k => $v3) {
                    if ($min_price == '') {
                        $min_price = $v3->price;
                    } else if ($min_price > $v3->price) {
                        $min_price = $v3->price;
                    }
                }

                //查询最低价格的和 拼团人数
                $min_bili = 100;
                $min_man = 999999;
                foreach ($level as $k => $v__) {
                    $bili = explode('~', $v__);
                    if ($min_bili > $bili[0]) {
                        $min_bili = $bili[0];
                        $min_man = $k;
                    }
                }

                $min_price = floatval($min_price) * intval($min_bili) / 100;
                $v->min_price = sprintf("%.2f", $min_price);

                $v->min_man = $min_man;
            }

            $sort = array(
                'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                'field' => 'product_status',       //排序字段
            );
            $arrSort = array();
            foreach ($res AS $uniqid => $row) {
                foreach ($row AS $key => $value) {
                    $arrSort[$key][$uniqid] = $value;
                }
            }
            if ($sort['direction']) {
                array_multisort($arrSort[$sort['field']], constant($sort['direction']), $res);
            }

            echo json_encode(array('code' => 1, 'list' => $res));
            exit;
        } else {
            //没有拼团商品
            echo json_encode(array('code' => 0, 'list' => $res));
            exit;
        }
    }

    /**
     * 获取商品详情数据
     */
    public function getgoodsdetail()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));
        $gid = addslashes(trim($request->getParameter('pro_id')));
        $access_id = addslashes(trim($request->getParameter('access_id')));
        $store_type = trim($request->getParameter('store_type'));
        $activity_no = trim($request->getParameter('activity_no'));
        $lktlog = new LaiKeLogUtils("app/group.log");

        $user_id = $this->user_id;
        $islogin = false;
        if (!empty($access_id)) { // 存在
            $getPayload_test = Tools::verifyToken($db, $store_id, $store_type, $access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            $sel_user_sql = "select * from lkt_user where store_id = $store_id and access_id = '$access_id'";
            $user_res = $db->select($sel_user_sql);
            if (count($user_res) >= 1) {
                $islogin = true;
            }
        }
        //查询商品
        $guigesql = "select m.*,c.num,c.img as image,c.price as market_price from (
        select attr_id,g.product_id,g.group_level,g.group_data,g.g_status,l.product_title as pro_name,l.content,l.status ,l.imgurl,g.activity_no
        from lkt_group_product as g
        left join lkt_product_list as l on g.product_id=l.id where g.store_id = '$store_id' and g.product_id=$gid and g.is_delete = 0 and g.activity_no = $activity_no
        group by g.activity_no 
       
        ) as m
            left join lkt_configure as c on m.attr_id=c.id  LIMIT 0 , 1
";
//        order by case
//                                          when g.g_status='2' then 1
//                                          when g.g_status='1' then 2
//                                          when g.g_status='3' then 3
//                                      end
//        echo $guigesql;exit;
        $guigeres = $db->select($guigesql);
        $new_content = Tools::getContent($db, $guigeres[0]->content);
        $guigeres[0]->content = $new_content;
        $sel_freightSql = "SELECT f.name ,f.freight ,p.mch_id
                           FROM lkt_product_list as p
                           LEFT JOIN lkt_freight as f on p.freight = f.id
                           WHERE p.id = $gid";
        $freightRes = $db->select($sel_freightSql);

        $freightArr = unserialize($freightRes[0]->freight);
        $p_id = $guigeres[0]->product_id;
        //查询属性里最低的金额
        $sel_min_price = "SELECT * FROM lkt_configure where pid = $p_id order by price";
        $min_price_res = $db->select($sel_min_price);
        if (!empty($min_price_res)) {
            $guigeres[0]->market_price = $min_price_res[0]->price;
        }

        $shop_list = array();
        $mch_id = $freightRes[0]->mch_id;

        //如果有店铺id
        if ($mch_id != 0) {
            $sql0 = "select id,name,logo from lkt_mch where store_id = '$store_id' and id = '$mch_id'";
            $r0 = $db->select($sql0);
            if ($r0) {
                $shop_id = $r0[0]->id;
                $shop_list['shop_id'] = $r0[0]->id;
                $shop_list['shop_name'] = $r0[0]->name;
                $shop_list['shop_logo'] = ServerPath::getimgpath($r0[0]->logo);
                $sql1 = "select id,product_class from lkt_product_list where store_id = '$store_id' and mch_id = '$shop_id' and mch_status = 2 and status = 2 and recycle = 0 and active = 1 order by add_date desc ";
                $r1 = $db->select($sql1);
                $shop_list['quantity_on_sale'] = count($r1);

                $quantity_sold = 0;
                $sql3 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid ";
                $r3 = $db->select($sql3);
                if ($r3) {
                    foreach ($r3 as $k => $v) {
                        $quantity_sold += $v->volume;  // 已售数量
                    }
                }
                $shop_list['quantity_sold'] = $quantity_sold;

                $sql0_0 = "select id from lkt_user_collection where store_id = '$store_id' and mch_id = '$shop_id'";
                $r0_0 = $db->select($sql0_0);
                $shop_list['collection_num'] = count($r0_0);
            }
            $sql = "insert into lkt_mch_browse(store_id,token,mch_id,user_id,event,add_time) values ('$store_id','$access_id','$mch_id','$user_id','访问了店铺',CURRENT_TIMESTAMP)";
            $ist_res = $db->insert($sql);
            if($ist_res < 1){
                $lktlog->customerLog(__METHOD__.":".__LINE__."添加店铺访问记录失败！sql:".$sql);
            }
        }

        list($guigeres) = $guigeres;

        $level = unserialize($guigeres->group_level);
        list($first_key, $first) = (reset($level) ? each($level) : each($level));    //取第一层级的参数
        $zekou = explode('~', $first)[1];    //获取折扣
        $kaiprice = floatval($guigeres->market_price) * intval($zekou) / 100;
        $guigeres->kaiprice = sprintf("%.2f", $kaiprice);
        $guigeres->groupnum = $first_key;
        $guigeres->freight = $freightArr[0]['two'];
        $guigeres->freight_name = $freightRes[0]->name;

        $buysql = "select count(*) as sum 
                   from lkt_order_details as d 
                   left join lkt_order as o on d.r_sNo=o.sNo 
                   where d.p_id=$gid and o.otype='pt' and d.r_status!=0 and d.r_status!=6 and d.store_id='$store_id'";
        $buysum = $db->select($buysql);

        $guigeres->buysum = $buysum[0]->sum;
        $content = $guigeres->content;
        $contres = unserialize($guigeres->group_data);

        //查询拼团配置
        $sel_group_cfg = "select * from lkt_group_config where store_id = $store_id";
        $group_cfg = $db->select($sel_group_cfg);

        $open_discount = $group_cfg[0]->open_discount;
        //判断是否开启团长优惠
        if ($open_discount == '0') {
            //如果没有开启团长优惠
            $level_ = array();
            foreach ($level as $k => $v) {
                $v_arr = explode('~', $v);
                $level_[$k] = $v_arr[0] . '~' . $v_arr[0];
            }
            $level = $level_;
        }

        $group_level = $level;
        $guigeres->group_level = $group_level;
        $guigeres->rule = $group_cfg[0]->rule;
        $imgsql = 'select product_url from lkt_product_img where product_id=' . $gid;
        $imgres = $db->select($imgsql);
        $imgarr = array();
        //如果有其他图片
        if (!empty($imgres)) {
            $guigeres->image = ServerPath::getimgpath($guigeres->imgurl);
            $imgarr[0] = $guigeres->image;

            foreach ($imgres as $k => $v) {
                $imgarr[$k + 1] = ServerPath::getimgpath($v->product_url);
            }
            $guigeres->images = $imgarr;
        } else {
            $guigeres->image = ServerPath::getimgpath($guigeres->image);
            $imgarr[0] = $guigeres->image;
            $guigeres->images = $imgarr;
        }

        $sql_size = "select g.attr_id,g.product_id,g.group_level,g.is_show,p.attribute,p.num,p.price,p.yprice,p.img,p.id,p.unit 
        from lkt_group_product as g 
        left join lkt_configure as p on g.attr_id=p.id 
        where g.store_id = '$store_id' and g.product_id = '$gid' and g.is_delete = 0 and g.activity_no = $activity_no
        order by price";
        $r_size = $db->select($sql_size);

        $isshow = (int)$r_size[0]->is_show;

        $array_price = array();
        $array_yprice = array();
        $skuBeanList = array();
        $attrList = array();
        if ($r_size) {
            $attrList = array();
            foreach ($r_size as $key => $value) {
                $array_price[$key] = $value->price;
                $array_yprice[$key] = $value->yprice;
                $attribute = unserialize($value->attribute);
                $attnum = 0;
                $arrayName = array();
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
                $attributes = array();
                $name = '';
                foreach ($attribute as $k => $v) {
                    $attributes[] = array('attributeId' => md5($k), 'attributeValId' => md5($v));
                    $name .= $v;
                }

                $cimgurl = ServerPath::getimgpath($value->img);
                $unit = $value->unit;

                $skuBeanList[$key] = array('name' => $name, 'imgurl' => $cimgurl, 'cid' => $value->id, 'price' => $value->price, 'count' => $value->num, 'unit' => $unit, 'attributes' => $attributes);

                for ($i = 0; $i < count($attrList); $i++) {
                    $attr = $attrList[$i]['attr'];
                    $all = $attrList[$i]['all'];
                    $ok = 0;
                    foreach ($attribute as $k => $v) {
                        if ($attrList[$i]['attrName'] == $k) {

                            if ($key == 0 && $skuBeanList[$key]['count'] > 0 && $ok == 0) {
                                $enable = true;
                                $select = true;
                                $ok = 1;
                            } else {
                                $enable = false;
                                $select = false;
                            }

                            $attr_array = array('attributeId' => md5($k), 'id' => md5($v), 'attributeValue' => $v, 'enable' => $enable, 'select' => $select, 'count' => $skuBeanList[$key]['count'], 'price' => $skuBeanList[$key]['price']);

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

        //查询此商品评价记录
        $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.size,a.anonymous,m.user_name,m.headimgurl,c.attribute ,a.uid
                from lkt_comments AS a 
                LEFT JOIN lkt_user AS m ON a.uid = m.user_id 
                left join lkt_configure as c on a.attribute_id=c.id where  a.pid = '$gid'";
        $r_c = $db->select($sql_c);
        $arr = array();
        if (!empty($r_c)) {
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
                    $array_c = array();
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
                $sel_user_in_sql = "select * from lkt_user where user_id = '$value->uid' and store_id = $store_id";
                $user_in_res = $db->select($sel_user_in_sql);
                if (empty($user_in_res)) {
                    $va['anonymous'] = '1';
                }

                $attribute = unserialize($va['attribute']);
                $attribute = array_values($attribute);
                $attribute = implode(' ', $attribute);
                $va['attribute'] = $attribute;
                $va['reply'] = $reply_admin;
                $obj = (object)$va;

                $arr[$key] = $obj;

            }

        }

        //查询开团数据
        $sql_kt = "select g.ptcode,g.ptnumber,g.groupman,g.endtime,u.user_name,u.headimgurl,o.sNo 
        from lkt_group_open as g 
        left join lkt_user as u on g.uid=u.user_id 
        left join lkt_order as o on g.ptcode=o.ptcode 
        where g.store_id = '$store_id' and g.ptgoods_id=$gid and g.ptstatus=1 and u.store_id = '$store_id' and 
        EXISTS(select * from lkt_order as o where o.ptcode=g.ptcode and o.status!=6) and o.pid='kaituan'";
        $res_kt = $db->select($sql_kt);

        // 根据用户id、产品id,获取收藏表信息
        $sql = "select * from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and p_id = '$gid'";
        $rr = $db->select($sql);
        if ($rr) {
            $collection_id = $rr['0']->id; // 收藏id
        } else {
            $collection_id = '';
        }

        $groupList = array();
        if (!empty($res_kt)) {
            foreach ($res_kt as $key => $value) {
                $value->leftTime = strtotime($value->endtime) - time();
                if (strtotime($value->endtime) - time() > 0) {
                    array_push($groupList, $res_kt[$key]);
                }
            }
        }

        $plugsql = "select status from lkt_plug_ins where store_id = '$store_id' and type = 0 and software_id = 3 and name like '%拼团%'";
        $plugopen = $db->select($plugsql);
        $plugopen = !empty($plugopen) ? $plugopen[0]->status : 0;

        //查询活动库存
        $sel_num_sql = "select c.num from ( select min(id) as id,attr_id,product_id from lkt_group_product where store_id = '$store_id' and product_id='$gid') as m left join lkt_configure as c on m.attr_id=c.id";
        $num_res = $db->select($sel_num_sql);
        $product_num = $num_res[0]->num;

//        查询活动时间
        $end_time = strtotime($contres->endtime);
        $start_time = strtotime($contres->starttime);
        $contres->lefttime = $end_time - time();
        $contres->righttime = $start_time - time();

        //判断活动是否结束，是否有库存
        if (time() < $start_time) {
            //活动未开启
            $product_status = 4;
        } else if (time() > $end_time || $guigeres->g_status == 3) {
            //活动结束
            $product_status = 3;
        } else if ($product_num == 0) {
            //没有库存
            $product_status = 2;
        } else {
            //正常下单
            $product_status = 1;
        }
//        $product_status = $guigeres->g_status;

        //计算拼团的最低价 和 对应的参团人数hg
        $sel_attr_sql = "select c.price
                from lkt_configure as c 
                left join lkt_product_list as p on c.pid=p.id 
                where c.pid=$gid";
        $min_price = '';
        $sel_attr_Res = $db->select($sel_attr_sql);
        foreach ($sel_attr_Res as $k => $v3) {
            if ($min_price == '') {
                $min_price = $v3->price;
            } else if ($min_price > $v3->price) {
                $min_price = $v3->price;
            }
        }

        //查询最低价格的和 拼团人数
        $kai_min_bili = $min_bili = 100;
        $kai_min_man = $min_man = 100;
        foreach ($level as $k => $v___) {
            $bili = explode('~', $v___);
            if ($bili[0] > $bili[1]) {
                $_min_bili = $bili[1];
            } else {
                $_min_bili = $bili[0];
            }
            if ($kai_min_bili > $_min_bili) {
                $kai_min_bili = $_min_bili;
                $kai_min_man = $k;
            }
        }
        $kai_min_price = floatval($min_price) * intval($kai_min_bili) / 100;
        $kai_min_price = sprintf("%.2f", $kai_min_price);
        foreach ($level as $k => $v__) {
            $bili = explode('~', $v__);
            if ($min_bili > $bili[0]) {
                $min_bili = $bili[0];
                $min_man = $k;
            }
        }
        $min_price = floatval($min_price) * intval($min_bili) / 100;
        $min_price = sprintf("%.2f", $min_price);


        $loseEfficacyImg = "http://xiaochengxu.laiketui.com/V2.7/images/loseEfficacy2x.png";
        $share = array('friends' => true, 'friend' => false);

        $ls_price = '';//零售价
        $min_index = '';
        foreach ($attrList[0]['attr'] as $k_ => $v_) {
            if ($v_['count'] > 0 && $ls_price == '') {
                $ls_price = $v_['price'];
                $min_index = $k_;
            } else if ($v_['count'] > 0 && $ls_price != '') {
                if ($ls_price > $v_['price']) {
                    $ls_price = $v_['price'];
                    $min_index = $k_;
                }
            }
        }

        $can_num = $group_cfg[0]->can_num; //最多参团数量
        $open_num = $group_cfg[0]->open_num; //最多开团数量
        //首页数据
        $config_again_buy = $group_cfg[0]->can_again; //查询是否开启重复参团设置（1是，0否）

        $user_can_open = true;
        $user_can_can = true;
        //查询当前用户开团数量
        $sel_open_num = "SELECT * FROM lkt_group_open WHERE uid = '$user_id' and ptstatus = 1 and store_id = 1";
        $already_open_num = $db->select($sel_open_num);
        $already_open_num = count($already_open_num);
        if ((int)$already_open_num >= (int)$open_num) {
            $user_can_open = false;
        }
        //查询用户当前参团数量
        $sel_can_num = "SELECT * from lkt_order where otype = 'pt' and store_id = 1 and user_id = '$user_id' and ptstatus = 1 and pid = 'cantuan' and add_time > '2019-07-15 00:00:00'";
        $already_can_num = $db->select($sel_can_num);
        $already_can_num = count($already_can_num);
        if ((int)$already_can_num >= (int)$can_num) {
            $user_can_can = false;
        }

        $again_can = true;
        $again_open = true;
        if ($config_again_buy == 0) {
            $sel_is_buy_pt_pro_sql = "SELECT d.* 
            from lkt_order as o
            LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
            where o.otype = 'pt' and o.user_id = '$user_id' and o.pid = 'cantuan' and o.ptstatus = 1 and o.store_id = $store_id  and d.p_id = $gid and o.pay_time > '$contres->starttime'  and o.pay_time < '$contres->endtime'";
            $sel_is_buy_pt_pro_res = $db->select($sel_is_buy_pt_pro_sql);
            if ($sel_is_buy_pt_pro_res) {
                $again_can = false;
            }
            $sel_is_buy_pt_pro_sql = "SELECT d.* 
            from lkt_order as o
            LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
            where o.otype = 'pt' and o.user_id = '$user_id' and o.pid = 'kaituan' and o.ptstatus = 1 and o.store_id = $store_id  and d.p_id = $gid and o.pay_time > '$contres->starttime'  and o.pay_time < '$contres->endtime'";
            $sel_is_buy_pt_pro_res = $db->select($sel_is_buy_pt_pro_sql);
            if ($sel_is_buy_pt_pro_res) {
                $again_open = false;
            }
        }

        $attrList[0]['attr'][$min_index]['enable'] = $attrList[0]['attr'][$min_index]['select'] = true;
        $dataarr = array('control' => $contres, 'again_can' => $again_can, 'again_open' => $again_open, 'user_can_open' => $user_can_open, 'user_can_open_num' => $open_num, 'user_can_can' => $user_can_can, 'user_can_can_num' => $can_num, 'islogin' => $islogin, 'min_price' => $min_price, 'min_man' => $min_man, 'kai_min_price' => $kai_min_price, 'kai_min_man' => $kai_min_man, 'shop_list' => $shop_list, 'collection_id' => $collection_id, 'detail' => $guigeres, 'attrList' => $attrList, 'skuBeanList' => $skuBeanList, 'comments' => $arr, 'groupList' => $groupList, 'isplug' => $plugopen, 'product_status' => $product_status, 'isshow' => $isshow, 'loseEfficacyImg' => $loseEfficacyImg);


        echo json_encode($dataarr);
        exit;
    }

    /**
     * 获取评论数据
     */
    public function getcomment()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $pid = intval($request->getParameter('pid'));
        $page = intval($request->getParameter('page'));
        $checked = intval($request->getParameter('checked'));

        $page = $page * 8;

        $condition = '';
        //添加查询条件
        switch ($checked) {
            case 1:
                $condition .= " and a.CommentType='GOOD'";
                break;
            case 2:
                $condition .= " and a.CommentType='NOTBAD'";
                break;
            case 3:
                $condition .= " and a.CommentType='BAD'";
                break;
            default:
                $condition = '';
                break;
        }


        //查询此商品评价记录
        $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.size,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id where a.store_id = '$store_id' and a.pid = '$pid'" . $condition . " limit $page,8";

        $r_c = $db->select($sql_c);
        $arr = array();
        if (!empty($r_c)) {
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
                    $array_c = array();
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

            echo json_encode(array('comment' => $arr));
            exit;
        } else {
            echo json_encode(array('comment' => false));
            exit;
        }
    }

    /**
     *
     * @return bool
     */
    public function getFormid()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $uid = addslashes(trim($request->getParameter('userid')));
        $formid = addslashes(trim($request->getParameter('from_id')));
        $lktlog = new LaiKeLogUtils("app/group.log");

        $fromidsql = "select count(*) as have from lkt_user_fromid where store_id = '$store_id' and open_id='$uid'";
        $fromres = $db->select($fromidsql);
        $fromres = intval($fromres[0]->have);
        $lifetime = date('Y-m-d H:i:s', time() + 7 * 24 * 3600);
        if ($formid != 'the formId is a mock one') {
            if ($fromres < 12) {
                $addsql = "insert into lkt_user_fromid(store_id,open_id,fromid,lifetime) values('$store_id','$uid','$formid','$lifetime')";
                $addres = $db->insert($addsql);
                if($addres < 1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."添加用户地址失败！sql:".$addsql);
                }
            } else {
                return false;
            }
        }

    }

    /**
     * 支付
     */
    public function payfor()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $uid = $this->user_id;
        $sizeid = addslashes(trim($request->getParameter('cid')));
        $pid = addslashes(trim($request->getParameter('pid')));
        $address_id = $request->getParameter('address_id'); //  地址id
        $ptcode = $request->getParameter('ptcode'); //  ptcode
        $pronum = intval(trim($request->getParameter('num')));
        $price = intval(trim($request->getParameter('price')));
        $access_id = trim($request->getParameter('access_id'));
        $user_id = '';
        if ($access_id != '') {
            $sql = "select * from lkt_user where store_id = $store_id and access_id = '$access_id'";
            $user_res = $db->select($sql);
            $user_id = $user_res[0]->user_id;
        }

        $mch_data = array();

        //根据商品查询商品店铺信息
        $sel_mch_sql = "SELECT m.id,m.store_id,m.name,m.logo FROM `lkt_product_list` as l 
                        LEFT JOIN lkt_mch as m on l.mch_id = m.id
                        WHERE l.id = $pid and l.store_id = $store_id ";
        $mch_res = $db->select($sel_mch_sql);
        if (!empty($mch_res)) {
            $mch_data = $mch_res[0];
        }

        // 根据地址id,查询收货地址
        $arr = array();
        $address = Tools::find_address($db, $store_id, $uid, $address_id);
        $arr['addemt'] = $address ? 1 : 0; // 收货地址状态
        $arr['adds'] = $address;

        // 查询属性
        $attrsql = "select m.*,l.product_title as pro_name,l.freight 
        from (select c.attribute,c.img as image,g.product_id,g.group_data,c.num from lkt_group_product as g left join lkt_configure as c on g.attr_id=c.id where g.store_id = '$store_id' and g.attr_id=$sizeid) as m left join lkt_product_list as l on m.product_id=l.id";
        $attrres = $db->select($attrsql);

        list($attrres) = $attrres;

        $attribute = unserialize($attrres->attribute);
        $groupres = unserialize($attrres->group_data);
        $size = '';
        foreach ($attribute as $ka => $va) {
            $size .= ' ' . $va;
        }
        $attrres->size = $size;
        $attrres->image = ServerPath::getimgpath($attrres->image);

        $moneysql = 'select user_id,user_name,money,password from lkt_user where store_id = \'' . $store_id . '\' and user_id="' . $uid . '"';
        $moneyres = $db->select($moneysql);

        if (!empty($moneyres)) {
            list($moneyres) = $moneyres;
            $money = $moneyres->money;
            $user_name = $moneyres->user_name;
            $user_password = $moneyres->password;
            if ($user_password != '') {
                $password_status = 1;
            } else {
                $password_status = 0;
            }
        } else {
            $money = 0;
            $user_name = '';
            $password_status = 0;
        }

        //查询拼团订单数量
        $havesql = "select count(*) as have 
                    from lkt_order as o 
                    left join lkt_order_details as d on o.sNo=d.r_sNo 
                    where o.store_id = '$store_id' and o.user_id='$uid' and o.otype='pt' and (o.status=9 ) and d.p_id=$attrres->product_id";
        $haveres = $db->select($havesql);

        if (!empty($haveres)) {
            $have = $haveres[0]->have;
        }
        $attrres->have = $have;

        //查询拼团设置
        $sel_group_cfg = "select * from lkt_group_config where store_id = $store_id";
        $group_cfg = $db->select($sel_group_cfg);
        $can_again = $group_cfg[0]->can_again;

        //未开启重复购买
        $sql = "select count(id) as count from lkt_order where ptcode = '$ptcode' and user_id = '$uid' and status NOT IN (0,6,7,8) and ptcode != '' and store_id = $store_id";
        $isadd_Res = $db->select($sql);
        if ($isadd_Res) {
            if ($isadd_Res[0]->count > 0) {
                $can_pay = false;
            } else {
                $can_pay = true;
            }
        } else {
            $can_pay = true;
        }

        //计算运费
        $yunfei = $this->freight($attrres->freight, $pronum, $address);

        //计算会员特惠
        $plugin_order = new Plugin_order($store_id);
        $grade = $plugin_order->user_grade('PT', $price, $user_id, $store_id);
        $grade_rate = floatval($grade['rate']);

        $payment = Tools::getPayment($db,$store_id);// 支付方式配置

        echo json_encode(array('is_add' => $arr['addemt'], 'payment' => $payment, 'mch_data' => $mch_data, 'buymsg' => $arr['adds'], 'proattr' => $attrres, 'money' => $money, 'user_name' => $user_name, 'groupres' => $groupres, 'grade_rate' => $grade_rate, 'yunfei' => $yunfei, 'can_pay' => $can_pay, 'password_status' => $password_status));
        exit;

    }

    /**
     * 计算运费
     * @param $freight
     * @param $num
     * @param $address
     * @return float|int
     */
    public function freight($freight, $num, $address)
    {
        $db = DBAction::getInstance();
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
                $sql2 = "select G_CName from admin_cg_group where G_CName = '$sheng'";

                $r_2 = $db->select($sql2);
                if ($r_2) {
                    $city = $r_2[0]->G_CName;
                    $rule_1 = $r_1[0]->freight;
                    $rule_2 = unserialize($rule_1);
                    foreach ($rule_2 as $key => $value) {
                        $citys_str = $value['name'];
                        $citys_array = explode('&nbsp;&nbsp;,&nbsp;&nbsp;', $citys_str);
                        $citys_arrays = array();
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

    /**
     *创建拼团订单
     */
    public function createOrder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $uid = $this->user_id;

        $pro_id = intval(trim($request->getParameter('pro_id')));
        $man_num = intval(trim($request->getParameter('man_num')));
        $buy_num = intval(trim($request->getParameter('num')));
        $activity_no = intval(trim($request->getParameter('activity_no')));
        $frompage = addslashes(trim($request->getParameter('frompage')));
        $paytype = addslashes(trim($request->getParameter('pay_type')));
        $ptcode = addslashes(trim($request->getParameter('ptcode')));
        $sizeid = intval(trim($request->getParameter('sizeid')));
        $address_id = intval(trim($request->getParameter('address_id')));//地址id
        $lktlog = new LaiKeLogUtils("app/group.log");

        //查询用户地址
        $address_sql = "select * from lkt_user_address where store_id = '$store_id' and id = '$address_id'";
        $address_res = $db->select($address_sql);
        if (!empty($address_res)) {
            $name = $address_res[0]->name;
            $sheng = $address_res[0]->sheng;
            $shi = $address_res[0]->city;
            $quyu = $address_res[0]->quyu;
            $address = $address_res[0]->address_xq;
            $tel = $address_res[0]->tel;
        } else {
            $ret['msg'] = "地址信息错误！";
            $ret['code'] = 500;
            echo json_encode($ret);
            exit;
        }

        //查询商品信息
        $sql1 = "select p.*, c.attribute,c.num,c.price 
        from lkt_configure as c 
        LEFT JOIN lkt_product_list as p on c.pid = p.id 
        where c.id= $sizeid and c.pid= $pro_id";
        $pro_size = $db->select($sql1);
        if (empty($pro_size)) {
            $ret['code'] = 500;
            $ret['msg'] = "参数错误！";
            echo json_encode($ret);
            exit;
        }
        //查询拼团价格
        $sql2 = "SELECT * FROM lkt_group_product WHERE store_id = $store_id and activity_no = $activity_no";
        $group_res = $db->select($sql2);
        $group_level = unserialize($group_res[0]->group_level);
        $group_level = $group_level[$man_num];
        $group_level_arr = explode('~', $group_level);
        //查询拼团配置是否开启团长优惠
        $sel_config_sql = "SELECT * FROM lkt_group_config WHERE store_id = $store_id";
        $config_res = $db->select($sel_config_sql);
        $open_discount = $config_res[0]->open_discount;
        //判断优惠比例
        if ($open_discount == 1 && $frompage == "kaituan") {
            $group_level = $group_level_arr[1];
        } else {
            $group_level = $group_level_arr[0];
        }
        $_y_price = $pro_size[0]->price;
        $y_price = $_y_price / 100 * $group_level;

        //计算运费
        $address_ = Tools::find_address($db, $store_id, $uid, $address_id);
        $yunfei = $this->freight($pro_size[0]->freight, $buy_num, $address_);

        //计算会员特惠
        $plugin_order = new Plugin_order($store_id);
        $_y_price = $y_price * $buy_num;
        $grade = $plugin_order->user_grade('PT', $_y_price, $uid, $store_id);
        $grade_rate = floatval($grade['rate']);

        $price = $y_price * $buy_num * $grade_rate + $yunfei;

        $db->begin();
        $creattime = date('Y-m-d H:i:s');

        $pro_name = $pro_size[0]->product_title;
        $pro_size = unserialize($pro_size[0]->attribute);
        $pro_size = implode(',', array_values($pro_size));
        $spz_price = $buy_num * $y_price;
        $code = true;
        $msg = '创建订单失败,请稍后再试!';
        $ordernum = 'PT' . mt_rand(10000, 99999) . date('Ymd') . substr(time(), 5);

//        查询商品的商铺id
        $pro_sql = "select mch_id from lkt_product_list where id = $pro_id";
        $pro_res = $db->select($pro_sql);
        if ($pro_id) {
            $mch_id = $pro_res[0]->mch_id;
            $mch_id = ',' . $mch_id . ',';
        }
        //添加一条订单数据
        $istsql2 = "insert into lkt_order
        (store_id,user_id,name,mobile,num,z_price,spz_price,sNo,sheng,shi,xian,address,pay,add_time,status,otype,ptcode,ptstatus,pid,groupman,mch_id,grade_rate) 
        values
        ('$store_id','$uid','$name','$tel',$buy_num,$price,$spz_price,'$ordernum','$sheng','$shi','$quyu','$address','$paytype','$creattime',0,'pt','$ptcode',0,'$frompage','$man_num','$mch_id',$grade_rate)";
        $res2 = $db->insert($istsql2, "last_insert_id");
        if ($res2 < 1) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."添加订单数据失败！sql:".$istsql2);
            $code = false;
        }

        //添加订单详情数据
        $istsql3 = "insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,r_sNo,add_time,r_status,size,sid,freight) values('$store_id','$uid',$pro_id,'$pro_name',$y_price,$buy_num,'$ordernum','$creattime',0,'$pro_size',$sizeid,'$yunfei')";
        $res3 = $db->insert($istsql3);
        if ($res3 < 1) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."添加订单详情数据失败！sql:".$istsql3);
            $code = false;
            echo 2;

        }

        //修改商品属性库存
        $up_sql1 = "update lkt_configure set num=num-$buy_num where id=$sizeid";
        $updres = $db->update($up_sql1);
        if ($updres < 1) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改属性库存失败！sql:".$up_sql1);
            $code = false;
            echo 3;
        }

        if ($code) {
            $db->commit();
            echo json_encode(array('status' => 1, 'order' => $ordernum, 'total' => $price, 'order_id' => $res2));
            exit;
        } else {
            $db->rollback();
            echo json_encode(array('status' => 0, 'msg' => $msg));
            exit;
        }

    }

    /**
     * 参团操作
     */
    public function cangroup()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $sNo = addslashes(trim($request->getParameter('oid')));
        $access_id = addslashes(trim($request->getParameter('access_id')));

        $store_id = $this->store_id;
        $userid = $this->user_id;

        //根据订单号查询拼团ptcode
        $ptsql = "select ptcode from lkt_order where store_id = '$store_id' and sNo='$sNo'";
        $ptres = $db->select($ptsql);

        $oid = $ptres[0]->ptcode;
        //查询该团有多少人
        $redsql = "select count(*) as recd from lkt_order where store_id = '$store_id' and ptcode='$oid' and user_id='$userid' and status not in(0,6,7)";
        $isrecd = $db->select($redsql);
        $recd = $isrecd[0]->recd;
        $selSql = "select uid,ptgoods_id,endtime,ptstatus,ptnumber,groupman from lkt_group_open where store_id = '$store_id' and ptcode='$oid'";
        $groupmsg = $db->select($selSql);
        $pid = $groupmsg[0]->ptgoods_id;
        $groupman = $groupmsg[0]->groupman;
        $groupList = array();   //其他团
        if ($recd > 0) {
            $sql = "select m.*,d.p_name,d.p_price,d.sid from (select k.ptgoods_id,k.ptnumber,k.addtime as cantime,k.endtime,k.ptstatus,k.groupman,p.name,p.num,p.sNo,p.sheng,p.shi,p.xian,p.address,p.mobile,p.status,p.id from lkt_group_open as k right join lkt_order as p on k.ptcode=p.ptcode where p.store_id = '$store_id' and p.ptcode='$oid' and p.user_id='$userid' and p.status != 0 ) as m left join lkt_order_details as d on m.sNo=d.r_sNo";
            $res = $db->select($sql);
            if ($res) {
                $ptgoods_id = $res[0]->ptgoods_id;
                $res = $res[0];
                $image = $db->select("select img,price from lkt_configure where id=$res->sid");
                $res->img = ServerPath::getimgpath($image[0]->img);
                $res->price = $image[0]->price;
                $ptstatus = $res->ptstatus;

                if ($ptstatus == 3) {    //如果拼团失败了,查询此产品的其他团信息
                    $sql_kt = "select g.ptcode,g.ptnumber,g.groupman,g.endtime,u.user_name,u.headimgurl,o.sNo from lkt_group_open as g left join lkt_user as u on g.uid=u.user_id left join lkt_order as o on g.ptcode=o.ptcode where g.store_id = '$store_id' and g.ptgoods_id=$pid and g.ptstatus=1 and u.store_id = '$store_id' and EXISTS(select * from lkt_order as o where o.ptcode=g.ptcode and o.status!=6) and g.uid!='$userid' and o.pid='kaituan'";
                    $res_kt = $db->select($sql_kt);
                    if (!empty($res_kt)) {
                        foreach ($res_kt as $key => $value) {
                            $res_kt[$key]->leftTime = strtotime($value->endtime) - time();
                            $res_kt[$key]->leftTimeStr = '00:00:00';
                            if (strtotime($value->endtime) - time() > 0) {
                                array_push($groupList, $res_kt[$key]);
                            }
                        }
                    }
                }
            } else {
                $res = (object)array();
            }
            if ($access_id == '') {
                $res->isSelf = false;
            } else {
                $res->isSelf = true;
            }
        } else {
            $res = $groupmsg[0];
            $goodsql = "select z.*,l.product_title as pro_name 
                            from (
                            select m.*,c.num,c.img as image,c.price 
                                from (
                                select min(id) as id,attr_id,product_id from lkt_group_product where store_id = '$store_id' and product_id=$res->ptgoods_id
                                ) as m 
                            left join lkt_configure as c on m.attr_id=c.id
                            ) as z 
                        left join lkt_product_list as l on z.product_id=l.id";
            $goods = $db->select($goodsql);

            $res->p_name = $goods[0]->pro_name;
            $res->price = $goods[0]->price;
            $res->img = ServerPath::getimgpath($goods[0]->image);
            $res->p_num = $goods[0]->num;
            $res->isSelf = false;
        }
        $memsql = "select i.user_id,u.headimgurl 
                    from lkt_order as i 
                    left join lkt_user as u on i.user_id=u.user_id 
                    where u.store_id = '$store_id' and i.ptcode='$oid' and i.status not in(0,6,7) order by i.id asc";
        $groupmember = $db->select($memsql);

        $gdata = $db->select("select *
                                        from lkt_group_product 
                                        where product_id=$pid and store_id = $store_id and is_delete = 0 and g_status != 1 order by id desc ");

        $group_data = unserialize($gdata[0]->group_data);
        $group_level = unserialize($gdata[0]->group_level);
        $zekou = $group_level[$groupman];
        $zekou = explode('~', $zekou);
        $zekou = $zekou[0];
        $res->group_data = $group_data;
        $res->zekou = $zekou;
        $res->groupmember = $groupmember;

        $sumsql = "select sum(o.num) as sum,d.p_id from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '1' and o.status>0 and o.status != 6 and o.otype='pt'  and d.p_id= '$res->ptgoods_id' group by d.p_id ";
        $sumres = $db->select($sumsql);
        if (!empty($sumres)) $res->sum = $sumres[0]->sum;
        switch ($res->ptstatus) {
            case 1:
                $res->groupStatus = '拼团中';
                break;
            case 2:
                $res->groupStatus = '拼团成功';
                break;
            case 3:
                $res->groupStatus = '拼团失败';
                break;
            default:
                $res->groupStatus = '未付歀';
                break;
        }
        $res->leftTime = strtotime($res->endtime) - time();


        $sql_size = "select g.attr_id,g.product_id,p.attribute,p.num,p.img,p.price,p.id from lkt_group_product as g left join lkt_configure as p on g.attr_id=p.id where g.store_id = '$store_id' and g.product_id = '$pid' order by p.price";

        $r_size = $db->select($sql_size);
        $skuBeanList = array();
        $attrList = array();
        if ($r_size) {

            $attrList = array();
            $a = 0;
            $attr = array();
            foreach ($r_size as $key => $value) {
                $array_price[$key] = $value->price;

                $attribute = unserialize($value->attribute);
                $attnum = 0;
                $arrayName = array();
                foreach ($attribute as $k => $v) {
                    if (!in_array($k, $arrayName)) {
                        array_push($arrayName, $k);
                        $kkk = $attnum++;
                        $attrList[$kkk] = array('attrName' => $k, 'attrType' => '1', 'id' => md5($k), 'attr' => array(), 'all' => array());
                    }
                }
            }
            $ok = array();
            foreach ($r_size as $key => $value) {
                $attribute = unserialize($value->attribute);
                $attributes = array();
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
                            if ($key == 0 && $skuBeanList[$key]['count'] > 0 && !array_key_exists($k, $ok)) {
                                $enable = true;
                                $select = true;
                                $ok[$k] = 1;
                            } else {
                                $enable = false;
                                $select = false;
                            }

                            $attr_array = array('attributeId' => md5($k), 'id' => md5($v), 'attributeValue' => $v, 'enable' => $enable, 'select' => $select, 'count' => $skuBeanList[$key]['count'], 'price' => $skuBeanList[$key]['price']);
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
        $plugsql = "select status from lkt_plug_ins where store_id = '$store_id' and type = 0 and name like '%拼团%'";
        $plugopen = $db->select($plugsql);
        $plugopen = !empty($plugopen) ? $plugopen[0]->status : 0;
        $goodssql = "select g.g_status,p.status,g.is_show,g.group_level 
					from lkt_group_product as g 
					right join lkt_product_list as p on g.product_id=p.id 
					where p.id=$pid and g.is_delete = 0
					order by case 
                                  when g.g_status='2' then 1
                                  when g.g_status='3' then 2
                                  when g.g_status='1' then 3
                              end 
					";
        $goodscode = $db->select($goodssql);
        $isshow = (int)$goodscode[0]->is_show;
        $goodscode = $goodscode[0];

        //计算拼团的最低价 和 对应的参团人数
        $pro_id = addslashes(trim($request->getParameter('pro_id')));
        $sel_proId_sql = "SELECT c.pid 
        FROM lkt_order_details as d
        LEFT JOIN lkt_configure as c on d.sid = c.id 
        WHERE d.r_sNo = '$sNo'";
        $proId_res = $db->select($sel_proId_sql);
        $pro_id = $proId_res[0]->pid;
        $sel_attr_sql = "select c.price
                from lkt_configure as c 
                left join lkt_product_list as p on c.pid=p.id 
                where c.pid=$pro_id";
        $min_price = '';
        $sel_attr_Res = $db->select($sel_attr_sql);
        foreach ($sel_attr_Res as $k => $v3) {
            if ($min_price == '') {
                $min_price = $v3->price;
            } else if ($min_price > $v3->price) {
                $min_price = $v3->price;
            }
        }
        //查询最低价格的和 拼团人数
        $kai_min_bili = $min_bili = 100;
        $kai_min_man = $min_man = 100;
        $level = unserialize($goodscode->group_level);
        foreach ($level as $k => $v___) {
            $bili = explode('~', $v___);
            if ($bili[0] > $bili[1]) {
                $_min_bili = $bili[1];
            } else {
                $_min_bili = $bili[0];
            }
            if ($kai_min_bili > $_min_bili) {
                $kai_min_bili = $_min_bili;
                $kai_min_man = $k;
            }
        }
        $kai_min_price = floatval($min_price) * intval($kai_min_bili) / 100;
        $kai_min_price = sprintf("%.2f", $kai_min_price);
        foreach ($level as $k => $v__) {
            $bili = explode('~', $v__);
            if ($min_bili > $bili[0]) {
                $min_bili = $bili[0];
                $min_man = $k;
            }
        }
        $min_price = floatval($min_price) * intval($min_bili) / 100;
        $min_price = sprintf("%.2f", $min_price);

        $loseEfficacyImg = "http://xiaochengxu.laiketui.com/V2.7/images/loseEfficacy2x.png";

        $share = array('friends' => true, 'friend' => false);

        $ls_price = '';//零售价
        $min_index = '';
        foreach ($attrList[0]['attr'] as $k_ => $v_) {

            if ($v_['count'] > 0 && $ls_price == '') {
                $ls_price = $v_['price'];
                $min_index = $k_;
            } else if ($v_['count'] > 0 && $ls_price != '') {
                if ($ls_price > $v_['price']) {
                    $ls_price = $v_['price'];
                    $min_index = $k_;
                }
            }
        }
        $attrList[0]['attr'][$min_index]['enable'] = $attrList[0]['attr'][$min_index]['select'] = true;

        $sel_group_cfg = "select * from lkt_group_config where store_id = $store_id";
        $group_cfg = $db->select($sel_group_cfg);

        //查询拼团规则
        $rule = $group_cfg[0]->rule;

        $user_can_open = true;
        $user_can_can = true;
        $group_again_by = true;
        $can_num = $group_cfg[0]->can_num; //最多参团数量
        $open_num = $group_cfg[0]->open_num; //最多开团数量
        $can_again = $group_cfg[0]->can_again; //是否能重复参团
        if ($res->group_data) {
            $start_time = $res->group_data->starttime;
            $end_time = $res->group_data->endtime;
        } else {
            $start_time = '';
            $end_time = $res->endtime;
        }

        if ($can_again != '1') {
            //end_pages_
            $sel_is_buy_pt_pro_sql = "SELECT d.* 
            from lkt_order as o
            LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
            where o.otype = 'pt' and o.pid = 'cantuan' and o.user_id = '$userid' and o.ptstatus = 1 and o.store_id = $store_id  and d.p_id = $pid and o.pay_time > '$start_time'  and o.pay_time < '$end_time'";
            $sel_is_buy_pt_pro_res = $db->select($sel_is_buy_pt_pro_sql);
            if ($sel_is_buy_pt_pro_res) {
                $group_again_by = false;
            }
        }

        //查询登录的用户
        if ($access_id != '') {
            $sel_user_sql = "select * from lkt_user where store_id = $store_id and access_id = '$access_id'";
            $user_res = $db->select($sel_user_sql);

            if ($user_res) {
                $user_id = $user_res[0]->user_id;
                //查询当前用户开团数量
                $sel_open_num = "SELECT * FROM lkt_group_open WHERE uid = '$user_id' and ptstatus = 1 and store_id = 1";
                $already_open_num = $db->select($sel_open_num);
                $already_open_num = count($already_open_num);
                if ((int)$already_open_num >= (int)$open_num) {
                    $user_can_open = false;
                }
                //查询用户当前参团数量
                $sel_can_num = "SELECT * from lkt_order where otype = 'pt' and store_id = 1 and user_id = '$user_id' and ptstatus = 1 and pid = 'cantuan'  and add_time > '2019-07-15 00:00:00'";
                $already_can_num = $db->select($sel_can_num);
                $already_can_num = count($already_can_num);
                if ((int)$already_can_num >= (int)$can_num) {
                    $user_can_can = false;
                }
            }
        }

        echo json_encode(array('rule' => $rule, 'isshow' => $isshow, 'group_again_by' => $group_again_by, 'user_can_open' => $user_can_open, 'user_can_can' => $user_can_can, 'islogin' => $this->login, 'min_price' => $min_price, 'min_man' => $min_man, 'groupmsg' => $res, 'groupMember' => $groupmember, 'skuBeanList' => $skuBeanList, 'attrList' => $attrList, 'isplug' => $plugopen, 'goodscode' => $goodscode, 'groupList' => $groupList, 'ptcode' => $oid, 'loseEfficacyImg' => $loseEfficacyImg));
        exit;

    }

    // 查询订单
    public function grouporder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $userid = $this->user_id;
        // 获取信息

        $order_type = addslashes(trim($request->getParameter('order_type'))); // 类型
        $page = intval(trim($request->getParameter('page'))); // 类型
        $page--;
        $start = $page * 10;


        if ($order_type == 'notpay') {
            $res = " and a.status = 0 "; // 未付款
        } else if ($order_type == 'grouping') {
            $res = " and a.status = 9 "; // 未发货
        } else if ($order_type == 'success') {
            $res = " and a.status in (1,2,3,5,12) "; // 待收货
        } else if ($order_type == 'fail') {
            $res = " and a.status in (10,11) "; // 待评论
        } else {
            $res = "and a.status != 4 and a.status != 8 ";
        }
        $order = array();

        // 根据用户id和前台参数,查询订单表 (id、订单号、订单价格、添加时间、订单状态、优惠券id)
        $sql = "select od.p_id,gp.is_show,gp.group_data,gp.endtime,od.sid,a.id,z_price,sNo,a.add_time,status,delivery_status,otype ,a.offset_balance,a.otype,a.pid,a.mch_id
                from lkt_order as a 
                LEFT JOIN lkt_order_details as od on a.sNo = od.r_sNo
                LEFT JOIN lkt_group_product as gp on od.sid = gp.attr_id
                where a.store_id = '$store_id' and a.status <> 7 and a.user_id = '$userid' " . $res . " and otype='pt'
                GROUP by a.id
                order by add_time desc LIMIT $start,10";
        $r = $db->select($sql);
        if ($r) {
            $time = date('Y-m-d H:i:s');
            $i = 0;
            foreach ($r as $k => $v) {
                $rew = array();
                $rew['id'] = $v->id; // 订单id
                $rew['z_price'] = $v->z_price; // 订单价格
                $rew['sNo'] = $v->sNo; // 订单号
                $sNo = $v->sNo; // 订单号
                $rew['add_time'] = $v->add_time; // 订单时间
                $rew['status'] = $v->status; // 订单状态
                $rew['otype'] = $v->otype; //订单类型
                $rew['offset_balance'] = $v->offset_balance; //余额支付
                $rew['delivery_status'] = $v->delivery_status; // 提醒状态
                $rew['z_price'] = $v->z_price;
                $mch_id = $v->mch_id;
                if ($v->z_price != $v->offset_balance) {
                    $rew['z_price'] = $v->z_price + $v->offset_balance;
                }

                if (!empty($mch_id)) {
                    $mch_id_ = substr($mch_id, 1, strlen($mch_id) - 2);
                    $sql0 = "select id,name,logo from lkt_mch where store_id = '$store_id' and (id = '$mch_id_' or id = '$mch_id')";
                    $r0 = $db->select($sql0);
                    if ($r0) {
                        $rew['shop_id'] = $r0[0]->id;
                        $rew['shop_name'] = $r0[0]->name;
                        $rew['shop_logo'] = ServerPath::getimgpath($r0[0]->logo);
                    } else {
                        $rew['shop_id'] = 0;
                        $rew['shop_name'] = '';
                        $rew['shop_logo'] = '';
                    }
                } else {
                    $rew['shop_id'] = 0;
                    $rew['shop_name'] = '';
                    $rew['shop_logo'] = '';
                }

                $rew['refund'] = true;
                $end_time = $v->endtime;
                $end_time = strtotime($end_time);
                if (time() > $end_time && $rew['status'] == 9) {
                    //活动已经结束
                    $rew['status'] == 11;
                    $rew['refund'] = false;

                }

                // 根据订单号,查询订单详情
                $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' and r_status <> 7";
                $rew['list'] = $db->select($sql);
                $z_freight = 0;
                foreach ($rew['list'] as $kk => $vv) {
                    $freight = $vv->freight;
                    $z_freight += $freight;
                }
                $rew['z_freight'] = $z_freight;
                $sqlsum = "select sum(num) as sum from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' and r_status <> 7";
                $sum23 = $db->select($sqlsum);

                $rew['sum'] = $sum23[0]->sum;
                unset($product);
                $product = array();

                if ($rew['list'] && !empty($rew['list'])) {
                    foreach ($rew['list'] as $key => $values) {
                        $size = $values->size;
                        $size = explode(' ', $size);
                        $size = implode(';', $size);
                        $size = ltrim($size, ";");
                        $values->size = $size;


                        $rew['pro_id'] = $values->p_id;

                        $p_id = $values->p_id; // 产品id
                        $values->attribute_id = $values->sid; // 属性id
                        $arr = (array)$values;
                        // 根据产品id,查询产品列表 (产品图片)
                        $sql = "select imgurl from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                        $rrr = $db->select($sql);
                        if ($rrr) {
                            $img_res = $rrr['0']->imgurl;
                            $url = ServerPath::getimgpath($img_res); // 拼图片路径
                            $arr['imgurl'] = $url;
                            $product[$key] = (object)$arr;
                        }
                    }
                    $rew['list'] = $product;
                    if ($v->status == '0') {
                        //如果是拼团未付款的订单，进入判断
                        //查询所有关闭了，结束了的活动商品id(attr_id)的
                        $can_open = 1;
                        $sql = 'SELECT * from lkt_group_product';
                        $group_cfg = $db->select($sql);
                        $close = array();
                        foreach ($group_cfg as $ks => $vs) {
                            $e_time = strtotime(unserialize($vs->group_data)->endtime);//获取结束时间戳
                            if ($e_time < time()) {
                                //活动已经结束
                                $close[$ks] = $vs->attr_id;
                            } else if ($vs->g_status != 2) {
                                //活动已经关闭
                                $close[$ks] = $vs->attr_id;
                            }
                        }
                        //比较订单是否是该商品
                        $isin_ = in_array($rew['list'][0]->attribute_id, $close);

                        if ($isin_) {
                            $can_open = 0;
                        }
                        //如果是，can_open = 0
                        $rew['can_open'] = $can_open;
                    }
                }
                $order[] = $rew;
            }
        } else {
            $order = '';
        }

        echo json_encode(array('code' => 200, 'order' => $order, 'message' => '操作成功'));
        exit();

    }

    // 验证未付款的参团订单后续付款是否可以再参团
    public function checkgroup()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));
        // 获取信息
        $sNo = addslashes(trim($request->getParameter('sNo'))); // 类型

        $sql = "select ptcode from lkt_order where sNo='$sNo' and store_id='$store_id'";
        $res = $db->select($sql);
        $ptcode = $res[0]->ptcode;   //团号
        $gsql = "select * from lkt_group_open where ptcode='$ptcode' and store_id='$store_id'";
        $gres = $db->select($gsql);
        if ($gres) {
            $ptstatus = $gres[0]->ptstatus;
            $endtime = $gres[0]->endtime;
            $endtime = strtotime($endtime);
            $time = time();

            if ($ptstatus == 1 && $time < $endtime) {      //符合参团条件
                echo json_encode(array('code' => 200));
                exit();
            } else {
                echo json_encode(array('code' => 0));   //不符合
                exit();
            }
        } else {
            echo json_encode(array('code' => 0));   //不符合
            exit();
        }


    }

    /*
     * 参团订单
     */
    public function canOrder()
    {
        $db = DBAction::getInstance();
        $db->begin();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $uid = addslashes(trim($request->getParameter('uid')));
        $form_id = addslashes(trim($request->getParameter('fromid')));
        $oid = addslashes(trim($request->getParameter('oid')));
        $pro_id = intval(trim($request->getParameter('pro_id')));
        $sizeid = intval(trim($request->getParameter('sizeid')));

        $man_num = intval(trim($request->getParameter('man_num')));
        $pro_name = addslashes(trim($request->getParameter('ptgoods_name')));
        $price = (float)(trim($request->getParameter('price')));
        $y_price = (float)(trim($request->getParameter('d_price')));
        $name = addslashes(trim($request->getParameter('name')));
        $sheng = intval(trim($request->getParameter('sheng')));
        $shi = intval(trim($request->getParameter('shi')));
        $quyu = intval(trim($request->getParameter('quyu')));
        $address = addslashes(trim($request->getParameter('address')));
        $tel = addslashes(trim($request->getParameter('tel')));
        $lack = intval(trim($request->getParameter('lack')));
        $buy_num = intval(trim($request->getParameter('num')));
        $paytype = addslashes(trim($request->getParameter('paytype')));
        $trade_no = addslashes(trim($request->getParameter('trade_no')));
        $status = intval(trim($request->getParameter('status')));
        $yunfei = (float)(trim($request->getParameter('yunfei')));
        $ordstatus = $status == 1 ? 9 : 0;
        $lktlog = new LaiKeLogUtils("app/group.log");

        $creattime = date('Y-m-d H:i:s');
        $pro_size = $db->select("select name,color,size from lkt_configure where id=$sizeid");

        $pro_size = $pro_size[0]->name . $pro_size[0]->color . $pro_size[0]->size;

        //查询开团记录
        $selsql = "select ptnumber,groupnum,ptstatus,endtime from lkt_group_open where store_id = '$store_id' and ptcode='$oid'";
        $selres = $db->select($selsql);

        if (!empty($selres)) {
            $ptnumber = $selres[0]->ptnumber;
            $ptstatus = $selres[0]->ptstatus;
            $endtime = strtotime($selres[0]->endtime);
        }
        //
        $ordernum = 'PT' . mt_rand(10000, 99999) . date('Ymd') . substr(time(), 5);
        $user_id = $db->select("select user_id,money from lkt_user where store_id = '$store_id' and wx_id='$uid'");
        $uid = $user_id[0]->user_id;
        $money = $user_id[0]->money;
        $code = true;

        if ($endtime >= time()) {
            if (($ptnumber + 1) < $man_num) {

                $istsql2 = "insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,pay,add_time,otype,ptcode,ptstatus,status,trade_no) values( '$store_id','$uid','$name','$tel',$buy_num,$price,'$ordernum',$sheng,$shi,$quyu,'$address','$paytype','$creattime','pt','$oid',$status,$ordstatus,'$trade_no')";
                $res2 = $db->insert($istsql2);

                $istsql3 = "insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,r_sNo,add_time,r_status,size,sid,freight) values('$store_id','$uid',$pro_id,'$pro_name',$y_price,$buy_num,'$ordernum','$creattime',-1,'$pro_size',$sizeid,'$yunfei')";
                $res3 = $db->insert($istsql3);
                if ($res2 > 0 && $res3 > 0) {
                    $updsql = "update lkt_group_open set ptnumber=ptnumber+1 where store_id = '$store_id' and ptcode='$oid'";
                    $updres = $db->update($updsql);
                    $updsql1 = "update lkt_configure set num=num-$buy_num where id=$sizeid";
                    $updres1 = $db->update($updsql1);
                    if ($updres < 1 || $updres1 < 1) {
                        $code = false;
                        $lktlog->customerLog(__METHOD__.":".__LINE__."参团失败！sql:".$updsql.'-'.$updsql1);
                    }
                } else {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."添加订单，订单详情数据失败！sql:".$istsql2.'-'.$istsql3);
                    $code = false;
                }

                if ($code) {
                    $db->commit();
                    $idres = $db->select("select id from lkt_order where store_id = '$store_id' and sNo='$ordernum'");
                    if (!empty($idres)) $idres = $idres[0]->id;
                    echo json_encode(array('order' => $ordernum, 'gcode' => $oid, 'group_num' => $oid, 'ptnumber' => $ptnumber, 'id' => $idres, 'endtime' => $endtime, 'code' => 1));
                    exit;
                } else {
                    $db->rollback();
                    $up_user_money_sql = "update lkt_user set money=money+$price where user_id='$uid' and store_id = '$store_id'";
                    $bere = $db->update($up_user_money_sql);
                    if($bere < 1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户金额失败！sql:".$up_user_money_sql);
                    }
                    $event = $uid . '退回拼团订单款' . $price . '元';
                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
                    $rr = $db->insert($sqll);
                    if($rr < 1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."添加记录失败！sql:".$sqll);
                    }
                    echo json_encode(array('code' => 0));
                    exit;
                }

            } else if (($ptnumber + 1) === $man_num) {
                $istsql2 = "insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,pay,add_time,otype,ptcode,ptstatus,status,trade_no) values('$store_id','$uid','$name','$tel',$buy_num,'$price','$ordernum',$sheng,$shi,$quyu,'$address','$paytype','$creattime','pt','$oid',$status,$ordstatus,'$trade_no')";
                $res2 = $db->insert($istsql2);

                $istsql3 = "insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,r_sNo,add_time,r_status,size,sid,freight) values('$store_id','$uid',$pro_id,'$pro_name',$y_price,$buy_num,'$ordernum','$creattime',-1,'$pro_size',$sizeid,'$yunfei')";
                $res3 = $db->insert($istsql3);
                if ($res2 > 0 && $res3 > 0) {
                    $updsql = "update lkt_group_open set ptnumber=ptnumber+1,ptstatus=2 where store_id = '$store_id' and ptcode='$oid'";
                    $updres1 = $db->update($updsql);
                    $updsql2 = "update lkt_order set ptstatus=2,status=1 where store_id = '$store_id' and ptcode='$oid' and status!=6";
                    $updres2 = $db->update($updsql2);
                    $updsql3 = "update lkt_configure set num=num-$buy_num where id=$sizeid";
                    $updres3 = $db->update($updsql3);
                    if ($updres1 < 1 || $updres2 < 1 || $updres3 < 1) {
                        $code = false;
                        $lktlog->customerLog(__METHOD__.":".__LINE__."参团失败！sql:".$updsql.'-'.$updsql2."-".$updsql3);
                    }
                } else {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."添加订单，订单详情数据失败！sql:".$istsql2.'-'.$istsql3);
                    $code = false;
                }

                if ($code) {
                    $db->commit();
                    $sql = "select * from lkt_notice where store_id = '1'";
                    $r = $db->select($sql);
                    $template_id = $r[0]->group_success;
                    $selmsg = "select m.*,d.p_name,d.p_price,d.num,d.sid from (select o.id,o.user_id,o.ptcode,o.sNo,o.z_price,u.wx_id as uid from lkt_order as o left join lkt_user as u on o.user_id=u.user_id where o.store_id = '$store_id' and o.ptcode='$oid' and o.status!=6 and u.store_id = '$store_id') as m left join lkt_order_details as d on m.sNo=d.r_sNo and d.store_id = '$store_id'";
                    $msgres = $db->select($selmsg);
                    foreach ($msgres as $k => $v) {
                        $fromidsql = "select fromid,open_id from lkt_user_fromid where open_id='$v->uid' and id=(select max(id) from lkt_user_fromid where store_id = '$store_id' and open_id='$v->uid')";
                        $fromidres = $db->select($fromidsql);
                        if (!empty($fromidres)) {
                            foreach ($fromidres as $ke => $val) {
                                if ($val->open_id == $v->uid) {
                                    $msgres[$k]->fromid = $val->fromid;
                                }
                            }
                        } else {
                            $msgres[$k]->fromid = '';
                        }
                    }
                    $this->Send_success($msgres, date('Y-m-d H:i:s', time()), $template_id, $pro_name);
                    echo json_encode(array('order' => $msgres, 'gcode' => $oid, 'code' => 2));
                    exit;
                } else {
                    $db->rollback();
                    $up_user_money_sql = "update lkt_user set money=money+$price where user_id='$uid' and store_id = '$store_id'";
                    $bere = $db->update($up_user_money_sql);
                    if($bere < 1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户金额失败！sql:".$up_user_money_sql);
                    }
                    $event = $uid . '退回拼团订单款' . $price . '元';
                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
                    $rr = $db->insert($sqll);
                    if($rr < 1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."添加记录失败！sql:".$sqll);
                    }
                    echo json_encode(array('code' => 0));
                    exit;
                }
            } else if ($ptnumber == $man_num) {
                $up_user_money_sql = "update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$uid'";
                $updres = $db->update($up_user_money_sql);
                if ($updres < 1) {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户金额失败！sql:".$up_user_money_sql);
                    $code = false;
                }
                $event = $uid . '退回拼团订单款' . $price . '元';
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
                $rr = $db->insert($sqll);
                if($rr < 1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."添加记录失败！sql:".$sqll);
                }
                if ($code) {                     //如果批量执行没出错则提交，否则就回滚
                    $db->commit();
                } else {
                    $db->rollback();
                }
                echo json_encode(array('code' => 3));
                exit;
            }

        } else {
            $up_user_money_sql = "update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$uid'";
            $updres = $db->update($up_user_money_sql);
            if ($updres < 1) {
                $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户金额失败！sql:".$up_user_money_sql);
                $code = false;
            }
            $event = $uid . '退回拼团订单款' . $price . '元';
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
            $rr = $db->insert($sqll);
            if($rr < 1){
                $lktlog->customerLog(__METHOD__.":".__LINE__."添加记录失败！sql:".$sqll);
            }
            if ($code) {                     //如果批量执行没出错则提交，否则就回滚
                $db->commit();
            } else {
                $db->rollback();
            }
            echo json_encode(array('code' => 4));
            exit;
        }


    }


    public function isgrouppacked()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $oid = addslashes(trim($request->getParameter('oid')));
        $selsql = "select ptnumber from lkt_group_open where store_id = '$store_id' and ptcode='$oid'";
        $selres = $db->select($selsql);
        if ($selres) {
            $hasnum = $selres[0]->ptnumber;
            echo json_encode(array('hasnum' => $hasnum));
            exit;
        } else {
            echo json_encode(array('hasnum' => 0));
            exit;
        }

    }

    public function confirmReceipt()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $oid = addslashes(trim($request->getParameter('oid')));
        $lktlog = new LaiKeLogUtils("app/group.log");

        $updsql = "update lkt_order set status=3 where store_id = '$store_id' and sNo='$oid'";
        $updres = $db->update($updsql);

        if ($updres > 0) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态成功！");
            echo json_encode(array('code' => 1));
            exit;
        }else{
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$updsql);
        }

    }

    function httpsRequest($url, $data = null)
    {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($data)) {
            // 发送post请求
            curl_setopt($ch, CURLOPT_POST, 1);
            // 设置发送post请求参数数据
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        // 3.执行会话; $result是微信服务器返回的JSON字符串
        $result = curl_exec($ch);
        // 4.关闭会话
        curl_close($ch);
        return $result;
    }

    public function Send_open()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('user_id'));  //--
        $form_id = trim($request->getParameter('form_id'));//--
        $page = trim($request->getParameter('page'));      //--
        $f_price = trim($request->getParameter('price'));
        $f_price = $f_price . '元';
        $f_sNo = trim($request->getParameter('order_sn'));
        $f_pname = trim($request->getParameter('f_pname'));
        $opentime = date('Y-m-d H:i:s', time());
        $endtime = trim($request->getParameter('endtime'));
        $sum = trim($request->getParameter('sum'));
        $sum = $sum . '元';
        $member = trim($request->getParameter('member'));
        $endtime = $endtime[0] . '小时';

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret

            $opentime = array('value' => $opentime, "color" => "#173177");
            $f_pname = array('value' => $f_pname, "color" => "#173177");
            $f_sNo = array('value' => $f_sNo, "color" => "#173177");
            $f_price = array('value' => $f_price, "color" => "#173177");
            $endtime = array('value' => $endtime, "color" => "#173177");
            $sum = array('value' => $sum, "color" => "#173177");
            $member = array('value' => $member, "color" => "#173177");
            $tishi = array('value' => '您可以邀请您的好友一起来拼团，邀请的人越多，成功的几率越高哦!', "color" => "#FF4500");
            $o_data = array('keyword1' => $member, 'keyword2' => $opentime, 'keyword3' => $endtime, 'keyword4' => $f_price, 'keyword5' => $sum, 'keyword6' => $f_sNo, 'keyword7' => $f_pname, 'keyword8' => array('value' => '已开团-待成团', "color" => "#FF4500"), 'keyword9' => $tishi);

            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

            $sql = "select * from lkt_notice where id = '1'";
            $r = $db->select($sql);
            $template_id = $r[0]->group_pay_success;

            $data = json_encode(array('access_token' => $AccessToken, 'touser' => $openid, 'template_id' => $template_id, 'form_id' => $form_id, 'page' => $page, 'data' => $o_data));

            $da = $this->httpsRequest($url, $data);

            echo json_encode($da);

            exit();
        }

    }

    public function Send_can()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('user_id'));  //--
        $form_id = trim($request->getParameter('form_id'));//--
        $page = trim($request->getParameter('page'));      //--
        $f_price = trim($request->getParameter('price'));
        $f_price = $f_price . '元';
        $f_sNo = trim($request->getParameter('order_sn'));
        $f_pname = trim($request->getParameter('f_pname'));
        $opentime = date('Y-m-d H:i:s', time());
        $endtime = intval($request->getParameter('endtime')) - time();
        $sum = trim($request->getParameter('sum'));
        $sum = $sum . '元';
        $man_num = trim($request->getParameter('man_num'));
        $hours = ceil($endtime / 3600);
        $minute = ceil(($endtime % 3600) / 60);
        $endtime = $hours . '小时' . $minute . '分钟';

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret

            $opentime = array('value' => $opentime, "color" => "#173177");
            $f_pname = array('value' => $f_pname, "color" => "#173177");
            $f_sNo = array('value' => $f_sNo, "color" => "#173177");
            $f_price = array('value' => $f_price, "color" => "#173177");
            $endtime = array('value' => $endtime, "color" => "#173177");
            $sum = array('value' => $sum, "color" => "#173177");
            $man_num = array('value' => $man_num, "color" => "#173177");

            $o_data = array('keyword1' => $f_pname, 'keyword2' => $f_price, 'keyword3' => $sum, 'keyword4' => $endtime, 'keyword5' => array('value' => '待成团', "color" => "#FF4500"), 'keyword6' => $opentime, 'keyword7' => $man_num, 'keyword8' => $f_sNo);

            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;
            $sql = "select * from lkt_notice where id = '1'";
            $r = $db->select($sql);
            $template_id = $r[0]->group_pending;
            $data = json_encode(array('access_token' => $AccessToken, 'touser' => $openid, 'template_id' => $template_id, 'form_id' => $form_id, 'page' => $page, 'data' => $o_data));

            $da = $this->httpsRequest($url, $data);

            echo json_encode($da);

            exit();
        }

    }

    public function Send_success($arr, $endtime, $template_id, $pro_name)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret

            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

        }
        foreach ($arr as $k => $v) {
            $data = array();
            $data['access_token'] = $AccessToken;
            $data['touser'] = $v->uid;
            $data['template_id'] = $template_id;
            $data['form_id'] = $v->fromid;
            $data['page'] = "pages/order/detail?orderId=$v->id";
            $z_price = $v->z_price . '元';
            $p_price = $v->p_price . '元';
            $minidata = array('keyword1' => array('value' => $pro_name, 'color' => "#173177"), 'keyword2' => array('value' => $z_price, 'color' => "#173177"), 'keyword3' => array('value' => $v->sNo, 'color' => "#173177"), 'keyword4' => array('value' => '拼团成功', 'color' => "#FF4500"), 'keyword5' => array('value' => $p_price, 'color' => "#FF4500"), 'keyword6' => array('value' => $endtime, 'color' => "#173177"));
            $data['data'] = $minidata;

            $data = json_encode($data);
            $da = $this->httpsRequest($url, $data);
            $delsql = "delete from lkt_user_fromid where open_id='$v->uid' and fromid='$v->fromid'";
            $db->delete($delsql);

        }


    }

    function getAccessToken($appID, $appSerect)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appSerect;
        // 时效性7200秒实现
        // 1.当前时间戳
        $currentTime = time();
        // 2.修改文件时间
        $fileName = "accessToken"; // 文件名
        if (is_file($fileName)) {
            $modifyTime = filemtime($fileName);
            if (($currentTime - $modifyTime) < 7200) {
                // 可用, 直接读取文件的内容
                $accessToken = file_get_contents($fileName);
                return $accessToken;
            }
        }
        // 重新发送请求
        $result = $this->httpsRequest($url);
        $jsonArray = json_decode($result, true);
        // 写入文件
        $accessToken = $jsonArray['access_token'];
        file_put_contents($fileName, $accessToken);
        return $accessToken;
    }


    public function verification()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $trade_no = addslashes(trim($request->getParameter('trade_no')));
        $sql = "select id,sNo,ptcode from lkt_order where store_id = '$store_id' and trade_no='$trade_no'";
        $gmsg = $db->select($sql);

        if (!empty($gmsg)) {
            echo json_encode(array('status' => 1, 'data' => $gmsg[0]));
            exit();
        } else {
            echo json_encode(array('status' => 0));
            exit();
        }
    }

    /**
     * 数组根据字段排序
     * @param $arr
     * @param $keys
     * @param string $type
     * @return array
     */
    function array_sort($arr, $keys, $type = 'desc')
    {
        $key_value = $new_array = array();
        foreach ($arr as $k => $v) {
            $key_value[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($key_value);
        } else {
            arsort($key_value);
        }
        reset($key_value);
        foreach ($key_value as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }

    public function removeOrder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $openid = $request->getParameter('openid');
        $id = $request->getParameter('id');
        $lktlog = new LaiKeLogUtils("app/group.log");

        $msgsql = "select o.id,o.user_id,o.ptcode,o.sNo,o.z_price,o.add_time,o.pay,o.trade_no,o.status,d.p_name,d.p_price,d.num,d.sid,u.money from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo left join lkt_user as u on o.user_id=u.user_id where o.store_id = '$store_id' and o.id=$id";
        $msg = $db->select($msgsql);

        if (!empty($msg)) {
            $user_id = $msg[0]->user_id;
            $paytype = $msg[0]->pay;
            $trade_no = $msg[0]->trade_no;    //支付单号
            $sNo = $msg[0]->sNo;    //订单号
            $p_name = $msg[0]->p_name;    //订单号
            $price = floatval($msg[0]->z_price);
            $z_price = $msg[0]->z_price * 100;    //订单金额
            $money = $msg[0]->money;   //余额
            $num = $msg[0]->num;   //购买数量
            $sid = $msg[0]->sid;   //产品属性号
            $status = $msg[0]->status;   //产品属性号
        }
        if ($status != 6) {
            $db->begin();
            $sql = "update lkt_order set status=6 where store_id = '$store_id' and id=$id";
            $updres = $db->update($sql);

            if ($updres < 0) {
                $lktlog->customerLog(__METHOD__.":".__LINE__."取消订单失败！sql:".$sql);
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '取消失败'));
                exit;
            }
            if ($paytype == 'wallet_Pay' || $paytype == 'combined_Pay') {    //余额支付或者组合支付
                $updsql1 = "update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$user_id'";
                $updres1 = $db->update($updsql1);
                if($updres1<1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户金额失败！sql:".$updsql1);
                }
                $event = $user_id . '退回拼团订单款' . $price . '元--订单号:' . $sNo;
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$price','$money','$event',5)";
                $rr = $db->insert($sqll);
                if($rr < 1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."添加记录失败！sql:".$sqll);
                }
                if ($updres1 < 0) {
                    $db->rollback();
                    echo json_encode(array('code' => 0, 'err' => '取消失败,退款未成功'));
                    exit;
                }
            } else if ($paytype == 'wxPay') {
                $refund = $ordernum = date('Ymd') . mt_rand(10000, 99999) . substr(time(), 5);
                $res1 = $this->wxrefundapi($trade_no, $refund, $z_price, $z_price);
                if ($res1['return_code'] != 'SUCCESS') {
                    $db->rollback();
                    echo json_encode(array('code' => 0, 'err' => 'fail to refund'));
                    exit;
                }
            }
            $up_configure_sql = "update lkt_configure set num=num+$num where id=$sid";
            $updres = $db->update($up_configure_sql);
            if ($updres < 0) {
                $lktlog->customerLog(__METHOD__.":".__LINE__."修改商品属性库存失败！sql:".$up_configure_sql);
                $db->rollback();
                echo json_encode(array('code' => 0, 'sql' => "update lkt_configure set num=num-$num where id=$sid"));
                exit;
            }

            $db->commit();
            $fromres1 = $this->get_fromid($openid);
            $fromid = $fromres1['fromid'];
            $sql = "select * from lkt_notice where store_id = '$store_id'";
            $r = $db->select($sql);
            $template_id = $r[0]->refund_success;
            $this->Send_fail($openid, $fromid, $sNo, $p_name, $price,
                $template_id, 'pages/user/user', $paytype);
            echo json_encode(array('code' => 1, 'err' => '取消成功'));
            exit;
        } else {
            echo json_encode(array('code' => 0, 'err' => '订单已取消'));
            exit;
        }
    }

    public function get_fromid($openid)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $fromidsql = "select fromid,open_id from lkt_user_fromid where open_id='$openid' and id=(select max(id) from lkt_user_fromid where store_id = '$store_id' and open_id='$openid')";
        $fromidres = $db->select($fromidsql);
        if ($fromidres) {
            $fromid = $fromidres[0]->fromid;
            $arrayName = array('openid' => $openid, 'fromid' => $fromid);
            return $arrayName;
        } else {
            return array('openid' => $openid, 'fromid' => '123456');
        }


    }

    /**
     * 发送失败方法
     * @param $uid
     * @param $fromid
     * @param $sNo
     * @param $p_name
     * @param $price
     * @param $template_id
     * @param $page
     * @param $paytype
     */
    public function Send_fail($uid, $fromid, $sNo, $p_name, $price, $template_id, $page, $paytype)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret
            $AccessToken = $this->getAccessToken($appid, $appsecret);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;

        }
        $paytype = $paytype == "wxPay" ? "退回到微信" : '退回到钱包';
        $data = array();
        $data['access_token'] = $AccessToken;
        $data['touser'] = $uid;
        $data['template_id'] = $template_id;
        $data['form_id'] = $fromid;
        $data['page'] = $page;
        $price = $price . '元';
        $minidata = array('keyword1' => array('value' => $sNo, 'color' => "#173177"), 'keyword2' => array('value' => $p_name, 'color' => "#173177"), 'keyword3' => array('value' => $price, 'color' => "#173177"), 'keyword4' => array('value' => $paytype, 'color' => "#FF4500"), 'keyword5' => array('value' => '拼团失败--退款', 'color' => "#FF4500"));
        $data['data'] = $minidata;

        $data = json_encode($data);

        $da = $this->httpsRequest($url, $data);
        $delsql = "delete from lkt_user_fromid where open_id='$uid' and fromid='$fromid'";
        $db->delete($delsql);

    }
}

?>