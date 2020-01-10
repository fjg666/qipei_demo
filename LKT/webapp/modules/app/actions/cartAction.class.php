<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class cartAction extends Action
{
    /*
    时间2018年03月15日
    修改内容：所有商品购买付款下订单等操作API请求
    修改人：苏涛
    主要功能：处理商品数据，返回购物请求结果
    备注：api-JSON
     */
    public function getDefaultView()
    {
        return;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }
        $this->$app();

        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    // 进入购物车页面
    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        //$cart_id = trim($request->getParameter('cart_id')); // 购物车id
        $arr = array();
        $login_status = 0;
        if(!empty($access_id)){ // 存在
            //查询登录用户
            $sql0_0 = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r0_0 = $db->select($sql0_0);
            //如果查询到用户，获取用户user_id ,登录状态设置为1
            if($r0_0){
                $login_status = 1;
                $user_id = $r0_0[0]->user_id;
            }
            if(empty($user_id)){
                //如果没有查询到用户，查询游客添加购物车商品

                $sql_c = "select a.*,m.product_title,m.mch_id,c.id AS attribute_id,c.pid,c.price,c.img,c.num,c.unit,c.attribute from lkt_cart AS a LEFT JOIN lkt_product_list AS m  ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c  ON a.Size_id = c.id where a.store_id = '$store_id' and m.recycle = 0 and m.status = 2 and m.mch_status = 2 and a.token = '$access_id' order by a.Create_time desc";
            }else{
//                如果查询到用户，查询用户的购物车商品

                $sql_c = "select a.*,m.product_title,m.mch_id,c.id AS attribute_id,c.pid,c.price,c.img,c.num,c.unit,c.attribute from lkt_cart AS a LEFT JOIN lkt_product_list AS m  ON a.Goods_id = m.id LEFT JOIN lkt_configure AS c  ON a.Size_id = c.id where a.store_id = '$store_id' and m.recycle = 0 and m.status = 2 and m.mch_status = 2 and a.user_id = '$user_id' order by a.Create_time desc";
            }
            $r_c = $db->select($sql_c);



            //如果有购物车商品
            if (!empty($r_c)) {
                $mch_str = '';

//                循环处理购物车商品数据
                foreach ($r_c as $key => $value) {
                    $imgurl = ServerPath::getimgpath($value->img); // 商品属性图片
                    $pid = $value->pid; // 商品id
                    $attribute_id = $value->attribute_id; // 商品属性id
                    $attribute_1 = '';
                    $mch_id = $value->mch_id;
                    $mch_str .=$mch_id.',';
                    //如果商品下有其他属性
                    if(empty($value->attribute)){
                        $attribute1 = $value->attribute;
                        $attribute2 = unserialize($attribute1);
                        if(!empty($attribute2)){
                            foreach ($attribute2 as $k => $v) {
                                $attribute_1 .= $v . ' ';
                            }
                        }
                        $attribute_1 = trim($attribute_1, ' '); // 移除两侧的空格(购物车显示的属性)
                    }

                    if ($value->num > 0) {
                        $stock = $value->num; // 库存
                    } else {
                        $stock = 0; // 库存
                    }

                    $sql_size = "select * from lkt_configure where pid = '$pid' and id = '$attribute_id'";
                    $r_size = $db->select($sql_size);
                    $skuBeanList = array();
                    $attrList = array();
                    $attr = array();
                    foreach ($r_size as $ke => $va) {
                        $array_price[$ke] = $va->price;
                        $array_yprice[$ke] = $va->yprice;
                        $attribute = unserialize($va->attribute);
                        $attnum = 0;
                        $arrayName = array();
                        foreach ($attribute as $k => $v) {
                            if (!in_array($k, $arrayName)) {
                                array_push($arrayName, $k);
                                $kkk = $attnum++;
                                $attrList[$kkk] = array('attrName' => $k, 'attrType' => '1', 'id' => md5($k), 'attr' => [], 'all' => []);
                            }
                        }
                    }
                    foreach ($r_size as $ke => $va) {
                        $attribute = unserialize($va->attribute);
                        $attributes = array();
                        $name = '';
                        foreach ($attribute as $k => $v) {
                            $attributes[] = array('attributeId' => md5($k), 'attributeValId' => md5($v));
                            $name .= $v;
                        }

                        $cimgurl = ServerPath::getimgpath($va->img);
                        $unit = $va->unit;

                        $skuBeanList[$key] = array('name' => $name, 'imgurl' => $cimgurl, 'cid' => $va->id, 'price' => $va->price, 'count' => $va->num, 'unit' => $unit, 'attributes' => $attributes);
                        for ($i = 0; $i < count($attrList); $i++) {
                            $attr = $attrList[$i]['attr'];
                            $all = $attrList[$i]['all'];
                            foreach ($attribute as $k => $v) {
                                if ($attrList[$i]['attrName'] == $k) {
                                    $attr_array = array('attributeId' => md5($k), 'id' => md5($v), 'attributeValue' => $v, 'enable' => false, 'select' => false);

                                    if (empty($attr)) {
                                        array_push($attr, $attr_array);
                                        array_push($all, $v);
                                    } else {
                                        if (!in_array($v, $all)) {
                                            array_push($attr, $attr_array);
                                            array_push($all, $v);
                                        }
                                    }
                                }
                            }
                            $attrList[$i]['all'] = $all;
                            $attrList[$i]['attr'] = $attr;
                        }
                    }
                    $arr[$key] = array('id' => $value->id, 'attribute_id' => $value->attribute_id,'mch_id'=>$value->mch_id, 'pid' => $value->Goods_id, 'attribute' => $attribute_1, 'price' => $value->price, 'num' => $value->Goods_num, 'pro_name' => $value->product_title, 'imgurl' => $imgurl, 'stock' => $stock, 'attrList' => $attrList, 'skuBeanList' => $skuBeanList);
                }
                $mch_str = rtrim($mch_str, ',');
                //            查询所有店铺信息

                $sel_mch_sql = "SELECT id,name,shop_information FROM `lkt_mch` WHERE review_status = 1 and store_id = $store_id and id in ($mch_str)";
                $mch_res = $db->select($sel_mch_sql);
            }else{
                $mch_res = array();

            }



        }else{
            $mch_res = array();
        }


        $sql_t = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,c.id as attribute_id,a.mch_id,c.num as stock,min(c.price) as price 
                    from lkt_product_list AS a 
                    RIGHT JOIN lkt_configure AS c ON a.id = c.pid 
                    where a.store_id = '$store_id' and a.recycle = 0 and a.status = 2 and a.mch_status = 2 and a.show_adr like '%2%' 
                    group by c.pid 
                    order by a.add_date 
                    desc,a.sort desc 
                    LIMIT 0,10";
        $r_t = $db->select($sql_t);
        if($r_t){
            foreach ($r_t as $k => $v){
                $v->imgurl = ServerPath::getimgpath($v->imgurl);
                $list[] = $v;
            }
        }else{
            $list = array();
        }

       
        echo json_encode(array('code' => 200, 'data' => $arr,'list'=>$list,'login_status'=>$login_status,'mch_list'=>$mch_res, 'message' => '成功'));
//        echo json_encode(array('code' => 200, 'data' => $arr,'list'=>$list,'login_status'=>$login_status, 'message' => '成功'));
        exit;
    }

    // 用户修改购物车数量操作
    public function up_cart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = $request->getParameter('access_id'); // 授权id
        $goods = $request->getParameter('goods'); // 购物车id(购物车id+数量)

        $goods1 = htmlspecialchars_decode($goods);
        $goods2 = json_decode($goods1);

        if(!empty($access_id)){ // 存在
            $sql0 = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r0 = $db->select($sql0);
            if($r0){
                $user_id = $r0[0]->user_id;
            }
            if( is_array( $goods2 ) ){
                foreach ($goods2 as $k => $v) {
                    $cart_id = $v->cart_id;
                    $num = $v->num;
                    if(empty($user_id)){
                        $sql = "select Size_id from lkt_cart where store_id = '$store_id' and id = '$cart_id' and token = '$access_id'";
                    }else{
                        $sql = "select Size_id from lkt_cart where store_id = '$store_id' and id = '$cart_id' and user_id = '$user_id'";
                    }
                    $r_1 = $db->select($sql);
                    if ($r_1) {
                        $attribute_id = $r_1[0]->Size_id; // 属性id
                        // 根据属性id,查询库存
                        $sql = "select num from lkt_configure where id = '$attribute_id'";
                        $r_2 = $db->select($sql);
                        $z_num = $r_2[0]->num;
                        if ($z_num >= $num) {
                            if(empty($user_id)){
                                $sql_u = "update lkt_cart set Goods_num = '$num' where store_id = '$store_id' and id = '$cart_id' and token = '$access_id'";
                            }else{
                                $sql_u = "update lkt_cart set Goods_num = '$num' where store_id = '$store_id' and id = '$cart_id' and user_id = '$user_id'";
                            }
                            $r_u = $db->update($sql_u);

                            echo json_encode(array('code' => 200, 'message' => '成功'));
                            exit;
                        } else {
                            if(empty($user_id)){
                                $sql_u = "update lkt_cart set Goods_num = '$z_num' where store_id = '$store_id' and id = '$cart_id' and token = '$access_id'";
                            }else{
                                $sql_u = "update lkt_cart set Goods_num = '$z_num' where store_id = '$store_id' and id = '$cart_id' and user_id = '$user_id'";
                            }
                            $r_u = $db->update($sql_u);

                            echo json_encode(array('code' => 105, 'message' => '库存不足'));
                            exit;
                        }
                    } else {
                        echo json_encode(array('code' => 109, 'message' => '参数错误'));
                        exit;
                    }
                }
            }else{
                $cart_id = $goods2->cart_id;
                $num = $goods2->num;

                if(empty($user_id)){
                    $sql = "select Size_id from lkt_cart where store_id = '$store_id' and id = '$cart_id' and token = '$access_id'";
                }else{
                    $sql = "select Size_id from lkt_cart where store_id = '$store_id' and id = '$cart_id' and user_id = '$user_id'";
                }
                $r_1 = $db->select($sql);

                if($r_1){
                    $attribute_id = $r_1[0]->Size_id; // 属性id

                    // 根据属性id,查询库存
                    $sql = "select num from lkt_configure where id = '$attribute_id'";
                    $r_2 = $db->select($sql);
                    $z_num = $r_2[0]->num;
                    if ($z_num >= $num) {
                        if(empty($user_id)){
                            $sql_u = "update lkt_cart set Goods_num = '$num' where store_id = '$store_id' and id = '$cart_id' and token = '$access_id'";
                        }else{
                            $sql_u = "update lkt_cart set Goods_num = '$num' where store_id = '$store_id' and id = '$cart_id' and user_id = '$user_id'";
                        }
                        $r_u = $db->update($sql_u);

                        echo json_encode(array('code' => 200, 'message' => '成功'));
                        exit;
                    } else {
                        if(empty($user_id)){
                            $sql_u = "update lkt_cart set Goods_num = '$z_num' where store_id = '$store_id' and id = '$cart_id' and token = '$access_id'";
                        }else{
                            $sql_u = "update lkt_cart set Goods_num = '$z_num' where store_id = '$store_id' and id = '$cart_id' and user_id = '$user_id'";
                        }
                        $r_u = $db->update($sql_u);
                        echo json_encode(array('code' => 105, 'message' => '库存不足'));
                        exit;
                    }
                }
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    // 清空购物车
    public function delAll_cart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        if(!empty($access_id)) { // 存在
            $sql0_0 = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                $user_id = $r0_0[0]->user_id;
            }
            if(empty($user_id)){
                $sql = "delete from lkt_cart where store_id = '$store_id' and token = '$access_id'";
            }else{
                $sql = "delete from lkt_cart where store_id = '$store_id' and user_id = '$user_id'";
            }
            $res = $db->delete($sql);
            if ($res < 0) {
                echo json_encode(array('code' => 101, 'err' => '未知错误!'));
                exit;
            }else{
                echo json_encode(array('code' => 200, 'message' => '成功'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    // 移动购物车指定商品去收藏
    public function to_Collection()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $car_id = $request->getParameter('car_id'); // 购物车id
        $access_id = trim($request->getParameter('access_id')); // 授权id
        if(!empty($access_id)) { // 存在
            $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db->select($sql);
            if($r){
                $user_id = $r[0]->user_id; // 用户id
                //循环移动并删除指定的购物车商品
                foreach ($car_id as $key => $value) {
                    //查询商品id
                    $csql = "select Goods_id from lkt_cart where store_id = '$store_id' and id ='$value' ";
                    $cres = $db->select($csql);
                    $pid = $cres[0]->Goods_id;
                    // 根据用户id,产品id,查询收藏表
                    $sql = "select * from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and p_id = '$pid'";
                    $r = $db->select($sql);
                    if (!$r) {
                        // 在收藏表里添加一条数据
                        $sql = "insert into lkt_user_collection(store_id,user_id,p_id,add_time) values('$store_id','$user_id','$pid',CURRENT_TIMESTAMP)";
                        $r = $db->insert($sql);
                    }
                    // 删除指定购物车id
                    $sql = 'delete from lkt_cart where store_id = \''.$store_id.'\' and id="' . $value . '"';
                    $res = $db->delete($sql);
                }
                if ($res) {
                    echo json_encode(array('code' => 200, 'message' => '成功'));
                    exit;
                } else {
                    echo json_encode(array('code' => 101, 'err' => '未知错误!'));
                    exit;
                }
            }else{
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    // 删除购物车指定商品
    public function delcart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $cart_id = $request->getParameter('cart_id');
        if(!empty($access_id)){ // 存在
            $sql0_0 = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                $user_id = $r0_0[0]->user_id;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }

        $typeArr = array();
        if(!empty($access_id)) { // 存在
            if(!empty($cart_id)){
                if(is_array($cart_id)){ // 是数组
                    foreach ($cart_id as $key => $value) {
                        $typeArr[$key] = $value;
                    }
                }else if(is_string($cart_id)){ // 是字符串
                    $typestr=trim($cart_id,','); // 移除两侧的逗号
                    $typeArr=explode(',',$typestr); // 字符串打散为数组
                }

                //循环删除指定的购物车商品
                foreach ($typeArr as $key => $value) {
                    if(empty($user_id)){
                        $sql = "delete from lkt_cart where store_id = '$store_id' and id='$value' and token = '$access_id'";
                    }else{
                        $sql = "delete from lkt_cart where store_id = '$store_id' and id='$value' and user_id = '$user_id'";
                    }
                    $res = $db->delete($sql);
                }
                if ($res) {
                    echo json_encode(array('code' => 200, 'message' => '成功'));
                    exit;
                } else {
                    echo json_encode(array('code' => 101, 'err' => '未知错误!'));
                    exit;
                }
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    // 修改购物车商品属性dj_attribute
    public function modify_attribute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $cart_id = $request->getParameter('cart_id'); // 购物车id
        $attribute_id = $request->getParameter('attribute_id'); // 属性id

        if (empty($cart_id) || empty($attribute_id)) {
            echo json_encode(array('code' => 109, 'message' => '参数错误'));
            exit;
        }
        if(!empty($access_id)) { // 存在
            $sql0_0 = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                $user_id = $r0_0[0]->user_id;
            }
            if(empty($user_id)){
                $sql = "select * from lkt_cart where store_id = '$store_id' and token = '$access_id' and id = '$cart_id'";
            }else{
                $sql = "select * from lkt_cart where store_id = '$store_id' and user_id = '$user_id' and id = '$cart_id'";
            }
            $r_1 = $db->select($sql);
            if ($r_1) {
                $Goods_id1 = $r_1[0]->Goods_id; // 商品id
                $Goods_num1 = $r_1[0]->Goods_num; // 商品数量
                if(empty($user_id)){
                    $sql = "select * from lkt_cart where store_id = '$store_id' and token = '$access_id' ";
                }else{
                    $sql = "select * from lkt_cart where store_id = '$store_id' and user_id = '$user_id' ";
                }
                $r_2 = $db->select($sql);
                foreach ($r_2 as $k => $v) {
                    $c_id = $v->id; // 购物车id
                    $Goods_id2 = $v->Goods_id; // 商品id
                    $Goods_num2 = $v->Goods_num; // 商品数量
                    $Size_id = $v->Size_id; // 属性id
                    $sql = "select num from lkt_configure where pid = '$Goods_id2' and id = '$Size_id'";
                    $r_3 = $db->select($sql);
                    $num = $r_3[0]->num;
                    if ($Size_id == $attribute_id) {
                        if ($c_id != $cart_id) {
                            if($Goods_num1 + $Goods_num2 > $num){
                                $sql = "update lkt_cart set Goods_num = '$num',Size_id = '$attribute_id' where store_id = '$store_id' and id = '$cart_id'";
                            }else{
                                $sql = "update lkt_cart set Goods_num = Goods_num+'$Goods_num2',Size_id = '$attribute_id' where store_id = '$store_id' and id = '$cart_id'";
                            }
                            $db->update($sql);

                            $sql = "delete from lkt_cart where store_id = '$store_id' and id = '$c_id'";
                            $db->delete($sql);
                        }
                    } else {
                        $sql = "select num from lkt_configure where pid = '$Goods_id1' and id = '$attribute_id'";
                        $r_3 = $db->select($sql);
                        if($r_3){
                            $num = $r_3[0]->num;
                            if($Goods_num1 > $num ){
                                $sql = "update lkt_cart set Goods_num = '$num',Size_id = '$attribute_id' where store_id = '$store_id' and id = '$cart_id'";
                            }else{
                                $sql = "update lkt_cart set Size_id = '$attribute_id' where store_id = '$store_id' and id = '$cart_id'";
                            }
                            $db->update($sql);
                        }
                    }
                }
                echo json_encode(array('code' => 200, 'message' => '成功'));
                exit;
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    // 修改购物车商品属性
    public function dj_attribute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $cart_id = $request->getParameter('cart_id'); // 购物车id

        if (empty($cart_id)) {
            echo json_encode(array('code' => 109, 'message' => '参数错误'));
            exit;
        }
        if(!empty($access_id)) { // 存在
            $sql0 = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r0 = $db->select($sql0);
            if($r0){
                $user_id = $r0[0]->user_id;
                $sql1 = "select Goods_id from lkt_cart where store_id = '$store_id' and id = '$cart_id' and user_id = '$user_id'";
            }else{
                $sql1 = "select Goods_id from lkt_cart where store_id = '$store_id' and id = '$cart_id' and token = '$access_id'";
            }
            $r1 = $db->select($sql1);
            if ($r1) {
                $pid = $r1[0]->Goods_id;
                $sql = "select * from lkt_configure where pid = '$pid'";
                $r_size = $db->select($sql);
                $skuBeanList = array();
                $attrList = array();
                $attr = array();
                foreach ($r_size as $ke => $va) {
                    $array_price[$ke] = $va->price;
                    $array_yprice[$ke] = $va->yprice;
                    $attribute = unserialize($va->attribute);
                    $attnum = 0;
                    $arrayName = array();
                    foreach ($attribute as $k => $v) {
                        if (!in_array($k, $arrayName)) {
                            array_push($arrayName, $k);
                            $kkk = $attnum++;
                            $attrList[$kkk] = array('attrName' => $k, 'attrType' => '1', 'id' => md5($k), 'attr' => [], 'all' => []);
                        }
                    }
                }
                foreach ($r_size as $ke => $va) {
                    $attribute = unserialize($va->attribute);
                    $attributes = array();
                    $name = '';
                    foreach ($attribute as $k => $v) {
                        $attributes[] = array('attributeId' => md5($k), 'attributeValId' => md5($v));
                        $name .= $v;
                    }

                    $cimgurl = ServerPath::getimgpath($va->img);
                    $unit = $va->unit;

                    $skuBeanList[] = array('name' => $name, 'imgurl' => $cimgurl, 'cid' => $va->id, 'price' => $va->price, 'count' => $va->num, 'unit' => $unit, 'attributes' => $attributes);
                    for ($i = 0; $i < count($attrList); $i++) {
                        $attr = $attrList[$i]['attr'];
                        $all = $attrList[$i]['all'];
                        foreach ($attribute as $k => $v) {
                            if ($attrList[$i]['attrName'] == $k) {
                                $attr_array = array('attributeId' => md5($k), 'id' => md5($v), 'attributeValue' => $v, 'enable' => false, 'select' => false);

                                if (empty($attr)) {
                                    array_push($attr, $attr_array);
                                    array_push($all, $v);
                                } else {
                                    if (!in_array($v, $all)) {
                                        array_push($attr, $attr_array);
                                        array_push($all, $v);
                                    }
                                }
                            }
                        }
                        $attrList[$i]['all'] = $all;
                        $attrList[$i]['attr'] = $attr;
                    }
                }
                $arr[] = array('attrList' => $attrList, 'skuBeanList' => $skuBeanList);
                echo json_encode(array('code' => 200, 'data' => $arr, 'message' => '成功'));
                exit;
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }
}


?>