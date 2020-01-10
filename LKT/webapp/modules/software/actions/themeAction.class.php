<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');


class themeAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $nav = [];
        $Navbar = new Navbar;
        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'theme_data'";
        $navs = $db->select($sql);
        if ($navs) {
            $data = unserialize($navs[0]->value);
            foreach ($data as $key => $value) {
                $nav[$key] = (object)$value;
            }
        } else {
            $theme_data = $Navbar->mini_program_pages();
            foreach ($theme_data as $key => $value) {
                $arrayName = array('top_img' => '', 'bottom_img' => '', 'title' => $value, 'name' => $value);
                $nav[$key] = (object)$arrayName;
            }
        }

        //获取权限数组去掉无权限的界面
        $request->setAttribute('navs', $nav);
        return View :: INPUT;
    }


    public function execute()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = intval($request->getParameter("id")); // id
        $type = trim($request->getParameter("type")); // 类型
        $status = trim($request->getParameter("status")); //状态
        $data = $request->getParameter("model"); //处理数据
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'theme_data'";
        $navs = $db->select($sql);
        if ($navs) {
            $modify['`value`'] = serialize($data);
            $theme_data = $db->modify($modify, 'lkt_option', " `group` ='$store_type' and `store_id` = '$store_id' and `name` = 'theme_data'");
        } else {
            $insert['`group`'] = $store_type;
            $insert['store_id'] = $store_id;
            $insert['`name`'] = 'theme_data';
            $insert['`value`'] = serialize($data);
            $theme_data = $db->insert_array($insert, 'lkt_option');
        }

        if ($theme_data > 0) {
            echo json_encode(array('code' => 0, 'msg' => '操作成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 1, 'msg' => '操作失败！'));
            exit();
        }

    }


    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>