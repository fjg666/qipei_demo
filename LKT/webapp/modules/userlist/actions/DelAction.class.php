<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $id = $request->getParameter('id'); // id
        // 根据新闻id，删除新闻信息
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $log = new LaiKeLogUtils('common/userlist.log');

        $sql01 = "select a.id,a.sNo,a.status from lkt_order as a ,lkt_user as b  where a.user_id = b.user_id and b.user_id = '$id' and b.store_id='{$store_id}' and a.store_id = '{$store_id}' and a.status in (0,1,2,3)";

       $re = $db->selectrow($sql01);

            if($re>0){//有订单，不能删除
                 $db->admin_record($store_id,$admin_id,'删除用户 '.$id.' 失败',24);
                    $res = array('status' => '2','info'=>'该用户有未完成的订单，不能删除');
                    echo json_encode($res);
                    exit();
            }else{
                    $db->begin();
                    $code = true;
                    $a=$db->admin_record($store_id,$admin_id,' 删除用户 '.$id,24);
                    $sql = "delete from lkt_user where user_id = '$id' and store_id='{$store_id}'";
                    $res = $db->delete($sql);
                    if($res < 0){
                        $code = false;
                        $log -> customerLog(__LINE__.':删除用户失败，sql为：'.$sql."\r\n");
                        $db->rollback();
                    }
                    //删除用户对应订单
                    $sql_0 = "delete from lkt_order where store_id = '$store_id' and user_id = '$id'";
                    $res_0 = $db->delete($sql_0);
                    if($res_0 < 0){
                        $code = false;
                        $log -> customerLog(__LINE__.':删除用户订单失败，sql为：'.$sql_0."\r\n");
                        $db->rollback();
                    }
                    //删除用户订单详情
                    $sql_1 = "delete from lkt_order_details where store_id = '$store_id' and user_id = '$id'";
                    $res_1 = $db->delete($sql_1);
                    if($res_1 < 0){
                        $code = false;
                        $log -> customerLog(__LINE__.':删除用户订单详情失败，sql为：'.$sql_1."\r\n");
                        $db->rollback();
                    }
                    //删除用户地址
                    $sql_2 = "delete from lkt_user_address where store_id = '$store_id' and uid = '$id'";
                    $res_2 = $db->delete($sql_2);
                    if($res_2 < 0){
                        $code = false;
                        $log -> customerLog(__LINE__.':删除用户收货地址失败，sql为：'.$sql_2."\r\n");
                        $db->rollback();
                    }
                    //删除用户收藏信息
                    $sql_3 = "delete from lkt_user_collection where store_id = '$store_id' and user_id = '$id'";
                    $res_3 = $db->delete($sql_3);
                    if($res_3 < 0){
                        $code = false;
                        $log -> customerLog(__LINE__.':删除用户收藏历史失败，sql为：'.$sql_3."\r\n");
                        $db->rollback();
                    }

                    if($code){
                        $db->commit();
                        echo json_encode(array('status'=>1,'info'=>'删除成功'));
                        exit;
                    }else{
                        echo json_encode(array('status'=>2,'info'=>'删除失败'));
                        exit;
                    }
                    
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