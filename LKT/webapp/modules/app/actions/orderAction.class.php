<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/freightAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/coupon_pluginAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Commission.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');
require_once(MO_LIB_DIR . '/Plugin/subtraction.class.php');
require_once(MO_LIB_DIR . '/Plugin/mch.class.php');
require_once(MO_LIB_DIR . '/third/logistics/LogisticsTool.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/Plugin_order.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');


class orderAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        //app指向具体操作方法
        $app = trim($request->getParameter('app')) ? addslashes(trim($request->getParameter('app'))) : '';
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))) : '';

        $access_id = addslashes(trim($request->getParameter('access_id'))); // 授权id
        $openid = addslashes(trim($request->getParameter('openid'))); // openid
        $store_type = addslashes(trim($request->getParameter('store_type')));
        $store_id = addslashes(trim($request->getParameter('store_id')));

        // 查询会员信息
        $sql = "select * from lkt_user where access_id = '$access_id' and store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $this->db = $db;
            $this->user = $r[0];
            $this->store_id = $store_id;
            $this->user_money = $r[0]->money;
            $this->user_score = $r[0]->score;
            if ($app) {
                $this->$app();
            } else {
                $this->$m();
            }
        } else {
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
        exit;
    }

    public function execute()
    {
        $this->getDefaultView();
    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }

    public function Settlement()
    {
        //1.列出基础数据
        $db = $this->db;
        $request = $this->getContext()->getRequest();
        $user = $this->user;
        $user_id = $user->user_id;
        $store_id = $this->store_id;
        $product1 = addslashes($request->getParameter('product'));//  商品数组--------['pid'=>66,'cid'=>88]
        $cart_id = addslashes(trim($request->getParameter('cart_id')));  //购物车id-- 12,13,123,
        $address_id = $request->getParameter('address_id'); //  地址id
        $shop_address_id = $request->getParameter('shop_address_id'); //  门店地址id
        $product_type = addslashes($request->getParameter('product_type'));//产品类型，JP-竞拍商品,KJ-砍价商品
        $grade_l = addslashes($request->getParameter('grade_l'));//会员特惠 兑换券级别
        $auction_id = addslashes($request->getParameter('auction_id'));//竞拍商品id
        $bargain_id = addslashes($request->getParameter('bargain_id'));//砍价商品id
        $canshu = addslashes($request->getParameter('canshu'));//参数
        $lktlog = new LaiKeLogUtils("app/order.log");

        $product = '';
        $shop_list = array();
        if ($product1 != '') {
            $product1 = htmlspecialchars_decode($product1);
            $product2 = json_decode($product1); // 字符串打散为数组
            foreach ($product2 as $k => $v) {
                foreach ($v as $ke => $va) {
                    $product3[$ke] = $va;
                }
            }
            $product = implode(',', $product3);
            $cart_id = '';
        }

        $products_total = 0;

        // 支付状态
        $payment = Tools::getPayment($db,$store_id);

        //用户基本信息
        $user_money = $user->money; // 用户余额
        $user_score = $user->score; // 用户积分
        $user_password = $user->password; // 支付密码
        $login_num = $user->login_num; // 支付密码错误次数
        $verification_time = $user->verification_time; // 支付密码验证时间
        $verification_time = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($verification_time)));
        $time = date('Y-m-d H:i:s', time());

        if ($login_num == 5) {
            if ($time < $verification_time) {
                $enterless = false;
            } else {
                $sql = "update lkt_user set login_num = 0 where store_id = '$store_id' and user_id = '$user_id'";
                $r = $db->update($sql);
                if($r < 1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户信息失败！sql:".$sql);
                }
                $enterless = true;
            }
        } else {
            $enterless = true;
        }
        if ($user_password != '') {
            $password_status = 1;
        } else {
            $password_status = 0;
        }
        if ($product_type == 'JP') {//竞拍商品，确认订单方式
            $plugin_order = new Plugin_order($store_id);
            $res_arr = $plugin_order->JP_setment($store_id, $auction_id, $user_id, $address_id);
            $res_arr['user_money'] = $user_money;
            $res_arr['password_status'] = $password_status;
            $res_arr['enterless'] = $enterless;
            echo json_encode($res_arr);
            exit;
        } else if ($product_type == 'KJ') {//砍价商品
            $bargain = Tools::products_KJ_list($db, $store_id, $bargain_id);//商品数组（pid,cid,num)
            //商品表
            $sql = "SELECT * from lkt_product_list where store_id = $store_id and id = " . $bargain[0]['pid'];
            $goodsRes = $db->select($sql);
            //属性表
            $sql = "SELECT * from lkt_configure where store_id = $store_id and id = " . $bargain[0]['cid'];
            $attrRes = $db->select($sql);
            $sql = "select * from lkt_bargain_goods where store_id='$store_id' and id='$bargain_id'";
            $barGRes = $db->select($sql);
            //查询默认地址
            $address = Tools::find_address($db, $store_id, $user_id, $address_id);
            $addemt = $address ? 1 : 0; //收货地址状态

            //3.列出商品数组-计算总价和优惠，运费
            $products_data = Tools::get_products_data($db, $store_id, $bargain, $products_total, $product_type);
            $product_id = $products_data['product_id'];
            $product_class = $products_data['product_class'];
            $products_freight = $products_data['products_freight'];
            $products = $products_data['products'];


            //计算砍价的价格
            $products_total = $barGRes[0]->min_price;
            $a_title = $goodsRes[0]->product_title;
            $market_price = $barGRes[0]->min_price;
            $imgurl = ServerPath::getimgpath($goodsRes[0]->imgurl);

            //计算会员特惠
            $plugin_order = new Plugin_order($store_id);
            $grade = $plugin_order->user_grade('KJ', $products_total, $user_id, $store_id);
            $grade_rate = floatval($grade['rate']);

            //4.计算运费

            $freight = Tools::get_freight($products_freight, $products, $address, $db, $store_id, $product_type);
            $products = $freight['products'];
            $yunfei = $freight['yunfei'];

            //计算竞拍价+运费
            $total = $products_total * $grade_rate + $yunfei; //竞拍商品不支持，优惠券，满减，红包

            $products[0]['list'][0]['price'] = $products_total;

            echo json_encode(array('payment' => $payment,'status' => 1, 'products' => $products, 'products_total' => $products_total, 'freight' => $yunfei, 'total' => $total, 'user_money' => $user_money, 'address' => $address, 'addemt' => $addemt, 'password_status' => $password_status, 'enterless' => $enterless, 'grade_rate' => $grade_rate));
            exit;
        } else if ($product_type == 'MS') {//秒杀商品
            //2.区分购物车结算和立即购买---列出选购商品

            $products = Tools::products_list($db, $store_id, $cart_id, $product, $product_type);
            //查询默认地址
            $address = Tools::find_address($db, $store_id, $user_id, $address_id);
            $addemt = $address ? 1 : 0; // 收货地址状态

            //其他限制-------待处理

            //3.列出商品数组-计算总价和优惠，运费
            $products_data = Tools::get_products_data($db, $store_id, $products, $products_total, $product_type);
            $product_id = $products_data['product_id'];
            $product_class = $products_data['product_class'];
            $products_freight = $products_data['products_freight'];
            $products = $products_data['products'];
            $products_total = $products_data['products_total'];

            //根据当前时间查询出活动
            $nowdate = date("Y-m-d H:i:s", time());
            $nowdate_ = explode(' ', $nowdate);
            $nowtime = '1970-01-01 ' . $nowdate_[1];

            $nowtime1 = $nowdate_[0] . ' 00:00:00';
            $sel_seckill_activity = "select * from lkt_seconds_activity where store_id = $store_id and starttime <= '$nowtime1' and endtime >= '$nowtime1' and is_delete = 0";
            $seckill_activity_res = $db->select($sel_seckill_activity);
            $seckill_activity_id = $seckill_activity_res[0]->id;

            //根据当前时间查询出活动时段
            $sel_seckill_time = "select * from lkt_seconds_time where store_id = $store_id and starttime < '$nowtime' and endtime > '$nowtime' and is_delete = 0";
            $seckill_time_res = $db->select($sel_seckill_time);
            $seckill_time_id = $seckill_time_res[0]->id;
            //获取商品id
            $pro_id = $product_id[0];
            //查询出秒杀价格
            $sel_price_sql = "SELECT * FROM `lkt_seconds_pro` WHERE 1 and is_delete = 0 and pro_id = $pro_id and activity_id = $seckill_activity_id and time_id = $seckill_time_id";
            $price_res = $db->select($sel_price_sql);

            if (!empty($price_res)) {
                $num = explode(',', $product);
                $num = $num[2];
                $products_total = $price_res[0]->seconds_price * $num;
            } else {
                $ret['code'] = 500;
                $ret['msg'] = "数据异常！";
                $ret['sql'] = $sel_price_sql;
                echo json_encode($ret);
                exit;
            }

            $is_distribution = $products[0]['list'][0]['is_distribution'];

            //4.计算运费
            $freight = Tools::get_freight($products_freight, $products, $address, $db, $store_id, $product_type);
            $products = $freight['products'];
            $products[0]['list'][0]['price'] = $price_res[0]->seconds_price;
            $yunfei = $freight['yunfei'];

            // 店铺
            $mch = new mch();
            $shop = $mch->Settlement($db, $store_id, $products);
            $shop_status = $shop['shop_status'];

            $discount = 1;
            //计算会员特惠
            $plugin_order = new Plugin_order($store_id);
            $product_id0 = $product_id[0];//第一个商品的id
            $sql0 = "select active from lkt_product_list where store_id = $store_id and id = $product_id0";
            $res0 = $db->select($sql0);
            $active = $res0[0]->active;

            //计算会员特惠
            $plugin_order = new Plugin_order($store_id);
            $product_id0 = $product_id[0];//第一个商品的id
            $sql0 = "select active from lkt_product_list where store_id = $store_id and id = $product_id0";
            $res0 = $db->select($sql0);
            $active = $res0[0]->active;

            $grade = $plugin_order->user_grade('MS', $products_total, $user_id, $store_id);

            $grade_rate = floatval($grade['rate']);

            $total = $products_total * $grade_rate - $yunfei; // 商品总价 - 自动满减 + 运费 - 优惠券金额    实际付款金额
            if ($total < 0) {
                $total = 0.01;
            }
            //计算会员特惠
            $plugin_order = new Plugin_order($store_id);
            $product_id0 = $product_id[0];//第一个商品的id
            $sql0 = "select active from lkt_product_list where store_id = $store_id and id = $product_id0";
            $res0 = $db->select($sql0);

            $grade = $plugin_order->user_grade('MS', $products_total, $user_id, $store_id);

            $grade_rate = floatval($grade['rate']);


            $total = $products_total * $grade_rate + $yunfei; // 商品总价 - 自动满减 + 运费 - 优惠券金额    实际付款金额


            //5.返回数据
            echo json_encode(array('payment' => $payment,'status' => 1, 'activity_id' => $seckill_activity_id, 'time_id' => $seckill_time_id, 'products' => $products, 'is_distribution' => $is_distribution, 'discount' => $discount, 'products_total' => $products_total, 'freight' => $yunfei, 'total' => $total, 'user_money' => $user_money, 'address' => $address, 'addemt' => $addemt, 'password_status' => $password_status, 'enterless' => $enterless, 'shop_status' => $shop_status, 'shop_list' => $shop_list, 'grade_rate' => $grade_rate));
            exit;
        } else {//普通商品，确认订单方式

            //2.区分购物车结算和立即购买---列出选购商品
            $products = Tools::products_list($db, $store_id, $cart_id, $product, $product_type);
            //查询默认地址order_details
            $address = Tools::find_address($db, $store_id, $user_id, $address_id);

            $addemt = $address ? 1 : 0; // 收货地址状态

            //其他限制-------待处理

            //3.列出商品数组-计算总价和优惠，运费
            $products_data = Tools::get_products_data($db, $store_id, $products, $products_total, $product_type);
            $product_id = $products_data['product_id'];
            $product_class = $products_data['product_class'];
            $products_freight = $products_data['products_freight'];
            $products = $products_data['products'];
            $products_total = $products_data['products_total'];

            $is_distribution = $products[0]['list'][0]['is_distribution'];

            //4.计算运费
            $freight = Tools::get_freight($products_freight, $products, $address, $db, $store_id, $product_type);

            $products = $freight['products'];
            $yunfei = $freight['yunfei'];

            if ($is_distribution != 1) {
                // 店铺
                $mch = new mch();
                $shop = $mch->Settlement($db, $store_id, $products);
                $shop_status = $shop['shop_status'];

                // 满减--插件
                $auto_jian = new subtraction();
                if ($shop_address_id) {
                    if ($shop_address_id != '') {
                        $shop_list = $mch->Settlement1($db, $store_id, $shop_address_id);
                    }
                    $auto = $auto_jian->auto_jian($db, $store_id, $products, array());
                    $yunfei = 0;
                } else {
                    $auto = $auto_jian->auto_jian($db, $store_id, $products, $address);
                    if ($auto['is_shipping'] == 1 && $grade_l == 0) {
                        $yunfei = 0;
                    }
                }
                if (array_key_exists ('is_subtraction',$auto) && $auto['is_subtraction'] == 1) {
                    $is_subtraction = $auto['is_subtraction'];
                    $reduce_money = $auto['reduce_money'];
                    $reduce_name = $auto['reduce_name'];
                    $products = $auto['products'];
                } else {
                    $is_subtraction = 0;
                    $reduce_money = 0;
                    $reduce_name = '';
                }

                // 优惠券--插件
                $coupon = new coupon();
                $coupon_arr = $coupon->Settlement($store_id, $user_id, $products_total, $product_class, $product_id, $canshu, $yunfei);
                $coupon_money = $coupon_arr['money']; //优惠券金额
                $coupon_id = $coupon_arr['coupon_id']; //优惠券ID
                $coupon_status = $coupon_arr['coupon_status'];
                $coupon_name = $coupon_arr['coupon_name'];
                if ($coupon_arr['activity_type'] == 1 && $grade_l == 0) {
                    $yunfei = 0;
                } else {
                    $yunfei = $yunfei;
                }

                $discount = 1;
                //计算会员特惠
                $plugin_order = new Plugin_order($store_id);
                $product_id0 = $product_id[0];//第一个商品的id
                $sql0 = "select active from lkt_product_list where store_id = $store_id and id = $product_id0";
                $res0 = $db->select($sql0);
                $active = $res0[0]->active;
                if ($active == 6) {
                    $grade = $plugin_order->user_grade('TH', $products_total, $user_id, $store_id);
                    $coupon_money = 0;
                    $coupon_id = 0;
                    $coupon_name = '';
                    $coupon_status = false;
                    $reduce_money = 0;
                    $reduce_name = '';
                    $is_subtraction = 0;
                } else {
                    $grade = $plugin_order->user_grade('GM', $products_total, $user_id, $store_id);
                }
                $grade_rate = floatval($grade['rate']);

                if ($grade_l) {
                    $products_total = 0;
                    $total = $yunfei; // 商品总价 - 自动满减 + 运费 - 优惠券金额    实际付款金额
                } else {

                    $total = $products_total * $grade_rate - $reduce_money - $coupon_arr['money']; // 商品总价 - 自动满减 + 运费 - 优惠券金额    实际付款金额
                    if ($total < 0) {
                        $total = 0.01;
                    }
                    $total = $total + $yunfei;
                }
            } else {

                $coupon_money = $coupon_arr['money'] = 0;
                $coupon_id = $coupon_arr['coupon_id'] = 0;
                $coupon_name = $coupon_arr['coupon_name'] = '';
                $coupon_status = $coupon_arr['coupon_status'] = false;
                $is_subtraction = 0;
                $reduce_money = 0;
                $reduce_name = '';
                //计算会员特惠
                $plugin_order = new Plugin_order($store_id);
                $grade = $plugin_order->user_grade('FX', $products_total, $user_id, $store_id);
                $grade_rate = floatval($grade['rate']);
                //查询用户分销等级对应折扣
                $sql = "select b.discount from lkt_user_distribution a left join lkt_distribution_grade b on a.level=b.id where a.store_id = '$store_id' and a.user_id='$user_id'";
                $res = $db->select($sql);
                if ($res) {
                    $discount = floatval($res[0]->discount);
                } else {
                    $discount = 1;
                }
                if ($discount > 0) {
                    $total = $products_total * $discount * $grade_rate; // 商品总价 * 分销折扣 + 运费   实际付款金额
                } else {
                    $discount = 1;
                    $total = $products_total; // 商品总价 + 运费   实际付款金额
                }
                $total = $total + $yunfei;
                $shop_status = 0;
            }
        }

        //5.返回数据
        echo json_encode(array('payment' => $payment,'status' => 1, 'products' => $products, 'is_distribution' => $is_distribution, 'discount' => $discount, 'products_total' => $products_total, 'freight' => $yunfei, 'total' => $total, 'user_money' => $user_money, 'address' => $address, 'addemt' => $addemt, 'coupon_id' => $coupon_id, 'coupon_name' => $coupon_name, 'coupon_money' => $coupon_money, 'coupon_status' => $coupon_status, 'reduce_money' => $reduce_money, 'password_status' => $password_status, 'enterless' => $enterless, 'reduce_name' => $reduce_name, 'is_subtraction' => $is_subtraction, 'shop_status' => $shop_status, 'shop_list' => $shop_list, 'grade_rate' => $grade_rate));
        exit;
    }

    /**
     * 生成订单
     */
    public function payment()
    {
        $db = $this->db;
        // 1.开启事务
        $db->begin();
        $coupon = new coupon();

        // 2.数据准备
        $request = $this->getContext()->getRequest();
        $store_id = $this->store_id;
        $user_id = $this->user->user_id; // 用户id
        $products_total = 0;

        $product1 = addslashes($request->getParameter('product'));//  商品数组--------['pid'=>66,'cid'=>88]
        $cart_id = addslashes(trim($request->getParameter('cart_id')));  // 购物车id-- 12,13,123,
        $auction_id = addslashes(trim($request->getParameter('auction_id'))); // 竞拍商品的id
        $bargain_id = addslashes(trim($request->getParameter('bargain_id'))); // 砍价商品的id
        $grade_l = addslashes($request->getParameter('grade_l'));//会员特惠 兑换券级别
        $product = '';
        $lktlog = new LaiKeLogUtils("app/order.log");
        // 如果数据不为空
        if ($product1 != '') {
            // 将字符串转数组
            $product1 = htmlspecialchars_decode($product1);
            $product2 = json_decode($product1); // 字符串打散为数组
            foreach ($product2 as $k => $v) {
                foreach ($v as $ke => $va) {
                    $product3[$ke] = $va;
                }
            }
            $product = implode(',', $product3);// 转字符串，逗号隔开
            $cart_id = '';
        }
        $type = trim($request->getParameter('type')) ? $request->getParameter('type') : 'GM'; // 订单类型
        $coupon_id = trim($request->getParameter('coupon_id')); // 优惠券id
        $allow = trim($request->getParameter('allow')); // 用户使用积分
        $address_id = $request->getParameter('address_id'); //  地址id
        $shop_address_id = $request->getParameter('shop_address_id'); //  门店地址id
        $remarks = trim($request->getParameter('remarks')); //  订单备注
        $store_type = addslashes(trim($request->getParameter('store_type')));
        $pay_type = addslashes(trim($request->getParameter('pay_type')));//

        // 3.区分购物车结算和立即购买---列出选购商品
        if ($type == 'JP') {
            $products = Tools::products_JP_list($db, $store_id, $auction_id);
        } else {
            $products = Tools::products_list($db, $store_id, $cart_id, $product, $type);
        }
        // 4.查询默认地址
        $address = Tools::find_address($db, $store_id, $user_id, $address_id);
        $addemt = $address ? 1 : 0; // 收货地址状态
        // 存储收货信息
        $mobile = $address['tel'];
        $name = $address['name'];
        $sheng = $address['sheng'];
        $shi = $address['city'];
        $xian = $address['quyu'];
        $address_xq = $address['address'];

        // 5.列出商品数组-计算总价和优惠，运费
        $products_data = Tools::get_products_data($db, $store_id, $products, $products_total, $type);//获取商品信息，运费信息
        // 存储信息
        $product_id = $products_data['product_id'];
        $product_class = $products_data['product_class'];
        $products_freight = $products_data['products_freight'];
        $products = $products_data['products'];
        $products_total = $products_data['products_total'];
        if ($type == 'JP') {
            // 计算竞拍商品的价格
            $sql = "select current_price,title,id,imgurl,market_price from lkt_auction_product where store_id = '$store_id' and id = '$auction_id'";
            $res = $db->select($sql);
            $products_total = $res[0]->current_price;// 真正的竞拍商品总价
        } else if ($type == 'MS') {
            //ms hg
            //根据当前时间查询出活动
            $nowdate = date("Y-m-d H:i:s", time());
            $nowdate_ = explode(' ', $nowdate);
            $nowtime = '1970-01-01 ' . $nowdate_[1];
            $nowtime1 = $nowdate_[0] . ' 00:00:00';
            $sel_seckill_activity = "select * from lkt_seconds_activity where store_id = $store_id and starttime <= '$nowtime1' and endtime >= '$nowtime1' and is_delete = 0";
            $seckill_activity_res = $db->select($sel_seckill_activity);
            $seckill_activity_id = $seckill_activity_res[0]->id;

            $nowtime1 = $nowdate_[0] . ' 00:00:00';
            $sel_seckill_activity = "select * from lkt_seconds_activity where store_id = $store_id and starttime <= '$nowtime1' and endtime >= '$nowtime1' and is_delete = 0";
            $seckill_activity_res = $db->select($sel_seckill_activity);
            $seckill_activity_id = $seckill_activity_res[0]->id;

            //根据当前时间查询出活动时段
            $sel_seckill_time = "select * from lkt_seconds_time where store_id = $store_id and starttime < '$nowtime' and endtime > '$nowtime' and is_delete = 0";
            $seckill_time_res = $db->select($sel_seckill_time);
            $seckill_time_id = $seckill_time_res[0]->id;
            //获取商品id
            $pro_id = $product_id[0];
            //查询出秒杀价格
            $sel_price_sql = "SELECT * FROM `lkt_seconds_pro` WHERE 1 and is_delete = 0 and pro_id = $pro_id and activity_id = $seckill_activity_id and time_id = $seckill_time_id";
            $price_res = $db->select($sel_price_sql);

            if (!empty($price_res)) {
                $products_total = $price_res[0]->seconds_price;
            } else {
                $ret['code'] = 500;
                $ret['msg'] = "数据异常！";
                $ret['sql'] = $sel_price_sql;
                echo json_encode($ret);
                exit;
            }
        }

        // 6.计算运费
        $freight = Tools::get_freight($products_freight, $products, $address, $db, $store_id, $type);
        // 存储运费数据
        $products = $freight['products'];
        $yunfei = $freight['yunfei'];
        //如果为0元订单，则订单状态为 1-已发货
        if ($grade_l && ($yunfei == 0)) {
            $order_status = 1;
        } else {
            $order_status = 0;
        }
        // 定义初始化数据
        $z_num = 0;
        $otype = '';
        // 判断是否为分销商品 1是 0否

        // 竞拍不支持分销
        if ($type != 'JP') {
            $is_distribution = $products[0]['list'][0]['is_distribution'];
        }
        $discount = 1;

        if ($type == 'JP') {
            $jp_payment = new Plugin_order($store_id);
            //序列化生成订单参数
            $info = array('name' => $name, 'mobile' => $mobile, 'sheng' => $sheng, 'shi' => $shi, 'xian' => $xian, 'address_xq' => $address_xq, 'pay_type' => $pay_type, 'coupon_id' => $coupon_id, 'allow' => $allow, 'store_type' => $store_type, 'remarks' => $remarks);
            $info = json_encode($info);//序列化成json字符串
            $jp_payment->JP_payment($store_id, $auction_id, $products, $user_id, $products_total, $yunfei, $info);
        } else if ($type == "MS") {
            // 店铺
            $mch = new mch();
            if ($shop_address_id) {
                $shop = $mch->Settlement($db, $store_id, $products, 'payment');
                $shop_status = $shop['shop_status'];
                $extraction_code = $shop['extraction_code'];
                $extraction_code_img = $shop['extraction_code_img'];
                $yunfei = 0;
            } else {
                $shop_status = 0;
                $extraction_code = '';
                $extraction_code_img = '';
            }

            // 判断是否使用优惠价 0 未使用，1使用
            // 优惠券--插件
            $coupon_money = 0;
            $coupon_status = 0;

            $sNo = $this->order_number($type, 'sNo'); // 生成订单号
            $real_sno = $this->order_number($type, 'real_sno'); // 生成支付订单号
            LaiKeLogUtils::lktLog("orderAction:生成订单" . $sNo);
            $data = array();
            $mch_id = '';
            $yunfei1 = 0;


            //循环订单商品
            foreach ($products as $k => $v) {
                $mch_id .= $v['shop_id'] . ',';
                $mch_id1 = $v['shop_id'];

                //如果是多店铺，添加一条购买记录
                if ($mch_id != 0) {
                    $sql = "insert into lkt_mch_browse(store_id,mch_id,user_id,event,add_time) values ('$store_id','$mch_id1','$user_id','购买了商品',CURRENT_TIMESTAMP)";
                    $buy_res = $db->insert($sql);
                    if($buy_res<1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."添加购买记录失败！sql:".$sql);
                    }
                }

                //循环商品数据
                foreach ($v['list'] as $key => $value) {
                    $pdata = (object)$value;
                    $pid = $value['pid'];
                    $cid = $value['cid'];
                    $num = $value['num'];
//                    $products_total = $products_total * $num;
                    //查询商品金额


                    $product_title = addslashes($value['product_title']);
                    $freight_price = floor(isset($value['freight_price']) ? $value['freight_price'] : 0);
                    $yunfei1 += $freight_price;
                    // 循环插入订单附表 ，添加不同的订单详情
                    if ($shop_address_id) {
                        $sql_d = 'insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,unit,r_sNo,add_time,r_status,size,sid,freight) VALUES ' . "('$store_id','$user_id','$pdata->pid','$product_title','$products_total','$pdata->num','$pdata->unit','$sNo',CURRENT_TIMESTAMP,'$order_status','$pdata->size','$pdata->cid',0)";
                    } else {
                        $sql_d = 'insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,unit,r_sNo,add_time,r_status,size,sid,freight) VALUES ' . "('$store_id','$user_id','$pdata->pid','$product_title','$products_total','$pdata->num','$pdata->unit','$sNo',CURRENT_TIMESTAMP,'$order_status','$pdata->size','$pdata->cid','$yunfei')";
                    }
                    $beres = $db->insert($sql_d, "last_insert_id");
                    // 如果添加事变
                    if ($beres < 1) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."添加订单详情失败！sql:".$sql_d);
                        $coupon_Log_content = '会员' . $user_id . '使用优惠券ID为' . $coupon_id . '添加订单详情失败！（商品ID为' . $pdata->pid . ',属性ID为' . $pdata->cid . '）';
                        $coupon->couponLog($coupon_id, $coupon_Log_content);
                        // 回滚事件，给提示
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试1!', 'line' => __LINE__));
                        exit;
                    }

                    $z_num += $pdata->num;
                    if ($cart_id != '') {
                        // 删除对应购物车内容
                        $sql_del = "delete from lkt_cart where store_id = '$store_id' and Goods_id='$pid' and user_id = '$user_id' and Size_id = '$cid'";
                        $res_del = $db->delete($sql_del);
                        if ($res_del < 1) {
                            $coupon_Log_content = '会员' . $user_id . '使用优惠券ID为' . $coupon_id . '生成订单时,删除购物车信息失败！（商品ID为' . $pdata->pid . ',属性ID为' . $pdata->cid . '）';
                            $coupon->couponLog($coupon_id, $coupon_Log_content);

                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试2!', 'line' => __LINE__));
                            exit;
                        }
                    }

                }
            }
            $mch_id = rtrim($mch_id, ',');
            $mch_id = ',' . $mch_id . ',';
            $bargain_order_no = '';
            $bargain_id = 0;
            //计算会员特惠
            $plugin_order = new Plugin_order($store_id);
            $product_id0 = $product_id[0];//第一个商品的id
            $sql0 = "select active from lkt_product_list where store_id = $store_id and id = $product_id0";
            $res0 = $db->select($sql0);
            $active = $res0[0]->active;
            $grade = $plugin_order->user_grade('MS', $products_total, $user_id, $store_id);//普通
            $grade_rate = floatval($grade['rate']);

            $total = ($products_total * $grade_rate)*$z_num + $yunfei; // 商品总价 * 分销折扣 - 自动满减 + 运费 - 优惠券金额     实际付款金额
            if ($total <= 0) {
                $total = 0.01;
            }

            $otype = "MS";

            $sql_o = 'insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,remark,pay,add_time,status,coupon_id,subtraction_id,consumer_money,coupon_activity_name,spz_price,reduce_price,coupon_price,source,otype,mch_id,p_sNo,bargain_id,comm_discount,remarks,real_sno,self_lifting,extraction_code,extraction_code_img,grade_rate) VALUES ' .
                "('$store_id','$user_id','$name','$mobile','$z_num','$total','$sNo','$sheng','$shi','$xian','$address_xq',' ','$pay_type',CURRENT_TIMESTAMP,'$order_status','$coupon_id','0','$allow','','$products_total','0','$coupon_money','$store_type','$otype','$mch_id','$bargain_order_no','$bargain_id','$discount','$remarks','$real_sno','$shop_status','$extraction_code','$extraction_code_img','$grade_rate')";
            $r_o = $db->insert($sql_o, "last_insert_id");
            if ($r_o > 0) {
                $activity_id = trim($request->getParameter('activity_id')); // 活动id
                $time_id = trim($request->getParameter('time_id')); // 时段id
                $pro_id = $pdata->pid;//商品id

                //查询redis缓存是否有库存

                $redis = new RedisClusters();
                $re = $redis->connect();

                $redis_name = "seconds_" . $activity_id . "_" . $time_id . "_" . $pro_id;
                $has_kc = true;
                $ii = 0;
                for ($i = 0; $i < $z_num; $i++) {
                    $res = $redis->lpop($redis_name);
                    if ($res) {
                        //有库存
                        $ii++;
                    } else {
                        //库存不足
                        $has_kc = false;
                    }
                }

                if (!$has_kc) {
                    //把redis库存加回去
                    for ($i_ = 0; $i_ < $ii; $i_++) {
                        $redis->lpush($redis_name, 1);
                    }
                }

                $redis->close();

                if ($has_kc) {
                    //添加秒杀记录
                    $istmssql = "insert into lkt_seconds_record(
                    `store_id`,`user_id`,`activity_id`, `time_id`, `pro_id`, `price`, `num`,`sNo`, `is_delete`, `add_time`
                    ) values(
                    '$store_id','$user_id',$activity_id,'$time_id',$pro_id,'$products_total','$z_num','$sNo',0,CURRENT_TIMESTAMP)";
                    $record_res = $db->insert($istmssql);
                    if($record_res<1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."添加秒杀记录失败！sql:".$sql);
                    }
                    //秒杀商品里的商品库存-1
                    $sqlllll = "update lkt_seconds_pro set num = num - $z_num where store_id = $store_id and is_delete  = 0 and activity_id = $activity_id and time_id = $time_id and pro_id = $pro_id";
                    $res_del1 = $db->update($sqlllll);
                    if($res_del1 < 1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改秒杀商品库存失败！sql:".$sqlllll);
                    }
                } else {
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试!', 'line' => __LINE__, 'redis' => $res, "redis_name" => $redis_name));
                    exit;
                }

                // 库存-1
                $sql_o0 = "update lkt_product_list set num = num - 1 where store_id = '$store_id' and id = '$pro_id'";
                $r_o0 = $db->update($sql_o0);
                if ($r_o0 < 1) {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改商品库存失败！sql:".$sql_o0);
                    $db->rollback();
                    echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试5!', 'line' => __LINE__));
                    exit;
                }
                if ($type != 'KJ') {
                    $sql_o1 = "update lkt_configure set num = num - 1 where pid = '$pid' and id = $cid";
                    $r_o1 = $db->update($sql_o1);
                    if ($r_o1 < 1) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改商品库存失败！sql:".$sql_o1);
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试6!', 'line' => __LINE__, "sql" => $sql_o1));
                        exit;
                    }
                }

                $coupon_Log_content = '会员' . $user_id . ',订单号' . $sNo . '使用领取优惠券ID为' . $coupon_id;
                $coupon->couponLog($coupon_id, $coupon_Log_content);
                //如果为会员等级赠送商品，修改兑换券状态
                if ($grade_l) {
                    $sql_1 = "update lkt_user_first set is_use = 1,sNo =  '$sNo' where store_id = $store_id and user_id = '$user_id' and level = $grade_l";
                    $res_1 = $db->update($sql_1);
                    if ($res_1 < 0) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户第一次开团会员状态失败！sql:".$sql_1);
                        $db->rollback();
                        echo json_encode(array('status' => 0, '更新兑换券使用状态失败'));
                        exit;
                    }
                }
                //返回
                $db->commit();
                $arr = array('sNo' => $sNo, 'total' => $total, 'order_id' => $r_o);
            } else {
                $coupon_Log_content = '会员' . $user_id . '使用领取优惠券ID为' . $coupon_id . '生成订单失败！';
                $coupon->couponLog($coupon_id, $coupon_Log_content);
                $lktlog->customerLog(__METHOD__.":".__LINE__."添加秒杀订单失败！sql:".$sql);
                //回滚删除已经创建的订单
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试7!', 'line' => __LINE__));
                exit;
            }
            echo json_encode(array('status' => 1, 'data' => $arr));
            exit;

        } else {
            if ($is_distribution != 1) {
                // 如果不是分销商品
                // 店铺
                $mch = new mch();

                if ($shop_address_id) {
                    $shop = $mch->Settlement($db, $store_id, $products, 'payment');
                    $shop_status = $shop['shop_status'];
                    $extraction_code = $shop['extraction_code'];
                    $extraction_code_img = $shop['extraction_code_img'];
                    $yunfei = 0;
                } else {
                    $shop_status = 0;
                    $extraction_code = '';
                    $extraction_code_img = '';
                }

                // 满减--插件
                $auto_jian = new subtraction();
                if ($shop_address_id) {
                    $auto = $auto_jian->auto_jian($db, $store_id, $products, array());
                    $yunfei = 0;
                } else {
                    $auto = $auto_jian->auto_jian($db, $store_id, $products, $address);
                    if ($auto['is_shipping'] == 1 && $grade_l == 0) {
                        $yunfei = 0;
                    }
                }
                if (array_key_exists ('is_subtraction',$auto) && $auto['is_subtraction'] == 1) {
                    // 获取满减金额
                    $give_id = $auto['give_id']; // 赠品ID
                    $subtraction_id = $auto['subtraction_id']; // 满减ID
                    $reduce_money = $auto['reduce_money']; // 满减金额
                    $products = $auto['products']; // 商品信息
                    $reduce_name_array = $auto['reduce_name_array']; // 满减名称
                } else {
                    // 获取满减金额
                    $give_id = 0; // 赠品ID
                    $subtraction_id = 0; // 满减ID
                    $reduce_money = 0; // 满减金额
                    $products = $products; // 商品信息
                    $reduce_name_array = ''; // 满减名称
                }

                // 判断是否使用优惠价 0 未使用，1使用
                // 优惠券--插件
                if ($coupon_id == 0) {
                    $coupon_money = 0;
                    $coupon_status = 0;
                } else {
                    $list = $coupon->getvou($store_id, $user_id, $coupon_id, $products_total);
                    // 获取优惠金额
                    $coupon_money = $list['money'];
                    $coupon_status = 1;
                    if ($list['activity_type'] == 1) {
                        $yunfei = 0;
                    }
                }

                if ($grade_l && $yunfei == 0) {
                    $order_status = 1;
                }

                // 获取满减金额
                $give_id = array_key_exists('give_id',$auto)?$auto['give_id']:0;
                $subtraction_id = array_key_exists('subtraction_id',$auto)?$auto['subtraction_id']:0;
                $reduce_money = array_key_exists('reduce_money',$auto)?$auto['reduce_money']:0;
                $products = array_key_exists('products',$auto)?$auto['products']:$products;
                $reduce_name_array = array_key_exists('reduce_name_array',$auto)?$auto['reduce_name_array']:'';

            } else {
                $give_id = 0;
                $subtraction_id = 0;
                $reduce_money = 0;
                $coupon_money = 0;
                $coupon_status = 0;
                $reduce_name_array = '';
                $otype = "FX";
                $type = "FX";
                // 查询用户分销等级对应折扣
                $sql = "select b.discount from lkt_user_distribution a left join lkt_distribution_grade b on a.level=b.id where a.store_id = '$store_id' and a.user_id='$user_id'";
                $res = $db->select($sql);
                if ($res) {
                    $discount = !empty($res) ? floatval($res[0]->discount) : 1;
                    if ($res[0]->discount == null || $res[0]->discount == '0.00') {
                        $discount = 1;
                    }
                } else {
                    $discount = 1;
                }
                $shop_status = 0;
                $extraction_code = '';
                $extraction_code_img = '';
            }

            $sNo = $this->order_number($type, 'sNo'); // 生成订单号
            $real_sno = $this->order_number($type, 'real_sno'); // 生成支付订单号
            LaiKeLogUtils::lktLog("orderAction:生成订单" . $sNo);
            $data = array();
            $mch_id = '';
            $yunfei1 = 0;

            //循环订单商品
            foreach ($products as $k => $v) {
                $mch_id .= $v['shop_id'] . ',';
                $mch_id1 = $v['shop_id'];

                //如果是多店铺，添加一条购买记录
                if ($mch_id != 0) {
                    $sql = "insert into lkt_mch_browse(store_id,mch_id,user_id,event,add_time) values ('$store_id','$mch_id1','$user_id','购买了商品',CURRENT_TIMESTAMP)";
                    $res = $db->insert($sql);
                    if($res< 1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."添加购买记录失败！sql:".$sql);
                    }
                }

                //循环商品数据
                foreach ($v['list'] as $key => $value) {
                    $pdata = (object)$value;
                    $pid = $value['pid'];
                    $cid = $value['cid'];
                    $num = $value['num'];
                    $product_title = addslashes($value['product_title']);
                    $freight_price = floor(isset($value['freight_price']) ? $value['freight_price'] : 0);
                    $yunfei1 += $freight_price;
                    // 循环插入订单附表 ，添加不同的订单详情
                    if ($shop_address_id) {
                        $sql_d = 'insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,unit,r_sNo,add_time,r_status,size,sid,freight) VALUES ' . "('$store_id','$user_id','$pdata->pid','$product_title','$pdata->price','$pdata->num','$pdata->unit','$sNo',CURRENT_TIMESTAMP,'$order_status','$pdata->size','$pdata->cid',0)";
                    } else {
                        $sql_d = 'insert into lkt_order_details(store_id,user_id,p_id,p_name,p_price,num,unit,r_sNo,add_time,r_status,size,sid,freight) VALUES ' . "('$store_id','$user_id','$pdata->pid','$product_title','$pdata->price','$pdata->num','$pdata->unit','$sNo',CURRENT_TIMESTAMP,'$order_status','$pdata->size','$pdata->cid','$yunfei')";
                    }
                    $beres = $db->insert($sql_d, "last_insert_id");
                    // 如果添加事变
                    if ($beres < 1) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."添加订单详情失败！sql:".$sql);
                        $coupon_Log_content = '会员' . $user_id . '使用优惠券ID为' . $coupon_id . '添加订单详情失败！（商品ID为' . $pdata->pid . ',属性ID为' . $pdata->cid . '）';
                        $coupon->couponLog($coupon_id, $coupon_Log_content);
                        // 回滚事件，给提示
                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试1!', 'line' => __LINE__));
                        exit;
                    }

                    // 分销
                    if ($is_distribution == 1) {

                        $comm = $this->order_distribution($pdata->pid, $sNo);
                        if ($comm == false) {
                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '分销记录创建失败!', 'line' => __LINE__));
                            exit;
                        }
                    }
                    // 分销 end
                    $z_num += $pdata->num;
                    if ($cart_id != '') {
                        // 删除对应购物车内容
                        $sql_del = "delete from lkt_cart where store_id = '$store_id' and Goods_id='$pid' and user_id = '$user_id' and Size_id = '$cid'";
                        $res_del = $db->delete($sql_del);
                        if ($res_del < 1) {
                            $coupon_Log_content = '会员' . $user_id . '使用优惠券ID为' . $coupon_id . '生成订单时,删除购物车信息失败！（商品ID为' . $pdata->pid . ',属性ID为' . $pdata->cid . '）';
                            $coupon->couponLog($coupon_id, $coupon_Log_content);

                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试2!', 'line' => __LINE__));
                            exit;
                        }
                    }
                    if (empty($grade_l)) {//非会员特惠商品才减库存
                        // 销量+1 库存-1
                        $sql = "update lkt_product_list set num = num - $num where id = '$pid'";
                        $res_del1 = $db->update($sql);
                        if ($res_del1 < 1) {
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改商品库存失败！sql:".$sql);
                            $coupon_Log_content = '会员' . $user_id . '使用优惠券ID为' . $coupon_id . '生成订单时,修改商品库存信息失败！（商品ID为' . $pdata->pid . '）';
                            $coupon->couponLog($coupon_id, $coupon_Log_content);

                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试3!', 'line' => __LINE__));
                            exit;
                        }

                        if ($type != "KJ") {
                            $sql = "update lkt_configure set num = num - $num where pid = '$pid' and id = '$cid'";
                            $res_del2 = $db->update($sql);
                            if ($res_del2 < 1) {
                                $lktlog->customerLog(__METHOD__.":".__LINE__."修改商品属性库存失败！sql:".$sql);
                                $coupon_Log_content = '会员' . $user_id . '使用优惠券ID为' . $coupon_id . '生成订单时,修改商品属性库存信息失败！（商品ID为' . $pdata->pid . ',属性ID为' . $pdata->cid . '）';
                                $coupon->couponLog($coupon_id, $coupon_Log_content);
                                $db->rollback();
                                echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试4!', 'line' => __LINE__));
                                exit;
                            }
                        }
                    }

                }
            }
            $mch_id = rtrim($mch_id, ',');
            $mch_id = ',' . $mch_id . ',';
            $bargain_order_no = '';
            if ($type == "KJ") {
                $bargain_order_no = addslashes(trim($request->getParameter('bargain_order_no')));
                $sql = "SELECT * from lkt_bargain_goods where id = $bargain_id";
                $_bargainRes_ = $db->select($sql);
                $products_total = $_bargainRes_[0]->min_price;
                //计算会员特惠
                $plugin_order = new Plugin_order($store_id);
                $grade = $plugin_order->user_grade('KJ', $products_total, $user_id, $store_id);
                $grade_rate = floatval($grade['rate']);
                $otype = 'KJ';
                $close_sql = "update lkt_order set status=6 where p_sNo='" . $bargain_order_no . "'";
                $close_res = $db->update($close_sql);
                if($close_res < 1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."关闭砍价订单失败！sql:".$close_sql);
                }
                // 获取满减金额
                $give_id = 0; // 赠品ID
                $subtraction_id = 0; // 满减ID
                $reduce_money = 0; // 满减金额
                $products = $products; // 商品信息
                $reduce_name_array = ''; // 满减名称
            } else {
                $bargain_id = 0;
            }
            //计算会员特惠
            $plugin_order = new Plugin_order($store_id);
            if ($is_distribution != 1) {//不是分销商品
                $product_id0 = $product_id[0];//第一个商品的id
                $sql0 = "select active from lkt_product_list where store_id = $store_id and id = $product_id0";
                $res0 = $db->select($sql0);
                $active = $res0[0]->active;
                if ($active == 6) {
                    $give_id = 0;
                    $subtraction_id = 0;
                    $reduce_money = 0;
                    $coupon_money = 0;
                    $coupon_status = 0;
                    $reduce_name_array = '';
                    $grade = $plugin_order->user_grade('TH', $products_total, $user_id, $store_id);//特惠
                    $otype = 'VIP';
                } else {
                    $grade = $plugin_order->user_grade('GM', $products_total, $user_id, $store_id);//普通
                }
            } else {
                $grade = $plugin_order->user_grade('FX', $products_total, $user_id, $store_id);//分销
            }
            $grade_rate = floatval($grade['rate']);

            if ($grade_l) {//会员特惠赠品
                $products_total = 0;
                $total = $yunfei;
                $otype = "vipzs";
            } else {
                $total = ($products_total - $coupon_money - $reduce_money) * $discount * $grade_rate; // 商品总价 * 分销折扣 - 自动满减 + 运费 - 优惠券金额     实际付款金额
                if ($total <= 0) {
                    $total = 0.01;
                }
                $total = $total + $yunfei;
            }

            $sql_o = 'insert into lkt_order(store_id,user_id,name,mobile,num,z_price,sNo,sheng,shi,xian,address,remark,pay,add_time,status,coupon_id,subtraction_id,consumer_money,coupon_activity_name,spz_price,reduce_price,coupon_price,source,otype,mch_id,p_sNo,bargain_id,comm_discount,remarks,real_sno,self_lifting,extraction_code,extraction_code_img,grade_rate) VALUES ' .
                "('$store_id','$user_id','$name','$mobile','$z_num','$total','$sNo','$sheng','$shi','$xian','$address_xq',' ','$pay_type',CURRENT_TIMESTAMP,'$order_status','$coupon_id','$subtraction_id','$allow','$reduce_name_array','$products_total','$reduce_money','$coupon_money','$store_type','$otype','$mch_id','$bargain_order_no','$bargain_id','$discount','$remarks','$real_sno','$shop_status','$extraction_code','$extraction_code_img','$grade_rate')";
            $r_o = $db->insert($sql_o, "last_insert_id");
            if ($r_o > 0) {
                if ($give_id != 0 && (empty($grade_l))) {
                    // 库存-1
                    $sql_o0 = "update lkt_product_list set num = num - 1 where store_id = '$store_id' and id = '$give_id'";
                    $r_o0 = $db->update($sql_o0);
                    if ($r_o0 < 1) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."生成订单时,修改赠品商品库存信息失败！sql:".$sql_o0);
                        $subtraction_Log_content = '会员' . $user_id . '生成订单时,修改赠品商品库存信息失败！（商品ID为' . $give_id . '）';
                        $auto_jian->subtractionLog($give_id, $subtraction_Log_content);

                        $db->rollback();
                        echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试5!', 'line' => __LINE__));
                        exit;
                    }
                    if ($type != "KJ") {
                        $sql_o1 = "update lkt_configure set num = num - 1 where pid = '$pid' order by id limit 1";
                        $r_o1 = $db->update($sql_o1);
                        if ($r_o1 < 1) {
                            $lktlog->customerLog(__METHOD__.":".__LINE__."生成订单时,修改赠品商品库存信息失败！sql:".$sql_o1);
                            $subtraction_Log_content = '会员' . $user_id . '生成订单时,修改赠品商品属性库存信息失败！（商品ID为' . $give_id . '）';
                            $auto_jian->subtractionLog($give_id, $subtraction_Log_content);
                            $db->rollback();
                            echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试6!', 'line' => __LINE__));
                            exit;
                        }
                    }
                }
                $coupon_Log_content = '会员' . $user_id . ',订单号' . $sNo . '使用领取优惠券ID为' . $coupon_id;
                $coupon->couponLog($coupon_id, $coupon_Log_content);
                //如果为会员等级赠送商品，修改兑换券状态
                if ($grade_l) {
                    $sql_1 = "update lkt_user_first set is_use = 1,sNo =  '$sNo' where store_id = $store_id and user_id = '$user_id' and level = $grade_l";
                    $res_1 = $db->update($sql_1);
                    if ($res_1 < 0) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."更新兑换券使用状态失败！sql:".$sql_1);

                        $db->rollback();
                        echo json_encode(array('status' => 0, '更新兑换券使用状态失败'));
                        exit;
                    }
                }

                if ($is_distribution != 1) {
                    $auto_jian->subtraction_record($db, $store_id, $user_id, $sNo);
                }
                //返回
                $db->commit();
                $arr = array('sNo' => $sNo, 'total' => $total, 'order_id' => $r_o);
            } else {
                $lktlog->customerLog(__METHOD__.":".__LINE__."添加订单失败！sql:".$sql);
                $coupon_Log_content = '会员' . $user_id . '使用领取优惠券ID为' . $coupon_id . '生成订单失败！';
                $coupon->couponLog($coupon_id, $coupon_Log_content);

                //回滚删除已经创建的订单
                $db->rollback();
                echo json_encode(array('status' => 0, 'err' => '下单失败,请稍后再试7!', 'line' => __LINE__));
                exit;
            }
            echo json_encode(array('status' => 1, 'data' => $arr));
            exit;
        }
    }

    /*
     * 修改备注
     */
    public function up_remarks()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $remarks = trim($request->getParameter('remarks')); // 备注
        $sNo = trim($request->getParameter('sNo')); // 订单号
        $store_id = trim($request->getParameter('store_id')); // 店铺号
        $lktlog = new LaiKeLogUtils("app/order.log");
        $sql = "update lkt_order set remarks= '$remarks' where sNo = '$sNo' and store_id = $store_id";
        $res = $db->update($sql);
        $ret['code'] = 0;
        $ret['msg'] = '修改失败！';
        if ($res) {
            $ret['code'] = 1;
            $ret['msg'] = '修改成功！';
        }else{
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单备注失败！sql:".$sql);
        }
        echo json_encode($ret);
        exit;
    }

    public function miaosha_ok()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id')); // 商城ID
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $sNo = trim($request->getParameter('sNo'));

        // 查询用户
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if ($r) {
            $user_id = $r[0]->user_id;

            $sql0 = "select * from lkt_order where store_id = '$store_id' and sNo = '$sNo' and user_id = '$user_id' and status=1";
            $r0 = $db->select($sql0);
            // 判断订单是否存在、有效
            if ($r0) {

                $msg_title = "【" . $sNo . "】秒杀成功！";
                $msg_content = "您的宝贝马上就会发货啦！";
                /**买家付款成功通知*/
                $pusher = new LaikePushTools();
                $pusher->pushMessage($user_id, $db, $msg_title, $msg_content, $store_id, '');

            }

        }
        return;
    }

    /**
     * 拆分订单
     */
    public function leave_Settlement()
    {
        LaiKeLogUtils::lktLog("orderAction:leave_Settlement");
        //操作失败!
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id')); // 商城ID
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $payment_money = trim($request->getParameter('price')); // 抵扣余额
        $order_list = addslashes(trim($request->getParameter('order_list')));
        $lktlog = new LaiKeLogUtils("app/order.log");
        //order_list 字符串转数组
        LaiKeLogUtils::lktLog("orderAction:order_list==>" . $order_list);
        $order_list = htmlspecialchars_decode($order_list);
        $order_list = json_decode($order_list, true);

        $sNo = $order_list['sNo'];

        //事物开始
        $db->begin();
        // 查询用户
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);

        // 判断用户是否存在、有效
        if ($r) {
            // 查询刚刚生成的订单
            $user_id = $r[0]->user_id;
            $sql0 = "select * from lkt_order where store_id = '$store_id' and sNo = '$sNo' and user_id = '$user_id'";
            $r0 = $db->select($sql0);
            // 判断订单是否存在、有效
            if ($r0) {
                //获取订单数据
                $coupon_id = $r0[0]->coupon_id; // 优惠券ID
                $coupon_price = $r0[0]->coupon_price; // 优惠券金额
                $subtraction_id = $r0[0]->subtraction_id; // 满减活动ID
                $coupon_activity_name = $r0[0]->coupon_activity_name; // 满减活动名称
                $reduce_price = $r0[0]->reduce_price; // 查询出的满减金额
                $z_price = $r0[0]->z_price; // 订单总价
                $z_spz_price = $r0[0]->spz_price;
                $status = $r0[0]->status; // 订单状态
                $name = $r0[0]->name; // 联系人
                $mobile = $r0[0]->mobile; // 联系电话
                $address = $r0[0]->address; // 联系地址

                $sql0_1 = "select id from lkt_user_address where store_id = '$store_id' and name = '$name' and tel = '$mobile'  and uid = '$user_id'";
                $r0_1 = $db->select($sql0_1);

                $address1 = $r0_1[0]->id;
                if ($status == 0) {
                    // 如果未支付完成则不拆分订单
                    exit;
                }
                $mch_id = $r0[0]->mch_id; // 店铺ID字符串
                $data = (array)$r0[0];
                unset($data['id']);
            } else {
                // 数据异常，返回错误提示
                $db->rollback();
                echo json_encode(array('code' => 0, 'message' => '参数错误'));
                exit;
            }
            $product_id_arr = array();
            // 根据订单号，查询订单商品ID
            $sql0 = "select a.id,b.p_id,a.offset_balance 
                        from lkt_order as a 
                        left join lkt_order_details as b on a.sNo = b.r_sNo 
                        where a.store_id = $store_id and b.r_sNo = '$sNo'";
            $r0 = $db->select($sql0);
            $payment_money = $r0[0]->offset_balance;
            if ($r0) {
                foreach ($r0 as $k => $v) {
                    $product_id_arr[] = $v->p_id;
                }
            }

            $type = substr($sNo, 0, 2);//获取订单号前两位字母（类型）
            $mch_id = substr($mch_id, 1, -1);
            $shop_id = explode(',', $mch_id); // 店铺id字符串

            if (count($shop_id) != 1) {  // 当为多家店铺时
                foreach ($shop_id as $k => $v) {
                    $sNo1 = $this->order_number($type, 'sNo'); // 生成订单号
                    $data['mch_id'] = $v;
                    $data['sNo'] = $sNo1;
                    $data['p_sNo'] = $sNo;
                    //查询单个商品的价格，运费，数量
                    $sql1 = "select a.id,a.p_id,a.p_price,a.num,a.freight,a.r_sNo 
                            from lkt_order_details as a 
                            left join lkt_product_list as b on a.p_id = b.id 
                            where a.store_id = '$store_id' and a.r_sNo = '$sNo' and b.mch_id = '$v'";
                    $r1 = $db->select($sql1);
                    //如果查询到数据
                    $order_num_ = 0;
                    if ($r1) {

                        $spz_price = 0;
                        $z_freight = 0;
                        $product_id = array();
                        foreach ($r1 as $ke => $va) {
                            $order_details_id = $va->id;
                            $product_id[$ke]['id'] = $va->p_id;
                            $product_id[$ke]['p_price'] = $va->p_price;
                            $product_id[$ke]['num'] = $va->num;
                            $order_num_ = $order_num_ + $va->num;
                            $spz_price += $va->p_price * $va->num;
                            $z_freight += $va->freight;
                            $sql2 = "update lkt_order_details set r_sNo = '$sNo1' where store_id = '$store_id' and id = '$order_details_id'";
                            $r2 = $db->update($sql2);
                            if ($r2 < 1) {
                                $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单号失败！sql:".$sql2);
                                //回滚删除已经创建的订单
                                $db->rollback();
                                echo json_encode(array('code' => 0, 'err' => '操作失败!', "line" => __LINE__));
                                exit;
                            }
                            $oldsno = $va->r_sNo;
                            $sql22 = "update lkt_distribution_record set sNo = '$sNo1' where store_id = '$store_id' and sNo = '$oldsno'";
                            $r22 = $db->update($sql22);
                            if ($r22 < 0) {
                                //回滚删除已经创建分销记录
                                $db->rollback();
                                echo json_encode(array('code' => 0, 'err' => '操作失败!', "line" => __LINE__));
                                exit;
                            }
                        }
                        $data['spz_price'] = $spz_price;
                        $data['pay_time'] = 'CURRENT_TIMESTAMP';

                        $data['reduce_price'] = $spz_price / $z_spz_price * $reduce_price; // 该店铺商品总价 除以 整个订单商品总价 乘以 优惠的满减金额
                        $data['coupon_price'] = $spz_price / $z_spz_price * $coupon_price; // 该店铺商品总价 除以 整个订单商品总价 乘以 优惠的优惠券金额

                        //计算会员特惠
                        $plugin_order = new Plugin_order($store_id);
                        $grade = $plugin_order->user_grade('GM', $spz_price, $user_id, $store_id);
                        $grade_rate = floatval($grade['rate']);

                        $data['z_price'] = ($spz_price - $data['coupon_price'] - $data['reduce_price']) * $grade_rate + $z_freight;
                        if ($status == 0) { // 当订单未付款或未付完全时
                            if ((int)$payment_money >= (int)$data['z_price']) {  // 余额抵扣金额 大于等于 拆分开的订单总价，表示该订单已付款
                                $payment_money = $payment_money - $data['z_price'];
                                $status1 = 1;
                                $data['offset_balance'] = 0;
                                $data['pay'] = 'wallet_pay';
                            } else { // 余额抵扣金额 小于 拆分开的订单总价，表示该订单未付款
                                $data['offset_balance'] = $payment_money;
                                $data['z_price'] = $data['z_price'] - $payment_money;
                                $status1 = 0;
                            }
                        } else {  // 当订单已付款时
                            $status1 = $status; // 订单状态
                        }

                        $data['status'] = $status1;
                        $data['mch_id'] = ',' . $data['mch_id'] . ',';
                        $data['num'] = $order_num_;
                        $r_attribute = $db->insert_array($data, 'lkt_order', '', 1);
                        if ($r_attribute < 1) {
                            $lktlog->customerLog(__METHOD__.":".__LINE__."添加订单失败！sql:".$sql);
                            $db->rollback();
                            echo json_encode(array('code' => 0, 'err' => '操作失败!', "line" => __LINE__));
                            exit;
                        }
                        $sql5 = "update lkt_order_details set r_status = '$status' where store_id = '$store_id' and r_sNo = '$sNo1'";
                        $r5 = $db->update($sql5);
                        if ($r5 == -1) {
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单详情订单号失败！sql:".$sql5);
                            //回滚删除已经创建的订单
                            $db->rollback();
                            echo json_encode(array('code' => 0, 'err' => '操作失败!', "line" => __LINE__));
                            exit;
                        }
                    } else {
                        //回滚删除已经创建的订单
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => '操作失败!', "line" => __LINE__));
                        exit;
                    }
                }
                if ($coupon_id) {
                    $sql3 = "update lkt_coupon set type = 2 where store_id = '$store_id' and id = '$coupon_id'";
                    $r3 = $db->update($sql3);
                    if ($r3 < 0) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."优惠券修改失败！sql:".$sql3);
                        //回滚删除已经创建的订单
                        $db->rollback();
                        echo json_encode(array('code' => 0, 'err' => '优惠券修改失败!',"sql"=>$sql3));
                        exit;
                    }
                }
                $sql4 = "update lkt_order set status = 8 where store_id = '$store_id' and sNo = '$sNo' and user_id = '$user_id'";
                $r4 = $db->update($sql4);
                if ($r4 < 1) {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$sql4);

                    //回滚删除已经创建的订单
                    $db->rollback();
                    echo json_encode(array('code' => 0, 'err' => '操作失败!', "line" => __LINE__));
                    exit;
                }
                $db->commit();
            }

            //订单成功后的推送和消息记录
            LaiKeLogUtils::lktLog("orderAction:推送开始" . $sNo);
            $this->orderMessage($sNo, $store_id, $user_id, $db, $shop_id);
            LaiKeLogUtils::lktLog("orderAction:推送结束");

            echo json_encode(array('code' => 200, 'message' => '成功！'));
            exit;
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 生成订单号
    private function order_number($type, $text = 'sNo')
    {
        $db = DBAction::getInstance();
        if ($type == 'PT') {
            $pay = 'PT';
        } else if ($type == 'HB') {
            $pay = 'HB';
        } else if ($type == 'JP') {
            $pay = 'JP';
        } else if ($type == 'KJ') {
            $pay = 'KJ';
        } else if ($type == 'MS') {
            $pay = 'MS';
        } else if ($type == 'FX') {
            $pay = 'FX';
        } else {
            $pay = 'GM';
        }
        $sNo = $pay . date("ymdhis") . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        $sql = "select * from lkt_order where $text = '$sNo'";
        $res = $db->select($sql);
        if ($res) {
            $this->order_number($pay, $text);
        } else {
            return $sNo;
        }
    }

    // 查询订单
    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $keyword = trim($request->getParameter('ordervalue')); // 商品名称/订单号
        $page = trim($request->getParameter('page')); // 页数
        $lktlog = new LaiKeLogUtils("app/order.log");
        // 获取信息
        $order_type = isset($_POST['order_type']) ? $_POST['order_type'] : false; // 类型

        if (!empty($page) || $page != ''){

            $pagestart = ($page-1)*10;
        }else{
            $pagestart = 0;
        }

        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $r_2 = $db->select($sql);
        if ($r_2) {
            $order_failure = $r_2[0]->order_failure; // 订单失效
            $order_overdue = $r_2[0]->order_overdue; // 订单删除
            if ($r_2[0]->company == '天') {
                $company = "day";
            } else {
                $company = "hour";
            }
            if ($r_2[0]->unit == '天') {
                $unit = "day";
            } else {
                $unit = "hour";
            }
        } else {
            $order_failure = 2;
            $order_overdue = 0;
            $company = "day";
        }

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $userid = $access[0]->user_id;
            if ($order_type == 'payment') {
                $res = " and a.status = 0 "; // 未付款
            } else if ($order_type == 'send') {
                $res = " and a.status = 1 "; // 未发货
            } else if ($order_type == 'receipt') {
                $res = " and a.status = 2 "; // 待收货
            } else if ($order_type == 'evaluete') {
                $res = " and a.status = 3 "; // 待评论
            } else {
                $res = " and a.status != 7 and a.status != 8 and a.status != 9 and a.status != 10 and a.status != 11 ";
            }

            $order = array();
            if (empty($keyword)) {
                // 根据用户id和前台参数,查询订单表 (id、订单号、订单价格、添加时间、订单状态、优惠券id)
                $sql = "SELECT  a.allow,a.id,  a.z_price,  a.sNo,  a.add_time,  a.status,  a.delivery_status,  a.otype,  a.mch_id,  d.sid ,a.offset_balance,p.is_distribution,a.self_lifting,a.spz_price 
                        FROM  lkt_order a
                        RIGHT JOIN lkt_order_details d ON a.sNo = d.r_sNo 
						LEFT JOIN lkt_product_list as p on p.id = d.p_id
                        WHERE a.store_id = " . $store_id . " and a.user_id = '$userid'" . $res . " GROUP BY a.sNo order by add_time desc LIMIT $pagestart,10";
                $r = $db->select($sql);
            } else {
                $sql = "select a.allow,a.id,a.z_price,a.sNo,a.add_time,a.status,a.delivery_status,a.otype,a.mch_id ,a.offset_balance,p.is_distribution,a.self_lifting,a.spz_price 
                from lkt_order as a 
                RIGHT JOIN lkt_order_details as b on a.sNo = b.r_sNo 
                LEFT JOIN lkt_product_list as p on p.id = b.p_id
                where a.store_id = '$store_id' and a.status !=7 and a.status !=8 and a.status !=9 and a.status != 10 and a.status != 11 and a.user_id = '$userid' and (a.sNo like '%$keyword%' or b.p_name like '%$keyword%' )
                order by a.add_time desc 
                LIMIT $pagestart,10";
                $r_1 = $db->select($sql);
                if ($r_1) {
                    $r = $r_1;
                } else {
                    $r = '';
                }
            }
            if ($r) {
                $r = $this->a_array_unique($r);
                $time = date('Y-m-d H:i:s');
                foreach ($r as $k => $v) {
                    $rew = array();
                    $rew['allow'] = $v->allow; // 积分
                    $rew['add_time'] = $v->add_time; // 订单时间
                    $rew['delivery_status'] = $v->delivery_status; // 提醒状态
                    $rew['id'] = $v->id; // 订单id
                    $rew['offset_balance'] = $v->offset_balance; //余额抵扣
                    $rew['otype'] = $v->otype; //订单类型
                    $rew['z_price'] = $v->z_price; // 订单价格
                    $rew['spz_price'] = $v->spz_price; // 商品价格
                    $rew['sNo'] = $v->sNo; // 订单号
                    $sNo = $v->sNo; // 订单号
                    $rew['status'] = $v->status; // 订单状态
                    $rew['self_lifting'] = $v->self_lifting; // 订单状态
                    if ($v->is_distribution == 1) {
                        $rew['otype'] = "FX"; //订单类型
                    }
                    $mch_id = $v->mch_id; // 店主ID

                    // 满减--插件
                    $auto_jian = new subtraction();
                    $subtraction_list = $auto_jian->subtraction_order($db, $store_id, $sNo);

                    $rew['subtraction_list'] = $subtraction_list;

                    //判断是否为多店铺订单hgindex
                    $mch_id_arr_ = explode(',', $mch_id);

                    if (count($mch_id_arr_) > 3) {
                        //是多店铺订单
                        $rew['ismch'] = true;
                    } else {
                        //不是多店铺订单
                        $rew['ismch'] = false;
                    }
                    $shop_list = array();
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
                    //如果为竞拍商品，则查出标题和图片
                    if ($rew['otype'] == 'JP') {
                        $jp_sNo = $rew['sNo'];
                        $sql_jp = "select title,imgurl,current_price from lkt_auction_product where store_id = '$store_id' and trade_no = '$jp_sNo'";
                        $res_jp = $db->select($sql_jp);
                        $jp_title = '';
                        $jp_imgurl = '';
                        $jp_price = '';
                        if ($res_jp) {
                            $jp_title = $res_jp[0]->title;
                            $jp_imgurl = $res_jp[0]->imgurl;

                            $jp_imgurl = ServerPath::getimgpath($jp_imgurl);
                            $jp_price = $res_jp[0]->current_price;
                        }
                        $rew['jp']['jp_title'] = $jp_title;
                        $rew['jp']['jp_imgurl'] = $jp_imgurl;
                        $rew['jp']['jp_price'] = $jp_price;

                    } else if ($rew['otype'] == 'pt') {
                        $rew['pt_price'] = sprintf("%.2f", $v->z_price);
                    }

                    // 根据订单号,查询订单详情
                    $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                    $rew['list'] = $db->select($sql);
                    $z_freight = 0;
                    foreach ($rew['list'] as $kk => $vv) {
                        $freight = $vv->freight;
                        $z_freight += $freight;
                    }

                    if (isset($rew['list'][0]->r_type)) {
                        $rew['r_type'] = $rew['list'][0]->r_type;
                    } else {
                        $rew['r_type'] = '100';
                    }
                    $rew['z_freight'] = $z_freight;
                    $sqlsum = "select sum(num) as sum from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                    $sum23 = $db->select($sqlsum);

                    $rew['sum'] = $sum23[0]->sum;
                    foreach ($rew['list'] as $k_ => $v_) {
                        $v_->integral = floatval($rew['allow']) / floatval($rew['sum']);
                    }
                    unset($product);
                    $product = array();

                    if ($rew['list'] && !empty($rew['list'])) {
                        foreach ($rew['list'] as $key => $values) {
                            if (strpos($values->r_sNo, 'PT') !== false) {
                                $rew['pro_id'] = $values->p_id;
                            }
                            $sid = $values->sid; // 产品id
                            $p_id = $values->p_id; // 产品id
                            if ($rew['ismch']) {
                                $sel_mch_sql = "SELECT m.id,m.name,m.logo  from lkt_product_list as l 
                                            LEFT JOIN lkt_mch as m on l.mch_id = m.id
                                            where l.id= $p_id";
                                $mch_res = $db->select($sel_mch_sql);
                                $values->shop_id = $mch_res[0]->id;
                                $values->shop_name = $mch_res[0]->name;
                                $values->shop_logo = ServerPath::getimgpath($mch_res[0]->logo);
                            }

                            $size = $values->size;
                            $size = explode(' ', $size);
                            $size = implode(';', $size);
                            $size = ltrim($size, ";");
                            $values->size = $size;


                            $values->attribute_id = $values->sid; // 属性id
                            $arr = (array)$values;
                            // 根据产品id,查询产品列表 (产品图片)
                            $sql = "select imgurl from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                            $rrr = $db->select($sql);
                            if ($rrr) {
                                $img_res = $rrr['0']->imgurl;
                                $url = ServerPath::getimgpath($img_res); // 拼图片路径
                                $arr['imgurl'] = $url;

                                if ($rew['otype'] == 'integral') {
                                    $sql = "select img from lkt_configure where id=" . $sid;
                                    $rrr = $db->select($sql);
                                    if ($rrr) {
                                        $arr['imgurl'] = ServerPath::getimgpath($rrr[0]->img); // 拼图片路径
                                    }
                                }

                                $product[$key] = (object)$arr;
                            }


                            $r_status = $values->r_status; // 订单详情状态
                            $sql_o = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' AND r_type = 0 AND r_status = '$r_status' and r_status != -1 ";
                            $res_o = $db->selectrow($sql_o);

                            $sql_d = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                            $res_d = $db->selectrow($sql_d);

                            // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                            if ($res_o == $res_d && $rew['otype'] != 'pt') {
                                //如果订单数量相等 则修改父订单状态
                                $sql = "update lkt_order set status = '$r_status' where store_id = '$store_id' and sNo = '$sNo'";
                                $r = $db->update($sql);
                                if($r < 1){
                                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单详情状态失败！sql:".$sql);
                                }
                                if ($r_status > 0) {
                                    $rew['status'] = $r_status;
                                }
                            }
                        }
                        $rew['list'] = $product;

                        if ($rew['otype'] == 'pt' && $order_type == 'payment') {
                            //如果是拼团未付款的订单，进入判断
                            //查询所有关闭了，结束了的活动商品id(attr_id)的
                            $sql = 'SELECT * from lkt_group_product';
                            $group_cfg = $db->select($sql);
                            $can_open = 1;
                            $close = array();
                            foreach ($group_cfg as $ks => $vs) {
                                $e_time = strtotime(unserialize($vs->group_data)->endtime);//获取结束时间戳
                                if ($e_time < time()) {
                                    //活动已经结束
                                    $close[$ks] = $vs->attr_id;
                                } else if ($vs->g_status != 2) {
                                    //活动已经关闭
                                    $close[$ks] = $vs->attr_id;
                                }
                            }
                            //比较订单是否是该商品
                            $isin_ = in_array($rew['list'][0]->attribute_id, $close);

                            if ($isin_) {
                                $can_open = 0;
                            }
                            //如果是，can_open = 0
                            $rew['can_open'] = $can_open;

                        }
                    }

                    $order[] = $rew;
                }
            } else {
                $order = '';
            }
            echo json_encode(array('code' => 200, 'order' => $order, 'order_failure' => $order_failure, 'company' => $company, 'message' => '操作成功'));
            exit();
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 查询订单-加载更多
    public function load_more()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $order_type = isset($_POST['order_type']) ? $_POST['order_type'] : false; // 类型
        $num = trim($request->getParameter('page')); // 加载次数
        $lktlog = new LaiKeLogUtils("app/order.log");
        if (!$num) {
            $num = 1;
        }
        $start = $num * 10;
        $end = 10;

        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $r_2 = $db->select($sql);
        if ($r_2) {
            $order_failure = $r_2[0]->order_failure; // 订单失效
            $order_overdue = $r_2[0]->order_overdue; // 订单删除
            if ($r_2[0]->company == '天') {
                $company = "day";
            } else {
                $company = "hour";
            }
            if ($r_2[0]->unit == '天') {
                $unit = "day";
            } else {
                $unit = "hour";
            }
        } else {
            $order_failure = 2;
            $order_overdue = 0;
            $company = "day";
        }
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $userid = $access[0]->user_id;
            if ($order_type == 'payment') {
                $res = " and a.status = 0 "; // 未付款
            } else if ($order_type == 'send') {
                $res = " and a.status = 1 "; // 未发货
            } else if ($order_type == 'receipt') {
                $res = " and a.status = 2 "; // 待收货
            } else if ($order_type == 'evaluete') {
                $res = " and a.status = 3 "; // 待评论
            } else {
                $res = " and a.status != 7 and a.status != 9 and a.status != 10 and a.status != 11 ";
            }
            $order = array();

            // 根据用户id和前台参数,查询订单表 (id、订单号、订单价格、添加时间、订单状态、优惠券id、订单类型)
            $sql = "select a.id,a.z_price,a.sNo,a.add_time,a.status,a.otype,p.is_distribution,a.mch_id,a.self_lifting
			from lkt_order as a 
			        RIGHT JOIN lkt_order_details d ON a.sNo = d.r_sNo 
					LEFT JOIN lkt_product_list as p on p.id = d.p_id
			where a.store_id = '$store_id' and a.status != 7 and a.status != 8  and a.user_id = '$userid' " . $res . "
			group by a.sNo
			order by a.add_time desc LIMIT $start,$end";
            $r = $db->select($sql);
            $time = date('Y-m-d H:i:s', time());
            if (!empty($r)) {
                //hgload
                foreach ($r as $k => $v) {
                    $rew = array();
                    $rew['id'] = $v->id; // 订单id
                    $rew['z_price'] = $v->z_price; // 订单价格
                    $rew['sNo'] = $v->sNo; // 订单号
                    $sNo = $v->sNo; // 订单号
                    $rew['add_time'] = $v->add_time; // 订单时间
                    $rew['status'] = $v->status; // 订单状态
                    $rew['otype'] = $v->otype; //订单类型-主要判断是否为竞拍订单
                    $rew['self_lifting'] = $v->self_lifting; // 订单状态
                    $mch_id = $v->mch_id; //订单类型-主要判断是否为竞拍订单
                    if ($v->is_distribution == 1) {
                        $rew['otype'] = "FX"; //订单类型
                    }
                    //判断是否为多店铺订单
                    $mch_id_arr_ = explode(',', $mch_id);

                    if (count($mch_id_arr_) > 3) {
                        //是多店铺订单
                        $rew['ismch'] = true;
                    } else {
                        //不是多店铺订单
                        $rew['ismch'] = false;
                    }
                    $shop_list = array();
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
                    // 满减--插件
                    $auto_jian = new subtraction();
                    $subtraction_list = $auto_jian->subtraction_order($db, $store_id, $sNo);

                    $rew['subtraction_list'] = $subtraction_list;
                    $time1 = date('Y-m-d H:i:s', strtotime("+$order_failure $company"));
                    if ($rew['status'] == 0 && $time1 <= $time) {
                        $sql11 = "update lkt_order set status = 6 where store_id = '$store_id' and id = " . $rew['id'];
                        $up_res1 = $db->update($sql11);
                        $sql22 = "update lkt_order_details set r_status = 6 where store_id = '$store_id' and r_sNo = " . $rew['sNo'];
                        $up_res2 = $db->update($sql22);
                        if($up_res1<1 || $up_res2<1){
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$sql11.'-'.$sql22);
                        }
                        $rew['status'] = 6;
                    }
                    //如果为竞拍商品，查询出标题和imgurl
                    if ($rew['otype'] == 'JP') {

                        $jp_sNo = $rew['sNo'];
                        $sql_jp = "select title,imgurl from lkt_auction_product where store_id = '$store_id' and trade_no = '$jp_sNo'";
                        $res_jp = $db->select($sql_jp);
                        $jp_title = $res_jp[0]->title;
                        $jp_imgurl = $res_jp[0]->imgurl;
                        $jp_imgurl = ServerPath::getimgpath($jp_imgurl);

                        $rew['jp_title'] = $jp_title;
                        $rew['jp_imgurl'] = $jp_imgurl;
                    }

                    // 根据订单号,查询订单详情
                    $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                    $rew['list'] = $db->select($sql);
                    $z_freight = 0;
                    foreach ($rew['list'] as $kk => $vv) {
                        $freight = $vv->freight;
                        $z_freight += $freight;
                    }
                    $rew['z_freight'] = $z_freight;
                    $sqlsum = "select sum(num) as sum from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                    $sum23 = $db->select($sqlsum);

                    $rew['sum'] = $sum23[0]->sum;
                    unset($product);
                    $product = array();
                    if ($rew['list'] && !empty($rew['list'])) {
                        foreach ($rew['list'] as $key => $values) {
                            $p_id = $values->p_id; // 产品id
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

                            $r_status = $values->r_status; // 订单详情状态

                            $sql_o = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' AND r_type = 0 AND r_status = '$r_status' and r_status != -1 ";
                            $res_o = $db->selectrow($sql_o);

                            $sql_d = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                            $res_d = $db->selectrow($sql_d);

                            // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                            if ($res_o == $res_d) {
                                //如果订单数量相等 则修改父订单状态
                                $sql = "update lkt_order set status = '$r_status' where store_id = '$store_id' and sNo = '$sNo'";
                                $r = $db->update($sql);
                                if($r<1){
                                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$sql);
                                }
                            }
                            if ($r_status > 0) {
                                $rew['status'] = $r_status;
                            }
                        }
                        $rew['list'] = $product;
                        if ($rew['otype'] == 'pt' && $order_type == 'payment') {
                            //如果是拼团未付款的订单，进入判断
                            //查询所有关闭了，结束了的活动商品id(attr_id)的
                            $can_open = 1;
                            $sql = 'SELECT * from lkt_group_product';
                            $group_cfg = $db->select($sql);
                            $close = array();
                            foreach ($group_cfg as $ks => $vs) {
                                $e_time = strtotime(unserialize($vs->group_data)->endtime);//获取结束时间戳
                                if ($e_time < time()) {
                                    //活动已经结束
                                    $close[$ks] = $vs->attr_id;
                                } else if ($vs->g_status != 2) {
                                    //活动已经关闭
                                    $close[$ks] = $vs->attr_id;
                                }
                            }
                            //比较订单是否是该商品
                            $isin_ = in_array($rew['list'][0]->attribute_id, $close);

                            if ($isin_) {
                                $can_open = 0;
                            }
                            //如果是，can_open = 0
                            $rew['can_open'] = $can_open;
                        }
                    }
                    $order[] = $rew;
                }
            } else {
                $order = '';
            }
            echo json_encode(array('code' => 200, 'order' => $order, 'order_failure' => $order_failure, 'company' => $company, 'message' => '操作成功'));
            exit();
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 订单详情确认收货
    public function recOrder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('id')); // 订单详情id
        $time = date('Y-m-d H:i:s');
        $mch = new mch();

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $user_id = $access[0]->user_id;
            $sql01 = "select r_sNo from lkt_order_details where store_id = '$store_id' and id = '$id' and user_id = '$user_id'";
            $rew = $db->select($sql01);
            if ($rew) {
                $r_sNo = $rew[0]->r_sNo;
                $type = substr($r_sNo, 0, 2);//获取订单号前两位字母（类型）

                $sql02 = "select z_price,otype,allow from lkt_order where store_id = '$store_id' and sNo = '$r_sNo'";
                $r02 = $db->select($sql02);
                $z_price = $r02[0]->z_price;
                $allow = $r02[0]->allow;
                $otype = $r02[0]->otype;
                // 根据订单详情id,修改订单详情
                if ($type == 'JP') {
                    //如果为竞拍订单，则确认收货后，关闭订单
                    $sql = "update lkt_order_details set r_status = 5,arrive_time = '$time' where store_id = '$store_id' and id = '$id'";
                } else {
                    $sql = "update lkt_order_details set r_status = 3,arrive_time = '$time' where store_id = '$store_id' and id = '$id'";
                }
                $r = $db->update($sql);
                if ($r > 0) {
                    $sql = "select p_id,num,r_status from lkt_order_details where store_id = '$store_id' and r_sNo = '$r_sNo'";
                    $rr = $db->select($sql);
                    $num = 0;
                    foreach ($rr as $k => $v) {
                        if ($v->r_status >= 3) {
                            $num++;
                        } else {
                            $num = $num;
                        }
                        $p_id = $v->p_id;
                        $p_num = $v->num;
                        $sql_x = "update lkt_product_list set volume = volume + '$p_num' where store_id = '$store_id' and id = '$p_id'";
                        $r_x = $db->update($sql_x);
                        if ($r_x < 1) {
                            $db->rollback();
                            echo json_encode(array('code' => 103, 'message' => '网络繁忙！', 'err' => $sql_x));
                            exit;
                        }
                    }
                    if (count($rr) == $num) {
                        // 根据订单详情id,修改订单详情
                        if ($type == 'JP') {
                            //如果为竞拍订单，则确认收货后，关闭订单
                            $sql = "update lkt_order set status = 5 where store_id = '$store_id' and sNo = '$r_sNo'";
                        } else {
                            $sql = "update lkt_order set status = 3 where store_id = '$store_id' and sNo = '$r_sNo'";
                        }

                        $db->update($sql);
                    }

                    //不是会员赠送商品
                    if ($otype != 'vipzs') {
                        $grade = new Plugin_order($store_id);
                        $grade->unlock_jifen($db, $user_id, $r_sNo, $store_id);
                        $grade->jifen($db, $user_id, $r_sNo, $store_id, 1);
                        $grade->back($db, $user_id, $r_sNo, $store_id, 1);
                    }
                    $this->db = $db;
                    $this->user_id = $user_id;
                    $this->store_id = $store_id;
                    $this->check_invitation($user_id);

                    $mch->parameter($db, $store_id, $r_sNo, $z_price,$allow);
                    $db->commit();

                    echo json_encode(array('code' => 200, 'message' => '操作成功'));
                    exit();
                } else {
                    $this->db = $db;
                    $this->user_id = $user_id;
                    $this->store_id = $store_id;
                    $this->check_invitation($user_id);

                    $mch->parameter($db, $store_id, $r_sNo, $z_price,$allow);
                    $db->commit();

                    echo json_encode(array('code' => 200, 'message' => '操作成功'));
                    exit();
                }
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
        return;
    }

    /*
     *  订单列表确认收货
     */
    public function ok_Order()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $order_id = trim($request->getParameter('order_id')); // 订单id
        $r_type = trim($request->getParameter('r_type')); // 订单id
        $lktlog = new LaiKeLogUtils("app/order.log");

        $db->begin();

        $time = date('Y-m-d H:i:s');
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            if ($r_type == 11) {
                //查询订单信息
                $sqlz = "select sNo from lkt_order_details where id = $store_id";
                $resz = $db->select($sqlz);

                $sql_1 = "update lkt_order_details set r_type = 12,r_status = 5  where store_id = '$store_id' and id = '$order_id'";
                $res = $db->update($sql_1);
                if(!empty($resz)){
                    $otype = $resz[0]->otype;
                    $sNo = $resz[0]->sNo;
                    if($otype == 'pt' || $otype == 'PT'){
                        $sql_2 = "update lkt_order set status = 5  where store_id = '$store_id' and sNo = '$sNo'";
                        $res2 = $db->update($sql_2);
                    }
                }
                $ret = array();
                $ret['code'] = 500;
                $ret['message'] = '收货失败！';
                if ($res < 1) {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."确认收货失败！sql:".$sql_1);
                    //失败
                    echo json_encode($ret);
                    $db->rollback();
                    exit;
                } else {
                    //成功
                    $ret['code'] = 200;
                    $ret['message'] = '收货成功！';
                    echo json_encode($ret);
                    $db->commit();
                    exit;
                }
            }
            $user_id = $access[0]->user_id;
            $sql = "select sNo,z_price,otype,allow from lkt_order where store_id = '$store_id' and id = '$order_id' and user_id = '$user_id'";
            $r = $db->select($sql);
            if ($r) {
                $sNo = $r[0]->sNo;
                $allow = $r[0]->allow;
                $z_price = $r[0]->z_price;
                $otype = $r[0]->otype;
                $type = substr($sNo, 0, 2);//获取订单号前两位字母（类型）
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误'));
                exit();
            }

            $sql = "select id,r_status,p_price,num,p_id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' and user_id = '$user_id'";
            $rr = $db->select($sql);

            if ($rr) {

                foreach ($rr as $k => $v) {
                    $id = $v->id;
                    $moneyy = floatval($v->p_price) * intval($v->num);

                    if ($v->r_status == 2) {

                        if ($type == 'JP') {
                            //如果为竞拍订单，则确认收货后，关闭订单
                            $sql_1 = "update lkt_order_details set r_status = 5, arrive_time = '$time' where store_id = '$store_id' and r_sNo = '$sNo' and id = '$id'";
                        } else {
                            $sql_1 = "update lkt_order_details set r_status = 3, arrive_time = '$time' where store_id = '$store_id' and r_sNo = '$sNo' and id = '$id'";
                        }
                        $r_1 = $db->update($sql_1);
                        $p_id = $rr[0]->p_id;
                        $sql = "SELECT is_distribution from lkt_product_list where id = $p_id and store_id = '$store_id'";
                        $zz_res = $db->select($sql);
                        if ($zz_res[0]->is_distribution == 1) {
                            //佣金发放
                            $comm = new Commission();
                            $comm->putcomm($db, $store_id, $sNo, $moneyy);
                        }
                        $sql01 = "select otype from lkt_order where store_id = $store_id and sNo = '$sNo'";
                        $res01 = $db->select($sql01);
                        //不是会员赠送商品
                        if ($otype != 'vipzs') {
                            $grade = new Plugin_order($store_id);
                            $grade->unlock_jifen($db, $user_id, $sNo, $store_id);
                            $grade->jifen($db, $user_id, $sNo, $store_id, 1);
                            $grade->back($db, $user_id, $sNo, $store_id, 1);
                        }
                        //佣金发放  end
                    } else if ($v->r_status == 4) {
                        $sql_1 = "update lkt_order_details set r_status = 3,r_type = 8, r_content = '已收货' where store_id = '$store_id' and r_sNo = '$sNo' and id = '$id'";
                        $r_1 = $db->update($sql_1);
                        if($r_1 < 1){
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单信息失败！sql:".$sql);
                        }
                    }

                    $p_id = $v->p_id;
                    $p_num = $v->num;
                    $sql_x = "update lkt_product_list set volume = volume + '$p_num' where store_id = '$store_id' and id = '$p_id'";
                    $r_x = $db->update($sql_x);
                    if ($r_x < 1) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改商品销量失败！sql:".$sql_x);
                        $db->rollback();
                        echo json_encode(array('code' => 103, 'message' => '网络繁忙！', 'err' => $sql_x));
                        exit;
                    }
                }
                if ($type == 'JP') {
                    //如果为竞拍订单，则确认收货后，关闭订单
                    $sql_2 = "update lkt_order set status = 5 where store_id = '$store_id' and sNo = '$sNo'";
                } else {
                    $sql_2 = "update lkt_order set status = 3 where store_id = '$store_id' and sNo = '$sNo'";
                }

                $r_2 = $db->update($sql_2);
                if ($r_2 > 0) {
                    $this->db = $db;
                    $this->user_id = $user_id;
                    $this->store_id = $store_id;

                    $this->check_invitation($user_id);

                    $coupon_list = '';
                    $mch = new mch();
                    if ($otype != 'vipzs') {
                        $mch->parameter($db, $store_id, $sNo, $z_price,$allow);
                    }
                    $db->commit();

                    echo json_encode(array('code' => 200, 'coupon_list' => $coupon_list, 'message' => '操作成功'));
                    exit();
                } else {
                    echo json_encode(array('code' => 103, 'message' => '网络繁忙!', 'err' => $sql_2));
                    exit();
                }
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误3223'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
        return;
    }

    // 查看物流
    public function logistics()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('id'));// 订单号
        $details = $request->getParameter('details'); // 订单详情id

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {

            $r_status = 0;

            $type = trim($request->getParameter('type'));

            // 根据订单详情id,修改订单详情
            if ($details) {
                $sql = "select id,express_id,courier_num,r_status from lkt_order_details where store_id = '$store_id' and r_sNo = '$id' AND id = '$details' ";
                $r = $db->select($sql);

            } else {
                $sql = "select id,express_id,courier_num,r_status from lkt_order_details where store_id = '$store_id' and r_sNo = '$id' group by courier_num";
                $r = $db->select($sql);

            }
            $oid = $r[0]->id;
            $r_status = $r[0]->r_status;

            if ($r) {

                if ($r_status == 4) {
                    $sql = "select express,express_num from lkt_return_goods where store_id = '$store_id' and oid = '$oid' order by id desc";
                    $r = $db->select($sql);
                    if ($r) {
                        $kuaidi_name = $r[0]->express; // 快递公司名称
                        $courier_num = $r[0]->express_num;//快递单号
                        $sql01 = "select * from lkt_express where kuaidi_name = '$kuaidi_name'";
                        $r01 = $db->select($sql01);
                        $type = $r01[0]->type;//快递公司代码

                    } else {
                        echo json_encode(array('code' => 108, 'message' => '暂无数据!'));
                        exit();
                    }
                } else {
                    $rew = array();
                    foreach ($r as $k => $v){
                        if (!empty($v->express_id) && !empty($v->courier_num)) {
                            $express_id = $v->express_id;//快递公司ID
                            $courier_num = $v->courier_num;//快递单号
                            $sql01 = "select * from lkt_express where id = '$express_id'";
                            $r01 = $db->select($sql01);
                            $type = $r01[0]->type;//快递公司代码
                            $kuaidi_name = $r01[0]->kuaidi_name; // 快递公司名称

                            $res_1 = LogisticsTool::getLogistics($type, $courier_num);
                            $list['list'] = $res_1;
                            $list['code'] = 200;
                            $list['kuaidi_name'] = $kuaidi_name;
                            $list['courier_num'] = $courier_num;
                            $list['type'] = $type;
                            $list['pro_list'] = array();

                            //查询一个快递下的商品信息
                            $sel_pro_sql = "SELECT sid FROM lkt_order_details WHERE r_sNo = '$id' and courier_num = '$courier_num' and store_id = $store_id";
                            $pro_res = $db->select($sel_pro_sql);
                            if($pro_res){

                                foreach ($pro_res as $kk => $vv){
                                    //查询商品规格
                                    $sid = $vv->sid;
                                    $sel_size_sql = "SELECT * FROM lkt_configure where id = $sid ";
                                    $size_res = $db->select($sel_size_sql);

                                    $sel_pro_sql2 = "SELECT num FROM lkt_order_details WHERE r_sNo = '$id' and courier_num = '$courier_num' and store_id = $store_id and sid = $sid";
                                    $pro_res2 = $db->select($sel_pro_sql2);

                                    $img = ServerPath::getimgpath($size_res[0]->img,$store_id);// 商品图片
                                    $pro_res1['img'] = $img;
                                    $pro_res1['num'] = $pro_res2[0]->num;
                                    $list['pro_list'][] = $pro_res1;
                                }

                            }
                        } else {
                            $list['code'] = 108;
                            $list['list'] = array();
                        }
                        $rew['res'][] = $list;

                    }
                    $rew['code'] = 200;
                    $rew['message'] = '操作成功！';

                    echo  json_encode($rew);
                    exit;
                }

                $res_1 = LogisticsTool::getLogistics($type, $courier_num);;
                echo json_encode(array('code' => 200, 'res_1' => $res_1, 'name' => $kuaidi_name, 'courier_num' => $courier_num, 'message' => '操作成功'));
                exit();

            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 取消订单
    public function removeOrder()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 1.开启事务

        $db->begin();
        $coupon = new coupon();

        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('order_id'));// 订单id
        $lktlog = new LaiKeLogUtils("app/order.log");
        // 根据微信id,查询用户id
        $sql = "select user_id,money from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $user_id = $access[0]->user_id;
            $money = $access[0]->money;
            // 根据订单id,查询订单列表(订单号)
            $sql = "select sNo,status,z_price,otype,coupon_id,subtraction_id,offset_balance from lkt_order where store_id = '$store_id' and id = '$id' and user_id = '$user_id'";
            $r = $db->select($sql);
            if ($r) {
                $sNo = $r[0]->sNo; // 订单号
                $status = $r[0]->status; // 订单状态
                $z_price = $r[0]->z_price; // 订单总价
                $coupon_id = $r[0]->coupon_id; // 优惠券id
                $subtraction_id = $r[0]->subtraction_id; // 满减活动ID
                $offset_balance = $r[0]->offset_balance;
                $otype = $r[0]->otype;
                if ($otype == 'vipzs') {
                    $up_user_frist_sql = "update lkt_user_first set is_use = 0 , sNo = '' where sNo = '$sNo' and store_id = $store_id";
                    $rr = $db->update($up_user_frist_sql);
                    if($rr < 1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户会员第一次开会员信息失败！sql:".$up_user_frist_sql);
                    }
                }
                switch ($status) {
                    case 0:
                        $event = $user_id . '取消订单号为' . $sNo . '的订单';

                        break;
                    case 1:
                        $sql = "update lkt_user set money = money + '$z_price' where store_id = '$store_id' and user_id = '$user_id'";
                        $r_r = $db->update($sql);
                        if($r_r < 1){
                            $lktlog->customerLog(__METHOD__.":".__LINE__."取消订单失败！sql:".$sql);
                        }

                        $event = $user_id . '取消订单号为' . $sNo . '的订单';
                        $sql = "insert into lkt_record (store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','$user_id','$z_price','$money',CURRENT_TIMESTAMP,'$event',23)";
                        $ist_res = $db->insert($sql);
                        if($ist_res<1){
                            $lktlog->customerLog(__METHOD__.":".__LINE__."添加记录失败！sql:".$sql);
                        }
                        break;
                    case 2:
                        echo json_encode(array('code' => 202, 'message' => '买家已发货!'));
                        exit();
                        break;
                    default:
                        if ($offset_balance > 0) {
                            //修改用户余额
                            $sql = "update lkt_user set money = money + '$offset_balance' where store_id = '$store_id' and user_id = '$user_id'";
                            $res = $db->update($sql);
                            if($res < 1){
                                $lktlog->customerLog(__METHOD__.":".__LINE__."修改用户余额失败！sql:".$sql);
                            }
                            //添加日志
                            $event = $user_id . '退款' . $offset_balance . '元余额';
                            $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$offset_balance','$offset_balance','$event',5)";
                            $rr = $db->insert($sqll);
                            if($rr<1){
                                $lktlog->customerLog(__METHOD__.":".__LINE__."添加记录失败！sql:".$sqll);
                            }
                        }
                        break;
                }

                $sql = "update lkt_order set status = 6,coupon_id = 0 where store_id = '$store_id' and id = '$id' and user_id = '$user_id'";
                $r1 = $db->update($sql);
                if($r1 < 1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$sql);
                }
                $sql = "update lkt_order_details set r_status = 6 where store_id = '$store_id' and r_sNo = '$sNo'";
                $r2 = $db->update($sql);
                if($r2 < 1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$sql);
                }
                if ($r1 >= 0 && $r2 >= 0) {
                    $sql = "update lkt_coupon set type = 0 where store_id = '$store_id' and id = '$coupon_id'";
                    $r3 = $db->update($sql);
                    if ($r3 == -1) {
                        $coupon_Log_content = '会员' . $user_id . '取消订单号为' . $sNo . '时,修改优惠券ID为' . $coupon_id . '的状态失败！';
                        $coupon->couponLog($coupon_id, $coupon_Log_content);
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改优惠卷类型失败！sql:".$sql);

                        $db->rollback();
                        echo json_encode(array('code' => 110, 'message' => '业务异常2!'));
                        exit();
                    }
                    $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                    $r_1 = $db->select($sql);
                    foreach ($r_1 as $k => $v) {
                        $pid = $v->p_id;
                        $Goods_num = $v->num;
                        $attribute_id = $v->sid;
                        $sql = "update lkt_product_list set num = num + '$Goods_num' where store_id = '$store_id' and id = '$pid'";
                        $r_r1 = $db->update($sql);
                        if($r_r1 < 1){
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改商品库存失败！sql:".$sql);
                        }
                        $sql = "update lkt_configure set num = num + '$Goods_num' where id = '$attribute_id'";
                        $r_r2 = $db->update($sql);
                        if($r_r2 < 1){
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改商品属性库存失败！sql:".$sql);
                        }
                    }
                    if ($subtraction_id != 0) {
                        $subtraction = new subtraction();
                        $subtraction->give_num($db, $store_id, $sNo);
                    }
                    //如果为竞拍商品则将竞拍记录中的订单编号置为NULL并删除订单
                    $jp_type = substr($sNo, 0, 2);
                    if ($jp_type == 'JP') {
                        $sql_0 = "update lkt_auction_product set trade_no = NULL where store_id = '$store_id' and trade_no = '$sNo'";
                        $res_0 = $db->update($sql_0);

                        $sNo = $r[0]->sNo; // 订单号
                        $sql_1 = "update lkt_order_details set r_status = 7 where store_id = '$store_id' and r_sNo = '$sNo'";
                        $res_1 = $db->update($sql_1);
                        if($res_1 < 1){
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单详情状态失败！sql:".$sql);
                        }
                        $sql_2 = "update lkt_order set status = 7 where store_id = '$store_id' and sNo = '$sNo'";
                        $res_2 = $db->update($sql_2);
                        if($res_2 < 1){
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$sql);
                        }
                        if ($res_0 < 0 || $res_1 < 0 || $res_2 < 0) {
                            $db->rollback();

                            echo json_encode(array('code' => 110, 'message' => '取消竞拍订单失败'));
                            exit;
                        }
                    }
                    if ($otype == "MS") {
                        $redis = new RedisClusters();
                        $re = $redis->connect();

                        //如果是秒杀订单 还原秒杀数量 ， 和redis
                        $sel_ms_record = "select * from lkt_seconds_record where store_id = $store_id and sNo = '$sNo' and user_id = '$user_id'";
                        $ms_record_res = $db->select($sel_ms_record);
                        if (!empty($ms_record_res)) {
                            $activity_id = $ms_record_res[0]->activity_id;
                            $time_id = $ms_record_res[0]->time_id;
                            $pro_id = $ms_record_res[0]->pro_id;
                            $num = $ms_record_res[0]->num;

                            $isremove = $redis->get("add_sec_num" . $activity_id . "_" . $time_id . "_" . $pro_id . "_" . $num);
                            if (!$isremove) {
                                $redis->set("add_sec_num" . $activity_id . "_" . $time_id . "_" . $pro_id . "_" . $num, '1', 5);
                                $redis_name = "seconds_" . $activity_id . "_" . $time_id . "_" . $pro_id;

                                for ($i = 0; $i < $num; $i++) {
                                    $up_sec_num_sql = "update lkt_seconds_pro set num = num + 1 where store_id = '$store_id' and activity_id = $activity_id and time_id = $time_id and pro_id = $pro_id";
                                    $rrr = $db->update($up_sec_num_sql);
                                    if($rrr < 1){
                                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改秒杀商品库存失败！sql:".$sql);
                                    }
                                    $aa = $redis->lpush($redis_name, 1);

                                }
                            }


                            $redis->close();

                        }
                    }

                    $coupon_Log_content = '会员' . $user_id . '取消订单号为' . $sNo . '时,修改优惠券ID为' . $coupon_id . '的状态！';
                    $coupon->couponLog($coupon_id, $coupon_Log_content);
                    $db->commit();
                    echo json_encode(array('code' => 200, 'message' => '成功!'));
                    exit();
                } else {

                    $coupon_Log_content = '会员' . $user_id . '取消订单号为' . $sNo . '时失败';
                    $coupon->couponLog($coupon_id, $coupon_Log_content);
                    $db->rollback();

                    echo json_encode(array('code' => 110, 'message' => '业务异常1!'));
                    exit();
                }
            } else {
                $db->rollback();

                echo json_encode(array('code' => 109, 'message' => '参数错误'));
                exit();
            }
        } else {
            $db->rollback();

            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
        return;
    }

    /*
     * 订单详情
     */
    public function order_details()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('order_id')); // 订单id
        $lktlog = new LaiKeLogUtils("app/order.log");
        $jp = array();

        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $r_2 = $db->select($sql);
        if ($r_2) {
            $order_failure = $r_2[0]->order_failure; // 订单失效
            $order_after = $r_2[0]->order_after; // 订单售后时限
            if ($r_2[0]->company == '天') {
                $company = "day";
            } else {
                $company = "hour";
            }

        } else {
            $order_after = 7; // 订单售后时限
            $order_failure = 2;
            $company = "day";
        }
        $time = date('Y-m-d H:i:s');

        $payment_config = Tools::getPayment($db,$store_id);// 支付方式配置

        // 根据微信id,查询用户id
        $sql = "select user_id,login_num,verification_time,password from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $user_id = $access[0]->user_id;
            $login_num = $access[0]->login_num; // 支付密码错误次数
            $verification_time = $access[0]->verification_time; // 支付密码验证时间
            $verification_time = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($verification_time)));
            $user_password = $access[0]->password;
            if ($user_password != '') {
                $password_status = 1;
            } else {
                $password_status = 0;
            }
            if ($login_num == 5) {
                if ($time < $verification_time) {
                    $enterless = false;
                } else {
                    $sql = "update lkt_user set login_num = 0 where store_id = '$store_id' and user_id = '$user_id'";
                    $db->update($sql);
                    $enterless = true;
                }
            } else {
                $enterless = true;
            }

            $sql = "select * from lkt_order where store_id = '$store_id' and id = '$id' and user_id = '$user_id'";
            $r = $db->select($sql);
            if ($r) {
                $sNo = $r[0]->sNo; // 订单号
                $z_price = $r[0]->z_price; // 总价
                $status = $r[0]->status;//订单状态
                if ($r[0]->otype == 'pt' && $r[0]->z_price != $r[0]->offset_balance && $status != 0) {
                    $z_price = $r[0]->z_price + $r[0]->offset_balance;
                }
                $hand_del = 0;
                if ($status == 6) {
                    //如果订单是关闭状态，查询是手动关闭还是自动guanbi
                    $del_type_sql = "SELECT * FROM lkt_record WHERE type = 23 and event like '%$sNo%'";
                    $del_type = $db->select($del_type_sql);
                    if (!empty($del_type)) {
                        $hand_del = 1;
                    }
                }
                $add_time = $r[0]->add_time; // 订单时间
                $remarks = $r[0]->remarks; // 订单备注
                $name = $r[0]->name;//联系人
                $mobile1 = $r[0]->mobile;//联系手机号
                $mobile = substr_replace($mobile1, '****', 3, 4);//隐藏操作
                $address = $r[0]->sheng . $r[0]->shi . $r[0]->xian . $r[0]->address;//联系地址
                $otype = $r[0]->otype;//订单类型
                $ptcode = $r[0]->ptcode;//拼团编号
                $pid = $r[0]->pid;//拼团订单类型
                $coupon_activity_name = $r[0]->coupon_activity_name;//自动满减名称
                if ($r[0]->reduce_price != 0){
                    $coupon_activity_name = "￥".$r[0]->reduce_price;
                }
                $coupon_id = $r[0]->coupon_id;// 优惠券ID
                $coupon_price = $r[0]->coupon_price;// 优惠券金额
                $offset_balance = $r[0]->offset_balance;// 余额抵扣
                $comm_discount = $r[0]->comm_discount;// 分销折扣
                $mch_id = trim($r[0]->mch_id, ','); // 店铺ID
                $grade_rate = $r[0]->grade_rate;//会员等级折扣
                $delivery_status = $r[0]->delivery_status;//提醒状态
                $self_lifting = $r[0]->self_lifting; // 是否自提
                $coupon_name = '';
                $sql0 = "select a.activity_type,a.discount from lkt_coupon_activity as a left join lkt_coupon as b on a.id = b.hid where a.store_id = '$store_id' and b.id = '$coupon_id'";
                $r0 = $db->select($sql0);
                if ($r0) {
                    if ($r0[0]->activity_type == 2) {
                        $coupon_name = '(' . $r0[0]->discount * 10 . '折)';
                    }
                }
                //如果为竞拍订单，则返回标题,imgurl
                if ($otype == 'JP') {
                    $jp_sNo = $sNo;
                    $sql_jp = "select title,imgurl,current_price from lkt_auction_product where store_id = '$store_id' and trade_no = '$jp_sNo'";
                    $res_jp = $db->select($sql_jp);
                    $jp = array();
                    $jp['title'] = $res_jp[0]->title;
                    $jp_imgurl = $res_jp[0]->imgurl;
                    $jp['imgurl'] = ServerPath::getimgpath($jp_imgurl);
                    $jp_price = $res_jp[0]->current_price;
                    $jp['jp_price'] = $jp_price;

                }

                if ($pid == 'cantuan') {            //参团订单，查询团的结束时间
                    $ptcode = $r[0]->ptcode;
                    $gsql = "select ptstatus,endtime from lkt_group_open where ptcode='$ptcode'";
                    $gstatus = $db->select($gsql);
                    $gstatus = (array)$gstatus[0];
                } else {
                    $gstatus = array();
                }
                if ($status) { // 付款
                    $user_money = false;
                } else { // 未付款
                    $o_user_money = "select money from lkt_user where store_id = '$store_id' and user_id ='$user_id' ";
                    $o_user_money_res = $db->select($o_user_money);
                    if ($o_user_money_res) {
                        $user_money = $o_user_money_res[0]->money;
                    } else {
                        $user_money = false;
                    }
                }
                $product_total = 0;
                $z_freight = 0;
                // 根据订单号,查询订单详情
                $sql = "select * from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                $list = $db->select($sql);
                $user_can_after = true;
                if ($list) {
                    $batch = array();
                    $courier_num_arr = array();
                    foreach ($list as $key => $values) {
                        //查询订单店铺
                        $sql_mch_id = "select * from lkt_order where store_id = '$store_id' and sNo = '$sNo'";
                        $mch_id_res = $db->select($sql_mch_id);
                        if (!empty($mch_id_res)) {
                            $mch_id = $mch_id_res[0]->mch_id;
                            $mch_id = explode(',', $mch_id);
                            $mch_id = $mch_id[1];
                            $sql_mch_name = "select name from lkt_mch where store_id = '$store_id' and id = '$mch_id'";
                            $mch_name_res = $db->select($sql_mch_name);
                            if (!empty($mch_name_res)) {
                                $mch_name = $mch_name_res[0]->name;
                            }
                        }

                        $p_id = $values->p_id; // 产品id
                        $sid = $values->sid;//属性id
                        //根据产品id 查询店铺id
                        $sel_mch_sql = "select mch_id from lkt_product_list where store_id = $store_id and id = $p_id";
                        $mch_id_res = $db->select($sel_mch_sql);
                        if (!empty($mch_id_res)) {
                            $mch_id = $mch_id_res[0]->mch_id;
                            $sel_mch_sql = "SELECT m.id,m.name,m.logo  from lkt_mch as m where id= $mch_id";
                            $mch_res = $db->select($sel_mch_sql);
                            $values->shop_id = $mch_id;
                            $values->shop_name = $mch_res[0]->name;
                            $values->shop_logo = ServerPath::getimgpath($mch_res[0]->logo);
                        }

                        $p_price = $values->p_price;//商品单价
                        $num = $values->num;// 数量
                        $freight = $values->freight; // 运费
                        $product_total += $p_price * $num; // 商品总价
                        //如果为竞拍商品，重新计算总价

                        $z_freight += $freight; // 运费总价
                        $arrive_time = $values->arrive_time; // 到货时间
                        $arrive_times = strtotime($arrive_time);
                        $order_after_times = $order_after * 24 * 60 * 60;
                        if ((time() - $order_after_times) > $arrive_times) {
                            $user_can_after = false;
                        }
                        $date = date('Y-m-d 00:00:00', strtotime('-7 days'));

                        //退款转态

                        if ($values->r_type == 0) {
                            $values->prompt = '审核中';
                        } else if ($values->r_type == 1) {
                            $values->prompt = '审核通过';
                        } else if ($values->r_type == 2) {
                            $values->prompt = '拒绝退货退款';
                        } else if ($values->r_type == 3) {
                            $values->prompt = '审核通过';
                        } else if ($values->r_type == 4) {
                            $values->prompt = '退货完成';
                        } else if ($values->r_type == 5) {
                            $values->prompt = '退货失败';
                        } else if ($values->r_type == 8) {
                            $values->prompt = '拒绝退款';
                        } else if ($values->r_type == 9) {
                            $values->prompt = '已退款';
                        }

                        if (!empty($values->express_id) && !empty($values->courier_num)) {
                            $express_id = $values->express_id;//快递公司ID
                            $courier_num = $values->courier_num;//快递单号
                            $deliver_time = $values->deliver_time;//快递单号
                            if(!in_array($courier_num,$courier_num_arr)){
                                $sql01 = "select * from lkt_express where id = '$express_id'";
                                $r01 = $db->select($sql01);
                                $type = $r01[0]->type;//快递公司代码
                                $kuaidi_name = $r01[0]->kuaidi_name;
                                $res_1 = LogisticsTool::getLogistics($type, $courier_num);
                                $logistics_arr = array('list' => $res_1, 'kuaidi_name' => $kuaidi_name, 'courier_num' => $courier_num, 'deliver_time' => $deliver_time);
                                $logistics[] = $logistics_arr;
                                $courier_num_arr[] = $courier_num;
                            }
                        } else {
                            $logistics = array();
                        }

                        if ($arrive_time != '') {
                            if ($arrive_time < $date) {
                                $values->info = 1; // 到货时间少于7天
                            } else {
                                $values->info = 0; // 已经到货
                            }
                        } else {
                            $values->info = 0; // 还没到货
                        }
                        if ($values->content != null) {
                            $batch[] = 1;
                            $values->is_repro = 1; // 申请退货（已经申请，不能再申请退货）
                        } else {
                            $batch[] = 0;
                            $values->is_repro = 0; // 没有申请退货（可以退货）
                        }
                        $arr = (array)$values;
                        // 根据产品id,查询产品列表 (产品图片)
                        $sql = "select a.imgurl,a.product_title,a.is_distribution,c.img from lkt_product_list AS a 
                        LEFT JOIN lkt_configure AS c ON a.id = c.pid 
                        where a.store_id = '$store_id' and a.id = '$p_id' AND c.id= '$sid' ";
                        $rrr = $db->select($sql);
                        $url = ServerPath::getimgpath($rrr[0]->imgurl); // 拼图片路径
                        if ($otype == 'integral') {
                            $url = ServerPath::getimgpath($rrr[0]->img); // 拼图片路径
                        }

                        $arr['imgurl'] = $url;
                        $arr['sid'] = $sid;
                        $arr['is_distribution'] = $rrr[0]->is_distribution;//是否为分销商品
                        $product[$key] = (object)$arr;

                        $r_status = $values->r_status; // 订单详情状态
                        if ($r_status) {
                            $sql_o = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' AND r_type = 0 AND r_status = 4 ";
                            $res_o = $db->selectrow($sql_o);

                            $sql_d = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                            $res_d = $db->selectrow($sql_d);

                            // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                            if ($res_o == $res_d) {
                                //如果订单数量相等 则修改父订单状态
                                $sql = "update lkt_order set status = '$r_status' where store_id = '$store_id' and sNo = '$sNo'";
                                $r = $db->update($sql);
                                if($r<1){
                                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$sql);
                                }
                            }
                        } else {
                            $status = $r_status;
                        }
                    }
                    $batch_del = 1; // 没有批量退货按钮
                    foreach ($batch as $key => $val) {
                        if ($val == 0) {
                            $batch_del = 0; // 有批量退货按钮
                            break;
                        }
                    }
                    $payment = $z_price;
                    $list = $product;
                } else {
                    $logistics = array();
                    $batch_del = 0;
                    $p_id = '';
                }
                $order_no = '';
                if ($otype == 'KJ') {
                    $sql = "select p_sNo from lkt_order where id = $id";
                    $order_no_res = $db->select($sql);
                    $order_no = $order_no_res[0]->p_sNo;
                }
                $allow = '';
                if ($otype == 'integral') {
                    $sql = "select allow from lkt_order where id = $id";
                    $order_no_res = $db->select($sql);
                    $allow = $order_no_res[0]->allow;
                }
                $is_end = false;

                $sel_end_sql = "SELECT * FROM lkt_group_product WHERE product_id = $p_id  and store_id = $store_id and is_delete = 0 GROUP BY product_id";

                $res_end = $db->select($sel_end_sql);
                if ($res_end) {

                    $group_cfg = $res_end[0]->group_data;
                    $group_data = unserialize($group_cfg);
                    $end_time = $group_data->endtime;
                    $end_time = strtotime($end_time);

                    if ($end_time < time()) {
                        $is_end = true;
                    }
                }

                $user_can_open = true;
                $user_can_can = true;
                $user_can_ms = true;
                $user_can_buy_ms = true;
                $isagain_can = false;
                $isagain_open = false;
                $isinpt = false;

                if ($otype == 'pt') {
                    //查询拼团配置
                    $sel_group_cfg = "select * from lkt_group_config where store_id = $store_id";
                    $group_cfg = $db->select($sel_group_cfg);

                    //判断是否重复参团
                    $can_num = $group_cfg[0]->can_num; //最多参团数量
                    $open_num = $group_cfg[0]->open_num; //最多开团数量
                    $can_again = $group_cfg[0]->can_again;

                    //查询当前用户开团数量
                    $sel_open_num = "SELECT * FROM lkt_group_open as lgo
                                        right join  lkt_order as lo on lo.ptcode = lgo.ptcode
                                        WHERE lgo.uid = '$user_id' and lgo.ptstatus = 1 and lgo.store_id = $store_id and lo.user_id = '$user_id'";
                    $data['aa'] = $sel_open_num;
                    $already_open_num = $db->select($sel_open_num);
                    $already_open_num = count($already_open_num);
                    $data['already_open_num'] = $already_open_num;
                    $data['(int)$already_open_num'] = (int)$already_open_num;
                    $data['(int)$open_num'] = (int)$open_num;

                    if ((int)$already_open_num >= (int)$open_num) {
//                        $user_can_open = false . "already_open_num:" . $already_open_num . "open_num:" . $open_num;
                        $user_can_open = false;
                    }
                    //查询用户当前参团数量
                    $sel_can_num = "SELECT * from lkt_order where otype = 'pt' and store_id = 1 and user_id = '$user_id' and ptstatus = 1 and pid = 'cantuan'  and add_time > '2019-07-15 00:00:00'";
                    $already_can_num = $db->select($sel_can_num);
                    $already_can_num = count($already_can_num);
                    if ((int)$already_can_num >= (int)$can_num) {
                        $user_can_can = false;
                    }
                    if ($can_again == '0') {

                        $sel_group_pro_data_sql = "select * from lkt_group_product where store_id = $store_id and product_id = $p_id";
                        $group_pro_data_res = $db->select($sel_group_pro_data_sql);

                        if ($group_pro_data_res) {
                            $group_data = $group_pro_data_res[0]->group_data;
                            $group_data = unserialize($group_data);
                            $start_time = $group_data->starttime;
                            $end_time = $group_data->endtime;

                            $sel_is_buy_pt_pro_sql = "SELECT d.* 
                            from lkt_order as o
                            LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
                            where o.otype = 'pt' and o.user_id = '$user_id' and o.pid = 'cantuan' and o.ptstatus = 1 and o.store_id = $store_id  and d.p_id = $p_id and o.pay_time > '$start_time'  and o.pay_time < '$end_time'";
                            $sel_is_buy_pt_pro_res = $db->select($sel_is_buy_pt_pro_sql);
                            if ($sel_is_buy_pt_pro_res) {
                                $isagain_can = true;
                            }

                            $sel_is_buy_pt_pro_sql = "SELECT d.* 
                            from lkt_order as o
                            LEFT JOIN lkt_order_details as d on o.sNo = d.r_sNo
                            where o.otype = 'pt' and o.user_id = '$user_id' and o.pid = 'kaituan' and o.ptstatus = 1 and o.store_id = $store_id  and d.p_id = $p_id and o.pay_time > '$start_time'  and o.pay_time < '$end_time'";
                            $sel_is_buy_pt_pro_res = $db->select($sel_is_buy_pt_pro_sql);
                            if ($sel_is_buy_pt_pro_res) {
                                $isagain_open = true;
                            }
                        }

                    }
                    $sql = "select * from lkt_order
                    where store_id = $store_id and user_id = '$user_id' and ptcode = '$ptcode' and ptcode != '' and ptstatus in (1,2) ";
                    $isagain_can_res = $db->select($sql);
                    if ($isagain_can_res) {
                        $isinpt = true;
                    }
                } else if ($otype == "MS") {
                    //查询秒杀设置
                    $sel_seckill_config = "select * from lkt_seconds_config where store_id = $store_id";
                    $seckill_config = $db->select($sel_seckill_config);
                    if (!empty($seckill_config)) {
                        if ($seckill_config[0]->buy_num == 0) {
                            $user_can_ms = true;
                        } else {
                            $msbuy_num = $seckill_config[0]->buy_num;//可秒杀数量

                            //查询秒杀活动时段、活动、商品id
                            $sql_ssc = "select * from lkt_seconds_record where store_id = '$store_id' and sNo = '$sNo'";
                            $ssc_res = $db->select($sql_ssc);
                            $seckill_activity_id = $ssc_res[0]->activity_id;
                            $seckill_time_id = $ssc_res[0]->time_id;
                            $add_time = $ssc_res[0]->add_time;
                            $add_time = explode(' ', $add_time);
                            $stime = $add_time[0] . ' 00:00:00';
                            $etime = $add_time[0] . ' 23:59:59';
                            $add_time = $add_time[0].' '.$add_time[1];
                            //查询已经购买了几个商品
                            $sql_ac1 = "SELECT
                            SUM(sr.num) as sum
                        FROM
                            `lkt_seconds_record` AS sr
                        LEFT JOIN lkt_seconds_time AS st ON st.id = sr.time_id
                        LEFT JOIN lkt_product_list AS pl ON sr.pro_id = pl.id
                        LEFT JOIN lkt_user AS u ON sr.user_id = u.user_id
                        LEFT JOIN lkt_seconds_activity AS sa ON sa.id = sr.activity_id
                        LEFT JOIN lkt_order as o on sr.sNo = o.sNo
                        WHERE
                            1 and sr.user_id = '$user_id'
                        AND sr.store_id = $store_id
                        AND sr.activity_id = $seckill_activity_id
                        AND sr.time_id = $seckill_time_id
                        AND sr.pro_id = $p_id
                        AND sr.add_time >= '$stime'
                        AND sr.add_time <= '$etime'
                        AND o.status != 6
                        AND o.status != 0";
                            $ac1_res = $db->select($sql_ac1);
                            $p_num = $ac1_res[0]->sum;
                            if ($msbuy_num <= $p_num) {
                                $user_can_ms = false;
                            }
                        }
                    }

                    //查询当前订单是否活动时段过期
                    $sel_ms_record_sql = "select * from lkt_seconds_record  where sNo = '$sNo' and store_id = $store_id";
                    $ms_record_res = $db->select($sel_ms_record_sql);
                    if (!empty($ms_record_res)) {
                        $ms_add_time = $ms_record_res[0]->add_time;
                        $ms_time_id = $ms_record_res[0]->time_id;
                        //查询时间是否在时段的范围
                        $now_time_1 = date("1970-01-01 H:i:s", time()); // 昨天结束时间
                        $sel_ms_time_sql = "select * from lkt_seconds_time  where id = $ms_time_id and starttime <= '$now_time_1' and  endtime >= '$now_time_1' and store_id = $store_id";
                        $ms_time_res = $db->select($sel_ms_time_sql);
                        if (empty($ms_time_res)) {
                            $user_can_buy_ms = false;
                        }
                    } else {
                        $user_can_buy_ms = false;
                    }
                }
                if ($self_lifting == '1') {
                    $sql0_0 = "select * from lkt_mch_store where store_id = '$store_id' and mch_id = '$mch_id'";
                    $r0_0 = $db->select($sql0_0);
                    if ($r0_0) {
                        $address = $r0_0[0]->sheng . $r0_0[0]->shi . $r0_0[0]->xian . $r0_0[0]->address;
                    }
                }
                echo json_encode(array('code' => 200, 'data' => array('status' => $status, 'payment' => $payment_config,  'hand_del' => $hand_del, 'is_end' => $is_end, 'user_can_open' => $user_can_open, 'user_can_after' => $user_can_after, 'user_can_ms' => $user_can_ms, 'user_can_buy_ms' => $user_can_buy_ms, 'user_can_can' => $user_can_can, 'isagain_can' => $isagain_can, 'isagain_open' => $isagain_open, 'isinpt' => $isinpt, 'remarks' => $remarks, 'gstatus' => $gstatus, 'otype' => $otype, 'pttype' => $pid, 'jp' => $jp, 'id' => $id, 'sNo' => $sNo, 'z_price' => $z_price, 'product_total' => $product_total, 'mch_name' => $mch_name, 'z_freight' => $z_freight, 'name' => $name, 'mobile' => $mobile, 'address' => $address, 'add_time' => $add_time, 'rstatus' => $status, 'list' => $list, 'user_money' => $user_money, 'logistics' => $logistics, 'order_failure' => $order_failure, 'company' => $company, 'batch_del' => $batch_del, 'coupon_activity_name' => $coupon_activity_name, 'coupon_price' => $coupon_price, 'coupon_name' => $coupon_name, 'enterless' => $enterless, 'offset_balance' => $offset_balance, 'omsg' => $r[0], 'pro_id' => $p_id, 'order_no' => $order_no, 'password_status' => $password_status, 'comm_discount' => $comm_discount, 'grade_rate' => $grade_rate, 'delivery_status' => $delivery_status, 'self_lifting' => $self_lifting, 'allow' => $allow), 'message' => '操作成功'));
                exit();
            } else {
                echo json_encode(array('code' => 109, 'err' => '参数错误！'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
        return;
    }

    /**
     * 售后详情数据
     */
    function Returndetail()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $id = trim($request->getParameter('id')); // 详情订单id
        $pid = trim($request->getParameter('pid'));

        //查询详情订单信息
        $sel_sql = "select * from lkt_order_details where store_id = $store_id && id = $id";
        $res = $db->select($sel_sql);

        $send_info = array();
        $return_info = array();

        //查询买家回寄信息
        $sel_sql = "SELECT * FROM lkt_return_goods WHERE oid =  $id and store_id = $store_id";
        $return_res = $db->select($sel_sql);
        if (!empty($return_res)) {
            $send_info = $return_res[0];

            if (count($return_res) > 1) {
                //查询卖家退换信息
                $return_info = $return_res[1];
            }

        }

        $info = array();

        //退款信息
        $info['re_time'] = $res[0]->re_time;//申请时间
        $price = $res[0]->real_money;//退款金额
        $info['p_price'] = $price;//退款金额
        $info['r_content'] = $res[0]->r_content;//拒绝原因
        if ($info['p_price'] == '0.00' || $info['p_price'] == 0) {
            $info['p_price'] = $res[0]->re_apply_money;
        }
        $info['re_type'] = $res[0]->re_type;//售后类型1
        $info['p_name'] = $res[0]->p_name;//售后商品名称
        $info['r_sNo'] = $res[0]->r_sNo;//售后订单
        $info['type'] = $res[0]->r_type;//售后类型
        $info['content'] = $res[0]->content;//退货原因
        $re_photo = unserialize($res[0]->re_photo);//凭证
        $info['re_photo'] = array();
        if (!empty($re_photo)) {
            foreach ($re_photo as $k => $v) {
                $info['re_photo'][$k] = ServerPath::getimgpath($v, $store_id); // 获取图片路径
            }
        }
        // 根据商品id，查询商品信息
        $sql0 = "select mch_id from lkt_product_list where store_id = '$store_id' and id = '$pid'";
        $ret['sql'] = $sql0;
        $r0 = $db->select($sql0);
        if ($r0) {
            $mch_id = $r0[0]->mch_id; // 店铺ID
            // 根据店铺ID，查询管理员信息
            $sql1 = "select id from lkt_admin where store_id = '$store_id' and shop_id = '$mch_id'";
            $r1 = $db->select($sql1);
            if ($r1) { // 存在，代表是自营商品
                // 获取信息
                $sql = "select address_xq,name,tel from lkt_service_address where store_id = '$store_id' and uid = 'admin' and is_default=1";
                $r_1 = $db->select($sql);
                $address = $r_1[0]->address_xq;
                $name = $r_1[0]->name;
                $phone = $r_1[0]->tel;
            } else {
                $sql1 = "select realname,tel,address from lkt_mch where store_id = '$store_id' and id = '$mch_id'";
                $r1 = $db->select($sql1);
                if ($r1) {
                    $address = $r1[0]->address;
                    $name = $r1[0]->realname;
                    $phone = $r1[0]->tel;
                } else {
                    echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
                    exit;
                }
            }

            $record = array();
            //查询售后记录
            $sel_sql = "select * from lkt_return_record where p_id = $id and store_id = $store_id";
            $record_res = $db->select($sel_sql);
            if (!empty($record_res)) {
                foreach ($record_res as $k => $v) {
                    if ($k < count($record_res) - 1) {
                        $record[$k] = $v;
                    }
                }
            }

        } else {
            echo json_encode(array('code' => 109, 'message' => '商品ID错误！'));
            exit;
        }

        $store_info = array();
        $store_info['address'] = $address;
        $store_info['name'] = $name;
        $store_info['phone'] = $phone;
        echo json_encode(array('code' => 200, 'msg' => '成功', 'info' => $info, 'store_info' => $store_info, 'record' => $record, 'send_info' => $send_info, 'return_info' => $return_info));
        exit;
    }

    function base64_image_content($base64_image_content, $path)
    {
        //匹配出图片的格式
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $new_file = $path . "/" . date('Ymd', time()) . "/";
            if (!file_exists($new_file)) {
                //检查是否有该文件夹，如果没有就创建，并给予最高权限
                mkdir($new_file, 0700);
            }
            $new_file = $new_file . time() . ".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                return '/' . $new_file;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // 退货信息
    public function ReturnDataList()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $pages = trim($request->getParameter('page'));
        $lmt = trim($request->getParameter('limit'));

        if ($lmt == 0) {
            if ($pages == '') {
                $pages = 1;
            }
            $pagesize = 10;
            $start = ($pages - 1) * $pagesize;
        } else {
            $start = 0;
            $pagesize = $lmt;
        }

        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id

        // 根据access_id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $userid = $access[0]->user_id;

            $sql = "select * from lkt_order_details 
                    where store_id = '$store_id' and user_id = '$userid' and re_type > 0
                    order by add_time desc 
                    limit $start,$pagesize";

            $list = $db->select($sql);
            $sqlcc = "select * from lkt_order_details 
                    where store_id = '$store_id' and user_id = '$userid' and  re_type > 0
                    order by case 
                                  when r_type='11' then 1
                                  when r_type='0' then 2
                                  when r_type='2' then 3
                                  when r_type='5' then 4
                                  when r_type='8' then 5
                                  when r_type='1' then 6
                                  when r_type='3' then 7
                                  when r_type='12' then 8
                                  when r_type='4' then 9
                                  when r_type='9' then 10
                              end ";
            $listcc = $db->select($sqlcc);
            $count = count($listcc);
            $hasp = floor($count / $pagesize);
            $yu = $count % $pagesize;
            if ($yu > 0) {
                $hasp = $hasp + 1;
            }
            if ($listcc) {
                $times = 0;
                foreach ($listcc as $k => $v) {
                    $end = ($start * 10 + $pagesize * 10) / 10;
                    if ($k >= $start && $k < $end) {
                        $p_id = $v->p_id;
                        $r_sNo = $v->r_sNo;
                        $sql = "select id from lkt_order where store_id = '$store_id' and sNo = '$r_sNo'";
                        $r = $db->select($sql);
                        $order_id = $r[0]->id;

                        $arr = (array)$v;
                        // 根据产品id,查询产品列表 (产品图片)
                        $sql = "select imgurl,mch_id from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                        $rrr = $db->select($sql);
                        if ($rrr) {
                            $url = ServerPath::getimgpath($rrr[0]->imgurl, $store_id); // 拼图片路径
                            $mch_id = $rrr[0]->mch_id;
                        }

                        if (!empty($mch_id)) {
                            $mch_id_ = substr($mch_id, 1, strlen($mch_id) - 2);
                            $sql0 = "select id,name,logo from lkt_mch where store_id = '$store_id' and (id = '$mch_id_' or id = '$mch_id')";
                            $r0 = $db->select($sql0);
                            if ($r0) {
                                $arr['shop_id'] = $r0[0]->id;
                                $arr['shop_name'] = $r0[0]->name;
                                $arr['shop_logo'] = ServerPath::getimgpath($r0[0]->logo);
                            } else {
                                $arr['shop_id'] = 0;
                                $arr['shop_name'] = '';
                                $arr['shop_logo'] = '';
                            }
                        } else {
                            $arr['shop_id'] = 0;
                            $arr['shop_name'] = '';
                            $arr['shop_logo'] = '';
                        }

                        $arr['order_id'] = $order_id;
                        $arr['imgurl'] = $url;
                        if ($v->r_type == 0) {
                            $arr['prompt'] = '审核中';
                            $arr['buyer'] = '';
                            $arr['return_state'] = '';
                        } else if ($v->r_type == 1) {
                            $sql = "SELECT * FROM `lkt_service_address` WHERE store_id = '$store_id' and uid = 'admin'";
                            $r1 = $db->select($sql);
                            $buyer['tel'] = $r1[0]->tel;
                            $buyer['name'] = $r1[0]->name;
                            $buyer['address_xq'] = $r1[0]->address_xq;
                            $arr['prompt'] = '审核通过';
                            $arr['buyer'] = $buyer;
                            $arr['return_state'] = '';
                        } else if ($v->r_type == 2) {
                            $arr['prompt'] = '审核拒绝';
                            $arr['buyer'] = '';
                            $arr['return_state'] = '';
                        } else if ($v->r_type == 3) {
                            $arr['prompt'] = '审核通过';
                            if ($v->re_type == 3) {
                                $arr['prompt'] = '商品审核中';
                            }
                            $arr['buyer'] = '';
                            $arr['return_state'] = '';
                        } else if ($v->r_type == 4) {
                            $arr['prompt'] = ' 审核通过';
                            $arr['buyer'] = '';
                            $arr['return_state'] = '退货退款';
                        } else if ($v->r_type == 5) {
                            $arr['prompt'] = '审核拒绝';
                            $arr['buyer'] = '';
                            $arr['return_state'] = '';
                        } else if ($v->r_type == 8) {
                            $arr['prompt'] = '审核拒绝';
                            $arr['buyer'] = '';
                            $arr['return_state'] = '';
                        } else if ($v->r_type == 9) {
                            $arr['prompt'] = ' 审核通过';
                            $arr['buyer'] = '';
                            $arr['return_state'] = '';
                        } else if ($v->r_type == 11) {
                            $arr['prompt'] = ' 退换中';
                            $arr['buyer'] = '';
                            $arr['return_state'] = '';
                        } else if ($v->r_type == 12) {
                            $arr['prompt'] = ' 售后完成';
                            $arr['prompt'] = ' ';
                            $arr['buyer'] = '';
                            $arr['return_state'] = '';
                        }
                        $product[$times] = (object)$arr;
                        $times++;
                    }
                }
                $list = $product;
                echo json_encode(array('code' => 200, 'list' => $list, 'hasp' => $hasp, 'message' => '成功'));
                exit();
            } else {
                echo json_encode(array('code' => 200, 'list' => array(), 'hasp' => $hasp, 'message' => '成功'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
        return;
    }

    // 储存快递回寄信息
    public function back_send()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $kdcode = trim($request->getParameter('kdcode')); // 快递单号
        $kdname = trim($request->getParameter('kdname')); // 快递名称
        $lxdh = trim($request->getParameter('lxdh')); // 寄件人电话
        $lxr = trim($request->getParameter('lxr')); // 寄件人
        $oid = trim($request->getParameter('oid')); // 订单详情id
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $lktlog = new LaiKeLogUtils("app/order.log");
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $userid = $access[0]->user_id;
            $sql = "insert into lkt_return_goods(store_id,name,tel,express,express_num,user_id,oid,add_data) values('$store_id','$lxr','$lxdh','$kdname','$kdcode','$userid','$oid',CURRENT_TIMESTAMP)";
            $rid = $db->insert($sql, 'last_insert_id');
            if($rid<1){
                $lktlog->customerLog(__METHOD__.":".__LINE__."添加回退物品信息失败！sql:".$sql);
            }
            $sql = "update lkt_order_details set r_type = 3 where store_id = '$store_id' and id = '$oid'";
            $r = $db->update($sql);

            if ($r) {
                echo json_encode(array('code' => 200, 'message' => '成功!'));
                exit();
            } else {
                $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单数据失败！sql:".$sql);
                $sql = "update lkt_order_details set r_type = 1 where store_id = '$store_id' and id = '$oid'";
                $r = $db->update($sql);
                if($r<1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单数据失败！sql:".$sql);
                }
                $sql = "delete from lkt_return_goods where store_id = '$store_id' and id = '$rid'";
                $db->delete($sql);

                echo json_encode(array('code' => 103, 'message' => '网络繁忙!'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 返回快递信息
    public function see_send()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $pid = trim($request->getParameter('pid'));

        // 根据商品id，查询商品信息
        $sql0 = "select mch_id from lkt_product_list where store_id = '$store_id' and id = '$pid'";
        $r0 = $db->select($sql0);
        if ($r0) {
            $mch_id = $r0[0]->mch_id; // 店铺ID
            // 根据店铺ID，查询管理员信息
            $sql1 = "select id from lkt_admin where store_id = '$store_id' and shop_id = '$mch_id'";
            $r1 = $db->select($sql1);
            if ($r1) { // 存在，代表是自营商品
                // 获取信息
                $sql = "select address_xq,name,tel from lkt_service_address where store_id = '$store_id' and uid = 'admin' and is_default=1";
                $r_1 = $db->select($sql);
                $address = $r_1[0]->address_xq;
                $name = $r_1[0]->name;
                $phone = $r_1[0]->tel;
            } else {
                $sql1 = "select realname,tel,address from lkt_mch where store_id = '$store_id' and id = '$mch_id'";
                $r1 = $db->select($sql1);
                if ($r1) {
                    $address = $r1[0]->address;
                    $name = $r1[0]->realname;
                    $phone = $r1[0]->tel;
                } else {
                    echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
                    exit;
                }
            }
        } else {
            echo json_encode(array('code' => 109, 'message' => '商品ID错误！'));
            exit;
        }

        $sql_1 = "select * from lkt_express ";
        $r_2 = $db->select($sql_1);

        if ($r_2) {
            echo json_encode(array('code' => 200, 'address' => $address, 'name' => $name, 'phone' => $phone, 'express' => $r_2, 'message' => '成功!'));
            exit();
        } else {
            echo json_encode(array('code' => 103, 'message' => '网络繁忙!'));
            exit();
        }
    }

    //删除购物车
    public function del_cart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id'));//Accessid
        $cart_id = trim($request->getParameter('cart_id'));// 订单id
        $sel_user_sql = "SELECT * from lkt_user where access_id = '$access_id' and store_id = 1";
        $user_res = $db->select($sel_user_sql);
        $user_id = $user_res[0]->user_id;
        $sel_cart_sql = "SELECT * FROM `lkt_cart` WHERE user_id = '$user_id' and id = '$cart_id' and store_id = '$store_id'";
        $cart_res = $db->select($sel_cart_sql);
        if ($cart_res) {
            $del_cart_sql = "DELETE FROM `lkt_cart` WHERE store_id = '$store_id' and user_id = '$user_id' and id = '$cart_id'";
            $ret = $db->delete($del_cart_sql);
        }
        exit;

    }

    // 删除订单
    public function del_order()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('order_id'));// 订单id
        $lktlog = new LaiKeLogUtils("app/order.log");
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $user_id = $access[0]->user_id;
            // 根据订单id,查询订单列表(订单号)
            $sql = "select sNo from lkt_order where store_id = '$store_id' and id = '$id' and user_id = '$user_id'";
            $r = $db->select($sql);
            if ($r) {
                $sNo = $r[0]->sNo; // 订单号
                $sql1 = "update lkt_order_details set r_status = 7 where store_id = '$store_id' and r_sNo = '$sNo'";
                $r1 = $db->update($sql1);

                $sql2 = "update lkt_order set status = 7 where store_id = '$store_id' and sNo = '$sNo'";
                $r2 = $db->update($sql2);

                if ($r1 > 0 && $r2 > 0) {
                    echo json_encode(array('code' => 200, 'message' => '成功!'));
                    exit();
                } else {
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单状态失败！sql:".$sql1.'-'.$sql2);
                    echo json_encode(array('code' => 110, 'message' => '业务异常!'));
                    exit();
                }
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 再次购买
    public function buy_again()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $id = trim($request->getParameter('id'));// 订单id
        $sql = "select * from lkt_order where store_id = '$store_id' and id ='$id'";
        $r = $db->select($sql);
        if ($r) {
            $list = array();
            $user_id = $r[0]->user_id;
            $sNo = $r[0]->sNo;
            $sql = "select p_id,num,sid from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
            $rr = $db->select($sql);
            foreach ($rr as $k => $v) {
                $list[$k] = $v;
            }

            $cart_type = 1; // 可以添加购物车

            foreach ($list as $ke => $va) {
                $sql = "select b.num from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where a.store_id = '$store_id' and a.status = 2 and a.mch_status = 2 and b.pid = '$va->p_id' and b.id = '$va->sid'";
                $rrr = $db->select($sql);
                if ($rrr) {
                    $num = $rrr[0]->num;
                    if ($num > 0) {
                        $cart_type = 1; // 可以添加购物车
                    } else {
                        $cart_type = 0; // 不可以添加购物车
                        break;
                    }
                } else {
                    $cart_type = 0; // 不可以添加购物车
                    break;
                }
            }
            if ($cart_type == 1) {
                foreach ($list as $key => $val) {
                    $sql = "insert into lkt_cart(store_id,user_id,Goods_id,Goods_num,Create_time,Size_id) values('$store_id','$user_id','$val->p_id','$val->num',CURRENT_TIMESTAMP,'$val->sid')";
                    $id1 = $db->insert($sql, 'last_insert_id'); // 得到添加数据的id
                    if($id1<1){
                        $lktlog->customerLog(__METHOD__.":".__LINE__."添加购物车失败！sql:".$sql);
                    }
                    $cart_id[] = $id1;
                }
            } else {
                echo json_encode(array('code' => 105, 'message' => '库存不足！'));
                exit;
            }

            $cart_id = implode(",", $cart_id);
            echo json_encode(array('code' => 200, 'cart_id' => $cart_id, 'message' => '成功'));
            exit();
        } else {
            echo json_encode(array('code' => 109, 'message' => '参数错误！'));
            exit;
        }
    }

    // 搜索
    public function search()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $sNo = trim($request->getParameter('sNo'));// 订单号

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $user_id = $access[0]->user_id;
            $sql = "select * from lkt_order where store_id = '$store_id' and sNo = '$sNo' and user_id = '$user_id'";
            $r1 = $db->select($sql);

            $sql = "select * from lkt_order_details where store_id = '$store_id' and user_id = '$user_id' and r_status = 4 and r_sNo = '$sNo' ";
            $r = $db->select($sql);
            if ($r) {
                $p_id = $r[0]->p_id; // 商品id
                $r_type = $r[0]->r_type; // 类型
                $arr = (array)$r[0];

                $sql = "select id from lkt_order where store_id = '$store_id' and sNo = '$sNo'";
                $rr = $db->select($sql);
                $order_id = $rr[0]->id;

                // 根据产品id,查询产品列表 (产品图片)
                $sql = "select imgurl from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                $rrr = $db->select($sql);
                if ($rrr) {
                    $url = ServerPath::getimgpath($rrr[0]->imgurl); // 拼图片路径
                }
                $arr['order_id'] = $order_id;
                $arr['imgurl'] = $url;
                if ($r_type == 0) {
                    $arr['prompt'] = '审核中';
                    $arr['buyer'] = '';
                    $arr['return_state'] = '';
                } else if ($r_type == 1) {
                    $sql = "SELECT * FROM `lkt_service_address` WHERE store_id = '$store_id' and uid = 'admin'";
                    $r1 = $db->select($sql);
                    $buyer['tel'] = $r1[0]->tel;
                    $buyer['name'] = $r1[0]->name;
                    $buyer['address_xq'] = $r1[0]->address_xq;
                    $arr['prompt'] = '审核通过';
                    $arr['buyer'] = $buyer;
                    $arr['return_state'] = '';
                } else if ($r_type == 2) {
                    $arr['prompt'] = '拒绝';
                    $arr['buyer'] = '';
                    $arr['return_state'] = '';
                } else if ($r_type == 3) {
                    $arr['prompt'] = '审核通过';
                    $arr['buyer'] = '';
                    $arr['return_state'] = '';
                } else if ($r_type == 4) {
                    $arr['prompt'] = '退货完成';
                    $arr['buyer'] = '';
                    $arr['return_state'] = '退货退款';
                } else if ($r_type == 5) {
                    $arr['prompt'] = '退货失败';
                    $arr['buyer'] = '';
                    $arr['return_state'] = '';
                }
                $list = $arr;
                echo json_encode(array('code' => 200, 'list' => $list, 'message' => '成功'));
                exit();
            } else {
                echo json_encode(array('code' => 200, 'list' => '', 'message' => '成功'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 点击退货后，进入的页面
    public function return_method()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $order_details_id = $request->getParameter('order_details_id');// 订单详情id

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $user_id = $access[0]->user_id;
            $refund_price = 0;
            $list = array();
            $freight = 0;
            $typeArr = array();
            $r_status = array();
            $status = false;
            if (!empty($order_details_id)) {
                if (is_array($order_details_id)) { // 是数组
                    foreach ($order_details_id as $key => $value) {
                        $typeArr[$key] = $value;
                    }
                } else if (is_string($order_details_id)) { // 是字符串
                    $typestr = trim($order_details_id, ','); // 移除两侧的逗号
                    $typeArr = explode(',', $typestr); // 字符串打散为数组
                }
            }
            foreach ($typeArr as $k => $v) {
                $sql = "select id,p_id,p_name,p_price,num,unit,r_status,r_sNo,freight,size,sid from lkt_order_details where store_id = '$store_id' and user_id = '$user_id' and id = '$v' ";
                $r = $db->select($sql);
                if ($r) {
                    $p_id = $r[0]->p_id;
                    $r_status[] = $r[0]->r_status;
                    $r_sNo = $r[0]->r_sNo;
                    $attribute_id = $r[0]->sid;
                    $refund_price += Tools::get_order_price($db, $store_id, $v);
                    $sql = "select * from lkt_configure where id = '$attribute_id' and pid = '$p_id'";
                    $rr = $db->select($sql);
                    if ($rr) {
                        $r[0]->image = ServerPath::getimgpath($rr[0]->img); // 图片
                        $list[] = $r[0];
                    }
                }
            }
            foreach ($r_status as $k => $v) {
                if ($v == 2) {
                    $status = true;
                    break;
                }
            }
            $sql3 = "select self_lifting from lkt_order where store_id = '$store_id' and sNo = '$r_sNo'";
            $r3 = $db->select($sql3);
            if ($r3) {
                $self_lifting = $r3[0]->self_lifting;
            } else {
                $self_lifting = '0';
            }
            $data = array('refund_price' => $refund_price, 'self_lifting' => $self_lifting, 'list' => $list, 'status' => $status);
            echo json_encode(array('code' => 200, 'data' => $data, 'message' => '成功！'));
            exit;
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 退货申请
    public function ReturnData()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        // 获取信息
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $order_details_id = $request->getParameter('order_details_id'); // 订单详情id
        $refund_amount = $request->getParameter('refund_amount'); // 退货金额
        $back_remark = urldecode($request->getParameter('explain')); // 退货原因
        $re_apply_money = $request->getParameter('refund_apply_money'); // 用户申请退款金额
        $type = $request->getParameter('type'); // 退货类型
        $upload_z_num = trim($request->getParameter('upload_z_num')); // 循环总次数
        $upload_num = trim($request->getParameter('upload_num')); // 上传次数
        $lktlog = new LaiKeLogUtils("app/order.log");
        $re_photo = '';//照片凭证
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $user_id = $access[0]->user_id;
            $p_name = array();
            $freight = 0;
            $typeArr = array();
            if (!empty($order_details_id)) {
                if (is_array($order_details_id)) { // 是数组
                    foreach ($order_details_id as $key => $value) {
                        $typeArr[$key] = $value;
                    }
                } else if (is_string($order_details_id)) { // 是字符串
                    $typestr = trim($order_details_id, ','); // 移除两侧的逗号
                    $typeArr = explode(',', $typestr); // 字符串打散为数组
                }
            }
            $Tools = new Tools($db, $store_id, 1);
            $image_arr = array();
            $image_array = array();

            if (empty($upload_z_num) && empty($upload_num)) { // 没有上传图片

            } else { // 有上传图片
                // 查询配置表信息
                $sql = "select * from lkt_config where store_id = '$store_id'";
                $r = $db->select($sql);
                $uploadImg = $r[0]->uploadImg;
                $uploadImg_domain = $r[0]->uploadImg_domain;
                $upserver = !empty($r) ? $r[0]->upserver : '2';   //如果没有设置配置则默认用阿里云
                // 图片上传位置
                if (empty($uploadImg)) {
                    $uploadImg = "./images";
                }
                if (!empty($_FILES)) {          //如果图片不为空
                    if ($upserver == '2') {
                        $imgURL_name = ServerPath::file_OSSupload($store_id, $store_type);
                    } else {
                        $imgURL_name = ServerPath::file_upload($store_id, $uploadImg, $uploadImg_domain, $store_type);
                    }
                    $image_arr1 = array('image' => $imgURL_name, 'call_num' => $upload_num); // 图片数组
                    $cache = array('user_id' => $user_id, 'order_details_id' => $order_details_id, 'image_arr' => $image_arr1); // 缓存数组
                }
                if ($upload_num + 1 != $upload_z_num) {
                    $res = $Tools->generate_session($db, $cache, 2);

                    echo json_encode(array('code' => 200, 'message' => '成功！'));
                    exit;
                } else {
                    $rew = $Tools->obtain_session($db, $user_id, 2, $order_details_id);
                    if ($rew != '') {
                        $image_arr2 = json_decode($rew, true);
                        if (count($image_arr2) == count($image_arr2, 1)) {
                            $image_arr[] = $image_arr2;
                            $image_arr[] = $image_arr1;
                        } else {
                            foreach ($image_arr2 as $k => $v) {
                                $image_arr[] = (array)$v;
                            }
                            array_push($image_arr, $image_arr1);
                        }
                    } else {
                        $image_arr[] = $image_arr1;
                    }
                }
                foreach ($image_arr as $ke => $va) {
                    $image_array[$ke] = $va['image'];
                }
            }
            //进入正式添加---开启事物
            $db->begin();
            foreach ($typeArr as $k => $v) {
                $sql = "select id,p_id,p_name,p_price,num,unit,r_sNo,freight,size,sid,r_status,re_photo,re_type,sid from lkt_order_details where store_id = '$store_id' and user_id = '$user_id' and id = '$v' ";
                $r = $db->select($sql);
                if ($r) {
                    $r_sNo = $r[0]->r_sNo; // 订单号
                    $p_name[] = $r[0]->p_name; // 商品名称
                    $p_price = $r[0]->p_price; // 商品单价
                    $num = $r[0]->num; // 数量
                    $freight = $r[0]->freight;
                    $r_status = $r[0]->r_status;
                    $order_details_id = $r[0]->id;
                    $re_type = $r[0]->re_type;
                    $attr_id = $r[0]->sid;

                    $sqlo = "select z_price,spz_price from lkt_order where store_id = '$store_id' and sNo = '$r_sNo'";
                    $order_res = $db->select($sqlo);
                    $z_price = $order_res[0]->z_price;
                    $spz_price = $order_res[0]->spz_price;
                    $refund_price = number_format($z_price / $spz_price * $p_price * $num - $freight, 2);

                    // 根据订单详情id,修改订单详情表(退货原因)
                    if ($re_type == 3) {
                        $sql = "update lkt_order_details set r_status = '4',content = '$back_remark',r_type = 0,re_type = '$type',re_time=CURRENT_TIMESTAMP where store_id = '$store_id' and r_sNo = '$r_sNo' and id = '$v'";
                    } else {
                        $sql = "update lkt_order_details set r_status = '4',content = '$back_remark',r_type = 0,re_type = '$type',re_money='$refund_price',re_apply_money='$re_apply_money',re_time=CURRENT_TIMESTAMP where store_id = '$store_id' and r_sNo = '$r_sNo' and id = '$v'";
                    }
                    $r2 = $db->update($sql);
                    if ($r2 < 0) {
                        $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单信息失败！sql:".$sql);
                        $db->rollback();
                        echo json_encode(array('code' => 110, 'message' => '业务异常！'));
                        exit();
                    }

                    if (count($image_array) > 0) {
                        $re_photo = serialize($image_array);
                        $sql1 = "update lkt_order_details set r_status = '4',re_photo = '$re_photo' where store_id = '$store_id' and r_sNo = '$r_sNo' and id = '$v'";
                        $r3 = $db->update($sql1);
                        if ($r3 < 0) {
                            $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单详情信息失败！sql:".$sql);
                            $db->rollback();
                            echo json_encode(array('code' => 110, 'message' => '业务异常！'));
                            exit();
                        }
                    }
                }
            }


            $sql = "select id,re_apply_money from lkt_order_details where store_id = '$store_id' and r_sNo = '$r_sNo'";
            $rrr = $db->select($sql);
            $order_details_num = count($rrr);

            $re_apply_money = $rrr[0]->re_apply_money;

            if ($re_apply_money * 100 < $refund_amount * 100 && $re_apply_money * 100 / 100 > 0) {
                $refund_amount = $re_apply_money;
            }

            if ($type == 1) {
                //退货退款
                $_type = 29;
            } else if ($type == 2) {
                //仅退款
                $_type = 28;
            } else {
                //售后
                $_type = 30;
            }
            //存入当前订单改变之前的状态
            $json_str = array();
            $json_str['r_sNo'] = $r_sNo;
            $json_str['r_status'] = $r_status;
            $json_str['order_details_id'] = $order_details_id;
            $json_str = json_encode($json_str);
            $instsql = "INSERT INTO `lkt_record`(`store_id`,`user_id`,`event`,`type`) 
                                    VALUES ($store_id,'$user_id','$json_str',$_type)";
            $rr = $db->insert($instsql);
            if($rr<1){
                $lktlog->customerLog(__METHOD__.":".__LINE__."添加记录失败！sql:".$instsql);
            }
            $r_money = $refund_amount;
            if ($re_apply_money < $refund_amount) {
                $r_money = $re_apply_money;
            }

            //查询商品id
            $sql_pro_sql = "select pid from lkt_configure where id = $attr_id";
            $pro_res = $db->select($sql_pro_sql);
            $pro_id = $pro_res[0]->pid;

            $re_time = date('Y-m-d H:i:s', time());

            //给这条订单添加一条售后记录
            $instsql2 = "INSERT INTO `lkt_return_record`(`user_id`, `store_id`, `re_type`, `r_type`, `sNo`, `money`, `re_photo`, `product_id`, `attr_id`,`re_time`, `explain`, `p_id`) 
                                                VALUES ('$user_id',$store_id ,$type,1,'$r_sNo',$r_money,'$re_photo',$pro_id,$attr_id,'$re_time','$back_remark',$order_details_id)";
            $rr2 = $db->insert($instsql2);
            if($rr2<1){
                $lktlog->customerLog(__METHOD__.":".__LINE__."添加售后记录失败！sql:".$instsql2);
            }
            $db->commit();
            $time = date('Y-m-d H:i:s');

            $res = $Tools->del_session($db, $user_id, 2, $order_details_id);
            $date = array('product_title' => $p_name, 'sNo' => $r_sNo, 'time' => $time, 'refund_amount' => $refund_amount);
            echo json_encode(array('code' => 200, 'date' => $date, 'message' => '成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
        return;
    }

    public function base64_image_contents($base64_image_content, $path, $imgname)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $type = $result[2];
            $new_file = $path . "/";
            if (!file_exists($new_file)) {
                mkdir($new_file, 0700);
            }
            $new_file = $path . '/' . $imgname . ".{$type}";
            $storage_path = $imgname . ".{$type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                return $storage_path;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function a_array_unique($array)
    { //写的比较好（写方法）

        $out = array(); //定义变量out为一个数组
        foreach ($array as $key => $value) { //将$array数组按照$key=>$value的样式进行遍历
            if (!in_array($value, $out)) {//如果$value不存在于out数组中，则执行
                $out[$key] = $value; //将该value值存入out数组中
            }
        }
        return $out; //最后返回数组out
    }

    //提醒发货
    public function delivery_delivery()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $order_id = trim($request->getParameter('order_id')); // 订单id
        $lktlog = new LaiKeLogUtils("app/order.log");
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $access = $db->select($sql);
        if (!empty($access)) {
            $user_id = $access[0]->user_id;

            $order = $db->select("select delivery_status,mch_id,sNo from lkt_order where store_id = '$store_id' and user_id = '$user_id' and id = '$order_id' and delivery_status = '0' ");
            if ($order) {
                if (!empty($order[0]->mch_id)) {

                    $mch_id = $order[0]->mch_id;
                    $mch_id = substr($mch_id, 1, strlen($mch_id) - 2);
                    $mch = $db->select("select user_id from lkt_mch where store_id = '$store_id' and id = '$mch_id'");
                    $mch_user = $mch[0]->user_id;
                    $msg_title = "【" . $order[0]->sNo . "】订单提醒发货！";
                    $msg_content = "用户已经迫不及待想要见到宝贝啦！";
                    //给用户发送消息
                    $pusher = new LaikePushTools();
                    $pusher->pushMessage($mch_user, $db, $msg_title, $msg_content, $store_id, 'admin');
                }
                $sql_u = "update lkt_order set delivery_status='1',readd='0' where store_id = '$store_id' and user_id = '$user_id' and id = '$order_id' ";
                $r_u = $db->update($sql_u);
                if($r_u < 1){
                    $lktlog->customerLog(__METHOD__.":".__LINE__."修改订单提醒状态失败！sql:".$sql);
                }
                echo json_encode(array('code' => 200, 'message' => '提醒成功！'));
                exit();
            } else {
                echo json_encode(array('code' => 215, 'message' => '已经提醒过了,请稍后再试！'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }


    }

    /**
     * [check_invitation description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @return  校验邀请有奖完成资格
     * @version 2.0
     * @date    2018-12-29T15:58:30+0800
     */
    public function check_invitation($user_id = 'user50')
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $time = date('Y-m-d h:i:s', time());
        $request = $this->getContext()->getRequest();
        $store_type = trim($request->getParameter('store_type')) ? $request->getParameter('store_type') : 0;
        $this->store_type = $store_type;

        //查询是否开启邀请有奖功能
        $sql = "select order_time,payment_amount from lkt_invitation where store_id = '$store_id' and `store_type` = '$store_type' and status = '1' ";
        $invitation = $db->select($sql);
        if ($invitation) {
            $payment_amount = $invitation[0]->payment_amount;
            $shixiao_time = $invitation[0]->order_time;
            $gq_time = date("Y-m-d H:i:s", strtotime("-$shixiao_time days")); // 失效时间

            //查询是否有优惠券-推荐人
            $sql_c = "select id from lkt_coupon_activity where store_id = '$store_id' and activity_type = '8'";
            $res_c = $db->select($sql_c);

            if ($res_c) {
                $hs = '';
                foreach ($res_c as $keyc => $valuec) {
                    $hs .= $valuec->id . ',';
                }

                $hid = trim($hs, ',');

                //查询是否领取过优惠券
                $sql_lc = "select id from lkt_coupon where store_id = '$store_id' and hid in ($hid)";
                $res_lc = $db->select($sql_lc);

                if (!$res_lc) {
                    $sql_u = "select o.spz_price,u.Referee,u.Register_data,u.user_id,u.user_name,o.sNo,o.z_price,o.status from lkt_user as u left join lkt_order as o on u.user_id=o.user_id where u.Register_data >= '$gq_time' and o.add_time >= '$gq_time' and u.Referee !='' and u.store_id = '$store_id' and u.user_id = '$user_id' and o.status =3 ORDER BY u.Register_data desc";

                    $res_u = $db->select($sql_u);
                    if ($res_u) {
                        foreach ($res_u as $key => $value) {
                            //防止多个子订单不同状态-计算整个订单实付
                            $cprice = $this->calculate_order($db, $value->sNo, $value->z_price, $value->spz_price);
                            if ($cprice >= $payment_amount) {
                                // 推荐人发放
                                $Referee = $value->Referee;
                                $coupon = new coupon_pluginAction();
                                $coupon_list = $coupon->give($store_id, $Referee, 'invitation');
                                if (!empty($coupon_list)) {
                                    foreach ($coupon_list as $keyl => $valuel) {
                                        $ww = $this->wxss($Referee, (object)$valuel);
                                    }
                                }
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
     * @param 计算整个订单实付
     * @version 2.0
     * @date    2018-12-29T18:17:40+0800
     */
    public function calculate_order($db, $sNo, $z_price, $spz_price)
    {
        //判断单个商品退款是否有使用优惠
        $sql_id = "select m.num,m.p_price from lkt_order_details AS m where m.r_sNo = '$sNo' and m.r_status = '3' ";
        $variable = $db->select($sql_id);
        $price = 0;
        foreach ($variable as $key => $value) {
            $num = $value->num;
            $p_price = $value->p_price * $num;
            //计算实际支付金额
            $price += number_format($z_price / $spz_price * $p_price, 2, ".", "");
        }
        return $price;
    }

    public function wxss($user_id, $cdata)
    {
        $db = $this->db;
        $store_id = $this->store_id;
        $store_type = $this->store_type;
        $time = date('Y-m-d h:i:s', time());

        $sql_openid = "select wx_id,user_name from lkt_user where store_id = '$this->store_id' and user_id = '$user_id'";
        $res_openid = $this->db->select($sql_openid);
        $openid = $res_openid[0]->wx_id;
        $user_name = $res_openid[0]->user_name;

        //实例化
        $Tools = new Tools($db, $store_id, $store_type);
        $data = array();

        $data['page'] = 'pages/coupon/index?currentTab=1';
        $data['template_id'] = 'receive';
        $data['openid'] = $openid;

        $o_data = array();
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
        $tres = $Tools->send_notice($data, 'wx');

        return $tres ? ($tres->errcode == 'ok' ? true : false) : false;

    }

    /**
     * [check_invitation description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  熊孔钰
     * @return  分销
     * $dis_0->商品id     $dis_1->订单号
     * @version 2.0
     * @date    2019-03-27T15:58:30+0800
     */
    public function order_distribution($dis_0, $dis_1)
    {
        $db = $this->db;

        $comm = new Commission();

        $store_id = $this->store_id;
        $time = date('Y-m-d h:i:s', time());
        $request = $this->getContext()->getRequest();

        $dis_sql_0 = "select a.is_distribution,a.distributor_id,b.p_price,b.num,b.user_id 
                        from lkt_product_list a 
                        left join lkt_order_details b on a.id=b.p_id 
                        where a.store_id = '$store_id' and b.p_id = '$dis_0' and b.r_sNo='$dis_1' limit 0,1";
        $dis_res_0 = $db->select($dis_sql_0);

        if (!$dis_res_0) {
            return true;
        }

        $dis_5 = $dis_res_0[0]->user_id;//用户id

        $dis_16 = intval($dis_res_0[0]->is_distribution);//是否为分销商品

        $dis_15 = intval($dis_res_0[0]->distributor_id);//商品绑定等级

        $dis_2 = floatval($dis_res_0[0]->p_price) * intval($dis_res_0[0]->num);//计算价格

        if ($dis_2 > 0 && $dis_16 == 1) {
            //查询设置
            $dis_sql_1 = "select * from lkt_distribution_config where store_id = '$store_id' ";
            $dis_res_1 = $db->select($dis_sql_1);
            if (!$dis_res_1) {
                return true;
            }
            $dis_3 = unserialize($dis_res_1[0]->sets);

            $dis_4 = $dis_3['c_cengji'];//分销层级
            $dis_12 = $dis_3['c_neigou'];//是否内购 1是 0否
            if ($dis_4 < 1) {
                return true;
            }

            $team_put = array_key_exists('team', $dis_3) ? explode(",", $dis_3['team'][1]) : array();//团队业绩

            //分销等级相应佣金计算
            $dis_sql_2 = "select id,sets from lkt_distribution_grade where store_id = '$store_id'";
            $dis_res_2 = $db->select($dis_sql_2);
            $dis_6 = array();//所有等级相应应得奖励
            $dis_6['level0']['different'] = 0;//默认等级级差奖
            $dis_6['level0']['sibling'] = 0;//默认等级平级奖
            //循环所有等级
            foreach ($dis_res_2 as $k => $v) {
                $dis_7 = unserialize($v->sets);//等级配置
                if ($dis_7['price_type'] == 1) {//佣金计算单位为元时
                    $dis_6['level' . $v->id]['different'] = $dis_7['different'];//计算级差
                    $dis_6['level' . $v->id]['sibling'] = $dis_7['sibling'];//计算平级
                } else {//佣金计算单位为百分比%时
                    $dis_6['level' . $v->id]['different'] = round($dis_7['different'] * $dis_2 / 100, 2);//计算级差
                    $dis_6['level' . $v->id]['sibling'] = round($dis_7['sibling'] * $dis_2 / 100, 2);//计算平级
                }
                //循环每个等级内层级  计算相应层级佣金   $kk层级   $vv相应层级佣金计算参数
                foreach ($dis_7['levelmoney'] as $kk => $vv) {
                    if ($dis_7['price_type'] == 1) {//佣金计算单位为元时
                        $dis_6['level' . $v->id]['comm' . $kk] = $vv;
                    } else {//佣金计算单位为百分比%时
                        $dis_6['level' . $v->id]['comm' . $kk] = round($vv * $dis_2 / 100, 2);
                    }
                }
            }

            //查询推荐人
            $dis_sql_3 = "select b.pid,b.level,a.Referee from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and a.user_id = '$dis_5'";
            $dis_res_3 = $db->select($dis_sql_3);
            if ($dis_res_3) {
                //如果分销表用户不存在先创建用户
                if (empty($dis_res_3[0]->pid)) {
                    $comm->create_level($db, $dis_5, 0, $dis_res_3[0]->Referee, $store_id);
                }
                //用户推荐人不存在时，推荐人默认为第一个分销商
                if (empty($dis_res_3[0]->Referee)) {
                    $sql = "select user_id from lkt_user_distribution where store_id = '$store_id' order by rt desc";
                    $res = $db->select($sql);
                    $dis_res_3[0]->Referee = $res[0]->user_id;
                }

                $dis_8 = !empty($dis_res_3[0]->pid) ? $dis_res_3[0]->pid : $dis_res_3[0]->Referee;//推荐人id
                $dis_9 = intval($dis_res_3[0]->level) > 0 ? intval($dis_res_3[0]->level) : 0;//会员分销等级
                $i = 1;
                $dis_17 = array();//存储被拿佣金等级
                $dis_21 = 0;//已经获取的团队业绩奖金
                $dis_18 = 0;//已被获取的级差奖金额
                if ($dis_8 == $dis_5) {//当购买人id等于推荐人id时推荐人id为空
                    $dis_8 = '';
                }

                //判断内购
                if ($dis_12 != 1) {
                    //查询自己等级
                    $dis_sql_5 = "select level,team_put from lkt_user_distribution where store_id = '$store_id' and user_id = '$dis_5'";
                    $dis_res_5 = $db->select($dis_sql_5);
                    //购买人等级  如果分销等级为空 那么分销等级为商品绑定的分销等级
                    $dis_13 = empty($dis_res_5[0]->level) ? $dis_15 : intval($dis_res_5[0]->level);
                    $dis_14 = intval($dis_13) > 0 ? $dis_6['level' . $dis_13]['comm1'] : 0;//用户为分销商时应获得的佣金
                    $dis_20 = floatval($dis_res_5[0]->team_put);//团队业绩奖
                    //当团队业绩提成大于0时
                    if ($dis_20 > 0) {
                        $dis_22 = round($dis_2 * $dis_20 / 100, 2);
                        $dis_14 += $dis_22 > 0 ? $dis_22 : 0;
                        $dis_21 = $dis_22 > 0 ? $dis_22 : $dis_21;
                    }
                    //当级差奖大于零时
                    if ($dis_6['level' . $dis_13]['different'] > 0) {
                        $dis_14 += $dis_6['level' . $dis_13]['different'];//层级佣金+级差奖
                        $dis_18 = floatval($dis_6['level' . $dis_13]['different']) > floatval($dis_18) ? $dis_6['level' . $dis_13]['different'] : $dis_18;//当可获取级差奖大于已领取级差奖金时更新已领取奖金
                        $dis_17[$dis_13] = 0;//存储此等级到数组，表示此等级级差奖已被领取
                    }
                    //当佣金大于零时插入佣金记录
                    if ($dis_14 > 0) {
                        $dis_11 = "会员" . $dis_5 . "获得" . $dis_14 . "佣金";
                        $dis_sql_6 = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$dis_5','$dis_5','$dis_14','$dis_1','$i','$dis_11','1',CURRENT_TIMESTAMP)";
                        $dis_res_6 = $db->insert($dis_sql_6);
                        if ($dis_res_6 < 1) {
                            return false;
                        }
                    }

                    $i = 2;
                }
                //当推荐人存在时
                if ($dis_8 && !empty($dis_8)) {
                    //while循环查询上级并计算佣金
                    while ($i <= $dis_4) {
                        //查询用户推荐人，分销商等级
                        $dis_sql_4 = "select pid,level,team_put from lkt_user_distribution where store_id = '$store_id' and user_id = '$dis_8'";
                        $dis_res_4 = $db->select($dis_sql_4);
                        $dis_9 = empty($dis_res_4[0]->level) ? 0 : intval($dis_res_4[0]->level);//分销商等级
                        $dis_23 = floatval($dis_res_4[0]->team_put);//团队业绩奖

                        if (!empty($dis_9) && $dis_9 > 0) {

                            $dis_10 = $dis_6['level' . $dis_9]['comm' . $i];//用户应得层级佣金
                            if (array_key_exists($dis_9, $dis_17)) {//当级差奖已被拿的时候
                                if ($dis_17[$dis_9] == 0) {
                                    $dis_10 += $dis_6['level' . $dis_9]['sibling'];
                                    $dis_17[$dis_9] = 1;
                                }
                            } else {//当级差奖还没有被拿的时候
                                //计算级差奖  等级相应级差奖-已被领取级差奖
                                $dis_19 = floatval($dis_6['level' . $dis_9]['different']) - floatval($dis_18);
                                $dis_10 += $dis_19 < 0 ? 0 : $dis_19;//层级佣金+级差奖，当获取的级差奖小于或等于0时，级差奖为0
                                $dis_18 = floatval($dis_6['level' . $dis_9]['different']) > floatval($dis_18) ? $dis_6['level' . $dis_9]['different'] : $dis_18;//当可获取级差奖大于已领取级差奖金时更新已领取奖金
                                $dis_17[$dis_9] = 0;//存储此等级到数组，表示此等级级差奖已被领取
                            }
                            //当团队业绩提成大于0时
                            if ($dis_23 > 0) {
                                $dis_24 = round(floatval($dis_2 * $dis_23 / 100) - floatval($dis_21), 2);
                                $dis_10 += $dis_24 > 0 ? $dis_24 : 0;
                                $dis_21 = $dis_24 > 0 ? $dis_24 : $dis_21;
                            }
                            //当佣金大于零时插入佣金记录
                            if ($dis_10 > 0) {
                                $dis_11 = "会员" . $dis_8 . "获得" . $dis_10 . "佣金";
                                $dis_sql_7 = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$dis_8','$dis_5','$dis_10','$dis_1','$i','$dis_11','1',CURRENT_TIMESTAMP)";
                                $dis_res_7 = $db->insert($dis_sql_7);
                                if ($dis_res_7 < 1) {
                                    return false;
                                }
                            }
                        }

                        if ($dis_res_4 && !empty($dis_res_4[0]->pid)) {
                            //当用户推荐人存在时  继续循环
                            $dis_8 = $dis_res_4[0]->pid;
                            $i++;

                        } else {
                            // 当用户推荐人不存在时，结束循环
                            break;
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     * 订单拆分后的消息推送和消息记录
     * @param $sNo
     * @param $store_id
     * @param $user_id
     * @param $db
     * @param $shop_id
     */
    public function orderMessage($sNo, $store_id, $user_id, $db, $shop_id)
    {
        $sql = " SELECT t.sNo,t.mch_id,t.status FROM lkt_order t WHERE p_sNo = '$sNo'";
        if (count($shop_id) == 1) {
            $sql = " SELECT t.sNo,t.mch_id FROM lkt_order t WHERE sNo = '$sNo'";
        }
        $r1 = $db->select($sql);
        if ($r1) {

            foreach ($r1 as $ke => $va) {
                $r_sNo = $va->sNo;
                $msg_title = "【" . $r_sNo . "】订单支付成功！";
                $msg_content = "您的宝贝马上就会发货啦！" . $r1[0]->status;
                /**买家付款成功通知*/
                $pusher = new LaikePushTools();
                $pusher->pushMessage($user_id, $db, $msg_title, $msg_content, $store_id, '');

                $mch_id = $va->mch_id;
                $mch_id = substr($mch_id, 1, -1);
                $sql0 = "select user_id from lkt_mch where id = " . $mch_id;
                $r0 = $db->select($sql0);
                $msg_title = "您有新的订单啦!";
                $pusher->pushMessage($r0[0]->user_id, $db, $msg_title, "订单号【" . $r_sNo . "】,请发货", $store_id, '');
            }
        }
    }

    // 查看提货码
    public function see_extraction_code()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('order_id'));// 订单id

        // 根据微信id,查询用户id
        $sql0 = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r0 = $db->select($sql0);
        if ($r0) {
            $user_id = $r0[0]->user_id;
            $sql1 = "select a.z_price,a.sNo,a.status,a.mch_id,a.extraction_code,a.extraction_code_img,b.p_id,b.p_price,b.num,b.size,b.sid from lkt_order as a left join lkt_order_details as b on a.sNo = b.r_sNo where a.store_id = '$store_id' and a.id = '$id' and a.user_id = '$user_id'";
            $r1 = $db->select($sql1);
            if ($r1) {
                $rew = explode(',', $r1[0]->extraction_code); // 提现码

                $status = $r1[0]->status; // 订单状态
                $z_price = $r1[0]->z_price; // 订单状态
                $sNo = $r1[0]->sNo; // 订单状态

                if ($status == 2) {
                    if (count($rew) != 3) {
                        // 店铺
                        $mch = new mch();
                        $shop = $mch->Settlement2($db, $store_id, $id);
                        $extraction_code1 = $shop['extraction_code'];
                        $extraction_code2 = explode(',', $extraction_code1);
                        $extraction_code = $extraction_code2[0];
                        $extraction_code_img = $shop['extraction_code_img'];
                    } else {
                        if ($rew[2] <= time()) { // 提货码有效时间 小于等于 当前时间
                            // 店铺
                            $mch = new mch();
                            $shop = $mch->Settlement2($db, $store_id, $id);
                            $extraction_code1 = $shop['extraction_code'];
                            $extraction_code2 = explode(',', $extraction_code1);
                            $extraction_code = $extraction_code2[0];
                            $extraction_code_img = $shop['extraction_code_img'];
                        } else {
                            $extraction_code = $rew[0]; // 提现码
                            $extraction_code_img = $r1[0]->extraction_code_img; // 提现码二维码
                        }
                    }
                } else {
                    $extraction_code = $rew[0]; // 提现码
                    $extraction_code_img = $r1[0]->extraction_code_img; // 提现码二维码
                }
                $num = 0;
                foreach ($r1 as $k => $v) {
                    $p_id = $v->p_id; // 商品ID
                    $sid = $v->sid; // 属性ID


                    // 根据产品id,查询产品列表 (产品图片)
                    $sql2 = "select a.product_title,c.img from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = '$p_id' AND c.id= '$sid' ";
                    $r2 = $db->select($sql2);
                    $product_title = $r2[0]->product_title; // 商品名称
                    $img = ServerPath::getimgpath($r2[0]->img); // 拼图片路径
                    $num = $num + $v->num;
                    $por_list[$k]['p_id'] = $v->p_id;
                    $por_list[$k]['product_title'] = $product_title;
                    $por_list[$k]['p_price'] = $v->p_price;
                    $por_list[$k]['num'] = $v->num;
                    $por_list[$k]['sid'] = $v->sid;
                    $por_list[$k]['size'] = $v->size;
                    $por_list[$k]['img'] = $img;
                }

                $arr = array('status' => $status, 'extraction_code' => $extraction_code, 'extraction_code_img' => $extraction_code_img, 'por_list' => $por_list, 'z_price' => $z_price, 'sNo' => $sNo, 'num' => $num);
                echo json_encode(array('code' => 200, 'list' => $arr, 'message' => '成功'));
                exit();
            } else {
                echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
                exit;
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

}

?>