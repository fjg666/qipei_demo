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
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $sql = "select * from lkt_bargain_config where store_id='$store_id'";
        $r = $db->select($sql);
        if($r){
            $buy_time = $r[0]->buy_time; // 砍价成功，购买的时间
            $show_time = $r[0]->show_time; // 活动结束显示的时间
            $status = $r[0]->status; // 是否开启插件
            $rule = $r[0]->rule; // 规则
            $imgUrl = $r[0]->imgurl; // 砍价轮播图
        }else{
            $status = 0;
            $buy_time = 10;
            $show_time = 3;
            $rule = '';
            $imgUrl = '';
        }

        $request->setAttribute('imgUrl', $imgUrl);
        $request->setAttribute('buy_time', $buy_time);
        $request->setAttribute('show_time', $show_time);
        $request->setAttribute('status', $status);
        $request->setAttribute('rule', $rule);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        // 接收信息
        $show_time = intval($request->getParameter('show_time'));//活动结束后显示的时间
        $buy_time = addslashes(trim($request->getParameter('buy_time'))); // 砍价成功后购买的时间
        $rule = addslashes(trim($request->getParameter('rule'))); // 规则内容
        $imgArr= $request->getParameter('imgurls');//砍价轮播图
        $status= trim($request->getParameter('status'));// 是否开启插件

        $log = new LaiKeLogUtils('common/bargain.log');// 日志

        if(is_numeric($show_time) == ''){
            $log -> customerLog(__LINE__.":砍价设置修改失败：显示时间请输入数字！ \r\n");
            echo json_encode(array('msg'=>'显示时间请输入数字！'));exit;
        }
        if($show_time < 0){
            $log -> customerLog(__LINE__.":砍价设置修改失败：显示时间不能为负数！ \r\n");
            echo json_encode(array('msg'=>'显示时间不能为负数！'));exit;
        }

        if(is_numeric($buy_time) == ''){
            $log -> customerLog(__LINE__.":砍价设置修改失败：购买时间请输入数字！ \r\n");
            echo json_encode(array('msg'=>'购买时间请输入数字！'));exit;
        }
        if($buy_time < 0){
            $log -> customerLog(__LINE__.":砍价设置修改失败：购买时间不能为负数！ \r\n");
            echo json_encode(array('msg'=>'购买时间不能为负数！'));exit;
        }

        // 查询配置是否存在
        $sql = "select * from lkt_bargain_config where store_id='$store_id'";
        $r = $db->select($sql);

        $time = time();
        $imgUrl = $imgArr[0];
        if($r){
            $sql = "update lkt_bargain_config set show_time = '$show_time',imgurl = '$imgUrl',buy_time = '$buy_time',rule = '$rule',updatetime = '$time',status='$status' where store_id='$store_id'";
            $r_1 = $db->update($sql);
            $sql_up = "UPDATE lkt_bargain_goods SET buytime = $buy_time where 1";
            $db->update($sql_up);
            if($r_1 == -1) {
                $db->admin_record($store_id,$admin_name,'砍价设置修改失败！',2);
                $log -> customerLog(__LINE__.":砍价设置修改失败：$sql \r\n");
                echo json_encode(array('msg'=>'未知原因，砍价设置修改失败！'));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'砍价设置修改成功！',2);
                $log -> customerLog(__LINE__.":砍价设置修改成功！\r\n");
                echo json_encode(array('msg'=>'砍价设置修改成功！', 'suc'=>1));exit;
            }
        }else{
            $sql = "insert into lkt_bargain_config(store_id,buy_time,show_time,rule,addtime,updatetime) values('$store_id','$buy_time','$show_time','$rule','$time','$time')";
            $r_1 = $db->insert($sql);
            $sql_up = "UPDATE lkt_bargain_goods SET buytime = $buy_time where 1";
            $db->update($sql_up);
            if($r_1 == -1) {
                $db->admin_record($store_id,$admin_name,'砍价设置添加失败！',1);
                $log -> customerLog(__LINE__.":砍价设置添加失败：$sql \r\n");
                echo json_encode(array('msg'=>'未知原因，砍价设置添加失败！'));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'砍价设置添加成功！',1);
                $log -> customerLog(__LINE__.":砍价设置添加成功！\r\n");
                echo json_encode(array('msg'=>'砍价设置添加成功！', 'suc'=>1));exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>