<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/version.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

/**
 * [Laike System] Copyright (c) 2019 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class ChangeAction extends Action
{

    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 竞拍商品首页
     * @date 2019年1月7日
     * @version 1.0
     */

    public function getDefaultView()
    {

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_id = $this->getContext()->getStorage()->read('admin_id');


        return View :: INPUT;
    }

    public function execute()
    {
        $request = $this->getContext()->getRequest();
        $m = $request->getParameter('m');

        $this -> $m();
    }
     
    //删除及批量删除
    public function del()
    {
        //初始化
        $log = new LaiKeLogUtils('common/auction.log');
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $id = $request->getParameter('id');
        
        //去除左右的点
        if (strpos($id, ',')) {
            $id = substr($id, 0, -1);
        }
        //判断是否有正在竞拍的活动
        $sql_0 = "select id from lkt_auction_product where id in ($id) and store_id = '$store_id' and status = 1";
        $res_0 = $db->select($sql_0);
        if ($res_0) {
            echo json_encode(array('status'=>2,'info'=>'操作失败，存在正在竞拍商品'));
            exit;
        }

        //判断是否有已结束，且生成了待付款订单的竞拍活动
        $sql_1 = "select id,trade_no from lkt_auction_product where id in ($id) and store_id = '$store_id' and status = 2 and trade_no is not null and is_buy = 0";
        $res_1 = $db->select($sql_1);

        if ($res_1) {
            foreach ($res_1 as $k => $v) {
                $sNo = $v->trade_no;
                $sql_1 = "update lkt_order_details set r_status = 7 where store_id = '$store_id' and r_sNo = '$sNo'";
                $res_1 = $db->update($sql_1);
                if($res_1 < 0){
                    $log -> customerLog(__LINE__.':更新订单详情状态失败，sql为：'.$sql_1."\r\n");
                }
                $sql_2 = "update lkt_order set status = 7 where store_id = '$store_id' and sNo = '$sNo'";
                $res_2 = $db->update($sql_2);
                if($res_2 < 0){
                    $log -> customerLog(__LINE__.':更新订单详情状态失败，sql为：'.$sql_1."\r\n");
                }
                if ($res_1 < 0 || $res_2 < 0) {

                    echo json_encode(array('status'=>2,'info'=>'操作失败，有未删除待付款订单！'));
                    exit;
                }
            }
        }

        //删除
        $sql = "update lkt_auction_product set recycle = 1 where id in ($id) and store_id = '$store_id'";
        $res = $db->update($sql);
        if ($res > 0) {
            echo json_encode(array('status'=>1,'info'=>'操作成功！'));
            exit;
        } else {
            $log -> customerLog(__LINE__.':回收竞拍活动失败，sql为：'.$sql."\r\n");
            echo json_encode(array('status'=>0,'info'=>'操作失败！'));
            exit;
        }
    }

    //开始，结束活动
    public function siwtch()
    {   
        $log = new LaiKeLogUtils('JP/JP_Time.log');
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $id = $request->getParameter('id');//竞拍商品id

        //根据状态进行，修改操作

        $sql = "select status,starttime,title from lkt_auction_product where id = '$id' and store_id = '$store_id'";
        $res = $db->select($sql);
        $status = $res[0]->status;
        $starttime = $res[0]->starttime;
        $title = $res[0]->title;
        $now_time = date("Y-m-d H:i:s");
        $user_id = '';
        // if($now_time < $starttime){
                
        // 	echo json_encode(array('status'=>'未在活动时间','start'=>1));
        // 	exit;
        // }
         
        if ($status == 0) {
            //未开始---->竞拍中
            $sql = "update lkt_auction_product set status = 1,starttime = '$now_time' where id = {$id} and store_id = '$store_id' and recycle = 0 ";
            $res = $db->update($sql);

            if ($res > 0) {
                $db->admin_record($store_id, $admin_name, $id.'开始成功！', 5);
                echo json_encode(array('status'=>1,'info'=>'开始成功','start'=>1));
                exit;
            } else {
                $log -> customerLog(__LINE__.':开始竞拍活动失败，sql为：'.$sql."\r\n");
                $db->admin_record($store_id, $admin_name, $id.'开始失败！', 5);
                echo json_encode(array('status'=>0,'info'=>'开始失败','start'=>1));
                exit;
            }
        } else {
            //查询出竞拍配置
            //查询出竞拍配置信息
            $sql = "select * from lkt_auction_config where store_id = '$store_id'";
            $res = $db->select($sql);
            if ($res) {
                $days = $res[0]->days;
            } else {
                $db->admin_record($store_id, $admin_name, '添加竞拍'.$title.'失败', 1);
                echo json_encode(array('status'=>'竞拍配置未设置'));
                exit;
            }
             
            $datetime = date("Y-m-d H:i:s");//结束时间
                $invalid_time = date('Y-m-d H:i:s', strtotime($datetime." + $days day"));//竞拍活动具体失效日期
                $sql_1 = "select low_pepole,pepole from lkt_auction_product where store_id = '$store_id' and id = '$id' and recycle = 0 ";
            $res_1 = $db->select($sql_1);
            $low_pepole = $res_1[0]->low_pepole;
            $pepole = $res_1[0]->pepole;
            //活动是否有出价
            $sql_2 = "select id from lkt_auction_record where store_id = '$store_id' and auction_id = '$id'";
            $res_2 = $db->selectrow($sql_2);
                  

            //事务开始
            $db->begin();
            $code = true;

            if (($pepole < $low_pepole) || ($res_2 <= 0)) {//结束人数不达标竞拍商品
                $sql = "update lkt_auction_product set status = 3,endtime = '$datetime',invalid_time = '$invalid_time' where id = {$id} and store_id = '$store_id' and recycle = 0 ";
            } else {
                $sql_0 = "select price,user_id from lkt_auction_record where store_id = '$store_id' and auction_id = '$id'  ORDER BY price desc,add_time desc,id desc limit 1";
                $res_0 = $db->select($sql_0);
                if (!$res_0) {
                    $code = false;
                } else {
                    $h_price = $res_0[0]->price;//最高价
                      $user_id = $res_0[0]->user_id;//最高价得主
                }
                  
                    
                //结束人数达标竞拍商品
                //竞拍押金退款标准改变
                $sql_1 = "update lkt_auction_promise set allow_back = 0 where store_id = '$store_id' and a_id = '$id' and user_id = '$user_id'";
                $res_1 = $db->update($sql_1);
                if (!$res_1) {
                    $log -> customerLog(__LINE__.':更新竞拍押金状态失败，sql为：'.$sql_1."\r\n");
                    $code = false;
                }

                //竞拍产品转态改变
                $sql = "update lkt_auction_product set status = 2,endtime = '$datetime',invalid_time = '$invalid_time',current_price = '$h_price',user_id = '$user_id' where id = {$id} and store_id = '$store_id' and recycle = 0 ";
            }

            $res = $db->update($sql);
            if (!$res) {
                $log -> customerLog(__LINE__.':更新竞拍活动失败，sql为：'.$sql."\r\n");
                $code = false;
            }
            if ($code != true) {
                $db->rollback();
            } else {
                $db->commit();
            }
            if ($code) {

                    /**竞拍得主领先通知*/
                $msg_title = '尊敬的会员恭喜你竞拍'.$title.'成功！';
                $msg_content = '请在规定时间内付款';
                //给用户发送消息
                $pusher = new LaikePushTools();
                $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id,'');
                $db ->admin_record($store_id, $admin_name, $id.'结束成功！', 5);
                echo json_encode(array('status'=>1,'info'=>'操作成功'));
                exit;
            } else {
                $db->admin_record($store_id, $admin_name, $id.'结束失败！', 5);
                echo json_encode(array('status'=>0,'info'=>'操作失败'));
                exit;
            }
        }
    }

    //显示和不显示活动
    public function show()
    {

             //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $id = $request->getParameter('id');
        $is_show = $request->getParameter('is_show');


        if ($is_show == 1) {//显示竞拍活动

            $sql = "update lkt_auction_product set is_show = 1 where id = '$id' and store_id = '$store_id' and recycle = 0 ";
            $res = $db->update($sql);
            if ($res > 0) {
                echo json_encode(array('msg'=>'操作成功'));
                exit;
            } else {
                $log -> customerLog(__LINE__.':显示竞拍活动失败，sql为：'.$sql."\r\n");
                echo json_encode(array('msg'=>'操作失败'));
                exit;
            }
        } elseif ($is_show == 0) {//不显示竞拍活动
            $sql = "update lkt_auction_product set is_show = 0 where id = '$id' and store_id = '$store_id' and recycle = 0 ";
            $res = $db->update($sql);
            if ($res > 0) {
                echo json_encode(array('msg'=>'操作成功'));
                exit;
            } else {
                $log -> customerLog(__LINE__.':隐藏竞拍活动失败，sql为：'.$sql."\r\n");
                echo json_encode(array('msg'=>'操作失败'));
                exit;
            }
        }
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}
