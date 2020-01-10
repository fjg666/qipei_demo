<?php

require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Commission.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/aliyun-dysms-php-sdk-lite/demo/sendSms.php');

/**
 * <p>Copyright (c) 2019-2020</p>
 * <p>Company: www.laiketui.com</p>
 * @author 熊孔钰
 * @content 分销接口
 * @date 2019年9月29日
 * @version 1.0
 */
class commcenterAction extends Action {

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
        if($app != 'get_config'){
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
        $logo = $r_1?$r_1['0'] ->logo:'';
        $company = $r_1?$r_1['0'] ->company:'';

        // 查询配置参数
        $user['content'] = '';// 分销规则
        $sql = "select sets from lkt_distribution_config where store_id = '$store_id' ";
        $r_1 = $db->select($sql);
        if($r_1){
            $sets = unserialize($r_1[0]->sets);
            $user['content'] = $sets['content'];
        }

        // 查询会员信息
        $sql = "select a.user_id,a.headimgurl,a.user_name,b.pid,b.commission,b.onlyamount,b.allamount,b.level from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and a.access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id;
            
            //会员升级
            $comm=new Commission();
            $comm->uplevel($db,$store_id,$user_id);

            $user['headimgurl'] = $r[0]->headimgurl;//用户头像
            $user['user_name'] = $r[0]->user_name;//用户昵称
            $user['user_id'] = $r[0]->user_id;//用户ID
            $user['comm3'] = $r[0]->commission;//可提现佣金
            $level = intval($r[0]->level);//分销等级

            if ($level > 0) {//分销等级大于0时
                
                $user['is_distribution'] = 1;//是否为分销商 1是 0否
                //查询等级名称
                $sqq_1 = "select sets from lkt_distribution_grade where id='$level'";
                $ree_1 = $db->select($sqq_1);
                $user['levelname'] = "默认等级";
                if ($ree_1) {
                    $val_1 = unserialize($ree_1[0]->sets);
                    $user['levelname'] = $val_1['s_dengjiname'];//等级名称
                }

                //累计佣金
                $sql_22 = "select sum(a.money) as sum from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.type=1 and a.user_id='$user_id' and a.status=1 and b.status in (1,2,3,5,7)";
                $r_22 = $db->select($sql_22);
                $user['comm2'] = floatval($r_22[0]->sum);

                //预计佣金
                $sql_11 = "select sum(a.money) as sum from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.type=1 and a.user_id='$user_id' and b.status in (1,2,3,5,7) and a.status=0";
                $r_11 = $db->select($sql_11);
                $user['comm1'] = floatval($r_11[0]->sum);

                $pid = $r[0]->pid;
                $sqq_2 = "select user_name from lkt_user where store_id = '$store_id' and user_id='$pid'";
                $ree_2 = $db->select($sqq_2);

                if ($ree_2) {
                    $user['pidname'] = empty($pid) ? "总店" : $ree_2[0]->user_name;
                }else{
                    $user['pidname'] = "总店";
                }
                
                //是否存在未审核提现申请
                $sql_44 = "select id,status from lkt_distribution_withdraw where store_id = '$store_id' and user_id='$user_id' and status=0 order by add_date desc LIMIT 0,1";
                $r_44 = $db->select($sql_44);
                $user['tixian_id'] = $r_44?$r_44[0]->id:0;//未审核提现申请ID

            }else{
                $user['is_distribution'] = 0;
            }

            echo json_encode(array('code'=>200,'data'=>$user,'message'=>'成功'));
            exit();
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }
    // 我的团队
    public function mygroup(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $store_type = trim($request->getParameter('store_type'));
        $page = trim($request->getParameter('page'));//页码
        $pagesize = 10;//每页显示多少条
        $start = $page*$pagesize;//开始行数

        // 查询配置参数
        $sql = "select * from lkt_distribution_config where store_id = '$store_id' ";
        $r_1 = $db->select($sql);
        if($r_1){
            $sets = unserialize($r_1[0]->sets);
        }

        // 查询会员信息
        $sql = "select a.user_id,b.uplevel from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and b.level>0 and a.access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){

            $uid = trim($request->getParameter('uid')); // 指定查询用户ID

            $user_id = empty($uid) ? $r[0]->user_id : $uid;// 如无指定查询用户便查询当前用户
            $user_level = intval($r[0]->uplevel);// 用户层级

            // 查询用户信息
            $sql = "select * from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
            $r = $db->select($sql);
            $list = array();
            if ($r) {
                
                $lt = $r[0]->lt;
                $rt = $r[0]->rt;
                $level = intval($r[0]->uplevel);
                $levell = $level+1;

                $panduan = $level-$user_level;// 计算会员与被查询会员相差层级
                if ($panduan > $sets['c_cengji']) {
                    echo json_encode(array('code' => 200, 'message' => '无法查看更多！'));
                    exit();
                }else{
                    //查询下级
                    $sql = "select a.user_id,a.headimgurl,a.user_name,b.level,b.uplevel,b.lt,b.rt from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where b.store_id='$store_id' and b.lt>'$lt' and b.rt<'$rt' and b.level>0 and b.uplevel='$levell' LIMIT $start,$pagesize";
                    $r = $db->select($sql);
                    if ($r) {
                        foreach ($r as $k => $v) {
                            
                            $llt = $v->lt;
                            $rrt = $v->rt;
                            $llevel = $v->uplevel;// 层级
                            $llevell = intval($llevel)+1;
                            $grade = $v->level;// 等级

                            // 查询直推下级总数
                            $sql = "select count(id) as count from lkt_user_distribution where store_id='$store_id' and lt>'$llt' and rt<'$rrt' and level>0 and uplevel='$llevell'";
                            $r = $db->select($sql);
                            $v->soncount = $r[0]->count;// 直推下级总数
                            $v->uplevel = intval($v->uplevel)-$user_level;// 相差层级
                            // 查询分销等级名称
                            $sql = "select sets from lkt_distribution_grade where store_id='$store_id' and id='$grade'";
                            $r = $db->select($sql);
                            $v->levelname = "默认等级";
                            if ($r) {
                                $sets = unserialize($r[0]->sets);
                                $v->levelname = $sets['s_dengjiname'];// 等级名称
                            }
                            $list[] = $v;
                        }
                    }
                    echo json_encode(array('code'=>200,'list'=>$list,'message'=>'成功'));
                    exit();
                }
            }
            echo json_encode(array('code'=>200,'list'=>$list,'message'=>'成功'));
            exit();
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }
    // 佣金明细
    public function comm_list(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $page = intval(trim($request->getParameter('page'))); // 页数
        $pagesize = 10;//每页显示多少条
        $start = $page*$pagesize;//开始行数

        // 查询用户ID
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if(!empty($r)){
            $user_id = $r[0]->user_id; // 用户ID

            //累计佣金
            $sql_2 = "select sum(a.money) as total from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.user_id='$user_id' and ((b.status in (1,2,3,5,7) and a.type=1) or a.type=3)";
            $r_2 = $db->select($sql_2);
            $total = $r_2[0]->total;

            // 查询有效佣金明细
            $sql = "select a.money,a.add_date,a.from_id,a.status from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id = '$store_id' and a.user_id = '$user_id' and ((b.status in (1,2,3,5,7) and a.type=1) or a.type=3) and a.money>0 order by a.add_date desc LIMIT $start,$pagesize";
            $r_1 = $db->select($sql);
            $z_num = count($r_1);// 记录行数
            $list = [];
            if($z_num > 0){
                foreach ($r_1 as $k => $v){
                    $from_id = $v->from_id;// 分销员
                    $v->from_user = '';// 分销员昵称
                    if (!empty($from_id)) {
                        $sqq_2 = "select user_name from lkt_user where store_id = '$store_id' and user_id='$from_id'";
                        $ree_2 = $db->select($sqq_2);
                        $v->from_user = $ree_2?$ree_2[0]->user_name:'';
                    }
                    $v->status = intval($v->status) == 1 ? "已发放" : "待发放";// 是否发放 0否 1是
                    $v->time = substr($v->add_date,0,strrpos($v->add_date,':'));// 记录时间
                    $list[$k] = $v;
                }
                echo json_encode(array('code'=>200,'list'=>$list,'total'=>$total,'message'=>'成功'));
                exit();
            }else{
                echo json_encode(array('code'=>103,'message'=>'没有更多了！'));
                exit();
            }
        }else{
            echo json_encode(array('code'=>404,'message'=>'请登录！'));
            exit;
        }
        echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
        exit();
    }
    // 提现明细
    public function cash_list(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $status = intval(trim($request->getParameter('status'))); // 状态 1.审核中 2.审核通过 3.拒绝
        $page = intval(trim($request->getParameter('page'))); // 页数
        $pagesize = 10;//每页显示多少条
        $start = $page*$pagesize;//开始行数

        $ccc = "";
        if ($status == 1) {
            $ccc = " and status=0";
        }else if ($status == 2) {
            $ccc = " and status=1";
        }else if ($status == 3) {
            $ccc = " and status=2";
        }

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if(!empty($r)){
            $user_id = $r[0]->user_id; // 用户id

            // 成功提现佣金
            $sql_2 = "select sum(money) as total from lkt_distribution_withdraw where store_id = '$store_id' and user_id = '$user_id' and status=1";
            $r_2 = $db->select($sql_2);
            $total = $r_2[0]->total;

            // 提现记录
            $sql = "select * from lkt_distribution_withdraw where store_id = '$store_id' and user_id = '$user_id' and money>0 ".$ccc." order by add_date desc LIMIT $start,$pagesize";
            $r_1 = $db->select($sql);
            $z_num = count($r_1);// 记录总数

            $list = [];
            if($z_num > 0){
                foreach ($r_1 as $k => $v){
                    $v->time = substr($v->add_date,0,strrpos($v->add_date,':'));
                    $list[$k] = $v;
                }
                echo json_encode(array('code'=>200,'list'=>$list,'total'=>$total,'message'=>'成功'));
                exit();
            }else{
                echo json_encode(array('code'=>103,'message'=>'没有更多了！'));
                exit();
            }
        }else{
            echo json_encode(array('code'=>404,'message'=>'请登录！'));
            exit;
        }
        echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
        exit();
    }
    // 提现详情
    public function cash_detail(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收信息
        $access_id = trim($request->getParameter('access_id')); // 授权ID
        $id = intval(trim($request->getParameter('id')));// 提现记录ID

        // 查询记录
        $sql = "select * from lkt_distribution_withdraw where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $bankid = $r[0]->Bank_id;// 银行卡ID
        // 查询用户银行卡信息
        $sql = "select * from lkt_user_bank_card where store_id = '$store_id' and id='$bankid'";
        $ree = $db->select($sql);
        if ($ree) {
            $r[0]->bank_name = $ree[0]->Bank_name;// 银行名称
            $r[0]->last = substr($ree[0]->Bank_card_number,-4);// 卡号

            echo json_encode(array('code'=>200,'res'=>$r[0],'message'=>'成功'));
            exit();
        }else{
            echo json_encode(array('code'=>404,'message'=>'提现订单不存在！'));
            exit();
        }
    }
    // 进入提现页面
    public function into_withdrawals(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收参数
        $access_id = trim($request->getParameter('access_id')); // 授权id

        // 查询设置
        $sql = "select sets from lkt_distribution_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        if ($r_1) {
            $set = unserialize($r_1[0]->sets);
            $min_amount = empty($set['cash_min'])?0:$set['cash_min']; // 最小提现金额
            $max_amount = empty($set['cash_max'])?9999:$set['cash_max']; // 最大提现金额
            $cash_charge = empty($set['cash_charge'])?0:$set['cash_charge']; // 手续费
        }else{
            $min_amount = 0; // 最小提现金额
            $max_amount = 99999; // 最大提现金额
            $cash_charge = 0; // 手续费
        }
        $unit = '元'; // 单位
        $pshd = '请输入提现金额(大于' . $min_amount . ')';

        // 查询分销商余额
        $sql = "select a.user_id,a.mobile,b.commission from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and a.access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){

            $user_id = $r[0]->user_id; // 分销商id
            $money = $r[0]->commission; // 分销商余额
            $mobile = $r[0]->mobile; // 手机号

            // 查询用户银行卡信息
            $sql = "select id,Cardholder,Bank_name,Bank_card_number,branch from lkt_user_bank_card where store_id = '$store_id' and user_id = '$user_id' and is_default = 1";
            $rr = $db->select($sql);

            $rew = '';
            if($rr){
                // 银行卡号中间马赛克
                $res = strlen($rr[0]->Bank_card_number) - 4;
                for ($i=0; $i < $res; $i++) {
                    $rew .= '*';
                }
                $rr[0]->Bank_card_number = $rew . substr($rr[0]->Bank_card_number,-4);
                // 银行卡号中间马赛克 end
                $bank_information = $rr[0];
            }else{
                $bank_information = '';
            }

            // 如果用户可提现金额小于最大提现金额 最大体现金额为用户可提现金额
            if($money < $max_amount){
                $max_amount = $money;
            }

            $data = array('min_amount'=>$min_amount,'max_amount'=>$max_amount,'pshd'=>$pshd,'unit'=>$unit,'bank_information'=>$bank_information,'mobile'=>$mobile,'cash_charge'=>$cash_charge);
            echo json_encode(array('code'=>200,'data'=>$data,'message'=>'成功'));
            exit();
        }else{
            echo json_encode(array('code'=>404,'err'=>'请登录！'));
            exit;
        }
        echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
        exit;
    }
    // 支付方法
    public function get_config(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        // 接收参数
        $url = addslashes(trim($request->getParameter('url'))); // 链接
        $type = addslashes(trim($request->getParameter('type'))); // 支付类名称

        // 返回参数
        $res = array(
            'config' => '',
            'url' => urlencode($url)
        );
        if (!empty($type)) {
            $sql2 = "select config_data from lkt_payment as p left join lkt_payment_config as c on c.pid = p.id where c.store_id='$store_id' and c.status = 1  and p.status = 0 and p.class_name = '$type' ";
            $res2 = $db->select($sql2);
            if ($res2) {
                $res['config'] = json_decode($res2[0]->config_data);
            }
        }

        echo json_encode(array('code'=>200,'data'=>$res,'message'=>'成功！'));
        exit();
    }
    // 提现申请
    public function withdrawals(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收信息
        $code = trim($request->getParameter('code')); // 验证码
        $amoney = trim($request->getParameter('amoney')); // 提现金额
        $branch = trim($request->getParameter('branch')); // 支行名称
        $mobile = trim($request->getParameter('mobile')); // 手机号码
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $Bank_name = trim($request->getParameter('Bank_name')); // 银行名称
        $Cardholder = trim($request->getParameter('Cardholder')); // 持卡人
        $Bank_card_number = trim($request->getParameter('Bank_card_number')); // 银行卡号

        $log = new LaiKeLogUtils('common/app_commcenter.log');// 日志

        // 验证手机号码
        $arr = array($mobile,array('code'=>$code));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);

        // 查询单位
        $sql = "select sets from lkt_distribution_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        $set = unserialize($r_1[0]->sets);
        $min_amount = empty($set['cash_min'])?0:$set['cash_min']; // 最小提现金额
        $max_amount = empty($set['cash_max'])?9999:$set['cash_max']; // 最大提现金额
        $tax = empty($set['cash_charge'])?0:$set['cash_charge']; // 设置的手续费参数

        // 提现金额不为数字
        if(is_numeric($amoney) == false){
            $log->customerLog(__LINE__.":佣金提现失败:提现金额应为数字！ \r\n");
            echo json_encode(array('code'=>114,'message'=>'提现金额应为数字！'));
            exit();
        }

        // 查询佣金
        $sql = "select a.user_id,a.user_name,b.commission from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and a.access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id; // 会员id
            $user_name = $r[0]->user_name; // 会员昵称
            $money = $r[0]->commission; // 佣金
            // 提现金额是否小于等于0,或者大于现有金额
            if($amoney > $money || $amoney <= 0){
                $log->customerLog(__LINE__.":佣金提现失败:提现金额是否小于等于0,或者大于现有金额！ \r\n");
                echo json_encode(array('code'=>114,'message'=>'提现金额是否小于等于0,或者大于现有金额！'));
                exit();
            }
            // 提现金额小于最小提现金额
            if($amoney < $min_amount){
                $log->customerLog(__LINE__.":佣金提现失败:提现金额小于最小提现金额！ \r\n");
                echo json_encode(array('code'=>114,'message'=>'提现金额小于最小提现金额！'));
                exit();
            }
            // 提现金额大于最大提现金额
            if($amoney > $max_amount){
                $log->customerLog(__LINE__.":佣金提现失败:提现金额大于最大提现金额！ \r\n");
                echo json_encode(array('code'=>114,'message'=>'提现金额大于最大提现金额！'));
                exit();
            }
            // 银行卡号是否为数字
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
                        $log->customerLog(__LINE__.":佣金提现失败:银行卡号不为数字！ \r\n");
                        echo json_encode(array('code'=>114,'message'=>'银行卡号不为数字!'));
                        exit();
                    }else{
                        $Bank_card_number = $Bank_card_number1;
                    }
                }else{
                    $log->customerLog(__LINE__.":佣金提现失败:银行卡号不为数字！ \r\n");
                    echo json_encode(array('code'=>114,'message'=>'银行卡号不为数字!'));
                    exit();
                }
            }else{
                if(strlen($Bank_card_number) != 19 && strlen($Bank_card_number) != 16){// 判断卡号位数
                    $log->customerLog(__LINE__.":佣金提现失败:卡号不正确！ \r\n");
                    echo json_encode(array('code'=>114,'message'=>'卡号不正确!'));
                    exit();
                }
            }
            // 根据卡号,查询银行名称
            $r = $this->bankInfo($Bank_card_number);
            if($r == ''){
                $log->customerLog(__LINE__.":佣金提现失败:卡号不正确！ \r\n");
                echo json_encode(array('code'=>114,'message'=>'卡号不正确!'));
                exit();
            }else{
                $name = strstr($r,'银行',true) . "银行";
                if($name != $Bank_name){
                    $log->customerLog(__LINE__.":佣金提现失败:银行信息不匹配！ \r\n");
                    echo json_encode(array('code'=>114,'message'=>'银行信息不匹配！'));
                    exit();
                }
            }
            $cost = $amoney * $tax;  // 实际的手续费
            // 查询用户是否存在审核中提现
            $sql = "select count(id) as a from lkt_distribution_withdraw where store_id = '$store_id' and status = 0 and user_id = '$user_id'";
            $r = $db->select($sql);
            $count = $r?$r[0]->a:0; // 条数
            if($count > 0){ // 存在审核中提现
                $log->customerLog(__LINE__.":佣金提现失败:您还有一笔提现正在审核中！ \r\n");
                echo json_encode(array('code'=>114,'message'=>'您还有一笔提现正在审核中！'));
                exit();
            }else{
                $date = date('Y-m-d');
                $sql = "select * from lkt_distribution_withdraw where store_id = '$store_id' and user_id = '$user_id' and add_date like '$date%'";
                $r = $db->select($sql);
                if (count($r) > 0) {
                    $log->customerLog(__LINE__.":佣金提现失败:一天只允许提现一次！ \r\n");
                    echo json_encode(array('code'=>114,'message'=>'一天只允许提现一次！'));
                    exit();
                }
                // 提现操作
                $this->tixian($user_id,$cost,$money,$user_name);
                // 提现操作    end
            }
        }

        $log->customerLog(__LINE__.":佣金提现失败:参数错误！ \r\n");
        echo json_encode(array('code'=>109,'message'=>'参数错误！'));
        exit();
        
        return;
    }
    // 提现操作
    public function tixian($user_id,$cost,$money,$user_name){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收信息
        $t_money = trim($request->getParameter('amoney')); // 提现金额
        $branch = trim($request->getParameter('branch')); // 支行名称
        $mobile = trim($request->getParameter('mobile')); // 手机号码
        $Bank_name = trim($request->getParameter('Bank_name')); // 银行名称
        $Cardholder = trim($request->getParameter('Cardholder')); // 持卡人
        $Bank_card_number = trim($request->getParameter('Bank_card_number')); // 银行卡号

        $log = new LaiKeLogUtils('common/app_commcenter.log');// 日志

        $db->begin();
        // 根据银行名称、卡号，查询用户银行卡信息
        $sql = "select id,Cardholder from lkt_user_bank_card where store_id = '$store_id' and Bank_name = '$Bank_name' and Bank_card_number = '$Bank_card_number' and user_id = '$user_id'";
        $r1 = $db->select($sql);
        if($r1){
            $bank_id = $r1[0]->id;
            if($Cardholder != $r1[0]->Cardholder){
                $log->customerLog(__LINE__.":佣金提现失败:持卡人信息错误！ \r\n");
                echo json_encode(array('code'=>209,'message'=>'持卡人信息错误！'));
                exit();
            }
        }else{
            $sql = "insert into lkt_user_bank_card(store_id,user_id,Cardholder,Bank_name,branch,Bank_card_number,add_date,is_default) values ('$store_id','$user_id','$Cardholder','$Bank_name','$branch','$Bank_card_number',CURRENT_TIMESTAMP,1)";
            $bank_id = $db->insert($sql,'last_insert_id');
            if ($bank_id < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":佣金提现失败:$sql \r\n");
                echo json_encode(array('code'=>209,'message'=>'操作失败！'));
                exit();
            }
        }
        $sql = "update lkt_user_distribution set commission = commission - '$t_money' where store_id = '$store_id' and user_id = '$user_id' and commission>='$t_money'";
        $res = $db->update($sql);
        if ($res < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":佣金提现失败:$sql \r\n");
            echo json_encode(array('code'=>209,'message'=>'操作失败！'));
            exit();
        }
        // 在提现列表里添加一条数据
        $sql = "insert into lkt_distribution_withdraw (store_id,user_id,name,mobile,Bank_id,money,z_money,s_charge,status,add_date) values ('$store_id','$user_id','$user_name','$mobile','$bank_id','$t_money','$money','$cost',0,CURRENT_TIMESTAMP)";
        $withdraw_id = $db->insert($sql,'last_insert_id');
        if($withdraw_id > 0){
            $event = $user_id.'申请佣金提现'.$t_money.'元';
            $sqll = "insert into lkt_distribution_record (store_id,user_id,money,event,type) values ('$store_id','$user_id','$t_money','$event',2)";
            $res = $db->insert($sqll);
            if ($res < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":佣金提现失败:$sqll \r\n");
                echo json_encode(array('code'=>209,'message'=>'操作失败！'));
                exit();
            }

            $db->commit();
            $log->customerLog(__LINE__.":佣金提现成功！ \r\n");
            echo json_encode(array('code'=>200,'message'=>'成功！','withdraw_id'=>$withdraw_id));
            exit();
        }else{
            $db->rollback();
            $log->customerLog(__LINE__.":佣金提现失败:业务异常！ \r\n");
            echo json_encode(array('code'=>209,'message'=>'业务异常！'));
            exit();
        }
        $log->customerLog(__LINE__.":佣金提现失败:参数错误！ \r\n");
        echo json_encode(array('code'=>209,'message'=>'参数错误！'));
        exit();
    }
    // 验证卡号是否跟银行匹配
    function bankInfo($card) { 
        require_once('bankList.php');
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

}
?>