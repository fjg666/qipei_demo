<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        // 接收信息
        $id = $request->getParameter("id"); // 角色id
        $menu_id = array();
        $sql0 = "select c.id from lkt_admin as a left join lkt_role_menu as b on a.role = b.role_id left join lkt_core_menu as c on b.menu_id = c.id where a.store_id = '$store_id' and a.type = 1";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $menu_id[] = $v->id;
            }
        }
        // 根据角色id查询角色信息
        $sql = "select * from lkt_role where store_id = '$store_id'and id = '$id'";
        $rr = $db->select($sql);
        $name = $rr[0]->name;

        $sql1 = "select menu_id from lkt_role_menu where role_id = '$id'";
        $r1 = $db->select($sql1);

        $list = Tools::menu_1($db,$r1,$menu_id);
        foreach ($list as $k => $v){
            $list1[$v->type][] = $v;
        }
        foreach ($list1 as $k => $v){
            $list2[$k]['title'] = Tools::header_data_dictionary($db,'导航栏',$k);
            $list2[$k]['id'] = $k;
            $list2[$k]['spread'] = false;
            $list2[$k]['field'] = 'name1';
            $list2[$k]['children'] = $v;
        }
        foreach ($list2 as $k => $v){
            $list3[] = (object)$v;
        }
        $list4 = json_encode($list3);

        $request->setAttribute('id', $id);
        $request->setAttribute('name', $name);
        $request->setAttribute("list", $list4);

        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/role.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        // 接收数据
        $id = $request->getParameter("id");
        $name = addslashes(trim($request->getParameter('name')));
        $permissions = $request->getParameter('id_list'); // 权限
        if ($name == '') {
            echo json_encode(array('status' => '角色不能为空！'));
            exit;
        } else {
            $sql = "select id from lkt_role where id != '$id' and store_id = '$store_id' and name = '$name'";
            $r = $db->select($sql);
            if ($r) {
                echo json_encode(array('status' => '角色已经存在！'));
                exit;
            }
        }

        if($permissions){

        }else{
            echo json_encode(array('status' => '请选择客户端权限！'));
            exit;
        }
        //更新数据表
        $sql = "update lkt_role set name='$name' where store_id='$store_id' and id ='$id'";
        $r = $db->update($sql);
        if ($r == -1) {
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改客户端ID为 '.$id.' 失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改客户端ID为 '.$id.' 失败';
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
                        $JurisdictionAction->admin_record($store_id,$admin_name,'添加角色权限菜单时失败,ID为'.$v,2);
                        $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加角色权限菜单时失败,ID为'.$v;
                        $lktlog->customerLog($Log_content);
                        $db->rollback();

                        echo json_encode(array('status' => '未知原因，添加失败！'));
                        exit;
                    }
                }
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改角色id为 '.$id.'成功',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改角色id为 '.$id.'成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '修改成功！', 'suc' => '1'));
                exit;
            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改角色id为 '.$id.' 失败 ',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改角色id为 '.$id.' 失败 ';
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