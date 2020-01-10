<?php
require_once ('aliyun-dysms-php-sdk-lite/demo/sendSms.php');
require_once ('JWT.php');
class Tools
{
    function __construct($db, $store_id, $store_type)
    {
        $this->db = $db;
        $this->store_id = $store_id;
        $this->store_type = $store_type;
        $this->get_config($db, $store_id);
    }

    public function get_config($db, $store_id)
    {
        $sql_conf = "select * from lkt_config where store_id = '$store_id' ";
        $res_conf = $db->select($sql_conf);
        if ($res_conf) {
            $this->config = $res_conf[0];
        } else {
            $this->config = [];
        }
    }
    /**
     * 获取详情数据
     * @param DBAction $db
     * @param $content
     * @return array
     */
    public static function getContent($db, $content)
    {
        $uploadImg_domain = 'https://xiaochengxu.laiketui.com/V3';
        // 查询系统参数
        $sql = "select * from lkt_upload_set ";
        $r_1 = $db->select($sql);
        if ($r_1) {
            foreach ($r_1 as $K => $v) {
                if ($v->type == '本地' && $v->attr == 'uploadImg_domain') {
                    $uploadImg_domain = $v->attrvalue; // 图片上传域名
                }
            }
        }

        $newa = substr($uploadImg_domain, 0, strrpos($uploadImg_domain, '/'));
        if ($newa == 'http:/' || $newa == 'https:/') {
            $newa = $uploadImg_domain;
        }
        $contarr = array();
        $new_content = $content;
        preg_match_all('/(<img.+?src=\"http)(.*?)/', $content, $contarr);
        if (empty($contarr[0])) {
            $new_content = preg_replace('/(<img.+?src=")(.*?)/', "$1$newa$2", $content);
        }
        return $new_content;
    }

    /**
     * [check_phone description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-10T19:16:19+0800
     * @param   [type]                   $mobile [description]
     * @return  [type]                验证手机号 [description]
     */
    public static function check_phone($mobile)
    {
//        if (preg_match("/^1[34578]\d{9}$/", $mobile)) {
        if(preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $mobile)){
                return true;
        } else {
            return false;
        }
    }

    /**
     * [send_notice description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-02T10:21:58+0800
     * @param   [type]                   $db          [description]
     * @param   [type]                   $store_id    [description]
     * @param   [type]                   $store_type  [description]
     * @param   [type]                   $data        [description]
     * @param   string $template_id [description]
     * @return  [type]                   发送通知
     */
    public function send_notice($data, $type = 'wx')
    {
        //区分不同类型发送
        if ($type == 'wx') {
            $msg = $this->wx_msg($data);
        } else {
            // $msg = $this->app_msg($data);
            $msg = false;
        }
        return $msg;
    }

    public function wx_msg($data)
    {

        $openid = $data['openid'];
        //获取fromid
        $form_id = self::get_fromid($this->db, $this->store_id, $openid);

        if ($form_id) {
            //定义点击界面
            $page = $data['page'];
            // 获取消息模板id
            $template_id = self::get_template_id($this->db, $this->store_id, $data['template_id']);

            $AccessToken = $this->getAccessToken();
            //设置消息数组
            $o_data = $data['o_data'];

            //拼凑最终data
            $s_data = json_encode(array('access_token' => $AccessToken, 'touser' => $openid, 'template_id' => $template_id, 'form_id' => $form_id, 'page' => $page, 'data' => $o_data));
            $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;
            $da = self::httpsRequest($url, $s_data);

            $res = json_decode($da);

            if ($res->errcode == 'ok') {
                self::get_fromid($this->db, $this->store_id, $openid, $form_id);
            }
            return $res;
        } else {
            return false;
        }

    }

    /**
     * [httpsRequest description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     */
    public static function httpsRequest($url, $data = null)
    {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);  
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);   
        //这个是重点。
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

    public function getAccessToken()
    {
        $appID = $this->config->appid;
        $appSerect = $this->config->appsecret;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appSerect;
        // 时效性7200秒实现
        // 1.当前时间戳
        $currentTime = time();
        // 2.修改文件时间
        $fileName = $appID . "_accessToken";
        // 文件名
        $accessToken = "";
        if (is_file($fileName)) {
            $modifyTime = filemtime($fileName);
            if (($currentTime - $modifyTime) < 7200) {
                //文件内容为空重新申请
                $accessToken = file_get_contents($fileName);
                if(empty($accessToken)){
                    $accessToken = $this->getAccess_token($url);
                    file_put_contents($fileName, $accessToken);
                }
            } else {
                //值过期需要重新取
                $accessToken = $this->getAccess_token($url);
                file_put_contents($fileName, $accessToken);
            }
        }else if(!file_exists($fileName)){
            //没有文件重新写
            $accessToken = $this->getAccess_token($url);
            file_put_contents($fileName, $accessToken);
        }
        return $accessToken;
    }

    /**
     * @param $url
     * @return string
     */
    public function  getAccess_token($url){
        $result = self::httpsRequest($url);
        $jsonArray = json_decode($result, true);
        $accessToken = $jsonArray['access_token'];
        if(!empty($accessToken)){
            return $accessToken;
        }
        return "";
    }



    public static function get_fromid($db, $store_id, $openid, $type = '')
    {

        if (empty($type)) {
            $fromidsql = "select fromid,open_id from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and id=(select max(id) from lkt_user_fromid where open_id='$openid')";
            $fromidres = $db->select($fromidsql);
            if ($fromidres) {
                $fromid = $fromidres[0]->fromid;
                return $fromid;
            } else {
                return false;
            }
        } else {
            $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and fromid='$type'";
            $re2 = $db->delete($delsql);
            return $re2;
        }

    }

    // 获取用户会话密钥
    public static function code_open($appid, $appsecret, $code)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $appsecret . '&js_code=' . $code . '&grant_type=authorization_code';
        $res = self::httpsRequest($url);
        $user = (array)json_decode($res);
        return $user;
    }

    public static function get_openid($db, $store_id, $user_id)
    {
        //查询openid
        $sql_openid = "select wx_id from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
        $res_openid = $db->select($sql_openid);
        return $res_openid ? $res_openid[0]->wx_id : false;
        // $openid = $res_openid[0]->wx_id;
    }

    /**
     * [get_fromid description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-02T10:59:21+0800
     * 静态方法获取模板ID
     */
    public static function get_template_id($db, $store_id, $name)
    {
        $sql = "select * from lkt_notice where store_id = '$store_id' ";
        $r = $db->select($sql);
        //退款模板
        $template_id = $r ? $r[0]->$name : '666';
        return $template_id;
    }

    /**
     * [array_key_remove description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2019-01-08T17:44:00+0800
     * @param   [type]                   $arr [description]
     * @param   [type]                   $key [description]
     * @return  [type]          删除指定数组元素[description]
     */
    public static function array_key_remove($arr, $key)
    {
        if (!array_key_exists($key, $arr)) {
            return $arr;
        }
        $keys = array_keys($arr);
        $index = array_search($key, $keys);
        if ($index !== FALSE) {
            array_splice($arr, $index, 1);
        }
        return $arr;
    }

    //区分购物车结算和立即购买---列出选购商品
    public static function products_list($db, $store_id, $cart_id, $product, $product_type='PT')
    {
        $products = [];
        if (!empty($cart_id)) {
            if (is_string($cart_id)) {
                //是字符串
                $typestr = trim($cart_id, ','); // 移除两侧的逗号
                $cartArr = explode(',', $typestr); // 字符串打散为数组
            } else {
                $cartArr = $cart_id;
            }
            foreach ($cartArr as $key => $value) {
                // 根据购物车id，查询购物车信息
                $sql = "select Goods_id,Size_id,Goods_num from lkt_cart where store_id = '$store_id' and id = '$value' and Goods_num > 0";
                $y_cart = $db->select($sql);
                if ($y_cart) {
                    $products[$key] = array('pid' => $y_cart['0']->Goods_id, 'cid' => $y_cart['0']->Size_id, 'num' => $y_cart['0']->Goods_num);
                }
            }
        } else {
            $arr = array();
            if (empty($product)) {
                echo json_encode(array('status' => 0, 'err' => '存在库存不足的商品！'));
                exit;
            } else {
                $typestr = trim($product, ','); // 移除两侧的逗号
                $cartArr = explode(',', $typestr); // 字符串打散为数组

                $arr['pid'] = $cartArr[0];
                $arr['cid'] = $cartArr[1];
                $arr['num'] = $cartArr[2];

                $sql0 = "select status from lkt_product_list where id = '$cartArr[0]'";
                $r0 = $db->select($sql0);
                if($r0){
                    $status = $r0[0]->status;
                    if($status == 1){
                        echo json_encode(array('code'=>221,'message'=>'该商品已下架！'));
                        exit;
                    }
                    $sql1 = "select num from lkt_configure where pid = '$cartArr[0]' and id = '$cartArr[1]'";
                    $r1 = $db->select($sql1);
                    if($r1){
                        $num = $r1[0]->num;
                        if($num < $cartArr[2]){
                            if ($product_type != 'KJ') {
                                echo json_encode(array('code'=>105,'message'=>'库存不足！'));
                                exit;
                            }
                        }
                    }else{
                        echo json_encode(array('code'=>109,'message'=>'参数错误！'));
                        exit;
                    }
                }else{
                    echo json_encode(array('code'=>109,'message'=>'参数错误！'));
                    exit;
                }
            }
            $products[0] = array('pid' => $arr['pid'], 'cid' => $arr['cid'], 'num' => $arr['num'] ? $arr['num'] : 1);
        }
        if (empty($products)) {
            echo json_encode(array('status' => 0, 'err' => '存在库存不足的商品！'));
            exit;
        }
        return $products;
    }

    
    /**
     * 第三方授权日志生成函数
     * @param $file 生成日志文件路径
     * @param $msg  日志内容
     */
    public  function thirdLog($file,$msg){

        $fp = fopen($file,'a');
        flock($fp,LOCK_EX);
        fwrite($fp,"生成日期：".date("Y-m-d H:i:s")."\r\n".$msg."\r\n");
        flock($fp,LOCK_UN);
        fclose($fp);
    }
    /**
     * [array_key_remove description]
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @title   http网络请求
     * @Author  凌烨棣
     * @param string $url : 网络地址
     * @param json $data ： 发送的json格式数据
     * @param type： 1-普通post请求，以文件流返回而不是直接输出  2-处理图片post请求,且为直接输出
     */
    public  function https_post($url,$data,$type = 1)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if($type == 1){
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        }else{
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
        }
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    /**
     * [array_key_remove description]
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @title   http网络请求
     * @Author  凌烨棣
     * @param string $url : 网络地址
     * @param type： 1-普通get请求，以文件流返回而不是直接输出  2-处理图片get请求,且为直接输出
     */
    public function https_get($url,$type = 1)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if($type == 1){
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); 
        }else{
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, FALSE); 
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl, CURLOPT_HEADER, FALSE) ; 
        curl_setopt($curl, CURLOPT_TIMEOUT,60);
       
        if (curl_errno($curl)) {
            return 'Errno'.curl_error($curl);
        }else{
            $result=curl_exec($curl);
        }
        curl_close($curl);
        return $result;
    }

    /**
     * [array_key_remove description]
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  凌烨棣
     * @version 2.0
     * @return  [products]         商品数组[pid,cid,num]
     */
    //列出选购商品，--竞拍商品
    public static function products_JP_list($db,$store_id,$auction_id){

        $product = array();

        $sql = "select id,attribute from lkt_auction_product where store_id = '$store_id' and id = '$auction_id'";
        $res = $db->select($sql);
        $attribute_1 = $res[0]->attribute;
        $attribute = unserialize($attribute_1);//商品id和规格id数组
        $i = 0;

        if(!$attribute){

            echo json_encode(array('code'=>110,'info'=>'查询规格异常'));
            exit;
        }else{

            foreach($attribute as $k => $v){//$k->商品id  $v-规格id

                //循环规格id，将商品id，规格id，商品num打入新数组 product
                foreach($v as $k1 => $v1){

                    $product[$i]['pid'] = $k;
                    $product[$i]['cid'] = $v1;
                    $product[$i]['num'] = 1;
                    $i++;
                }

            }
        }

        return $product;
    }
    //列出选购商品，--砍价商品
    public static function products_KJ_list($db,$store_id,$bargain_id){
        $product = array();
        $sql = "select attr_id,goods_id from lkt_bargain_goods where store_id = '$store_id' and id = '$bargain_id'";
        $res = $db->select($sql);
        $i = 0;
        //新增非空判断
        if(isset($res[0])){
            $product[$i]['pid'] = $res[0]->goods_id;
            $product[$i]['cid'] = $res[0]->attr_id;
            $product[$i]['num'] = 1;
        }
        return $product;
    }

     /**
     * 查询店铺
     * $store_id    商城id
     * $mch_id    店铺id
     * $db  数据库连接
     */
     public static function shop($db,$store_id,$mch_id = 1){
        $shop_list = array();
        $sql0 = "select id,name,logo from lkt_mch where store_id = '$store_id' and id = '$mch_id'";
        $r0 = $db->select($sql0);
        if ($r0) {
            $shop_id = $r0[0]->id;
            $shop_list['shop_id'] = $r0[0]->id;
            $shop_list['shop_name'] = $r0[0]->name;
            $shop_list['shop_logo'] = ServerPath::getimgpath($r0[0]->logo);
            $sql1 = "select id,product_class from lkt_product_list where store_id = '$store_id' and mch_id = '$shop_id' and mch_status = 2 and status = 2 and recycle = 0 and active = 1 order by add_date desc ";
            $r1 = $db->select($sql1);
            
            $shop_list['quantity_on_sale'] = count($r1);

            $quantity_sold = 0;
            $sql3 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid ";
            $r3 = $db->select($sql3);
            if($r3){
                foreach($r3 as $k => $v){
                    $quantity_sold += $v->volume;  // 已售数量
                }
            }
            $shop_list['quantity_sold'] = $quantity_sold;

            $sql0_0 = "select id from lkt_user_collection where store_id = '$store_id' and mch_id = '$shop_id'";
            $r0_0 = $db->select($sql0_0);
            $shop_list['collection_num'] = count($r0_0);
        }   
        return $shop_list;
     }

    //查询默认地址
    public static function find_address($db, $store_id, $user_id, $address_id = '')
    {
        $address = [];
        $sql_a = "select * from lkt_user_address where store_id ='$store_id' and uid='$user_id' and id ='$address_id' ";
        $r_a = $db->select($sql_a);
        if (!empty($r_a)) {
            $address = (array)$r_a['0']; // 收货地址
        } else {
            // 根据用户id、默认地址,查询收货地址信息
            $sql_e = "select * from lkt_user_address where store_id ='$store_id' and uid='$user_id' and is_default = 1";
            $r_e = $db->select($sql_e);
            if (empty($r_e)) {
                // 根据用户id、默认地址,查询收货地址信息
                $sql_q = "select * from lkt_user_address where store_id = '$store_id' and uid='$user_id' ";
                $r_e = $db->select($sql_q);
                if ($r_e) {
                    $aaaid = $r_e[0]->id;
                    $address = (array)$r_e['0']; // 收货地址
                    $sql_u = "update lkt_user_address set is_default = 1 where store_id = '$store_id' and id = '$aaaid'";
                    $db->update($sql_u);
                }
            }
            $address = isset($r_e['0']) ? (array)$r_e['0'] : []; // 收货地址
        }

        return $address;
    }

    public static function get_products_data($db, $store_id, $products, $products_total = 0,$product_type='GM')
    {
        if (empty($products) && $product_type!='KJ') {
            echo json_encode(array('status' => 0, 'err' => '存在库存不足的商品！'));
            exit;
        }
        foreach ($products as $key => $value) {
            $pid = $value['pid'];
            $cid = $value['cid'];
            $num = $value['num'];
            $sql_list = "select m.product_title,m.volume,c.price,c.unit,c.attribute,c.img,c.yprice,m.freight,m.product_class,m.brand_id,m.weight,m.mch_id,m.is_distribution from lkt_product_list AS m LEFT JOIN lkt_configure AS c ON m.id = c.pid  where m.store_id = '$store_id' and c.num > 0 and c.num >= $num and m.status = 2 and m.id = '$pid' and c.id = '$cid'";
            $r_list = $db->select($sql_list);
            if ($r_list) {
                $value = array_merge($value, (array)$r_list[0]);
            } else {

                if ($product_type!='KJ') {
                    echo json_encode(array('status' => 0, 'err' => '存在库存不足的商品！'));
                    exit;
                }else{
                    $sql_list = "select m.product_title,m.volume,c.price,c.unit,c.attribute,c.img,c.yprice,m.freight,m.product_class,m.brand_id,m.weight,m.mch_id,m.is_distribution from lkt_product_list AS m LEFT JOIN lkt_configure AS c ON m.id = c.pid  where m.store_id = '$store_id' and m.status = 2 and m.id = '$pid' and c.id = '$cid'";
                    $r_list = $db->select($sql_list);
                    $value = array_merge($value, (array)$r_list[0]);
                }
            }
            $attribute = unserialize($value['attribute']);
            $product_id[] = $pid;
            $product_class[] = $value['product_class'];
            $size = '';
            foreach ($attribute as $ka => $va) {
                $size .= ' ' . $va;
            }
            $value = self::array_key_remove($value, 'attribute');
            //储存商品数据
            $products_freight[$value['freight']][] = array('pid' => $pid, 'num' => $num, 'freight_id' => $value['freight'], 'weight' => $value['weight']);

            $value['img'] = ServerPath::getimgpath($value['img']);/* 拼接图片链接*/
            $price = $value['price']; // 产品价格
            $value['size'] = $size; // 产品价格
            $products_total += $num * $price; // 产品总价
            $products[$key] = $value;
        }

        if($product_type == 'JP'){
            return array('product_id' => $product_id, 'product_class' => $product_class, 'products_freight' => $products_freight, 'products' => $products, 'products_total' => $products_total);
        }else{
            $products1 = [];
            $products2 = [];
            foreach($products as $key=>$value){
                $products1[$value['mch_id']][] = $value;
            }

            $num_1 = 0;
            foreach ($products1 as $k => $v){
                $product_total = 0;
                foreach ($v as $ke => $va){
                    $product_total += $va['price'] * $va['num'];
                }
                if($k != 0){
                    // 根据商城id、用户id、审核通过，查询店铺ID
                    $sql0 = "select id,name,logo,collection_num from lkt_mch where store_id = '$store_id' and id = '$k' and review_status = 1";
                    $r0 = $db->select($sql0);
                    if($r0) {
                        $products2[$num_1]['shop_id'] = $r0[0]->id; // 店铺id
                        $products2[$num_1]['shop_name'] = $r0[0]->name; // 店铺名称
                        $products2[$num_1]['shop_logo'] = $r0[0]->logo; // 店铺logo
                        $products2[$num_1]['list'] = $v;
                    }else{
                        $products2[$num_1]['shop_id'] = 0; // 店铺id
                        $products2[$num_1]['shop_name'] = ''; // 店铺名称
                        $products2[$num_1]['shop_logo'] = ''; // 店铺logo
                        $products2[$num_1]['list'] = $v;
                    }
                }else{
                    $products2[$num_1]['shop_id'] = 0; // 店铺id
                    $products2[$num_1]['shop_name'] = ''; // 店铺名称
                    $products2[$num_1]['shop_logo'] = ''; // 店铺logo
                    $products2[$num_1]['list'] = $v;
                }
                $products2[$num_1]['product_total'] = $product_total; // 该店铺商品总价

                $num_1 = $num_1 + 1;
            }
            return array('product_id' => $product_id, 'product_class' => $product_class, 'products_freight' => $products_freight, 'products' => $products2, 'products_total' => $products_total);

        }
    }



    public static function get_freight($freight_array, $products, $address, $db, $store_id,$product_type)
    {

//        $freight_array 商品信息
//        $products 商品详细信息
//        $address 用户地址信息
//        $store_id 店铺id
//        $product_type 商品类型
        $yunfei = 0;

        $farray = [];
        foreach ($freight_array as $key_f => $value_f) {
            //查找默认运费模板
            if ($key_f) {
                $sql = "select * from lkt_freight where store_id = '$store_id' and id = '$key_f'";
            } else {
                $sql = "select * from lkt_freight where store_id = '$store_id' and is_default = '1'";
            }
            $r_1 = $db->select($sql);
            if ($r_1) {
                $rule = $r_1[0];
                //类型
                $type = $rule->type;
                //防止空地址报错
                if (empty($address)) {
                    // return 0;
                } else {
                    $num = 0;//数量
                    $g = 0;//重量
                    foreach ($value_f as $k => $v) {
                        $num += $v["num"];
                        $g += $v["weight"];

                        $sheng = $address['sheng'];
                        if (is_numeric($sheng)) {
                            $sql2 = "select G_CName from admin_cg_group where GroupID = '$sheng'";
                            $r_2 = $db->select($sql2);
                            $city = $r_2[0]->G_CName;
                        } else {
                            $city = $sheng;
                        }

                        if (!empty($city)) {
                            $rule_1 = $r_1[0]->freight;
                            $rule_2 = unserialize($rule_1);

                            foreach ($rule_2 as $key => $value) {
                                $str = str_replace("&nbsp;" , "" , $value['name']) ;
                                $citys_str = $str;

                                $citys_str = $citys_str;
                                $citys_array = explode(',', $citys_str);
                                $citys_arrays = [];
                                foreach ($citys_array as $k => $v) {
                                    $citys_arrays[$v] = $v;
                                }
                                if (array_key_exists($city, $citys_arrays)) {
                                    $yfmb = 0;
                                    //根据规则计算方式不同计算运费 类型 0:件 1:重量
                                    if ($type == "0") {
                                        //件方式计算
                                        if($num > intval($value['one'])){ // 当购买数量大于安全值
                                            $num = $num - intval($value['one']);
                                            if($num > intval($value['three'])){ // 当购买数量-安全值 > 非安全值
                                                $yfmb += $value['two'];
                                                $yfmb += ($num - $value['three']) * $value['four'];
                                            }else if($num == intval($value['three'])){
                                                $yfmb += $value['two'];
                                                $yfmb += $value['four'];
                                            }else{
                                                $yfmb += $value['two'];
                                            }
                                        }else{ // 当购买数量不大于安全值
                                            $yfmb += $value['two'];
                                        }
                                    } else {
                                        if ($g > intval($value['one'])) {
                                            $g = $g - intval($value['one']);

                                            if ($g > intval($value['three'])) {
                                                $yfmb += $value['two'];
                                                $yfmb += ceil(($g - $value['one']) / $value['three']) * $value['four'];
                                            }else if($g == intval($value['three'])){
                                                $yfmb += $value['two'];
                                                $yfmb += $value['four'];
                                            } else {
                                                // 当购买数量低于或等于首件数量时
                                                $yfmb += $value['two'];
                                            }
                                        }else{
                                            $yfmb += $value['two'];
                                        }
                                    }
                                    $yunfei += $yfmb;
                                    $farray['freight_id'][$key_f] = number_format($yfmb / $num, 2, ".", "");
                                } else {
                                    $farray['freight_id'][$key_f] = 0;
                                }
                            }
                        }
                    }


                }
            }
        }
        $farray['yunfei'] = $yunfei;
        $freight_ids = isset($farray['freight_id']) ? $farray['freight_id'] : [];
        $farray['freight_ids'] = $freight_ids;
        if($product_type == 'JP'){
            foreach ($products as $kf => $vf) {
                if (array_key_exists($vf['freight'], $freight_ids)) {
                    $products[$kf]['freight_price'] = $freight_ids[$vf['freight']] * $products[$kf]['num'];
                }
            }
        }else{
            if(count($products) == 1){ // 判断是否为1个店铺
                if(count($products[0]['list']) == 1){ // 判断是否是多个商品
                    foreach ($products as $kf => $vf) {
                        foreach ($vf['list'] as $kf1 => $vf1){
                            if (array_key_exists($vf1['freight'], $freight_ids)) {
                                $products[$kf]['list'][$kf1]['freight_price'] = $freight_ids[$vf1['freight']] * $vf1['num'];
                            }else{
                                $products[$kf]['list'][$kf1]['freight_price'] = 0;
                            }
                        }
                    }
                }else{
                    $farray['yunfei'] = 0;
                    foreach ($products as $kf => $vf) {
                        foreach ($vf['list'] as $kf1 => $vf1){
                            $products[$kf]['list'][$kf1]['freight_price'] = 0;
                        }
                    }
                }
            }else{
                $farray['yunfei'] = 0;
                foreach ($products as $kf => $vf) {
                    foreach ($vf['list'] as $kf1 => $vf1){
                        $products[$kf]['list'][$kf1]['freight_price'] = 0;
                    }
                }
            }
        }
        $farray['products'] = $products;
        return $farray;
    }

    /**
     * 解压文件到指定目录
     * @param  string  zip压缩文件的路径
     * @param  string  解压文件的目的路径
     * @param  boolean 是否以压缩文件的名字创建目标文件夹
     * @param  boolean 是否重写已经存在的文件
     * @return boolean 返回成功 或失败
     */
    public static function unzip($src_file, $dest_dir = false, $create_zip_name_dir = false, $overwrite = true)
    {
        if ($zip = zip_open($src_file)) {
            if ($zip) {
                $splitter = ($create_zip_name_dir === true) ? "." : "/";
                if ($dest_dir === false) {
                    $dest_dir = substr($src_file, 0, strrpos($src_file, $splitter)) . "/";
                }
                // 如果不存在 创建目标解压目录
                self::create_dirs($dest_dir);
                // 对每个文件进行解压
                while ($zip_entry = zip_read($zip)) {
                    // 文件不在根目录
                    $pos_last_slash = strrpos(zip_entry_name($zip_entry), "/");
                    if ($pos_last_slash !== false) {
                        // 创建目录 在末尾带 /
                        self::create_dirs($dest_dir . substr(zip_entry_name($zip_entry), 0, $pos_last_slash + 1));
                    }
                    // 打开包
                    if (zip_entry_open($zip, $zip_entry, "r")) {
                        // 文件名保存在磁盘上
                        $file_name = $dest_dir . zip_entry_name($zip_entry);
                        if ($overwrite === true || $overwrite === false && !is_file($file_name)) {
                            // 读取压缩文件的内容
                            $fstream = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                            file_put_contents($file_name, $fstream);
                            // 设置权限
                            chmod($file_name, 0777);
                        }
                        // 关闭入口
                        zip_entry_close($zip_entry);
                    }
                }
                // 关闭压缩包
                zip_close($zip);
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * 创建目录
     */
    public static function create_dirs($path)
    {
        if (!is_dir($path)) {
            $directory_path = "";
            $directories = explode("/", $path);
            array_pop($directories);
            foreach ($directories as $directory) {
                $directory_path .= $directory . "/";
                if (!is_dir($directory_path)) {
                    mkdir($directory_path);
                    chmod($directory_path, 0777);
                }
            }
        }
    }

    /**获取当前地址*/
    public static function  curPageURL()
    {
        $pageURL = 'http';
        $aaa = $_SERVER["REQUEST_URI"];
        $url = substr($aaa, 0, strrpos($aaa, "/"));
        if ($_SERVER["REQUEST_SCHEME"] == "https") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $url;
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"] . $url;
        }
        return $pageURL;
    }

    public static function get_pay_config($db,$type)
    {
        $sql2 = "select config_data from lkt_payment as p left join lkt_payment_config as c on c.pid = p.id where c.status = 1  and p.status = 0 and p.class_name = '$type' ";

        $res2 = $db->select($sql2);
        if($res2){
            return json_decode($res2[0]->config_data);
        }else{
            return false;
        }
    }

    public static function get_order_price($db,$store_id,$id)
    {
        // $db = $this->db;
        // $store_id = $this->store_id;
        //判断单个商品退款是否有使用优惠
        $sql_id = "select a.id,m.freight,a.trade_no,m.num,a.sNo,a.pay,a.z_price,a.user_id,a.spz_price,m.p_price,a.consumer_money,m.express_id from lkt_order as a LEFT JOIN lkt_order_details AS m ON a.sNo = m.r_sNo where a.store_id = '$store_id' and m.id = '$id' ";
        $order_res = $db->select($sql_id);
        $pay = $order_res[0]->pay;
        $num = $order_res[0]->num;
        $p_price = $order_res[0]->p_price * $num;
        $express_id = $order_res[0]->express_id;
        $consumer_money = $order_res[0]->consumer_money;
        $spz_price = $order_res[0]->spz_price;

        //运费
        $freight = $order_res[0]->freight;
        $z_price = $order_res[0]->z_price;

        //判断是否发货
        if ($freight && $express_id) {
            $z_price = $z_price - $freight;
//            $p_price = $p_price - $freight;
//            $spz_price = $spz_price - $freight;
        }

        //计算实际支付金额
        $price = number_format($z_price / $spz_price * $p_price, 2, ".", "");

        if ($price <= 0 && $pay == 'consumer_pay' && $consumer_money > 0) {
            $price = $consumer_money;
        }

        return $price;
    }

    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2019/1/25  14:21
     * @version 1.0
     */
    // 数据字典
    public static function data_dictionary($db,$name,$values){
        $select = '';

        // 根据参数，查询数据字典名称
        $sql0 = "select id from lkt_data_dictionary_name where name = '$name' and status = 1 and recycle = 0";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id;

            $sql1 = "select value,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id'";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    if($values == $v->value){
                        $select .= "<option selected value='$v->value'>$v->text</option>";
                    }else{
                        $select .= "<option value='$v->value'>$v->text</option>";
                    }
                }
            }
        }
        return $select;
    }
    // 验证数据字典名称
    public static function test_data_dictionary_name($db,$id){
        $res = true;

        $sql0 = "select id from lkt_data_dictionary_list where recycle = 0 and sid = '$id'";
        $r0 = $db->select($sql0);
        if($r0){
            $res = false;
        }
        return $res;
    }
    // 验证数据字典
    public static function test_data_dictionary($db,$id,$status){
        $res = array('status'=>true,'msg'=>'');
        $sql0 = "select a.s_name,a.text,b.name from lkt_data_dictionary_list as a left join lkt_data_dictionary_name as b on a.sid = b.id where a.id = '$id'";
        $r0 = $db->select($sql0);
        if($r0){
            if($r0[0]->name == '商品分类'){
                $newstr = substr($r0[0]->text,0,strlen($r0[0]->text)-3);  //这是去掉字符串中的最后一个汉字
                $level = Tools::Chinese_to_Number_Conversion($newstr); // 中文转数字
                if($status || $status == '0'){
                    if($status == 0){ // 目前不生效，改为生效
                        if($level >= 2){
                            $level1 = $level -2;
                            // 查询目前级别上一级是否正在使用
                            $sql1 = "select cid from lkt_product_class where recycle = 0 and level = '$level'";
                            $r1 = $db->select($sql1);
                            if(empty($r1)){ // 没有
                                $res = array('status'=>false,'msg'=>'该级别上级未生效,不能生效！');
                            }
                        }
                    }else{ //  目前生效，改为不生效
                        $level1 = $level -1;
                        // 查询目前级别是否正在使用
                        $sql1 = "select cid from lkt_product_class where recycle = 0 and level = '$level1'";
                        $r1 = $db->select($sql1);
                        if($r1){
                            $res = array('status'=>false,'msg'=>'该级别正在使用,不能失效！');
                        }
                    }
                }else{
                    $level1 = $level -1;
                    // 查询目前级别是否正在使用
                    $sql1 = "select cid from lkt_product_class where recycle = 0 and level = '$level1'";
                    $r1 = $db->select($sql1);
                    if($r1){
                        $res = array('status'=>false,'msg'=>'该级别正在使用,不能删除！');
                    }
                }
            }else if($r0[0]->name == '属性名'){
                $sql1 = "select attribute from lkt_configure where recycle = 0 ";
                $r1 = $db->select($sql1);
                if($r1){
                    foreach ($r1 as $k => $v){
                        $arrar_t = unserialize($v->attribute);
                        foreach ($arrar_t as $k1 => $v1){
                            if($r0[0]->text == $k1){
                                $res = array('status'=>false,'msg'=>'该属性名正在使用');
                                break 2;
                            }
                        }
                    }
                    if($status || $status == '0'){
                        if($status == 1){ //  目前生效，改为不生效
                            $res['msg'] =  $res['msg'] . ',不能失效！';
                        }
                    }else{
                        $res['msg'] =  $res['msg'] . ',不能删除！';
                    }
                }
            }else if($r0[0]->name == '属性值'){
                $s_name = $r0[0]->s_name;
                $sql1 = "select id,attribute from lkt_configure where recycle = 0 ";
                $r1 = $db->select($sql1);
                if($r1){
                    foreach ($r1 as $k => $v){
                        if($v->attribute != ''){
                            $arrar_t = unserialize($v->attribute);
                            if($arrar_t != array()){
                                foreach ($arrar_t as $k1 => $v1){
                                    if($s_name == $k1 && $r0[0]->text == $v1){
                                        $res = array('status'=>false,'msg'=>'该属性值正在使用');
                                        break 2;
                                    }
                                }
                            }
                        }
                    }
                    if($status || $status == '0'){
                        if($status == 1){ //  目前生效，改为不生效
                            $res['msg'] =  $res['msg'] . ',不能失效！';
                        }
                    }else{
                        $res['msg'] =  $res['msg'] . ',不能删除！';
                    }
                }
            }
        }
        return $res;
    }
    // 中文转数字
    public static function Chinese_to_Number_Conversion($string)
    {
        if(is_numeric($string)){
            return $string;
        }
        $string = str_replace('仟', '千', $string);
        $string = str_replace('佰', '百', $string);
        $string = str_replace('拾', '十', $string);
        $num = 0;
        $wan = explode('万', $string);
        if (count($wan) > 1) {
            $num += cn2num($wan[0]) * 10000;
            $string = $wan[1];
        }
        $qian = explode('千', $string);
        if (count($qian) > 1) {
            $num += cn2num($qian[0]) * 1000;
            $string = $qian[1];
        }
        $bai = explode('百', $string);
        if (count($bai) > 1) {
            $num += cn2num($bai[0]) * 100;
            $string = $bai[1];
        }
        $shi = explode('十', $string);
        if (count($shi) > 1) {
            $num += cn2num($shi[0] ? $shi[0] : '一') * 10;
            $string = $shi[1] ? $shi[1] : '零';
        }
        $ling = explode('零', $string);
        if (count($ling) > 1) {
            $string = $ling[1];
        }
        $d = array(
            '一' => '1','二' => '2','三' => '3','四' => '4','五' => '5','六' => '6','七' => '7','八' => '8','九' => '9',
            '壹' => '1','贰' => '2','叁' => '3','肆' => '4','伍' => '5','陆' => '6','柒' => '7','捌' => '8','玖' => '9',
            '零' => 0, '0' => 0, 'O' => 0, 'o' => 0,
            '两' => 2
        );
        return $num + @$d[$string];
    }
    // 商品 $status是否可以编辑
    public static function s_type($db,$name,$values=array(),$status=true){
        $arr = array();
        $sql0 = "select id from lkt_data_dictionary_name where name = '$name' and status = 1 and recycle = 0";

        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id;

            $sql1 = "select value,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id'";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    $arr[$v->value] = $v->text;
                }
            }
        }

        $res = '';
        $c = $status?'':'disabled';
        if($name == '商品类型'){
            foreach ($arr as $k => $v) {
                if(in_array($k,$values)){
                    $res .= "<div class='ra1'><input name='s_type[]' type='checkbox' id='sex-$k' class='inputC' value='$k' checked='checked' $c> <label for='sex-$k'>$v</label></div>";
                }else{
                    $res .= "<div class='ra1'><input name='s_type[]' type='checkbox' id='sex-$k' class='inputC' value='$k' $c> <label for='sex-$k'>$v</label> </div>";
                }
            }
        }else if($name == '单位'){
            if(count($values) == 0){
                foreach ($arr as $k => $v) {
                    $res .= "<option value='$k'>
                                $v
                            </option>";
                }
            }else{
                foreach ($arr as $k => $v) {
                    if($values['unit'] == $k){
                        $res .= "<option value='$k' selected='selected'>
                            $v
                        </option>";
                    }else{
                        $res .= "<option value='$k'>
                            $v
                        </option>";
                    }
                }
            }
        }else if($name == '商品展示位置'){
            foreach ($arr as $k => $v) {
                if(in_array($k,$values)){
                    $checked = "checked='checked'";
                }else{
                    $checked = "";
                }
                $res .= "<div class='ra1'>
                            <input name='show_adr[]' type='checkbox' id='show_adr-$k' class='inputC' value='$k' $checked > 
                            <label for='show_adr-$k' style='width: 80px!important;'>$v</label> 
                        </div>";
            }
        }
        return $res;
    }
    // 获取属性名
    public static function attribute($db,$name,$values=array()){
        $arr = array();
        // 根据参数，查询数据字典名称
        $sql0 = "select id from lkt_data_dictionary_name where name = '$name' and status = 1 and recycle = 0";
        $r0 = $db->select($sql0);
        if($r0) {
            $id = $r0[0]->id;

            $sql1 = "select id,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id'";
            $r1 = $db->select($sql1);
            if($r1){
                if(count($values) != 0){
                    foreach ($r1 as $k => $v){
                        if(in_array($v->text,$values)){
                            $arr[] = array('id'=>$v->id,'text'=>$v->text,'status'=>true);
                        }else{
                            $arr[] = array('id'=>$v->id,'text'=>$v->text,'status'=>false);
                        }
                    }
                }else{
                    foreach ($r1 as $k => $v){
                        $arr[] = array('id'=>$v->id,'text'=>$v->text,'status'=>false);
                    }
                }
            }
        }

        return $arr;
    }
    // 获取属性值
    public static function attribute_name($db,$name,$attribute_name,$values=array()){
        $arr = array();
        $arr1 = array();

        // 根据参数，查询数据字典名称
        $sql0 = "select id from lkt_data_dictionary_name where name = '$name' and status = 1 and recycle = 0";
        $r0 = $db->select($sql0);
        if($r0) {
            $id = $r0[0]->id;

            $sql1 = "select id,s_name,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id'";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    if($attribute_name == $v->s_name){
                        $arr1[] = $v->text;
                    }
                }
            }
        }
        if(count($values) != 0){
            foreach ($arr1 as $k => $v){
                if(in_array($v,$values)){
                    $arr[] = array('value'=>$v,'status'=>true);
                }else{
                    $arr[] = array('value'=>$v,'status'=>false);
                }
            }
        }else{
            foreach ($arr1 as $k => $v){
                $arr[] = array('value'=>$v,'status'=>false);
            }
        }

        return $arr;
    }
    // 头部导航数据字典-
    public static function header_data_dictionary($db,$name,$values){
        $select = '';

        // 根据参数，查询数据字典名称
        $sql0 = "select id from lkt_data_dictionary_name where name = '$name' and status = 1 and recycle = 0";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id;

            $sql1 = "select value,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id'";
            $r1 = $db->select($sql1);
            if($r1){

                foreach ($r1 as $k => $v){
                    if($values == $v->value){
                        $select = $v->text;
                    }
                }
            }
        }
        return $select;
    }
    // 菜单树结构
    public static function menu($db,$list){
        // 查询菜单表(模块名称、模块标识、模块描述)
        $sql = "select * from lkt_core_menu where s_id = 0 and is_core = 0 and is_plug_in = 0 and recycle = 0 order by type,sort,id";
        $r = $db->select($sql);
        if ($r) {
            foreach ($r as $k => $v) {
                $r[$k]->spread = false; // 定义没选中
                $r[$k]->checked = false; // 定义没选中
                $r[$k]->field = '';
                $id_1 = $v->id;

                $sql = "select * from lkt_core_menu where s_id = '$id_1' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                $r_1 = $db->select($sql);
                if($r_1){
                    $r[$k]->spread = true; // 选中

                    foreach ($r_1 as $ke => $va){
                        $r_1[$ke]->spread = false; // 定义没选中
                        $r_1[$ke]->checked = false; // 定义没选中
                        $r_1[$ke]->field = '';
                        $id_2 = $va->id;

                        $sql = "select * from lkt_core_menu where s_id = '$id_2' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                        $r_2 = $db->select($sql);
                        if($r_2){
                            $r_1[$ke]->spread = true; // 选中
                            foreach ($r_2 as $key => $val){
                                $r_2[$key]->spread = false; // 定义没选中
                                $r_2[$key]->checked = false; // 定义没选中
                                $r_2[$key]->field = '';
                                $id_3 = $val->id;

                                $sql = "select * from lkt_core_menu where s_id = '$id_3' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                                $r_3 = $db->select($sql);
                                if($r_3){
                                    $r_2[$key]->spread = true; // 选中
                                    foreach ($r_3 as $key1 => $val1){
                                        $r_3[$key1]->spread = false; // 定义没选中
                                        $r_3[$key1]->checked = false; // 定义没选中
                                        $r_3[$key1]->field = '';
                                        $id_4 = $val1->id;
                                        if($list){
                                            foreach ($list as $k4 => $v4){
                                                if($id_4 == $v4->menu_id){
                                                    $r_3[$key1]->checked = true; // 选中
                                                }
                                            }
                                        }
                                    }
                                    $val->children = $r_3;
                                }else{
                                    if ($list != '') {
                                        foreach ($list as $k3 => $v3) {
                                            if($id_3 == $v3->menu_id){
                                                $r_2[$key]->checked = true; // 选中
                                            }
                                        }
                                    }
                                }
                            }
                            $va->children = $r_2;
                        }else{
                            if ($list != '') {
                                foreach ($list as $k2 => $v2) {
                                    if($id_2 == $v2->menu_id){
                                        $r_1[$ke]->checked = true; // 选中
                                    }
                                }
                            }
                        }
                    }
                    $v->children = $r_1;
                }else{
                    if ($list != '') {
                        foreach ($list as $k1 => $v1) {
                            if ($id_1 == $v1->menu_id) {
                                $r[$k]->checked = true; // 选中
                            }
                        }
                    }
                }
            }
        }
        return $r;
    }
    // 菜单树结构-查看
    public static function menu1($db,$list){
        $res = array();

        // 查询菜单表(模块名称、模块标识、模块描述)
        $sql = "select id,title,type from lkt_core_menu where s_id = 0 and is_core = 0 and is_plug_in = 0 and recycle = 0 order by type,sort,id";
        $r = $db->select($sql);
        if ($r) {
            foreach ($r as $k => $v) {
                $r[$k]->spread = false; // 定义没选中
                $r[$k]->checked = false; // 定义没选中
                $r[$k]->disabled = 'disabled';
                $r[$k]->field = '';
                $id_0 = $v->id;
                if ($list != '') {
                    foreach ($list as $k_0 => $v_0) {


                        if ($id_0 == $v_0->menu_id) {

                            $r[$k]->checked = true; // 选中
                            $res[$k] = $r[$k];
                        }
                    }
                }
                $sql1 = "select id,title,type from lkt_core_menu where s_id = '$id_0' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                $r_1 = $db->select($sql1);
                if($r_1){
                    foreach ($r_1 as $k1 => $v1) {
                        $r_1[$k1]->spread = false; // 定义没选中
                        $r_1[$k1]->checked = false; // 定义没选中
                        $r_1[$k1]->disabled = 'disabled';
                        $r_1[$k1]->field = '';
                        $id_1 = $v1->id;
                        $res1 = array();
                        if ($list != '') {
                            foreach ($list as $k1_1 => $v1_1) {
                                if ($id_1 == $v1_1->menu_id) {
                                    $r_1[$k1]->checked = true; // 选中
                                    $res1[$k1] = $r_1[$k1];
                                }
                            }
                        }
                        $sql2 = "select id,title,type from lkt_core_menu where s_id = '$id_1' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                        $r_2 = $db->select($sql2);
                        if($r_2){
                            foreach ($r_2 as $k2 => $v2) {
                                $r_2[$k2]->spread = false; // 定义没选中
                                $r_2[$k2]->checked = false; // 定义没选中
                                $r_2[$k2]->disabled = 'disabled';
                                $r_2[$k2]->field = '';
                                $id_2 = $v2->id;
                                $res2 = array();
                                if ($list != '') {
                                    foreach ($list as $k2_2 => $v2_2) {
                                        if ($id_2 == $v2_2->menu_id) {
                                            $r_2[$k2]->checked = true; // 选中
                                            $res2[$k2] = $r_2[$k2];
                                        }
                                    }
                                }
                                $sql3 = "select id,title,type from lkt_core_menu where s_id = '$id_2' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                                $r_3 = $db->select($sql3);
                                if($r_3){
                                    foreach ($r_3 as $k3 => $v3) {
                                        $r_3[$k3]->spread = false; // 定义没选中
                                        $r_3[$k3]->checked = false; // 定义没选中
                                        $r_3[$k3]->disabled = 'disabled';
                                        $r_3[$k3]->field = '';
                                        $id_3 = $v3->id;
                                        $res3 = array();
                                        if ($list != '') {
                                            foreach ($list as $k3_3 => $v3_3) {
                                                if ($id_3 == $v3_3->menu_id) {
                                                    $r_3[$k3]->checked = true; // 选中
                                                    $res3[$k3] = $r_3[$k3];
                                                }
                                            }
                                        }
                                        $sql4 = "select id,title,type from lkt_core_menu where s_id = '$id_3' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                                        $r_4 = $db->select($sql4);
                                        if($r_4){
                                            foreach ($r_4 as $k4 => $v4) {
                                                $r_4[$k4]->spread = false; // 定义没选中
                                                $r_4[$k4]->checked = false; // 定义没选中
                                                $r_4[$k4]->disabled = 'disabled';
                                                $r_4[$k4]->field = '';
                                                $id_4 = $v4->id;
                                                $res4 = array();
                                                if ($list != '') {
                                                    foreach ($list as $k4_4 => $v4_4) {
                                                        if ($id_4 == $v4_4->menu_id) {
                                                            $r_4[$k4]->checked = true; // 选中
                                                            $res4[$k4] = $r_4[$k4];
                                                        }
                                                    }
                                                }
                                                if($res4 != array()){
                                                    $res3[$k3]->children[] = $res4[$k4];
                                                }
                                            }
                                        }
                                        if($res3 != array()){
                                            $res2[$k2]->children[] = $res3[$k3];
                                        }
                                    }
                                }
                                if($res2 != array()){
                                    $res1[$k1]->children[] = $res2[$k2];
                                }
                            }
                        }
                        if($res1 != array()){
                            $res[$k]->children[] = $res1[$k1];
                        }
                    }
                }
            }
        }
        return $res;
    }
    // 菜单树结构
    public static function menu_1($db,$list,$menu_id){
        $res = array();
        // 查询菜单表(模块名称、模块标识、模块描述)
        $sql = "select * from lkt_core_menu where s_id = 0 and is_core = 0 and is_plug_in = 0 and recycle = 0 order by type,sort,id";
        $r = $db->select($sql);
        if ($r) {
            foreach ($r as $k => $v) {
                $r[$k]->spread = false; // 定义没选中
                $r[$k]->checked = false; // 定义没选中
                $r[$k]->field = '';
                $id_1 = $v->id;
                if(in_array($id_1,$menu_id)){

                    $sql = "select * from lkt_core_menu where s_id = '$id_1' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                    $r_1 = $db->select($sql);
                    if($r_1){
                        $r[$k]->spread = true; // 选中

                        foreach ($r_1 as $ke => $va){
                            $r_1[$ke]->spread = false; // 定义没选中
                            $r_1[$ke]->checked = false; // 定义没选中
                            $r_1[$ke]->field = '';
                            $id_2 = $va->id;
                            if(in_array($id_2,$menu_id)){
                                $sql = "select * from lkt_core_menu where s_id = '$id_2' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                                $r_2 = $db->select($sql);
                                if($r_2){
                                    $r_1[$ke]->spread = true; // 选中
                                    foreach ($r_2 as $key => $val){
                                        $r_2[$key]->spread = false; // 定义没选中
                                        $r_2[$key]->checked = false; // 定义没选中
                                        $r_2[$key]->field = '';
                                        $id_3 = $val->id;
                                        if(in_array($id_3,$menu_id)){
                                            $sql = "select * from lkt_core_menu where s_id = '$id_3' and is_core = 0 and is_plug_in = 0 and recycle = 0 order by sort,id";
                                            $r_3 = $db->select($sql);
                                            if($r_3){
                                                $r_2[$key]->spread = true; // 选中
                                                foreach ($r_3 as $key1 => $val1){
                                                    $r_3[$key1]->spread = false; // 定义没选中
                                                    $r_3[$key1]->checked = false; // 定义没选中
                                                    $r_3[$key1]->field = '';
                                                    $id_4 = $val1->id;
                                                    if(in_array($id_4,$menu_id)){
                                                        if($list){
                                                            foreach ($list as $k4 => $v4){
                                                                if($id_4 == $v4->menu_id){
                                                                    $r_3[$key1]->checked = true; // 选中
                                                                }
                                                            }
                                                        }
                                                        $val->children[] = $val1;
                                                    }
                                                }
                                            }else{
                                                if ($list != '') {
                                                    foreach ($list as $k3 => $v3) {
                                                        if($id_3 == $v3->menu_id){
                                                            $r_2[$key]->checked = true; // 选中
                                                        }
                                                    }
                                                }
                                            }
                                            $va->children[] = $val;
                                        }
                                    }
                                }else{
                                    if ($list != '') {
                                        foreach ($list as $k2 => $v2) {
                                            if($id_2 == $v2->menu_id){
                                                $r_1[$ke]->checked = true; // 选中
                                            }
                                        }
                                    }
                                }
                                $v->children[] = $va;
                            }
                        }
                    }else{
                        if ($list != '') {
                            foreach ($list as $k1 => $v1) {
                                if ($id_1 == $v1->menu_id) {
                                    $r[$k]->checked = true; // 选中
                                }
                            }
                        }
                    }
                    $res[] = $r[$k];
                }
            }
        }
        return $res;
    }
    // 获取菜单ID
    public static function get_permissions($checkedData,$list){
        foreach ($checkedData as $k => $v){
            if(isset($v['children'])){ // 检测变量是否存在
                foreach ($v['children'] as $ke => $va){
                    $list[] = $va['id'];
                    if(isset($va['children'])){ // 检测变量是否存在
                        $list = Tools::get_permissions($v['children'],$list);
                    }
                }
            }
        }
        return $list;
    }

    public static function menu_name($db,$id){
        $rew = '';
        $sql0 = "select b.title from lkt_role_menu as a left join lkt_core_menu as b on a.menu_id = b.id where a.role_id = '$id' and b.recycle = 0 and b.s_id = 0";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $rew .= $v->title . ',';
            }
        }
        return $rew;
    }
    // 生怕分类递归找上级
    public function str_option($cid,$res = ''){
        $db = DBAction::getInstance();
        $store_id = $this->store_id;
        $sql2 = "select sid,cid from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid'";
        $r2 = $db->select($sql2);
        if($r2){
            $sid = $r2[0]->sid; // 上级ID
            $res = $r2[0]->cid . '-' . $res;
            if($sid == 0){
                $res = '-' . $res;
            }else{
                $res = $this->str_option($r2[0]->sid,$res);
            }
        }
        return $res;
    }

    /**
     * 拼音字符转换图
     * @var array
     */
    private static $_aMaps = array(
        'a'=>-20319,'ai'=>-20317,'an'=>-20304,'ang'=>-20295,'ao'=>-20292,
        'ba'=>-20283,'bai'=>-20265,'ban'=>-20257,'bang'=>-20242,'bao'=>-20230,'bei'=>-20051,'ben'=>-20036,'beng'=>-20032,'bi'=>-20026,'bian'=>-20002,'biao'=>-19990,'bie'=>-19986,'bin'=>-19982,'bing'=>-19976,'bo'=>-19805,'bu'=>-19784,
        'ca'=>-19775,'cai'=>-19774,'can'=>-19763,'cang'=>-19756,'cao'=>-19751,'ce'=>-19746,'ceng'=>-19741,'cha'=>-19739,'chai'=>-19728,'chan'=>-19725,'chang'=>-19715,'chao'=>-19540,'che'=>-19531,'chen'=>-19525,'cheng'=>-19515,'chi'=>-19500,'chong'=>-19484,'chou'=>-19479,'chu'=>-19467,'chuai'=>-19289,'chuan'=>-19288,'chuang'=>-19281,'chui'=>-19275,'chun'=>-19270,'chuo'=>-19263,'ci'=>-19261,'cong'=>-19249,'cou'=>-19243,'cu'=>-19242,'cuan'=>-19238,'cui'=>-19235,'cun'=>-19227,'cuo'=>-19224,
        'da'=>-19218,'dai'=>-19212,'dan'=>-19038,'dang'=>-19023,'dao'=>-19018,'de'=>-19006,'deng'=>-19003,'di'=>-18996,'dian'=>-18977,'diao'=>-18961,'die'=>-18952,'ding'=>-18783,'diu'=>-18774,'dong'=>-18773,'dou'=>-18763,'du'=>-18756,'duan'=>-18741,'dui'=>-18735,'dun'=>-18731,'duo'=>-18722,
        'e'=>-18710,'en'=>-18697,'er'=>-18696,
        'fa'=>-18526,'fan'=>-18518,'fang'=>-18501,'fei'=>-18490,'fen'=>-18478,'feng'=>-18463,'fo'=>-18448,'fou'=>-18447,'fu'=>-18446,
        'ga'=>-18239,'gai'=>-18237,'gan'=>-18231,'gang'=>-18220,'gao'=>-18211,'ge'=>-18201,'gei'=>-18184,'gen'=>-18183,'geng'=>-18181,'gong'=>-18012,'gou'=>-17997,'gu'=>-17988,'gua'=>-17970,'guai'=>-17964,'guan'=>-17961,'guang'=>-17950,'gui'=>-17947,'gun'=>-17931,'guo'=>-17928,
        'ha'=>-17922,'hai'=>-17759,'han'=>-17752,'hang'=>-17733,'hao'=>-17730,'he'=>-17721,'hei'=>-17703,'hen'=>-17701,'heng'=>-17697,'hong'=>-17692,'hou'=>-17683,'hu'=>-17676,'hua'=>-17496,'huai'=>-17487,'huan'=>-17482,'huang'=>-17468,'hui'=>-17454,'hun'=>-17433,'huo'=>-17427,
        'ji'=>-17417,'jia'=>-17202,'jian'=>-17185,'jiang'=>-16983,'jiao'=>-16970,'jie'=>-16942,'jin'=>-16915,'jing'=>-16733,'jiong'=>-16708,'jiu'=>-16706,'ju'=>-16689,'juan'=>-16664,'jue'=>-16657,'jun'=>-16647,
        'ka'=>-16474,'kai'=>-16470,'kan'=>-16465,'kang'=>-16459,'kao'=>-16452,'ke'=>-16448,'ken'=>-16433,'keng'=>-16429,'kong'=>-16427,'kou'=>-16423,'ku'=>-16419,'kua'=>-16412,'kuai'=>-16407,'kuan'=>-16403,'kuang'=>-16401,'kui'=>-16393,'kun'=>-16220,'kuo'=>-16216,
        'la'=>-16212,'lai'=>-16205,'lan'=>-16202,'lang'=>-16187,'lao'=>-16180,'le'=>-16171,'lei'=>-16169,'leng'=>-16158,'li'=>-16155,'lia'=>-15959,'lian'=>-15958,'liang'=>-15944,'liao'=>-15933,'lie'=>-15920,'lin'=>-15915,'ling'=>-15903,'liu'=>-15889,'long'=>-15878,'lou'=>-15707,'lu'=>-15701,'lv'=>-15681,'luan'=>-15667,'lue'=>-15661,'lun'=>-15659,'luo'=>-15652,
        'ma'=>-15640,'mai'=>-15631,'man'=>-15625,'mang'=>-15454,'mao'=>-15448,'me'=>-15436,'mei'=>-15435,'men'=>-15419,'meng'=>-15416,'mi'=>-15408,'mian'=>-15394,'miao'=>-15385,'mie'=>-15377,'min'=>-15375,'ming'=>-15369,'miu'=>-15363,'mo'=>-15362,'mou'=>-15183,'mu'=>-15180,
        'na'=>-15165,'nai'=>-15158,'nan'=>-15153,'nang'=>-15150,'nao'=>-15149,'ne'=>-15144,'nei'=>-15143,'nen'=>-15141,'neng'=>-15140,'ni'=>-15139,'nian'=>-15128,'niang'=>-15121,'niao'=>-15119,'nie'=>-15117,'nin'=>-15110,'ning'=>-15109,'niu'=>-14941,'nong'=>-14937,'nu'=>-14933,'nv'=>-14930,'nuan'=>-14929,'nue'=>-14928,'nuo'=>-14926,
        'o'=>-14922,'ou'=>-14921,
        'pa'=>-14914,'pai'=>-14908,'pan'=>-14902,'pang'=>-14894,'pao'=>-14889,'pei'=>-14882,'pen'=>-14873,'peng'=>-14871,'pi'=>-14857,'pian'=>-14678,'piao'=>-14674,'pie'=>-14670,'pin'=>-14668,'ping'=>-14663,'po'=>-14654,'pu'=>-14645,
        'qi'=>-14630,'qia'=>-14594,'qian'=>-14429,'qiang'=>-14407,'qiao'=>-14399,'qie'=>-14384,'qin'=>-14379,'qing'=>-14368,'qiong'=>-14355,'qiu'=>-14353,'qu'=>-14345,'quan'=>-14170,'que'=>-14159,'qun'=>-14151,
        'ran'=>-14149,'rang'=>-14145,'rao'=>-14140,'re'=>-14137,'ren'=>-14135,'reng'=>-14125,'ri'=>-14123,'rong'=>-14122,'rou'=>-14112,'ru'=>-14109,'ruan'=>-14099,'rui'=>-14097,'run'=>-14094,'ruo'=>-14092,
        'sa'=>-14090,'sai'=>-14087,'san'=>-14083,'sang'=>-13917,'sao'=>-13914,'se'=>-13910,'sen'=>-13907,'seng'=>-13906,'sha'=>-13905,'shai'=>-13896,'shan'=>-13894,'shang'=>-13878,'shao'=>-13870,'she'=>-13859,'shen'=>-13847,'sheng'=>-13831,'shi'=>-13658,'shou'=>-13611,'shu'=>-13601,'shua'=>-13406,'shuai'=>-13404,'shuan'=>-13400,'shuang'=>-13398,'shui'=>-13395,'shun'=>-13391,'shuo'=>-13387,'si'=>-13383,'song'=>-13367,'sou'=>-13359,'su'=>-13356,'suan'=>-13343,'sui'=>-13340,'sun'=>-13329,'suo'=>-13326,
        'ta'=>-13318,'tai'=>-13147,'tan'=>-13138,'tang'=>-13120,'tao'=>-13107,'te'=>-13096,'teng'=>-13095,'ti'=>-13091,'tian'=>-13076,'tiao'=>-13068,'tie'=>-13063,'ting'=>-13060,'tong'=>-12888,'tou'=>-12875,'tu'=>-12871,'tuan'=>-12860,'tui'=>-12858,'tun'=>-12852,'tuo'=>-12849,
        'wa'=>-12838,'wai'=>-12831,'wan'=>-12829,'wang'=>-12812,'wei'=>-12802,'wen'=>-12607,'weng'=>-12597,'wo'=>-12594,'wu'=>-12585,
        'xi'=>-12556,'xia'=>-12359,'xian'=>-12346,'xiang'=>-12320,'xiao'=>-12300,'xie'=>-12120,'xin'=>-12099,'xing'=>-12089,'xiong'=>-12074,'xiu'=>-12067,'xu'=>-12058,'xuan'=>-12039,'xue'=>-11867,'xun'=>-11861,
        'ya'=>-11847,'yan'=>-11831,'yang'=>-11798,'yao'=>-11781,'ye'=>-11604,'yi'=>-11589,'yin'=>-11536,'ying'=>-11358,'yo'=>-11340,'yong'=>-11339,'you'=>-11324,'yu'=>-11303,'yuan'=>-11097,'yue'=>-11077,'yun'=>-11067,
        'za'=>-11055,'zai'=>-11052,'zan'=>-11045,'zang'=>-11041,'zao'=>-11038,'ze'=>-11024,'zei'=>-11020,'zen'=>-11019,'zeng'=>-11018,'zha'=>-11014,'zhai'=>-10838,'zhan'=>-10832,'zhang'=>-10815,'zhao'=>-10800,'zhe'=>-10790,'zhen'=>-10780,'zheng'=>-10764,'zhi'=>-10587,'zhong'=>-10544,'zhou'=>-10533,'zhu'=>-10519,'zhua'=>-10331,'zhuai'=>-10329,'zhuan'=>-10328,'zhuang'=>-10322,'zhui'=>-10315,'zhun'=>-10309,'zhuo'=>-10307,'zi'=>-10296,'zong'=>-10281,'zou'=>-10274,'zu'=>-10270,'zuan'=>-10262,'zui'=>-10260,'zun'=>-10256,'zuo'=>-10254
    );

    /**
     * 将中文编码成拼音
     * @param string $utf8Data utf8字符集数据
     * @param string $sRetFormat 返回格式 [head:首字母|all:全拼音]
     * @return string
     */
    public static function encode($utf8Data, $sRetFormat='head'){
        $sGBK = iconv('UTF-8', 'GBK', $utf8Data);
        $aBuf = array();
        for ($i=0, $iLoop=strlen($sGBK); $i<$iLoop; $i++) {
            $iChr = ord($sGBK{$i});
            if ($iChr>160)
                $iChr = ($iChr<<8) + ord($sGBK{++$i}) - 65536;
            if ('head' === $sRetFormat)
                $aBuf[] = substr(self::zh2py($iChr),0,1);
            else
                $aBuf[] = self::zh2py($iChr);
        }
        if ('head' === $sRetFormat)
            return implode('', $aBuf);
        else
            return implode(' ', $aBuf);
    }

    /**
     * 中文转换到拼音(每次处理一个字符)
     * @param number $iWORD 待处理字符双字节
     * @return string 拼音
     */
    private static function zh2py($iWORD) {
        if($iWORD>0 && $iWORD<160 ) {
            return chr($iWORD);
        } elseif ($iWORD<-20319||$iWORD>-10247) {
            return '';
        } else {
            foreach (self::$_aMaps as $py => $code) {
                if($code > $iWORD) break;
                $result = $py;
            }
            return $result;
        }
    }

    // 生成订单号
    public static function order_number($type)
    {
        if($type == ''){
            $type = 'GM';
        }
        return $type.date("ymdhis").rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
    }
    // 生成session
    public function generate_session($db,$cache,$type){

        $sql = "delete from lkt_session_id where date_add(add_date, interval 5 minute) < now() ";
        $db->delete($sql);
        if($type == 1){
            $variable = 'p_id';
        }else if($type == 2){
            $variable = 'order_details_id';
        }else if($type == 3){
            $variable = 'comment_id';
        }
        $image_arr = array();
        $image_arr1 = array();
        $rew = 0; // 用来判断，是否有短信数据。0代表没有，1代表有
        $sql1 = "select * from lkt_session_id where type = '$type'";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $content1 = json_decode($v->content);
                if(!empty($content1->user_id)){
                    if($cache['user_id'] == $content1->user_id && $cache[$variable] == $content1->$variable){ // 存在
                        $id = $v->id;
                        $image_arr1 = $content1->image_arr;
                        $rew = 1;
                        break;
                    }
                }
            }
        }
        if($rew == 0){ // 不存在
            $content1 = json_encode($cache);
            $sql1 = "insert into lkt_session_id(content,add_date,type) values ('$content1',CURRENT_TIMESTAMP,'$type')";
            $r = $db->insert($sql1);
            if($r > 0){
                $res = 1;
            }else{
                $res = 0;
            }
        }else{
            if(count($image_arr1) != 0 && count($image_arr1) != 1){
                foreach ($image_arr1 as $k => $v){
                    $image_arr[] = (array)$v;
                }
                array_push($image_arr,$cache['image_arr']);
            }else{
                $image_arr[] = (array)$image_arr1;
                $image_arr[] = $cache['image_arr'];
            }

            $content2 = array('user_id'=>$cache['user_id'],$variable=>$cache[$variable],'image_arr'=>$image_arr);
            $content = json_encode($content2); // 数组转json字符串
            $sql = "update lkt_session_id set content = '$content' where id = '$id' and type = '$type'";
            $r = $db->update($sql);
            if($r != -1){
                $res = 1;
            }else{
                $res = 0;
            }
        }
        return $res;
    }
    // 获得session
    public function obtain_session($db,$user_id,$type,$p_id){

        $sql = "delete from lkt_session_id where date_add(add_date, interval 5 minute) < now() ";
        $db->delete($sql);

        if($type == 1){
            $variable = 'p_id';
        }else if($type == 2){
            $variable = 'order_details_id';
        }else if($type == 3){
            $variable = 'comment_id';
        }

        $cache = '';
        $sql1 = "select * from lkt_session_id where type = '$type'";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $content1 = json_decode($v->content);
                if(!empty($content1->user_id)){
                    if($user_id == $content1->user_id && $p_id == $content1->$variable){ // 存在
                        $cache = json_encode($content1->image_arr); // 数组转json字符串
                        break;
                    }
                }
            }
        }
        return $cache;
    }
    // 删除session
    public function del_session($db,$user_id,$type,$p_id){

        if($type == 1){
            $variable = 'p_id';
        }else if($type == 2){
            $variable = 'order_details_id';
        }else if($type == 3){
            $variable = 'comment_id';
        }

        $sql = "delete from lkt_session_id where date_add(add_date, interval 5 minute) < now() ";
        $db->delete($sql);
        $sql1 = "select * from lkt_session_id where type = '$type'";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $content1 = json_decode($v->content);
                if(!empty($content1->user_id)) {
                    if($user_id == $content1->user_id && $p_id == $content1->$variable){ // 存在
                        $sql = "delete from lkt_session_id where id = '$v->id' and type = '$type'";
                        $db->delete($sql);
                    }
                }
            }
        }
        return;
    }
    // 获取短信类别
    public static function get_message_data_dictionary($db,$name,$type,$values){
        $list = array();
        $text = '';

        $sql0_0 = "select id from lkt_data_dictionary_name where name = '短信模板类型' and status = 1 and recycle = 0";
        $r0_0 = $db->select($sql0_0);
        if($r0_0) {
            $id0_0 = $r0_0[0]->id;
            $sql0_1 = "select value,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id0_0' and value = '$type'";
            $r0_1 = $db->select($sql0_1);
            if($r0_1){
                $text = $r0_1[0]->text;
            }
        }
        // 根据参数，查询数据字典名称
        $sql0 = "select id from lkt_data_dictionary_name where name = '$name' and status = 1 and recycle = 0";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id;

            $sql1 = "select value,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id' and s_name = '$text'";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    if($values == $v->value){
                        $v->status = true;
                    }else{
                        $v->status = false;
                    }
                    $list[] = $v;
                }
            }
        }
        return $list;
    }
    // 后台验证短信模板是否正确
    public function message($SignName,$PhoneNumbers,$TemplateCode,$TemplateParam){
        $sql = "select * from lkt_message_config where store_id = '$this->store_id'";
        $r = $this->db->select($sql);
        if($r){
            $accessKeyId = $r[0]->accessKeyId;
            $accessKeySecret = $r[0]->accessKeySecret;

            $res = sendSms($accessKeyId,$accessKeySecret,$SignName,$PhoneNumbers,$TemplateCode,$TemplateParam);
            if($res->Code == 'OK'){
                return $res;
                
            }else{
                echo json_encode(array('status' =>'配置信息错误' ));exit;
            }
        }else{
            echo json_encode(array('status' =>'失败！' ));exit;
        }
    }
    // 发送验证码
    public function generate_code($db,$mobile,$type,$type1){
        $time = date('Y-m-d H:i:s'); // 当前时间
        $code = rand(100000,999999);

        $sql = "delete from lkt_session_id where date_add(add_date, interval 5 minute) < now() ";
        $db->delete($sql);

        $sql0 = "select * from lkt_message_config where store_id = '$this->store_id'";
        $r0 = $this->db->select($sql0);
        if($r0){
            $accessKeyId = $r0[0]->accessKeyId;
            $accessKeySecret = $r0[0]->accessKeySecret;
            if($type == 0){
                $TemplateParam = array('code'=>$code); // 验证码
                $sql1 = "select a.*,b.SignName,b.TemplateCode from lkt_message_list as a left join lkt_message as b on a.Template_id = b.id where a.store_id = '$this->store_id' and a.type = 0 and a.type1 = '$type1'";
                $r1 = $db->select($sql1);
                if($r1){
                    $SignName = $r1[0]->SignName;
                    $TemplateCode = $r1[0]->TemplateCode;
                }else{
                    $sql2 = "select a.*,b.SignName,b.TemplateCode from lkt_message_list as a left join lkt_message as b on a.Template_id = b.id where a.store_id = '$this->store_id' and a.type = 0 and a.type1 = '1'";
                    $r2 = $db->select($sql2);
                    if($r2){
                        $SignName = $r2[0]->SignName;
                        $TemplateCode = $r2[0]->TemplateCode;
                    }else{
                        echo json_encode(array('code'=>219,'message'=>'暂无设置短信信息'));
                        exit();
                    }
                }
            }else{
                $sql2 = "select a.*,b.SignName,b.TemplateCode from lkt_message_list as a left join lkt_message as b on a.Template_id = b.id where a.store_id = '$this->store_id' and a.type = '$type' and a.type1 = '$type1' ";
                $r2 = $db->select($sql2);
                if($r2){
                    $SignName = $r2[0]->SignName;
                    $TemplateCode = $r2[0]->TemplateCode;
                    $content = unserialize($r2[0]->content);
                    foreach ($content as $k => $v){
                        if($k = 'code'){
                            $content['code'] = $code;
                        }
                    }
                    $TemplateParam = $content;
                }else{
                    $sql3 = "select a.*,b.SignName,b.TemplateCode from lkt_message_list as a left join lkt_message as b on a.Template_id = b.id where a.store_id = '$this->store_id' and a.type = '$type' and a.type1 = '0' ";
                    $r3 = $db->select($sql3);
                    if($r3){
                        $SignName = $r3[0]->SignName;
                        $TemplateCode = $r3[0]->TemplateCode;
                        $content = unserialize($r3[0]->content);
                        foreach ($content as $k => $v){
                            if($k = 'code'){
                                $content['code'] = $code;
                            }
                        }
                        $TemplateParam = $content;
                    }else{
                        echo json_encode(array('code'=>219,'message'=>'暂无设置短信信息'));
                        exit();
                    }
                }
            }

            $arr = array($mobile,$TemplateParam);
            $content1 = json_encode($arr); // 数组转json字符串

            $res = sendSms($accessKeyId,$accessKeySecret,$SignName,$mobile,$TemplateCode,$TemplateParam);
            if($res->Code == 'OK'){
                $rew = 0; // 用来判断，是否有短信数据。0代表没有，1代表有
                $sql1 = "select * from lkt_session_id ";
                $r1 = $db->select($sql1);
                if($r1){
                    foreach ($r1 as $k => $v){
                        $content2 = json_decode($v->content);
                        if(($mobile == $content2[0])){
                            $sql = "update lkt_session_id set content = '$content1' where id = '$v->id'";
                            $db->update($sql);
                            $rew = 1;
                        }
                    }
                }
                if($rew == 0){
                    $sql1 = "insert into lkt_session_id(content,add_date) values ('$content1',CURRENT_TIMESTAMP)";
                    $db->insert($sql1);
                }

                echo json_encode(array('code'=>200,'message'=>'成功'));
                exit();
            }else{
                if($res->Code == 'isv.OUT_OF_SERVICE'){
                    echo json_encode(array('code'=>220,'message'=>'阿里云余额不足！'));
                    exit();
                }else if($res->Code == 'isv.SMS_TEMPLATE_ILLEGAL'){
                    echo json_encode(array('code'=>220,'message'=>'短信模板不存在，或未经审核通过！'));
                    exit();
                }else if($res->Code == 'isv.SMS_SIGNATURE_ILLEGAL'){
                    echo json_encode(array('code'=>220,'message'=>'签名不存在，或未经审核通过！'));
                    exit();
                }else if($res->Code == 'isv.MOBILE_NUMBER_ILLEGAL'){
                    echo json_encode(array('code'=>220,'message'=>'手机号码格式错误！'));
                    exit();
                }else if($res->Code == 'isv.MOBILE_COUNT_OVER_LIMIT'){
                    echo json_encode(array('code'=>220,'message'=>'手机号码数量超出！'));
                    exit();
                }else if($res->Code == 'isv.BUSINESS_LIMIT_CONTROL'){
                    echo json_encode(array('code'=>220,'message'=>'短信发送频率超限！'));
                    exit();
                }else if($res->Code == 'isv.AMOUNT_NOT_ENOUGH'){
                    echo json_encode(array('code'=>220,'message'=>'当前账户余额不足！'));
                    exit();
                }else{
                    echo json_encode(array('code'=>$res->Code,'message'=>'请去阿里短信查看错误信息！'));
                    exit();
                }
            }
        }else{
            echo json_encode(array('code'=>219,'message'=>'暂无设置短信信息'));
            exit();
        }
    }
    // 验证验证码
    public function verification_code($db,$arr){
        $time = date('Y-m-d H:i:s'); // 当前时间
        $status = 0;

        $sql = "delete from lkt_session_id where date_add(add_date, interval 5 minute) < now() ";
        $db->delete($sql);

        $sql1 = "select * from lkt_session_id";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $id = $v->id;
                $content1 = json_decode($v->content);
                if($arr[0] == $content1[0]){
                    if(isset($content1[1]->code)){
                        if($arr[1]['code'] != $content1[1]->code){
                            echo json_encode(array('code'=>216,'message'=>'验证码错误!'));
                            exit;
                        }else{
                            $status = 1;
                        }
                    }
                }
            }
        }

        if($status == 0){
            echo json_encode(array('code'=>217,'message'=>'验证码失效，请重新发送!'));
            exit;
        }
        return $id;
    }
    // 生成密钥
    public static function getToken(){
        $payload = array('iat'=>time(),'exp'=>time()+7200,'jti'=>md5(uniqid('JWT').time()));
        $token = Jwt::getToken($payload);
        return $token;
    }

    // 对token进行验证签名,如果过期返回false,成功返回数组
    public static function userToken($access_id){

        $getPayload_test = Jwt::verifyToken($access_id);
        return $getPayload_test;
    }

    // 对token进行验证签名,如果过期返回false,成功返回数组
    public static function verifyToken($db,$store_id,$store_type,$access_id){
        $sql0 = "select is_register from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $is_register = $r0[0]->is_register;
            if($is_register == 2 && $store_type == 1){ // 当注册为免注册，并且来源为小程序
                $getPayload_test = true;
            }else{
                $getPayload_test = Jwt::verifyToken($access_id);
            }
        }
        return $getPayload_test;
    }
    public static function del_banner($db,$store_id,$id,$tyle){
        $status = true;
        $sql0 = "select id,url from lkt_banner where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $key => $val){
                if(strpos($val->url,$tyle) !== false){
                    $parameter = trim(strrchr($val->url, '='),'=');
                    if($id == $parameter){
                        $status = false;
                        return $status;
                    }
                }
            }
        }
        $sql1 = "select url from lkt_coupon_activity where store_id = '$store_id' and skip_type = 2 and recycle = 0";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $res = trim(strrchr($v->url, '?'),'?');
                $res1 = explode('&',$res);
                foreach ($res1 as $ke => $va){
                    $rew = explode('=',$va);
                    if($rew[0] == $tyle){
                        if($id == $rew[1]){
                            $status = false;
                            return $status;
                        }
                    }
                }
            }
        }
        return $status;
    }
    // 商品状态
    public function commodity_status($db,$store_id,$id){

        $sql0 = "select product_title,product_class,status,brand_id,mch_id,initial,freight,active from lkt_product_list as a where a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 and a.id = '$id'";
        $r0 = $db->select($sql0);
        if($r0){
            if($r0[0]->status == 2){ // 当为上架状态
                // 砍价
                $sql00 = "select * FROM `lkt_bargain_goods`  where store_id = '$store_id' and status in (0,1,2) and is_delete = 0 and goods_id = '$id' ";
                $r00 = $db->select($sql00);
                if($r00){
                    echo json_encode(array('status' => '2')); exit;
                }
                // 积分商城
                $sql00 = "select * FROM `lkt_integral_goods`  where store_id = '$store_id' and is_delete = 0 and goods_id = '$id' ";
                $r00 = $db->select($sql00);
                if($r00){
                    echo json_encode(array('status' => '2')); exit;
                }
                // 拼团
                $sql01 = "SELECT g_status from lkt_group_product where store_id = '$store_id' and product_id = '$id' and is_delete = 0 and (g_status = 2 or g_status = 1) ";
                $r01 = $db->select($sql01);
                if($r01){
                    echo json_encode(array('status' => '2')); exit;
                }
                // 秒杀
                $sql010 = "SELECT * FROM `lkt_seconds_pro` as sp
                        RIGHT JOIN lkt_seconds_activity as sa on sa.id = sp.activity_id
                        WHERE 1 and sp.pro_id = $id and sp.is_delete = 0 and sa.is_delete = 0";
                $r010 = $db->select($sql010);
                if($r010){
                    echo json_encode(array('status' => '2')); exit;
                }
                // 竞拍
                $sql02 = "(select attribute from lkt_auction_product where store_id = '$store_id' and status in (0,1) ) union (select attribute from lkt_auction_product where store_id = '$store_id' and status = 2 and is_buy = 0)";
                $r02 = $db->select($sql02);

                $arr = array();//正在进行活动中的商品id数组
                if($r02){
                    foreach ($r02 as $k => $v) {
                        $attr = $v->attribute;//序列化的字符串
                        $attr = unserialize($attr);
                        $arr[$k] = array_keys($attr)[0];//商品id数组

                    }
                    if(in_array($id, $arr)){
                        echo json_encode(array('status' => '2')); exit;
                    }
                }

                // 优惠券
                $sql03 = "select type,product_class_id,product_id from lkt_coupon_activity where store_id = '$store_id' and recycle = 0 and status in (0,1,2)";
                $r03 = $db->select($sql03);
                if($r03){
                    foreach ($r03 as $key => $val){
                        if($val->type == 2){
                            $product_list = unserialize($val->product_id);
                            $product_list = explode(',',$product_list);
                            if(in_array($id,$product_list)){
                                echo json_encode(array('status' => '2')); exit;
                            }
                        }
                    }
                }
                // 满减
                $sql05 = "select pro_id from lkt_subtraction_config where store_id = '$store_id' ";
                $r05 = $db->select($sql05);
                if($r05){
                    $pro_id = explode(',',$r05[0]->pro_id);
                    if(in_array($id,$pro_id)){
                        echo json_encode(array('status' => '2')); exit;
                    }
                }

                $sql1 = "select a.* from lkt_product_list as a left join lkt_order_details as b on a.id = b.p_id where a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 and r_status in (0,1,2) and a.id = '$id'";
                $r1 = $db->select($sql1);
                if($r1){
                    echo json_encode(array('status' => '3')); exit;
                }
                //会员赠送商品
                $sql_06 = "select is_product from lkt_user_rule where store_id = $store_id";
                $res_06 = $db->select($sql_06);
                if($res_06){
                    $is_product = $res_06[0]->is_product;//0-未开通 1-开通
                    if($is_product == 1){
                        $sql06 = "select id from lkt_user_grade where store_id = $store_id and pro_id = $id";
                        $res06 = $db->select($sql06);
                        if($res06){
                            echo json_encode(array('status'=>'2'));exit;
                        }
                    }
                }
            }else{ // 当为下架或待上架状态
                if(strlen($r0[0]->product_title) > 60){
                    echo json_encode(array('status' => '4'));
                    exit;
                }
                if($r0[0]->initial){
                    $initial = unserialize($r0[0]->initial);
                    foreach ($initial as $k => $v){
                        if($k == 'cbj' && $v == ''){
                            echo json_encode(array('status' => '4'));
                            exit;
                        }else if($k == 'yj' && $v == ''){
                            echo json_encode(array('status' => '4'));
                            exit;
                        }else if($k == 'sj' && $v == ''){
                            echo json_encode(array('status' => '4'));
                            exit;
                        }else if($k == 'unit' && $v == '0'){
                            echo json_encode(array('status' => '4'));
                            exit;
                        }else if($k == 'kucun' && $v == ''){
                            echo json_encode(array('status' => '4'));
                            exit;
                        }
                    }
                }
                if ($r0[0]->freight == 0) {
                    echo json_encode(array('status' => '4'));
                    exit;
                }
                if ($r0[0]->active == '') {
                    echo json_encode(array('status' => '4'));
                    exit;
                }
            }
        }
        return;
    }
    // 防止sql注入的函数，过滤掉那些非法的字符,提高sql安全性，同时也可以过滤XSS的攻击。
    public function filter($str){
        if (empty($str)) return false;
        $str = htmlspecialchars($str);
        $str = str_replace( '/', "", $str);
        $str = str_replace( '"', "", $str);
        $str = str_replace( '(', "", $str);
        $str = str_replace( ')', "", $str);
        $str = str_replace( 'CR', "", $str);
        $str = str_replace( 'ASCII', "", $str);
        $str = str_replace( 'ASCII 0x0d', "", $str);
        $str = str_replace( 'LF', "", $str);
        $str = str_replace( 'ASCII 0x0a', "", $str);
        $str = str_replace( ',', "", $str);
        $str = str_replace( '%', "", $str);
        $str = str_replace( ';', "", $str);
        $str = str_replace( 'eval', "", $str);
        $str = str_replace( 'open', "", $str);
        $str = str_replace( 'sysopen', "", $str);
        $str = str_replace( 'system', "", $str);
        $str = str_replace( '$', "", $str);
        $str = str_replace( "'", "", $str);
        $str = str_replace( "'", "", $str);
        $str = str_replace( 'ASCII 0x08', "", $str);
        $str = str_replace( '"', "", $str);
        $str = str_replace( '"', "", $str);
        $str = str_replace("", "", $str);
        $str = str_replace("&gt", "", $str);
        $str = str_replace("&lt", "", $str);
        $str = str_replace("<SCRIPT>", "", $str);
        $str = str_replace("</SCRIPT>", "", $str);
        $str = str_replace("<script>", "", $str);
        $str = str_replace("</script>", "", $str);
        $str = str_replace("select","",$str);
        $str = str_replace("join","",$str);
        $str = str_replace("union","",$str);
        $str = str_replace("where","",$str);
        $str = str_replace("insert","",$str);
        $str = str_replace("delete","",$str);
        $str = str_replace("update","",$str);
        $str = str_replace("like","",$str);
        $str = str_replace("drop","",$str);
        $str = str_replace("DROP","",$str);
        $str = str_replace("create","",$str);
        $str = str_replace("modify","",$str);
        $str = str_replace("rename","",$str);
        $str = str_replace("alter","",$str);
        $str = str_replace("cas","",$str);
        $str = str_replace("&","",$str);
        $str = str_replace(">","",$str);
        $str = str_replace("<","",$str);
        $str = str_replace(" ",chr(32),$str);
        $str = str_replace(" ",chr(9),$str);
        $str = str_replace("    ",chr(9),$str);
        $str = str_replace("&",chr(34),$str);
        $str = str_replace("'",chr(39),$str);
        $str = str_replace("<br />",chr(13),$str);
        $str = str_replace("''","'",$str);
        $str = str_replace("css","'",$str);
        $str = str_replace("CSS","'",$str);
        $str = str_replace("<!--","",$str);
        $str = str_replace("convert","",$str);
        $str = str_replace("md5","",$str);
        $str = str_replace("passwd","",$str);
        $str = str_replace("password","",$str);
        $str = str_replace("../","",$str);
        $str = str_replace("./","",$str);
        $str = str_replace("Array","",$str);
        $str = str_replace("or 1='1'","",$str);
        $str = str_replace(";set|set&set;","",$str);
        $str = str_replace("`set|set&set`","",$str);
        $str = str_replace("--","",$str);
        $str = str_replace("OR","",$str);
        $str = str_replace('"',"",$str);
        $str = str_replace("*","",$str);
        $str = str_replace("-","",$str);
        $str = str_replace("+","",$str);
        $str = str_replace("/","",$str);
        $str = str_replace("=","",$str);
        $str = str_replace("'/","",$str);
        $str = str_replace("-- ","",$str);
        $str = str_replace(" -- ","",$str);
        $str = str_replace(" --","",$str);
        $str = str_replace("(","",$str);
        $str = str_replace(")","",$str);
        $str = str_replace("{","",$str);
        $str = str_replace("}","",$str);
        $str = str_replace("-1","",$str);
        $str = str_replace(".","",$str);
        $str = str_replace("response","",$str);
        $str = str_replace("write","",$str);
        $str = str_replace("|","",$str);
        $str = str_replace("`","",$str);
        $str = str_replace(";","",$str);
        $str = str_replace("etc","",$str);
        $str = str_replace("root","",$str);
        $str = str_replace("//","",$str);
        $str = str_replace("!=","",$str);
        $str = str_replace("$","",$str);
        $str = str_replace("&","",$str);
        $str = str_replace("&&","",$str);
        $str = str_replace("==","",$str);
        $str = str_replace("#","",$str);
        $str = str_replace("@","",$str);
        $str = str_replace("mailto:","",$str);
        $str = str_replace("CHAR","",$str);
        $str = str_replace("char","",$str);
        return $str;
    }
    // 数字转拼音
    public function shuzi($str){
        $res = '';
        if($str == '1'){
            $res = "yi";
        }else if($str == '2'){
            $res = "er";
        }else if($str == '3'){
            $res = "san";
        }else if($str == '4'){
            $res = "si";
        }else if($str == '5'){
            $res = "wu";
        }else if($str == '6'){
            $res = "liu";
        }else if($str == '7'){
            $res = "qi";
        }else if($str == '8'){
            $res = "ba";
        }else if($str == '9'){
            $res = "jiu";
        }else if($str == '0'){
            $res = "ling";
        }
        return $res;
    }
    // 中文转字母
    public function _getFirstCharter($str){
        if(empty($str)){return '';}
        $fchar=ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});
        $s1=iconv('UTF-8','gb2312',$str);
        $s2=iconv('gb2312','UTF-8',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;
        if($asc>=-20319&&$asc<=-20284) return 'A';
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return null;
    }
    // 二维数组去重
    public static function assoc_unique($arr, $key) {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr)) {//搜索$v[$key]是否在$tmp_arr数组中存在，若存在返回true
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        sort($arr); //sort函数对数组进行排序
        return $arr;
    }
    // 获取支付方式状态
    public static function getPayment($db,$store_id)
    {
        $res = array();
        $sql = "select c.status,p.class_name from lkt_payment_config c left join lkt_payment p on c.pid=p.id where c.store_id='$store_id'";
        $r = $db->select($sql);
        foreach ($r as $k=>$v){
            $res[$v->class_name] = $v->status;
        }

        return $res;
    }
}

?>