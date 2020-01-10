<?php
//require_once(MO_LIB_DIR . '/DBAction.class.php');

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/client.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收信息
        $id = intval($request->getParameter('id')); //id
        // 查询所有没有回收的客户账号
        $sql = "select role from lkt_admin where type = 1 and recycle = 0";
        $r_admin = $db->select($sql);
        if($r_admin){
            foreach($r_admin as $k => $v){
                $role = explode(',',$v->role);
                if(in_array($id,$role)){
                    echo json_encode(array('status'=>2,'info'=>'该客户端正在使用!'));
                    exit;
                }
            }
        }

        // 根据id删除信息
        $sql = "delete from lkt_role where id = '$id'";
        $res = $db->delete($sql);

        if($res>0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除客户端ID为'.$id.'成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除客户端ID为'.$id.'成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status'=>1,'info'=>'成功!'));
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'删除客户端ID为'.$id.'失败',3);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除客户端ID为'.$id.'失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status'=>0,'info'=>'失败!'));
        }
        return;
    }

    public function execute(){

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>