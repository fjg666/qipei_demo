<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');


class pageindexAction extends Action
{

    public $store_id;
    public $userAuth;
    public $db;

    public function getDefaultView()
    {

        $db = DBAction::getInstance();
        $this->db = $db;
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 根据插件id，查询插件信息

        $sql = "select * from lkt_index_page where store_id = '$store_id' and `store_type` = '$store_type' ";
        $home_page_data_res = $db->select($sql);
        $request->setAttribute("lkt_index_page", $home_page_data_res);
        return View :: INPUT;

    }


    public function execute()
    {
        $db = DBAction::getInstance();
        $this->db = $db;
        $request = $this->getContext()->getRequest();
        $module_list = trim($request->getParameter('module_list'));
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql_update_listr = "update lkt_option set value = '$module_list' where store_id = '$store_id' and `group` = '$store_type' and name = 'home_page_data' ";
        $res_update_list = $db->update($sql_update_listr);
        if ($res_update_list) {
            echo json_encode(array('code' => 0, 'msg' => '修改成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 0, 'msg' => '修改失败！'));
            exit();
        }

    }


    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>