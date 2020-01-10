<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class modifyAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $top_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $id = intval($request->getParameter("id")); // 轮播图id
        $yimage = addslashes(trim($request->getParameter('yimage'))); // 原图片路径带名称
        $uploadImg = substr($yimage,0,strripos($yimage, '/')) . '/'; // 图片路径

        // 根据轮播图id，查询轮播图信息
        $sql = "select * from lkt_guide where id = '$id'";
        $r = $db->select($sql);
        if($r){
            $image = ServerPath::getimgpath($r[0]->image,$store_id); // 轮播图
            $type = $r[0]->type ; // 链接
            $sort = $r[0]->sort; // 排序
        }

        $request->setAttribute("uploadImg",$uploadImg);
        $request->setAttribute("image",$image);
        $request->setAttribute('id', $id);
        $request->setAttribute('type', $type);
        $request->setAttribute('sort', $sort);
        $request->setAttribute("store_type",$top_type);

        return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $top_type = $this->getContext()->getStorage()->read('store_type');

        $lktlog = new LaiKeLogUtils("common/guide.log");
        $JurisdictionAction = new JurisdictionAction();
        // 1.开启事务
        $db->begin();

        // 接收信息
		$id = intval($request->getParameter('id'));
        $image = addslashes(trim($request->getParameter('image'))); // 轮播图
        $oldpic = addslashes(trim($request->getParameter('oldpic'))); // 原轮播图
        $type = addslashes(trim($request->getParameter('type'))); // 类型
        $sort = floatval(trim($request->getParameter('sort'))); // 排序
        if($top_type == 1){
            $type = 1;
        }
        if($image){
            $image = preg_replace('/.*\//','',$image);
            if($image != $oldpic){
                $oldpic = ServerPath::getimgpath($oldpic,$store_id); // 轮播图
                @unlink ($oldpic);
            }
        }else{
            $image = $oldpic;
        }

		//更新数据表
		$sql = "update lkt_guide " .
			"set image = '$image',type = '$type', sort = '$sort' "
			."where store_id = '$store_id' and id = '$id'";
		$r = $db->update($sql);

		if($r == -1) {

            $JurisdictionAction->admin_record($store_id,$admin_name,'修改引导图ID为'.$id.'失败',2);

            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改引导图ID为'.$id.'失败,类型为 '.$top_type;
            $lktlog->customerLog($Log_content);

            $db->rollback();

            echo json_encode(array('status' =>'未知原因，修改失败！' ));exit;

        }else {
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改引导图ID为'.$id,2);

            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改引导图ID为'.$id.'成功,类型为 '.$top_type;
            $lktlog->customerLog($Log_content);

            $db->commit();

            echo json_encode(array('status' =>'修改成功！','suc'=>'1' ));exit;
        }
		return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>