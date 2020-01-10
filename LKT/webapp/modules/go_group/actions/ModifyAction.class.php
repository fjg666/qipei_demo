<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = addslashes(trim($request->getParameter('id'))); // 商品id
        $activity_no = addslashes(trim($request->getParameter('activity_no'))); // 活动id
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $product_class = $request->getParameter('cid'); // 分类名称
        $type = addslashes(trim($request->getParameter('type'))); // 用户id

        $sql = "select b.*,c.price,c.num,c.attribute,c.min_inventory,p.product_title 
                    from lkt_group_product as b 
                    left join lkt_configure as c on b.attr_id=c.id 
                    left join lkt_product_list as p on b.product_id=p.id 
                    where b.product_id=$id and b.store_id='$store_id' and b.is_delete = 0 and b.activity_no = $activity_no";
        $res = $db->select($sql);
        $msg = $res[0];
        $group_data = unserialize($msg->group_data);
        $group_level = unserialize($msg->group_level);
        $starttime = $res[0]->starttime;
        $endtime = $res[0]->endtime;
        $iscopy = 0;
        if (strtotime($starttime) <= 0 && strtotime($endtime) <= 0) {
            $iscopy = 1;
        }

        $g_status = $msg->g_status;
        $is_show = $msg->is_show;
        $firstkey = array_keys($group_level)[0];
        $lastset = reset($group_level);
        $lastset = explode('~', $lastset);
        $lastset[] = $firstkey;
        unset($group_level[$firstkey]);

        $levelstr = '';
        if (count($group_level) > 0) {
            foreach ($group_level as $k => $v) {
                $num = $k;
                $price = explode('~', $v);
                $levelstr .= '
                <div class="manlevel">
                <input type="number" max="50" min="1" class="input-text ct-rs" value="' . $num . '" name="min_man" style="width:60px;" onkeyup="onkeyup1(this)">&nbsp;&nbsp;人团&nbsp;&nbsp;<span style="margin-left:17px;">折扣价: 参团</span>
                <input type="number" class="input-text" value="' . $price[0] . '"  name="canprice" style="width:80px;margin-left:5px;" onkeyup="onkeyup1(this)">&nbsp;%<span style="margin-left: 5px;">开团</span>
                <input type="number" class="input-text" value="' . $price[1] . '"  name="memberprice" style="width:80px;margin-left:5px;" onkeyup="onkeyup1(this)">&nbsp;%';

                if ($g_status == 1) {
                    $levelstr .= ' <input class="btn btn-primary radius" type="button" onclick="removepro(event)" value="删除" style="margin-left:10px;height: 36px!important;">';
                }

                $levelstr .= '</div>';
            }
        }

        $prosql = "select b.num,b.min_inventory,a.attribute,a.price as prices ,MIN(a.price)as price,a.id as attr_id,b.id,b.product_title,b.imgurl,c.name 
                from lkt_configure as a 
                left join lkt_product_list as b on a.pid = b.id 
                left join lkt_mch as c on b.mch_id = c.id  
                where b.store_id = '$store_id' and c.store_id = '$store_id' and b.active = 2 and b.recycle = 0 and b.id = $id  group by b.id";
        $proattr = $db->select($prosql);
        if (!empty($proattr)) {
            foreach ($proattr as $k => $v) {
                $attrtype1 = unserialize($v->attribute);
                $attrtype1 = array_values($attrtype1);
                $attrtype1 = implode(',', $attrtype1);

                $proattr[$k]->attrtype = $attrtype1;
                $proattr[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
                //查询是否有这个属性
                $sel_hava_attr_sql = "select * from lkt_group_product where store_id = $store_id and attr_id = $v->attr_id";
                $sel_hava_attr_res = $db->select($sel_hava_attr_sql);
                if ($sel_hava_attr_res) {
                    $proattr[$k]->select = true;
                } else {
                    $proattr[$k]->select = false;
                }
            }
        }


        $sql01 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 ";
        $rr = $db->select($sql01);
        $res_ = '';
        foreach ($rr as $key => $value) {
            $c = '-' . $value->cid . '-';
            //判断所属类别 添加默认标签
            if ($product_class == $c) {
                $res_ .= '<option selected="selected" value="' . $c . '">' . $value->pname . '</option>';
            } else {
                $res_ .= '<option  value="' . $c . '">' . $value->pname . '</option>';
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
                        $res_ .= '<option selected="selected" value="' . $cone . '">' . $hx . $ve->pname . '</option>';
                    } else {
                        $res_ .= '<option  value="' . $cone . '">' . $hx . $ve->pname . '</option>';
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
                                $res_ .= '<option selected="selected" value="' . $ctow . '">' . $hxe . $v->pname . '</option>';
                            } else {
                                $res_ .= '<option  value="' . $ctow . '">' . $hxe . $v->pname . '</option>';
                            }
                        }
                    }
                }
            }
        }

        $brandsql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0";
        $brandres = $db->select($brandsql);
        $request->setAttribute("activity_no", $activity_no);
        $request->setAttribute("iscopy", $iscopy);
        $request->setAttribute("brandres", $brandres);
        $request->setAttribute("class", $res_);
        $request->setAttribute("group_data", $group_data);
        $request->setAttribute("g_status", $g_status);
        $request->setAttribute("is_show", $is_show);
        $request->setAttribute("list", $res);
        $request->setAttribute("proattr", $proattr);
        $request->setAttribute("lastset", $lastset);
        $request->setAttribute("levelstr", $levelstr);
        $request->setAttribute("goods_id", $id);
        return View :: INPUT;

    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $gdata = json_decode($request->getParameter('gdata'));
        $goods_id = $request->getParameter('goods_id');
        $glevel = $request->getParameter('glevel');
        $old_goods_id = $request->getParameter('old_goods_id');
        $g_status = $request->getParameter('g_status');
        $group_title = $request->getParameter('group_title');
        $activity_no = $request->getParameter('activity_no');
        $tuanZ = json_decode($request->getParameter('tuanZ'));


        $sel_attr_sql = "select c.id from lkt_configure as c
                        left join lkt_product_list as p on c.pid = p.id
                        where c.pid = $goods_id and p.store_id = $store_id";
        $attr_res = $db->select($sel_attr_sql);

        if ($gdata->endtime == 'changqi') {
            $gdata->endtime = date('Y-m-d H:i:s', strtotime("+1years", strtotime($gdata->starttime)));
        }
        $starttime = $gdata->starttime;
        $endtime = $gdata->endtime;

        //查询老活动与复制活动的活动时间有没有相交
//        $sql_gettime_sql = "select * from lkt_group_product where product_id = $goods_id and store_id = $store_id and activity_no != $activity_no and is_delete = 0";
        $sql_gettime_sql = "select * from lkt_group_product where product_id = $goods_id and store_id = $store_id   and starttime != '0000-00-00 00:00:00' and starttime != '0000-00-00 00:00:00' and activity_no != $activity_no and is_delete = 0 and (g_status = 1 || g_status = 2) GROUP by activity_no";

        $gettime_res = $db->select($sql_gettime_sql);

        if ($gettime_res) {
            foreach ($gettime_res as $k => $v) {
                if ((strtotime($v->starttime) < strtotime($endtime) && strtotime($v->endtime) > strtotime($starttime))) {
                    $db->rollback();
                    echo json_encode(array('code' => 2));
                    exit;
                }
            }
        }

        if ($group_title == '') {
            $goods_sql = "select product_title from lkt_product_list where id=$goods_id and store_id = $store_id";
            $goods_res = $db->select($goods_sql);
            $group_title = $goods_res[0]->product_title;
        }

        //查询进行中未开始中的是否有重复名称
        $sel_gods_sql = "select * 
        from lkt_group_product 
        where store_id = 1 and activity_no != '$activity_no' and is_delete = 0 and (g_status = 1 or g_status = 2) and group_title = '$group_title' GROUP by activity_no";
        $gods_res = $db->select($sel_gods_sql);
        if (!empty($gods_res)) {
            $db->rollback();
            echo json_encode(array('code' => 3));
            exit;
        }
        if ($g_status == 3) $g_status = 1;
        $gdata = serialize($gdata);
        $glevel = serialize($glevel);

        $time = date('Y-m-d H:i:s');
        $db->begin();

        //查询旧拼团活动的状态
        $selsql = "select * from lkt_group_product where product_id=$old_goods_id and store_id='$store_id' and activity_no = $activity_no and is_delete = 0";
        $selres = $db->select($selsql);
        $status = $selres[0]->g_status;
        $is_copy = $selres[0]->is_copy;
        $is_show = $selres[0]->is_show;
        //删除旧拼团活动
        $delsql = "delete from lkt_group_product where product_id=$old_goods_id and store_id='$store_id' and is_delete = 0 and activity_no = $activity_no";
        $delres = $db->delete($delsql);

        $str = '';
        $code = true;
        $lktlog = new LaiKeLogUtils("common/group.log");

        if ($delres > 0) {
            $str = 'insert into lkt_group_product(store_id,attr_id,product_id,group_level,group_data,group_title,g_status,is_show,starttime,endtime,activity_no,is_copy) values';
            foreach ($attr_res as $k => $v) {
                $attr_id = $v->id;
                $str .= "('$store_id',$attr_id,$goods_id,'$glevel','$gdata','$group_title','$status','$is_show','$starttime','$endtime','$activity_no',$is_copy),";
            }
            $str = substr($str, 0, strlen($str) - 1);
            $respro = $db->insert($str);

            if ($respro < 0) {
                $lktlog->customerLog(__METHOD__.":".__LINE__."修改拼团活动失败！sql：".$str);
                $db->rollback();
                echo json_encode(array('code' => 0));
                exit;
            } else {
                $lktlog->customerLog(__METHOD__.":".__LINE__."修改拼团活动成功！");
                $db->commit();
                echo json_encode(array('code' => 1));
                exit;
            }
        } else {
            $db->rollback();
            $code = false;
        }

        if ($code) {
            $db->commit();
            echo json_encode(array('code' => 1));
            exit;
        } else {
            $db->rollback();
            echo json_encode(array('code' => 0));
            exit;
        }


    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>