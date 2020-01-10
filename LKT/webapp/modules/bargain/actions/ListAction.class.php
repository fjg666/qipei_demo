<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class ListAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $goods_id = $request->getParameter('goods_id'); // 产品id
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $sql = "select l.*,c.* from lkt_bargain_goods as l right join lkt_configure as c on l.attr_id=c.id where l.goods_id=$goods_id and store_id = '$store_id'";
        $res = $db -> select($sql);
        
        $redsql = "select * from lkt_bargain_order where goods_id=$goods_id and store_id = '$store_id'";
        $resres = $db -> select($redsql);


        $request->setAttribute("list",$res);
        $request->setAttribute("record",$resres);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

    // 生成订单号
    private function order_number(){
        return date('Ymd',time()).time().rand(10,99);//18位
    }

}

?>