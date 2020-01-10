<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');

class SeeAction extends Action {

	public function getDefaultView() {

                $db = DBAction::getInstance();
                $request = $this->getContext()->getRequest();
                $store_id = $this->getContext()->getStorage()->read('store_id');

                $id = $request->getParameter("id"); 
                $sql = "select a.user_name,a.headimgurl,a.Register_data,a.mobile,b.* from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and a.id = '$id'";
                $user = $db->select($sql);
                
                if(!$user){
        	        $sql = "select a.user_name,a.headimgurl,a.Register_data,a.mobile,b.* from lkt_user a left join lkt_user_distribution b on a.user_id=b.user_id where a.store_id = '$store_id' and a.user_id = '$id'";
        	        $user = $db->select($sql);
                }
                //推荐人昵称
                if ($user[0]->pid) {
                        $p = "select user_name from lkt_user where store_id = '$store_id' and user_id = '".$user[0]->pid."'";
                        $pr = $db->select($p);
                        $user[0]->p_name = !empty($pr)?$pr[0]->user_name:'未设置';
                }else{
                        $user[0]->pid = '总店';
                        $user[0]->p_name = '总店';
                }
                //分销等级
                $l = "select sets from lkt_distribution_grade where store_id = '$store_id' and id='".$user[0]->level."'";
                $lr = $db->select($l);
                $sets = unserialize($lr[0]->sets);
                $user[0]->levelname = $sets['s_dengjiname']?$sets['s_dengjiname']:'默认等级';
                //预计佣金
                $sql44 = "select sum(a.money) as yjyj from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.type=1 and a.status=0 and a.user_id='$id' and b.status in (1,2,3,5,7)";
                $yjyj = $db->select($sql44);
                $user[0]->yjyj = $yjyj[0]->yjyj?number_format($yjyj[0]->yjyj,2):'0.00';
                //累计佣金
                $sql33 = "select sum(a.money) as ljyj from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.type=1 and a.user_id='$id' and a.status=1 and b.status in (1,2,3,5,7)";
                $ljyj = $db->select($sql33);
                $user[0]->ljyj = $ljyj[0]->ljyj?number_format($ljyj[0]->ljyj,2):'0.00';

                $request->setAttribute('user', $user);

                return View :: INPUT;

	}



	public function execute(){
	       return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>