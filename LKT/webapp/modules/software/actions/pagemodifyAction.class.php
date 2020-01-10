<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
class pagemodifyAction extends Action {
	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = intval($request->getParameter("id")); // id
        $yimage = addslashes(trim($request->getParameter('yimage'))); // 原图片路径带名称
        $uploadImg = substr($yimage,0,strripos($yimage, '/')) . '/'; // 图片路径
        $sql = "select * from lkt_index_page where id = '$id' and store_id = '$store_id' and `store_type` = '$store_type' ";
        $r = $db->select($sql);
        $value = '';
        if($r){
            $value = $r[0];
        }
        $request->setAttribute("list",$value);
        $request->setAttribute("id",$id);
        return View :: INPUT;
	}

	public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = intval($request->getParameter("id")); // id
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $name = trim($request->getParameter('name')); // name
        if(empty($name)){
            echo json_encode(array('code'=>0,'msg'=>'请填写名称！'));
            exit();
        }
        $style = trim($request->getParameter('style')); // 类型

        $pic_list = $request->getParameter('pic_list'); //详情
        $page_pic_list = json_encode($pic_list);
        if($page_pic_list){
            $list = json_decode($page_pic_list);
            foreach ($list as $key => $value) {
                if(empty($value->pic_url)){
                     echo json_encode(array('code'=>0,'msg'=>'请添加图片！'));
                                exit();
                }
                if(empty($value->url)){
                     echo json_encode(array('code'=>0,'msg'=>'请填写链接地址！'));
                                exit();
                }
            }
        }
        $sql =  "UPDATE `lkt_index_page` SET `value`='$page_pic_list', `name`='$name', `sort`='10', `style`='$style', `add_date`=CURRENT_TIMESTAMP WHERE `id`='$id' and store_id = '$store_id' and `store_type` = '$store_type' ";
        $r = $db->update($sql);

        if($r > 0){
            echo json_encode(array('code'=>0,'msg'=>'修改成功！'));
            exit();
        }else{
            echo json_encode(array('code'=>0,'msg'=>'修改失败！'));
            exit();
        }
        return;
	}







	public function getRequestMethods(){



		return Request :: POST;



	}







}







?>