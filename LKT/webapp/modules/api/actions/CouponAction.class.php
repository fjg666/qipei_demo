<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/coupon_pluginAction.class.php');
require_once('Apimiddle.class.php');

class CouponAction extends Apimiddle
{
    /*
    时间2018年03月26日
    修改内容：优惠券
    修改人：段宏波
    主要功能：处理小程序首页请求结果
    公司：湖南壹拾捌号网络技术有限公司
     */
    public function getDefaultView() {
        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 获取小程序优惠券活动
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = trim($request->getParameter('store_id'));
        $openid = trim($request->getParameter('openid')); // 微信id

        // 查询用户id
        $sql = "select user_id,Register_data from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $user = $db->select($sql);
        $user_id = $user[0]->user_id;

        $coupon = new coupon_pluginAction();
        $coupon_arr = $coupon->index($store_id,$user_id);
        array_multisort(array_column($coupon_arr,'point_type'),SORT_ASC,$coupon_arr);

        echo json_encode(array('list'=>$coupon_arr));
        exit();
    }
    // 点击领取
    public function receive(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $openid = trim($request->getParameter('openid')); // 微信id
        $id = trim($request->getParameter('id')); // 活动id

        // 查询用户id
        $sql = "select user_id,Register_data from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $user = $db->select($sql);
        if($user){
            $user_id = $user[0]->user_id; // 用户id

            $coupon = new coupon_pluginAction();
            $res = $coupon->receive($store_id,$user_id,$id);

            echo json_encode(array('status'=>1,'info'=>$res));
            exit();
        }else{
            echo json_encode(array('status'=>0,'info'=>'网络繁忙！'));
            exit();
        }
    }
    // 我的优惠券
    public function mycoupon(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('openid')); // 微信id

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id;

            $coupon = new coupon_pluginAction();
            $list = $coupon->mycoupon($store_id,$user_id);
            echo json_encode(array('status'=>1,'list1'=>$list[0],'list2'=>$list[1],'list3'=>$list[2]));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

    }
    // 立即使用
    public function immediate_use(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $id = trim($request->getParameter('id')); // 优惠券id
        $openid = trim($request->getParameter('openid')); // 微信id
        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id;
            $coupon = new coupon_pluginAction();
            $list = $coupon->immediate_use($store_id,$user_id,$id);

            echo json_encode(array('status'=>1));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }
    }

    // 我的优惠券(可以使用的)
    public function my_coupon(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('openid')); // 微信id
        $cart_id = trim($request->getParameter('cart_id')); //  购物车id

        $typestr=trim($cart_id,','); // 移除两侧的逗号
        $typeArr=explode(',',$typestr); // 字符串打散为数组
        $zong =0;

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id; // 用户id
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }

        // 根据用户id,查询收货地址
        $sql_a = 'select id from lkt_user_address where store_id = \''.$store_id.'\' and uid=\''.$user_id.'\'';
        $r_a = $db->select($sql_a);
        $address = [];
        $yunfei = 0;
        if(!empty($r_a)){
            // 根据用户id、默认地址,查询收货地址信息
            $sql_e = 'select * from lkt_user_address where store_id = \''.$store_id.'\' and uid=\''.$user_id.'\' and is_default = 1';
            $r_e = $db->select($sql_e);
            if(!empty($r_e)){
                $address = (array)$r_e['0']; // 收货地址
            }else{
                // 根据用户id、默认地址,查询收货地址信息
                $aaaid = $r_a[0]->id;
                $sql_q = "select * from lkt_user_address where  store_id = '$store_id' andid= '$aaaid'";
                $r_e = $db->select($sql_q);
                $address = (array)$r_e['0']; // 收货地址
                $sql_u = "update lkt_user_address set is_default = 1 where store_id = '$store_id' and id = '$aaaid'";
                $db->update($sql_u);
            }
        }
        foreach ($typeArr as $key => $value) {
            // 联合查询返回购物信息
            $sql_c = "select a.Goods_num,a.Goods_id,a.id,m.product_title,m.volume,c.price,c.attribute,c.img,c.yprice,m.freight,m.product_class from lkt_cart AS a LEFT JOIN lkt_product_list AS m ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c ON a.Size_id = c.id  where a.store_id = '$store_id' and c.num >0 and m.status ='0' and a.id = '$value'";
            $r_c = $db->select($sql_c);
            $product = (array)$r_c['0']; // 转数组
            $attribute = unserialize($product['attribute']);
            $product_id[] = $product['Goods_id']; // 商品id数组
            $product_class[] = $product['product_class']; // 商品分类数组
            $size = '';
            foreach ($attribute as $ka => $va) {
                $size .= ' '.$va;
            }
            $Goods_id = $product['Goods_id'];

            $num = $product['Goods_num']; // 产品数量
            $price = $product['price']; // 产品价格
            $product['size'] = $size; // 产品价格
            $zong += $num*$price; // 产品总价

            //计算运费
            $yunfei = $yunfei + $this->freight($product['freight'],$product['Goods_num'],$address,$db);

            $res[$key] = $product;
        }
        $coupon = new coupon_pluginAction();
        $list = $coupon->my_coupon($store_id,$user_id,$zong,$product_id,$product_class);
        if($list != []){
            echo json_encode(array('list'=>$list));
            exit();
        }else{
            echo json_encode(array('status'=>0,'info'=>'暂无数据'));
            exit();
        }
    }

    // 选择优惠券
    public function getvou(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
//        $cart_id = trim($request->getParameter('cart_id')); // 购物车id
        $openid = trim($request->getParameter('openid')); // 微信id
        $coupon_id = trim($request->getParameter('coupon_id')); // 优惠券id
        // 根据活动id,查询活动信息
        $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id; // 用户id
            $coupon = new coupon_pluginAction();
            $list = $coupon->getvou($store_id,$user_id,$coupon_id);

            echo json_encode(array('status'=>1,'id'=>$list['id'],'money'=>$list['money']));
            exit();
        }else{
            echo json_encode(array('status'=>0,'err'=>'网络繁忙！'));
            exit();
        }
    }

    public function freight($freight,$num,$address,$db){
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql = "select * from lkt_freight where store_id = '$store_id' and id = '$freight'";
        $r_1 = $db->select($sql);
        if($r_1){
            $rule = $r_1[0];
            $yunfei = 0;
            if(empty($address)){
                return 0;
            }else{
                $sheng = $address['sheng'];
                $sql2 = "select G_CName from admin_cg_group where GroupID = '$sheng'";
                $r_2 = $db->select($sql2);
                if($r_2){
                    $city = $r_2[0]->G_CName;
                    $rule_1 = $r_1[0]->freight;
                    $rule_2 = unserialize($rule_1);

                    foreach ($rule_2 as $key => $value) {
                        $citys_str = $value['name'];
                        $citys_array=explode(',',$citys_str);
                        $citys_arrays = [];
                        foreach ($citys_array as $k => $v) {
                            $citys_arrays[$v] = $v;
                        }
                        if(array_key_exists($city , $citys_arrays)){
                            if($num > $value['three']){
                                $yunfei += $value['two'];
                                $yunfei += ($num-$value['three'])*$value['four'];
                            }else{
                                $yunfei += $value['two'];
                            }
                        }
                    }
                    return $yunfei;
                }else{
                    return 0;
                }
            }
        }else{
            return 0;
        }
    }
}

?>