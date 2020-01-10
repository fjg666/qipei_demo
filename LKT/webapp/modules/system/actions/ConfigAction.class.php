<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class ConfigAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Config');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Agreement');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Aboutus');

        // 查询配置信息
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $is_register = $r[0]->is_register;// 是否需要注册 1.注册 2.免注册
            $logo = $r[0]->logo; // 公司logo
            $logo1 = $r[0]->logo1; // 首页logo
            $wx_headimgurl = $r[0]->wx_headimgurl;//默认微信用户头像
            $logo = ServerPath::getimgpath($logo,$store_id); // 公司logo
            $logo1 = ServerPath::getimgpath($logo1,$store_id); // 首页logo

            $wx_headimgurl1 = ServerPath::getimgpath($wx_headimgurl,$store_id);//默认微信用户头像
            $company = $r[0]->company; // 公司名称
            $wx_name = $r[0]->wx_name;  //默认微信用户名
            $user_id = $r[0]->user_id;  // 用户ID默认前缀
            $H5_domain = $r[0]->H5_domain;  // H5域名
            $message_day = $r[0]->message_day;  // 消息保留天数
            $customer_service = $r[0]->customer_service;  // 客服
        }

        $request->setAttribute('logo', isset($logo) ? $logo : '');
        $request->setAttribute('logo1', isset($logo1) ? $logo1 : '');
        $request->setAttribute('wx_name',isset($wx_name) ? $wx_name : '');
        $request->setAttribute('user_id',isset($user_id) ? $user_id : '');
        $request->setAttribute('company', isset($company) ? $company : '');
        $request->setAttribute("H5_domain", isset($H5_domain) ? $H5_domain : '');
        $request->setAttribute('message_day', isset($message_day) ? $message_day : '');
        $request->setAttribute('is_register', isset($is_register) ? $is_register : '');
        $request->setAttribute('wx_headimgurl',isset($wx_headimgurl) ? $wx_headimgurl : '');
        $request->setAttribute('wx_headimgurl1',isset($wx_headimgurl1) ? $wx_headimgurl1 : '');
        $request->setAttribute("customer_service", isset($customer_service) ? $customer_service : '');
        $request->setAttribute('button', $button);

        return View :: INPUT;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        //取得参数
        $is_register= addslashes($request->getParameter('is_register')); //是否需要注册 1.注册 2.免注册
        $image= addslashes($request->getParameter('image')); // 公司logo
        $oldpic= addslashes($request->getParameter('oldpic')); // 原图片
        $image1= addslashes($request->getParameter('image1')); // 公司logo
        $oldpic1= addslashes($request->getParameter('oldpic1')); // 原图片
        $wx_headimg = addslashes($request->getParameter('wx_image'));//默认微信头像
        $wx_oldpic = addslashes($request->getParameter('wx_oldpic'));//原默认头像
        $company = addslashes($request->getParameter('company')); // 公司名称
        $wx_name = addslashes($request->getParameter('wx_name')); // 微信默认用户名称
        $yuser_id = addslashes($request->getParameter('yuser_id')); // 原用户ID默认前缀
        $user_id = addslashes($request->getParameter('user_id')); // 用户ID默认前缀
        $message_day = addslashes($request->getParameter('message_day')); // 消息保留天数
        $customer_service= addslashes($request->getParameter('customer_service')); // 客服
        $H5_domain= addslashes($request->getParameter('H5_domain')); // H5域名

        $log = new LaiKeLogUtils('common/system.log');// 日志

        if($company == ''){
            $log -> customerLog(__LINE__.":修改基础配置失败: 公司名称不能为空！\r\n");
            echo json_encode(array('status' => '公司名称不能为空！'));exit;
        }

        if($wx_name == ''){
            $log -> customerLog(__LINE__.":修改基础配置失败: 微信用户默认名不能为空！\r\n");
            echo json_encode(array('status'=>'微信用户默认名不能为空！'));exit;
        }

        if($image){
            $image = preg_replace('/.*\//','',$image); // 获取图片名称
            if($image != $oldpic){
                $oldpic_0 = ServerPath::getimgpath($oldpic);//
                @unlink ($oldpic_0);
            }
        }else{
            $image = $oldpic;
        }
        if($image1){
            $image1 = preg_replace('/.*\//','',$image1); // 获取图片名称
            if($image1 != $oldpic1){
                $oldpic_1 = ServerPath::getimgpath($oldpic1);//
                @unlink ($oldpic_1);
            }
        }else{
            $image1 = $oldpic1;
        }

        if($wx_headimg){
            $wx_headimg = preg_replace('/.*\//','',$wx_headimg);//获取头像名称
            if($wx_headimg != $wx_oldpic){
                $wx_oldpic1 = ServerPath::getimgpath($wx_oldpic);//默认微信用户头像
                @unlink ($wx_oldpic1);
            }
        }else{
            $wx_headimg = $wx_oldpic;
        }
        if($message_day){}else{$message_day=0;}
        $sql0 = "select * from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            // 更新
            $sql = "update lkt_config set logo = '$image',logo1 = '$image1',wx_headimgurl = '$wx_headimg',H5_domain = '$H5_domain',company = '$company', wx_name = '$wx_name',user_id = '$user_id',message_day = '$message_day',customer_service = '$customer_service',modify_date = CURRENT_TIMESTAMP where store_id = '$store_id'";
            $r = $db->update($sql);
            if($r == -1) {
                $db->admin_record($store_id,$admin_name,'修改基础配置失败',2);
                $log -> customerLog(__LINE__.":修改基础配置失败: $sql \r\n");
                echo json_encode(array('status' => '未知原因，修改失败！！'));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'修改基础配置成功！',2);
                $log -> customerLog(__LINE__.":修改基础配置成功！\r\n");
                if($yuser_id != $user_id){
                    $this->up($db,$store_id,$yuser_id,$user_id);// 修改所有表用户id前缀
                }
                echo json_encode(array('status' => '修改成功！','suc'=>'1'));exit;
            }
        }else{
            $sql1 = "insert into lkt_config(store_id,is_register,logo,logo1,wx_headimgurl,H5_domain,company,wx_name,user_id,message_day,customer_service,modify_date) values ('$store_id','$is_register','$image','$image1','$wx_headimg','$H5_domain','$company','$wx_name','$user_id','$message_day','$customer_service',CURRENT_TIMESTAMP)";
            $r1 = $db->insert($sql1);
            if($r1 > 0){
                $log -> customerLog(__LINE__.":添加基础配置成功！ \r\n");
                $db->admin_record($store_id,$admin_name,'添加基础配置成功！',1);
                echo json_encode(array('status' => '添加成功！','suc'=>'1'));exit;
            }else{
                $db->admin_record($store_id,$admin_name,'添加基础配置失败',1);
                $log -> customerLog(__LINE__.":添加基础配置失败: $sql1 \r\n");
                echo json_encode(array('status' => '未知原因，添加失败！！'));exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    public function up($db,$store_id,$yuser_id,$user_id){
        $res = array(
            array('lkt_user','user_id'),
            array('lkt_auction_product','user_id'),
            array('lkt_auction_promise','user_id'),
            array('lkt_auction_record','user_id'),
            array('lkt_bargain_order','user_id'),
            array('lkt_bargain_record','user_id'),
            array('lkt_cart','user_id'),
            array('lkt_combined_pay','user_id'),
            array('lkt_comments','uid'),
            array('lkt_coupon','user_id'),
            array('lkt_dismantling_envelopes_record','user_id'),
            array('lkt_distribution_record','user_id'),
            array('lkt_distribution_record','from_id'),
            array('lkt_group_open','uid'),
            array('lkt_lottery_parameters','user_id'),
            array('lkt_mch','user_id'),
            array('lkt_mch_visit_log','user_id'),
            array('lkt_money_point','user_id'),
            array('lkt_order','user_id'),
            array('lkt_order_details','user_id'),
            array('lkt_record','user_id'),
            array('lkt_record','event'),
            array('lkt_red_packet_detailed','user_id'),
            array('lkt_red_packet_record','user_id'),
            array('lkt_red_packet_send','user_id'),
            array('lkt_red_packet_users','user_id'),
            array('lkt_reply_comments','uid'),
            array('lkt_return_goods','user_id'),
            array('lkt_share','user_id'),
            array('lkt_sign_record','user_id'),
            array('lkt_stock','user_id'),
            array('lkt_user_address','uid'),
            array('lkt_user_bank_card','user_id'),
            array('lkt_user_collection','user_id'),
            array('lkt_user_distribution','user_id'),
            array('lkt_user_footprint','user_id'),
            array('lkt_withdraw','user_id'),
            array('lkt_printing','r_userid'),
        );
        foreach ($res as $k => $v){
            if($yuser_id == ''){
                $sql0 = "update $v[0] set $v[1] = CONCAT('$user_id',$v[1]) where store_id = '$store_id'";
                $db->update($sql0);
            }else{
                $sql0 = "update $v[0] set $v[1] = replace($v[1],'$yuser_id','$user_id') where store_id = '$store_id'";
                $db->update($sql0);
            }
        }

        return;
    }
}

?>