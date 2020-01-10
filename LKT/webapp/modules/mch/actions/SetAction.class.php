<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class SetAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=List');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Set');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Product');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Withdraw');
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Withdraw_list');

        $sql = "select * from lkt_mch_config where store_id = '$store_id'";
        $r = $db -> select($sql);
        if($r){
            $logo = ServerPath::getimgpath($r[0]->logo,$store_id);
            $settlement = $r[0]->settlement;
            $min_charge = $r[0]->min_charge;
            $max_charge = $r[0]->max_charge;
            $service_charge = $r[0]->service_charge;
            $illustrate = $r[0]->illustrate;
            $agreement = $r[0]->agreement;
        }

        $request->setAttribute('button', $button);

        $request->setAttribute("logo", isset($logo) ? $logo : '');
        $request->setAttribute("settlement", isset($settlement) ? $settlement : '');
        $request->setAttribute("min_charge", isset($min_charge) ? $min_charge : '');
        $request->setAttribute("max_charge", isset($max_charge) ? $max_charge : '');
        $request->setAttribute("service_charge", isset($service_charge) ? $service_charge : '');
        $request->setAttribute("illustrate", isset($illustrate) ? $illustrate : '');
        $request->setAttribute("agreement", isset($agreement) ? $agreement : '');

        return View :: INPUT;

    }

    public function execute() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/mch.log");
        // 1.开启事务
        $db->begin();

        $this->db = $db;
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $logo = trim($request->getParameter('logo'));
        $oldpic = trim($request->getParameter('oldpic'));
        $settlement = trim($request->getParameter('settlement'));
        $min_charge = trim($request->getParameter('min_charge'));
        $max_charge = trim($request->getParameter('max_charge'));
        $service_charge = trim($request->getParameter('service_charge'));
        $illustrate = addslashes(trim($request->getParameter('illustrate')));
        $agreement = addslashes(trim($request->getParameter('agreement')));

        if($logo){
            $logo = preg_replace('/.*\//','',$logo); // 获取图片名称
            if($logo != $oldpic){
                $oldpic_1 = ServerPath::getimgpath($oldpic,$store_id);//
                @unlink ($oldpic_1);
            }
        }else{
            $logo = $oldpic;
        }
        if(empty($logo)){
            echo json_encode(array('status' =>'请上传默认店铺Logo！' ));exit;
        }
        if (is_numeric($min_charge)) {
            if (preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $min_charge)) {

            }else{
                echo json_encode(array('status' =>'最低提现金额格式错误！' ));exit;
            }
        } else {
            echo json_encode(array('status' =>'最低提现金额请填写数字！' ));exit;
        }
        if (is_numeric($max_charge)) {
            if (preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $max_charge)) {

            }else{
                echo json_encode(array('status' =>'最大提现金额格式错误！' ));exit;
            }
        } else {
            echo json_encode(array('status' =>'最大提现金额请填写数字！' ));exit;
        }
        if($max_charge <= $min_charge){
            echo json_encode(array('status' =>'最低提现金额不能大于最大提现金额！' ));exit;
        }
        if (is_numeric($service_charge)) {
            if (preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $service_charge)) {

            }else{
                echo json_encode(array('status' =>'手续费格式错误！' ));exit;
            }
        } else {
            echo json_encode(array('status' =>'手续费请填写数字！' ));exit;
        }
        $sql = "select * from lkt_mch_config where store_id = '$store_id' ";
        $navs = $db->select($sql);
        if ($navs) {
            $sql = "update lkt_mch_config set logo='$logo',settlement='$settlement',min_charge='$min_charge',max_charge='$max_charge',service_charge='$service_charge',illustrate='$illustrate',agreement='$agreement' where store_id = '$store_id'";
            $r = $db->update($sql);
            if ($r == -1) {
                $JurisdictionAction->admin_record($store_id,$admin_name,' 修改多商户设置失败 ',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改多商户设置失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'未知原因，修改失败！' ));exit;

            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,' 修改多商户设置成功 ',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改多商户设置成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' =>'修改成功！','suc'=>'1' ));exit;
            }
        } else {
            $sql = "insert into lkt_mch_config(store_id,logo,settlement,min_charge,max_charge,service_charge,illustrate,agreement) values ('$store_id','$logo','$settlement','$min_charge','$max_charge','$service_charge','$illustrate','$agreement')";
            $r = $db->insert($sql);
            if ($r > 0) {
                $JurisdictionAction->admin_record($store_id,$admin_name,' 添加多商户设置成功 ',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加多商户设置成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' =>'添加成功！','suc'=>'1' ));exit;
                exit();
            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,' 添加多商户设置失败 ',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加多商户设置失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;
            }
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>