<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');

class addAction extends Action {

	public function getDefaultView() {
		return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收数据 
        $color_name = addslashes(trim($request->getParameter('color_name')));
        $color = addslashes(trim($request->getParameter('color')));
        $sort = floatval(trim($request->getParameter('sort')));

        $sql = "insert into lkt_background_color(store_id,color_name,color,sort) " .
            "values('$store_id','$color_name','$color','$sort')";
        $r = $db->insert($sql);

        if($r == -1){
            $db->admin_record($store_id,$admin_name,'添加前台背景颜色失败',1);

            header("Content-type:text/html;charset=utf-8");
			echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;

        }else{
            $db->admin_record($store_id,$admin_name,'添加前台背景颜色'.$color_name,1);

            echo json_encode(array('status' =>'添加成功！','suc'=>'1' ));exit;
        }
	    return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>