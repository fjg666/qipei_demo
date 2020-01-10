<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

/**
 * [getDefaultView description]
 * <p>Copyright (c) 2018-2019</p>
 * <p>Company: www.laiketui.com</p>
 * @Author  苏涛
 * @return  [type]                   [description]
 * @version 2.0
 * @date    2018-12-13T17:33:21+0800
 */
class IndexAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $button[0] = $db->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=orderslist&action=Detail');
        $button[1] = $db->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=orderslist&action=Modify');
        $button[2] = $db->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=orderslist&action=Kuaidishow');
        $button[3] = $db->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=orderslist&action=Del');
        $button[4] = $db->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=orderslist&action=Close');

        $ordtype1 = 'ti/普通订单,';

        $Plugin = new Plugin();
        $Plugin_arr = $Plugin->is_Plugin1($db, $store_id, 'order');

        $Plugin_arr['res1'] = rtrim($Plugin_arr['res1'], ',');
        $ordtype1 = $ordtype1 . $Plugin_arr['res1'];

        $ordtype1 = rtrim($ordtype1, ',');
        $ordtype2 = explode(',', $ordtype1);
        foreach ($ordtype2 as $k => $v) {
            $ordtype3 = explode('/', $v);
            $ordtype[$ordtype3[0]] = $ordtype3[1];
        }
        $otype = isset($_GET['otype']) && $_GET['otype'] !== '' ? $_GET['otype'] : false;
        $status = trim($request->getParameter('status')); // 订单状态
        $news_status = trim($request->getParameter('news_status')); // 订单状态
        $delivery_status = trim($request->getParameter('delivery_status')); // 提醒发货
        $readd = trim($request->getParameter('readd')); // 未查看信息
        $mch_id = trim($request->getParameter('mch_id')); // 店铺ID
        $x_order = trim($request->getParameter('x_order')); // 店铺ID

        $ostatus = isset($_GET['ostatus']) && $_GET['ostatus'] !== '' ? $_GET['ostatus'] : false;
        $sNo = isset($_GET['sNo']) && $_GET['sNo'] !== '' ? $_GET['sNo'] : false;
        $brand = trim($request->getParameter('brand'));
        $prostr = '';
        $URL = '';
        $con = '';
        foreach ($_GET as $key => $value001) {
            $con .= "&$key=$value001";
        }
        if ($brand) {
            $prostr .= " and lpl.brand_id = '$brand'";
        }
        $brand_str = '';

        $condition = " and o.status != 8 ";

        $pageto = $request->getParameter('pageto');
        // 导出
        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : '10';
        // 每页显示多少条数据
        $page = $request->getParameter('page');

        // 页码
        if ($page) {
            $start = ($page - 1) * 10;
        } else {
            $start = 0;
        }

        $source = trim($request->getParameter('source'));
        if ($source == 1) {
            $condition .= " and o.source = '1' ";
        } else if ($source == 2) {
            $condition .= " and o.source = '2' ";
        }

        $startdate = $request->getParameter("startdate");
        $enddate = $request->getParameter("enddate");
        if ($x_order) {
            $startdate = date('Y-m-d 00:00:00');
            $enddate = date('Y-m-d 23:59:59');
            $condition .= " and (o.status = 0 or o.status = 1) ";

        }
        if ($startdate != '') {
            $condition .= " and o.add_time >= '$startdate 00:00:00' ";
        }
        if ($enddate != '') {
            $condition .= " and o.add_time <= '$enddate 23:59:59' ";
        }
        if ($otype == 't2') {
            $condition .= " and o.otype='pt'";
            if ($status == 'g0') {
                $condition .= " and o.status= 0 ";
            } else if ($status == 'g1') {
                $condition .= " and o.status= 9 ";
            } else if ($status == 'g2') {
                $condition .= " and o.status > 0 and o.status < 9 ";
            } else if ($status == 'g3') {
                $condition .= " and o.status > 9 ";
            }
            if ($ostatus) {
                $condition .= " and o.status=$ostatus ";
            }
        } else if ($otype == 't3') {
            $condition .= " and o.otype = 'KJ' ";
            if($status != ''){
                $condition.=" and o.status=$status";
            }
        } else if ($otype == 't4') {
            $condition .= " and o.otype = 'JP' ";
            if($status != ''){
                $condition.=" and o.status=$status";
            }
        } else if ($otype == 't5') {
            $condition .= " and o.otype = 'FX' ";
            if($status != ''){
                $condition.=" and o.status=$status";
            }
        } else if ($otype == 't7') {
            $condition .= " and o.otype = 'integral' ";
            if($status != ''){
                $condition.=" and o.status=$status";
            }
        } else if ($otype == 't8') {
            $condition .= " and o.otype = 'MS' ";
            if($status != ''){
                $condition.=" and o.status=$status";
            }
        }else if ($otype == 'ti') {
            $condition .= " and o.otype = '' ";
            if($status != ''){
                $condition.=" and o.status=$status";
            }
        } else {
            if ($status != '') {
                $condition .= " and o.status=$status ";
            }
        }
        if ($readd != '') { // 未查看信息
            $condition .= " and o.readd = '$readd' ";
        }
        if ($news_status === 0) { // 消息传过来的参数
            $condition .= " and o.status in (0,1)";
        } else if ($news_status == 1) {
            $condition .= " and o.status = 1";
            $status = 1;
        }
        if ($delivery_status) { // 提现发货
            $condition .= " and o.delivery_status = '$delivery_status' ";
        }
        if ($mch_id) {
            $condition .= " and o.mch_id = ',$mch_id,' ";
        }
        if ($sNo !== false) {
            $sNo = htmlspecialchars($sNo);
            $condition .= ' and (o.sNo like "%' . $sNo . '%" or o.name like "%' . $sNo . '%" or o.mobile like "%' . $sNo . '%" ' . ' or o.user_id like "%' . $sNo . '%" ' . ' or o.p_sNo like "%' . $sNo . '%")';
        }
        $sql1111 = "select SUM(o.z_price) as z_price,COUNT(o.id) as num 
                    from lkt_order as o 
                    left join lkt_user as lu on o.user_id = lu.user_id 
                    where o.store_id = '$store_id' and lu.store_id='$store_id' $condition 
                    order by o.add_time desc ";
        $resd_total = $db->select($sql1111);
        $total = $resd_total[0]->num;
        $data1['num'] = $total;
        $data1['numprice'] = $resd_total[0]->z_price;

        $sql1 = "select o.real_sno,o.id,o.consumer_money,o.num,o.sNo,o.name,o.sheng,o.shi,o.xian,o.source,o.address,o.add_time,o.mobile,o.z_price,o.status,o.reduce_price,o.coupon_price,o.allow,o.drawid,o.otype,o.ptstatus,o.spz_price,o.pay,o.drawid,lu.user_name,o.user_id,o.mch_id,o.p_sNo 
                from lkt_order as o 
                left join lkt_user as lu on o.user_id = lu.user_id 
                right join lkt_order_details as d on o.sNo = d.r_sNo
                where o.store_id = '$store_id'  and lu.store_id = '$store_id'  $condition ";

        if ($pageto == 'This_page') { // 导出本页
            $sql1 .= "$condition group by o.sNo order by o.add_time desc limit $start,$pagesize ";
            $db->admin_record($store_id, $admin_name, ' 导出订单第 ' . $page . ' 的信息 ', 4);
        } else if ($pageto == 'whole') { // 导出全部
            $sql1 .= " group by o.sNo order by o.add_time desc ";
            $db->admin_record($store_id, $admin_name, ' 导出订单全部信息 ', 4);
        } else if ($pageto == 'inquiry') { // 导出查询
            $sql1 .= "$condition group by o.sNo order by o.add_time desc";
        } else {
            $sql1 .= "$condition group by o.sNo order by o.add_time desc limit $start,$pagesize ";
        }
        $res1 = $db->select($sql1);

        $list = array();
        //支付方式
        $sql = "select * from lkt_payment where 1=1  order by sort desc";
        $payments = $db->select($sql);
        $payments_type = array();
        foreach ($payments as $keyp => $valuep) {
            $payments_type[$valuep->class_name] = $valuep->name;
        }


        $pager = new ShowPager($total, $pagesize, $page);
        $url = 'index.php?module=orderslist' . $con;
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        //获取目前设置的分销商品
        $sql = "select a.id,c.img from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.is_distribution = 1 and a.num >0 group by c.pid ";
        $distribution_products = $db->select($sql);
        foreach ($distribution_products as $key => $value) {
            $distribution_products[$key] = $value->id;
        }
        $distribution_products = (array)$distribution_products;
        if(!empty($res1)){
            foreach ($res1 as $k => $v) {
                $freight = 0;
                $mch_id = $v->mch_id;
                $mch_arr = explode(',',$mch_id);
                if(count($mch_arr) >3){
                    $res1[$k]->is_mch = 1;
                }else{
                    $res1[$k]->is_mch = 0;
                }
                $res1[$k]->address = $v->sheng . $v->shi . $v->xian . $v->address;
                $res1[$k]->statu = $res1[$k]->status;
                $zqprice = 0;
                $order_id = $v->sNo;
                $pay = $v->pay;

                if (array_key_exists($pay, $payments_type)) {
                    $v->pay = $payments_type[$pay];
                } else {
                    $v->pay = '组合支付';
                }

                if ($pay == 'combined_Pay') {
                    $psql = "select weixin_pay,balance_pay,total from lkt_combined_pay where order_id = '$order_id'";
                    $pres = $db->select($psql);
                    foreach ($pres as $kp => $vp) {
                        $res1[$k]->weixin_pay = $vp->weixin_pay;
                        $res1[$k]->balance_pay = $vp->balance_pay;
                        $res1[$k]->total = $vp->total;
                    }
                }

                $user_id = $v->user_id;
                $sqldt = "select lpl.imgurl,lpl.product_title,lpl.product_number,lod.p_price,lod.unit,lod.num,lod.size,lod.p_id,lod.courier_num,lod.express_id,lod.freight,lpl.brand_id ,lm.name as mchname
                        from lkt_order_details as lod 
                        left join lkt_product_list as lpl on lpl.id=lod.p_id 
                        LEFT JOIN lkt_mch as lm on lm.id = lpl.mch_id 
                        where r_sNo='$v->sNo' $prostr";
                $products = $db->select($sqldt);
                $res1[$k]->freight = $freight;

                if ($products) {
                    $courier_num = array();       // 快递单号
                    foreach ($products as $kd => $vd) {
                        $freight += $vd->freight;
                        $vd->imgurl = ServerPath::getimgpath($vd->imgurl, $store_id);
                        if ($vd->express_id) {
                            $exper_id = $vd->express_id;
                            $sql03 = "select * from lkt_express where id = $exper_id ";
                            $r03 = $db->select($sql03);
                            $courier_num[] = $vd->courier_num . "  (" . $r03[0]->kuaidi_name . ")"; // 快递单号
                        }
                        $products[$kd] = $vd;
                    }
                    $courier_num_arr = array();
                    foreach ($courier_num as $kkk => $vvv){
                        if(!in_array($vvv,$courier_num_arr)){
                            $courier_num_arr[] = $vvv;
                        }
                    }
                    $res1[$k]->courier_num = $courier_num_arr;
                    $res1[$k]->products = $products;
                    $res1[$k]->mchname = $products[0]->mchname;
                    $pt_status = '';
                    if ($v->otype == 'pt') {
                        switch ($v->status) {
                            case 0 :
                                $res1[$k]->status = '待付款';
                                $res1[$k]->pt_status = '待付款';
                                $res1[$k]->bgcolor = '#f5b1aa';
                                break;
                            case 1 :
                                $res1[$k]->pt_status = '拼团成功';
                                $res1[$k]->status = '待发货';
                                $res1[$k]->bgcolor = '#f0908d';
                                break;
                            case 2 :
                                $res1[$k]->pt_status = '拼团成功';
                                $res1[$k]->status = '待收货';
                                $res1[$k]->bgcolor = '#f0908d';
                                break;
                            case 3 :
                                $res1[$k]->status = '待评价';
                                $res1[$k]->bgcolor = '#f0908d';
                                $res1[$k]->pt_status = '拼团成功';
                                break;
                            case 4 :
                                $res1[$k]->status = '退货';
                                $res1[$k]->bgcolor = '#e198b4';
                                break;
                            case 5 :
                                $res1[$k]->status = '已完成';
                                $res1[$k]->bgcolor = '#f7b977';
                                $res1[$k]->pt_status = '拼团成功';
                                break;
                            case 6 :
                                $res1[$k]->status = '已关闭';
                                $res1[$k]->bgcolor = '#f7b977';
                                $res1[$k]->pt_status = '拼团成功';
                                break;
                            case 8 :
                                $res1[$k]->status = '订单删除';
                                $res1[$k]->bgcolor = '#ff1800';
                                $res1[$k]->pt_status = '订单删除';
                                break;
                            case 9 :
                                $res1[$k]->status = '拼团中';
                                $res1[$k]->bgcolor = '#f5b199';
                                $res1[$k]->pt_status = '拼团中';
                                break;
                            case 10 :
                                $res1[$k]->status = '未退款';
                                $res1[$k]->pt_status = '拼团失败';
                                $res1[$k]->bgcolor = '#ee827c';
                                break;
                            case 11 :
                                $res1[$k]->status = '已退款';
                                $res1[$k]->pt_status = '拼团失败';
                                $res1[$k]->bgcolor = '#ee827c';
                                break;
                        }
                    } else {
                        $v->otype = substr($v->sNo, 0, 2);
                        switch ($v->status) {
                            case 0 :
                                $res1[$k]->status = '待付款';
                                $res1[$k]->bgcolor = '#f5b1aa';
                                break;
                            case 1 :
                                $res1[$k]->status = '待发货';
                                $res1[$k]->bgcolor = '#f09199';
                                break;
                            case 2 :
                                $res1[$k]->status = '待收货';
                                $res1[$k]->bgcolor = '#f19072';
                                break;
                            case 3 :
                                $res1[$k]->status = '待评价';
                                $res1[$k]->bgcolor = '#e4ab9b';
                                break;
                            case 4 :
                                $res1[$k]->status = '退货';
                                $res1[$k]->bgcolor = '#e198b4';
                                break;
                            case 5 :
                                $res1[$k]->status = '已完成';
                                $res1[$k]->bgcolor = '#f7b977';
                                break;
                            case 6 :
                                $res1[$k]->status = '已关闭';
                                $res1[$k]->bgcolor = '#ffbd8b';
                                break;
                            case 7 :
                                $res1[$k]->status = '已关闭';
                                $res1[$k]->bgcolor = '#ffbd8b';
                                break;
                            case 8 :
                                $res1[$k]->status = '订单删除';
                                $res1[$k]->bgcolor = '#ff1800';
                                break;
                            case 9 :
                                $res1[$k]->status = '拼团中';
                                $res1[$k]->bgcolor = '#ffbd8b';
                                break;
                            case 11 :
                                $res1[$k]->status = '拼团失败';
                                $res1[$k]->bgcolor = '#ffbd8b';
                                break;
                            case 10 :
                                $res1[$k]->status = '拼团失败';
                                $res1[$k]->bgcolor = '#ffbd8b';
                                break;
                            case 12 :
                                $res1[$k]->status = '已完成';
                                $res1[$k]->bgcolor = '#f7b977';
                                break;
                        }
                    }

                    if ($v->otype == 'IN') {
                        $integralid = $v->p_sNo;
                        $sql = "select g.integral,g.money,c.img from lkt_integral_goods as g left join lkt_configure as c on g.attr_id = c.id where g.id='$integralid'";
                        $inr = $db->select($sql);
                        if ($inr) {
                            $v->p_integral = $inr[0]->integral;
                            $v->p_money = $inr[0]->money;
                            $vd->imgurl = ServerPath::getimgpath($inr[0]->img);
                        }
                    }

                    $res1[$k]->freight = $freight;
                    $list[] = $res1[$k];
                }

            }
        }else{
            $list = array();
        }

        $class = Tools::data_dictionary($db, '订单状态', $status);
        $source_str = Tools::data_dictionary($db, '来源', $source);

        $request->setAttribute("source", $source_str);
        $request->setAttribute("brand_str", $brand_str);
        $request->setAttribute("startdate", $startdate);
        $request->setAttribute("enddate", $enddate);
        $request->setAttribute("ordtype", $ordtype);
        $request->setAttribute("order", $list);
        $request->setAttribute("sNo", $sNo);
        $request->setAttribute("otype", $otype);
        $request->setAttribute("status", $status);
        $request->setAttribute("total", $total);
        $request->setAttribute("ostatus", $ostatus);
        $request->setAttribute('pageto', $pageto);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute('data1', $data1);
        $request->setAttribute('button', $button);
        $request->setAttribute('class', $class);
        return View::INPUT;
    }


    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        //m指向具体操作方法
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))) : 'getDefaultView';
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $this->store_id = $store_id;
        $this->db = $db;
        //m指向具体操作方法
        $this->$m();
        exit;
    }


    /**
     * [close description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @param   [type]                   $store_id [description]
     * @return  [type]                             [description]
     * @version 2.0
     * @date    2018-12-21T12:29:21+0800
     */
    public function close()
    {
        $store_id = $this->store_id;
        $this->db->begin();
        $request = $this->getContext()->getRequest();
        $oid = trim($request->getParameter('oid'));
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        $sql1 = "update lkt_order_details set r_status = 6 where store_id = '$store_id' and r_sNo = $oid";
        $res1 = $this->db->update($sql1);
        if (!$res1) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单详情失败！sql:" . $sql1);
            $this->db->rollback();
            echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
            exit;
        }

        $sql2 = "update lkt_order set status = 6 where store_id = '$store_id' and sNo = '$oid'";
        $res2 = $this->db->update($sql2);

        if (!$res2) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单失败！sql:" . $sql2);
            $this->db->rollback();
            echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
            exit;
        }
        $this->db->commit();
        echo json_encode(array('status' => 1, 'msg' => '操作成功！'));
        exit;
    }


    /**
     * 删除订单
     */
    public function del()
    {
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $data = $request->getParameter('data');
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        $orders = explode(',', substr($data, 0, strlen($data) - 1));
        $this->db->begin();
        foreach ($orders as $key => $value) {

            $sql1 = "update lkt_order_details set r_status = 7 where store_id = '$store_id' and r_sNo = $value";
            $res1 = $this->db->update($sql1);
            if (!$res1) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单详情失败！sql:" . $sql1);
                $this->db->rollback();
                echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
                exit;
            }

            $sql2 = "update lkt_order set status = 7  where store_id = '$store_id' and sNo = '$value'";
            $res2 = $this->db->update($sql2);
            if (!$res2) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单详情失败！sql:" . $sql2);
                $this->db->rollback();
                echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
                exit;
            }
        }
        $this->db->commit();
        echo json_encode(array('status' => 1, 'msg' => '操作成功！'));
        exit;
    }

    public function getRequestMethods()
    {
        return Request::POST;
    }

}

?>