<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');

class productAction extends Action
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
        $this->execute();
    }

    public function execute()
    {
        @ob_clean();
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        header('Access-Control-Allow-Origin: *');
        header('Content-Type:application/json; charset=utf-8');
        $this->$app();
        exit;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    // 获取产品详情
    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $id = trim($request->getParameter('pro_id')); // 获取商品id
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $_type_ = trim($request->getParameter('type')); //
        $bargain_id = trim($request->getParameter('bargain_id'));
        $attr_id = trim($request->getParameter('attr_id')); // 属性ID
        $time = time();
		$uploadImg_domain = 'https://xiaochengxu.laiketui.com/V2.7';
        // 查询系统参数
        $sql = "select * from lkt_upload_set ";
        $r_1 = $db->select($sql);
        if($r_1){
            foreach ($r_1 as $K => $v){
                if($v -> type == '本地' && $v->attr == 'uploadImg_domain'){
                    $uploadImg_domain = $v -> attrvalue; // 图片上传域名
                }
            }
        }
        if ($access_id != '') {
            // 根据授权id,查询用户信息(被邀请人)
            $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db->select($sql);
            if ($r) { // 是会员
                $user_id = $r[0]->user_id; // 用户id
                $login_status = 1;
                $grade = $r[0]->grade;//会员等级id
                // 根据用户id、产品id,获取收藏表信息
                $sql = "select * from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and p_id = '$id'";
                $rr = $db->select($sql);
                if ($rr) {
                    $type = 1; // 已收藏
                    $collection_id = $rr['0']->id; // 收藏id
                } else {
                    $type = 0; // 未收藏
                    $collection_id = '';
                }
                // 根据用户id,在足迹表里插入一条数据
                $sql = "insert into lkt_user_footprint(store_id,user_id,p_id,add_time) values('$store_id','$user_id','$id',CURRENT_TIMESTAMP)";
                $rrr = $db->insert($sql);
            }else{
                $user_id = '游客'.$time;
                $type = 0; // 未收藏
                $collection_id = '';
                $login_status = 0;
                $grade = '';
            }
        } else {
            $access_id = Tools::getToken();
            $grade = '';
            $user_id = '游客'.$time;;
            $type = 0; // 未收藏
            $collection_id = '';
            $login_status = 0;
        }
        if($grade){
            $is_grade = 1;//是会员
        }else{
            $is_grade = 0;//非会员
        }

        /* 商品开始 */
        // 根据产品id,查询产品数据
        $sql = 'select a.*,c.price,c.yprice,c.img,c.unit,c.attribute from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid ' . "where a.store_id = '$store_id' and c.recycle = 0 and a.id = $id ";
        if($_type_ === 'KJ'){
            $sql = 'select a.*,c.price,c.yprice,c.img,c.unit,c.attribute from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid ' . "where a.store_id = '$store_id' and c.recycle = 0 and a.id = $id and c.id='$attr_id'";
        }
        $res = $db->select($sql);

        if ($res == '') {
            echo json_encode(array('code' => 101, 'message' => '未知错误'));
            exit();
        } else {
            $img_arr = array();
            $shop_list = array();
            $mch_id = $res[0]->mch_id;
            $imgurl = ServerPath::getimgpath($res[0]->imgurl); // 图片
            if($_type_ === 'KJ'){
                $imgurl = ServerPath::getimgpath($res[0]->img); // 图片
            }

            if ($mch_id != 0) {
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
                    $sql3 = "select c.img,a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and c.recycle = 0 and a.active = 1 group by c.pid ";
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
                $sql = "insert into lkt_mch_browse(store_id,token,mch_id,user_id,event,add_time) values ('$store_id','$access_id','$mch_id','$user_id','访问了店铺',CURRENT_TIMESTAMP)";
                $db->insert($sql);
            }
            $img_arr[0] = $imgurl;  // 图片路径
            // 根据商品id,查询商品图片表
            $sql_img = "select product_url,id from lkt_product_img where product_id = '$id'";
            $r = $db->select($sql_img);
            if ($r) {
                foreach ($r as $key => $value) {
                    $key1 = $key+1;
                    $img_arr[$key1] = ServerPath::getimgpath($value->product_url); // 图片路径
                }
            }
            $class = $res['0']->product_class; // 产品类别
            $typestr = trim($class, '-');
            $typeArr = explode('-', $typestr);
            //  取数组最后一个元素 并查询分类名称
            $cid = end($typeArr);
            // 根据商品类别,查询类别名称
            $sql_p = "select pname from lkt_product_class where store_id = '$store_id' and cid ='" . $cid . "'";

            $r_p = $db->select($sql_p);
            if ($r_p) {
                $pname = $r_p['0']->pname; // 分类名称
            } else {
                array_pop($typeArr);
                $cid = end($typeArr);
                $sql_p1 = "select pname from lkt_product_class where store_id = '$store_id' and cid ='" . $cid . "'";
                $r_p1 = $db->select($sql_p1);
                $pname = $r_p1['0']->pname; // 分类名称
            }

            $product = array();
            $content = $res['0']->content; // 商品内容

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
            $p_id = $product['pro_id'] = $res['0']->id; // 商品id
            $product['name'] = $res['0']->product_title; // 商品名字
            $active = $res['0']->active; // 产品活动类型
            foreach ($res as $k => $v) {
                $num[] = $v->num;
                $price[] = $v->price;
                $yprice[] = $v->yprice;
                $price_min = floatval(min($price));
                $price_max = floatval(max($price));
                $yprice_min = floatval(min($yprice));
                $yprice_max = floatval(max($yprice));
                if ($price_min == $price_max) {
                    $product['price'] = $price_min; // 出售价格
                } else {
                    $product['price'] = $price_min . '-' . $price_max; // 出售价格
                }
                if ($yprice_min == $yprice_max) {
                    $product['yprice'] = $yprice_min; // 原价格
                } else {
                    $product['yprice'] = $yprice_min . '-' . $yprice_max; // 原价格
                }
            }
            $product['num'] = $res['0']->num; // 数量
            if ($res['0']->unit != '') {
                $product['unit'] = $res['0']->unit; // 单位
            } else {
                $product['unit'] = '个';
            }
            $product['photo_x'] = $imgurl;
            $product['content'] = $new_content; // 商品内容
            $product['cat_name'] = $pname; // 分类名称
            $product['img_arr'] = $img_arr; // 图片路径
            $product['status'] = $res['0']->status; // 状态
            $product['volume'] = $res['0']->volume; // 销量
            $product['is_distribution'] = $res['0']->is_distribution; // 是否为分销商品
            $product['user_id'] = $user_id; // 用户id
            $sel_freightSql = "SELECT f.freight ,f.freight ,p.mch_id
                           FROM lkt_product_list as p
                           LEFT JOIN lkt_freight as f on p.freight = f.id
                           WHERE p.id = $p_id";
            $freightRes = $db->select($sel_freightSql);
            $yunfei = unserialize($freightRes[0]->freight);
            $product['yunfei'] = $yunfei[0]['two'];
            $product['canbuy'] = 1;
            if (intval($product['is_distribution'])>0) {
                $distributor_id = $res['0']->distributor_id;
                $is_distribution = $res['0']->is_distribution;

                if (intval($is_distribution) > 0) {

                    $sql1 = "select sort from lkt_distribution_grade where id='$distributor_id'";
                    $r1 = $db->select($sql1);
                    $sql2 = "select b.sort from lkt_user_distribution as a left join lkt_distribution_grade as b on a.level=b.id where a.user_id='$user_id'";
                    $r2 = $db->select($sql2);

                    $sort1 = !empty($r1)?$r1[0]->sort:0;
                    $sort2 = !empty($r2)?$r2[0]->sort:0;

                    if (intval($sort2) < intval($sort1)) {
                        $product['canbuy'] = 0;
                    }
                    //判断会员的等级是否满足分销
                    $sql = "select g.rate from lkt_user_rule r left join lkt_user_grade g on r.distribute_l=g.id where g.store_id='$store_id'";
                    $rate = $db->select($sql);
                    if ($rate) {
                        $rrr = $rate[0]->rate;

                        $sql = "SELECT id from lkt_user_grade where rate <='$rrr' and id='$grade'";
                        $r = $db->select($sql);
                        if (!$r) {
                            $product['canbuy'] = -1;
                        }
                    }
                }
                
            }

            if (!empty($res[0]->brand_id)) {
                $b_id = $res[0]->brand_id; // 品牌id
                // 根据品牌id,查询品牌名称
                $sql01 = "select brand_name from lkt_brand_class where store_id = '$store_id' and brand_id = '$b_id'";
                $r01 = $db->select($sql01);
            }
            if (!empty($r01)) {
                $product['brand_name'] = $r01[0]->brand_name; // 品牌名称
            } else {
                $product['brand_name'] = '无';
            }
            /* 商品结束 */
            /* 评论开始 */
            // 根据商品id、评论表(微信id)与会员表(微信id)相等,查询信息
            $whereStr = '';
            if($_type_ === 'KJ'){
                $whereStr =" and a.oid like 'KJ%'";
            }

            $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.anonymous,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id and a.store_id = m.store_id where a.store_id = '$store_id' and a.pid = '$id'".$whereStr;
            $r_c = $db->select($sql_c);
            $arr = array();
            if($r_c){
                foreach ($r_c as $key => $value) {
                    $attribute_id = $value->attribute_id;
                    $attribute_str = '';

                    $sql_shu = "select attribute from lkt_configure where pid = '$id' and id = '$attribute_id'";
                    $r_shu = $db->select($sql_shu);
                    if($r_shu){
                        $attribute = unserialize($r_shu[0]->attribute);
                        foreach ($attribute as $k => $v){
                            $attribute_str .= $k . ":" . $v . ',';
                        }
                        $attribute_str = rtrim($attribute_str, ',');
                    }
                    $value->attribute_str = $attribute_str;
                    $va = (array)$value;
                    $va['time'] = substr($va['add_time'], 0, 10); // 评论时间
                    //-------------2018-05-03  修改  作用:返回评论图片
                    $comments_id = $va['id']; // 评论id
                    // 根据评论id,查询评论图片表
                    $comments_sql = "select comments_url from lkt_comments_img where comments_id = '$comments_id' ";
                    $comment_res = $db->select($comments_sql);
                    $va['images'] = '';
                    if ($comment_res) {
                        $va['images'] = $comment_res; // 评论图片
                        $array_c = array();
                        foreach ($comment_res as $kc => $vc) {
                            $url = $vc->comments_url; // 评论图片
                            $array_c[$kc] = array('url' => ServerPath::getimgpath($url));
                        }
                        $va['images'] = $array_c;
                    }
                    if ($va['anonymous'] == 1) {
                        $va['user_name'] = '匿名';
                        $va['headimgurl'] = '';
                    }
                    //-------------2018-07-27  修改
                    $ad_sql = "select content from lkt_reply_comments where store_id = '$store_id' and cid = '$comments_id' and uid = 'admin' ";
                    $ad_res = $db->select($ad_sql);
                    if ($ad_res) {
                        $reply_admin = $ad_res[0]->content;
                    } else {
                        $reply_admin = '';
                    }
                    $va['reply'] = $reply_admin;

                    $obj = (object)$va;
                    $arr[$key] = $obj;
                }
            }


            /* 评论结束 */
            /* 属性开始 */
            // 根据商品id,查询商品属性信息
            $sql_size = "select * from lkt_configure where pid = '$id' and recycle = 0";
            $r_size = $db->select($sql_size);
            $skuBeanList = array();
            $attrList = array();
            $num = 0;
            if ($r_size) {

                $attrList = array();
                $a = 0;
                $attr = array();
                foreach ($r_size as $key => $value) {
                    $array_price[$key] = $value->price;
                    $array_yprice[$key] = $value->yprice;
                    $attribute = unserialize($value->attribute);
                    $attnum = 0;
                    $arrayName = array();
                    foreach ($attribute as $k => $v) {
                        if (!in_array($k, $arrayName)) {
                            array_push($arrayName, $k);
                            $kkk = $attnum++;
                            $attrList[$kkk] = array('attrName' => $k, 'attrType' => '1', 'id' => md5($k), 'attr' => array(), 'all' => array());
                        }
                    }
                }

                foreach ($r_size as $key => $value) {
                    $attribute = unserialize($value->attribute);
                    $attributes = array();
                    $num += $value->num;
                    $name = '';
                    foreach ($attribute as $k => $v) {
                        $attributes[] = array('attributeId' => md5($k), 'attributeValId' => md5($v));
                        $name .= $v;
                    }

                    $cimgurl = ServerPath::getimgpath($value->img);
                    $unit = $value->unit;

                    $skuBeanList[$key] = array('name' => $name, 'imgurl' => $cimgurl, 'cid' => $value->id, 'price' => $value->price, 'count' => $value->num, 'unit' => $unit, 'attributes' => $attributes);

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
            }
            $product['num'] = $num; // 数量

            //排序
            asort($array_price);
            asort($array_yprice);
            //获取价格区间并返回
            $qj_price = reset($array_price) == end($array_price) ? reset($array_price) : reset($array_price) . '-' . end($array_price);
            $qj_yprice = reset($array_yprice) == end($array_yprice) ? reset($array_yprice) : reset($array_yprice) . '-' . end($array_yprice);
            // 出售价格
            $cs_price = $r_size[0]->price;

            // 出售数量
            $sql = "select count(id) as count from lkt_bargain_order where bargain_id='$bargain_id' and original_price=0";
            $r = $db->select($sql);
            $cs_num = $r[0]->count;

            $logo = 'http://xiaochengxu.laiketui.com/ceshi/images/logo_40x40.png';

            $Plugin = new Plugin();
            $Plugin_arr1 = $Plugin->front_Plugin($db,$store_id);
            $coupon = new coupon();
            $coupon_status = false;
            $coupon_str = array();
            foreach ($Plugin_arr1 as $k => $v){
                if($k == 'coupon_status' && $v == 1 ){
                    $coupon_list = $coupon->test($store_id);
                    if($coupon_list == 1){
                        $coupon_status = true;
                        $coupon_arr = $coupon->pro_coupon($store_id, $user_id,$id);
                        foreach ($coupon_arr as $k => $v){
                            if($k <= 2){
                                $coupon_str[] = $v['name'];
                            }
                        }
                    }else{
                        $coupon_status = false;
                    }
                }
            }

            // 返回JSON             $skuBeanList = []; $attrList = [];
            $data = array('logo' => $logo, 'pro' => $product, 'shop_list' => $shop_list, 'cs_num' => $cs_num, 'cs_price' => $cs_price, 'qj_price' => $qj_price, 'qj_yprice' => $qj_yprice, 'attrList' => $attrList, 'skuBeanList' => $skuBeanList, 'collection_id' => $collection_id, 'comments' => $arr, 'type' => $type,'access_id'=>$access_id,'login_status'=>$login_status,'active'=>$active,'is_grade'=>$is_grade,'coupon_status'=>$coupon_status,'coupon_str'=>$coupon_str);
            if($_type_=='KJ'){
                $attr_id = trim($request->getParameter('attr_id'));
                $sql = "SELECT min_price from lkt_bargain_order WHERE attr_id = $attr_id and goods_id = $id and bargain_id='$bargain_id'";
                $res__ = $db->select($sql);
                if($res__){
                    $cs_yprice =  $res__[0]->min_price;
                    $data = array('logo' => $logo, 'pro' => $product, 'shop_list' => $shop_list, 'cs_num' => $cs_num,'cs_yprice'=>$cs_yprice, 'cs_price' => $cs_price, 'qj_price' => $qj_price, 'qj_yprice' => $qj_yprice, 'attrList' => $attrList, 'skuBeanList' => $skuBeanList, 'collection_id' => $collection_id, 'comments' => $arr, 'type' => $type,'access_id'=>$access_id,'login_status'=>$login_status,'is_grade'=>$is_grade);
                }
            }else if($_type_ == 'MS'){
                $navType = trim($request->getParameter('navType')); // 活动状态
                $pro_id = trim($request->getParameter('id')); // 活动商品id

                //根据当前时间查询出活动
                $nowdate = date("Y-m-d H:i:s",time());
                $nowdate_ = explode(' ',$nowdate);
                $nowtime = '1970-01-01 '.$nowdate_[1];
                $nowtime1 = $nowdate_[0].' 00:00:00';
                $nowtime2 = $nowdate_[0].' 23:59:59';

                $sel_aec_pro_sql ="SELECT * FROM lkt_seconds_pro WHERE id = $pro_id and store_id = $store_id";
                $seckill_pro_res = $db->select($sel_aec_pro_sql);

                $seckill_activity_id = $seckill_pro_res[0]->activity_id;
                $seckill_time_id = $seckill_pro_res[0]->time_id;
                $p_id = $seckill_pro_res[0]->pro_id;
                //根据当前时间查询出活动时段
                $sel_seckill_time = "select * from lkt_seconds_time where store_id = $store_id and id = $seckill_time_id and is_delete = 0";
                $seckill_time_res = $db->select($sel_seckill_time);
                $seckill_time_endtimet = strtotime($seckill_time_res[0]->endtime);
                $nowtimet = strtotime($nowtime);
                $sel_freightSql = "SELECT f.name ,f.freight ,p.mch_id
                           FROM lkt_product_list as p
                           LEFT JOIN lkt_freight as f on p.freight = f.id
                           WHERE p.id = $p_id";
                $freightRes = $db->select($sel_freightSql);
                $data['pro']['freight_name'] = $freightRes[0]->name;
                $data['pro']['price'] = $seckill_pro_res[0]->seconds_price;
                $data['pro']['max_num'] = $seckill_pro_res[0]->max_num;
                $data['pro']['num'] = $seckill_pro_res[0]->num;


                $data['pro']['content'] =$res[0]->content;

                if($navType == 1){
                    $data['pro']['lefttime'] = $seckill_time_endtimet - $nowtimet;
                }else if ($navType == 2){
                    $sel_seckill_time = "select * from lkt_seconds_time where store_id = $store_id and id = $seckill_time_id  and is_delete = 0 order by starttime";
                    $seckill_time_res = $db->select($sel_seckill_time);
                    if(!empty($seckill_time_res)){
                        $seckill_time_starttimet = strtotime($seckill_time_res[0]->starttime);
                        $data['pro']['lefttime'] = $seckill_time_starttimet - $nowtimet;
                    }else{
                        $sel_seckill_time = "select * from lkt_seconds_time where store_id = $store_id and endtime > '$nowtime'  and is_delete = 0";
                        $seckill_time_res = $db->select($sel_seckill_time);
                        $seckill_time_endtimet = strtotime($seckill_time_res[0]->endtime);
                        $data['pro']['lefttime'] = $seckill_time_endtimet - $nowtimet;
                    }
                }else{
                    $sel_seckill_time = "select * from lkt_seconds_time where store_id = $store_id and starttime > '$nowtime'  and is_delete = 0";
                    $seckill_time_res = $db->select($sel_seckill_time);
                    $seckill_time_starttimet = strtotime($seckill_time_res[0]->starttime);
                    $data['pro']['lefttime'] = $seckill_time_starttimet - $nowtimet +3600*24;
                }

                //查询秒杀设置
                $sel_seckill_config = "select * from lkt_seconds_config where store_id = $store_id";
                $seckill_config = $db->select($sel_seckill_config);
                if(!empty($seckill_config)){
                    $data['pro']['rule'] =$seckill_config[0]->rule;

                    if($seckill_config[0]->buy_num == 0){
                        $data['pro']['buy_num'] = 99999999;
                    }else{
                        $data['pro']['buy_num'] = $seckill_config[0]->buy_num;

                        //查询已经购买了几个商品
                        $sql_ac1 = "SELECT
                            sr.*
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
                        AND sr.pro_id = $id
                        AND sr.add_time >= '$nowtime1'
                        AND sr.add_time <= '$nowtime2'
                        AND o.status != 6
                        AND o.status != 0";
                        $ac1_res = $db->select($sql_ac1);
                        if (!empty($ac1_res)){
                            $p_num = 0;
                            foreach ($ac1_res as $k1 => $v1){
                                $p_num_ = $v1->num;
                                $p_num = $p_num + 0 + $p_num_;
                            }
                            $data['pro']['purchased'] = $p_num;

                        }else{
                            $data['pro']['purchased'] = 0;
                        }
                    }

                }else{
                    echo json_encode(array('code' => 500,  'message' => '没有配置秒杀设置！'));
                }
            }
            echo json_encode(array('code' => 200, 'data' => $data, 'message' => '成功'));
            exit();
        }
    }

    // 添加购物车
    public function add_cart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $Goods_id = trim($request->getParameter('pro_id')); // 商品id
        $Goods_num = trim($request->getParameter('num')); // 数量
        $attribute_id = trim($request->getParameter('attribute_id')); // 商品属性id
        $type = $request->getParameter('type'); // 类型

        if (empty($Goods_id) || empty($attribute_id)) {
            echo json_encode(array('code' => 109, 'message' => '参数错误'));
        } else {
            if(empty($access_id)){
                // 生成密钥
                $access_id = Tools::getToken();
            }else{
                $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                if($getPayload_test == false){
                    // 过期重新生成一个，不需要做登录提示。
                    $access_id = Tools::getToken();
                }else{
                    // 根据授权id,查询用户信息
                    $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
                    $r = $db->select($sql);
                    if($r){
                        $user_id = $r[0]->user_id; // 用户id
                    }
                }
            }


            // 根据商品属性id,查询商品数量
            $sql_k = "select num from lkt_configure where id = '$attribute_id'";
            $res_k = $db->select($sql_k);
            $num = $res_k[0]->num; // 商品数量
            if ($num >= $Goods_num) {
                if(empty($user_id)){ // 当用户ID不存在时
                    // 根据商城ID、token、商品ID、属性ID，查询购物车信息
                    $sql_c = "select id,Goods_num from lkt_cart where store_id = '$store_id' and token = '$access_id' and Goods_id = '$Goods_id' and Size_id = '$attribute_id'";
                    $r0 = $db->select($sql_c);
                    if($r0){ // 存在
                        $Goods_num1 = $r0[0]->Goods_num;
                        if($Goods_num + $Goods_num1 > $num){
                            $sql_u = "update lkt_cart set Goods_num = '$num' where store_id = '$store_id' and token = '$access_id' and Goods_id = '$Goods_id' and Size_id = '$attribute_id'";
                        }else{
                            $sql_u = "update lkt_cart set Goods_num = Goods_num + '$Goods_num' where store_id = '$store_id' and token = '$access_id' and Goods_id = '$Goods_id' and Size_id = '$attribute_id'";
                        }
                        $db->update($sql_u);
                        echo json_encode(array('code'=>200,'data'=>array('cart_id'=>$r0['0']->id,'type'=>$type,'access_id'=>$access_id),'message'=>'成功'));
                        exit;
                    }else{
                        $sql = "insert into lkt_cart (store_id,token,Goods_id,Goods_num,Create_time,Size_id) values('$store_id','$access_id','$Goods_id','$Goods_num',CURRENT_TIMESTAMP,$attribute_id) ";
                        $r = $db -> insert($sql,'last_insert_id');
                        if($r){
                            echo json_encode(array('code'=>200,'data'=>array('cart_id'=>$r,'type'=>$type,'access_id'=>$access_id),'message'=>'成功'));
                        }else{
                            echo json_encode(array('code'=>110,'message'=>'业务异常'));
                        }
                    }
                }else{
                    // 查询购物车是否有过改商品，有则修改 无则新增
                    $sql_c = "select Goods_num,id from lkt_cart where store_id = '$store_id' and user_id = '$user_id' and Goods_id = '$Goods_id' and Size_id = '$attribute_id'";
                    $res = $db->select($sql_c);
                    if ($res) {
                        if($type == 'addcart'){ // 当类型为添加时
                            $Goods_num1 = $res[0]->Goods_num;
                            if($Goods_num + $Goods_num1 > $num){
                                $sql_u = "update lkt_cart set Goods_num = '$num' where store_id = '$store_id' and user_id = '$user_id' and Goods_id = '$Goods_id' and Size_id = '$attribute_id'";
                            }else{
                                $sql_u = "update lkt_cart set Goods_num = Goods_num + '$Goods_num' where store_id = '$store_id' and user_id = '$user_id' and Goods_id = '$Goods_id' and Size_id = '$attribute_id'";
                            }
                            // 根据用户id、微信id、商品id、属性id，修改购物车数量
                        }else if($type == 'immediately'){
                            // 根据用户id、微信id、商品id、属性id，修改购物车数量
                            $sql_u = "update lkt_cart set Goods_num = '$Goods_num' where store_id = '$store_id' and user_id = '$user_id' and Goods_id = '$Goods_id' and Size_id = '$attribute_id'";
                        }
                        $r_u = $db->update($sql_u);

                        echo json_encode(array('code'=>200,'data'=>array('cart_id'=>$res['0']->id,'type'=>$type,'access_id'=>$access_id),'message'=>'成功'));
                    }else{
                        $sql = "insert into lkt_cart (store_id,token,user_id,Goods_id,Goods_num,Create_time,Size_id) values('$store_id','$access_id','$user_id','$Goods_id','$Goods_num',CURRENT_TIMESTAMP,$attribute_id) ";
                        $r = $db -> insert($sql,'last_insert_id');
                        if($r){
                            echo json_encode(array('code'=>200,'data'=>array('cart_id'=>$r,'type'=>$type,'access_id'=>$access_id),'message'=>'成功'));
                        }else{
                            echo json_encode(array('code'=>110,'message'=>'业务异常'));
                        }
                    }
                }
            } else {
                echo json_encode(array('code' => 105, 'message' => '库存不足！'));
            }
        }
        exit;
    }
    // 添加购物车
    public function immediately_cart()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $product1 = addslashes($request->getParameter('product'));//  商品数组--------['pid'=>66,'cid'=>88]
        $product = '';
        $cart_id = '';
        if ($product1 != '') {
            $product1 = htmlspecialchars_decode($product1);
            $product2 = json_decode($product1); // 字符串打散为数组
            foreach ($product2 as $k => $v) {
                foreach ($v as $ke => $va) {
                    $product3[$ke] = $va;
                }
            }
            $product = implode(',', $product3);

        }
        $products = Tools::products_list($db, $store_id, $cart_id, $product);
        echo json_encode(array('code' => 200, 'message' => '操作成功'));
        exit();
    }


    // 生成订单号
    private function order_number()
    {
        return date('Ymd', time()) . time() . rand(10, 99);//18位
    }

    // 发送评论数据
    public function comment()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $type = $request->getParameter('type'); // 类型
//        $order_id = trim($request->getParameter('order_id')); // 订单id
        $access_id = $request->getParameter('access_id'); // 授权id
        $order_details_id = trim($request->getParameter('order_details_id')); // 订单详情id
        $num = trim($request->getParameter('num')); //选择类型
//        $attribute_id = trim($request->getParameter('attribute_id')); // 属性id

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if (!empty($r)) {
            $status = $type == '' ? 3 : 5;

//            if ($num == 'all') {
//                $sql = "select sNo from lkt_order where store_id = '$store_id' and id = '$order_id'";
//                $rr = $db->select($sql);
//                $sNo = $rr[0]->sNo;
//                $sql_o = "select a.p_id as commodityId,m.img,a.size,a.sid from lkt_order_details AS a LEFT JOIN lkt_configure AS m ON a.sid = m.id  where a.store_id = '$store_id' and a.r_sNo = '$sNo' and a.r_status in($status,-1)";
//                $r_o = $db->select($sql_o);
//            } else {
//                $sql_o = "select a.p_id as commodityId,m.img,a.size,a.sid from lkt_order_details AS a LEFT JOIN lkt_configure AS m ON a.sid = m.id  where a.store_id = '$store_id' and a.id = '$order_id' and a.r_status in($status,-1)";
//                $r_o = $db->select($sql_o);
//            }
            $sql_o = "select a.p_id as commodityId,m.img,a.size,a.sid 
                        from lkt_order_details AS a 
                        LEFT JOIN lkt_configure AS m ON a.sid = m.id  
                        where a.store_id = '$store_id' and a.id = '$order_details_id' and a.r_status in($status,-1)";
            $r_o = $db->select($sql_o);

            if ($r_o) {
                foreach ($r_o as $key => $value) {
                    $arr = (array)$value;
                    $sql = "select product_title from lkt_product_list where store_id = '$store_id' and id = " . $value->commodityId;
                    $r = $db->select($sql);
                    $arr['product_title'] = $r[0]->product_title;
                    $imgurl = $arr['img'];/* end 保存*/
                    $arr['commodityIcon'] = ServerPath::getimgpath($imgurl);
                    $obj = (object)$arr;
                    $res[$key] = $obj;
                }
                echo json_encode(array('code' => 200, 'commentList' => $res, 'message' => '成功！'));
                exit();
            } else {
                echo json_encode(array('code' => 200, 'commentList' => array(), 'message' => '成功！'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit();
        }
    }

    function base64_image_content($base64_image_content, $path)
    {
        // 匹配出图片的格式
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
    // 添加图片
    public function img_comment()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = $request->getParameter('access_id'); // 授权id
        $comment_id = $request->getParameter('cid'); // 评论ID
        $call_num = addslashes(trim($request->getParameter('upload_num'))); // 接口调用次数
        $for_num = addslashes(trim($request->getParameter('upload_z_num'))); // 接口调用总次数
        if (empty($access_id)) {
            echo json_encode(array('code' => 116, 'message' => '未授权！'));
            exit();
        }
        $Tools = new Tools($db, $store_id, 1);
        $image_arr = array();
        $image_array = array();
        // 根据access_id,查询用户id
        $sql = "select user_id,user_name from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if (!empty($r)) {
            $user_id = $r[0]->user_id;
            $sql_c = "select id,oid from lkt_comments where id = '$comment_id'";
            $r_c = $db->select($sql_c);
            if ($r_c) {
                // 查询配置表信息
                $sql = "select * from lkt_config where store_id = '$store_id'";
                $r = $db->select($sql);
                $uploadImg = $r[0]->uploadImg;
                $uploadImg_domain = $r[0]->uploadImg_domain;
                $upserver = !empty($r)?$r[0]->upserver:'2';   //如果没有设置配置则默认用阿里云

                if(!empty($_FILES)){ // 如果图片不为空
                    if($upserver == '2'){
                        $image = ServerPath::file_OSSupload($store_id, $store_type);
                    }else{
                        $image = ServerPath::file_upload($store_id,$uploadImg,$uploadImg_domain,$store_type);
                    }
                    if($image == false){
                        echo json_encode(array('code' => 109,'message'=>'上传失败或图片格式错误！'));
                        exit;
                    }else{
                        $image = preg_replace('/.*\//', '', $image);
                    }
                    $image_arr1 = array('image'=>$image,'call_num'=>$call_num); // 图片数组

                    $cache = array('user_id'=>$user_id,'comment_id'=>$comment_id,'image_arr'=>$image_arr1); // 缓存数组
                }else{
                    echo json_encode(array('code' => 109, 'message' => '参数错误'));
                    exit;
                }
                if($call_num + 1 != $for_num){ // 当前调用接口次数 不等于 总调用接口次数

                    $res = $Tools->generate_session($db,$cache,3);

                    echo json_encode(array('code' => 200,'comment_id'=>$comment_id,'message' => '成功！'));
                    exit;
                }else{
                    $rew = $Tools->obtain_session($db,$user_id,3,$comment_id);
                    if($rew != ''){
                        $image_arr2 = json_decode($rew,true);
                        if (count($image_arr2) == count($image_arr2, 1)) {
                            $image_arr[] = $image_arr2;
                            $image_arr[] = $image_arr1;
                        } else {
                            foreach ($image_arr2 as $k => $v){
                                $image_arr[] = (array)$v;
                            }
                            array_push($image_arr,$image_arr1);
                        }
                    }else{
                        $image_arr[] = $image_arr1;
                    }
                    foreach ($image_arr as $ke => $va){
                        $image_array[$ke] = $va['image'];
                    }
                }
                //进入正式添加---开启事物
                $db->begin();
                foreach ($image_array as $k => $v){
                    $sql = "insert into lkt_comments_img(comments_url,comments_id,add_time) VALUES ('$v','$comment_id',CURRENT_TIMESTAMP)";
                    $res = $db->insert($sql);
                    if ($res == -1) {
                        $db->rollback();
                        echo json_encode(array('code' => 110,'message'=>'业务异常！'));
                        exit;
                    }
                }
                $db->commit();

                $res = $Tools->del_session($db,$user_id,3,$comment_id);

                echo json_encode(array('code' => 200,'message' => '成功！'));
                exit();
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误2'));
                exit();
            }


        } else {
            echo json_encode(array('code' => 109, 'message' => '参数错误3'));
            exit();
        }
    }
    // 添加评论
    public function add_comment()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = $request->getParameter('access_id'); // 授权id
        $anonymous = $request->getParameter('anonymous'); // 是否匿名
//        $order_id = $request->getParameter('orderid'); // 订单id
        $order_details_id = trim($request->getParameter('order_details_id')); // 订单详情id
//        $type = $request->getParameter('type'); // 类型
        $start = $request->getParameter('start'); // 星级
        $comment = $request->getParameter('comment'); // 内容
        $goodsId = $request->getParameter('goodsId'); // 产品id
        $attribute_id = $request->getParameter('attributeId'); // 属性id
//        $num = trim($request->getParameter('num')); //选择类型

        if (empty($access_id)) {
            echo json_encode(array('code' => 116, 'message' => '未授权！'));
            exit();
        }

        // 根据access_id,查询用户id
        $sql = "select user_id,user_name from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if (!empty($r)) {
            $user_id = $r[0]->user_id;

//            if ($num == 'all') {
//                $sql = "select sNo from lkt_order where store_id = '$store_id' and id = '$order_id' and user_id = '$user_id'";
//            } else {
//                $sql = "select r_sNo as sNo from lkt_order_details where store_id = '$store_id' and id = '$order_id' and user_id = '$user_id'";
//            }
            $sql = "select r_sNo as sNo from lkt_order_details where store_id = '$store_id' and id = '$order_details_id' and user_id = '$user_id'";
            $rr = $db->select($sql);

            //进入正式添加---开启事物
            $db->begin();

            if ($rr) {
                $sNo = $rr[0]->sNo; // 订单号
                //敏感词表
                require('badword.src.php');
                $sql_c = "select id,oid from lkt_comments where store_id = '$store_id' and oid = '$sNo' and pid = '$goodsId' and attribute_id = '$attribute_id' ";
                $r_c = $db->select($sql_c);
//                if ($type == 1) {
//                    //追评
//                    $time = date("Y-m-d H:i:s");
//                    if ($comment != '') {
//                        $sql = "update lkt_comments set review = '$comment',review_time = '$time' where store_id = '$store_id' and oid = '$sNo' and pid = '$goodsId' and attribute_id = '$attribute_id'";
//                        $r_1 = $db->update($sql);
//                        if ($r_1 > 0) {
//                            $sql_f = "update lkt_order_details set r_status = 12 where store_id = '$store_id' and r_sNo = '$sNo' and sid = '$attribute_id'";
//                            $r_f = $db->update($sql_f);
//                            if ($r_f < 0) {
//                                echo json_encode(array('code' => 110, 'message' => '业务异常1!'));
//                                exit();
//                            }
//                        }
//                    }
//
//                    $cid = $r_c[0]->id;
//                    $sql = "select r_status from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
//                    $rr = $db->select($sql);
//                    if ($rr) {
//                        foreach ($rr as $k1 => $v1) {
//                            $r_status[] = $v1->r_status;
//                        }
//                        $arr = array_count_values($r_status);
//                        $num = 0;
//                        if (!empty($arr[4])) {
//                            $num += $arr[4];
//                        }
//                        if (!empty($arr[12])) {
//                            $num += $arr[12];
//                        }
//                        if ($num == count($rr)) {
//                            $sql = "update lkt_order set status = 12 where store_id = '$store_id' and sNo = '$sNo'";
//                            $db->update($sql);
//                        }
//                    }
//                } else {
                    //没有评价
                    if ($comment != '' && empty($r_c)) {
                        //评论表里没有此条记录且用户提交的内容或图片不为空
                        $badword1 = array_combine($badword, array_fill(0, count($badword), '*'));
                        $content = preg_replace("/\s(?=\s)/", "\\1", $this->strtr_array($comment, $badword1));
                        $sql_d = 'insert into lkt_comments(store_id,oid,uid,pid,attribute_id,content,CommentType,anonymous,add_time) VALUES ' . "('$store_id','$sNo','$user_id','$goodsId','$attribute_id','$comment','$start','$anonymous',CURRENT_TIMESTAMP)";
                        $cid = $db->insert($sql_d, 'last_insert_id');

                        if ($cid > 0) {
                            $sql_f = "update lkt_order_details set r_status = 5 where store_id = '$store_id' and r_sNo = '$sNo' and sid = '$attribute_id'";
                            $r_f = $db->update($sql_f);
                            if ($r_f < 0) {
                                $db->rollback();
                                echo json_encode(array('code' => 110, 'message' => '业务异常!'));
                                exit();
                            }
                        } else {
                            $db->rollback();
                            echo json_encode(array('code' => 110, 'message' => '业务异常!'));
                            exit();
                        }

                    }
                    if (!empty($r_c)) {
                        $cid = $r_c[0]->id;
                    }

                    $sql = "select r_status from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                    $rr = $db->select($sql);
                    if ($rr) {
                        //判断是否需要修改整笔订单状态
                        $r_status = array();
                        foreach ($rr as $k1 => $v1) {
                            $r_status[] = $v1->r_status;
                        }
                        $arr = array_count_values($r_status);
                        $arr_num = 0;
                        if (!empty($arr[4])) {
                            $arr_num += $arr[4];
                        }
                        if (!empty($arr[5])) {
                            $arr_num += $arr[5];
                        }
                        if (!empty($arr[6])) {
                            $arr_num += $arr[6];
                        }
                        if ($arr_num == count($rr)) {
                            $sql1 = "update lkt_order set status = 5 where store_id = '$store_id' and sNo = '$sNo'";
                            $r1 = $db->update($sql1);
                            if($r1 == -1){
                                $db->rollback();
                                echo json_encode(array('code' => 110, 'message' => '业务异常!'));
                                exit();
                            }
                        }
                    }
//                }
                $db->commit();

                echo json_encode(array('code' => 200, 'cid' => $cid, 'message' => '成功!'));
                exit();
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误1'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit();
        }
    }
    // 追加评论
    public function t_comment()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = $request->getParameter('access_id'); // 授权id
        $anonymous = $request->getParameter('anonymous'); // 是否匿名
//        $order_id = $request->getParameter('orderid'); // 订单id
        $order_details_id = trim($request->getParameter('order_details_id')); // 订单详情id
//        $type = $request->getParameter('type'); // 类型
        $start = $request->getParameter('start'); // 星级
        $comment = $request->getParameter('comment'); // 内容
        $goodsId = $request->getParameter('goodsId'); // 产品id
        $attribute_id = $request->getParameter('attributeId'); // 属性id
//        $num = trim($request->getParameter('num')); //选择类型
        $call_num = addslashes(trim($request->getParameter('upload_num'))); // 接口调用次数
        $for_num = addslashes(trim($request->getParameter('upload_z_num'))); // 接口调用总次数
        if (empty($access_id)) {
            echo json_encode(array('code' => 116, 'message' => '未授权！'));
            exit();
        }

        $Tools = new Tools($db, $store_id, 1);
        $image_arr = array();
        $image_array = array();
        // 根据微信id,查询用户id
        $sql = "select user_id,user_name from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if (!empty($r)) {
            $user_id = $r[0]->user_id;

//            if ($num == 'all') {
//                $sql = "select sNo from lkt_order where store_id = '$store_id' and id = '$order_id' and user_id = '$user_id'";
//            } else {
//                $sql = "select r_sNo as sNo from lkt_order_details where store_id = '$store_id' and id = '$order_id' and user_id = '$user_id'";
//            }
            $sql = "select r_sNo as sNo from lkt_order_details where store_id = '$store_id' and id = '$order_details_id' and user_id = '$user_id'";
            $rr = $db->select($sql);

            if ($rr) {
                $sNo = $rr[0]->sNo; // 订单号
                // 查询配置表信息
                $sql = "select * from lkt_config where store_id = '$store_id'";
                $r = $db->select($sql);
                $uploadImg = $r[0]->uploadImg;
                $uploadImg_domain = $r[0]->uploadImg_domain;
                $upserver = !empty($r)?$r[0]->upserver:'2';   //如果没有设置配置则默认用阿里云

                //敏感词表
                require('badword.src.php');

                $sql_c = "select id,oid from lkt_comments where store_id = '$store_id' and oid = '$sNo' and pid = '$goodsId' and attribute_id = '$attribute_id' ";
                $r_c = $db->select($sql_c);
                $r_d = $r_c[0]->id;

                if($for_num){
                    if(!empty($_FILES)){ // 如果图片不为空
                        if($upserver == '2'){
                            $image = ServerPath::file_OSSupload($store_id, $store_type);
                        }else{
                            $image = ServerPath::file_upload($store_id,$uploadImg,$uploadImg_domain,$store_type);
                        }
                        if($image == false){
                            echo json_encode(array('code' => 109,'message'=>'上传失败或图片格式错误！'));
                            exit;
                        }else{
                            $image = preg_replace('/.*\//', '', $image);
                        }
                        $image_arr1 = array('image'=>$image,'call_num'=>$call_num); // 图片数组

                        $cache = array('user_id'=>$user_id,'comment_id'=>$r_d,'image_arr'=>$image_arr1); // 缓存数组
                    }else{
                        echo json_encode(array('code' => 109, 'message' => '参数错误'));
                        exit;
                    }
                    if($call_num + 1 != $for_num){ // 当前调用接口次数 不等于 总调用接口次数

                        $res = $Tools->generate_session($db,$cache,3);

                        echo json_encode(array('code' => 200,'comment_id'=>$r_d,'message' => '成功！'));
                        exit;
                    }else{
                        $rew = $Tools->obtain_session($db,$user_id,3,$r_d);
                        if($rew != ''){
                            $image_arr2 = json_decode($rew,true);
                            if (count($image_arr2) == count($image_arr2, 1)) {
                                $image_arr[] = $image_arr2;
                                $image_arr[] = $image_arr1;
                            } else {
                                foreach ($image_arr2 as $k => $v){
                                    $image_arr[] = (array)$v;
                                }
                                array_push($image_arr,$image_arr1);
                            }
                        }else{
                            $image_arr[] = $image_arr1;
                        }
                        foreach ($image_arr as $ke => $va){
                            $image_array[$ke] = $va['image'];
                        }
                    }
                }
                //进入正式添加---开启事物
                $db->begin();

//                if ($type == 1) {
                    //追评
                    $time = date("Y-m-d H:i:s");
//                    if ($comment != '' || !empty($_FILES)) {
                        $sql = "update lkt_comments set review = '$comment',review_time = '$time' where store_id = '$store_id' and oid = '$sNo' and pid = '$goodsId' and attribute_id = '$attribute_id'";
                        $r_1 = $db->update($sql);
                        if ($r_1 > 0) {
                            $sql_f = "update lkt_order_details set r_status = 12 where store_id = '$store_id' and r_sNo = '$sNo' and sid = '$attribute_id'";
                            $r_f = $db->update($sql_f);
                            if ($r_f < 0) {
                                $db->rollback();
                                echo json_encode(array('code' => 110, 'message' => '业务异常!'));
                                exit();
                            }
                        }else{
                            $db->rollback();
                            echo json_encode(array('code' => 110, 'message' => '业务异常!'));
                            exit();
                        }
//                    }

//                    if (!empty($_FILES)) {          //如果图片不为空
//                        if ($upserver == '2') {
//                            $imgURL_name = ServerPath::file_OSSupload($store_id, $store_type);
//                        } else {
//                            $imgURL_name = ServerPath::file_upload($store_id, $uploadImg, $uploadImg_domain, $store_type);
//                        }
//                        if ($imgURL_name != false) {       //图片上传成功
//                            $sql = "insert into lkt_comments_img(comments_url,comments_id,type,add_time) VALUES ('$imgURL_name','$r_d','1',CURRENT_TIMESTAMP)";
//                            $res = $db->insert($sql);
//                        }
//
//                    }
                if(count($image_array) != 0){
                    foreach ($image_array as $k => $v){
                        $sql = "insert into lkt_comments_img(comments_url,comments_id,type,add_time) VALUES ('$v','$r_d','1',CURRENT_TIMESTAMP)";
                        $res = $db->insert($sql);
                        if ($res == -1) {
                            $db->rollback();
                            echo json_encode(array('code' => 110,'message'=>'业务异常！'));
                            exit;
                        }
                    }
                }

                    $sql = "select r_status from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                    $rr = $db->select($sql);
                    if ($rr) {
                        foreach ($rr as $k1 => $v1) {
                            $r_status[] = $v1->r_status;
                        }
                        $arr = array_count_values($r_status);
                        $num = 0;
                        if (!empty($arr[4])) {
                            $num += $arr[4];
                        }
                        if (!empty($arr[12])) {
                            $num += $arr[12];
                        }
                        if ($num == count($rr)) {
                            $sql1 = "update lkt_order set status = 12 where store_id = '$store_id' and sNo = '$sNo'";
                            $r1 = $db->update($sql1);
                            if($r1 == -1){
                                $db->rollback();
                                echo json_encode(array('code' => 110, 'message' => '业务异常!'));
                                exit();
                            }
                        }
                    }

                $db->commit();
                $res = $Tools->del_session($db,$user_id,3,$r_d);
//                    echo json_encode(array('code' => 200, 'message' => '成功'));
//                    exit();

//                } else {
//                    //没有评价
//                    if (($comment != '' || !empty($_FILES)) && empty($r_c)) {     //评论表里没有此条记录且用户提交的内容或图片不为空
//                        $badword1 = array_combine($badword, array_fill(0, count($badword), '*'));
//                        $content = preg_replace("/\s(?=\s)/", "\\1", $this->strtr_array($comment, $badword1));
//                        $sql_d = 'insert into lkt_comments(store_id,oid,uid,pid,attribute_id,content,CommentType,anonymous,add_time) VALUES ' . "('$store_id','$sNo','$user_id','$goodsId','$attribute_id','$comment','$start','$anonymous',CURRENT_TIMESTAMP)";
//                        $r_d = $db->insert($sql_d, 'last_insert_id');
//
//                        if ($r_d > 0) {
//                            $sql_f = "update lkt_order_details set r_status = 5 where store_id = '$store_id' and r_sNo = '$sNo' and sid = '$attribute_id'";
//                            $r_f = $db->update($sql_f);
//                            if ($r_f < 0) {
//                                echo json_encode(array('code' => 110, 'message' => '业务异常3!'));
//                                exit();
//                            }
//                        } else {
//                            echo json_encode(array('code' => 110, 'message' => '业务异常4!'));
//                            exit();
//                        }
//
//                    }
//                    if (!empty($r_c)) {
//                        $r_d = $r_c[0]->id;
//                    }
//                    if (!empty($_FILES)) {          //如果图片不为空
//                        if ($upserver == '2') {
//                            $imgURL_name = ServerPath::file_OSSupload($store_id, $store_type);
//                        } else {
//                            $imgURL_name = ServerPath::file_upload($store_id, $uploadImg, $uploadImg_domain, $store_type);
//                        }
//
//                        if ($imgURL_name != false) {       //图片上传成功
//                            $sql = "insert into lkt_comments_img(comments_url,comments_id,add_time) VALUES ('$imgURL_name','$r_d',CURRENT_TIMESTAMP)";
//                            $res = $db->insert($sql);
//                        }
//                    }
//
//                    if (!empty($r_c)) {
//                        $cid = $r_c[0]->id;
//                    }
//
//                    $sql = "select r_status from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
//                    $rr = $db->select($sql);
//                    if ($rr) {
//                        //判断是否需要修改整笔订单状态
//                        $r_status = array();
//                        foreach ($rr as $k1 => $v1) {
//                            $r_status[] = $v1->r_status;
//                        }
//                        $arr = array_count_values($r_status);
//                        $arr_num = 0;
//                        if (!empty($arr[4])) {
//                            $arr_num += $arr[4];
//                        }
//                        if (!empty($arr[5])) {
//                            $arr_num += $arr[5];
//                        }
//                        if (!empty($arr[6])) {
//                            $arr_num += $arr[6];
//                        }
//                        if ($arr_num == count($rr)) {
//                            $sql = "update lkt_order set status = 5 where store_id = '$store_id' and sNo = '$sNo'";
//                            $db->update($sql);
//                        }
//                    }
//
//                }

                echo json_encode(array('code' => 200, 'message' => '成功!'));
                exit();
            } else {
                echo json_encode(array('code' => 109, 'message' => '参数错误1'));
                exit();
            }
        } else {
            echo json_encode(array('code' => 115, 'message' => '非法入侵！'));
            exit();
        }
    }

    //替换
    function strtr_array($str, $replace_arr)
    {
        $maxlen = 0;
        $minlen = 1024 * 128;
        if (empty($replace_arr)) return $str;
        foreach ($replace_arr as $k => $v) {
            $len = strlen($k);
            if ($len < 1) continue;
            if ($len > $maxlen) $maxlen = $len;
            if ($len < $minlen) $minlen = $len;
        }
        $len = strlen($str);
        $pos = 0;
        $result = '';
        while ($pos < $len) {
            if ($pos + $maxlen > $len) $maxlen = $len - $pos;
            $found = false;
            $key = '';
            for ($i = 0; $i < $maxlen; ++$i) $key .= $str[$i + $pos];
            for ($i = $maxlen; $i >= $minlen; --$i) {
                $key1 = substr($key, 0, $i);
                if (isset($replace_arr[$key1])) {
                    $result .= $replace_arr[$key1];
                    $pos += $i;
                    $found = true;
                    break;
                }
            }
            if (!$found) $result .= $str[$pos++];
        }
        return $result;
    }

    // 评价详情显示
    public function getcomment()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $pid = $request->getParameter('pid'); // 商品id
        $type = $request->getParameter('type'); // 类型
        $isbargain = $request->getParameter('bargain'); // 类型

        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
        if (strpos($uploadImg, '../') === false) { // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        } else { // 不存在
            $img = $uploadImg_domain . substr($uploadImg, 2); // 图片路径
        }

        $whereStr = " and a.type != 'KJ'";
        $whereStr1 = " and type != 'KJ'";
        if($isbargain == 'true'){
            $whereStr = " and a.oid like 'KJ%'";
            $whereStr1 = " and oid like 'KJ%'";
        }
        if ($pid) {
            $sql = "select id,CommentType from lkt_comments where store_id = '$store_id' and pid = '$pid' ".$whereStr1."order by add_time desc ";
            $r = $db->select($sql);

            $comments_total = 0;
            $comments_hao = 0;
            $comments_zhong = 0;
            $comments_cha = 0;
            $comments_image = 0;
            if ($r) {
                $comments_total = count($r);
                foreach ($r as $k => $v) {
                    if ($v->CommentType == 1 || $v->CommentType == 2 || $v->CommentType == 'bad') {
                        $comments_cha++;
                    } else if ($v->CommentType == 3 || $v->CommentType == 'NOTBAD') {
                        $comments_zhong++;
                    } else if ($v->CommentType == 4 || $v->CommentType == 5 || $v->CommentType == 'GOOD') {
                        $comments_hao++;
                    }
                    $sql = "select id from lkt_comments_img where comments_id = '$v->id' ";
                    $rr = $db->select($sql);
                    if ($rr) {
                        $comments_image++;
                    }
                }
            }


            if ($type == 0) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.anonymous,a.review,a.review_time,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id and a.store_id = m.store_id where a.store_id = '$store_id' and a.pid = '$pid' $whereStr order by add_time desc limit 10";
            } else if ($type == 1) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.anonymous,a.review,a.review_time,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id and a.store_id = m.store_id where a.store_id = '$store_id' $whereStr and a.pid = '$pid' and CommentType = 4 or a.pid = '$pid' and CommentType = 5 or a.pid = '$pid' and CommentType='GOOD' order by add_time desc limit 10";
            } else if ($type == 2) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.anonymous,a.review,a.review_time,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id and a.store_id = m.store_id where a.store_id = '$store_id' and a.pid = '$pid' and CommentType = 3 or a.pid = '$pid' and CommentType='NOTBAD' $whereStr order by add_time desc limit 10";
            } else if ($type == 3) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.anonymous,a.review,a.review_time,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id and a.store_id = m.store_id where a.store_id = '$store_id' and a.pid = '$pid' and CommentType = 1 or a.pid = '$pid' and CommentType = 2 or a.pid = '$pid' and CommentType='bad' $whereStr order by add_time desc limit 10";
            } else if ($type == 4) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.anonymous,a.review,a.review_time,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.user_id and a.store_id = m.store_id where a.store_id = '$store_id' and a.pid = '$pid' and (a.id in (select comments_id from lkt_comments_img where comments_id = a.id)) $whereStr order by add_time desc limit 10";
            }
            $r_c = $db->select($sql_c);
            $arr = [];
                if($r_c){
                    foreach ($r_c as $key => $value) {
                        $pid = $value->pid;
                        $attribute_id = $value->attribute_id;
                        $attribute_str = '';

                        $sql_shu = "select attribute from lkt_configure where pid = '$pid' and id = '$attribute_id'";
                        $r_shu = $db->select($sql_shu);
                        if($r_shu){
                            $attribute = unserialize($r_shu[0]->attribute);
                            foreach ($attribute as $k => $v){
                                $attribute_str .= $v . ',';
                            }
                            $attribute_str = rtrim($attribute_str, ',');
                        }
                        $value->attribute_str = $attribute_str;
                        $va = (array)$value;
                        $va['time'] = substr($va['add_time'], 0, 10); // 评论时间
                        if ($va['CommentType'] == 'bad') {
                            $va['CommentType'] = 2;
                        } else if ($va['CommentType'] == 'NOTBAD') {
                            $va['CommentType'] = 3;
                        } else if ($va['CommentType'] == 'GOOD') {
                            $va['CommentType'] = 5;
                        }
                        if ($va['anonymous'] == 1) {
                            $va['user_name'] = '匿名';
                        } else {
                            $va['user_name'] = $value->user_name;
                        }
                        //-------------2018-05-03  修改  作用:返回评论图片
                        $comments_id = $va['id']; // 评论id
                        // 根据评论id,查询评论图片表
                        $comments_sql = "select * from lkt_comments_img where comments_id = '$comments_id' ";
                        $comment_res = $db->select($comments_sql);
                        $va['images'] = '';
                        if ($comment_res) {
                            $array_c = [];
                            $array_d = [];
                            foreach ($comment_res as $kc => $vc) {
                                if ($vc->type == 0) {
                                    $url = $vc->comments_url; // 评论图片
                                    $array_c[] = array('url' => ServerPath::getimgpath($url));
                                } else {
                                    $url = $vc->comments_url; // 评论图片
                                    $array_d[] = array('url' => ServerPath::getimgpath($url));
                                }
                            }
                            $va['images'] = $array_c;
                            $va['review_images'] = $array_d;
                        }

                        //-------------2018-05-03  修改
                        $ad_sql = "select content from lkt_reply_comments where store_id = '$store_id' and cid = '$comments_id' and uid = 'admin' ";
                        $ad_res = $db->select($ad_sql);
                        if ($ad_res) {
                            $reply_admin = $ad_res[0]->content;
                        } else {
                            $reply_admin = '';
                        }
                        $va['reply'] = $reply_admin;

                        $obj = (object)$va;
                        $arr[$key] = $obj;
                    }
                }
            echo json_encode(array('code' => 200, 'data' => $arr, 'comments_total' => $comments_total, 'comments_hao' => $comments_hao, 'comments_zhong' => $comments_zhong, 'comments_cha' => $comments_cha, 'comments_image' => $comments_image, 'message' => '成功'));
            exit();
        } else {
            echo json_encode(array('code' => 109, 'message' => '参数错误'));
            exit;
        }

    }

    // 评价详情显示-加载
    public function load_getcomment()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $pid = $request->getParameter('pid'); // 商品id
        $type = $request->getParameter('type'); // 类型
        $num = trim($request->getParameter('page')); // 加载次数
        if (!$num) {
            $num = 1;
        }
        $start = $num * 10;
        $end = 10;

        if ($pid) {
            if ($type == 0) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.wx_id where a.store_id = '$store_id' and a.pid = '$pid' order by add_time desc limit $start,$end";
            } else if ($type == 1) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.wx_id where a.store_id = '$store_id' and a.pid = '$pid' and CommentType = 4 or a.pid = '$pid' and CommentType = 5 or a.pid = '$pid' and CommentType='GOOD' order by add_time desc limit $start,$end";
            } else if ($type == 2) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.wx_id where a.store_id = '$store_id' and a.pid = '$pid' and CommentType = 3 or a.pid = '$pid' and CommentType='NOTBAD' order by add_time desc limit $start,$end";
            } else if ($type == 3) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.wx_id where a.store_id = '$store_id' and a.pid = '$pid' and CommentType = 1 or a.pid = '$pid' and CommentType = 2 or a.pid = '$pid' and CommentType='bad' order by add_time desc limit $start,$end";
            } else if ($type == 4) {
                $sql_c = "select a.id,a.add_time,a.content,a.CommentType,a.pid,a.attribute_id,m.user_name,m.headimgurl from lkt_comments AS a LEFT JOIN lkt_user AS m ON a.uid = m.wx_id where a.store_id = '$store_id' and a.pid = '$pid' and (a.id in (select comments_id from lkt_comments_img where comments_id = a.id)) order by add_time desc limit $start,$end";
            }
            $r_c = $db->select($sql_c);
            $arr = [];
            foreach ($r_c as $key => $value) {
                $pid = $value->pid;
                $attribute_id = $value->attribute_id;
                $attribute_str = '';

                $sql_shu = "select attribute from lkt_configure where pid = '$pid' and id = '$attribute_id'";
                $r_shu = $db->select($sql_shu);
                if($r_shu){
                    $attribute = unserialize($r_shu[0]->attribute);
                    foreach ($attribute as $k => $v){
                        $attribute_str .= $v . ',';
                    }
                    $attribute_str = rtrim($attribute_str, ',');
                }
                $value->attribute_str = $attribute_str;
                $va = (array)$value;
                $va['time'] = substr($va['add_time'], 0, 10); // 评论时间
                if ($va['CommentType'] == 'bad') {
                    $va['CommentType'] = 2;
                } else if ($va['CommentType'] == 'NOTBAD') {
                    $va['CommentType'] = 3;
                } else if ($va['CommentType'] == 'GOOD') {
                    $va['CommentType'] = 5;
                }

                //-------------2018-05-03  修改  作用:返回评论图片
                $comments_id = $va['id']; // 评论id
                // 根据评论id,查询评论图片表
                $comments_sql = "select comments_url from lkt_comments_img where comments_id = '$comments_id' ";
                $comment_res = $db->select($comments_sql);
                $va['images'] = '';
                if ($comment_res) {
                    $va['images'] = $comment_res; // 评论图片
                    $array_c = [];
                    foreach ($comment_res as $kc => $vc) {
                        $url = $vc->comments_url; // 评论图片
                        $array_c[$kc] = array('url' => ServerPath::getimgpath($url));
                    }
                    $va['images'] = $array_c;
                }
                //-------------2018-05-03  修改
                $obj = (object)$va;
                $arr[$key] = $obj;
            }
            echo json_encode(array('code' => 200, 'data' => $arr, 'message' => '成功'));
            exit();
        } else {
            echo json_encode(array('code' => 109, 'message' => '参数错误'));
            exit;
        }

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
}

?>

