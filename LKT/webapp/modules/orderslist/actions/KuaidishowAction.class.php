<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/third/logistics/LogisticsTool.class.php');

class KuaidishowAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 获取信息
        $r_sNo = trim($request->getParameter('r_sNo'));// 订单详情id
        // 根据订单详情id,修改订单详情

        $sql = "select express_id,courier_num from lkt_order_details where r_sNo = '$r_sNo'";
        $r = $db->select($sql);
        $list = array();
        if(!empty($r)){
            foreach ($r as $k => $v){
                if (!empty($v->express_id) && !empty($v->courier_num)) {
                    $express_id = $v->express_id;//快递公司ID
                    $courier_num = $v->courier_num;//快递单号
                    $sql01 = "select * from lkt_express where id = '$express_id'";
                    $r01 = $db->select($sql01);
                    $type = $r01[0]->type;//快递公司代码
                    $kuaidi_name = $r01[0]->kuaidi_name;//快递公司名字
                    $res_1 = LogisticsTool::getLogistics($type, $courier_num);
                    if (empty($res_1)) {
                        $res = array('code' => 0,'courier_num'=>$courier_num,'kuaidi_name'=>$kuaidi_name, 'data' => array());
                    } else {
                        $res = array('code' => 1,'courier_num'=>$courier_num,'kuaidi_name'=>$kuaidi_name, 'data' => $res_1);
                    }
                } else {
                    $res = array('code' => 0, 'data' => array());
                }
                $list['list'][$k] = $res;
            }
        }
        if(empty($list)){
            $list['code'] = 0;
        }else{
            $list['code'] = 1;
        }
        echo json_encode($list);
        exit;
    }

    public function execute()
    {
        $this->getDefaultView();
    }

    public function getRequestMethods()
    {
        return Request::POST;
    }

}

?>