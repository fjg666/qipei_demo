<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');


class navAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // $store_type = $this->getContext()->getStorage()->read('store_type');
        // $store_id = $this->getContext()->getStorage()->read('store_id');
        $nav = [];
        $id = intval($request->getParameter("id"));
        if ($id) {
            $sql = "select * from lkt_home_nav where is_delete =0 and id = '$id'";
            $navs = $db->select($sql);
            if ($navs) {
                $nav = $navs[0];
            }
        }

        $request->setAttribute('id', $id);
        $request->setAttribute('navs', $nav);
        return View :: INPUT;
    }


    public function execute()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // $store_type = $this->getContext()->getStorage()->read('store_type');
        // $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = intval($request->getParameter("id")); // id
        $type = trim($request->getParameter("type")); // 类型
        $status = trim($request->getParameter("status")); //状态
        $data = $request->getParameter("model"); //处理数据

        if(empty($data['name'])){
            echo json_encode(array('code' => 1, 'msg' => '请填写名称！'));
            exit();
        }
        if(empty($data['uniquely'])){
            echo json_encode(array('code' => 1, 'msg' => '请填写唯一标识名称！'));
            exit();
        }
        if(empty($data['pic_url'])){
            echo json_encode(array('code' => 1, 'msg' => '请上传图片！'));
            exit();
        }
        if(empty($data['sort'])){
            echo json_encode(array('code' => 1, 'msg' => '请填写排序号！'));
            exit();
        }
        
        $uniquely = $data['uniquely'];

        if ($id) {

            //检查分类名是否重复
            $sql = "select uniquely from lkt_home_nav where uniquely = '$uniquely' and id <> '$id'";
            $r = $db->select($sql);
            if ($r) {
                echo json_encode(array('code' => 0, 'msg' => "唯一标识：$uniquely 已存在！"));
                exit();
            }

            $lkt_home_nav = $db->modify($data, 'lkt_home_nav', " id = '$id'");
        } else {

            //检查分类名是否重复
            $sql = "select uniquely from lkt_home_nav where uniquely = '$uniquely' ";
            $r = $db->select($sql);
            if ($r) {
                echo json_encode(array('code' => 0, 'msg' => "唯一标识：$uniquely 已存在！"));
                exit();
            }

            // $data['store_type'] = $store_type;
            // $data['store_id'] = $store_id;
            $lkt_home_nav = $db->insert_array($data, 'lkt_home_nav');
        }

        if ($lkt_home_nav) {
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