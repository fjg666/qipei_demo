<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');

class modifyAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $id = intval($request->getParameter("id")); // id

        // 根据id查询
        $sql = "select * from lkt_background_color where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        if($r){
            $color_name = $r[0]->color_name;
            $color = $r[0]->color;
            $sort = $r[0]->sort;
        }

        $request->setAttribute('id', $id);
        $request->setAttribute('color_name', isset($color_name) ? $color_name : '');
        $request->setAttribute('color', isset($color) ? $color : '');
        $request->setAttribute('sort', isset($sort) ? $sort : '');
        return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收数据 
        $id = intval($request->getParameter('id'));
        $color_name = addslashes(trim($request->getParameter('color_name')));
        $color = addslashes(trim($request->getParameter('color')));
        $sort = floatval(trim($request->getParameter('sort')));

		//更新数据表
		$sql = "update lkt_background_color set color_name = '$color_name',color = '$color', sort = '$sort' where store_id = '$store_id' and id = '$id'";
		$r = $db->update($sql);
		if($r == -1) {
            $db->admin_record($store_id,$admin_name,'添加前台背景颜色id为'.$id.'失败',1);

            echo json_encode(array('status' => '未知原因，修改失败！'));exit;
		} else {
            $db->admin_record($store_id,$admin_name,'添加前台背景颜色id为'.$id,1);

            echo json_encode(array('status' =>'修改成功！','suc'=>'1' ));exit;
		}
		return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>