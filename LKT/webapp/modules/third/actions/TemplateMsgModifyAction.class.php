<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

/**
* <p>Copyright (c) 2019-2020</p>
* <p>Company: www.laiketui.com</p>
* @author 凌烨棣
* @content 小程序模板消息
* @date 2019年3月5日
* @version v2.2.1
*/

class TemplateMsgModifyAction extends Action
{

	public function getDefaultView(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();

		$id = addslashes(trim($request->getParameter('id')));

		$sql = "select * from lkt_notice_config where id = '$id'";
		$res = $db->select($sql);
       

        $request->setAttribute('res',$res[0]);


        return View :: INPUT;


	}

   

	public function execute(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();

		$m = addslashes(trim($request->getParameter('m')));//编辑或者删除

		$this->$m();



	}

	public function edit(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$admin_name = $this->getContext()->getStorage()->read('admin_name');
		

		$id = addslashes(trim($request->getParameter('id')));//主键id
		$c_name = addslashes(trim($request->getParameter('c_name')));//模板消息中文名称
		$e_name = addslashes(trim($request->getParameter('e_name')));//模板消息对应字段
		$stock_id = addslashes(trim($request->getParameter('stock_id')));//微信模板库id
		$stock_key = addslashes(trim($request->getParameter('stock_key')));//模板关键词列表

		$now_time = date("Y-m-d H:i:s");
		$sql = "update lkt_notice_config set c_name = '$c_name',e_name = '$e_name',stock_id = '$stock_id',stock_key = '$stock_key',update_time = '$now_time' where id = '$id'";
		$res = $db->update($sql);
		
		if($res > 0 ){

		    $db->admin_record(1,$admin_name,'修改模板消息'.$id.'成功！',5);
			echo json_encode(array('suc'=>1,'msg'=>'更新成功！'));
			exit;
		}else{

			$db->admin_record(1,$admin_name,'修改模板'.$id.'失败！',5);
			echo json_encode(array('msg'=>'更新失败！'));
			exit;
		}


	}

	public function del(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$admin_name = $this->getContext()->getStorage()->read('admin_name');
		$id = addslashes(trim($request->getParameter('id')));//主键id	

		$sql = "delete from lkt_notice_config where id = '$id'";
		$res = $db->delete($sql);
		
		if($res > 0){

			 $db->admin_record(1,$admin_name,'删除模板消息'.$id.'成功！',5);
			 echo json_encode(array('status'=>1,'info'=>'删除成功！'));
			 exit;
		}else{

			 $db->admin_record(1,$admin_name,'删除模板消息'.$id.'失败！',5);
			 echo json_encode(array('status'=>0,'info'=>'删除失败！'));
			 exit;
		}

	}

	public function getRequestMethods(){

        return Request :: POST;

	}


}