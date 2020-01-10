<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class MemberAction extends Action {

    public function getDefaultView() {

       return;
    }

    // 删除活动
    public function delpro(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');// 管理员
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $id = $request->getParameter('id');// 活动ID

        $log = new LaiKeLogUtils('common/bargain.log');// 日志
        
        if (count(explode(',', $id)) > 1) {
            $id = substr($id, 0,-1);
        }

        $time = date('Y-m-d H:i:s');
        $sql = "select * from lkt_bargain_goods where id in ($id) and store_id='$store_id' and begin_time<'$time' && end_time>'$time'";
        $selRes = $db->select($sql);
        if (count($selRes) > 0) {
            $log -> customerLog(__LINE__.":删除砍价活动失败：不能删除进行中的活动！\r\n");
            $db->admin_record($store_id,$admin_name,'删除ID为'.$id.'的砍价活动失败！',1);
            echo json_encode(array('status' => 2,'info' => '不能删除进行中的活动!'));exit;
        }
        $sql = "update lkt_bargain_goods set is_delete = 1 where id in ($id)";
        $res = $db -> update($sql);
        if($res < 0){
            $log -> customerLog(__LINE__.":删除砍价活动失败：$sql\r\n");
            $db->admin_record($store_id,$admin_name,'删除ID为'.$id.'的砍价活动失败！',3);
            echo json_encode(array('status' => 2,'info' => '删除失败!'));exit;
        }else{
            $log -> customerLog(__LINE__.":删除砍价活动成功！\r\n");
            $db->admin_record($store_id,$admin_name,'删除ID为'.$id.'的砍价活动成功！',3);
            echo json_encode(array('status' => 1,'info' => '删除成功!'));exit;
        }
    }
    // 置顶
    public function top(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');// 管理员
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $id = $request->getParameter('id');// 活动ID

        $log = new LaiKeLogUtils('common/bargain.log');// 日志

        $sql = "SELECT MAX(sort) as sort FROM `lkt_bargain_goods`";
        $sortRes = $db->select($sql);
        if($sortRes){
            $sort = $sortRes[0]->sort;// 最大排序号
            $sort = (int)$sort + 1;
            // 修改排序号
            $sql = "UPDATE `lkt_bargain_goods` SET sort = $sort WHERE id = $id";
            $res = $db->update($sql);
            if($res){
                $log -> customerLog(__LINE__.":【".$id."】活动置顶成功！\r\n");
                $db->admin_record($store_id,$admin_name,'置顶ID为'.$id.'的砍价活动成功！',2);
                echo json_encode(array('status' => 1,'info' => '操作成功!'));exit;
            }
            $log -> customerLog(__LINE__.":【".$id."】活动置顶失败：$sql\r\n");
            $db->admin_record($store_id,$admin_name,'置顶ID为'.$id.'的砍价活动失败！',2);
            echo json_encode(array('status' => 0,'info' => '操作失败!'));exit;
        }
        $log -> customerLog(__LINE__.":【".$id."】活动置顶失败：没有活动！\r\n");
        $db->admin_record($store_id,$admin_name,'置顶ID为'.$id.'的砍价活动失败！',2);
        echo json_encode(array('status' => 0,'info' => '操作失败!'));exit;

    }
    // 修改活动是否显示
    public function is_market(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');// 管理员
        $id = $request->getParameter('id');// 活动ID
        $type = $request->getParameter('type');//停止或开始产品砍价

        $log = new LaiKeLogUtils('common/bargain.log');// 日志

        $sql = "update lkt_bargain_goods set is_show=$type where id=$id and store_id='$store_id'";
        $res = $db -> update($sql);
        if($res < 0){
            $log -> customerLog(__LINE__.":修改砍价活动显示状态失败：$sql\r\n");
            $db->admin_record($store_id,$admin_name,'修改ID为'.$id.'的砍价活动显示状态失败！',2);
            echo json_encode(array('status' => 0,'info' => '操作失败!'));exit;
        }else{
            $log -> customerLog(__LINE__.":修改砍价活动显示状态成功！\r\n");
            $db->admin_record($store_id,$admin_name,'修改ID为'.$id.'的砍价活动显示状态成功！',2);
            echo json_encode(array('status' => 1,'info' => '操作成功!'));exit;
        }
    }
    // 开始活动
    public function kaishi(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');// 管理员
        $bargain_id = $request->getParameter('id');// 活动ID

        $log = new LaiKeLogUtils('common/bargain.log');// 日志

        $time = date('Y-m-d H:i');

        $sql = "update lkt_bargain_goods set status=1,begin_time='$time' where id=$bargain_id and store_id='$store_id'";
        $res = $db -> update($sql);
        if($res < 0){
            $log -> customerLog(__LINE__.":开始砍价活动失败：$sql\r\n");
            $db->admin_record($store_id,$admin_name,'开始ID为'.$bargain_id.'的砍价活动失败！',2);
            echo json_encode(array('status' => 0,'info' => '操作失败!'));exit;
        }else{
            $log -> customerLog(__LINE__.":开始砍价活动成功!\r\n");
            $db->admin_record($store_id,$admin_name,'开始ID为'.$bargain_id.'的砍价活动成功!',2);
            echo json_encode(array('status' => 1,'info' => '操作成功!'));exit;
        }
    }

    public function execute() {

        $request = $this->getContext()->getRequest();
        $m = $request->getParameter('m');

        $this -> $m();
        
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>