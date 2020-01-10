<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/Plugin_order.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');



class seckillAction extends Action
{

    public function getDefaultView()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //接受参数
        $store_id = addslashes(trim($request->getParameter('store_id')));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = addslashes(trim($request->getParameter('access_id')));
        $m = addslashes(trim($request->getParameter('m')));
        $m = $m ? $m : 'getDefaultView';

        if (!empty($access_id)) { // 存在
            $getPayload_test = Tools::verifyToken($db, $store_id, $store_type, $access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if ($getPayload_test == false && $m != 'seckillhome' && $m != 'grouphome' && $m != 'getgoodsdetail') { // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }

        //查用户基本信息
        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $res = $db->select($sql);
        if ($res) {
            $user_id = $res[0]->user_id;
            $this->login = true;

        } else {
            $user_id = '';
            $arr = array('seckillhome', 'getgoodsdetail', 'cangroup');
            if (!in_array($m, $arr)) {
                echo json_encode(array('code' => 0, 'msg' => '参数缺少1！', 'status' => 1));
                exit;
            } else {
                $this->login = false;
            }
        }

        //增加该类中的公共属性，调用到各方法
        $this->db = $db;
        $this->request = $request;
        $this->store_id = $store_id;
        $this->user_id = $user_id;
        $this->access_id = $access_id;

        $this->$m();
        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    /**
     * 秒杀首页列表数据
     */
    public function seckillhome()
    {
        $db = $this->db;
        $request = $this->request;
        $store_id = $this->store_id;

        $paegr = trim($request->getParameter('page')); //  '页面'
        $id = trim($request->getParameter('id')); //时段id
        $access_id = trim($request->getParameter('access_id')); //时段id
        $type = trim($request->getParameter('type')); //  '类型' 0过期 1进行中 2即将开始 3明日预告

        if (!$paegr) {
            $paegr = 1;
        }
        $start = ($paegr - 1) * 10;
        $end = $paegr * 10;

        $islogin = 0;
        $user_id = '';

        $sel_group_cfg = "select * from lkt_seconds_config where store_id = $store_id";
        $group_cfg = $db->select($sel_group_cfg);

        //查询秒杀规则
        $rule = '';
        if (!empty($group_cfg)) {
            $rule = $group_cfg[0]->rule;
        }


        $sel_user = "SELECT * FROM lkt_user WHERE store_id = 1 and access_id ='$access_id'";
        $user_res = $db->select($sel_user);

        if (!empty($user_res)) {
            $islogin = 1;
            $user_id = $user_res[0]->user_id;
        }

        $wherestr = "";

        //获取现在日期
        $now_datetime = date('Y-m-d H:i:s', time());
        //获取比较日期
        $now_datetime_arr = explode(' ', $now_datetime);//当前时间
        $tomorrow_datetime_arr = explode(' ', $now_datetime);//明日时间
        $date = $now_datetime_arr[0] . ' 00:00:00';
        $tomorrow_date = $tomorrow_datetime_arr[0] . ' 00:00:00';
        $time = '1970-01-01 ' . $now_datetime_arr[1];
        if ($id == '') {
            //现在进行中的
            $wherestr = "and sa.starttime <= '$date' and sa.endtime >= '$date'
            and st.starttime <= '$time' and st.endtime > '$time'";
        } else if ($id == '-1') {
            $wherestr = "and sa.starttime <= '$tomorrow_date' and sa.endtime > '$tomorrow_date'";
        } else {
            $wherestr = "and sa.starttime <= '$date' and sa.endtime >= '$date'
            and  st.id = $id";
        }

        //查询是否有进行中的活动，如果没有则不查询时段数据
        $sel_actvt_sql = "SELECT * FROM `lkt_seconds_activity` WHERE 1 and store_id = $store_id and is_delete = 0 and status = 2";
        $actvt_res = $db->select($sel_actvt_sql);

        $sql = "select sp.* ,st.starttime,st.endtime
            from lkt_seconds_pro as sp
            LEFT JOIN lkt_seconds_activity as sa on sp.activity_id = sa.id
            LEFT JOIN lkt_seconds_time as st on sp.time_id = st.id
            where sp.store_id = 1 and sp.store_id = 1 and st.store_id = 1 $wherestr and sp.is_show = 1 and sp.is_delete = 0 and st.is_delete = 0 and sa.is_delete = 0 order by sp.num desc";
        $res = $db->select($sql);

        if (!empty($actvt_res)) {
            //查询所有时段
            $sel_time_sql = "SELECT * FROM `lkt_seconds_time` WHERE 1 and store_id = $store_id and is_delete = 0 ORDER BY starttime";
            $time_res = $db->select($sel_time_sql);
            if (!empty($time_res)) {
                foreach ($time_res as $k => $v) {
                    $start = explode(' ', $v->starttime);
                    $end = explode(' ', $v->endtime);
                    if (strtotime($time) > strtotime($v->endtime)) {
                        $v->type = 0;
                    } else if (strtotime($time) < strtotime($v->starttime)) {
                        $v->type = 2;
                    } else {
                        $v->type = 1;
                    }
                    $v->starttime = $start[1];
                    $v->endtime = $end[1];
                    $title = explode(':', $start[1]);
                    $v->title = $title[0] . ':' . $title[1];
                }
            } else {
                echo json_encode(array('code' => 500, 'list' => array(), 'msg' => '异常错误！'));
                exit;
            }
        } else {
            $time_res = array();
        }


        //判断是否有秒杀商品
        if (!empty($res)) {
            //如果有
            foreach ($res as $k => $v) {
                //查询出活动结束时间
                $activity_start = $v->starttime;
                $activity_end = $v->endtime;
                $activity_id = $res[0]->activity_id;
                $time_id = $res[0]->time_id;
                $pro_id = $res[0]->pro_id;
                $now_datetime = date("Y-m-d H:i:s", time());
                $now_datetime_ = explode(' ', $now_datetime);
                $now_datetime = '1970-01-01 ' . $now_datetime_[1];
                $now_timet = strtotime($now_datetime);
                $start_timet = strtotime($activity_start);
                $end_timet = strtotime($activity_end);
                $v->lefttime = $end_timet - $now_timet;
                $v->totaltime = $end_timet - $start_timet;
                if ($id == -1) {
                    $v->lefttime = $start_timet - $now_timet + 3600 * 24;

                    if ($islogin) {
                        $sel_setremind_sql = "SELECT * from lkt_seconds_remind where store_id = $store_id and user_id = '$user_id' and activity_id = $activity_id and time_id = $time_id and pro_id = $pro_id";
                        $setremind_res = $db->select($sel_setremind_sql);
                        if (!empty($setremind_res)) {
                            $v->setremind = 1;
                        } else {
                            $v->setremind = 0;
                        }
                    } else {
                        $v->setremind = 0;
                    }

                    $v->type = 3;
                } else {
                    if ($now_timet < $start_timet) {
                        $v->type = 2;
                        $v->lefttime = $start_timet - $now_timet;
                    } else if ($now_timet > $end_timet) {
                        $v->type = 0;
                    } else {
                        $v->lefttime = $end_timet - $now_timet;
                        $v->type = 1;
                    }
                }

                //查询商品价格，名字
                $sel_sql = "SELECT pl.product_title , pl.imgurl,c.* 
                            from lkt_product_list as pl 
                            LEFT JOIN lkt_configure as c on c.pid = pl.id
                            where 1 and pl.store_id = $store_id and pid = $v->pro_id
                            group by c.pid
                            ORDER by c.price";
                $pro_res = $db->select($sel_sql);
                if (!empty($pro_res)) {
                    $v->product_title = $pro_res[0]->product_title;
                    $v->price = $pro_res[0]->price;
                    $v->imgurl = ServerPath::getimgpath($pro_res[0]->imgurl);

                }
            }

            echo json_encode(array('code' => 200, 'list' => $res, 'rule' => $rule, 'time_list' => $time_res, 'msg' => '成功！'));
            exit;
        } else {
            //没有秒杀商品
            $res = array();
            echo json_encode(array('code' => 200, 'list' => array(), 'rule' => $rule, 'time_list' => $time_res, 'msg' => '没有设置秒杀商品！'));
            exit;
        }
    }

    /*
     *  查询订单
     */
    public function seckillorder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $userid = $this->user_id;
        // 获取信息

        $order_type = addslashes(trim($request->getParameter('order_type'))); // 类型
        $page = intval(trim($request->getParameter('page'))); // 页数
        $page--;
        $start = $page * 10;


        $sql = "select od.p_id,od.sid,a.id,z_price,sNo,a.add_time,status,delivery_status,otype ,a.offset_balance,a.otype,a.pid,a.mch_id
                from lkt_order as a 
                LEFT JOIN lkt_order_details as od on a.sNo = od.r_sNo
                where a.store_id = '$store_id' and a.status <> 7 and a.user_id = '$userid' and otype='MS'
                GROUP by a.id
                order by status 
                LIMIT $start,10";
        $r = $db->select($sql);
        if ($r) {
            $time = date('Y-m-d H:i:s');
            $i = 0;
            foreach ($r as $k => $v) {
                $rew = array();
                $rew['id'] = $v->id; // 订单id
                $rew['z_price'] = $v->z_price; // 订单价格
                $rew['sNo'] = $v->sNo; // 订单号
                $sNo = $v->sNo; // 订单号
                $rew['add_time'] = $v->add_time; // 订单时间
                $rew['status'] = $v->status; // 订单状态
                $rew['otype'] = $v->otype; //订单类型
                $rew['offset_balance'] = $v->offset_balance; //余额支付
                $rew['delivery_status'] = $v->delivery_status; // 提醒状态
                $rew['z_price'] = $v->z_price;
                $mch_id = $v->mch_id;

                if ($v->z_price != $v->offset_balance) {
                    $rew['z_price'] = $v->z_price + $v->offset_balance;
                }

                if (!empty($mch_id)) {
                    $mch_id_ = substr($mch_id, 1, strlen($mch_id) - 2);
                    $sql0 = "select id,name,logo from lkt_mch where store_id = '$store_id' and (id = '$mch_id_' or id = '$mch_id')";
                    $r0 = $db->select($sql0);
                    if ($r0) {
                        $rew['shop_id'] = $r0[0]->id;
                        $rew['shop_name'] = $r0[0]->name;
                        $rew['shop_logo'] = ServerPath::getimgpath($r0[0]->logo);
                    } else {
                        $rew['shop_id'] = 0;
                        $rew['shop_name'] = '';
                        $rew['shop_logo'] = '';
                    }
                } else {
                    $rew['shop_id'] = 0;
                    $rew['shop_name'] = '';
                    $rew['shop_logo'] = '';
                }

                $rew['refund'] = true;

                // 根据订单号,查询订单详情
                $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' and r_status <> 7";
                $rew['list'] = $db->select($sql);
                $z_freight = 0;
                foreach ($rew['list'] as $kk => $vv) {
                    $freight = $vv->freight;
                    $z_freight += $freight;
                }
                $rew['z_freight'] = $z_freight;
                $sqlsum = "select sum(num) as sum from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' and r_status <> 7";
                $sum23 = $db->select($sqlsum);

                $rew['sum'] = $sum23[0]->sum;
                unset($product);
                $product = array();

                if ($rew['list'] && !empty($rew['list'])) {
                    foreach ($rew['list'] as $key => $values) {
                        $size = $values->size;
                        $size = explode(' ', $size);
                        $size = implode(';', $size);
                        $size = ltrim($size, ";");
                        $values->size = $size;
                        $rew['pro_id'] = $values->p_id;
                        $p_id = $values->p_id; // 产品id
                        $values->attribute_id = $values->sid; // 属性id
                        $arr = (array)$values;
                        // 根据产品id,查询产品列表 (产品图片)
                        $sql = "select imgurl from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                        $rrr = $db->select($sql);
                        if ($rrr) {
                            $img_res = $rrr['0']->imgurl;
                            $url = ServerPath::getimgpath($img_res); // 拼图片路径
                            $arr['imgurl'] = $url;
                            $product[$key] = (object)$arr;
                        }
                    }
                    $rew['list'] = $product;
                    if ($v->status == '0') {
                        //如果是秒杀未付款的订单，进入判断
                    }
                }
                $order[] = $rew;
            }
        } else {
            $order = '';
        }
        echo json_encode(array('code' => 200, 'order' => $order, 'message' => '操作成功'));
        exit();
    }

    /**
     * 设置提醒
     */
    public function setremind()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $pro_id = trim($request->getParameter('pro_id')); // 获取商品id
        $activity_id = trim($request->getParameter('activity_id')); //活动id
        $time_id = trim($request->getParameter('time_id')); //时段id
        $type = trim($request->getParameter('type')); //设置提醒 1设置 0取消提醒
        $lktlog = new LaiKeLogUtils("app/seckill.log");

        $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if ($r) { // 是会员
            $user_id = $r[0]->user_id; // 用户id
            $time = date('Y-m-d 00:00:00', time());
            if ($type == 1) {
                //添加记录
                $ist_sql = "INSERT INTO `lkt_seconds_remind`(`store_id`, `user_id`, `is_remind`, `activity_id`, `time_id`, `pro_id`, `add_time`) VALUES ($store_id,'$user_id',1,$activity_id,$time_id,$pro_id,'$time')";
                $res = $db->insert($ist_sql);
                if ($res < 1) {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."添加秒杀提醒失败！sql:".$ist_sql);
                    $ret['code'] = 500;
                    $ret['message'] = "添加提醒失败！";
                } else {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."添加秒杀提醒成功！");
                    $ret['code'] = 200;
                    $ret['message'] = "添加提醒成功！";
                }
            } else {
                //删除记录
                $ist_sql = "DELETE FROM `lkt_seconds_remind` WHERE store_id = $store_id and user_id = '$user_id' and activity_id = $activity_id and time_id = $time_id and pro_id = $pro_id";
                $res = $db->delete($ist_sql);
                if ($res < 1) {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."取消秒杀提醒失败！sql:".$ist_sql);
                    $ret['code'] = 500;
                    $ret['message'] = "取消提醒失败！";
                } else {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."取消秒杀提醒成功！");
                    $ret['code'] = 200;
                    $ret['message'] = "取消提醒成功！";
                }
            }

        } else {
            $ret['code'] = 404;
            $ret['message'] = "未登录！";
        }
        echo json_encode($ret);
        exit;

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

    /**
     * 数组根据字段排序
     * @param $arr
     * @param $keys
     * @param string $type
     * @return array
     */
    function array_sort($arr, $keys, $type = 'desc')
    {
        $key_value = $new_array = array();
        foreach ($arr as $k => $v) {
            $key_value[$k] = $v[$keys];
        }
        if ($type == 'asc') {
            asort($key_value);
        } else {
            arsort($key_value);
        }
        reset($key_value);
        foreach ($key_value as $k => $v) {
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
}

?>