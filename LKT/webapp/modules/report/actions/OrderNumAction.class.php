<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/version.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class OrderNumAction extends Action{

	/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @date 2018年1月2日
     * @version 1.0
     */

	public function getDefaultView(){
		//初始化常用实例
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$store_id = $this->getContext()->getStorage()->read('store_id');
		$admin_id = $this->getContext()->getStorage()->read('admin_id');

		//接受参数
		$startdate = addslashes(trim($request->getParameter('startdate')));
		$enddate = addslashes(trim($request->getParameter('enddate')));

		//默认时间段为七天
		if(empty($startdate)||empty($enddate)){
			$enddate = date("Y-m-d");
			$startdate = date("Y-m-d",strtotime('-6 day'));

		}


		//获取日期数组
		$day_arr_1 = $this->getDateFromRange($startdate,$enddate);
		$day_arr = json_encode($day_arr_1);

		//查询订单总数,总成交额
		$sql = "select COUNT(*) as num ,SUM(z_price) as z_price from lkt_order where store_id = '$store_id' and add_time between '{$startdate} 00:00:00' and '{$enddate} 23:59:59'";
		$res_0 = $db->select($sql);

		$order_all = $res_0[0]->num;
		$z_price_all = $res_0[0]->z_price;
		

		//查询有效订单总数，有效成交额
		$sql_1 = "select COUNT(*) as num,SUM(z_price) as z_price from lkt_order where store_id = '$store_id' and add_time between '{$startdate} 00:00:00' and '{$enddate} 23:59:59' and status > 0 and status not in (0,4,7,11) and pay_time != ''";
		$res_1 = $db->select($sql_1);
		$order_valid = $res_1[0]->num;
		$z_price_valid = $res_1[0]->z_price;


	   	

		//按每天查询有效订单----有效订单数，有效金额
		$sql = "select COUNT(*) as num, SUM(z_price) as z_price,DATE_FORMAT(add_time,'%Y-%m-%d') as r_date from lkt_order where store_id = '$store_id' and status not in (0,4,7,11) and pay_time != '' group by r_date having r_date between '{$startdate}' and '{$enddate}'   order by r_date desc ";
		$res = $db->select($sql);
		

		//将没有订单的日期中的订单数置为0
		$sum_arr_0 = [];//

		//将没有订单总金额的日期中的订单总金额置为0
		$price_arr_0 = [];
 
		foreach($day_arr_1 as $k => $v){
			//将每个日期的订单数都置为零
			$sum_arr_0[$k] = 0;
			$price_arr_0[$k] = 0;
			
		}
		foreach($day_arr_1 as $k =>$v){
			foreach($res as $k1 => $v1){
				//如果有日期，则将该日期的num，z_price 返回
				if($v == ($v1->r_date)){
					$sum_arr_0[$k] = $v1->num;
					$price_arr_0[$k] = $v1->z_price;
				}
			}
		}
 	
		$sum_arr = json_encode($sum_arr_0);
		$price_arr = json_encode($price_arr_0);
		
		
		//分配模板变量
		$request->setAttribute('order_all',$order_all);
		$request->setAttribute('z_price_all',$z_price_all);
		$request->setAttribute('order_valid',$order_valid);
		$request->setAttribute('z_price_valid',$z_price_valid);



		$request->setAttribute('day_arr',$day_arr);
		$request->setAttribute('sum_arr',$sum_arr);
		$request->setAttribute('price_arr',$price_arr);

		



		return View :: INPUT;
	}
	public function execute(){

	}
	public function getRequestMethods(){

		return Request :: POST;
	}

	//获取日期之间的天数

	 /**
	 * 获取指定日期段内每一天的日期
	 * @parm  Date  $startdate 开始日期
	 * @parm  Date  $enddate   结束日期
	 * @  Array
	 */
    public function getDateFromRange($startdate, $enddate){

        $stimestamp = strtotime($startdate);
        $etimestamp = strtotime($enddate);

        // 计算日期段内有多少天
        $days = ($etimestamp-$stimestamp)/86400+1;

        // 保存每天日期
        $date = array();

        for($i=0; $i<$days; $i++){
            $date[] = date('Y-m-d', $stimestamp+(86400*$i));
        }

        return $date;
    }


}