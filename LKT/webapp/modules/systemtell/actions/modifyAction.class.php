<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');

class modifyAction extends Action{

    public function getDefaultView(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $id = intval($request->getParameter("id")); // 活动id
        // 根据插件id，查询插件信息
        $sql = "select * from lkt_system_tell where id = '$id'";
        $res = $db->select($sql);
        if ($res) {
            $res = $res[0];
        }
        
        $request->setAttribute("res", $res);
        return View :: INPUT;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $id = trim($request->getParameter('id'));
        $title = trim($request->getParameter('title')); // notice
        $telltype = $request->getParameter('telltype');
        $startdate = trim($request->getParameter('startdate')); // 活动图片
        $enddate = trim($request->getParameter('enddate')); // 活动介绍
        $detail = trim($request->getParameter('detail')); // 活动介绍
        if ($title == '') {
            echo json_encode(array('status' => '标题不能为空！'));
            exit;
        }

        if (empty($startdate)) {
            echo json_encode(array('status' => '起始时间不能为空！'));
            exit;
        }

        if (empty($enddate)) {
            echo json_encode(array('status' => '结束时间不能为空！'));
            exit;
        }


        //更新数据表
        $sql = "update lkt_system_tell " .
            "set title = '$title',type = '$telltype',startdate = '$startdate',enddate = '$enddate',content = '$detail',add_time = CURRENT_TIMESTAMP " . "where id = '$id'";
        $r = $db->update($sql);

        if ($r == -1) {
            $db->admin_record(0,$admin_name,'修改公告id为'.$id.'失败',2);

            echo json_encode(array('status' => '未知原因，修改失败！'));
            exit;
        } else {
            $db->admin_record(0,$admin_name,'修改公告id为'.$id,2);

            echo json_encode(array('status' => '修改成功！', 'suc' => '1'));
            exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>