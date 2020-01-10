<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id

        $sNo = addslashes(trim($request->getParameter('sNo')));// 订单号
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

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        $condition = " p.store_id = '$store_id' and p.type=1 ";
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
        $sql = "select p.* from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo where $condition";
        $r_pager = $db->select($sql);
        $total = count($r_pager);        

        if($pageto == 'This_page'){ // 导出本页
            $sql = "select p.*,o.add_time,o.pay_time from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo where $condition order by p.create_time desc limit $start,$pagesize";
            $db->admin_record($store_id,$admin_name,' 导出发货单第 '.$page.' 的信息 ',4);
        }else if($pageto == 'whole'){ // 导出全部
            $sql = "select p.*,o.add_time,o.pay_time from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo where p.store_id = '$store_id' and p.type=1  order by p.create_time desc";
            $db->admin_record($store_id,$admin_name,' 导出发货单全部信息 ',4);
        }else if($pageto == 'inquiry'){ // 导出查询
            $sql = "select p.*,o.add_time,o.pay_time from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo where $condition order by p.create_time desc";
            $db->admin_record($store_id,$admin_name,' 导出发货单查询信息 ',4);
        }else{
            $sql = "select p.* from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo where $condition order by p.create_time desc limit $start,$pagesize";
        }
        $list = $db->select($sql);

        if ($pageto != '') {
            foreach ($list as $k => $v) {
                $goods = array();
                $d_s = explode(',', $v->d_sNo);
                foreach ($d_s as $key => $value) {
                    if ($value) {
                        $sql = "select p.product_title as p_title,d.num as p_num,d.deliver_time from lkt_product_list p left join lkt_order_details d on p.id=d.p_id where d.id='$value'";
                        $r = $db->select($sql);
                        if ($r) {
                            $goods[] = $r[0];
                        }
                        $list[$k]->deliver_time = $r?$r[0]->deliver_time:'';
                    }
                }
                $list[$k]->goods = $goods;
            }
        }
        $pager = new ShowPager($total,$pagesize,$page);
        $url = "index.php?module=invoice&action=Index&sNo=".urlencode($sNo)."&r_mobile=".urlencode($r_mobile)."&recipient=".urlencode($recipient)."&r_time=".urlencode($r_time)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&print_type=".urlencode($print_type)."&o_status=".urlencode($o_status)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        // 查询平台店铺id
        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r?$r[0]->shop_id:0;
        // 查询平台单据模版
        $sql = "select * from lkt_mch_template where store_id='$store_id' and mch_id='$shop_id' and type=1";
        $tpl = $db->select($sql);

        $request->setAttribute("pageto",$pageto);
        $request->setAttribute("tpl",$tpl);
        $request->setAttribute("list",$list);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute("sNo",$sNo);
        $request->setAttribute("r_mobile",$r_mobile);
        $request->setAttribute("recipient",$recipient);
        $request->setAttribute("r_time",$r_time);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("print_type",$print_type);
        $request->setAttribute("o_status",$o_status);

        return View :: INPUT;
    }

    public function getimgpath($img){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_files_record where store_id = '$store_id' and image_name='$img'";
        $res = $db -> select($sql);

        $serverURL = $this->getContext()->getStorage()->read('serverURL');
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');


        if(!empty($res)){
            $store_type = $res[0] -> store_type;
            $upload_mode = $res[0] -> upload_mode;
            if($upload_mode == 2){
                $image = $serverURL['OSS'] . '/' . $store_id . '/' . $store_type . '/' .$img;
            }else if($upload_mode == 3){
                $image = $serverURL['tenxun'] . '/' . $store_id . '/' . $store_type . '/' .$img;
            }else if($upload_mode == 4){
                $image = $serverURL['qiniu'] . '/' . $store_id . '/' . $store_type . '/' .$img;
            }else{
                $image = $uploadImg . $img;
            }
        }else{
            $image = $uploadImg . $img;
        }

        return $image;
    }

    public function execute() {

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
            title='$title' where store_id = '$store_id' and id='$id'");
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
            isopen='$isopen',
            title='$title' where store_id = '$store_id' and sNo='$old_sno' and d_sNo='$old_dsno'");

        echo json_encode(array('code' => 200,'msg'=>'编辑成功！'));exit;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>