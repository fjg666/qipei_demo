<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class StickAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/product.log");

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $id = trim($request->getParameter("id")); // id
        $upper_id = trim($request->getParameter("upper_id")); // 上条数据id
        $underneath_id = trim($request->getParameter("underneath_id")); // 下条条数据id
        $upper_status = trim($request->getParameter("upper_status")); // 上条数据id

        $res = 0;
        //进入正式添加---开启事物
        $db->begin();

        // 根据ID，查询商品状态和排序号
        $sql0 = "select sort from lkt_product_list where store_id = '$store_id' and recycle = 0 and id = '$id'";
        $r0 = $db->select($sql0);
        $sort0 = $r0[0]->sort; // 排序号

        if($upper_status){ // 上移
            // 上条数据ID，查询商品状态和排序号
            $sql1 = "select sort from lkt_product_list where store_id = '$store_id' and recycle = 0 and id = '$upper_id'";
            $r1 = $db->select($sql1);
            $sort1 = $r1[0]->sort; // 上条数据排序号

            // 修改当前商品排序
            $sql2 = "update lkt_product_list set sort = '$sort1' where store_id = '$store_id' and recycle = 0 and id = '$id'";
            $r2 = $db->update($sql2);
            // 修改上条数据商品排序
            $sql3 = "update lkt_product_list set sort = '$sort0' where store_id = '$store_id' and recycle = 0 and id = '$upper_id'";
            $r3 = $db->update($sql3);

            if($r2 > 0 && $r3 > 0){
                $JurisdictionAction->admin_record($store_id,$admin_name,'上移商品ID为'.$id.'成功',7);

                $Log_content = __METHOD__ . '->' . __LINE__ . ' 上移商品ID为'.$id.'成功';
                $lktlog->customerLog($Log_content);

                $db->commit();

                $res = 1;
            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,'上移商品ID为'.$id.'失败',7);

                $Log_content = __METHOD__ . '->' . __LINE__ . ' 上移商品ID为'.$id.'失败';
                $lktlog->customerLog($Log_content);

                $db->rollback();
            }
        }else{ // 下移
            // 下条数据ID，查询商品状态和排序号
            $sql1 = "select sort from lkt_product_list where store_id = '$store_id' and recycle = 0 and id = '$underneath_id'";
            $r1 = $db->select($sql1);
            $sort1 = $r1[0]->sort; // 下条数据排序号

            // 修改当前商品排序
            $sql2 = "update lkt_product_list set sort = '$sort1' where store_id = '$store_id' and recycle = 0 and id = '$id'";
            $r2 = $db->update($sql2);
            // 修改上条数据商品排序
            $sql3 = "update lkt_product_list set sort = '$sort0' where store_id = '$store_id' and recycle = 0 and id = '$underneath_id'";
            $r3 = $db->update($sql3);

            if($r2 > 0 && $r3 > 0){
                $JurisdictionAction->admin_record($store_id,$admin_name,'下移商品ID为'.$id.'成功',7);

                $Log_content = __METHOD__ . '->' . __LINE__ . ' 下移商品ID为'.$id.'成功';
                $lktlog->customerLog($Log_content);

                $db->commit();

                $res = 1;
            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,'下移商品ID为'.$id.'失败',7);

                $Log_content = __METHOD__ . '->' . __LINE__ . ' 下移商品ID为'.$id.'失败';
                $lktlog->customerLog($Log_content);

                $db->rollback();
            }
        }

        echo $res;
        exit;
        return;

    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/banner.log");

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $id = $request->getParameter("id"); // id
        //进入正式添加---开启事物
        $db->begin();

        $sort_sql = "select MAX(sort) as sort from lkt_product_list where store_id = '$store_id' and recycle = 0";
        $sort_r = $db->select($sort_sql);
        $sort= $sort_r[0]->sort +1;

        $sql = "update lkt_product_list set sort = '$sort' where store_id = '$store_id' and recycle = 0 and id = '$id'";
        $r = $db->update($sql);
        if($r > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'置顶商品ID为'.$id.'成功',7);

            $Log_content = __METHOD__ . '->' . __LINE__ . ' 置顶商品ID为'.$id.'成功';
            $lktlog->customerLog($Log_content);

            $db->commit();
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'置顶商品ID为'.$id.'失败',7);

            $Log_content = __METHOD__ . '->' . __LINE__ . ' 置顶商品ID为'.$id.'失败';
            $lktlog->customerLog($Log_content);

            $db->rollback();
        }
        echo $r;
        exit;
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>