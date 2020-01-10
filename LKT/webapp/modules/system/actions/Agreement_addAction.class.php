<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Agreement_addAction extends Action {

    public function getDefaultView() {

        return View :: INPUT;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        //取得参数
        $type = addslashes(trim($request->getParameter('type'))); // 类型
        $content = addslashes(trim($request->getParameter('content'))); // 内容
        $name = addslashes(trim($request->getParameter('name'))); // 标题

        $log = new LaiKeLogUtils('common/system.log');// 日志

        $res = '';
        if($type == 0){
            $res = '注册';
        }else if($type == 1){
            $res = '店铺';
        }

        $sql0 = "select * from lkt_agreement where store_id = '$store_id' and type = '$type'";
        $r0 = $db->select($sql0);
        if($r0){
            $log -> customerLog(__LINE__.":添加协议失败：该类协议已存在！ \r\n");
            $db->admin_record($store_id,$admin_name,'添加协议失败！',1);
            echo json_encode(array('status' => '该类协议已存在！'));exit;
        }
        if($content == ''){
            $log -> customerLog(__LINE__.":添加协议失败：协议内容不能为空！ \r\n");
            $db->admin_record($store_id,$admin_name,'添加协议失败！',1);
            echo json_encode(array('status' => '协议内容不能为空！'));exit;
        }

        $sql = "insert into lkt_agreement (store_id,name,type,content,modify_date) values ('$store_id','$name','$type','$content',CURRENT_TIMESTAMP)";
        $r = $db->insert($sql);
        if($r == -1) {
            $db->admin_record($store_id,$admin_name,'添加'.$res.'协议失败',1);
            $log -> customerLog(__LINE__.":添加协议失败：$sql \r\n");
            echo json_encode(array('status' => '未知原因，添加失败！！'));exit;
        } else {
            $db->admin_record($store_id,$admin_name,'添加'.$res.'协议成功！',1);
            $log -> customerLog(__LINE__.":添加协议成功！ \r\n");
            echo json_encode(array('status' => '添加成功！','suc'=>'1'));exit;
        }

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}

?>