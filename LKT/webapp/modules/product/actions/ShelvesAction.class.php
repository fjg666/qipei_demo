<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ShelvesAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/product.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号

        $id = intval($request->getParameter("id")); // 商品id
        $url = $request->getParameter("url"); // 路径

        $sql = "select status,num from lkt_product_list where id = '$id'";
        $r = $db->select($sql);

        if($r[0]->num < 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'商品ID为 '.$id.' 操作失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为 '.$id.' 操作失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '0','info'=>'失败！')); exit;
        }

        if($r[0]->status == 2){
            $res = Tools::del_banner($db,$store_id,$id,'productId');
            if($res == false){
                echo json_encode(array('status' =>'2','info' =>'此商品已被使用，请取消绑定后再做删除操作！' ));exit;
            }

            $sql = "update lkt_product_list set status = 3 where id = '$id'";
            $rr = $db->update($sql);
            if($rr > 0){
                $JurisdictionAction->admin_record($store_id,$admin_name,'商品ID为 '.$id.' 下架成功',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为 '.$id.' 下架成功';
                $lktlog->customerLog($Log_content);

                $db->commit();
                echo json_encode(array('status' => '1','info'=>'下架成功！')); exit;
            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,' 商品ID为 '.$id.' 下架失败',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为 '.$id.' 下架失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '0','info'=>'下架失败！')); exit;
            }
        }else{
            $sql = "update lkt_product_list set status = 2,upper_shelf_time = CURRENT_TIMESTAMP where id = '$id'";
            $rr = $db->update($sql);
            if($rr > 0){
                $JurisdictionAction->admin_record($store_id,$admin_name,' 商品ID为 '.$id.' 上架成功',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为 '.$id.' 上架成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '1','info'=>'上架成功！')); exit;
            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,' 商品ID为 '.$id.' 上架失败',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 商品ID为 '.$id.' 上架失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '0','info'=>'上架失败！')); exit;
            }
        }
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = intval($request->getParameter("id")); // 商品id

        $Tools = new Tools($db, $store_id, 1);
        $Tools->commodity_status($db,$store_id,$id);

        echo json_encode(array('status' => '1')); exit;
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>