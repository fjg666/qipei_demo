<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 * @author 周文
 * @date 2018年12月10日
 * @version 2.0
 */
require_once(MO_LIB_DIR . '/phpqrcode.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class bargainAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
    }

    /**
     * 分配方法
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));

        if ($m == 'getgoodsdetail') {
            $this->getgoodsdetail();
        } else if ($m == 'bargainhome') {
            $this->bargainhome();
        } else if ($m == 'mybargain') {
            $this->mybargain();
        } else if ($m == 'helpbargain') {
            $this->helpbargain();
        } else if ($m == 'createbargain') {
            $this->createbargain();
        } else if ($m == 'shareimg') {
            $this->shareimg();
        } else if ($m == 'getRule') {
            $this->getRule();
        }else{
            echo json_encode(array('code' => 400, 'message' => '非法入侵！'));
        }

        return;
    }
    // 下载网络图片
    function downImgUrl($imgurl) {

        // 获取头像
        $imgPath = "./" . uniqid() . mt_rand(1, 200) . ".png";

        //合成头像
        $ch = curl_init($imgurl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_REFERER, '');
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);   //只需要设置一个秒的数量就可以
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $img = curl_exec($ch);
        curl_close($ch);
        file_put_contents($imgPath, $img);
        return $imgPath;
    }
    // base64转换为图片并保存
    function base64EncodeImage($image_file)
    {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }
    // 获得二维码，并储存到本地
    public function get_qrcode($url, $uploadImg, $size = 5)
    {
        $qrcode_name = md5(time() . rand(1000, 9999));
        $qrcode_name = 1;
        $value = $url;                  //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = $size;           //生成图片大小
        $filename = $uploadImg . '/' . $qrcode_name . '.png';

        QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        return $filename;
    }
    /**
     * 砍价商品列表
     * 状态 -1--失败 0--进行中 1--成功 2--付款
     */
    public function bargainhome()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));   // 商城ID
        $paegr = trim($request->getParameter('page'));          // 页码
        $userid = trim($request->getParameter('userid'));       // 用户ID
        $access_id = trim($request->getParameter('access_id')); // 授权ID
        $now = date('Y-m-d H:i:s',time());// 当前时间
        $db->update("update lkt_bargain_goods set status=2 where end_time<='$now' and is_delete=0");// 到期活动结束

        //如果没有传入page 默认传入第一页
        if (!$paegr) {$paegr = 1;}
        //查询条数
        $pagesize = 10;
        $start = ($paegr - 1) * $pagesize;

        $sql = "select * from lkt_bargain_config where store_id='$store_id'";
        $config = $db->select($sql);
        $headimg = !empty($config)?$config[0]->imgurl:'';         // 活动轮播图
        $show_time = !empty($config)?$config[0]->show_time:'';    // 商品活动结束后显示的时间
        $only_times = !empty($config)?$config[0]->only_times:1;   // 可参加的次数
        $buy_time = !empty($config)?$config[0]->buy_time:0;       // 砍价成功，购买的时间
        $sjs = $show_time * 3600;                                 // 结束后持续可见的秒数
        $time = date("Y-m-d H:i:s", time()-$sjs);                 // 不可见时间
        $now = date("Y-m-d H:i:s", time());                       // 当前时间
        $buytime = time()-floatval($buy_time)*3600;               // 计算多久之前的商品现在已经不能购买

        //查询用户信息
        $sql = "select * from lkt_user where access_id = '$access_id' and access_id != ''";
        $userInfo = $db->select($sql);
        if (!$userInfo || empty($userInfo)) {
            $user_id = '';
        }else{
            $user_id = $userInfo[0]->user_id;
        }

        // 查询商品信息
        $sql = "select b.id as bargain_id,b.*,c.* 
        from lkt_bargain_goods as b 
        left join lkt_product_list as a on b.goods_id=a.id 
        left join lkt_configure as c on b.attr_id=c.id 
        where b.store_id = '$store_id' and c.num>0 and b.is_delete=0 and (b.status=1 or b.status=2) and b.begin_time<'$now' AND is_show = 1 and b.end_time>'$time' and a.status=2 order by b.status asc limit $start,$pagesize";
        $res = $db->select($sql);
        if ($res) {
            foreach ($res as $k => $v) {
                // 查询商品名称
                $sql = "select product_title from lkt_product_list where id = '".$v->goods_id."'";
                $pro_res = $db->select($sql);
                $res[$k]->title = $pro_res[0]->product_title;
                // 商品图片
                $res[$k]->img = ServerPath::getimgpath($v->img);

                $v->isbegin = 1;// 活动开始
                $lefttime = $res[$k]->leftTime = strtotime($v->end_time) - time();// 默认计算活动剩余时间秒数
                if (strtotime($v->begin_time) > time()) {// 如果活动还未到开始时间
                    $v->isbegin = 0;// 活动未开始
                    $lefttime = $res[$k]->leftTime = strtotime($v->begin_time) - time();//计算活动距离开始时间秒数
                }
                $res[$k]->day = $res[$k]->hour = $res[$k]->mniuate = $res[$k]->second = '00';// 初始全部为0
                $day = $res[$k]->day = floor($lefttime / (3600 * 24))>0?floor($lefttime / (3600 * 24)):0;                       // 天
                $hour = $res[$k]->hour = floor(($lefttime % (3600 * 24)) / 3600)>0?floor(($lefttime % (3600 * 24)) / 3600):'00';// 小时
                $mniuate = $res[$k]->mniuate = floor(($lefttime % 3600) / 60)>0?floor(($lefttime % 3600) / 60):'00';            // 分
                $second = $res[$k]->second = floor(($lefttime % 3600) % 60)>0?floor(($lefttime % 3600) % 60):'00';              // 秒
                $res[$k]->status = 0;                                                                                           // 活动状态默认为0未开始

                // 当用户登录时 查询用户是否存在订单 status -1.砍价失败 0.未开始砍价 1.砍价中 2.砍价成功 3.已付款
                if ($userInfo) {
                    $sql = "select * from lkt_bargain_order where store_id='$store_id' and bargain_id='$v->bargain_id' and user_id='$user_id' order by id desc
                            limit 0,1";
                    $orr = $db->select($sql);
                    if ($orr) {
                        // $res[$k]->jx_res = 1;
                        $res[$k]->order_no = $orr[0]->order_no;
                        if ($orr[0]->status == 0) {// 砍价中
                            $res[$k]->status = 1;
                        }else if ($orr[0]->status == 1 || ($orr[0]->original_price == 0 && $orr[0]->status == 0)) {// 砍价成功
                            $res[$k]->status = 2;
                            // 查询订单状态
                            $sql = "SELECT id,status from lkt_order where status != '6' and status != '7' and status != '8' and  p_sNo = '$v->order_no'";
                            $ishas = $db->select($sql);
                            if ($ishas) {
                                $res[$k]->hasorder = 1;                 // 是否已经创建订单 1.是
                                $res[$k]->sNo_id = $ishas[0]->id;       // 订单ID
                                if (intval($ishas[0]->status) == 0) {   // 如果订单状态为待付款
                                    $res[$k]->gopay = 1;                // 1.去付款
                                    if (floatval($buy_time) > 0) {      // 后台设置结算时间大于0时
                                        // 查询订单
                                        $b_o_sql = "select * from lkt_bargain_order where order_no='$v->order_no' and achievetime>$buytime";
                                        $b_o = $db->select($b_o_sql);
                                        if (!$b_o) {
                                            $res[$k]->status = -1;
                                        }
                                    }
                                }else{
                                    $res[$k]->status = 3;
                                }
                            }
                        }else if ($orr[0]->status == 2) {// 已付款
                            $res[$k]->status = 3;
                        }else{// 失败
                            $res[$k]->status = -2;
                        }
                    }
                }
                unset($res[$k]->id);
                unset($res[$k]->begin_time);
                unset($res[$k]->end_time);
            }
            echo json_encode(array('code' => 200, 'list' => $res, 'img' => $headimg));
            exit;
        } else {
            echo json_encode(array('code' => 200, 'list' => $res, 'img' => $headimg));
            exit;
        }
    }

    /**
     * 砍价规则
     */
    public function getRule()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "SELECT rule FROM lkt_bargain_config where store_id='$store_id'";
        $ruleRes = $db->select($sql);
        $rule = $ruleRes?$ruleRes[0]->rule:''; // 砍价规则

        echo json_encode(array('code' => 200, 'rule' => $rule));exit;
    }

    /**
     * 我的砍价商品
     * 状态 -1--失败 0--进行中 1--成功 2--付款
     */
    public function mybargain()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $page = intval($request->getParameter('page'))?intval($request->getParameter('page')):1;// 页码
        $access_id = $request->getParameter('access_id');// 授权ID
        $pagesize = 10;// 查询行数
        $start = ($page - 1) * $pagesize;

        //查询用户信息
        $sql = "select * from lkt_user where access_id = '$access_id'";
        $userInfo = $db->select($sql);
        if (!$userInfo || $access_id == '') {
            echo json_encode(array('code' => 404, 'message' => '请登陆！'));
            exit;
        }
        $userid = $userInfo[0]->user_id;

        // 查询配置
        $sql = "select * from lkt_bargain_config where store_id='$store_id'";
        $r = $db->select($sql);
        $buy_time = $r[0]->buy_time;                // 砍价成功，购买的时间
        $buytime = time()-floatval($buy_time)*3600; // 计算多久之前的商品现在已经不能购买

        //查询已经参与砍价活动
        $sql = "select o.*,g.end_time from lkt_bargain_order as o left join lkt_bargain_goods as g on g.id = o.bargain_id where user_id = '$userid' and g.is_delete = 0 order by o.status desc limit $start,$pagesize";
        $res = $db->select($sql);

        $jixuArr        = [];
        $fukuanArr      = [];
        $shibaiArr      = [];
        $wanchengArr    = [];
        $jixuindex      = $fukuanindex = $shibaiindex = $wanchengindex = 0;
        if ($res) {
            //已经参与砍价活动
            foreach ($res as $k => $v) {
                $bargain_id = $v->bargain_id;// 砍价商品ID
                $status = $v->status;        // 订单状态
                // 商品表
                $sql = "SELECT * from lkt_product_list where id = '".$v->goods_id."'";
                $goodsRes = $db->select($sql);
                $v->title = $goodsRes[0]->product_title;                    // 商品名称
                // 属性表
                $sql = "SELECT * from lkt_configure where id = '".$v->attr_id."'";
                $attrRes = $db->select($sql);
                $res[$k]->img = $attrRes?ServerPath::getimgpath($attrRes[0]->img):'';   // 商品图
                $res[$k]->price = $attrRes?$attrRes[0]->price:0;                       // 原价
                // 砍价商品表
                $sql = "SELECT * from lkt_bargain_goods where id = '$bargain_id' and store_id = '$store_id'";
                $bar = $db->select($sql);
                $res[$k]->leftTime = strtotime($bar[0]->end_time) - time(); // 活动剩余时间
                // 计算一共砍了多少钱了
                $sql = "SELECT SUM(money) as money from lkt_bargain_record where order_no = '$v->order_no' and store_id = $store_id";
                $sum = $db->select($sql);
                $res[$k]->success_money = $sum[0]->money;//算到小数点后两位
                // 初始化时间
                $res[$k]->hour = "00";
                $res[$k]->mniuate = "00";
                $res[$k]->second = "00";
                $res[$k]->isbegin =  1;
                $res[$k]->status = 1;
                $res[$k]->canbuy = -1;
                // 查询订单
                $sql = "SELECT id,status from lkt_order where status != '6' and status != '7' and status != '8' and bargain_id = '$bargain_id' and  p_sNo = '$v->order_no'";
                $ishas = $db->select($sql);
                // status -1.砍价失败 0.未开始砍价 1.砍价中 2.砍价成功 3.已付款
                if (intval($status) == 0) {//砍价中
                    $res[$k]->status = 1;
                    $jixuArr[$jixuindex] = $res[$k];
                    $jixuindex++;
                }else if (intval($status) == 1 || (intval($v->original_price) == 0 && intval($status) == 0)) {//成功
                    if (floatval($buy_time) > 0) {// 设置了购买时间
                        $canbuy = date('Y-m-d H:i:s',strtotime("+".$buy_time."hour",$v->achievetime));// 购买截止时间
                        $res[$k]->canbuy = strtotime($canbuy) - time();// 购买时间 = 截止时间-当前时间
                    }else{
                        $res[$k]->canbuy = $res[$k]->leftTime;// 购买时间 = 活动剩余时间
                    }
                    if (intval($res[$k]->canbuy) > 0) {// 当购买时间大于0时
                        $res[$k]->status = 2;
                        if ($ishas) {// 如果订单已创建
                            $res[$k]->hasorder = 1;
                            $res[$k]->sNo_id = $ishas[0]->id;
                            if (intval($ishas[0]->status) == 0) {// 如果订单状态为待付款
                                $res[$k]->gopay = 1;
                            }else{
                                $res[$k]->status = 3;
                            }
                        }
                        $wanchengArr[$wanchengindex] = $res[$k];
                        $wanchengindex++;
                    }else{
                        $res[$k]->status = -1;
                        $shibaiArr[$shibaiindex] = $res[$k];
                        $shibaiindex++;
                    }
                }else if (intval($status) == 2) {//已付款
                    $res[$k]->status = 3;
                    $wanchengArr[$wanchengindex] = $res[$k];
                    $wanchengindex++;
                }else{//失败
                    $res[$k]->status = -1;
                    $shibaiArr[$shibaiindex] = $res[$k];
                    $shibaiindex++;
                }
            }
            $new_res = array_merge($wanchengArr,$jixuArr);
            $new_res = array_merge($new_res, $fukuanArr);
            $new_res = array_merge($new_res, $shibaiArr);
            echo json_encode(array('code' => 200, 'list' => $new_res));
            exit;
        } else {
            echo json_encode(array('code' => 200, 'list' => $res));
            exit;
        }
    }

    /**
     * 砍价商品详情
     */
    public function getgoodsdetail()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $oid = trim($request->getParameter('order_no'));        // 砍价订单号
        $ishelp_ = trim($request->getParameter('isHelp'));      // 帮好友砍
        $attr_id = trim($request->getParameter('attr_id'));     // 商品属性
        $store_id = trim($request->getParameter('store_id'));   // 商城ID
        $access_id = trim($request->getParameter('access_id')); // 授权ID
        $bargain_id = trim($request->getParameter('bargain_id'));// 砍价商品ID
        // 验证用户是否登录
        $store_type = 2;
        $islogin = 1;
        $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id);
        if($getPayload_test == false){ // 过期
            $islogin = 0;
        }
        // 验证用户是否登录 end
        // 查询砍价订单
        $sql = "select * from lkt_bargain_order where order_no = '$oid'";
        $orderRes = $db->select($sql);

        $res = $this->getlist($orderRes);
        $list = $res['list'];
        $status = $res['status'];

        // 查询帮砍好友
        $sql = "SELECT user_id from lkt_bargain_record where order_no = '$oid'  AND store_id = $store_id";
        $helpRes = $db->select($sql);
        $help_list = [];
        foreach ($helpRes as $k => $v) {
            $_userid = $v->user_id;
            // 查询好友昵称与头像
            $sql = "SELECT user_name,headimgurl from lkt_user where user_id = '$_userid'";
            $frdInfo1 = $db->select($sql);
            // 查询帮砍金额
            $sql = "SELECT money from lkt_bargain_record WHERE order_no = '$oid' and user_id ='$v->user_id'";
            $frdInfo2 = $db->select($sql);

            $help_list[$k]['user_name'] = $frdInfo1?$frdInfo1[0]->user_name:'';     // 好友昵称
            $help_list[$k]['headimgurl'] = $frdInfo1?$frdInfo1[0]->headimgurl:'';   // 好友头像
            $help_list[$k]['bargain_money'] = $frdInfo2?$frdInfo2[0]->money:'0.00'; // 帮砍金额
        }
        // 判断活动是否结束 false未结束 true结束
        $loseEfficacy = false;
        if (intval($list->is_show) == 0) {
            $loseEfficacy = true;
        }
        // 如果是帮砍
        if ($ishelp_ == 1) {
            // 查询用户是否登录
            $selSql = "SELECT user_name,headimgurl from lkt_user where access_id = '$access_id'";
            $userRes = $db->select($selSql);
            if ($access_id == '' || !$userRes) {
                echo json_encode(array('code' => 404, 'message' => '未登录，请先登陆！！', 'loseEfficacy' => $loseEfficacy, 'list' => $list, 'help_list' => $help_list, 'status' => $status, 'islogin' => $islogin));
                exit;
            }
            $selfRes['user_name'] = $userRes[0]->user_name;     // 用户昵称
            $selfRes['headimgurl'] = $userRes[0]->headimgurl;   // 用户头像
            echo json_encode(array('code' => 200, 'self' => $selfRes, 'list' => $list, 'help_list' => $help_list, 'loseEfficacy' => $loseEfficacy, 'status' => $status, 'islogin' => $islogin));
            exit;
        }
        echo json_encode(array('code' => 200, 'list' => $list, 'help_list' => $help_list, 'loseEfficacy' => $loseEfficacy, 'status' => $status, 'islogin' => $islogin));
        exit;
    }

    /**
     * 列表数据梳理
     */
    public function getlist($orderRes)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $oid = trim($request->getParameter('order_no'));        // 砍价订单号
        $store_id = trim($request->getParameter('store_id'));   // 商城ID
        $access_id = trim($request->getParameter('access_id')); // 授权ID
        $bargain_id = trim($request->getParameter('bargain_id'));// 砍价商品ID

        $list = [];
        // status -1.砍价失败 0.未开始砍价 1.砍价成功 2.已付款
        if ($orderRes) {
            //商品表
            $sql = "select * from lkt_product_list where id = '".$orderRes[0]->goods_id."'";
            $goodsRes = $db->select($sql);
            $orderRes[0]->title = $goodsRes?$goodsRes[0]->product_title:'';                 // 商品名称
            //属性表
            $sql = "select * from lkt_configure where id = '".$orderRes[0]->attr_id."'";
            $attrRes = $db->select($sql);
            $orderRes[0]->img = $attrRes?ServerPath::getimgpath($attrRes[0]->img):'';       // 商品图片
            $orderRes[0]->price = $attrRes?$attrRes[0]->price:'0.00';                       // 商品原价
            //砍价商品表
            $sql = "select * from lkt_bargain_goods where store_id = '$store_id' and id='$bargain_id'";
            $barGRes = $db->select($sql);
            $orderRes[0]->is_show = $barGRes?$barGRes[0]->is_show:0;                        // 活动是否显示
            $orderRes[0]->bargain_id = $barGRes?$barGRes[0]->id:'';                         // 砍价活动ID
            $orderRes[0]->leftTime = $barGRes?strtotime($barGRes[0]->end_time) - time():0;  // 活动剩余时间
            // 查询砍价订单
            $sql = "select id,status from lkt_order where status != '6' and status != '7' and status != '8' and bargain_id = '$bargain_id' and  p_sNo = '$oid'";
            $ishas = $db->select($sql);
            $orderRes[0]->hasorder = 0;                 // 是否创建订单 0.没创建 1.创建了
            if ($ishas) {                               // 如果订单存在
                $orderRes[0]->hasorder = 1;             // 订单已创建
                $orderRes[0]->sNo_id = $ishas[0]->id;   // 订单ID
                if (intval($ishas[0]->status) == 0) {   // 如果订单状态为待付款
                    $orderRes[0]->gopay = 1;            // 去付款
                }
            }
            // 查询砍价记录总金额
            $sql = "SELECT SUM(money) as money from lkt_bargain_record where order_no = '$oid' and store_id = $store_id";
            $sum = $db->select($sql);
            $orderRes[0]->free_money = $orderRes[0]->price - $orderRes[0]->min_price;   // 计算需要砍的价格
            $orderRes[0]->free_money = sprintf("%.2f", $orderRes[0]->free_money);       // 精确到两位小数
            $orderRes[0]->success_money = sprintf("%.2f", floatval($sum[0]->money));    // 已砍总额
            //初始化时分秒
            $orderRes[0]->hour = "00";
            $orderRes[0]->mniuate = "00";
            $orderRes[0]->second = "00";
            $list = $orderRes[0];
        }
        $list = (array)$list;
        //查询用户信息
        $usql = "select user_id from lkt_user where store_id = $store_id and access_id = '$access_id'";
        $urr = $db->select($usql);
        $status = '';
        if ($urr) {
            //查询用户是否帮砍过
            $sql = "select id from lkt_bargain_record where order_no='$oid' and user_id='".$urr[0]->user_id."'";
            $r = $db->select($sql);
            if ($r) {$status = 500;}
            // 查询用户是否参与此砍价 selfstatus 0.进行中 1.待付款 2.已付款 3.失败 4.未参与
            $sql = "select status,order_no,achievetime from lkt_bargain_order where store_id = $store_id and user_id='".$urr[0]->user_id."' and bargain_id='$bargain_id'";
            $rrr = $db->select($sql);
            if ($rrr) {
                $list['selfstatus'] = 0;                      // 用户订单状态默认为0进行中
                $achievetime = $rrr[0]->achievetime;        // 砍价成功时间
                $list['selforder_no'] = $rrr[0]->order_no;    // 用户砍价成功订单号
                // 查询用户此砍价活动的订单
                $sql = "select id,status,p_sNo from lkt_order where status != '6' and status != '7' and status != '8' and  p_sNo = '".$rrr[0]->order_no."'";
                $urr = $db->select($sql);
                if ($urr) {
                    $list['selfhasorder'] = 1;    // 1.订单存在
                    $uusta = $urr[0]->status;   // 订单状态
                    if ($uusta == 0) {
                        $list['selfstatus'] = 1;
                        // 查询砍价配置
                        $sql = "select buy_time from lkt_bargain_config where store_id = '$store_id'";
                        $r = $db->select($sql);
                        $buytime = floatval($r[0]->buy_time);
                        if ($r && floatval($r[0]->buy_time) > 0 && floatval($achievetime) > 0) {
                            $jutime = floatval($r[0]->buy_time) * 3600;     // 购买时限（秒）
                            $chatime = time() - $achievetime;               // 计算砍价成功距离现在已经多少秒
                            $list['selfstatus'] = 1;
                            if ($chatime > $jutime) {       // 如果距离时间大于购买时限 状态砍价失败
                                $list['selfstatus'] = 3;
                            }
                        }
                    }else if ($uusta == 1) {
                        $list['selfstatus'] = 2;
                    }
                }
            }else{
                $list['selfstatus'] = 4;
            }
        }else{
            $list['selfstatus'] = 4;
        }

        $res = array(
            'status' => $status,
            'list' => (object)$list
        );

        return $res;
    }

    /**
     * 创建一条砍价商品订单
     */
    public function createbargain()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id'));// 授权ID
        $bargain_id = intval(trim($request->getParameter('bargain_id')));// 砍价活动ID
        $log = new LaiKeLogUtils('common/app_bargain.log');// 日志
        //查询用户信息
        $sql = "select * from lkt_user where access_id = '$access_id'";
        $userInfo = $db->select($sql);
        if (!$userInfo || $access_id == '') {
            echo json_encode(array('code' => 404, 'message' => '请登录！', 'list' => array()));
            exit;
        }
        $userid = $userInfo[0]->user_id;// 用户ID
        //查询订单商品状态参数
        $selSql = "select * from `lkt_bargain_goods` where store_id = '$store_id' and id = '$bargain_id'";
        $statusRes = $db->select($selSql);
        if (!$statusRes) {
            echo json_encode(array('code' => 0));
            exit;
        }
        $goods_id = $statusRes[0]->goods_id;                    // 商品ID
        $attr_id = $statusRes[0]->attr_id;                      // 属性ID
        $data = $statusRes[0]->status_data;                     // 砍价方式数据
        $status_data = unserialize($data);                      // 解压砍价方式数据
        $min_price = $statusRes[0]->min_price;                  // 最低价
        $man_num = $statusRes[0]->man_num;                      // 砍价人数 0为不限制
        $time = time();                                         // 当前时间
        //查询商品价格
        $selSql = "select price from lkt_configure where id = '$attr_id' and num>0";
        $selRes = $db->select($selSql);
        if (empty($selRes)) {
            echo json_encode(array('code' => 500, 'message' => '库存不足，无法参与砍价！'));
            exit;
        }
        $price = $selRes[0]->price; // 商品原价
        //生成订单号
        $order_sNo = 'KJ' . substr($time, 5) . mt_rand(10000, 99999);
        // 自己砍一刀
        if ($man_num == 0) {// 如果没有设置人数
            $kan = rand(($status_data->min_not) * 10, ($status_data->max_not) * 10) / 10;//随机砍价金额
        } else {// 设置了人数
            $kan = rand(($status_data->min_one) * 10, ($status_data->max_one) * 10) / 10;//随机砍价金额
        }
        $original_price = floatval($price) - floatval($min_price) - floatval($kan);      // 剩余价格 = 商品原价-最低价格-自己砍价金额
        $original_price = sprintf("%.2f", $original_price);                              //算到小数点后两位

        // 查询是否存在订单
        $sql = "select * from lkt_bargain_order where store_id = '$store_id' and user_id = '$userid' and attr_id = '$attr_id' and bargain_id = '$bargain_id' and goods_id = '$goods_id'";
        $isin = $db->select($sql);
        if (!$isin) {
            $db->begin();// 事物开始
            // 添加一条砍价订单
            $sql = "insert into lkt_bargain_order(store_id,user_id,order_no,attr_id,goods_id,original_price,min_price,status,addtime,status_data,bargain_id) values('$store_id','$userid','$order_sNo',$attr_id,$goods_id,'$original_price',$min_price,0,'$time','$data','$bargain_id')";
            $ist = $db->insert($sql);
            if ($ist < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":创建砍价订单失败:$sql \r\n");
                echo json_encode(array('code' => 500, 'message' => '添加砍价订单失败！'));exit;
            }
            //生成一条砍价记录
            $istSql = "insert into lkt_bargain_record(store_id,order_no,user_id,money,add_time) values('$store_id','$order_sNo','$userid',$kan,$time)";
            $istRes = $db->insert($istSql);
            if ($istRes < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":创建砍价订单失败:$istSql \r\n");
                echo json_encode(array('code' => 500, 'message' => '添加砍价记录失败！'));exit;
            }

            //先扣除一个产品库存
            $updsql = "update lkt_configure set num=num-1 where id='$attr_id' and num>0";
            $updres = $db->update($updsql);
            if ($updres < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":创建砍价订单失败:$updsql \r\n");
                echo json_encode(array('code' => 500, 'message' => '库存不足，无法参与砍价！'));exit;
            }
            $db->commit();// 事物提交
            // 查询砍价订单
            $sql = "select * from lkt_bargain_order where order_no = '$order_sNo'";
            $orderRes = $db->select($sql);
        }else{
            $order_sNo = $isin[0]->order_no;    // 订单号
            $orderRes = $isin;                  // 砍价订单详情
        }
        //查询帮砍好友
        $selSql = "select a.user_name,a.headimgurl,b.money from lkt_user a left join lkt_bargain_record b on a.user_id=b.user_id where a.access_id = '$access_id' and b.order_no='$order_sNo'";
        $userRes = $db->select($selSql);
        $help_list = [];
        $help_list[0]['user_name'] = $userRes?$userRes[0]->user_name:'';    // 好友昵称
        $help_list[0]['bargain_money'] = $userRes?$userRes[0]->money:'0.00';// 帮砍金额
        $help_list[0]['headimgurl'] = $userRes?$userRes[0]->headimgurl:'';  // 好友头像
        // 砍价详情
        $list = [];
        if ($orderRes) {
            //商品表
            $sql = "select * from lkt_product_list where id = " . $orderRes[0]->goods_id;
            $goodsRes = $db->select($sql);
            $orderRes[0]->title = $goodsRes?$goodsRes[0]->product_title:'';          // 商品名称
            //属性表
            $sql = "select * from lkt_configure where id = " . $orderRes[0]->attr_id;
            $attrRes = $db->select($sql);
            $orderRes[0]->price = $attrRes?$attrRes[0]->price:'0.00';                // 原价
            $orderRes[0]->img = $attrRes?ServerPath::getimgpath($attrRes[0]->img):'';// 商品图
            //砍价商品表
            $sql = "select * from lkt_bargain_goods where id = " . $bargain_id;
            $barGRes = $db->select($sql);
            $orderRes[0]->bargain_id = $barGRes?$barGRes[0]->id:'';                     // 砍价ID
            $orderRes[0]->leftTime = $barGRes?strtotime($barGRes[0]->end_time)-time():0;// 活动剩余时间
            $sql = "select SUM(money) as money from lkt_bargain_record where order_no = '$order_sNo' and store_id = $store_id";
            $sum = $db->select($sql);
            $orderRes[0]->success_money = sprintf("%.2f", floatval($sum[0]->money));    // 已砍金额
            $orderRes[0]->free_money = floatval($orderRes[0]->price)-floatval($orderRes[0]->min_price);   // 需砍金额
            $orderRes[0]->free_money = sprintf("%.2f", $orderRes[0]->free_money);       // 需砍金额算到小数点后两位
            //初始化时分秒
            $orderRes[0]->hour = "00";
            $orderRes[0]->mniuate = "00";
            $orderRes[0]->second = "00";
            $list = $orderRes[0];
        }
        if ($isin) {//已经参加了该商品砍价！
            echo json_encode(array('code' => 200, 'message' => '', 'status' => 500, 'list' => $list, 'order_no' => $order_sNo, 'loseEfficacy' => false, 'min_price' => $min_price, 'help_list' => $help_list));
            exit;
        }
        echo json_encode(array('code' => 200, 'list' => $list, 'loseEfficacy' => false, 'order_no' => $order_sNo, 'bargain_money' => $kan, 'min_price' => $min_price, 'difference' => $original_price, 'help_list' => $help_list));
        exit;
    }

    /**
     * 好友帮忙砍价操作
     */
    public function helpbargain()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收参数
        $store_id = trim($request->getParameter('store_id'));
        $access_id = $request->getParameter('access_id');
        $oid = $request->getParameter('order_no');// 订单号
        $log = new LaiKeLogUtils('common/app_bargain.log');// 日志
        $time = time();// 当前时间
        $code = 200;   //状态值
        $status = "fail";

        // 验证用户是否登录
        $sql = "select * from lkt_user where access_id = '$access_id' and user_id != ''";
        $userInfo = $db->select($sql);
        if (empty($userInfo[0]->id) || !$userInfo || $access_id == '') {
            echo json_encode(array('code' => 404, 'message' => '未登录，请先登陆！！'));
            exit;
        }
        $store_type = 2;
        $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id);
        if($getPayload_test == false){ // 过期
            echo json_encode(array('code' => 404, 'message' => '未登录，请先登陆！！'));
            exit;
        }
        $userid = $userInfo[0]->user_id;    // 用户ID
        // 验证用户是否登录 end

        //查询商品数据
        $sql = "select * from lkt_bargain_order WHERE order_no = '$oid'";
        $orderRes = $db->select($sql);
        $list = [];
        $code = 1;
        if ($orderRes) {
            $list = $this->getlistt($orderRes);
        }

        //查询帮砍好友
        $sql = "SELECT user_id from lkt_bargain_record where order_no = '$oid' AND store_id = 1";
        $helpRes = $db->select($sql);
        $help_list = [];
        foreach ($helpRes as $k => $v) {
            $_userid = $v->user_id;
            $sql = "SELECT a.user_name,a.headimgurl,b.money from lkt_user a left join lkt_bargain_record b on a.user_id=b.user_id where a.user_id = '$_userid' and b.order_no = '$oid'";
            $frdInfo1 = $db->select($sql);
            $help_list[$k]['user_name']     = $frdInfo1?$frdInfo1[0]->user_name:''; // 好友昵称
            $help_list[$k]['bargain_money'] = $frdInfo1?$frdInfo1[0]->money:'0.00'; // 帮砍金额
            $help_list[$k]['headimgurl']    = $frdInfo1?$frdInfo1[0]->headimgurl:'';// 好友头像
        }

        //查询一条砍价信息
        $sql = "select o.*,g.* from lkt_bargain_order as o left join lkt_bargain_goods as g on o.bargain_id=g.id where o.store_id = '$store_id' and o.order_no='$oid'";
        $res = $db->select($sql);
        list($res) = $res;

        //查询此人是否已经对同一个订单已经砍过价
        $sql = "SELECT id from lkt_bargain_record WHERE order_no = '$oid' AND user_id = '$userid' AND user_id !=''";
        $can_nex = $db->select($sql);
        if (count($can_nex) > 0) {
            //参加过，停止接下来的操作
            echo json_encode(array('$sql' => $sql, 'code' => 200, 'status' => $status, 'statusCode' => 500, 'help_list' => $help_list, 'message' => '您已经帮他砍过这件商品了！', 'list' => $list));
            exit;
        }
        //查询已经有多少人参加砍价
        $sel_hel_num_sql = "SELECT COUNT(*) as num FROM lkt_bargain_record WHERE order_no = '$oid' AND store_id = $store_id";
        $hel_num_Res = $db->select($sel_hel_num_sql);
        $hel_num = $hel_num_Res[0]->num;// 已经帮忙砍价的好友人数
        $man_num = intval($res->man_num);// 砍价人数 0为不限制
        // 事物开始
        $db->begin();
        $status_data = unserialize($res->status_data);
        if (isset($status_data->min_not) && isset($status_data->max_not)) {
            //不限制人数
            $minprice = floatval($status_data->min_not);
            $maxprice = floatval($status_data->max_not);
        } else if ($status_data->one_man <= $hel_num) {
            //限制了人数而且已经达到第一批人数
            $minprice = floatval($res->original_price);
            $maxprice = floatval('0.01');
        } else {
            //限制了人数，人数没达到第一批人数
            $minprice = floatval($status_data->min_one);
            $maxprice = floatval($status_data->max_one);
        }
        $original_price = floatval($res->original_price);   //剩余价格
        if ($man_num == 0) {//没有限制人数
            if ($original_price >= $minprice) { //大于最大值的区间取随机数
                if ($maxprice > $original_price) {
                    $maxprice = $original_price;
                }
                $randprice = mt_rand($minprice * 100, $maxprice * 100) / 100;
            } else { //小于最大值的区间取差价,砍价成功
                $randprice = $original_price;
            }
            if ($randprice == $original_price) {
                $status = "success";
                $updsql = "update lkt_bargain_order set original_price = original_price - $randprice,status=1 , achievetime = $time where store_id = '$store_id' and order_no='$oid'";
            }else{
                $updsql = "update lkt_bargain_order set original_price = original_price - $randprice where store_id = '$store_id' and order_no='$oid'";
            }
            $updres = $db->update($updsql);
            //判断数据是否处理成功
            if ($updres < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":帮砍失败:$updsql \r\n");
                echo json_encode(array('code' => 500, 'message' => '砍价异常！'));exit;
            }
        } else {//设置了限制人数
            $redsql = "select count(*) as num from lkt_bargain_record where store_id = '$store_id' and order_no='$oid'";
            $redres = $db->select($redsql);
            $redres = intval($redres[0]->num);          //查询此订单下的砍价记录数
            $oneman = intval($status_data->one_man);    //前多少个人
            $snum = intval($man_num)-intval($redres);   //还需要几人才能砍价成功
            $twoman = intval($man_num)-intval($oneman); //第二波人数
            if ($redres < $oneman) {//在第一波人之内
                $minprice = floatval($status_data->min_one);
                // 0.计算出第一批还有多少人没砍
                $oneneed = $snum-$twoman;
                // 1.计算出第二波人每人砍0.01,第一批人最多还能砍多少
                $onecan = $original_price-($twoman*0.01);
                // 2.计算出第一波人后面每人砍最低价,这个人最多能砍多少
                $maxprice_ = $onecan-($oneneed*$minprice);
                // 3.判断最大值是否超过后台设置最大值 如果超过 为最大值
                $maxprice_ = $maxprice_>floatval($status_data->max_one)?floatval($status_data->max_one):$maxprice_;
                // 4.判断最大值是否超过剩余价格 如果超过 最大值为剩余价格
                $maxprice = $original_price<$maxprice_?$original_price:$maxprice_;
            } else {//在第二波人之内
                if ($snum > 1) {
                    $minprice = '0.01';
                    $maxprice = $original_price-($snum*0.01);
                }else{
                    $minprice = $original_price;
                    $maxprice = $original_price;
                }
            }
            if ($snum > 1) { //如果不是最后一个人
                $randprice = mt_rand($minprice * 100, $maxprice * 100) / 100;
                $updsql = "update lkt_bargain_order set original_price=original_price-$randprice where store_id = '$store_id' and order_no='$oid'";
                $updres = $db->update($updsql);
                //判断数据是否处理成功
                if ($updres < 1) {
                    $db->rollback();
                    $log->customerLog(__LINE__.":帮砍失败:$updsql \r\n");
                    echo json_encode(array('code' => 500, 'message' => '砍价异常！'));exit;
                }
            } else { //小于最大值的区间取差价,砍价成功
                $randprice = $original_price;
                $updsql = "update lkt_bargain_order SET original_price=original_price-$randprice , status=1 , achievetime = $time where store_id = $store_id and order_no='$oid'";
                $updres = $db->update($updsql);
                if ($updres < 1) {
                    $db->rollback();
                    $log->customerLog(__LINE__.":帮砍失败:$updsql \r\n");
                    echo json_encode(array('code' => 500, 'message' => '砍价异常！'));exit;
                } else {
                    $status = "success";
                }
            }
        }
        $istsql = "insert into lkt_bargain_record(store_id,order_no,user_id,money,add_time) values($store_id,'$oid','$userid','$randprice','$time')";
        $istres = $db->insert($istsql);
        if ($istres < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":帮砍失败:$istsql \r\n");
            echo json_encode(array('code' => 500, 'message' => '砍价异常！'));exit;
        } else {
            $log->customerLog(__LINE__.":帮砍成功！ \r\n");
            $db->commit();
        }

        $user_name = $userInfo[0]->user_name;   // 用户昵称 
        $headimg = $userInfo[0]->headimgurl;    // 用户头像

        echo json_encode(array('code' => 200, 'statusCode ' => '200', 'user_name' => $user_name, 'headimgurl' => $headimg, 'list' => $list, 'status' => $status, 'help_list' => $help_list, 'randprice' => $randprice));
        exit;

    }

    /**
     * 获取商品详情list
     */
    public function getlistt($orderRes)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收参数
        $store_id = trim($request->getParameter('store_id'));
        $oid = $request->getParameter('order_no');// 订单号
        //商品表
        $sql = "select * from lkt_product_list where id = '".$orderRes[0]->goods_id."'";
        $goodsRes = $db->select($sql);
        $orderRes[0]->title = $goodsRes?$goodsRes[0]->product_title:'';                 // 商品名称
        //属性表
        $sql = "select * from lkt_configure where id = '".$orderRes[0]->attr_id."'";
        $attrRes = $db->select($sql);
        $orderRes[0]->img = $attrRes?ServerPath::getimgpath($attrRes[0]->img):'';       // 商品图片
        $orderRes[0]->price = $attrRes?$attrRes[0]->price:'0.00';                       // 商品原价
        //砍价商品表
        $sql = "select * from lkt_bargain_goods where store_id = '$store_id' and id='".$orderRes[0]->bargain_id."'";
        $barGRes = $db->select($sql);
        $orderRes[0]->is_show = $barGRes?$barGRes[0]->is_show:0;                        // 活动是否显示
        $orderRes[0]->bargain_id = $barGRes?$barGRes[0]->id:'';                         // 砍价活动ID
        $orderRes[0]->leftTime = $barGRes?strtotime($barGRes[0]->end_time) - time():0;  // 活动剩余时间
        // 查询砍价订单
        $sql = "select id,status from lkt_order where status != '6' and status != '7' and status != '8' and bargain_id = '".$orderRes[0]->bargain_id."' and  p_sNo = '$oid'";
        $ishas = $db->select($sql);
        $orderRes[0]->hasorder = 0;                 // 是否创建订单 0.没创建 1.创建了
        if ($ishas) {                               // 如果订单存在
            $orderRes[0]->hasorder = 1;             // 订单已创建
            $orderRes[0]->sNo_id = $ishas[0]->id;   // 订单ID
            if (intval($ishas[0]->status) == 0) {   // 如果订单状态为待付款
                $orderRes[0]->gopay = 1;            // 去付款
            }
        }
        // 查询砍价记录总金额
        $sql = "SELECT SUM(money) as money from lkt_bargain_record where order_no = '$oid' and store_id = $store_id";
        $sum = $db->select($sql);
        $orderRes[0]->free_money = $orderRes[0]->price - $orderRes[0]->min_price;   // 计算需要砍的价格
        $orderRes[0]->free_money = sprintf("%.2f", $orderRes[0]->free_money);       // 精确到两位小数
        $orderRes[0]->success_money = sprintf("%.2f", floatval($sum[0]->money));    // 已砍总额
        //初始化时分秒
        $orderRes[0]->hour = "00";
        $orderRes[0]->mniuate = "00";
        $orderRes[0]->second = "00";
        $list = $orderRes[0];

        return $list;
    }

}

?>