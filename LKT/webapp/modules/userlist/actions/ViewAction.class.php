<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');

class ViewAction extends Action {

	public function getDefaultView() {

                $db = DBAction::getInstance();
                $request = $this->getContext()->getRequest();
                $store_id = $this->getContext()->getStorage()->read('store_id');

                $id = $request->getParameter("id"); 
                $sql = "select * from lkt_user where store_id = '$store_id' and user_id = '$id'";
                $r = $db->select($sql);
               
                if(!$r){
        	        $sql = "select * from lkt_user where store_id = '$store_id' and id = '$id'";
        	        $r = $db->select($sql);
                }
                //获取用户密码的明文

                $mima  = $r[0]->mima;
                if($mima){
                     $mima = $db->unlock_url($mima);
                    $r[0]->mima_1 = $mima;
                }
               

                 //该用户有效订单数
                $sql_1 = "select id from lkt_order where store_id = '$store_id' and user_id='$id' and status > 0 and status not in (4,7,11) and pay_time != ''";
                $res_1 = $db->selectrow($sql_1);
                $r[0]->z_num = $res_1;

                //该用户交易金额
                $sql_2 = "select SUM(z_price) as z_price from lkt_order where store_id = '$store_id' and user_id='$id' and status > 0 and status not in (4,7,11) and pay_time != ''";
                $res_2 = $db->select($sql_2);

                //查询用户会员等级
                $grade = $r[0]->grade;
                $sql_3 = "select name,rate from lkt_user_grade where store_id = '$store_id' and id = '$grade'";
                $res_3 = $db->select($sql_3);
                if($res_3){
                    $r[0]->grade = $res_3[0]->name;
                    $r[0]->rate = $res_3[0]->rate;
                }else{
                    $r[0]->grade = '普通会员';
                    $r[0]->rate = '暂无折扣';
                }

                if(empty($res_2[0]->z_price)){
                        
                        $r[0]->z_price = 0;
                        
                }else{
                        
                        $r[0]->z_price = $res_2[0]->z_price;
                }
                $request->setAttribute('user', $r);

                return View :: INPUT;

	}



	public function execute(){
		
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>