<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class BangdingAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $id = addslashes(trim($request->getParameter('id'))); //
        $m = addslashes(trim($request->getParameter('m'))); //
        if($m){
            $this->$m();
        }
        // 查询已绑定商户
        $sql0 = "select a.id,a.tel,b.name from lkt_admin as a left join lkt_customer as b on a.store_id = b.id where a.type = 1 and a.recycle = 0 and b.recycle = 0 and a.role = '$id'";
        $r0 = $db->select($sql0);
        // 查询未绑定商户
        $sql1 = "select a.id,a.tel,b.name from lkt_admin as a left join lkt_customer as b on a.store_id = b.id where a.type = 1 and a.recycle = 0 and b.recycle = 0 and (a.role != '$id' or a.role is null) ";
        $r1 = $db->select($sql1);

        echo json_encode(array('list1'=>$r0,'list2'=>$r1));
        exit;

        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/client.log");
        $Plugin = new Plugin();
        $db->begin();

        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账户
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = addslashes(trim($request->getParameter('id'))); //
        $list = $request->getParameter('list'); //
        $list1 = $request->getParameter('list1'); //
        $store_list = array();
        if($list1 != array()){
            $sql0_0 = "select id,store_id from lkt_admin where recycle = 0 and role = '$id'";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                foreach ($r0_0 as $k => $v){
                    if(!in_array($v->id,$list1)){
                        $id1 = $v->id;
                        $store_list[] = $v->store_id;
                        $sql0_1 = "update lkt_admin set role = '' where recycle = 0 and id = '$id1'";
                        $r0_1 = $db->update($sql0_1);
                        if($r0_1 <= 0){
                            $JurisdictionAction->admin_record($store_id,$admin_name,'取消商户绑定角色时失败，商户ID为'.$id1,2);
                            $Log_content = __METHOD__ . '->' . __LINE__ . ' 取消商户绑定角色时失败，商户ID为'.$id1;
                            $lktlog->customerLog($Log_content);
                            $db->rollback();

                            echo json_encode(array('status' => '未知原因，绑定失败！'));
                            exit;
                        }else{
                            $JurisdictionAction->admin_record($store_id,$admin_name,'取消商户绑定角色，商户ID为'.$id1,2);
                            $Log_content = __METHOD__ . '->' . __LINE__ . ' 取消商户绑定角色，商户ID为'.$id1;
                            $lktlog->customerLog($Log_content);
                        }

                    }
                }
            }
        }
        if($list != array()){
            $menu_list = array();
            $sql0_0 = "select a.name from lkt_core_menu as a left join lkt_role_menu as b on a.id = b.menu_id where role_id = '$id'";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                foreach ($r0_0 as $k => $v){
                    $menu_list1[] = $v->name;
                }
                $menu_list = array_unique($menu_list1);
            }
            foreach ($list as $k => $v){
                $sql0_1 = "select store_id,role from lkt_admin where recycle = 0 and id = '$v'";
                $r0_1 = $db->select($sql0_1);
                if($r0_1){
                    foreach ($r0_1 as $k1 => $v1){
                        $Plugin = new Plugin();
                        $Plugin->add($db,$v1->store_id,$v1->role,$menu_list);

                        $Plugin->inspect($db,$v1->store_id,$menu_list);
                    }
                }
                $sql0 = "update lkt_admin set role = '$id' where recycle = 0 and id = '$v'";
                $r0 = $db->update($sql0);
                if($r0 > 0){
                    $JurisdictionAction->admin_record($store_id,$admin_name,'绑定商户角色，商户ID为'.$v,2);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 绑定商户角色，商户ID为'.$v;
                    $lktlog->customerLog($Log_content);
                }else{
                    $JurisdictionAction->admin_record($store_id,$admin_name,'绑定商户角色时失败，商户ID为'.$v,2);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 绑定商户角色时失败，商户ID为'.$v;
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('status' => '未知原因，绑定失败！'));
                    exit;
                }
            }
        }
        if($store_list != array()){
            foreach ($store_list as $k => $v){
                $Plugin->inspect($db,$v,array());
            }
        }
        $db->commit();

        echo json_encode(array('status' => '绑定成功！', 'suc' => '1'));
        exit;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 验证所选商户是否已经绑定角色
    public function yanzheng(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $list = $request->getParameter('list'); //

        if($list != array()){
            foreach ($list as $k => $v){
                $sql0 = "select role from lkt_admin where recycle = 0 and id = '$v'";
                $r0 = $db->select($sql0);
                if($r0){
                    $role = $r0[0]->role;
                    if($role == ''){

                    }else{
                        echo json_encode(array('status'=>2));
                        exit;
                    }
                }else{
                    echo json_encode(array('status'=>0,'msg'=>'参数错误！'));
                    exit;
                }
            }
        }
        echo json_encode(array('status'=>1));
        exit;
    }

    public function sousuo(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = addslashes(trim($request->getParameter('id'))); //
        $name = addslashes(trim($request->getParameter('name'))); //

        $sql0 = "select a.id,a.tel,b.name from lkt_admin as a left join lkt_customer as b on a.store_id = b.id where a.type = 1 and a.recycle = 0 and b.recycle = 0 and a.role != '$id' and b.name like '%$name%'";
        $r0 = $db->select($sql0);

        echo json_encode(array('list'=>$r0));
        exit;
    }
}

?>