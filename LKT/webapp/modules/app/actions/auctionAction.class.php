<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Apimiddle.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JWT.php');
require_once(MO_LIB_DIR . '/phpqrcode.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');

/**
 * [Laike System] Copyright (c) 2019 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class auctionAction extends Action
{

    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 小程序的竞拍接口
     * @date 2019年1月7日
     * @version 1.0
     */

    public function getDefaultView()
    {
        echo json_encode(array('code' => 200, 'msg' => 404));
    }



    public function execute()
    {
       
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
       
        //接受参数
        $store_id = addslashes(trim($request->getParameter('store_id')));
        $store_type = trim($request->getParameter('store_type'));
        $m = addslashes(trim($request->getParameter('m')));
        //没有access_id 只能访问竞拍首页
        $access_id = addslashes(trim($request->getParameter('access_id')));

        $m = $m ? $m : 'getDefaultView';
        $this->access_id = $access_id;
        $this->store_id  = $store_id;
        $this->request = $request;
        $this->db = $db;

        if($m == 'bid' || $m == 'bid_detail' || $m == 'go_pay'){
            if(!empty($access_id)){ // 存在
                $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                if($getPayload_test == false){ // 过期
                    echo json_encode(array('code' => 404, 'message' => '请登录！'));
                    exit;
                }
            } 
        }
        //增加该类中的公共属性，调用到各方法
        //跳转具体的方法
        $this->$m();

        return;
    }

    //竞拍首页

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    public function index()
    {

        //获取类属性
        $db = $this->db;
        $store_id = $this->store_id;
        $access_id = $this->access_id;
        $request = $this->request;
        $type = addslashes(trim($request->getParameter('type')));
        $page = addslashes(trim($request->getParameter('page')));

        //登录状态
        if(empty($access_id)){//用户未登录
            $is_user = 0;
            $user_id = '';
        }else{

            $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $res = $db->select($sql);

            if($res){

                $user_id = $res[0]->user_id;
                $is_user = 1;//用户已登录
            }else{
                $user_id = '';
                $is_user = 0;//用户未登录
            }
        }
        //分页
        $size = 10;
        if($page){
            $start = ($page - 1)* $size;
        }else{
            $start = 0;
        }
        //列表页数据
        if($type == 'ready'){//未开始的竞拍
            $this->indexReady($start,$size,$is_user);

        }else if($type == 'running') { //热拍
            $this->indexRunning($start,$size,$is_user,$user_id);  

        }else if($type == 'my') {//我的竞拍
            $this->indexMy($start,$size,$user_id);

        }


    }

    //(未开始和正在竞拍)要请求的接口方法
    public function detail()
    {

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $now = time();
        $a_id = addslashes(trim($request->getParameter('id')));//竞拍商品id
        $isfx = addslashes(trim($request->getParameter('isfx')));//true-从分享链接进入  false-不是从分享链接进入
        //接收参数
        $store_id = $this->store_id;
        $access_id = $this->access_id;
        //登录状态
        if(empty($access_id)){//用户未登录
            $is_user = 0;
        }else{
            $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $res = $db->select($sql);
            if($res){
                $user_id = $res[0]->user_id;
                $user_money = $res[0]->money;
            }
            //判断用户是否登录
            if(empty($res)){
                $is_user = 0;//用户未登录
            }else{
                $is_user = 1;//用户已登录
            }
        }
        //查询店铺相应信息
        $sql_s = "select id,mch_id from lkt_auction_product where store_id = '$store_id' and id = '$a_id'";
        $res_s = $db->select($sql_s);
        $shop_list = array();
        if($res_s){
            $mch_id = $res_s[0]->mch_id;
            $shop_list = Tools::shop($db,$store_id,$mch_id);

        }    
        //获取该竞拍商品最新三条记录条数
        $sql_bid = "select a.* ,b.user_name,b.mobile from lkt_auction_record as a left join lkt_user as b on a.user_id = b.user_id where a.store_id = b.store_id and a.store_id = '$store_id' and a.auction_id = '$a_id' order by a.price desc,a.add_time desc,a.id desc limit 3";
        $res_bid = $db->select($sql_bid); 
        foreach($res_bid as $k => $v){//截取用户手机号
            $mobile_0 = $v->mobile;
            $v->mobile = substr($mobile_0, -3,3);
        }
         //出价记录条数
        $sql = "select id from lkt_auction_record where store_id = '$store_id' and auction_id = '$a_id'";
        $bid_num = $db->selectrow($sql);
        //将总记录条数存入redis
        $sql_5 = "select invalid_time from lkt_auction_product where store_id = $store_id and id = $a_id";
        $res_5 = $db->select($sql_5);
        if($res_5){
            $redis = new RedisClusters();
            $re = $redis->connect();
            $bid_num_name = 'AC'.$a_id.'bid_num';
            $invalid_time = $res_5[0]->invalid_time;
            $second = strtotime($invalid_time) - strtotime('now');
            $redis->set($bid_num_name,$bid_num,$second);
            $redis->close();//关闭句柄
        }
        $payment = Tools::getPayment($db,$store_id);// 支付方式配置
        if(empty($user_id)){//用户未登录
            $result =  $this->detailLogout($a_id,$isfx);
            echo json_encode(array('is_user'=>$is_user, 'payment' => $payment,'code' => 200, 'res' => $result['res'],'shop_list' => $shop_list, 'type' => $result['type'],'bid_num'=>$bid_num,'res_bid'=>$res_bid));
            exit;  
        }else{//用户已登录
            $result = $this->detailLogin($a_id,$isfx,$user_id);
            echo json_encode(array('is_user'=>$is_user, 'payment' => $payment,'code' => 200, 'res' => $result['res'],'shop_list' => $shop_list, 'type' => $result['type'],'money'=>$result['money'],'is_promise'=>$result['is_promise'],'password_status'=>$result['password_status'],'bid_num'=>$bid_num,'res_bid'=>$res_bid));
            exit;  
            
        }

    }

    //已结束(无论是否为得主)请求的接口
    public function end_detail()
    {

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        //接收参数
        $store_id = $this->store_id;
        $access_id = $this->access_id;
       
        $a_id = addslashes(trim($request->getParameter('id')));//竞拍商品id
        $isfx = addslashes(trim($request->getParameter('isfx')));//true-从分享链接进入  false-不是从分享链接进入
       
        if(empty($access_id)){//用户未登录
            $is_user = 0;
        }else{
            $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $res = $db->select($sql);
         
            if($res){
                $user_id = $res[0]->user_id;
                $user_money = $res[0]->money;
            }
            //判断用户是否登录
            if(empty($res)){
                
                $is_user = 0;//用户未登录
            }else{
                
                $is_user = 1;//用户已登录
            }
        }
        //查询店铺相应信息
        $sql_s = "select id,mch_id from lkt_auction_product where store_id = '$store_id' and id = '$a_id'";
        $res_s = $db->select($sql_s);
        $shop_list = array();
        if($res_s){
            $mch_id = $res_s[0]->mch_id;
            $shop_list = Tools::shop($db,$store_id,$mch_id);

        }     
        //获取该竞拍商品最新三条记录条数
        $sql_bid = "select a.* ,b.user_name,b.mobile from lkt_auction_record as a left join lkt_user as b on a.user_id = b.user_id where a.store_id = b.store_id and a.store_id = '$store_id' and a.auction_id = '$a_id' order by a.price desc,a.add_time desc,a.id desc limit 3";
        $res_bid = $db->select($sql_bid); 
        foreach($res_bid as $k => $v){//截取用户手机号
            $mobile_0 = $v->mobile;
            $v->mobile = substr($mobile_0, -3,3);
        }
        //出价记录条数
        $sql = "select id from lkt_auction_record where store_id = '$store_id' and auction_id = '$a_id'";
        $bid_num = $db->selectrow($sql);
        //根据用户登录转态，显示内容
        if($is_user == 0){//用户未登录
            $result = $this->endDetailLogout($a_id,$isfx);
            echo json_encode(array('is_user'=>$is_user,'code' => 200, 'res' => $result['res'], 'shop_list'=>$shop_list,'bid_num'=>$bid_num,'res_bid'=>$res_bid));
            exit;
        }else{//用户登录状态
            $result = $this->endDetailLogin($a_id,$isfx,$user_id);
            echo json_encode(array('is_user'=>$is_user,'code' => 200, 'res' => $result['res'], 'shop_list'=>$shop_list,'money'=>$user_money,'bid_num'=>$bid_num,'res_bid'=>$res_bid,'host_user'=>$result['host_user']));
            exit;

        }

    }

    //出价记录表
    public function record()
    {

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        //接收参数
        $store_id = $this->store_id;
       

        $a_id = addslashes(trim($request->getParameter('id')));

        $sql = "select a.*,b.mobile,b.user_name from lkt_auction_record as a left join lkt_user as b on a.user_id = b.user_id where a.store_id = '$store_id' and b.store_id = '$store_id' and a.auction_id = '$a_id' order by a.price desc,a.add_time desc,a.id desc ";
        $res = $db->select($sql);
        
        foreach($res as $k => $v){
            $mobile_0 = $v->mobile;
            $v->mobile = substr($mobile_0, -3,3);
        }

        if (!$res) {
            $info = [];
            echo json_encode(array('code' => 108, 'res' => $info));
            exit;
        }

        echo json_encode(array('code' => 200, 'res' => $res));
        exit;
    }

    //竞拍规则接口
    public function rule(){
        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
         //接收参数
        $store_id = $this->store_id;

        $sql = "select content from lkt_auction_config where store_id = '$store_id'";
        $res = $db->select($sql);

        if($res){
            $my_rule = $res[0]->content;
        }
        echo json_encode(array('code'=>200,'my_rule'=>$my_rule));
        exit;
    }

    //生成微信订单所需信息，去微信支付
    //押金支付
    public function go_pay()
    {

        //初始化
        $log = new LaiKeLogUtils('app/auction.log');
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //接受参数
        $store_id = $this->store_id;
        $access_id = $this->access_id;
        $a_id = addslashes(trim($request->getParameter('id'))); //竞拍商品id
        $paytype = addslashes(trim($request->getParameter('type'))); //支付方式 wallet_pay-钱包支付 aliPay-支付宝支付 app_wechat - app微信支付 jsapi_wechat-微信内网页支付   mini_wechat-小程序微信支付
        $datetime = date("Y-m-d H:i:s");
        $password = addslashes(trim($request->getParameter('password'))); //余额支付密码

        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $res = $db->select($sql);

        $user_id = $res[0]->user_id;

        if($res){
            $is_user = 1;//用户已登录
        }else{
            $is_user = 0;//用户未登录
            echo json_encode(array('code'=>200,'msg'=>'请登录'));
            exit;
        }

        //total ,押金总金额
        $sql = "select promise from lkt_auction_product where store_id = '$store_id' and id = '$a_id'";
        $res = $db->select($sql);
        if ($res) {
            $total = $res[0]->promise;
        }else{
            $total = 0;
        }

        //生成订单号
        $pay = 'AC';//竞拍押金

        // 商户订单号
        $dingdanhao = $pay . date("ymdhis") . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);

        if ($paytype == 'wallet_pay') { //钱包支付

            $sql = "select user_id,money,password from lkt_user where store_id = $store_id and access_id = '$access_id'";
            $res = $db->select($sql);
            $password_user = $res[0]->password;
            $password = md5($password);

            if($password != $password_user){
                echo json_encode(array('code'=>110,'err'=>'支付密码错误！'));
                exit;
            }
            $db->begin();
            if($res){

                //判断是否余额足够
                $money = $res[0]->money;//余额
                if ($money < $total) {

                    echo json_encode(array('code'=>112,'info'=>'余额不足！'));
                    exit;
                }else{

                    $pay_money = -$total;//扣除余额，为负数

                    $sql_1 = "update lkt_user set money = (money + $pay_money) where store_id = '$store_id' and user_id = '$user_id'";
                    $res_1 = $db->update($sql_1);

                    if($res_1 < 0){
                        $log -> customerLog(__LINE__.':更新用户余额失败，sql为：'.$sql_1."\r\n");
                        $db->rollback();
                        echo json_encode(array('code'=>110,'info'=>'修改余额失败！'));
                        exit;
                    }
                   
                    //记录表的上交金额为正数
                    $pay_money = $total;
                    $sql_2 = "insert into lkt_record (store_id,user_id,money,oldmoney,add_date,event,type) values ('$store_id','$user_id','$pay_money','$money','$datetime','交竞拍押金','26')";
                    $res_2 = $db->insert($sql_2);//消费记录表

                    
                    $sql_3 = "insert into lkt_auction_promise (store_id,user_id,promise,add_time,a_id,is_pay,trade_no,type) values ('$store_id','$user_id','$total','$datetime','$a_id',1,'$dingdanhao','$paytype')";
                    $res_3 = $db->insert($sql_3);
                    if($res_3 < 0 ){
                        $log -> customerLog(__LINE__.':插入押金记录失败，sql为：'.$sql_3."\r\n");
                        $db->rollback();
                        echo json_encode(array('code'=>110,'info'=>'插入押金记录失败！'));
                        exit;
                    }

                    $sql_4 = "update lkt_auction_product set pepole = pepole+1 where store_id = '$store_id' and id = '$a_id'";
                    $res_4 = $db->update($sql_4);
                    if($res_4 < 0){
                        $log -> customerLog(__LINE__.':更新竞拍活动参与人数失败，sql为：'.$sql_4."\r\n");
                        $db->rollback();
                        echo json_encode(array('code'=>110,'info'=>'更新竞拍活动参与人数失败！'));
                        exit;
                    }
                    $db->commit();
                    //在redis中自增参与人数
                    $redis = new RedisClusters();
                    $re = $redis->connect();
                    $redis->incr('AC'.$a_id.'pepole');
                    $sql_5 = "select current_price,pepole,invalid_time from lkt_auction_product where store_id = $store_id and id = $a_id";
                    $res_5 = $db->select($sql_5);
                    $redis->close();//关闭句柄
                    echo json_encode(array('code'=>200,'info'=>'上交押金成功！','status'=>2));
                    exit;

                }
                
            }else{

                echo json_encode(array('code' => 110, 'info' => '没有用户信息！'));
                exit;
            }


        }else{ //其他线上支付  aliPay-支付宝支付 app_wechat-app微信支付 jsapi_wechat-微信内网页支付   mini_wechat-小程序微信支付

            //title,产品标题
            $title = '竞拍押金';
 
            //插入一条押金记录，is_pay = 0(未支付), allow_back = 0（不符合退款标准）
            $sql_1 = "insert into lkt_auction_promise (store_id,user_id,promise,add_time,a_id,trade_no,is_pay,type,allow_back) values ('$store_id','$user_id','$total','$datetime','$a_id','$dingdanhao',0,'$paytype',0)";
            $res_1 = $db->insert($sql_1);

            if ($res_1 < 0) {

                echo json_encode(array('code' => 110, 'info' => '插入押金记录失败'));
                exit;
            } else {

                echo json_encode(array('code' => 200, 'title' => $title, 'sNo' => $dingdanhao, 'total' => $total,'pay_type'=>'JP','status'=>1));
                exit;
            }


        }

    }

    //出价详情接口  

    public function bid_detail(){

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        //接受参数
        $a_id = addslashes(trim($request->getParameter('id')));//竞拍商品id
        $store_id = $this->store_id;
        $access_id = $this->access_id;

        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $res = $db->select($sql);

        $user_id = $res[0]->user_id;

        if($res){
            $is_user = 1;//用户已登录
        }else{
            $is_user = 0;//用户未登录
            echo json_encode(array('code'=>200,'msg'=>'请登录'));
        }

        //判断参与人数是否达到

        $sql_0 = "select pepole,low_pepole from lkt_auction_product where store_id = '$store_id' and id = '$a_id'";
        $res_0 = $db->select($sql_0);

        $pepole = $res_0[0]->pepole;//参与的人数
        $low_pepole = $res_0[0]->low_pepole;//最低参与人数


        //获取该竞拍商品最新三条记录条数
        $sql_bid = "select a.* ,b.user_name from lkt_auction_record as a left join lkt_user as b on a.user_id = b.user_id where a.store_id = b.store_id and a.store_id = '$store_id' and a.auction_id = '$a_id' order by a.price desc,a.add_time desc,a.id desc limit 3";
        $res_bid = $db->select($sql_bid); 

        foreach($res_bid as $k => $v){//截取用户手机号
            $mobile_0 = $v->mobile;
            $v->mobile = substr($mobile_0, -3,3);
        }

         //出价记录条数
        $sql = "select id from lkt_auction_record where store_id = '$store_id' and auction_id = '$a_id'";
        $bid_num = $db->selectrow($sql);

        //判断是否交过押金
        $sql = "select id,trade_no from lkt_auction_promise where store_id = '$store_id' and a_id = '$a_id' and user_id = '$user_id' and is_pay = 1";
        $res = $db->select($sql);
        if(!$res){
            echo json_encode(array('code'=>200,'info'=>'未缴纳押金，请先支付押金！'));
            exit;
        }

        //我的竞拍动态
        $sql = "select price,add_time from lkt_auction_record where store_id = '$store_id' and auction_id = '$a_id' and user_id = '$user_id' order by price desc,add_time desc,id desc limit 3";
        $res_my = $db->select($sql);

        if(!$res_my){
            $res_my = array();
        }

        //全部竞拍动态

        $sql_1 = "select  a.price,a.add_time,b.user_name from lkt_auction_record as a left join lkt_user as b on a.user_id = b.user_id where a.store_id = '$store_id' and b.store_id = '$store_id' and a.auction_id = '$a_id' order by a.price desc,a.add_time desc,a.id desc limit 10";
        $res_all = $db->select($sql_1);

        if(!$res_all){
            $res_all = array();
        }

        //出价商品详情
        $sql_2 = "select id,title,starttime,endtime,status,price,add_price,market_price,current_price,imgurl,promise,pepole from lkt_auction_product where store_id = '$store_id' and id = '$a_id' and status = 1";
        $res = $db->select($sql_2);


        if(!$res){
            echo json_encode(array('code'=>110,'info'=>'查询商品详情异常！'));
            exit;
        }
        if ($res) {

            foreach ($res as $k => $v) {

                    $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                   
                    
            }
        }

        echo json_encode(array('code'=>200,'info'=>'成功','res_my'=>$res_my,'res_all'=>$res_all,'res'=>$res,'pepole'=>$pepole,'low_pepole'=>$low_pepole,'bid_num'=>$bid_num,'res_bid'=>$res_bid));
        exit;

    }

    //出价接口
    public function bid(){

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();   
        //日志记录类实例化
        $log = new LaiKeLogUtils('app/auction.log');

        //接受参数
        $store_id = $this->store_id;
        $access_id = $this->access_id;

        $sql = "select user_id,money,user_name,mobile from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $res = $db->select($sql);

        if($res){
            $user_id = $res[0]->user_id;
            $user_name = $res[0]->user_name;
            $mobile = $res[0]->mobile;
            $is_user = 1;//用户已登录
        }else{
            $is_user = 0;//用户未登录
            echo json_encode(array('code'=>200,'msg'=>'请登录'));
            exit;
        }



        $a_id = addslashes(trim($request->getParameter('id')));
        $price = addslashes(trim($request->getParameter('price')));
        $datetime = date("Y-m-d H:i:s");
        
        // //查询出价用户是否符合出价时间
        $sql = "select add_time from lkt_auction_record where store_id = '$store_id' and auction_id = '$a_id' and user_id = '$user_id' order by id desc";
        $res = $db->select($sql);

        if($res){
            $last_add_time = $res[0]->add_time;
            $sql_0 = "select wait_time from lkt_auction_product where store_id = $store_id";
            $res_0 = $db->select($sql_0);
            $wait_time = $res_0[0]->wait_time;
            $spacing = (strtotime('now')-strtotime($last_add_time));
            if($spacing < $wait_time){
                echo json_encode(array('code'=>110,'info'=>'未在加价时间，请稍后重试'));
                exit;
            }
        } 
        //判断所加价格是否大于开拍加
        $sql = "select price,current_price,pepole,invalid_time,add_price from lkt_auction_product where store_id = '$store_id' and id = '$a_id'";
        $res = $db->select($sql);
        if($price < $res[0]->price){
            echo json_encode(array('code'=>110,'info'=>'出价价格不得低于开拍价'));
            exit;
        }
        //判断出价金额是否大于最高价
        $redis = new RedisClusters();
        $re = $redis->connect();
        $redis_max_price = $redis->get("AC".$a_id."max_price");
        if(bccomp($redis_max_price + $res[0]->add_price, $price,2) > 0){//小于 最高价+出价金额
            echo json_encode(array('code'=>110,'info'=>'加价幅度过低，请重新出价'));
            exit;
        }

        $db->begin();
        $sql_1 = "insert into lkt_auction_record (store_id,user_id,auction_id,add_time,price) values ('$store_id','$user_id','$a_id','$datetime','$price')";
        $res_1 = $db->insert($sql_1);
        if($res_1 < 0){
            $log -> customerLog(__LINE__.':插入竞拍记录失败，sql为：'.$sql_1."\r\n");
        }

        //查询出最高价
        $sql_3 = "select price from lkt_auction_record where store_id = '$store_id' and auction_id = '$a_id' order by price desc,add_time desc,id desc limit 1";
        $res_3 = $db->select($sql_3);
        if(!$res_3){
            echo json_encode(array('code'=>110,'info'=>'加价失败！'));
            exit;
        }else{
            $most_price = $res_3[0]->price;
        }

        $sql_2 = "update lkt_auction_product set current_price = '$most_price' where store_id = '$store_id' and id = '$a_id' and status = 1";
        $res_2 = $db->update($sql_2);
        if($res_2 < 0){
            $log -> customerLog(__LINE__.':更新竞拍活动最新价失败，sql为：'.$sql_2."\r\n");
        }
        if($res_1 < 0 || $res_2 < 0){
            $db->rollback();
            $log -> customerLog(__LINE__.':竞拍商品加价异常，竞拍活动id为'.$a_id."\r\n");
            echo json_encode(array('code'=>110,'info'=>'更新加价异常！'));
            exit;
        }

        $db->commit();
        //最高价，参与人数,出价最新记录，存入redis
        //查询记录
        $max_price = $price;//最高价 
        $pepole = $res[0]->pepole;//参与人数
        $invalid_time = $res[0]->invalid_time;//redis失效时间
        //计算秒数
        $invalid_time_s = strtotime($invalid_time);
        $datetime_s = strtotime($datetime);
        $second = $invalid_time_s - $datetime_s;
        //最新出价记录
        $bid = new stdClass();
        $bid->price = $price;
        $bid->add_time = $datetime;
        $bid->user_name = $user_name;
        $bid->moible = $mobile;
        //获取该竞拍商品最新三条记录条数
        $sql_bid = "select a.price,a.add_time,b.user_name,b.mobile from lkt_auction_record as a left join lkt_user as b on a.user_id = b.user_id where a.store_id = b.store_id and a.store_id = '$store_id' and a.auction_id = '$a_id' order by a.price desc,a.add_time desc,a.id desc limit 3";
        $res_bid = $db->select($sql_bid); 
        if($res_bid){//存在出价记录
           
        }else{//不存在出价记录
            $res_bid = array();
            array_push($res_bid,$bid);
        }
       
        //存入redis
        $redis = new RedisClusters();
        $re     = $redis->connect();
        $max_price_name = "AC".$a_id."max_price";
        $pepole_name = "AC".$a_id."pepole";
        $bid_name = "AC".$a_id."bid";
        $redis->set($max_price_name,$max_price,$second);
        $redis->set($pepole_name,$pepole,$second);
        $redis->set($bid_name,json_encode($res_bid),$second);
        $redis->incr('AC'.$a_id.'bid_num');//自增竞拍记录条数
        $redis->close();

        echo json_encode(array('code'=>200,'info'=>'更新加价成功！','suc'=>1));
        exit;

    }
    //定时请求接口获取热数据
	public function timeRequest(){
        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $a_id = addslashes(trim($request->getParameter('id')));//竞拍活动id
        //接受参数
        $store_id = $this->store_id;
        $access_id = $this->access_id;
        $redis = new RedisClusters();
        $re     = $redis->connect();
        //竞拍活动中redis对应的key
        $max_price_name = "AC".$a_id."max_price";
        $pepole_name = "AC".$a_id."pepole";
        $bid_name = "AC".$a_id."bid";
        $bid_num_name = 'AC'.$a_id.'bid_num';
        $max_price = round($redis->get($max_price_name),2);
        $pepole = $redis->get($pepole_name);
        $bid = json_decode($redis->get($bid_name));
        $bid_num = $redis->get($bid_num_name);
        $redis->close();
        //如果redis不存在，则从数据库中读取
        if(!$max_price || !$pepole){
            $sql = "select current_price,pepole from lkt_auction_product where store_id = $store_id and id = $a_id";
            $res = $db->select($sql);
            $max_price = $res[0]->current_price;
            $pepole = $res[0]->pepole;
        }
        if(!$bid){
            $bid = array();
        }

        echo json_encode(array('code'=>200,'res_bid'=>$bid,'max_price'=>$max_price,'pepole'=>$pepole,'bid_num'=>$bid_num));
        exit;

    }

    // 获得二维码，并储存到本地
    public function getQrCode($url,$uploadImg,$size = 5){

        $qrcode_name = md5(date("Ymd").rand(1000,9999));
        $value = $url;//二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = $size;           //生成图片大小
        $filename = $uploadImg.'/'.$qrcode_name.'.png';

        QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);
        return $filename;
    }
    //将图片转码base64
    function base64EncodeImage ($image_file) {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }


    /**
     * @title   待开拍
     * @param  $start: 分页开始下标
     * @param  $size: 每页大小
     * @param  $is_user: 用户是否登录 true登录
     * @return 输出json
     */
    private function indexReady($start,$size,$is_user){
        $db = $this->db;
        $store_id = $this->store_id;

        $sql = "select id,title,imgurl,starttime,price,add_price,pepole,status from lkt_auction_product where store_id = '$store_id' and status = 0 and recycle = 0 and is_show = 1 LIMIT $start,$size";
        $res = $db->select($sql);

        if ($res) {

            foreach($res as $k => $v){
                
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $v->mark =0;
            }
            echo json_encode(array('code' => 200, 'list' => $res,'is_user'=>$is_user));
            exit;
        } else {

            $info = [];
            echo json_encode(array('code' => 200, 'list' => $info,'is_user'=>$is_user));
            exit;
        }
    }

     /**
     * @title   热拍中
     * @param  $url: 分页开始下标
     * @param  $size: 每页大小
     * @param  $is_user: 用户是否登录 true登录
     * @param  $user_id: 用户的id
     * @return 输出json
     */
    private function indexRunning($start, $size, $is_user, $user_id){
        $db = $this->db;
        $store_id = $this->store_id;
        $now_time = date('Y-m-d h:i:s');
        $list = array();
        if($is_user == 1){//用户登录状态下

           
            //进行中的竞拍 （交过押金，未交押金）
            $sql_1 = "select a.id,a.title,a.starttime,a.imgurl,a.endtime,a.price,a.add_price,a.user_id,a.status,a.invalid_time,a.pepole,a.is_buy,b.is_pay          from lkt_auction_product as a 
                     left join lkt_auction_promise as b on a.id = b.a_id and b.store_id = '$store_id' and b.user_id = '$user_id' and b.is_pay = 1 
                     where a.store_id = '$store_id'  and a.status = 1 and a.recycle = 0 and a.is_show = 1 and a.invalid_time > '$now_time' 
                     group by a.id 
                     order by a.id desc,b.add_time desc LIMIT $start,$size";
            $res_1 = $db->select($sql_1);
      
           
            if($res_1){

                foreach ($res_1 as $k => $v) {
                $v->imgurl = ServerPath::getimgpath($v->imgurl, $store_id);
                $v->status = 'run';//进行中
                $v->mark = 1;//继续竞拍
                array_push($list, $v);
                }
            }

            //已结束竞拍  （结束，流拍）
            $sql_2 = "select a.id,a.title,a.starttime,a.imgurl,a.endtime,a.user_id,a.price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_buy,b.is_pay,          a.trade_no 
                      from lkt_auction_product as a 
                      left join lkt_auction_promise as b on a.id = b.a_id and b.store_id = '$store_id' and b.user_id = '$user_id' 
                      where a.store_id = '$store_id'  and a.status in(2,3) and a.invalid_time > '$now_time' and a.is_show = 1 and a.recycle = 0 
                      group by a.id 
                      order by a.id desc LIMIT $start,$size";
            $res_2 = $db->select($sql_2);
            if($res_2){

                foreach ($res_2 as $k => $v) {
                    $now_user_id = $v->user_id;
                    $now_status = $v->status;
                    $now_is_buy = $v->is_buy;
                    $now_trade_no = $v->trade_no;
                    $v->imgurl = ServerPath::getimgpath($v->imgurl, $store_id);
                    if(($now_status == 2) && ($user_id != $now_user_id)){
                        $v->mark = 2;//已结束
                    }else if(($now_status == 2) && ($user_id == $now_user_id) && ($now_is_buy == 0) && ($now_trade_no == '')){
                        $v->mark = 3;//未付款
                    }else if(($now_status == 2) && ($user_id == $now_user_id) && ($now_trade_no != '')){

                        $v->mark = 4;//我的订单
                    }else if($now_status  == 3){
                        $v->mark = 5;//已流拍
                    }
                    $v->status = 'end';//已结束
                    array_push($list, $v);
                }
            }

            echo json_encode(array('code'=>200,'list'=>$list,'is_user'=>$is_user));
            exit;
        }else{//用户未登录状态下


            //进行中的竞拍 （交过押金，未交押金）
            $sql_1 = "select a.id,a.title,a.starttime,a.imgurl,a.endtime,a.price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_buy from lkt_auction_product as a  where a.store_id = '$store_id'  and a.status = 1 and a.invalid_time > '$now_time' and a.is_show = 1 and a.recycle = 0  group by a.id order by a.id desc LIMIT $start,$size";
            $res_1 = $db->select($sql_1);
          
            if($res_1){

                foreach ($res_1 as $k => $v) {
                $v->imgurl = ServerPath::getimgpath($v->imgurl, $store_id);
                $v->status = 'run';//进行中
                $v->mark = 1;
                array_push($list, $v);
                }
            }

            //已结束竞拍  （结束，流拍）
            $sql_2 = "select a.id,a.title,a.starttime,a.imgurl,a.endtime,a.price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_buy from lkt_auction_product as a where a.store_id = '$store_id'  and a.status in (2,3) and a.invalid_time > '$now_time' and a.is_show = 1 and a.recycle = 0  group by a.id order by a.id desc LIMIT $start,$size";

            $res_2 = $db->select($sql_2);

            if($res_2){
                foreach ($res_2 as $k => $v) {
                    $now_status = $v->status ;
                    $v->imgurl = ServerPath::getimgpath($v->imgurl, $store_id);
                    $v->status = 'end';//已结束
                    if($now_status == 2){
                        $v->mark = 2;//未登录状态下，已结束
                    }else if($now_status == 3){
                        $v->mark = 5;//未登录状态下，流拍
                    }
                    array_push($list, $v);
                }
            }

            echo json_encode(array('code'=>200,'list'=>$list,'is_user'=>$is_user));
            exit;
        }
    }

    /**
     * @title   我的竞拍
     * @param  $url: 分页开始下标
     * @param  $size: 每页大小
     * @param  $user_id: 用户的id
     * @return 输出json
     */
    private function indexMy($start,$size,$user_id){
        //mark（1-继续竞拍 2-已结束，不是得主  3.已结束，是得主未付款 4.已结束，是得主已付款）
        $db = $this->db;
        $store_id = $this->store_id;
        if(empty($user_id)){

            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }   
        //是否有我的拍品
        $now_time = date('Y-m-d h:i:s');

        $sql = "select a.id,a.title from 
                lkt_auction_product as a 
                left join lkt_auction_promise as b on a.id = b.a_id 
                where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status != 0 and a.invalid_time > '$now_time' and a.recycle = 0 and a.is_show = 1 and b.user_id = '$user_id' and b.is_pay = 1";
        $res = $db->select($sql);
        if (!$res) {
            $info = [];
            echo json_encode(array('code' => 200, 'res' => $info));
            exit;
        }

        $list = array();
        //1.继续竞拍
        $sql_1 = "select   a.id, a.title, a.starttime,a.imgurl,a.endtime,a.price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_buy,a.trade_no,                  b.is_pay from 
                  lkt_auction_product as a 
                  left join lkt_auction_promise as b on a.id = b.a_id  
                  where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 1 and a.invalid_time > '$now_time' and a.recycle = 0 and a.is_show = 1 and b.user_id = '$user_id' and b.is_pay = 1 group by a.id 
                  order by a.id desc LIMIT $start,$size";
        $res_1 = $db->select($sql_1);

        if ($res) {

            foreach ($res_1 as $k => $v) {
                $v->imgurl = ServerPath::getimgpath($v->imgurl, $store_id);
                $v->mark = 1;
                array_push($list, $v);
            }
        }

        //2.已结束，不是得主
        $sql_2 = "select a.id,a.title,a.starttime,a.imgurl,a.endtime,a.price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_buy,a.trade_no,a.user_id,            b.is_pay from 
                  lkt_auction_product as a 
                  left join lkt_auction_promise as b on a.id = b.a_id where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 2 and b.user_id = '$user_id' and a.invalid_time > '$now_time' and a.is_show = 1 and a.recycle = 0 and b.is_pay = 1 and a.user_id != '$user_id' 
                  group by a.id order by a.id desc LIMIT $start,$size";
        $res_2 = $db->select($sql_2);
    
        
        if ($res_2) {

            foreach ($res_2 as $k => $v) {
                 $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $v->mark = 2;
                array_push($list, $v);
            }
        }
   
        //3.待付款 （未成订单号）
        $sql_3 = "select a.id,a.title,a.starttime,a.endtime,a.imgurl,a.price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_buy,a.trade_no,a.trade_no,           b.is_pay from 
                  lkt_auction_product as a 
                  left join lkt_auction_promise as b on a.id = b.a_id 
                  where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 2 and a.invalid_time > '$now_time' and a.user_id = '$user_id' and a.is_show = 1 and a.recycle = 0 and b.is_pay = 1 and b.user_id = '$user_id' and a.is_buy = 0 and  a.trade_no is null 
                  group by a.id 
                  order by a.id desc LIMIT $start,$size";
        $res_3 = $db->select($sql_3);
        if ($res_3) {

            foreach ($res_3 as $k => $v) {
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $v->mark = 3;

                //有订单号则返回订单id
                $trade_no =  $v->trade_no;
                if(!$trade_no){
                    $v->order_id = '';
                }else{
                    $sql_o = "select id from lkt_order where store_id = $store_id and sNo = '$trade_no'";
                    $res_o = $db->select($sql_o);
                    // $order_id = $res_o[0]->id;
                    // if($order_id){
                    //     $v->order_id = $order_id;
                        
                    // }
                }
                array_push($list, $v);

            }
        }

        //4.我的订单（已生成订单号）
        $sql_4 = "select a.id,a.title,a.starttime,a.endtime,a.imgurl,a.price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_buy,a.trade_no,b.is_pay              from 
                  lkt_auction_product as a 
                  left join lkt_auction_promise as b on a.id = b.a_id 
                  where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 2 and a.invalid_time > '$now_time' and a.user_id = '$user_id' and a.is_show = 1 and a.recycle = 0 and b.is_pay = 1 and b.user_id = '$user_id'  and a.trade_no is not null 
                  group by a.id 
                  order by a.id desc LIMIT $start,$size";
        $res_4 = $db->select($sql_4);
        if ($res_4) {
            foreach ($res_4 as $k => $v) {
                 $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $v->mark = 4;

                //有订单号则返回订单id
                $trade_no =  $v->trade_no;
                if(!$trade_no){
                    $v->order_id = '';
                }else{
                    $sql_o = "select id from lkt_order where store_id = $store_id and sNo = '$trade_no'";
                    $res_o = $db->select($sql_o);
                    // $order_id = $res_o[0]->id;
                    // if($order_id){
                    //     // $v->order_id = $order_id;
                        
                    // }
                }    
                array_push($list, $v);
            }
        }

        //5.已流拍，参与过，但人数不达标
        $sql_5 = "select a.id,a.title,a.starttime,a.endtime,a.imgurl,a.price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_buy,b.is_pay from                    lkt_auction_product as a 
                  left join lkt_auction_promise as b on a.id = b.a_id 
                  where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 3 and a.is_show = 1 and a.invalid_time > '$now_time' and a.recycle = 0 
                  group by a.id 
                  order by a.id desc LIMIT $start,$size";
        $res_5 = $db->select($sql_5);

        if ($res_5) {

            foreach ($res_5 as $k => $v) {
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $v->mark = 5;
                array_push($list, $v);
            }
        }
        echo json_encode(array('code' => 200, 'res' => $list));
        exit;
    }

    /**
     * @title  detail未登录
     * @param  $a_id: 竞拍活动id
     * @param  $isfx: 是否为从分享链接请求 true是
     * @return 数组
     */
    private function detailLogout($a_id,$isfx){
        $now = time();
        $db = $this->db;
        $store_id = $this->store_id;
        //如果为分享则可以查出已删除，或隐藏的活动
        if($isfx){
            $sql = "select id,title,starttime,endtime,price,add_price,is_show,recycle,market_price,low_pepole,current_price,pepole,attribute,promise,is_show,recycle,imgurl,status,user_id,attribute from lkt_auction_product where store_id = '$store_id' and id = '$a_id' ";
        }else{
             $sql = "select id,title,starttime,endtime,price,add_price,market_price,low_pepole,current_price,pepole,attribute,promise,attribute,imgurl,status,user_id from lkt_auction_product where store_id = '$store_id' and id = '$a_id' and is_show = 1 and recycle = 0";
        }
        $res = $db->select($sql);//商品详情
     
        if (!$res) {

            echo json_encode(array('code' => 109, 'info' => '参数错误！1'));
            exit;
        }
           
        $res[0]->imgurl = ServerPath::getimgpath($res[0]->imgurl,$store_id);
        $attribute = unserialize($res[0]->attribute);
        $my_attribute_id =  array_values($attribute)[0];//规格id
        $my_attribute_id = array_keys($my_attribute_id)[0];
        $res[0]->product_id = array_keys($attribute)[0];//商品id
        $my_product_id =  $res[0]->product_id;

        //查询出商品的详情以及规格
        $sql_0 = "select content,attribute from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where store_id = '$store_id' and a.id = '$my_product_id' and b.id = '$my_attribute_id'";
        $res_0 = $db->select($sql_0);
        $res[0]->content = Tools::getContent($db,$res_0[0]->content); //拍平描述
        if($res_0){
            $attr = unserialize($res_0[0]->attribute);
            $attr = array_values($attr);
            if($attr){
                if (gettype($attr[0]) != 'string') unset($attr[0]);
            }
            $res[0]->attr = implode(',',$attr);
        }

        $status = $res[0]->status;
        if($status == 0) {
            $type = 0; //未开始
            $res[0]->mark = 0;
        }elseif($status == 1){
            $type = 1;//进行中
             $res[0]->mark = 1;
        }else{
            //伪代码
            $type = 999;
        }
        //计算离活动开始的秒数和活动结束的秒数
        $res[0]->start_second = strtotime($res[0]->starttime) - $now; 
        if($res[0]->start_second < 0){
             $res[0]->start_second = 0;
        }

        $res[0]->end_second = strtotime($res[0]->endtime) - $now;
        if($res[0]->end_second < 0){
            $res[0]->end_second = 0;
        }

        //返回数组
        $result = array();
        $result['type'] = $type;
        $result['res'] = $res;    
        return $result;    
    }

    /**
     * @title  detail登录
     * @param  $a_id: 竞拍活动id
     * @param  $isfx: 是否为从分享链接请求 true是
     * @param  $user_id: 用户访问id
     * @return 数组
     */
    private function detailLogin($a_id,$isfx,$user_id){
        $db = $this->db;
        $store_id = $this->store_id;
        $sql = "select user_id,money,password from lkt_user where store_id = $store_id and user_id = '$user_id'";
        $res = $db->select($sql);
        $now = strtotime('now');//现在时间戳var
        $money = $res[0]->money;//用户余额
        $password = $res[0]->password;//支付密码
        if(empty($password)){
            $password_status = 0;
        }else{
            $password_status = 1;
        }

        if($isfx){
            $sql = "select id,title,starttime,endtime,price,add_price,market_price,low_pepole,current_price,pepole,attribute,promise,is_show,recycle,imgurl,status,user_id,attribute from lkt_auction_product where store_id = '$store_id' and id = '$a_id' ";
        }else{
             $sql = "select id,title,starttime,endtime,price,add_price,market_price,low_pepole,is_show,recycle,current_price,pepole,attribute,promise,imgurl,status,user_id,attribute from lkt_auction_product where store_id = '$store_id' and id = '$a_id' and is_show = 1 and recycle = 0";
        }
        $res = $db->select($sql);//商品详情


        if (!$res) {
            echo json_encode(array('code' => 109, 'info' => '参数错误！4'));
            exit;
        }
        $res[0]->imgurl = ServerPath::getimgpath($res[0]->imgurl,$store_id);
        $attribute = unserialize($res[0]->attribute);
        $my_attribute_id = array_values($attribute)[0];//规格id
        $my_attribute_id = array_keys($my_attribute_id)[0];
        $res[0]->product_id = array_keys($attribute)[0];//商品id
        $my_product_id =  $res[0]->product_id;
        //查询出下一次可加价时间
        $sql_1 = "select add_time from lkt_auction_record where store_id = '$store_id' and auction_id = '$a_id' and user_id = '$user_id' order by id desc";
        $res_1 = $db->select($sql_1);
        if($res_1){
            $last_add_time = $res_1[0]->add_time;//上一次加价时间
            $sql_0 = "select wait_time from lkt_auction_config where store_id = $store_id";
            $res_0 = $db->select($sql_0);
            $wait_time = $res_0[0]->wait_time;//加价等待时间
            $next_add_time0 = strtotime($last_add_time)+$wait_time;//下次加价时间戳
            
           
        // $res[0]->next_add_time0 = $next_add_time0;
        // $res[0]->now = $now;
            if(($next_add_time0 - $now) < 0){
                $res[0]->wait_time = 0;
            }else{
                $res[0]->wait_time = ($next_add_time0 - $now);
            }

        }else{
             $res[0]->wait_time = 0;
        } 
        //查询出商品的详情
        $sql_0 = "select content,attribute from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where store_id = '$store_id' and a.id = '$my_product_id' and b.id = '$my_attribute_id'";
        $res_0 = $db->select($sql_0);
        $res[0]->content = Tools::getContent($db,$res_0[0]->content); //拍平描述
        if($res_0){
            $attr = unserialize($res_0[0]->attribute);
            $attr = array_values($attr);
            if($attr){
                if (gettype($attr[0]) != 'string') unset($attr[0]);
            }
            $res[0]->attr = implode(',',$attr);
        }

        $status = $res[0]->status;
        if ($status == 0) {
            $res[0]->mark = 0; //未开始
            $is_promise = 0;
            $type = 0;
        }elseif($status == 1) {
            $res[0]->mark = 1;//进行中
            $type = 1; //进行中

        }else{
          //伪代码
          $type = 999;
        }
        //计算离活动开始的秒数和活动结束的秒数
        $res[0]->start_second = strtotime($res[0]->starttime) - $now; 
        if($res[0]->start_second < 0){
             $res[0]->start_second = 0;
        }
      
        $res[0]->end_second = strtotime($res[0]->endtime) - $now;
        if($res[0]->end_second < 0){
            $res[0]->end_second = 0;
        }
        //判断用户是否交过押金
        $sql_1 = "select * from lkt_auction_promise where store_id = '$store_id' and user_id = '$user_id' and a_id = '$a_id' and is_pay = 1";
        $res_1 = $db->select($sql_1);

        if(!$res_1){

            $is_promise = 0;//未交押金
        }else{
            $is_promise = 1;//交过保证金
        }
        //返回数组
        $result = array();
        $result['res'] = $res;
        $result['type'] = $type;
        $result['money'] = $money;
        $result['is_promise'] = $is_promise;
        $result['password_status'] = $password_status;
        return $result;
    }

    /**
     * @title  end_detail未登录
     * @param  $a_id: 竞拍活动id
     * @param  $isfx: 是否为从分享链接请求 true是
     * @return 数组
     */
    private function endDetailLogout($a_id,$isfx){
        $db = $this->db;
        $store_id = $this->store_id;
        //如果为分享，则不限制回收字段
        if($isfx){
              $sql = "select a.id,a.title,a.starttime,a.endtime,a.imgurl,a.price,a.user_id,a.is_buy,a.market_price,a.promise,a.current_price,a.add_price,a.status,a.invalid_time,a.pepole,a.trade_no,a.is_buy,a.is_show,a.recycle,a.attribute from lkt_auction_product as a  where a.store_id = '$store_id'  and a.id = '$a_id' ";
        }else{
             $sql = "select a.id,a.title,a.starttime,a.endtime,a.imgurl,a.price,a.user_id,a.is_buy,a.market_price,a.promise,a.current_price,a.add_price,a.status,a.invalid_time,a.pepole,a.trade_no,a.is_show,a.recycle,a.is_buy,a.attribute from lkt_auction_product as a  where a.store_id = '$store_id'  and a.id = '$a_id' and a.is_show = 1 and a.recycle = 0";
        }

        $res = $db->select($sql);
        if($res){
            $ac_status = $res[0]->status;//竞拍转态
            $res[0]->imgurl = ServerPath::getimgpath($res[0]->imgurl,$store_id);
            $attribute = unserialize($res[0]->attribute);
            $my_attribute_id = array_values($attribute)[0];//规格id
            $my_attribute_id = array_keys($my_attribute_id)[0];
            $res[0]->product_id = array_keys($attribute)[0];//商品id
            $my_product_id =  $res[0]->product_id;

            //查询出商品的详情
            $sql_0 = "select content,attribute from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where store_id = '$store_id' and a.id = '$my_product_id' and b.id = '$my_attribute_id'";
            $res_0 = $db->select($sql_0);
            $res[0]->content = Tools::getContent($db,$res_0[0]->content); //拍平描述
            if($res_0){
                $attr = unserialize($res_0[0]->attribute);
                $attr = array_values($attr);
                if($attr){
                    if (gettype($attr[0]) != 'string') unset($attr[0]);
                }
                $res[0]->attr = implode(',',$attr);
            }
            //mark为前端 竞拍状态判断标准
            if($ac_status == 2){
                $res[0]->mark = 2;//已结束
            }elseif ($ac_status == 3) {
                $res[0]->mark = 5;//已流拍
            }
        }else{
            echo json_encode(array('code'=>109,'msg'=>'参数错误'));
            exit;
        }

        //返回数组
        $result = array();

    }

    /**
     * @title  end_detail登录
     * @param  $a_id: 竞拍活动id
     * @param  $isfx: 是否为从分享链接请求 true是
     * @param  $user_id: 用户访问id
     * @return 数组
     */
    private function endDetailLogin($a_id,$isfx,$user_id){
        $db = $this->db;
        $store_id = $this->store_id;
        if($isfx){
            $sql = "select a.id,a.title,a.starttime,a.endtime,a.imgurl,a.price,a.user_id,a.is_buy,a.market_price,a.promise,a.current_price,a.add_price,a.status,a.invalid_time,a.pepole,a.is_show,a.recycle,a.trade_no,a.is_buy,a.attribute from lkt_auction_product as a  where a.store_id = '$store_id'  and a.id = '$a_id'";
        }else{
            $sql = "select a.id,a.title,a.starttime,a.endtime,a.imgurl,a.price,a.user_id,a.is_buy,a.market_price,a.promise,a.current_price,a.add_price,a.status,a.invalid_time,a.pepole,a.trade_no,a.is_show,a.recycle,a.is_buy,a.attribute from lkt_auction_product as a  where a.store_id = '$store_id'  and a.id = '$a_id' and a.is_show = 1 and a.recycle = 0";
        }
        $res = $db->select($sql);
        if($res){

            $ac_status = $res[0]->status;//该竞拍商品的状态
            $ac_user_id = $res[0]->user_id;//该竞拍商品的得主
            $ac_is_buy = $res[0]->is_buy;//该竞拍商品的付款状态 
            $ac_trade_no = $res[0]->trade_no;//该竞拍商品的订单

            if(($ac_status == 2) && ($ac_user_id != $user_id)){
                $res[0]->mark = 2;//已结束
            }elseif(($ac_status == 2) && ($ac_user_id == $user_id) && ($ac_is_buy == 0) && ($ac_trade_no == '')){
                $res[0]->mark = 3;//待付款
            }elseif(($ac_status == 2) && ($ac_user_id == $user_id)&& ($ac_trade_no != '')){
                $res[0]->mark = 4;//我的订单
            }elseif($ac_status == 3){
                $res[0]->mark = 5;//流拍
            }

            $res[0]->imgurl = ServerPath::getimgpath($res[0]->imgurl,$store_id);
            $attribute = unserialize($res[0]->attribute);
            $my_attribute_id = array_values($attribute)[0];//规格id
            $my_attribute_id = array_keys($my_attribute_id)[0];
            $res[0]->product_id = array_keys($attribute)[0];//商品id
            $my_product_id =  $res[0]->product_id;

            //查询出商品的详情
            $sql_0 = "select content,attribute from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where store_id = '$store_id' and a.id = '$my_product_id' and b.id = '$my_attribute_id'";
            $res_0 = $db->select($sql_0);
            $res[0]->content = Tools::getContent($db,$res_0[0]->content); //拍平描述
            if($res_0){
                $attr = unserialize($res_0[0]->attribute);
                $attr = array_values($attr);
                if($attr){
                    if (gettype($attr[0]) != 'string') unset($attr[0]);
                }
                $res[0]->attr = implode(',',$attr);
            }
        }else{
            echo json_encode(array('code'=>109,'msg'=>'参数错误'));
            exit;
        }
        //查询出最终得主 
        $sql_1 = "select  a.id,b.user_name  from lkt_auction_product as a left join lkt_user as b on a.user_id = b.user_id where a.store_id = '$store_id' and a.store_id = b.store_id and a.id = '$a_id' and a.status != 3 ";
        $res_1 = $db->select($sql_1);
        
        if($res_1){
            $host_user = $res_1[0]->user_name;
        }else{
            $host_user = '';
        }

        $result = array();
        $result['res'] = $res;
        $result['host_user'] = $host_user;
        return $result;
    }

}





