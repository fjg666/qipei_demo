<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  14:35
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/mch.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号

        // 接收信息
        $id = $request->getParameter('id'); // 产品id

        $sql0 = "delete from lkt_mch where store_id = '$store_id' and id = '$id'";
        $r0 = $db->delete($sql0);
        if($r0){
            $sql1 = "select id from lkt_product_list where store_id = '$store_id' and mch_id = '$id'";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k => $v){
                    $p_id = $v->id;
                    // 根据产品id，删除产品信息
                    $sql2 = "update lkt_product_list set recycle = 1,status = 1 where store_id = '$store_id' and id = '$p_id'";
                    $r2 = $db->update($sql2);
                    if($r2 <= 0){
                        $JurisdictionAction->admin_record($store_id, $admin_name, '删除店铺ID为'.$id.'时，删除商品ID为'.$p_id.'失败', 3);
                        $Log_content = __METHOD__ . '->' . __LINE__ . '删除店铺ID为'.$id.'时，删除商品ID为'.$p_id.'失败';
                        $lktlog->customerLog($Log_content);
                        $db->rollback();

                        $res = array('status' => '0','info'=>'删除失败！');
                        echo json_encode($res);
                        return;
                    }
                    $sql3 = "update lkt_configure set recycle = 1 where pid = '$p_id";
                    $r3 = $db->update($sql3);
                    if($r3 <= 0){
                        $JurisdictionAction->admin_record($store_id, $admin_name, '删除店铺ID为'.$id.'时，删除商品ID为'.$p_id.'的属性失败', 3);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除店铺ID为'.$id.'时，删除商品ID为'.$p_id.'的属性失败';
                        $lktlog->customerLog($Log_content);
                        $db->rollback();
                        $res = array('status' => '0','info'=>'删除失败！');
                        echo json_encode($res);
                        return;
                    }
                    $sql4 = "update lkt_product_img set recycle = 1 where product_id = '$p_id'";
                    $r4 = $db->update($sql4);
                    if($r4 <= 0){
                        $JurisdictionAction->admin_record($store_id, $admin_name, '删除店铺ID为'.$id.'时，删除商品ID为'.$p_id.'的图片失败', 3);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除店铺ID为'.$id.'时，删除商品ID为'.$p_id.'的图片失败';
                        $lktlog->customerLog($Log_content);
                        $db->rollback();
                        $res = array('status' => '0','info'=>'删除失败！');
                        echo json_encode($res);
                        return;
                    }

                    $sql5 = "delete from lkt_cart where store_id = '$store_id' and Goods_id = '$p_id'";
                    $r5 = $db->delete($sql5);
                    if($r5 <= 0){
                        $JurisdictionAction->admin_record($store_id, $admin_name, '删除店铺ID为'.$id.'时，删除购物车里商品ID为'.$p_id.'失败', 3);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除店铺ID为'.$id.'时，删除购物车里商品ID为'.$p_id.'失败';
                        $lktlog->customerLog($Log_content);
                        $db->rollback();
                        $res = array('status' => '0','info'=>'删除失败！');
                        echo json_encode($res);
                        return;
                    }
                    $sql6 = "delete from lkt_user_footprint where store_id = '$store_id' and Goods_id = '$p_id'";
                    $r6 = $db->delete($sql6);
                    if($r6 <= 0){
                        $JurisdictionAction->admin_record($store_id, $admin_name, '删除店铺ID为'.$id.'时，删除足迹里商品ID为'.$p_id.'失败', 3);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除店铺ID为'.$id.'时，删除足迹里商品ID为'.$p_id.'失败';
                        $lktlog->customerLog($Log_content);
                        $db->rollback();
                        $res = array('status' => '0','info'=>'删除失败！');
                        echo json_encode($res);
                        return;
                    }
                    $sql7 = "delete from lkt_user_collection where store_id = '$store_id' and Goods_id = '$p_id' or mch_id = '$id'";
                    $r7 = $db->delete($sql7);
                    if($r7 <= 0){
                        $JurisdictionAction->admin_record($store_id, $admin_name, '删除店铺ID为'.$id.'时，删除收藏里商品ID为'.$p_id.'失败', 3);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除店铺ID为'.$id.'时，删除收藏里商品ID为'.$p_id.'失败';
                        $lktlog->customerLog($Log_content);
                        $db->rollback();
                        $res = array('status' => '0','info'=>'删除失败！');
                        echo json_encode($res);
                        return;
                    }
                }
            }
            $JurisdictionAction->admin_record($store_id, $admin_name, '删除店铺ID为'.$id.'成功', 3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除店铺ID为'.$id.'成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            $res = array('status' => '1','info'=>'成功！');
            echo json_encode($res);
            return;
        }else{
            $JurisdictionAction->admin_record($store_id, $admin_name, '删除店铺ID为'.$id.'失败', 3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除店铺ID为'.$id.'失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            $res = array('status' => '0','info'=>'删除失败！');
            echo json_encode($res);
            return;
        }
    }

    public function execute(){
        return $this->getDefaultView();
    }


    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>