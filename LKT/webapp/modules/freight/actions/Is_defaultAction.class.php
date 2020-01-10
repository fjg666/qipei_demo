<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Is_defaultAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/freight.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收信息
        $id = $request->getParameter('id'); // 产品id

        $sql = "select id,is_default from lkt_freight where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $y_id = 0;
            foreach ($r as $k => $v){
                $is_default = $v->is_default;

                if($is_default == 1){
                    $y_id = $v->id;
                }
            }
            if($y_id != 0){
                if($y_id == $id){
                    $sql = "update lkt_freight set is_default = 0 where store_id = '$store_id' and id = '$id'";
                    $r0 = $db->update($sql);
                    if($r0 > 0){
                        $JurisdictionAction->admin_record($store_id,$admin_name,' 修改规则ID为 '.$id.' 的信息成功',2);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改规则ID为 '.$id.' 的信息成功';
                        $lktlog->customerLog($Log_content);
                        $db->commit();
                        $res = array('status' => '1','info'=>'成功！');
                    }else{
                        $JurisdictionAction->admin_record($store_id,$admin_name,' 删除规则ID为 '.$id.' 失败',3);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除规则ID为'.$id.'失败';
                        $lktlog->customerLog($Log_content);

                        $db->rollback();
                        $res = array('status'=>0,'info'=>'删除规则失败！');
                    }
                }else{
                    $sql = "update lkt_freight set is_default = 0 where store_id = '$store_id' ";
                    $r0 = $db->update($sql);

                    $sql = "update lkt_freight set is_default = 1 where store_id = '$store_id' and id = '$id'";
                    $r1 = $db->update($sql);
                    if($r0 > 0 && $r1 > 0){
                        $JurisdictionAction->admin_record($store_id,$admin_name,' 修改规则ID为 '.$id.' 的信息成功',2);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改规则ID为 '.$id.' 的信息成功';
                        $lktlog->customerLog($Log_content);
                        $db->commit();
                        $res = array('status' => '1','info'=>'成功！');
                    }else{
                        $JurisdictionAction->admin_record($store_id,$admin_name,' 删除规则ID为 '.$id.' 失败',3);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除规则ID为'.$id.'失败';
                        $lktlog->customerLog($Log_content);

                        $db->rollback();
                        $res = array('status'=>0,'info'=>'删除规则失败！');
                    }
                }
            }else{
                $sql = "update lkt_freight set is_default = 1 where store_id = '$store_id' and id = '$id'";
                $r0 = $db->update($sql);
                if($r0 > 0){
                    $JurisdictionAction->admin_record($store_id,$admin_name,' 修改规则ID为 '.$id.' 的信息成功',2);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改规则ID为 '.$id.' 的信息成功';
                    $lktlog->customerLog($Log_content);
                    $db->commit();
                    $res = array('status' => '1','info'=>'成功！');
                }else{
                    $JurisdictionAction->admin_record($store_id,$admin_name,' 删除规则ID为 '.$id.' 失败',3);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除规则ID为'.$id.'失败';
                    $lktlog->customerLog($Log_content);

                    $db->rollback();
                    $res = array('status'=>0,'info'=>'删除规则失败！');
                }
            }
        }
        echo json_encode($res);
        return;
    }

    public function execute(){
        return $this->getDefaultView();
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>