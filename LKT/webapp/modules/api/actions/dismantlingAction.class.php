<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once('Apimiddle.class.php');
class dismantlingAction extends Apimiddle {

    public function getDefaultView() {
        return json_encode(array('fail' => '40028' ));
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $m = addslashes(trim($request->getParameter('m')));

        $openid = $request->getParameter('openid'); // 微信id
        $sql = "select g.*,u.user_id,u.user_name from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_user as u  ON d.user_id = u.user_id where g.store_id = '$store_id' and u.wx_id = '$openid' and g.is_ordinary = '0'";
        $r = $db -> select($sql);

        if(!$r){
            echo json_encode(array('status' => false,'err' => '您没有成为会员无法访问!' ));
            exit;
        }
        $this->$m();

//        if($m == 'index'){
//            //请求分销中心数据
//            $this->index();
//        }else if($m == 'forward'){
//            //进入提现 计算返回可提现金额
//            $this->forward();
//        }else if($m == 'get_forward'){
//            //申请提现
//            $this->get_forward();
//        }else if($m == 'Distribution_order'){
//            //显示分销商品
//            $this->Distribution_order();
//        }else if($m == 'withdrawals'){
//            $this->withdrawals();
//        }else if($m == 'Distribution_products'){
//            $this->Distribution_products();
//        }else if($m == 'mytean'){
//            $this->mytean();
//        }else if($m == 'record'){
//            $this->record();
//        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 请求分销中心数据
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $openid = $request->getParameter('openid'); // 微信id

        // 查询会员信息
        $sql = "select g.*,u.user_id,u.user_name,u.consumer_money,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_user as u ON d.user_id = u.user_id where u.store_id = '$store_id' and u.wx_id = '$openid' ";
        $r = $db -> select($sql);
        if($r){
            //推荐人id
            $tj_id = $r[0]->pid;
            //用户id
            $user_id = $r[0]->user_id;
            //反序列化出提成比例数组
            $sets = unserialize($r[0]->sets);
            // lt
            $lt = $r[0]->lt;
            // rt
            $rt = $r[0]->rt;
            // 分销层级
            $uplevel = $r[0]->uplevel;
            // 三级的比例
            $num = [$sets['b_yi'],$sets['b_er'],$sets['b_san']];

            $consumer_money = $r[0]->consumer_money;

            $djname = $sets['s_dengjiname'];
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        $sqlrr = "select * from lkt_user where store_id = '$store_id' and user_id = '$tj_id'";
        $rr = $db -> select($sqlrr);
        if($rr){
            $wx_name = $rr[0]->wx_name;
        }else{
            $wx_name = '暂无经纪人';
        }

        $data = [];
        $data['title'] = 'CRM管理';
        $data['tname'] = '经纪人';
        $list = [];

        $list['products'] = '我的产品';
        $list['orders'] = '我的订单';
        $list['mycode'] = '我的二维码';
        $list['sales_details'] = '销售明细';
        $list['my_client'] = '我的客户';

        $list['products_img'] = '/images/core/fxcp.png';
        $list['orders_img'] = '/images/core/wddd.png';
        $list['mycode_img'] = '/images/core/tgewm.png';
        $list['sales_details_img'] = '/images/core/fxmx.png';
        $list['my_client_img'] = '/images/core/wdtd.png';
        $data['list'] = $list;
        //可收入
        $array01 = 0.00;

        $sql33 = "select sum(money) as dkyj from lkt_distribution_record where store_id = '$store_id' and user_id = '$user_id' and (type = 1 or type = 3) order by add_date desc";
        $dkyj = $db->select($sql33);
        if($dkyj['0']->dkyj){
            $array01 = $dkyj['0']->dkyj;
        }

        $arrnum = array('yj' => $array01,'consumer_money'=>$consumer_money,'wx_name'=>$wx_name,'djname'=>$djname,'status'=>true,'data'=>$data);
        echo json_encode($arrnum);
        exit;
    }

    //进入提现 计算返回可提现金额
    public function forward()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $openid = $_POST['openid']; // 微信openid

        // 查询会员信息
        $sql = "select g.*,u.user_id,u.user_name,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_user as u  ON d.user_id = u.user_id where u.store_id = '$store_id' and u.wx_id = '$openid' ";
        $r = $db -> select($sql);
        if($r){
            //推荐人id
            $tj_id = $r[0]->pid;
            //用户id
            $user_id = $r[0]->user_id;
            //反序列化出提成比例数组
            $sets = unserialize($r[0]->sets);
            // lt
            $lt = $r[0]->lt;
            // rt
            $rt = $r[0]->rt;
            // 分销层级
            $uplevel = $r[0]->uplevel;
            // 三级的比例
            $num = [$sets['b_yi'],$sets['b_er'],$sets['b_san']];
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        //获取目前设置的分销商品
        $sql ="select a.id from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.status = 0 and a.is_distribution = 1 and a.num >0 group by c.pid ";
        $products = $db->select($sql);
        foreach ($products as $key => $value) {
            $products[$key] = $value->id;
        }
        $products = (array)$products;

        $array02 = 0;
        for ($j=1; $j <= count($num); $j++) {

            $uplevel = $uplevel+$j;
            $sqlxj = "select * from lkt_user_distribution where store_id = '$store_id' and pid = '$user_id' and lt>'$lt' and rt<'$rt' and uplevel = '$uplevel' ";
            $obj = $db -> select($sqlxj);

            if($obj){
                for ($i=0; $i < count($obj); $i++) {
                    if($i > 1000){
                        break;
                    }else{
                        $uid = $obj[$i]->user_id;
                        //可提金额
                        $sql01 = "select lo.allow,lo.z_price,lo.spz_price,lo.reduce_price,lo.coupon_price,lc.img,lod.p_name,lod.r_status,lod.id,lod.add_time,lod.p_price,lod.p_id from lkt_order as lo LEFT JOIN lkt_order_details as lod ON lo.sNo = lod.r_sNo LEFT JOIN lkt_configure as lc ON lc.id = lod.sid where lo.store_id = '$store_id' and lod.user_id = '$uid' and lo.drawid = '0' and lod.r_status = 5 ";
                        $rew2 = $db->select($sql01);

                        if($rew2){
                            foreach ($rew2 as $key => $value) {
                                if(in_array($value->p_id, $products)){
                                    //计算出实际付款金额 并生成比例 和佣金
                                    $p_price = $value->p_price;
                                    $spz_price = $value->spz_price=='0.00' ? 1:$value->spz_price;
                                    $z_price = $value->z_price;

                                    if($z_price == $p_price || $z_price == $spz_price){
                                        $price = $z_price;
                                    }else{
                                        $price = number_format($z_price / $spz_price * $p_price, 2, ".", "");
                                    }

                                    $zqprice = number_format($price/100*$num[$j], 2, ".", "");

                                    $array02 += $zqprice;
                                }
                            }

                        }
                    }

                }
            }
        }

        $sql = "select SUM(money) as money from lkt_record where store_id = '$store_id' and user_id = '$user_id' and type = 6";
        $r_6 = $db->select($sql);
        if($r_6){
            $money =  $r_6[0]-> money;
        }else{
            $money = 0;
        }

        $array02 = $array02 - $money;

        $arrnum = array('ktx' => $array02,'status'=>true);
        echo json_encode($arrnum);
        exit;
    }
    //申请提现
    public function get_forward()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $openid = $_POST['openid']; // 微信openid
        $tmoney = $_POST['money']; // 微信openid

        // 查询会员信息
        $sql = "select g.*,u.user_id,u.user_name,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_user as u  ON d.user_id = u.user_id where u.store_id = '$store_id' and u.wx_id = '$openid' ";
        $r = $db -> select($sql);
        if($r){
            //推荐人id
            $tj_id = $r[0]->pid;
            //用户id
            $user_id = $r[0]->user_id;
            //反序列化出提成比例数组
            $sets = unserialize($r[0]->sets);
            // lt
            $lt = $r[0]->lt;
            // rt
            $rt = $r[0]->rt;
            // 分销层级
            $uplevel = $r[0]->uplevel;
            // 三级的比例
            $num = [$sets['b_yi'],$sets['b_er'],$sets['b_san']];
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        //获取目前设置的分销商品
        $sql ="select a.id from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.is_distribution = 1 and a.num >0 group by c.pid ";
        $products = $db->select($sql);
        foreach ($products as $key => $value) {
            $products[$key] = $value->id;
        }
        $products = (array)$products;

        $array02 = 0;
        for ($j=1; $j <= count($num); $j++) {

            $uplevel = $uplevel+$j;
            $sqlxj = "select * from lkt_user_distribution where store_id = '$store_id' and pid = '$user_id' and lt>'$lt' and rt<'$rt' and uplevel = '$uplevel' ";
            $obj = $db -> select($sqlxj);

            if($obj){
                for ($i=0; $i < count($obj); $i++) {
                    if($i > 1000){
                        break;
                    }else{
                        $uid = $obj[$i]->user_id;
                        //可提金额
                        $sql01 = "select lo.allow,lo.z_price,lo.spz_price,lo.reduce_price,lo.coupon_price,lc.img,lod.p_name,lod.r_status,lod.id,lod.add_time,lod.p_price,lod.p_id from lkt_order as lo LEFT JOIN lkt_order_details as lod ON lo.sNo = lod.r_sNo LEFT JOIN lkt_configure as lc ON lc.id = lod.sid where lo.store_id = '$store_id' and lod.user_id = '$uid' and lo.drawid = '0' and lod.r_status = 5 ";
                        $rew2 = $db->select($sql01);

                        if($rew2){
                            foreach ($rew2 as $key => $value) {
                                if(in_array($value->p_id, $products)){
                                    //计算出实际付款金额 并生成比例 和佣金
                                    $p_price = $value->p_price;
                                    $spz_price = $value->spz_price=='0.00' ? 1:$value->spz_price;
                                    $z_price = $value->z_price;

                                    if($z_price == $p_price || $z_price == $spz_price){
                                        $price = $z_price;
                                    }else{
                                        $price = number_format($z_price / $spz_price * $p_price, 2, ".", "");
                                    }

                                    $zqprice = number_format($price/100*$num[$j], 2, ".", "");

                                    $array02 += $zqprice;
                                }
                            }

                        }
                    }

                }
            }
        }
        //查询提现过多少钱
        $sql = "select SUM(money) as money from lkt_record where store_id = '$store_id' and user_id = '$user_id' and type = 6";
        $r_6 = $db->select($sql);
        if($r_6){
            $money =  $r_6[0]-> money;
        }else{
            $money = 0;
        }

        //计算后的可提现金额
        $array02 = $array02 - $money;
        if($tmoney <= $array02 && $tmoney >0 ){
            $sql = "update lkt_user set money = money+'$tmoney' where store_id = '$store_id' and wx_id = '$openid'";
            $r = $db->update($sql);
            if($r){
                $event = '用户 ' . $user_id . ' 使用分销提现了 ' . $money.'元';
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$tmoney','$array02','$event',6)";
                $rr = $db->insert($sqll);
            }else{
                $res = array('err' => '提现失败!','status'=>false);
                echo json_encode($res);
                exit;
            }
        }

        $res = array('succ' => '提现成功!','status'=>true);
        echo json_encode($res);
        exit;
    }
    //显示分销商品
    public function Distribution_products()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $paegr = trim($request->getParameter('page'));
        $openid = trim($request->getParameter('openid'));

        // 查询会员信息
        $sql = "select g.*,u.user_id,u.user_name from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_user as u  ON d.user_id = u.user_id where u.store_id = '$store_id' and u.wx_id = '$openid' ";
        $r = $db -> select($sql);
        if($r){
            $user_id = $r[0]->user_id;
            $sets = unserialize($r[0]->sets);
            $one = $sets['b_yi'];

            if(!$paegr){
                $paegr = 1;
            }

            $start = ($paegr-1)*10;
            $end = 10;

            $sql ="select a.id,a.product_title,a.volume,min(c.price) as price,c.yprice,a.imgurl from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.is_distribution = 1 and a.num >0 and a.distributor_id = 0 and a.recycle = 0 and a.status = 0 group by c.pid order by a.id desc LIMIT $start,$end ";
            $rr = $db->select($sql);
            if($rr){
                $product = [];
                foreach ($rr as $k => $v) {
                    $imgurl = ServerPath::getimgpath($v->imgurl);
                    
                    $product[$k] = array('id' => $v->id,'name' => $v->product_title ,'image' => $v->imgurl,'yprice' => $v->yprice,'price' => $v->price,'price_z' => number_format($v->price/100*$one, 2,".",""),'imgurl' => $imgurl,'volume' => $v->volume);
                }
                echo json_encode(array('status'=>1,'list'=>$product));
                exit;
            }else{
                echo json_encode(array('status'=>0,'err'=>'没有了！'));
                exit;
            }
        }else{
            echo json_encode(array('status'=>0,'err'=>'没有了！'));
            exit;
        }

    }


    //显示订单明细
    public function Distribution_order()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $openid = $_POST['openid']; // 微信id

        // 查询会员信息
        $sql = "select g.*,u.user_id,u.user_name,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_user as u  ON d.user_id = u.user_id where u.store_id = '$store_id' and u.wx_id = '$openid' ";

        $and = '';
        //当前页码
        $page = trim($request -> getParameter('page'));
        //选择的类型
        $type = trim($request -> getParameter('type'));
        //已完成的子状态
        $status = trim($request -> getParameter('status'));
        //操作分页显示
        $start = 10*$page;
        $end = 10;
        //类型判断 添加sql条件
        if($type == 'all'){
            //全部订单
            $and .= " and lod.r_status >='0' and lod.r_status <= '6' ";
        }else if($type == 'effective'){
            //有效订单
            if($status == 'payment'){

                //已付款订单
                $and .= " and (lod.r_status ='1' or lod.r_status ='2' or lod.r_status ='3' ) ";

            }else if($status == 'received'){

                //已收货订单
                $and .= " and (lod.r_status ='3' or lod.r_status ='5' ) ";

            }else if($status == 'settlement'){

                //已结算订单
                $and .= " and (lod.r_status ='5' or lod.r_status ='6' ) ";

            }
        }else if($type == 'invalid'){
            //失效订单
            $and .= " and (lod.r_status ='0' or lod.r_status ='4' ) ";
        }

        $r = $db -> select($sql);
        if($r){
            //推荐人id
            $tj_id = $r[0]->pid;
            //用户id
            $user_id = $r[0]->user_id;
            //反序列化出提成比例数组
            $sets = unserialize($r[0]->sets);
            // lt
            $lt = $r[0]->lt;
            // rt
            $rt = $r[0]->rt;
            // 分销层级
            $level = $r[0]->uplevel;
            // 三级的比例
            $num = [$sets['b_yi'],$sets['b_er'],$sets['b_san']];
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        // 储存订单信息
        $orders = [];

        //获取目前设置的分销商品
        $sql ="select a.id from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.recycle = 0 and a.status = 0 and a.is_distribution = 1 and a.num >0 group by c.pid ";
        $products = $db->select($sql);
        foreach ($products as $key => $value) {
            $products[$key] = $value->id;
        }
        $products = (array)$products;


        $keys = 0;
        for ($j=1; $j <= count($num); $j++) {

            $uplevel = $level+$j;
            $sqlxj = "select * from lkt_user_distribution where store_id = '$store_id' and lt>'$lt' and rt<'$rt' and uplevel = '$uplevel' ";
            $obj = $db -> select($sqlxj);
            // var_dump($obj,$sqlxj);
            if($obj){
                for ($i=0; $i < count($obj); $i++) {
                    if($i > 1000){
                        break;
                    }else{
                        $uid = $obj[$i]->user_id;
                        //显示订单
                        $sql01 = "select lo.allow,lo.z_price,lo.spz_price,lo.reduce_price,lo.coupon_price,lc.img,lod.p_name,lod.r_status,lod.id,lod.add_time,lod.p_price,lod.p_id,lo.sNo from lkt_order as lo LEFT JOIN lkt_order_details as lod ON lo.sNo = lod.r_sNo LEFT JOIN lkt_configure as lc ON lc.id = lod.sid where lo.store_id = '$store_id' and lod.user_id = '$uid' and lo.drawid = '0' $and order by lod.add_time DESC LIMIT $start,$end";
                        $rew = $db->select($sql01);
                        if($rew){
                            foreach ($rew as $key => $value) {
                                //计算出实际付款金额 并生成比例 和佣金
                                if(in_array($value->p_id, $products)){
                                    $p_price = $value->p_price;
                                    $spz_price = $value->spz_price=='0.00' ? 1:$value->spz_price;
                                    $z_price = $value->z_price;

                                    if($z_price == $p_price || $z_price == $spz_price){
                                        $price = $z_price;
                                    }else{
                                        $price = number_format($z_price / $spz_price * $p_price, 2, ".", "");
                                    }
                                    $sNo = $value->sNo;
                                    $ss_num =isset($num[$j]) ? $num[$j]:0;
                                    $value->zqprice = $this->yj_find($db,$sNo,$user_id);
                                    //显示订单状态和背景颜色
                                    switch ($value->r_status) {
                                        case 0:
                                            $value->status ='未付款';
                                            $value->bgcolor ='#999999';
                                            break;
                                        case 1:
                                            $value->status ='未发货';
                                            $value->bgcolor ='#45C9CB';
                                            break;
                                        case 2:
                                            $value->status ='待收货';
                                            $value->bgcolor ='#2B9CD5';
                                            break;
                                        case 3:
                                            $value->status ='待评论';
                                            $value->bgcolor ='#FF6347';
                                            break;
                                        case 4:
                                            $value->status ='退货';
                                            $value->bgcolor ='#999999';
                                            break;
                                        case 6:
                                            $value->status ='订单关闭';
                                            $value->bgcolor ='#999999';
                                            break;
                                        case 5:
                                            $value->status ='已签收';
                                            $value->bgcolor ='#31C05D';
                                            break;
                                    }
                                    $value->extract = $value->zqprice ? number_format($value->zqprice  / $z_price , 3, ".", "") * 100:0;
                                    $value->imgurl  =  ServerPath::getimgpath($value->img);
                                    $orders[$keys++] = $value;
                                }
                            }
                        }
                    }
                }
            }
        }

        $arrnum = array('orders' => $orders,'status'=>true,'title'=>'销售明细');
        echo json_encode($arrnum);
        exit;
    }


    //查找佣金
    public function yj_find($db,$sNo,$user_id)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql_c = "select money from lkt_distribution_record where store_id = '$store_id' and user_id = '$user_id' and sNo= '$sNo' ";
        $r_c = $db->select($sql_c);
        return $r_c ? $r_c[0]->money:0;
    }

    //显示我的团队
    public function mytean()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $openid = $_POST['openid']; // 微信id

        // 查询会员信息
        $sql = "select g.*,u.user_id,u.user_name,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_user as u  ON d.user_id = u.user_id where u.store_id = '$store_id' and u.wx_id = '$openid' ";
        $r = $db -> select($sql);

        if($r){
            //推荐人id
            $tj_id = $r[0]->pid;
            //用户id
            $user_id = $r[0]->user_id;
            //反序列化出提成比例数组
            $sets = unserialize($r[0]->sets);
            // lt
            $lt = $r[0]->lt;
            // rt
            $rt = $r[0]->rt;
            // 分销层级
            $level = $r[0]->uplevel;
            // 三级的比例
            $num = [$sets['b_yi'],$sets['b_er'],$sets['b_san']];
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        // 储存订单信息
        $users = [];

        $zong = 0;

        $keys = 0;
        for ($j=1; $j <= count($num); $j++) {
            // $users[]
            $uplevel = $level+$j;
            $sqlxj = "select lud.*,u.user_name,u.headimgurl,u.Register_data from lkt_user_distribution as lud LEFT JOIN lkt_user as u ON u.user_id = lud.user_id where u.store_id = '$store_id' and lt>'$lt' and rt<'$rt' and uplevel = '$uplevel' ";
            $obj = $db -> select($sqlxj);

            if($obj){

                for ($i=0; $i < count($obj); $i++) {
                    $zong = $zong + 1;
                    if($i > 1000){
                        break;
                    }else{
                        $uid = $obj[$i]->user_id;
                        $ltrs = $obj[$i]->lt;
                        $rtrs = $obj[$i]->rt;
                        $uplevelrs = $obj[$i]->uplevel;
                        $uplevelrser = $obj[$i]->uplevel+3;

                        $sqlrs = "select u.user_name from lkt_user_distribution as lud LEFT JOIN lkt_user as u ON u.user_id = lud.user_id where u.store_id = '$store_id' and lt>'$ltrs' and rt<'$rtrs' and uplevel >= '$uplevelrs' and uplevel <= '$uplevelrser' ";

                        $objrs = $db -> selectrow($sqlrs);

                        $obj[$i]->num = $objrs;
                    }

                }
                $users[$j] = $obj;
            }
        }
        $data = [];
        $data['title']='我的客户';
        $data['nname']='客户总人数';

        $arrnum = array('users' => $users,'status'=>true,'zong'=>$zong,'data'=>$data);
        echo json_encode($arrnum);
        exit;
    }

    public function record()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 接收信息
        $openid = trim($request->getParameter('openid'));

        // 查询会员信息
        $sql = "select * from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r_2 = $db -> select($sql);
        if($r_2){
            $user_id = $r_2[0]->user_id; // 用户id
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        // 根据用户id、类型为充值,查询操作列表-----入账记录
        $sql = "select money,add_date,type from lkt_distribution_record where store_id = '$store_id' and user_id = '$user_id' and (type = 1 or type = 3) order by add_date desc";
        $r_5 = $db->select($sql);
        $list_1 = [];
        if($r_5){
            foreach ($r_5 as $k => $v) {
                $v->time = substr($v->add_date,0,strrpos($v->add_date,':'));
                $list_1[$k]=$v;
            }
        }
        $sql = "select money,add_date,type from lkt_distribution_record where store_id = '$store_id' and user_id = '$user_id' and (type = 4 or type = 5) order by add_date desc";
        $r_6 = $db->select($sql);
        if($r_6){
            foreach ($r_6 as $k => $v) {
                $v->time = substr($v->add_date,0,strrpos($v->add_date,':'));
                if($v->type == '4'){
                    $v->money = '-'.$v->money;
                }else{
                    $v->money = '+'.$v->money;
                }
            }
            $list_2 = $r_6;
        }else{
            $list_2 = [];
        }
        echo json_encode(array('status'=>1,'list_1'=>$list_1,'list_2'=>$list_2));
        exit();
    }
}
?>