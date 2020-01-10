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

class mchorderAction extends Action {
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
    //商户提交报价
    public function user_add_enquiry(){
        $db = DBAction::getInstance();
        $output = New Result;

        $request = $this->getContext()->getRequest();

        $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $user_id  = $request->getParameter('user_id');  //用户id
        $eid      = $request->getParameter('eid');      //询价id
        $mch_id   = $request->getParameter('mch_id');   //商户id
        $order_sn = $request->getParameter('order_sn'); //订单id
        $jsonData = json_decode($request->getParameter('jsonData'),true); //报价数据json格式
        $createDate = date('Y-m-d H:i:s');

        //查询用户权限是否是商家
        $UserSql = "select * from lkt_user where id = ".$user_id;
        $checkUser = $db->select($UserSql);
        if($checkUser[0]->level == 1){
            $output->_jsonError('-1','权限不足！');
        }

        //添加报价订单表
        $sql1 = "insert into lkt_offer(store_id,eid,order_sn,user_id,mch_id,create_date) value($store_id,$eid,$order_sn,$user_id,$mch_id,$createDate)";

        //添加订单表
        //$sql5 = "insert into lkt_order() values()";

        $oid = $db->insert($sql1, 'last_insert_id');
        if($oid > 0){
            foreach($jsonData as $key => $val){
                //添加订单信息表
                $sql2 = "insert into lkt_offer_info(order_id,order_sn,yc_price,yc_remarks,xx_price,xx_remarks,pp_price,pp_remarks,cc_price,cc_remarks) value($oid,'$order_sn','".$val['yc_price']."','".$val['yc_remarks']."','".$val['xx_price']."','".$val['xx_reamrks'].",'".$val['pp_price']."','".$val['pp_remarks']."','".$val['cc_price']."','".$val['cc_remarks'].")";
                $db->insert($sql2, 'last_insert_id');
            }

            //修改询价状态
            $sql3 = "update lkt_enquiry set is_baojia = 1, baojia_date = '".date('Y-m-d H:i:s')."' where id = ".$eid;
            $check = $db->update($sql3);
            if($check > 0){
                //查询询价配件
                $sql4 = "select GROUP_CONCAT(parts_name) as parts_name from lkt_enquiry_parts where eid = ".$eid;
                $enquiry = $db->select($sql4);
                //报价成功 微信推送给询价用户
                WxPush::send_notice($user_id,$checkUser[0]->wx_id,$enquiry[0]->parts_name);
                $this->_jsonResult('报价成功！');
            }else{
                $this->_jsonError('-1','报价失败！');
            }
        }else{
            $output->_jsonError('-1','添加订单失败！');
        }
    }

    //商户报价列表
    public function user_offer(){
        $db = DBAction::getInstance();
        $output = New Result;

        $request = $this->getContext()->getRequest();
        $user_id  = $request->getParameter('user_id'); //用户id

        //查询用户权限是否是商家
        $UserSql = "select level from lkt_user where id = ".$user_id;

        $checkUser = $db->select($UserSql);
        if($checkUser){
            if($checkUser[0]->level == 1){
                $output->_jsonError('-1','权限不足！');
            }
        }

        //查询用户询价列表
        $sql = "select * from lkt_enquiry where user_id = ".$user_id;
        $enquiry = $db->select($sql);
        $data['enquiry'] = json_decode(json_encode($enquiry),true);

        //根据用户询价查询配件列表
        foreach($data['enquiry'] as $key => $val){
            $sql2  = "select * from lkt_enquiry_parts where eid = ".$val['id'];
            $parts = $db->select($sql2);
            $data['enquiry'][$key]['parts'] = json_decode(json_encode($parts),true);
        }

        $output->_jsonResult('',$data);
    }
}



