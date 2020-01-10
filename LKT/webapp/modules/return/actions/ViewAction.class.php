<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ViewAction extends Action
{


    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收信息
        $id = intval($request->getParameter("id")); // 产品id
        $lktlog = new LaiKeLogUtils("common/return.log");

        // 根据产品id，查询产品产品信息
        $sql = "select * from lkt_order_details where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $re_photo = !empty($r[0]->re_photo) ? unserialize($r[0]->re_photo):[];
        $imgs = [];
        if(!empty($re_photo)){
            foreach ($re_photo as $key => $value) {
                $imgs[] = ServerPath::getimgpath($value,$store_id);
            }
        }


        $rdata = [];
        $r_type = $r[0]->r_type;
        if ($r_type == 3) {
            $oid = $r[0]->id;
            $sqlo = "select * from lkt_return_goods where store_id = '$store_id' and oid = '$oid'";
            $ro = $db->select($sqlo);
            if($ro){
                  $rdata = (array)$ro[0];
            }
        }


        /*-----------进入订单详情把未读状态改成已读状态，已读状态的状态不变-------*/
        $sql01 = "select readd,a.id from lkt_order as a ,lkt_order_details AS m where a.store_id = '$store_id' and a.sNo = m.r_sNo and m.id = '$id'";
        $r01 = $db->select($sql01);
        if($r01){
            if ($r01[0]->readd == 0) {
                $id01 = $r01[0]->id;
                $sql02 = "update lkt_order set readd = 1 where store_id = '$store_id' and id = $id01";
                $up = $db->update($sql02);
                if ($up > 0) {
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单成功！");
                } else {
                    $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改订单失败！sql:" . $sql02);
                }
            }
        }
        /*--------------------------------------------------------------------------*/
//        var_dump($r);exit;

        $record = array();
        //查询售后记录
        $sel_sql = "select * from lkt_return_record where p_id = $id and store_id = $store_id";
        $record_res = $db->select($sel_sql);
        if(!empty($record_res)){
            foreach ($record_res as $k => $v){
                if($k<count($record_res)-1){
                    $record[$k] = $v;
                }
            }
        }

        $request->setAttribute("rdata", $rdata);
        $request->setAttribute("record", $record);
        $request->setAttribute("list", $r);
        $request->setAttribute("imgs", $imgs);
        return View :: INPUT;

    }


    public function execute()
    {

        $db = DBAction::getInstance();

        $request = $this->getContext()->getRequest();


        return;

    }


    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>