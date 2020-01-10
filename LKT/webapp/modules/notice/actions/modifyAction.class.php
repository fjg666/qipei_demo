<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class modifyAction extends Action{

    public function getDefaultView(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');
        // 接收信息
        $id = intval($request->getParameter("id")); // 活动id
        // 根据插件id，查询插件信息
        $sql = "select * from lkt_set_notice where store_id = '$store_id' and id = '$id'";
        $res = $db->select($sql);
        if ($res) {
            $id = $res[0]->id;
            $image = ServerPath::getimgpath($res[0]->img_url,$store_id);
            $name = $res[0]->name;
            $detail = $res[0]->detail;
        }

        $request->setAttribute("id", $id);
        $request->setAttribute("name", $name);
        $request->setAttribute("image", $image);
        $request->setAttribute("detail", $detail);
        return View :: INPUT;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');

        $id = addslashes(trim($request->getParameter('id'))); // 
        $url = addslashes(trim($request->getParameter('uploadImg'))); // 图片上传位置
        $notice = addslashes(trim($request->getParameter('notice'))); // name
        $detail = addslashes(trim($request->getParameter('detail'))); //
        $oldpic = addslashes(trim($request->getParameter('oldpic')));
        $image = addslashes(trim($request->getParameter('image')));

        if ($image) {
            $image = preg_replace('/.*\//', '', $image);
            if ($image != $oldpic) {
                @unlink($uploadImg . $oldpic);
            }
        } else {
            $image = $oldpic;
        }

        if (empty($detail)) {
            echo json_encode(array('status' => '公告内容不能为空！'));
            exit;
        }

        if (empty($notice)) {
            echo json_encode(array('status' => '公告名称不能为空！'));
            exit;
        }

        //更新数据表
        $sql = "update lkt_set_notice " .
            "set img_url = '$image',user = '$admin_name',name = '$notice',detail = '$detail',time = CURRENT_TIMESTAMP " . "where store_id = '$store_id' and id = '$id'";
        $r = $db->update($sql);

        if ($r == -1) {
            $db->admin_record($store_id,$admin_name,'修改公告id为'.$id.'失败',2);

            echo json_encode(array('status' => '未知原因，修改失败！'));
            exit;
        } else {
            $db->admin_record($store_id,$admin_name,'修改公告id为'.$id,2);

            echo json_encode(array('status' => '修改成功！', 'suc' => '1'));
            exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>