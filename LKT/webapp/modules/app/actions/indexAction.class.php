<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/Plugin/sign.class.php');
require_once(MO_LIB_DIR . '/Plugin/bargain.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');
require_once(MO_LIB_DIR . '/Plugin/auction.class.php');

class indexAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        // get请求走这
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();

        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        // post请求走这
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    // 获取小程序首页数据
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $store_type = trim($request->getParameter('store_type')); // 来源
        $parameter = '';
        if(!empty($access_id)){
            $sql = "select user_id,parameter from lkt_user where access_id = '$access_id'";
            $r0 = $db->select($sql);
            if($r0){
                $user_id = $r0[0]->user_id;
                $parameter = unserialize($r0[0]->parameter);
            }else{
                $user_id = '';
            }
        }else{
            $user_id = '';
        }
        // 插件
        $Plugin_arr = array();
        $Plugin = new Plugin();
        $Plugin_arr1 = $Plugin->front_Plugin($db,$store_id);
        foreach ($Plugin_arr1 as $k => $v){
            if($k == 'sign' && $v == 1){
                $sign = new sign();
                $sign_arr = $sign->test($store_id,$user_id);

                if($sign_arr['is_sign_status'] == 1){
                    $Plugin_arr[] = array('name'=>'签到',"appimg"=>"images/icon/h_sign.png",'url'=>'../../pagesA/shop/sign','status'=>false);
                }
            }else if($k == 'coupon' && $v == 1 ){
                $coupon = new coupon();
                $coupon_list = $coupon->test($store_id);
                if($coupon_list == 1){
                    $Plugin_arr[] = array('name'=>'优惠券',"appimg"=>"images/icon/h_coupon.png",'url'=>'../../pagesA/shop/coupon','status'=>false);
                }
            }else if($k == 'go_group'&& $v == 1){
                $Plugin_arr[] = array('name'=>'拼团',"appimg"=>"images/icon/h_group.png",'url'=>'../../pagesA/group/group','status'=>false);
            }else if($k == 'seconds'&& $v == 1){
                //查询秒杀是否开启
                $sel_sql = "SELECT is_open FROM `lkt_seconds_config` WHERE 1 and store_id = $store_id";
                $sel_res = $db->select($sel_sql);
                if(!empty($sel_res)){
                    if($sel_res[0]->is_open == 1){
                        $Plugin_arr[] = array('name'=>'秒杀',"appimg"=>"images/icon/h_seckill.png",'url'=>'../../pagesB/seckill/seckill','status'=>false);
                    }
                }
            }else if($k == 'invitation'&& $v == 1){
                $invitation = new invitation();
                $invitation_list = $invitation->test($store_id);
                if($invitation_list == 1){
                    $Plugin_arr[] = array('name'=>'邀请有奖',"appimg"=>"images/icon/renwu2x.png",'url'=>'../../pagesA/shop/invite','status'=>false);
                }
            }else if($k == 'auction' && $v==1){
                $auction = new auction();
                $is_open = $auction->test($store_id);
                if($is_open == 1){
                    $Plugin_arr[] = array('name'=>'竞拍',"appimg"=>"images/icon/h_bidding.png",'url'=>'../../pagesA/bidding/bidding','status'=>false);
                }
            }else if($k == 'bargain' && $v==1){

                $bargain = new bargain();
                $config = $bargain->test($store_id,$user_id);

                if($config['status'] == 1){
                    $Plugin_arr[] = array('name'=>'砍价',"appimg"=>"images/icon/h_bargain.png", 'url'=>'../../pagesA/bargain/bargain?topTabBar=true','status'=>false);
                }
            }
        }

        // 插件结束
        $sql = "select logo1 from lkt_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        if($r_1){
            $logo = ServerPath::getimgpath($r_1[0]->logo1,$store_id);
        }else{ // 没有数据，默认显示图片
            $logo = 'https://laikeds.oss-cn-shenzhen.aliyuncs.com/1/0/1550673836340.png';
        }
        // 查询轮播图,根据排序、轮播图id顺序排列
        $sql = "select * from lkt_banner where store_id = '$store_id' and type = '$store_type' order by sort desc";
        $r = $db->select($sql);
        $banner = array();
        if($r){
            foreach($r as $k=>$v){
                $result = array();
                $result['id'] = $v->id; // 轮播图id
                $result['image'] = ServerPath::getimgpath($v->image,$store_id); // 图片
                $result['url'] = $v->url;
                $domain = strstr($v->url, 'tabBar');
                if($domain){
                    $result['type'] = 'switchTab';
                }else{
                    $result['type'] = 'navigate';
                }
                $result['parameter'] = trim(strrchr($v->url, '='),'=');
                $banner[] = $result;
                unset($result); // 销毁指定变量
            }
        }

        $r_d = array();
        $r_d1 = array();

        if($parameter != ''){
            foreach ($parameter as $key => $value) {
                $cid = $value;
                $sql_c = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid' order by sort ";
                $r_c = $db->select($sql_c);

                if($r_c){
                    $r_d1[$key] = $r_c[0];
                }
                $c_type = " and product_class like '%-$cid-%'";
                $sql_2 = "select a.id,a.product_title,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.status = 2 and a.mch_status = 2 and a.recycle = 0 and a.active = 1 and a.show_adr like '%1%' $c_type group by c.pid  order by a.add_date desc,a.sort desc LIMIT 10";
                $r_2 = $db->select($sql_2);
                if($r_2){
                    foreach($r_2 as $k => $v){
                        $r_2[$k]->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                    }
                    $r_d1[$key]->list = $r_2;
                }
            }
            foreach ($r_d1 as $k => $v){
                $r_d[] = $v;
            }
        }else{
            //查询商品并分类显示返回JSON至小程序
            $sql_c = 'select cid,pname from lkt_product_class where store_id = \''.$store_id.'\' and recycle = 0 and sid=0 order by sort ';
            $r_c = $db->select($sql_c);
            if($r_c){
                foreach ($r_c as $key => $value) {
                    $cid = $value->cid;
                    $c_type = " and a.product_class like '%-$cid-%'";
                    $sql_2 = "select a.id,a.product_title,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.status = 2 and a.mch_status = 2 and a.recycle = 0 and a.active = 1 $c_type group by c.pid  order by a.add_date,a.sort desc LIMIT 10";
                    $r_2 = $db->select($sql_2);
                    if($r_2){
                        foreach($r_2 as $k => $v){
                            $r_2[$k]->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                        }
                    }
                    $value->list = $r_2;
                }
                $r_d = $r_c;
            }
        }

        $sql_t = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.status = 2 and a.mch_status = 2 and a.recycle = 0 and a.active = 1 and a.show_adr like '%1%' group by c.pid  order by a.sort desc,a.add_date DESC LIMIT 0,20";
        $r_t = $db->select($sql_t);
        if($r_t){
            foreach($r_t as $k => $v){
                $r_t[$k]->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
            }
        }

        //消息数量
        $xxnum = 0;
        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test && !empty($user_id)){ // 过期
                $sql_xx = "select count(id) as count from lkt_system_message where store_id='$store_id' and recipientid='$user_id' and type=1";
                $r_xx = $db->select($sql_xx);
                $xxnum = $r_xx[0]->count;
            }
        }

        $data = array('logo'=>$logo,'banner'=>$banner,'list2'=>$r_d,'list3'=>$r_t,'plugin_arr' => $Plugin_arr,'sign_status' => 1, 'is_sign_status' => 1, 'xxnum' => $xxnum);
        echo json_encode(array('code'=>200,'data'=>$data,'message'=>'操作成功'));
        exit();
    }

    // 加载更多商品
    public function get_more(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $num = trim($request->getParameter('page')); // 加载次数

        if(!$num){
            $num = 1;
        }
        $start = $num*20;
        $end = 20;
        $sql_p = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.status = 2 and a.mch_status = 2 and a.recycle = 0 and a.active = 1 and a.show_adr like '%1%' group by c.pid  order by a.sort desc,a.add_date DESC";
        $r_p = $db->select($sql_p);
        $z_num = count($r_p);

        $sql_t = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.status = 2 and a.mch_status = 2 and a.recycle = 0 and a.active = 1 and a.show_adr like '%1%' group by c.pid  order by a.sort desc,a.add_date DESC LIMIT $start,$end";
        $r_t = $db->select($sql_t);
        $product = array();
        if($r_t != '' && $r_p != ''){
            if($z_num >= $end){
                foreach ($r_t as $k => $v) {
                    $imgurl = ServerPath::getimgpath($v->imgurl);/* end 保存*/
                    $product[$k] = array('id' => $v->id,'name' => $v->product_title,'yprice' => $v->yprice,'price' => $v->price,'imgurl' => $imgurl,'volume' => $v->volume);
                }
                echo json_encode(array('code'=>200,'data'=>$product,'message'=>'操作成功'));
                exit();
            }else{
                echo json_encode(array('code'=>200,'data'=>$product,'message'=>'成功'));
                exit();
            }
        }else{
            echo json_encode(array('code'=>101,'message'=>'未知错误'));
            exit();
        }
    }

    // 扫一扫
    public function scan(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $bar_code = $request->getParameter('bar_code'); // 条形码

        $sql1 = "select *,min(h.price) from (select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,c.price,c.yprice from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.scan = '$bar_code' and a.status = 2 and a.mch_status = 2 order by a.add_date desc) as h group by id";
        $r = $db->select($sql1);
        if($r){
            foreach ($r as $k => $v){
                $r[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
            }
            echo json_encode(array('code'=>200,'data'=>$r,'message'=>'成功'));
            exit();
        }else{
            echo json_encode(array('code'=>108,'message'=>'暂无数据'));
            exit();
        }
    }

    // 存储
    public function parameter(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        $arr = $request->getParameter('arr');

        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }else{
                $sql = "select * from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
                $r = $db->select($sql);
                if($r){
                    $parameter = serialize($arr);
                    $sql = "update lkt_user set parameter = '$parameter' where store_id = '$store_id' and access_id = '$access_id'";
                    $rr = $db->update($sql);
                    if($rr){
                        echo json_encode(array('code' => 200, 'message' => '成功'));
                        exit;
                    }
                }else{
                    echo json_encode(array('code' => 404, 'message' => '请登录！'));
                    exit;
                }
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    public function guided_graph(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type')); // 来源

        $list = array();
        $sql = "select * from lkt_guide where store_id = '$store_id' and type = 1 and source = '$store_type' order by sort,add_date desc limit 3";
        $r = $db->select($sql);
        if($r){
            foreach ($r as $k => $v) {
                $v->image = ServerPath::getimgpath($v->image);
            }
            $list = $r;
        }

        echo json_encode(array('code' => 200,'list'=>$list, 'message' => '成功'));
        exit;
    }
}

?>

