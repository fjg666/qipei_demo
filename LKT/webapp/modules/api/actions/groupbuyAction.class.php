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
require_once('Apimiddle.class.php');


class groupbuyAction extends Apimiddle
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = 'select m.*,l.product_title as pro_name from (select min(p.attr_id) as attr_id,product_id,p.group_price,p.group_id,c.img,c.price as market_price from lkt_group_product as p left join lkt_configure as c where p.store_id = \'' . $store_id . '\' and p.group_id=(select status from lkt_group_buy where is_show=1) group by p.product_id limit 8) as m left join lkt_product_list as l on m.product_id=l.id';
        $res = $db->select($sql);

        $sqltime = 'select man_num,endtime,status from lkt_group_buy where store_id = \'' . $store_id . '\' and is_show=1';
        $restime = $db->select($sqltime);
        if (!empty($restime)) {
            $endtime = date('Y-m-d H:i:s', $restime[0]->endtime);
            $g_man = $restime[0]->man_num;
            $gid = $restime[0]->status;
        }

        if (!empty($res)) {
            $groupid = $res[0]->group_id;
            $sqlsum = "select sum(m.num) as sum,m.p_id from (select o.num,d.p_id from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and o.pid='$groupid' and o.status>0) as m group by m.p_id";
            $ressum = $db->select($sqlsum);

            foreach ($res as $k => $v) {
                $v->sum = 0;
                $res[$k] = $v;
                $res[$k]->imgurl = ServerPath::getimgpath($v->image);
                if (!empty($ressum)) {
                    foreach ($ressum as $ke => $val) {
                        if ($val->p_id == $v->product_id) {
                            $res[$k]->sum = $val->sum;
                        }
                    }
                }

            }
            $banner = '';
            echo json_encode(array('code' => 1, 'banner' => $banner, 'list' => $res, 'endtime' => $endtime, 'groupman' => $g_man, 'groupid' => $gid));
            exit;
        }
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        
        $this->$m();
        return;
    }

    public function grouphome()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $paegr = trim($request->getParameter('page')); //  '页面'
        $select = trim($request->getParameter('select')); //  选中的方式 0 默认  1 销量   2价格
        if ($select == 0) {
            $select = 'p.id';
        } elseif ($select == 1) {
            $select = 's.sum';
        } else {
            $select = 'p.group_price';
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

        $sqltime = 'select * from lkt_group_buy where store_id = \'' . $store_id . '\' and is_show=1';
        $restime = $db->select($sqltime);
        
            

        $sql = "select w.*,l.product_title as pro_name from (select z.*,c.img as image,c.price as market_price from (select p.id,min(p.attr_id) as attr_id,p.product_id,p.group_price,p.group_data,s.sum from lkt_group_product as p left join (select sum(m.num) as sum,m.p_id from (select o.num,d.p_id from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and o.status>0) as m group by m.p_id) as s on p.product_id=s.p_id where p.store_id = '$store_id' and p.g_status=2 group by p.product_id order by $select$sort limit $start,$end) as z left join lkt_configure as c on z.attr_id=c.id) as w left join lkt_product_list as l on w.product_id=l.id where l.status=0";
        $res = $db->select($sql);
       if (!empty($res)) {
        foreach ($res as $k => $v) {
            $res[$k] = $v;
            $res[$k]->imgurl = ServerPath::getimgpath($v->image);
            if ($v->sum === null) $res[$k]->sum = 0;
        }
           
            echo json_encode(array('code' => 1, 'list' => $res));
            exit;
        } else {
            echo json_encode(array('code' => 0, 'list' => $res));
            exit;
        }
    }

    public function morepro()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $page = $request->getParameter('page');
        $groupid = addslashes(trim($request->getParameter('groupid')));

        $total = $page * 8;
        $sql = "select min(attr_id) as attr_id,product_id,group_price,group_id,pro_name,image,market_price from lkt_group_product where store_id = '$store_id' and group_id='$groupid' group by product_id limit $total,8";
        $res = $db->select($sql);


        if (!empty($res)) {
            $groupid = $res[0]->group_id;
            $sqlsum = "select sum(m.num) as sum,m.p_id from (select o.num,d.p_id from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and o.pid='$groupid' and o.status>0) as m group by m.p_id";
            $ressum = $db->select($sqlsum);

            foreach ($res as $k => $v) {
                $v->sum = 0;
                $res[$k] = $v;
                $res[$k]->imgurl = ServerPath::getimgpath($v->image);
                if (!empty($ressum)) {
                    foreach ($ressum as $ke => $val) {
                        if ($val->p_id == $v->product_id) {
                            $res[$k]->sum = $val->sum;
                        }
                    }
                }
            }
            echo json_encode(array('code' => 1, 'list' => $res));
            exit;
        } else {
            echo json_encode(array('code' => 0, 'list' => $res));
            exit;
        }
    }

    public function getgoodsdetail()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $gid = addslashes(trim($request->getParameter('gid')));
        $user_id = addslashes(trim($request->getParameter('userid')));

        $guigesql = 'select m.*,c.num,c.img as image,c.price as market_price from (select min(g.attr_id) as attr_id,g.product_id,g.group_price,g.member_price,g.group_data,l.product_title as pro_name,l.content,l.status from lkt_group_product as g left join lkt_product_list as l on g.product_id=l.id where g.store_id = \'' . $store_id . '\' and g.product_id=' . $gid . ') as m left join lkt_configure as c on m.attr_id=c.id';
        $guigeres = $db->select($guigesql);
        list($guigeres) = $guigeres;
        
        $content = $guigeres->content;
        $contres = unserialize($guigeres -> group_data);

        $imgsql = 'select product_url from lkt_product_img where product_id=' . $gid;
        $imgres = $db->select($imgsql);

        $imgarr = [];

        if (!empty($imgres)) {
            foreach ($imgres as $k => $v) {
                $imgarr[$k] = ServerPath::getimgpath($v->product_url);
            }
            $guigeres->image = ServerPath::getimgpath($guigeres->image);
            $guigeres->images = $imgarr;
        } else {
            $guigeres->image = ServerPath::getimgpath($guigeres->image);
            $imgarr[0] = $guigeres->image;
            $guigeres->images = $imgarr;
        }
        

        $commodityAttr = [];
        $sql_size = "select g.attr_id,g.product_id,g.group_price,g.member_price,p.attribute,p.num,p.price,p.yprice,p.img,p.id from lkt_group_product as g left join lkt_configure as p on g.attr_id=p.id where g.store_id = '$store_id' and g.product_id = '$gid'";
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

                $skuBeanList[$key] = array('name' => $name, 'imgurl' => $cimgurl, 'cid' => $value->id, 'member_price' => $value->member_price, 'price' => $value->price, 'count' => $value->num, 'attributes' => $attributes);


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


        //查询此商品评价记录
        $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.size,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id where m.store_id = '$store_id' and a.pid = '$gid' and m.wx_id != '' limit 2";
        $r_c = $db->select($sql_c);
        $arr = [];

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
            $goodsql = "select count(*) as num from lkt_comments where (store_id = '$store_id' and pid='$gid' and CommentType='GOOD') or (store_id = '$store_id' and pid='$gid' and CommentType=5) or (pid='$gid' and CommentType=4)";
            $goodnum = $db->select($goodsql);
            $com_num = array();
            $com_num['good'] = $goodnum[0]->num;
            $badsql = "select count(*) as num from lkt_comments where (store_id = '$store_id' and pid='$gid' and CommentType='BAD') or (store_id = '$store_id' and pid='$gid' and CommentType=3)";
            $badnum = $db->select($badsql);
            $com_num['bad'] = $badnum[0]->num;
            $notbadsql = "select count(*) as num from lkt_comments where (store_id = '$store_id' and pid='$gid' and CommentType='NOTBAD') or (store_id = '$store_id' and pid='$gid' and CommentType=2) or (pid='$gid' and CommentType=1)";
            $notbadnum = $db->select($notbadsql);
            $com_num['notbad'] = $notbadnum[0]->num;
        } else {
            $com_num = array('bad' => 0, 'good' => 0, 'notbad' => 0);
        }

        $sql_kt = "select g.ptcode,g.ptnumber,g.endtime,u.user_name,u.headimgurl from lkt_group_open as g left join lkt_user as u on g.uid=u.user_id where g.store_id = '$store_id' and g.ptgoods_id=$gid and g.ptstatus=1 and u.store_id = '$store_id' and EXISTS(select * from lkt_order as o where o.ptcode=g.ptcode and o.status!=6)";
        $res_kt = $db->select($sql_kt);
        
        $groupList = [];
        if (!empty($res_kt)) {
            foreach ($res_kt as $key => $value) {
                $res_kt[$key]->leftTime = strtotime($value->endtime) - time();
                if (strtotime($value->endtime) - time() > 0) {
                    array_push($groupList, $res_kt[$key]);
                }
            }
        }

        $plugsql = "select status from lkt_plug_ins where store_id = '$store_id' and type = 0 and software_id = 3 and name like '%拼团%'";
        $plugopen = $db->select($plugsql);
        $plugopen = !empty($plugopen) ? $plugopen[0]->status : 0;

        $share = array('friends' => true, 'friend' => false);
        echo json_encode(array('control' => $contres, 'share' => $share, 'detail' => $guigeres, 'attrList' => $attrList, 'skuBeanList' => $skuBeanList, 'comments' => $arr, 'comnum' => $com_num, 'groupList' => $groupList, 'isplug' => $plugopen));
        exit;
    }

    public function getcomment()
    {           //store_id
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $pid = intval($request->getParameter('pid'));
        $page = intval($request->getParameter('page'));
        $checked = intval($request->getParameter('checked'));

        $page = $page * 8;

        $condition = '';
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
        $arr = [];
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

            echo json_encode(array('comment' => $arr));
            exit;
        } else {
            echo json_encode(array('comment' => false));
            exit;
        }
    }

    public function getFormid()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $uid = addslashes(trim($request->getParameter('userid')));
        $formid = addslashes(trim($request->getParameter('from_id')));

        $fromidsql = "select count(*) as have from lkt_user_fromid where store_id = '$store_id' and open_id='$uid'";
        $fromres = $db->select($fromidsql);
        $fromres = intval($fromres[0]->have);
        $lifetime = date('Y-m-d H:i:s', time() + 7 * 24 * 3600);
        if ($formid != 'the formId is a mock one') {
            if ($fromres < 12) {
                $addsql = "insert into lkt_user_fromid(store_id,open_id,fromid,lifetime) values('$store_id','$uid','$formid','$lifetime')";
                $addres = $db->insert($addsql);
            } else {
                return false;
            }
        }

    }

    public function payfor()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $uid = addslashes(trim($request->getParameter('uid')));
        $oid = addslashes(trim($request->getParameter('oid')));
        $sizeid = intval(trim($request->getParameter('sizeid')));
        $pronum = intval(trim($request->getParameter('pronum')));

        // 根据用户id,查询收货地址
        $sql_a = 'select id from lkt_user_address where store_id = \'' . $store_id . '\' and uid=(select user_id from lkt_user where store_id = \'' . $store_id . '\' and wx_id="' . $uid . '")';
        $r_a = $db->select($sql_a);
        if ($r_a) {
            $arr['addemt'] = 0; // 有收货地址
            // 根据用户id、默认地址,查询收货地址信息
            $sql_e = 'select * from lkt_user_address where store_id = \'' . $store_id . '\' and uid=(select user_id from lkt_user where store_id = \'' . $store_id . '\' and wx_id="' . $uid . '") and is_default = 1';
            $r_e = $db->select($sql_e);
            //$r_e = (array)$r_e['0'];
            $r_e = !empty($r_e) ? (array)$r_e['0'] : array(); // 收货地址
            $arr['adds'] = $r_e;
        } else {
            $arr['addemt'] = 1; // 没有收货地址
            $arr['adds'] = ''; // 收货地址
            $r_e = array();
        }
   
        $attrsql = "select m.*,l.product_title as pro_name,l.freight from (select c.attribute,c.img as image,g.product_id,g.group_price,g.member_price,g.group_data,c.num from lkt_group_product as g left join lkt_configure as c on g.attr_id=c.id where g.store_id = '$store_id' and g.attr_id=$sizeid) as m left join lkt_product_list as l on m.product_id=l.id";
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

        $moneysql = 'select user_id,user_name,money from lkt_user where store_id = \'' . $store_id . '\' and wx_id="' . $uid . '"';
        $moneyres = $db->select($moneysql);

        if (!empty($moneyres)) {
            list($moneyres) = $moneyres;
            $money = $moneyres->money;
            $user_name = $moneyres->user_name;
            $userid = $moneyres->user_id;
        }
        $selfsql = "select count(*) as isset from lkt_order where store_id = '$store_id' and user_id='$userid' and ptcode='$oid'";
        $is_self = $db->select($selfsql);
        $is_self = $is_self[0]->isset;

        $havesql = "select count(*) as have from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and o.user_id='$userid' and o.status=9 and d.p_id=$attrres->product_id";
        $haveres = $db->select($havesql);
        
        if (!empty($haveres)) {
            $have = $haveres[0]->have;
        }
        $attrres->have = $have;
        //计算运费
        $yunfei = $this->freight($attrres->freight, $pronum, $r_e);
        
        echo json_encode(array('is_add' => $arr['addemt'], 'buymsg' => $arr['adds'], 'proattr' => $attrres, 'money' => $money, 'user_name' => $user_name, 'groupres' => $groupres, 'isself' => $is_self,'yunfei' => $yunfei));
        exit;

    }

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


    public function createGroup()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $uid = addslashes(trim($request->getParameter('uid')));
        $form_id = addslashes(trim($request->getParameter('fromid')));
        $pro_id = intval(trim($request->getParameter('pro_id')));
        $man_num = intval(trim($request->getParameter('man_num')));
        $time_over = addslashes(trim($request->getParameter('time_over')));
        $sizeid = intval(trim($request->getParameter('sizeid')));
        
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

        $db->begin();
        $group_num = 'KT' . substr(time(), 5) . mt_rand(10000, 99999);

        $creattime = date('Y-m-d H:i:s');
        
        $grouptime = $db -> select("select group_data from lkt_group_product where attr_id=$sizeid and store_id = '$store_id'");
        $grouptime = unserialize($grouptime[0] -> group_data);
        $endtime = $grouptime -> endtime;
        $time_over = ($time_over * 3600 + time()) > strtotime($endtime)?strtotime($endtime):($time_over * 3600 + time());
        $time_over = date('Y-m-d H:i:s', $time_over);

        $pro_size = $db->select("select attribute,num from lkt_configure where id=$sizeid");
        $pro_size = unserialize($pro_size[0] -> attribute);
        $pro_size = implode(',',array_values($pro_size));

        $user_id = $db->select("select user_id,money from lkt_user where store_id = '$store_id' and wx_id='$uid'");
        $uid = $user_id[0]->user_id;
        $money = $user_id[0]->money;

        $code = true;
        $istsql1 = "insert into lkt_group_open(store_id,uid,ptgoods_id,ptcode,ptnumber,addtime,endtime,ptstatus) values('$store_id','$uid',$pro_id,'$group_num',1,'$creattime','$time_over',$status)";
        $res1 = $db->insert($istsql1);

        if ($res1 < 1) {
            $code = false;
        }

        $ordernum = 'PT' . mt_rand(10000, 99999) . date('Ymd') . substr(time(), 5);
        $istsql2 = "insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,pay,add_time,status,otype,ptcode,ptstatus,trade_no) values('$store_id','$uid','$name','$tel',$buy_num,$price,'$ordernum',$sheng,$shi,$quyu,'$address','$paytype','$creattime',$ordstatus,'pt','$group_num',$status,'$trade_no')";
        $res2 = $db->insert($istsql2);

        if ($res2 < 1) {
            $code = false;
        }

        $istsql3 = "insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,r_sNo,add_time,r_status,size,sid,freight) values('$store_id','$uid',$pro_id,'$pro_name',$y_price,$buy_num,'$ordernum','$creattime',-1,'$pro_size',$sizeid,'$yunfei')";
        //var_dump($istsql3);
        $res3 = $db->insert($istsql3);
        if ($res3 < 1) {
            $code = false;       
        }

        $updres = $db->update("update lkt_configure set num=num-$buy_num where id=$sizeid");
        if ($updres < 1) {
            $code = false;
        }

        if ($code) {
            $db->commit();
            $idres = $db->select("select id from lkt_order where store_id = '$store_id' and sNo='$ordernum'");
            if (!empty($idres)) $idres = $idres[0]->id;
            echo json_encode(array('order' => $ordernum, 'gcode' => $group_num, 'group_num' => $group_num, 'id' => $idres, 'code' => 1));
            exit;
        } else {
            $db-> rollback();
            $bere = $db -> update("update lkt_user set money=money+$price where user_id='$uid' and store_id = '$store_id'");
            $event = $uid . '退回拼团订单款' . $price . '元';
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
            $rr = $db->insert($sqll);
            echo json_encode(array('code' => 0));
            exit;
        }


    }

    public function cangroup()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $oid = addslashes(trim($request->getParameter('oid')));
        $gid = addslashes(trim($request->getParameter('gid')));
        $user_id = addslashes(trim($request->getParameter('userid')));

        $groupmsg = $db->select("select uid,ptgoods_id,endtime,ptstatus,ptnumber from lkt_group_open where store_id = '$store_id' and ptcode='$oid'");

        $userid = $db->select("select user_id from lkt_user where store_id = '$store_id' and wx_id='$user_id'");
        $userid = $userid[0]->user_id;
        $isrecd = $db->select("select count(*) as recd from lkt_order where store_id = '$store_id' and ptcode='$oid' and user_id='$userid'");
        $recd = $isrecd[0]->recd;

        if ($recd > 0) {
            $sql = "select m.*,d.p_name,d.p_price,d.sid from (select k.ptgoods_id,k.ptnumber,k.addtime as cantime,k.endtime,k.ptstatus,p.name,p.num,p.sNo,p.sheng,p.shi,p.xian,p.address,p.mobile,p.status from lkt_group_open as k right join lkt_order as p on k.ptcode=p.ptcode where p.store_id = '$store_id' and p.ptcode='$oid' and p.user_id='$userid') as m left join lkt_order_details as d on m.sNo=d.r_sNo";
            $res = $db->select($sql);
            
            if ($res) {               
                $ptgoods_id = $res[0]->ptgoods_id;   
                $res = $res[0];

                $image = $db->select("select img,yprice from lkt_configure where id=$res->sid");

                $res->img = ServerPath::getimgpath($image[0]->img);
                $res->yprice = $image[0]->yprice;
                //$res->p_price = $aa[0]->gprice;
            } else {
                $res = (object)array();
            }
            $res->isSelf = true;
        } else {
            $res = $groupmsg[0];
            $goodsql = "select z.*,l.product_title as pro_name from (select m.*,c.num,c.img as image,c.yprice from (select min(group_price) as gprice,attr_id,product_id from lkt_group_product where store_id = '$store_id' and product_id=$res->ptgoods_id) as m left join lkt_configure as c on m.attr_id=c.id) as z left join lkt_product_list as l on z.product_id=l.id";
            $goods = $db->select($goodsql);
            $res->p_name = $goods[0]->pro_name;
            $res->p_price = $goods[0]->gprice;

            $res->yprice = $goods[0]->yprice;
            $res->img = ServerPath::getimgpath($goods[0]->image);
            $res->p_num = $goods[0]->num;
            $res->isSelf = false;
        }
        
        $memsql = "select i.user_id,u.headimgurl from lkt_order as i left join lkt_user as u on i.user_id=u.user_id where u.store_id = '$store_id' and i.ptcode='$oid' order by i.id asc";
        $groupmember = $db->select($memsql);
        
        $group_data = $db -> select("select min(attr_id),group_data from lkt_group_product where product_id=$gid");
        $group_data = unserialize($group_data[0] -> group_data);
        
            $res->group_data = $group_data;
            $res->groupmember = $groupmember;
            $sumsql = "select count(m.sNo) as sum from (select o.sNo from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and d.p_id='$res->ptgoods_id') as m";
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

            $sql_size = "select g.attr_id,g.product_id,g.group_price as price,g.member_price,p.attribute,p.num,p.img,p.yprice,p.id from lkt_group_product as g left join lkt_configure as p on g.attr_id=p.id where g.store_id = '$store_id' and g.product_id = '$gid'";
            $r_size = $db->select($sql_size);
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

            $plugsql = "select status from lkt_plug_ins where store_id = '$store_id' and type = 0 and name like '%拼团%'";
            $plugopen = $db->select($plugsql);
            $plugopen = !empty($plugopen) ? $plugopen[0]->status : 0;

            $goodssql = "select g.g_status,p.status from lkt_group_product as g right join lkt_product_list as p on g.product_id=p.id where p.id=$gid";
            $goodscode = $db -> select($goodssql);
            $goodscode = $goodscode[0];

            echo json_encode(array('groupmsg' => $res, 'groupMember' => $groupmember, 'skuBeanList' => $skuBeanList, 'attrList' => $attrList, 'isplug' => $plugopen,'goodscode' => $goodscode));
            exit;
        


    }

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

        $creattime = date('Y-m-d H:i:s');
        $pro_size = $db->select("select name,color,size from lkt_configure where id=$sizeid");
        $pro_size = $pro_size[0]->name . $pro_size[0]->color . $pro_size[0]->size;
        $selsql = "select ptnumber,ptstatus,endtime from lkt_group_open where store_id = '$store_id' and ptcode='$oid'";
        $selres = $db->select($selsql);

        if (!empty($selres)) {
            $ptnumber = $selres[0]->ptnumber;
            $ptstatus = $selres[0]->ptstatus;
            $endtime = strtotime($selres[0]->endtime);
        }
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
                    $updres1 = $db->update("update lkt_configure set num=num-$buy_num where id=$sizeid");
                    if ($updres < 1 || $updres1 < 1) {
                        $code = false;
                    }
                }else{
                    $code = false;
                }

                 if($code){
                    $db->commit();
                    $idres = $db->select("select id from lkt_order where store_id = '$store_id' and sNo='$ordernum'");
                    if (!empty($idres)) $idres = $idres[0]->id;
                    echo json_encode(array('order' => $ordernum, 'gcode' => $oid, 'group_num' => $oid, 'ptnumber' => $ptnumber, 'id' => $idres, 'endtime' => $endtime, 'code' => 1));exit;
                  }else{
                    $db-> rollback();
                    $bere = $db -> update("update lkt_user set money=money+$price where user_id='$uid' and store_id = '$store_id'");
                    $event = $uid . '退回拼团订单款' . $price . '元';
                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
                    $rr = $db->insert($sqll);
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
                    $updres2 = $db->update("update lkt_order set ptstatus=2,status=1 where store_id = '$store_id' and ptcode='$oid' and status!=6");   
                    $updres3 = $db->update("update lkt_configure set num=num-$buy_num where id=$sizeid");
                    if ($updres1 < 1 || $updres2 < 1 || $updres3 < 1) {
                        $code = false;
                    }
                }else{
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
                      if(!empty($fromidres)){
                        foreach ($fromidres as $ke => $val) {
                            if ($val->open_id == $v->uid) {
                                $msgres[$k]->fromid = $val->fromid;
                            }
                        }
                      }else{
                         $msgres[$k]->fromid = '';
                      }
                    }
                    $this->Send_success($msgres, date('Y-m-d H:i:s', time()), $template_id, $pro_name);    
                    echo json_encode(array('order' => $msgres, 'gcode' => $oid, 'code' => 2));
                    exit;
                }else{
                    $db-> rollback();
                    $bere = $db -> update("update lkt_user set money=money+$price where user_id='$uid' and store_id = '$store_id'");
                    $event = $uid . '退回拼团订单款' . $price . '元';
                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
                    $rr = $db->insert($sqll);
                    echo json_encode(array('code' => 0));
                    exit;
                }
            } else if ($ptnumber == $man_num) {
                $updres = $db->update("update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$uid'");
                if ($updres < 1) {
                    $code = false;
                }
                $event = $uid . '退回拼团订单款' . $price . '元';
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
                $rr = $db->insert($sqll);
                if($code){                     //如果批量执行没出错则提交，否则就回滚
                     $db->commit();
                }else{
                     $db->rollback();
                }
                echo json_encode(array('code' => 3));
                exit;
            }

        } else {
            $updres = $db->update("update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$uid'");
            if ($updres < 1) {
                $code = false;
            }
            $event = $uid . '退回拼团订单款' . $price . '元';
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$uid','$price','$money','$event',5)";
            $rr = $db->insert($sqll);
            if($code){                     //如果批量执行没出错则提交，否则就回滚
                 $db->commit();
            }else{
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
        
        $updsql = "update lkt_order set status=3 where store_id = '$store_id' and sNo='$oid'";
        $updres = $db->update($updsql);

        if ($updres > 0) {
            echo json_encode(array('code' => 1));
            exit;
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
        // $oid = trim($request->getParameter('oid'));
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

    /*

   * 发送请求

   　@param $ordersNo string 订单号　

     @param $refund string 退款单号

     @param $price float 退款金额

     return array

   */

    /*
   * 发送请求
   @param $ordersNo string 订单号　
   @param $refund string 退款单号
   @param $price float 退款金额
   return array
   */
    private function wxrefundapi($ordersNo, $refund, $total_fee, $price)
    {
        //通过微信api进行退款流程
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select mch_id from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
             $mch_id = $r[0]->mch_id; // 商户mch_id

            require_once(MO_LIB_DIR . '/WxPayPubHelper/'.$mch_id.'_WxPay.pub.config.php');
            $this->SSLCERT_PATH = WxPayConf_pub::SSLCERT_PATH;
            $this->SSLKEY_PATH = WxPayConf_pub::SSLKEY_PATH;
            $this->APPID = WxPayConf_pub::APPID;
            $this->MCHID = WxPayConf_pub::MCHID;
            $this->APPSECRET = WxPayConf_pub::APPSECRET;
            $this->KEY = WxPayConf_pub::KEY;

            $appid = WxPayConf_pub::APPID;
            $appsecret = WxPayConf_pub::APPSECRET;
            $mch_key = WxPayConf_pub::KEY;
           
        }

        require_once(MO_LIB_DIR . '/WxPayPubHelper/'.$mch_id.'_WxPay.pub.config.php');
        $this->cert = WxPayConf_pub::SSLCERT_PATH;
        $this->key = WxPayConf_pub::SSLKEY_PATH;

        $parma = array('appid' => $appid, 'mch_id' => $mch_id, 'nonce_str' => $this->createNoncestr(), 'out_refund_no' => $refund, 'out_trade_no' => $ordersNo, 'total_fee' => $total_fee, 'refund_fee' => $price, 'op_user_id' => $appid);

        $parma['sign'] = $this->getSign($parma, $mch_key);
        $xmldata = $this->arrayToXml($parma);
        
        $xmlresult = $this->postXmlSSLCurl($xmldata, 'https://api.mch.weixin.qq.com/secapi/pay/refund');
        $result = $this->xmlToArray($xmlresult);

        return $result;
    }

    /*
     * 生成随机字符串方法
     */
    protected function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /*
     * 对要发送到微信统一下单接口的数据进行签名
     */
    protected function getSign($Obj, $mch_key)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $mch_key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    /*
     *排序并格式化参数方法，签名时需要使用
     */
    protected function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    //数组转字符串方法
    protected function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    protected function xmlToArray($xml)
    {
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

    //需要使用证书的请求
    private function postXmlSSLCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        
        // $cert = str_replace('lib', 'filter', MO_LIB_DIR) . '/apiclient_cert.pem';
        // $key = str_replace('lib', 'filter', MO_LIB_DIR) . '/apiclient_key.pem';
        
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, $this->SSLCERT_PATH);
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, $this->SSLKEY_PATH);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
            curl_close($ch);
            return false;
        }
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    //临时存放微信付款信息
    public function up_out_trade_no()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = trim($request->getParameter('store_id'));
        $pagefrom = trim($request->getParameter('pagefrom'));
        $uid = addslashes(trim($request->getParameter('uid')));
        $oid = addslashes(trim($request->getParameter('oid')));
        $form_id = addslashes(trim($request->getParameter('fromid')));
        $pro_id = intval(trim($request->getParameter('pro_id')));
        $man_num = intval(trim($request->getParameter('man_num')));
        $sizeid = intval(trim($request->getParameter('sizeid')));
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
        $time_over = addslashes(trim($request->getParameter('time_over')));
        $yunfei = (float)(trim($request->getParameter('yunfei')));
        $ordstatus = $status == 1 ? 9 : 0;
        $user_id = $db->select("select user_id from lkt_user where store_id = '$store_id' and wx_id='$uid'");
        $uid = $user_id[0]->user_id;

        if ($pagefrom == 'kaituan') {
            $array = array('store_id' => $store_id, 'uid' => $uid, 'form_id' => $form_id, 'oid' => $oid, 'pro_id' => $pro_id, 'sizeid' => $sizeid, 'man_num' => $man_num, 'pro_name' => $pro_name, 'price' => $price, 'y_price' => $y_price, 'name' => $name, 'sheng' => $sheng, 'shi' => $shi, 'quyu' => $quyu, 'address' => $address, 'tel' => $tel, 'lack' => $lack, 'buy_num' => $buy_num, 'paytype' => $paytype, 'trade_no' => $trade_no, 'status' => $status, 'ordstatus' => $ordstatus, 'time_over' => $time_over, 'pagefrom' => $pagefrom,'yunfei' => $yunfei);
        } else {
            $array = array('store_id' => $store_id, 'uid' => $uid, 'form_id' => $form_id, 'oid' => $oid, 'pro_id' => $pro_id, 'sizeid' => $sizeid, 'man_num' => $man_num, 'pro_name' => $pro_name, 'price' => $price, 'y_price' => $y_price, 'name' => $name, 'sheng' => $sheng, 'shi' => $shi, 'quyu' => $quyu, 'address' => $address, 'tel' => $tel, 'lack' => $lack, 'buy_num' => $buy_num, 'paytype' => $paytype, 'trade_no' => $trade_no, 'status' => $status, 'ordstatus' => $ordstatus, 'pagefrom' => $pagefrom,'yunfei' => $yunfei);
        }
        

        $data = serialize($array);

        $sql = "insert into lkt_order_data(trade_no,data,addtime) values('$trade_no','$data',CURRENT_TIMESTAMP)";
        $rid = $db->insert($sql);

        $yesterday = date("Y-m-d", strtotime("-1 day"));
        $sql = "delete from lkt_order_data where addtime < '$yesterday'";
        $db->delete($sql);

        echo json_encode(array('data' => $array));
        exit();
    }

    public function verification()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $trade_no = addslashes(trim($request->getParameter('trade_no')));
        $sql = "select id,sNo,ptcode from lkt_order where store_id = '$store_id' and trade_no='$trade_no'";
        $gmsg = $db->select($sql);
        
        if(!empty($gmsg)){
            echo json_encode(array('status' => 1, 'data' => $gmsg[0]));
            exit();
        } else {
            echo json_encode(array('status' => 0));
            exit();
        }
    }

    public function removeOrder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = $request->getParameter('openid');
        $id = $request->getParameter('id');

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
        if($status != 6){
        $db->begin();
        $sql = "update lkt_order set status=6 where store_id = '$store_id' and id=$id";
        $updres = $db->update($sql);

        if ($updres < 0) {
            $db->rollback();
            echo json_encode(array('code' => 0, 'err' => '取消失败'));
            exit;
        }
        if ($paytype == 'wallet_Pay' || $paytype == 'combined_Pay') {    //余额支付或者组合支付
            $updsql1 = "update lkt_user set money=money+$price where store_id = '$store_id' and user_id='$user_id'";
            $updres1 = $db->update($updsql1);
            
            $event = $user_id . '退回拼团订单款' . $price . '元--订单号:' . $sNo;
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$price','$money','$event',5)";
            $rr = $db->insert($sqll);
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

        $updres = $db->update("update lkt_configure set num=num+$num where id=$sid");
        if ($updres < 0) {
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
      }else{
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