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
class CloseAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();

        return View :: INPUT;

    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $lktlog = new LaiKeLogUtils("common/orderslist.log");

        $db->begin();
        $request = $this->getContext()->getRequest();
        $oid = trim($request->getParameter('oid'));
        $sql1 = "update lkt_order_details set r_status = 6 where store_id = '$store_id' and r_sNo = '$oid'";
        $res1 = $db->update($sql1);
        if (!$res1) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单详情失败！sql:" . $sql1);
            $db->rollback();
            echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
            exit;
        }

        $sql2 = "update lkt_order set status = 6 where store_id = '$store_id' and sNo = '$oid'";
        $res2 = $db->update($sql2);

        if (!$res2) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "关闭订单失败！sql:" . $sql2);
            $db->rollback();
            echo json_encode(array('status' => 0, 'msg' => '操作失败！'));
            exit;
        }

        $event = 'Admin取消订单号为' . $oid . '的订单';
        $sql = "insert into lkt_record (store_id,user_id,money,oldmoney,add_date,event,type) values('$store_id','Admin','0','0',CURRENT_TIMESTAMP,'$event',23)";
        $ist_res = $db->insert($sql);

        $sql3 = "select p_id,num,sid from lkt_order_details where store_id = '$store_id' and r_sNo = '$oid'";
        $r3 = $db->select($sql3);
        if ($r3) {
            $p_id = $r3[0]->p_id;
            $num = $r3[0]->num;
            $sid = $r3[0]->sid;

            $sql4 = "update lkt_product_list set num = num + '$num' where store_id = '$store_id' and id = '$p_id'";
            $res_4 = $db->update($sql4);
            if($res_4 < 1){
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改商品库存失败！sql:" . $sql4);
            }
            $sql5 = "update lkt_configure set num = num + '$num' where id = '$sid'";
            $res_5 = $db->update($sql5);
            if($res_5 < 1){
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改商品规格库存失败！sql:" . $sql5);
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