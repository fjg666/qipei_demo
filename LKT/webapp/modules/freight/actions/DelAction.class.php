<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {

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

        $id = rtrim($id, ','); // 去掉最后一个逗号
        $sql = "SELECT * from lkt_product_list where store_id = '$store_id' and recycle = 0 and freight in ($id)";
        $ishas = $db->select($sql);
        if($ishas){
            $res = array('status'=>500,'info'=>'含有商品设置该运费规则，不能删除！');
            echo json_encode($res);
            exit;
        }
        $id = explode(',',$id); // 变成数组
        if(count($id) > 1){
            foreach ($id as $k => $v){
                $sql = "select id from lkt_product_list where store_id = '$store_id' and freight = '$v' ";
                $r = $db->select($sql);
                if($r){
                    $sql = "update lkt_product_list set freight = 0 where store_id = '$store_id' and id = " . $r[0]->id;
                    $db->update($sql);
                }
                // 根据产品id，删除产品信息
                $sql0 = "delete from lkt_freight where store_id = '$store_id' and id = '$v'";
                $r0 = $db->delete($sql0);
                if($r0 > 0){
                    $JurisdictionAction->admin_record($store_id,$admin_name,' 删除规则ID为 '.$v.' 的信息',3);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除规则ID为 '.$v.' 的信息';
                    $lktlog->customerLog($Log_content);

                }else{
                    $JurisdictionAction->admin_record($store_id,$admin_name,' 删除规则ID为 '.$v.' 失败',3);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除规则ID为'.$v.'失败';
                    $lktlog->customerLog($Log_content);

                    $db->rollback();
                    $res = array('status'=>0,'info'=>'删除规则失败！');
                    echo json_encode($res);
                    exit;
                }
            }
        }else{
            $fid = $id[0];
            $sql = "select id from lkt_freight where store_id = '$store_id' and id = '$fid' and is_default = 1";
            $r = $db->select($sql);
            if($r){
                $res = array('status'=>0,'info'=>'默认规则不能修改！');
                echo json_encode($res);
                exit;
            }
            // 根据产品id，删除产品信息
            $sql0 = "delete from lkt_freight where store_id = '$store_id' and id = '$fid'";
            $r0 = $db->delete($sql0);
            if($r0 > 0){
                $JurisdictionAction->admin_record($store_id,$admin_name,' 删除规则ID为 '.$fid.' 的信息',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除规则ID为 '.$fid.' 的信息';
                $lktlog->customerLog($Log_content);

            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,' 删除规则ID为 '.$fid.' 失败',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除规则ID为'.$fid.'失败';
                $lktlog->customerLog($Log_content);

                $db->rollback();
                $res = array('status'=>0,'info'=>'删除规则失败！');
                echo json_encode($res);
                exit;
            }
        }
        $db->commit();
        $res = array('status'=>1,'info'=>'成功！');
        echo json_encode($res);
        exit;
    }

    public function execute(){
        return $this->getDefaultView();
    }


    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>