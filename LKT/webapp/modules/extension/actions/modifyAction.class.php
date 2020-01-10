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
        $store_type = $this->getContext()->getStorage()->read('store_type');

        // 接收信息
        $id = intval($request->getParameter("id")); // 推广图id
        // 根据推广图id，查询推广图信息
        $sql = "select * from lkt_extension where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $res = [];
        if($r){
            $data = json_decode($r[0]->data); // 推广图
            $res = $r[0];
        }
        $request->setAttribute('store_type', $store_type);
        $request->setAttribute('id', $id);
        $request->setAttribute("res",$res);
        $request->setAttribute('data', $data);
        
        return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_type = $this->getContext()->getStorage()->read('store_type');

        // 接收数据
        $id = intval($request->getParameter("id")); // 推广图id

        $title = trim($request->getParameter('title')); // 名称
        $type = trim($request->getParameter('type')); // 海报类型
        $keyword = trim($request->getParameter('keyword')); // 关键词

        $isdefault = trim($request->getParameter('isdefault')); // 是否默认
        $bg = trim($request->getParameter('bg')); // 背景图片
        $waittext = trim($request->getParameter('waittext')); // 等待语
        $data = trim($request->getParameter('data')); // 排序的数据
        $color = trim($request->getParameter('color')); // 颜色
        $img =$request->getParameter('img');
        
        if(empty($title) || empty($keyword) || empty($waittext)){
        	echo json_encode(array('status' => '信息未填写完整,请重新添加！'));exit;
        }
        // 添加数据
        if($isdefault){
            $sql = "update lkt_extension set isdefault = 0 where store_id = '$store_id' and type = '$type' and store_type = '$store_type";
            $r = $db->update($sql);
        }

		//更新数据表
        $sql = "update lkt_extension set image='$img',name='$title',type='$type',keyword='$keyword',isdefault='$isdefault',bg='$bg',waittext='$waittext',data='$data',color='$color',add_date =CURRENT_TIMESTAMP where store_id = '$store_id' and id = '$id' and store_type = '$store_type'";
		$r = $db->update($sql);
		if($r == -1) {
            $db->admin_record($store_id,$admin_name,'修改推广图id为'.$id.'失败',2);

            echo json_encode(array('status' =>'未知原因，修改失败！' ));exit;
		}else {
            $db->admin_record($store_id,$admin_name,'修改推广图id为'.$id,2);

            echo json_encode(array('status' =>'修改成功！' ,'suc'=>'1'));exit;
		}
		return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}

}

?>