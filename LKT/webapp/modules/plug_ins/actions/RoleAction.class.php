<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class RoleAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        // 接收信息
        $id = $request->getParameter("id"); // 角色id

        // 根据角色id查询角色信息
        $sql0 = "select * from lkt_role where id = '$id'";
        $r0 = $db->select($sql0);
        $name = $r0[0]->name;

        $sql1 = "select menu_id from lkt_role_menu where role_id = '$id'";
        $r1 = $db->select($sql1);

        $list = Tools::menu($db,$r1);
        foreach ($list as $k => $v){
            $v->title_name = Tools::header_data_dictionary($db,'导航栏',$v->type);
        }

        $request->setAttribute('id', $id);
        $request->setAttribute('name',isset($name) ? $name : '');
        $request->setAttribute("list", $list);

        return View :: INPUT;
    }
    public function execute()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/plug_ins.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        // 接收数据
        $id = $request->getParameter("id");
        $name = addslashes(trim($request->getParameter('name')));
        $permissions = $request->getParameter('permission'); // 权限
        if ($name == '') {
            echo json_encode(array('status' => '角色不能为空！'));
            exit;
        } else {
            $sql0 = "select id from lkt_role where id != '$id' and name = '$name'";
            $r0 = $db->select($sql0);
            if ($r0) {
                echo json_encode(array('status' => '角色已经存在！'));
                exit;
            }
        }

        if($permissions){

        }else{
            echo json_encode(array('status' => '请选择客户端权限！'));
            exit;
        }
        $sql1 = "select id from lkt_role where id ='$id' ";
        $r1 = $db->select($sql1);
        if($r1){
            //更新数据表
            $sql = "update lkt_role set name='$name' where id ='$id'";
            $r = $db->update($sql);
            if ($r == -1) {
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改商户管理权限失败',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商户管理权限失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '未知原因，修改失败！', 'suc' => '1'));
                exit;
            } else {
                $sql_del = "delete from lkt_role_menu where role_id = '$id'";
                $r_del = $db->delete($sql_del);
                if($r_del > 0){
                    foreach ($permissions as $k => $v){
                        $sql1 = "insert into lkt_role_menu(role_id,menu_id,add_date)values('$id','$v',CURRENT_TIMESTAMP)";
                        $r1 = $db->insert($sql1);
                        if($r1 > 0){

                        }else{
                            $JurisdictionAction->admin_record($store_id,$admin_name,'添加商户管理权限菜单时失败,ID为'.$v,1);
                            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商户管理权限菜单时失败,ID为'.$v;
                            $lktlog->customerLog($Log_content);
                            $db->rollback();

                            echo json_encode(array('status' => '未知原因，添加失败！'));
                            exit;
                        }
                    }
                    $JurisdictionAction->admin_record($store_id,$admin_name,'修改商户管理权限菜单成功',2);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商户管理权限菜单成功';
                    $lktlog->customerLog($Log_content);
                    $db->commit();

                    echo json_encode(array('status' => '修改成功！', 'suc' => '1'));
                    exit;
                }else{
                    $JurisdictionAction->admin_record($store_id,$admin_name,'修改修改商户管理权限菜单时，删除权限菜单失败',2);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改修改商户管理权限菜单时，删除权限菜单失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('status' => '未知原因，修改失败！'));
                    exit;
                }
            }
        }else{
            $sql = "insert into lkt_role(name,status,admin_id,store_id,add_date)values('$name',1,'$admin_id','0',CURRENT_TIMESTAMP)";
            $r = $db->insert($sql, 'last_insert_id'); // 得到添加数据的id
            if ($r > 0 ) {
                foreach ($permissions as $k => $v){
                    $sql1 = "insert into lkt_role_menu(role_id,menu_id,add_date) values('$r0','$v',CURRENT_TIMESTAMP)";
                    $r1 = $db->insert($sql1);
                    if($r1 > 0){

                    }else{
                        $JurisdictionAction->admin_record($store_id,$admin_name,'添加商户管理权限菜单时失败,ID为'.$v,1);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商户管理权限菜单时失败,ID为'.$v;
                        $lktlog->customerLog($Log_content);
                        $db->rollback();

                        echo json_encode(array('status' => '未知原因，添加失败！'));
                        exit;
                    }
                }
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加商户管理成功',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商户管理成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '添加成功！', 'suc' => '1'));
                exit;
            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加商户管理权限失败',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商户管理权限失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' => '未知原因，添加失败！'));
                exit;
            }
        }

        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>