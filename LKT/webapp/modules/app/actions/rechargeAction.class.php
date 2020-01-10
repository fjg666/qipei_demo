<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/phpqrcode.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');

/**
 * [Laike System] Copyright (c) 2019 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class rechargeAction extends Action {
    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣  
     * @content 会员充值 以及 等级管理接口
     * @date 2019年7月19日
     * @version 1.0
     */

    public function getDefaultView() {

        return ;
    }

    public function execute(){
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = addslashes(trim($request->getParameter('access_id')));
        $store_id = trim($request->getParameter('store_id'));
        $app = $app ? $app : 'getDefaultView';

        if($app != 'grade'){
            if(!empty($access_id)){ // 存在
                $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                if($getPayload_test == false){ // 过期
                    echo json_encode(array('code' => 404, 'message' => '请登录！'));
                    exit;
                }

               
            }else{//不存在
                $user_id = '';
                $is_user =  0;

            }
            $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $res = $db->select($sql);

            if($res){
                $user_id = $res[0]->user_id;
                $is_user = 1;//用户已登录
            }else{
                $is_user = 0;//用户未登录
                $user_id = '';
            }
        }else{
           if($access_id){
                $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
                $res = $db->select($sql);

                if($res){
                    $user_id = $res[0]->user_id;
                    $is_user = 1;//用户已登录
                }else{
                    $is_user = 0;//用户未登录
                    $user_id = '';
                }
           }else{
            $access_id = '';
            $is_user = '';
            $user_id = '';
           }
        }
        
       

        //增加类公用属性，调用到各方法
        $this->access_id = $access_id;
        $this->store_id = $store_id;
        $this->store_type = $store_type;
        $this->is_user = $is_user;
        $this->user_id = $user_id;
        $this->db = $db;
        $this->request = $request;

        $this->$app();

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    // 请求我的详细数据
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        //查询最低充值金额
        $ss = "select * from lkt_finance_config where store_id = '$store_id'";
        $rs = $db->select($ss);
        $min_cz = $rs[0]->min_cz;
        echo json_encode(array('code'=>200,'min_cz'=>$min_cz,'message'=>'成功'));
        exit();
    }

    //会员等级列表展示接口
    public function grade(){

        //获取类公共属性调用到各方法
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $is_user = $this->is_user;
        $user_id = $this->user_id;
        $access_id = $this->access_id;

        //所有会员等级
        $sql_u = "select * from lkt_user_grade where store_id = '$store_id' order by rate desc";
        $res_u = $db->select($sql_u);
        if(!$res_u){
            $res_u = array();
        }

        $payment = Tools::getPayment($db,$store_id);// 支付方式配置
       
        //开通金额方式
        $sql1 = "select method,is_wallet,rule from lkt_user_rule where store_id = $store_id";
        $res1 = $db->select($sql1);
        if($res1){
            $method = explode(',',$res1[0]->method); 
            $is_wallet = $res1[0]->is_wallet;
            $rule = $res1[0]->rule;
        }else{
            $method = array();
            $is_wallet = 0;
            $rule = '';
        }
        //判断每个等级的开通方式是否在设置中开启
        foreach ($res_u as $k => $v) {
            if($v->money == '0.00'){//未设置金额
                unset($v->money);
            }
            if($v->money_j == '0.00'){//未设置金额
                unset($v->money_j);
            }
            if($v->money_n == '0.00'){//未设置金额
                unset($v->money_n);
            }
            if(!in_array(1,$method)){//包月
                unset($v->money);
            }
            if(!in_array(2,$method)){//包季
                unset($v->money_j);
            }
            if(!in_array(3,$method)){//包年
                unset($v->money_n);
            }
           
            $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
            $v->imgurl_s = ServerPath::getimgpath($v->imgurl_s,$store_id);
        }
        //是否设置支付密码
        if($user_id){
            $sql = "select password from lkt_user where store_id = $store_id and user_id = '$user_id'";
            $res = $db->select($sql);
             if($res[0]->password){//存在密码
                $is_password = 1;
            }else{//不存在
                $is_password = 0;
            }
        }else{
                $is_password = 0;
        }
       
        //判断用户是否已开通会员 1-已开通  0-未开通
		$grade_id  = 0 ;
        if($user_id){
            $sql_1 = "select id,grade from lkt_user where store_id = $store_id and user_id = '$user_id' and grade != 0";
            $res_1 = $db->select($sql_1);
            if($res_1){
                $is_open = 1;
				$grade_id = $res_1[0]->grade;
            }else{
                $is_open = 0;
            }
        }else{
            $is_open = 0;
        }

        if(empty($access_id)){
            $is_open = 0;
        }
        
        echo json_encode(array('code'=>200, 'payment' => $payment,'data'=>$res_u,'is_wallet'=>$is_wallet,'is_password'=>$is_password,'rule'=>$rule,'is_open'=>$is_open,'grade_id'=>$grade_id));
        exit;

    }

    /**
     * @description: 会员等级订单金额计算
     * @param {id} 会员等级id
     * @param {flag} 开通-续费-升级 标识
     * @param {user_id} 会员userid
     * @param {method} 开通时长
     * @return: total 总价
     */       
    public function orderTotal($id,$flag,$user_id,$method){
        $db = $this->db;
        $store_id = $this->store_id;
        $total = 0;
        //防止前端非法请求，金额在后端计算
        $sql = "select money,money_j,money_n from lkt_user_grade where store_id = $store_id and id = $id";
        $res = $db->select($sql);
        if($flag != 3 ){//非升级
            if($method == 1){
                $total = $res[0]->money;
            }else if($method == 2){
                $total = $res[0]->money_j;
            }else if($method == 3){
                $total = $res[0]->money_n;
            }
        }else{//升级
            //1.查询单前等级的到期时间，费用
            $sql1 = "select  a.grade_end,b.money,b.id from lkt_user as a left join lkt_user_grade as b on a.grade = b.id where a.store_id = $store_id and a.store_id = b.store_id and a.user_id = '$user_id'";
            $res1 = $db->select($sql1);
            if(!$res1){
                echo json_encode(array('code'=>109,'msg'=>'非法请求'));
                exit;
            }
            $now_money = $res1[0]->money;//费用
            $grade_end_now = $res1[0]->grade_end;//到期时间
            //2.根据要升级的会员等级，计算费用
            $now = date("Y-m-d");
            $end = date("Y-m-d",strtotime("$grade_end_now"));
            $date1 = explode('-',$now);//现在时间
            $date2 = explode('-',$end);//结束时间
            if($date1[1]<$date2[1]){ //判断月份大小，进行相应加或减
                $month_number= abs($date1[0] - $date2[0]) * 12 + abs($date1[1] - $date2[1]);
            }else{
                $month_number= abs($date1[0] - $date2[0]) * 12 - abs($date1[1] - $date2[1]);
            }
            if($month_number == 0){//升级本月
                $month_number = 1;//最少为一个月
            }else{
                //不足一月按一月算
                $days = $date2[2]-$date1[2];
                if($days>0){
                    $month_number = $month_number + 1;
                }
            }
            $total = ($res[0]->money - $now_money)*$month_number;

        }
        return $total;
    }

    //会员等级订单接口
    public function grade_order(){
      
        $log = new LaiKeLogUtils('app/recharge.log');
        //获取类公共属性调用到各方法
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $is_user = $this->is_user;
        $user_id = $this->user_id; 
        //参数
        $id = addslashes(trim($request->getParameter('id')));//等级id
        $type = addslashes(trim($request->getParameter('type')));//支付方式 wallet_pay-钱包支付 aliPay-支付宝支付 app_wechat - app微信支付 jsapi_wechat-微信内网页支付   mini_wechat-小程序微信支付
        $password = addslashes(trim($request->getParameter('password'))); //余额支付密码
        $method = addslashes(trim($request->getParameter('method')));//充值时长 1-包月 2-包季 3-包年
        $flag = addslashes(trim($request->getParameter('flag')));//充值用途 1-充值 2-续费 3-升级
        $tui_id = addslashes(trim($request->getParameter('tui_id')));//推荐人user_id
        
        //查询用户会员结束时间
        $sql_0 ="select grade_end from lkt_user where store_id = $store_id and user_id = '$user_id'"; 
        $res_0 = $db->select($sql_0);
        if($res_0){
            $grade_end_last = $res_0[0]->grade_end ? $res_0[0]->grade_end : ''; 
        }

        $datetime = date("Y-m-d H:i:s");
        $sql = "select money from lkt_user_grade where store_id = '$store_id'";
        $res = $db->select($sql);
        if(!$res){
            echo json_encode(array('code'=>109,'msg'=>'参数错误'));
            exit;
        }
        $total = 0;
        $total = $this->orderTotal($id,$flag,$user_id,$method);
        
        if($total <= 0){
            echo json_encode(array('code'=>109,'msg'=>'非法请求'));
            exit;
        }

        //订单号
        $sNo = 'DJ'.date("ymdhis").rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);//会员等级订单号

        $sql = "select name from lkt_user_grade where store_id = $store_id and id = '$id'";
        $res = $db->select($sql);
        if($res){
            $name = $res[0]->name;//会员等级名称
        }
      
        //支付业务
        if($type == 'wallet_pay'){//余额支付
            $sql = "select user_id,money,password,tui_id from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
            $res = $db->select($sql);
            $password = md5($password);
            if($res){
                $password_user = $res[0]->password;//支付密码
                $money = $res[0]->money;//用户余额
                $have_tui = $res[0]->tui_id ? 1 : 0;//1-有推荐人 0-无推荐人
            }
            if($password_user != $password){
                echo json_encode(array('code'=>109,'msg'=>'支付密码错误'));
                exit;
            }

            if($money < $total){
                echo json_encode(array('code'=>109,'msg'=>'余额不足'));
                exit;
            }else{

                //事务开始
                $db->begin();
                $code = true;
                //金额更新
                $sql_0 = "update lkt_user set money = (money - $total) where store_id = '$store_id' and user_id = '$user_id'";
                $res_0 = $db->update($sql_0);
                if($res_0 < 0){
                    $log -> customerLog('金额更新失败，sql为：'.$sql_0."\r\n");
                    $code = false;
                }
                //插入余额记录
                $sql_1 = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ($store_id,'$user_id',$total,$money,'充值会员等级',4)";
                $res_1 = $db->insert($sql_1);
                if($res_1 < 0){
                    $log -> customerLog('插入余额记录，sql为：'.$sql_1."\r\n");
                    $code = false;
                }

                //判断是续费，充值，还是升级

                //根据选择充值时长，继续到期时间
                if($flag == 1){//充值
                    if($method == 1){//包月
                        $grade_end = date("Y-m-d H:i:s",strtotime("+1 months"));
                    }else if($method == 2){//包季
                        $grade_end = date("Y-m-d H:i:s",strtotime("+3 months"));
                    }else if($method == 3){//包年
                        $grade_end = date("Y-m-d H:i:s",strtotime("+1 years"));
                    }
                }else if($flag == 2){//续费
                    if($method == 1){//包月
                        $grade_end = date("Y-m-d H:i:s",strtotime("$grade_end_last +1 months"));
                    }else if($method == 2){//包季
                        $grade_end = date("Y-m-d H:i:s",strtotime("$grade_end_last +3 months"));
                    }else if($method == 3){//包年
                        $grade_end = date("Y-m-d H:i:s",strtotime("$grade_end_last +1 years"));
                    }
                }else if($flag == 3){//升级

                }


                //更新会员等级
                if($flag == 1){//充值
                    if($tui_id && $have_tui == 0){
                        $sql_2 = "update lkt_user set grade = $id,grade_add = '$datetime',grade_end = '$grade_end',grade_m = $method,is_box = 1,tui_id = '$tui_id' where store_id = $store_id and user_id = '$user_id' ";
                    }else{
                        $sql_2 = "update lkt_user set grade = $id,grade_add = '$datetime',grade_end = '$grade_end',grade_m = $method,is_box = 1 where store_id = $store_id and user_id = '$user_id' "; 
                    }
                   
                }else if($flag == 2){//续费
                    $sql_2 = "update lkt_user set grade = $id,grade_add = '$datetime',grade_end = '$grade_end',grade_m = $method,is_box = 1 where store_id = $store_id and user_id = '$user_id' ";
                }else if($flag == 3){//升级
                    $sql_2 = "update lkt_user set grade = $id,grade_add = '$datetime',grade_m = $method,is_box = 1 where store_id = $store_id and user_id = '$user_id' ";
                }
                //会员首次开通，或者升级 记录处理
                $sql1 = "select is_product from lkt_user_rule where store_id = $store_id";
                $res1 = $db->select($sql1);
                if($res1){
                    $is_product = $res1[0]->is_product;
                }else{
                    $is_product = 0;//0-不开启会员赠送商品 1-开启
                }
              
                if($flag != 2){
                    //判断用户是否为第一次开通或者升级该会员等级
                    $sql_33 = "select id from lkt_user_first where store_id = $store_id and level = '$id' and user_id = '$user_id'";
                    $res_33 = $db->select($sql_33);
                    if(!$res_33){//未开通过
                       
                        //优惠券
                        $coupon = new coupon();
                        $coupon->Coupons($store_id,$user_id,$id);
                        if( $is_product == 1){
                            //商品兑换券
                            $sql_3 = "select valid from lkt_user_rule where store_id = $store_id";
                            $res_3 = $db->select($sql_3);
                            if(!$res_3){//默认七天失效
                                $end_time = date("Y-m-d",strtotime("+ 7 days",time()));
                            }else{
                                $valid = $res_3[0]->valid;
                                $end_time = date("Y-m-d",strtotime("+ $valid days",time()));
                            }

                            //查询出赠送商品的信息入库，并预先减少库存
                            $sql1 = "select pro_id from lkt_user_grade where store_id = $store_id and id = $id";
                            $res1 = $db->select($sql1);
                            if($res1){
                                $pro_id = $res1[0]->pro_id;
                                $sql2 = "select a.id as attr_id,b.id,b.product_title,a.num from lkt_configure as a left join lkt_product_list as b on a.pid = b.id left join lkt_mch as c on b.mch_id = c.id  where b.store_id = '$store_id' and c.store_id = '$store_id' and b.active = 1 and b.status = 2  and a.num > 0 and b.id = '$pro_id' group by b.id ";
                                $res2 = $db->select($sql2);
                                if($res2){
                                    $attr_id = $res2[0]->attr_id;
                                    $num = $res2[0]->num;
                                    if(($num-1) >= 0){//库存足够
                                        $sql3 = "update lkt_configure set num = num - 1 where pid = '$pro_id' and id = '$attr_id'";
                                        $res3 = $db->update($sql3);
                                        if($res3){
                                            $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id,attr_id) values ('$user_id','$id','$id','$end_time','$store_id','$attr_id')";
                                        }else{
                                            $log -> customerLog(__LINE__.':更新库存失败，sql为：'.$sql_1."\r\n");
                                            $code = false;
                                            $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id) values ('$user_id','$id','$id','$end_time','$store_id')";
                                        }
                                    }else{//库存不足
                                        $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id) values ('$user_id','$id','$id','$end_time','$store_id')";
                                        $log -> customerLog(__LINE__.':预减的库存不足'."\r\n");
                                    }
                                }else{//库存不足也没有赠送商品
                                    $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id) values ('$user_id','$id','$id','$end_time','$store_id')";
                                     $log -> customerLog(__LINE__.':库存不足，sql为：'.$sql2."\r\n");
                                }
                            }else{//没有赠送商品
                                $sql_4 = "insert into lkt_user_first (user_id,grade_id,level,end_time,store_id) values ('$user_id','$id','$id','$end_time','$store_id')";
                                 $log -> customerLog(__LINE__.':没有设置会员赠送商品'."\r\n");
                            }
                            $res_4 = $db->insert($sql_4);
                            if($res_4 < 0){
                                $log -> customerLog(__LINE__.':插入会员兑换券失败，sql为：'.$sql_4."\r\n");
                                $code = false;
                            }
                        }
                        //会员赠送商品逻辑
                    }else{//开通过
                      
                    }
                }
               
                $res_2 = $db->update($sql_2);
                if($res_2 < 0){
                    $log -> customerLog(__LINE__.':开通会员失败，sql为：'.$sql_2."\r\n");
                    $code = false;
                }

                //消息推送
                if($flag == 1){//充值
                    $msg_title = '充值会员成功';
                    $msg_content = '您已开通'.$name.'成功，快去享受特权吧';
                }else if($flag == 2){//续费
                    $msg_title = '续费会员成功';
                    $msg_content = '您已续费'.$name.'成功，快去享受特权吧';
                }else if($flag ==3){//生级
                    $msg_title = '升级会员成功';
                    $msg_content = '您已升级'.$name.'成功，快去享受特权吧';
                }

                if($code){
                    $db->commit();
                    //会员等级通知
                    $pusher = new LaikePushTools();
                    $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,'');
                    if($flag == 1){
                        $msg = '充值会员成功';
                    }else if($flag ==2){
                        $msg = '续费会员成功';
                    }else if($flag ==3){
                        $msg ='升级会员成功';
                    }
                    echo json_encode(array('code'=>200,'msg'=>$msg));
                    exit;
                }else{
                    $log -> customerLog('升级会员等级失败，会员的user_id为：'.$user_id);
                    $db->rollback();
                     if($flag == 1){
                        $msg = '充值会员失败';
                    }else if($flag ==2){
                        $msg = '续费会员失败';
                    }else if($flag ==3){
                        $msg ='升级会员失败';
                    }
                    echo json_encode(array('code'=>109,'msg'=>$msg));
                    exit;
                }
            }

        }else{//非余额支付

            $array = array('order_id' => $sNo, 'user_id' => $user_id, 'trade_no' => $sNo, 'pay' => $type, 'total' => $total, 'store_id' => $store_id,'grade_id'=>$id,'method'=>$method,'flag'=>$flag,'tui_id'=>$tui_id);
            $data = serialize($array);
            $sql = "insert into lkt_order_data(trade_no,data,addtime) values('$sNo','$data',CURRENT_TIMESTAMP)"; 
            $rid = $db->insert($sql);
            echo json_encode(array('code'=>200,'title'=>$name.'充值','sNo'=>$sNo,'total'=>$total,'pay_type'=>'DJ'));
            exit;
        }


    }

    //会员升价渲染等级接口
    public function upgrade(){
        //获取类公共属性调用到各方法
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $is_user = $this->is_user;
        $user_id = $this->user_id;

        //查询单前用户会员等级,时长，金额
        $sql_0 = "select b.grade_m,b.grade_end,a.* from lkt_user_grade as a left join lkt_user as b  on a.store_id = b.store_id  where a.store_id = $store_id and a.id = b.grade and b.user_id = '$user_id'";
        $res_0 = $db->select($sql_0);//改会员等级的用户以及等级数据

        if($res_0){
            $rate = $res_0[0]->rate;
            $grade_m = $res_0[0]->grade_m;
            $money = $res_0[0]->money;
            $money_j = $res_0[0]->money_j;
            $money_n = $res_0[0]->money_n;
            $grade_end = $res_0[0]->grade_end;
        }else{
            echo json_encode(array('code'=>109,'msg'=>'参数错误'));
            exit;
        }

        //开通金额方式
        $sql1 = "select method,is_wallet,rule from lkt_user_rule where store_id = $store_id";
        $res1 = $db->select($sql1);
        if($res1){
            $method = explode(',',$res1[0]->method); 
            $is_wallet = $res1[0]->is_wallet;
            $rule = $res1[0]->rule;
        }else{
            $method = array();
            $is_wallet = 0;
            $rule = '';
        }

        //查询出可升级的会员等级
        $sql_u = "select * from lkt_user_grade where store_id = $store_id and rate < '$rate'";
        $res_u = $db->select($sql_u);
        $now = date("Y-m-d");
        $end = date("Y-m-d",strtotime("$grade_end"));
        if($res_u){
            //计算升级差价
            foreach ($res_u as $k => $v) {
                //根据用户剩余月数计算升级金额
                $date1 = explode('-',$now);//现在时间
                $date2 = explode('-',$end);//结束时间
                if($date1[1]<$date2[1]){ //判断月份大小，进行相应加或减
                    $month_number= abs($date1[0] - $date2[0]) * 12 + abs($date1[1] - $date2[1]);
                }else{
                    $month_number= abs($date1[0] - $date2[0]) * 12 - abs($date1[1] - $date2[1]);
                }
                if($month_number == 0){//升级本月
                    $month_number = 1;//最少为一个月
                }else{
                    //不足一月按一月算
                    $days = $date2[2]-$date1[2];
                    if($days>0){
                        $month_number = $month_number + 1;
                    }
                }
                $v->money = (($v->money) - $money)*$month_number;

                $v->money_up = '1';//传给前端做
                //只保留要升级的费用
                unset($v->money_j);
                unset($v->money_n);
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $v->method = $grade_m;
                $v->imgurl_s = ServerPath::getimgpath($v->imgurl_s,$store_id);
            }
        }

        //是否设置支付密码
        $sql = "select password from lkt_user where store_id = $store_id and user_id = '$user_id' and password is not null";
        $res = $db->select($sql);
        if($res){//存在密码
            $is_password = 1;
        }else{//不存在
            $is_password = 0;
        }
        
        echo json_encode(array('code'=>200,'data'=>$res_u,'is_wallet'=>$is_wallet,'is_password'=>$is_password,'rule'=>$rule));
        exit;


    }

    //会员等级中心接口
    public function grade_center(){

        //获取类公共属性调用到各方法
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $is_user = $this->is_user;
        $user_id = $this->user_id;

        //会员本信息
        $sql = "select user_id,user_name,wx_name,headimgurl,grade,grade_end from lkt_user where store_id = '$store_id' and user_id = '$user_id' ";
        $res = $db->select($sql);
        if($res){
            //会员等级
            $grade = $res[0]->grade;
            if($grade == 0){
               $res[0]->grade = '普通会员'; 
               $res[0]->imgurl = '';
               $res[0]->level = 0;
            }else{
               $sql_0 = "select name,rate,imgurl_s,imgurl,level,font_color,date_color from lkt_user_grade where store_id = '$store_id' and id = $grade";
               $res_0 = $db->select($sql_0);
               $res[0]->grade = $res_0[0]->name;
               $res[0]->rate = $res_0[0]->rate;
               $res[0]->imgurl_s = ServerPath::getimgpath($res_0[0]->imgurl_s,$store_id);
               $res[0]->imgurl = ServerPath::getimgpath($res_0[0]->imgurl,$store_id);
               $res[0]->font_color = $res_0[0]->font_color;
               $res[0]->date_color = $res_0[0]->date_color;

            }
            
        }else{
            echo json_encode(array('code'=>109,'参数错误'));
            exit;
        }

        //会员规则
        $sql_0 = "select rule,is_limit,level,poster from lkt_user_rule where store_id = $store_id ";
        $res_0 = $db->select($sql_0);
        $rule = $res_0[0]->rule;
        $is_limit = $res_0[0]->is_limit;
        $level = $res_0[0]->level;//限制的会员等级id
        $share_img = ServerPath::getimgpath($res_0[0]->poster,$store_id);
        //share  0-不可分享 1-可以分享
        if($is_limit == 1){//限制分享
            //判断该用户是否达到会员推荐级别
            $sql_00 = "select rate from lkt_user_grade where store_id = '$store_id' and id = $level";
            $res_00 = $db->select($sql_00);
            if($res_00){
                $low_rate = $res_00[0]->rate;//最低级别的折率
                 $sql_01 = "select id from lkt_user_grade where store_id = '$store_id' and rate <= '$low_rate'";
                $res_01 = $db->select($sql_01);
                $id_arr = array();//可以推荐会员的等级id
                foreach($res_01 as $k => $v){
                    array_push($id_arr,$v->id);
                }
                if(in_array($grade,$id_arr)){
                    $share = 1;
                }else{
                    $share = 0;
                }
            }else{
                $share = 1;
            }

           
        }else{//不限制分享
            $share = 1;
        }
        
        //会员特惠商品
        $sql_1 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.status = 2 and a.mch_status = 2 and a.recycle = 0 and a.active = 6  group by c.pid  order by a.sort desc,a.add_date DESC limit 0,10";
        $res_1 = $db->select($sql_1);
        if(!$res_1){
            $res_1 = array();
        }else{
            foreach($res_1 as $k => $v){
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
            }
        }

        
        //判断是否可以升级
        $sql2 = "select upgrade from lkt_user_rule where store_id = $store_id ";
        $res2 = $db->select($sql2);
        if($res2){
            $upgrade = $res2[0]->upgrade;
            if(strstr($upgrade,'2')){
                $sql_3 = "select b.rate from lkt_user as a left join lkt_user_grade as b on a.grade = b.id where a.store_id = '$store_id' and b.store_id = $store_id and user_id = '$user_id'";
                $res_3 = $db->select($sql_3);
                $rate = $res_3[0]->rate;
                $sql_4 = "select * from lkt_user_grade where store_id = $store_id and rate < '$rate'";
                $res_4 = $db->select($sql_4);
                if($res_4){
                    $is_up = 1;
                }else{
                    $is_up = 0;
                }
            }else{
                $is_up = 0;
            }
        }else{
            $is_up = 0;
        }


        echo json_encode(array('code'=>200,'data'=>$res,'product'=>$res_1,'rule'=>$rule,'share'=>$share,'share_img'=>$share_img,'up'=>$is_up));
        exit;

    }

    //加载更多商品
    public function get_more(){

        //获取类公共属性
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $is_user = $this->is_user;
        $user_id = $this->user_id;

        $num = $request->getParameter('num');//加载页数
        if(!$num){
            $num = 1;
        }
        $pagesize = 10;//每次查询的数目
        $start = $num*$pagesize;//开始查询的位置
        $sql = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.status = 2 and a.mch_status = 2 and a.recycle = 0 and a.active = 6  group by c.pid  order by a.sort desc,a.add_date DESC limit $start,$pagesize";
        $res = $db->select($sql);
        if(!$res){
            echo json_encode(array('code'=>109,msg=>'暂无更多商品'));
            exit;
        }else{
            foreach($res as $k => $v){
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
            }
            echo json_encode(array('code'=>200,'data'=>$res));
            exit;
        }

    }

    //关闭续费提醒
    public function close(){

        //获取类公共属性
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $is_user = $this->is_user;
        $user_id = $this->user_id;

        $sql = "update lkt_user set is_box = 0 where store_id = $store_id and user_id = '$user_id'";
        $res = $db->update($sql);
        if($res){
            echo json_encode(array('code'=>200,'msg'=>'关闭提示成功'));
            exit;
        }else{
            echo json_encode(array('code'=>109,'msg'=>'关闭提示失败'));
            exit;
        }
    }


    //会员推荐分享二维码
    public function share(){
        //获取类公共属性
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $tui_id = $this->user_id;//点击分享的人的user_id为推荐人id

        $data = new stdClass;
        $data->isfx = 1;
        $data->tui_id = $tui_id;
        $data_str = json_encode($data);
        $url = "pagesA/vip/vip?data=$data_str";
        //根据分享来源，确定二维码分享路劲
        if($store_type == 1){//微信小程序
            $sql = "select * from lkt_payment_config where pid = '5' and store_id = '$store_id' ";
            $r = $db->select($sql);
            $value = $r ? $r[0]:[];
            if ($value) {
                $list = json_decode($value->config_data);
                $appid = $list->appid;
                $appsecret = $list->appsecret;
            }
            //判断是否为授权小程序
            $sql0 = "select id from lkt_third_mini_info where store_id = $store_id";
            $res0 = $db->select($sql0);
            if($res0){//
                $is_third = 1;
            }else{
                $is_third = 0;
            }
            $qrcode_path = $this->get_mini_code($db,$url,$appid,$appsecret,$is_third,$store_id,130);

        }else if($store_type == 2){//app
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
            if (!empty($r[0]->H5_domain)) {
                $url = $r[0]->H5_domain.$url;
            }
            $qrcode_path = $this->getQrCode($url, 'images/product_share_img',3);
        }
        if(!$qrcode_path){
            echo json_encode(array('code'=>109,'msg'=>'参数错误，获取二维码失败'));
            exit;
        }
        //合成图片
        //bg_image 背景图  qrcode_path 二维码
        $sql_1 = "select poster from lkt_user_rule where store_id = $store_id and poster is not NULL";
        $res_1 = $db->select($sql_1);
        if(!$res_1){
            echo json_encode(array('code'=>109,'msg'=>'分享海报背景图未设置'));
            exit;
        }
        $poster =  ServerPath::getimgpath($res_1[0]->poster,$store_id);
       
        if(strstr($poster,"aliyuncs.com")){//存在阿里云
            $path1 = $poster.'?x-oss-process=image/resize,w_300,limit_0';
            $bg_image = $this->downImgUrl($path1);//下载分享海报
        }else{//不存在阿里云
             //存在本地
            $wherefile = 'localhost';
            $bg_image = $this->downImgUrl($poster);//下载商品图片
            $imgPath = "images/product_share_img/" . uniqid() . mt_rand(1, 200) . ".png";
            list($width, $height)=getimagesize($bg_image);
            $per=round(300/$width,3);
            $n_w=$width*$per;
            $n_h=$height*$per;
            $new=imagecreatetruecolor($n_w, $n_h);
            $img = $this->getImageType($bg_image);
            //copy部分图像并调整
            imagecopyresized($new, $img,0, 0,0, 0,$n_w, $n_h, $width, $height);
            //图像输出新图片、另存为
            imagejpeg($new, $imgPath);
            imagedestroy($new);
            imagedestroy($img);
            unlink($bg_image);
            $bg_image = $imgPath;
        }


        //1.创建画布，默认的背景色是黑色
        $im = imagecreatetruecolor(300,487);
        $white = imagecolorallocate($im,255,255,255);
        imagefill($im,0,0,$white);//默认的背景色是黑色改为白色

        //2.绘制图形(拷贝原图片到目标画布)-背景图-二维码
        //2.1加载源图片
        $src_bg_image =  $this->getImageType($bg_image);
        //2.2获取图片大小
        $src_bg_info = getimagesize($bg_image);
        $imageWidth = $src_bg_info[0];//宽
        $imageHeight = $src_bg_info[1];//高
        //2.3得到宽高后，将图片拷贝到目标画布上
        imagecopymerge($im,$src_bg_image,0,0,0,0,$imageWidth,$imageHeight,100);//背景图

        $src_code_image = $this->getImageType($qrcode_path);
        $src_code_info = getimagesize($qrcode_path);
        $imageWidth1 = $src_code_info[0];//宽
        $imageHeight1 = $src_code_info[1];//高
        if($store_type == 1){//小程序
                imagecopymerge($im, $src_code_image, 95, 278, 0, 0, imagesx($src_code_image), imagesy($src_code_image)-18, 100);
        }else{
            if ($store_type == 2) {//app
                imagecopymerge($im, $src_code_image, 90, 270, 0, 0,imagesx($src_code_image), imagesy($src_code_image), 100);
            }else{
                imagecopymerge($im, $src_code_image, 95, 278, 0, 0,imagesx($src_code_image), imagesy($src_code_image)-18, 100);
            }

        }

        $share_img_name = md5(date("Ymd").rand(1000,9999));
        $share_img_path = 'images/product_share_img/'.$share_img_name.'.png';
        imagepng($im,$share_img_path);

        $base64img = $this->base64EncodeImage($share_img_path);
        $base64img = str_replace("\r\n", "", $base64img);
        unlink($qrcode_path);

        $sql = "select endurl from lkt_third where id = 1";
        $r = $db->select($sql);
        $share_img_path = $r[0]->endurl.$share_img_path;
    

        echo json_encode(array('code'=>200,'imgUrl'=>$share_img_path));
        exit;
    }
    //微信小程序二维码获取
    public function get_mini_code($db,$url,$APPID,$APPSECRET,$is_third,$store_id,$code_width=200){
        if($is_third == 0){
            header('content-type:text/html;charset=utf-8');
            //获取access_token
            $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$APPID&secret=$APPSECRET";
            //缓存access_token
            $_SESSION['access_token'] = "";
            $_SESSION['expires_in'] = 0;
            $ACCESS_TOKEN = "";
            if(!isset($_SESSION['access_token']) || (isset($_SESSION['expires_in']) && time() > $_SESSION['expires_in']))
            {

                $json = $this->httpRequest( $access_token );
                $json = json_decode($json,true);
                $_SESSION['access_token'] = $json['access_token'];
                $_SESSION['expires_in'] = time()+7200;
                $ACCESS_TOKEN = $json["access_token"];
            }
            else{
                $ACCESS_TOKEN =  $_SESSION["access_token"];
            }
        }else{
            $tools = new Tools($db,$store_id,'');
            $ACCESS_TOKEN = $tools->update_authorizer_access_token();//授权token
        }
        
        //构建请求二维码参数
        //path是扫描二维码跳转的小程序路径，可以带参数?id=xxx
        //width是二维码宽度
        $qcode ="https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=$ACCESS_TOKEN";
        $param = json_encode(array("path"=>$url,"width"=> 50));

        //POST参数
        $result = $this->httpRequest( $qcode, $param,"POST");
        $ret = json_decode($result);
        if($ret){
            if(@$ret->errcode != 0){
                echo json_encode(array('errcode'=>$ret->errcode,'errmsg'=>$ret->errmsg));
                exit;
            }
        }
        //生成二维码
        $file_path = 'images/product_share_img/';
        $qrcode_name = md5(time() . rand(1000, 9999));

        $filename = $file_path.$qrcode_name.'.jpg';
        $qrcode_name = file_put_contents($filename, $result);
        

        $imgPath = "images/product_share_img/" . uniqid() . mt_rand(1, 200) . ".jpg";

        list($width, $height)=getimagesize($filename);
        $per=round($code_width/$height,3);
        $n_w=$width*$per;
        $n_h=$height*$per;

        $new=imagecreatetruecolor($n_w, $n_h);
        $img=imagecreatefromjpeg($filename);
        //copy部分图像并调整
        imagecopyresized($new, $img,0, 0,0, 0,$n_w, $n_h, $width, $height);
        //图像输出新图片、另存为
        imagejpeg($new, $imgPath);
        imagedestroy($new);
        imagedestroy($img);
        // unlink($filename);
        $filename = $imgPath;
        return $filename;
        //$base64_image ="data:image/jpeg;base64,".base64_encode( $result );
        //echo $base64_image;
    }

    // 获得普通二维码，并储存到本地
    public function getQrCode($url,$uploadImg,$size = 5){

        $qrcode_name = md5(date("Ymd").rand(1000,9999));
        $value = $url;//二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = $size;           //生成图片大小
        $filename = $uploadImg.'/'.$qrcode_name.'.png';

        QRcode::png($value,$filename , $errorCorrectionLevel, $matrixPointSize, 2);
        return $filename;
    }
    /**
     * 下载网络图片
     * @param $imgurl
     * @return string
     */
    function downImgUrl($imgurl) {

        // 获取头像
        $imgPath = "images/product_share_img/" . uniqid() . mt_rand(1, 200) . ".png";

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

    /**
     * 获取图片类型
     * @param $picname
     * @return resource|null
     */
    function getImageType($picname){
        $ename=getimagesize($picname);
        $ename=explode('/',$ename['mime']);
        $ext=$ename[1];
        $image = null;
        switch($ext){
            case "png":
                $image=imagecreatefrompng($picname);
                break;
            case "jpeg":
                $image=imagecreatefromjpeg($picname);
                break;
            case "jpg":
                $image=imagecreatefromjpeg($picname);
                break;
            case "gif":
                $image=imagecreatefromgif($picname);
                break;
        }
        return $image;
    }

    function base64EncodeImage($image_file)
    {
        $base64_image = '';
        $image_info = getimagesize($image_file);
        $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
        $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
        return $base64_image;
    }

    //把请求发送到微信服务器换取二维码
    function httpRequest($url, $data='', $method='GET'){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if($method=='POST')
        {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data != '')
            {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }

        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
?>