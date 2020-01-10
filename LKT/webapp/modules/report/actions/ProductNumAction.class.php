<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/version.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */


class ProductNumAction extends Action{

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
		
		//接受参数
		$startdate = addslashes(trim($request->getParameter('startdate')));
		$enddate = addslashes(trim($request->getParameter('enddate')));
		
		//1.平台所有上架商品数量
		$sql = "select COUNT(*) as num from lkt_product_list where status = 2 and store_id = '$store_id'";
		$res = $db->select($sql);

		if($res){
			$product_num = $res[0]->num;
		}

		//2.平台对接商家数量
		
		$sql = "select COUNT(id) as c_num from lkt_mch where store_id = '$store_id'";
		$res = $db->select($sql);

		if($res){
			$customer_num = $res[0]->c_num;
		}

		//3.前十商品销售排行

		$sql_top = "select id,product_title,volume from lkt_product_list where store_id = '$store_id' order by volume desc limit 10";
		$res_top = $db->select($sql_top);
   
        if($res_top){

        
		
        	if(@$res_top[0]){

        		$res_top_title_0 = $res_top[0]->product_title;
			    $res_top_volume_0 = $res_top[0]->volume;

			    $request->setAttribute('res_top_title_0',$res_top_title_0);//前十销量排行
			    $request->setAttribute('res_top_volume_0',$res_top_volume_0);
	   

        	}
			
        	if(@$res_top[1]){

        		$res_top_title_1 = $res_top[1]->product_title;
				$res_top_volume_1 = $res_top[1]->volume;

				 $request->setAttribute('res_top_title_1',$res_top_title_1);
				 $request->setAttribute('res_top_volume_1',$res_top_volume_1);
        	}
	 
			if(@$res_top[2]){
        		$res_top_title_2 = $res_top[2]->product_title;
				$res_top_volume_2 = $res_top[2]->volume;

				$request->setAttribute('res_top_title_2',$res_top_title_2);
				$request->setAttribute('res_top_volume_2',$res_top_volume_2);
        	}
			

			if(@$res_top[3]){
        		$res_top_title_3 = $res_top[3]->product_title;
				$res_top_volume_3 = $res_top[3]->volume;

				$request->setAttribute('res_top_title_3',$res_top_title_3);
				$request->setAttribute('res_top_volume_3',$res_top_volume_3);
        	}
			

	   
	   
	    
	   
	    
	   
	    
	    
	    
			if(@$res_top[4]){
        		$res_top_title_4 = $res_top[4]->product_title;
				$res_top_volume_4 = $res_top[4]->volume;

				$request->setAttribute('res_top_title_4',$res_top_title_4);
				$request->setAttribute('res_top_volume_4',$res_top_volume_4);
        	}
			

			if(@$res_top[5]){
        		$res_top_title_5 = $res_top[5]->product_title;
				$res_top_volume_5 = $res_top[5]->volume;

				$request->setAttribute('res_top_title_5',$res_top_title_5);
				$request->setAttribute('res_top_volume_5',$res_top_volume_5);
        	}
			

			if(@$res_top[6]){
        		$res_top_title_6 = $res_top[6]->product_title;
				$res_top_volume_6 = $res_top[6]->volume;

				$request->setAttribute('res_top_title_6',$res_top_title_6);
				$request->setAttribute('res_top_volume_6',$res_top_volume_6);
        	}
			

			if(@$res_top[7]){
        		$res_top_title_7 = $res_top[7]->product_title;
				$res_top_volume_7 = $res_top[7]->volume;

				$request->setAttribute('res_top_title_7',$res_top_title_7);
				$request->setAttribute('res_top_volume_7',$res_top_volume_7);
        	}
			

			if(@$res_top[8]){
        		$res_top_title_8 = $res_top[8]->product_title;
				$res_top_volume_8 = $res_top[8]->volume;

				$request->setAttribute('res_top_title_8',$res_top_title_8);
				$request->setAttribute('res_top_volume_8',$res_top_volume_8);
        	}
			

			if(@$res_top[9]){
        		$res_top_title_9 = $res_top[9]->product_title;
				$res_top_volume_9 = $res_top[9]->volume;

			    $request->setAttribute('res_top_title_9',$res_top_title_9);
			    $request->setAttribute('res_top_volume_9',$res_top_volume_9);
        	}
			

        }
		

		//4.库存预警的商品

		
		$page = $request -> getParameter('page');//分页显示
		$pagesize = $request->getParameter('pagesize');

		$pagesize = $pagesize ? $pagesize : 10;
		if($page){
			$start = ($page-1)*$pagesize;
		}else{
			$start = 0;
			$page = 1;
		}

		$sql_total = "select COUNT(*) as total from lkt_configure as c left join lkt_product_list as a on c.pid = a.id left join (select max(add_date) as add_date,type,attribute_id from lkt_stock where type = 2 group by attribute_id) as b on c.id = b.attribute_id where a.store_id = '$store_id' and a.recycle = 0 and c.num <= a.min_inventory";
		$res_total = $db->select($sql_total);
		if($res_total){
			$total = $res_total[0]->total;//总记录数
		}


		
		
        $showpager=new ShowPager($total,$pagesize,$page);//初始化分页类
		$offset=$showpager -> offset;//设置开始查询位置



	    $sql_stock = "select a.product_number,a.product_title,c.img,c.attribute,c.total_num,c.num,b.add_date from lkt_configure as c left join lkt_product_list as a on c.pid = a.id left join (select max(add_date) as add_date ,type ,attribute_id from lkt_stock where type = 2 group by attribute_id ) as b on c.id = b.attribute_id where a.store_id = '$store_id' and a.recycle = 0 and c.num <= a.min_inventory limit $offset,$pagesize";
	    $res_stock = $db->select($sql_stock);
	    if($res_stock){
	    	
	    	foreach($res_stock as $k => $v){

	    		$v->image = ServerPath::getimgpath($v->img,$store_id);
	    		$attribute = unserialize($v->attribute);
	    		$specifications = '';
                foreach ($attribute as $ke => $va){
                    $specifications .= $ke .':'.$va.',';
                }
                $v->specifications = rtrim($specifications, ",");
	    	}

	    }
	   

	    $url = 'index.php?module=report&action=product_num';
	    $pages_show = $showpager->multipage($url,$total,$page,$pagesize,$start,$para='');


	    //5.商品库存量统计(按一级商品分类)  

	    $sql_class = "select pname,cid from lkt_product_class where store_id = '$store_id' and level = 0 and recycle = 0 order by cid desc";
	    $res_class = $db->select($sql_class); 
	    
	 	
	 	//5.1 入库量	
	    $sql = "select a.product_id,SUM(flowing_num) as all_num,b.product_class,a.type from lkt_stock as a left join lkt_product_list as b on a.product_id = b.id  where a.store_id = '$store_id' and b.store_id = '$store_id' and b.recycle = 0 and a.type = 0 group by a.product_id";
	    $res = $db->select($sql); //入库量

	   
	    $class_arr = array();
	  
	    if($res){
	    	foreach($res as $k => $v){
	    		if(!empty($v->product_class)){
	    			  $class_arr = explode('-',$v->product_class);
	    	         $v->class = $class_arr[1];  //改商品的顶级分类
	    		}else{
	    			$v->class = '';
	    		}
	    	   

	    	}
	    }


	   

	    if($res_class){

	    	foreach($res_class as $k => $v){
	    		$cid = $v->cid;
	    		$pname = $v->pname;
	    		$v->num_in = 0;

	    		foreach($res as $k1 => $v1){
	    			if($cid == $v1->class){

	    				$v->num_in += $v1->all_num;//顶级分类下入库量

	    			}
	    		}
	        }
	    }
	 	
	    
	    //5.2出库量
	    $sql_0 = "select a.product_id,SUM(flowing_num) as all_num,b.product_class,a.type from lkt_stock as a left join lkt_product_list as b on a.product_id = b.id  where a.store_id = '$store_id' and b.store_id = '$store_id' and b.recycle = 0 and a.type = 1 group by a.product_id";
	    $res_0 = $db->select($sql_0);
	   
	   
	    if($res_0){

	    	foreach($res_0 as $k => $v){
	    		$class_arr = explode('-', $v->product_class);
	    		$v->class = $class_arr[1];//顶级分类id

	    	}
	    }
       

	    if($res_class){

	    	foreach($res_class as $k => $v){
	    		
	    		$pname = $v->pname;
	    		$cid = $v->cid;
	    		$v->num_out = 0;
	    		foreach($res_0 as $k1 => $v1){
	    			if($cid == $v1->class){

	    				$v->num_out += $v1->all_num;//顶级分类下出库量
	    			}
	    		}
	    	}
	    } 

	   //5.3剩余库存量
	    $sql_have = "select id,product_class,num from lkt_product_list where store_id = '$store_id' and recycle = 0 ";
	    $res_have = $db->select($sql_have);

	    if($res_have){

	    	foreach($res_have as $k => $v){
	    		if($v->product_class){
	    			$class_arr_0 = explode('-', $v->product_class);
	    			$v->class = $class_arr_0[1];//顶级分类id
	    		}else{
	    			$v->class = '';
	    		}
	    		
	    	}
	    }

	    if($res_class){

	    	foreach($res_class as $k => $v){

	    		$cid = $v->cid;
	    		$v->num = 0;//剩余库存
	    		foreach($res_have as $k1 => $v1){
	    			if($cid == $v1->class){

	    				$v->num += $v1->num;//顶级分类下，商品剩余库存 
	    			}
	    		} 
	    	}
	    }
	    $in_out = json_encode($res_class);


	    $request->setAttribute('product_num',$product_num);//上架商品数量
	    $request->setAttribute('customer_num',$customer_num);//商户数量
	     
	    $request->setAttribute('res_stock',$res_stock);//库存预警商品
	    $request->setAttribute('in_out',$in_out);//库存预警商品

	    //


		
		
		return View :: INPUT;
	}
	public function execute(){

	}
	public function getRequestMethods(){

		return Request :: POST; 
	}

}