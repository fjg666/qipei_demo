<?php
require_once(MO_CONFIG_DIR . '/db_config.php');
/**
 * <p>Copyright (c) 2018-2019</p>
 * <p>Company: www.laiketui.com</p>
 * @author 段宏波
 * @date 2019/1/16  14:37
 * @version 1.0
 */
class JurisdictionAction
{
    // 管理员记录
    function admin_record($store_id,$admin_name,$event,$type){
        $db = DBAction::getInstance();

        $event = $admin_name . $event;
        $sql = "insert into lkt_admin_record(store_id,admin_name,event,type,add_date) values ('$store_id','$admin_name','$event','$type',CURRENT_TIMESTAMP)";
        $db->insert($sql);
        return;
    }

    // 按钮权限
    function Jurisdiction($store_id,$admin_name,$admin_type1,$url){
        $db = DBAction::getInstance();

        if($admin_type1 == 0){
            $sql = "select * from lkt_admin where name ='$admin_name'";
        }else{
            $sql = "select * from lkt_admin where name ='$admin_name' and store_id = '$store_id'";
        }
        $r = $db->select($sql);
        $admin_type = $r[0]->admin_type;
        $role = explode (',',$r[0]->role); // 角色
        if($admin_type != 1){
            $permission_1 = array();
            $permission = array();
            foreach ($role as $k => $v){
                $sql1 = "select b.id,b.type,b.url from lkt_role_menu as a left join lkt_core_menu as b on a.menu_id = b.id where a.role_id = '$v' and b.recycle = 0 ";
                $r1 = $db->select($sql1);
                if($r1){
                    foreach ($r1 as $k1 => $v1){
                        if($v1->type != '0') {
                            $v1->title_name = Tools::header_data_dictionary($db, '导航栏', $v1->type);
                            $role_list1[] = (array)$v1;
                        }
                        $permission_1[] = $v1->id;
                    }
                }
            }
            foreach ($permission_1 as $ke => $va){
                $sql = "select url from lkt_core_menu where id = ".$va;
                $rrr = $db->select($sql);
                if($rrr){
                    if($rrr[0]->url != ''){
                        $permission[] = $rrr[0]->url;
                    }
                }
            }
        }
        if($r[0]->admin_type != 1 && !in_array($url,$permission)){
            return 0;
        }else{
            return 1;
        }
    }
}

?>