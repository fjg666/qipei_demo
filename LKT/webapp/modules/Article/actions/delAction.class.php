<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');

class delAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg'); // 图片上传位置
        // 接收信息
        $id = intval($request->getParameter('id')); // 新闻id
        // 根据文章id,查询文章
        $sql = "select * from lkt_article where store_id = '$store_id' and Article_id = '$id'";
        $r = $db->select($sql);
        $Article_imgurl = $r[0]->Article_imgurl;
        @unlink ($uploadImg.$Article_imgurl);
        // 根据文章id，删除新闻信息
        $sql = "delete from lkt_article where store_id = '$store_id' and Article_id = '$id'";
        $res = $db->delete($sql);
        if($res > 0){
            $db->admin_record($store_id,$admin_name,'删除文章id为'.$id,3);

            echo json_encode(array('status' =>1));exit;
        }else{
            $db->admin_record($store_id,$admin_name,'删除文章id为'.$id.'失败',3);

            echo json_encode(array('status' =>0)); exit;
        }
        return;
    }

    public function execute(){
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>