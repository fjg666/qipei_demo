<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class IndexAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $proname = $request->getParameter("proname"); // 商品名字
        $username = $request->getParameter("username"); // 用户名字
        $group_status = $request->getParameter("group_status"); // 活动状态
        $group_num = $request->getParameter("group_num"); // 拼团人数
        $status = trim($request->getParameter('status'));
        $pagesize = $request->getParameter('pagesize');
        $activity_no = $request->getParameter('activity_no');
        $pagesize = $pagesize ? $pagesize : 10;
        // 每页显示多少条数据
        $page = $request->getParameter('page');

        $pageto = $request->getParameter('pageto');   // 导出

        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }
        $whereStr = '';
        //如果名字不为空
        if ($proname != '') {
            $whereStr .= " and p_name LIKE '%$proname%' ";
        }
        //如果商品名字不为空
        if ($username != '') {
            $whereStr .= " AND user_name LIKE '%$username%' ";
        }
        //如果活动状态不为空
        if ($group_status != '' && $group_status != '#') {
            $whereStr .= " AND g.ptstatus = $group_status";
        }

        //如果拼团人数不为空
        if ($group_num != '') {
            $whereStr .= " AND g.groupman = $group_num ";
        }

        //删除没有设定时间的拼团活动

        $up_sql00 = "UPDATE `lkt_group_product` SET `is_delete`= 1 WHERE starttime = '0000-00-00 00:00:00' or endtime = '0000-00-00 00:00:00'";
        $upres = $db->update($up_sql00);

        //如果是查看订单
        if ($status > 3) {
            if ($status == 4) {
                if($pageto == 'whole') { // 导出全部
                    $whereStr = "";
                    $page_limit = "";
                }else if($pageto == 'inquiry'){//导出查询
                    $page_limit = "";
                }else if($pageto == 'This_page'){//导出本页
                    $page_limit = "$start,$pagesize";
                }else{
                    $page_limit = "$start,$pagesize";
                }

                if(!empty($activity_no)){
                    $whereStr .= "and g.activity_no = $activity_no";
                }

                //查询开团记录
                $type = 'record';
                $sql = "SELECT u.user_name,d.p_name,d.p_id as goods_id,d.sid as attr_id,o.* ,g.ptstatus as pt_status,gp.group_title
                    from lkt_order as o
                    LEFT JOIN lkt_user as u on o.user_id = u.user_id
                    LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
                    LEFT JOIN lkt_group_open as g on o.ptcode = g.ptcode
                    LEFT JOIN lkt_group_product as gp on gp.product_id = d.p_id and gp.activity_no = g.activity_no
                    where o.pid = 'kaituan' and o.store_id = '$store_id' and gp.is_delete = 0  and  o.ptcode!= '' $whereStr 
                    group  by o.id
                    ORDER BY add_time DESC limit 
                    $page_limit";
                $sql1 = "SELECT u.user_name,d.p_name,d.p_id as goods_id,d.sid as attr_id,o.* 
                    from lkt_order as o
                    LEFT JOIN lkt_user as u on o.user_id = u.user_id
                    LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
                    LEFT JOIN lkt_group_open as g on o.ptcode = g.ptcode
                    LEFT JOIN lkt_group_product as gp on gp.product_id = d.p_id and gp.activity_no = g.activity_no
                    where o.pid = 'kaituan' and o.store_id = '$store_id' and gp.is_delete = 0 and  o.ptcode!= '' $whereStr 
                    group  by o.id";
            } else {
                //查询参团记录
                $type = 'canrecord';
                $sql = "SELECT u.user_name,d.p_name,d.p_id as goods_id,d.sid as attr_id,o.* ,gp.group_title
                    from lkt_order as o
                    LEFT JOIN lkt_user as u on o.user_id = u.user_id
                    LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
                    LEFT JOIN lkt_group_open as goo on goo.ptcode = o.ptcode
                    LEFT JOIN lkt_group_product as gp on gp.product_id = d.p_id and gp.activity_no = goo.activity_no
                    where o.pid = 'cantuan' and o.store_id = '$store_id' and gp.is_delete = 0  and  o.ptcode!= '' $whereStr
                    group  by o.id
                    ORDER BY add_time DESC limit $start,$pagesize";
                $sql1 = "SELECT u.user_name,d.p_name,d.p_id as goods_id,d.sid as attr_id,o.* 
                    from lkt_order as o
                    LEFT JOIN lkt_user as u on o.user_id = u.user_id
                    LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
                    LEFT JOIN lkt_group_open as goo on goo.ptcode = o.ptcode
                    LEFT JOIN lkt_group_product as gp on gp.product_id = d.p_id and gp.activity_no = goo.activity_no
                    where o.pid = 'cantuan' and o.store_id = '$store_id' and gp.is_delete = 0 and  o.ptcode!= '' $whereStr
                    group  by o.id
                    ORDER BY add_time DESC";
            }
            //查出分页数据
            $res = $db->select($sql);
            //查出所有数据
            $res_all = $db->select($sql1);


            //查询拼团所有人数
            $sel_group_man = "SELECT * FROM lkt_group_open WHERE 1 and store_id = $store_id group by groupman";
            $group_man_res = $db->select($sel_group_man);
            $man_arr = array();
            foreach ($group_man_res as $k => $v){

                    $man_arr[count($man_arr)] = $v->groupman;

            }
            //查询拼团时限
            $cfg_sql = "select * from lkt_group_config where store_id = $store_id";
            $cfg_res = $db->select($cfg_sql);
            if (!empty($cfg_res[0]->group_time)) {
//            如果有拼团时限
                $group_time = $cfg_res[0]->group_time;
            } else {
//            如果没有拼团时限
                $group_time = 10;
            }
            if ($res) {
                foreach ($res as $k => $v) {
//                查询商品属性
                    $sql = "SELECT price,img from lkt_configure where id = $v->attr_id";
                    $c_res = $db->select($sql);
                    $v->price = $c_res[0]->price;
                    $v->imgurl = ServerPath::getimgpath($c_res[0]->img, $store_id);
                    $add_time_ = strtotime($v->add_time);
                    $v->pt_end_time = date('Y-m-d H:i:s', $add_time_ + $group_time * 3600);
                    //查询拼团配置
                    $sql = "select * from lkt_group_open where store_id = $store_id and ptcode = '$v->ptcode'";
                    $gp_res = $db->select($sql);
                    if (!empty($gp_res[0]->group_level)) {
                        $biliArr = unserialize($gp_res[0]->group_level);
                    } else {
                        $ptcode = $v->ptcode;
                        $sql = "SELECT * from lkt_group_open where ptcode = '$ptcode'";
                        $group_level = $db->select($sql);
                        $biliArr = unserialize($group_level[0]->group_level);
                    }

                    $groupman = $v->groupman;//参团人数
                    $v->openmoney = 0;
//                   如果这个参团比例参数中有这个团的参团比例
                    if (!empty($biliArr[$groupman])) {

                        $KC_arr = explode("~", $biliArr[$groupman]);
                        $v->openmoney = round(($KC_arr[1] * $v->price) / 100,2);//开团 人价格
                        $v->canmoney = round($KC_arr[0] * $v->price / 100,2);//参团 人价格
                        $cfg = unserialize($gp_res[0]->group_data);
                        $v->start_time = $cfg->starttime;
                        $v->end_time = $cfg->endtime;
                        $start_time = strtotime($v->start_time);
                        $end_time = strtotime($v->end_time);
                        if (time() < $start_time) {
                            $v->group_status = 0;
                        } else if (time() > $start_time && time() < $end_time) {
                            $v->group_status = 1;
                        } else if (time() > $end_time) {
                            $v->group_status = 2;
                        }
                    } else {
                        //如果没有,则设为空 和默认值
                        $v->openmoney = 0;//开团 人价格
                        $v->canmoney = 0;//参团 人价格
                        $v->start_time = '';
                        $v->end_time = '';
                    }
                }
            }
            //计算总条数
            $total = count($res_all);
            //获取分页
            $pager = new ShowPager($total, $pagesize, $page);
            $url = "index.php?module=go_group&status=$status&proname=$proname&username=$username&group_num=$group_num&group_status=$group_status&action=Index&status=" . $status . "&proname=" . urlencode($proname) . "&pagesize=" . urlencode($pagesize);
            $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');
            //传递渲染数据
            $request->setAttribute("list", $res);
            $request -> setAttribute('pageto', $pageto);
            $request->setAttribute("man_arr", $man_arr);
            $request->setAttribute("type", $type);
            $request->setAttribute("status", $status);
            $request->setAttribute("proname", $proname);
            $request->setAttribute("group_num", $group_num);
            $request->setAttribute("group_status", $group_status);
            $request->setAttribute("username", $username);
            $request->setAttribute("pages_show", $pages_show);

            return View :: INPUT;

        }
        $status = trim($request->getParameter('gstatus'));
        // 查询拼团活动列表
        $and = " g.store_id = '$store_id' ";
        // 导出
        $pageto = $request->getParameter('pageto');
        $gstatus = $request->getParameter('gstatus');
        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : 10;
        // 每页显示多少条数据
        $page = $request->getParameter('page');

        if ($pageto == 'all') {             //导出数据
            $sql = "select * from lkt_group_product";
            $res = $db->select($sql);
            $db->admin_record($store_id, $admin_name, ' 导出用户列表全部数据 ', 4);
            $request->setAttribute("list", $res);
            $request->setAttribute("pageto", $pageto);
            return View :: INPUT;
        }
        // 页码
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        //添加搜索条件
        if ($status != '0' && $status != '') {
            $and .= " and g.g_status= $status";
        }

        if ($proname != '') {
            $and .= " and p.product_title like '%$proname%'";
        }
        // 查询插件表
        $sql = "select min(g.attr_id) as attr_id,g.group_title,g.product_id,g.group_level,g.group_data,g. g_status,g.is_show,p.product_title,p.status,p.product_class,p.imgurl,c.price,c.price  as prices,MIN(c.price) as price,p.id as pid ,g.activity_no,g.is_copy,g.id
                from lkt_group_product as g 
                left join lkt_product_list as p on g.product_id=p.id 
                left join lkt_configure as c on g.attr_id=c.id 
                where g.is_delete = 0 and $and" . " 
                group by g.activity_no 
                order by g.g_status asc
                limit $start,$pagesize";
        $res = $db->select($sql);
        $sqlll = "select min(g.attr_id) as attr_id,g.group_title,g.product_id,g.group_level,g.group_data,g. g_status,g.is_show,p.product_title,p.status,p.product_class,p.imgurl,c.price,c.price  as prices,MIN(c.price) as price,p.id as pid ,g.activity_no,g.is_copy,g.id
                from lkt_group_product as g 
                left join lkt_product_list as p on g.product_id=p.id 
                left join lkt_configure as c on g.attr_id=c.id 
                where g.is_delete = 0 and $and" . " 
                group by g.activity_no 
                order by g.g_status asc";
        $resss = $db->select($sqlll);
        //判断是否有数据
        if ($res) {
            foreach ($res as $k => $v) {
                //如果是复制商品，同种商品没有进行中的活动则可以手动开启
                $v->no_have = 0;
                $v->is_copy = 0;

                $product_id = $v->product_id;
                    $sql_101 = "select * from lkt_group_product where product_id =$product_id  and g_status = 2 and store_id = $store_id and is_delete = 0 group by activity_no";
                    $res_101 = $db->select($sql_101);
                    if (!empty($res_101)) {
                        $v->no_have = 0;
                    } else {
                        $v->no_have = 1;
                    }

                //查询商品库存
                $sql = "select SUM(num) as num from lkt_configure where pid = '$v->pid'";
                $res_n = $db->select($sql);
                $v->num = $res_n[0]->num;
                $group_data = unserialize($v->group_data);
                $group_level = unserialize($v->group_level);

                $min_man = 1;
                $min_bili = 100;
                foreach ($group_level as $k_ => $v_) {
                    $biliArr = explode('~', $v_);
                    if ($biliArr[0] < $min_bili) {
                        $min_man = $k_;
                        $min_bili = $biliArr[0];
                    }
                }
                $v->min_man = $min_man;
                $min_price = $min_bili * $v->price / 100;
                $v->min_price = sprintf("%.2f", $min_price);
                $str = '';
                foreach ($group_level as $key => $value) {
                    $arr = explode('~', $value);
                    $str .= '<div><span class="tored">' . $key . '</span>人团,价:参 <span class="tored">' . $arr[0] . '%</span> ,开 <span class="tored">' . $arr[1] . '%</span></div>';
                }
                $v->group_level = $str;
                $v->starttime = $group_data->starttime;
                $v->endtime = $group_data->endtime;
                if (strtotime($v->starttime) == 0 && strtotime($v->endtime) == 0) {
                    $v->actime = '<p style="color: red;">暂未设置</p>';
                    $v->g_status = 1;
                } else {
                    $v->actime = $group_data->starttime . ' <br> ' . $group_data->endtime;
                }
                $v->imgurl = ServerPath::getimgpath($v->imgurl, $store_id);
            }

        }
        //分页
        $total = count($resss);
        $pager = new ShowPager($total, $pagesize, $page);
        $url = "index.php?module=go_group&action=Index&proname=" . urlencode($proname) . "&gstatus=" . urlencode($gstatus) . "&pagesize=" . urlencode($pagesize);
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');
        //渲染数据传递
        $request->setAttribute("list", $res);
        $request->setAttribute("pageto", $pageto);
        $request->setAttribute("status", $status);
        $request->setAttribute("proname", $proname);
        $request->setAttribute("gstatus", $gstatus);
        $request->setAttribute("pages_show", $pages_show);
        return View :: INPUT;
    }

    public function execute()
    {

    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }

}

?>