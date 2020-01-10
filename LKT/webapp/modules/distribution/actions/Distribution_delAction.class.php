
<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class Distribution_delAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $log = new LaiKeLogUtils('common/distribution.log');// 日志

        // 接收信息
        $id = $request->getParameter('id');

        // 查询等级是否存在分销商
        $sql = "select id from lkt_user_distribution where level='$id'";
        $r = $db->select($sql);
        if (count($r) > 0) {
            $db->admin_record($store_id,$admin_name,'删除分销等级id为'.$id.'失败',1);
            $log -> customerLog(__LINE__.":删除分销等级：等级： ".$id."\r\n");
            echo json_encode(array('status' => 2,'info'=>'该等级存在分销商，无法删除！'));
            exit;
        }

        // 删除该等级
        $sql = "delete from lkt_distribution_grade where store_id = '$store_id' and id = '$id'";
        $res = $db->delete($sql);
        if($res > 0){
            $db->admin_record($store_id,$admin_name,'删除分销等级id为'.$id,1);
            $log -> customerLog(__LINE__.":删除分销等级：等级： ".$id."\r\n");
            echo json_encode(array('status' => 1, 'suc' => '1'));
            exit;
        }else{
            $db->admin_record($store_id,$admin_name,'删除分销等级id为'.$id.'失败',1);
            $log -> customerLog(__LINE__.":删除分销等级：等级： ".$id."\r\n");
            echo json_encode(array('status' => 0));
            exit;
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