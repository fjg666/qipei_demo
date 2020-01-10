<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class HelprecordAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        // 接收参数
        $order_no = $request->getParameter('order_no');// 砍价订单号
        $pagesize = $request->getParameter('pagesize');// 每页显示多少条数据
        $pagesize = $pagesize ? $pagesize : 10;
        $page = $request->getParameter('page');// 页码
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        // 查询总记录数
        $sql = "select r.id from lkt_bargain_record as r LEFT JOIN lkt_bargain_order as o on r.order_no = o.order_no where r.order_no = '$order_no' and r.store_id = $store_id";
        $total = $db->selectrow($sql);
        if ($start > $total) {
            $page = 1;
            $start = 0;
        }

        //初始化分页类
        $showpager = new ShowPager($total,$pagesize,$page);
        $offset=$showpager->offset;//设置开始查询位置
        $url = "index.php?module=bargain&action=Helprecord&order_no=".urlencode($order_no)."&pagesize=" . intval($pagesize);
        $pages_show = $showpager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        $sql = "select r.*,o.goods_id ,o.min_price,o.bargain_id
                from lkt_bargain_record as r 
                LEFT JOIN lkt_bargain_order as o on r.order_no = o.order_no 
                where r.order_no = '$order_no' and r.store_id = $store_id";
        $res = $db->select($sql);
        $goods_id = $res[0]->goods_id;// 活动ID
        $bargain_id = $res[0]->bargain_id;// 砍价订单号
        $min_price = $res[0]->min_price;// 砍价最低价

        $sql = "select c.price
                from lkt_product_list as p
                LEFT JOIN lkt_configure as c on c.pid = p.id
                where p.id = '$goods_id' and p.store_id = $store_id";
        $p_res = $db->select($sql);
        // 需要砍的价格 = 商品价格-砍价最低价
        $only_total_money = floatval($p_res[0]->price)-floatval($min_price);
        $ed_money = 0;
        foreach ($res as $k => $v){
            $user_id = $v->user_id;// 用户ID
            $sql = "select user_name from lkt_user where user_id = '$user_id'";
            $u_res = $db->select($sql);
            $v->user_name = empty($u_res)?'':$u_res[0]->user_name;// 用户昵称
            $v->time = date('Y-m-d H:i',$v->add_time);// 帮砍时间
            $ed_money += floatval($v->money);
            $v->only_money = sprintf("%.2f", $only_total_money) - sprintf("%.2f", $ed_money);// 当前砍价
        }

        $request->setAttribute("list", $res);
        $request->setAttribute("bargain_id", $bargain_id);
        $request->setAttribute("pages_show", $pages_show);

        return View :: INPUT;
    }


    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>