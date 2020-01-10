<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');


class navindexAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // $store_type = $this->getContext()->getStorage()->read('store_type');
        // $store_id = $this->getContext()->getStorage()->read('store_id');
        $title = $request->getParameter("title"); // 分类id
        $title1 = $request->getParameter("title1"); // 分类id
        $sql = "select * from lkt_home_nav where is_delete =0 order by sort desc ";
        $navs = $db->select($sql);
        $request->setAttribute('navs', $navs);
        $request->setAttribute("title",$title);
        $request->setAttribute("title1",$title1);
        return View :: INPUT;
	}



	public function execute(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $id = intval($request->getParameter("id")); // id
        $type = trim($request->getParameter("type")); // 类型
        $status = trim($request->getParameter("status")); //状态

        // $store_type = $this->getContext()->getStorage()->read('store_type');
        // $store_id = $this->getContext()->getStorage()->read('store_id');

        if($type == 'del'){
            $sql_lkt_home_nav = "update lkt_home_nav set is_delete = '1' where id = '$id' ";
            $lkt_home_nav=$db->update($sql_lkt_home_nav);
        }else{
            $sql_lkt_home_nav = "update lkt_home_nav set is_hide = '$status' where id = '$id' ";
            $lkt_home_nav=$db->update($sql_lkt_home_nav);
        }



        if($lkt_home_nav){
            echo json_encode(array('code'=>0,'msg'=>'操作成功！'));
            exit();
        }else{
            echo json_encode(array('code'=>1,'msg'=>'操作失败！'));
            exit();
        }

	}



	public function getRequestMethods(){

		return Request :: POST;

	}



}



?>