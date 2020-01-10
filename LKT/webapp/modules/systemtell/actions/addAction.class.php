<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class addAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $title = trim($request->getParameter('title')); // notice
        $telltype = $request->getParameter('telltype');
        $startdate = trim($request->getParameter('startdate')); // 活动图片
        $enddate = trim($request->getParameter('enddate')); // 活动介绍
        $detail = trim($request->getParameter('detail')); // 活动介绍
        if ($title == '') {
            echo json_encode(array('status' => '标题不能为空！'));
            exit;
        }
        if($telltype == 1){
           if (empty($startdate)||empty($enddate)) {
            echo json_encode(array('status' => '系统维护必须设置起始时间!'));
            exit;
           }
        } 

        $sql = "insert into lkt_system_tell(title,type,startdate,enddate,content,add_time) " .
            "values('$title',$telltype,'$startdate','$enddate','$detail',CURRENT_TIMESTAMP)";
        $rr = $db->insert($sql);
        if ($rr == -1) {
            $db->admin_record(0,$admin_name,'添加公告'.$title.'失败',1);
            echo json_encode(array('status' => '未知原因，添加失败！'));
            exit;
        } else {
            $db->admin_record(0,$admin_name,'添加公告'.$title,1);
            echo json_encode(array('status' => '添加成功！', 'suc' => '1'));
            exit;
        }
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>