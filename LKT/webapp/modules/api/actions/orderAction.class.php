<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/coupon_pluginAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once('Apimiddle.class.php');

class orderAction extends Apimiddle {

    public function getDefaultView() {

        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    //处理返回可选退货类型
    public function return_type()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $id = trim($request->getParameter('id')); //订单id
        $oid = trim($request->getParameter('oid')); // 订单号
        $sql = "select r_status from lkt_order_details where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        if($r){
            $status = $r[0]->r_status;
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }
        //状态 0：未付款 1：未发货 2：待收货 3：待评论 4：退货 5:已完成 6 订单关闭 9拼团中 10 拼团失败-未退款 11 拼团失败-已退款''',
        // itemList: ['退货退款', '仅退款','换货'],
        // itemList_text:'退货退款',
        // tapIndex:1
        $arrayType1 = array('text' => '退货退款','id' => '1');
        $arrayType2 = array('text' => '仅退款','id' => '2');
        $arrayType3 = array('text' => '换货','id' => '3');
        $arrayType = [$arrayType1,$arrayType2,$arrayType3];

        $itemList_text = '退货退款';
        $tapIndex=1;
        if($status == 1){
            $arrayType = [$arrayType2];
            $itemList_text = '仅退款';
            $tapIndex=2;
        }else if($status == 2){
            $arrayType = [$arrayType1,$arrayType2];
            $itemList_text = '退货退款';
            $tapIndex=1;
        }else{

        }
        echo json_encode(array('status'=>1,'arrayType'=>$arrayType,'itemList_text'=>$itemList_text,'tapIndex'=>$tapIndex));
        exit();
    }
    // 查询订单
    public function index(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        //查询当前正在执行的团信息
        // $group = $db -> select("select * from lkt_group_buy where is_show=1");
        // if(!empty($group)) list($groupmsg) = $group;

        // 获取信息
        $openid = $_POST['openid']; // 微信id
        $order_type = $_POST['order_type']; // 类型
        $otype = $_POST['otype']; // 类型
        if($otype == 'pay6'){
            // if(!empty($groupmsg)) $res = "and a.otype='pt' and a.pid='$groupmsg->status'"; // 我的拼团
            $res = "and a.otype='pt'"; // 我的拼团
        }else{
            $res = "";
        }
        if(!empty($order_type) && $order_type != $otype){
            if($otype =='pay6'){
                //拼团的状态没和其他订单状态共用字段，分开判断
                if($order_type == 'payment'){
                    $res .= "and a.status = 0 "; // 未付款
                }else if($order_type == 'send'){
                    $res .= "and a.status = 1 "; // 未发货
                }else if($order_type == 'receipt'){
                    $res .= "and a.status = 2 "; // 待收货
                }else if($order_type == 'evaluate'){
                    $res .= "and a.status = 3 "; // 待评论
                }else{
                    $res = "";
                }
            }else{
                if($order_type == 'payment'){
                    $status = 0;
                    $res .= "and a.status = '$status'"; // 未付款
                }else if($order_type == 'send'){
                    $status = 1;
                    $res .= "and a.status = '$status' "; // 未发货
                }else if($order_type == 'receipt'){
                    $status = 2;
                    $res .= "and a.status = '$status'"; // 待收货
                }else if($order_type == 'evaluate'){
                    $status = 3;
                    $res .= "and a.status = '$status'"; // 待评论
                }else{
                    $res = "";
                }
            }

        }


        // 根据微信id,查询用户id
        $sql = "select * from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r = $db -> select($sql);
        $user_id = $r[0]->user_id;

        $order = array();
        // 根据用户id和前台参数,查询订单表 (id、订单号、订单价格、添加时间、订单状态、优惠券id)
        $sql = "select id,z_price,sNo,add_time,status,coupon_id,pid,drawid,ptcode from lkt_order as a where store_id = '$store_id' and user_id = '$user_id' " . $res ." order by add_time desc";
        $r = $db->select($sql);

        $plugsql = "select status from lkt_plug_ins where store_id = '$store_id' and type = 0 and software_id = 3 and name like '%拼团%'";
        $plugopen = $db -> select($plugsql);
        $plugopen = !empty($plugopen)?$plugopen[0] -> status:0;

        if($r){
            foreach ($r as $k => $v) {
                $rew = [];
                $rew['id'] = $v->id; // 订单id
                $rew['z_price'] = $v->z_price; // 订单价格
                $rew['sNo'] = $v->sNo; // 订单号
                $sNo = $v->sNo; // 订单号
                $rew['add_time'] = $v->add_time; // 订单时间
                $rew['status'] = $v->status; // 订单状态
                $rew['coupon_id'] = $v->coupon_id; // 优惠券id

                $rew['ptcode'] = $v->ptcode; // 拼团号
                $rew['plugopen'] = $plugopen; // 拼团是否开启（0 未启用 1.启用）
                $coupon_id = $v->coupon_id; // 优惠券id

                $rew['lottery_status1'] ='';
                $rew['lottery_status'] ='';
                $rew['drawid'] =0;

                if($coupon_id == 0){ // 优惠券id为0
                    $rew['total'] = $rew['z_price']; // 总价为订单价格
                }else{
                    // 根据优惠券id,查询优惠券信息
                    $sql = "select * from lkt_coupon where store_id = '$store_id' and id = '$coupon_id' ";
                    $rr = $db->select($sql);
                    // var_dump($sql);
                    if($rr){
                        $expiry_time = $rr[0]->expiry_time; // 优惠券到期时间
                        $money = $rr[0]->money; // 优惠券金额
                        $time = date('Y-m-d H:i:s'); // 当前时间
                        if($expiry_time <= $time){
                            // 优惠券过期
                            // 根据优惠券id,修改优惠券状态
                            $sql = "update lkt_coupon set type = 3 where store_id = '$store_id' and id = '$coupon_id'";
                            $db->update($sql);
                            $rew['info'] = 0;
                        }else{ // 优惠券没过期
                            $rew['info'] = 1;
                        }
                        $rew['total'] = $rew['z_price'] + $money; // 总价为 订单价格+优惠券价格
                    }else{
                        $rew['total'] = $rew['z_price']; // 总价为订单价格
                    }

                }

                $rew['pname'] = '';

                // 根据订单号,查询订单详情
                $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' ";
                $rew['list'] = $db->select($sql);
                $product = [];
                if($rew['list']){
                    foreach ($rew['list'] as $key => $values) {
                        if(strpos($values -> r_sNo, 'PT') !== false){
                            $man_num = $db -> select("select group_data from lkt_group_product where store_id = '$store_id' and attr_id='$values->sid'");
                            $rew['man_num'] = !empty($man_num)?unserialize($man_num[0] -> group_data):0;
                            $rew['pro_id'] = $values->p_id;
                            $rew['is_group'] = true;
                        }else{
                            $rew['is_group'] = false;
                        }
                        $rew['pname'] .= $values->p_name; // 订单内商品
                        $p_id = $values->p_id; // 产品id
                        $arr = (array)$values;
                        // 根据产品id,查询产品列表 (产品图片)
                        $sql = "select imgurl from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                        $rrr = $db->select($sql);
                        if($rrr){
                            $img_res = $rrr['0']->imgurl;
                            $url = ServerPath::getimgpath($img_res); // 拼图片路径
                            $arr['imgurl'] = $url;
                            $product[$key]=(object)$arr;
                        }
                        $r_status = $values->r_status; // 订单详情状态

                        $sql_o = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' AND r_type = 0 AND r_status = '$r_status' and r_status != -1 ";
                        $res_o = $db->selectrow($sql_o);

                        $sql_d = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                        $res_d = $db->selectrow($sql_d);

                        // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                        if($res_o == $res_d){
                            //如果订单数量相等 则修改父订单状态
                            $sql = "update lkt_order set status = '$r_status' where store_id = '$store_id' and sNo = '$sNo'";
                            $r = $db->update($sql);
                        }
                    }
                    $rew['list'] = $product;
                }
                $order[] = $rew;
            }
        }else{
            $order = '';
        }

        echo json_encode(array('status'=>1,'order'=>$order));
        exit();
        return;
    }
    // 确认收货
    public function recOrder(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $id = trim($request->getParameter('id')); // 订单详情id
        $time = date('Y-m-d H:i:s');

        $sql01 = "select b.user_id,b.drawid,b.sNo from lkt_order_details as a ,lkt_order as b where b.store_id = '$store_id' and a.id = '$id' and b.sNo=a.r_sNo";
        $rew = $db->select($sql01);
        $user_id = $rew[0]->user_id;
        $sNo = $rew[0]->sNo ;

        if($rew[0]->drawid >0){
            // 根据订单详情id,修改订单详情
            $sql = "update lkt_order_details set r_status = 6,arrive_time = '$time' where store_id = '$store_id' and id = '$id'";
            $r = $db->update($sql);
            // 根据订单号,修改订单表
            $sql02 = "update lkt_order set status = 6,arrive_time = '$time' where store_id = '$store_id' and sNo = '$sNo'";
            $rew02 = $db->update($sql02);
        }else{
            // 根据订单详情id,修改订单详情
            $sql = "update lkt_order_details set r_status = 3,arrive_time = '$time' where store_id = '$store_id' and id = '$id'";
            $r = $db->update($sql);
        }
        if($r>0){
            $coupon = new coupon_pluginAction();
            $coupon_list = $coupon->give($store_id,$user_id,'shopping',$sNo);

            $this->db = $db;
            $this->user_id = $user_id;
            $this->store_id = $store_id;
            $this->check_invitation($user_id);

            echo json_encode(array('status'=>1,'err'=>'操作成功!'));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit();
        }
        return;
    }

    // 确认收货
    public function ok_Order(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $db->begin();
        // 获取信息
        $sNo = trim($request->getParameter('sNo')); // 订单号
        $time = date('Y-m-d H:i:s');

        $sql01 = "select user_id,otype from lkt_order where store_id = '$store_id' and sNo='$sNo'";
        $rew = $db->select($sql01);
        if($rew){
            $user_id = $rew[0]->user_id;

            $sql_1 = "update lkt_order_details set r_status = 3, arrive_time = '$time' where store_id = '$store_id' and r_sNo = '$sNo' and r_status = '2'";
            $r_1 = $db->update($sql_1);
            if($r_1 < 1){
                $db->rollback();
                echo json_encode(array('status'=>0,'err'=>'操作失败!'));
                exit();
            }
            if($rew[0]->otype == 'pt') $r_1 = 1;
            $sql_2 = "update lkt_order set status = 3 where store_id = '$store_id' and sNo = '$sNo'";
            $r_2 = $db->update($sql_2);
            if($r_2 < 1){
                $db->rollback();
                echo json_encode(array('status'=>0,'err'=>'操作失败!'));
                exit();
            }
        }

        if($r_1 >0 && $r_2 > 0){
            $coupon = new coupon_pluginAction();
            $coupon_list = $coupon->give($store_id,$user_id,'shopping',$sNo);
            $this->db = $db;
            $this->user_id = $user_id;
            $this->store_id = $store_id;
            $aaa = $this->check_invitation($user_id);
            // $db->rollback(); 
            $db->commit();
            // var_dump($aaa);$db->commit(); 
            echo json_encode(array('status'=>1,'coupon_list'=>$coupon_list,'err'=>'操作成功!'));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit();
        }
        return;
    }

    // 查看物流
    public function logistics(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $id = trim($request->getParameter('id'));// 订单详情id
        $details = $request->getParameter('details');
        $type = trim($request->getParameter('type'));
        // 根据订单详情id,修改订单详情
        if($details){
            $sql = "select express_id,courier_num from lkt_order_details where store_id = '$store_id' and r_sNo = '$id' AND id = '$details'";
            $r = $db->select($sql);
        }else{
            $sql = "select express_id,courier_num from lkt_order_details where store_id = '$store_id' and r_sNo = '$id'";
            $r = $db->select($sql);
        }

        if(!empty($r[0]->express_id) && !empty($r[0]->courier_num)){
            $express_id = $r[0]->express_id;//快递公司ID
            $courier_num = $r[0]->courier_num;//快递单号
            $sql01 = "select * from lkt_express where id = '$express_id'";
            $r01 = $db->select($sql01);
            $type = $r01[0]-> type;//快递公司代码
            $kuaidi_name = $r01[0]-> kuaidi_name;
            $url = "http://www.kuaidi100.com/query?type=$type&postid=$courier_num";
            $res = $this->httpsRequest($url);
            $res_1 = json_decode($res);
            echo json_encode(array('status'=>1,'res_1'=>$res_1,'name'=>$kuaidi_name,'courier_num'=>$courier_num));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'暂未查到!'));
            exit();
        }

    }

    function httpsRequest($url, $data=null) {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if(!empty($data)) {
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

    // 取消订单
    public function removeOrder(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $openid = $request->getParameter('openid');// 微信id
        $id = trim($request->getParameter('id'));// 订单id

        $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $rr = $db->select($sql);
        if($rr){
            $user_id = $rr[0]->user_id; // 用户id
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        // 根据订单id,查询订单列表(订单号)
        $sql = "select z_price,sNo,status,coupon_id from lkt_order where store_id = '$store_id' and id = '$id' and user_id = '$user_id' ";
        $r = $db->select($sql);
        if($r){
            $z_price = $r[0]->z_price; // 订单价
            $sNo = $r[0]->sNo; // 订单号
            $status = $r[0]->status; // 订单状态
            $coupon_id = $r[0]->coupon_id; // 优惠券id
            
            if($coupon_id != 0){
                // 根据优惠券id,查询优惠券信息
                $sql = "select * from lkt_coupon where store_id = '$store_id' and id = '$coupon_id' ";
                $r_c = $db->select($sql);
                $expiry_time = $r_c[0]->expiry_time; // 优惠券到期时间
                $time = date('Y-m-d H:i:s'); // 当前时间
                if($expiry_time <= $time){
                    // 根据优惠券id,修改优惠券状态
                    $sql = "update lkt_coupon set type = 2 where store_id = '$store_id' and id = '$coupon_id'";
                    $db->update($sql);
                }else{
                    // 根据优惠券id,修改优惠券状态
                    $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and id = '$coupon_id'";
                    $db->update($sql);
                }
            }

            $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
            $r_0 = $db->select($sql);
            if($r_0){
                foreach ($r_0 as $k => $v){
                    $p_id = $v->p_id;
                    $num = $v->num;
                    $sid = $v->sid;
                    $sql = "update lkt_product_list set num = num + $num where id = '$p_id'";
                    $db->update($sql);

                    $sql = "update lkt_configure set num = num + $num where pid = '$p_id' and id = '$sid' ";
                    $db->update($sql);
                }
            }

            // 根据订单号,修改订单表信息
            $sql = "update lkt_order_details set r_status = 6 where store_id = '$store_id' and r_sNo = '$sNo'";
            $r_2 = $db->update($sql);
            // 根据订单号,修改订单表
            $sql02 = "update lkt_order set status = 6 where store_id = '$store_id' and sNo = '$sNo'";
            $r_1 = $db->update($sql02);


            if($r_1>0 && $r_2>0){
                if($status == 1){
                    $sql = "update lkt_user set money = money + '$z_price' where store_id = '$store_id' and user_id = '$user_id'";
                    $db->update($sql);
                }
                echo json_encode(array('status'=>1,'err'=>'操作成功!'));
                exit();
            }else{
                echo json_encode(array('status'=>0,'err'=>'操作失败!'));
                exit();
            }
        }else{
            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit();
        }
        return;
    }
    // 订单详情
    public function order_details(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $id = $_POST['order_id']; // 订单id
        $type1 = $_POST['type1']; //

        $sql = "select sNo,z_price,add_time,name,mobile,address,drawid,user_id,status,coupon_id,coupon_activity_name,otype,ptcode,red_packet from lkt_order where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);

        if($r){
            $sNo = $r[0]->sNo; // 订单号
            $z_price = $r[0]->z_price; // 总价
            $add_time = $r[0]->add_time; // 订单时间
            $name = $r[0]->name;//联系人
            $num = $r[0]->mobile;//联系手机号
            $mobile = substr_replace($num,'****',3,4);//隐藏操作
            $address = $r[0]->address;//联系地址
            $user_id = $r[0]->user_id;//成员id
            $status = $r[0]->status;//订单状态
            $gstatus = $r[0]->status;//订单状态
            $otype = $r[0]->otype;//订单状态
            $ptcode = $r[0]->ptcode;//订单状态
            $red_packet = $r[0]->red_packet;//红包

            // 判断红包使用
            if ($red_packet >0 && $red_packet != 'unll') {
                $red_packet = $red_packet;
            }else{
                $red_packet = 0;
            }

            if($status){
                $user_money = false;
            }else{
                $o_user_money = "select money from lkt_user where store_id = '$store_id' and user_id ='$user_id' " ;
                $o_user_money_res= $db->select($o_user_money);
                if($o_user_money_res){
                    $user_money = $o_user_money_res[0]->money;
                }else{
                    $user_money = false;
                }

            }

            $coupon_id = $r[0]->coupon_id;//优惠券id
            
            $coupon_activity_name ='';
            $coupon_activity_name = $r[0]->coupon_activity_name; // 满减活动名称
            if($coupon_id){
                $sql = "select money from lkt_coupon where store_id = '$store_id' and id = '$coupon_id'";
                $r_coupon = $db->select($sql);
                $coupon_money = $r_coupon[0]->money;
            }else{
                $coupon_money = 0;
            }
            $wx_id ='';
            $lottery_status ='';
            $type1 = 22;
            $drawid ='';

            $freight = 0;
            // 根据订单号,查询订单详情
            $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'" ;
            $list = $db->select($sql);
            if($list){
                foreach ($list as $key => $values) {
                    $freight += $values->freight;
                    // print_r($values->freight);
                    $p_id = $values->p_id; // 产品id
                    $sid = $values->sid;//属性id
                    $arrive_time = $values->arrive_time;
                    $date = date('Y-m-d 00:00:00', strtotime('-7 days'));
                    if($arrive_time != ''){
                        if($arrive_time < $date){
                            $values->info = 1;
                        }else{
                            $values->info = 0;
                        }
                    }else{
                        $values->info = 0;
                    }
                    $arr = (array)$values;
                    // 根据产品id,查询产品列表 (产品图片)
                    $sql = "select img,product_title from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = $p_id AND c.id= '$sid' ";
                    $rrr = $db->select($sql);
                    $url = ServerPath::getimgpath($rrr[0]->img); // 拼图片路径
                    $title = $rrr[0]->product_title;
                    $arr['imgurl'] = $url;
                    $arr['sid'] = $sid;
                    $product[$key]=(object)$arr;

                    $r_status = $values->r_status; // 订单详情状态
                    if($r_status){
                        $sql_o = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' AND r_type = 0 AND r_status = 4 ";
                        $res_o = $db->selectrow($sql_o);
                        $sql_d = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                        $res_d = $db->selectrow($sql_d);
                        // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                        if($res_o == $res_d){
                            //如果订单数量相等 则修改父订单状态
                            $sql = "update lkt_order set status = '$r_status' where store_id = '$store_id' and sNo = '$sNo'";
                            $r = $db->update($sql);
                        }
                        $status = $r_status;
                        $status1 = $r_status;
                    }else{
                        $status = $r_status;
                        $status1 = $r_status;
                    }

                    if($r){
                        if($r[0]->otype == 'pt'){
                            $product[$key] -> r_status = $gstatus;
                        }
                    }

                    $dr =$status1;
                }
                $list = $product;

            }
            $man_num = '';
            if($r){
                if($r[0]->otype == 'pt') {
                    $man_num = $db -> select("select group_data from lkt_group_product where store_id = '$store_id' and attr_id='$sid'");
                    $man_num = unserialize($man_num[0] -> group_data);
                }
            }

            $ores = $db->select("select * from lkt_order_config where store_id = '$store_id'");
            $dfh_time = $ores ? $ores[0]->order_failure:48;

            echo json_encode(array('status'=>1,'id'=>$id,'dfh_time'=>$dfh_time,'freight'=>$freight,'sNo'=>$sNo,'z_price'=>$z_price,'name'=>$name,'mobile'=>$mobile,'address'=>$address,'add_time'=>$add_time,'rstatus'=>$status,'list'=>$list,'lottery_status'=>$lottery_status,'type1'=>$type1,'otype'=>$otype,'man_num'=>$man_num,'ptcode' => $ptcode,'dr'=>$dr,'role'=>$role,'title'=>$title,'drawid'=>$drawid,'p_id'=>$p_id,'coupon_id'=>$coupon_id,'coupon_money'=>$coupon_money,'user_money' =>$user_money,'coupon_activity_name'=>$coupon_activity_name,'red_packet' =>$red_packet));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'系统繁忙！'));
            exit();
        }
        return;
    }

    // 退货申请
    public function ReturnData(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        //开启事务
        $db->begin();
        // 获取信息
        $id = $_POST['id']; // 订单详情id
        $oid = $_POST['oid']; // 订单号
        $otype = $_POST['otype']; // 状态

        $re_type = trim($request->getParameter('re_type'));
        $back_remark = htmlentities($_POST['back_remark']); // 退货原因

        $sql = "update lkt_order_details set r_status = 4,content = '$back_remark',r_type = 0,re_type = '$re_type',re_time=CURRENT_TIMESTAMP where store_id = '$store_id' and id = $id";
        $r = $db->update($sql);
        if ($r < 1) {
            $db->rollback();
            echo json_encode(array('status'=>0,'err'=>'系统繁忙5！'));
            exit();
        }

        $sql_o = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$oid' AND r_type = 0 AND r_status = 4 ";
        $res_o = $db->selectrow($sql_o);

        $sql_d = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$oid'";
        $res_d = $db->selectrow($sql_d);

        if($res_o == $res_d){
            //如果订单数量相等 则修改父订单状态
            $sql = "update lkt_order set status = 4 where store_id = '$store_id' and sNo = '$oid'";
            $r3 = $db->update($sql);
        }

            $sql04 = "update lkt_order set readd = 0 where store_id = '$store_id' and sNo = '$oid'"; // 申请退货修改已读字段变成未读字段
            $r04 = $db->update($sql04);

            $sql_o = "select id,MAX(r_status) as ss from lkt_order_details where store_id = '$store_id' and r_sNo = '$oid' and r_status != '4' ";
            $res_o = $db->select($sql_o);
            $ss = $res_o[0]->ss;
            if($ss){
                $sql_u = "update lkt_order set status = '$ss' where store_id = '$store_id' and sNo = '$oid' ";
                $r_u = $db->update($sql_u); 
            }
            
            $db->commit();

            if($r>0){
                echo json_encode(array('status'=>1,'succ'=>'申请成功！'));
                exit();
            }else{
                echo json_encode(array('status'=>0,'err'=>'系统繁忙4！'));
                exit();
            }
    }

    // 退货列表
    public function ReturnDataList(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $openid = $_POST['openid']; // 微信id
        $order_type = $_POST['order_type']; // 参数
        $sql = "select user_id from lkt_user where wx_id = '$openid'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id;
            if($order_type == 'whole'){

                $sql = "select * from lkt_order_details where store_id = '$store_id' and user_id = '$user_id' and (r_status = 4 OR r_type > 0)";
                $list = $db->select($sql);
                if($list){
                    foreach ($list as $k => $v) {
                        $p_id = $v->p_id;
                        $arr = (array)$v;
                        // 根据产品id,查询产品列表 (产品图片)
                        $sql = "select imgurl from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                        $rrr = $db->select($sql);
                        if($rrr){
                            $url = ServerPath::getimgpath($rrr[0]->imgurl); // 拼图片路径
                            $arr['imgurl'] = $url;
                            $product[$k]=(object)$arr;
                        }
                    }
                    $list = $product;
                    echo json_encode(array('status'=>1,'list'=>$list));
                    exit();
                }else{
                    echo json_encode(array('status'=>0,'list'=>''));
                    exit();
                }
            }else if($order_type == 'stay'){

                $sql = "select * from lkt_order_details where store_id = '$store_id' and user_id = '$user_id' and r_status = 4 and r_type = 0";
                $list = $db->select($sql);
                if($list){
                    foreach ($list as $k => $v) {
                        $p_id = $v->p_id;
                        $arr = (array)$v;
                        // 根据产品id,查询产品列表 (产品图片)
                        $sql = "select imgurl from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                        $rrr = $db->select($sql);
                        if($rrr){
                            $url = ServerPath::getimgpath($rrr[0]->imgurl); // 拼图片路径
                            $arr['imgurl'] = $url;
                            $product[$k]=(object)$arr;
                        }

                    }
                    $list = $product;
                    echo json_encode(array('status'=>1,'list'=>$list));
                    exit();
                }else{
                    echo json_encode(array('status'=>0,'list'=>''));
                    exit();
                }
            }
        }else{

            echo json_encode(array('status'=>0,'list'=>''));
            exit();
        }

        return;
    }
    //储存快递回寄信息
    public function back_send(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $kdcode = trim($request->getParameter('kdcode'));
        $kdname = trim($request->getParameter('kdname'));
        $lxdh = trim($request->getParameter('lxdh'));
        $lxr = trim($request->getParameter('lxr'));
        $uid = trim($request->getParameter('uid'));
        $oid = trim($request->getParameter('oid'));

        $sql = "insert into lkt_return_goods(store_id,name,tel,express,express_num,uid,oid,add_data) values('$store_id','$lxr','$lxdh','$kdname','$kdcode','$uid','$oid',CURRENT_TIMESTAMP)";
        $rid = $db->insert($sql,'last_insert_id');

        $sql = "update lkt_order_details set r_type = 3 where store_id = '$store_id' and id = '$oid'";
        $r = $db->update($sql);

        if($r){
            echo json_encode(array('status'=>1,'err'=>'操作成功!'));
            exit();
        }else{
            $sql = "delete from lkt_return_goods where store_id = '$store_id' and id = '$rid'";
            $db->delete($sql);

            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit();
        }
    }
    //返回快递信息
    public function see_send(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $sql = "select address_xq,name,tel from lkt_service_address where store_id = '$store_id' and uid = 'admin' and is_default=1";
        $r_1 = $db->select($sql);
        if($r_1){
            $address = $r_1[0]->address_xq;
            $name = $r_1[0]->name;
            $phone = $r_1[0]->tel;
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        $sql_1 = "select * from lkt_express ";
        $r_2 = $db->select($sql_1);

        if($r_2){
            echo json_encode(array('status'=>1,'address'=>$address,'name'=>$name,'phone'=>$phone,'express'=>$r_2));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'操作失败!'));
            exit();
        }
    }
    //临时存放微信付款信息
    public function up_out_trade_no(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $coupon_id = trim($request->getParameter('coupon_id')); // 优惠券id
        $allow = trim($request->getParameter('allow')); // 用户使用消费金
        $coupon_money = trim($request->getParameter('coupon_money')); // 付款金额
        $order_id = trim($request->getParameter('order_id')); // 订单号
        $user_id = trim($request->getParameter('user_id')); // 微信id
        $d_yuan = trim($request->getParameter('d_yuan')); // 抵扣余额
        $trade_no = trim($request->getParameter('trade_no')); // 微信支付单号
        $pay =  trim($request->getParameter('pay'));
        $array = array('coupon_id' => $coupon_id,'allow' => $allow,'coupon_money' => $coupon_money,'order_id' => $order_id,'user_id' => $user_id,'d_yuan' => $d_yuan,'trade_no' => $trade_no,'pay' => $pay);
        $data = serialize($array);

        $sql_u = "update lkt_order set trade_no='$trade_no' where store_id = '$store_id' and sNo = '$order_id' ";
        $r_u = $db->update($sql_u);

        $sql = "insert into lkt_order_data(trade_no,data,addtime) values('$trade_no','$data',CURRENT_TIMESTAMP)";
        $rid = $db->insert($sql);

        $yesterday= date("Y-m-d",strtotime("-1 day"));
        $sql = "delete from lkt_order_data where addtime < '$yesterday'";
        $db->delete($sql);

        echo json_encode(array('status'=>$r_u));
        exit();
    }
    //提醒发货
    public function delivery_delivery()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $order_id = trim($request->getParameter('order_id')); // 订单号
        //delivery_status 0:未提醒  1:提醒中
        $order = $db->select("select delivery_status from lkt_order where store_id = '$store_id' and sNo = '$order_id' and delivery_status = '0' ");
        if($order){
            $sql_u = "update lkt_order set delivery_status='1' where store_id = '$store_id' and sNo = '$order_id' ";
            $r_u = $db->update($sql_u);
            echo json_encode(array('status'=>1,'succ' => '提醒成功！'));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err' => '已经提醒过了,请稍后再试！'));
            exit();
        }
    }

    /**
     * [freight description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  sutao
     * @version 2.0
     * @date    2018-12-10T11:41:47+0800
     * @param   [type]        购物的商品            $products [arrray]
     * @param   [type]        用户地址              $address  [array]
     * @param   [type]        数据库连接标识         $db       [obj]
     * @return  [type]        返回运费金额                     [description]
     */
    public function freight($products, $address, $db)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        //先按按照模板id重新创建数组
        $freight_array = [];
        foreach ($products as $key => $value) {
            $freight_array[$value['freight_id']][] = $value;
        }

        // var_dump($products, $address,$freight_array);exit;
        $yunfei = 0;
        $farray = [];
        foreach ($freight_array as $key_f => $value_f) {
            //查找默认运费模板
            if($key_f){
                $sql = "select * from lkt_freight where store_id = '$store_id' and id = '$key_f'";
            }else{
                $sql = "select * from lkt_freight where store_id = '$store_id' and is_default = '1'";
            }
            $r_1 = $db->select($sql);

            if ($r_1) {
                $rule = $r_1[0];
                //类型
                $type = $rule->type;
                //防止空地址报错
                if (empty($address)) {
                    // return 0;
                }else{
                    $num = 0;//数量
                    $g = 0;//重量
                    foreach ($value_f as $k => $v) {  
                        $num += $v["num"];
                        $g += $v["weight"];
                    }
                    $sheng = $address['sheng'];

                    $sql2 = "select G_CName from admin_cg_group where GroupID = '$sheng'";
                    $r_2 = $db->select($sql2);
                    if ($r_2) {
                            //查找省
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
                                        $yfmb = 0;
                                        //根据规则计算方式不同计算运费 类型 0:件 1:重量
                                        if($type == "0"){
                                            //件方式计算
                                            if ($num > intval($value['three'])) {
                                                $yfmb += $value['two'];
                                                $yfmb += ($num - $value['three']) * $value['four'];
                                            } else {
                                                $yfmb += $value['two'];
                                            }
                                        }else{
                                            if ($g > intval($value['three'])) {
                                                $yfmb += $value['two'];
                                                $yfmb += ceil(($g - $value['one'])/$value['three']) * $value['four'];
                                                
                                            } else {
                                                // 当购买数量低于或等于首件数量时
                                                $yfmb += $value['two'];
                                            }
                                        }
                                        $yunfei += $yfmb;
                                        $farray['freight_id'][$key_f] = number_format($yfmb / $num, 2, ".", "");
                                }else{
                                        $farray['freight_id'][$key_f] = 0;
                                }
                            }
                    }
                }
            }
        }
        $farray['totle'] = $yunfei;
        return $farray;
    }

    // 创建订单操作
    public function payment()
    {
        $db = DBAction::getInstance();
        //开启事务
        $db->begin();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $cart_id = trim($request->getParameter('cart_id')); // 购物车id
        $uid = trim($request->getParameter('uid')); // 微信id
        $type = trim($request->getParameter('type')); // 用户支付方式
        $coupon_id = trim($request->getParameter('coupon_id')); // 优惠券id
        $r_name = trim($request->getParameter('name')); // 自动满减金额名称
        $reduce_money = trim($request->getParameter('reduce_money')); // 自动满减金额
        $allow = trim($request->getParameter('allow')); // 用户使用积分
        $red_packet = trim($request->getParameter('red_packet')); // 用户使用红包
        $total = $_POST['total']; // 付款金额

        if ($r_name) {
            $coupon_activity_name = $r_name;
        } else {
            $coupon_activity_name = '';
        }
        // 根据微信id,查询用户id
        $sql_user = 'select user_id,money from lkt_user where store_id = \'' . $store_id . '\' and wx_id=\'' . $uid . '\'';
        $r_user = $db->select($sql_user);
        if($r_user){
            $userid = $r_user['0']->user_id; // 用户id
            $user_money = $r_user['0']->money; // 用户余额
        }else{
            echo json_encode(array('status' => 0, 'err' => '未知错误！'));
            exit;
        }


        if ($type == 'wallet_Pay' && $user_money < $total) { // 当余额小于付款金额
            echo json_encode(array('status' => 0, 'err' => '余额不足！'));
            exit;
        } else {
            // 根据用户id、默认地址,查询地址信息
            $sql_a = 'select * from lkt_user_address where store_id = \'' . $store_id . '\' and uid=\'' . $userid . '\' and is_default = 1';
            $r_a = $db->select($sql_a);
            if($r_a){
                $name = $r_a['0']->name; // 联系人
                $mobile = $r_a['0']->tel; // 联系电话
                $address = $r_a['0']->address_xq; // 加省市县的详细地址
                $sheng = $r_a['0']->sheng; // 省
                $shi = $r_a['0']->city; // 市
                $xian = $r_a['0']->quyu; // 县
            }
            $z_num = 0;
            $z_price = 0;

            $sNo = $this->order_number(); // 生成订单号
            // 根据省的id,查询省名称
            $sql = "select G_CName from admin_cg_group where GroupID = '$sheng'";
            $r1 = $db->select($sql);
            if ($r1) {
                $G_CName = $r1[0]->G_CName; // 省
            }

            $z_freight = 0; // 总运费

            //  拆分购物ID 依次插入数据库
            $typestr = trim($cart_id, ',');
            $typeArr = explode(',', $typestr);
            foreach ($typeArr as $key => $value) {
                // 联合查询返回购物信息
                $sql_c = "select a.Size_id,a.Goods_num,a.Goods_id,a.id,m.product_title,m.volume,m.freight,c.price,c.attribute,c.img,c.yprice,c.unit,m.weight  from lkt_cart AS a LEFT JOIN lkt_product_list AS m ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c ON a.Size_id = c.id where a.store_id = '$store_id' and a.id = '$value' and c.num >= a.Goods_num ";
                $r_c = $db->select($sql_c);
                if (!empty($r_c)) {
                    $product = (array)$r_c['0']; // 转数组
                    $product['photo_x'] = ServerPath::getimgpath($product['img']);/* 拼接图片链接*/
                    $num = $product['Goods_num']; // 商品数量
                    $z_num += $num; // 商品数量
                    $price = $product['price']; // 商品价格
                    $z_price += $num * $price; // 总价
                    $pid = $product['Goods_id']; // 商品id
                    $product_title = $product['product_title']; // 商品名称
                    $size_id = $product['Size_id']; // 商品Size_id
                    $unit = $product['unit'];
                    $freight_id = $r_c[0]->freight; // 运费id

                    $freight = 0; // 运费为0

                    $z_freight += $freight;

                    //写入配置
                    $attribute = unserialize($product['attribute']);
                    $size = '';
                    foreach ($attribute as $ka => $va) {
                        $size .= $va . ' ';
                    }
                    // 循环插入订单附表
                    $sql_d = 'insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,unit,r_sNo,add_time,r_status,size,sid,freight) VALUES ' . "('$store_id','$userid','$pid','$product_title','$price','$num','$unit','$sNo',CURRENT_TIMESTAMP,0,'$size','$size_id','$freight')";
                    $beres = $db->insert($sql_d,"last_insert_id");
                    if ($beres < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!'));
                        exit;
                    }

                    $freight_o[] = array('num' => $num,'od_id'=>$beres,'freight'=>$freight_id);

                    // 删除对应购物车内容
                    $sql_del = 'delete from lkt_cart where store_id = \'' . $store_id . '\' and id="' . $value . '"';
                    $res_del = $db->delete($sql_del);
                    if ($res_del < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!'));
                        exit;
                    }
                    $sql = "update lkt_product_list set volume = volume + $num,num = num - $num where id = '$pid'";
                    $res_del1 = $db->update($sql);
                    if($res_del1 < 1){
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!'));
                        exit;
                    }
                    $sql = "update lkt_configure set num = num - $num where pid = '$pid' and id = '$size_id'";
                    $res_del2 = $db->update($sql);
                    if($res_del2 < 1){
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!'));
                        exit;
                    }
                } else {
                    //回滚删除已经创建的订单
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!'));
                    exit;
                }
                $products_freight[] = array('pid' => $pid,'num'=>$product['Goods_num'],'freight_id'=>$product['freight'],'weight'=>$product['weight']);
            }
            $spz_price = $z_price; // 商品总价

            $freight = $this->freight($products_freight,(array)$r_a['0'], $db);
            $z_freight = $freight['totle'];
            $freight_ids = isset($freight['freight_id']) ? $freight['freight_id']:[];
            foreach ($freight_o as $kf => $vf) {
                if (array_key_exists($vf['freight'], $freight_ids)) {
                    $freight_price = ceil($freight_ids[$vf['freight']]*$freight_o[$kf]['num']);
                    $od_id = $vf['od_id'];
                    $sql_d = "update lkt_order_details set freight = $freight_price where id = '$od_id'";
                    $r_d_2 = $db->update($sql_d);
                }
            }

            // 判断积分使用
            if ($allow > 0 && $allow != 'undefined') {
                $z_price = $z_price - $allow;
            } else {
                $allow = 0;
            }
            // 判断红包使用
            if ($red_packet > 0 && $red_packet != 'undefined') {
                // $z_price = $z_price - $red_packet;
            } else {
                $red_packet = 0;
            }
            // 判断满减金额
            if ($reduce_money > 0 && $reduce_money != 'undefined') {
                $z_price = $z_price - $reduce_money;
            } else {
                $reduce_money = 0;
            }
            //判断优惠券
            if ($coupon_id) {
                $sql = "select * from lkt_coupon where store_id = '$store_id' and id = '$coupon_id'";
                $r_coupon = $db->select($sql);
                $c_money = $r_coupon[0]->money;
                $z_price = $z_price - $c_money;
            } else {
                $coupon_id = 0;
                $c_money = 0;
            }

            $z_price = $z_price + $z_freight; // 订单总价
            if ($z_price < 0) {
                //回滚删除已经创建的订单
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '订单金额有误!'));
                exit;
            }

            // 在订单表里添加一条数据
            $sql_o = 'insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,remark,pay,add_time,status,coupon_id,coupon_activity_name,spz_price,reduce_price,coupon_price,red_packet,source) VALUES ' .
                "('$store_id','$userid','$name','$mobile','$z_num','$z_price','$sNo','$sheng','$shi','$xian','$address',' ','$type',CURRENT_TIMESTAMP,0,'$coupon_id','$coupon_activity_name','$spz_price','$reduce_money','$c_money','$red_packet',1)";
            $r_o = $db->insert($sql_o, "last_insert_id");
            if ($r_o > 0) {
                //返回
                $db->commit();
                $arr = array('pay_type' => $type, 'sNo' => $sNo, 'coupon_money' => $z_price, 'coupon_id' => $coupon_id, 'order_id' => $r_o);
                echo json_encode(array('status' => 1, 'arr' => $arr));
                exit;
            } else {
                //回滚删除已经创建的订单
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!'));
                exit;
            }
        }
    }

    private function order_number($type = '')
    {
        if($type == 'PT'){
            $pay = 'PT';
        }else if($type == 'HB'){
            $pay = 'HB';
        }else{
            $pay = 'GM';
        }
        return $pay.date("ymdhis").rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }

    // 付款后修改订单状态,并修改商品库存-----计算分销
    public function up_order()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $coupon_id = trim($request->getParameter('coupon_id')); // 优惠券id
        $allow = trim($request->getParameter('allow')); // 用户使用消费金
        $coupon_money = trim($request->getParameter('coupon_money')); // 付款金额
        $order_id = trim($request->getParameter('order_id')); // 订单号
        $user_id = trim($request->getParameter('user_id')); // 微信id
        $d_yuan = trim($request->getParameter('d_yuan')); // 抵扣余额
        $trade_no = trim($request->getParameter('trade_no')); // 微信支付单号
        $pay = trim($request->getParameter('pay'));
        // 根据微信id,查询用户id
        $sql_user = 'select user_id,money from lkt_user where store_id = \'' . $store_id . '\' and wx_id=\'' . $user_id . '\'';
        $r_user = $db->select($sql_user);
        if ($r_user) {
            $userid = $r_user['0']->user_id; // 用户id
            $user_money = $r_user['0']->money; // 用户余额

            if ($d_yuan) {
                // 使用组合支付的时候 lkt_combined_pay
                $sql = "update lkt_user set money = money-'$d_yuan' where store_id = '$store_id' and user_id = '$userid'";
                $r = $db->update($sql);
                $weixin_pay = $coupon_money - $d_yuan;
                //写入日志
                $sqll = "insert into lkt_combined_pay (weixin_pay,balance_pay,total,order_id,add_time,user_id) values ('$weixin_pay','$d_yuan','$coupon_money','$order_id',CURRENT_TIMESTAMP,'$user_id')";
                $rr = $db->insert($sqll);
                // 根据修改支付方式
                $sql_combined = "update lkt_order set pay = 'combined_Pay' where store_id = '$store_id' and sNo = '$order_id' and user_id = '$userid' ";
                $r_combined = $db->update($sql_combined);

                //微信支付记录-写入日志
                $event = $userid . '使用组合支付了' . $coupon_money . '元--订单号:' . $order_id;
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$userid','$coupon_money','$d_yuan','$event',4)";
                $rr = $db->insert($sqll);
            }

            if ($trade_no) {
                //微信支付记录-写入日志
                $event = $userid . '使用微信支付了' . $coupon_money . '元--订单号:' . $order_id;
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$userid','$coupon_money','$d_yuan','$event',4)";
                $rr = $db->insert($sqll);
            }

            if ($coupon_money <= 0 && $allow > 0) {
                // 根据订单号、用户id,修改订单状态(未发货)
                $sql_u = "update lkt_order set status = 1,pay = 'consumer_pay',trade_no='$trade_no' where store_id = '$store_id' and sNo = '$order_id' and user_id = '$userid' ";
                $r_u = $db->update($sql_u);
            } else {
                // 根据订单号、用户id,修改订单状态(未发货)
                $rpay = '';
                if ($pay) {
                    $rpay = " ,pay = '$pay'";
                }
                $sql_u = "update lkt_order set status = 1 $rpay,trade_no='$trade_no' where store_id = '$store_id' and sNo = '$order_id' and user_id = '$userid' ";
                $r_u = $db->update($sql_u);
            }

            if ($allow && $coupon_money > 0) {
                // 使用组合支付的时候 lkt_combined_pay 消费金情况
                if ($pay == 'wallet_Pay') {
                    $zpay = 'balance_pay';
                } else {
                    $zpay = 'weixin_pay';
                }
                //写入日志
                $total = $allow + $coupon_money;
                $sqll = "insert into lkt_combined_pay ($zpay,consumer_pay,total,order_id,add_time,user_id) values ('$coupon_money','$allow','$total','$order_id',CURRENT_TIMESTAMP,'$user_id')";
                $rr = $db->insert($sqll);
                // 根据修改支付方式
                $sql_combined = "update lkt_order set pay = 'combined_Pay' where store_id = '$store_id' and sNo = '$order_id' and user_id = '$userid' ";
                $r_combined = $db->update($sql_combined);

                //微信支付记录-写入日志
                $event = $userid . '使用组合支付了' . $total . '元--订单号:' . $order_id;
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$userid','$coupon_money','$d_yuan','$event',4)";
                $rr = $db->insert($sqll);
            }

            // 根据用户id、优惠券id,修改优惠券状态(已使用)
            $sql = "update lkt_coupon set type = 2 where store_id = '$store_id' and user_id = '$userid' and id = '$coupon_id'";
            $db->update($sql);

            // 根据订单号,查询商品id、商品名称、商品数量
            $sql_o = "select p_id,num,p_name,sid from lkt_order_details where store_id = '$store_id' and r_sNo = '$order_id' ";
            $r_o = $db->select($sql_o);
            // 根据订单号,修改订单详情状态(未发货)
            $sql_d = "update lkt_order_details set r_status = 1 where store_id = '$store_id' and r_sNo = '$order_id' ";
            $r_d = $db->update($sql_d);
            // 修改产品数据库数量
            $pname = '';
            foreach ($r_o as $key => $value) {
                $pid = $value->p_id; // 商品id
                $num = $value->num; // 商品数量
                $p_name = $value->p_name; // 商品名称
                $sid = $value->sid; // 商品属性id
                $pname .= $p_name;
                // 根据商品id,修改商品数量
//                $sql_p = "update lkt_configure set  num = num - $num where id = $sid";
//                $r_p = $db->update($sql_p);
                // 根据商品id,修改卖出去的销量
//                $sql_x = "update lkt_product_list set volume = volume + $num,num = num-$num where store_id = '$store_id' and id = $pid";
//                $r_x = $db->update($sql_x);
            }

            if ($r_u) {
                // 根据订单号,查询订单id、订单金额
                $sql_id = "select * from lkt_order where store_id = '$store_id' and sNo = '$order_id' ";
                $r_id = $db->select($sql_id);
                $id = $r_id['0']->id; // 订单id
                $time = date("Y-m-d h:i:s", time()); // 当前时间
                // $ds =  $this->distribution($r_id);
                //分销结算-------假定是默认只有支付成功后计算发放佣金
                $fxsql = "select sNo from lkt_distribution_record where store_id = '$store_id' and sNo = '$order_id' and level = '1' ";
                $fxres = $db->select($fxsql);
                $ds = false;
                if (!$fxres) {
                    $ds = $this->distribution($r_id);
                }
                //分销结算结束

                echo json_encode(array('status' => 1, 'succ' => '操作成功!', 'sNo' => $order_id, 'coupon_money' => $coupon_money, 'id' => $id, 'pname' => $pname, 'time' => $time, 'qu' => $ds));
                exit;
            } else {
                echo json_encode(array('status' => 0, 'err' => '操作失败!'));
                exit;
            }
        } else {
            echo json_encode(array('status' => 0, 'err' => '操作失败!'));
            exit;
        }
    }


    

    public function distribution($order)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        //--------分销开关--------
        $sqlldc = "select * from lkt_distribution_config where store_id = '$store_id' ";
        $res_ldc = $db->select($sqlldc);
        $ldc_sets = unserialize($res_ldc[0]->sets);
        $c_cengji = $ldc_sets['c_cengji'];
        if($c_cengji < 1){
            return false;
        }

        //用户id和订单号
        $user_id = $order[0]->user_id;
        $sNo = $order[0]->sNo;
        //开启事务
        $db->begin();
        //循环订单
        $sql01 = "select lo.allow,lo.z_price,lo.spz_price,lo.reduce_price,lo.coupon_price,lod.p_name,lod.r_status,lod.id,lod.add_time,lod.p_price,lod.p_id,lod.r_sNo,lod.num,lpl.distributor_id,lpl.separate_distribution from lkt_order as lo LEFT JOIN lkt_order_details as lod ON lo.sNo = lod.r_sNo LEFT JOIN lkt_product_list as lpl ON lpl.id = lod.p_id where lo.store_id = '$store_id' and lod.r_sNo = '$sNo' and lo.drawid = '0' and lod.r_status !=0 and lod.r_status !=4 and(lpl.is_distribution ='1' OR lpl.separate_distribution > '0')";
        $rew = $db->select($sql01);
        if ($rew) {

            //获取目前设置的分销商品
            $sql = "select a.id from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.is_distribution = 1 and a.num >0 group by c.pid ";
            $products = $db->select($sql);
            foreach ($products as $key => $value) {
                $products[$key] = $value->id;
            }
            $products = (array)$products;

            //先查询好区域代理id和比例
            $qsql = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_agent = '1' ";
            $qres = $db->select($qsql);
            $qid = $qres[0]->id;

            $fxdlsid = [];
            $fxdlsyj = [];

            //循环每个订单 对应操作
            foreach ($rew as $key => $value) {
                //商品id
                $product = $value->p_id;
                //计算出实际付款金额 并生成比例 和佣金
                $p_price = $value->p_price;
                $spz_price = $value->spz_price == '0.00' ? 1 : $value->spz_price;
                $z_price = $value->z_price;

                $sql_o = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' ";
                $res_o = $db->selectrow($sql_o);
                //运费
                $sql_y = "select SUM(freight) as freight from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' ";
                $res_y = $db->select($sql_y);
                if ($res_y) {
                    $freight = $res_y[0]->freight;
                    $z_price = $z_price - $freight;
                }

                // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                if ($res_o == 1) {
                    $price = $z_price;
                } else {
                    $price = number_format($z_price / $spz_price * $p_price * $value->num, 2, ".", "");
                }
                //绑定的等级id
                $distributor_id = $value->distributor_id;
                //单独分销比例
                $separate_distribution = $value->separate_distribution;
                //判断是否是单独分销
                if ($separate_distribution > 0) {
                    $dd_res = $this->find_fenxiao($db, $user_id);
                    if ($dd_res) {
                        $lt = $dd_res->lt;
                        $rt = $dd_res->rt;
                        $uplevel = $dd_res->uplevel;
                        //是单独分销产品----单独发佣金
                        $sd_cmoney = [];
                        $separate_distribution_Arr = explode(',', $separate_distribution);
                        if ($separate_distribution_Arr) {
                            //实付金额
                            foreach ($separate_distribution_Arr as $ka => $va) {
                                if ($va > 1) {
                                    $cmoney = $va / $p_price * $price;
                                } else {
                                    $cmoney = $price * $va;
                                }
                                $sd_cmoney[$ka] = $cmoney;
                            }
                        } else {
                            $sd_cmoney[0] = $separate_distribution_str;
                        }
                        //给单独分销佣金
                        if (!empty($sd_cmoney)) {
                            $this->separate_distribution($user_id, $sd_cmoney, $sNo, $db, $lt, $rt, $uplevel, 1);
                        }
                    }

                    //给单独分销佣金完成
                } else {
                    //判断是否是有等级提升
                    if ($distributor_id > 0) {
                        //查询用户等级判断是否升级 等级关系
                        $sql011 = "select id,sort from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = 0";
                        $variable = $db->select($sql011);
                        $distribus = [];

                        $info_user = $this->find_fenxiao($db, $user_id);
                        if ($info_user) {
                            //列出等级关系----在升级
                            foreach ($variable as $kd => $vd) {
                                if ($vd->sort > $info_user->sort) {
                                    array_push($distribus, $vd->id);
                                }
                            }

                            if (in_array($distributor_id, $distribus)) {
                                //升级用户等级  --- 01
                                $sql = "update lkt_user_distribution set level = '$distributor_id' where store_id = '$store_id' and user_id = '$user_id'";
                                $beres = $db->update($sql);
                                if ($beres < 1) {
                                    $db->rollback();
                                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:40', 'sql' => $sql));
                                    exit;
                                }
                                //升级用户等级结束  --- 01
                                $info_user = $this->find_fenxiao($db, $user_id);
                                $this->grade_upgrading($db, $distributor_id, $user_id, $sNo, $info_user, $value, $qid, $price);
                            }
                        } else {
                            //加入分销
                            $this->create_level($db, $user_id, $distributor_id);
                            $info_user = $this->find_fenxiao($db, $user_id);
                            //发放佣金
                            $this->grade_upgrading($db, $distributor_id, $user_id, $sNo, $info_user, $value, $qid, $price);
                        }
                    } else {
                        $jben_res = $this->find_fenxiao($db, $user_id);
                        if ($jben_res) {
                            $lt = $jben_res->lt;
                            $rt = $jben_res->rt;
                            $uplevel = $jben_res->uplevel;
                            $this->jc_distribution($db, $lt, $rt, $user_id, $price, $sNo);
                        }
                    }
                }
            }
        }

        $db->commit();
        return true;

    }

    //创建分销等级和会员信息
    public function create_level($db, $user_id, $distributor_id)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $t_user_id = '0';
        //初始会员
        $sqlc = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$t_user_id'";
        $resc = $db->select($sqlc);
        //分销推荐
        if ($resc) {
            $sqlqw = "select user_id from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
            $resqw = $db->select($sqlqw);
            if (!$resqw) {
                $rt = $resc[0]->rt;
                $level = $distributor_id;
                $uplevel = $resc[0]->uplevel + 1;
                $ups01 = "update lkt_user_distribution set lt = lt + 2 where store_id = '$store_id' and lt>='$rt'";
                $ups02 = "update lkt_user_distribution set rt = rt + 2 where store_id = '$store_id' and rt>='$rt'";
                $lrt = $rt + 1;
                $ups03 = "INSERT INTO lkt_user_distribution ( `store_id`,`user_id`, `pid`, `level`, `lt`, `rt`, `uplevel`, `add_date`) VALUES ( '$store_id','$user_id', '$t_user_id', '$level', '$rt', '$lrt', '$uplevel', CURRENT_TIMESTAMP)";
                $beres1 = $db->update($ups01);
                $beres2 = $db->update($ups02);
                $beres3 = $db->insert($ups03);
                //事务
                if ($beres3 < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:30', 'sql' => $ups03 . $ups01 . $ups02));
                    exit;
                }
            }
        }
    }

    //单独分销
    public function separate_distribution($from_id, $sd_cmoney, $sNo, $db, $lt, $rt, $uplevel, $snum)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $num = count($sd_cmoney);
        $sqlxj = "select * from lkt_user_distribution as lud LEFT JOIN lkt_distribution_grade as ldg ON ldg.id = lud.level where lud.store_id = '$store_id' and lud.lt<'$lt' and lud.rt>'$rt' ORDER BY lud.uplevel desc LIMIT 0,$num ";
        $variable = $db->select($sqlxj);
        foreach ($variable as $key => $value) {
            if (isset($sd_cmoney[$key])) {
                $money = $sd_cmoney[$key] * $snum;
                $user_id = $value->user_id;
                if ($money && $money > 0.1 && $user_id) {
                    $sql = "update lkt_user set money = money+'$money' where store_id = '$store_id' and user_id = '$user_id'";
                    $beres = $db->update($sql);
                    if ($beres < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:01', 'sql' => $sql));
                        exit;
                    }
                    $event = $user_id . "获得了" . $money . "单独佣金";
                    $level = $key + 1;
                    $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$money','$sNo','$level','$event','1',CURRENT_TIMESTAMP)";
                    $beres = $db->insert($sqlldr);
                    //事务
                    if ($beres < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:02', 'sql' => $sqlldr));
                        exit;
                    }
                }
            }
        }
    }

    //基本分销佣金发放
    public function jc_distribution($db, $lt, $rt, $user_id, $price, $sNo)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        //基本分销佣金发放
        $sqlxj = "select * from lkt_user_distribution as lud LEFT JOIN lkt_distribution_grade as ldg ON ldg.id = lud.level where lud.store_id = '$store_id' and lud.lt<'$lt' and lud.rt>'$rt' ORDER BY lud.uplevel desc LIMIT 0,3 ";
        $obj = $db->select($sqlxj);
        //查找和发放分销佣金
        foreach ($obj as $key => $value) {
            $lsets = unserialize($value->sets);
            $luser = $value->user_id;
            if ($luser) {
                $bili = [$lsets['b_yi'], $lsets['b_er'], $lsets['b_san']];
                $price_type = $lsets['price_type'];
                if ($price_type) {
                    $yj = $bili[$key];
                } else {
                    $yj = $price * $bili[$key] / 100;
                }
                //写入佣金记录表
                if ($yj) {
                    $sql = "update lkt_user set money = money+'$yj' where store_id = '$store_id' and user_id = '$luser'";
                    $beres = $db->update($sql);
                    //事务
                    if ($beres < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:03', 'sql' => $sql));
                        exit;
                    }
                    //发钱 写记录
                    $event = $luser . '获得了' . $yj . '元佣金 ' . $sNo;
                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$luser','$yj','$price','$event',7)";
                    $beres = $db->insert($sqll);
                    //事务
                    if ($beres < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:04', 'sql' => $sqll));
                        exit;
                    }
                    //佣金表
                    $ldr_level = $key + 1;
                    $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$luser','$user_id','$yj','$sNo','$ldr_level','$event','1',CURRENT_TIMESTAMP)";
                    $beres = $db->insert($sqlldr);
                    //事务
                    if ($beres < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:05', 'sql' => $sqlldr));
                        exit;
                    }
                }
            }

        }
        //基础分销佣金发放完毕
    }

    //便携查找分销员信息
    public function find_fenxiao($db, $user_id)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $sql = "select g.*,d.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id where d.store_id = '$store_id' and d.user_id = '$user_id' ";
        $res = $db->select($sql);
        if ($res) {
            return $res[0];
        } else {
            return false;
        }

    }

    //消费金变现
    public function realization_consumer($db, $consumer_id, $user_id, $from_id, $sNo, $price)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $qsqlc = "select g.transfer_balance from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id where d.store_id = '$store_id' and d.user_id = '$consumer_id' ";
        $qresq = $db->select($qsqlc);
        if ($qresq) {
            $zh_money = $qresq[0]->transfer_balance;
            //消费金变现 查询消费金
            $qsqlu = "select money,consumer_money from lkt_user where store_id = '$store_id' and user_id = '$user_id' ";
            $qresu = $db->select($qsqlu);
            //推荐人的消费金余额
            $consumer_money = $qresu[0]->consumer_money;
            $oldmoney = $qresu[0]->money;

            if ($zh_money) {
                //如果推荐人的消费金余额减去购买人购买返回抵用的消费金大于等于零时
                if ($consumer_money - $zh_money >= 0) {
                    $sql = "update lkt_user set money = money+'$zh_money',consumer_money = consumer_money-'$zh_money' where store_id = '$store_id' and user_id = '$user_id'";
                    $beres = $db->update($sql);
                    //事务
                    if ($beres < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:06', 'sql' => $sql));
                        exit;
                    }

                    $event = $user_id . '抵扣了' . $zh_money . '元消费金2';
                    $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$zh_money','$sNo','0','$event','4',CURRENT_TIMESTAMP)";
                    $beres2 = $db->insert($sqlldr);
                    //事务
                    if ($beres2 < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:07', 'sql' => $sqlldr));
                        exit;
                    }

                    $event = "会员" . $user_id . "消费金解封转入余额" . $zh_money . "元";
                    $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$zh_money','$sNo','0','$event','1',CURRENT_TIMESTAMP)";
                    $beres3 = $db->insert($sqlldr);

                    //事务
                    if ($beres3 < 1) {
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:07', 'sql' => $sqlldr));
                        exit;
                    }

                } else if ($consumer_money - $zh_money < 0) {
                    if ($consumer_money > 0) {
                        $sql = "update lkt_user set money = money+'$consumer_money',consumer_money = consumer_money-'$consumer_money' where store_id = '$store_id' and user_id = '$user_id'";
                        $beres = $db->update($sql);
                        //事务
                        if ($beres < 1) {
                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '参数错误 code:09', 'sql' => $sql));
                            exit;
                        } else {
                            $event = $user_id . '获得了' . $consumer_money . '元推荐人消费金解封code:10';
                            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$consumer_money','$sNo','0','$event','7',CURRENT_TIMESTAMP)";
                            $beres1 = $db->insert($sqlldr);
                            //事务
                            if ($beres1 < 1) {
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '参数错误 code:11', 'sql' => $sqlldr));
                                exit;
                            }

                            $event = $user_id . '抵扣了' . $consumer_money . '元消费金2';
                            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$consumer_money','$sNo','0','$event','4',CURRENT_TIMESTAMP)";
                            $beres2 = $db->insert($sqlldr);
                            //事务
                            if ($beres2 < 1) {
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '参数错误 code:07', 'sql' => $sqlldr));
                                exit;
                            }
                        }
                    }
                }
                //消费金发放完成
            }
        }
    }

    // 对比等级发放佣金和消费金 *高推低按低  低推高按照本等级*-------------05
    public function contrast_rating($db, $contrast_id, $user_id, $from_id, $sNo, $r_f, $qid, $paixu, $price)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        //查找等级比例
        $r_d = $this->find_fenxiao($db, $contrast_id);
        if ($r_d) {
            $cmoneys = [];
            //会员佣金
            $member_proportion_str = $r_d->member_proportion;
            $member_Arr = explode(',', $member_proportion_str);
            if ($member_Arr) {
                foreach ($member_Arr as $ka => $va) {
                    if ($va > 1) {
                        $cmoney = $va;
                    } else {
                        $cmoney = $price * $va;
                    }
                    $cmoneys[$ka] = $cmoney;
                }
            } else {
                $cmoneys[0] = $member_proportion_str;
            }

            //如果是分销商的话 就设置id
            if ($r_f->level == $qid) {
                $this->find_partner('区域管理佣金', $db, $sNo, $user_id, $user_id, $qid, $cmoney, 0.1);
            }

            $sql = "update lkt_user set money = money+'$cmoney' where store_id = '$store_id' and user_id = '$user_id'";
            $db->update($sql);

            //写日志
            $event = $user_id . '获得了' . $cmoney . '元推荐人佣金--- code:12';
            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$cmoney','$cmoney','$event',7)";
            $beres = $db->insert($sqll);
            //事务
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:13'));
                exit;
            }
            //佣金表
            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$cmoney','$sNo','1','$event','1',CURRENT_TIMESTAMP)";
            $beres = $db->insert($sqlldr);
            //事务
            if ($beres < 1) {
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:14'));
                exit;
            }


            $shangji_id2 = $r_f->pid;
            $r_ff = $this->find_fenxiao($db, $shangji_id2);
            if ($r_ff) {
                $sort02 = $r_ff->sort;
                $cmoney_users = '';
                //判断购买人和上级的等级
                if ($sort02 > $paixu) {
                    $cmoney_users = $from_id;
                } else {
                    $cmoney_users = $shangji_id2;
                }
                //推荐人上级佣金发放
                if ($shangji_id2) {
                    $this->contrast_fating($db, $cmoney_users, $shangji_id2, $from_id, $sNo, $r_ff, $qid, $paixu);
                }
            }

        }
    }

    //推荐人上级佣金发放
    public function contrast_fating($db, $contrast_id, $user_id, $from_id, $sNo, $r_f, $qid, $paixu)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        //查找等级比例
        $r_d = $this->find_fenxiao($db, $contrast_id);
        if ($r_d) {
            $cmoneys = [];
            //会员佣金
            $member_proportion_str = $r_d->member_proportion;
            $member_Arr = explode(',', $member_proportion_str);
            if ($member_Arr) {
                foreach ($member_Arr as $ka => $va) {
                    if ($va > 1) {
                        $cmoney = $va;
                    } else {
                        $cmoney = $price * $va;
                    }
                    $cmoneys[$ka] = $cmoney;
                }
            } else {
                $cmoneys[0] = $member_proportion_str;
            }


            $cmoney = $cmoneys[0];//佣金
            $shaosje = $cmoneys[0];

            //如果是分销商的话 就设置id
            if ($r_f->level == $qid) {
                $this->find_partner('区域管理佣金', $db, $sNo, $user_id, $user_id, $qid, $cmoneys[0], 0.1);
            }

            if (isset($cmoneys[1])) {

                $cmoney1 = $cmoneys[1];
                $sql = "update lkt_user set money = money+'$cmoney1' where store_id = '$store_id' and user_id = '$user_id'";
                $beres = $db->update($sql);

                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:22'));
                    exit;
                }

                //写日志
                $event = $user_id . '获得了' . $cmoney1 . '元荐人上级的佣金 code:23';
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$cmoney1','$cmoney1','$event',7)";
                $beres = $db->insert($sqll);
                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:24'));
                    exit;
                }
                //佣金表
                $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$from_id','$cmoney1','$sNo','2','$event','1',CURRENT_TIMESTAMP)";
                $beres = $db->insert($sqlldr);
                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:25'));
                    exit;
                }

            }

        }
    }

    //对比上级 按照实际情况发放佣金和消费金
    public function contrast_level($shangji_id, $user_id, $db, $distributorid, $sNo, $qid, $price)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        //查找推荐人 返佣金
        $r_f = $this->find_fenxiao($db, $shangji_id);
        //查询购买人自己所在的分销等级和排序号
        $r_u = $this->find_fenxiao($db, $user_id);
        $cmoney = 0;
        //记录烧伤金额
        $shaosje = 0;

        if ($r_f) {
            //推荐人消费金变现------------------------06
            $paixu_1 = $r_f->sort;//推荐人的排序号
            $paixu = $r_u->sort;    //购买人的排序号
            if ($paixu_1 >= $paixu) {
                //消费金转余额
                //$this->realization_consumer($db, $user_id, $shangji_id, $user_id, $sNo, $price);
                //发放佣金
                $this->contrast_rating($db, $user_id, $shangji_id, $user_id, $sNo, $r_f, $qid, $paixu, $price);
            } else {
                //消费金转余额
                //$this->realization_consumer($db, $shangji_id, $shangji_id, $user_id, $sNo, $price);
                //发放佣金
                $this->contrast_rating($db, $shangji_id, $shangji_id, $user_id, $sNo, $r_f, $qid, $paixu, $price);
            }
            //推荐人消费金变现结束------------------------06
        }

        //--------烧伤佣金开关--------
        $sqlldc = "select * from lkt_distribution_config where store_id = '$store_id' ";
        $res_ldc = $db->select($sqlldc);
        $ldc_sets = unserialize($res_ldc[0]->sets);
        $partner_burn = $ldc_sets['partner_burn'];

        if ($partner_burn) {
            //2.在根据id判断是否是代理商
            if ($distributorid == $qid) {
                //3.如果是的话 就查找上级最近的一个代理商
                $sjqydl = $this->quyudaili($shangji_id, $qid, $db);
                if ($sjqydl) {
                    //4.然后把原本的钱减去烧伤的钱发放给上级代理商
                    $sql_ersan = "select g.member_proportion from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id LEFT JOIN lkt_product_list as lpl ON lpl.distributor_id = g.id where d.store_id = '$store_id' and d.user_id = '$sjqydl' ";
                    $r_san = $db->select($sql_ersan);
                    $member_proportion_str = $r_san[0]->member_proportion;
                    $member_Arr = explode(',', $member_proportion_str);
                    $ssyj = [];
                    foreach ($member_Arr as $ka => $va) {
                        if ($va > 1) {
                            $cmoney = $va;
                        } else {
                            $cmoney = $price * $va;
                        }
                        $ssyj[$ka] = $cmoney;
                    }
                    //查询 原本代理商 的一级佣金
                    $shprice = $ssyj[0] - $shaosje;
                    if ($shprice > 0) {
                        // 判断用户是否存在
                        if ($db->select("select id from lkt_user where store_id = '$store_id' and user_id = '$sjqydl'")) {
                            $sql = "update lkt_user set money = money+'$shprice' where store_id = '$store_id' and user_id = '$sjqydl'";
                            $beres = $db->update($sql);
                            //事务
                            if ($beres < 1) {
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '参数错误 code:38', 'sql' => $sql));
                                exit;
                            }
                            $event = $sjqydl . '获得了' . $shprice . '元代理商烧伤佣金' . $ssyj[0] . '---' . $shaosje;
                            $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$sjqydl','$user_id','$shprice','$sNo','5','$event','1',CURRENT_TIMESTAMP)";
                            $beres = $db->insert($sqlldr);

                            $ref_t = $this->find_partner('代理商烧伤佣金', $db, $sNo, $sjqydl, $sjqydl, $qid, $shprice, 0.1);
                            //事务
                            if ($beres < 1) {
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '参数错误 code:39', 'sql' => $sqlldr));
                                exit;
                            }
                        }

                    }
                }
            }

        }
    }

    //等级升级
    public function grade_upgrading($db, $distributorid, $user_id, $sNo, $info_user, $order_detail, $qid, $price)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        //检查是否该用户是否是分销商
        if ($info_user) {
            $tj_id = $info_user->pid;//推荐人id
            $sets = unserialize($info_user->sets); //反序列化出提成比例数组
            $lt = $info_user->lt;
            $rt = $info_user->rt;
            $uplevel = $info_user->uplevel;// 分销层级
            $num = [$sets['b_yi'], $sets['b_er'], $sets['b_san']];// 三级的比例

            //------------------------------------关键部分------------------------------------

            //送消费金,积分-------02
        
            $integral = $info_user->integral;
            if ($integral > 0) {
                $sql = "update lkt_user set score = score+'$integral' where store_id = '$store_id' and user_id = '$user_id'";
                $beres = $db->update($sql);
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:41', 'sql' => $sql));
                    exit;
                }
                $event = "会员" . $user_id . "充值了" . $integral . "积分";
                //类型 1:转入(收入) 2:提现 3:管理佣金 4:使用消费金 5收入消费金 6 系统扣款 7:充值积分 8使用积分
                $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$user_id','$integral','$sNo','0','$event','8',CURRENT_TIMESTAMP)";
                $beres = $db->insert($sqlldr);
                //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:42', 'sql' => $sqlldr));
                    exit;
                }

                $sqll = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$integral','$event',CURRENT_TIMESTAMP,6)";
                $beres = $db->insert($sqll);                              //事务
                if ($beres < 1) {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:43', 'sql' => $sqll));
                    exit;
                }

            }
        } else {
            //不是分销商
            $db->rollback();
            echo json_encode(array('status' => 0, 'err' => '参数错误 不是分销商 code:47'));
            exit;
        }
        //消费金转余额------------05

    }

    //查找用户上级合伙人 并按照相应比例发放佣金 并记录
    public function find_partner($type, $db, $sNo, $user_id, $pid, $level, $price, $end, $num = 0)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        //先查询好区域代理id和比例
        $qsql = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_agent = '1' ";
        $qres = $db->select($qsql);
        $qid = $qres[0]->id;
        $qysets = unserialize($qres[0]->sets);
        $proportion = $qysets['g_yi'];
        $dd_res = $this->find_fenxiao($db, $user_id);
        if ($dd_res) {
            $lt = $dd_res->lt;
            $rt = $dd_res->rt;
            $sqlhhr = "select * from lkt_user_distribution as lud LEFT JOIN lkt_distribution_grade as ldg ON ldg.id = lud.level where lud.store_id = '$store_id' and lud.lt<'$lt' and lud.rt>'$rt' and level = '$qid' ORDER BY lud.uplevel desc ";
            $hhr = $db->select($sqlhhr);
            if ($hhr) {
                for ($i = 0; $i < count($hhr); $i++) {
                    if ($i > 1000) {
                        break;
                    }
                    $uid = $hhr[$i]->user_id;
                    if ($uid) {
                        $money = $price * $proportion / 100;
                        if ($money < $end) {
                            break;
                        }
                        $sql = "update lkt_user set money = money+'$money' where store_id = '$store_id' and user_id = '$uid'";
                        $beres = $db->update($sql);
                        if ($beres < 1) {
                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '参数错误 code:33', 'sql' => $sql));
                            exit;
                        }
                        $event = $uid . "获得了" . $money . "下级合伙人的佣金--" . $type;
                        $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$uid','$pid','$money','$sNo','0','$event','3',CURRENT_TIMESTAMP)";
                        $beres = $db->insert($sqlldr);
                        $price = $money;
                        //事务
                        if ($beres < 1) {
                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '参数错误 code:2', 'sql' => $sqlldr));
                            exit;
                        }
                    }

                }
            }
        }
    }

    //查找分销商的代理商的代理商
    public function quyudaili($user_id = '', $level = 0, $db, $num = 0)
    {
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $dd_res = $this->find_fenxiao($db, $user_id);
        if ($dd_res) {
            $lt = $dd_res->lt;
            $rt = $dd_res->rt;
            $sjqydlsql = "select * from lkt_user_distribution as lud LEFT JOIN lkt_distribution_grade as ldg ON ldg.id = lud.level where lud.store_id = '$store_id' and lud.lt<'$lt' and lud.rt>'$rt' and level = '$level' ORDER BY lud.uplevel desc LIMIT 0,1 ";
            $sjqydl_res = $db->select($sjqydlsql);
            if ($sjqydl_res) {
                $qyid = $sjqydl_res[0]->user_id;
                return $qyid;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //分销方法结束

    // 进入结算页面
    public function Settlement()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $cart_id = trim($request->getParameter('cart_id')); //  购物车id
        $uid = trim($request->getParameter('uid')); // 微信id

        //地址
        $address = [];
        //计算运费
        $yunfei = 0;
        // 根据微信id,查询用户id
        $sql_user = 'select user_id,money from lkt_user where store_id = \'' . $store_id . '\' and wx_id=\'' . $uid . '\'';
        $r_user = $db->select($sql_user);
        if($r_user){
            $userid = $r_user['0']->user_id; // 用户id
            $user_money = $r_user['0']->money; // 用户余额
            
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        // 根据用户id,查询收货地址
        $sql_a = 'select id from lkt_user_address where store_id = \'' . $store_id . '\' and uid=\'' . $userid . '\'';
        $r_a = $db->select($sql_a);
        if (!empty($r_a)) {
            $arr['addemt'] = 0; // 有收货地址
            // 根据用户id、默认地址,查询收货地址信息
            $sql_e = 'select * from lkt_user_address where store_id = \'' . $store_id . '\' and uid=\'' . $userid . '\' and is_default = 1';
            $r_e = $db->select($sql_e);
            if (!empty($r_e)) {
                $arr['adds'] = (array)$r_e['0']; // 收货地址
            } else {
                // 根据用户id、默认地址,查询收货地址信息
                $aaaid = $r_a[0]->id;
                $sql_q = "select * from lkt_user_address where store_id = '$store_id' and id= '$aaaid'";
                $r_e = $db->select($sql_q);
                $arr['adds'] = (array)$r_e['0']; // 收货地址
                $sql_u = "update lkt_user_address set is_default = 1 where store_id = '$store_id' and id = '$aaaid'";
                $db->update($sql_u);
            }
            $address = (array)$r_e['0']; // 收货地址
        } else {
            $arr['addemt'] = 1; // 没有收货地址
            $arr['adds'] = ''; // 收货地址
        }

        $typestr = trim($cart_id, ','); // 移除两侧的逗号
        $typeArr = explode(',', $typestr); // 字符串打散为数组
        //  取数组最后一个元素 并查询分类名称
        $zong = 0;

        //新增分销分销等级商品不能再次购买
        $sql = "select a.id,c.r_status from lkt_product_list AS a RIGHT JOIN lkt_order_details AS c ON a.id = c.p_id where a.store_id = '$store_id' and c.user_id = '$userid' and a.distributor_id > 0 and a.num >0 group by c.p_id";
        $products = $db->select($sql);
        $status = [];
        $status_id = 0;
        if($products){
            foreach ($products as $key => $value) {
                $products[$key] = $value->id;
                $status[$value->id] = $value->r_status;
            }
            $products = (array)$products;
        }else{
            $products = array();
        }
        //查询是否是会员卡商品 限制支付方式只能为余额和微信
        $sql_t = "select a.id,a.distributor_id from lkt_product_list AS a where a.store_id = '$store_id' and a.distributor_id > '0' group by a.id  order by a.sort DESC ";
        $r_t = $db->select($sql_t);
        $distributor_products = [];
        if($r_t){
            foreach ($r_t as $kt => $vt) {
                $distributor_products[$vt->id] = $vt->distributor_id;
            }
            $distributor_products = (array)$distributor_products;
        }
        //控制优惠方式
        $discount = true;
        $pstuat = true;

        $sql = "select g.* from lkt_distribution_grade as g LEFT JOIN lkt_user_distribution AS d ON d.level = g.id where d.store_id = '$store_id' and d.user_id = '$userid' ";
        $r = $db->select($sql);
        //添加防止购买比自己低等级 列出排序号
        $usort = isset($r[0]) ? $r[0]->sort : 0;

        foreach ($typeArr as $key => $value) {
            // 联合查询返回购物信息
            $sql_c = "select a.Goods_num,a.Goods_id,a.id,m.product_title,m.volume,c.price,c.attribute,c.img,c.yprice,m.freight,m.product_class,m.weight from lkt_cart AS a LEFT JOIN lkt_product_list AS m ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c ON a.Size_id = c.id  where a.store_id = '$store_id' and c.num >0 and m.status ='0' and a.id = '$value'";
            $r_c = $db->select($sql_c);
            if($r_c){
                $product = (array)$r_c['0']; // 转数组
            }else{
                $sql = "update lkt_cart set Goods_num = 0 where id = '$value'";
                $db->update($sql);
                echo json_encode(array('status' => 0, 'err' => '存在库存不足的商品！'));
                exit;
                break;
            }
            $attribute = unserialize($product['attribute']);
            $product_id[] = $product['Goods_id'];
            $product_class[] = $product['product_class'];
            $size = '';
            foreach ($attribute as $ka => $va) {
                $size .= ' ' . $va;
            }
            $Goods_id = $product['Goods_id'];
            if (in_array($Goods_id, $products)) {
                $pstuat = false;
                $status_id = $Goods_id;
            }

            if (array_key_exists($Goods_id, $distributor_products)) { // 检查数组里是否有指定的键名或索引
                $discount = false;
                $grade_id = $distributor_products[$Goods_id];
                if ($grade_id) {
                    $sql_grade = "select sort from lkt_distribution_grade where store_id = '$store_id' and id = '$grade_id' ";
                    $r_grade = $db->select($sql_grade);
                    if ($r_grade) {
                        $gsort = $r_grade[0]->sort;
                        if ($gsort <= $usort) {
                            echo json_encode(array('status' => 0, 'err' => '存在无法购买的商品！'));
                            exit;
                            break;
                        }
                    }
                }
            }

            //储存商品数据
            $products_freight[] = array('pid' => $Goods_id,'num'=>$product['Goods_num'],'freight_id'=>$product['freight'],'weight'=>$product['weight']);

            $product['photo_x'] = ServerPath::getimgpath($product['img']);/* 拼接图片链接*/
            $num = $product['Goods_num']; // 产品数量
            $price = $product['price']; // 产品价格
            $product['size'] = $size; // 产品价格
            $zong += $num * $price; // 产品总价
            $res[$key] = $product;
        }

        //计算运费
        $freight = $this->freight($products_freight, $address, $db);
        $yunfei = $freight['totle'];

        $freight_ids = isset($freight['freight_id']) ? $freight['freight_id']:[];
        foreach ($res as $kf => $vf) {
            if (array_key_exists($vf['freight'], $freight_ids)) {
               $res[$kf]['freight_price'] = ceil($freight_ids[$vf['freight']]*$res[$kf]['Goods_num']);
            }
        }


        $arr['freight'] = $yunfei;

         
        // 查询自动满减设置
        $sql = "select * from lkt_subtraction where store_id = '$store_id' and status=1";
        $r_subtraction = $db->select($sql);
        $subtraction = [];
        $reduce_name = '';
        $reduce = 0;
        if(!empty($r_subtraction)){             //当前有满减活动
            $subactive = true;     //当前有满减活动
            $subtraction = json_decode($r_subtraction[0]->subtraction); // 自动满减
            $subtraction = (array)$subtraction;
            
            $goodsids = explode(',',$r_subtraction[0]->goods);
            $surport = true;
            foreach ($product_id as $k => $v) {          //判断是否是满减产品,如果产品当中有一样是非满减产品则不支持满减
                if(!in_array($v,$goodsids)){
                    $surport = false;
                    break;
                }
            }
            
            if($surport){
               $levelarr = array_keys($subtraction);
               sort($levelarr);
               $key;
               $subtraction = (object)$subtraction;
                foreach ($subtraction as $ke => $val) {
                    $val = explode('~',$val);
                    $subtraction -> $ke = $val[0];
                }
                if ($zong < $levelarr[0]) {               //小于最低等级
                    $reduce_name = '不满足满减活动';
                } else {
                    foreach ($levelarr as $k => $v) {
                        if ($zong >= $levelarr[count($levelarr) - 1]) {         //如果比最高等级都大
                            $key = $levelarr[count($levelarr) - 1];
                            break;
                        } else {
                            if ($zong >= $levelarr[$k] && $zong < $levelarr[$k + 1]) {
                                $key = $levelarr[$k];
                                break;
                            }
                        }
                    }
                    
                    $subprice = $subtraction -> $key;
                    $reduce_name = '满' . $key . '减' . $subprice;
                    $reduce = $subprice;
                }
            }else{
                $subtraction = (object)$subtraction;
                foreach ($subtraction as $ke => $val) {
                    $val = explode('~',$val);
                    $subtraction -> $ke = $val[0];
                }
                $reduce_name = '不满足满减活动';
            }
            $arr['subtraction'] = $subtraction;
        }else{             //当前无满减活动
           $subactive = false;
        }      
        $arr['name'] = $reduce_name;
        $arr['reduce_money'] = $reduce;
        $arr['subactive'] = $subactive;
        
        if ($pstuat) {
            $arr['price'] = $zong; // 产品总价
            $arr['pro'] = $res; // 产品信息

            $time = date("Y-m-d H:i:s"); // 当前时间
            
            $coupon = new coupon_pluginAction();
            $coupon_arr = $coupon->coupon($store_id,$userid,$zong,$product_class,$product_id);

            $arr['money'] = $coupon_arr['money'];
            $arr['coupon_id'] = $coupon_arr['coupon_id'];
            $arr['coupon_money'] = $zong - $reduce + $yunfei - $coupon_arr['money']; // 商品总价 - 自动满减 + 运费 - 优惠券金额
            $arr['user_money'] = $user_money; // 用户余额
            $arr['discount'] = $discount; // 优惠控制
            
            echo json_encode(array('status' => 1, 'arr' => $arr));
            exit;
        } else {
            if ($status[$status_id] == 0) {
                echo json_encode(array('status' => 0, 'err' => '您有会员套餐未付款订单！'));
                exit;
            } else {
                echo json_encode(array('status' => 0, 'err' => '存在无法购买的商品！'));
                exit;
            }
        }
    }
    //余额支付
    public function wallet_pay()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $uid = trim($request->getParameter('uid')); // 微信id
        $total = trim($request->getParameter('total')); // 付款余额
        // 根据微信id,查询用户列表(支付密码,钱包余额,用户id)
        $sql_user = "select password,money,user_id from lkt_user where store_id = '$store_id' and wx_id='$uid'";
        $r_user = $db->select($sql_user);
        if($r_user){
            $user_money = $r_user['0']->money; // 用户余额
            $userid = $r_user['0']->user_id; // 用户id
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        if ($user_money >= $total) {
            // 根据微信id,修改用户余额
            if ($total > 0) {
                $sql = "update lkt_user set money = money-'$total' where store_id = '$store_id' and user_id = '$userid'";
                $r = $db->update($sql);
                $event = $userid . '使用了' . $total . '元余额';
                $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$userid','$total','$user_money','$event',4)";
                $rr = $db->insert($sqll);
            }
            echo json_encode(array('status' => 1, 'succ' => '扣款成功!'));
        } else {
            echo json_encode(array('status' => 0, 'err' => '余额不足！'));
        }
        exit;
    }
    //普通商品储存from_id 用于发货 退款等操作信息推送
    public function save_formid()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $uid = addslashes(trim($request->getParameter('userid')));
        $formid = addslashes(trim($request->getParameter('from_id')));
        $lifetime = date('Y-m-d H:i:s', time() + 7 * 24 * 3600);
        if ($formid != 'the formId is a mock one' && $formid != '') {
            $addsql = "insert into lkt_user_fromid(store_id,open_id,fromid,lifetime) values('$store_id','$uid','$formid','$lifetime')";
            $addres = $db->insert($addsql);
            echo json_encode(array('status' => 1, 'succ' => $addres));
        }
    }
    /**
     * [check_invitation description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-29T15:58:30+0800
     * @return  校验邀请有奖完成资格
     */
    public function check_invitation($user_id = 'user50')
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $time =  date('Y-m-d h:i:s',time());
        $request = $this->getContext()->getRequest();
        $store_type = trim($request->getParameter('store_type')) ? $request->getParameter('store_type'):0;
        $this->store_type = $store_type;
        
        //查询是否开启邀请有奖功能and `store_type` = '$store_type'
        $sql = "select order_time,payment_amount from lkt_invitation where store_id = '$store_id'  and status = '1' ";
        $invitation = $db->select($sql);
        if($invitation){
            $payment_amount = $invitation[0]->payment_amount;
            $shixiao_time = $invitation[0]->order_time;
            $gq_time = date("Y-m-d H:i:s", strtotime("-$shixiao_time days")); // 失效时间

            //查询是否有优惠券-推荐人
            $sql_c = "select id from lkt_coupon_activity where store_id = '$store_id' and activity_type = '8'";
            $res_c = $db->select($sql_c);

            if($res_c){
                $hs = '';
                foreach ($res_c as $keyc => $valuec) {
                    $hs .= $valuec->id.',';
                }

                $hid = trim($hs, ',');

                //查询是否领取过优惠券
                $sql_lc = "select id from lkt_coupon where store_id = '$store_id' and hid in ($hid)";
                $res_lc = $db->select($sql_lc);

                if(!$res_lc){
                    $sql_u = "select o.spz_price,u.Referee,u.Register_data,u.user_id,u.user_name,o.sNo,o.z_price,o.status from lkt_user as u left join lkt_order as o on u.user_id=o.user_id where u.Register_data >= '$gq_time' and o.add_time >= '$gq_time' and u.Referee !='' and u.store_id = '$store_id' and u.user_id = '$user_id' and o.status =3 ORDER BY u.Register_data desc";

                    $res_u = $db->select($sql_u);

                    // var_dump($res_u,$sql_u);
                    if($res_u){
                        foreach ($res_u as $key => $value) {
                            //防止多个子订单不同状态-计算整个订单实付
                            $cprice = $this->calculate_order($db,$value->sNo,$value->z_price,$value->spz_price);
                            if($cprice >= $payment_amount){
                                // 推荐人发放
                               $Referee = $value->Referee;
                               $coupon = new coupon_pluginAction();
                               $coupon_list = $coupon->give($store_id,$Referee,'invitation');
                               if(!empty($coupon_list)){
                                    foreach ($coupon_list as $keyl => $valuel) {
                                        $ww = $this->wxss($Referee,(object)$valuel);
                                        // var_dump($ww);
                                    }
                               }
                               // var_dump($coupon_list);
                               break;
                            }
                        }
                    }
                }
            }

        }
    }

    /**
     * [calculate_order description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-29T18:17:40+0800
     * @param   计算整个订单实付
     */
    public function calculate_order($db,$sNo,$z_price,$spz_price)
    {
        //判断单个商品退款是否有使用优惠
        $sql_id = "select m.num,m.p_price from lkt_order_details AS m where m.r_sNo = '$sNo' and m.r_status = '3' ";
        $variable = $db->select($sql_id);
        $price = 0;
        foreach ($variable as $key => $value) {
            $num = $value->num;
            $p_price = $value->p_price*$num;
            //计算实际支付金额
            $price += number_format($z_price / $spz_price * $p_price, 2,".","");
        }
        return $price;
    }


    public function wxss($user_id,$cdata)
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $time =  date('Y-m-d h:i:s',time());

        $sql_openid = "select wx_id,user_name from lkt_user where store_id = '$this->store_id' and user_id = '$user_id'";
        $res_openid = $this->db->select($sql_openid);
        $openid = $res_openid[0]->wx_id;
        $user_name = $res_openid[0]->user_name;

        //实例化
        $Tools = new Tools($db,$store_id,$store_type);
        $data = [];

        $data['page'] = 'pages/coupon/index?currentTab=1';
        $data['template_id'] = 'receive';
        $data['openid'] = $openid;

        $o_data = [];
        //设置消息数组
        $o_data['keyword1'] = array('value' => $user_name, "color" => "#173177");
        $o_data['keyword2'] = array('value' => '系统', "color" => "#173177");
        $o_data['keyword3'] = array('value' => $cdata->name, "color" => "#173177");
        $o_data['keyword4'] = array('value' => '我的优惠券', "color" => "#173177");
        $o_data['keyword5'] = array('value' => $cdata->add_time, "color" => "#173177");
        $o_data['keyword6'] = array('value' => $cdata->end_time, "color" => "#173177");
        $o_data['keyword7'] = array('value' => $cdata->money, "color" => "#173177");
        $o_data['keyword8'] = array('value' => $cdata->limit, "color" => "#173177");

        $data['o_data'] = $o_data;
        $tres = $Tools->send_notice($data,'wx');

        return $tres? ($tres->errcode == 'ok' ? true:false):false;

    }


}
?>