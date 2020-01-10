<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  17:50
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $log = new LaiKeLogUtils('common/member.log');
        // 接收信息
        $id = $request->getParameter('id'); //id

        $sql = "select * from lkt_admin where name = '$admin_name'";
        $r = $db->select($sql);
        if($r){
            $admin_type = $r[0]->admin_type;
            $type = $r[0]->type;
            $admin_id1 = $r[0]->id;
            if($admin_type == 1 || $type == 1){
                if($admin_id1 == $id){
                    $res = array('status' => '2','info'=>'不能删除自己！');
                    echo json_encode($res);exit;
                }else{
                    $sql = "select name from lkt_admin where id = '$id'";
                    $r = $db->select($sql);
                    $name = $r[0]->name;

                    $sql = "update lkt_admin set recycle = 1 , status = 1 where id = $id";
                    $res_0 = $db->update($sql);
                    if($res_0 < 0){
                        $log -> customerLog(__LINE__.':删除管理员失败，sql为：'.$sql."\r\n");
                    }

                    $db->admin_record($store_id,$admin_name,' 删除管理员 '.$name,3);


                    $res = array('status' => '1','info'=>'删除成功！');
                    echo json_encode($res);exit;
                }
            }else{
                $res = array('status' => '0','info'=>'无权操作！');
                echo json_encode($res);exit;
            }
        }

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