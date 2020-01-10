<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
class pageaddAction extends Action {
	public function getDefaultView() {

		return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
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
            if($list){
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
            }else{
            	echo json_encode(array('code'=>0,'msg'=>'请填写链接地址！'));
	                                exit();
            }

        }

       $sql =  "INSERT INTO `lkt_index_page` (`value`, `name`, `sort`, `store_id`, `store_type`, `style`, `add_date`) VALUES ('$page_pic_list', '$name', '10', '$store_id', '$store_type', '$style', CURRENT_TIMESTAMP)";
        $r = $db->insert($sql);

        if($r > 0){
            echo json_encode(array('code'=>0,'msg'=>'添加成功！'));
            exit();
        }else{
            echo json_encode(array('code'=>0,'msg'=>'添加失败！'));
            exit();
        }
	    return;
	}







	public function getRequestMethods(){



		return Request :: POST;



	}







}







?>