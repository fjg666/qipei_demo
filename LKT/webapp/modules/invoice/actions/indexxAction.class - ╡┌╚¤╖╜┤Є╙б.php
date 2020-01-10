<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class indexxAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

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

        $sql = "select p.* from lkt_printing as p left join lkt_order as o on p.sNo = o.sNo left join lkt_order_details as d on p.expresssn = d.courier_num where $condition group by p.id order by p.create_time desc limit $start,$pagesize";
        $list = $db->select($sql);

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

        return View :: INPUT;
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
                if (empty($v['expresssn'])) {
                    $res = $this->set_print($v);
                    if ($res) {
                        $sql = "update `lkt_printing` set `expresssn`='$res',`express`='顺丰' where (`id`='".$v['id']."')";
                        $db->update($sql);
                        $v['expresssn'] = $res;
                    }
                }
                $res = $this->go_print($v);
            }
            echo json_encode(array('code' => 200,'data'=>$details));exit;
        }else{
            echo json_encode(array('code' => 404));exit;
        }

    }

    public function go_print($details){
        $link = 'http://www.kdniao.com/External/PrintOrder.aspx';
        $id = '1572080';
        $appkey = '329e5f72-e0f4-4ce3-9350-79f9165a45c1';

        $request_data = '[{"OrderCode":"SF190827045827009","PortName":"print"}]';

        $data_sign = $this->encrypt($this->get_ip().$request_data, $appkey);
        //是否预览，0-不预览 1-预览
        $is_priview = '0';

        //组装表单
        $form = '<form id="form1" method="POST" action="'.$link.'"><input type="text" name="RequestData" value=\''.$request_data.'\'/><input type="text" name="EBusinessID" value="'.$id.'"/><input type="text" name="DataSign" value="'.$data_sign.'"/><input type="text" name="IsPriview" value="'.$is_priview.'"/></form>';

        echo json_encode(array('code' => 200, 'msg'=>$form));exit;
    }

    public function set_print($details){
        // $link = 'http://sandboxapi.kdniao.com:8080/kdniaosandbox/gateway/exterfaceInvoke.json';// API测试地址
        // $id = 'test1572080';
        // $appkey = 'bfda2fdd-7ef7-4562-b32f-fff8b6053f4a';
        $link = 'http://api.kdniao.com/api/EOrderService';// API正式地址
        $id = '1572080';
        $appkey = '329e5f72-e0f4-4ce3-9350-79f9165a45c1';

        $details['ProvinceName'] = '北京市';
        $details['CityName'] = '市辖区';
        $details['ExpAreaName'] = '西城区';
        $details['r_address'] = '故宫';

        $requestData = array();
        $requestData['MemberID'] = $details['s_id'];
        $requestData['ShipperCode'] = 'SF';
        $requestData['OrderCode'] = $details['sNo'];
        $requestData['PayType'] = 1;// 邮费支付方式:1-现付，2-到付，3-月结，4-第三方支付(仅SF支持)
        $requestData['ExpType'] = 1;// 快递类型：1-标准快件
        $requestData['Receiver'] = array(
            'Name'=>$details['recipient'],
            'Mobile'=>$details['r_mobile'],
            'ProvinceName'=>$details['ProvinceName'],
            'CityName'=>$details['CityName'],
            'ExpAreaName'=>$details['ExpAreaName'],
            'Address'=>$details['r_address']
        );
        $requestData['Sender'] = array(
            'Name'=>$details['sender'],
            'Mobile'=>$details['s_mobile'],
            'ProvinceName'=>$details['ProvinceName'],
            'CityName'=>$details['CityName'],
            'ExpAreaName'=>$details['ExpAreaName'],
            'Address'=>$details['s_address']
        );
        $requestData['Quantity'] = 1;
        $requestData['Commodity'] = array(
            0 => array(
                'GoodsName'=>$details['title']
            )
        );

        $requestData = json_encode($requestData, JSON_UNESCAPED_UNICODE);

        $data = array(
            'EBusinessID' => $id,
            'RequestType' => '1007',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $data['DataSign'] = $this->encrypt($requestData, $appkey);

        $res = $this->sendPost($link, $data);
        $re = json_decode($res);

        if ($re->ResultCode == 100 || $re->ResultCode == 106) {
            return $re->Order->LogisticCode;
        }else{
            var_dump($re);die;
            return false;
        }
        
    }

    function sendPost($url, $datas) {
        $temps = array();   
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);      
        }   
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if(empty($url_info['port']))
        {
            $url_info['port']=80;   
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);  
        
        return $gets;
    }

    function get_ip() {
        $IP_SERVICE_URL = 'http://www.kdniao.com/External/GetIp.aspx';
        // $IP_SERVICE_URL = 'ns1.dnspod.net:6666';
        //获取客户端IP
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        if(!$ip || $this->is_private_ip($ip)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $IP_SERVICE_URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            return $output;
        }
        else{
            return $ip;
        }
    }

    function is_private_ip($ip) {
        return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
    }

    function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }

    function curl_https($url, $data=array(), $header=array(), $timeout=30){  

        $ip = "100.100.".rand(1, 255).".".rand(1, 255);
        $headers = array("X-FORWARDED-FOR:$ip");

        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 从证书中检查SSL加密算法是否存在  
        curl_setopt($ch, CURLOPT_URL, $url);  
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
       
        $response = curl_exec($ch);  
       
        if($error=curl_error($ch)){  
            return false;
        }
       
        curl_close($ch);  

        return $response;

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>