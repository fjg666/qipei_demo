<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */


class UserConsumeAction extends Action{

	/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @date 2018年1月2日
     * @version 1.0
     */

	public function getDefaultView(){
		//初始化
		$db=DBAction::getInstance();
		$request=$this->getContext()->getRequest();
		$admin_name=$this->getContext()->getStorage()->read('admin_name');
		$store_id=$this->getContext()->getStorage()->read('store_id');
		  $title = $request->getParameter("title"); // 分类id
        $title1 = $request->getParameter("title1"); // 分类id
		//接收分页查询的条件
		$name=addslashes(trim($request->getParameter('name')));
		$source=addslashes(trim($request->getParameter('source')));
		$startdate=addslashes(trim($request->getParameter('startdate')));
		$enddate=addslashes(trim($request->getParameter('enddate')));
		
		// die;
		//接收导出excel的参数数据
		$pageto=addslashes(trim($request->getParameter('pageto')));
		//接受分页类需要的参数
		$page=$request->getParameter('page');//页码
		$pagesize=$request->getParameter('pagesize');//每页个数
		

	    //初始化分页查询条件
	    $condition=" and a.store_id = '$store_id' and b.store_id = '$store_id' ";

	    if($name!=''){
	    	$condition.="and a.user_name like '%{$name}%'";
	    }
	    if($source!= 0){
	    	$condition.="and a.source = '$source'";
	    }
	    if($startdate!=''){
	    	$condition.="and a.Register_data >= '$startdate'";
	    }
	    if($enddate!=''){
	    	$condition.="and a.Register_data <= '$enddate'";
	    }


	   //初始化分页类
		$sql="select a.id  from lkt_user  as a INNER JOIN lkt_order as b on a.user_id = b.user_id".$condition."group by a.user_id";
		$total=$db->selectrow($sql);
		//var_dump($sql,$total);
		//$total=intval($total[0]->total);//总数
		if($page){
			$start=($page-1)*10;
		}else{
			$page=1;
			$start=0;
		}//页码和开始位置
		$pagesize = $pagesize ? $pagesize : 10;
		

		$showpager=new ShowPager($total,$pagesize,$page);
		$offset=$showpager -> offset;//设置开始查询位置
	  

	    //根据是否有导出数据，进行查询
	    //a.user_id,a.user_name,b.z_price,b.订单数量，b.退款数量
	    if($pageto != 'all'){
	    	$sql="select a.id ,a.user_id ,a.user_name , a.source,SUM(b.z_price) as z_price ,COUNT(b.id) as num from lkt_user as a INNER JOIN lkt_order as b on a.user_id = b.user_id".
	    		$condition."group by b.user_id order by z_price desc limit $offset,$pagesize";
	    		 $res=$db->select($sql);
	    		  
	    }else{
	    	$sql="select a.id ,a.user_id ,a.user_name,a.source ,SUM(b.z_price) as z_price ,COUNT(b.id) as num from lkt_user as a INNER JOIN lkt_order as b on a.user_id = b.user_id".
	    		$condition."group by b.user_id order by z_price desc ";
	    		$db->admin_record($store_id,$admin_name,'导出全部用户消费数据报表',4);
	    		 $res=$db->select($sql);

	    }
	 
      
	    //通过foreach计算每个用户的退款数，及退款总金额
	    	foreach ($res as $k => $v) {
	    		$user_id=$v->user_id;
	    		$sql1="select COUNT(id) as back_num,COUNT(money) as back_z_price from lkt_record where store_id = '$store_id' and user_id = '$user_id' and type = 5";
	    		$res1=$db->select($sql1);
	    		//判断是否存在退货商品
	    		if(empty($res1)){
	    		 	$res[$k]->back_num = 0;
	    		 	$res[$k]->back_z_price = 0;
	    		 	$res[$k]->real_num = $v->num;
	    		 	$res[$k]->real_z_price = $v->z_price;
	    	    }else{

	    	    	$res[$k]->back_num = $res1[0]->back_num;
	    	    	$res[$k]->back_z_price = $res1[0]->back_z_price;
	    	    	$res[$k]->real_num = intval($v->num)-$res1[0]->back_num;
	    	    	$res[$k]->real_z_price = bcsub($v->z_price, $res1[0]->back_z_price,2);
	    	    }
	    	}
	    	//返回分页类的分页内容
	    	$url="index.php?module=report&action=UserConsume&name=".urlencode($name)."&source=".urlencode($source)."&startdate="
	    	     .urlencode($startdate)."&enddate=".urlencode($enddate);
	    	$pages_show=$showpager->multipage($url,$total,$page,$pagesize,$start,$para=''); 
	    	// echo '<pre>';
	    	// var_dump($res,$pages_show);
	    	// die;

	    	//分配模板变量
	    	$request -> setAttribute('pageto',$pageto);
	    	$request -> setAttribute('name',$name);
	    	$request -> setAttribute('source',$source);
	    	$request -> setAttribute('startdate',$startdate);
	    	$request -> setAttribute('enddate',$enddate);
	    	$request -> setAttribute('res',$res);
	    	$request -> setAttribute('pages_show',$pages_show);
	    	

	    	$request->setAttribute("title",$title);
            $request->setAttribute("title1",$title1);


		return View :: INPUT;
	}

	public function execute(){

	}
	public function getRequestMethods(){
		return Request :: NONE;
	}
}