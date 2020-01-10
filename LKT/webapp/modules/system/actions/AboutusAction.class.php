<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class AboutusAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Config');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Agreement');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=system&action=Aboutus');

        $sql = "select aboutus from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $aboutus = $r[0]->aboutus;  // 关于我们
        }
       
        $request->setAttribute('aboutus', isset($aboutus) ? $aboutus : '');
        $request->setAttribute('button', $button);

        return View :: INPUT;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号

        $aboutus = addslashes(trim($request->getParameter('aboutus'))); // 关于我们

        $log = new LaiKeLogUtils('common/system.log');// 日志

        if($aboutus == ''){
            $log -> customerLog(__LINE__.":修改关于我们失败：内容设置不能为空！ \r\n");
            $db->admin_record($store_id,$admin_name,'修改关于我们失败！',2);
            echo json_encode(array('status' => '内容设置不能为空！'));exit;
        }

        // 更新
        $sql = "update lkt_config set aboutus = '$aboutus',modify_date = CURRENT_TIMESTAMP where store_id = '$store_id'";
        $r = $db->update($sql);
        if($r == -1) {
            $db->admin_record($store_id,$admin_name,'修改关于我们失败！',2);
            $log -> customerLog(__LINE__.":修改关于我们失败：$sql \r\n");
            echo json_encode(array('status' => '未知原因，修改失败！'));exit;
        } else {
            $db->admin_record($store_id,$admin_name,'修改关于我们成功！',2);
            $log -> customerLog(__LINE__.":修改关于我们成功！ \r\n");
            echo json_encode(array('status' => '修改成功！','suc'=>'1'));exit;
        }

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}

?>