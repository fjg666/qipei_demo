<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/resultAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/lktpay/ttpay/TTUtils.php');
require_once(MO_LIB_DIR . '/lktpay/bdpay/BDUtils.php');
require_once(MO_LIB_DIR . '/alipay/AlipayTools.class.php');
require_once(MO_LIB_DIR . '/LKTConfigInfo.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');
require_once(MO_LIB_DIR . '/sendAction.class.php');

class loginAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $output = New Result;
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();
        return;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $output = New Result;
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();
        return;
    } 

    public function getRequestMethods(){
        return Request :: POST;
    }

    //短信发送
    public function send_sms(){
        //$db = DBAction::getInstance();
        $output = New Result;
        $redis  = new RedisClusters();
        $clapi  = new ChuanglanSmsApi();
        $request = $this->getContext()->getRequest();
        $mobile  = $request->getParameter('mobile');  //联系电话
        if(!isset($mobile)){
            $output->_jsonError('-1','参数为空！');
        }

        //生成随机数（4位数）
        $code = mt_rand(1000,9999);

        //设置您要发送的内容：其中“【】”中括号为运营商签名符号，多签名内容前置添加提交
        $result = $clapi->sendSMS($mobile,'【汽配无忧】您的验证码是：'.$code.'，请不要把验证码泄露给其他人。');

        $arr = json_decode($result,true);
        if($arr['code'] == 0){
            //将验证码存入redis
            $redis->connect();
            $redis->set($mobile,$code,60);
            $redis->close();

            $output->_jsonResult('发送成功！');
        }else{
            $output->_jsonError('-1',$arr['errorMsg']);
        }
    }

    //修理店（用户）注册
    public function user_register(){
        $db = DBAction::getInstance();
        $output = New Result;
        $redis  = new RedisClusters();
        $request = $this->getContext()->getRequest();

        $store_id   = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $user_name  = $request->getParameter('user_name'); //修理店名称
        $project    = $request->getParameter('project'); //主营项目
        $station_number = $request->getParameter('station_number'); //工位数量
        $region     = $request->getParameter('region');  //所属区域
        $address    = $request->getParameter('address'); //详细地址
        $name       = $request->getParameter('name');  //联系人
        $mobile     = $request->getParameter('mobile');  //联系电话
        $verify     = $request->getParameter('verify');  //验证码
        $password   = $request->getParameter('password');  //密码
        $confirm_password = $request->getParameter('confirm_password');  //确认密码

        //判断账号是否注册
        $checkZh = "select id from lkt_user where store_id = '$store_id' and zhanghao = '$mobile'";
        $r0 = $db->select($checkZh);
        if($r0){
            $output->_jsonError('-1','该账号已存在!');
        }

        //判断手机号是否注册
        $checkMobile = "select id from lkt_user where store_id = '$store_id' and mobile = '$mobile'";
        $r1 = $db->select($checkMobile);
        if($r1){
            $output->_jsonError('-1','该手机号码已注册,请登录!');
        }

        //判断验证码是否正确
        $redis->connect();
        $yzm = $redis->get($mobile);
        $redis->close();
        if($yzm != $verify){
            $output->_jsonError('-1','短信验证码错误！');
        }


        //判断密码是否一致
        if($password != $confirm_password){
            $output->_jsonError('-1','密码不一致！');
        }

        $sql = "insert into lkt_user(store_id,user_name,project,station_number,region,address,real_name,mobile,zhanghao,mima,source) values('$store_id','$user_name','$project','$station_number','$region','$address','$name','$mobile','$mobile','$password',2)";
        $uid = $db->insert($sql,'last_insert_id');

        if($uid > 0){
            //更新user_id.获取数据库最大一条id 然后加一，存入数据库
            $sql2 = "select max(id) as userid from lkt_user where 1=1";
            $r = $db->select($sql2);
            $rr = $r[0]->userid;
            $user_id = 'user'.($rr+1);//新注册的用户user_id

            $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$uid' and store_id = '$store_id'";
            $db->update($sql_1);

            $msg['uid'] = $uid;
            $output->_jsonResult('注册成功！',$msg);
        }else{
            $output->_jsonError('-1','注册失败！');
        }
    }

    //图片上传
    public function image_upload(){
        $db = DBAction::getInstance();
        $output = New Result;

        $request = $this->getContext()->getRequest();

        $store_id   = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $name  = $request->getParameter('name'); //图片对应名称
        $id    = $request->getParameter('id'); //id
        $type    = $request->getParameter('type'); //注册类型  1=修理店 2=汽配商

        // 查询配置表信息
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);

        $uploadImg_domain = $r[0]->uploadImg_domain;

        //
        if(!empty($_FILES[$name])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $image = ServerPath::file_upload2($_FILES[$name],$store_id,$uploadImg,$uploadImg_domain);

            if($image == false){
                $output->_jsonError('-1','请上传照片！');
            }else{
                $url = preg_replace('/.*\//', '', $image);
            }
        }else{
            $output->_jsonError('-1','请上传照片！');
        }

        if($type == 1){
            $sql = "update lkt_user set ".$name." = '$url' where user_id = '$id'";
        }elseif($type == 2){
            $sql = "update lkt_mch set ".$name." = '$url' where id = '$id'";
        }
        $check = $db->update($sql);

        if($check > 0){
            $output->_jsonResult('上传成功');
        }
    }


    //汽配商（商家）注册
    public function mch_register(){
        $db = DBAction::getInstance();
        $output = New Result;
        $redis  = new RedisClusters();
        $request = $this->getContext()->getRequest();

        $store_id   =  addslashes(trim($request->getParameter('store_id'))); // 商城id
        $store_name  = $request->getParameter('store_name'); //修理店名称
        $shop_information    = $request->getParameter('shop_information'); //主营业务
        $shop_range = $request->getParameter('shop_range'); //经营范围
        $brand_model     = json_decode($request->getParameter('brand_model'), true);  //品牌车型 json格式

        //循环判断用户选择的品牌车型
        $cid_str = '';
        foreach($brand_model as $key => $val){
            foreach($val as $k => $v){
                if($v == 'all'){
                    $id = $k;
                    $brandSql = "select cid from lkt_product_class where sid = ".$id;
                    $brand = $db->select($brandSql);

                    foreach($brand as $keys => $vals){
                        $cid_str .= $vals.",";
                    }
                }else{
                    $cid_str .= $v;
                }
            }
        }
        $cid_str = rtrim($cid_str, ',');

        $accessories_level     = $request->getParameter('accessories_level');  //配件等级
        $business_type     = $request->getParameter('business_type');  //业务类型
        $stock     = $request->getParameter('stock');  //库存规模
        $region     = $request->getParameter('region');  //所属区域
        $city     = $request->getParameter('city');  //汽配城
        $address    = $request->getParameter('address'); //详细地址
        $name       = $request->getParameter('realname');  //联系人姓名
        $mobile     = $request->getParameter('mobile');  //联系电话
        $verify     = $request->getParameter('verify');  //验证码
        $password   = $request->getParameter('password');  //密码
        $confirm_password = $request->getParameter('confirm_password');  //确认密码

        if(!isset($store_id) && !isset($store_name) && !isset($shop_information) && !isset($shop_range) && !isset($brand_model) && !isset($accessories_level) && !isset($business_type) && !isset($stock) && !isset($region) && !isset($city) && !isset($address) && !isset($realname) && !isset($mobile) && !isset($verify) && !isset($password) && !isset($confirm_password)){
            $output->_jsonError('-1','参数为空！');
        }

        //判断手机号是否注册
        $checkMobile = "select id from lkt_user where store_id = '$store_id' and mobile = '$mobile'";
        $r1 = $db->select($checkMobile);
        if($r1){
            $output->_jsonError('-1','该手机号码已注册,请登录!');
        }

        //判断验证码是否正确
        $redis->connect();
        $yzm = $redis->get($mobile);
        $redis->close();
        if($yzm != $verify){
            $output->_jsonError('-1','短信验证码错误！');
        }

        //判断密码是否一致
        if($password != $confirm_password){
            $output->_jsonError('-1','密码不一致！');
        }

        // 查询配置表信息
        /*$sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);

        $uploadImg_domain = $r[0]->uploadImg_domain;

        //营业执照照片
        if(!empty($_FILES['business_license'])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $business_license = ServerPath::file_upload2($_FILES['cashier_image'],$store_id,$uploadImg,$uploadImg_domain);

            if($business_license == false){
                $output->_jsonError('-1','请上传门店照片！');
            }else{
                $business_license = preg_replace('/.*\//', '', $business_license);
            }
        }else{
            $output->_jsonError('-1','请上传门店照片！');
        }

        //门店照片
        if(!empty($_FILES['store_image'])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $store_image = ServerPath::file_upload2($_FILES['station_image'],$store_id,$uploadImg,$uploadImg_domain);

            if($store_image == false){
                $output->_jsonError('-1','请上传工位照片！');
            }else{
                $store_image = preg_replace('/.*\//', '', $store_image);
            }
        }else{
            $output->_jsonError('-1','请上传工位照片！');
        }

        //收银台照片（前台）
        if(!empty($_FILES['cashier_image'])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $cashier_image = ServerPath::file_upload2($_FILES['storeroom_image'],$store_id,$uploadImg,$uploadImg_domain);

            if($cashier_image == false){
                $output->_jsonError('-1','请上传工位照片！');
            }else{
                $cashier_image = preg_replace('/.*\//', '', $cashier_image);
            }
        }else{
            $output->_jsonError('-1','请上传工位照片！');
        }

        //库房照片
        if(!empty($_FILES['storeroom_image'])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $storeroom_image = ServerPath::file_upload2($_FILES['work_image'],$store_id,$uploadImg,$uploadImg_domain);

            if($storeroom_image == false){
                $output->_jsonError('-1','请上传工作照片！');
            }else{
                $storeroom_image = preg_replace('/.*\//', '', $storeroom_image);
            }
        }else{
            $output->_jsonError('-1','请上传工作照片！');
        }*/
        $db->begin(); //开始事务

        //添加用户
        $sql = "insert into lkt_user(store_id,real_name,mobile,zhanghao,mima,source) values('$store_id','$name','$mobile','$mobile','$password',2)";
        $uid = $db->insert($sql,'last_insert_id');
        $db->commit(); //提交事务

        if($uid > 0){
            $add_time = date('Y-m-d H:i:s');
            //$sql = "insert into lkt_mch(store_id,user_id,name,shop_information,shop_range,realname,brand_model,tel,accessories_level,business_type,stock,region,address,city,business_license,store_image,cashier_image,storeroom_image,add_time) values($store_id,'$uid','$store_name','$shop_information','$shop_range','$name','$cid_str','$mobile','$accessories_level','$business_type','$stock','$region','$address','$city','$business_license','$store_image','$cashier_image','$storeroom_image','$add_time')";
            $sql = "insert into lkt_mch(store_id,user_id,name,shop_information,shop_range,realname,brand_model,tel,accessories_level,business_type,stock,region,address,city,add_time) values($store_id,'$uid','$store_name','$shop_information','$shop_range','$name','$cid_str','$mobile','$accessories_level','$business_type','$stock','$region','$address','$city','$add_time')";

            $sid = $db->insert($sql,'last_insert_id');
            if($sid){
                //更新user_id.获取数据库最大一条id.然后加一，存入数据库
                $sql2 = "select max(id) as userid from lkt_user where 1=1";
                $r = $db->select($sql2);
                $rr = $r[0]->userid;
                $user_id = 'user'.($rr+1);//新注册的用户user_id

                $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$uid' and store_id = '$store_id'";
                $db->update($sql_1);

                $msg['mch_id'] = $sid;
                $output->_jsonResult('注册成功！',$msg);
            }else{
                $db->rollback(); //如果添加失败，则回到到原来的数据
                $output->_jsonError('-1','注册失败！');
            }

        }else{
            $output->_jsonError('-1','注册失败！');
        }
    }

    //登录
    public function login(){
        $db = DBAction::getInstance();
        $output = New Result;
        $request = $this->getContext()->getRequest();

        $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $mobile   = $request->getParameter('mobile'); //账号
        $password = $request->getParameter('password'); //密码

        $sql = "select id,zhanghao from lkt_user where zhanghao = '$mobile'";
        $arr = $db->select($sql);
        if(!empty($arr)){
            $sql2 = "select * from lkt_user where id = ".$arr[0]->id." and mima = '$password'";
            $arr2 = $db->select($sql2);
            if(!empty($arr2)){
                //如果是商家登录 判断该商家是否审核通过
                if($arr2[0]->level == 2){
                    $sql3 = "select review_status from lkt_mch where review_status = 1";
                    $arr3 = $db->select($sql3);
                    if(empty($arr3)){
                        $output->_jsonError('-1','该商家正在审核！');
                    }
                }
                //生成token
                $Tools = new Tools($db, $store_id, 1);

                $token = $Tools->getToken();
                $data['user_id'] = $arr2[0]->user_id;
                $data['user_name'] = $arr2[0]->user_name;
                $data['headimgurl'] = $arr2[0]->headimgurl;
                $data['level'] = $arr2[0]->level; //用户等级

                //修改用户token
                $now_time = date('Y-m-d H:i:s');
                $sql1 = "update lkt_user set access_id = '$token',last_time = '$now_time' where store_id = '$store_id' and zhanghao = '$mobile'";
                $db->update($sql1);

                echo json_encode(array('code'=>200,'access_id'=>$token,'user_id'=>$arr2[0]->user_id,'user_name'=>$arr2[0]->user_name,'headimgurl'=>$arr2[0]->headimgurl,'level'=>$arr2[0]->level,'y_password'=>1,'wx_status'=>0,'message'=>'成功!'));
                exit;
            }else{
                /*$output->_jsonError('-1','密码错误！');*/
                echo json_encode(array('code'=>114,'message'=>'密码错误!'));
                exit;
            }
        }else{
            //$output->_jsonError('-1','该账号不存在！');
            echo json_encode(array('code'=>113,'message'=>'该号码未注册,请注册!'));
            exit;
        }
    }



    //忘记密码
    public function forgetPwd(){
        $db = DBAction::getInstance();
        $output = New Result;
        $request = $this->getContext()->getRequest();

        $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $mobile   = $request->getParameter('mobile'); //手机号
        $verify     = $request->getParameter('verify');  //验证码
        $password   = $request->getParameter('password');  //密码
        $confirm_password = $request->getParameter('confirm_password');  //确认密码

        //查询手机号是否注册
        $sql1 = "select zhanghao from lkt_user where zhanghao = '$mobile'";
        $check = $db->select($sql1);
        if(emtpy($check)){
            $output->_jsonError('-1','该手机号未注册！');
        }

        //判断验证码是否正确
        $arr = array($mobile,array('code'=>$verify));
        $Tools = new Tools($db, $store_id, 2);
        $rew = $Tools->verification_code($db,$arr);
        if($rew){
            $deleCode = "delete from lkt_session_id where id = '$rew' ";
            $db->delete($deleCode);
        }

        //判断密码是否一致
        if($password != $confirm_password){
            $output->_jsonError('-1','密码不一致！');
        }

        //修改密码
        $sql = "update lkt_user set mima = '$confirm_password' where zhanghao = '$mobile'";
        $checkUpdate = $db->update($sql);
        if($checkUpdate < 0){
            $output->_jsonError('-1','修改失败！');
        }else{
            $output->_jsonResult('修改成功！');
        }
    }

    //查询商户资料
    public function user_info(){
        $db = DBAction::getInstance();
        $output = New Result;

        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id')); // 商城ID
        $mch_id = $request->getParameter('mch_id');

        $sql = "select * from lkt_mch where id = ".$mch_id." and store_id = ".$store_id;
        $arr = $db->select($sql);
        if($arr){
            $output->_jsonResult('',$arr);
        }
    }


    //修改商家资料
    public function update_info(){
        $db = DBAction::getInstance();
        $output = New Result;
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id')); // 商城ID

        $mch_id     = $request->getParameter('mch_id'); //商家ID
        $realname   = $request->getParameter('realname'); //姓名
        $phone      = $request->getParameter('phone'); //联系方式
        $region     = $request->getParameter('region'); //地区

        // 查询配置表信息
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);

        $uploadImg_domain = $r[0]->uploadImg_domain;

        //营业执照照片
        if(!empty($_FILES['business_license'])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $business_license = ServerPath::file_upload2($_FILES['cashier_image'],$store_id,$uploadImg,$uploadImg_domain);

            if($business_license == false){
                $output->_jsonError('-1','请上传门店照片！');
            }else{
                $business_license = preg_replace('/.*\//', '', $business_license);
            }
        }else{
            $output->_jsonError('-1','请上传门店照片！');
        }

        //门店照片
        if(!empty($_FILES['store_image'])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $store_image = ServerPath::file_upload2($_FILES['station_image'],$store_id,$uploadImg,$uploadImg_domain);

            if($store_image == false){
                $output->_jsonError('-1','请上传工位照片！');
            }else{
                $store_image = preg_replace('/.*\//', '', $store_image);
            }
        }else{
            $output->_jsonError('-1','请上传工位照片！');
        }

        //收银台照片（前台）
        if(!empty($_FILES['cashier_image'])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $cashier_image = ServerPath::file_upload2($_FILES['storeroom_image'],$store_id,$uploadImg,$uploadImg_domain);

            if($cashier_image == false){
                $output->_jsonError('-1','请上传工位照片！');
            }else{
                $cashier_image = preg_replace('/.*\//', '', $cashier_image);
            }
        }else{
            $output->_jsonError('-1','请上传工位照片！');
        }

        //库房照片
        if(!empty($_FILES['storeroom_image'])){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";
            $storeroom_image = ServerPath::file_upload2($_FILES['work_image'],$store_id,$uploadImg,$uploadImg_domain);

            if($storeroom_image == false){
                $output->_jsonError('-1','请上传工作照片！');
            }else{
                $storeroom_image = preg_replace('/.*\//', '', $storeroom_image);
            }
        }else{
            $output->_jsonError('-1','请上传工作照片！');
        }

        $sql = "insert into lkt_review(mch_id, realname, phone, region, business_license, store_image, cashier_image, storeroom_image) values($mch_id, $realname, $phone, $region, $business_license, $store_image, $cashier_image, $storeroom_image)";
        $add = $db->insert($sql);
        if($add){
            $output->_jsonResult('','修改成功，请等待审核！');
        }else{
            $output->_jsonError('-1','修改失败！');
        }
    }


    // 判断是否要注册
    public function is_register(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id')); // 商城ID
        $store_type = trim($request->getParameter('store_type')); // 来源
        // 根据商城id，查询配置表
        $sql0 = "select is_register from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $is_register = $r0[0]->is_register;
            if($is_register == 2 && $store_type == 1){ // 当注册为免注册，并且来源为小程序
                $is_register = 2; // 免注册
            }else{
                $is_register = 1; // 注册
            }
            echo json_encode(array('code'=>200,'is_register'=>$is_register,'message'=>'成功!'));
            exit;
        }else{
            echo json_encode(array('code'=>228,'message'=>'请商城管理员填写基础配置!'));
            exit;
        }
    }
    // 授权未过期
    public function login_access(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $store_type = trim($request->getParameter('store_type')); // 来源

        $openid = trim($request->getParameter('openid'));//用户openid

        if(!$openid ||empty($openid)){
            LaiKeLogUtils::lktLog("wxid异常:".$openid);
            echo json_encode(array('code'=>201,'微信id异常!'));
            exit;
        }

        // 根据商城id，openid,查询用户信息
        $sql = "select id,user_name,headimgurl,access_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r = $db->select($sql);
        if($r){
            // 存在
            $access_id = $r[0]->access_id;
            if(!$access_id||!Tools::verifyToken($db,$store_id,$store_type,$access_id)){
                $access_id = Tools::getToken();
                $sql = "update  lkt_user set access_id = '$access_id' where store_id = '$store_id' and wx_id = '$openid'";
                LaiKeLogUtils::lktLog("授权用户未过期更新日志:".$sql);
                $db->update($sql);
            }
            $user_status = 1; // 老用户
            $user = array();
            $user['user_name'] = $r[0]->user_name;
            $user['headimgurl'] = $r[0]->headimgurl;
            echo json_encode(array('code'=>200,'openid'=>$openid,'user_status'=>$user_status,'user'=>$user,'access_id'=>$access_id,'message'=>'成功!'));
            exit;
        }else{
            LaiKeLogUtils::lktLog("免注册登录流程,不存在此用户:".$openid);
            echo json_encode(array('code'=>228,'message'=>'免注册登录流程,不存在此用户'));
            exit;
        }
    }
    // 用户授权时，存储用户信息
    public function user(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $store_type = trim($request->getParameter('store_type')); // 来源
        $code = addslashes(trim($request->getParameter('code'))); // code
        $user_name = addslashes(trim($request->getParameter('nickName'))); // 用户昵称
        $headimgurl = trim($request->getParameter('headimgurl')); // 用户头像
        $sex = trim($request->getParameter('sex')); // 用户性别

        $pid = trim($request->getParameter('pid')); // 推荐人id
        $access_id = trim($request->getParameter('access_id')); // 推荐人id

        //获取用户openid

        // 查询小程序配置
        $sql0 = "select appid,appsecret from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if ($r0) {
            $appid = $r0[0]->appid; // 小程序唯一标识
            $appsecret = $r0[0]->appsecret; // 小程序的 app secret
        } else {
            echo json_encode(array('code'=>228,'message'=>'请商城管理员填写基础配置!'));
            exit;
        }
        if (!$code) {
            echo json_encode(array('code' => 115, 'message' => '非法操作！'));
            exit();
        }
        if($store_type == 1){ // 来源为小程序
            if (!$appid || !$appsecret) {
                echo json_encode(array('code' => 115, 'message' => '非法操作！'));
                exit();
            }
            $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $appsecret . '&js_code=' . $code . '&grant_type=authorization_code';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            // 保证返回成功的结果是服务器的结果
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch,   CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            $res = curl_exec($ch);
            curl_close($ch);
            $user = (array)json_decode($res);
            LaiKeLogUtils::lktLog("授权错误信息:".json_encode($user));
            if (isset($user['errcode'])||!isset($user['openid'])){
                LaiKeLogUtils::lktLog("授权错误信息:");
                LaiKeLogUtils::lktLog("appid:".$appid."->appsecret:".$appsecret);
                LaiKeLogUtils::lktLog("授权url:".$url);
                LaiKeLogUtils::lktLog(json_encode($user));
                return;
            }else if(isset($user['openid'])){
                $openid = $user['openid'];
                $session_key = $user['session_key'];
            }
        }



        $sql0 = "select * from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $db->begin();
            $is_register = $r0[0]->is_register;
            $user_id1 = $r0[0]->user_id; //默认用户名ID前缀
            if($is_register == 2 && $store_type == 1){ // 当注册为免注册，并且来源为小程序

                if(empty($access_id)){ // 授权ID为空,代表没有进入商品详情
                    // 生成密钥
                    $token = Tools::getToken();
                }else{ // 授权ID存在,代表有进入商品详情
                    $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                    if($getPayload_test == false){ // 过期
                        // 生成密钥
                        $token = Tools::getToken();
                    }else{
                        $token = $access_id;
                    }
                }

                //判断是否有该用户信息
                $sql_1 = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
                $res_1 =$db->select($sql_1);
                $user_id = -1;
                if($res_1){//存在则更新
                    $user_id = $res_1[0]->user_id;
					$setStr = "";

                    if(!empty($user_name)){
                        $setStr .= ",user_name = '$user_name'";
                    }

                    if(!empty($headimgurl)){
                        $setStr .= ",headimgurl = '$headimgurl'";
                    }

                    if(!empty($sex)){
                        $setStr .= ",sex = '$sex'";
                    }

                    $sql_2 = "update lkt_user set access_id = '$token' ".$setStr." where store_id = '$store_id' and wx_id = '$openid'";

					$res_2 = $db->update($sql_2);
                    if($res_2 < 0){
                        $db->rollback();
                        echo json_encode(array('code'=>228,'message'=>'更新用户信息失败'));
                        exit;
                    }
                }else{//不存在，则添加

                    $ppid = '';
                    if (!empty($pid)) {
                        $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
                        $r_0 = $db->select($sql_0);
                        if ($r_0) {
                            $ppid = $pid;
                        }
                    }

                    if($ppid){
                         $sql = "insert into lkt_user(store_id,access_id,user_name,wx_id,headimgurl,sex,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$user_name','$openid','$headimgurl','$sex','','$user_id','','$store_type','$ppid')";
                         $r = $db->insert($sql);
                    }else{
                         $sql = "insert into lkt_user(store_id,access_id,user_name,wx_id,headimgurl,sex,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$user_name','$openid','$headimgurl','$sex','','$user_id','','$store_type','')";
                         $r = $db->insert($sql);
                    }

                     //更新user_id
                    $sql = "select max(id) as userid from lkt_user where 1=1";
                    $r = $db->select($sql);
                    $rr = $r[0]->userid;
                    $user_id = $user_id1.($rr+1);//新注册的用户user_id

                    $sql_0 = "select id from  lkt_user where store_id = '$store_id' and wx_id = '$openid'";
                    $res_0 = $db->select($sql_0);
                    $new_id = $res_0[0]->id;//要修改的用户id

                    $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$new_id' and store_id = '$store_id'";
                    $res_1 = $db->update($sql_1);

                    $event = '会员' . $user_id . '授权注册成功';
                    // 在操作列表里添加一条会员登录信息
                    $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
                    $r01 = $db->insert($sql);

                    if($r <= 0 || $r01 <= 0 || $res_1 <= 0){
                         $db->rollback();
                         echo json_encode(array('code'=>109,'message'=>'授权失败!',"line"=>__LINE__));
                         exit;
                    }

                }

                $this->updateCartInfo($token, $db, $user_id);
            }else{
                echo json_encode(array('code'=>228,'message'=>'请先开通免注册功能'));
                exit;
            }

            $user = array();
            $user['user_name'] = $user_name;
            $user['headimgurl'] = $headimgurl;
            echo json_encode(array('code'=>200,'access_id'=>$token,'message'=>'成功!','user'=>$user,'openid'=>$openid,'session_key'=>$session_key));
            exit;
        }else{
            echo json_encode(array('code'=>228,'message'=>'请商城管理员填写基础配置!'));
            exit;
        }
    }

    /**
     * 阿里用户登陆
     */
    public function mpaliUserLogin(){
        try {
            $db = DBAction::getInstance();
            $request = $this->getContext()->getRequest();
            $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
            $alimp_auth_code = addslashes(trim($request->getParameter('alimp_auth_code'))); // 授权ID
            $access_id = trim($request->getParameter('access_id')); // 来客电商访问token
            if (empty($alimp_auth_code)) {
                throw new Exception('缺少参数', 201);
            }
            $userid = AlipayTools::getAliUserId($store_id,$alimp_auth_code);
            $data = array();
            if( $userid ) {
                $db->begin();
                //直接查询数据库用户表
                $sql = " select * from lkt_user where zfb_id = '".$userid."'";
                $userRs = $db->select($sql);
                //存在用户
                if($userRs){
                    //查询到用户则直接返回给用户
                    if(empty($access_id) || "undefined" == $access_id){ // 授权ID为空,代表没有进入商品详情
                        // 生成密钥
                        $token = Tools::getToken();
                    } else {
                        // 授权ID存在,代表有进入商品详情
                        $getPayload_test = Tools::verifyToken($db,$store_id,1,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                        if($getPayload_test == false){ // 过期
                            // 生成密钥
                            $token = Tools::getToken();
                        } else {
                            $token = $access_id;
                        }
                    }
                    $lkt_user_id = $userRs[0]->user_id;
                    $sql = "update lkt_user set access_id = '$token' ,login_num=login_num+1, last_time = now() where user_id = '$lkt_user_id'";
                    $userRs[0]->access_id = $token;
                    $data["code"] = 200;
                    $data["msg"] = '已授权';
                    $data["userInfo"] = $userRs[0];
                    $updateRowNum = $db->update($sql);
                    if($updateRowNum < 0){
                        $db->rollback();
                        $data["code"] = 201;
                        $data["msg"] = '更新用户信息失败';
                    }else{
                        //更新购物车里面的商品用户ID
                        $this->updateCartInfo($token, $db, $lkt_user_id);
                    }
                }else{
                    //没有查询到用户则前端授权
                    $data["code"] = 203;
                    $data["zfb_id"] = $userid;
                    $data["msg"] = '未授权';
                }
            } else {
                //没有取到阿里的用户ID
                $data["code"] = 202;
                $data["msg"] = '获取用户信息失败';
            }
            echo json_encode($data);
            exit;
        } catch (Exception $exception) {
            echo json_encode(array('code' => $exception->getCode(), 'msg' => $exception->getMessage()));
            exit;
        }
    }

    /**
     * 新增、修改阿里用户
     */
    public function updateAliUser(){
        try{
            $db = DBAction::getInstance();
            $request = $this->getContext()->getRequest();
            $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
            $store_type = trim($request->getParameter('store_type')); // 来源
            $user_name = trim($request->getParameter('nickName')); // 用户昵称
            $headimgurl = trim($request->getParameter('headimgurl')); // 用户头像
            $sex = trim($request->getParameter('sex')); // 用户性别
            $pid = trim($request->getParameter('pid')); // 推荐人id

            //支付宝ID
            $zfb_id = trim($request->getParameter('zfb_id')); // 支付宝ID

            $access_id = trim($request->getParameter('access_id')); // 推荐人id
            $token = $access_id;

            //返回前端的数组
            $data = array();

            $token = $this->getToken($access_id, $db, $store_id, $store_type);

            $user_id = $this->getPreUserId($store_id, $db);

            $sql_1 = "select user_id from lkt_user where store_id = '$store_id' and zfb_id = '$zfb_id'";
            $res_1 =$db->select($sql_1);
            $db->begin();
            if($res_1){//存在则更新
                $user_id = $res_1[0]->user_id;
                $sql_2 = "update lkt_user set access_id = '$token',user_name = '$user_name',headimgurl = '$headimgurl',sex = '$sex' where store_id = '$store_id' and zfb_id = '$zfb_id'";
                $res_2 = $db->update($sql_2);
                if($res_2 < 0){
                    $db->rollback();
                    echo json_encode(array('code'=>228,'message'=>'更新用户信息失败'));
                    exit;
                }
            }else{//不存在，则添加
                $ppid = '';
                if (!empty($pid)) {
                    $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
                    $r_0 = $db->select($sql_0);
                    if ($r_0) {
                        $ppid = $pid;
                    }
                }
                if($ppid){
                    $sql = "insert into lkt_user(store_id,access_id,user_name,zfb_id,headimgurl,sex,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$user_name','$zfb_id','$headimgurl','$sex','','$user_id','','$store_type','$ppid')";
                    $r = $db->insert($sql);
                }else{
                    $sql = "insert into lkt_user(store_id,access_id,user_name,zfb_id,headimgurl,sex,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$user_name','$zfb_id','$headimgurl','$sex','','$user_id','','$store_type','')";
                    $r = $db->insert($sql);
                }

                //更新user_id
                $sql = "select max(id) as userid from lkt_user where 1=1";
                $r = $db->select($sql);
                $rr = $r[0]->userid;
                $user_id = $user_id.($rr+1);//新注册的用户user_id

                $sql_0 = "select id from  lkt_user where store_id = '$store_id' and zfb_id = '$zfb_id'";
                $res_0 = $db->select($sql_0);
                $new_id = $res_0[0]->id;//要修改的用户id

                $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$new_id' and store_id = '$store_id'";
                $res_1 = $db->update($sql_1);

                $event = '会员' . $user_id . '授权注册成功';
                // 在操作列表里添加一条会员登录信息
                $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
                $r01 = $db->insert($sql);

                if($r <= 0 || $r01 <= 0 || $res_1 <= 0){
                    $db->rollback();
                    echo json_encode(array('code'=>109,'message'=>'授权失败!',"line"=>__LINE__));
                    exit;
                }
            }
            $this->updateCartInfo($token, $db, $user_id);

            $sql = " select * from lkt_user where zfb_id = '".$zfb_id."'";
            $userRs = $db->select($sql);
            //存在用户
            if($userRs) {
                echo json_encode(array('code'=>200,'message'=>"成功","userInfo"=>$userRs[0]));
                exit;
            } else {
                throw  new Exception("未查获取到用户信息",109);
            }
        } catch (Exception $exception) {
            echo json_encode(array('code'=>$exception->getCode(),'message'=>$exception->getMessage()));
            exit;
        }
    }

    /**
     * 新增或修改头条用户
     */
    public function updateTTUser(){
        try{
            $db = DBAction::getInstance();
            $request = $this->getContext()->getRequest();
            $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
            $store_type = trim($request->getParameter('store_type')); // 来源
            $user_name = trim($request->getParameter('nickName')); // 用户昵称
            $headimgurl = trim($request->getParameter('headimgurl')); // 用户头像
            $sex = trim($request->getParameter('sex')); // 用户性别
            $pid = trim($request->getParameter('pid')); // 推荐人id

            //头条ID
            $tt_id = trim($request->getParameter('tt_id')); // 头条ID
            $access_id = trim($request->getParameter('access_id')); //
            $token = $access_id;
            //返回前端的数组
            $data = array();
            $token = $this->getToken($access_id, $db, $store_id, $store_type);

            //前缀
            $user_id = $this->getPreUserId($store_id, $db);

            $sql_1 = "select user_id from lkt_user where store_id = '$store_id' and zfb_id = '$tt_id'";
            $res_1 =$db->select($sql_1);
            $db->begin();
            if($res_1){//存在则更新
                $user_id = $res_1[0]->user_id;
                $sql_2 = "update lkt_user set access_id = '$token',user_name = '$user_name',headimgurl = '$headimgurl',sex = '$sex' where store_id = '$store_id' and tt_id = '$tt_id'";
                $res_2 = $db->update($sql_2);
                if($res_2 < 0){
                    $db->rollback();
                    echo json_encode(array('code'=>228,'message'=>'更新用户信息失败'));
                    exit;
                }
            }else{//不存在，则添加
                $ppid = '';
                if (!empty($pid)) {
                    $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
                    $r_0 = $db->select($sql_0);
                    if ($r_0) {
                        $ppid = $pid;
                    }
                }
                if($ppid){
                    $sql = "insert into lkt_user(store_id,access_id,user_name,tt_id,headimgurl,sex,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$user_name','$tt_id','$headimgurl','$sex','','$user_id','','$store_type','$ppid')";
                    $r = $db->insert($sql);
                }else{
                    $sql = "insert into lkt_user(store_id,access_id,user_name,tt_id,headimgurl,sex,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$user_name','$tt_id','$headimgurl','$sex','','$user_id','','$store_type','')";
                    $r = $db->insert($sql);
                }



                //更新user_id
                $sql = "select max(id) as userid from lkt_user where 1=1";
                $r = $db->select($sql);
                $rr = $r[0]->userid;
                $user_id = $user_id.($rr+1);//新注册的用户user_id

                $sql_0 = "select id from  lkt_user where store_id = '$store_id' and tt_id = '$tt_id'";
                $res_0 = $db->select($sql_0);
                $new_id = $res_0[0]->id;//要修改的用户id

                $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$new_id' and store_id = '$store_id'";
                $res_1 = $db->update($sql_1);

                $event = '会员' . $user_id . '授权注册成功';
                // 在操作列表里添加一条会员登录信息
                $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
                $r01 = $db->insert($sql);

                if($r < 0 || $r01 < 0 || $res_1 < 0){
                    $db->rollback();
                    echo json_encode(array('code'=>109,'message'=>'授权失败!',"line"=>__LINE__));
                    exit;
                }
            }
            $this->updateCartInfo($token, $db, $user_id);
            $sql = " select * from lkt_user where tt_id = '".$tt_id."'";
            $userRs = $db->select($sql);
            //存在用户
            if($userRs) {
                echo json_encode(array('code'=>200,'message'=>"成功","userInfo"=>$userRs[0]));
                exit;
            } else {
                throw  new Exception("未查获取到用户信息",109);
            }
        } catch (Exception $exception) {
            echo json_encode(array('code'=>$exception->getCode(),'message'=>$exception->getMessage()));
            exit;
        }
    }

    /**
     * 头条用户登陆
     */
    function ttUserLogin(){
        try {
            $db = DBAction::getInstance();
            $request = $this->getContext()->getRequest();
            $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
            $tt_auth_code = addslashes(trim($request->getParameter('tt_auth_code'))); // 授权ID
            $access_id = trim($request->getParameter('access_id')); // 来客电商访问token
            if (empty($tt_auth_code)) {
                throw new Exception('缺少参数', 201);
            }
            $config = LKTConfigInfo::getPayConfig($store_id,"tt_alipay");
            if(empty($config)){
                echo json_encode(array("code"=>"201","msg"=>"未配置头条相关信息"));
                exit;
            }
            $ttAppid = $config['ttAppid'];
            $ttAppSecret = $config['ttAppSecret'];
            LaiKeLogUtils::lktLog(__METHOD__ . '->' . __LINE__ . json_encode($config));
            $userid = TTUtils::getTTOpenId($ttAppid,$ttAppSecret,$tt_auth_code);
            LaiKeLogUtils::lktLog(__METHOD__ . '->' . __LINE__ . "=".$userid);
            $data = array();
            if( $userid ) {
                $db->begin();
                //直接查询数据库用户表
                $sql = " select * from lkt_user where tt_id = '".$userid."'";
                $userRs = $db->select($sql);
                //存在用户
                if($userRs){
                    //查询到用户则直接返回给用户
                    if(empty($access_id)|| "undefined" == $access_id){ // 授权ID为空,代表没有进入商品详情
                        // 生成密钥
                        $token = Tools::getToken();
                    } else {
                        // 授权ID存在,代表有进入商品详情
                        $getPayload_test = Tools::verifyToken($db,$store_id,1,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                        if($getPayload_test == false){ // 过期
                            // 生成密钥
                            $token = Tools::getToken();
                        }else{
                            $token = $access_id;
                        }
                    }
                    $lkt_user_id = $userRs[0]->user_id;
                    $sql = "update lkt_user set access_id = '$token' ,login_num=login_num+1, last_time = now() where user_id = '$lkt_user_id'";
                    $userRs[0]->access_id = $token;
                    $data["code"] = 200;
                    $data["msg"] = '已授权';
                    $data["userInfo"] = $userRs[0];
                    $updateRowNum = $db->update($sql);
                    if($updateRowNum < 0){
                        $db->rollback();
                        $data["code"] = 201;
                        $data["msg"] = '更新用户信息失败';
                    }else{
                        //更新购物车里面的商品用户ID
                        $this->updateCartInfo($token, $db, $lkt_user_id);
                    }
                }else{
                    //没有查询到用户则前端授权
                    $data["code"] = 203;
                    $data["tt_id"] = $userid;
                    $data["msg"] = '未授权';
                }
            } else {
                //没有取到阿里的用户ID
                $data["code"] = 202;
                $data["msg"] = '获取用户信息失败';
            }
            echo json_encode($data);
            exit;
        } catch (Exception $exception) {
            echo json_encode(array('code' => $exception->getCode(), 'msg' => $exception->getMessage()));
            exit;
        }
    }

    /**
     * 百度用户登录
     */
    function bdUserLogin(){
        try {
            $db = DBAction::getInstance();
            $request = $this->getContext()->getRequest();
            $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
            $bd_auth_code = addslashes(trim($request->getParameter('bd_auth_code'))); // 授权ID
            $access_id = trim($request->getParameter('access_id')); // 来客电商访问token
            if (empty($bd_auth_code)) {
                throw new Exception('缺少参数', 201);
            }

           $bdconfig = LKTConfigInfo::getPayConfig($store_id,"baidu_pay");

           if(empty($bdconfig)){
               echo json_encode(array("code"=>"201","msg"=>"未配置百度相关信息"));
               exit;
           }

            // $config = array(
            //     "client_id"=> "umxLDGg2WFLNoHwkktNOv1O22bn3qFAN", //
            //     "sk"=> "rgj32AITnKE3cldfaL5520IVYvadWtCY" //
            // );

            $ttAppid = $bdconfig['bdmpappid'];
            $ttAppSecret = $bdconfig['bdmpappsk'];

            LaiKeLogUtils::lktLog(__METHOD__ . '->' . __LINE__ . json_encode($bdconfig));
            $userid = BDUtils::getBDOpenId($ttAppid,$ttAppSecret,$bd_auth_code);
            LaiKeLogUtils::lktLog(__METHOD__ . '->' . __LINE__ . "=".$userid);
            $data = array();
            if( $userid ) {
                $db->begin();
                //直接查询数据库用户表
                $sql = " select * from lkt_user where bd_id = '".$userid."'";
                $userRs = $db->select($sql);
                //存在用户
                if($userRs){
                    //查询到用户则直接返回给用户
                    if(empty($access_id) || 'undefined' == $access_id){ // 授权ID为空,代表没有进入商品详情
                        // 生成密钥
                        $token = Tools::getToken();
                    } else {
                        // 授权ID存在,代表有进入商品详情
                        $getPayload_test = Tools::verifyToken($db,$store_id,1,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                        if($getPayload_test == false){ // 过期
                            // 生成密钥
                            $token = Tools::getToken();
                        }else{
                            $token = $access_id;
                        }
                    }
                    $lkt_user_id = $userRs[0]->user_id;
                    $sql = "update lkt_user set access_id = '$token' ,login_num=login_num+1, last_time = now() where user_id = '$lkt_user_id'";
                    $userRs[0]->access_id = $token;
                    $data["code"] = 200;
                    $data["msg"] = '已授权';
                    $data["userInfo"] = $userRs[0];
                    $updateRowNum = $db->update($sql);
                    if($updateRowNum < 0){
                        $db->rollback();
                        $data["code"] = 201;
                        $data["msg"] = '更新用户信息失败';
                    }else{
                        //更新购物车里面的商品用户ID
                        $this->updateCartInfo($token, $db, $lkt_user_id);
                    }
                }else{
                    //没有查询到用户则前端授权
                    $data["code"] = 203;
                    $data["bd_id"] = $userid;
                    $data["msg"] = '未授权';
                }
            } else {
                //没有取到阿里的用户ID
                $data["code"] = 202;
                $data["msg"] = '获取用户信息失败';
            }
            echo json_encode($data);
            exit;
        } catch (Exception $exception) {
            echo json_encode(array('code' => $exception->getCode(), 'msg' => $exception->getMessage()));
            exit;
        }
    }

    /**
     * 新增或修改百度用户
     */
    public function updateBDUser(){
        try{
            $db = DBAction::getInstance();
            $request = $this->getContext()->getRequest();
            $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
            $store_type = trim($request->getParameter('store_type')); // 来源
            $user_name = trim($request->getParameter('nickName')); // 用户昵称
            $headimgurl = trim($request->getParameter('headimgurl')); // 用户头像
            $sex = trim($request->getParameter('sex')); // 用户性别
            $pid = trim($request->getParameter('pid')); // 推荐人id

            //百度openID
            $bd_id = trim($request->getParameter('bd_id')); // 百度openID
            $access_id = trim($request->getParameter('access_id')); //
            $token = $access_id;
            //返回前端的数组
            $data = array();

            // 获取 token
            $token = $this->getToken($access_id, $db, $store_id, $store_type);

            //前缀
            $user_id = $this->getPreUserId($store_id, $db);

            $sql_1 = "select user_id from lkt_user where store_id = '$store_id' and bd_id = '$bd_id'";
            $res_1 =$db->select($sql_1);

            $db->begin();
            if($res_1){//存在则更新
                $user_id = $res_1[0]->user_id;
                $sql_2 = "update lkt_user set access_id = '$token',user_name = '$user_name',headimgurl = '$headimgurl',sex = '$sex' where store_id = '$store_id' and bd_id = '$bd_id'";
                $res_2 = $db->update($sql_2);
                if($res_2 < 0){
                    $db->rollback();
                    echo json_encode(array('code'=>228,'message'=>'更新用户信息失败'));
                    exit;
                }
            }else{//不存在，则添加
                $ppid = '';
                if (!empty($pid)) {
                    $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
                    $r_0 = $db->select($sql_0);
                    if ($r_0) {
                        $ppid = $pid;
                    }
                }
                if($ppid){
                    $sql = "insert into lkt_user(store_id,access_id,user_name,bd_id,headimgurl,sex,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$user_name','$bd_id','$headimgurl','$sex','','$user_id','','$store_type','$ppid')";
                    $r = $db->insert($sql);
                }else{
                    $sql = "insert into lkt_user(store_id,access_id,user_name,bd_id,headimgurl,sex,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$user_name','$bd_id','$headimgurl','$sex','','$user_id','','$store_type','')";
                    $r = $db->insert($sql);
                }



                //更新user_id
                $sql = "select max(id) as userid from lkt_user where 1=1";
                $r = $db->select($sql);
                $rr = $r[0]->userid;
                $user_id = $user_id.($rr+1);//新注册的用户user_id

                $sql_0 = "select id from  lkt_user where store_id = '$store_id' and bd_id = '$bd_id'";
                $res_0 = $db->select($sql_0);
                $new_id = $res_0[0]->id;//要修改的用户id

                $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$new_id' and store_id = '$store_id'";
                $res_1 = $db->update($sql_1);

                $event = '会员' . $user_id . '授权注册成功';
                // 在操作列表里添加一条会员登录信息
                $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
                $r01 = $db->insert($sql);

                if($r < 0 || $r01 < 0 || $res_1 < 0){
                    $db->rollback();
                    echo json_encode(array('code'=>109,'message'=>'授权失败!',"line"=>__LINE__));
                    exit;
                }
            }
            $this->updateCartInfo($token, $db, $user_id);
            $sql = " select * from lkt_user where bd_id = '".$bd_id."'";
            $userRs = $db->select($sql);
            //存在用户
            if($userRs) {
                echo json_encode(array('code'=>200,'message'=>"成功","userInfo"=>$userRs[0]));
                exit;
            } else {
                throw  new Exception("未查获取到用户信息",109);
            }
        } catch (Exception $exception) {
            echo json_encode(array('code'=>$exception->getCode(),'message'=>$exception->getMessage()));
            exit;
        }
    }

    // 进入登录页面
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql0 = "select logo,company from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $logo = ServerPath::getimgpath($r0[0]->logo);
            $company = $r0[0]->company;
        }else{
            $logo = '../../static/img/landing_logo@2x.png';
            $company = '来客电商';
        }
        
        //查询协议名称
        $sql = "select name from lkt_agreement where store_id = $store_id and type = 0 limit  1";
        $res = $db->select($sql);
        $Agreement = $res ? $res[0]->name : '注册协议';

        echo json_encode(array('code'=>200,'logo'=>$logo,'company'=>$company,'Agreement'=>$Agreement,'message'=>'成功!'));
        exit;
    }
    // 注册
    /*public function user_register(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id')); // 授权ID
        $clientid = trim($request->getParameter('clientid')); // 推送客户id

        $zhanghao =  addslashes(trim($request->getParameter('userId'))); // 账号
        $tel = $request->getParameter('phone'); // 手机号码
        $password = $db->lock_url($request->getParameter('password'));//密码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码
        $store_type = trim($request->getParameter('store_type')); // 来源

        $pid = trim($request->getParameter('pid')); // 推荐人id

        if($zhanghao == ''){
            echo json_encode(array('code'=>203,'message'=>'账号不能为空!'));
            exit;
        }else{
            $sql0 = "select id from lkt_user where store_id = '$store_id' and zhanghao = '$zhanghao'";
            $r0 = $db->select($sql0);
            if($r0){
                echo json_encode(array('code'=>203,'message'=>'该账号已存在!'));
                exit;
            }
            $sql1 = "select id from lkt_user where store_id = '$store_id' and mobile = '$tel'";
            $r1 = $db->select($sql1);
            if($r1){
                echo json_encode(array('code'=>203,'message'=>'该手机号码已注册,请登录!!'));
                exit;
            }
        }
        $arr = array($tel,array('code'=>$keyCode));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);

        $sql0 = "select * from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $wx_headimgurl = $r0[0]->wx_headimgurl;//默认微信用户头像
            $headimgurl = ServerPath::getimgpath($wx_headimgurl);//默认微信用户头像
            $wx_name = $r0[0]->wx_name;  //默认微信用户名
            $user_id1 = $r0[0]->user_id; //默认用户名ID前缀
        }

        $ppid = '';
        if (!empty($pid)) {
            $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
            $r_0 = $db->select($sql_0);
            if ($r_0) {
                $ppid = $pid;
            }
        }

        if(empty($access_id)){ // 授权ID为空,代表没有进入商品详情
            // 生成密钥
            $token = Tools::getToken();
        }else{ // 授权ID存在,代表有进入商品详情
            $token = $access_id;
        }
      
        $db->begin();
        if(!empty($clientid)){
            if(empty($ppid)){
                $sql = "insert into lkt_user(store_id,access_id,user_name,headimgurl,mobile,zhanghao,mima,source,clientid) values('$store_id','$token','$wx_name','$headimgurl','$tel','$zhanghao','$password','$store_type','$clientid')";
            }else{
                $sql = "insert into lkt_user(store_id,access_id,user_name,headimgurl,mobile,zhanghao,mima,source,Referee,clientid) values('$store_id','$token','$wx_name','$headimgurl','$tel','$zhanghao','$password','$store_type','$ppid','$clientid')";
            }
        }else{
            if(empty($ppid)){
                $sql = "insert into lkt_user(store_id,access_id,user_name,headimgurl,mobile,zhanghao,mima,source) values('$store_id','$token','$wx_name','$headimgurl','$tel','$zhanghao','$password','$store_type')";
            }else{
                $sql = "insert into lkt_user(store_id,access_id,user_name,headimgurl,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$wx_name','$headimgurl','$tel','$zhanghao','$password','$store_type','$ppid')";
            }
        }

        $r = $db->insert($sql);
        //更新user_id
        $sql = "select max(id) as userid from lkt_user where 1=1";
        $r = $db->select($sql);
        $rr = $r[0]->userid;
        $user_id = $user_id1.($rr+1);//新注册的用户user_id 
       
        $sql_0 = "select id from  lkt_user where store_id = '$store_id' and mobile = '$tel'";
        $res_0 = $db->select($sql_0); 
        $new_id = $res_0[0]->id;//要修改的用户id

        $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$new_id' and store_id = '$store_id'";
        $res_1 = $db->update($sql_1);

        $event = '会员' . $user_id . '注册成功';
        // 在操作列表里添加一条会员登录信息
        $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
        $r01 = $db->insert($sql);

        if( $r > 0 && $r01 > 0 && $res_1 > 0){
            $db->commit();
            $y_password = 1;
            if($rew){
                $sql2 = "delete from lkt_session_id where id = '$rew' ";
                $db->delete($sql2);
            }
            echo json_encode(array('code'=>200,'access_id'=>$token,'user_name'=>$tel,'headimgurl'=>$headimgurl,'y_password'=>$y_password,'message'=>'成功!'));
        }else{
            $db->rollback();
            echo json_encode(array('code'=>109,'message'=>'注册失败!'));
        }

        $this->update_user($db,$store_id,$user_id,$token);
        

        exit;
    }*/
    // 注册协议
    public function register_agreement(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $sql1 = "select * from lkt_agreement where store_id = '$store_id' and type = 0";
        $r1 = $db->select($sql1);
        if($r1){
            $content = $r1[0]->content;
        }else{
            $content = '';
        }
        echo json_encode(array('code'=>200,'content'=>$content,'message'=>'成功!'));
        exit;
    }
    // 验证码登录
    public function register(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权ID
        $clientid = trim($request->getParameter('clientid')); // 推送客户ID

        $tel = $request->getParameter('phone'); // 手机号码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码

        $pid = trim($request->getParameter('pid')); // 推荐人id

        $arr = array($tel,array('code'=>$keyCode));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);

        $wx_status = 0;
        // 根据商城id、手机号，查询用户信息
        $sql = "select * from lkt_user where store_id = '$store_id' and mobile = '$tel'";
        $r = $db->select($sql);
        if($r){ // 存在
            $user_id = $r[0]->user_id;
            $user_name = $r[0]->user_name;
            $headimgurl = $r[0]->headimgurl;
            $password = $r[0]->mima;
            $event = '会员' . $user_id . '登录';
            if($password){
                $y_password = 1; // 有密码
            }else{
                $y_password = 0; // 没密码
            }
            if($store_type == 1){
                $wx_id = $r[0]->wx_id;
                if($wx_id != ''){
                    $wx_status = 1;
                }
            }else if($store_type == 2){

            }
            if(empty($access_id)){ // 授权ID为空,代表没有进入商品详情
                // 生成密钥
                $token = Tools::getToken();
            }else{ // 授权ID存在,代表有进入商品详情
                $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                if($getPayload_test == false){ // 过期
                    // 生成密钥
                    $token = Tools::getToken();
                }else{
                    $token = $access_id;
                }
                $this->update_user($db,$store_id,$user_id,$token);
            }

            //分销推广推荐人修改
            $c = '';
            // if (!empty($pid)) {
            //     $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
            //     $r_0 = $db->select($sql_0);
            //     if ($r_0) {
            //         $sql_1 = "select id from lkt_user_distribution where store_id = '$store_id' and user_id='$user_id'";
            //         $r_1 = $db->select($sql_1);
            //         if ($r_1) {
            //             $c = ",Referee='$pid'";
            //         }
            //     }
            // }

            //最后登录时间
            $now_time = date('Y-m-d H:i:s');

            //登录后更新，最后登录时间
            $sql1 = "update lkt_user set clientid='$clientid',access_id = '$token' $c ,last_time = '$now_time' where store_id = '$store_id' and mobile = '$tel'";
            if(empty($clientid)){
                $sql1 = "update lkt_user set access_id = '$token' $c ,last_time = '$now_time' where store_id = '$store_id' and mobile = '$tel'";
            }
            $r1 = $db->update($sql1);
            // 在操作列表里添加一条会员登录信息
            $sql = "insert into lkt_record (store_id,user_id,add_date,event,type) values ('$store_id','$user_id',CURRENT_TIMESTAMP,'$event',0)";
            $r01 = $db->insert($sql);
            if($r01 > 0){
                if($rew){
                    $sql2 = "delete from lkt_session_id where id = '$rew' ";
                    $db->delete($sql2);
                }
                echo json_encode(array('code'=>200,'access_id'=>$token,'user_name'=>$user_name,'headimgurl'=>$headimgurl,'y_password'=>$y_password,'wx_status'=>$wx_status,'message'=>'成功!'));
                exit;
            }else{
                echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                exit;
            }
        }else{
            // 根据商城id、账号，查询用户信息
            $sql0 = "select * from lkt_user where store_id = '$store_id' and zhanghao = '$tel'";
            $r0 = $db->select($sql0);
            if($r0){
                $user_id = $r0[0]->user_id;
                $user_name = $r0[0]->user_name;
                $headimgurl = $r0[0]->headimgurl;
                $password = $r0[0]->mima;
                $event = '会员' . $user_id . '登录';
                if($password){
                    $y_password = 1; // 有密码
                }else{
                    $y_password = 0; // 没密码
                }
                if($store_type == 1){
                    $wx_id = $r0[0]->wx_id;
                    if($wx_id != ''){
                        $wx_status = 1;
                    }
                }else if($store_type == 2){

                }
                if(empty($access_id)){ // 授权ID为空,代表没有进入商品详情
                    // 生成密钥
                    $token = Tools::getToken();
                }else{ // 授权ID存在,代表有进入商品详情
                    $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                    if($getPayload_test == false){ // 过期
                        // 生成密钥
                        $token = Tools::getToken();
                    }else{
                        $token = $access_id;
                    }
                    $this->update_user($db,$store_id,$user_id,$token);
                }

                //分销推广推荐人修改
                $c = '';
                if (!empty($pid)) {
                    $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
                    $r_0 = $db->select($sql_0);
                    if ($r_0) {
                        $sql_1 = "select id from lkt_user_distribution where store_id = '$store_id' and user_id='$user_id'";
                        $r_1 = $db->select($sql_1);
                        if ($r_1) {
                            $c = ",Referee='$pid'";
                        }
                    }
                }

                //最后登录时间
                $now_time = date('Y-m-d H:i:s');

                //登录后更新，最后登录时间
                $sql1 = "update lkt_user set clientid='$clientid',access_id = '$token' $c ,last_time = '$now_time' where store_id = '$store_id' and zhanghao = '$tel'";
                if(empty($clientid)){
                    $sql1 = "update lkt_user set access_id = '$token' $c ,last_time = '$now_time' where store_id = '$store_id' and zhanghao = '$tel'";
                }
                $r1 = $db->update($sql1);
                // 在操作列表里添加一条会员登录信息
                $sql = "insert into lkt_record (store_id,user_id,add_date,event,type) values ('$store_id','$user_id',CURRENT_TIMESTAMP,'$event',0)";
                $r01 = $db->insert($sql);
                if( $r01 > 0 ){
                    if($rew){
                        $sql2 = "delete from lkt_session_id where id = '$rew' ";
                        $db->delete($sql2);
                    }
                    echo json_encode(array('code'=>200,'access_id'=>$token,'user_name'=>$user_name,'headimgurl'=>$headimgurl,'y_password'=>$y_password,'wx_status'=>$wx_status,'message'=>'成功!'));
                    exit;
                }else{
                    echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                    exit;
                }
            }else{
                $sql1 = "select * from lkt_config where store_id = '$store_id'";
                $r1 = $db->select($sql1);
                if($r1){
                    $wx_headimgurl = $r1[0]->wx_headimgurl;//默认微信用户头像
                    $headimgurl = ServerPath::getimgpath($wx_headimgurl);//默认微信用户头像
                    $wx_name = $r1[0]->wx_name;  //默认微信用户名
                    $user_id1 = $r1[0]->user_id; //默认用户名ID前缀
                }
                if(empty($access_id)){ // 授权ID为空,代表没有进入商品详情
                    // 生成密钥
                    $token = Tools::getToken();
                }else{ // 授权ID存在,代表有进入商品详情
                    $token = $access_id;
                }
                $ppid = '';
                if (!empty($pid)) {
                    $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
                    $r_0 = $db->select($sql_0);
                    if ($r_0) {
                        $ppid = $pid;
                    }
                }

                $db->begin();
                if(!empty($clientid)){
                    if(empty($ppid)){
                        $sql = "insert into lkt_user(store_id,access_id,user_name,headimgurl,mobile,zhanghao,mima,source,clientid) values('$store_id','$token','$wx_name','$headimgurl','$tel','$tel','','$store_type','$clientid')";
                    }else{
                        $sql = "insert into lkt_user(store_id,access_id,user_name,headimgurl,mobile,zhanghao,mima,source,Referee,clientid) values('$store_id','$token','$wx_name','$headimgurl','$tel','$tel','','$store_type','$ppid','$clientid')";
                    }
                }else{
                    if(empty($ppid)){
                        $sql = "insert into lkt_user(store_id,access_id,user_name,headimgurl,mobile,zhanghao,mima,source) values('$store_id','$token','$wx_name','$headimgurl','$tel','$tel','','$store_type')";
                    }else{
                        $sql = "insert into lkt_user(store_id,access_id,user_name,headimgurl,mobile,zhanghao,mima,source,Referee) values('$store_id','$token','$wx_name','$headimgurl','$tel','$tel','','$store_type','$ppid')";
                    }
                }
                $r = $db->insert($sql);

                //更新user_id
                $sql = "select max(id) as userid from lkt_user where 1=1";
                $r = $db->select($sql);
                $rr = $r[0]->userid;
                $user_id = $user_id1.($rr+1);//新注册的用户user_id 
               
                $sql_0 = "select id from  lkt_user where store_id = '$store_id' and mobile = '$tel'";
                $res_0 = $db->select($sql_0); 
                $new_id = $res_0[0]->id;//要修改的用户id

                $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$new_id' and store_id = '$store_id'";
                $res_1 = $db->update($sql_1);

                $event = '会员' . $user_id . '注册成功';
                // 在操作列表里添加一条会员登录信息
                $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
                $r01 = $db->insert($sql);

                if( $r > 0 && $r01 > 0 ){
                    $db->commit();
                    $y_password = 0; // 没密码
                    if($rew){
                        $sql2 = "delete from lkt_session_id where id = '$rew' ";
                        $db->delete($sql2);
                    }
                    echo json_encode(array('code'=>200,'access_id'=>$token,'user_name'=>$wx_name,'headimgurl'=>$headimgurl,'y_password'=>$y_password,'message'=>'成功!'));
                }else{
                    $db->rollback();
                    echo json_encode(array('code'=>109,'message'=>'注册失败!'));
                }
                $this->update_user($db,$store_id,$user_id,$token);
            }

//            echo json_encode(array('code'=>113,'message'=>'该手机号码未注册,请注册!'));
//            exit;
        }
    }
    // 用户登录
    /*public function login(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权ID
        $clientid = trim($request->getParameter('clientid')); //推送客户端ID

        $tel = $request->getParameter('phone'); // 电话号码
        $password = $request->getParameter('password');//密码

        $pid = $request->getParameter('pid');//推荐人id
        $wx_status = 0;
        $sql01="select * from lkt_user where store_id = '$store_id' and (zhanghao = '$tel' or mobile = '$tel')";
        $re = $db->select($sql01);

        if(!empty($re)){
            if($re[0]->mima == ''){
                echo json_encode(array('code'=>114,'message'=>'您还为设置密码，请用验证码登录!'));
                exit;
            }
            $password01= $db->unlock_url($re[0]->mima);

            $user_id = $re[0]->user_id;
            $user_name = $re[0]->user_name;
            $headimgurl = $re[0]->headimgurl;
            $event = '会员' . $user_id . '登录';
            if($store_type == 1){
                $wx_id = $re[0]->wx_id;
                if($wx_id != ''){
                    $wx_status = 1;
                }
            }else if($store_type == 2){

            }
            if($password){
                //if($password == $password01 && strlen($password) == strlen($password01) ){
                    if(empty($access_id)){ // 授权ID为空,代表没有进入商品详情
                        // 生成密钥
                        $token = Tools::getToken();
                    }else{ // 授权ID存在,代表有进入商品详情
                        $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
                        if($getPayload_test == false){ // 过期
                            // 生成密钥
                            $token = Tools::getToken();
                        }else{
                            $token = $access_id;
                        }

                        $this->update_user($db,$store_id,$user_id,$token);
                    }
                    //分销推广推荐人修改
                    $c = '';
                    if (!empty($pid)) {
                        $sql_0 = "select id from lkt_user_distribution where user_id='$pid' and store_id = '$store_id'";
                        $r_0 = $db->select($sql_0);
                        if ($r_0) {
                            $sql_1 = "select id from lkt_user_distribution where store_id = '$store_id' and user_id='$user_id'";
                            $r_1 = $db->select($sql_1);
                            if ($r_1) {
                                $c = ",Referee='$pid'";
                            }
                        }
                    }
                    //end

                    //最后登录时间
                    $now_time = date('Y-m-d H:i:s');

                    $sql1 = "update lkt_user set clientid='$clientid',access_id = '$token' $c ,last_time = '$now_time' where store_id = '$store_id' and (zhanghao = '$tel' or mobile = '$tel')";
                    if(empty($clientid)){
                        $sql1 = "update lkt_user set access_id = '$token' $c ,last_time = '$now_time' where store_id = '$store_id' and (zhanghao = '$tel' or mobile = '$tel')";
                    }

                    $r1 = $db->update($sql1);

                    $sql = "insert into lkt_record (store_id,user_id,add_date,event,type) values ('$store_id','$user_id',CURRENT_TIMESTAMP,'$event',0)";
                    $r01 = $db->insert($sql);
                    if($r01 > 0){
                        $y_password = 1; // 有密码

                        echo json_encode(array('code'=>200,'access_id'=>$token,'user_name'=>$user_name,'headimgurl'=>$headimgurl,'y_password'=>$y_password,'wx_status'=>$wx_status,'message'=>'成功!'));
                        exit;
                    }else{
                       echo json_encode(array('code'=>103,'message'=>'网络繁忙!'));
                       exit;
                    }
                   
                /*}else{
                    echo json_encode(array('code'=>114,'message'=>'密码错误!'));
                    exit;
                }
            }else{
                echo json_encode(array('code'=>114,'message'=>'您还为设置密码，请用验证码登录!'));
                exit;
            }
        }else{
            echo json_encode(array('code'=>113,'message'=>'该号码未注册,请注册!'));
            exit;
        }

    }*/

    // 获取旧密码
    public function oldpassword(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        if(empty($access_id)){
            echo json_encode(array('code'=>116,'message'=>'未授权！'));
            exit;
        }else{
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }
        // 根据微信id,查询用户id
        $sql01 = "select mima from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $re = $db->select($sql01);
        if(!empty($re)){
            $password= $db->unlock_url($re[0]->mima);

            echo json_encode(array('code'=>200,'oldpassword'=>$password,'message'=>'成功！'));
            exit;
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }

    // 忘记密码,验证账号是否存在
    public function forget_zhanghao(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $zhanghao = $request->getParameter('zhanghao'); // 账号

        $sql01="select mobile from lkt_user where store_id = '$store_id' and (zhanghao = '$zhanghao' or mobile = '$zhanghao')";
        $re = $db->select($sql01);
        if(!empty($re)){
            $mobile = $re[0]->mobile;
            echo json_encode(array('code'=>200,'mobile'=>$mobile,'message'=>'成功!'));
            exit;
        }else{
            echo json_encode(array('code'=>113,'message'=>'该账号未注册,请注册!'));
            exit;
        }
    }
    // 忘记密码,验证验证码是否正确
    public function forget_code(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $tel = $request->getParameter('phone'); // 手机号码
        $keyCode = trim($request->getParameter('keyCode')); // 验证码

        $arr = array($tel,array('code'=>$keyCode));
        $Tools = new Tools($db, $store_id, 1);
        $rew = $Tools->verification_code($db,$arr);

        if($rew){
            $sql2 = "delete from lkt_session_id where id = '$rew' ";
            $db->delete($sql2);
        }
        echo json_encode(array('code'=>200,'message'=>'成功!'));
        exit;
    }

    // 忘记密码重置密码
    public function forgotpassword(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $tel = $request->getParameter('phone'); // 手机号码
        $password = $db->lock_url($request->getParameter('password')); // 重置密码

        $sql01="select * from lkt_user where store_id = '$store_id' and mobile = '$tel'";
        $re = $db->select($sql01);
        if(!empty($re)){
            $sql = "update lkt_user set mima = '$password' where store_id = '$store_id' and mobile = '$tel'";
            $r = $db->update($sql);
            if($r){
                echo json_encode(array('code'=>200,'message'=>'修改成功!'));
                exit;
            }
        }else{
            echo json_encode(array('code'=>113,'message'=>'该手机号码未注册,请验证码登录!'));
            exit;
        }
    }

    public function update_user($db,$store_id,$user_id,$token){
        // 根据商城ID、token，查询购物车信息
        $sql0 = "select id,Goods_id,Size_id,Goods_num from lkt_cart where store_id = '$store_id' and token = '$token'";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $cart_id = $v->id; //商品id
                $Goods_id = $v->Goods_id; //商品id
                $Size_id = $v->Size_id; // 属性id
                $Goods_num = $v->Goods_num; // 数量
                // 根据商城id、用户id、商品id、属性id，查询用户购物车信息
                $sql1 = "select id,Goods_num from lkt_cart where store_id = '$store_id' and user_id = '$user_id' and Goods_id = '$Goods_id' and Size_id = '$Size_id'";
                $r1 = $db->select($sql1);
                if($r1){ // 存在 表示用户购物车有该商品
                    $id = $r1[0]->id; // 购物车id
                    $Goods_num1 = $r1[0]->Goods_num;// 数量
                    // 根据商品id、属性id,查询属性库存
                    $sql2 = "select num from lkt_configure where id = '$Size_id' and pid = '$Goods_id'";
                    $r2 = $db->select($sql2);
                    if($r2){
                        $num = $r2[0]->num; // 库存
                        if($Goods_num + $Goods_num1 >= $num){ // 没登录时购物车数量 + 登入后已存在的购物车数量 >= 库存剩余数量
                            $cart_num = $num;
                        }else{
                            $cart_num = $Goods_num + $Goods_num1;
                        }
                        // 根据商城ID、用户ID、购物车ID，修改购物车数量
                        $sql = "update lkt_cart set Goods_num = '$cart_num' where store_id = '$store_id' and user_id = '$user_id' and id = '$id'";
                        $db->update($sql);

                        // 根据商城ID、购物车ID，删除购物车信息
                        $sql = "delete from lkt_cart where store_id = '$store_id' and id = '$cart_id'";
                        $db->delete($sql);
                    }
                }else{ // 不存在 表示用户购物车没有该商品
                    // 根据商城ID、token、购物车ID，修改购物车用户ID
                    $sql = "update lkt_cart set user_id = '$user_id' where store_id = '$store_id' and token = '$token' and Goods_id = '$Goods_id'";
                    $db->update($sql);
                }
            }
        }

        // 根据商城ID、token，修改店铺浏览记录表
        $sql3 = "update lkt_mch_browse set user_id = '$user_id' where store_id = '$store_id' and token = '$token'";
        $db->update($sql3);

        return;
    }
    // 判断token是否存在或是否失效
    public function token(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权ID
        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                if($store_type == 1){ // 当为小程序时
                    // 根据商城ID、授权ID，查询用户信息
                    $sql1 = "select id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
                    $r1 = $db->select($sql1);
                    if($r1){ // 存在
                        // 生成密钥
                        $token = Tools::getToken();
                        $sql2 = "update lkt_user set access_id = '$token' where store_id = '$store_id' and access_id = '$access_id'";
                        $r2 = $db->update($sql2);
                        echo json_encode(array('code'=>200,'login_status'=>1,'access_id'=>$token,'message'=>'成功！'));
                        exit;
                    }else{ // 不存在
                        echo json_encode(array('code' => 404, 'message' => '请登录！'));
                        exit;
                    }
                }

                $sql3 = "update lkt_user set access_id = '' where store_id = '$store_id' and access_id = '$access_id'";
                $r3 = $db->update($sql3);

                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }else{
                // 根据商城ID、授权ID，查询用户信息
                $sql1 = "select id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
                $r1 = $db->select($sql1);
                if($r1){ // 存在
                    echo json_encode(array('code'=>200,'login_status'=>1,'message'=>'成功！'));
                    exit;
                }else{ // 不存在
                    echo json_encode(array('code'=>200,'login_status'=>0,'message'=>'成功！'));
                    exit;
                }
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }

    public function quit(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $access_id = trim($request->getParameter('access_id')); // 授权ID

        // 根据商城ID、token，修改会员列表
        $sql3 = "update lkt_user set access_id = '' where store_id = '$store_id' and access_id = '$access_id'";
        $db->update($sql3);

        echo json_encode(array('code'=>200,'message'=>'成功！'));
        exit;
    }

    /**
     * 更新购物车信息
     * @param $token
     * @param $db
     * @param $lkt_user_id
     */
    public function updateCartInfo($token, $db, $lkt_user_id)
    {
        $sql = "select count(1) as c from lkt_cart t where  token = '" . $token . "'";
        $r = $db->select($sql);
        if ($r[0]->c > 0) {
            $sql = " update lkt_cart t set t.user_id =  '" . $lkt_user_id . "' where token = '" . $token . "'";
            $res_update_cart = $db->update($sql);
            if ($res_update_cart >= 0) {
                $db->commit();
            } else {
                $db->rollback();
                echo json_encode(array('code' => 109, 'message' => '授权失败', "line" => __LINE__));
                exit;
            }
        } else {
            $db->commit();
        }
    }

    /**
     * 获取用户userid 前缀
     * @param $store_id
     * @param $db
     * @return string
     */
    public function getPreUserId($store_id, $db)
    {
        $user_id = "user";
        $sql0 = "select * from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if ($r0) {
            $user_id = $r0[0]->user_id; //默认用户名ID前缀
        }
        return $user_id;
    }

    /**
     * 获取token
     * @param $access_id
     * @param $db
     * @param $store_id
     * @param $store_type
     * @return bool|string
     */
    public function getToken($access_id, $db, $store_id, $store_type)
    {
        if (empty($access_id) || "undefined" == $access_id) { // 授权ID为空,代表没有进入商品详情
            $token = Tools::getToken();
        } else {
            // 授权ID存在,代表有进入商品详情
            $getPayload_test = Tools::verifyToken($db, $store_id, $store_type, $access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if ($getPayload_test == false) { // 过期
                // 生成密钥
                $token = Tools::getToken();
            }
        }
        return $token;
    }
}
?>