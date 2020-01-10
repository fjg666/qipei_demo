<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = trim($request->getParameter('id'));

        $sql1 = "select m.*,u.user_name from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where m.store_id = '$store_id' and m.id = '$id'";
        $res = $db -> select($sql1);
        $list = $res ? $res[0]:array();
        if($res){
            foreach ($res as $k => $v){
                $v->logo = ServerPath::getimgpath($v->logo,$store_id);
                $v->business_license = ServerPath::getimgpath($v->business_license,$store_id);
            }
        }
        $request->setAttribute('list',(object)$list);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/mch.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = trim($request->getParameter('id'));
        $user_id = trim($request->getParameter('user_id'));
        $mch = $request->getParameter('mch');

        if($mch['tel'] == ''){
            echo json_encode(array('status' => "联系电话不能为空！"));exit;
        }
        if($mch['address'] == ''){
            echo json_encode(array('status' => "联系地址不能为空！"));exit;
        }
        $shop_information = $mch['shop_information'];
        $shop_range = $mch['shop_range'];
        $tel = $mch['tel'];
        $address = $mch['address'];
        $logo = preg_replace('/.*\//', '', $mch['logo']);
        $shop_nature = $mch['shop_nature'];
        $is_open = $mch['is_open'];
        $rew = " shop_information = '$shop_information',shop_range = '$shop_range',tel = '$tel',address = '$address',logo = '$logo',shop_nature = '$shop_nature',is_open = '$is_open'";
        $sql = "update lkt_mch set $rew where id = '$id'";
        $r = $db->update($sql);
        if($r == -1){
            $JurisdictionAction->admin_record($store_id,$admin_name,' 修改 '.$user_id.' 的开店信息失败 ',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改 '.$user_id.' 的开店信息失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '未知原因，修改失败！'));
            exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,' 修改 '.$user_id.' 的开店信息成功 ',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改 '.$user_id.' 的开店信息成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '修改成功！', 'suc' => '1'));
            exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>