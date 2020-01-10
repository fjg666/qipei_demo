<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class TemplateAction extends Action{


	/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 小程序模板管理页接口
     * @date 2019年3月5日
     * @version v2.2.1
     */
	public function getDefaultView(){
        
		$db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $trade_data = addslashes(trim($request->getParameter('trade_data')));//行业
        $is_use = addslashes(trim($request->getParameter('is_use')));//是否应用
        $title = addslashes(trim($request->getParameter('title')));//模板名称

        //分页参数
        $pagesize = addslashes(trim($request->getParameter('pagesize')));//每页多少数据
        $page = addslashes(trim($request->getParameter('page')));//页码

        $pagesize = $pagesize ? $pagesize : 10;
        if($page){
        	
        	$start = ($page-1)*$pagesize;
        }else{
        	$page = 1;
        	$start = 0;
        }

        //初始化查询条件
        $condition = " 1 = 1 ";
        if($trade_data){
        	$condition .= " and trade_data = '$trade_data' ";
        }

   
        if($is_use || $is_use === '0'){//
        	$condition .= " and is_use = '$is_use' "; 
        	
        }
        if($title){
        	$condition .= " and title = '%$title%' ";
        }

        //总记录数
        $sql = "select COUNT(*) as num from lkt_third_template where ".$condition;
        $res = $db->select($sql);

        $total = $res[0]->num;

        //实例化分页类
        $showpager = new ShowPager($total,$pagesize,$page);
        $offset = $showpager -> offset;


        $sql = "select * from lkt_third_template where ".$condition." order by id desc limit $offset,$pagesize ";
        $res = $db->select($sql);
   

        if($res){

        	foreach($res as $k => $v){
        		
        		$v->image = ServerPath::getimgpath($v->img_url,1); 
                $v->trade_text = $this->getTrade($v->trade_data);

        	}
        } 



		$url="index.php?module=third&action=Template&trade_data=".urlencode($trade_data)."&is_use=".urlencode($is_use)."&title=".urlencode($title);	
		$pages_show = $showpager->multipage($url,$total,$page,$pagesize,$start,$para='');


        //获取所有的模板行业
        $res_trade = $this->getAllTrade();

		$request->setAttribute('res_trade',$res_trade);
        $request->setAttribute('res',$res);
		$request->setAttribute('trade_data',$trade_data);
		$request->setAttribute('is_use',$is_use);
		$request->setAttribute('title',$title);
		$request->setAttribute('num',$total);
		$request->setAttribute('pages_show',$pages_show);
        
        return View :: INPUT; 




	}

	public function execute(){

	    $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $id = addslashes(trim($request->getParameter('id')));
        $is_use = addslashes(trim($request->getParameter('is_use')));

        //is_use = 1  停用
        if($is_use == 1){

        	$sql_1 = "update lkt_third_template set is_use = 0 where  id = '$id'";
			    
		    $res_1 = $db->update($sql_1);
		    if($res_1 > 0){
		    	echo json_encode(array('suc'=>1,'msg'=>'停用模板成功！'));
		    	exit;
		    }else{
		    	echo json_encode(array('msg'=>'停用模板失败！'));
		    	exit;
		    }
        }else{

        	$sql_2 = "update lkt_third_template set is_use = 1 where   id = '$id'";
        	$res_2 = $db->update($sql_2);

        	if($res_2 > 0){
        		echo json_encode(array('suc'=>1,'msg'=>'启用模板成功！'));
        		exit;
        	}else{
        		echo json_encode(array('msg'=>'启用模板失败！'));
        		exit;
        	}
        }
       

	}

	public function getRequestMethods(){

		return Request :: POST;
	}

    //获取选中的小程序模板行业文字内容
    private function getTrade($code){
        
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $sql = "select code,value from lkt_data_dictionary where recycle = 0 and status = 1 and code = '$code'";
        $res = $db->select($sql);
        
        if($res){
            $value =$res[0]->value;
            $value_arr = explode(',', $value);
            $trade_text = $value_arr[1];
            return $trade_text;
        }else{
            return false;
        }
    }


    //获取数据字典中的全部行业数据
    private function getAllTrade(){


        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
   

        //查询数据字典的模板行业
        $sql_data = "select code,value from lkt_data_dictionary where name = '小程序模板行业' and status = 1 and recycle = 0";
        $res_data = $db->select($sql_data);

        $trade_arr = array();
        if($res_data){

            foreach($res_data as $k => $v){

                $value = $v->value;//键,值
                $value_arr = explode(',',$value);

                $my_obj = new stdClass();
                $my_obj->trade_text = $value_arr[1];//显示的行业
                $my_obj->trade_code = $v->code;//对应数据编码

                $trade_arr[$k] = $my_obj;

            }

        }  
        return $trade_arr;
    }
}