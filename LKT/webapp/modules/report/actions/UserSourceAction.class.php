<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/version.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class UserSourceAction extends Action{

	/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @date 2018年1月2日
     * @version 1.0
     */

	public function getDefaultView(){

		//初始化
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$admin_id = $this->getContext()->getStorage()->read('admin_id');
		$store_id = $this->getContext()->getStorage()->read('store_id');

		//接受参数
		$startdate = addslashes(trim($request->getParameter('startdate')));
		$enddate = addslashes(trim($request->getParameter('enddate')));

		//没有时间参数则设置为七天
		if(empty($startdate)||empty($enddate)){
			$enddate = date("Y-m-d");
			$startdate = date("Y-m-d",strtotime('-6 day'));
		}

		//根据时间查询总数---------------小程序
		$sql1 = "select COUNT(*) as sum from lkt_user where store_id = '{$store_id}' and source = 1 and Register_data between '{$startdate} 00:00:00'
		 and '{$enddate} 23:59:59'";
		$res1 = $db->select($sql1);
		$num_wx = $res1[0]->sum;
	   

		//根据时间查询总数---------------手机app
		$sql2 = "select COUNT(*) as sum from lkt_user where store_id = '{$store_id}' and source = 2 and Register_data between '{$startdate} 00:00:00'
		 and '{$enddate} 23:59:59'";
		$res2 = $db->select($sql2);
		$num_app = $res2[0]->sum;

		$request->setAttribute('num_wx',$num_wx);
		$request->setAttribute('num_app',$num_app);

		


		return View :: INPUT;
	}
	public function execute(){

	}
	public function getRequestMethods(){

		return Request :: NONE;
	}


}