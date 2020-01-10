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
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');


        $request->setAttribute("uploadImg", $uploadImg);
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $notice = $request->getParameter('notice'); // notice
        $image = addslashes($request->getParameter('image')); // 活动图片
        $detail = addslashes(trim($request->getParameter('detail'))); // 活动介绍
        if ($image) {
            $image = preg_replace('/.*\//', '', $image);
        } else {
            echo json_encode(array('status' => '公告活动图片不能为空！'));
            exit;
        }

        if (empty($detail)) {
            echo json_encode(array('status' => '公告内容不能为空！'));
            exit;
        }

        if (empty($notice)) {
            echo json_encode(array('status' => '公告名称不能为空！'));
            exit;
        }

        $sql = "insert into lkt_set_notice(store_id,user,name,img_url,detail,time) " .
            "values('$store_id','$admin_name','$notice','$image','$detail',CURRENT_TIMESTAMP)";
        $rr = $db->insert($sql);
        if ($rr == -1) {
            $db->admin_record($store_id,$admin_name,'添加公告'.$notice.'失败',1);

            echo json_encode(array('status' => '未知原因，添加失败！'));
            exit;
        } else {
            $db->admin_record($store_id,$admin_name,'添加公告'.$notice,1);

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