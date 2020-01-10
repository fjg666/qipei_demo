<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');

class CouponAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $hid = addslashes(trim($request->getParameter('id'))); //
        $sNo = addslashes(trim($request->getParameter('sNo'))); // 关联订单号
        $name = addslashes(trim($request->getParameter('name'))); // 会员名称
        $status = addslashes(trim($request->getParameter('status'))); // 请选择优惠券状态

        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $list = array();
        $condition = " a.store_id = '$store_id' and a.status = 0 and a.recycle = 0 and a.hid = '$hid' ";
        if($sNo != ''){
            $condition .= " and c.sNo like '%$sNo%'";
        }
        if($name != ''){
            $condition .= " and d.user_name like '%$name%'";
        }
        if($status != '' && $status != 0){
            if($status == 1){
                $condition .= " and status = '3'";
            }else{
                $condition .= " and status != '3'";
            }
        }

        $time = date('Y-m-d H:i:s'); // 当前时间
        $sql0 = "select a.id,a.hid,a.user_id,a.add_time,a.expiry_time,a.type,b.name,b.activity_type,b.money,b.discount from lkt_coupon as a LEFT JOIN lkt_coupon_activity as b ON a.hid = b.id left join lkt_order as c ON a.id = c.coupon_id left join lkt_user as d on a.user_id = d.user_id where $condition";
        $r0 = $db->select($sql0);

        $total = count($r0);
        $pager = new ShowPager($total,$pagesize,$page);

        $sql1 = "select a.id,a.hid,a.user_id,a.add_time,a.expiry_time,a.type,b.name,b.activity_type,b.money,b.discount,c.sNo from lkt_coupon as a LEFT JOIN lkt_coupon_activity as b ON a.hid = b.id left join lkt_order as c ON a.id = c.coupon_id left join lkt_user as d on a.user_id = d.user_id where $condition order by a.add_time desc limit $start,$pagesize";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v) {
                $id = $v->id; // 优惠券id
                $userid = $v->user_id; // 用户id
                $expiry_time = $v->expiry_time; // 到期时间

                // 当前时间大于活动结束时间,优惠券已过期
                if($time > $expiry_time){
                    $sql2 = "update lkt_coupon set type = 3 where store_id = '$store_id' and id = '$id' ";
                    $db->update($sql2);
                    $v->status = 3;
                }

                if($v->name){
                    $v->name = $v->name; // 活动名称
                }else{
                    // 查询配置信息
                    $sql3 = "select * from lkt_config where store_id = '$store_id' ";
                    $rrr = $db->select($sql3);
                    $v->name = $rrr[0]->company; // 公司名称
                }

                $sql4 = "select user_name from lkt_user where user_id = '$userid'";
                $r4 = $db->select($sql4);
                if($r4){
                    $v->user_name = $r4[0]->user_name;
                }else{
                    $v->user_name = '';
                }

                $list[] = $v;
            }
        }
        $url = "index.php?module=coupon&action=Coupon&id=".urlencode($hid)."&sNo=".urlencode($sNo)."&name=".urlencode($name)."&status=".urlencode($status)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$list);
        $request->setAttribute("hid",$hid);
        $request->setAttribute("sNo",$sNo);
        $request->setAttribute("name",$name);
        $request->setAttribute("status",$status);
        $request->setAttribute("pages_show",$pages_show);
        $request->setAttribute("pagesize",$pagesize);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>