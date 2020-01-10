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
class DetailAction extends Action
{

    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @return  订单详情
     * @version 2.0
     * @date    2018-12-25T10:56:55+0800
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

        $button[0] = $JurisdictionAction->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=orderslist&action=Addsign');

        $id = $request->getParameter('id'); // 订单id
        $type = $request->getParameter('type'); // 修改订单
        $update_s = $type ? true : false;

        $sql0 = "select remind from lkt_order_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if ($r0) {
            $remind = $r0[0]->remind;
            if ($remind == 0) {
                $remind_time = date("Y-m-d H:i:s", strtotime("+7 day"));
            } else {
                $remind_day = floor($remind / 24);
                $remind_hour = $remind % 24;
                $remind_time = date("Y-m-d H:i:s", strtotime("+$remind_day day +$remind_hour hour"));

            }
        } else {
            $remind_time = date("Y-m-d H:i:s", strtotime("+7 day"));
        }

        /*-----------进入订单详情把未读状态改成已读状态，已读状态的状态不变-------*/
        $sql01 = "select delivery_status,readd from lkt_order where store_id = '$store_id' and sNo = '$id'";
        $r01 = $db->select($sql01);
        if ($r01) {
            if ($r01[0]->readd == 0) {
                if ($r01[0]->delivery_status == 1) {
                    $sql02 = "update lkt_order set readd = 1,remind = '$remind_time' where store_id = '$store_id' and sNo = '$id'";
                } else {
                    $sql02 = "update lkt_order set readd = 1 where store_id = '$store_id' and sNo = '$id'";
                }
                $up = $db->update($sql02);
                if($up < 1){
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改已读状态失败！sql:" . $sql02);
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

        $sql = "select l.p_sNo,d.id,l.source,l.remarks,l.pay_time,l.id as oid,l.spz_price,u.user_name,l.sNo,l.name,l.mobile,l.sheng,l.shi,l.z_price,l.xian,l.status,l.address,l.pay,l.trade_no,l.coupon_id,l.reduce_price,l.coupon_price,l.allow,l.drawid,l.otype,l.grade_rate,d.user_id,d.p_id,d.p_name,d.p_price,d.num,d.unit,d.add_time,d.deliver_time,d.arrive_time,d.r_status,d.content,d.express_id,d.courier_num,d.sid,d.size,d.freight,e.kuaidi_name,c.total_num ,s.subtraction_type,s.subtraction
                from lkt_order_details as d 
                left join lkt_order as l on l.sNo=d.r_sNo 
                left join lkt_user as u on u.user_id=l.user_id and u.store_id='$store_id' 
                left join lkt_express as e on d.express_id=e.id 
				left join lkt_configure as c on c.id = d.sid
				LEFT JOIN lkt_subtraction as s on s.id = l.subtraction_id
                where l.store_id = '$store_id' and l.sNo='$id'";
        $res = $db->select($sql);
        $num = count($res);
        $data = array();
        $reduce_price = 0; // 满减金额
        $coupon_price = 0; // 优惠券金额
        $allow = 0; // 积分
        $yunfei = 0;
        $courier_num_arr = array();
        $yh_money = 0;
        foreach ($res as $k => $v) {
            $sid = $v->sid;
            $data['user_name'] = $v->user_name; // 联系人
            $data['name'] = $v->name; // 联系人
            $data['remarks'] = $v->remarks; //备注
            $data['pay_time'] = $v->pay_time;//支付时间
            $data['source'] = $v->source; //来源
            $data['sNo'] = $v->sNo; // 订单号
            $data['oid'] = $v->oid; // oid
            $data['mobile'] = $v->mobile; // 联系电话
            if($v->grade_rate == "1.00" || $v->grade_rate == "0.00"){
                $v->grade_rate2 = 1;
                $v->grade_rate = '-';
            }else{
                $v->grade_rate2 = $v->grade_rate;
                $v->grade_rate = $v->grade_rate * 10;
                $v->grade_rate = $v->grade_rate."折";
            }
            $yh_money = $yh_money+($v->num * $v->p_price) -  ($v->num*$v->p_price*$v->grade_rate2+$v->freight);

            $data['grade_rate'] = 0;
            $data['address'] = $v->sheng . $v->shi . $v->xian . $v->address; // 详细地址

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


            if(!in_array($v->courier_num,$courier_num_arr)){
                $data['courier_num'][$k]['num'] = $v->courier_num; // 快递单号
                $data['courier_num'][$k]['kuaidi_name'] = $v->kuaidi_name;
                $courier_num_arr[] = $v->courier_num;
            }
            $data['fh'] = 1;
            if($data['courier_num'][0]['kuaidi_name'] == null || empty($data['courier_num'][0]['kuaidi_name'])){
                $data['fh'] = 0;
            }
            $data['drawid'] = $v->drawid; // 抽奖ID
            $reduce_price = $v->reduce_price; // 满减金额
            $coupon_price = $v->coupon_price; // 优惠券金额
            $allow = $v->allow; // 积分
            if (array_key_exists($v->pay, $payments_type)) {
                $paytype = $payments_type[$v->pay];
            } else {
                $paytype = '组合支付';
            }
            $data['paytype'] = $paytype; // 支付方式
            $data['trade_no'] = $v->trade_no; // 微信支付交易号
            $yunfei = $yunfei + $v->freight;
            $data['id'] = $id;
            // 根据产品id,查询产品主图
            $psql = 'select imgurl from lkt_product_list where store_id = \'' . $store_id . '\' and id="' . $v->p_id . '"';
            $img = $db->selectarray($psql);
            if (!empty($img)) {
                $v->pic = ServerPath::getimgpath($img[0]['imgurl'], $store_id);
                $res[$k] = $v;
            }
            $data['lottery_status'] = 7;
        }
        //判断是否有赠品
        $zp_res = array();
        if ($res[0]->subtraction_type == 3) {
            $subtraction = unserialize($res[0]->subtraction);
            foreach ($subtraction as $k__ => $v__) {
                $zp_id = $v__;
            }
            $sel_zp_sql = "SELECT * FROM lkt_product_list as p LEFT JOIN lkt_configure as c on c.pid=p.id where pid = $zp_id and p.store_id = $store_id";
            $zp_res = $db->select($sel_zp_sql);
            $zp_res = $zp_res[0];
            $zp_res->product_title = "<span style='color: red;'>(赠品)</span>" . $zp_res->product_title;
            $zp_res->img = ServerPath::getimgpath($zp_res->img, $store_id);
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


        if ($data['otype'] == 'pt') {
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
                case 4 :
                    $data['r_status'] = '退货';
                    $data['bgcolor'] = '#e198b4';
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

        $sdata = array('待付款', '待发货', '待收货', '待评价', '退货', '已完成', '已关闭');
        $request->setAttribute("sdata", $sdata);
        $request->setAttribute("yh_money", $yh_money);
        $request->setAttribute("zp_res", $zp_res);
        $request->setAttribute("update_s", $update_s);
        $request->setAttribute("data", $data);
        $request->setAttribute("detail", $res);
        $request->setAttribute("reduce_price", $reduce_price);
        $request->setAttribute("coupon_price", $coupon_price);
        $request->setAttribute("allow", $allow);
        $request->setAttribute("num", $num);
        $request->setAttribute('button', $button);

        return View :: INPUT;

    }


    /**
     * [execute description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @return  操作订单详情
     * @version 2.0
     * @date    2018-12-25T10:57:43+0800
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        //m指向具体操作方法
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))) : 'getDefaultView';
        $store_id = $this->getContext()->getStorage()->read('store_id');
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
     * @return  修改订单操作
     * @version 2.0
     * @date    2018-12-25T10:58:54+0800
     */
    public function updata()
    {
        $store_id = $this->store_id;
        $this->db->begin();

        $request = $this->getContext()->getRequest();
        $where = $request->getParameter('where');
        $updata = $request->getParameter('updata');

        $sNo = $where['sNo'];
        $status = $where['status'];

        foreach ($updata as $key => $value) {
            if (empty($value)) {
                $this->db->rollback();
                echo json_encode(array('status' => 0, 'msg' => '输入值有误！'));
                exit;
            }
            if ($key == 'z_price') {
                if ($value < 0) {
                    $this->db->rollback();
                    echo json_encode(array('status' => 0, 'msg' => '订单金额有误！'));
                    exit;
                }
            }

            if ($key == 'mobile') {
                if (!preg_match("/^1[34578]\d{9}$/", $value) || strlen($value) != 11) {
                    $this->db->rollback();
                    echo json_encode(array('status' => 0, 'msg' => '手机号格式不正确！'));
                    exit;
                }
            }
            $updata[$key] = addslashes($value);
        }

        //列出数据
        if ($status < 2) {
            $table = 'lkt_order';
            $ww = 'sNo';
        } elseif ($status == 2) {
            $table = 'lkt_order_details';
            $ww = 'r_sNo';
        } else {
            $this->db->rollback();
            echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
            exit;
        }

        $res = $this->db->modify($updata, $table, "`$ww` ='$sNo' and `store_id` = '$store_id'");
        if ($res < 1) {
            $this->db->rollback();
            echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
            exit;
        }

        $this->db->commit();
        echo json_encode(array('status' => 1, 'msg' => '操作成功！'));
        exit;
    }

    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>