<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/SF.class.php');
require_once(MO_LIB_DIR . '/sf/print.php');
require_once(MO_LIB_DIR . '/Plugin/subtraction.class.php');

class indexxAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id

        $sNo = addslashes(trim($request->getParameter('sNo')));// 订单号
        $expresssn = addslashes(trim($request->getParameter('expresssn')));// 运单号
        $r_mobile = addslashes(trim($request->getParameter('r_mobile')));// 下单人手机号码
        $recipient = addslashes(trim($request->getParameter('recipient')));// 下单人名称
        $r_time = trim($request->getParameter('r_time'));// 1.下单时间 2.付款时间 3.发货时间 4.打印时间
        $startdate = trim($request->getParameter('startdate'));// 开始时间
        $enddate = trim($request->getParameter('enddate'));// 结束时间
        $print_type = trim($request->getParameter('print_type'));// 打印状态1.已打印2.未打印
        $o_status = trim($request->getParameter('o_status'));// 订单状态1.未发货2.已发货
        $pagesize = $request -> getParameter('pagesize');
        $pageto = $request -> getParameter('pageto');
        $pagesize = $pagesize ? $pagesize:'10';
        $r_time = $r_time?$r_time:1;
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        $sql = "select work_domain from lkt_third where 1";
        $r = $db->select($sql);
        $open = 0;
        $host = $r?$r[0]->work_domain:'';//要ping的地址，也可以是IP
        if (!empty($host)) {
            $port = '4040';//要ping的端口
            $res = $this->ping($host,$port);
            if ($res == 'replay time out!') {
                $open = 1;
            }
        }

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        $condition = " p.store_id = '$store_id' and p.type=2 ";
        if($print_type != ''){
            if (intval($print_type) == 1) {
                $condition .= " and p.status=1 ";
            }else if (intval($print_type) == 2) {
                $condition .= " and p.status=0 ";
            }
        }
        if($sNo != ''){
            $condition .= " and p.sNo like '%$sNo%' ";
        }
        if($expresssn != ''){
            $condition .= " and p.expresssn = '$expresssn' ";
        }
        if($r_mobile != ''){
            $condition .= " and p.r_mobile like '%$r_mobile%' ";
        }
        if($recipient != ''){
            $condition .= " and p.recipient like '%$recipient%' ";
        }
        if($r_time != ''){
            if (intval($r_time) == 1) {
                if ($startdate != '') {
                    $condition .= " and o.add_time >= '$startdate 00:00:00' ";
                }
                if ($enddate != '') {
                    $condition .= " and o.add_time <= '$enddate 23:59:59' ";
                }
            }else if (intval($r_time) == 2) {
                if ($startdate != '') {
                    $condition .= " and o.pay_time >= '$startdate 00:00:00' ";
                }
                if ($enddate != '') {
                    $condition .= " and o.pay_time <= '$enddate 23:59:59' ";
                }
            }else if (intval($r_time) == 3) {
                if ($startdate != '') {
                    $condition .= " and d.deliver_time >= '$startdate 00:00:00' ";
                }
                if ($enddate != '') {
                    $condition .= " and d.deliver_time <= '$enddate 23:59:59' ";
                }
            }else if (intval($r_time) == 4) {
                if ($startdate != '') {
                    $condition .= " and p.print_time >= '$startdate 00:00:00' ";
                }
                if ($enddate != '') {
                    $condition .= " and p.print_time <= '$enddate 23:59:59' ";
                }
            }
        }
        if($o_status != ''){
            if (intval($print_type) == 1) {
                $condition .= " and o.status=1 ";
            }else if (intval($print_type) == 2) {
                $condition .= " and o.status in (2,3,5) ";
            }
        }
        // 查询插件表
        $sql = "select p.* from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo left join lkt_order_details as d on p.expresssn = d.courier_num where $condition group by p.id";
        $r_pager = $db->select($sql);
        $total = count($r_pager);

        if($pageto == 'This_page'){ // 导出本页
            $sql = "select p.*,o.add_time,o.pay_time,d.deliver_time from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo left join lkt_order_details as d on p.expresssn = d.courier_num where $condition group by p.id order by p.create_time desc limit $start,$pagesize";
            $db->admin_record($store_id,$admin_name,' 导出发货单第 '.$page.' 的信息 ',4);
        }else if($pageto == 'whole'){ // 导出全部
            $sql = "select p.*,o.add_time,o.pay_time,d.deliver_time from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo left join lkt_order_details as d on p.expresssn = d.courier_num where p.store_id = '$store_id' and p.type=2 group by p.id order by p.create_time desc";
            $db->admin_record($store_id,$admin_name,' 导出发货单全部信息 ',4);
        }else if($pageto == 'inquiry'){ // 导出查询
            $sql = "select p.*,o.add_time,o.pay_time,d.deliver_time from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo left join lkt_order_details as d on p.expresssn = d.courier_num where $condition group by p.id order by p.create_time desc";
            $db->admin_record($store_id,$admin_name,' 导出发货单查询信息 ',4);
        }else{
            $sql = "select p.* from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo left join lkt_order_details as d on p.expresssn = d.courier_num where $condition group by p.id order by p.create_time desc limit $start,$pagesize";
        }
        $list = $db->select($sql);

        if ($pageto != '') {
            foreach ($list as $k => $v) {
                $goods = array();
                $d_s = explode(',', $v->d_sNo);
                foreach ($d_s as $key => $value) {
                    if ($value) {
                        $sql = "select p.product_title as p_title,d.num as p_num from lkt_product_list p left join lkt_order_details d on p.id=d.p_id where d.id='$value'";
                        $r = $db->select($sql);
                        if ($r) {
                            $goods[] = $r[0];
                        }
                        $list[$k]->goods = $r?$r:array();
                    }
                }
            }
            $list[$k]->goods = $goods;
        }
        $pager = new ShowPager($total,$pagesize,$page);
        $url = "index.php?module=invoice&action=Index&sNo=".urlencode($sNo)."&r_mobile=".urlencode($r_mobile)."&recipient=".urlencode($recipient)."&r_time=".urlencode($r_time)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&print_type=".urlencode($print_type)."&o_status=".urlencode($o_status)."&expresssn=".urlencode($expresssn)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        // 查询平台店铺id
        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r?$r[0]->shop_id:1;
        // 查询平台单据模版
        $sql = "select * from lkt_mch_template where store_id='$store_id' and mch_id='$shop_id' and type=2";
        $tpl = $db->select($sql);

        $request->setAttribute("pageto",$pageto);
        $request->setAttribute("tpl",$tpl);
        $request->setAttribute("list",$list);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute("sNo",$sNo);
        $request->setAttribute("expresssn",$expresssn);
        $request->setAttribute("r_mobile",$r_mobile);
        $request->setAttribute("recipient",$recipient);
        $request->setAttribute("r_time",$r_time);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("print_type",$print_type);
        $request->setAttribute("o_status",$o_status);
        $request->setAttribute("open",$open);

        return View :: INPUT;
    }

    public function microtime_float()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
    public function ping($host,$port)
    {
        $time_start = $this->microtime_float();
        $ip = gethostbyname($host);
        $fp = @fsockopen($host,$port);
        if(!$fp) return 'replay time out!';
        $get = "GET / HTTP/1.1\r\nHost:".$host."\r\nConnection: Close\r\n\r\n";
        @fputs($fp,$get);
        @fclose($fp);
        $time_end = $this->microtime_float();
        $time = $time_end - $time_start;
        $time = ceil($time * 1000);
        return 'Reply from '.$ip.': time='.$time.'ms';
    }

    public function execute() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $m = trim($request->getParameter('m'));

        $this->$m();

        echo json_encode(array('status' => 0,'msg'=>'输入值有误！'));exit;
        exit;
    }

    public function edit(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = trim($request->getParameter('id'));
        $d_sNo = trim($request->getParameter('d_sNo'));
        $sender = trim($request->getParameter('sender'));
        $s_mobile = trim($request->getParameter('s_mobile'));
        $s_sheng = trim($request->getParameter('s_sheng'));
        $s_shi = trim($request->getParameter('s_shi'));
        $s_xian = trim($request->getParameter('s_xian'));
        $s_address = trim($request->getParameter('s_address'));
        $recipient = trim($request->getParameter('recipient'));
        $r_mobile = trim($request->getParameter('r_mobile'));
        $r_sheng = trim($request->getParameter('r_sheng'));
        $r_shi = trim($request->getParameter('r_shi'));
        $r_xian = trim($request->getParameter('r_xian'));
        $r_address = trim($request->getParameter('r_address'));

        $express = trim($request->getParameter('express'));
        $expresssn = trim($request->getParameter('expresssn'));
        $isopen = intval($request->getParameter('isopen'));


        $sql = "select d.id,p.imgurl,p.product_title,p.product_number,d.size,d.p_name,d.p_price,d.num,d.unit as total,p.weight from lkt_order_details d left join lkt_product_list p on d.p_id=p.id where d.store_id='$store_id' and d.id in ($d_sNo)";
        $r = $db->select($sql);
        $num = 0;
        $weight = 0;
        $title = '';
        foreach ($r as $k => $v) {
            if (!empty($v)) {
                $num += $v->num;
                $weight += $v->weight;
                $title .= $v->size.' '.$v->p_name.' ';
            }
        }

        $sql = "select sNo,d_sNo from lkt_printing where store_id = '$store_id' and id='$id'";
        $rrr = $db->select($sql);
        $old_sno = $rrr[0]->sNo;
        $old_dsno = $rrr[0]->d_sNo;

        // 修改快递单
        $db->update("update lkt_printing set d_sNo='$d_sNo',
            sender='$sender',
            s_mobile='$s_mobile',
            s_sheng='$s_sheng',
            s_shi='$s_shi',
            s_xian='$s_xian',
            s_address='$s_address',
            recipient='$recipient',
            r_mobile='$r_mobile',
            r_sheng='$r_sheng',
            r_shi='$r_shi',
            r_xian='$r_xian',
            r_address='$r_address',
            num='$num',
            weight='$weight',
            express='$express',
            expresssn='$expresssn',
            isopen='$isopen',
            title='$title' where store_id = '$store_id' and id='$id'");
        // 修改发货单
        $db->update("update lkt_printing set d_sNo='$d_sNo',
            sender='$sender',
            s_mobile='$s_mobile',
            s_sheng='$s_sheng',
            s_shi='$s_shi',
            s_xian='$s_xian',
            s_address='$s_address',
            recipient='$recipient',
            r_mobile='$r_mobile',
            r_sheng='$r_sheng',
            r_shi='$r_shi',
            r_xian='$r_xian',
            r_address='$r_address',
            num='$num',
            weight='$weight',
            isopen='$isopen',
            title='$title' where store_id = '$store_id' and sNo='$old_sno' and d_sNo='$old_dsno'");

        echo json_encode(array('code' => 200,'msg'=>'编辑成功！'));exit;
    }

    public function go_print(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $ids = trim($request->getParameter('id'));
        $ids = explode(',', $ids);
        $details = array();

        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $config = $db->select($sql);
        $accesscode = $config?$config[0]->accesscode:'';
        $checkword = $config?$config[0]->checkword:'';
        $custid = $config?$config[0]->custid:'';

        foreach ($ids as $k => $v) {
            if (!empty($v)) {
                $id = $v;
                $sql = "select p.*,u.user_name as r_uname,m.user_id as s_id from lkt_printing p left join lkt_user u on p.r_userid=u.user_id left join lkt_mch m on p.s_id=m.id where p.id='$id'";
                $r = $db->select($sql);
                $detail = $r?(array)$r[0]:array();
                if (!empty($detail)) {
                    $d_id = $detail['d_sNo'];
                    $d_id = explode(',', $d_id);
                    $detail['goods'] = array();
                    $detail['sum'] = 0;
                    foreach ($d_id as $k => $v) {
                        $sql = "select d.id,p.imgurl,p.product_title,p.product_number,d.size,d.p_name,d.p_price,d.num,d.unit,d.re_type as total from lkt_order_details d left join lkt_product_list p on d.p_id=p.id where d.store_id='$store_id' and d.id='$v'";
                        $r = $db->select($sql);
                        if ($r) {
                            $r[0]->imgurl = ServerPath::getimgpath($r[0]->imgurl,$store_id);
                            $r[0]->total = floatval($r[0]->p_price)*intval($r[0]->num);
                            $detail['sum'] += $r[0]->total;
                            $detail['goods'][] = $r[0];
                        }
                    }
                    // 赠品
                    $auto_jian = new subtraction();
                    $subtraction_list = $auto_jian->subtraction_order($db,$store_id,$detail['sNo']);
                    if (!empty($subtraction_list)) {
                        $zengpin = array(
                            'imgurl' => $subtraction_list['imgurl'],
                            'product_title' => '【赠品】'.$subtraction_list['product_title'],
                            'product_number' => $subtraction_list['product_number'],
                            'num' => $subtraction_list['num'],
                            'size' => '',
                            'p_price' => '0.00',
                            'total' => '0.00',
                            'unit' => ''
                        );
                        $detail['goods'][] = (object)$zengpin;
                    }
                    // 赠品 end
                }
                $detail['now'] = date('Y-m-d H:i:s');
                $details[] = $detail;
            }
        }

        $images = array();
        $print = new Express();
        if (!empty($details)) {
            foreach ($details as $k => $v) {
                if (empty($v['img_url']) || !is_file($v['img_url'])) {
                    $v['accesscode'] = $accesscode;
                    $v['checkword'] = $checkword;
                    $v['custid'] = $custid;
                    $getPayload_test = $print->go_print($v);
                    if ($getPayload_test) {
                        $images[] = $getPayload_test;
                        $db->update("update `lkt_printing` set `status`='1',`img_url`='".$getPayload_test."' where (`id`='".$v['id']."')");
                    }
                }else{
                    $images[] = $v['img_url'];
                }
            }
        }
        echo json_encode(array('code' => 200,'data'=>$images));exit;
        exit;
    }

    public function put_print(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $ids = trim($request->getParameter('id'));
        $ids = explode(',', $ids);
        $details = array();

        foreach ($ids as $k => $v) {
            if (!empty($v)) {
                $id = $v;
                $sql = "select p.*,u.user_name as r_uname,m.user_id as s_id from lkt_printing p left join lkt_user u on p.r_userid=u.user_id left join lkt_mch m on p.s_id=m.id where p.id='$id'";
                $r = $db->select($sql);
                $detail = $r?(array)$r[0]:array();
                if (!empty($detail)) {
                    $d_id = $detail['d_sNo'];
                    $d_id = explode(',', $d_id);
                    $detail['goods'] = array();
                    $detail['sum'] = 0;
                    foreach ($d_id as $k => $v) {
                        $sql = "select d.id,p.imgurl,p.product_title,p.product_number,d.size,d.p_name,d.p_price,d.num,d.unit as total from lkt_order_details d left join lkt_product_list p on d.p_id=p.id where d.store_id='$store_id' and d.id='$v'";
                        $r = $db->select($sql);
                        if ($r) {
                            $r[0]->imgurl = ServerPath::getimgpath($r[0]->imgurl,$store_id);
                            $r[0]->total = floatval($r[0]->p_price)*intval($r[0]->num);
                            $detail['sum'] += $r[0]->total;
                            $detail['goods'][] = $r[0];
                        }
                    }
                }
                $detail['now'] = date('Y-m-d H:i:s');
                $details[] = $detail;
            }
        }

        if (!empty($details)) {
            foreach ($details as $k => $v) {

                if (empty($v['origincode'])) {//顺丰
                    $res = $this->put_sf($v);
                    if ($res['head'] == 'OK') {
                        $sql = "update `lkt_printing` set `express`='顺丰',`expresssn`='".$res['mailno']."',`mini_sno`='".$res['orderid']."',`destcode`='".$res['destcode']."',`origincode`='".$res['origincode']."' where (`id`='".$v['id']."')";
                        $db->update($sql);
                        $v['expresssn'] = $res;
                    }else{
                        echo json_encode(array('code' => '110' ,'msg' => $res['message']));exit;
                    }
                }
            }
            echo json_encode(array('code' => 200));exit;
        }else{
            echo json_encode(array('code' => 404));exit;
        }

    }

    public function put_sf($details){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $config = $db->select($sql);
        $custid = $config?$config[0]->custid:'';
        $accesscode = $config?$config[0]->accesscode:'';
        $checkword = $config?$config[0]->checkword:'';

        $post = array();
        $post['count'] = $details['num'];
        $post['custid'] = '7551234567';
        $post['orderid'] = 'SF'.$details['store_id'].$details['id'].$details['num'].$details['id'].$details['num'];

        $post['j_company'] = '来客电商';
        $post['j_contact'] = $details['sender'];
        $post['j_tel'] = $details['s_mobile'];
        $post['j_province'] = $details['s_sheng'];
        $post['j_city'] = $details['s_shi'];
        $post['j_county'] = $details['s_xian'];
        $post['j_address'] = $details['s_address'];

        $post['j_company'] = '来客推';
        $post['d_contact'] = $details['recipient'];
        $post['d_tel'] = $details['r_mobile'];
        $post['d_province'] = $details['r_sheng'];
        $post['d_city'] = $details['r_shi'];
        $post['d_county'] = $details['r_xian'];
        $post['d_address'] = $details['r_address'];

        $post['remark'] = $details['remark'];
        $cargoes = array(
            'name' => $details['title']
        );

        $config = array(
            'accesscode' => $accesscode ,                               //商户号码
            'checkword'  => $checkword,                                 //商户密匙
            'ssl'        => false,                                      //是否ssl
            'server'     => "http://bsp-oisp.sf-express.com/",          //http
            'uri'        => 'bsp-oisp/sfexpressService',                //接口地址
        );
        $shunfeng = new SF($config);
        $getPayload_test = $shunfeng->Order($post,$cargoes);

        return $getPayload_test;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>