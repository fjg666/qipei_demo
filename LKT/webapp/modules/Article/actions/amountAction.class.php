<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');

class amountAction extends Action {

    public function getDefaultView() {
        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收信息
        $id = intval($request->getParameter('id'));
        // 根据新闻id，查询新闻信息
        $sql = "select * from lkt_article where store_id = '$store_id' and Article_id = '$id'";
        $r = $db->select($sql);
        $title = $r[0]->Article_title; // 文章标题
        $total_amount = $r[0]->total_amount; // 红包金额
        $total_num = $r[0]->total_num; // 红包数量
        $wishing = $r[0]->wishing; // 祝福语

        $request->setAttribute("id",$id);
        $request->setAttribute("title",$title);
        $request->setAttribute("total_amount",$total_amount);
        $request->setAttribute("total_num",$total_num);
        $request->setAttribute("wishing",$wishing);
        return View :: INPUT;
    }

    public function execute(){
        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收参数
        $id = intval($request->getParameter('id')); // 文章id
        $total_amount = addslashes(trim($request->getParameter('total_amount'))); // 红包金额
        $total_num = addslashes(trim($request->getParameter('total_num'))); // 红包数量
        $wishing = addslashes(trim($request->getParameter('wishing'))); // 祝福语
        // 判断金额是否为空 或 判断金额是否为0
        if($total_amount == '' || $total_amount == 0){
        	echo json_encode(array('status' =>'红包金额不能为0！' ));exit;
        }
        // 判断数量是否为空
        if($total_num == ''){
        	echo json_encode(array('status' =>'红包数量不能为空！' ));exit;
        }
        // 判断金额和数量是否为数字
        if(is_numeric($total_amount) == false || is_numeric($total_num) == false){
        	echo json_encode(array('status' =>'金额或数量不为数字！'));exit;
        }
        // 根据文章id，修改新闻列表信息
        $sql = "update lkt_article " . "set total_amount = '$total_amount',total_num = '$total_num',wishing = '$wishing'" ."where store_id = '$store_id' and Article_id = '$id'";
        $r = $db->update($sql);
        if($r == -1){
            $db->admin_record($store_id,$admin_name,'修改文章id为'.$id.'的分享设置失败',2);

            echo json_encode(array('status' => '未知原因，红包设置失败！'));exit;
        }else{
            $db->admin_record($store_id,$admin_name,'修改文章id为'.$id.'的分享设置',2);

            echo json_encode(array('status' => '红包设置成功！','suc'=>'1'));exit;
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>