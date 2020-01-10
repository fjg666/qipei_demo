<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class SetAction extends Action {
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = intval($request->getParameter("id")); // id
        $payments = (object)[];

        $sql = "select * from lkt_payment where `id` = '$id' ";
        $payment = $db->select($sql);
        if ($payment) {
            //其他数据
            $payments = $payment[0];
        }
        $request->setAttribute('payments', $payments);
        return View :: INPUT;
    }

    public function execute()
    {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = intval($request->getParameter("id")); // id
        $name = trim($request->getParameter("name")); // 支付名称
        $status = trim($request->getParameter("status")); //状态
        $client_type = trim($request->getParameter("client_type")); //1:PC端 2:移动端 3:通用
        $poundage = trim($request->getParameter("poundage")); //手续费
        $sort = trim($request->getParameter("sort")); //排序
        $note = trim($request->getParameter("note")); //支付说明
        $logo = trim($request->getParameter("logo")); //支付方式logo图片路径
        $poundage_type = trim($request->getParameter("poundage_type")); //手续费方式 1百分比 2固定值'

        $log = new LaiKeLogUtils('common/payment.log');// 日志

        $sql = "select * from lkt_payment where id = '$id' ";// 查询是否存在
        $navs = $db->select($sql);
        if ($navs) {// 存在 修改
            $modify['`name`'] = $name;
            $modify['`status`'] = $status;
            $modify['`client_type`'] = $client_type;
            $modify['`poundage`'] = $poundage;
            $modify['`sort`'] = $sort;
            $modify['note'] = $note;
            $modify['logo'] = $logo;
            $modify['poundage_type'] = $poundage_type;
            
            $theme_data = $db->modify($modify, 'lkt_payment', " `id` ='$id' ");
            $res = 2;
        } else {// 不存在 添加
            $insert['`name`'] = $name;
            $insert['`status`'] = $status;
            $insert['`client_type`'] = $client_type;
            $insert['`poundage`'] = $poundage;
            $insert['`sort`'] = $sort;
            $insert['`note`'] = $note;
            $insert['`logo`'] = $logo;
            $insert['`poundage_type`'] = $poundage_type;
            $theme_data = $db->insert_array($insert, 'lkt_payment');
            $res = 1;
        }

        if ($theme_data > 0) {
            if($res == 1){
                $log -> customerLog(__LINE__.":添加【".$name."】支付方式成功！\r\n");
                $db->admin_record(0,$admin_name,' 添加支付方式'.$name.'成功 ',1);
            }else{
                $log -> customerLog(__LINE__.":修改【".$name."】支付方式成功！\r\n");
                $db->admin_record(0,$admin_name,' 修改支付方式ID为 '.$id.' 成功 ',1);
            }
            echo json_encode(array('status' => '操作成功！','suc'=>'1'));exit;
            exit();
        } else {
            if($res == 1){
                $log -> customerLog(__LINE__.":添加【".$name."】支付方式失败！\r\n");
                $db->admin_record(0,$admin_name,' 修改支付方式失败 ',2);
            }else{
                $log -> customerLog(__LINE__.":修改【".$name."】支付方式失败！\r\n");
                $db->admin_record(0,$admin_name,' 修改支付方式ID为 '.$id.' 失败 ',2);
            }
            echo json_encode(array('status' => '未知原因，操作失败！'));exit;
            exit();
        }

    }


    public function getRequestMethods()
    {

        return Request :: POST;

    }


}







?>