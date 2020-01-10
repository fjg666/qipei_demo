<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
    }

    public function execute(){
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/product_class.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id
        // 获取分类id
        $cid = intval($request->getParameter('cid'));
        $uploadImg = addslashes(trim($request->getParameter('uploadImg'))); // 图片路径

        // 根据分类id,查询产品分类表
        $sql = "select * from lkt_product_class where cid = '$cid' and store_id = '$store_id'";
        $r = $db->select($sql);
        $level = $r[0]->level;
        $cid_r = $r[0]->cid;
        $str_option = array();
        $num = 0;
        $str_option[$num] = $cid;
        if($level >= 0){
            $str_option = $this->str_option($level,$cid,$str_option,$num);
        }
        foreach ($str_option as $k => $v){
            $res = Tools::del_banner($db,$store_id,$v,'cid');
            if($res == false){
                echo json_encode(array('status' =>'2','info' =>'此分类已被使用，请更改状态后再做删除操作！' ));exit;
            }
        }
        foreach ($str_option as $k => $v){
            $sql = "select * from lkt_product_class where cid = '$v' and store_id = '$store_id'";
            $rr = $db->select($sql);
            $img = $rr[0]->img;
            $sql = "update lkt_product_class set recycle = 1 where cid = '$v' and store_id = '$store_id'";
            $res = $db->update($sql);
            if($res == -1){
                $JurisdictionAction->admin_record($store_id,$admin_name,'删除商品分类ID为 '.$v.' 失败',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除商品分类ID为 '.$v.' 失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'0'));exit;
            }else{
                @unlink ($uploadImg.$img);
                $JurisdictionAction->admin_record($store_id,$admin_name,'删除商品分类ID为 '.$v.'成功',3);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除商品分类ID为 '.$v.'成功';
                $lktlog->customerLog($Log_content);
            }
        }

        $db->commit();
        echo json_encode(array('status' =>'1'));exit;
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    //递归找下级
    public function str_option($level,$cid,$str_option,$num){
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

        $sqlc = "select cid from lkt_product_class where recycle = 0 and store_id = '$store_id' and sid = '$cid'";
        $res = $db->select($sqlc);
        if($res){
            foreach ($res as $k => $v){
                $num++;
                $str_option[$num] = $v->cid;
                $this->str_option($level,$v->cid,$str_option,$num);
            }
            return $str_option;
        }else{
            return $str_option;
        }
    }
}
?>