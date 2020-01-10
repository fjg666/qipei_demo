<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 * @author 熊孔钰
 * @date 2019年8月10日
 * @version 2.8
 */
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Plugin/sign.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class integralAction extends Action
{

    public function getDefaultView()
    {
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();
        return ;
    }

    /**
     * 分配方法
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));

        if (!empty($app)) {
            $this->$app();
        }else{
            echo json_encode(array('code' => 400, 'msg' => '请指向对应请求方法！'));
            exit;
        }
        return;
    }
    // 积分商城列表
    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收参数
        $store_id = intval($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id'));
        $page = intval($request->getParameter('page'))?intval($request->getParameter('page')):1;// 页码
        $pagesize = 10;// 每页显示多少条数据
        $start = ($page-1)*$pagesize;// 开始行数

        // 查询商品信息
        $sql = "select g.*,a.volume,a.imgurl,a.product_title,a.subtitle,c.price,c.yprice,c.img,c.total_num,c.num,c.name,c.color,c.size,a.s_type from lkt_integral_goods as g left join lkt_product_list as a on g.goods_id=a.id left join lkt_configure as c on g.attr_id = c.id  where g.store_id = '$store_id' and a.status = 2 and c.num>0 and g.is_delete=0 order by g.sort desc LIMIT $start,$pagesize ";
        $goods = $db->select($sql);
        $list = array();
        foreach ($goods as $k => $v) {
            $v->imgurl = ServerPath::getimgpath($v->img,$store_id);// 商品图
            $v->sales = $v->volume>0?$v->volume:0;// 销量
            $list[] = $v;
        }

        $bg_img = '';   // 积分商城轮播图
        $score = 0;     // 用户积分
        $go_sign = 0;   // 能否签到 0否 1能

        // 查询轮播图
        $sql = "select bg_img from lkt_integral_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r && !empty($r[0]->bg_img)) {
            $bg_img = $r[0]->bg_img;
        }

        // 查询用户积分
        $sql = "select score,user_id from lkt_user where access_id = '$access_id' and access_id != ''";
        $r = $db->select($sql);
        if ($r) {
            $score = $r[0]->score;
            $user_id = $r[0]->user_id;
        }

        // 签到模块是否开启
        $sign = new sign();
        $sign_arr = $sign->test($store_id,$user_id);
        if($sign_arr['is_sign_status'] == 1){
            $go_sign = 1;
        }

        echo json_encode(array("code" => 200, "list" => $list, "score" => $score, "bg_img" => $bg_img, "go_sign" => $go_sign));exit;
    }
    // 积分商品详情
    public function goodsdetail()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收参数
        $store_id = intval($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id'));
        $id = intval($request->getParameter('id'));// 商品ID

        // 查询配置
        $sql = "select status from lkt_integral_config where store_id='$store_id'";
        $r = $db->select($sql);
        $isopen = $r?$r[0]->status:0;// 是否开启插件 0.否  1.是

        if ($access_id != '') {
            // 根据授权id,查询用户信息(被邀请人)
            $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db->select($sql);
            if ($r) { // 是会员
                $user_id = $r[0]->user_id; // 用户id
                $login_status = 1;

                // 根据用户id、产品id,获取收藏表信息
                $sql = "select * from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and p_id = '$id' and type=2";
                $rr = $db->select($sql);
                if ($rr) {
                    $type = 1; // 已收藏
                    $collection_id = $rr['0']->id; // 收藏id
                } else {
                    $type = 0; // 未收藏
                    $collection_id = '';
                }
                // 根据用户id,在足迹表里插入一条数据
                $sql = "insert into lkt_user_footprint(store_id,user_id,p_id,add_time) values('$store_id','$user_id','$id',CURRENT_TIMESTAMP)";
                $db->insert($sql);
            }else{
                $user_id = '游客'.time();
                $type = 0; // 未收藏
                $collection_id = '';
                $login_status = 0;
            }
        } else {
            $access_id = Tools::getToken();

            $user_id = '游客'.time();
            $type = 0; // 未收藏
            $collection_id = '';
            $login_status = 0;
        }

        // 查询商品信息
        $sql = "select g.is_delete,g.integral,g.money,g.goods_id,g.attr_id,a.content,a.mch_id,a.product_title,a.volume as score,c.price,c.img,c.total_num,c.num,c.attribute from lkt_integral_goods as g left join lkt_product_list as a on g.goods_id=a.id left join lkt_configure as c on g.attr_id = c.id  where g.id = '$id'";
        $goods = $db->select($sql);
        if ($goods) {
            // 商品详情获取
            $this->getdetail($goods,$type,$collection_id,$isopen);
            // 商品详情获取   end
        }else{
            echo json_encode(array("code" => 404, "msg" => '商品不存在！'));exit;
        }

    }
    // 商品详情获取
    public function getdetail($goods,$type,$collection_id,$isopen)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = intval($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id'));

        $goods[0]->is_collection = $type;// 是否收藏 0.否  1.是
        $goods[0]->collection_id = $collection_id;// 收藏ID
        $goods[0]->imgurl = ServerPath::getimgpath($goods[0]->img,$store_id);// 商品图片
        $attribute = unserialize($goods[0]->attribute);// 商品属性
        $goods[0]->attribute = '';
        foreach ($attribute as $k => $v) {
            $goods[0]->attribute .= "【".$k."：".$v."】";
        }

        $uploadImg_domain = 'https://xiaochengxu.laiketui.com/V2.7';
        // 查询图片上传设置
        $sql = "select * from lkt_upload_set ";
        $r_1 = $db->select($sql);
        if($r_1){
            foreach ($r_1 as $K => $v){
                if($v->type == '本地' && $v->attr == 'uploadImg_domain'){
                    $uploadImg_domain = $v->attrvalue; // 图片上传域名
                }
            }
        }
        $newa = substr($uploadImg_domain, 0, strrpos($uploadImg_domain, '/'));
        if ($newa == 'http:/' || $newa == 'https:/') {
            $newa = $uploadImg_domain;
        }
        $content = $goods[0]->content;// 商品详情
        $contarr = array();
        preg_match_all('/(<img.+?src=\"http)(.*?)/', $content, $contarr);
        if (empty($contarr[0])) {
            $goods[0]->content = preg_replace('/(<img.+?src=")(.*?)/', "$1$newa$2", $content);
        }

        $mch_id = $goods[0]->mch_id;// 店铺ID
        if ($mch_id != 0) {
            $sql0 = "select id,name,logo from lkt_mch where store_id = '$store_id' and id = '$mch_id'";
            $r0 = $db->select($sql0);
            if ($r0) {
                $shop_list['shop_id'] = $r0[0]->id;// 店铺ID
                $shop_list['shop_name'] = $r0[0]->name;// 店铺名称
                $shop_list['shop_logo'] = ServerPath::getimgpath($r0[0]->logo);// 店铺logo
                // 在售商品
                $sql1 = "select id,product_class from lkt_product_list where store_id = '$store_id' and mch_id = '$mch_id' and mch_status = 2 and status = 2 and recycle = 0 and active = 1 order by add_date desc ";
                $r1 = $db->select($sql1);
                $shop_list['quantity_on_sale'] = count($r1);
                // 已售
                $quantity_sold = 0;
                $sql3 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$mch_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid ";
                $r3 = $db->select($sql3);
                if($r3){
                    foreach($r3 as $k => $v){
                        $quantity_sold += $v->volume;  // 已售数量
                    }
                }
                $shop_list['quantity_sold'] = $quantity_sold;
                // 关注人数
                $sql0_0 = "select id from lkt_user_collection where store_id = '$store_id' and mch_id = '$mch_id'";
                $r0_0 = $db->select($sql0_0);
                $shop_list['collection_num'] = count($r0_0);
            }

            //用户基本信息
            $sql = "select * from lkt_user where access_id = '$access_id' and store_id = '$store_id'";
            $user = $db->select($sql);
            if ($user && !empty($access_id)) {
                $user_id = $user[0]->user_id; // 用户ID
                // 添加访问记录
                $sql = "insert into lkt_mch_browse(store_id,token,mch_id,user_id,event,add_time) values ('$store_id','$access_id','$mch_id','$user_id','访问了店铺',CURRENT_TIMESTAMP)";
                $db->insert($sql);
            }
        }
        // 用户评价
        $sql = "select a.*,b.headimgurl,b.user_name from lkt_comments a left join lkt_user b on a.uid=b.user_id where a.store_id = '$store_id' and a.pid='".$goods[0]->goods_id."' and a.attribute_id='".$goods[0]->attr_id."' order by a.add_time desc limit 0,1";
        $comments = $db->select($sql);
        $comm_count = 0;
        if ($comments) {// 评价存在时 查询评价总数
            $sql1 = "select COUNT(*) as count from lkt_comments a left join lkt_user b on a.uid=b.user_id where a.store_id = '$store_id' and a.pid='".$goods[0]->goods_id."' and a.attribute_id='".$goods[0]->attr_id."' order by a.add_time desc limit 0,1";
            $count1 = $db->select($sql1);
            $comm_count = $count1?$count1[0]->count:0;
        }

        echo json_encode(array("code" => 200, "goods" => $goods[0], "shop_list" => $shop_list, "comments" => $comments, "isopen" => $isopen, "comm_count" => $comm_count));exit;
    }
    // 积分商城规则
    public function rule()
    {    
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = intval($request->getParameter('store_id'));

        // 查询积分商城配置
        $sql = "select content from lkt_integral_config where store_id='$store_id'";
        $r = $db->select($sql);
        $content = $r?$r[0]->content:'';// 积分商城规则

        echo json_encode(array('code' => 200, 'content' => $content));exit;
    }
    // 支付
    public function payment()
    {    
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收参数
        $store_id = intval($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id'));
        $jifen_id =  addslashes($request->getParameter('jifen_id'));// 商品ID
        $address_id = $request->getParameter('address_id'); //  地址ID
        $store_type = addslashes(trim($request->getParameter('store_type')));// 来源 1.小程序 2.APP

        $log = new LaiKeLogUtils('common/app_integral.log');// 日志

        $buynum = 1;// 购买数量

        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }

        //用户基本信息
        $sql = "select * from lkt_user where access_id = '$access_id' and store_id = '$store_id'";
        $user = $db->select($sql);
        $user_id = $user[0]->user_id; // 用户ID
        $user_money = $user[0]->money; // 用户余额
        $user_score = $user[0]->score; // 用户总积分
        $lock_score = $user[0]->lock_score;//用户被冻结的积分

        $sql = "select g.integral,g.money,g.goods_id,g.attr_id,a.mch_id,a.freight,a.product_title,c.attribute,c.price,c.unit,c.num from lkt_integral_goods as g left join lkt_product_list as a on g.goods_id=a.id left join lkt_configure as c on g.attr_id = c.id  where g.store_id='$store_id' and g.id = '$jifen_id'";
        $g = $db->select($sql);
        if (!$g) {
            $log->customerLog(__LINE__.":积分订单下单失败:$sql \r\n");
            echo json_encode(array('code' => 112, 'message' => '下单失败,请稍后再试！'));
            exit;
        }

        $pdata = $g[0];
        $need_money = $pdata->money;     // 所需余额
        $need_score = $pdata->integral;  // 所需积分
        $attr_id = $pdata->attr_id;      // 属性ID
        $goods_id = $pdata->goods_id;    // 商品ID
        $num = $pdata->num;              // 库存

        // 查询默认地址
        $address = Tools::find_address($db,$store_id,$user_id,$address_id);
        $addemt = $address ? 1:0; // 收货地址状态

        $mobile = $address['tel'];          // 电话
        $name = $address['name'];           // 名字
        $sheng = $address['sheng'];         // 省
        $shi = $address['city'];            // 市
        $xian = $address['quyu'];           // 区/县
        $address_xq = $address['address'];  // 详细地址
        // 运费
        $freight_price = $freight = $this->freight($pdata->freight, 1, $address);
        // 余额
        $products_total = floatval($need_money) * intval($buynum);
        $total_money = floatval($need_money) * intval($buynum) + floatval($freight_price);
        // 积分
        $total_score = floatval($need_score) * intval($buynum);

        $attribute = unserialize($pdata->attribute);
        $pdata->size = '';
        foreach ($attribute as $k => $v) {
            $pdata->size .= ' ' . $v;
        }

        if (floatval($user_money) < floatval($total_money)) {
            $log->customerLog(__LINE__.":积分订单下单失败:余额不足，无法兑换！ \r\n");
            echo json_encode(array('code' => 110, 'message' => '余额不足，无法兑换！'));
            exit;
        }

        if (floatval($user_score - $lock_score) < floatval($total_score)) {
            $log->customerLog(__LINE__.":积分订单下单失败:可用积分不足，无法兑换！ \r\n");
            echo json_encode(array('code' => 110, 'message' => '可用积分不足，无法兑换！'));
            exit;
        }

        if (intval($num) < intval($buynum)) {
            $log->customerLog(__LINE__.":积分订单下单失败:库存不足，无法兑换！ \r\n");
            echo json_encode(array('code' => 110, 'message' => '库存不足，无法兑换！'));
            exit;
        }

        // 事物
        $db->begin();
        // 生成订单号
        $sNo = 'IN'.date("ymdhis").rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9); 
        // 减库存
        $sql = "update lkt_configure set num=num-$buynum where id='$attr_id' and num >= $buynum";
        $r = $db->update($sql);
        if ($r < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sql \r\n");
            echo json_encode(array('code' => 112, 'err' => $sql, 'line'=>__LINE__));
            exit;
        }
        // 减库存
        $sql = "update lkt_product_list set num=num-$buynum where id='$goods_id' and num >= $buynum";
        $r = $db->update($sql);
        if ($r < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sql \r\n");
            echo json_encode(array('code' => 112, 'err' => $sql, 'line'=>__LINE__));
            exit;
        }
        //  创建订单详情
        $sql_d = "insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,unit,r_sNo,add_time,r_status,size,sid,freight) VALUES ('$store_id','$user_id','$goods_id','$pdata->product_title','$need_money','$buynum','$pdata->unit','$sNo',CURRENT_TIMESTAMP,0,'$pdata->size','$attr_id','$freight_price')";
        $beres = $db->insert($sql_d);
        if ($beres < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sql_d \r\n");
            echo json_encode(array('code' => 112, 'err' => $sql_d, 'line'=>__LINE__));
            exit;
        }
        // 创建订单
        $sql_o = "insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,remark,pay,add_time,status,spz_price,source,otype,mch_id,allow,p_sNo) VALUES ('$store_id','$user_id','$name','$mobile','$buynum','$total_money','$sNo','$sheng','$shi','$xian','$address_xq',' ','wallet_pay',CURRENT_TIMESTAMP,0,'$products_total','$store_type','integral',',$pdata->mch_id,','$total_score','$jifen_id')";
        $order_id = $db->insert($sql_o, "last_insert_id");
        if ($order_id < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sql_o \r\n");
            echo json_encode(array('code' => 112, 'err' => $sql_o, 'line'=>__LINE__));
            exit;
        }
        // 修改用户余额与积分
        $sql = "update lkt_user set money=money-'$total_money',score=score-'$total_score' where store_id = '$store_id' and user_id = '$user_id' and money>='$total_money' and score>='$total_score'";
        $r = $db->update($sql);
        if ($r < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sql \r\n");
            echo json_encode(array('code' => 112, 'err' => $sql, 'line'=>__LINE__));
            exit;
        }
        // 添加操作记录
        $event = $user_id . '使用了' . $total_money . '元余额';
        $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$total_money','$user_money','$event',4)";
        $rr = $db->insert($sqll);
        if ($rr < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sqll \r\n");
            echo json_encode(array('code' => 112, 'err' => $sqll, 'line'=>__LINE__));
            exit;
        }
        // 添加操作记录
        $event = $user_id . '使用了' . $total_score . '积分';
        $sqll = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type,recovery) values ('$store_id','$user_id','$total_score','$event',CURRENT_TIMESTAMP,1,0)";
        $rr = $db->insert($sqll);
        if ($rr < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sqll \r\n");
            echo json_encode(array('code' => 112, 'err' => $sqll, 'line'=>__LINE__));
            exit;
        }
        // 修改订单状态与支付方式
        $sql = "update lkt_order set status=1,pay='wallet_pay',pay_time=CURRENT_TIMESTAMP where store_id = '$store_id' and sNo = '$sNo'";
        $r = $db->update($sql);
        if ($r < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sql \r\n");
            echo json_encode(array('code' => 112, 'err' => $sql, 'line'=>__LINE__));
            exit;
        }
        // 修改订单详情状态
        $sql = "update lkt_order_details set r_status=1 where store_id = '$store_id' and r_sNo='$sNo'";
        $r = $db->update($sql);
        if ($r < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":积分订单下单失败:$sql \r\n");
            echo json_encode(array('code' => 112, 'err' => $sql, 'line'=>__LINE__));
            exit;
        }
        $db->commit();

        echo json_encode(array('code' => 200, 'message' => '成功', 'order_id' => $order_id, 'sNo' => $sNo, 'total' => $total_money, 'total_score' => $total_score));
        exit;
    }
    // 确认订单数据加载
    public function integral_axios()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收参数
        $store_id = intval($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id'));
        $jifen_id =  addslashes($request->getParameter('id'));// 商品ID
        $address_id = $request->getParameter('address_id'); // 地址ID

        $log = new LaiKeLogUtils('common/app_integral.log');// 日志

        $sql = "select * from lkt_user where access_id = '$access_id' and store_id = '$store_id'";
        $user = $db->select($sql);
        if(!$user){
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }

        $total = 0;// 总价

        //用户基本信息
        $user_id = $user[0]->user_id;                       // 用户ID
        $user_money = $user[0]->money;                      // 用户余额
        $user_score = $user[0]->score;                      // 用户积分
        $user_password = $user[0]->password;                // 支付密码
        $login_num = $user[0]->login_num;                   // 支付密码错误次数
        $verification_time = $user[0]->verification_time;   // 支付密码验证时间
        $verification_time = date('Y-m-d H:i:s',strtotime('+1 day',strtotime($verification_time)));
        $time = date('Y-m-d H:i:s',time());
        // 能否支付
        if($login_num == 5){
            if($time < $verification_time){
                $enterless = false;
            }else{
                $sql = "update lkt_user set login_num = 0 where store_id = '$store_id' and user_id = '$user_id'";
                $db->update($sql);
                $enterless = true;
            }
        }else{
            $enterless = true;
        }
        // 是否设置支付密码
        if($user_password != ''){
            $password_status = 1;
        }else{
            $password_status = 0;
        }

        // 查询默认地址
        $address = Tools::find_address($db,$store_id,$user_id,$address_id);
        $addemt = $address ? 1:0; // 收货地址状态

        // 获取商品信息
        $products = array();
        $sql = "select g.integral,g.money,g.goods_id,a.mch_id,a.freight,a.product_title,c.price,c.img,c.attribute from lkt_integral_goods as g left join lkt_product_list as a on g.goods_id=a.id left join lkt_configure as c on g.attr_id = c.id  where g.id = '$jifen_id'";
        $goods = $db->select($sql);
        if ($goods) {
            // 商品属性
            $attribute = unserialize($goods[0]->attribute);
            $goods[0]->attribute = '';
            foreach ($attribute as $k => $v) {
                $goods[0]->attribute .= $v.",";
            }
            $goods[0]->attribute = substr($goods[0]->attribute,0,strlen($goods[0]->attribute)-1); 
            $products = (array)$goods[0];

            $products['imgurl'] = ServerPath::getimgpath($products['img']);// 商品图
            // 店铺
            $sql = "select * from lkt_mch where store_id = '$store_id' and id = '".$products['mch_id']."'";
            $shop = $db->select($sql);
            if ($shop) {
                $products['shop_name'] = $shop[0]->name;
                $products['shop_logo'] = $shop[0]->logo;
            }

            // 计算运费
            $products['freight'] = $freight = $this->freight($products['freight'], 1, $address);

            $total = floatval($products['money'])+floatval($freight);//商品价格+运费
        }

        // 返回数据
        echo json_encode(array('code' => 200,'products' => $products,'total'=>$total,'freight' => $freight, 'user_money' => $user_money, 'user_score' => $user_score, 'address' => $address,'addemt' => $addemt,'password_status'=>$password_status,'enterless'=>$enterless));
        exit;
    }
    // 计算运费
    public function freight($freight, $num, $address)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 根据运费ID查询详细配置
        $sql = "select * from lkt_freight where store_id = '$store_id' and id = '$freight'";
        $r_1 = $db->select($sql);
        if ($r_1) {
            $rule = $r_1[0];    // 运费配置
            $yunfei = 0;        // 运费
            if (empty($address)) {
                return 0;
            } else {
                $city = $address['sheng']."&nbsp;&nbsp;";
                $city2 = "&nbsp;&nbsp;".$address['sheng']."&nbsp;&nbsp;";
                $rule_1 = $r_1[0]->freight;
                $rule_2 = unserialize($rule_1);
                foreach ($rule_2 as $key => $value) {
                    $citys_str = $value['name'];
                    $citys_array = explode(',', $citys_str);
                    $citys_arrays = [];
                    foreach ($citys_array as $k => $v) {
                        $citys_arrays[$v] = $v;
                    }
                    if (array_key_exists($city, $citys_arrays) || array_key_exists($city2, $citys_arrays)) {
                        if ($num > $value['three']) {
                            $yunfei += $value['two'];
                            $yunfei += ($num - $value['three']) * $value['four'];
                        } else {
                            $yunfei += $value['two'];
                        }
                    }
                }
                return $yunfei;
            }
        } else {
            return 0;
        }
    }


}

?>