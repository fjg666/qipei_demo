

<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/sign_pluginAction.class.php');
require_once(MO_LIB_DIR . '/coupon_pluginAction.class.php');
require_once('Apimiddle.class.php');

class appAction extends Action
{

    public $config = '';
    public $img = '';

    public function getDefaultView()
    {
        return;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        // 查询小程序配置
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);

        if ($r) {
            $this->config = $r[0];
            $uploadImg_domain = $r[0]->uploadImg_domain; // 图片上传域名
            $uploadImg = $r[0]->uploadImg; // 图片上传位置
            if (strpos($uploadImg, './') === false) { // 判断字符串是否存在 ../
                $img = $uploadImg_domain . $uploadImg; // 图片路径
            } else {
                $img = $uploadImg_domain . substr($uploadImg, 1); // 图片路径
            }
            $this->img = $img;
        } else {
            $this->config = false;

        }

        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();
        return;
    }

    public function Navbar()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //软件类型
        $store_type = trim($request->getParameter('store_type')) ? trim($request->getParameter('store_type')) : 1;
        //商城id
        $store_id = trim($request->getParameter('store_id')) ? trim($request->getParameter('store_id')) : 1;

        $Nav_bar = new Navbar();

        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'navbar'";
        $Navbar_res = $db->select($sql);

        $Navbar = $Nav_bar->getNavbar($db, $this->img, $Navbar_res);

        $sql_navigation_bar_color = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'navigation_bar_color'";
        $res_navigation_bar_color = $db->select($sql_navigation_bar_color);
        if($res_navigation_bar_color){
            $navigation_bar_color = $res_navigation_bar_color[0]->value;
        }else{
            $navigation_bar_color =  '{"frontColor":"#000000","backgroundColor":"#ffffff","bottomBackgroundColor":"#ffffff"}';
        }
        $navigation_bar_color = json_decode($navigation_bar_color);

        $nav = [];
        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'theme_data'";
        $navs = $db->select($sql);

        if ($navs) {
            $data = unserialize($navs[0]->value);
            foreach ($data as $key => $value) {
                $nav[$key] = (object)$value;
                if($key == 'pages/index/index'){
                    $Navbar->background_image = $value['bottom_img'];
                }
            }
        } else {
            $theme_data = $Nav_bar->mini_program_pages();
            foreach ($theme_data as $key => $value) {
                $arrayName = array('top_img' => '', 'bottom_img' => '', 'title' => $value, 'name' => $value);
                $nav[$key] = (object)$arrayName;
            }
        }

        echo json_encode(array('status' => 1, 'data' => $Navbar, 'theme' => $nav,'navigation_bar_color'=>$navigation_bar_color));
        exit();
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    // 获取用户会话密钥
    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        // 获取临时凭证
        $code = $_POST['code'];

        // 查询小程序配置
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $appid = $r[0]->appid; // 小程序唯一标识
            $appsecret = $r[0]->appsecret; // 小程序的 app secret
        }else{
            $appid = ''; // 小程序唯一标识
            $appsecret = ''; // 小程序的 app secret
        }
        if (!$code) {
            echo json_encode(array('status' => 0, 'err' => '非法操作！'));
            exit();
        }
        if (!$appid || !$appsecret) {
            echo json_encode(array('status' => 0, 'err' => '非法操作！'));
            exit();
        }
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $appsecret . '&js_code=' . $code . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $res = curl_exec($ch);
        curl_close($ch);
        $user = (array)json_decode($res);

        $sql = "select * from lkt_background_color where store_id = '$store_id' and status = 1";
        $r = $db->select($sql);
        $user['bgcolor'] = $r ? $r[0]->color:'#FF6347';
        echo json_encode($user);
        exit();
        return;
    }

    //用户信息存储
    public function user()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        $edition = trim($request->getParameter('edition')); // 版本号

        $wxname = $_POST['nickName']; // 微信昵称
        $headimgurl = $_POST['headimgurl']; // 微信头像
        $sex = $_POST['sex']; // 性别
        $openid = $_POST['openid']; // 微信id
        $pid = $_POST['p_openid']; // 推荐人微信id

        // 生成密钥
        $access_token = '';
        $str = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890';
        for ($i = 0; $i < 32; $i++) {
            $access_token .= $str[rand(0, 61)];
        }
        // 判断是否存在推荐人微信id
        if ($pid == '' || $pid == 'undefined') {
            $Referee = false;
        } else {
            if (strlen($pid) == '32') {
                $sql = "select * from lkt_user where store_id = '$store_id' and wx_id = '$pid'";
                $r = $db->select($sql);
                $Referee = $r[0]->user_id;
            } else {
                $Referee = $pid;
            }
        }

        // 根据wxid,查询会员信息
        $sql = "select * from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $rr = $db->select($sql);
        if (!empty($rr)) {
            $sql = "update lkt_user set access_token = '$access_token' where store_id = '$store_id' and wx_id = '$openid'";
            $db->update($sql);
            $user_id = $rr[0]->user_id;

            $sqlu = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
            $resu = $db->select($sqlu);
            if (!$resu) {
                $t_user_id = $Referee;
                if ($t_user_id) {

                    //  2018-09-10 添加防止不是具有分销等级的会员绑定同样不是分销等级的会员关系
                    $qsql = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = '1' ";
                    $qres = $db->select($qsql);
                    //普通等级 id 没有权限进入分销 和绑定关系
                    if ($qres) {
                        $qtid = $qres[0]->id;
                    } else {
                        $qtid = 0;
                    }
                    $sqlc = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$t_user_id' and level != '$qtid' ";
                    $resc = $db->select($sqlc);
                    //-----控制结束

                    //分销推荐
                    if ($resc) {
                        $sqlqw = "select user_id from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
                        $resqw = $db->select($sqlqw);
                        if (!$resqw) {
                            $rt = $resc[0]->rt;
                            $level = $qtid;
                            $uplevel = $resc[0]->uplevel + 1;
                            $ups01 = "update lkt_user_distribution set lt = lt + 2 where store_id = '$store_id' and lt>='$rt'";
                            $ups02 = "update lkt_user_distribution set rt = rt + 2 where store_id = '$store_id' and rt>='$rt'";
                            $lrt = $rt + 1;
                            $ups03 = "INSERT INTO lkt_user_distribution ( `store_id`,`user_id`, `pid`, `level`, `lt`, `rt`, `uplevel`, `add_date`) VALUES ( '$store_id','$user_id', '$t_user_id', '$level', '$rt', '$lrt', '$uplevel', CURRENT_TIMESTAMP)";
                            $db->update($ups01);
                            $db->update($ups02);
                            $db->insert($ups03);
                        }
                    }
                }
            }


            $event = '会员' . $user_id . '登录';
            // 在操作列表里添加一条会员登录信息
            $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
            $r = $db->insert($sql);

            // 查询订单设置表
            $sql = "select * from lkt_order_config where store_id = '$store_id'";
            $r = $db->select($sql);
            $order_overdue = $r ? $r[0]->order_overdue:1; // 未付款订单保留时间
            $unit = $r? $r[0]->unit:1; // 未付款订单保留时间单位
            if ($order_overdue != 0) {
                if ($unit == '天') {
                    $time01 = date("Y-m-d H:i:s", strtotime("-$order_overdue day")); // 订单过期删除时间
                } else {
                    $time01 = date("Y-m-d H:i:s", strtotime("-$order_overdue hour")); // 订单过期删除时间
                }
                // 根据用户id，订单为未付款，订单添加时间 小于 未付款订单保留时间,查询订单表
                $sql = "select * from lkt_order where store_id = '$store_id' and user_id = '$user_id' and status = 0 and add_time < '$time01' ";
                $r_c = $db->select($sql);
                // 有数据，循环查询优惠券id,修改优惠券状态
                if ($r_c) {
                    foreach ($r_c as $key => $value) {
                        $coupon_id = $value->coupon_id;  // 优惠券id
                        if ($coupon_id != 0) {
                            // 根据优惠券id,查询优惠券信息
                            $sql = "select * from lkt_coupon where store_id = '$store_id' and id = '$coupon_id' ";
                            $r_c = $db->select($sql);
                            $expiry_time = $r_c[0]->expiry_time; // 优惠券到期时间
                            $time = date('Y-m-d H:i:s'); // 当前时间
                            if ($expiry_time <= $time) {
                                // 根据优惠券id,修改优惠券状态(已过期)
                                $sql = "update lkt_coupon set type = 3 where store_id = '$store_id' and id = '$coupon_id'";
                                $db->update($sql);
                            } else {
                                // 根据优惠券id,修改优惠券状态(未使用)
                                $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and id = '$coupon_id'";
                                $db->update($sql);
                            }
                        }
                    }
                }
                // 根据用户id、订单未付款、添加时间小于前天时间,就删除订单信息
                $sql01 = "update lkt_order set status = 6 where store_id = '$store_id' and user_id = '$user_id' and status = 0 and add_time < '$time01' ";
                $re01 = $db->update($sql01);
                // 根据用户id、订单未付款、添加时间小于前天时间,就删除订单详情信息
                $sql02 = "update lkt_order_details set r_status = 6 where store_id = '$store_id' and user_id = '$user_id' and r_status = 0 and add_time < '$time01' ";
                $re02 = $db->update($sql02);
            }
        } else {
            // 查询会员列表的最大id
            $sql = "select max(id) as userid from lkt_user where store_id = '$store_id'";
            $r = $db->select($sql);
            $rr = $r[0]->userid;
            $user_id = ($rr + 1);
            // 在会员列表添加一条数据

            // 默认头像和名称
            if (empty($wxname) || $wxname == 'undefined') {
                //设置为lkt_config 中的微信默认名称
                $sql_1 = "select wx_name from lkt_config where store_id = '$store_id'";
                $res_1 = $db->select($sql_1);
                $wxname = $res_1[0]->wx_name;
                $wxname = $wxname ? $wxname : '简单的奇迹';
            }
            if (empty($headimgurl) || $headimgurl == 'undefined') {
                //设置为lkt_config 中的微信默认头像
                $sql_2 = "select wx_headimgurl from lkt_config where store_id = '$store_id'";
                $res_2 = $db->select($sql_2);
                $headimgurl = $res_2[0]->wx_headimgurl;
                $headimgurl = ServerPath::getimgpath($headimgurl);
                $headimgurl = $headimgurl ?$headimgurl : 'https://lg-8tgp2f4w-1252524862.cos.ap-shanghai.myqcloud.com/moren.png';
            }

            if (empty($sex) || $sex == 'undefined') {
                $sex = '0';
            }
            $sql = "insert into lkt_user (store_id,user_id,user_name,headimgurl,wx_name,sex,wx_id,Referee,access_token,img_token,source) values('$store_id','$user_id','$wxname','$headimgurl','$wxname','$sex','$openid','$Referee','$access_token','$access_token',1)";

            $r = $db->insert($sql);

            $sqlu = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
            $resu = $db->select($sqlu);
            if (!$resu) {
                $t_user_id = $Referee;
                if ($t_user_id) {

                    //  2018-09-10 添加防止不是具有分销等级的会员绑定同样不是分销等级的会员关系
                    $qsql = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = '1' ";
                    $qres = $db->select($qsql);
                    //普通等级 id 没有权限进入分销 和绑定关系
                    if ($qres) {
                        $qtid = $qres[0]->id;
                    } else {
                        $qtid = 0;
                    }
                    $sqlc = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$t_user_id' and level != '$qtid' ";
                    $resc = $db->select($sqlc);
                    //-----控制结束

                    //分销推荐
                    if ($resc) {
                        $sqlqw = "select user_id from lkt_user_distribution where store_id = '$store_id' and user_id = '$user_id'";
                        $resqw = $db->select($sqlqw);
                        if (!$resqw) {
                            $rt = $resc[0]->rt;
                            $level = 6;
                            $uplevel = $resc[0]->uplevel + 1;
                            $ups01 = "update lkt_user_distribution set lt = lt + 2 where store_id = '$store_id' and lt>='$rt'";
                            $ups02 = "update lkt_user_distribution set rt = rt + 2 where store_id = '$store_id' and rt>='$rt'";
                            $lrt = $rt + 1;
                            $ups03 = "INSERT INTO lkt_user_distribution ( `store_id`,`user_id`, `pid`, `level`, `lt`, `rt`, `uplevel`, `add_date`) VALUES ( '$store_id','$user_id', '$t_user_id', '$level', '$rt', '$lrt', '$uplevel', CURRENT_TIMESTAMP)";
                            $db->update($ups01);
                            $db->update($ups02);
                            $db->insert($ups03);
                        }

                    }
                }
            }
            //查询首次注册所获积分
            $sql001 = "select jifennum from lkt_software_jifen where store_id = '$store_id'";
            $r_1001 = $db->select($sql001);
            $jifennum = $r_1001 ? $r_1001[0]->jifennum : 0;
            //添加积分到用户表
            if ($jifennum) {
                $sql002 = "update lkt_user set score = score + '$jifennum' where store_id = '$store_id' and user_id = '$user_id'";
                $db->update($sql002);
                // 在积分操作列表里添加一条会员首次登录信息获取积分的信息
                $record = '会员' . $user_id . '首次关注获得积分' . $jifennum;
                $sql = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$jifennum','$record',CURRENT_TIMESTAMP,2)";
                $r = $db->insert($sql);
            }

            $event = '会员' . $user_id . '登录';
            // 在操作列表里添加一条会员登录信息
            $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
            $r = $db->insert($sql);
        }

        $coupon = new coupon_pluginAction();
        $coupon_list = $coupon->give($store_id,$user_id,'start');

        $sign = new sign_pluginAction();
        $sign_arr = $sign->test($store_id,$user_id);

        $sign_status = $sign_arr['sign_status'];
        $is_sign_status = $sign_arr['is_sign_status'];

        $sql = "select * from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $rr = $db->select($sql);
        $nickName = $rr[0]->wx_name;
        $avatarUrl = $rr[0]->headimgurl;
        echo json_encode(array('access_token' => $access_token, 'user_id' => $user_id, 'sign' => true, 'sign_status' => $sign_status, 'is_sign_status' => $is_sign_status, 'nickName' => $nickName, 'avatarUrl' => $avatarUrl,'coupon_list'=>$coupon_list));
        exit();
    }

    public function get_plug()
    {
        header("Content-type: text/html; charset=utf-8");
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));

        // 查询插件表里,状态为启用的插件
        $sql = "select name,image from lkt_plug_ins where store_id = '$store_id' and status = 1 and type = 0 ";
        $r_c = $db->select($sql);

        $coupon = false;
        $wallet = false;
        $integral = false;
        $red_packet = false;
        $pays[0] = array('name' => '微信支付', 'value' => 'wxPay', 'icon' => '../../images/wxzf.png', 'checked' => true);
        $wallet = true;
        $arrayName = array('name' => '钱包支付', 'value' => 'wallet_Pay', 'icon' => '../../images/qbzf.png', 'checked' => false);
        @array_push($pays, $arrayName);
        if ($r_c) {

            foreach ($r_c as $k => $v) {
                if (strpos($v->name, '劵') !== false) {
                    // 判断字符串里是否有 优惠劵
                    $v->name = '优惠劵';
                    $coupon = true;
                }
                // if ($v->name == '钱包') {
                //     $wallet = true;
                //     $arrayName = array('name' => '钱包支付', 'value' => 'wallet_Pay', 'icon' => '../../images/qbzf.png', 'checked' => false);
                //     @array_push($pays, $arrayName);
                // }
                if ($v->name == '签到') {
                    $integral = true;
                }
                if ($v->name == '发红包') {
                    $red_packet = true;
                }
            }

            echo json_encode(array('status' => 1, 'pays' => $pays, 'coupon' => $coupon, 'wallet' => $wallet, 'integral' => $integral, 'red_packet' => $red_packet));
            exit();
        } else {
            echo json_encode(array('status' => 0, 'pays' => $pays, 'coupon' => $coupon, 'wallet' => $wallet, 'integral' => $integral, 'red_packet' => $red_packet));
            exit();
        }
    }

    public function secToTime($times)
    {
        $result = '00:00:00';
        if ($times > 0) {
            $hour = floor($times / 3600);
            $minute = floor(($times - 3600 * $hour) / 60);
            $second = floor((($times - 3600 * $hour) - 60 * $minute) % 60);
            $result = $hour . ':' . $minute . ':' . $second;
        }
        return $result;
    }
}

?>