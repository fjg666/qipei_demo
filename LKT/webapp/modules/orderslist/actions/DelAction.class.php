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
class DelAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();

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
        $data = $request->getParameter('data');
        $orders = explode(',', substr($data, 0, strlen($data) - 1));
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        $db->begin();
        foreach ($orders as $key => $value) {
            $sql1 = "update lkt_order_details set r_status = 8 where store_id = '$store_id' and r_sNo = '$value'";
            $res1 = $db->update($sql1);
            if (!$res1) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单详情状态！sql:" . $sql1);
                $db->rollback();
                echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
                exit;
            }

            $sql2 = "update lkt_order set status = 8  where store_id = '$store_id' and sNo = '$value'";
            $res2 = $db->update($sql2);
            if (!$res2) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单状态！sql:" . $sql2);
                $db->rollback();
                echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
                exit;
            }
        }
        $db->commit();
        echo json_encode(array('status' => 1, 'msg' => '操作成功！'));
        exit;
    }

    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>