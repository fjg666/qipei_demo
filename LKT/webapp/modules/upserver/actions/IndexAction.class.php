<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class IndexAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $upserver = $r[0]->upserver;// 上传服务器:1,本地　2,阿里云 3,腾讯云 4,七牛云
        }
        $request->setAttribute('upserver', isset($upserver) ? $upserver : '');
        return View :: INPUT;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号

        //取得参数
        $upserver= $request->getParameter('upserver');// 上传服务器:1,本地　2,阿里云 3,腾讯云 4,七牛云
        
        $log = new LaiKeLogUtils('common/upserver.log');// 日志

        // 更新
        $sql = "update lkt_config set upserver = '$upserver' where store_id = '$store_id'";
        $r = $db->update($sql);
        if($r == -1) {
            $db->admin_record($store_id,$admin_name,'修改图片上传配置失败！',2);
            $log -> customerLog(__LINE__.":修改图片上传配置失败: $sql \r\n");
            echo "<script type='text/javascript'>" .
                "alert('未知原因，修改失败！');" .
                "location.href='index.php?module=upserver';</script>";
            return $this->getDefaultView();
        } else {
            $db->admin_record($store_id,$admin_name,'修改图片上传配置成功！',2);
            $log -> customerLog(__LINE__.":修改图片上传配置成功！\r\n");
            header("Content-type:text/html;charset=utf-8");
            echo "<script type='text/javascript'>" .
                "alert('修改成功！');" .
                "location.href='index.php?module=upserver';</script>";
        }
        
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>