<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class modifyAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg'); // 图片上传位置

        // 接收信息
        $id = intval($request->getParameter("id")); // 文章id

        // 根据文章id，查询文章文章信息
        $sql = "select * from lkt_article where store_id = '$store_id' and Article_id = '$id'";
        $r = $db->select($sql);
        if($r){
            $Article_title = $r[0]->Article_title; // 文章标题
            $Article_prompt = $r[0]->Article_prompt; // 文章标题
            $sort = $r[0]->sort; // 排序
            $content = $r[0]->content; // 文章内容Article_imgurl
            $Article_imgurl = $r[0]->Article_imgurl;
            $Article_imgurl = ServerPath::getimgpath($Article_imgurl,$store_id); // 文章图片
        }

		$request->setAttribute('id', $id);
        $request->setAttribute('Article_title',$Article_title);
        $request->setAttribute('Article_prompt',$Article_prompt);
        $request->setAttribute('sort', isset($sort) ? $sort : '');
        $request->setAttribute('Article_imgurl', $Article_imgurl);
        $request->setAttribute('content', $content);
//        $request->setAttribute('uploadImg', $uploadImg);
        return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg'); // 图片上传位置
        // 接收信息
		$id = intval($request->getParameter('id'));
        $Article_title = trim($request->getParameter('Article_title')); // 文章标题
        $Article_prompt = trim($request->getParameter('Article_prompt')); // 文章副标题
        $sort = floatval(trim($request->getParameter('sort'))); // 排序
        $imgurl = addslashes($request->getParameter('imgurl')); // 文章新图片
        $oldpic = addslashes($request->getParameter('oldpic')); // 文章原图片
        $content = addslashes($request->getParameter('content')); // 文章内容

        if($imgurl){
            $imgurl = preg_replace('/.*\//','',$imgurl);
            if($imgurl != $oldpic){
                @unlink ($uploadImg.$oldpic);
            }
        }else{
            $imgurl = $oldpic; // 文章图片
        }

        if (empty($Article_title)) {
            echo json_encode(array('status' => '标题不能为空！'));
            exit;
        }

        if (empty($content)) {
            echo json_encode(array('status' => '内容不能为空！'));
            exit;
        }

        // 检查文章标题是否重复
        $sql = "select 1 from lkt_article where store_id = '$store_id' and Article_title = '$Article_title' and Article_id <> '$id'";
        $r = $db->select($sql);
        if ($r && count($r) > 0) {
			echo json_encode(array('status' => '{$Article_title} 已经存在，请选用其他标题进行修改！'));exit;
        }

		//更新数据表
		$sql = "update lkt_article " .
			"set Article_title = '$Article_title',Article_prompt = '$Article_prompt', sort = '$sort',Article_imgurl = '$imgurl', content = '$content' "
			."where store_id = '$store_id' and Article_id = '$id'";
		$r = $db->update($sql);

		if($r == -1) {
            $db->admin_record($store_id,$admin_name,'修改文章id为'.$id.'失败',2);

            echo json_encode(array('status' => '未知原因，文章修改失败！'));exit;
		} else {
            $db->admin_record($store_id,$admin_name,'修改文章id为'.$id,2);

            echo json_encode(array('status' =>'文章修改成功！','suc'=>'1'));exit;
		}
		return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>