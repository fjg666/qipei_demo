<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AppAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $sql = "select app_domain_name from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $app_domain_name = $r[0]->app_domain_name; // APP域名
        }
       
        $request->setAttribute("app_domain_name", isset($app_domain_name) ? $app_domain_name : '');
        return View :: INPUT;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        //取得参数
        $app_domain_name= addslashes($request->getParameter('app_domain_name')); // APP域名

        $log = new LaiKeLogUtils('common/system.log');// 日志

        if($app_domain_name == ''){
            $db->admin_record($store_id,$admin_name,'修改H5配置失败',1);
            $log -> customerLog(__LINE__.":修改H5配置失败：APP域名不能为空！ \r\n");
            echo json_encode(array('status' => 'APP域名不能为空！'));exit;
        }
        $sql0 = "select * from lkt_config where store_id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            // 更新
            $sql = "update lkt_config set app_domain_name = '$app_domain_name',modify_date = CURRENT_TIMESTAMP where store_id = '$store_id'";
            $r = $db->update($sql);
            if($r == -1) {
                $db->admin_record($store_id,$admin_name,'修改H5配置失败',1);
                $log -> customerLog(__LINE__.":修改H5配置失败：$sql \r\n");
                echo json_encode(array('status' => '未知原因，修改失败！！'));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'修改H5配置',1);
                $log -> customerLog(__LINE__.":修改H5配置成功！ \r\n");
                echo json_encode(array('status' => '修改成功！','suc'=>'1'));exit;
            }
        }else{
            $sql1 = "insert into lkt_config(store_id,app_domain_name,modify_date) values ('$store_id','$app_domain_name',CURRENT_TIMESTAMP)";
            $r1 = $db->insert($sql1);
            if($r1 > 0){
                $db->admin_record($store_id,$admin_name,'添加H5配置',1);
                $log -> customerLog(__LINE__.":添加H5配置成功！ \r\n");
                echo json_encode(array('status' => '添加成功！','suc'=>'1'));exit;
            }else{
                $db->admin_record($store_id,$admin_name,'添加H5配置失败',1);
                $log -> customerLog(__LINE__.":添加H5配置失败：$sql1 \r\n");
                echo json_encode(array('status' => '未知原因，添加失败！！'));exit;
            }
        }

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>