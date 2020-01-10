<?php
require_once(MO_CONFIG_DIR . '/db_config.php');

class draw
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=draw&action=Index',
//            'index.php?module=draw&action=addsign',
//            'index.php?module=draw&action=del',
//            'index.php?module=draw&action=modify',
//            'index.php?module=draw&action=operation',
//            'index.php?module=draw&action=parameters',
//            'index.php?module=draw&action=whether'
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select * from lkt_draw where store_id = '$store_id' ";
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
        $sql0 = "insert into lkt_draw(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_draw where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    public function order(){
        $res = 't3/抽奖订单,';
        return $res;
    }
}

?>