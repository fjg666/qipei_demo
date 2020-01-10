<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');

class Plugin {
    // 获取插件
    public function is_Plugin($db,$store_id){
        $list = array();
        $sql = "select Identification from lkt_plug_ins ";
        $r = $db->select($sql);
        if($r){
            foreach ($r as $k => $v){
                $Identification = $v->Identification;
                require_once(MO_LIB_DIR . '/Plugin/'.$Identification.'.class.php');
                $Identification = new $Identification();
                if(method_exists($Identification,'is_Plugin')){
                    $Identification_list = $Identification->is_Plugin($store_id);
                    $list[$v->Identification] = $Identification_list;
                }
            }
        }
        return $list;
    }
    // 检验插件还是否存在
    public function add($db,$store_id,$role,$menu_list){
        $menu_list_0 = array();
        $sql0_0 = "select a.module from lkt_core_menu as a left join lkt_role_menu as b on a.id = b.menu_id where role_id = '$role'";
        $r0_0 = $db->select($sql0_0);
        if($r0_0){
            foreach ($r0_0 as $k => $v){
                if($v->module != ''){
                    $menu_list_1[] = $v->module;
                }
            }
            $menu_list_0 = array_unique($menu_list_1);
        }

        $sql = "select Identification from lkt_plug_ins ";
        $r = $db->select($sql);
        if($r){
            foreach ($r as $k => $v){
                if(!in_array($v->Identification,$menu_list_0) && in_array($v->Identification,$menu_list)){
                    require_once(MO_LIB_DIR . '/Plugin/'.$v->Identification.'.class.php');
                    $Identification = new $v->Identification();
                    if(method_exists($Identification,'add')){
                        // 删除插件设置
                        $Identification->add($store_id);
                    }
                }
            }
        }
        return;
    }
    // 检验插件还是否存在
    public function inspect($db,$store_id,$menu_list){
        $list = $this->is_Plugin($db,$store_id); // 查询有哪些插件
        foreach ($list as $k => $v){
            if($v != 2){ // 当存在插件数据
                if(!in_array($k,$menu_list)){ // 插件标识 不存在 菜单标识里 （代表取消该插件）
                    require_once(MO_LIB_DIR . '/Plugin/'.$k.'.class.php');
                    $Identification = new $k();
                    if(method_exists($Identification,'del')){
                        // 删除插件设置
                        $Identification->del($store_id);
                    }
                }
            }
        }
        return;
    }
    public function product_plugin($db,$store_id,$type,$active='',$distributor_id=''){
        $res = array();
        $res1 = '';
        $res2 = '';

        $list = $this->is_Plugin($db,$store_id); // 查询有哪些插件
        foreach ($list as $k => $v){
            if($v != 2){ // 当存在插件数据
                require_once(MO_LIB_DIR . '/Plugin/'.$k.'.class.php');
                $Identification = new $k();
                if(method_exists($Identification,$type)){
                    echo $k;echo "--";
                    if($k == 'distribution'){
                        $Identification_list = $Identification->$type($store_id,$active,$distributor_id);
                        $res1 .= $Identification_list['res'];
                        $res2 .= $Identification_list['res1'];
                    }else{
                        $Identification_list = $Identification->$type($active);
                        $res1 .= $Identification_list;
                    }
                }
            }
        }
        $res['res1'] = $res1;
        $res['res2'] = $res2;
        return $res;
    }

    public function product_activity_type($db,$store_id,$type,$active=''){
        $res = '';
        $list = $this->is_Plugin($db,$store_id); // 查询有哪些插件
        foreach ($list as $k => $v){
            if($v != 2){ // 当存在插件数据
                require_once(MO_LIB_DIR . '/Plugin/'.$k.'.class.php');
                $Identification = new $k();
                if(method_exists($Identification,$type)){
                    $Identification_list = $Identification->$type($active);
                    $res .= $Identification_list;
                }
            }
        }
        return $res;
    }

    public function is_Plugin1($db,$store_id,$type,$active='',$distributor_id=''){
        $res = array();
        $res1 = '';
        $res2 = '';
        $list = $this->is_Plugin($db,$store_id); // 查询有哪些插件

        foreach ($list as $k => $v){
            if($v != 2){ // 当存在插件数据
                require_once(MO_LIB_DIR . '/Plugin/'.$k.'.class.php');
                $Identification = new $k();
                if(method_exists($Identification,$type)){


                        $Identification_list = $Identification->$type($active);
                        $res1 .= $Identification_list;

                }
            }
        }
        $res['res1'] = $res1;
        $res['res2'] = $res2;
        return $res;
    }

    public function front_Plugin($db,$store_id){
        $list = $this->is_Plugin($db,$store_id); // 查询有哪些插件
        return $list;
    }
}
?>