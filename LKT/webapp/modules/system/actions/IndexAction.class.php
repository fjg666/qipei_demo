<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class IndexAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $appid = $r[0]->appid; // 小程序id
            $appsecret = $r[0]->appsecret; // 小程序密钥
        }
       
        $request->setAttribute("appid", isset($appid) ? $appid : '');
        $request->setAttribute('appsecret', isset($appsecret) ? $appsecret : '');
        return View :: INPUT;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        //取得参数
        $appid= addslashes($request->getParameter('appid')); // 小程序id
        $appsecret = addslashes(trim($request->getParameter('appsecret'))); // 小程序密钥

        $log = new LaiKeLogUtils('common/system.log');// 日志

        if($appid == ''){
            $log -> customerLog(__LINE__.":修改系统设置失败：小程序id不能为空！ \r\n");
            echo json_encode(array('status' => '小程序id不能为空！'));exit;
        }
        if($appsecret == ''){
            $log -> customerLog(__LINE__.":修改系统设置失败：小程序密钥不能为空！ \r\n");
            echo json_encode(array('status' => '小程序密钥不能为空！'));exit;
        }

        $sql0 = "select * from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            // 更新
            $sql1 = "update lkt_config set appid = '$appid',appsecret = '$appsecret',modify_date = CURRENT_TIMESTAMP where store_id = '$store_id'";
            $r1 = $db->update($sql1);
            if($r1 == -1) {
                $db->admin_record($store_id,$admin_name,'修改系统设置失败！',2);
                $log -> customerLog(__LINE__.":修改系统设置失败：$sql \r\n");
                echo json_encode(array('status' => '未知原因，修改失败！！'));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'修改系统设置',2);
                $log -> customerLog(__LINE__.":修改系统设置成功！ \r\n");
                echo json_encode(array('status' => '修改成功！','suc'=>'1'));exit;
            }
        }else{
            $sql1 = "insert into lkt_config(store_id,appid,appsecret,modify_date) value('$store_id','$appid','$appsecret',CURRENT_TIMESTAMP)";
            $r1 = $db->insert($sql1);
            if($r1 == -1) {
                $db->admin_record($store_id,$admin_name,'添加系统设置失败！',1);
                $log -> customerLog(__LINE__.":添加系统设置失败：$sql1 \r\n");
                echo json_encode(array('status' => '未知原因，添加失败！！'));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'添加系统设置成功！',1);
                $log -> customerLog(__LINE__.":添加系统设置成功！ \r\n");
                echo json_encode(array('status' => '添加成功！','suc'=>'1'));exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>