<?php
require_once(MO_CONFIG_DIR . '/db_config.php');

class go_group
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=go_group&action=Index',
//            'index.php?module=go_group&action=Addgroup',
//            'index.php?module=go_group&action=Addproduct',
//            'index.php?module=go_group&action=Config',
//            'index.php?module=go_group&action=Grouppro',
//            'index.php?module=go_group&action=Member',
//            'index.php?module=go_group&action=Modify',
//            'index.php?module=go_group&action=Setpro',
//            'index.php?module=go_group&action=Canrecord',
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select * from lkt_group_config where store_id = '$store_id' ";
        $r0 = $db->select($sql0);
        if($r0){
            $is_display = 1;
        }else{
            $is_display = 2;
        }
        return $is_display;
    }
    // 添加插件设置
    public function add($store_id){
        $db = DBAction::getInstance();
        $sql0 = "insert into lkt_group_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_group_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    public function product($active){
        if($active == 2) {
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" checked="checked" style="display: none;" id="active-2" class="inputC1" value="2" >
                        <label for="active-2">拼团</label>
                    </div>';
        }else{
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" style="display: none;" id="active-2" class="inputC1" value="2">
                        <label for="active-2">拼团</label>
                    </div>';
        }
        return $res;
    }

    public function activity_type($active){
        if($active == 2){
            $res = "<option selected value='2'>拼团</option>";
        }else{
            $res = "<option value='2'>拼团</option>";
        }
        return $res;
    }

    public function order($active){
        $res = 't2/拼团订单,';
        return $res;
    }
}

?>