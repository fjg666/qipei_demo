<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class ConfigAction extends Action
{

    /**
     * 页面渲染
     * @return string
     */
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $r = $db->select($sql);
        $day = 0;
        $hour = 0;
        $remind_day = 0;
        $remind_hour = 0;
        if ($r) {
            $order_failure = $r[0]->order_failure;
            $order_after = $r[0]->order_after;
            $auto_the_goods = $r[0]->auto_the_goods;
            $order_ship = $r[0]->order_ship;
            $remind = $r[0]->remind;
            $hour = $order_ship;
            if ($remind == 0) {
                $remind_day = 0;
                $remind_hour = 0;
            } else {
                $remind_day = floor($remind / 24);
                $remind_hour = $remind % 24;
            }
            if ($order_ship > 24) {
                $day = floor($order_ship / 24);
                $hour = $order_ship % 24;
            }

            if ($hour == 24) {
                $day = $day + 1;
                $hour = 0;
            }
        } else {
            $order_failure = 2;
            $order_after = 7;
            $auto_the_goods = 2;
        }
        $accesscode = $r ? $r[0]->accesscode : ''; // 顾客编码
        $checkword = $r ? $r[0]->checkword : ''; // 校验码
        $custid = $r ? $r[0]->custid : ''; // 月结卡号

        $request->setAttribute("auto_the_goods", $auto_the_goods);
        $request->setAttribute("order_failure", $order_failure);
        $request->setAttribute("order_after", $order_after);
        $request->setAttribute("day", $day);
        $request->setAttribute("hour", $hour);
        $request->setAttribute("remind_day", $remind_day);
        $request->setAttribute("remind_hour", $remind_hour);
        $request->setAttribute("accesscode", $accesscode);
        $request->setAttribute("checkword", $checkword);
        $request->setAttribute("custid", $custid);

        return View :: INPUT;
    }

    /**
     * post请求处理
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $auto_the_goods = trim($request->getParameter('auto_the_goods')); // 确认收货时间
        $order_failure = addslashes(trim($request->getParameter('order_failure'))); //订单过期删除时间
        $order_after = addslashes(trim($request->getParameter('order_after'))); //订单过期删除时间
        $remind_day = trim($request->getParameter('remind_day')); // 提醒限制
        $remind_hour = trim($request->getParameter('remind_hour')); // 提醒限制
        $sx_set = trim($request->getParameter('sx_set')); // 是否开启发货时间限制 1-开启 0-关闭
        $sx_day = trim($request->getParameter('sx-day')); // 发货时限单位：天
        $sx_hour = trim($request->getParameter('sx-hour')); // 发货时限单位：小时
        $accesscode = trim($request->getParameter('accesscode')); // 顾客编码
        $checkword = trim($request->getParameter('checkword')); // 校验码
        $custid = trim($request->getParameter('custid')); // 月结卡号
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        if ($auto_the_goods != '') {
            if (is_numeric($auto_the_goods)) {
                if ($auto_the_goods <= 0) {
                    echo json_encode(array("status" => '确认收货时间不能为负数或零!'));
                    exit;
                }
            } else {
                echo json_encode(array("status" => '确认收货时间请输入数字!'));
                exit;
            }
        }
        if ($order_failure != '') {
            if (is_numeric($order_failure)) {
                if ($order_failure <= 0) {
                    echo json_encode(array("status" => '订单过期删除时间不能为负数或零!'));
                    exit;
                }
            } else {
                echo json_encode(array("status" => '订单过期删除时间请输入数字!'));
                exit;
            }
        }
        if ($order_after != '') {
            if (is_numeric($order_after)) {
                if ($order_after <= 0) {
                    echo json_encode(array("status" => '订单售后时间不能为负数或零!'));
                    exit;
                }
            } else {
                echo json_encode(array("status" => '订单过期删除时间请输入数字!'));
                exit;
            }
        }
        if ($remind_day == '' || $remind_day == '0') {
            $remind_day = 0;
        } else {
            if ($remind_day < 0) {
                echo json_encode(array("status" => '请输入正确的提醒限制时间!'));
                exit;
            }
        }
        if ($remind_hour == '' || $remind_hour == '0') {
            $remind_hour = 0;
        } else {
            if ($remind_hour < 0) {
                echo json_encode(array("status" => '请输入正确的提醒限制时间!'));
                exit;
            }
        }
        if ($remind_day == 0 && $remind_hour == 0) {
            $remind = 0;
        } else {
            $remind = $remind_hour + ($remind_day * 24);
        }

        //如果开启限制
        if ($sx_set == '1') {
            if ($sx_day == '') {
                $sx_day = 0;
            }
            if ($sx_hour == '') {
                $sx_hour = 0;
            }
            $sx_hour = $sx_hour + ($sx_day * 24);
            if ($sx_hour == 0) {
                echo json_encode(array("status" => '请输入正确的发货限制时间!'));
                exit;
            }
        } else {
            $sx_hour = 0;
        }


        $sql = "select * from lkt_order_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $sql = "update lkt_order_config set order_failure = '$order_failure',order_after = '$order_after',auto_the_goods = '$auto_the_goods',order_ship = '$sx_hour',remind = '$remind',modify_date = CURRENT_TIMESTAMP,accesscode = '$accesscode',checkword = '$checkword',custid = '$custid' where store_id = '$store_id'";
            $r_1 = $db->update($sql);
            if ($r_1 == -1) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单设置失败！sql:" . $sql);
                $JurisdictionAction->admin_record($store_id, $admin_name, ' 修改订单设置失败 ', 2);
                echo json_encode(array("status" => '未知原因，订单设置修改失败！'));
                exit;
            } else {
                $JurisdictionAction->admin_record($store_id, $admin_name, ' 修改订单设置 ', 2);
                echo json_encode(array("status" => '订单设置修改成功！', 'suc' => '1'));
                exit;
            }
        } else {
            $sql = "insert into lkt_order_config(store_id,auto_the_goods,order_failure,order_after,modify_date,order_ship,remind,accesscode,checkword,custid) value('$store_id','$auto_the_goods','$order_failure','$order_after',CURRENT_TIMESTAMP,'$sx_hour','$remind','$accesscode','$checkword','$custid')";
            $r_1 = $db->insert($sql);
            if ($r_1 == -1) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加订单设置失败！sql:" . $sql);
                $JurisdictionAction->admin_record($store_id, $admin_name, ' 添加订单设置失败 ', 1);
                echo json_encode(array("status" => '未知原因，订单设置修改失败！'));
                exit;
            } else {
                $JurisdictionAction->admin_record($store_id, $admin_name, ' 添加订单设置 ', 1);
                echo json_encode(array("status" => '订单设置修改成功！', 'suc' => '1'));
                exit;
            }
        }
        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>