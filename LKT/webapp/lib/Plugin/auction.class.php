<?php
require_once(MO_CONFIG_DIR . '/db_config.php');

class auction
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=auction&action=Index',
//            'index.php?module=auction&action=Add',
//            'index.php?module=auction&action=Change',
//            'index.php?module=auction&action=Modify',
//            'index.php?module=auction&action=Record',
//			'index.php?module=auction&action=Config'
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select is_open from lkt_auction_config where store_id = '$store_id' ";
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
        $sql0 = "insert into lkt_auction_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_auction_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    public function product($active){
        if($active == 4) {
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" checked="checked" style="display: none;" id="active-4" class="inputC1" value="4" >
                        <label for="active-4">竞拍</label>
                    </div>';
        }else{
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" style="display: none;" id="active-4" class="inputC1" value="4" >
                        <label for="active-4">竞拍</label>
                    </div>';
        }
        return $res;
    }
    public function activity_type($active){
        if($active == 4){
            $res = "<option selected value='4'>竞拍</option>";
        }else{
            $res = "<option value='4'>竞拍</option>";
        }
        return $res;
    }
    public function order($active){
        $res = 't4/竞拍订单,';
        return $res;
    }
    //判断竞拍插件是否开启
    public function test($store_id){
        $db = DBAction::getInstance();
        $time = date("Y-m-d H:i:s"); // 当前时间
        $sql = "select is_open from lkt_auction_config where store_id = '$store_id'";
        $res = $db->select($sql);
        if($res){
            $is_open = $res[0]->is_open;
        }else{
            $is_open = 0;
        }
        return $is_open;
    }
}

?>