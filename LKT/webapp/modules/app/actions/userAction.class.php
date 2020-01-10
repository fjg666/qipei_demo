<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/aliyun-dysms-php-sdk-lite/demo/sendSms.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Commission.class.php');
require_once(MO_LIB_DIR . '/Plugin/sign.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');

class userAction extends Action {

    public function getDefaultView() {
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));

        $this->$app();
        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权id

        if($app != 'index' && $app != 'Verification' && $app != 'about_us' && $app != 'secret_key'){
            if(!empty($access_id)){ // 存在
                $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                if($getPayload_test == false){ // 过期
                    echo json_encode(array('code' => 230, 'message' => '请登录！'));
                    exit;
                }
            }else{
                echo json_encode(array('code' => 230, 'message' => '请登录！'));
                exit;
            }
        }
        $this->$app();
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 请求我的数据
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$store_id' ";
        $r_1 = $db->select($sql);
        if($r_1){
            $logo = $r_1['0'] ->logo;
            $company = $r_1['0'] ->company;
        }else{
            $logo = '';
            $company = '';
        }
        $logo = ServerPath::getimgpath($logo);

        //查询插件是否开启
        $plugin = array();
        $Plugin_arr = new Plugin();
        $Plugin_arr1 = $Plugin_arr->front_Plugin($db,$store_id);

        foreach ($Plugin_arr1 as $k => $v){
            if($k == 'sign' && $v == 1){
                $sign = new sign();
                $sign_arr = $sign->test($store_id,'');
                $plugin['sign'] = $sign_arr['is_sign_status'];
            }else if($k == 'coupon' && $v == 1 ){
                $coupon = new coupon();
                $coupon_list = $coupon->test($store_id);
                $plugin['coupon'] = $coupon_list;
            }else if($k == 'mch' && $v == 1 ){
                $plugin['mch'] = 1;
            }
        }
        $sql0 = "select * from lkt_admin where store_id = '$store_id' and type = 1";
        $r0 = $db->select($sql0);
        $permission1 = explode(',',$r0[0]->permission);

        //竞拍
        $sql = "select is_open from lkt_auction_config where store_id = '$store_id'";
        $res = $db->select($sql);
        if($res){
            $plugin['JP'] = $res[0]->is_open;
        }else{
            $plugin['JP'] = 0;
        }
        $plugin['JP'] = 0;
        //钱包 0 隐藏 1 显示
        $plugin['QB'] = 1;
        //分销
        $sql = "select status from lkt_distribution_config where store_id = '$store_id'";
        $res = $db->select($sql);
        $plugin['FX'] = $res?$res[0]->status:0;
        //积分商城
        $sql = "select status from lkt_integral_config where store_id = '$store_id'";
        $res = $db->select($sql);
        $plugin['JF'] = $res?$res[0]->status:0;
        //秒杀
        //查询秒杀是否开启
        $sel_sql = "SELECT is_open FROM `lkt_seconds_config` WHERE 1 and store_id = 1";
        $sel_res = $db->select($sel_sql);
        $plugin['MS'] = $sel_res?$sel_res[0]->is_open:0;
        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！','plugin'=>$plugin));
                exit;
            }
            // 查询会员信息
            $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db -> select($sql);
            if($r){
                $user['headimgurl'] = $r[0]->headimgurl;
                $user['user_name'] = htmlspecialchars_decode($r[0]->user_name);
                $user['money'] = $r[0]->money;
                $user['score'] = $r[0]->score;
                $user['mobile'] = $r[0]->mobile;
                if($r[0]->birthday){//不为null
                    $user['birthday'] = date("Y-m-d",strtotime($r[0]->birthday));
                }else{//为null
                    $user['birthday'] = date("Y-m-d",strtotime('0000-00-00 00:00:00'));
                }
                $user_id = $r[0]->user_id;
                $grade_end = date("Y-m-d",strtotime($r[0]->grade_end));
                $is_box = $r[0]->is_box;
                $remind = 0;//不提醒续费

                //查询未读消息数量
                $sql_xx = "select count(id) as count from lkt_system_message where store_id='$store_id' and recipientid='$user_id' and type=1";
                $r_xx = $db->select($sql_xx);
                $xxnum = $r_xx[0]->count;

                //会员等级查询
                $gtade_0 = $r[0]->grade;//等级id
                $sql_0 = "select name,level,imgurl_s,imgurl_my,rate,font_color,date_color from lkt_user_grade where store_id = '$store_id' and id = '$gtade_0'";
                $res_0 = $db->select($sql_0);
                if($res_0){
                    $grade = $res_0[0]->name;
                    $level = $res_0[0]->level;
                    $rate =  number_format($res_0[0]->rate, 1);
                    $imgurl_my = ServerPath::getimgpath($res_0[0]->imgurl_my,$store_id);
                    $imgurl_s = ServerPath::getimgpath($res_0[0]->imgurl_s,$store_id);
                    $font_color = $res_0[0]->font_color;
                    $date_color = $res_0[0]->date_color;
                    //查询是否需要续费提醒
                    $sql_1 = "select auto_time from lkt_user_rule where store_id = $store_id and is_auto = 1";
                    $res_1 = $db->select($sql_1);
                    if($res_1){
                        $auto_time = $res_1[0]->auto_time;//自动续费提醒时间
                        //计算离会员到期还有多久
                        $now = strtotime("now");
                        $end = strtotime($grade_end);
                        if($now > $end){
                            $remind = 0;
                        }else{
                            $cha = round(($end - $now)/86400);//相差天数
                            if(($cha < $auto_time) && ($is_box == 1)){//到了自动提醒时间,且用户未关闭提示
                                //
                                $remind = 1;
                            }else{
                                $remind = 0;
                            }
                        }
                    }else{
                        $remind = 0;
                    }

                }else{
                    $grade = '普通会员';
                    $level = 0;
                    $imgurl_my = '';
                    $rate = '';
                    $font_color = '';
                    $imgurl_s = '';
                    $date_color = '';
                }

                //查询是否有会员级别
                $sql01 = "select * from lkt_user_grade where store_id = $store_id";
                $res01 = $db->select($sql01);
                if($res01){//有会员等级
                    $have_grade = 1;
                }else{//无会员等级
                    $have_grade = 0;
                }

                //会员升级
                $comm=new Commission();
                $comm->uplevel($db,$store_id,$user_id);

                // //个人中心小红点
                $num_arr =[0,1,2,3,4];
                $res_order= [];

                $sql = "";
                foreach ($num_arr as $key => $value) {
                    if($value == '4'){
                        $sql_order = "select num from lkt_order_details where store_id = '$store_id' and r_status = '$value' and  user_id = '$user_id'" ;
                        $order_num = $db -> selectrow($sql_order);
                        $res_order[$key] =  $order_num;
                    }else{
                        if($value==1){
                            $sql_order01 = "select drawid from lkt_order where store_id = '$store_id' and status = '$value' and  user_id = '$user_id'" ;
                            $re = $db->select($sql_order01);
                            $res_order[$key] =  sizeof($re);
                        }else{
                            $sql_order = "select num from lkt_order where store_id = '$store_id' and status = '$value' and  user_id = '$user_id'" ;
                            $order_num = $db -> selectrow($sql_order);
                            $res_order[$key] =  $order_num;

                            $order_num = $db -> selectrow($sql_order);
                            $res_order[$key] =  $order_num;
                        }
                    }
                }
                $sql = "select count(id) as a from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id'";
                $collection = $db->select($sql);
                if($collection){
                    $collection_num = $collection[0]->a;
                }else{
                    $collection_num = 0;
                }

                $sql = "select count(id) as a from lkt_user_footprint where store_id = '$store_id' and user_id = '$user_id'";
                $footprint = $db->select($sql);
                if($footprint){
                    $footprint_num = $footprint[0]->a;
                }else{
                    $footprint_num = 0;
                }
                $coupon = new coupon();
                $coupon_list = $coupon->mycoupon($store_id, $user_id,0);
//                $user['coupon_num'] = count($coupon_list[0]);
                $user['coupon_num'] = count($coupon_list);

                $data = array('user'=>$user,'th'=>$res_order['4'],'dfk_num'=>$res_order['0'],'dfh_num'=>$res_order['1'],'dsh_num'=>$res_order['2'],'dpj_num'=>$res_order['3'],'logo'=>$logo,'company'=>$company,'collection_num'=>$collection_num,'footprint_num'=>$footprint_num,'grade'=>$grade,'grade_end'=>$grade_end,'level'=>$level,'remind'=>$remind,'font_color'=>$font_color,'date_color'=>$date_color,'rate'=>$rate,'imgurl_my'=>$imgurl_my,'imgurl_s'=>$imgurl_s,'xxnum'=>$xxnum,'have_grade'=>$have_grade);
                echo json_encode(array('code'=>200,'data'=>$data,'message'=>'成功','plugin'=>$plugin));
                exit();
            }else{
                echo json_encode(array('code' => 404, 'message' => '请登录！','plugin'=>$plugin));
                exit;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！','plugin'=>$plugin));
            exit;
        }
    }
    // 我的钱包
    public function details(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收信息
        $access_id = trim($request->getParameter('access_id')); // 授权id

        // 根据微信id,查询用户id
        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if(!empty($r)){
            $user_id = $r[0]->user_id; // 用户id
            $user_money = $r[0]->money; // 用户余额
            if($user_money == ''){
                $user_money = 0;
            }
            // 根据用户id、类型为充值,查询操作列表-----消费记录
            $sql = "select money,add_date,type from lkt_record where store_id = '$store_id' and user_id = '$user_id' and is_mch = 0 and (type =1 or type =2 or type =3 or type =4 or type =5 or type =11 or type =12 or type =13 or type =14 or type =19 or type =20 or type =21 or type =22 or type =23 or type =24 or type = 26 or type = 27 or type =30) order by add_date desc LIMIT 0,10";
            $r_1 = $db->select($sql);
            $list = [];
            if($r_1){
                foreach ($r_1 as $k => $v){
                    $v->time = substr($v->add_date,0,strrpos($v->add_date,':'));
                    $list[$k] = $v;
                }
            }
            $sql = "select id from lkt_withdraw where store_id = '$store_id' and status = 0 and user_id = '$user_id' and is_mch = 0";
            $rr = $db->select($sql);
            $count = count($rr); // 条数
            if($count > 0){
                $status = 1;
            }else{
                $status = 0;
            }
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
        //查询钱包单位
        $sql_1 = "select unit from lkt_finance_config where store_id = $store_id";
        $res_1 = $db->select($sql_1);
        $unit = '元';
        if($res_1){
            $unit = $res_1[0]->unit;
        }

        echo json_encode(array('code'=>200,'unit'=>$unit,'user_money'=>$user_money,'list'=>$list,'status'=>$status,'message'=>'成功'));
        exit();
    }
    // 我的钱包明细加载更多
    public function wallet_detailed(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 接收信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $num = trim($request->getParameter('page')); // 加载次数
        $start = $num*10;
        $end = 10;

        // 根据微信id,查询用户id
        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if(!empty($r)){
            $user_id = $r[0]->user_id; // 用户id
            $user_money = $r[0]->money; // 用户余额
            if($user_money == ''){
                $user_money = 0;
            }
            $sql = "select id from lkt_record where store_id = '$store_id' and user_id = '$user_id' and (type =1 or type =2 or type =3 or type =4 or type =5 or type =11 or type =12 or type =13 or type =14 or type =19 or type =20 or type =21 or type =22 or type =23 or type =24) order by add_date desc";
            $rr = $db->select($sql);
            $z_num = count($rr);

            // 根据用户id、类型为充值,查询操作列表-----消费记录
            $sql = "select money,add_date,type from lkt_record where store_id = '$store_id' and user_id = '$user_id' and is_mch = 0 and (type =1 or type =2 or type =3 or type =4 or type =5 or type =11 or type =12 or type =13 or type =14 or type =19 or type =20 or type =21 or type =22 or type =23 or type =24) order by add_date desc LIMIT $start,$end";
            $r_1 = $db->select($sql);

            $list = [];
            if($rr != '' && $r_1 != ''){
                if($z_num >= $end){
                    foreach ($r_1 as $k => $v){
                        $v->time = substr($v->add_date,0,strrpos($v->add_date,':'));
                        $list[$k] = $v;
                    }
                    echo json_encode(array('code'=>200,'list'=>$list,'message'=>'成功'));
                    exit();
                }else{
                    echo json_encode(array('code'=>103,'message'=>'没有更多了！'));
                    exit();
                }
            }
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }

        // echo json_encode(array('code'=>200,'user_money'=>$user_money,'list'=>$list,'message'=>'成功'));
        // exit();
    }
    // 进入提现页面
    public function into_withdrawals(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID

        if($shop_id != 0){
            $this->into_wallet1();
        }else{
            // 查询单位
            $sql = "select * from lkt_finance_config where store_id = '$store_id'";
            $r_1 = $db->select($sql);
            $min_amount = floatval($r_1[0]->min_amount); // 最小提现金额
            $max_amount = floatval($r_1[0]->max_amount); // 最大提现金额
            $unit = $r_1[0]->unit; // 单位
//        $multiple = $r_1[0]->multiple; // 提现倍数
            // 根据微信id,查询会员金额
            $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db -> select($sql);
            if($r){
                $user_id = $r[0]->user_id; // 会员id
                $money = $r[0]->money; // 会员余额
                $mobile = $r[0]->mobile; // 手机号
                $sql = "select id,Cardholder,Bank_name,Bank_card_number from lkt_user_bank_card where store_id = '$store_id' and user_id = '$user_id' and is_default = 1";
                $rr = $db->select($sql);
                $rew = '';
                if($rr){
                    $res = strlen($rr[0]->Bank_card_number) - 4;
                    for ($i=0; $i < $res; $i++) {
                        $rew .= '*';
                    }
                    $rr[0]->Bank_card_number = $rew . substr($rr[0]->Bank_card_number,-4);
                    $bank_information = $rr[0];
                }else{
                    $bank_information = '';
                }

                $pshd = '请输入提现金额(大于' . $min_amount . '小于'.$max_amount.')';

                $data = array('min_amount'=>$min_amount,'max_amount'=>$max_amount,'money'=>$money,'pshd'=>$pshd,'unit'=>$unit,'bank_information'=>$bank_information,'mobile'=>$mobile);
                echo json_encode(array('code'=>200,'data'=>$data,'message'=>'成功'));
                exit();
            }else{
                echo json_encode(array('code'=>115,'err'=>'非法入侵！'));
                exit;
            }
        }
    }
    // 店主进入提现页面
    public function into_wallet1(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $access_id = trim($request->getParameter('access_id')); // 授权id

        $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db -> select($sql);
        if($r){
            $user_id = $r[0]->user_id; // 会员id
        }else{
            echo json_encode(array('code'=>115,'err'=>'非法入侵！'));
            exit;
        }
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id,account_money,tel from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            $account_money = $r0[0]->account_money; // 商户余额
            $tel = $r0[0]->tel; // 联系电话
            if($mch_id == $shop_id){
                $sql1 = "select min_charge,max_charge,service_charge from lkt_mch_config where store_id = '$store_id'";
                $r1 = $db -> select($sql1);
                if($r1){
                    $min_charge = floatval($r1[0]->min_charge); // 最小提现金额
                    $max_charge = floatval($r1[0]->max_charge); // 最大提现金额
                    $service_charge = $r1[0]->service_charge; // 提现说明
                }else{
                    echo json_encode(array('code'=>110,'err'=>'业务异常！'));
                    exit;
                }
                $sql2 = "select id,Cardholder,Bank_name,Bank_card_number from lkt_user_bank_card where store_id = '$store_id' and mch_id = '$mch_id' and is_default = 1";
                $r2 = $db->select($sql2);
                $rew = '';
                if($r2){
                    $res = strlen($r2[0]->Bank_card_number) - 4;
                    for ($i=0; $i < $res; $i++) {
                        $rew .= '*';
                    }
                    $r2[0]->Bank_card_number = $rew . substr($r2[0]->Bank_card_number,-4);
                    $bank_information = $r2[0];
                }else{
                    $bank_information = array();
                }
                $pshd = '请输入提现金额(大于'.$min_charge.'小于'.$max_charge.')';
                $data = array('min_amount'=>$min_charge,'max_amount'=>$max_charge,'money'=>$account_money,'pshd'=>$pshd,'unit'=>'元','bank_information'=>$bank_information,'mobile'=>$tel);
                echo json_encode(array('code'=>200,'data'=>$data,'message'=>'成功'));
                exit;
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 验证卡号与银行名是否匹配
    public function Verification(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $Bank_name = trim($request->getParameter('Bank_name')); // 银行名称
        $Bank_card_number = trim($request->getParameter('Bank_card_number')); // 银行卡号
        // 银行卡号不为数字
        if(is_numeric($Bank_card_number) == false){
            echo json_encode(array('code'=>109,'message'=>'参数错误'));
            exit();
        }
        // 根据卡号,查询银行名称
        require_once('bankList.php');
        $r = $this->bankInfo($Bank_card_number,$bankList);
        if($r == ''){
            echo json_encode(array('code'=>113,'message'=>'卡号不正确'));
            exit();
        }else{
            $name = strstr($r,'银行',true) . "银行";
            if($Bank_name){
                if($name != $Bank_name){
                    echo json_encode(array('code'=>114,'message'=>'银行信息不匹配'));
                    exit();
                }else{
                    echo json_encode(array('code'=>200,'Bank_name'=>$Bank_name,'message'=>'成功'));
                    exit();
                }
            }else{
                $Bank_name = $name;
                echo json_encode(array('code'=>200,'Bank_name'=>$Bank_name,'message'=>'成功'));
                exit();
            }
        }
    }
    // 短信验证码
    public function secret_key(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收信息
        $mobile = trim($request->getParameter('phone')); // 手机号码
        $message_type = trim($request->getParameter('message_type')); // 短信类型
        $message_type1 = trim($request->getParameter('message_type1')); // 短信类别

        echo json_encode(array('code'=>219,'message'=>'验证码是：123456'));
        exit();
        //$Tools = new Tools($db, $store_id, 1);
        //$res = $Tools->generate_code($db,$mobile,$message_type,$message_type1);
    }
    // 提现申请
    public function withdrawals(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 接收信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $amoney = trim($request->getParameter('amoney')); // 提现金额
        $Bank_name = trim($request->getParameter('Bank_name')); // 银行名称
        $branch = trim($request->getParameter('branch')); // 支行名称
        $Bank_card_number = trim($request->getParameter('Bank_card_number')); // 银行卡号
        $Cardholder = trim($request->getParameter('Cardholder')); // 持卡人
        $mobile = trim($request->getParameter('mobile')); // 手机号码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码

        if($shop_id != 0){
            $this->withdrawals1();
        }else{
            $arr = array($mobile,array('code'=>$keyCode));
            $Tools = new Tools($db, $store_id, 1);
            $rew = $Tools->verification_code($db,$arr);
            // 查询单位
            $sql = "select * from lkt_finance_config where store_id = '$store_id'";
            $r_1 = $db->select($sql);
            $min_amount = $r_1[0]->min_amount; // 最小提现金额
            $max_amount = $r_1[0]->max_amount; // 最大提现金额
            $tax = $r_1[0]->service_charge; // 设置的手续费参数

            // 提现金额不为数字
            if(is_numeric($amoney) == false){
                echo json_encode(array('code'=>204,'message'=>'提现金额不为数字'));
                exit();
            }

            // 根据微信id,查询会员金额
            $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db -> select($sql);
            if($r){
                $user_id = $r[0]->user_id; // 会员id
                $user_name = $r[0]->user_name; // 会员昵称
                $money = $r[0]->money; // 会员金额

                // 提现金额是否小于等于0,或者大于现有金额
                if($amoney > $money || $amoney <= 0){
                    echo json_encode(array('code'=>205,'message'=>'提现金额是否小于等于0,或者大于现有金额'));
                    exit();
                }
                // 提现金额小于最小提现金额
                if($amoney < $min_amount){
                    echo json_encode(array('code'=>206,'message'=>'提现金额小于最小提现金额'));
                    exit();
                }
                // 提现金额大于最大提现金额
                if($amoney > $max_amount){
                    echo json_encode(array('code'=>207,'message'=>'提现金额大于最大提现金额'));
                    exit();
                }
                // 银行卡号不为数字
                if(is_numeric($Bank_card_number) == false){

                    $sql = "select Bank_card_number from lkt_user_bank_card where store_id = '$store_id' and user_id = '$user_id' and is_default = 1";
                    $rr = $db->select($sql);
                    $rew = '';
                    if($rr) {
                        $Bank_card_number1 = $rr[0]->Bank_card_number;
                        $res = strlen($rr[0]->Bank_card_number) - 4;
                        for ($i = 0; $i < $res; $i++) {
                            $rew .= '*';
                        }
                        $rr[0]->Bank_card_number = $rew . substr($rr[0]->Bank_card_number, -4);
                        if($Bank_card_number != $rr[0]->Bank_card_number){
                            echo json_encode(array('code'=>208,'message'=>'银行卡号不为数字!'));
                            exit();
                        }else{
                            $Bank_card_number = $Bank_card_number1;
                        }
                    }else{
                        echo json_encode(array('code'=>208,'message'=>'银行卡号不为数字!'));
                        exit();
                    }
                }else{
                    if(strlen($Bank_card_number) != 19 && strlen($Bank_card_number) != 16){
                        echo json_encode(array('code'=>114,'message'=>'卡号不正确!'));
                        exit();
                    }
                }
                // 根据卡号,查询银行名称
                require_once('bankList.php');
                $r = $this->bankInfo($Bank_card_number,$bankList);
                if($r == ''){
                    echo json_encode(array('code'=>114,'message'=>'卡号不正确!'));
                    exit();
                }else{
                    $name = strstr($r,'银行',true) . "银行";
                    if($name != $Bank_name){
                        echo json_encode(array('code'=>114,'message'=>'银行信息不匹配'));
                        exit();
                    }
                }
                $cost = $amoney * $tax;  // 实际的手续费
                $t_money = $amoney; // 提现金额
                // 根据用户id和未核审,查询数据
                $sql = "select count(id) as a from lkt_withdraw where store_id = '$store_id' and status = 0 and user_id = '$user_id'";
                $r = $db->select($sql);
                $count = $r[0]->a; // 条数
                if($count > 0){
                    echo json_encode(array('code'=>111,'message'=>'请勿重复'));
                    exit();
                }else{
                    // 根据银行名称、卡号，查询用户银行卡信息
                    $sql = "select id,Cardholder from lkt_user_bank_card where store_id = '$store_id' and Bank_name = '$Bank_name' and Bank_card_number = '$Bank_card_number' and user_id = '$user_id'";
                    $r1 = $db->select($sql);
                    if($r1){
                        $bank_id = $r1[0]->id;
                        if($Cardholder != $r1[0]->Cardholder){
                            echo json_encode(array('code'=>209,'message'=>'持卡人信息错误'));
                            exit();
                        }
                    }else{
                        $sql = "insert into lkt_user_bank_card(store_id,user_id,Cardholder,Bank_name,branch,Bank_card_number,mobile,add_date,is_default) values ('$store_id','$user_id','$Cardholder','$Bank_name','$branch','$Bank_card_number','$mobile',CURRENT_TIMESTAMP,1)";
                        $bank_id = $db->insert($sql,'last_insert_id');
                    }
                    $sql = "update lkt_user set money = money - '$t_money' where store_id = '$store_id' and user_id = '$user_id'";
                    $res = $db->update($sql);
                    // 在提现列表里添加一条数据
                    $sql = "insert into lkt_withdraw (store_id,user_id,name,mobile,Bank_id,money,z_money,s_charge,status,add_date) values ('$store_id','$user_id','$user_name','$mobile','$bank_id','$t_money','$money','$cost',0,CURRENT_TIMESTAMP)";
                    $r = $db->insert($sql);
                    if($r == 1){
                        $event = $user_id.'申请提现'.$t_money.'元余额';
                        $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$t_money','$money','$event',2)";
                        $db->insert($sqll);

                        if($rew){
                            $sql2 = "delete from lkt_session_id where id = '$rew' ";
                            $db->delete($sql2);
                        }
                        echo json_encode(array('code'=>200,'message'=>'成功'));
                        exit();
                    }else{
                        echo json_encode(array('code'=>110,'message'=>'业务异常'));
                        exit();
                    }
                }
            }else{
                echo json_encode(array('code'=>109,'message'=>'参数错误'));
                exit();
            }
        }
        return;
    }
    // 申请提现
    public function withdrawals1(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $amoney = trim($request->getParameter('amoney')); // 提现金额
        $Bank_name = trim($request->getParameter('Bank_name')); // 银行名称
        $branch = trim($request->getParameter('branch')); // 支行名称
        $Bank_card_number = trim($request->getParameter('Bank_card_number')); // 银行卡号
        $Cardholder = trim($request->getParameter('Cardholder')); // 持卡人
        $mobile = trim($request->getParameter('mobile')); // 手机号码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码

        $arr = array($mobile,array('code'=>$keyCode));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);
        // 根据微信id,查询会员金额
        $sql = "select user_id,user_name from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db -> select($sql);
        if($r){
            $user_id = $r[0]->user_id;
            $user_name = $r[0]->user_name;
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id,account_money,tel from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            $account_money = $r0[0]->account_money; // 商户余额
            $mobile = $r0[0]->tel; // 联系电话
            if($mch_id == $shop_id){
                $sql1 = "select settlement,min_charge,max_charge,service_charge from lkt_mch_config where store_id = '$store_id'";
                $r1 = $db -> select($sql1);
                if($r1){
                    $settlement = $r1[0]->settlement; // 结算方式
                    $min_charge = $r1[0]->min_charge; // 最低提现金额
                    $max_charge = $r1[0]->max_charge; // 最大提现金额
                    $service_charge = $r1[0]->service_charge; // 提现说明
                }else{
                    echo json_encode(array('code'=>101,'message'=>'未知错误'));
                    exit();
                }
                if($settlement == 0){
                    $time1 = date("Y-m-d 00:00:00");
                    $time2 = date("Y-m-d 23:59:59");
                }else if($settlement == 1){
                    $time1 = date('Y-m-01 00:00:00', time());
                    $time2 = date('Y-m-d 23:59:59', strtotime("$time1 +1 month -1 day"));
                }else if($settlement == 2){
                    $season = ceil(date('n') /3);
                    $time1 =  date('Y-m-01 00:00:00',mktime(0,0,0,($season - 1) *3 +1,1,date('Y')));
                    $time2 = date('Y-m-d 23:59:59',mktime(0,0,0,$season * 3,1,date('Y')));
                }

                // 提现金额不为数字
                if(is_numeric($amoney) == false){
                    echo json_encode(array('code'=>204,'message'=>'提现金额不为数字'));
                    exit();
                }
                // 提现金额是否小于等于0
                if($amoney <= 0){
                    echo json_encode(array('code'=>205,'message'=>'提现金额不能小于等于0'));
                    exit();
                }
                // 提现金额是否小于最低提现金额
                if($amoney < $min_charge){
                    echo json_encode(array('code'=>206,'message'=>'提现金额不能小于最低提现金额'));
                    exit();
                }
                // 提现金额是否大于最大提现金额
                if($amoney > $max_charge){
                    echo json_encode(array('code'=>207,'message'=>'提现金额不能大于最大提现金额'));
                    exit();
                }
                // 提现金额 大于 店主金额
                if($amoney > $account_money){
                    echo json_encode(array('code'=>207,'message'=>'提现金额不能大于最大提现金额'));
                    exit();
                }
                // 银行卡号不为数字
                if(is_numeric($Bank_card_number) == false){
                    $sql = "select Bank_card_number from lkt_user_bank_card where store_id = '$store_id' and mch_id = '$mch_id' and is_default = 1";
                    $rr = $db->select($sql);
                    $rew = '';
                    if($rr) {
                        $Bank_card_number1 = $rr[0]->Bank_card_number;
                        $res = strlen($rr[0]->Bank_card_number) - 4;
                        for ($i = 0; $i < $res; $i++) {
                            $rew .= '*';
                        }
                        $rr[0]->Bank_card_number = $rew . substr($rr[0]->Bank_card_number, -4);
                        if($Bank_card_number != $rr[0]->Bank_card_number){
                            echo json_encode(array('code'=>208,'message'=>'银行卡号不为数字!'));
                            exit();
                        }else{
                            $Bank_card_number = $Bank_card_number1;
                        }
                    }else{
                        echo json_encode(array('code'=>208,'message'=>'银行卡号不为数字!'));
                        exit();
                    }
                }else{
                    if(strlen($Bank_card_number) != 19 && strlen($Bank_card_number) != 16){
                        echo json_encode(array('code'=>114,'message'=>'卡号不正确!'));
                        exit();
                    }
                }
                // 根据卡号,查询银行名称
                require_once('bankList.php');
                $r = $this->bankInfo($Bank_card_number,$bankList);
                if($r == ''){
                    echo json_encode(array('code'=>114,'message'=>'卡号不正确!'));
                    exit();
                }else{
                    $name = strstr($r,'银行',true) . "银行";
                    if($name != $Bank_name){
                        echo json_encode(array('code'=>114,'message'=>'银行信息不匹配'));
                        exit();
                    }
                }

                if($service_charge == '0.00'){
                    $cost = 0;  // 实际的手续费
                }else{
                    $cost = $amoney * $service_charge;  // 实际的手续费
                }
                $t_money = $amoney; // 提现金额

                // 根据用户id和未核审,查询数据
                $sql0 = "select count(id) as a from lkt_withdraw where store_id = '$store_id' and user_id = '$user_id' and is_mch = 1 and status = 0 order by add_date desc limit 1";
                $r0 = $db->select($sql0);
                $count0 = $r0[0]->a; // 条数
                if($count0 > 0){
                    echo json_encode(array('code'=>111,'message'=>'您的上笔申请还未审核，请稍后再试'));
                    exit();
                }
                // 根据用户id和未核审,查询数据
                $sql = "select count(id) as a from lkt_withdraw where store_id = '$store_id' and add_date >= '$time1' and add_date <= '$time2' and user_id = '$user_id' and is_mch = 1 ";
                $r = $db->select($sql);
                $count = $r[0]->a; // 条数
                if($count > 0){
                    echo json_encode(array('code'=>111,'message'=>'提现申请次数已达上限！'));
                    exit();
                }else{
                    // 根据银行名称、卡号，查询用户银行卡信息
                    $sql = "select id,Cardholder from lkt_user_bank_card where store_id = '$store_id' and Bank_name = '$Bank_name' and Bank_card_number = '$Bank_card_number' and mch_id = '$mch_id'";
                    $r1 = $db->select($sql);
                    if($r1){
                        $bank_id = $r1[0]->id;
                        if($Cardholder != $r1[0]->Cardholder){
                            echo json_encode(array('code'=>209,'message'=>'持卡人信息错误'));
                            exit();
                        }
                    }else{
                        $sql = "insert into lkt_user_bank_card(store_id,user_id,Cardholder,Bank_name,branch,Bank_card_number,mobile,add_date,is_default,mch_id) values ('$store_id',0,'$Cardholder','$Bank_name','$branch','$Bank_card_number','$mobile',CURRENT_TIMESTAMP,1,'$mch_id')";
                        $bank_id = $db->insert($sql,'last_insert_id');
                    }
                    $sql = "update lkt_mch set account_money = account_money - '$t_money' where store_id = '$store_id' and id = '$mch_id'";
                    $res = $db->update($sql);
                    // 在提现列表里添加一条数据
                    $sql = "insert into lkt_withdraw (store_id,user_id,name,mobile,Bank_id,money,z_money,s_charge,status,add_date,is_mch) values ('$store_id','$user_id','$user_name','$mobile','$bank_id','$t_money','$account_money','$cost',0,CURRENT_TIMESTAMP,1)";
                    $r = $db->insert($sql);
                    if($r == 1){
                        $event = '店主'.$user_id.'申请提现'.$t_money.'元余额';
                        $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type,is_mch) values ('$store_id','$user_id','$t_money','$account_money','$event',2,1)";
                        $db->insert($sqll);

                        if($rew){
                            $sql2 = "delete from lkt_session_id where id = '$rew' ";
                            $db->delete($sql2);
                        }

                        echo json_encode(array('code'=>200,'message'=>'成功'));
                        exit();
                    }else{
                        echo json_encode(array('code'=>110,'message'=>'业务异常'));
                        exit();
                    }
                }
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 验证卡号是否跟银行匹配
    function bankInfo($card,$bankList) {
        $card_8 = substr($card, 0, 8);
        if (isset($bankList[$card_8])) {
            return $bankList[$card_8];
        }
        $card_6 = substr($card, 0, 6);
        if (isset($bankList[$card_6])) {
            return $bankList[$card_6];
        }
        $card_5 = substr($card, 0, 5);
        if (isset($bankList[$card_5])) {
            return $bankList[$card_5];
        }
        $card_4 = substr($card, 0, 4);
        if (isset($bankList[$card_4])) {
            return $bankList[$card_4];
        }
        return '';
    }

    public function set(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id')); // 授权id

        // 根据授权id,查询用户id
        $sql = "select password,mima from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
            $password = $r[0]->password;
            $mima = $r[0]->mima;
            if($password != ''){
                $password_status = 1;
            }else{
                $password_status = 0;
            }
            if($mima != ''){
                $mima_status = 1;
            }else{
                $mima_status = 0;
            }
            echo json_encode(array('code'=>200,'password_status'=>$password_status,'mima_status'=>$mima_status,'message'=>'成功!'));
            exit;
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }

    }
    // 修改密码
    public function updatepassword(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
//        $y_password = $request->getParameter('oldpassword'); // 旧密码
//        $x_password = $request->getParameter('newpassword'); // 新密码
        $x_password = $db->lock_url($request->getParameter('password')); // 密码
        $tel = $request->getParameter('phone'); // 手机号码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码

        $arr = array($tel,array('code'=>$keyCode));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);
        // 根据微信id,查询用户id
        $sql = "select user_id,mima from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if(!empty($r)){
            $password = $r[0]->mima;
            if($password == $x_password){
                echo json_encode(array('code'=>118,'message'=>'新密码不能跟旧密码相同！'));
                exit;
            }
            $sql = "update lkt_user set mima = '$x_password' where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db->update($sql);
            if($r > 0){
                if($rew){
                    $sql2 = "delete from lkt_session_id where id = '$rew' ";
                    $db->delete($sql2);
                }
                echo json_encode(array('code'=>200,'message'=>'成功!'));
                exit;
            }else{
                echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                exit;
            }
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
        return;
    }
    // 设置密码
    public function set_password(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $password = $db->lock_url($request->getParameter('password')); // 密码
        $tel = $request->getParameter('phone'); // 手机号码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码

        $arr = array($tel,array('code'=>$keyCode));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);

        // 根据授权id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
            $sql = "update lkt_user set mima = '$password' where store_id = '$store_id' and access_id = '$access_id'";
            $rr = $db->update($sql);
            if($r > 0){
                if($rew){
                    $sql2 = "delete from lkt_session_id where id = '$rew' ";
                    $db->delete($sql2);
                }
                echo json_encode(array('code'=>200,'message'=>'成功!'));
                exit;
            }else{
                echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                exit;
            }
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }

    }
    // 修改手机号
    public function update_phone(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $y_tel = $request->getParameter('y_phone'); // 旧手机号码
        $x_tel = $request->getParameter('x_phone'); // 新手机号码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码
        $time = date("Y-m-s H:i:s");

        $arr = array($x_tel,array('code'=>$keyCode));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);

        if(preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $x_tel)){
            // 根据授权id,查询用户id
            $sql = "select zhanghao,mobile from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db->select($sql);
            if($r){
                $zhanghao = $r[0]->zhanghao; // 账号
                $mobile = $r[0]->mobile; // 手机号
                if($mobile == $y_tel){
                    $sql = "select * from lkt_user where store_id = '$store_id' and zhanghao = '$x_tel' or mobile = '$x_tel'";
                    $r_1 = $db->select($sql);
                    if($r_1){
                        echo json_encode(array('code'=>201,'message'=>'新手机号已存在!'));
                        exit;
                    }else{
                        if($zhanghao == $mobile){ // 当 手机号码跟账号相同时
                            // 修改账号和手机号
                            $sql = "update lkt_user set mobile = '$x_tel',zhanghao = '$x_tel' where store_id = '$store_id' and access_id = '$access_id'";
                        }else{
                            $sql = "update lkt_user set mobile = '$x_tel' where store_id = '$store_id' and access_id = '$access_id'";
                        }
                        $rr = $db->update($sql);

                        if($rr > 0){
                            if($rew){
                                $sql2 = "delete from lkt_session_id where id = '$rew' ";
                                $db->delete($sql2);
                            }
                            echo json_encode(array('code'=>200,'message'=>'成功!'));
                            exit;
                        }else{
                            echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                            exit;
                        }
                    }
                }else{
                    echo json_encode(array('code'=>119,'message'=>'旧号码错误!'));
                    exit;
                }
            }else{
                echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
                exit;
            }
        }else{
            echo json_encode(array('code'=>119,'message'=>'手机号码有误！'));
            exit();
        }
    }
    // 修改用户信息
    public function set_user(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $Nickname = addslashes(trim($request->getParameter('Nickname'))); // 昵称
        $src_img = $request->getParameter('src_img'); // 图片base64
        $store_type = $request->getParameter('store_type'); // 图片base64
        $birthday = $request->getParameter('birthday'); // 出生日期

        // 根据授权id,查询用户id
        $sql = "select zhanghao from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
            if(!empty($src_img) && empty($Nickname) && empty($birthday)){
                // 查询配置表信息
                $sql = "select * from lkt_config where store_id = '$store_id'";
                $r = $db->select($sql);
                $uploadImg = $r[0]->uploadImg;
                $uploadImg_domain = $r[0]->uploadImg_domain;
                $upserver = !empty($r)?$r[0]->upserver:'2';   //如果没有设置配置则默认用阿里云
                // 图片上传位置
                if(empty($uploadImg)){
                    $uploadImg = "../LKT/images";
                }
                if($upserver == '2'){
                    $headimgurl = ServerPath::file_OSSupload($store_id,$store_type,true);
                }else{
                    $headimgurl = ServerPath::file_upload($store_id,$uploadImg,$uploadImg_domain,$store_type,true);
                }
                if($headimgurl == false){
                    echo json_encode(array('code'=>105,'message'=>'上传失败或图片格式错误!'));exit;
                }
                $sql = "update lkt_user set headimgurl = '$headimgurl' where store_id = '$store_id' and access_id = '$access_id'";
                $r = $db->update($sql);
                if($r > 0){
                    echo json_encode(array('code'=>200,'headportrait'=>$headimgurl,'message'=>'成功!'));
                    exit;
                }else{
                    echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                    exit;
                }
            }else if(empty($headportrait) && !empty($Nickname) && empty($birthday)){
                $sql = "update lkt_user set user_name = '$Nickname' where store_id = '$store_id' and access_id = '$access_id'";
                $r = $db->update($sql);
                if($r > 0){
                    echo json_encode(array('code'=>200,'Nickname'=>$Nickname,'message'=>'成功!'));
                    exit;
                }else{
                    echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                    exit;
                }
            }else if(empty($headportrait) && empty($Nickname) && !empty($birthday)){
                $sql1 = "select birthday from lkt_user where store_id and $store_id and access_id = '$access_id'";
                $res1 = $db->select($sql1);

                if( $res1){
                    if($res1[0]->birthday != "0000-00-00 00:00:00" && $res1[0]->birthday != NULL){
                        echo json_encode(array('code'=>109,'message'=>'你已设置过生日，不可更改'));
                        exit;
                    }
                }
                $sql = "update lkt_user set birthday = '$birthday' where store_id = '$store_id' and access_id = '$access_id'";
                $r = $db->update($sql);
                if($r > 0){
                    echo json_encode(array('code'=>200,'message'=>'设置成功'));
                    exit;
                }else{
                    echo json_encode(array('code'=>109,'message'=>'设置失败'));
                    exit;
                }
            }
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }
    // 设置支付密码
    public function set_payment_password(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
//        $tel = $request->getParameter('phone'); // 手机号码
        $password = MD5($request->getParameter('password')); // 密码

//        $keyCode = trim($request->getParameter('keyCode')); // 验证码
//        $time = date("Y-m-s H:i:s");

//        $arr = array($tel,array('code'=>$keyCode));
//        $Tools = new Tools($db, $store_id, 1);
//        $rew = $Tools->verification_code($db,$arr);

        // 根据授权id,查询用户id
        $sql = "select mobile from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
//            $mobile = $r[0]->mobile;
//            if($mobile == $tel){
            $sql = "update lkt_user set password = '$password' where store_id = '$store_id' and access_id = '$access_id'";
            $rr = $db->update($sql);
            if($rr > 0){
                echo json_encode(array('code'=>200,'message'=>'成功!'));
                exit;
            }else{
                echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                exit;
            }
//            }else{
//                echo json_encode(array('code'=>115,'message'=>'非法入侵!'));
//                exit;
//            }
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }

    // 修改支付密码
    public function modify_payment_password(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $x_password = MD5($request->getParameter('x_password')); // 新密码

        $tel = $request->getParameter('phoneNum'); // 手机号码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码
        $time = date("Y-m-s H:i:s");

        $arr = array($tel,array('code'=>$keyCode));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);

        // 根据微信id,查询用户id
        $sql01 = "select mobile,password from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $re = $db->select($sql01);
        if(!empty($re)){
            $mobile= $re[0]->mobile;
            $password= $re[0]->password;
            if($mobile == $tel){
                if($x_password == $password){
                    echo json_encode(array('code'=>118,'message'=>'新密码不能跟旧密码相同！'));
                    exit;
                }else{
                    $sql = "update lkt_user set password = '$x_password' where store_id = '$store_id' and access_id = '$access_id'";
                    $rr = $db->update($sql);
                    if($rr > 0){
                        if($rew){
                            $sql2 = "delete from lkt_session_id where id = '$rew' ";
                            $db->delete($sql2);
                        }
                        echo json_encode(array('code'=>200,'message'=>'成功!'));
                        exit;
                    }else{
                        echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                        exit;
                    }
                }
            }else{
                echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
                exit;
            }
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }
    // 验证支付密码
    public function payment_password(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $password1 = MD5($request->getParameter('password')); // 密码
        $time = date('Y-m-d H:i:s',time());

        // 根据授权id,查询用户id
        $sql = "select password,login_num from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
            $password = $r[0]->password;
            $login_num = $r[0]->login_num;
            if($password1 == $password){
                $sql = "update lkt_user set login_num = 0 where store_id = '$store_id' and access_id = '$access_id'";
                $db->update($sql);
                echo json_encode(array('code'=>200,'message'=>'成功!'));
                exit;
            }else{
                if($login_num < 4){
                    $login_num = $login_num+1;
                    $sql = "update lkt_user set login_num = '$login_num' where store_id = '$store_id' and access_id = '$access_id'";
                    $db->update($sql);
                    $enterless = true;
                }else{
                    $sql = "update lkt_user set login_num = 5,verification_time = '$time' where store_id = '$store_id' and access_id = '$access_id'";
                    $db->update($sql);
                    $enterless = false;
                }
                echo json_encode(array('code'=>114,'enterless'=>$enterless,'message'=>'密码错误!'));
                exit;
            }
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }
    public function base64_image_contents($base64_image_content,$path,$imgname){
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
            $type = $result[2];
            $new_file = $path."/";
            if(!file_exists($new_file)){
                mkdir($new_file, 0700);
            }
            $new_file =  $path.'/'.$imgname.".{$type}";
            $storage_path =$imgname.".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
                return $storage_path;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function about_us(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $aboutus = '';
        $sql = "select aboutus from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $aboutus = $r[0]->aboutus;
        }
        echo json_encode(array('code'=>200,'aboutus'=>$aboutus,'message'=>'成功!'));
        exit;
    }


}
?>