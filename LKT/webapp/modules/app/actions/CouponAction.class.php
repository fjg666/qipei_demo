<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');

class CouponAction extends Action
{
    /*
    时间2018年03月26日
    修改内容：优惠券
    修改人：段宏波
    主要功能：处理小程序首页请求结果
    公司：湖南壹拾捌号网络技术有限公司
     */
    public function getDefaultView()
    {

    }

    public function execute()
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

        $uid = '';
        $access_id = addslashes(trim($request->getParameter('access_id'))); // 授权id
        $openid = addslashes(trim($request->getParameter('openid'))); // openid
        $store_type = addslashes(trim($request->getParameter('store_type')));
        $store_id = addslashes(trim($request->getParameter('store_id')));
        if($app != 'index' && $app != 'pro_coupon'){
            if(!empty($access_id)){ // 存在
                $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                if($getPayload_test == false){ // 过期
                    echo json_encode(array('code' => 404, 'message' => '请登录！'));
                    exit;
                }
            }
        }

        // 查询会员信息
        $sql = "select * from lkt_user where access_id = '$access_id' and store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $this->db = $db;
            $this->user = $r[0];
            $this->store_id = $store_id;
            $this->user_money = $r[0]->money;

        }
        if ($app) {
            $this->$app();
        } else {
            $this->$m();
        }
        exit;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    // 获取小程序优惠券活动
    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 微信id

        if($access_id == ''){
            $user_id = '';
        }else{
            // 查询用户id
            $sql = "select user_id,Register_data from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $user = $db->select($sql);
            if ($user) {
                $user_id = $user[0]->user_id;
            } else {
                $user_id = '';
            }
        }

        $coupon = new coupon();
        $coupon_arr = $coupon->index($store_id, $user_id);

        array_multisort(array_column($coupon_arr, 'point_type'), SORT_ASC, $coupon_arr);

        echo json_encode(array('code' => 200, 'list' => $coupon_arr, 'message' => '成功'));
        exit();
    }

    // 点击领取
    public function receive()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('id')); // 活动id
        if (empty($access_id)) {
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
        // 查询用户id
        $sql = "select user_id,Register_data from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $user = $db->select($sql);
        if ($user) {
            $user_id = $user[0]->user_id; // 用户id

            $coupon = new coupon();
            $res = $coupon->receive($store_id, $user_id, $id);

            echo json_encode(array('code' => 200, 'money' => $res, 'message' => '成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    // 我的优惠券
    public function mycoupon()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $type = trim($request->getParameter('type')); // 授权id

        if (empty($access_id)) {
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if ($r) {
            $user_id = $r[0]->user_id;

            $coupon = new coupon();
            $list = $coupon->mycoupon($store_id, $user_id,$type);

            echo json_encode(array('code' => 200, 'list' => $list, 'message' => '成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    // 立即使用
    public function immediate_use()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $id = trim($request->getParameter('id')); // 优惠券id
        $access_id = trim($request->getParameter('access_id')); // 授权id

        if (empty($access_id)) {
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if ($r) {
            $user_id = $r[0]->user_id;

            $coupon = new coupon();
            $list = $coupon->immediate_use($store_id, $user_id, $id);

            echo json_encode(array('code' => 200, 'message' => '成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 我的优惠券(可以使用的)
    public function my_coupon()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $user = $this->user;
        $user_id = $user->user_id;

        $product1 = addslashes($request->getParameter('product'));//  商品数组--------['pid'=>66,'cid'=>88]
        $cart_id = addslashes(trim($request->getParameter('cart_id')));  //购物车id-- 12,13,123,
        $product = '';
        if($product1 != '' && $product1 != 'undefined'){
            $product1 = htmlspecialchars_decode($product1);
            $product2 = json_decode($product1); // 字符串打散为数组
            foreach ($product2 as $k => $v){
                foreach ($v as $ke => $va){
                    $product3[$ke] = $va;
                }
            }
            $product = implode(',',$product3);
            $cart_id = '';
        }
        $products_total = 0;
        //2.区分购物车结算和立即购买---列出选购商品
        $products = Tools::products_list($db, $store_id, $cart_id, $product);
        //3.列出商品数组-计算总价和优惠，运费
        $products_data = Tools::get_products_data($db, $store_id, $products, $products_total);
        $product_id = $products_data['product_id'];
        $product_class = $products_data['product_class'];
        $products_total = $products_data['products_total'];

        $coupon = new coupon();
        $list = $coupon->my_coupon($store_id, $user_id, $products_total, $product_id, $product_class);
        if ($list != []) {
            echo json_encode(array('code' => 200, 'list' => $list, 'message' => '成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 108, 'message' => '暂无数据'));
            exit();
        }

    }

    // 选择优惠券
    public function getvou()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $address_id = $request->getParameter('address_id'); //  地址id
        $x_coupon_id = trim($request->getParameter('coupon_id')); // 优惠券id
        $product1 = addslashes($request->getParameter('product'));//  商品数组--------['pid'=>66,'cid'=>88]
        $cart_id = addslashes(trim($request->getParameter('cart_id')));  //购物车id-- 12,13,123,
        $product = '';
        if($product1 != '' && $product1 != 'undefined'){
            $product1 = htmlspecialchars_decode($product1);
            $product2 = json_decode($product1); // 字符串打散为数组
            foreach ($product2 as $k => $v){
                foreach ($v as $ke => $va){
                    $product3[$ke] = $va;
                }
            }
            $product = implode(',',$product3);
            $cart_id = '';
        }
        if (empty($access_id)) {
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }

        $products_total = 0;
        //2.区分购物车结算和立即购买---列出选购商品
        $products = Tools::products_list($db, $store_id, $cart_id, $product);

        //3.列出商品数组-计算总价和优惠，运费
        $products_data = Tools::get_products_data($db, $store_id, $products, $products_total);
        $products_freight = $products_data['products_freight'];
        $products = $products_data['products'];
        $products_total = $products_data['products_total'];

        // 根据活动id,查询活动信息
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if ($r) {
            $user_id = $r[0]->user_id; // 用户id

            //查询默认地址
            $address = Tools::find_address($db,$store_id,$user_id,$address_id);

            //4.计算运费
            $freight = Tools::get_freight($products_freight,$products, $address,$db,$store_id,'');
            $products = $freight['products'];
            $yunfei = $freight['yunfei'];


            $coupon = new coupon();
            $list = $coupon->getvou($store_id, $user_id, $x_coupon_id,$products_total);
            if($list['activity_type'] == 1){
                $yunfei = 0;
            }else{
                $yunfei = $yunfei;
            }
            echo json_encode(array('code' => 200, 'id' => $list['id'], 'money' => $list['money'], 'coupon_name' => $list['coupon_name'],'freight' => $yunfei, 'message' => '成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit;
        }
    }

    // 获取商品可用优惠券活动
    public function pro_coupon()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id')); // 微信id
        $pro_id = trim($request->getParameter('pro_id')); // 商品id

        if($access_id == ''){
            $user_id = '';
        }else{
            // 查询用户id
            $sql = "select user_id,Register_data from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $user = $db->select($sql);
            if ($user) {
                $user_id = $user[0]->user_id;
            } else {
                $user_id = '';
            }
        }

        $coupon = new coupon();
        $coupon_arr = $coupon->pro_coupon($store_id, $user_id,$pro_id);

        array_multisort(array_column($coupon_arr, 'point_type'), SORT_ASC, $coupon_arr);

        echo json_encode(array('code' => 200, 'list' => $coupon_arr, 'message' => '成功'));
        exit();
    }
}

?>