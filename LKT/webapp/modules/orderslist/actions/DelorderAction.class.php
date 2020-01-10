<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class DelorderAction extends Action
{


    public function getDefaultView()
    {
        return View :: INPUT;
    }


    /**
     * post请求处理
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $ids = trim($request->getParameter('ids'));
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        $sql = "select id,drawid,sNo,ptcode,pid from lkt_order where store_id = '$store_id' and id in ($ids)";

        $res = $db->select($sql);

        $gcode = $db->select("select status from lkt_group_buy where store_id = '$store_id' and status=(select status from lkt_group_buy where is_show=1)");

        $gid = !empty($gcode) ? $gcode[0]->status : 1;

        $group = array();

        foreach ($res as $k => $v) {                //过滤掉还没结束的拼团订单，和还没得到结果的抽奖订单

            if ($gid == $v->pid) {

                $group[] = $v->sNo;

                unset($res[$k]);

            }

            if (in_array($v->lottery_status, array(0, 1, 2, 4)) && $v->lottery_status !== null) {    //过滤还没出结果的抽奖订单

                $draw[] = $v->sNo;

                unset($res[$k]);

            }


        }

        $msg = '删除了 ' . count($res) . ' 笔订单';

        if (!empty($group)) {

            $msg .= ',已保留了 ' . count($group) . ' 笔活动未结束的拼团订单';

        }


        foreach ($res as $key => $value) {

            $sql_1 = "update lkt_order set status = 6 where sNo='$value->sNo'";
            $delo = $db->update($sql_1);

            if($delo < 1){
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单失败！sql:" . $sql_1);
            }
            $sql_2 = "update lkt_order_details set r_status = 6 where r_sNo='$value->sNo'";
            $deld = $db->update($sql_2);
            if($deld < 1){
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单详情失败！sql:" . $sql_2);
            }
            $sql_3 = "delete from lkt_group_open where ptcode='$value->ptcode'";
            $delg = $db->delete($sql_3);
        }

        echo json_encode(array('code' => 1, 'msg' => $msg));
        exit;

    }


    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>