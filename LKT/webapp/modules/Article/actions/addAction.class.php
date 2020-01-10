<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');

class addAction extends Action{

    public function getDefaultView(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');

        $request->setAttribute('uploadImg',$uploadImg);
        return View :: INPUT;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收数据 
        $Article_title = addslashes(trim($request->getParameter('Article_title'))); // 文章标题
        $Article_prompt = addslashes(trim($request->getParameter('Article_prompt'))); // 文章副标题
        $sort = floatval(trim($request->getParameter('sort'))); // 排序
        $imgurl = addslashes($request->getParameter('imgurl')); // 文章图片
        $content = addslashes(trim($request->getParameter('content'))); // 文章内容

        if ($imgurl) {
            $imgurl = preg_replace('/.*\//', '', $imgurl);
        }
        
        if (empty($Article_title)) {
            echo json_encode(array('status' => '标题不能为空！'));
            exit;
        }

        if (empty($content)) {
            echo json_encode(array('status' => '内容不能为空！'));
            exit;
        }

        // 发布文章
        $sql = "insert into lkt_article(store_id,Article_title,Article_prompt,Article_imgurl,sort,content,add_date) " .
            "values('$store_id','$Article_title','$Article_prompt','$imgurl','$sort','$content',CURRENT_TIMESTAMP)";
        $r = $db->insert($sql);

        if ($r == -1) {
            $db->admin_record($store_id,$admin_name,'添加文章'.$Article_title.'失败',1);

            echo json_encode(array('status' => '未知原因，文章发布失败！'));
            exit;
        } else {
            $db->admin_record($store_id,$admin_name,'添加文章'.$Article_title,1);

            echo json_encode(array('status' => '文章发布成功！', 'suc' => '1'));
            exit;
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>