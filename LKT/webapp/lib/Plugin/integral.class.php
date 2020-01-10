<?php
require_once(MO_CONFIG_DIR . '/db_config.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');

class integral
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=integral&action=Index',
//            'index.php?module=integral&action=Addpro',
//            'index.php?module=integral&action=Config'
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select status from lkt_integral_config where store_id = '$store_id' ";
        $r0 = $db->select($sql0);
        if($r0){
            $is_display = $r0[0]->status;
        }else{
            $is_display = 2;
        }
        return $is_display;
    }
    // 添加插件设置
    public function add($store_id){
        $db = DBAction::getInstance();
        $sql0 = "insert into lkt_integral_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_integral_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    public function product($active=''){

        if($active == 7) {
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" checked="checked" style="display: none;" id="active-7" class="inputC1" value="7"  >
                        <label for="active-7">积分</label>
                    </div>';
        }else{
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" style="display: none;" id="active-7" class="inputC1" value="7" >
                        <label for="active-7">积分</label>
                    </div>';
        }
        return $res;
    }

    public function activity_type($active){
        if($active == 7){
            $res = "<option selected value='7'>积分</option>";
        }else{
            $res = "<option value='7'>积分</option>";
        }
        return $res;
    }

    public function order($active = ''){
        $res = 't7/积分订单,';
        return $res;
    }

}

?>