
<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class MoveAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $log = new LaiKeLogUtils('common/distribution.log');// 日志

        // 接收信息
        $id = $request->getParameter('id'); // 等级ID
        $cao = $request->getParameter('cao'); // 操作 up上移 down下移

        // 查询等级是否存在
        $sql = "select * from lkt_distribution_grade where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $sort = $r[0]->sort;
        if ($cao == 'up') {// 上移
            $sql01 = "select sort from lkt_distribution_grade where store_id = '$store_id' and sort<'$sort' order by sort desc limit 0,1";
            $r01 = $db->select($sql01);
            if ($r01) {
                $newsort = $r01[0]->sort;
                $sql = "update lkt_distribution_grade set sort=sort+1 where store_id = '$store_id' and sort>='$newsort' and sort<'$sort'";
                $res = $db->delete($sql);
                $sql = "update lkt_distribution_grade set sort='$newsort' where store_id = '$store_id' and id='$id'";
                $res = $db->delete($sql);
            }
            $log -> customerLog(__LINE__.":修改分销等级排序：等级 ".$id."上移\r\n");
            $db->admin_record($store_id,$admin_name,'等级'.$id.'上移',1);
            echo json_encode(array('status' => 1, 'suc' => '1'));
            exit;
        }else{// 下移
            $sql01 = "select sort from lkt_distribution_grade where store_id = '$store_id' and sort>'$sort' order by sort asc limit 0,1";
            $r01 = $db->select($sql01);
            if ($r01) {
                $newsort = $r01[0]->sort;
                $sql = "update lkt_distribution_grade set sort=sort-1 where store_id = '$store_id' and sort<='$newsort' and sort>'$sort'";
                $res = $db->delete($sql);
                $sql = "update lkt_distribution_grade set sort='$newsort' where store_id = '$store_id' and id='$id'";
                $res = $db->delete($sql);
            }
            $log -> customerLog(__LINE__.":修改分销等级排序：等级 ".$id."下移\r\n");
            $db->admin_record($store_id,$admin_name,'等级'.$id.'下移',1);
            echo json_encode(array('status' => 1, 'suc' => '1'));
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