<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/resultAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/Plugin/sign.class.php');
require_once(MO_LIB_DIR . '/Plugin/bargain.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');
require_once(MO_LIB_DIR . '/Plugin/auction.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');

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

    //查询首页轮播图
    public function app_banner(){
        $db = DBAction::getInstance();
        $output = New Result;

        // 查询轮播图,根据排序、轮播图id顺序排列
        $sql = "select * from lkt_banner where store_id = '1' and type = '2' order by sort desc";
        $r = $db->select($sql);
        $banner = array();
        if($r){
            foreach($r as $k=>$v){
                $result = array();
                $result['id'] = $v->id; // 轮播图id
                $result['image'] = ServerPath::getimgpath($v->image,1); // 图片
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
        $output->_jsonResult('',$banner);
    }

    //查询所有车型
    public function car_model_list(){
        $db = DBAction::getInstance();
        $redis = new RedisClusters();
        $output = New Result;
        $redis->connect();

        $car_model = $redis->get('car_model');

        if($car_model){
            echo $car_model;
        }else{
            //type=1 汽车品牌车型
            $sql = "select cid,sid,pname,img,level from lkt_product_class where store_id = 1 and type = 1";
            $parent = $db->select($sql);
            $arr = json_decode(json_encode($parent),true);
            $res = $this->cate_tree($arr,0,0);
            $data = json_encode($res);
            $redis->set('car_model',$data);

            echo $data;
        }
        $redis->close();//关闭句柄
    }

    //根据品牌查询车型
    public function son_list(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $redis = new RedisClusters();
        $redis->connect();
        $cid = trim($request->getParameter('cid'));

        $car_model = $redis->get('car_son_model');

        if($car_model){
            echo $car_model;
        }else{
            //type=1 汽车品牌车型
            $sql = "select cid,sid,pname,img,level from lkt_product_class where sid = ".$cid." and type = 1";
            $parent = $db->select($sql);
            $parent = json_decode(json_encode($parent), true);
            foreach($parent as $key=>$val){
                $sql = "select cid,sid,pname,img,level from lkt_product_class where sid = ".$val['cid']." and type = 1";
                $son = $db->select($sql);
                $son = json_decode(json_encode($son), true);
                foreach($son as $k=>$v){
                    $parent[$key]['son'][] = $v;
                }
            }
            $data = json_encode($parent);
            //添加到redis里面
            $redis->set('car_son_model',$data);

            echo $data;
        }
        $redis->close();//关闭句柄
    }

    //递归分类
    public function cate_tree($arr,$id,$level)
    {
        $list = array();
        foreach ($arr as $k=>$v){
            if ($v['sid'] == $id){
                $v['level']=$level;
                $v['son'] = $this->cate_tree($arr,$v['cid'],$level+1);
                $list[] = $v;
            }
        }
        return $list;
    }

    //查询所有专项件
    public function car_Special(){
        $db = DBAction::getInstance();
        $redis = new RedisClusters();
        $output = New Result;
        $redis->connect();

        $car_model = $redis->get('car_Special');

        if($car_model){
            echo $car_model;
        }else{
            //type=2 专项件
            $sql = "select cid,sid,pname,img,level from lkt_product_class where store_id = 1 and type = 2";
            $parent = $db->select($sql);
            $arr = json_decode(json_encode($parent),true);
            $data = json_encode($arr);
            $redis->set('car_Special',$data);

            echo $data;
        }
        $redis->close();//关闭句柄
    }
	
	//查询快递名称列表
	public function logistics_list(){
		$output = New Result;

        //
        $host = "http://wuliu.market.alicloudapi.com";
		$path = "/getExpressList";
		$method = "GET";
		$appcode = "db13534fe5aa4cfa94dcf1eefded576b";
		$headers = array();
		array_push($headers, "Authorization:APPCODE " . $appcode);
		$querys = "type=ALL";
		$bodys = "";
		$url = $host . $path . "?" . $querys;

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_FAILONERROR, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		//curl_setopt($curl, CURLOPT_HEADER, true); 如不输出json, 请打开这行代码，打印调试头部状态码。
		//状态码: 200 正常；400 URL无效；401 appCode错误； 403 次数用完； 500 API网管错误
		if (1 == strpos("$".$host, "https://"))
		{
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		}
		$result = json_decode(curl_exec($curl), true);
		$output->_jsonResult('',$result['result']);

	}


	//根据单号查询快递信息
	public function logistics(){
		$output = New Result;
		$request = $this->getContext()->getRequest();

        //
        $order_sn = trim($request->getParameter('order_sn'));
		$type = trim($request->getParameter('type'));

		$host = "https://wuliu.market.alicloudapi.com";//api访问链接
		$path = "/kdi";//API访问后缀
		$method = "GET";
		$appcode = "db13534fe5aa4cfa94dcf1eefded576b";//替换成自己的阿里云appcode
		$headers = array();
		array_push($headers, "Authorization:APPCODE " . $appcode);
		$querys = "no=".$order_sn."&type=".$type;  //参数写在这里
		$bodys = "";
		$url = $host . $path . "?" . $querys;//url拼接

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_FAILONERROR, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		//curl_setopt($curl, CURLOPT_HEADER, true); 如不输出json, 请打开这行代码，打印调试头部状态码。
		//状态码: 200 正常；400 URL无效；401 appCode错误； 403 次数用完； 500 API网管错误
		if (1 == strpos("$".$host, "https://"))
		{
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		}
		$result = curl_exec($curl);
		$result = json_decode($result, true);
		if($result['status'] == '0'){
			$output->_jsonResult('',$result);
		}else{
			$output->_jsonError('-1',$result['msg']);
		}
	}

    //搜索店铺
    public function search_mch(){
        $db = DBAction::getInstance();
        $output = New Result;
        $request = $this->getContext()->getRequest();
        $page = addslashes(trim($request->getParameter('page')));

        $cid = $request->getParameter('cid');  //品牌分类id 根据品牌搜索
        $search_type = $request->getParameter('search_type');  //搜索类型 1=根据品牌 2=根据专项件
        $keyword = $request->getParameter('keyword'); //专项件名称  根据专项件搜索

        $user_id  = $request->getParameter('user_id');  //用户id

        $region = $request->getParameter('region');  //区域
        $city  = $request->getParameter('city');  //汽配城
        $level = $request->getParameter('level');  //配件等级

        if(!isset($search_type)){
            $output->_jsonError('-1','参数为空！');
        }

        //如果没有传入page 默认传入第一页
        if (!$page) {$page = 1;}
        //每页条数
        $pagesize = 20;
        $start = ($page - 1) * $pagesize;

        $str = '';
        if($city){
            $str = " city like '%".$city."%'";
        }

        if($search_type == 1){
            //查询这个分类和上级分类的店铺
            $sql = "select * from lkt_mch where review_status = 1 and region like '%".$region."%' and accessories_level like '%".$level."%' and brand_model like '%".$cid."%'".$str;
        }elseif($search_type == 2){
            //查询某个区域的专项件的店铺
            $sql = "select * from lkt_mch where review_status = 1 and region like '%".$region."%' and accessories_level like '%".$level."%' and earmarked_cate like '%".$keyword."%'".$str;
        }

        $sql .= " limit $start,$pagesize";
        $arr = $db->select($sql);

        //查询该店铺是否收藏和收藏数量
        if(!empty($arr)){
            foreach($arr as $key=>$val){
                $sql2 = "select id from lkt_user_collection where user_id = '$user_id' and mch_id = ".$val->id." and type = 1";
                $check = $db->select($sql2);
                if($check){
                    $arr[$key]['is_collection'] = 1; //已收藏
                }else{
                    $arr[$key]['is_collection'] = 2; //未收藏
                }

                /*$sql3 = "select count(*) as number from lkt_user_collection where mch_id = 1 and type = 1";
                $number = $db->select($sql3);
                $arr[$key]['number'] = $number[0]->number;*/
            }
        }

        $output->_jsonResult('',$arr);
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

