<?php
require_once(MO_CONFIG_DIR . '/db_config.php');

class seconds
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=seconds&action=Index',
//            'index.php?module=seconds&action=Settime',
//            'index.php?module=seconds&action=Addpro',
//            'index.php?module=seconds&action=Config',
//            'index.php?module=seconds&action=Member',
//            'index.php?module=seconds&action=Modify',
//            'index.php?module=seconds&action=Prolist',
//            'index.php?module=seconds&action=Record',
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select is_open from lkt_seconds_config where store_id = '$store_id' ";
        $r0 = $db->select($sql0);
        if($r0){
            $is_display = $r0[0]->is_open;
        }else{
            $is_display = 2;
        }
        return $is_display;
    }
    // 添加插件设置
    public function add($store_id){
        $db = DBAction::getInstance();
        $sql0 = "insert into lkt_seconds_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_seconds_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    public function product($active){
        if($active == 8) {
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" checked="checked" style="display: none;" id="active-8" class="inputC1" value="8" >
                        <label for="active-8">秒杀</label>
                    </div>';
        }else{
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" style="display: none;" id="active-8" class="inputC1" value="8">
                        <label for="active-8">秒杀</label>
                    </div>';
        }
        return $res;
    }

    public function activity_type($active){
        if($active == 8){
            $res = "<option selected value='8'>秒杀</option>";
        }else{
            $res = "<option value='8'>秒杀</option>";
        }
        return $res;
    }

    public function order($active){
        $res = 't8/秒杀订单,';
        return $res;
    }
}

?>