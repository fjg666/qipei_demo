<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class MemberRecordDelAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $log = new LaiKeLogUtils('common/member.log');
        // 接收信息
        $id = $request->getParameter('id'); // id数组
        $type = $request->getParameter('type'); //id
        if($type == 'onekey'){
            $sql = "TRUNCATE TABLE lkt_admin_record";
            $db->query($sql);
            $db->admin_record($store_id,$admin_name,'一键清空管理员记录表',3);
        }else{
            $id = rtrim($id, ','); // 去掉最后一个逗号
            $id = explode(',',$id); // 变成数组
            foreach ($id as $k => $v){
                $sql = "delete from lkt_admin_record where id = '$v'";
                $res_0 = $db->delete($sql);
                if($res_0 < 0){
                    $log -> customerLog(__LINE__.':删除管理员日志记录失败，sql为：'.$sql."\r\n");
                    $res = array('status' => '1','info'=>'删除失败！');
                    echo json_encode($res);
                    exit;
                }
            }
            $db->admin_record($store_id,$admin_name,'批量删除管理员记录表',3);
        }

        $res = array('status' => '1','info'=>'删除成功！');
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