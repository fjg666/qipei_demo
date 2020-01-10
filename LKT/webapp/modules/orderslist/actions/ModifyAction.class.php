<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class ModifyAction extends Action
{

    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-25T10:56:55+0800
     * @return  订单详情
     */
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=orderslist&action=Addsign');

        $id = $request->getParameter('id'); // 订单id
        $type = $request->getParameter('type'); // 修改订单
        $update_s = $type ? true:false;
        /*-----------进入订单详情把未读状态改成已读状态，已读状态的状态不变-------*/
        $sql01 = "select readd from lkt_order where store_id = '$store_id' and sNo = '$id'";
        $r01 = $db->select($sql01);
        // var_dump($sql01,$r01);
        if($r01){
          if ($r01[0]->readd == 0) {
                $sql02 = "update lkt_order set readd = 1 where store_id = '$store_id' and sNo = '$id'";
                $up = $db->update($sql02);
                if($up < 1){
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单已读状态失败！sql:" . $sql02);
                }
            }  
        }
        /*--------------------------------------------------------------------------*/

        //支付方式
        $sql = "select * from lkt_payment where 1=1  order by sort desc";
        $payments = $db->select($sql);
        $payments_type = array();
        foreach ($payments as $keyp => $valuep) {
            $payments_type[$valuep->class_name] = $valuep->name;
        }

        $sql = "select l.p_sNo,d.id,l.source,l.pay_time,l.id as oid,u.user_name,l.sNo,l.name,l.mobile,l.sheng,l.shi,l.z_price,l.xian,l.status,l.address,l.pay,l.trade_no,l.coupon_id,l.reduce_price,l.coupon_price,l.allow,l.drawid,l.otype,d.user_id,d.p_id,d.p_name,d.p_price,d.num,d.unit,d.add_time,d.deliver_time,d.arrive_time,d.r_status,d.content,d.express_id,d.courier_num,d.sid,d.size,d.freight 
                from lkt_order_details as d 
                left join lkt_order as l on l.sNo=d.r_sNo 
                left join lkt_user as u on u.user_id=l.user_id and u.store_id='$store_id' where l.store_id = '$store_id' and l.sNo='$id'";
        $res = $db->select($sql);

        $num = count($res);
        $data = array();
        $reduce_price = 0; // 满减金额
        $coupon_price = 0; // 优惠券金额
        $allow = 0; // 积分
        $yunfei = 0;

//        //查询省市区
//        $sel_sheng_sql = "select * from admin_cg_group where G_Level = 2 and G_ParentID = 0";
//        $sheng_res = $db->select($sel_sheng_sql);
//        $city_res = array();
//        if(!empty($sheng_res)){
//            foreach ($sheng_res as $G_k => $G_v){
//                $city_res[$G_k]['value'] = $G_v->G_CName;
//                $city_res[$G_k]['label'] = $G_v->G_CName;
//                $parent_id = $G_v->GroupID;
//                $sel_shi_sql = "select * from admin_cg_group where G_Level = 3 and G_ParentID = $parent_id";
//                $shi_res = $db->select($sel_shi_sql);
//                if(!empty($shi_res)){
//                    foreach ($shi_res as $G_k1 => $G_v1){
//                        $city_res[$G_k]['children'][$G_k1]['value'] = $G_v1->G_CName;
//                        $city_res[$G_k]['children'][$G_k1]['label'] = $G_v1->G_CName;
//                        $parent_id1 = $G_v1->GroupID;
//                        $sel_xian_sql = "select * from admin_cg_group where G_Level = 4 and G_ParentID = $parent_id1";
//                        $xian_res = $db->select($sel_xian_sql);
//                        if(!empty($xian_res)){
//                            foreach ($xian_res as $G_k2 => $G_v2){
//                                $city_res[$G_k]['children'][$G_k1]['children'][$G_k2]['value'] = $G_v2->G_CName;
//                                $city_res[$G_k]['children'][$G_k1]['children'][$G_k2]['label'] = $G_v2->G_CName;
//                            }
//                        }
//                    }
//                }
//
//            }
//        }
//        echo json_encode($city_res);exit;
        foreach ($res as $k => $v) {

            $sid = $v->sid;
            $data['user_name'] = $v->user_name; // 联系人
            $data['name'] = $v->name; // 联系人
            $data['pay_time'] = $v->pay_time;//支付时间
            $data['source'] = $v->source; //来源
            $data['sNo'] = $v->sNo; // 订单号
            $data['oid'] = $v->oid; // oid
            $data['mobile'] = $v->mobile; // 联系电话
            $data['address'] = $v->address; // 详细地址
            $data['sheng'] = $v->sheng; // 省
            $data['shi'] = $v->shi; // 市
            $data['xian'] = $v->xian; // 县

            $data['add_time'] = $v->add_time; // 添加时间

            $data['z_price'] = $v->z_price; // 添加时间

            $data['user_id'] = $v->user_id; // 用户id

            $data['deliver_time'] = $v->deliver_time; // 发货时间

            $data['arrive_time'] = $v->arrive_time; // 到货时间

            $data['r_status'] = $v->r_status; // 订单详情状态

            $data['status01'] = $v->r_status; // 订单详情状态

            $data['gstatus'] = $v->status; // 订单详情状态

            $data['otype'] = $v->otype;  // 订单类型

            $data['content'] = $v->content; // 退货原因

            $data['express_id'] = $v->express_id; // 快递公司id

            $data['courier_num'] = $v->courier_num; // 快递单号

            $data['drawid'] = $v->drawid; // 抽奖ID
            $reduce_price = $v->reduce_price; // 满减金额
            $coupon_price = $v->coupon_price; // 优惠券金额
            $allow = $v->allow; // 积分
            // var_dump($v->pay,array_key_exists($v->pay,$payments_type));
            if(array_key_exists($v->pay,$payments_type)){
                $paytype = $payments_type[$v->pay];
            }else{
                $paytype = '组合支付';
            }
            $data['paytype'] = $paytype; // 支付方式


            $data['trade_no'] = $v->trade_no; // 微信支付交易号
            
            $yunfei = $yunfei+$v->freight;
            $data['id'] = $id;
            // 根据产品id,查询产品主图
            $psql = 'select imgurl from lkt_product_list where store_id = \''.$store_id.'\' and id="' . $v->p_id . '"';
            $img = $db->selectarray($psql);
            if (!empty($img)) {
                $v->pic = ServerPath::getimgpath($img[0]['imgurl'],$store_id);
                $res[$k] = $v;
            }
            $data['lottery_status'] = 7;
        }
        $data['freight'] = $yunfei; // 运费
        if (isset($data['express_id'])) {
            $exper_id = $data['express_id'];
            // 根据快递公司id,查询快递公司表信息
            $sql03 = "select * from lkt_express where id = $exper_id ";
            $r03 = $db->select($sql03);
            $data['express_name'] = $r03[0]->kuaidi_name; // 快递公司名称
        } else {
            $data['express_name'] = '';
        }

        if($data['otype'] == 'pt') {
            switch ($data['gstatus']) {
                case 0 :
                    $data['r_status'] = '待付款';
                    $data['pt_status'] = '待付款';
                    $data['bgcolor'] = '#f5b1aa';
                    break;
                case 1 :
                    $data['pt_status'] = '拼团成功';
                    $data['r_status'] = '待发货';
                    $data['bgcolor'] = '#f0908d';
                    break;
                case 2 :
                    $data['pt_status'] = '拼团成功';
                    $data['r_status'] = '待收货';
                    $data['bgcolor'] = '#f0908d';
                    break;
                case 3 :
                    $data['r_status'] = '待评价';
                    $data['bgcolor'] = '#f0908d';
                    $data['pt_status'] = '拼团成功';
                    break;
                case 5 :
                    $data['r_status'] = '已完成';
                    $data['bgcolor'] = '#f7b977';
                    $data['pt_status'] = '拼团成功';
                    break;
                case 6 :
                    $data['r_status'] = '已关闭';
                    $data['bgcolor'] = '#f7b977';
                    $data['pt_status'] = '拼团成功';
                    break;
                case 9 :
                    $data['r_status'] = '待成团';
                    $data['bgcolor'] = '#f5b199';
                    $data['pt_status'] = '拼团中';
                    break;
                case 10 :
                    $data['r_status'] = '未退款';
                    $data['pt_status'] = '拼团失败';
                    $data['bgcolor'] = '#ee827c';
                    break;
                case 11 :
                    $data['r_status'] = '已退款';
                    $data['pt_status'] = '拼团失败';
                    $data['bgcolor'] = '#ee827c';
                    break;
            }
        } else {
            switch ($data['gstatus']) {
                case 0 :
                    $data['r_status'] = '待付款';
                    $data['bgcolor'] = '#f5b1aa';
                    break;
                case 1 :
                    $data['r_status'] = '待发货';
                    $data['bgcolor'] = '#f09199';
                    break;
                case 2 :
                    $data['r_status'] = '待收货';
                    $data['bgcolor'] = '#f19072';
                    break;
                case 3 :
                    $data['r_status'] = '待评价';
                    $data['bgcolor'] = '#e4ab9b';
                    break;
                case 4 :
                    $data['r_status'] = '退货';
                    $data['bgcolor'] = '#e198b4';
                    break;
                case 5 :
                    $data['r_status'] = '已完成';
                    $data['bgcolor'] = '#f7b977';
                    break;
                case 6 :
                    $data['r_status'] = '已关闭';
                    $data['bgcolor'] = '#ffbd8b';
                    break;
                case 7 :
                    $data['r_status'] = '已关闭';
                    $data['bgcolor'] = '#ffbd8b';
                    break;
                case 8 :
                    $data['r_status'] = '追加评论';
                    $data['bgcolor'] = '#ffbd8b';
                    break;
                case 9 :
                    $data['r_status'] = '拼团中';
                    $data['bgcolor'] = '#ffbd8b';
                    break;
                case 11 :
                    $data['r_status'] = '拼团失败';
                    $data['bgcolor'] = '#ffbd8b';
                    break;
                case 10 :
                    $data['r_status'] = '拼团失败';
                    $data['bgcolor'] = '#ffbd8b';
                    break;
                case 12 :
                    $data['r_status'] = '已完成';
                    $data['bgcolor'] = '#f7b977';
                    break;
            }
        }
        $sdata = array('待付款', '待发货', '待收货', '待评价', '退货', '已完成','已关闭');

        if ($v->otype == 'integral') {
            $integralid = $v->p_sNo;
            $sql = "select g.integral,g.money,c.img from lkt_integral_goods as g left join lkt_configure as c on g.attr_id = c.id where g.id='$integralid'";
            $inr = $db->select($sql);
            if ($inr) {
                $v->p_integral = $inr[0]->integral;
                $v->p_money = $inr[0]->money;
                $v->pic = ServerPath::getimgpath($inr[0]->img);
            }
        }

        $sql02 = "select * from lkt_express ";
        $r02 = $db -> select($sql02);
//        var_dump($r02);exit;
        $request -> setAttribute("express", $r02);
        $request->setAttribute("sdata", $sdata);
        $request->setAttribute("update_s", $update_s);
        $request->setAttribute("data", $data);
        $request->setAttribute("detail", $res);
        $request->setAttribute("reduce_price", $reduce_price);
        $request->setAttribute("coupon_price", $coupon_price);
        $request->setAttribute("allow", $allow);
        $request->setAttribute("num", $num);
        $request -> setAttribute('button', $button);

        return View :: INPUT;

    }


    /**
     * [execute description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-25T10:57:43+0800
     * @return  操作订单详情
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        //m指向具体操作方法
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))):'getDefaultView';
        $store_id =  $this->getContext()->getStorage()->read('store_id');
        $this->store_id = $store_id;
        $this->db = $db;
        //m指向具体操作方法
        $this->$m();
        exit;
    }

    /**
     * [updata description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-25T10:58:54+0800
     * @return  修改订单操作
     */
    public function updata()
    {
        $store_id = $this->store_id;
        

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $where = $request->getParameter('where');
        $updata = $request->getParameter('updata');
        $sheng = $request->getParameter('sheng');
        $shi = $request->getParameter('shi');
        $xian = $request->getParameter('xian');
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        $sNo = $where['sNo'];
        $status = $where['status'];
        $updata['sheng'] = $sheng;
        $updata['shi'] = $shi;
        $updata['xian'] = $xian;
        $r_status = $updata['status'];
        foreach ($updata as $key => $value) {
            if($value == ''){
               echo json_encode(array('status' => 0,'msg'=>'输入值有误！'));exit;
            }
            if($key == 'z_price'){
                if($value < 0){
                   echo json_encode(array('status' => 0,'msg'=>'订单金额有误！'));exit;
                }
            }

            if($key == 'mobile'){
                if(!preg_match("/^1[34578]\d{9}$/", $value) || strlen($value) != 11){
                   echo json_encode(array('status' => 0,'msg'=>'手机号格式不正确！'));exit;
                }
            }
            $updata[$key] = addslashes($value);
        }

        //列出数据
        if($status < 2){
            $table = 'lkt_order';
            $ww = 'sNo';
            $updata['status'] = $updata['status'];

        }elseif ($status == 2) {
            $table = 'lkt_order_details';
            $ww = 'r_sNo';
            $updata['r_status'] = $updata['status'];
        }else{
           echo json_encode(array('status' => 0,'msg'=>'操作失败！'));exit;
        }

        $this->db->begin();
        unset($updata['status']);

        $res = $this->db->modify($updata, $table, "`$ww` ='$sNo' and `store_id` = '$store_id'");
        if ($res < 0) {
            if($status != $r_status){
                $sql_d = "update lkt_order_details set r_status = '$r_status' where r_sNo = '$sNo' ";
                $r_d1 = $this->db->update($sql_d);
                if($r_d1 < 1){
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单已读状态失败！sql:" . $sql_d);
                }
                $sql_d = "update lkt_order set status = '$r_status' where sNo = '$sNo' ";
                $r_d2 = $this->db->update($sql_d);
                if($r_d2 < 1){
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单状态失败！sql:" . $sql_d);
                }
                $JurisdictionAction->admin_record($store_id,$admin_name,' 修改单号为'.$sNo.'的订单 状态为:'.$r_status,7);

            }else{
                $this->db->rollback();
                echo json_encode(array('status' => 0,'msg'=>'操作失败！'));exit;
            }
        }


        if($status != $r_status){
            $sql_d1 = "update lkt_order_details set `r_status` = '$r_status' where r_sNo = '$sNo' ";
            $r_d1 = $this->db->update($sql_d1);
            if($r_d1 < 1){
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单详情状态失败！sql:" . $sql_d1);
            }
            $sql_d2 = "update lkt_order set `status` = '$r_status' where sNo = '$sNo' ";
            $r_d2 = $this->db->update($sql_d2);
            if($r_d2 < 1){
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单状态失败！sql:" . $sql_d2);
            }
            $JurisdictionAction->admin_record($store_id,$admin_name,' 修改单号为'.$sNo.'的订单 状态为:'.$r_status,7);
        }

        $this->db->commit();
        echo json_encode(array('status' => 1,'msg'=>'操作成功！'));exit;
    }

    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>