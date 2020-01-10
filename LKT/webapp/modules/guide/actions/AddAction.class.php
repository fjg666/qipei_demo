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
        $top_type = $this->getContext()->getStorage()->read('store_type');

        $request->setAttribute("store_type",$top_type);

		return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $top_type = $this->getContext()->getStorage()->read('store_type');
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/guide.log");
        // 1.开启事务
        $db->begin();
        // 接收数据 
        $image= addslashes($request->getParameter('image')); // 轮播图
        $type = addslashes(trim($request->getParameter('type'))); // 类型
        $sort = floatval(trim($request->getParameter('sort'))); // 排序

        if($top_type == 1){
            $type = 1;
        }

        if($image){
            $image = preg_replace('/.*\//','',$image);
        }else{
            echo json_encode(array('status' =>'引导图不能为空！' ));exit;
        }

        // 添加
        $sql = "insert into lkt_guide(store_id,image,source,type,sort,add_date) " .
            "values('$store_id','$image','$top_type','$type','$sort',CURRENT_TIMESTAMP)";
        $r = $db->insert($sql);
        if($r == -1){
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加引导图失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加引导图失败,类型为 '.$top_type;
            $lktlog->customerLog($Log_content);

            $db->rollback();

            echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加引导图',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加引导图成功,类型为 '.$top_type;
            $lktlog->customerLog($Log_content);

            $db->commit();

            echo json_encode(array('status' =>'添加成功！','suc'=>'1' ));exit;
        }
	    return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>