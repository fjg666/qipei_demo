<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once('Apimiddle.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
//发红包
class red_packetAction extends Apimiddle
{

    public function getDefaultView()
    {
        echo json_encode(array('code' => 200, 'msg' => '404'));
        exit;
    }
    /**
     * [execute description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-15T15:01:33+0800
     * @return  控制器跳转指定方法 [description]
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //m指向具体操作方法
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))):'getDefaultView';
        $openid = addslashes(trim($request->getParameter('openid')));
        $store_id = addslashes(trim($request->getParameter('store_id')));

        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r = $db->select($sql);
        $user_id = $r ? $r[0]->user_id:'';

        $this->user_money = $r[0]->money;

        if(empty($user_id) || empty($openid) || empty($store_id)){
            echo json_encode(array('code' => 200, 'msg' => '参数缺少' ,'status' => 1));
            exit;
        }
        //列出纪要用到的公共数据
        $this->db = $db;
        $this->user_id = $user_id;
        $this->store_id = $store_id;
        //m指向具体操作方法
        $this->$m();
        exit;

    }

    //模拟退款
    public function testr()
    {
        $store_id = $this->store_id;

        $datetime = date("Y-m-d H:i:s", time());//当前时间
        $sql0 = "select * from lkt_red_packet_send where store_id = '$store_id' and expire_date < '$datetime' and detailed != '' ";
        $r_10 = $this->db->select($sql0);
        // var_dump($r_10,$sql0);
        if($r_10){
            foreach ($r_10 as $key => $value) {
                //开启事物
                $this->db->begin();

                $user_id = $value->user_id;
                $store_id = $value->store_id;
                $money = explode(',',$value->detailed);
                $total =0;//红包的金额
                foreach ($money as $k => $v) {
                    $total += $v;
                }
                var_dump($total);
                //支付方式
                if($value->trade_no){
                    //退微信
                    $res = $this->return_wx_pay($value,$this->db);
                    var_dump($res);   
                }else{
                    //退余额
                    $sql = "update lkt_user set money = money + '$total' where store_id = '$store_id' and user_id = '$user_id'";
                    $res = $this->db->update($sql);
                    //添加日志
                    $event = $user_id . '退款' . $total . '元余额';
                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$total','$total','$event',5)";
                    $rr = $this->db->insert($sqll);
                    //发送推送信息
                    if ($rr < 1 || $res < 1) {
                        $this->db->rollback();
                        echo 0;
                        exit;
                    }

                }

                if($res){
                    $sql = "update lkt_red_packet_send set detailed = '' where r_id = '$value->r_id'";
                    $res = $this->db->update($sql);
                    if ($res < 1) {
                        $this->db->rollback();
                        echo 0;
                        exit;
                    }
                }
                //提交
                $this->db->commit();
            }
        }
    }

    public function return_wx_pay($value,$db)
    {
            $datetime = date("Y-m-d H:i:s", time());//当前时间
            $user_id = $value->user_id;
            $store_id = $value->store_id;
            $money = explode(',',$value->detailed);
            $total =0;//红包的金额
            foreach ($money as $k => $v) {
                $total += $v;
            }
            //配置信息
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
            if ($r) {
                $appid = $r[0]->appid;
                // 小程序唯一标识
                $appsecret = $r[0]->appsecret;
                // 小程序的 app secret
                $company = $r[0]->company;
                $mch_key = $r[0]->mch_key; 
                // 商户key
                $mch_id = $r[0]->mch_id; 
                // 商户mch_id
            }
            //处理退款
            $wxtk_res = $this->wxrefundapi($value->trade_no, $value->trade_no . $value->r_id, $total * 100, $value->money * 100, $appid, $mch_id, $mch_key);
            if(is_array($wxtk_res)){
                $sql = "select * from lkt_notice where store_id = '$store_id' ";
                $r = $db->select($sql);
                //退款模板
                $template_id = $r ? $r[0]->refund_res:'666';
                //提醒
                $sql_openid = "select wx_id from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
                $res_openid = $db->select($sql_openid);
                $openid = $res_openid[0]->wx_id;
                $froms = $this->get_fromid($openid);
                $form_id = $froms['fromid'];
                $page = 'pages/index/index';
                $text = '红包退款';
                //消息模板id
                $send_id = $template_id;
                $keyword1 = array('value' => $value->trade_no . $value->r_id, "color" => "#173177");
                $keyword2 = array('value' => $company, "color" => "#173177");
                $keyword3 = array('value' => $datetime, "color" => "#173177");
                $keyword4 = array('value' => '退款成功', "color" => "#173177");
                $keyword5 = array('value' => $total . '元', "color" => "#173177");
                $keyword6 = array('value' => $text, "color" => "#173177");
                $keyword7 = array('value' => '系统已还原订单状态', "color" => "#173177");
                //拼成规定的格式
                $o_data = array('keyword1' => $keyword1, 'keyword2' => $keyword2, 'keyword3' => $keyword3, 'keyword4' => $keyword4, 'keyword5' => $keyword5, 'keyword6' => $keyword6, 'keyword7' => $keyword7);

                $res = $this->Send_Prompt($appid, $appsecret, $form_id, $openid, $page, $send_id, $o_data);
                $this->get_fromid($openid, $form_id);
                return true;
            }else{
                return false;
            }


    }

    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $user_id = $this->user_id;

        $sql = "select money from lkt_user where store_id = '$store_id' and user_id = '$user_id' ";
        $r_1 = $db->select($sql);
        if (!empty($r_1[0])) {
            $money = $r_1[0]->money ? $money = $r_1[0]->money : 0;
        } else {
            $money = 0;
        }

        $sql01 = "select * from lkt_red_packet_config where store_id = '$store_id'";
        $r_101 = $db->select($sql01);

        if (!empty($r_101[0])) {
            //随机红包参数
            foreach ($r_101 as $key => $value) {
                $r[$key]['id'] = $value->id;
                $r[$key]['type'] = unserialize($value->rand);
                $res = $r[$key]['type']['use_redpacket'];
                $r[$key]['content'] = $r[$key]['type']['content'];
                if (!empty($res)) {
                    // print_r($res);die;
                    $r[$key]['red'] = explode(',', $res);
                } else {
                    $r[$key]['red'] = '';
                }
            }
            //普通红包参数
            foreach ($r_101 as $k => $v) {
                $r[$k+1]['id'] = $v->id;
                $r[$k+1]['type'] = unserialize($v->ordinary);
                $res = $r[$k+1]['type']['use_redpacket'];
                $r[$k+1]['content'] = $r[$k+1]['type']['content'];
                if(!empty($res)){
                    $r[$k+1]['red'] = explode(',',$res);
                }else{
                    $r[$k+1]['red'] = '';
                }
            }
            echo json_encode(array('r' => $r, 'status' => 1, 'money' => $money));
            exit;

        } else {
            echo json_encode(array('r' => '', 'status' => 2, 'money' => $money));
            exit;
        }
    }

    /**
     * [syn_pay_res description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-15T14:57:23+0800
     * @param   支付异步结果返回 int [description]
     */
    public function syn_pay_res()
    {
        $request = $this->getContext()->getRequest();
        $trade_no = $request->getParameter('trade_no');
        $user_id = $this->user_id;
        $store_id = $this->store_id;
        if(empty($trade_no)){
            echo json_encode(array('code' => 200, 'msg' => '参数缺少' ,'status' => 1));
            exit;
        }

        $lkt_r_sql = "select r_id from lkt_red_packet_send where store_id = '$store_id' and trade_no = '$trade_no' and user_id = '$user_id'";
        $ltes = $this->db->select($lkt_r_sql);

        
        if ($ltes) {
            echo json_encode(array('id' => $ltes[0]->r_id,'status'=>1));
        }else{
            echo "$lkt_r_sql";
            echo json_encode(array('status'=>0,'err'=>'支付失败'));
        }
        exit;
    }

    public function red_packet_send()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $user_id = $this->user_id;//用户
        $money = $request->getParameter('money');//金额
        $num = $request->getParameter('num');//数量
        $show = $request->getParameter('show');//1.随机红包  2. 普通红包
        $paytype = $request->getParameter('paytype');//支付类型 wallet_Pay 钱包支付  wxPay  微信支付
        $remarks = $request->getParameter('remarks') ? $request->getParameter('remarks') : "恭喜发财 大吉大利";//备注



        $sql001 = "select user_id,money from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
        $r001 = $db->select($sql001);//本人
        if($r001){

            $user_id001 = $r001[0]->user_id;
            $money001 = $r001[0]->money;
            $pay_money = $money;
            if ($show == 2) {
                $pay_money = $money*$num;
            }
            $pay_money = -$pay_money;
            $sql01 = "update lkt_user set money = money + $pay_money where store_id = '$store_id' and user_id = '$user_id' and money >0 ";
            $r01 = $db->update($sql01);//钱包支付 修改余额
            if(!$r01){
                echo json_encode(array('id' => false,'status'=>0));exit;
            }


            $date_time = date('Y-m-d H:i:s', time());
            $sql0002 = "insert into lkt_record (store_id,user_id,money,oldmoney,add_date,event,type) values ('$store_id','$user_id001','$pay_money','$money001','$date_time','发红包','25')";//
            $r0002 = $db->insert($sql0002);


            //现在时间
            $datetime = date('Y-m-d H:i:s', time());
            if ($show == 2) {
                $tes = $this->putong_redpacket($money,$num);
            } else {
                $tes = $this->redpacket($money, $num);
            }
            if (!empty($tes)) {
                $red = implode(',', $tes);
            } else {
                $red = '';
            }

            $sql01 = "select * from lkt_red_packet_config where store_id = '$store_id'";//红包参数
            $r_1 = $db->select($sql01);
            if (!empty($r_1)) {
                $ordinary = unserialize($r_1[0]->ordinary);
                $rand = unserialize($r_1[0]->rand);
            }else{
                $ordinary['shixiao_time']=$rand['shixiao_time']=24;
            }
            //红包类型决定失效时间
            $type = $show;
            $shixiao_time = $type > 1 ? $ordinary['shixiao_time']:$rand['shixiao_time'];

            $dd = date("Y-m-d H:i:s", strtotime($datetime) + $shixiao_time * 3600);

            $sql = "insert into lkt_red_packet_send(store_id,user_id,money,num,remarks,time,detailed,type,expire_date) " .
                "values('$store_id','$user_id','$money','$num','$remarks','$datetime','$red','$show','$dd')";
            $packet_send_id = $db->insert($sql, 'last_insert_id');


            $status = $packet_send_id > 0 ? 1:0;
            echo json_encode(array('id' => $packet_send_id,'status'=>$status));
            exit;
        }else{
            echo json_encode(array('id' => false,'status'=>0));exit;
        }
    }

    function putong_redpacket($money, $num)
    {//普通红包
        $total = $money;//总金额
        $min = 0.01;//单个红包最小金额数
        $res = array();
        for ($i = 1; $i <= $num; $i++) {
            $res[] = $total;
        }
        $res[] = $total;
        return $res;
    }

    function redpacket($money, $num)
    {
        //添加红包信息时随机获取每个红包的金额
        $total = $money;//总金额
        $min = 0.01;//单个红包最小金额数
        $res = array();
        for ($i = 1; $i < $num; $i++) {
            $safe_total = ($total - ($num - $i) * $min) / ($num - $i);//随机安全上限
            $money = mt_rand($min * 100, $safe_total * 100) / 100;
            $res[] = $money;
            $total = $total - $money;
        }
        $res[] = $total;
        return $res;
    }

    public function red_packet_show()
    {//红包显示
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $datetime = date("Y-m-d H:i:s", time());//当前时间
        $user_id = $this->user_id; // 本人微信id
        $id = $request->getParameter('id'); // 红包ID
        $money = '0';

        $sql = "select a.*,b.headimgurl,b.user_name from lkt_red_packet_send as a,lkt_user as b where a.store_id = '$store_id' and a.user_id = b.user_id and r_id = '$id'";//查询红包信息
        $r_1 = $db->select($sql);
        if (!empty($r_1)) {

            if ($r_1[0]->user_id == $user_id) {//判断该用户为发红包的用户，直接查询其他抢红包的红包之和
                $sql03 = "select sum(money) as a from lkt_red_packet_detailed where store_id = '$store_id' and r_id = '$id'";
                $a = $db->select($sql03);
                if (!empty($a[0]->a)) {
                    $money = $a[0]->a;
                } else {
                    $money = '0';
                }
                $status = 2;//未失效
            } else {
                // var_dump($datetime,$r_1[0]->expire_date);
                if ($datetime > $r_1[0]->expire_date) {//红包过期
                    $status = 1;//失效
                    $money = '';
                } else {
                    $sql02 = "select money from lkt_red_packet_detailed where store_id = '$store_id' and r_id = '$id' and user_id = '$user_id'";//查询领取该红包的人的详细信息
                    $r_102 = $db->select($sql02);


                    if (!empty($r_102)) {
                        $money = $r_102[0]->money;
                    } else {
                        $money = '';
                    }

                    $status = 2;//未失效
                }

            }
        } else {
            $r_1 = 1;
            $status = 3;//未失效
        }


        $sql01 = "select a.*,b.headimgurl,b.user_name from lkt_red_packet_detailed as a ,lkt_user as b where a.store_id = '$store_id' and a.user_id = b.user_id and r_id = '$id'";//查询领取该红包的人的详细信息
        $r_101 = $db->select($sql01);
        if (!empty($r_101)) {
            $r_101 = $r_101;
        } else {
            $r_101 = 1;
        }
        $r_1001 = $db->selectrow($sql01);

        echo json_encode(array('money' => $money, 'r_1' => $r_1, 'r_101' => $r_101, 'num' => $r_1001, 'status' => $status));
        exit;

    }

    public function send()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $user_id = $this->user_id; // 本人微信id

        $sql = "select a.*,b.headimgurl,b.user_name,b.money as total from lkt_red_packet_send as a,lkt_user as b where a.store_id = '$store_id' and a.user_id = b.user_id and a.user_id = '$user_id' order by a.time desc";//查询红包信息

        $r_1 = $db->select($sql);
        if (!empty($r_1[0]->total)) {
            $total = $r_1[0]->total;
        } else {
            $total = 0;//钱包余额
        }

        $conmoney = 0;
        $num01 = 0;
        if (!empty($r_1)) {
            foreach ($r_1 as $key => $value) {
                $r_id = $value->r_id;
                $money = $value->money;
                $show = $value->type ? $value->type : 1;//随机红包类型
                $datetime = date("Y-m-d H:i:s", time());//当前时间
                $ddtime = $value->expire_date;
                //var_dump($datetime,$ddtime,($datetime >= $ddtime));

                if ($datetime <= $ddtime) {
                    $r_1[$key]->type01 = '1';//有效时间

                } else {
                    $r_1[$key]->type01 = '2';//过期时间
                }

                $sql01 = "select a.*,b.headimgurl,b.user_name from lkt_red_packet_detailed as a ,lkt_user as b where a.store_id = '$store_id' and a.user_id = b.user_id and r_id = '$r_id'";//查询领取该红包的人的详细信息
                // $r_101 = $db->select($sql01);
                $num = $db->selectrow($sql01);
                $r_1[$key]->num1 = $num;
                $sql001 = "select sum(money)as a from lkt_red_packet_detailed where store_id = '$store_id' and r_id = '$r_id' and user_id !='$user_id'";
                $total01 = $db->select($sql001);
                $tmoney = $total01[0]->a;
                if (!empty($tmoney)) {
                    $mon = $tmoney;
                } else {
                    $mon = 0;
                }
                $sql002 = "select id from lkt_red_packet_detailed where store_id = '$store_id' and r_id = '$r_id' and user_id !='$user_id'";
                $num02 = $db->selectrow($sql002);

                if (!empty($num02)) {
                    $num1 = $num02;
                } else {
                    $num1 = 0;
                }

                $conmoney += $mon;
                $num01 += $num1;

                unset($mon);
                unset($num);
                unset($num1);
            }
        }

        echo json_encode(array('money' => $conmoney, 'r_1' => $r_1, 'num' => $num01, 're01' => [], 'total' => $total));
        exit;
    }

    public function received()
    {
        //收到红包
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $user_id = $this->user_id; // 本人微信id
        $sql = "select a.* ,b.remarks,b.user_id as user_id1 from lkt_red_packet_detailed as a,lkt_red_packet_send as b where a.store_id = '$store_id' and a.r_id = b.r_id and a.user_id = '$user_id' order by time desc";
        $r = $db->select($sql);
        $num = $db->selectrow($sql);


        $conmoney = 0;

        if (!empty($r)) {
            foreach ($r as $key => $value) {
                $user_id1 = $value->user_id1;
                $time = $value->time;
                $money01 = $value->money;
                $sql = "select headimgurl from lkt_user where store_id = '$store_id' and user_id='$user_id1'";
                $re = $db->select($sql);
                $r[$key]->headimgurl = $re[0]->headimgurl;
                $conmoney += $money01;
                unset($money01);
                $r[$key]->type2 = 1;
            }
        }


        echo json_encode(array('money' => $conmoney, 'r_1' => $r, 'num' => $num));
        exit;

    }

    //拆红包
    public function red_packet_open()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //开启事务
        $db->begin();
        $store_id = trim($request->getParameter('store_id'));

        $user_id = $this->user_id; // 本人微信id
        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id;
            $umoney = $r[0]->money;
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        $id = $request->getParameter('id'); // 红包ID
        //现在时间
        $datetime = date('Y-m-d H:i:s', time());

        $sql_w = "select * from lkt_red_packet_detailed  where store_id = '$store_id' and r_id = '$id' and user_id ='$user_id'";//查询用户是否领过该红包
        $r_w = $db->select($sql_w);
        if (!empty($r_w)) {
            $db->rollback();
            echo json_encode(array('total' => '已经领过该红包了', 'status' => 3));
            exit;
        } else {
            $sql = "select * from lkt_red_packet_send  where store_id = '$store_id' and r_id = '$id' for update";//查询红包信息
            $r_1 = $db->select($sql);
            if (!empty($r_1)) {
                $version = $r_1[0]->version;
                $money = $r_1[0]->detailed;
                $user_id1 = $r_1[0]->user_id;
                $re = explode(',', $money);
                $total = $re[0];//拆红包的金额
                if ($total && $total > 0) {
                    unset($re[0]);
                    $red = implode(',', $re);
                    $sql01 = "update lkt_red_packet_send set detailed = '$red',version = version+1 where store_id = '$store_id' and r_id = '$id' and version = '$version' ";
                    $r01 = $db->update($sql01);//修改原来红包的数量，清除数据
                    if (!$r01) {
                        $db->rollback();
                        echo json_encode(array('total' => '', 'status' => 2));
                        exit;
                    }
                    $sql02 = "insert into lkt_red_packet_detailed(store_id,r_id,user_id,money,time)values('$store_id','$id','$user_id','$total','$datetime')";
                    //添加信息到红包信息表里
                    $re = $db->insert($sql02);
                    if (!$re) {
                        $db->rollback();
                        echo json_encode(array('total' => '', 'status' => 2));
                        exit;
                    }
                    $sql = "update lkt_user set money = money+'$total' where store_id = '$store_id' and user_id = '$user_id'";//修改钱包金额
                    $beres = $db->update($sql);
                    if (!$beres) {
                        $db->rollback();
                        echo json_encode(array('total' => '', 'status' => 2));
                        exit;
                    }
                    $event = $user_id . '获得了' . $total . '元红包';
                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$total','$umoney','$event',6)";
                    $beres1 = $db->insert($sqll);

                    if (!$beres1) {
                        $db->rollback();
                        echo json_encode(array('total' => '', 'status' => 2));
                        exit;
                    }
                    $db->commit();
                    echo json_encode(array('total' => $total, 'status' => 1));
                    exit;
                } else {
                    $db->commit();
                    echo json_encode(array('total' => '', 'status' => 2));
                    exit;
                }

            } else {
                $db->commit();
                echo json_encode(array('total' => '', 'status' => 2));
                exit;
            }
        }

    }

    public function order_data()
    {//临时储存微信支付数据

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $data['store_id'] = $this->store_id;
        $trade_no = $request->getParameter('trade_no');//微信订单号
        $data['trade_no'] = $trade_no;
        $data['user_id'] = $this->user_id;//user_id
        $data['money'] = $request->getParameter('money');//金额
        $data['num'] = $request->getParameter('num');//数量
        $data['show'] = $request->getParameter('show');//1.随机红包  2. 普通红包
        $data['paytype'] = $request->getParameter('paytype');//支付类型 wallet_Pay 钱包支付  wxPay  微信支付
        $data['remarks'] = $request->getParameter('remarks') ? $request->getParameter('remarks') : "恭喜发财 大吉大利";//备注
        //现在时间
        $datetime = date('Y-m-d H:i:s', time());
        $info = serialize($data);
        $sql = "insert into lkt_order_data (trade_no,data,addtime) values ('$trade_no','$info','$datetime')";//
        $re = $db->insert($sql);

        echo json_encode(array('re' => $re));
        exit;

    }






    public function Send_Prompt($appid, $appsecret, $form_id, $openid, $page, $send_id, $o_data)
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $AccessToken = $this->getAccessToken($appid, $appsecret);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;
        $data = json_encode(array('access_token' => $AccessToken, 'touser' => $openid, 'template_id' => $send_id, 'form_id' => $form_id, 'page' => $page, 'data' => $o_data));
        $da = $this->httpsRequest($url, $data);
        return $da;
    }

    public function get_fromid($openid, $type = '')
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        if (empty($type)) {
            $fromidsql = "select fromid,open_id from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and id=(select max(id) from lkt_user_fromid where store_id = '$store_id' and open_id='$openid')";
            $fromidres = $db->select($fromidsql);
            if ($fromidres) {
                $fromid = $fromidres[0]->fromid;
                $arrayName = array('openid' => $openid, 'fromid' => $fromid);
                return $arrayName;
            } else {
                return array('openid' => $openid, 'fromid' => '123456');
            }
        } else {
            $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and fromid='$type'";
            $re2 = $db->delete($delsql);
            return $re2;
        }

    }

    function httpsRequest($url, $data = null)
    {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if (!empty($data)) {
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

    function getAccessToken($appID, $appSerect)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appSerect;
        // 时效性7200秒实现
        // 1.当前时间戳
        $currentTime = time();
        // 2.修改文件时间
        $fileName = "accessToken";
        // 文件名
        if (is_file($fileName)) {
            $modifyTime = filemtime($fileName);
            if (($currentTime - $modifyTime) < 7200) {
                // 可用, 直接读取文件的内容
                $accessToken = file_get_contents($fileName);
                return $accessToken;
            }
        }
        // 重新发送请求
        $result = $this->httpsRequest($url);
        $jsonArray = json_decode($result, true);
        // 写入文件
        $accessToken = $jsonArray['access_token'];
        file_put_contents($fileName, $accessToken);
        return $accessToken;
    }

    /*
     * 发送请求
     @param $ordersNo string 订单号　
     @param $refund string 退款单号
     @param $price float 退款金额
     return array
     */
    private function wxrefundapi($ordersNo, $refund, $total_fee, $price, $appid, $mch_id, $mch_key)
    {
        //通过微信api进行退款流程

        require_once(MO_LIB_DIR . '/WxPayPubHelper/'.$mch_id.'_WxPay.pub.config.php');
        $this->SSLCERT_PATH = WxPayConf_pub::SSLCERT_PATH;
        $this->SSLKEY_PATH = WxPayConf_pub::SSLKEY_PATH;
        $this->APPID = WxPayConf_pub::APPID;
        $this->MCHID = WxPayConf_pub::MCHID;
        $this->APPSECRET = WxPayConf_pub::APPSECRET;
        $this->KEY = WxPayConf_pub::KEY;

        $parma = array('appid' => $appid, 'mch_id' => $mch_id, 'nonce_str' => $this->createNoncestr(), 'out_refund_no' => $refund, 'out_trade_no' => $ordersNo, 'total_fee' => $total_fee, 'refund_fee' => $price, 'op_user_id' => $appid);
        $parma['sign'] = $this->getSign($parma, $mch_key);
        $xmldata = $this->arrayToXml($parma);
        $xmlresult = $this->postXmlSSLCurl($xmldata, 'https://api.mch.weixin.qq.com/secapi/pay/refund');
        $result = $this->xmlToArray($xmlresult);
        return $result;
    }

    /*
     * 生成随机字符串方法
     */
    protected function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /*
     * 对要发送到微信统一下单接口的数据进行签名
     */
    protected function getSign($Obj, $mch_key)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . $mch_key;
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }

    /*
     *排序并格式化参数方法，签名时需要使用
     */
    protected function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            //$buff .= strtolower($k) . "=" . $v . "&";
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }

    //数组转字符串方法
    protected function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }

    protected function xmlToArray($xml)
    {
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

    //需要使用证书的请求
    private function postXmlSSLCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, $this->SSLCERT_PATH);
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, $this->SSLKEY_PATH);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error" . "<br>";
            curl_close($ch);
            return false;
        }
    }









}

?>