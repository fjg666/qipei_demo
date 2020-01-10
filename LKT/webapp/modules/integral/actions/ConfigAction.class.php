<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ConfigAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

        $bg_img = ''; // 背景图
        $content = ''; // 规则
        $status = 0; // 是否开启插件
        $sql = "select * from lkt_integral_config where store_id='$store_id'";
        $r = $db->select($sql);
        if($r){
            $bg_img = $r[0]->bg_img; // 背景图
            $content = $r[0]->content; // 规则
            $status = $r[0]->status; // 是否开启插件
        }

        $request->setAttribute('bg_img', $bg_img);
        $request->setAttribute('content', $content);
        $request->setAttribute('status', $status);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');// 管理员
        // 接收信息
        $content = addslashes(trim($request->getParameter('content'))); // 规则内容
        $imgArr = $request->getParameter('imgurls');//轮播图
        $status = trim($request->getParameter('status'));//是否开启插件

        $log = new LaiKeLogUtils('common/integral.log');// 日志

        // 查询是否配置
        $sql = "select * from lkt_integral_config where store_id='$store_id'";
        $r = $db->select($sql);
        $bg_img = $imgArr[0];

        if($r){
            $sql = "update lkt_integral_config set content = '$content',bg_img = '$bg_img',status='$status' where store_id='$store_id'";
            $r_1 = $db->update($sql);
            if($r_1 == -1) {
                $log -> customerLog(__LINE__.":积分商城配置修改失败：$sql \r\n");
                $db->admin_record($store_id,$admin_name,'积分商城配置修改失败！',2);
                echo json_encode(array('status' => 0,'info' => '设置失败!'));exit;
            } else {
                $log -> customerLog(__LINE__.":积分商城配置修改成功！ \r\n");
                $db->admin_record($store_id,$admin_name,'积分商城配置修改成功！',2);
                echo json_encode(array('status' => 1,'info' => '设置成功！'));exit;
            }
        }else{
            $sql = "insert into lkt_integral_config(store_id,content,bg_img,status) values('$store_id','$content','$bg_img','$status')";
            $r_1 = $db->insert($sql);
            if($r_1 == -1) {
                $log -> customerLog(__LINE__.":积分商城配置添加失败：$sql \r\n");
                $db->admin_record($store_id,$admin_name,'积分商城配置添加失败！',2);
                echo json_encode(array('status' => 0,'info' => '设置失败!'));exit;
            } else {
                $log -> customerLog(__LINE__.":积分商城配置添加成功！ \r\n");
                $db->admin_record($store_id,$admin_name,'积分商城配置添加成功！',1);
                echo json_encode(array('status' => 1,'info' => '设置成功！'));exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>