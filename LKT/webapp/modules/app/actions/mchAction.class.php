<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/phpqrcode.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/Plugin/mch.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/alipay/return.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/Plugin_order.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

/**
 * <p>Copyright (c) 2019</p>
 * <p>Company: www.laiketui.com</p>
 * @Author  段宏波
 * @version 2.0
 * @date    2019-01-29 15:51:29+0800
 * @return  [type]   多店铺接口   [description]
 */
class mchAction extends Action {

    public function getDefaultView() {
        $this->execute();
        exit;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        //m指向具体操作方法
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))):'';
        if($m != 'store_homepage' && $m != 'agreement' && $m != 'store_homepage_load' && $m != 'uploadImgs' && $m != 'get_attribute_name' && $m != 'get_attribute_value'){
            if(!empty($access_id)){ // 存在
                $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                if($getPayload_test == false){ // 过期
                    echo json_encode(array('code' => 404, 'message' => '请登录！'));
                    exit;
                }
            }else{
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
            $sql = "select user_id,user_name from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $r = $db->select($sql);
            if($r){
                $user_id = $r[0]->user_id;
                $user_name = $r[0]->user_name;
                $this->db = $db;
                $this->user_id = $user_id;
                $this->user_name = $user_name;
                $this->store_id = $store_id;
            }else{
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }
        $this->$m();
        exit;
    }
    public function getRequestMethods(){
        return Request :: POST;
    }

    // 我的店铺
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $user_id = $this->user_id;
        $mch_data = array();
        // 根据商城ID、用户ID、店铺审核状态通过，查询是否有店铺
        $sql0 = "select * from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $shop_id = $r0[0]->id;
            $mch_data['shop_id'] = $r0[0]->id;
            $mch_data['name'] = $r0[0]->name;
            $mch_data['shop_information'] = $r0[0]->shop_information;
            $mch_data['logo'] = ServerPath::getimgpath($r0[0]->logo,$store_id);
            $mch_data['account_money'] = $r0[0]->account_money;
            $status = 2; // 审核通过
        }else{
            $sql1 = "select * from lkt_mch where store_id = '$store_id' and user_id = '$user_id' order by add_time desc limit 1";
            $r1 = $db->select($sql1);
            if($r1){
                if($r1[0]->review_status == 0){
                    $mch_data['shop_id'] = $r1[0]->id;
                    $status = 1; // 审核中
                }else{
                    $status = 3; // 审核不通过
                    $mch_data['shop_id'] = $r1[0]->id;
                    $mch_data['review_result'] = $r1[0]->review_result;

                }
            }else{
                $status = 0; // 没有申请
            }
            $shop_id = 0;
        }

        $time1 = date("Y-m-d 00:00:00");
        $time2 = date("Y-m-d 23:59:59");
        $mch_data['order_num'] = 0;
        $mch_data['order_num1'] = 0;
        $mch_data['order_num2'] = 0;
        $mch_data['visitor_num'] = 0;
        $mch_data['income'] = 0;
        if($shop_id != 0){
            $sql_0 = "select id from lkt_order where store_id = '$store_id' and mch_id like '%,$shop_id,%' and add_time >= '$time1' and add_time <= '$time2' and status !=8 and (status != 6 or status != 7)";
            $r_0 = $db->select($sql_0);
            $mch_data['order_num'] = count($r_0); // 今日订单

            $sql_1 = "select id from lkt_order where store_id = '$store_id' and mch_id like '%,$shop_id,%' and ((status = 1 and self_lifting = 0 ) or (status = 2 and self_lifting = 1 ))";
            $r_1 = $db->select($sql_1);
            $mch_data['order_num1'] = count($r_1); // 待发货订单

            $sql_2 = "select b.id from lkt_order as a left join lkt_order_details as b on a.sNo = b.r_sNo where b.store_id = '$store_id' and a.mch_id like '%,$shop_id,%' and b.r_status = 4";
            $r_2 = $db->select($sql_2);
            $mch_data['order_num2'] = count($r_2); // 售后订单

            $sql_3 = "select user_id,token from lkt_mch_browse where store_id = '$store_id' and mch_id = '$shop_id' ";
            $r_3 = $db->select($sql_3);
            $res1 = array();
            $res1_1 = array();
            if($r_3){
                foreach ($r_3 as $K => $v) {
                    $res1[$v->token][] = $v;
                }
                foreach ($res1 as $K => $v) {
                    foreach ($v as $ke => $va){
                        $res1_1[$va->user_id][] = $va;
                    }
                }
            }
            $mch_data['visitor_num'] = count($res1_1); // 访客数

            $sr = 0;// 今日收入
            $js = 0;
            $sql_4 = "select * from lkt_mch_account_log where store_id = '$store_id' and addtime >= '$time1' and addtime <= '$time2' and mch_id = '$shop_id' and type in (1,2)";
            $r_4 = $db->select($sql_4);
            if($r_4){
                foreach ($r_4 as $k => $v){
                    if($v->status == 1){
                        $sr += $v->price;
                    }else{
                        $js += $v->price;
                    }
                }
            }
            $income = $sr - $js;
            if($income < 0){
                $mch_data['income'] = 0;
            }else{
                $mch_data['income'] = $income;
            }
        }

        echo json_encode(array('code' => 200,'data'=>$mch_data,'status'=>$status, 'message' => '成功！'));
        exit();
    }
    // 点击申请开店按钮
    public function click_Apply(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $user_id = $this->user_id;

        $sql0 = "select b.level from lkt_user as a left join lkt_user_distribution as b on a.user_id = b.user_id where a.store_id = '$store_id' and a.user_id = '$user_id'";
        $r0 = $db->select($sql0);
        if($r0){
            if($r0[0]->level > 0){
                $sql = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 0";
                $r = $db->select($sql);
                if($r){
                    $status = 1; // 审核中
                }else{
                    $status = 0; // 没有申请
                }

            }else{
                $status = 4; // 不是分销商
            }
        }else{
            $status = 4; // 不是分销商
        }

        echo json_encode(array('code' => 200,'status'=>$status, 'message' => '成功！'));
        exit();
    }
    // 验证店铺名称
    public function verify_store_name(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $name =  addslashes(trim($request->getParameter('name'))); // 店铺名称
        $user_id = $this->user_id;

        require('shop_name.php');
        foreach($shop_name as $key=>$val ){
            if (strstr($name, $val  ) !== false ){
                echo json_encode(array('code'=>225,'message'=>'店铺名称不合法！'));
                exit();
            }
        }

        $sql = "select id from lkt_mch where store_id = '$store_id' and name = '$name' and user_id != '$user_id'";
        $r = $db->select($sql);
        if($r){
            echo json_encode(array('code' => 223, 'message' => '店铺名称已存在！'));
            exit();
        }else{
            echo json_encode(array('code' => 200, 'message' => '成功！'));
            exit();
        }

    }
    // 申请开通店铺
    public function apply()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $db->begin();

        $store_id =  addslashes(trim($request->getParameter('store_id'))); // 商城id
        $user_id =  $this->user_id; // 用户id
        $name =  addslashes(trim($request->getParameter('name'))); // 店铺名称
        $shop_information =  addslashes(trim($request->getParameter('shop_information'))); // 店铺信息
        $shop_range =  addslashes(trim($request->getParameter('shop_range'))); // 经营范围
        $realname =  addslashes(trim($request->getParameter('realname'))); // 真实姓名
        $ID_number =  addslashes(trim($request->getParameter('ID_number'))); // 身份证号码
        $tel =  addslashes(trim($request->getParameter('tel'))); // 联系电话
        $address =  addslashes(trim($request->getParameter('address'))); // 联系地址
        $shop_nature =  addslashes(trim($request->getParameter('shop_nature'))); // 店铺性质
        $store_type = trim($request->getParameter('store_type'));
        if($store_type = 1){
            $store_type = '0';
        }elseif ($store_type = 2){
            $store_type = 'app';
        }
        require('shop_name.php');
        foreach($shop_name as $key=>$val ){
            if (strstr($name, $val  ) !== false ){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'申请开通店铺时，店铺名称不合法！';
                $this->mchLog($Log_content);

                echo json_encode(array('code'=>225,'message'=>'店铺名称不合法！'));
                exit();
            }
        }

        $sql = "select id from lkt_mch where store_id = '$store_id' and name = '$name' and user_id != '$user_id'";
        $r = $db->select($sql);
        if($r){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'申请开通店铺时，店铺名称已存在！';
            $this->mchLog($Log_content);

            echo json_encode(array('code' => 223, 'message' => '店铺名称已存在！'));
            exit();
        }

        $res = $this->is_idcard($ID_number);
        if(!$res){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'申请开通店铺时，身份证号码错误！';
            $this->mchLog($Log_content);

            echo json_encode(array('code'=>225,'message'=>'身份证号码错误！'));
            exit();
        }

        if(preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $tel)){

        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'申请开通店铺时，手机号码有误！';
            $this->mchLog($Log_content);

            echo json_encode(array('code'=>117,'message'=>'手机号码有误！'));
            exit();
        }
        if(!empty($_FILES)){
            // 查询配置表信息
            $sql = "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);

            $uploadImg = $r[0]->uploadImg;
            $uploadImg_domain = $r[0]->uploadImg_domain;
            $upserver = !empty($r)?$r[0]->upserver:'2';   //如果没有设置配置则默认用阿里云
            // 图片上传位置
            if(empty($uploadImg)){
                $uploadImg = "../LKT/images";
            }
            if($upserver == '2'){
                $business_license = ServerPath::file_OSSupload($store_id, $store_type);
            }else{
                $business_license = ServerPath::file_upload($store_id,$uploadImg,$uploadImg_domain,$store_type);
            }
            if($business_license == false){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'申请开通店铺时，上传失败或图片格式错误！';
                $this->mchLog($Log_content);

                echo json_encode(array('code' => 109,'message'=>'上传失败或图片格式错误！'));
                exit;
            }else{
                $business_license = preg_replace('/.*\//', '', $business_license);
            }
        }else{
            $business_license = '';
        }

        $sql = "insert into lkt_mch(store_id,user_id,name,shop_information,shop_range,realname,ID_number,tel,address,shop_nature,business_license,add_time) values ('$store_id','$user_id','$name','$shop_information','$shop_range','$realname','$ID_number','$tel','$address','$shop_nature','$business_license',CURRENT_TIMESTAMP)";
        $res_data = $db->insert($sql);
        if ($res_data > 0) {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'申请开通店铺成功！';
            $this->mchLog($Log_content);
            $db->commit();

            echo json_encode(array('code' => 200, 'message' => '成功！'));
            exit();
        } else {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'申请开通店铺失败！';
            $this->mchLog($Log_content);
            $db->rollback();

            echo json_encode(array('code' => 224, 'message' => '申请失败！'));
            exit();
        }
    }
    // 入驻协议
    public function agreement(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id =  addslashes(trim($request->getParameter('store_id'))); // 商城id

        $sql = "select agreement from lkt_mch_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $agreement = $r[0]->agreement;
        }else{
            $agreement = '';
        }

        echo json_encode(array('code' => 200,'agreement'=>$agreement, 'message' => '成功！'));
        exit();
    }
    // 继续开通店铺
    public function continue_apply()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id =  addslashes(trim($request->getParameter('store_id'))); // 商城id
        $shop_id =  addslashes(trim($request->getParameter('shop_id'))); // 店铺ID
        $user_id =  $this->user_id; // 用户id
        $sql0 = "select * from lkt_mch where store_id = '$store_id' and user_id = '$user_id' order by add_time desc limit 1";
        $r0 = $db->select($sql0);
        if($r0){
            $r0[0]->logo = ServerPath::getimgpath($r0[0]->logo, $store_id); //图片
            $r0[0]->business_license = ServerPath::getimgpath($r0[0]->business_license, $store_id); //图片
            echo json_encode(array('code' => 200,'list'=>$r0[0], 'message' => '成功！'));
            exit();
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 上传商品页面
    public function upload_merchandise_page(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));

        $user_id = $this->user_id;
        $user_name = $this->user_name;

        $sql0 = "select product_number from lkt_product_number where store_id = '$store_id' and status = 1 order by addtime desc limit 1";
        $r0 = $db->select($sql0);
        if ($r0) {
            $product_number1 = $r0[0]->product_number;
            $product_number = $this->add($product_number1);
        } else {
            $product_number = $this->add();
        }
        $sql0_0 = "insert into lkt_product_number(store_id,mch_id,operation,product_number,addtime) values ('$store_id','$shop_id','$user_name','$product_number',CURRENT_TIMESTAMP)";
        $r0_0 = $db->insert($sql0_0);

        // 运费
        $sql_2 = "select id,name from lkt_freight where store_id = '$store_id' order by add_time desc";
        $freight_list = $db->select($sql_2);

        $sql_0 = "select value from lkt_data_dictionary where name = '单位' and status = 1";
        $r_0 = $db->select($sql_0);
        if($r_0){
            foreach ($r_0 as $k => $v){
                $value = $v->value;
                $value_arr = explode(',',$value);
                $unit[] = $value_arr[1];
            }
        }

        $sql0 = "select value from lkt_data_dictionary where name = '商品类型' and status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $value = $v->value;
                $value_arr = explode(',',$value);
                $arr[$value_arr[0]] = array('name'=>$value_arr[1],'value'=>$value_arr[0],'status'=>false);
            }
        }
        $sql1 = "select value from lkt_data_dictionary where name = '商品展示位置' and status = 1";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $value = $v->value;
                $value_arr = explode(',',$value);
                $arr1[$value_arr[0]] = array('name'=>$value_arr[1],'value'=>$value_arr[0],'status'=>false);
            }
        }

        $Plugin = new Plugin();
        $Plugin_arr1 = $Plugin->front_Plugin($db,$store_id,'product');

        $Plugin_arr = array();
        $Plugin_arr['active'][] = array('name'=>'正价','value'=>1,'status'=>false);
        foreach ($Plugin_arr1 as $k => $v){
            if($k == 'go_group_status' && $v == 1){
                $Plugin_arr['active'][] = array('name'=>'拼团','value'=>2,'status'=>false);
            }else if($k == 'bargain_status' && $v == 1 ){
                $Plugin_arr['active'][] = array('name'=>'砍价','value'=>3,'status'=>false);
            }else if($k == 'auction_status'&& $v == 1){
                $Plugin_arr['active'][] = array('name'=>'竞拍','value'=>4,'status'=>false);
            }else if($k == 'distribution_status'&& $v == 1){
                $Plugin_arr['active'][] = array('name'=>'分销','value'=>5,'status'=>false);

                $sql02 = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = 0";
                $r02 = $db->select($sql02);
                $distributors = array();
                $distributors_num = 0;
                $distributors[$distributors_num] = (object)array('id' => "0", 'name' => '不绑定等级的会员商品','status'=>true);
                if ($r02) {
                    foreach ($r02 as $k => $v) {
                        $distributors_num++;
                        $sets = unserialize($v->sets);
                        $name = $sets['s_dengjiname'];
                        $distributors[$distributors_num] = (object)array('id' => $v->id, 'name' => $name,'status'=>false);
                    }
                }
            }else if($k == 'integral_status'&& $v == 1){
                $Plugin_arr['active'][] = array('name'=>'积分','value'=>7,'status'=>false);
            }else if($k == 'seconds_status'&& $v == 1){
                $Plugin_arr['active'][] = array('name'=>'秒杀','value'=>8,'status'=>false);
            }
        }
        $Plugin_arr['active'][] = array('name'=>'会员','value'=>6,'status'=>false);

        echo json_encode(array('code' => 200,'product_number'=>$product_number,'freight_list'=>$freight_list,'unit'=>$unit,'show_adr'=>$arr1,'s_type'=>$arr,'plugin_list'=>$Plugin_arr,'distributors'=>$distributors, 'message' => '成功！'));
        exit();
    }
    // 获取分类
    public function get_class(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $class_str = addslashes(trim($request->getParameter('class_str'))); // 分类ID
        $brand_id = addslashes(trim($request->getParameter('brand_str'))); // 品牌ID

        $list = array();
        $id = 0;
        if($class_str == '0'){ // 没有选择分类
            // 获取产品类别
            $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc";
            $r0 = $db->select($sql0);
            if($r0){
                foreach ($r0 as $k => $v){
                    $r0[$k]->status = false;
                }
                $list[] = $r0;
                $id = $r0[0]->cid;
            }

        }else{ // 选择了分类
            $list1 = array();
            // 获取产品类别
            $sql0_0 = "select cid,sid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$class_str' order by sort desc";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                $sid = $r0_0[0]->sid; // 上级ID
            }
            // 根据分类ID，查询下级
            $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$class_str' order by sort desc";
            $r0 = $db->select($sql0);
            if($r0){ // 有下级
                foreach ($r0 as $k => $v){
                    $r0[$k]->status = false;
                }
                $list1[] = $r0;
            }else{ // 没有下级
                // 根据分类上级ID查询同级
                $sql1 = "select cid,sid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$sid' order by sort desc";
                $r1 = $db->select($sql1);
                $id = $class_str;
                if($r1){
                    foreach ($r1 as $k => $v){
                        if($v->cid == $class_str){
                            $r1[$k]->status = true;
                        }else{
                            $r1[$k]->status = false;
                        }
                    }
                }
                $list1[] = $r1;
            }
            $res = $this->superior($sid,$list1);
            if($res != array()){
                $num = count( $res['list']) - 1;
                $list[] = $res['list'][$num];
                $id = $res['id'];
            }else{
                $list = $list1;
                $id = $class_str;
            }
        }
//        $brand_list1 = array('brand_id'=>'0','brand_name'=>'请选择商品品牌');
        $brand_sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%,$id,%' order by sort desc";
        $brand_list = $db->select($brand_sql);
//        array_unshift($brand_list,(object)$brand_list1);

        if($brand_id != 0 || $brand_id != ''){
            foreach($brand_list as $k => $v){
                if($brand_id == $v->brand_id){
                    $brand_list[$k]->status = true;
                }else{
                    $brand_list[$k]->status = false;
                }
            }
        }

        $data = array('class_list'=>$list,'brand_list'=>$brand_list);
        echo json_encode(array('code' => 200,'list'=>$data, 'message' => '成功！'));
        exit;
    }
    // 选择分类
    public function choice_class(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = trim($request->getParameter('store_id'));
        $cid = addslashes(trim($request->getParameter('cid'))); // 参数
        $brand_id = addslashes(trim($request->getParameter('brand_str'))); // 品牌ID

        $list = array();
        $id = 0;
        $pname = '';
        // 查询下级
        $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$cid' order by sort desc";
        $r0 = $db->select($sql0);
        if($r0){ // 有下级
            foreach ($r0 as $k => $v){
                $r0[$k]->status = false;
            }
            $list[] = $r0;
        }else{ // 没有下级
            $sql1 = "select cid,sid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid'";
            $r1 = $db->select($sql1);
            if($r1){
                $id = $r1[0]->cid;
                $pname = $r1[0]->pname;
            }
        }

        $sql2 = "select sid,cid from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid'";
        $r2 = $db->select($sql2);
        if($r2){
            $sid = $r2[0]->sid; // 上级ID
            if($sid == 0){
                $cid = $r2[0]->cid;
            }else{
                $Tools = new Tools($db, $store_id, 1);
                $res = $Tools->str_option($sid);
                $res = explode('-',trim($res,'-'));
                $cid = $res[0];
            }
        }
//        $brand_list1 = array('brand_id'=>'0','brand_name'=>'请选择商品品牌');
        $brand_sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%,$cid,%' order by sort desc";
        $brand_list = $db->select($brand_sql);
//        array_unshift($brand_list,(object)$brand_list1);
        if($brand_id != 0 || $brand_id != ''){
            foreach($brand_list as $k => $v){
                if($brand_id == $v->brand_id){
                    $brand_list[$k]->status = true;
                }else{
                    $brand_list[$k]->status = false;
                }
            }
        }

        $data = array('class_list'=>$list,'class_id'=>$id,'class_name'=>$pname,'brand_list'=>$brand_list);
        echo json_encode(array('code' => 200,'list'=>$data, 'message' => '成功！'));
        exit;
    }
    // 查询分类上级
    public function superior($cid,$list){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $arr = array();
        // 根据id，查询分类
        $sql0 = "select cid,sid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid' ";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->cid;
            $sid = $r0[0]->sid;
            $pname = $r0[0]->pname;
            $level = $r0[0]->level;
            $arr['id'] = $id;
            if($level != 0){ // 当不是1级分类
                // 获取产品类别
                $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$sid' order by sort desc";
                $r0 = $db->select($sql0);
                if($r0){
                    foreach ($r0 as $k => $v){
                        if($v->cid == $cid){
                            $r0[$k]->status = true;
                        }else{
                            $r0[$k]->status = false;
                        }
                    }
                    array_unshift($list,$r0);
                }
                $res = $this->superior($sid,$list);
                $arr['id'] = $res['id'];
                $arr['list'] = $res['list'];
            }else{ // 当是1级分类
                // 获取产品类别
                $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc";
                $r0 = $db->select($sql0);
                if($r0){
                    foreach ($r0 as $k => $v){
                        if($v->cid == $cid){
                            $r0[$k]->status = true;
                        }else{
                            $r0[$k]->status = false;
                        }
                    }
                    array_unshift($list,$r0);
                }
                $arr['list'] = $list;
            }
        }
        return $arr;
    }
    // 获取属性名
    public function get_attribute_name(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $attribute_str = addslashes(trim($request->getParameter('attribute_str'))); // 属性名字符串
        $attribute_str = htmlspecialchars_decode($attribute_str); // 将特殊的 HTML 实体转换回普通字符
        $attribute_str1 = explode(',',$attribute_str); // 转数组

        $attribute = Tools::attribute($db, '属性名',$attribute_str1);

        $data = array('attribute'=>$attribute);
        echo json_encode(array('code' => 200,'list'=>$data, 'message' => '成功！'));
        exit;
    }
    // 获取属性值
    public function get_attribute_value(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $attribute_str = addslashes(trim($request->getParameter('attribute_str'))); // 属性名字符串
        $attr_arr = addslashes(trim($request->getParameter('attr_arr'))); // 属性字符串

        $attribute_str = htmlspecialchars_decode($attribute_str); // 将特殊的 HTML 实体转换回普通字符
        $attribute_str1 = explode(',',$attribute_str); // 转数组

        $attr_arr = htmlspecialchars_decode($attr_arr); // 将特殊的 HTML 实体转换回普通字符
        $attr_arr1 = json_decode($attr_arr); // json字符串转数组
        $rew = array();
        $arr = array();
        $arr1 = array();
        $arr2 = array();
        if(count($attr_arr1) > 0){
            foreach ($attr_arr1 as $k => $v){
                foreach ($v->attr_list as $k1 => $v1){
                    $arr1[] = array($v->attr_group_name,$v1->attr_name);
                }
            }
            // 将二维数组某一个字段相同的数组合并起来的方法
            foreach ($arr1 as $k => $v) {
                $arr2[$v[0]][] = $v[1];
            }
            // 去重
            foreach ($arr2 as $k => $v) {
                $arr3[$k] = array_unique($v);
            }
            foreach ($arr3 as $k => $v) {
                if(in_array($k,$attribute_str1)){
                    $arr[$k] = $v;
                }
            }
            foreach ($arr as $k => $v) {
                $rew[$k] = Tools::attribute_name($db, '属性值',$k,$v);
            }
        }else{
            if(count($attribute_str1) != 0){
                foreach ($attribute_str1 as $k => $v){
                    $rew[$v] = Tools::attribute_name($db, '属性值',$v);
                }
            }
        }

        $data = array('list'=>$rew);
        echo json_encode(array('code' => 200,'list'=>$data, 'message' => '成功！'));
        exit;
    }
    // 上传商品页面返回
    public function del(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $db->begin();

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $mch_id = $this->getContext()->getStorage()->read('mch_id'); //店铺id
        $user_name = $this->user_name;

        $sql = "update lkt_product_number set status = 2 where store_id = '$store_id' and mch_id = '$mch_id' and operation = '$user_name' and max(id)";
        $r = $db->update($sql);
        if ($r > 0) {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_name.'离开上传商品页面，删除商品编号成功！';
            $this->mchLog($Log_content);
            $db->commit();

        } else {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_name.'离开上传商品页面，删除商品编号失败！';
            $this->mchLog($Log_content);
            $db->rollback();

        }
        echo json_encode(array('code' => 200, 'message' => '成功！'));
        exit;
    }
    // 点击编辑商品
    public function modify(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));
        $p_id = addslashes(trim($request->getParameter('p_id'))); // 产品id

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $rr = $db->select($sql);
        if($rr) {
            $mch_id = $rr[0]->id;
            if($mch_id != $shop_id){
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }else{
                // 运费
                $sql_2 = "select id,name from lkt_freight where store_id = '$store_id' order by add_time desc";
                $freight_list = $db->select($sql_2);

                $sql_0 = "select value from lkt_data_dictionary where name = '单位' and status = 1";
                $r_0 = $db->select($sql_0);
                if($r_0){
                    foreach ($r_0 as $k => $v){
                        $value = $v->value;
                        $value_arr = explode(',',$value);
                        $unit[] = $value_arr[1];
                    }
                }

                // 根据产品id，查询产品产品信息
                $sql = "select * from lkt_product_list where store_id = '$store_id' and mch_id = '$mch_id' and id = '$p_id'";
                $r = $db->select($sql);
                if ($r) {
                    $product_class = $r[0]->product_class; // 产品类别
                    $res = explode('-',trim($product_class,'-')); // 移除字符串两侧的字符，然后转数组
                    $brand_id = $r[0]->brand_id; // 产品品牌
                    $status = $r[0]->status; // 上下架状态
                    $imgurl = ServerPath::getimgpath($r[0]->imgurl, $store_id); //图片
                    $imgs_sql = "select * from lkt_product_img where product_id = '$p_id'";
                    $imgurls1 = $db->select($imgs_sql);
                    $imgurls = array();
                    $imgurls[] = $imgurl;
                    if ($imgurls1) {
                        foreach ($imgurls1 as $k => $v) {
                            $imgurls[] = ServerPath::getimgpath($v->product_url, $store_id);
                        }
                    }

                    $initial = unserialize($r[0]->initial);
                    $content = $r[0]->content;
                    $richList = $r[0]->richList;

                    $distributor_id = $r[0]->distributor_id;//分销层级id
                    $s_type = explode(',',$r[0]->s_type);
                    $freight_id = $r[0]->freight;
                    $show_adr = explode(',', $r[0]->show_adr);
                    $active = explode(',', $r[0]->active);
                }else{
                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
                $product_class_list1 = array();
                $cid = '';

                $class_id0 = $res[0]; //  商品所属分类的顶级

                foreach ($res as $k => $v){
                    $class_sql = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$v' ";
                    $class_r = $db->select($class_sql);
                    $class[] = $class_r[0];
                }

//                $brand_list1 = array('brand_id'=>'0','brand_name'=>'请选择商品品牌');
                $brand_sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%,$class_id0,%' order by sort desc";
                $brand_list = $db->select($brand_sql);
//                array_unshift($brand_list,(object)$brand_list1);

                $sql1 = " select brand_name from lkt_brand_class where brand_id = '$brand_id' ";
                $r1 = $db->select($sql1);
                $brand_name = $r1[0]->brand_name;
                $brand_class_list1 = array('brand_id'=>$brand_id,'brand_name'=>$brand_name);

                $sql2 = " select name from lkt_freight where id = '$freight_id' ";
                $r2 = $db->select($sql2);
                $name = $r2[0]->name;
                $freight_list1 = array('id'=>$freight_id,'name'=>$name);

                if($distributor_id != 0){
                    $sql2_1 = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = 0 and id = '$distributor_id'";
                    $r2_1 = $db->select($sql2_1);
                    $sets2_1 = unserialize($r2_1[0]->sets);
                    $name2_1 = $sets2_1['s_dengjiname'];
                }else{
                    $name2_1 = '会员专区商品绑定等级';
                }
                $distributors1 = array('id'=>$distributor_id,'name'=>$name2_1);

                $sql3 = "select value from lkt_data_dictionary where name = '商品类型' and status = 1";
                $r3 = $db->select($sql3);
                if($r3){
                    foreach ($r3 as $k => $v){
                        $value = $v->value;
                        $value_arr = explode(',',$value);
                        $arr[$value_arr[0]] = array('name'=>$value_arr[1],'value'=>$value_arr[0],'status'=>false);
                    }
                }
                foreach ($arr as $k => $v){
                    foreach ($s_type as $ke => $va){
                        if($va == $v['value']){
                            $arr[$k]['status'] = true;
                        }
                    }
                }
                $sql3_1 = "select value from lkt_data_dictionary where name = '商品展示位置' and status = 1";
                $r3_1 = $db->select($sql3_1);
                if($r3_1){
                    foreach ($r3_1 as $k => $v){
                        $value = $v->value;
                        $value_arr = explode(',',$value);
                        $show_adr1[$value_arr[0]] = array('name'=>$value_arr[1],'value'=>$value_arr[0],'status'=>false);
                    }
                }
                foreach ($show_adr1 as $k => $v){
                    foreach ($show_adr as $ke => $va){
                        if($va == $v['value']){
                            $show_adr1[$k]['status'] = true;
                        }
                    }
                }

                $Plugin = new Plugin();
                $Plugin_arr1 = $Plugin->front_Plugin($db,$store_id,'product');
                $Plugin_arr = array();
                $Plugin_arr['active'][] = array('name'=>'正价','value'=>1,'status'=>false);
                foreach ($Plugin_arr1 as $k => $v){
                    if($k == 'go_group_status' && $v == 1){
                        $Plugin_arr['active'][] = array('name'=>'拼团','value'=>2,'status'=>false);
                    }else if($k == 'bargain_status' && $v == 1 ){
                        $Plugin_arr['active'][] = array('name'=>'砍价','value'=>3,'status'=>false);
                    }else if($k == 'auction_status'&& $v == 1){
                        $Plugin_arr['active'][] = array('name'=>'竞拍','value'=>4,'status'=>false);
                    }else if($k == 'distribution_status'&& $v == 1){
                        $Plugin_arr['active'][] = array('name'=>'分销','value'=>5,'status'=>false);
                        $sql02 = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = 0";
                        $r02 = $db->select($sql02);
                        $distributors = array();
                        $distributors_num = 0;
                        if($distributor_id){
                            $distributors[$distributors_num] = (object)array('id' => 0, 'name' => '不绑定等级的会员商品','status'=>false);
                            if ($r02) {
                                foreach ($r02 as $k => $v) {
                                    $distributors_num++;
                                    $sets = unserialize($v->sets);
                                    $name = $sets['s_dengjiname'];
                                    if($distributor_id == $v->id){
                                        $distributor_status = true;
                                    }else{
                                        $distributor_status = false;
                                    }
                                    $distributors[$distributors_num] = (object)array('id' => $v->id, 'name' => $name,'status'=>$distributor_status);
                                }
                            }
                        }else{
                            $distributors[$distributors_num] = (object)array('id' => "0", 'name' => '不绑定等级的会员商品','status'=>true);
                            if ($r02) {
                                foreach ($r02 as $k => $v) {
                                    $distributors_num++;
                                    $sets = unserialize($v->sets);
                                    $name = $sets['s_dengjiname'];
                                    $distributor_status = false;
                                    $distributors[$distributors_num] = (object)array('id' => $v->id, 'name' => $name,'status'=>$distributor_status);
                                }
                            }
                        }
                    }else if($k == 'integral_status'&& $v == 1){
                        $Plugin_arr['active'][] = array('name'=>'积分','value'=>7,'status'=>false);
                    }else if($k == 'seconds_status'&& $v == 1){
                        $Plugin_arr['active'][] = array('name'=>'秒杀','value'=>8,'status'=>false);
                    }
                }
                $Plugin_arr['active'][] = array('name'=>'会员','value'=>6,'status'=>false);

                foreach ($Plugin_arr['active'] as $k => $v){
                    foreach ($active as $ke => $va){
                        if($va == $v['value']){
                            $Plugin_arr['active'][$k]['status'] = true;
                        }
                    }
                }
                $attr_group_list = array();
                $checked_attr_list = array();
                //-----查询规格数据
                $size = "select * from lkt_configure where pid = '$p_id'";
                $res_size = $db->select($size);
                if ($res_size) {
                    $arrar_t = unserialize($res_size[0]->attribute);
                    foreach ($arrar_t as $key => $value) {
                        $attr_group_list[] = array('attr_group_name' => $key, 'attr_list' => array(), 'attr_all' => array());
                    }

                    foreach ($res_size as $k => $v) {
                        $attribute = unserialize($v->attribute); // 属性
                        $attr_lists = array();
                        //列出属性名
                        foreach ($attribute as $key => $value) {
                            foreach ($attr_group_list as $keya => $valuea) {
                                if ($key == $valuea['attr_group_name']) {
                                    if (!in_array($value, $attr_group_list[$keya]['attr_all'])) {
                                        if($status == 1){
                                            $attr_list = array('attr_name' => $value,'status' => true);
                                        }else{
                                            $attr_list = array('attr_name' => $value,'status' => false);
                                        }
                                        array_push($attr_group_list[$keya]['attr_list'], $attr_list);
                                        array_push($attr_group_list[$keya]['attr_all'], $value);
                                    }
                                }
                            }
                            $attr_lists[] = array('attr_id' => '', 'attr_group_name' => $key, 'attr_name' => $value);
                        }
                        $checked_attr_list[] = array('attr_list' => $attr_lists, 'cbj' => $v->costprice, 'yj' => $v->yprice, 'sj' => $v->price, 'kucun' => $v->total_num, 'unit' => $v->unit,'bar_code' => $v->bar_code, 'img' => ServerPath::getimgpath($v->img, $store_id), 'cid' => $v->id);
                    }
                    foreach ($attr_group_list as $key => $value) {
                        $attr_group_list[$key] = Tools::array_key_remove($attr_group_list[$key], 'attr_all');
                    }
                }

                $type_status = 0;

                $sql4 = "select a.* from lkt_product_list as a left join lkt_order_details as b on a.id = b.p_id where a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 and r_status not in (0,1,2) and a.id = '$p_id'";
                $r4 = $db->select($sql4);
                if($r4){
                    $type_status = 1;
                }else{

                    // 砍价
                    $sql00 = "SELECT * FROM `lkt_bargain_goods`  where store_id = '$store_id' and status = 1 and is_delete = 0 and goods_id = '$p_id' ";
                    $r00 = $db->select($sql00);
                    if($r00){
                        $type_status = 2;
                    }
                    // 拼团
                    $sql01 = "SELECT g_status from lkt_group_product where store_id = '$store_id' and product_id = '$p_id' ";
                    $r01 = $db->select($sql01);
                    if($r01){
                        $type_status = 2;
                    }

                    // 竞拍
                    $sql02 = "(select attribute from lkt_auction_product where store_id = '$store_id' and status in (0,1) ) union (select attribute from lkt_auction_product where store_id = '$store_id' and status = 2 and is_buy = 0)";
                    $r02 = $db->select($sql02);

                    $arr_arr = array();//正在进行活动中的商品id数组
                    if($r02){

                        foreach ($r02 as $k => $v) {
                            $attr = $v->attribute;//序列化的字符串
                            $attr = unserialize($attr);
                            $arr_arr[$k] = array_keys($attr);//商品id数组
                        }
                        if(in_array($p_id, $arr_arr)){
                            $type_status = 2;
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
                                if(in_array($p_id,$product_list)){
                                    $type_status = 2;
                                }
                            }
                        }
                    }
                    // 满减
                    $sql05 = "select pro_id from lkt_subtraction where store_id = '$store_id' ";
                    $r05 = $db->select($sql05);
                    if($r05){
                        $pro_id = explode(',',$r05[0]->pro_id);
                        if(in_array($p_id,$pro_id)){
                            $type_status = 2;
                        }
                    }
                }
                echo json_encode(array('code' => 200,'richList'=>$richList,'content'=> $content, 'brand_list'=>$brand_list,'freight_list'=>$freight_list,'unit'=>$unit,'s_type'=>$arr,'plugin_list'=>$Plugin_arr,'distributors'=>$distributors,'list'=>$r[0],'product_class_list1'=>$class,'brand_class_list1'=>$brand_class_list1,'freight_list1'=>$freight_list1,'distributors1'=>$distributors1,'attr'=>$attr_group_list,'attrList'=>$checked_attr_list,'unit'=>$unit,'show_adr'=>$show_adr1,'imgurls'=>$imgurls,'initial'=>$initial,'status'=>$status,'type_status'=>$type_status, 'message' => '成功！'));
                exit();
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 上传商品
    public function upload_merchandise(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $JurisdictionAction = new JurisdictionAction();
        $shop_id = trim($request->getParameter('shop_id'));
        $store_type = trim($request->getParameter('store_type'));
        if($store_type = 1){
            $store_type = '0';
        }elseif ($store_type = 2){
            $store_type = 'app';
        }
        $product_title = urldecode(addslashes(trim($request->getParameter('product_title')))); // 产品标题
        $subtitle = urldecode(addslashes(trim($request->getParameter('subtitle')))); // 小标题
        $scan = addslashes(trim($request->getParameter('scan'))); // 条形码
        $product_class_id = addslashes(trim($request->getParameter('product_class_id'))); // 产品类别
        $brand_id = addslashes(trim($request->getParameter('brand_id'))); // 品牌
        $keyword = urldecode(addslashes(trim($request->getParameter('keyword')))); // 关键词
        $weight = addslashes(trim($request->getParameter('weight'))); // 重量
        $initial = urldecode(addslashes(trim($request->getParameter('initial')))); // 初始值
        $attr = urldecode($request->getParameter('attr_group')); // 属性
        $attrList = urldecode($request->getParameter('attr_arr')); // 属性
        $freight_id = $request->getParameter('freight_id'); // 运费
        $display_position = $request->getParameter('display_position'); // 显示位置
        $s_type = $request->getParameter('s_type'); // 显示类型
        $active = $request->getParameter('active'); // 支持活动
        $distributor_id = trim($request->getParameter('distributor_id')); //关联的分销层级id
        $is_hexiao = $request->getParameter('is_hexiao'); // 是否支持线下核销
        $hxaddress = $request->getParameter('hxaddress'); // 核销地址
        $content = addslashes(trim($request->getParameter('content'))); // 产品内容
        $richList = addslashes(trim($request->getParameter('richList'))); // 产品数组内容
        $mch_status = addslashes(trim($request->getParameter('mch_status'))); // 产品内容
        $unit = urldecode(addslashes(trim($request->getParameter('unit')))); // 单位
        $min_inventory = urldecode(addslashes(trim($request->getParameter('stockWarn')))); // 库存预警
        $p_id = addslashes(trim($request->getParameter('p_id'))); // 产品id
        $call_num = addslashes(trim($request->getParameter('time'))); // 接口调用次数
        $for_num = addslashes(trim($request->getParameter('for_num'))); // 接口调用总次数

        $initial = htmlspecialchars_decode($initial); // 将特殊的 HTML 实体转换回普通字符
        $initial1 = explode(',',$initial); // 转数组

        $key = array();
        $val = array();
        foreach ($initial1 as $k => $v){
            $initial2 = explode('=',$v); // 转数组
            $key[] = $initial2[0];
            $val[] = $initial2[1];
        }

        $initial = array_combine($key,$val); // 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
        $initial = serialize($initial); // 序列化
        $attr = htmlspecialchars_decode($attr);
        $attr = json_decode($attr,true);
        $attrList = htmlspecialchars_decode($attrList);
        $attrList = json_decode($attrList,true);

        $content = htmlspecialchars_decode($content);
        $richList = htmlspecialchars_decode($richList);
        $user_id = $this->user_id;
        $user_name = $this->user_name;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0) {
            $mch_id = $r0[0]->id;
            if($mch_id != $shop_id){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);

                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }

        if ($product_title == '') {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，商品名称不能为空！';
            $this->mchLog($Log_content);

            echo json_encode(array('code' => 109,'message'=>'商品名称不能为空'));
            exit;
        }
        if(strlen($product_title) > 60){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，商品标题不能超过20个中文字长度！';
            $this->mchLog($Log_content);
            echo json_encode(array('status' => '商品标题不能超过20个中文字长度！'));
            exit;
        }

        if($p_id == '' || $p_id == 'undefined'){
            $sql_0 = "select id from lkt_product_list where store_id = '$store_id' and recycle = 0 and product_title = '$product_title' and mch_id = '$mch_id'";
            $r_0 = $db->select($sql_0);
            if($r_0){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，您有存在该商品,请勿重复添加！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 226,'message'=>'您有存在该商品,请勿重复添加！'));
                exit;
            }
        }

        if ($product_class_id == '0') {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，请选择商品类别！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message' => '请选择商品类别！'));
            exit;
        }else{
            $Tools = new Tools($db, $store_id, 1);
            $product_class_id = $Tools->str_option( $product_class_id);
        }
        if ($brand_id == '0') {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，请选择品牌！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请选择品牌！'));
            exit;
        }
        if($keyword == ''){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，请填写关键词！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请填写关键词！'));
            exit;
        }
        if($weight == ''){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，请填写商品重量！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请填写商品重量！'));
            exit;
        }else{
            if(is_numeric($weight)){
                if($weight < 0){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，重量不能为负数！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 109,'message'=>'重量不能为负数！'));
                    exit;
                }else{
                    $weight = number_format($weight,2,".", "");
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，重量请填写数字！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 109,'message'=>'重量请填写数字！'));
                exit;
            }
        }

        $z_num = 0;
        $attributes = array();
        //处理属性
        if (count($attrList) == 0) {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，请填写属性！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请填写属性！'));
            exit;
        } else {
            foreach ($attrList as $key => $value) {
                $attr_list = $value['attr_list'];
                $attr_list_arr = array();
                $attr_list_srt = '';
                foreach ($attr_list as $k => $v) {
                    $attr_list_arr[$v['attr_group_name']] = $v['attr_name'];
                    $attr_list_srt .= $v['attr_group_name'] . '-' . $v['attr_name'];
                }
                $z_num += $value['kucun'];
                $value['total_num'] = $value['kucun'];
                $value1['img'] = '';

                //价格判断
                foreach ($value as $cvkey => $cvvalue) {
                    if (!is_array($cvvalue)) {
                        if(empty($cvvalue) &&  $cvvalue != 0){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，请完善属性！';
                            $this->mchLog($Log_content);

                            echo json_encode(array('status' => "请完善属性！"));
                            exit;
                        }
                    }
                }
                $costprice = $value['cbj'];
                $yprice = $value['yj'];
                $price = $value['sj'];
                if ($costprice > $price) {
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，成本价不能大于售价！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('status' => "成本价不能大于售价！"));
                    exit;
                }

                $value['img'] = preg_replace('/.*\//', '', $value['img']);
                $value['attribute'] = serialize($attr_list_arr);
                $value = Tools::array_key_remove($value, 'attr_list');
                $attributes[$key]['costprice'] = $value['cbj'];
                $attributes[$key]['yprice'] = $value['yj'];
                $attributes[$key]['price'] = $value['sj'];
                $attributes[$key]['num'] = $value['kucun'];
                $attributes[$key]['total_num'] = $value['total_num'];
                $attributes[$key]['unit'] = $unit;
                $attributes[$key]['min_inventory'] = $min_inventory;
                $attributes[$key]['img'] = $value['img'];
                $attributes[$key]['attribute'] = $value['attribute'];
            }
        }

        if (!is_numeric($min_inventory) || strpos($min_inventory, ".") !== false) {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，库存预警请输入整数！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'库存预警请输入整数！'));
            exit;
        } else {
            if ($min_inventory <= 0) {
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，库存预警请输入大于0的整数！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 109,'message'=>'库存预警请输入大于0的整数！'));
                exit;
            }
        }
        if ($freight_id == 0) {
            $sql = "select id from lkt_freight where store_id = '$store_id' and is_default = 1";
            $rr = $db->select($sql);
            if ($rr) {
                $freight_id = $rr[0]->id;
            } else {
                $freight_id = 0;
            }
        }
        $s_type = $s_type ? $s_type:array();

        if (empty($active)) {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，请选择支持活动类型！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请选择支持活动类型！'));
            exit;
        }else {
            if($active == 1){
                $show_adr = trim($display_position,',');
                $is_distribution = 0;
            }else if($active == 5){
                $show_adr = 0;
                $is_distribution = 1;
            }else{
                $show_adr = 0;
                $is_distribution = 0;
            }
        }
        // 查询配置表信息
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        $uploadImg = $r[0]->uploadImg;
        $uploadImg_domain = $r[0]->uploadImg_domain;
        $upserver = !empty($r)?$r[0]->upserver:'2';   //如果没有设置配置则默认用阿里云
        // 图片上传位置
        if(empty($uploadImg)){
            $uploadImg = "../LKT/images";
        }

        $Tools = new Tools($db, $store_id, 1);

        $image_arr = array();
        $image_arr1 = array();
        $cache = array();
        if(!empty($_FILES)){ // 如果图片不为空
            if($upserver == '2'){
                $image = ServerPath::file_OSSupload($store_id, $store_type);
            }else{
                $image = ServerPath::file_upload($store_id,$uploadImg,$uploadImg_domain,$store_type);
            }

            if($image == false){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，上传失败或图片格式错误！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 109,'message'=>'上传失败或图片格式错误！'));
                exit;
            }else{
                $image = preg_replace('/.*\//', '', $image);
            }
            $image_arr1 = array('image'=>$image,'call_num'=>$call_num); // 图片数组

            $cache = array('user_id'=>$user_id,'p_id'=>$p_id,'image_arr'=>$image_arr1); // 缓存数组
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'上传商品时，没有上传图片！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'上传失败或图片格式错误！'));
            exit;
        }
        if($call_num + 1 != $for_num){ // 当前调用接口次数 不等于 总调用接口次数

            $res = $Tools->generate_session($db,$cache,1);

            echo json_encode(array('code' => 200,'p_id'=>$p_id,'message' => '成功！'));
            exit;
        }else{
            $rew = $Tools->obtain_session($db,$user_id,1,$p_id);
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
            foreach ($image_arr as $k => $v){
                if($v['call_num'] == 0){ // 当为第一次请求时
                    $image = $v['image'];
                    unset($image_arr[$k]); // 删除原图数组的某元素
                }
            }
            //进入正式添加---开启事物
            $db->begin();
            $sql0_0 = "select product_number from lkt_product_number where store_id = '$store_id' and mch_id = '$mch_id' and operation = '$user_name' and status = 1 order by addtime desc limit 1";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                $product_number = $r0_0[0]->product_number;
            }else{
                $product_number = '';
            }
            // 发布产品
            $sql = "insert into lkt_product_list(store_id,product_number,product_title,subtitle,scan,product_class,brand_id,keyword,weight,imgurl,content,richList,sort,num,min_inventory,show_adr,s_type,add_date,is_distribution,distributor_id,freight,is_hexiao,hxaddress,active,mch_id,mch_status,initial,publisher) " .
                "values('$store_id','$product_number','$product_title','$subtitle','$scan','$product_class_id','$brand_id','$keyword','$weight','$image','$content','$richList',1,'$z_num','$min_inventory','$show_adr','$s_type',CURRENT_TIMESTAMP,'$is_distribution','$distributor_id','$freight_id','$is_hexiao','$hxaddress','$active','$mch_id','$mch_status','$initial','$user_name')";
            $id1 = $db->insert($sql, 'last_insert_id'); // 得到添加数据的id
            if($id1){
                if(count($image_arr) != 0){
                    foreach ($image_arr as $k => $v){
                        $product_url = $v['image'];
                        $sql_x = "insert into lkt_product_img(product_url,product_id,add_date) values('$product_url','$id1',CURRENT_TIMESTAMP)";
                        $r_x = $db->insert($sql_x);
                        if($r_x > 0){
//                            $db->commit();
                        }else{
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加商品轮播图时，失败！';
                            $this->mchLog($Log_content);
                            $db->rollback();
                            echo json_encode(array('code' => 110,'message'=>'业务异常！'));
                            exit;
                        }
                    }
                }
                foreach ($attributes as $ke => $va){
                    $va['pid'] = $id1;
                    $va['img'] = $image;
                    $va['ctime'] = 'CURRENT_TIMESTAMP';
                    $r_attribute = $db->insert_array($va,'lkt_configure','',1);
                    if($r_attribute < 1){
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加商品属性时，失败！';
                        $this->mchLog($Log_content);
                        $db->rollback();
                        echo json_encode(array('code' => 110,'message'=>'业务异常！'));
                        exit;
                    }
                    $num = $va['num'];
                    // 在库存记录表里，添加一条入库信息
                    $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id1','$r_attribute','$num','$num',0,CURRENT_TIMESTAMP)";
                    $db->insert($sql);

                    if($min_inventory >= $num){ // 当属性库存低于等于预警值
                        // 在库存记录表里，添加一条预警信息
                        $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,add_date) values('$store_id','$id1','$r_attribute','$num','$num',2,CURRENT_TIMESTAMP)";
                        $db->insert($sql);
                    }
                }
                $db->commit();
                $JurisdictionAction->admin_record($store_id,$user_id,'添加商品'.$product_title,1);
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加商品'.$product_title.'！';
                $this->mchLog($Log_content);

                $res = $Tools->del_session($db,$user_id,1,$p_id);

                echo json_encode(array('code' => 200,'p_id'=>$id1,'message' => '成功！'));
            }else{
                $JurisdictionAction->admin_record($store_id,$user_id,'添加商品'.$product_title.'失败',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加商品失败！';
                $this->mchLog($Log_content);
                $db->rollback();

                echo json_encode(array('code' => 110,'message'=>'业务异常！'));
                exit;
            }
        }
    }
    // 我的商品
    public function my_merchandise(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));
        $type = trim($request->getParameter('type'));

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($shop_id == $mch_id){ // 判断传过来的店铺ID是否与查询出来的店铺信息匹配
                if($type == 1){
                    // 我的商品
                    $sql1 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,a.status,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.recycle = 0 group by c.pid  order by a.add_date desc LIMIT 10";
                }else{
                    // 待审核商品
                    $sql1 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.mch_status,a.refuse_reasons,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status != 2 and a.recycle = 0 group by c.pid  order by a.add_date desc LIMIT 10";
                }
                $r1 = $db->select($sql1);
                if($r1){
                    foreach($r1 as $k => $v){
                        //查询商品库存
                        $sql = "select SUM(num) as num from lkt_configure where pid = '$v->id'";
                        $res_n = $db->select($sql);
                        $r1[$k]->num = $res_n[0]->num;
                        $r1[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
                    }
                }
                echo json_encode(array('code' => 200,'list'=>$r1,'message' => '成功！' ));
                exit;
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 我的商品-加载更多
    public function my_merchandise_load(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));
        $type = trim($request->getParameter('type'));
        $pege = trim($request->getParameter('pege'));

        $start = $pege*10;
        $end = 10;

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($shop_id == $mch_id){ // 判断传过来的店铺ID是否与查询出来的店铺信息匹配
                if($type == 1){
                    // 我的商品
                    $sql1 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,a.status,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 group by c.pid  order by a.add_date desc LIMIT limit $start,$end";
                    $r1 = $db->select($sql1);
                    if($r1){
                        foreach($r1 as $k => $v){
                            //查询商品库存
                            $sql = "select SUM(num) as num from lkt_configure where pid = '$v->id'";
                            $res_n = $db->select($sql);
                            $r1[$k]->num = $res_n[0]->num;
                            $r1[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
                        }
                    }
                }else if($type == 2){
                    // 待审核商品
                    $sql1 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.mch_status,a.refuse_reasons,min(c.price) as price from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status != 2 group by c.pid  order by a.add_date desc LIMIT limit $start,$end";
                    $r1 = $db->select($sql1);
                    if($r1){
                        foreach($r1 as $k => $v){
                            //查询商品库存
                            $sql = "select SUM(num) as num from lkt_configure where pid = '$v->id'";
                            $res_n = $db->select($sql);
                            $r1[$k]->num = $res_n[0]->num;
                            $r1[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
                        }
                    }
                }
                echo json_encode(array('code' => 200,'list'=>$r1,'message' => '成功！' ));
                exit;
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 修改库存页面
    public function up_stock_page(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id')); // 商城ID
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $p_id = trim($request->getParameter('p_id')); // 商品ID
        $user_id = $this->user_id;

        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select b.id,b.num,b.min_inventory,b.attribute from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where a.store_id = '$store_id' and a.mch_id = '$mch_id' and a.id = '$p_id'";
                $r1 = $db->select($sql1);
                if($r1){
                    $attr_group_list = array();
                    $checked_attr_list = array();
                    $arrar_t = unserialize($r1[0]->attribute);

                    foreach ($arrar_t as $key => $value) {
                        $arr1[] = $key;
                        $attr_group_list[] = array('attrName'=>array($key),'attrValue' => array());

                    }
                    $num = count($attr_group_list);
                    if($num >1){
                        foreach ($r1 as $k => $v) {
                            $attribute = unserialize($v->attribute); // 属性
                            $attr_lists = array();

                            //列出属性名
                            foreach ($attribute as $key => $value) {
                                foreach ($attr_group_list as $keya => $valuea) {
                                    if ($key == $valuea['attrName'][0]) {
                                        if (!in_array($value, $attr_group_list[$keya]['attrValue'])) {
                                            $attr_list = $value;
                                            array_push($attr_group_list[$keya]['attrValue'], $attr_list);
                                        }
                                    }
                                }
                                $attr_lists[] = array('name' => $key, 'value' => $value);
                            }
                            foreach ($attr_lists as $ke => $va){
                                $attr_lists[$ke]['stock'] = (int)$v->num;
                                $attr_lists[$ke]['stockWarn'] = (int)$v->min_inventory;
                                $attr_lists[$ke]['cid'] = $v->id;
                                $attr_lists[$ke]['addStockNum'] = 0;
                            }
                            $checked_attr_list[] = $attr_lists;
                        }
                        foreach ($attr_group_list as $key => $value) {
                            $attr_group_list[$key] = Tools::array_key_remove($attr_group_list[$key], 'attr_all');
                        }
                    }else{
                        foreach ($r1 as $k => $v) {
                            $attribute = unserialize($v->attribute); // 属性
                            $attr_lists = array();

                            //列出属性名
                            foreach ($attribute as $key => $value) {
                                foreach ($attr_group_list as $keya => $valuea) {
                                    if ($key == $valuea['attrName'][0]) {
                                        if (!in_array($value, $attr_group_list[$keya]['attrValue'])) {
                                            $attr_list = $value;
                                            array_push($attr_group_list[$keya]['attrValue'], $attr_list);
                                        }
                                    }
                                }
                                $attr_lists = array('name' => $key, 'value' => $value);
                            }
                            $checked_attr_list[] = array('name' => $attr_lists['name'],'value'=> $attr_lists['value'], 'stock' => (int)$v->num, 'stockWarn' => (int)$v->min_inventory, 'cid' => $v->id,'addStockNum'=>0);
                        }
                    }
                    echo json_encode(array('code' => 200,'attr'=>$attr_group_list,'attrList'=>$checked_attr_list,'message' => '成功！' ));
                    exit;
                }else{
                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 修改库存
    public function up_stock(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $db->begin();

        $store_id = trim($request->getParameter('store_id')); // 商城ID
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $p_id = trim($request->getParameter('p_id')); // 商品ID
        $number = trim($request->getParameter('number')); // 数量数组
        $user_id = $this->user_id;
        $number = explode(',',$number);
        $z_num = 0;
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0) {
            $mch_id = $r0[0]->id;
            if ($mch_id == $shop_id) {
                $sql1 = "select b.id,b.num,b.total_num from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where a.store_id = '$store_id' and a.mch_id = '$mch_id' and a.id = '$p_id'";
                $r1 = $db->select($sql1);
                if($r1){
                    foreach ($r1 as $k => $v) {
                        $sid = $v->id;
                        $z_num = $z_num + $number[$k];
                        $total_num = $v->total_num + $number[$k];
                        $num = $v->num + $number[$k];
                        if($num < 0){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品ID为'.$p_id.'属性ID为'.$sid.'的库存时，库存错误！';
                            $this->mchLog($Log_content);
                            $db->rollback();

                            echo json_encode(array('code' => 109,'message'=>'剩余库存不能低于0！'));
                            exit;
                        }else{
                            $sql2 = "update lkt_configure set total_num = '$total_num',num = '$num' where pid = '$p_id' and id = '$sid'";
                            $r2 = $db->update($sql2);
                            if($r2 == -1){
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品ID为'.$p_id.'属性ID为'.$sid.'的库存时，修改失败！';
                                $this->mchLog($Log_content);
                                $db->rollback();
                                echo json_encode(array('code' => 103,'message'=>'网络繁忙！'));
                                exit;
                            }else{
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品ID为'.$p_id.'属性ID为'.$sid.'的库存时，修改成功！';
                                $this->mchLog($Log_content);
                            }
                        }
                    }
                    $sql3 = "update lkt_product_list set num = num + '$total_num' where id = '$p_id'";
                    $r3 = $db->update($sql3);
                    if($r3 == -1){
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品ID为'.$p_id.'的库存时，修改失败！';
                        $this->mchLog($Log_content);
                        $db->rollback();
                        echo json_encode(array('code' => 103,'message'=>'网络繁忙！'));
                        exit;
                    }else{
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品ID为'.$p_id.'的库存时，修改成功！';
                        $this->mchLog($Log_content);
                    }
                    $db->commit();

                    echo json_encode(array('code' => 200,'message' => '成功！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改库存时，商品ID'.$p_id.'错误！';
                    $this->mchLog($Log_content);

                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);

                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);

            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 提交审核/撤销审核
    public function submit_audit(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $db->begin();

        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));
        $p_id = trim($request->getParameter('p_id'));

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($shop_id == $mch_id){ // 判断传过来的店铺ID是否与查询出来的店铺信息匹配
                $sql1 = "select id,mch_status from lkt_product_list where store_id = '$store_id' and recycle = 0 and id = '$p_id'";
                $r1 = $db->select($sql1);
                if($r1){
                    if($r1[0]->mch_status == 1){
                        $sql2 = "update lkt_product_list set mch_status = 4 where store_id = '$store_id' and id = '$p_id'";
                    }else if($r1[0]->mch_status == 4){
                        $sql2 = "update lkt_product_list set mch_status = 1 where store_id = '$store_id' and id = '$p_id'";
                    }
                    $r2 = $db->update($sql2);
                    if($r2 > 0){
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'提交或撤销商品ID为'.$p_id.'的审核成功！';
                        $this->mchLog($Log_content);
                        $db->commit();

                        echo json_encode(array('code' => 200,'message' => '成功！' ));
                        exit;
                    }else{
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'提交或撤销商品ID为'.$p_id.'的审核失败！';
                        $this->mchLog($Log_content);
                        $db->rollback();

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                        exit;
                    }
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'提交或撤销商品时，商品ID'.$p_id.'错误！';
                    $this->mchLog($Log_content);

                    echo json_encode(array('code' => 109,'message' => '商品ID错误！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 删除我的商品
    public function del_my_merchandise(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));
        $p_id = trim($request->getParameter('p_id'));

        $user_id = $this->user_id;
        $db->begin();

        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($shop_id == $mch_id){ // 判断传过来的店铺ID是否与查询出来的店铺信息匹配
                $this->commodity_status($db,$store_id,$p_id);
                $sql1 = "select id from lkt_product_list where store_id = '$store_id' and recycle = 0 and id = '$p_id'";
                $r1 = $db->select($sql1);
                if($r1){
                    $sql2 = "update lkt_product_list set recycle = 1 where store_id = '$store_id' and id = '$p_id'";
                    $r2 = $db->update($sql2);
                    if($r2 > 0){
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'删除商品ID为'.$p_id.'成功！';
                        $this->mchLog($Log_content);
                        $db->commit();

                        echo json_encode(array('code' => 200,'message' => '成功！' ));
                        exit;
                    }else{
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'删除商品ID为'.$p_id.'失败！';
                        $this->mchLog($Log_content);
                        $db->rollback();

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                        exit;
                    }
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'提交或撤销商品时，商品ID'.$p_id.'错误！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 109,'message' => '商品ID错误！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 我的商品上下架
    public function my_merchandise_status(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));
        $p_id = trim($request->getParameter('p_id'));
        $status = trim($request->getParameter('status'));

        $user_id = $this->user_id;
        $db->begin();

        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($shop_id == $mch_id){ // 判断传过来的店铺ID是否与查询出来的店铺信息匹配
                $this->commodity_status($db,$store_id,$p_id);

                $sql1 = "select id from lkt_product_list where store_id = '$store_id' and recycle = 0 and id = '$p_id'";
                $r1 = $db->select($sql1);
                if($r1){
                    if($status == 2){ // 上架
                        $rew = '下架';
                        $sql2 = "update lkt_product_list set status = 3 where store_id = '$store_id' and id = '$p_id'";
                    }else{ // 下架
                        $rew = '上架';
                        $sql2 = "update lkt_product_list set status = 2 where store_id = '$store_id' and id = '$p_id'";
                    }
                    $r2 = $db->update($sql2);
                    if($r2 > 0){
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'商品ID为'.$p_id.$rew.'成功！';
                        $this->mchLog($Log_content);
                        $db->commit();

                        echo json_encode(array('code' => 200,'message' => '成功！' ));
                        exit;
                    }else{
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'删除商品ID为'.$p_id.$rew.'失败！';
                        $this->mchLog($Log_content);
                        $db->rollback();

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                        exit;
                    }
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'提交或撤销商品时，商品ID'.$p_id.'错误！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 109,'message' => '商品ID错误！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 重新编辑
    public function re_edit(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        if($store_type = 1){
            $store_type = '0';
        }elseif ($store_type = 2){
            $store_type = 'app';
        }
        $JurisdictionAction = new JurisdictionAction();

        $p_id = addslashes(trim($request->getParameter('p_id'))); // 产品id
        $product_title = urldecode(addslashes(trim($request->getParameter('product_title')))); // 产品标题
        $subtitle = urldecode(addslashes(trim($request->getParameter('subtitle')))); // 小标题
        $scan = addslashes(trim($request->getParameter('scan'))); // 条形码
        $product_class_id = addslashes(trim($request->getParameter('product_class_id'))); // 产品类别
        $brand_id = addslashes(trim($request->getParameter('brand_id'))); // 品牌
        $keyword = urldecode(addslashes(trim($request->getParameter('keyword')))); // 关键词
        $weight = addslashes(trim($request->getParameter('weight'))); // 重量
        $initial = urldecode(addslashes(trim($request->getParameter('initial')))); // 初始值
        $attr = urldecode($request->getParameter('attr_group')); // 属性
        $attrList = urldecode($request->getParameter('attr_arr')); // 属性
        $richList = $request->getParameter('richList'); // 商品详情
        $freight_id = $request->getParameter('freight_id'); // 运费
        $display_position = $request->getParameter('display_position'); // 显示位置
        $s_type = $request->getParameter('s_type'); // 显示类型
        $active = $request->getParameter('active'); // 支持活动
        $is_distribution = trim($request->getParameter('is_distribution')); //是否开启分销
        $distributor_id = trim($request->getParameter('distributor_id')); //关联的分销层级id
        $is_hexiao = $request->getParameter('is_hexiao'); // 是否支持线下核销
        $hxaddress = $request->getParameter('hxaddress'); // 核销地址
        $content = addslashes(trim($request->getParameter('content'))); // 产品内容
        $content = htmlspecialchars_decode($content);
        $mch_status = addslashes(trim($request->getParameter('mch_status'))); // 商品审核状态
        $showImgOld = addslashes(trim($request->getParameter('showImgOld'))); // 产品图片(原图)
        $firstPage = addslashes(trim($request->getParameter('firstPage'))); // 产品图片
        $unit = urldecode(addslashes(trim($request->getParameter('unit')))); // 产品单位
        $min_inventory = urldecode(addslashes(trim($request->getParameter('stockWarn')))); // 库存预警
        $call_num = addslashes(trim($request->getParameter('time'))); // 接口调用次数
        $for_num = addslashes(trim($request->getParameter('for_num'))); // 接口调用总次数

        $initial = htmlspecialchars_decode($initial); // 将特殊的 HTML 实体转换回普通字符
        $initial1 = explode(',',$initial); // 转数组
        $key = array();
        $val = array();
        foreach ($initial1 as $k => $v){
            $initial2 = explode('=',$v); // 转数组
            $key[] = $initial2[0];
            $val[] = $initial2[1];
        }

        $initial = array_combine($key,$val); // 创建一个数组，用一个数组的值作为其键名，另一个数组的值作为其值
        $initial = serialize($initial); // 序列化

        $attr = htmlspecialchars_decode($attr);
        $attr = json_decode($attr,true);
        $attrList = htmlspecialchars_decode($attrList);
        $attrList = json_decode($attrList,true);
        $richList = htmlspecialchars_decode($richList);

        $user_id = $this->user_id;
        $user_name = $this->user_name;

        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
        if ($product_title == '') {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，商品名称不能为空！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'商品名称不能为空'));
            exit;
        }
        if(strlen($product_title) > 60){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，商品标题不能超过20个中文字长度！';
            $this->mchLog($Log_content);
            echo json_encode(array('status' => '商品标题不能超过20个中文字长度！'));
            exit;
        }
        $sql_0 = "select id from lkt_product_list where store_id = '$store_id' and recycle = 0 and product_title = '$product_title' and mch_id = '$mch_id' id != '$p_id'";
        $r_0 = $db->select($sql_0);
        if($r_0){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，您有存在该商品,请勿重复添加！';
            $this->mchLog($Log_content);

            echo json_encode(array('code' => 226,'message'=>'您有存在该商品,请勿重复添加！'));
            exit;
        }
        $sql_1 = "select id,imgurl from lkt_product_list where store_id = '$store_id' and recycle = 0 and mch_id = '$mch_id' and id = '$p_id'";
        $r_1 = $db->select($sql_1);
        if($r_1){
            $imgurl = ServerPath::getimgpath($r_1[0]->imgurl); //图片
        }

        if($product_class_id == '0') {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，请选择商品类别！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message' => '请选择商品类别！'));
            exit;
        }else{
            $Tools = new Tools($db, $store_id, 1);
            $product_class_id = $Tools->str_option( $product_class_id);
        }
        if($brand_id == '0') {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，请选择品牌！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请选择品牌！'));
            exit;
        }
        if($keyword == ''){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，请填写关键词！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请填写关键词！'));
            exit;
        }
        if($weight == ''){
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，请填写商品重量！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请填写商品重量！'));
            exit;
        }else{
            if(is_numeric($weight)){
                if($weight < 0){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，重量不能为负数！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 109,'message'=>'重量不能为负数！'));
                    exit;
                }else{
                    $weight = number_format($weight,2,".", "");
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，重量请填写数字！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 109,'message'=>'重量请填写数字！'));
                exit;
            }
        }

        $z_num = 0;
        $attributes = array();
        //处理属性
        if (count($attrList) == 0) {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，请填写属性！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请填写属性！'));
            exit;
        } else {
            foreach ($attrList as $key => $value) {
                $cid = $value['cid'];
                $attr_list = $value['attr_list'];
                $attr_list_arr = array();
                $attr_list_srt = '';
                foreach ($attr_list as $k => $v) {
                    $attr_list_arr[$v['attr_group_name']] = $v['attr_name'];
                    $attr_list_srt .= $v['attr_group_name'] . '-' . $v['attr_name'];
                }
                $z_num += $value['kucun'];
                $value['total_num'] = $value['kucun'];
                $value1['img'] = '';

                //价格判断
                foreach ($value as $cvkey => $cvvalue) {
                    if (!is_array($cvvalue)) {
                        if(empty($cvvalue) &&  $cvvalue != 0){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，请完善属性！';
                            $this->mchLog($Log_content);
                            echo json_encode(array('status' => "请完善属性！"));
                            exit;
                        }
                    }
                }
                $costprice = $value['cbj'];
                $yprice = $value['yj'];
                $price = $value['sj'];
                if ($costprice > $price) {
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，成本价不能大于售价！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('status' => "成本价不能大于售价！"));
                    exit;
                }
                if($cid != 0 && $cid != '' ){
                    $sql0_0 = "select total_num,num from lkt_configure where id = '$cid'";
                    $r0_0 = $db->select($sql0_0);
                    $total_num = $r0_0[0]->total_num; // 总库存数
                    $num = $r0_0[0]->num; // 剩余数量
                    if($value['kucun'] == $total_num) { // 当传过来的数量 等于 总库存数，表示没有改变了数量
                        $attributes[$key]['num'] = $num;
                        $attributes[$key]['total_num'] = $total_num;
                    }else{
                        $total_num1 = $total_num - $value['stock']; // 总库存数 - 传过来的数量
                        if($total_num1 > 0){ // 大于0，表示减少总库存
                            if($num - $total_num1 < 0){ // 小于0，表示剩余库存低于0
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，'.$value['value'].':'.$value['name'].'数量低于库存数！';
                                $this->mchLog($Log_content);
                                echo json_encode(array('code' => 109,'message'=>$value['value'].':'.$value['name'].'数量低于库存数！'));
                                exit;
                            }else{ // 大于0，表示剩余库存大于0
                                $attributes['total_num'] = $value['stock'];
                                $attributes['num'] = $num - $total_num1;
                            }
                        }else{ // 小于0，表示增加总库存
                            $attributes['total_num'] = $value['stock'];
                            $attributes['num'] = $num - $total_num1;
                        }
                    }
                }else{
                    $attributes['num'] = $value['stock'];
                    $attributes['total_num'] = $value['stock'];
                }
                $value['img'] = preg_replace('/.*\//', '', $value['img']);
                $value['attribute'] = serialize($attr_list_arr);
                $value = Tools::array_key_remove($value, 'attr_list');

                $attributes[$key]['cid'] = $value['cid'];
                $attributes[$key]['costprice'] = $value['cbj'];
                $attributes[$key]['yprice'] = $value['yj'];
                $attributes[$key]['price'] = $value['sj'];
                $attributes[$key]['unit'] = $unit;
                $attributes[$key]['min_inventory'] = $min_inventory;
                $attributes[$key]['img'] = $value['img'];
                $attributes[$key]['attribute'] = $value['attribute'];
            }
        }

        if(!is_numeric($min_inventory) || strpos($min_inventory, ".") !== false) {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，库存预警请输入整数！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'库存预警请输入整数！'));
            exit;
        } else {
            if ($min_inventory <= 0) {
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，库存预警请输入大于0的整数！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 109,'message'=>'库存预警请输入大于0的整数！'));
                exit;
            }
        }

        if($freight_id == 0) {
            $sql = "select id from lkt_freight where store_id = '$store_id' and is_default = 1";
            $rr = $db->select($sql);
            if ($rr) {
                $freight_id = $rr[0]->id;
            } else {
                $freight_id = 0;
            }
        }
        $s_type = $s_type ? $s_type:array();
        if(empty($active)) {
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，请选择支持活动类型！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 109,'message'=>'请选择支持活动类型！'));
            exit;
        }else {
            if($active == 1){
                if($display_position == '' || $display_position == 'undefined' || empty($display_position)){
                    $display_position = 0;
                }
                $show_adr = trim($display_position,',');
                $is_distribution = 0;
                $distributor_id = 0;
            }else if($active == 5){
                $show_adr = 0;
                $is_distribution = 1;
            }else{
                $show_adr = 0;
                $is_distribution = 0;
                $distributor_id = 0;
            }
        }
        // 查询配置表信息
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        $uploadImg = $r[0]->uploadImg;
        $uploadImg_domain = $r[0]->uploadImg_domain;
        $upserver = !empty($r)?$r[0]->upserver:'2';   //如果没有设置配置则默认用阿里云
        // 图片上传位置
        if(empty($uploadImg)){
            $uploadImg = "../LKT/images";
        }
        $Tools = new Tools($db, $store_id, 1);
        $image_arr = array();
        $image_arr1 = array();
        $cache = array();

        if(!empty($_FILES)){ // 当有新图上传时
            if($upserver == '2'){
                $image = ServerPath::file_OSSupload($store_id, $store_type);
            }else{
                $image = ServerPath::file_upload($store_id,$uploadImg,$uploadImg_domain,$store_type);
            }
            if($image == false){
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，上传失败或图片格式错误！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 109,'message'=>'上传失败或图片格式错误！'));
                exit;
            }else{
                $image = preg_replace('/.*\//', '', $image);
            }

            $image_arr1 = array('image'=>$image,'call_num'=>$call_num); // 图片数组

            $cache = array('user_id'=>$user_id,'p_id'=>$p_id,'image_arr'=>$image_arr1); // 缓存数组
        }

        if($call_num + 1 != $for_num){ // 当前调用接口次数 不等于 总调用接口次数
            $res = $Tools->generate_session($db,$cache,1);

            if($res == 1){
                echo json_encode(array('code' => 200,'p_id'=>$p_id,'message' => '成功！'));
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑商品时，网络繁忙！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 103,'message' => '网络繁忙！'));
            }
            exit;
        }else{
            $rew = $Tools->obtain_session($db,$user_id,1,$p_id);
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
            $showImgOld = explode(',',$showImgOld);

            //进入正式添加---开启事物
            $db->begin();
            $image = '';
            // 删除以前的商品轮播图
            $sql_y = "delete from lkt_product_img where product_id = '$p_id'";
            $db->delete($sql_y);
            if(in_array($firstPage,$showImgOld)) { // 第一张图是原图
                // 去掉原图数组中的主图
                foreach ($showImgOld as $k => $v){
                    if($v == $firstPage){
                        unset($showImgOld[$k]);
                    }
                }
                $image = preg_replace('/.*\//', '', $firstPage); // 主图
            }else{ // 当第一张为新图时
                foreach ($image_arr as $k => $v){
                    if($v['call_num'] == 0){ // 当为第一次请求时
                        $image = $v['image'];
                        unset($image_arr[$k]); // 删除原图数组的某元素
                    }
                }
            }

            if(!empty($_FILES)) { // 当有新图上传时
                if(count($image_arr) != 0){
                    foreach ($image_arr as $k => $v){
                        $product_url = $v['image'];
                        $sql_x = "insert into lkt_product_img(product_url,product_id,add_date) values('$product_url','$p_id',CURRENT_TIMESTAMP)";
                        $r_x = $db->insert($sql_x);
                        if($r_x > 0){
//                            $db->commit();
                        }else{
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加商品ID为'.$p_id.'的轮播图时失败！';
                            $this->mchLog($Log_content);
                            $db->rollback();
                            echo json_encode(array('code' => 110,'message'=>'业务异常！'));
                            exit;
                        }
                    }
                }
            }

            if(count($showImgOld) != 0){
                foreach ($showImgOld as $k => $v){
                    $v = preg_replace('/.*\//', '', $v);
                    if($v != ''){
                        $sql_img = "insert into lkt_product_img(product_url,product_id,add_date) values('$v','$p_id',CURRENT_TIMESTAMP)";
                        $r = $db->insert($sql_img);
                        if($r > 0){
//                            $db->commit();
                        }else{
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加商品ID为'.$p_id.'的轮播图时失败！';
                            $this->mchLog($Log_content);
                            $db->rollback();
                            echo json_encode(array('code' => 110,'message'=>'业务异常！'));
                            exit;
                        }
                    }
                }
            }
            // 修改产品
            $sql = "update lkt_product_list set product_title = '$product_title',subtitle = '$subtitle',scan = '$scan',product_class = '$product_class_id',brand_id = '$brand_id',keyword = '$keyword',weight = '$weight',imgurl='$image',content = '$content',richList='$richList',num = '$z_num',min_inventory = '$min_inventory',show_adr = '$show_adr',initial='$initial',s_type = '$s_type',is_distribution = '$is_distribution',distributor_id = '$distributor_id',freight = '$freight_id',is_hexiao = '$is_hexiao',hxaddress = '$hxaddress',active = '$active',mch_status = '$mch_status' where store_id = '$store_id' and mch_id = '$mch_id' and id = '$p_id'";
            $r = $db->update($sql);
            if($r != -1){
                $c_num = 0;
                $cids = array();
                if ($attributes) {
                    $sql = "select id from lkt_configure where pid = '$p_id'";
                    $rcs = $db->select($sql);
                    if ($rcs) {
                        foreach ($rcs as $keyc => $valuec) {
                            $cids[$valuec->id] = $valuec->id;
                        }
                    }
                }
                foreach ($attributes as $ke => $va) {
                    $num = $va['num'];
                    $c_num += $num;
                    $cid = $va['cid'];
                    $va['img'] = $image;

                    $va['ctime'] = 'CURRENT_TIMESTAMP';
                    $va = Tools::array_key_remove($va, 'cid');
                    if ($cid) {
                        if (array_key_exists($cid, $cids)) {
                            unset($cids[$cid]);
                        }
                        $r_attribute = $db->modify($va, 'lkt_configure', " `id` = '$cid'");
                        if ($r_attribute != 1) {
                            $r_attribute = $db->modify($va, 'lkt_configure', " `id` = '$cid'", 1);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品ID为'.$p_id.'属性ID为'.$cid.'时失败！';
                            $this->mchLog($Log_content);
                            $db->rollback();
                            echo json_encode(array('code' => 103,'message'=>'网络繁忙！'));
                            exit;
                        }
                        $ccc = $db->select("select num from lkt_configure where id = '$cid' ");
                        $cnums = $ccc ? $ccc[0]->num : 0;
                        $num = $num - $cnums;
                    } else {
                        $va['pid'] = $p_id;
                        $r_attribute = $db->insert_array($va, 'lkt_configure', '', 1);
                        if ($r_attribute < 1) {
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加商品ID为'.$p_id.'的属性时失败！';
                            $this->mchLog($Log_content);
                            $db->rollback();
                            echo json_encode(array('code' => 103,'message'=>'网络繁忙！'));
                            exit;
                        }
                    }

                    if ($num > 0) {
                        // 在库存记录表里，添加一条入库信息
                        $sql = "insert into lkt_stock(store_id,product_id,attribute_id,flowing_num,type,add_date) values('$store_id','$p_id','$r_attribute','$num',0,CURRENT_TIMESTAMP)";
                        $db->insert($sql);
                        if ($min_inventory >= $num) { // 当属性库存低于等于预警值
                            // 在库存记录表里，添加一条预警信息
                            $sql = "insert into lkt_stock(store_id,product_id,attribute_id,flowing_num,type,add_date) values('$store_id','$p_id','$r_attribute','$num',2,CURRENT_TIMESTAMP)";
                            $db->insert($sql);
                        }
                    }
                }
                //删除属性
                if (!empty($cids)) {
                    foreach ($cids as $keyds => $valueds) {
                        $db->delete("DELETE FROM `lkt_configure` WHERE (`id`='$valueds')");
                    }
                }

                if ($c_num < 1) {
                    $sql_1 = "update lkt_product_list set status='3' where id = '$p_id'";
                } else {
                    $sql_1 = "update lkt_product_list set status='2' where id = '$p_id'";
                }
                $r_update = $db->update($sql_1);

                $JurisdictionAction->admin_record($store_id,$user_id,'修改商品ID为'.$p_id,2);
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品ID为'.$p_id.'成功';
                $this->mchLog($Log_content);

                $res = $Tools->del_session($db,$user_id,1,$p_id);
                $db->commit();

                echo json_encode(array('code' => 200,'p_id'=>$p_id,'message' => '成功！'));
                exit;
            }else{
                $JurisdictionAction->admin_record($store_id,$user_id,'修改商品ID为'.$p_id.'失败',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品ID为'.$p_id.'失败';
                $this->mchLog($Log_content);

                $db->rollback();

                echo json_encode(array('code' => 110,'message'=>'业务异常！'));
                exit;
            }
        }
    }
    // 店铺主页
    public function store_homepage(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));
        $access_id = trim($request->getParameter('access_id')); // 授权id

        $type = trim($request->getParameter('type'));

        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id;
        }
        if(empty($user_id)){
            $collection_status = 0; // 未收藏
        }else{
            $sql = "select id from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and mch_id = '$shop_id'";
            $r = $db->select($sql);
            if($r){
                $collection_status = 1; // 已收藏
            }else{
                $collection_status = 0; // 未收藏
            }
        }
        $res = array();

        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id,name,logo from lkt_mch where store_id = '$store_id' and id = '$shop_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $shop_name = $r0[0]->name; // 店铺名称
            $shop_logo = ServerPath::getimgpath($r0[0]->logo,$store_id); // 店铺logo
            $quantity_on_sale = 0; // 在售数量
            $quantity_sold = 0; // 已售数量
            $product_class = array();

            $sql0_0 = "select id from lkt_user_collection where store_id = '$store_id' and mch_id = '$shop_id'";
            $r0_0 = $db->select($sql0_0);
            $collection_num = count($r0_0);

            $sql1 = "select id,product_class from lkt_product_list where store_id = '$store_id' and mch_id = '$shop_id' and mch_status = 2 and status = 2 and recycle = 0 and active = 1 order by add_date desc ";
            $r1 = $db->select($sql1);
            $quantity_on_sale = count($r1);
            $res = array();
            if($type == 1){
                $sql_3 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid  order by a.volume desc LIMIT 10";
                $r_3 = $db->select($sql_3);
                if($r_3){
                    foreach($r_3 as $k => $v){
                        $r_3[$k]->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                    }
                    $res = $r_3;
                }
            }else if($type == 2){
                $sql_3 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid  order by a.add_date desc LIMIT 10";
                $r_3 = $db->select($sql_3);
                if($r_3){
                    foreach($r_3 as $k => $v) {
                        $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                    }
                    $res = $r_3;
                }
            }else if($type == 3){
                if($r1){
                    foreach($r1 as $k => $v) {
                        $v->product_class = ltrim($v->product_class, "-"); // 去掉字符串前面的'-'
                        $v->product_class = substr($v->product_class,0,strpos($v->product_class, '-')); // 截取字符串第一个'-'前面的内容
                        $product_class[] = $v->product_class;
                    }
                    $product_class = array_unique($product_class);
                    foreach ($product_class as $key => $value) {
                        $cid = $value;
                        $sql_c = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid' order by sort ";
                        $r_c = $db->select($sql_c);
                        if($r_c){
                            $res[] = $r_c[0];
                        }
                    }
                }
            }

            $sql_3 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid ";
            $r3 = $db->select($sql_3);
            if($r3){
                foreach($r3 as $k => $v){
                    $quantity_sold += $v->volume;  // 已售数量
                }
            }

            $sql_4 = "select * from lkt_mch_store where store_id = '$store_id' and mch_id = '$shop_id' ";
            $r4 = $db->select($sql_4);

            $data = array('shop_name'=>$shop_name,'shop_logo'=>$shop_logo,'collection_num'=>$collection_num,'collection_status'=>$collection_status,'quantity_on_sale'=>$quantity_on_sale,'quantity_sold'=>$quantity_sold,'list'=>$res,'shop_list'=>$r4);

            echo json_encode(array('code' => 200,'data'=>$data,'message' => '成功！' ));
            exit;
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵1！' ));
            exit;
        }
    }
    // 店铺主页-加载更多
    public function store_homepage_load(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $type = trim($request->getParameter('type'));

        $page = trim($request->getParameter('page'));

        $start = $page*10;
        $end = 10;
        if($type == 1){
            $sql0 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid  order by a.volume desc LIMIT $start,$end";
        }else if($type == 2){
            $sql0 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.mch_status = 2 and a.status = 2 and a.recycle = 0 and a.active = 1 group by c.pid  order by a.add_date desc LIMIT $start,$end";
        }
        $r0 = $db->select($sql0);
        if($r0){
            foreach($r0 as $k => $v){
                $r0[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
            }
        }
        echo json_encode(array('code' => 200,'list'=>$r0,'message' => '成功！' ));
        exit;
    }
    // 店铺主页-点击商品分类
    public function store_homepage_cid(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $c_id = trim($request->getParameter('c_id')); // 分类ID
        $sql0 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.mch_id = '$shop_id' and a.status = 2 and a.product_class like '%-$c_id-%' group by c.pid  order by a.add_date desc LIMIT 10";
        $r0 = $db->select($sql0);
        if($r0){
            foreach($r0 as $k => $v){
                $r0[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
            }
        }
        echo json_encode(array('code' => 200,'list'=>$r0,'message' => '成功！' ));
        exit;
    }
    // 店铺主页-点击商品分类-加载更多
    public function store_homepage_cid_load(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $c_id = trim($request->getParameter('c_id')); // 分类ID
        $pege = trim($request->getParameter('pege'));

        $start = $pege*10;
        $end = 10;

        $sql0 = "select a.id,a.product_title,a.subtitle,a.imgurl,a.volume,min(c.price) as price,c.yprice from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and mch_id = '$shop_id' and a.status = 2 and product_class like '%-$c_id-%' group by c.pid  order by a.add_date desc LIMIT $start,$end";
        $r0 = $db->select($sql0);
        if($r0){
            foreach($r0 as $k => $v){
                $r0[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
            }
        }
        echo json_encode(array('code' => 200,'list'=>$r0,'message' => '成功！' ));
        exit;
    }
    // 店铺点击收藏按钮
    public function collection_shop(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $db->begin();

        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $user_id = $this->user_id;

        $sql0 = "select * from lkt_user_collection where store_id = '$store_id' and user_id = '$user_id' and mch_id = '$shop_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $sql1 = "delete from lkt_user_collection where store_id = '$store_id' and mch_id = '$shop_id' and user_id = '$user_id'";
            $r1 = $db->delete($sql1);
            if($r1 > 0){
                $sql2 = "update lkt_mch set collection_num = collection_num - 1 where store_id = '$store_id' and id = '$shop_id' ";
                $db->update($sql2);

                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'取消收藏，店铺ID为'.$shop_id.'成功！';
                $this->mchLog($Log_content);
                $db->commit();

                echo json_encode(array('code'=>200,'message'=>'取消成功！'));
                exit();
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'取消收藏，店铺ID为'.$shop_id.'失败！';
                $this->mchLog($Log_content);
                $db->rollback();

                echo json_encode(array('code'=>105,'message'=>'网络繁忙！'));
                exit();
            }
        }else{
            // 在收藏表里添加一条数据
            $sql1 = "insert into lkt_user_collection(store_id,user_id,mch_id,add_time) values('$store_id','$user_id','$shop_id',CURRENT_TIMESTAMP)";
            $r1 = $db->insert($sql1,'last_insert_id');
            if($r1 > 0){
                $sql2 = "update lkt_mch set collection_num = collection_num + 1 where store_id = '$store_id' and id = '$shop_id' ";
                $db->update($sql2);

                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加收藏，店铺ID为'.$shop_id.'成功！';
                $this->mchLog($Log_content);
                $db->commit();

                echo json_encode(array('code'=>200,'message'=>'收藏成功！'));
                exit();
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加收藏，店铺ID为'.$shop_id.'失败！';
                $this->mchLog($Log_content);
                $db->rollback();

                echo json_encode(array('code'=>105,'message'=>'网络繁忙！'));
                exit();
            }
        }
    }
    // 进入设置店铺
    public function into_set_shop(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id,logo,name,shop_information,shop_range,realname,ID_number,tel,address from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            $r0[0]->logo = ServerPath::getimgpath($r0[0]->logo,$store_id);

            if($mch_id == $shop_id){
                echo json_encode(array('code' => 200,'list'=>$r0,'message' => '成功！' ));
                exit;
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 设置店铺
    public function set_shop(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $db->begin();

        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $store_type = trim($request->getParameter('store_type'));
        if($store_type = 1){
            $store_type = '0';
        }elseif ($store_type = 2){
            $store_type = 'app';
        }
        $name = $request->getParameter('name'); // 店铺名称
        $shop_information = $request->getParameter('shop_information'); // 店铺信息
        $realname = $request->getParameter('realname'); // 真实姓名
        $ID_number = $request->getParameter('ID_number'); // 身份证
        $tel = $request->getParameter('tel'); // 联系电话
        $address = $request->getParameter('address'); // 联系地址
        $shop_range = $request->getParameter('shop_range'); // 经营范围
        $user_id = $this->user_id;

        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                if(!empty($_FILES)){
                    // 查询配置表信息
                    $sql = "select * from lkt_config where store_id = '$store_id'";
                    $r = $db->select($sql);

                    $uploadImg = $r[0]->uploadImg;
                    $uploadImg_domain = $r[0]->uploadImg_domain;
                    $upserver = !empty($r)?$r[0]->upserver:'2';   //如果没有设置配置则默认用阿里云
                    // 图片上传位置
                    if(empty($uploadImg)){
                        $uploadImg = "../LKT/images";
                    }
                    if($upserver == '2'){
                        $logo = ServerPath::file_OSSupload($store_id, $store_type);
                    }else{
                        $logo = ServerPath::file_upload($store_id,$uploadImg,$uploadImg_domain,$store_type);
                    }
                    if($logo == false){
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'设置店铺ID为'.$shop_id.'时，上传失败或图片格式错误！';
                        $this->mchLog($Log_content);

                        echo json_encode(array('code' => 109,'message'=>'上传失败或图片格式错误！'));
                        exit;
                    }else{
                        $logo = preg_replace('/.*\//', '', $logo);
                    }

                    $res = " logo = '$logo' " ;
                }else if($name != ''){
                    $sql = "select id from lkt_mch where store_id = '$store_id' and name = '$name' and review_status != 2";
                    $r = $db->select($sql);
                    if($r){
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'设置店铺ID为'.$shop_id.'时，店铺名称已存在！';
                        $this->mchLog($Log_content);

                        echo json_encode(array('code' => 223, 'message' => '店铺名称已存在！'));
                        exit();
                    }
                    $res = " name = '$name' " ;
                }else if($shop_information != ''){
                    $res = " shop_information = '$shop_information' " ;
                }else if($realname != ''){
                    $res = " realname = '$realname' " ;
                }else if($ID_number != ''){
                    $res = $this->is_idcard($ID_number);
                    if(!$res){
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'设置店铺ID为'.$shop_id.'时，身份证号码错误！';
                        $this->mchLog($Log_content);

                        echo json_encode(array('code'=>225,'message'=>'身份证号码错误！'));
                        exit();
                    }
                    $res = " ID_number = '$ID_number' " ;
                }else if($tel != ''){
                    if(preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $tel)){

                    }else{
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'设置店铺ID为'.$shop_id.'时，手机号码有误！';
                        $this->mchLog($Log_content);
                        echo json_encode(array('code'=>117,'message'=>'手机号码有误！'));
                        exit();
                    }
                    $res = " tel = '$tel' " ;
                }else if($address != ''){
                    $res = " address = '$address' " ;
                }else if($shop_range != ''){
                    $res = " shop_range = '$shop_range' " ;
                }
                $sql0_0 = "update lkt_mch set $res where store_id = '$store_id' and user_id = '$user_id' and id = '$mch_id'";
                $r0_0 = $db->update($sql0_0);
                if($r0_0 == -1){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'设置店铺ID为'.$shop_id.'失败！';
                    $this->mchLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'设置店铺ID为'.$shop_id.'成功！';
                    $this->mchLog($Log_content);
                    $db->commit();

                    echo json_encode(array('code' => 200,'message' => '成功！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'设置店铺ID为'.$shop_id.'时，店铺ID错误！';
                $this->mchLog($Log_content);

                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);

            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 我的顾客
    public function shop_customer(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $page = trim($request->getParameter('page')); // 店铺ID

        $user_id = $this->user_id;
        $list = array();
        $start_time_1=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d'),date('Y'))); // 今天开始时间
        $end_time_1=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1); // 今天结束时间

        $start_time_2=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')-1,date('Y'))); // 昨天开始时间
        $end_time_2=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d'),date('Y'))-1); // 昨天结束时间

        $start_time_3=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')-2,date('Y'))); // 前天开始时间
        $end_time_3=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')-1,date('Y'))-2); // 前天结束时间

        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $several = 10;
                $start = $page * $several;
                // 查询今天的数据
                $list['list1'] = $this->customer_list($db,$store_id,$mch_id,$start_time_1,$end_time_1,$start,$several);
                // 当今天的数据少于10条时，查询昨天的数据
                if(count($list['list1']['res']) < 10){
                    $several = $several - count($list['list1']['res']);
                    $list['list2'] = $this->customer_list($db,$store_id,$mch_id,$start_time_2,$end_time_2,$start,$several);
                }
                // 当今天的数据加上昨天的数据少于10条时，查询前天的数据
                if(count($list['list2']['res']) < $several){
                    $several = $several - count($list['list2']['res']);
                    $list['list3'] = $this->customer_list($db,$store_id,$mch_id,$start_time_3,$end_time_3,$start,$several);
                }
                // 当今天昨天前天的数据之和少于10条时，查询更早的数据
                if(count($list['list3']['res']) < $several){
                    $several = $several - count($list['list3']['res']);
                    $list['list4'] = $this->customer_list($db,$store_id,$mch_id,$start_time_3,'',$start,$several);
                }
                $num = 0;
                foreach ($list as $k => $v){
                    $num = $num + count($v['res']);
                }
                echo json_encode(array('code' => 200,'list'=>$list,'num'=>$num,'message' => '成功！' ));
                exit;
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 查询顾客数据
    public function customer_list($db,$store_id,$mch_id,$start_time,$end_time,$start,$several){
        $list = array();
        $arr = array();
        if($end_time != ''){
            $sql1 = "select user_id,token,event,add_time from lkt_mch_browse where store_id = '$store_id' and mch_id = '$mch_id' and add_time > '$start_time' and add_time < '$end_time' group by user_id order by add_time desc limit $start,$several";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    $user_id = $v->user_id;
                    $v->add_time = date('H:i:s',strtotime($v->add_time));
                    $sql1_1 = "select user_id,token,event,add_time from lkt_mch_browse where store_id = '$store_id' and mch_id = '$mch_id' and add_time > '$start_time' and add_time < '$end_time' and user_id = '$user_id' order by add_time desc";
                    $r1_1 = $db->select($sql1_1);
                    $arr[$v->user_id] = $r1_1;
                }
                if(count($arr) != 0) {
                    $list = $this->customer($db, $store_id, $arr);
                    $list['time'] = date('Y-m-d', strtotime($end_time));
                }
            }
        }else{
            $sql1 = "select user_id,token,event,add_time from lkt_mch_browse where store_id = '$store_id' and mch_id = '$mch_id' and add_time <= '$start_time' group by user_id order by add_time desc limit $start,$several";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    $user_id = $v->user_id;
                    $v->add_time = date('H:i:s',strtotime($v->add_time));
                    $sql1_1 = "select user_id,token,event,add_time from lkt_mch_browse where store_id = '$store_id' and mch_id = '$mch_id' and add_time <= '$start_time' and user_id = '$user_id' order by add_time ";
                    $r1_1 = $db->select($sql1_1);
                    $arr[$v->user_id] = $r1_1;
                }
                if(count($arr) != 0) {
                    $list = $this->customer($db, $store_id, $arr);
                    $list['time'] = '更早';
                }
            }
        }
        return $list;
    }
    // 顾客数据
    public function customer($db,$store_id,$res){
        $list = array();
        foreach ($res as $K => $v) {
            $v[0]->status = false;
            if(mb_substr($v[0]->user_id,0,2,'utf-8') == '游客' ){
                $sql_1 = "select wx_headimgurl from lkt_config where store_id = '$store_id'";
                $r_1 = $db->select($sql_1);
                if($r_1){
                    foreach ($v as $ke => $va){
                        $va->headimgurl = ServerPath::getimgpath($r_1[0]->wx_headimgurl,$store_id);
                        $va->zhanghao = $va->user_id;
                    }
                }
            }else{
                $user_id1 = $v[0]->user_id;
                $sql_1 = "select headimgurl,user_name from lkt_user where user_id = '$user_id1'";
                $r_1 = $db->select($sql_1);
                if($r_1){
                    foreach ($v as $ke => $va){
                        $va->headimgurl = $r_1[0]->headimgurl;
                        $va->zhanghao = $r_1[0]->user_name;
                    }
                }
            }
            $list['res'][] = $v;
        }
        return $list;
    }
    // 我的订单
    public function my_order(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $order_type = isset($_POST['order_type'])?$_POST['order_type']:false; // 类型

        $user_id = $this->user_id;
        $list1 = array();
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            $list = array();

            if($mch_id == $shop_id){

                $sql_1 = "select id,z_price,allow,sNo,add_time,status,otype from lkt_order as a where a.store_id = '$store_id' and a.mch_id like '%,$mch_id,%' and a.status = 0 ";
                $r_1 = $db->select($sql_1);
                $payment_num = count($r_1);

                $sql_2 = "select id,z_price,allow,sNo,add_time,status,otype from lkt_order as a where a.store_id = '$store_id' and a.mch_id like '%,$mch_id,%' and ((a.status = 1 and a.self_lifting = '0') or (a.status = 2 and a.self_lifting = '1')) ";
                $r_2 = $db->select($sql_2);
                $send_num = count($r_2);

                $sql_3 = "select a.id,a.r_sNo,a.p_id,a.p_name,a.p_price,a.num,a.size,a.sid,a.r_status,a.r_type,a.re_time,b.imgurl,b.is_distribution,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.store_id = '$store_id' and a.r_status = 4 and b.mch_id = '$mch_id'";
                $r_3 = $db->select($sql_3);
                $return_num = count($r_3);

                if($order_type != 'return'){
                    if($order_type == 'payment'){
                        $res = " and a.status = 0 "; // 未付款
                    }else if($order_type == 'send'){
                        $res = " and ((a.status = 1 and a.self_lifting = '0') or (a.status = 2 and a.self_lifting = '1'))"; // 未发货
                    }else{
                        $res = " and a.status != 7 ";
                    }
                    // 根据用户id和前台参数,查询订单表 (id、订单号、订单价格、添加时间、订单状态、优惠券id)
                    $sql1 = "select a.id,a.z_price,a.allow,a.sNo,a.add_time,a.status,a.otype,a.pay_time,a.mch_id,a.spz_price,a.reduce_price,a.coupon_price,a.self_lifting from lkt_order as a where a.store_id = '$store_id' and a.mch_id like '%,$mch_id,%' and a.status != 8 " . $res . " order by add_time desc LIMIT 0,10";
                    $r1 = $db->select($sql1);
                    if($r1){
                        $r1 = $this->a_array_unique($r1);
                        foreach ($r1 as $k => $v){
                            $sNo = $v->sNo;
                            $order_mch_id = explode(',',trim($v->mch_id,','));
                            $z_spz_price = $v->spz_price; // 商品总价

                            $v->time = date("Y-n-j",strtotime($v->add_time));
                            if(count($order_mch_id) > 1 && $v->status == 0){
                                $v->order_status = false;
                                $spz_price = 0; // 店铺商品总价
                                $z_freight = 0; // 店铺商品总运费价
                                //查询单个商品的价格，运费，数量
                                $sql_1 = "select a.id,a.p_id,a.p_name,a.p_price,a.num,a.size,a.sid,a.r_status,a.re_type,a.r_type,a.freight,b.imgurl,b.is_distribution,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.r_sNo = '$sNo' and b.mch_id = '$mch_id'";
                                $r_1 = $db->select($sql_1);
                                if($r_1){
                                    foreach ($r_1 as $ke => $va){
                                        $spz_price += $va->p_price * $va->num; // 店铺商品总价
                                        $z_freight += $va->freight;  // 店铺商品总运费价
                                    }
                                }
                                $reduce_price = $spz_price/$z_spz_price * $v->reduce_price; // 该店铺商品总价 除以 整个订单商品总价 乘以 优惠的满减金额
                                $coupon_price = $spz_price/$z_spz_price * $v->coupon_price; // 该店铺商品总价 除以 整个订单商品总价 乘以 优惠的优惠券金额
                                $v->reduce_price = $reduce_price;
                                $v->coupon_price = $coupon_price;
                                //计算会员特惠
                                $plugin_order = new Plugin_order($store_id);
                                $grade = $plugin_order->user_grade('GM',$spz_price,$user_id,$store_id);
                                $grade_rate = floatval($grade['rate']);

                                $v->z_price = number_format(($spz_price - $reduce_price - $coupon_price) * $grade_rate + $z_freight,2);
                                $v->list = $r_1;
                            }else{
                                $sql_1 = "select a.id,a.p_id,a.p_name,a.p_price,a.num,a.size,a.sid,a.r_status,a.re_type,a.r_type,a.freight,b.imgurl,b.is_distribution,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.r_sNo = '$sNo' and b.mch_id = '$mch_id'";
                                $r_1 = $db->select($sql_1);
                                if($r_1){
                                    foreach ($r_1 as $ke => $va){
                                        $va->otype = $v->otype;
                                        if($va->is_distribution == 1){
                                            $va->otype = "FX"; //订单类型
                                        }
                                        if($va->img){
                                            $r_1[$ke]->imgurl = ServerPath::getimgpath($va->img,$store_id);
                                        }else{
                                            $r_1[$ke]->imgurl = ServerPath::getimgpath($va->imgurl,$store_id);
                                        }
                                        $va->status = false;
                                    }
                                    $v->list = $r_1;
                                }
                                $v->order_status = true;
                            }
                        }
                        $list1 = $r1;
                    }
                }else{
                    $sql1 = "select a.id,a.r_sNo,a.p_id,a.p_name,a.p_price,a.num,a.size,a.sid,a.r_status,a.re_type,a.r_type,a.freight,a.re_time,b.imgurl,b.is_distribution,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.store_id = '$store_id' and a.r_status = 4 and b.mch_id = '$mch_id' order by a.re_time desc,r_type asc limit 0,10 ";
                    $r1 = $db->select($sql1);
                    if($r1){
                        foreach ($r1 as $k => $v){
                            $sNo = $v->r_sNo;
                            if($v->img){
                                $v->imgurl = ServerPath::getimgpath($v->img,$store_id);
                            }else{
                                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                            }
                            $sql2 = "select id,z_price,allow,sNo,add_time,status,otype,self_lifting from lkt_order as a where a.store_id = '$store_id' and a.mch_id like '%,$mch_id,%' and a.sNo  ='$sNo'";
                            $r2 = $db->select($sql2);
                            if($r2){
                                $r2[0]->time = date("Y-n-j",strtotime($v->re_time));
                                $v->otype = $r2[0]->otype;
                                if($v->is_distribution == 1){
                                    $v->otype = "FX"; //订单类型
                                }
                                $r2[0]->list[] = $v;
                                $r2[0]->status = 4;
                                $r2[0]->order_status = true;
                                $list1[] = $r2[0];
                            }
                        }
                    }
                }
                if(count($list1) != 0){
                    foreach ($list1 as $key => $info) {
                        $result[$info->time][] = $info;
                    }
                    $rew = 0;
                    foreach($result as $key=>$value){

                        $list[$rew]['time'] = $key;
                        $list[$rew]['res'] = $value;
                        $rew = $rew +1;
                    }
                }
                echo json_encode(array('code' => 200,'list'=>$list,'payment_num'=>$payment_num,'send_num'=>$send_num,'return_num'=>$return_num,'message' => '成功！' ));
                exit;
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 我的订单-加载更多
    public function my_order_load(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $order_type = isset($_POST['order_type'])?$_POST['order_type']:false; // 类型
        $page = trim($request->getParameter('page'));

        $user_id = $this->user_id;
        $start = $page*10;
        $end = 10;

        $list1 = array();
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            $list = array();

            if($mch_id == $shop_id){
                if($order_type != 'return') {
                    if ($order_type == 'payment') {
                        $res = " and a.status = 0 "; // 未付款
                    } else if ($order_type == 'send') {
                        $res = " and ((a.status = 1 and a.self_lifting = '0') or (a.status = 2 and a.self_lifting = '1')) "; // 未发货
                    } else {
                        $res = " and a.status != 7 ";
                    }
                    // 根据用户id和前台参数,查询订单表 (id、订单号、订单价格、添加时间、订单状态、优惠券id)
                    $sql1 = "select a.id,a.z_price,a.sNo,a.add_time,a.status,a.otype,a.pay_time,a.mch_id,a.spz_price,a.reduce_price,a.coupon_price,a.self_lifting from lkt_order as a where a.store_id = '$store_id' and a.mch_id like '%,$mch_id,%' and a.status != 8 " . $res . " order by add_time desc LIMIT $start,$end";
                    $r1 = $db->select($sql1);
                    if($r1){
                        $r1 = $this->a_array_unique($r1);
                        foreach ($r1 as $k => $v){
                            $sNo = $v->sNo;
                            $order_mch_id = explode(',',trim($v->mch_id,','));
                            $z_spz_price = $v->spz_price; // 商品总价

                            $v->time = date("Y-n-j",strtotime($v->add_time));
                            if(count($order_mch_id) > 1 && $v->status == 0){
                                $v->order_status = false;
                                $spz_price = 0; // 店铺商品总价
                                $z_freight = 0; // 店铺商品总运费价
                                //查询单个商品的价格，运费，数量
                                $sql_1 = "select a.id,a.p_id,a.p_name,a.p_price,a.num,a.size,a.sid,a.r_status,a.re_type,a.r_type,a.freight,b.imgurl,b.is_distribution,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.r_sNo = '$sNo' and b.mch_id = '$mch_id'";
                                $r_1 = $db->select($sql_1);
                                if($r_1){
                                    foreach ($r_1 as $ke => $va){
                                        $spz_price += $va->p_price * $va->num; // 店铺商品总价
                                        $z_freight += $va->freight;  // 店铺商品总运费价
                                    }
                                }
                                $reduce_price = $spz_price/$z_spz_price * $v->reduce_price; // 该店铺商品总价 除以 整个订单商品总价 乘以 优惠的满减金额
                                $coupon_price = $spz_price/$z_spz_price * $v->coupon_price; // 该店铺商品总价 除以 整个订单商品总价 乘以 优惠的优惠券金额
                                $v->reduce_price = $reduce_price;
                                $v->coupon_price = $coupon_price;
                                //计算会员特惠
                                $plugin_order = new Plugin_order($store_id);
                                $grade = $plugin_order->user_grade('GM',$spz_price,$user_id,$store_id);
                                $grade_rate = floatval($grade['rate']);

                                $v->z_price = number_format(($spz_price - $reduce_price - $coupon_price) * $grade_rate + $z_freight,2);
                                $v->list = $r_1;
                            }else{
                                $sql_1 = "select a.id,a.p_id,a.p_name,a.p_price,a.num,a.size,a.sid,a.r_status,a.re_type,a.r_type,a.freight,b.imgurl,b.is_distribution,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.r_sNo = '$sNo' and b.mch_id = '$mch_id'";
                                $r_1 = $db->select($sql_1);
                                if($r_1){
                                    foreach ($r_1 as $ke => $va){
                                        $va->otype = $v->otype;
                                        if($va->is_distribution == 1){
                                            $va->otype = "FX"; //订单类型
                                        }
                                        if($va->img){
                                            $r_1[$ke]->imgurl = ServerPath::getimgpath($va->img,$store_id);
                                        }else{
                                            $r_1[$ke]->imgurl = ServerPath::getimgpath($va->imgurl,$store_id);
                                        }
                                        $va->status = false;
                                    }
                                    $v->list = $r_1;
                                }
                                $v->order_status = true;
                            }
                        }
                        $list1 = $r1;
                    }
                }else{
                    $sql1 = "select a.id,a.r_sNo,a.p_id,a.p_name,a.p_price,a.num,a.size,a.sid,a.r_status,a.re_type,a.r_type,a.re_time,b.imgurl,b.is_distribution,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.store_id = '$store_id' and a.r_status = 4 and b.mch_id = '$mch_id' order by a.re_time desc,r_type asc limit $start,$end ";
                    $r1 = $db->select($sql1);
                    if($r1){
                        foreach ($r1 as $k => $v){
                            $sNo = $v->r_sNo;
                            if($v->img){
                                $v->imgurl = ServerPath::getimgpath($v->img,$store_id);
                            }else{
                                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                            }
                            $sql2 = "select id,z_price,sNo,add_time,status,otype,self_lifting from lkt_order as a where a.store_id = '$store_id' and a.mch_id like '%,$mch_id,%' and a.sNo  ='$sNo'";
                            $r2 = $db->select($sql2);
                            if($r2){
                                $v->otype = $r2[0]->otype;
                                if($v->is_distribution == 1){
                                    $v->otype = "FX"; //订单类型
                                }
                                $r2[0]->time = date("Y-n-j",strtotime($v->re_time));
                                $r2[0]->list = $v;
                                $list1 = $r2;
                            }
                        }
                    }
                }

                foreach ($list1 as $key => $info) {
                    $result[$info->time][] = $info;
                }
                $rew = 0;
                foreach($result as $key=>$value){

                    $list[$rew]['time'] = $key;
                    $list[$rew]['res'] = $value;
                    $rew = $rew +1;
                }

                echo json_encode(array('code' => 200,'list'=>$list,'message' => '成功！' ));
                exit;
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 点击发货按钮-弹出填写发货信息
    public function into_send(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select * from lkt_express ";
                $r1 = $db -> select($sql1);

                echo json_encode(array('code' => 200,'list'=>$r1,'message' => '成功！' ));
                exit;
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 发货
    public function send(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $JurisdictionAction = new JurisdictionAction();
        $db->begin();

        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = trim($request -> getParameter('sNo')); // 订单号
        $express_id = trim($request->getParameter('express_id')); // 快递公司ID
        $courier_num = $request -> getParameter('courier_num'); // 快递单号
        $orderList_id = $request -> getParameter('orderList_id'); // 发货数组

        $user_id = $this->user_id;
        $time = date('Y-m-d H:i:s', time());

        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        $count = 0;//统计详细订单记录数
        $batchSend = false;//是否批量发货
        $len = 0;//选择的订单数
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                if (!empty($express_id)) {
                    $con = ",express_id='$express_id'";
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货时,未选择快递公司！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 109,'message' => '请选择快递公司！' ));
                    exit();
                }
                if (!empty($courier_num)) {
                    if(strlen($courier_num) > 10 && strlen($courier_num) < 20){
                        $sql1 = "select id from lkt_order_details where express_id = '$express_id' and courier_num = '$courier_num'";
                        $r1 = $db->select($sql1);
                        if($r1){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货时,快递单号已存在！';
                            $this->mchLog($Log_content);
                            echo json_encode(array('code' => 109,'message' => '快递单号已存在！' ));
                            exit();
                        }else{
                            $con .= ",courier_num ='$courier_num'";
                        }
                    }else{
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货时,快递单号输入错误！';
                        $this->mchLog($Log_content);
                        echo json_encode(array('code' => 109,'message' => '快递单号输入错误！' ));
                        exit();
                    }
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货时,未填写快递单号！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 109,'message' => '请输入快递单号！' ));
                    exit();
                }
                $con .= ",deliver_time= ' $time '";

                if($orderList_id == ''){ // 订单列表发货
                    // 根据商城ID、订单号，查询订单详情ID
                    $sql0_0 = "select id from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' ";
                    $r0_0 = $db->select($sql0_0);
                    if($r0_0){
                        foreach ($r0_0 as $k => $v){
                            $order_details_list[] = $v->id;
                        }
                    }
                    $order_details_id = implode(',',$order_details_list);
                    $len = count($order_details_list);
                }else{
                    $order_details_id = $orderList_id;
                }
                // 根据订单号，查询是否存在退货的商品
                $sql2 = "select otype from lkt_order where sNo = '$sNo' ";
                $r2 = $db->select($sql2);
                if($r2){
                    $otype = $r2[0]->otype;

                    if ($otype == '') {
                        // 查询是否有退货商品
                        $sql = "select express_id,r_sNo from lkt_order_details where id in($order_details_id) and r_status = '4' ";
                        $rrup = $db->selectrow($sql);
                        if($rrup){ // 存在
                            $sql_o = "select r_sNo from lkt_order_details where store_id = '$store_id' and id = '$order_details_id' and r_status = '4'";
                            $res_o = $db -> select($sql_o);

                            if ($rrup <= 1) {
                                $ssooid = $res_o[0]->r_sNo;
                                $sqll = "update lkt_order set status='2' where store_id = '$store_id' and sNo='$ssooid'";
                                $rl = $db -> update($sqll);
                                if($r1 < 1){
                                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货时,修改订单状态失败,订单号为'.$ssooid.'！';
                                    $this->mchLog($Log_content);
                                    $db->rollback();
                                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                    exit();
                                }
                            }

                            $sqld = "update lkt_order_details set r_status='2' $con where sNo = '$sNo'  and r_status = '4'";
                            $rd = $db -> update($sqld);
                            if ($rd < 1) {
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货时,修改订单详情失败,订单号为'.$sNo.'！';
                                $this->mchLog($Log_content);
                                $db->rollback();
                                echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                exit();
                            }
                            $JurisdictionAction->admin_record($store_id,$user_id,' 为单号为 '.$sNo.' 的订单发货 ',7);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货成功,订单号为'.$sNo.'！';
                            $this->mchLog($Log_content);
                            $db->commit();
                            echo json_encode(array('code' => 200,'message' => '成功！' ));
                            exit();
                        }


                        $sqld = "update lkt_order_details set r_status='2' $con where r_sNo = '$sNo' and r_status = '1' and id in($order_details_id)";
                        $rd = $db -> update($sqld);
                        if ($rd < 0) {
                            $db->rollback();
                            $JurisdictionAction->admin_record($store_id,$user_id,' 为单号为 '.$sNo.' 的订单发货失败 ',7);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货失败,订单号为'.$sNo.'！';
                            $this->mchLog($Log_content);
                            echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                            exit();
                        }

                        $sql = "select id from lkt_order_details where r_status in (1,2) and r_sNo='$sNo'";
                        //所有为已发货状态的订单详情跟所选订单一样多的情况下为批量发货
                        $count = $db->selectrow($sql);
                        if($count == $len){
                            //批量发货
                            $batchSend = true;
                        }

                        //查询订单信息
                        $sql_p = "select o.id,o.user_id,o.sNo,d.p_name,d.p_id,d.sid,d.num,o.name,o.address from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and d.r_sNo = '$sNo' ";
                        $res_p = $db -> select($sql_p);
                        $curSendPos = 0; //统计当前发货次数
                        foreach ($res_p as $key => $value) {
                            $p_name = $value -> p_name;
                            $user_id = $value -> user_id;
                            $address = $value -> address;
                            $name = $value -> name;
                            $order_id = $value -> id;
                            $oid = $value -> sNo;
                            $p_id = $value -> p_id;
                            $sid = $value -> sid;
                            $num = $value -> num;

                            $upod = $db->selectrow("select id from lkt_order_details where r_status = 1 and r_sNo='$oid'");
                            $curSendPos = $curSendPos + 1;
                            $sendFinish = (!$upod && !$batchSend) || ($batchSend && $curSendPos == $len );
                            if($sendFinish){
                                $sqll = "update lkt_order set status='2' where sNo='$oid'";
                                $rl = $db -> update($sqll);
                                if ($rl < 0) {
                                    $db->rollback();
                                    $JurisdictionAction->admin_record($store_id,$user_id,' 为单号为 '.$sNo.' 的订单发货失败 ',7);
                                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货失败,订单号为'.$sNo.'！';
                                    $this->mchLog($Log_content);
                                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                    exit();
                                }else{
                                    $msg_title = "【".$oid."】订单发货啦！";
                                    $msg_content = "您购买的商品已经在赶去见您的路上啦~";

                                    $JurisdictionAction->admin_record($store_id,$user_id,' 使订单号为 '.$sNo.' 的订单发货 ',7);

                                    /**发货成功通知*/
                                    $pusher = new LaikePushTools();
                                    $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,$user_id);
                                }
                            }
                            $sql0 = "select num from lkt_product_list where store_id = '$store_id' and id = '$p_id'";
                            $r0 = $db->select($sql0);
                            $total_num = $r0[0]->num;
                            $sql = "insert into lkt_stock(store_id,product_id,attribute_id,total_num,flowing_num,type,user_id,add_date) values('$store_id','$p_id','$sid','$total_num','$num',1,'$user_id',CURRENT_TIMESTAMP)";
                            $db->insert($sql);
                        }
                        $JurisdictionAction->admin_record($store_id,$user_id,' 使订单号为 '.$sNo.' 的订单发货 ',7);
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货成功,订单号为'.$sNo.'！';
                        $this->mchLog($Log_content);
                        $db->commit();
                        echo json_encode(array('code' => 200,'message' => '发货成功！'));
                        exit();
                    } else if ($otype == 'pt') {
                        $sqld = 'update lkt_order_details set ' . substr($con, 1) . ' where r_sNo ="' . $sNo . '"';
                        $rd = $db -> update($sqld);
                        $msgsql = "select o.id,o.user_id,o.sNo,d.p_name,o.name,o.address from lkt_order as o left join lkt_order_details as d on o.sNo=d.r_sNo where o.store_id = '$store_id' and d.r_sNo ='$sNo'";
                        $msgres = $db -> select($msgsql);


                        if (!empty($msgres))
                            $msgres = $msgres[0];
                        $uid = $msgres -> user_id;

                        $oid = $msgres -> sNo;
                        $sqll = 'update lkt_order set status=2 where sNo="' . $oid . '"';
                        $rl = $db -> update($sqll);
                        $sqld = "update lkt_order_details set r_status='2' $con where r_sNo = '$sNo' and r_status = '1'";
                        $rd = $db -> update($sqld);
                        if ($rd < 1) {
                            $db->rollback();
                            $JurisdictionAction->admin_record($store_id,$user_id,' 为单号为 '.$sNo.' 的订单发货失败 ',7);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货失败,订单号为'.$sNo.'！';
                            $this->mchLog($Log_content);
                            echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                            exit();
                        }

                        $openid = $db -> select("select wx_id from lkt_user where store_id = '$store_id' and user_id='$uid'");
                        $msgres -> uid = $openid[0] -> wx_id;
                        $compa = "select kuaidi_name from lkt_express where id=$express_id";
                        $compres = $db -> select($compa);
                        if (!empty($compres))
                            $msgres -> company = $compres[0] -> kuaidi_name;
                        $fromidsql = "select fromid from lkt_user_fromid where store_id = '$store_id' and open_id='$msgres->uid' and id=(select max(id) from lkt_user_fromid where open_id='$msgres->uid')";
                        $fromid = $db -> select($fromidsql);
                        if (!empty($fromid)){
                            $msgres -> fromid = $fromid[0] -> fromid;
                        }else{
                            $msgres -> fromid = '';
                        }

                        $msgres -> courier_num = $courier_num;
                        if ($rl > 0 && $rd > 0) {
                            $sql = "select * from lkt_notice where store_id = '$store_id' ";
                            $r = $db -> select($sql);
                            if($r){
                                $template_id = $r[0] -> order_delivery;
                            }else{
                                $template_id = '';
                            }

                            //$res = $this -> Send_success($msgres, $template_id);
                            $JurisdictionAction->admin_record($store_id,$user_id,' 使订单号为 '.$oid.' 的订单发货 ',7);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货成功,订单号为'.$sNo.'！';
                            $this->mchLog($Log_content);
                            $db->commit();
                            $msg_title = "【".$oid."】订单发货啦！";
                            $msg_content = "您购买的商品【".$msgres->p_name."】已经在赶去见您的路上啦~";
                            /**发货成功通知*/
                            $pusher = new LaikePushTools();
                            $pusher->pushMessage($uid, $db, $msg_title, $msg_content,$store_id,'');

                            echo json_encode(array('code' => 200,'message' => '成功！' ));
                            exit();
                        }else{
                            $db->rollback();
                            $JurisdictionAction->admin_record($store_id,$user_id,' 为单号为 '.$sNo.' 的订单发货失败 ',7);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货失败,订单号为'.$sNo.'！';
                            $this->mchLog($Log_content);
                            echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                            exit();
                        }
                    }
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'发货时,订单号错误,订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 109,'message' => '订单号错误！' ));
                    exit();
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 关闭订单
    public function closing_order(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = trim($request -> getParameter('sNo')); // 订单号
        $this->db->begin();

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){

                $sql1 = "update lkt_order_details set r_status = 6 where store_id = '$store_id' and r_sNo = '$sNo'";
                $res1 = $this->db->update($sql1);
                if (!$res1) {
                    $this->db->rollback();

                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'关闭订单时，修改订单详情状态失败，订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));exit;
                }

                $sql2 = "update lkt_order set status = 6 where store_id = '$store_id' and sNo = '$sNo'";
                $res2 = $this->db->update($sql2);

                if (!$res2) {
                    $this->db->rollback();
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'关闭订单时，修改订单状态失败，订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                    exit;
                }

                $sql3 = "select p_id,num,sid from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo'";
                $r3 = $db->select($sql3);
                if($r3){
                    $p_id = $r3[0]->p_id;
                    $num = $r3[0]->num;
                    $sid = $r3[0]->sid;

                    $sql4 = "update lkt_product_list set num = num + '$num' where store_id = '$store_id' and id = '$p_id'";
                    $db->update($sql4);

                    $sql5 = "update lkt_configure set num = num + '$num' where id = '$sid'";
                    $db->update($sql5);
                }
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'关闭订单成功，订单号为'.$sNo.'！';
                $this->mchLog($Log_content);
                $this->db->commit();
                echo json_encode(array('code' => 200,'message' => '成功！' ));
                exit;
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 编辑订单页面-点击商品属性
    public function dj_attribute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $pid = $request->getParameter('p_id'); // 商品ID

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
                    $attrList[$kkk] = array('attrName' => $k, 'attrType' => '1', 'id' => md5($k), 'attr' => array(), 'all' => array());
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
    }
    // 编辑订单页面-修改商品属性
    public function up_attribute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = $request->getParameter('sNo'); // 订单号
        $pid = $request->getParameter('p_id'); // 商品ID
        $attribute_id = $request->getParameter('attribute_id'); // 属性id

        $user_id = $this->user_id;

        $arr = array();
        $list = array();
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select id,sNo,user_id,name,mobile,address,z_price,status,spz_price,readd,add_time,coupon_price as coupon_money,reduce_price as reduce_money from lkt_order where store_id = '$store_id' and mch_id like '%,$mch_id,%' and sNo = '$sNo'";
                $r1 = $db->select($sql1);
                if($r1){
                    if ($r1[0]->readd == 0) {
                        $sql2 = "update lkt_order set readd = 1 where store_id = '$store_id' and sNo = '$sNo'";
                        $up = $db->update($sql2);
                    }
                    $arr = $r1[0];
                    $user_id1 = $r1[0]->user_id;

                    $sql3 = "select user_name from lkt_user where store_id = '$store_id' and user_id = '$user_id1'";
                    $r3 = $db->select($sql3);
                    $arr->user_name = $r3[0]->user_name;

                    $yunfei = 0;
                    $sql4 = "select p_id,p_name,p_price,num,freight,size,sid from lkt_order_details where r_sNo = '$sNo'";
                    $r4 = $db->select($sql4);
                    foreach ($r4 as $k => $v){
                        $p_id = $v->p_id;
                        $sid = $v->sid;
                        $yunfei = $yunfei+$v->freight;
                        // 根据产品id,查询产品主图
                        $psql = "select a.imgurl,b.img from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where a.store_id = '$store_id' and a.id='$p_id' and b.id = '$sid'";
                        $img = $db->selectarray($psql);
                        if (!empty($img)) {
                            if($img[0]['img']){
                                $v->pic = ServerPath::getimgpath($img[0]['img']);
                            }else{
                                $v->pic = ServerPath::getimgpath($img[0]['imgurl']);
                            }
                            $res[$k] = $v;
                        }
                    }
                    $arr->list = $res;
                    $arr->z_freight = $yunfei;
                    foreach ($arr->list as $k => $v){
                        if($v->p_id == $pid){
                            if($v->sid != $attribute_id){
                                // 根据商品ID、属性ID，查询出售价和库存
                                $sql_1 = "select a.imgurl,b.img,b.num,b.price,b.attribute from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where a.store_id = '$store_id' and a.id='$pid' and b.id = '$attribute_id'";
                                $r_1 = $db->select($sql_1);
                                if($r_1){
                                    $num2 = $r_1[0]->num; // 库存
                                    $price2 = $r_1[0]->price; // 出售价
                                    if($num2 < $v->num){
                                        echo json_encode(array('code' => 105,'message' => '库存不足！' ));
                                        exit;
                                    }else{
                                        $chajia = $v->p_price - $price2;
                                        $v->p_price = $price2;
                                        $attribute_1 = '';
                                        if(!empty($r_1[0]->attribute)){
                                            $attribute1 = $r_1[0]->attribute;
                                            $attribute2 = unserialize($attribute1);
                                            foreach ($attribute2 as $ke => $va) {
                                                $attribute_1 .= $va . ' ';
                                            }
                                            $attribute_1 = trim($attribute_1, ' '); // 移除两侧的空格(购物车显示的属性)
                                        }
                                        $v->size = $attribute_1;
                                        $v->sid = $attribute_id;
                                        if($r_1[0]->img){
                                            $v->pic = ServerPath::getimgpath($r_1[0]->img);
                                        }else{
                                            $v->pic = ServerPath::getimgpath($r_1[0]->imgurl);
                                        }
                                    }
                                }
                            }else{
                                $chajia = 0;
                            }
                        }
                    }
                    $arr->spz_price = $arr->spz_price - $chajia;
                    $arr->z_price = $arr->z_price - $chajia;

                    echo json_encode(array('code' => 200,'list'=>$arr,'message' => '成功！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品属性时，订单号错误，订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 编辑订单页面-改变
    public function change(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = $request->getParameter('sNo'); // 订单号
        $data = $request->getParameter('data'); // 数据
        $data = htmlspecialchars_decode($data);
        $data = json_decode($data,true);

        $user_id = $this->user_id;

        $arr = array();
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select id,sNo,user_id,name,mobile,address,z_price,status,spz_price,readd,add_time,coupon_price as coupon_money,reduce_price as reduce_money from lkt_order where store_id = '$store_id' and mch_id like '%,$mch_id,%' and sNo = '$sNo'";
                $r1 = $db->select($sql1);
                if($r1){
                    if ($r1[0]->readd == 0) {
                        $sql2 = "update lkt_order set readd = 1 where store_id = '$store_id' and sNo = '$sNo'";
                        $up = $db->update($sql2);
                    }
                    $arr = $r1[0];
                    $user_id1 = $r1[0]->user_id;

                    //计算会员特惠
                    $plugin_order = new Plugin_order($store_id);
                    $grade = $plugin_order->user_grade('GM',$r1[0]->spz_price,$user_id,$store_id);
                    $grade_rate = floatval($grade['rate']);

                    $sql3 = "select user_name from lkt_user where store_id = '$store_id' and user_id = '$user_id1'";
                    $r3 = $db->select($sql3);
                    $arr->user_name = $r3[0]->user_name;

                    $yunfei = 0;
                    $sql4 = "select p_id,p_name,p_price,num,freight,size,sid from lkt_order_details where r_sNo = '$sNo'";
                    $r4 = $db->select($sql4);
                    foreach ($r4 as $k => $v){
                        $p_id = $v->p_id;
                        $sid = $v->sid;
                        $yunfei = $yunfei+$v->freight;
                        // 根据产品id,查询产品主图
                        $psql = "select a.imgurl,b.img from lkt_product_list as a left join lkt_configure as b on a.id = b.pid where a.store_id = '$store_id' and a.id='$p_id' and b.id = '$sid'";
                        $img = $db->selectarray($psql);
                        if (!empty($img)) {
                            if($img[0]['img']){
                                $v->pic = ServerPath::getimgpath($img[0]['img']);
                            }else{
                                $v->pic = ServerPath::getimgpath($img[0]['imgurl']);
                            }
                            $res[$k] = $v;
                        }
                    }

                    $arr->grade_rate = $grade_rate;
                    $arr->list = $res;
                    $arr->z_freight = $yunfei;
                    $arr->z_price = $r1[0]->z_price;

                    $spz_price = 0;
                    $arr->name = $data['name'];
                    $arr->mobile = $data['mobile'];
                    $arr->address = $data['address'];
                    foreach ($data['list'] as $k => $v){
                        foreach ($arr->list as $ke => $va){
                            if($va->p_id == $v['p_id'] && $va->p_price != $v['p_price']){ // 改变了商品价格
                                $va->p_price = $v['p_price'];
                            }
                        }
                    }

                    foreach ($arr->list as $k => $v){
                        $spz_price += $v->p_price * $v->num; // 商品总价
                    }
                    $por_chajia = $r1[0]->spz_price - $spz_price; // 原来的商品总价 - 改变后的商品总价 = 改变的商品总价金额
                    $freight_chajia = $yunfei - $data['z_freight']; // 原来的总运费 - 改变后的总运费 = 改变的总运费金额
                    $arr->spz_price = $spz_price;
                    $arr->z_freight = $data['z_freight'];
                    $arr->z_price = $r1[0]->z_price - $por_chajia - $freight_chajia;

                    echo json_encode(array('code' => 200,'list'=>$arr,'message' => '成功！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品属性时，订单号错误，订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 修改订单
    public function up_order(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = $request->getParameter('sNo'); // 订单号
        $data = $request->getParameter('orderDetail'); // 数据
        $data = htmlspecialchars_decode($data);
        $data = json_decode($data,true);
        $db->begin();

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0) {
            $mch_id = $r0[0]->id;
            if ($mch_id == $shop_id) {
                $sql1 = "select id from lkt_order where store_id = '$store_id' and mch_id like '%,$mch_id,%' and sNo = '$sNo'";
                $r1 = $db->select($sql1);
                if($r1){

                    $sql2 = "update lkt_order set name = '".$data['name']."',mobile = '".$data['mobile']."',address = '".$data['address']."',spz_price = '".$data['spz_price']."',z_price = '".$data['z_price']."' where store_id = '$store_id' and mch_id like '%,".$mch_id.",%' and sNo = '$sNo'";
                    $r2 = $db->update($sql2);
                    if($r2 == -1){
                        $db->rollback();
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改订单失败，订单号为'.$sNo.'！';
                        $this->mchLog($Log_content);
                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                        exit();
                    }else{
                        foreach ($data['list'] as $k => $v){
                            if($k == 0){
                                $sql3 = 'update lkt_order_details set p_price='.'"'.$v['p_price'].'"'.',freight='.'"'.$data['z_freight'].'"'.',sid='.'"'.$v['sid'].'"'.',size='.'"'.$v['size'].'"'.' where r_sNo = '.'"'.$sNo.'"'.' and p_id='.$v['p_id'];
                            }else{
                                $sql3 = 'update lkt_order_details set p_price='.'"'.$v['p_price'].'"'.',sid='.'"'.$v['sid'].'"'.',size='.'"'.$v['size'].'"'.' where r_sNo = '.'"'.$sNo.'"'.' and p_id='.$v['p_id'];
                            }
                            $r3 = $db->update($sql3);
                            if($r3 == -1){
                                $db->rollback();
                                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改订单详情失败，订单号为'.$sNo.'！';
                                $this->mchLog($Log_content);
                                echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                exit();
                            }
                        }
                    }
                    $db->commit();
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改订单成功，订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 200,'message' => '成功！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'修改商品属性时，订单号错误，订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 订单详情
    public function order_details(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = $request->getParameter('sNo'); // 订单号

        $user_id = $this->user_id;

        $arr = array();
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select id,sNo,user_id,name,mobile,address,z_price,allow,status,otype,spz_price,readd,add_time,mch_id,coupon_id,coupon_price as coupon_money,reduce_price as reduce_money,comm_discount,remarks,self_lifting from lkt_order where store_id = '$store_id' and mch_id like '%,$mch_id,%' and sNo = '$sNo'";
                $r1 = $db->select($sql1);
                if($r1){
                    $order_mch_id = explode(',',trim($r1[0]->mch_id,','));
                    $z_spz_price = $r1[0]->spz_price; // 商品总价

                    $coupon_id = $r1[0]->coupon_id;// 优惠券ID
                    $self_lifting = $r1[0]->self_lifting;// 是否自提

                    $coupon_name = '';
                    $sql1_1 = "select a.activity_type,a.money,a.discount from lkt_coupon_activity as a left join lkt_coupon as b on a.id = b.hid where a.store_id = '$store_id' and b.id = '$coupon_id'";
                    $r1_1 = $db->select($sql1_1);
                    if($r1_1){
                        if($r1_1[0]->activity_type == 2){
                            $coupon_name = '(' . $r1_1[0]->discount*10 . '折)';
                        }else if($r1_1[0]->activity_type == 4){
                            if($r1_1[0]->money == 0 ){
                                $coupon_name = '(' . $r1_1[0]->discount*10 . '折)';
                            }
                        }
                    }

                    if ($r1[0]->readd == 0) {
                        $sql2 = "update lkt_order set readd = 1 where store_id = '$store_id' and sNo = '$sNo'";
                        $up = $db->update($sql2);
                    }
                    $mobile = $r1[0]->mobile;
                    $r1[0]->mobile = $mobile;
                    $arr = $r1[0];
                    if($self_lifting == '1'){
                        $sql0_0 = "select * from lkt_mch_store where store_id = '$store_id' and mch_id = '$mch_id'";
                        $r0_0 = $db->select($sql0_0);
                        if($r0_0){
                            $arr->name = $r0_0[0]->name;
                            $arr->mobile = $r0_0[0]->mobile;
                            $arr->address = $r0_0[0]->sheng . $r0_0[0]->shi . $r0_0[0]->xian . $r0_0[0]->address;
                        }
                    }
                    $user_id1 = $r1[0]->user_id;

                    $sql3 = "select user_name from lkt_user where store_id = '$store_id' and user_id = '$user_id1'";
                    $r3 = $db->select($sql3);
                    $arr->user_name = $r3[0]->user_name;

                    $yunfei = 0; // 总运费
                    $spz_price = 0; // 商品总价

                    $sql4 = "select a.id,a.p_id,a.p_name,a.p_price,a.num,a.freight,a.size,a.sid,a.r_status,a.r_type,a.freight,b.imgurl,b.is_distribution,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.r_sNo = '$sNo' and b.mch_id = '$mch_id'";
                    $r4 = $db->select($sql4);
                    if($r4){
                        foreach ($r4 as $k => $v){
                            $yunfei = $yunfei+$v->freight;
                            $spz_price += $v->p_price * $v->num;
                            if($v->img){
                                $v->pic = ServerPath::getimgpath($v->img);
                            }else{
                                $v->pic = ServerPath::getimgpath($v->imgurl);
                            }
                            $res[$k] = $v;
                        }
                    }
                    //计算会员特惠
                    $plugin_order = new Plugin_order($store_id);
                    $grade = $plugin_order->user_grade('GM',$spz_price,$user_id,$store_id);
                    $grade_rate = floatval($grade['rate']);

                    if(count($order_mch_id) > 1 && $r1[0]->status == 0){ // 当为跨店铺未付款订单时
                        $reduce_price = $spz_price/$z_spz_price * $r1[0]->reduce_money; // 该店铺商品总价 除以 整个订单商品总价 乘以 优惠的满减金额
                        $coupon_price = $spz_price/$z_spz_price * $r1[0]->coupon_money; // 该店铺商品总价 除以 整个订单商品总价 乘以 优惠的优惠券金额
                        $r1[0]->reduce_money = $reduce_price;
                        $r1[0]->coupon_money = $coupon_price;

                        $arr->z_price = number_format(($spz_price - $reduce_price - $coupon_price) * $grade_rate + $yunfei,2);
                        $arr->order_status = false;
                    }else{
                        $arr->z_price = $r1[0]->z_price;
                        $arr->order_status = true;
                    }

                    $arr->spz_price = $spz_price;
                    $arr->list = $res;
                    $arr->z_freight = $yunfei;
                    $arr->coupon_name = $coupon_name;
                    $arr->grade_rate = $grade_rate;

                    echo json_encode(array('code' => 200,'list'=>$arr,'message' => '成功！' ));
                    exit;
                }else{
                    echo json_encode(array('code' => 115,'message' => '非法入侵1！' ));
                    exit;
                }
            }else{
                echo json_encode(array('code' => 115,'message' => '非法入侵2！' ));
                exit;
            }
        }else{
            echo json_encode(array('code' => 115,'message' => '非法入侵3！' ));
            exit;
        }
    }
    // 物流
    public function logistics(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = trim($request -> getParameter('sNo')); // 订单号

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select id from lkt_order where store_id = '$store_id' and mch_id like '%,$mch_id,%' and sNo = '$sNo'";
                $r1 = $db->select($sql1);
                if($r1){
                    $sql2 = "select express_id,courier_num from lkt_order_details where r_sNo = '$sNo'";
                    $r2 = $db->select($sql2);
                    if (!empty($r2[0]->express_id) && !empty($r2[0]->courier_num)) {
                        $express_id = $r2[0]->express_id;//快递公司ID
                        $courier_num = $r2[0]->courier_num;//快递单号
                        $sql01 = "select * from lkt_express where id = '$express_id'";
                        $r01 = $db->select($sql01);
                        $type = $r01[0]->type;//快递公司代码
                        $kuaidi_name = $r01[0]->kuaidi_name;
                        $url = "http://www.kuaidi100.com/query?type=$type&postid=$courier_num";
                        $res = $this->httpsRequest($url);

                        $res_1 = json_decode($res);
                        if (empty($res_1->data)) {
                            $data = array();
                        } else {
                            $data = $res_1->data;
                        }
                    } else {
                        $data = array();
                    }

                    echo json_encode(array('code' => 200,'data'=>$data,'message' => '成功！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'查看物流时，订单号错误，订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 退货页面
    public function return_page(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = trim($request -> getParameter('sNo')); // 订单号
        $order_details_id = trim($request -> getParameter('order_details_id')); // 订单详情ID

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select id from lkt_order where store_id = '$store_id' and mch_id like '%,$mch_id,%' and sNo = '$sNo'";
                $r1 = $db->select($sql1);
                if($r1){
                    // 根据产品id，查询产品产品信息
                    $sql2 = "select a.id,a.r_sNo,a.p_id,a.p_name,a.p_price,a.num,a.size,a.sid,a.r_status,a.r_type,a.re_type,a.content,a.re_time,a.re_photo,a.re_apply_money,b.imgurl,c.img from lkt_order_details as a left join lkt_product_list as b on a.p_id = b.id left join lkt_configure as c on a.sid = c.id where a.store_id = '$store_id' and a.r_status = 4 and a.id = '$order_details_id' ";
                    $r2 = $db->select($sql2);
                    if($r2){
                        if($r2[0]->img){
                            $r2[0]->imgurl = ServerPath::getimgpath($r2[0]->img,$store_id);
                        }else{
                            $r2[0]->imgurl = ServerPath::getimgpath($r2[0]->imgurl,$store_id);
                        }
                        $re_photo = !empty($r2[0]->re_photo) ? unserialize($r2[0]->re_photo):array();
                        $imgs = array();
                        if(!empty($re_photo)){
                            foreach ($re_photo as $key => $value) {
                                $imgs[] = ServerPath::getimgpath($value,$store_id);
                            }
                        }

                        $rdata = array();
                        $r_type = $r2[0]->r_type;
                        if ($r_type == 3) {
                            $oid = $r2[0]->id;
                            $sqlo = "select * from lkt_return_goods where store_id = '$store_id' and oid = '$oid'";
                            $ro = $db->select($sqlo);
                            if($ro){
                                $rdata = (array)$ro[0];
                            }
                        }
                        /*-----------进入订单详情把未读状态改成已读状态，已读状态的状态不变-------*/
                        $sql01 = "select readd,a.id from lkt_order as a ,lkt_order_details AS m where a.store_id = '$store_id' and a.sNo = m.r_sNo and m.id = '$order_details_id'";
                        $r01 = $db->select($sql01);
                        if($r01){
                            if ($r01[0]->readd == 0) {
                                $id01 = $r01[0]->id;
                                $sql02 = "update lkt_order set readd = 1 where store_id = '$store_id' and id = $id01";
                                $up = $db->update($sql02);
                            }
                        }
                        /*--------------------------------------------------------------------------*/
                        echo json_encode(array('code' => 200,'list'=>$r2,'rdata'=>$rdata,'imgs'=>$imgs,'message' => '成功！' ));
                        exit;
                    }else{
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'进入退货页面时，订单详情ID错误，订单详情ID为'.$order_details_id.'！';
                        $this->mchLog($Log_content);
                        echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                        exit;
                    }
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'进入退货页面时，订单号错误，订单号为'.$sNo.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 退款金额页面
    public function return_amount(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = trim($request -> getParameter('sNo')); // 订单号
        $order_details_id = trim($request -> getParameter('order_details_id')); // 订单详情ID

        $user_id = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select a.id,m.freight,a.trade_no,m.num,a.sNo,a.pay,a.z_price,a.user_id,a.spz_price,m.p_price,a.consumer_money,m.express_id from lkt_order as a LEFT JOIN lkt_order_details AS m ON a.sNo = m.r_sNo where a.store_id = '$store_id' and a.mch_id like '%,$mch_id,%' and m.id = '$order_details_id' and m.r_status = '4' ";
                $r1 = $db->select($sql1);
                if($r1){
                    $pay = $r1[0]->pay;
                    $num = $r1[0]->num;
                    $p_price = $r1[0]->p_price * $num;
                    $express_id = $r1[0]->express_id;
                    $consumer_money = $r1[0]->consumer_money;
                    $spz_price = $r1[0]->spz_price;

                    //运费
                    $freight = $r1[0]->freight;
                    $z_price = $r1[0]->z_price;

                    //判断是否发货
                    if ($freight && $express_id) {
                        $z_price = $z_price - $freight;
                        $p_price = $p_price - $freight;
                        $spz_price = $spz_price - $freight;
                    }
                    //计算实际支付金额
                    $price = number_format($z_price / $spz_price * $p_price, 2, ".", "");

                    if ($price <= 0 && $pay == 'consumer_pay' && $consumer_money > 0) {
                        $price = $consumer_money;
                    }
                    echo json_encode(array('code' => 200,'price'=>$price,'message' => '成功！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'进入退款金额页面时，订单详情ID错误，订单详情ID为'.$order_details_id.'！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 通过/拒绝
    public function examine(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $sNo = trim($request -> getParameter('sNo')); // 订单号
        $order_details_id = trim($request -> getParameter('order_details_id')); // 订单详情ID
        $r_type = trim($request -> getParameter('r_type')); // 退货类型
        $price = trim($request->getParameter('price')); // 退款金额
        $text = trim($request->getParameter('text')); // 拒绝理由

        //开启事务
        $JurisdictionAction = new JurisdictionAction();
        $db->begin();
        $time = date("Y-m-d h:i:s", time());
        //退款模板
        $template_id = 'refund_res';

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $company = $r[0]->company;
        }
        $user_id1 = $this->user_id;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id1' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id1 = $r0[0]->id;
            if($mch_id1 == $shop_id){
                // 根据商城ID、店铺ID、订单号、订单详情ID，查询订单
                $sql1 = "select a.user_id,b.id,b.re_type from lkt_order as a left join lkt_order_details as b on a.sNo = b.r_sNo where a.store_id = '$store_id' and a.mch_id like '%,$mch_id1,%' and a.sNo = '$sNo' and b.id = '$order_details_id'";
                $r1 = $db->select($sql1);
                if($r1){ // 存在
                    $re_type = $r1[0]->re_type;
                    if($r_type == 1 || $r_type == 4 || $r_type == 9 && $re_type != 3){
                        // 根据订单详情ID，修改订单详情状态
                        $sql_0 = "update lkt_order_details set r_type = '$r_type' where id = '$order_details_id'";
                        $r_0 = $db->update($sql_0);
                        if($r_type == 4 || $r_type == 9){
                            // 根据商城ID、订单详情ID、退货状态，查询订单信息
                            $sql_id = "select a.offset_balance,m.id as oid,a.id,a.trade_no,m.num,a.sNo,a.pay,a.z_price,a.user_id,a.allow,a.spz_price,a.reduce_price,a.coupon_price,a.coupon_id,a.subtraction_id,a.p_sNo,m.p_price,a.consumer_money,m.express_id,m.freight,m.re_apply_money from lkt_order as a LEFT JOIN lkt_order_details AS m ON a.sNo = m.r_sNo where a.store_id = '$store_id' and m.id = '$order_details_id' and m.r_status = '4' ";
                            $order_res = $db->select($sql_id);
                            if ($order_res) { // 存在
                                $pay = $order_res[0]->pay; // 支付方式
                                $user_id = $order_res[0]->user_id; // 用户ID
                                $coupon_id = $order_res[0]->coupon_id;
                                $subtraction_id = $order_res[0]->subtraction_id; // 满减活动ID
                                $consumer_money = $order_res[0]->consumer_money; // 消费金
                                $express_id = $order_res[0]->express_id; // 快递公司id
                                $freight = $order_res[0]->freight; // 运费
                                $o_d_id = $order_res[0]->oid; // 订单详情ID
                                $offset_balance = $order_res[0]->offset_balance; // 抵扣余额
                                $p_sNo = $order_res[0]->p_sNo; // 父订单号
                                $t1t = true;
                                $z_price = $order_res[0]->z_price; // 订单总价
                                $w_pay = $z_price-$offset_balance; // 实际支付金额
                                $re_apply_money = $order_res[0]->re_apply_money; // 用户填写退款金额
                                $spz_price = $order_res[0]->spz_price; // 商品总价
                                $p_price = $order_res[0]->p_price * $order_res[0]->num; // 该商品总价

                                if (empty($price)) { // 没有填写退款金额，计算出退款金额
                                    $price = $this->get_order_price($o_d_id);
                                }

                                // 组合支付
                                if($offset_balance > 0 && $offset_balance < $z_price){
                                    $return_user_money = number_format($offset_balance / $z_price * $price, 2, ".", "");
                                    $res = $this->return_user_money($user_id,$return_user_money);
                                    $t1t = false;
                                    $price = number_format(($price-$return_user_money) / $z_price * $price, 2, ".", "");
                                }
                                $appid = '';
                                $pay_config = Tools::get_pay_config($db,$pay);
                                if($pay_config){
                                    if ($pay == 'aliPay') {
                                        $appid = $pay_config->appid;
                                    }else{
                                        $mch_id = $pay_config->mch_id;
                                    }
                                }else{
                                    $mch_id = '';
                                }

                                //不同支付方式判断
                                switch ($pay) {
                                    case 'wallet_pay' :
                                        //钱包
                                        if($t1t){
                                            $res = $this->return_user_money($user_id,$price);
                                        }
                                        break;
                                    case 'aliPay' :
                                        //支付宝手机支付
                                        $zfb_res = Alipay::refund($sNo,$price,$appid,$store_id,$pay);
                                        if ($zfb_res != 'success') {
                                            $db->rollback();
                                            echo 0;
                                            exit;
                                        }
                                        break;
                                    case 'wap_unionpay' :
                                        // 中国银联手机支付

                                        break;
                                    case 'app_wechat' :
                                        //微信APP支付.
                                        $wxtk_res = wxpay::wxrefundapi($sNo, $sNo.$o_d_id,$price,$w_pay,$store_id,$pay);
                                        if ($wxtk_res['result_code'] != 'SUCCESS') {
                                            $db->rollback();
                                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'通过订单号为'.$sNo.'退款，调用微信APP支付失败！';
                                            $this->mchLog($Log_content);
                                            echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                            exit;
                                        }
                                        break;
                                    case 'mini_wechat' :
                                        //微信小程序支付
                                        $wxtk_res = wxpay::wxrefundapi($sNo, $sNo.$o_d_id,$price,$w_pay,$store_id,$pay);
                                        if ($wxtk_res['result_code'] != 'SUCCESS') {
                                            $db->rollback();
                                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'通过订单号为'.$sNo.'退款，微信小程序支付失败！';
                                            $this->mchLog($Log_content);
                                            echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                            exit;
                                        }
                                        break;
                                }

                                $should_price = number_format($z_price / $spz_price * $p_price, 2, ".", "");

                                if($should_price > $price) { // 当应退款金额 大于 店家输入的金额
                                    $s_money = $should_price - $price; // 剩余未退款金额
                                    // 根据商城ID、店铺ID，查询店铺余额
                                    $sql4 = "select user_id,account_money from lkt_mch where store_id = '$store_id' and id = '$mch_id1'";
                                    $r4 = $db->select($sql4);
                                    $account_money = $r4[0]->account_money + $s_money; // 店铺余额+剩余未退款金额

                                    // 修改店铺金额
                                    $sql5 = "update lkt_mch set account_money = '$account_money' where store_id = '$store_id' and id = '$mch_id1'";
                                    $r5 = $db->update($sql5);

                                    // 添加一条退款记录
                                    $sql6 = "insert into lkt_mch_account_log (store_id,mch_id,price,account_money,status,type,addtime) values ('$store_id','$mch_id1','$s_money','$account_money',1,2,CURRENT_TIMESTAMP)";
                                    $r6 = $db->insert($sql6);
                                }
                                // 根据订单号,查询商品id、商品名称、商品数量
                                $sql_o = "select p_id,num,p_name,sid from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' ";
                                $r_o = $db->select($sql_o);
                                //退款后还原商品数量
                                foreach ($r_o as $key => $value) {
                                    $pname = $value->p_name;
                                    $pid = $value->p_id;
                                    // 商品id
                                    $num = $value->num;
                                    // 商品数量
                                    $sid = $value->sid;
                                    // 根据商品id,修改商品数量
                                    $sql_p = "update lkt_configure set  num = num + $num where id = $sid";
                                    $r_p = $db->update($sql_p);
                                    // 根据商品id,修改卖出去的销量
                                    $sql_x = "update lkt_product_list set num = num+$num where store_id = '$store_id' and id = $pid";
                                    $r_x = $db->update($sql_x);
                                    if ($r_x < 1 || $r_p < 1) {
                                        $db->rollback();
                                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'通过订单号为'.$sNo.'退款，修改商品库存失败！';
                                        $this->mchLog($Log_content);
                                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                        exit;
                                    }

                                    $keyword1 = array('value' => $sNo, "color" => "#173177");
                                    $keyword2 = array('value' => $pname, "color" => "#173177");
                                    $keyword3 = array('value' => $time, "color" => "#173177");
                                    $keyword4 = array('value' => '退款成功', "color" => "#173177");
                                    $keyword5 = array('value' => $price . '元', "color" => "#173177");
                                    $keyword6 = array('value' => '预计24小时内到账', "color" => "#173177");
                                    $keyword7 = array('value' => '原支付方式', "color" => "#173177");
                                    //拼成规定的格式
                                    $o_data = array('keyword1' => $keyword1, 'keyword2' => $keyword2, 'keyword3' => $keyword3, 'keyword4' => $keyword4, 'keyword5' => $keyword5, 'keyword6' => $keyword6, 'keyword7' => $keyword7);
                                    //发信息
                                    $Tools = new Tools($db, $store_id, '');
                                    $data = array();
                                    $data['page'] = 'pages/index/index';
                                    $data['template_id'] = $template_id;
                                    $data['openid'] = Tools::get_openid($db, $store_id, $user_id);
                                    $data['o_data'] = $o_data;
                                    $tres = $Tools->send_notice($data, 'wx');
                                }

                                //修改订单状态为关闭
                                $sql = "update lkt_order_details set r_status = '6' where store_id = '$store_id' and id = '$order_details_id'";
                                $res1 = $db->update($sql);

                                $sql_o = "select id,MAX(r_status) as ss from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' and r_status <= '4' ";
                                $res_o = $db->select($sql_o);
                                // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                                if ($res_o[0]->ss) {
                                    $ss = $res_o[0]->ss;
                                    $sql_u = "update lkt_order set status = '$ss' where store_id = '$store_id' and sNo = '$sNo' ";
                                    $r_u = $db->update($sql_u);
                                } else {
                                    $sql_u = "update lkt_order set status = '6' where store_id = '$store_id' and sNo = '$sNo' ";
                                    $r_u = $db->update($sql_u);
                                }
                                if($coupon_id != 0){
                                    $time = date("Y-m-d H:i:s");
                                    $sql0 = "select expiry_time from lkt_coupon where store_id = '$store_id' and id = '$coupon_id'";
                                    $r0 = $db->select($sql0);
                                    if($r0){
                                        $expiry_time = $r0[0]->expiry_time;
                                        if($expiry_time < $time){
                                            $sql1 = "update lkt_coupon set type = 3 where store_id = '$store_id' and id = '$coupon_id'";
                                        }else{
                                            $sql1 = "update lkt_coupon set type = 0 where store_id = '$store_id' and id = '$coupon_id'";
                                        }
                                        $db->update($sql1);
                                    }
                                }

                                if($subtraction_id != 0){
                                    // 满减--插件
                                    $auto_jian = new subtraction();
                                    $auto = $auto_jian->give_num($db,$store_id,$sNo);
                                    if($auto == 2){
                                        $db->rollback();
                                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'通过订单号为'.$sNo.'退款，修改赠品库存失败！';
                                        $this->mchLog($Log_content);
                                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                        exit;
                                    }
                                }
                                if ($r_u) {
                                    $JurisdictionAction->admin_record($store_id, $user_id1, ' 批准订单详情id为 ' . $order_details_id . ' 退货 ', 9);
                                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'批准订单详情id为 ' . $order_details_id . ' 退货！';
                                    $this->mchLog($Log_content);
                                    $db->commit();

                                    echo json_encode(array('code' => 200,'message' => '成功！' ));
                                    exit;
                                } else {
                                    $JurisdictionAction->admin_record($store_id, $user_id1, ' 批准订单详情id为 ' . $order_details_id . ' 退货失败 ', 9);
                                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'批准订单详情id为 ' . $order_details_id . ' 退货失败！';
                                    $this->mchLog($Log_content);
                                    $db->rollback();
                                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                                    exit;
                                }

                            } else {
                                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                                exit;
                            }
                        }else{
                            $JurisdictionAction->admin_record($store_id, $user_id1, ' 批准订单详情id为 ' . $order_details_id . ' 退货 ', 9);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'批准订单详情id为 ' . $order_details_id . ' 退货！';
                            $this->mchLog($Log_content);
                            $db->commit();
                            echo json_encode(array('code' => 200,'message' => '成功！' ));
                            exit;
                        }
                    }else if($re_type == 3 && $r_type == 3){

                        //售后店家寄回商品
                        $express = intval($request->getParameter('express'));//快递公司编号
                        $courier_num = $request->getParameter('courier_num');//快递单号
                        //快递添加一条数据
                        $sel_user_info = "SELECT o.user_id,o.name,o.mobile
                                FROM lkt_order_details as od
                                LEFT JOIN lkt_order as o on o.sNo = od.r_sNo
                                where od.id = '$order_details_id' and od.store_id = $store_id";
                        $user_info = $db->select($sel_user_info);
                        $lxr = $user_info[0]->name;
                        $lxdh = $user_info[0]->mobile;
                        $userid = $user_info[0]->user_id;

                        //查询快递名称
                        $sel_express = "SELECT * FROM `lkt_express` WHERE id = $express";
                        $express_res = $db->select($sel_express);
                        $kdname =$express_res[0]->kuaidi_name;

                        $sql = "insert into lkt_return_goods(store_id,name,tel,express,express_num,user_id,oid,add_data)
                    values('$store_id','$lxr','$lxdh','$kdname','$courier_num','$userid','$order_details_id',CURRENT_TIMESTAMP)";
                        $rid = $db->insert($sql,'last_insert_id');

                        $up_order_d_sql = "update lkt_order_details set express_id='$express',courier_num='$courier_num',r_type = 11 where store_id = '$store_id' and id = '$order_details_id'";
                        $res = $db->update($up_order_d_sql);

                        if($res && $rid){
                            //执行成功
                            $db->commit();
                            echo json_encode(array('code' => 200,'message' => '成功！' ));
                            exit();
                        }else{
                            //执行失败
                            $db->rollback();
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'批准订单详情id为 ' . $order_details_id . ' 退货失败！';
                            $this->mchLog($Log_content);
                            echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                            exit();
                        }
                    }else{ // 拒绝
                        // 根据商城ID、订单详情ID、退货状态，查询订单信息
                        $sql_id = "select a.id,a.trade_no,a.sNo,a.pay,a.z_price,a.user_id,a.source from lkt_order as a LEFT JOIN lkt_order_details AS m ON a.sNo = m.r_sNo where a.store_id = '$store_id' and m.id = '$order_details_id' and m.r_status = '4' ";
                        $order_res = $db->select($sql_id);
                        $sNo = $order_res[0]->sNo;
                        $z_price = $order_res[0]->z_price;
                        $user_id = $order_res[0]->user_id;
                        //  判断订单来源
                        if ($order_res[0]->source == 1) {

                            $keyword1 = array('value' => $sNo, "color" => "#173177");
                            $keyword2 = array('value' => $company, "color" => "#173177");
                            $keyword3 = array('value' => $time, "color" => "#173177");
                            $keyword4 = array('value' => '退款失败', "color" => "#173177");
                            $keyword5 = array('value' => $z_price . '元', "color" => "#173177");
                            $keyword6 = array('value' => $text, "color" => "#173177");
                            $keyword7 = array('value' => '系统已还原订单状态', "color" => "#173177");
                            //拼成规定的格式
                            $o_data = array('keyword1' => $keyword1, 'keyword2' => $keyword2, 'keyword3' => $keyword3, 'keyword4' => $keyword4, 'keyword5' => $keyword5, 'keyword6' => $keyword6, 'keyword7' => $keyword7);

                            //发信息
                            $Tools = new Tools($db, $store_id, $this->store_type);
                            $data = array();
                            $data['page'] = 'pages/index/index';
                            $data['template_id'] = $template_id;
                            $data['openid'] = Tools::get_openid($db, $store_id, $user_id);
                            $data['o_data'] = $o_data;
                            $tres = $Tools->send_notice($data, 'wx');
                        } else {
                            /**退款拒绝通知*/
                            $pusher = new LaikePushTools();
                            $pusher->pushMessage($user_id, $db, '退款拒绝通知', $text,$store_id,'');
                        }
                        $text = htmlentities($request->getParameter('text'));
                        //回退订单状态
                        $utts = 1;
                        //查询订单信息
                        $sql_p = "select express_id from lkt_order_details where store_id = '$store_id' and id = '$order_details_id'";
                        $res_p = $db->select($sql_p);
                        if ($res_p[0]->express_id) { // 存在快递信息
                            $utts = 2;
                            //判断之前的状态并修改
                            $sql = "select id from lkt_comments where store_id = '$store_id' and oid = '$sNo' ";
                            $resu = $db->selectrow($sql);
                            if ($resu > 0) { // 已评论
                                $utts = 3;
                            }
                        }

                        // 根据订单号,修改订单详情状态------------还原子订单状态
                        $sql_d = "update lkt_order_details set r_status = '$utts',r_type = '$r_type',r_content = '$text' where store_id = '$store_id' and id = '$order_details_id' ";
                        $res = $db->update($sql_d);
                        $sql_o = "select id,MIN(r_status) as ss from lkt_order_details where store_id = '$store_id' and r_sNo = '$sNo' and r_status < 4 and r_status > 0 ";
                        $res_o = $db->select($sql_o);
                        // 如果订单下面的商品都处在同一状态,那就改订单状态为已完成
                        if (count($res_o) < 1) {
                            $sql_u = "update lkt_order set status = '$utts' where store_id = '$store_id' and sNo = '$sNo' ";
                            $r_u = $db->update($sql_u);
                        } else {
                            $ss = $res_o[0]->ss;
                            $sql_u = "update lkt_order set status = '$ss' where store_id = '$store_id' and sNo = '$sNo' ";
                            $r_u = $db->update($sql_u);
                        }
                        if ($res) {
                            $JurisdictionAction->admin_record($store_id, $user_id1, ' 拒绝订单详情id为 ' . $order_details_id . ' 退货 ', 9);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'拒绝订单详情id为 ' . $order_details_id . ' 退货！';
                            $this->mchLog($Log_content);
                            $db->commit();
                            echo json_encode(array('code' => 200,'message' => '成功！' ));
                            exit;
                        } else {
                            $JurisdictionAction->admin_record($store_id, $user_id1, ' 拒绝订单详情id为 ' . $order_details_id . ' 退货失败 ', 9);
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'拒绝订单详情id为 ' . $order_details_id . ' 退货失败！';
                            $this->mchLog($Log_content);
                            $db->rollback();
                            echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                            exit;
                        }
                    }
                }else{
                    echo json_encode(array('code' => 115,'message' => '非法入侵1！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'店铺ID为'.$mch_id1.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id1.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 我的提现
    public function my_wallet(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID

        $user_id = $this->user_id;

        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id,account_money,integral_money from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            $account_money = $r0[0]->account_money; // 商户余额
            $integral_money = $r0[0]->integral_money; // 商户积分
            if($mch_id == $shop_id){
                $sql1 = "select illustrate from lkt_mch_config where store_id = '$store_id'";
                $r1 = $db -> select($sql1);
                if($r1){
                    $illustrate = $r1[0]->illustrate; // 提现说明
                }else{
                    $illustrate = '';
                }

                // 收入总额
                $sql = "select sum(price) as sum from lkt_mch_account_log where store_id = '$store_id' and mch_id = '$mch_id' and type=1";
                $rrr = $db->select($sql);
                $all_money = $rrr?$rrr[0]->sum:'0.00';

                echo json_encode(array('code' => 200,'account_money'=>$account_money,'integral_money'=>$integral_money,'all_money'=>$all_money,'illustrate'=>$illustrate,'message' => '成功！' ));
                exit;
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 账户明细
    public function account_details(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $type = trim($request->getParameter('type')); // 类型

        $user_id = $this->user_id;

        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $list = array();
                $list1 = array();
                $num = 0;
                if($type == 1){ // 入账
                    $sql1 = "select * from lkt_mch_account_log where store_id = '$store_id' and mch_id = '$mch_id' and status = 1 order by addtime desc limit 0,10";
                }else if($type == 2){ // 出账
                    $sql1 = "select * from lkt_mch_account_log where store_id = '$store_id' and mch_id = '$mch_id' and status = 2 order by addtime desc limit 0,10";
                }else{ // 积分
                    $sql1 = "select * from lkt_mch_account_log where store_id = '$store_id' and mch_id = '$mch_id' and integral>0 order by addtime desc limit 0,10";
                }
                $r1 = $db->select($sql1);
                if($r1){
                    foreach ($r1 as $k => $v){
                        $v->time = date("Y-n-j",strtotime($v->addtime));
                        if($v->status == 1){
                            if($v->integral > 0){
                                $v->type_name = '积分兑换';
                            }else{
                                $v->type_name = '订单';
                            }
                        }else{
                            $v->type_name = '提现';
                        }
                        $list1[$v->time][] = $v;
                    }

                    foreach ($list1 as $ke => $va){
                        $list[$num]['time'] = $ke;
                        $list[$num]['res'] = $va;
                        $num = $num+1;
                    }
                }
                echo json_encode(array('code' => 200,'list'=>$list,'message' => '成功！' ));
                exit;
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 账户明细-加载更多
    public function account_details_load(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $type = trim($request->getParameter('type')); // 类型
        $pege = trim($request->getParameter('pege'));

        $user_id = $this->user_id;
        $start = $pege*10;
        $end = 20;
        // 根据商城id、用户id、审核通过，查询店铺ID
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $list = array();
                if($type == 1){ // 入账
                    $sql1 = "select * from lkt_mch_account_log where store_id = '$store_id' and mch_id = '$mch_id' and status = 1 order by addtime desc limit $start,$end";
                }else{ // 出账
                    $sql1 = "select * from lkt_mch_account_log where store_id = '$store_id' and mch_id = '$mch_id' and status = 2 order by addtime desc limit $start,$end";
                }
                $r1 = $db->select($sql1);
                if($r1){
                    foreach ($r1 as $k => $v){
                        $v->time = date("Y-n-j",strtotime($v->addtime));
                        if($v->type == 1){
                            $v->type_name = '订单';
                        }else if($v->type == 2){
                            $v->type_name = '退款';
                        }else{
                            $v->type_name = '提现';
                        }
                        $list[$k]['time'] = $v->time;
                        $list[$k]['res'] = $v;
                    }
                }
                echo json_encode(array('code' => 200,'list'=>$list,'message' => '成功！' ));
                exit;
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 我的门店
    public function my_store(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $user_id = $this->user_id;

        $sql1 = "select * from lkt_mch_store where store_id = '$store_id' and mch_id = '$shop_id' ";
        $r1 = $db->select($sql1);

        echo json_encode(array('code' => 200,'list'=>$r1,'message' => '成功！' ));
        exit;
    }
    // 添加我的门店
    public function add_store(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $name = trim($request->getParameter('name')); // 店铺名称
        $mobile = trim($request->getParameter('mobile')); // 联系电话
        $business_hours = trim($request->getParameter('business_hours')); // 营业时间
        $city_all = trim($request->getParameter('city_all')); // 省市区
        $address = trim($request->getParameter('address')); // 详细地址
        $user_id = $this->user_id;
        $db->begin();

        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id;
            if($id == $shop_id){
                if($name == ''){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加门店时，店铺名称不能为空！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'店铺名称不能为空！'));
                    exit;
                }
                if($mobile == ''){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加门店时，联系电话不能为空！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'联系电话不能为空！'));
                    exit;
                }else{
                    if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/", $mobile)){

                    }else{
                        if (preg_match("/^([0-9]{3,4}-)?[0-9]{7,8}$/", $mobile)) {

                        } else {
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加门店时，联系电话有误！';
                            $this->mchLog($Log_content);
                            echo json_encode(array('code'=>109,'message'=>'联系电话有误！'));
                            exit;
                        }
                    }
                }
                $arr = explode('~',$business_hours);
                if($arr[0] >= $arr[1]){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加门店时，营业时间有误！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'营业时间有误！'));
                    exit;
                }
                if($city_all == ''){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加门店时，所在城市不能为空！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'所在城市不能为空！'));
                    exit;
                }else{
                    $city_all = explode('-',$city_all);
                    $sheng = $city_all[0];
                    $shi = $city_all[1];
                    $xian = $city_all[2];
                }

                if($address == ''){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加门店时，详细地址不能为空！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'详细地址不能为空！'));
                    exit;
                }
                $sql1 = "insert into lkt_mch_store(store_id,mch_id,name,mobile,business_hours,sheng,shi,xian,address,add_date) value ('$store_id','$shop_id','$name','$mobile','$business_hours','$sheng','$shi','$xian','$address',CURRENT_TIMESTAMP)";
                $r1 = $db->insert($sql1);
                if($r1 > 0){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加门店成功！';
                    $this->mchLog($Log_content);
                    $db->commit();

                    echo json_encode(array('code' => 200,'message' => '成功！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'添加门店失败！';
                    $this->mchLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 编辑我的门店-页面
    public function edit_store_page(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $user_id = $this->user_id;

        $list = array();
        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $sql1 = "select * from lkt_mch_store where store_id = '$store_id' and mch_id = '$shop_id' ";
                $r1 = $db->select($sql1);
                if($r1){
                    $r1[0]->business_hours = explode(',',$r1[0]->business_hours);
                    $list = $r1[0];
                }
                echo json_encode(array('code' => 200,'list'=>$list,'message' => '成功！' ));
                exit;
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 编辑我的门店
    public function edit_store(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID

        $name = trim($request->getParameter('name')); // 店铺名称
        $mobile = trim($request->getParameter('mobile')); // 联系电话
        $business_hours = trim($request->getParameter('business_hours')); // 营业时间
        $city_all = trim($request->getParameter('city_all')); // 省市区
        $address = trim($request->getParameter('address')); // 详细地址
        $user_id = $this->user_id;
        $db->begin();

        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                if($name == ''){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑门店时，店铺名称不能为空！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'店铺名称不能为空！'));
                    exit;
                }
                if($mobile == ''){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑门店时，联系电话不能为空！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'联系电话不能为空！'));
                    exit;
                }else{
                    if(preg_match("/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{1}[0-9]{8}$/", $mobile)){

                    }else{
                        if (preg_match("/^([0-9]{3,4}-)?[0-9]{7,8}$/", $mobile)) {

                        } else {
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑门店时，联系电话有误！';
                            $this->mchLog($Log_content);
                            echo json_encode(array('code'=>109,'message'=>'联系电话有误！'));
                            exit;
                        }
                    }
                }
                $arr = explode('~',$business_hours);
                if($arr[0] >= $arr[1]){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑门店时，营业时间有误！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'营业时间有误！'));
                    exit;
                }
                if($city_all == ''){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑门店时，所在城市不能为空！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'所在城市不能为空！'));
                    exit;
                }else{
                    $city_all = explode('-',$city_all);
                    $sheng = $city_all[0];
                    $shi = $city_all[1];
                    $xian = $city_all[2];
                }

                if($address == ''){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑门店时，详细地址不能为空！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code'=>109,'message'=>'详细地址不能为空！'));
                    exit;
                }
                $sql1 = "update lkt_mch_store set name='$name',mobile='$mobile',business_hours='$business_hours',sheng='$sheng',shi='$shi',xian='$xian',address='$address' where store_id = '$store_id' and mch_id = '$shop_id' ";
                $r1 = $db->update($sql1);

                if($r1 == -1){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑门店失败！';
                    $this->mchLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'编辑门店成功！';
                    $this->mchLog($Log_content);
                    $db->commit();

                    echo json_encode(array('code' => 200,'message' => '成功！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 删除我的门店
    public function del_store(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id')); // 店铺ID
        $user_id = $this->user_id;
        $db->begin();

        $sql0 = "select id from lkt_mch where store_id = '$store_id' and user_id = '$user_id' and review_status = 1";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->id;
            if($mch_id == $shop_id){
                $mch_id1 = ','.$mch_id.',';
                $sql0_0 = "select id from lkt_order where store_id = '$store_id' and mch_id = '$mch_id1' and self_lifting = '1'";
                $r0_0 = $db->select($sql0_0);
                if($r0_0){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'删除门店时，该门店已生产订单！';
                    $this->mchLog($Log_content);
                    echo json_encode(array('code' => 103,'message' => '该门店已生产订单，不能删除！' ));
                    exit;
                }
                $sql1 = "delete from lkt_mch_store where store_id = '$store_id' and mch_id = '$shop_id' ";
                $r1 = $db->delete($sql1);
                if($r1 > 0){
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'删除门店成功！';
                    $this->mchLog($Log_content);
                    $db->commit();
                    echo json_encode(array('code' => 200,'message' => '成功！' ));
                    exit;
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'删除门店失败！';
                    $this->mchLog($Log_content);
                    $db->rollback();
                    echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'店铺ID为'.$mch_id.'与传过来的店铺ID'.$shop_id.'不一致！';
                $this->mchLog($Log_content);
                echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'没有店铺！';
            $this->mchLog($Log_content);
            echo json_encode(array('code' => 115,'message' => '非法入侵！' ));
            exit;
        }
    }
    // 验证提货码
    public function verification_extraction_code(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('order_id'));// 订单id
        $extraction_code = trim($request->getParameter('extraction_code'));// 提货码

        // 1.开启事务
        $db->begin();
        $mch = new mch();

        // 根据微信id,查询用户id
        $sql0 = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $user_id = $r0[0] -> user_id;
            if($id){
                $sql1 = "select a.sNo,a.z_price,a.allow,a.status,a.extraction_code,b.p_id,b.num,b.p_price from lkt_order as a left join lkt_order_details as b on a.sNo = b.r_sNo where a.store_id = '$store_id' and a.id = '$id' and a.mch_id like '%,$shop_id,%' and a.extraction_code like '%$extraction_code%'";
            }else{
                $sql1 = "select a.sNo,a.z_price,a.allow,a.status,a.extraction_code,b.p_id,b.num,b.p_price from lkt_order as a left join lkt_order_details as b on a.sNo = b.r_sNo where a.store_id = '$store_id' and a.mch_id like '%,$shop_id,%' and a.extraction_code like '%$extraction_code%'";
            }
            $r1 = $db->select($sql1);
            if($r1){
                $sNo = $r1[0]->sNo;
                $allow = $r1[0]->allow;
                $z_price = $r1[0]->z_price;
                $status = $r1[0]->status;
                $p_id = $r1[0]->p_id;
                $num = $r1[0]->num;
                $rew = explode(',',$r1[0]->extraction_code);

                $p_price = $r1[0]->p_price;
                if($status == 2){
                    if($rew[2] <= time()){ // 提货码有效时间 小于等于 当前时间
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'验证提货码时，验证码已失效！';
                        $mch->mchLog($Log_content);
                        echo json_encode(array('code'=>103,'message'=>'验证码已失效！'));
                        exit;
                    }else{
                        if($rew[0] != $extraction_code){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'验证提货码时，验证码已失效！';
                            $mch->mchLog($Log_content);
                            echo json_encode(array('code'=>115,'message'=>'验证码已失效！'));
                            exit;
                        }
                    }

                    $sql2 = "update lkt_order set status = 3 where sNo = '$sNo'";
                    $r2 = $db->update($sql2);
                    if($r2 == -1){
                        $db->rollback();
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提订单号'.$sNo.'时,改变订单状态失败！';
                        $mch->mchLog($Log_content);

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                        exit;
                    }
                    $sql3 = "update lkt_order_details set r_status = 3 where r_sNo = '$sNo'";
                    $r3 = $db->update($sql3);
                    if($r3 == -1){
                        $db->rollback();
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提订单号'.$sNo.'时,改变订单详情状态失败！';
                        $mch->mchLog($Log_content);

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                        exit;
                    }
                    $sql_x = "update lkt_product_list set volume = volume + '$num' where store_id = '$store_id' and id = '$p_id'";
                    $r_x = $db->update($sql_x);
                    if ($r_x < 1) {
                        $db->rollback();
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提订单号'.$sNo.'时,改变商品销量失败！';
                        $mch->mchLog($Log_content);

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！'));
                        exit;
                    }

                    $mch = new mch();
                    $mch->parameter($db,$store_id,$sNo,$z_price,$allow);

                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提订单号'.$sNo.'成功！';
                    $mch->mchLog($Log_content);

                    $db->commit();
                    echo json_encode(array('code'=>200,'sNo'=>$sNo,'p_price'=>$z_price,'message'=>'成功'));
                    exit();
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提订单号'.$sNo.'时，验证码已失效！';
                    $mch->mchLog($Log_content);

                    echo json_encode(array('code'=>115,'message'=>'验证码已失效！'));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提时，提货码'.$extraction_code.'错误！';
                $mch->mchLog($Log_content);
                echo json_encode(array('code'=>115,'message'=>'验证码错误！'));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . $access_id.'错误！';
            $mch->mchLog($Log_content);

            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }
    // 扫码提货码
    public function sweep_extraction_code(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $shop_id = trim($request->getParameter('shop_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $id = trim($request->getParameter('order_id'));// 订单id
        $extraction_code = trim($request->getParameter('extraction_code'));// 提货码

        // 1.开启事务
        $db->begin();
        $mch = new mch();

        // 根据微信id,查询用户id
        $sql0 = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $user_id = $r0[0] -> user_id;
            if($id){
                $sql1 = "select a.sNo,a.z_price,a.allow,a.status,a.extraction_code,b.p_id,b.num,b.p_price from lkt_order as a left join lkt_order_details as b on a.sNo = b.r_sNo where a.store_id = '$store_id' and a.id = '$id' and a.mch_id like '%,$shop_id,%' and a.extraction_code like '%$extraction_code%'";
            }else{
                $sql1 = "select a.sNo,a.z_price,a.allow,a.status,a.extraction_code,b.p_id,b.num,b.p_price from lkt_order as a left join lkt_order_details as b on a.sNo = b.r_sNo where a.store_id = '$store_id' and a.mch_id like '%,$shop_id,%' and a.extraction_code like '%$extraction_code%'";
            }
            $r1 = $db->select($sql1);
            if($r1){
                $sNo = $r1[0]->sNo;
                $allow = $r1[0]->allow;
                $z_price = $r1[0]->z_price;
                $status = $r1[0]->status;
                $p_id = $r1[0]->p_id;
                $num = $r1[0]->num;
                $rew = explode(',',$r1[0]->extraction_code);
                $p_price = $r1[0]->p_price;

                if($status == 2){
                    if($rew[2] <= time()){ // 提货码有效时间 小于等于 当前时间
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'验证提货码时，验证码已失效！';
                        $mch->mchLog($Log_content);
                        echo json_encode(array('code'=>103,'message'=>'验证码已失效！'));
                        exit;
                    }else{
                        if($r1[0]->extraction_code != $extraction_code){
                            $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'验证提货码时，验证码已失效！';
                            $mch->mchLog($Log_content);
                            echo json_encode(array('code'=>103,'message'=>'验证码已失效！'));
                            exit;
                        }
                    }

                    $sql2 = "update lkt_order set status = 3 where sNo = '$sNo'";
                    $r2 = $db->update($sql2);
                    if($r2 == -1){
                        $db->rollback();
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提订单号'.$sNo.'时,改变订单状态失败！';
                        $mch->mchLog($Log_content);

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                        exit;
                    }
                    $sql3 = "update lkt_order_details set r_status = 3 where r_sNo = '$sNo'";
                    $r3 = $db->update($sql3);
                    if($r3 == -1){
                        $db->rollback();
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提订单号'.$sNo.'时,改变订单详情状态失败！';
                        $mch->mchLog($Log_content);

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！' ));
                        exit;
                    }
                    $sql_x = "update lkt_product_list set volume = volume + '$num' where store_id = '$store_id' and id = '$p_id'";
                    $r_x = $db->update($sql_x);
                    if ($r_x < 1) {
                        $db->rollback();
                        $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提订单号'.$sNo.'时,改变商品销量失败！';
                        $mch->mchLog($Log_content);

                        echo json_encode(array('code' => 103,'message' => '网络繁忙！'));
                        exit;
                    }
                    $mch = new mch();
                    $mch->parameter($db,$store_id,$sNo,$z_price,$allow);
                    $db->commit();
                    echo json_encode(array('code'=>200,'sNo'=>$sNo,'p_price'=>$z_price,'message'=>'成功'));
                    exit();
                }else{
                    $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提时，验证码已失效！';
                    $mch->mchLog($Log_content);
                    echo json_encode(array('code'=>103,'message'=>'验证码已失效！'));
                    exit;
                }
            }else{
                $Log_content = __METHOD__ . '->' . __LINE__ . '会员'.$user_id.'自提时，验证码已失效！';
                $mch->mchLog($Log_content);
                echo json_encode(array('code'=>103,'message'=>'验证码已失效！'));
                exit;
            }
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . $access_id.'错误！';
            $mch->mchLog($Log_content);
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }
    // 验证身份证格式是否正确
    public function is_idcard( $id )
    {
        $id = strtoupper($id);
        $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
        $arr_split = array();
        if(!preg_match($regx, $id))
        {
            return false;
        }
        if(15==strlen($id)) //检查15位
        {
            $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

            @preg_match($regx, $id, $arr_split);
            //检查生日日期是否正确
            $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
            if(!strtotime($dtm_birth))
            {
                return FALSE;
            } else {
                return TRUE;
            }
        }
        else      //检查18位
        {
            $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
            @preg_match($regx, $id, $arr_split);
            $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
            if(!strtotime($dtm_birth)) //检查生日日期是否正确
            {
                return FALSE;
            }
            else
            {
                //检验18位身份证的校验码是否正确。
                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                $sign = 0;
                for ( $i = 0; $i < 17; $i++ )
                {
                    $b = (int) $id{$i};
                    $w = $arr_int[$i];
                    $sign += $b * $w;
                }
                $n = $sign % 11;
                $val_num = $arr_ch[$n];
                if ($val_num != substr($id,17, 1))
                {
                    return FALSE;
                } //phpfensi.com
                else
                {
                    return TRUE;
                }
            }
        }

    }
    // 去除重复
    public function a_array_unique($array){ //写的比较好（写方法）
        $out = array(); //定义变量out为一个数组
        foreach ($array as $key=>$value){ //将$array数组按照$key=>$value的样式进行遍历
            if (!in_array($value, $out)){//如果$value不存在于out数组中，则执行
                $out[$key] = $value; //将该value值存入out数组中
            }
        }
        return $out; //最后返回数组out
    }
    // 验证卡号是否跟银行匹配
    function bankInfo($card,$bankList) {
        $card_8 = substr($card, 0, 8);
        if (isset($bankList[$card_8])) {
            return $bankList[$card_8];
        }
        $card_6 = substr($card, 0, 6);
        if (isset($bankList[$card_6])) {
            return $bankList[$card_6];
        }
        $card_5 = substr($card, 0, 5);
        if (isset($bankList[$card_5])) {
            return $bankList[$card_5];
        }
        $card_4 = substr($card, 0, 4);
        if (isset($bankList[$card_4])) {
            return $bankList[$card_4];
        }
        return '';
    }
    // 获取退款金额
    public function get_order_price($id)
    {
        $db = $this->db;
        $store_id = $this->store_id;
        //判断单个商品退款是否有使用优惠
        $sql_id = "select a.id,m.freight,a.trade_no,m.num,a.sNo,a.pay,a.z_price,a.user_id,a.spz_price,m.p_price,a.consumer_money,m.express_id ,m.re_apply_money from lkt_order as a LEFT JOIN lkt_order_details AS m ON a.sNo = m.r_sNo where a.store_id = '$store_id' and m.id = '$id' and m.r_status = '4' ";
        $order_res = $db->select($sql_id);
        $re_apply_money = $order_res[0]->re_apply_money; // 用户填写退款金额
        $pay = $order_res[0]->pay; // 支付方式
        $num = $order_res[0]->num; // 数量
        $p_price = $order_res[0]->p_price * $num; // 单个商品总价
        $express_id = $order_res[0]->express_id; // 快递ID
        $consumer_money = $order_res[0]->consumer_money;
        $spz_price = $order_res[0]->spz_price; // 商品总价

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
        if((int)$re_apply_money < (int)$price && (int)$re_apply_money > 0){ // 当用户填写退款金额 小于 计算实际支付金额
            $price = $re_apply_money; // 用用户填写退款金额
        }
        return $price;
    }
    // 归还用户钱
    public function return_user_money($user_id,$price)
    {
        $db = $this->db;
        $store_id = $this->store_id;

        // 根据商城ID、买家用户ID，查询买家余额
        $sql1 = "select money from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
        $r1 = $db->select($sql1);
        $money = $r1[0]->money;
        // 修改买家用户余额
        $sql2 = "update lkt_user set money = money + '$price' where store_id = '$store_id' and user_id = '$user_id'";
        $res = $db->update($sql2);
        // 添加买家退款日志
        $event = $user_id . '退款' . $price . '元余额';
        $sqll3 = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$price','$money','$event',5)";
        $rr = $db->insert($sqll3);

        return 1;
    }
    // 自动生成商品编码
    public function add($obj = '')
    {
        $res1 = "L18";
        $res2 = "K";
        $res3 = "T";
        if ($obj == '') {
            $product_number = $res1 . '-' . $res2 . '001-' . $res3 . '001';
        } else {
            $arr = explode("-", $obj);
            $arr[1] = substr($arr[1], 1);
            $arr[2] = substr($arr[2], 1);
            $bit = 3;//产生7位数的数字编号

            if ((int)$arr[2] == 999) {
                $rew2 = (int)$arr[1] + 1;
                $rew3 = "001";
                $num_len = strlen($rew2);
                $zero = '';
                for ($i = $num_len; $i < $bit; $i++) {
                    $zero .= "0";
                }
                $real_num = $zero . $rew2;
                $product_number = $res1 . '-' . $res2 . $real_num . '-' . $res3 . $rew3;
            } else {
                $rew3 = (int)$arr[2] + 1;
                $num_len = strlen($rew3);
                $zero = '';
                for ($i = $num_len; $i < $bit; $i++) {
                    $zero .= "0";
                }
                $real_num = $zero . $rew3;
                $product_number = $res1 . '-' . $res2 . $arr[1] . '-' . $res3 . $real_num;
            }
        }
        return $product_number;
    }

    public function Send_Prompt($appid, $appsecret, $form_id, $openid, $page, $send_id, $o_data) {
        $db = DBAction::getInstance();
        $request = $this -> getContext() -> getRequest();
        $AccessToken = $this -> getAccessToken($appid, $appsecret);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;
        $data = json_encode(array('access_token' => $AccessToken, 'touser' => $openid, 'template_id' => $send_id, 'form_id' => $form_id, 'page' => $page, 'data' => $o_data));
        $da = $this -> httpsRequest($url, $data);
        return $da;
    }
    function getAccessToken($appID, $appSerect) {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appID . "&secret=" . $appSerect;
        // 时效性7200秒实现
        // 1.当前时间戳
        $currentTime = time();
        // 2.修改文件时间
        $fileName = "accessToken";
        // 文件名
        if (is_file($fileName)) {
            $modifyTime = filemtime($fileName);
            if (($currentTime - $modifyTime) < 7200) {
                // 可用, 直接读取文件的内容
                $accessToken = file_get_contents($fileName);
                return $accessToken;
            }
        }
        // 重新发送请求
        $result = $this -> httpsRequest($url);
        $jsonArray = json_decode($result, true);
        // 写入文件
        $accessToken = $jsonArray['access_token'];
        file_put_contents($fileName, $accessToken);
        return $accessToken;
    }
    function httpsRequest($url, $data = null) {
        // 1.初始化会话
        $ch = curl_init();
        // 2.设置参数: url + header + 选项
        // 设置请求的url
        curl_setopt($ch, CURLOPT_URL, $url);
        // 保证返回成功的结果是服务器的结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
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
    public function get_fromid($openid, $type = '') {
        $db = DBAction::getInstance();
        $request = $this -> getContext() -> getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        if (empty($type)) {
            $fromidsql = "select fromid,open_id from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and id=(select max(id) from lkt_user_fromid where open_id='$openid')";
            $fromidres = $db -> select($fromidsql);
            if ($fromidres) {
                $fromid = $fromidres[0] -> fromid;
                $arrayName = array('openid' => $openid, 'fromid' => $fromid);
                return $arrayName;
            } else {
                return array('openid' => $openid, 'fromid' => '123456');
            }
        } else {
            $delsql = "delete from lkt_user_fromid where store_id = '$store_id' and open_id='$openid' and fromid='$type'";
            $re2 = $db -> delete($delsql);
            return $re2;
        }

    }
    /**
     * 图片上传
     */
    public function uploadImgs(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        if($store_type = 1){
            $store_type = '0';
        }elseif ($store_type = 2){
            $store_type = 'app';
        }
        // 查询配置表信息
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        $uploadImg = $r[0]->uploadImg;
        $uploadImg_domain = $r[0]->uploadImg_domain;
        //upserver 1:本地 2:阿里云OSS
        $upserver = !empty($r)?$r[0]->upserver:'2';   //如果没有设置配置则默认用阿里云
        // 图片上传位置
        if(empty($uploadImg)){
            $uploadImg = "../LKT/images";
        }
        if(!empty($_FILES)){ // 如果图片不为空
            if($upserver == '2'){
                $image = ServerPath::file_OSSupload($store_id, $store_type);
            }else{
                $image = ServerPath::file_upload($store_id,$uploadImg,$uploadImg_domain,$store_type);
            }
            $image = ServerPath::getimgpath($image,$store_id);
            if($image == false){
                echo json_encode(array('code' => 109,'message'=>'上传失败或图片格式错误！'));
                exit;
            }else{
                echo json_encode(array('code' => 200,'data'=>$image));
                exit;
            }
        }else{
            echo json_encode(array('code' => 109,'message'=>'上传失败！'));
            exit;
        }
    }
    // 商品状态
    public function commodity_status($db,$store_id,$id){
        $sql0 = "select product_title,product_class,status,brand_id,mch_id,initial,freight,active from lkt_product_list as a where a.store_id = '$store_id' and a.recycle = 0 and a.id = '$id'";
        $r0 = $db->select($sql0);
        if($r0){
            $status = $r0[0]->status;
            if($status == 2){
                $sql1 = "select a.* from lkt_product_list as a left join lkt_order_details as b on a.id = b.p_id where a.store_id = '$store_id' and a.recycle = 0 and a.mch_status = 2 and r_status in (0,1,2) and a.id = '$id'";
                $r1 = $db->select($sql1);
                if($r1){
                    echo json_encode(array('code' => 109,'message' => '该商品有未完成的订单，无法下架！' ));
                    exit;
                }else{
                    // 砍价
                    $sql00 = "select * from lkt_bargain_goods where store_id = '$store_id' and status = 1 and is_delete = 0 and goods_id = '$id' ";
                    $r00 = $db->select($sql00);
                    if($r00){
                        echo json_encode(array('code' => 109,'message' => '该商品有参与插件活动，无法下架！' ));
                        exit;
                    }
                    // 拼团
                    $sql01 = "select g_status from lkt_group_product where store_id = '$store_id' and product_id = '$id' ";
                    $r01 = $db->select($sql01);
                    if($r01){
                        echo json_encode(array('code' => 109,'message' => '该商品有参与插件活动，无法下架！' ));
                        exit;
                    }
                    // 竞拍
                    $sql02 = "(select attribute from lkt_auction_product where store_id = '$store_id' and status in (0,1) ) union (select attribute from lkt_auction_product where store_id = '$store_id' and status = 2 and is_buy = 0)";
                    $r02 = $db->select($sql02);
                    $arr = array();//正在进行活动中的商品id数组
                    if($r02){
                        foreach ($r02 as $k => $v) {
                            $attr = $v->attribute;//序列化的字符串
                            $attr = unserialize($attr);
                            $arr[$k] = array_keys($attr);//商品id数组
                        }
                        if(in_array($id, $arr)){
                            echo json_encode(array('code' => 109,'message' => '该商品有参与插件活动，无法下架！' ));
                            exit;
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
                                    echo json_encode(array('code' => 109,'message' => '该商品有参与插件活动，无法下架！' ));
                                    exit;
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
                            echo json_encode(array('code' => 109,'message' => '该商品有参与插件活动，无法下架！' ));
                            exit;
                        }
                    }
                }
            }else{
                if(strlen($r0[0]->product_title) > 60){
                    echo json_encode(array('code' => 109,'message' => '请先去完善商品信息！' ));
                    exit;
                }
                if($r0[0]->initial){
                    $initial = unserialize($r0[0]->initial);
                    foreach ($initial as $k => $v){
                        if($k == 'cbj' && $v == ''){
                            echo json_encode(array('code' => 109,'message' => '请先去完善商品信息！' ));
                            exit;
                        }else if($k == 'yj' && $v == ''){
                            echo json_encode(array('code' => 109,'message' => '请先去完善商品信息！' ));
                            exit;
                        }else if($k == 'sj' && $v == ''){
                            echo json_encode(array('code' => 109,'message' => '请先去完善商品信息！' ));
                            exit;
                        }else if($k == 'unit' && $v == '0'){
                            echo json_encode(array('code' => 109,'message' => '请先去完善商品信息！' ));
                            exit;
                        }else if($k == 'kucun' && $v == ''){
                            echo json_encode(array('code' => 109,'message' => '请先去完善商品信息！' ));
                            exit;
                        }
                    }
                }
                if ($r0[0]->freight == 0) {
                    echo json_encode(array('code' => 109,'message' => '请先去完善商品信息！' ));
                    exit;
                }
                if ($r0[0]->active == '') {
                    echo json_encode(array('code' => 109,'message' => '请先去完善商品信息！' ));
                    exit;
                }
            }
        }else{
            echo json_encode(array('code' => 109,'message' => '商品ID错误！' ));
            exit;
        }
        return;
    }

    // 店铺日志
    public function mchLog($Log_content){
        $lktlog = new LaiKeLogUtils("app/mch.log");
        $lktlog->customerLog($Log_content);
        return;
    }

}
?>

