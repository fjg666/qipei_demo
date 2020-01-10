<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class OperationAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/product.log");
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        // 接收信息
        $id = $request->getParameter('id'); // 产品id
        $type = $request->getParameter('type');

        if($id && $id != 'null'){
            $id = rtrim($id, ','); // 去掉最后一个逗号
            $id = explode(',',$id); // 变成数组

            foreach ($id as $k => $v){
                // 查询商品信息(产品值属性 1：新品,2：热销，3：推荐)
                $sql0 = "select s_type from lkt_product_list where id = '$v'";
                $r0 = $db->select($sql0);
                if($r0){
                    $s_type1 = $r0[0]->s_type;
                    $s_type = explode(',',$s_type1); // 转数组
                }else{
                    $s_type = array();
                }
                if($type == 1 || $type == 2){ // 当为上下架时
                    $Tools = new Tools($db, $store_id, 1);
                    $Tools->commodity_status($db,$store_id,$v);
                    if($type == 1){
                        $status = 2;
                        $sql = "update lkt_product_list set status = 2,upper_shelf_time = CURRENT_TIMESTAMP where id = '$v'";
                        $rr = $db->update($sql);
                    }else{
                        $status = 3;
                        $res = Tools::del_banner($db,$store_id,$v,'productId');
                        if($res == false){
                            echo json_encode(array('status' =>'2','info' =>'此商品已被使用，请取消绑定后再做删除操作！' ));exit;
                        }
                    }
                    $sql = "update lkt_product_list set status = '$status' where id = '$v'";
                }else if($type >= 3) { // 当不为上下架时
                    if ($type == 3) {
                        $add_type = 1; // 新品
                        if(in_array($add_type,$s_type)){ // 存在
                            $sql = "update lkt_product_list set s_type = '$s_type1' where id = '$v'";
                        }else{ // 不存在
                            $s_type2 = implode(',',array_merge($s_type, (array)$add_type)); // 把两个数组合并为一个数组,在把数组转字符串
                            $sql = "update lkt_product_list set s_type = '$s_type2' where id = '$v'";
                        }
                    } else if ($type == 4) {
                        $del_type = 1; // 取消新品
                        if(in_array($del_type,$s_type)){ // 存在
                            foreach ($s_type as $key=>$value){
                                if ($value == $del_type){
                                    unset($s_type[$key]); // 去除数组元素
                                }
                            }
                            $s_type3 = implode(',',$s_type); // 数组转字符串
                            $sql = "update lkt_product_list set s_type = '$s_type3' where id = '$v'";
                        }else{
                            $sql = "update lkt_product_list set s_type = '$s_type1' where id = '$v'";
                        }
                    } else if ($type == 5) {
                        $add_type = 2; // 热销
                        if(in_array($add_type,$s_type)){ // 存在
                            $sql = "update lkt_product_list set s_type = '$s_type1' where id = '$v'";
                        }else{ // 不存在
                            $s_type2 = implode(',',array_merge($s_type, (array)$add_type));
                            $sql = "update lkt_product_list set s_type = '$s_type2' where id = '$v'";
                        }
                    } else if ($type == 6) {
                        $del_type = 2; // 取消热销
                        if(in_array($del_type,$s_type)){ // 存在
                            foreach ($s_type as $key=>$value){
                                if ($value == $del_type){
                                    unset($s_type[$key]);
                                }
                            }
                            $s_type3 = implode(',',$s_type);
                            $sql = "update lkt_product_list set s_type = '$s_type3' where id = '$v'";
                        }else{
                            $sql = "update lkt_product_list set s_type = '$s_type1' where id = '$v'";
                        }
                    } else if ($type == 7) {
                        $add_type = 3; // 推荐
                        if(in_array($add_type,$s_type)){ // 存在
                            $sql = "update lkt_product_list set s_type = '$s_type1' where id = '$v'";
                        }else{ // 不存在
                            $s_type2 = implode(',',array_merge($s_type, (array)$add_type));
                            $sql = "update lkt_product_list set s_type = '$s_type2' where id = '$v'";
                        }
                    } else if ($type == 8) {
                        $del_type = 3; // 取消推荐
                        if(in_array($del_type,$s_type)){ // 存在
                            foreach ($s_type as $key=>$value){
                                if ($value == $del_type){
                                    unset($s_type[$key]);
                                }
                            }
                            $s_type3 = implode(',',$s_type);
                            $sql = "update lkt_product_list set s_type = '$s_type3' where id = '$v'";
                        }else{
                            $sql = "update lkt_product_list set s_type = '$s_type1' where id = '$v'";
                        }
                    }

                }

                $r = $db->update($sql);
                if($r == -1){
                    if($type == 1 || $type == 2){
                        $JurisdictionAction->admin_record($store_id,$admin_name,' 修改商品ID为 '.$v.' 的状态失败 ',2);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品ID为 '.$v.' 的状态失败';
                    }else{
                        $JurisdictionAction->admin_record($store_id,$admin_name,' 修改商品ID为 '.$v.' 的类型失败 ',2);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品ID为 '.$v.' 的类型失败';
                    }
                    $lktlog->customerLog($Log_content);
                    $db->rollback();
                    echo json_encode(array('status' => '0','info'=>'操作失败！'));
                    return;
                }else{
                    if($type == 1 || $type == 2){
                        $JurisdictionAction->admin_record($store_id,$admin_name,' 修改商品ID为 '.$v.' 的状态 ',2);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品ID为 '.$v.' 的状态';
                    }else{
                        $JurisdictionAction->admin_record($store_id,$admin_name,' 修改商品ID为 '.$v.' 的类型 ',2);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品ID为 '.$v.' 的类型';
                    }
                    $lktlog->customerLog($Log_content);
                }
            }
        }else{
            echo json_encode(array('status' =>'0','info' =>'请选择商品！' ));exit;
        }

        $db->commit();
        $res = array('status' => '1','info'=>'操作成功！');
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