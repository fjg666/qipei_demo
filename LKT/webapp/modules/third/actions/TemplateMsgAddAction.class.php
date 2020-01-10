<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');



/**
* <p>Copyright (c) 2019-2020</p>
* <p>Company: www.laiketui.com</p>
* @author 凌烨棣
* @content 小程序模板消息ID生成接口
* @date 2019年3月5日
* @version v2.2.1
*/


class TemplateMsgAddAction extends Action
{
	public function getDefaultView(){

		$db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();



        


		return View :: INPUT;
	} 

	public function execute(){


		$db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $c_name = addslashes(trim($request->getParameter('c_name')));//中文名称
        $e_name = addslashes(trim($request->getParameter('e_name')));//模板消息对应字段
        $stock_id = addslashes(trim($request->getParameter('stock_id')));//微信模板库id
        $stock_key = addslashes(trim($request->getParameter('stock_key')));//模板关键词列表
        

        $now_time = date("Y-m-d H:i:s");//
        $sql = "insert into lkt_notice_config (c_name,e_name,stock_id,stock_key,update_time) values ('$c_name','$e_name','$stock_id','$stock_key','$now_time')";
        $res = $db->insert($sql);
        
        if($res > 0){
            echo json_encode(array('suc'=>1,'msg'=>'添加模板消息配置成功！'));
            exit;
        }else{
            echo json_encode(array('msg'=>'添加模板消息配置失败！'));
            exit;
        }

    


	}

	
	public function getRequestMethods(){

		return Request :: POST;
	}
}