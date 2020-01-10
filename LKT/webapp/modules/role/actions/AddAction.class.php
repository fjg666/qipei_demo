<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $menu_id = array();
        $sql0 = "select c.id from lkt_admin as a left join lkt_role_menu as b on a.role = b.role_id left join lkt_core_menu as c on b.menu_id = c.id where a.store_id = '$store_id' and a.type = 1";
        $r0 = $db->select($sql0);
        if($r0){
            foreach ($r0 as $k => $v){
                $menu_id[] = $v->id;
            }
        }
        // 根据商城id、管理员账号查询管理员信息
        $list = Tools::menu_1($db,'',$menu_id);

        foreach ($list as $k => $v){
            $list1[$v->type][] = $v;
        }

        foreach ($list1 as $k => $v){
            $list2[$k]['title'] = Tools::header_data_dictionary($db,'导航栏',$k);
            $list2[$k]['id'] = $k;
            $list2[$k]['checked'] = false;
            $list2[$k]['spread'] = false;
            $list2[$k]['field'] = 'name1';
            $list2[$k]['children'] = $v;
        }
        foreach ($list2 as $k => $v){
            $list3[] = (object)$v;
        }

        $list4 = json_encode($list3);

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
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账户
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        // 接收数据
        $name = addslashes(trim($request->getParameter('name'))); // 角色
        $permissions = $request->getParameter('id_list'); // 权限

        if ($name == '') {
            echo json_encode(array('status' => '角色不能为空！'));
            exit;
        } else {
            $sql = "select id from lkt_role where store_id = '$store_id' and name = '$name'";
            $r = $db->select($sql);
            if ($r) {
                echo json_encode(array('status' => '角色已经存在！'));
                exit;
            }
        }

        if($permissions){

        }else{
            echo json_encode(array('status' => '请选择角色权限！'));
            exit;
        }

        // 添加一条数据
        $sql0 = "insert into lkt_role(name,status,admin_id,store_id,add_date)values('$name',0,'$admin_id','$store_id',CURRENT_TIMESTAMP)";
        $r0 = $db->insert($sql0, 'last_insert_id'); // 得到添加数据的id
        if ($r0 > 0) {
            foreach ($permissions as $k => $v){
                $sql1 = "insert into lkt_role_menu(role_id,menu_id,add_date) values('$r0','$v',CURRENT_TIMESTAMP)";
                $r1 = $db->insert($sql1);
                if($r1 > 0){

                }else{
                    $JurisdictionAction->admin_record($store_id,$admin_name,'添加角色权限菜单时失败,ID为'.$v,1);
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加角色权限菜单时失败,ID为'.$v;
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    echo json_encode(array('status' => '未知原因，添加失败！'));
                    exit;
                }
            }
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加角色成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加角色成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '添加成功！', 'suc' => '1'));
            exit;
        } else {
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加角色失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加角色失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '未知原因，添加失败！'));
            exit;
        }
        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>