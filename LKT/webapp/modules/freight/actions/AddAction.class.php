<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

		return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/freight.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收数据
        $name = addslashes(trim($request->getParameter('name'))); // 规则名称
        $type = addslashes(trim($request->getParameter('type'))); // 类型
        $hidden_freight = $request->getParameter('hidden_freight'); // 运费信息

        if($hidden_freight){
            $freight_list = json_decode($hidden_freight,true);
            if(empty($freight_list)){
               echo json_encode(array('status' =>'运费规则不能为空！' ));exit;
            }
            $freight = serialize($freight_list);
        }else{
            echo json_encode(array('status' =>'运费规则不能为空！' ));exit;
        }

		if($name == ''){
			echo json_encode(array('status' =>'规则名称不能为空！' ));exit;
        }else{
            $sql = "select * from lkt_freight where store_id = '$store_id' and name '$name'";
            $r = $db->select($sql);
            if($r){
                echo json_encode(array('status' =>"规则名称{$name}已经存在，请选用其他名称！" ));exit;
            }
        }

        // 添加规则
        $sql = "insert into lkt_freight(store_id,name,type,freight,is_default,add_time) values('$store_id','$name','$type','$freight',0,CURRENT_TIMESTAMP)";
		$rr = $db->insert($sql);
        if($rr > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,' 添加规则 '.$name.'成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加规则成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

			echo json_encode(array('status' =>'规则添加成功！','suc'=>'1'));exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,' 添加规则失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加规则失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

			echo json_encode(array('status' =>'未知原因，规则添加失败！' ));exit;
        }
	    return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>