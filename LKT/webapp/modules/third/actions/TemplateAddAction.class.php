<?php

require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class TemplateAddAction extends Action{


	public function getDefaultView(){


	    $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
   

        //查询数据字典的所有模板行业
        $trade_arr = $this->getAllTrade();
      
        $request->setAttribute('trade_arr',$trade_arr);


		return View :: INPUT;
	}

	public function execute(){

        	$db = DBAction::getInstance();
            $request = $this->getContext()->getRequest();
          
            $title = addslashes(trim($request->getParameter('title')));
            $trade_data = addslashes(trim($request->getParameter('trade_data')));//对应的数据字典编码
            $img_url = addslashes(trim($request->getParameter('img_url')));
            $template_id = addslashes(trim($request->getParameter('template_id')));
            $lk_desc = addslashes(trim($request->getParameter('lk_desc')));
            $now = date("Y-m-d H:i:s");

            //切割图片路径
            if($img_url){
                $img_url = preg_replace('/.*\//','',$img_url);
            }

          
            $sql = "insert into lkt_third_template (title,trade_data,img_url,template_id,lk_desc,update_time) values ('$title','$trade_data','$img_url','$template_id','$lk_desc','$now')";
            $res = $db->insert($sql);
          

            if($res > 0){
            	echo json_encode(array('suc'=>1,'msg'=>'添加模板成功！'));
            	exit;
            }else{
            	echo json_encode(array('msg'=>'添加模板失败！'));
            	exit;
            }
    
        
	}

	public function getRequestMethods(){

		return Request :: POST;
	}

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