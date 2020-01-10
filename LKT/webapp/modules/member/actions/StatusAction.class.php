<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class StatusAction extends Action {

	public function getDefaultView() {
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $log = new LaiKeLogUtils('common/member.log');
        $id = addslashes(trim($request->getParameter('id')));

        $sql = "select * from lkt_admin where id = '$admin_id'";
        $r = $db->select($sql);
        if($r){
            $admin_type = $r[0]->admin_type;
            $type = $r[0]->type;
            if($admin_type == 1 || $type == 1){
                if($admin_id == $id){
                    $res = array('status' => '2','info'=>'不能禁用自己！');
                    echo json_encode($res);
                }else{
                    $sql = "select name,status from lkt_admin where id = '$id'";
                    $r = $db->select($sql);
                    if($r){
                        $name = $r[0]->name;
                        $status = $r[0]->status;
                        if($status == 1){
                            $sql = "update lkt_admin set status = 2,login_num = 0  where id = '$id'";
                            $res_1 = $db->update($sql);
                            if($res_1 < 0){
                                $log -> customerLog(__LINE__.':更新管理员状态失败，sql为：'.$sql."\r\n");
                            }
                            $db->admin_record($store_id,$admin_name,'启用管理员'.$name,5);

                            $res = array('status' => '1','info'=>'启用成功！');
                            echo json_encode($res);
                        }else if($status == 2){
                            $sql = "update lkt_admin set status = 1 where id = '$id'";
                            $res_2 = $db->update($sql);
                            if($res_2 < 0){
                                $log -> customerLog(__LINE__.':更新管理员状态失败，sql为：'.$sql."\r\n");
                            }

                            $db->admin_record($store_id,$admin_name,'禁用管理员'.$name,5);

                            $res = array('status' => '1','info'=>'禁用成功！');
                            echo json_encode($res);
                        }
                    }
                }
            }else{
                $res = array('status' => '0','info'=>'无权操作！');
                echo json_encode($res);
            }
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