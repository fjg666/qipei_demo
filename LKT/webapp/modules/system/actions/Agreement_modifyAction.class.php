<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Agreement_modifyAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = addslashes(trim($request->getParameter('id'))); // id

        $sql = "select * from lkt_agreement where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $type = $r?$r[0]->type:''; // 公司logo
        $content = $r?$r[0]->content:'';  // 用户协议
        $name = $r ? $r[0]->name:'';//标题

        $request->setAttribute('id', $id);
        $request->setAttribute('type', $type);
        $request->setAttribute('content',$content);
        $request->setAttribute('name',$name);

        return View :: INPUT;
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        //取得参数
        $id = addslashes(trim($request->getParameter('id'))); // id
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
        $sql0 = "select * from lkt_agreement where store_id = '$store_id' and type = '$type' and id != '$id'";
        $r0 = $db->select($sql0);
        if($r0){
            $db->admin_record($store_id,$admin_name,' 修改协议id为 '.$id.' 的信息失败！',2);
            $log -> customerLog(__LINE__.":修改协议失败:该类协议已存在！ \r\n");
            echo json_encode(array('status' => '该类协议已存在！'));exit;
        }
        if($content == ''){
            $db->admin_record($store_id,$admin_name,' 修改协议id为 '.$id.' 的信息失败！',2);
            $log -> customerLog(__LINE__.":修改协议失败:协议内容不能为空！ \r\n");
            echo json_encode(array('status' => '协议内容不能为空！'));exit;
        }

        // 更新
        $sql = "update lkt_agreement set name = '$name',type = '$type',content = '$content',modify_date = CURRENT_TIMESTAMP where store_id = '$store_id' and id = '$id'";
        $r = $db->update($sql);
        if($r == -1) {
            $db->admin_record($store_id,$admin_name,'修改'.$res.'协议失败！',2);
            $log -> customerLog(__LINE__.":修改协议失败: $sql \r\n");
            echo json_encode(array('status' => '未知原因，修改失败！！'));exit;
        } else {
            $db->admin_record($store_id,$admin_name,'修改'.$res.'协议',2);
            $log -> customerLog(__LINE__.":修改协议成功！ \r\n");
            echo json_encode(array('status' => '修改成功！','suc'=>'1'));exit;
        }

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}

?>