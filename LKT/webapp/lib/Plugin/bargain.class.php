<?php
require_once(MO_CONFIG_DIR . '/db_config.php');

class bargain
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=bargain&action=Index',
//            'index.php?module=bargain&action=Addpro',
//            'index.php?module=bargain&action=Config',
//            'index.php?module=bargain&action=List',
//            'index.php?module=bargain&action=Member',
//            'index.php?module=bargain&action=Modify',
//            'index.php?module=bargain&action=Record',
//            'index.php?module=bargain&action=Helprecord'
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select status from lkt_bargain_config where store_id = '$store_id' ";
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
        $sql0 = "insert into lkt_bargain_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_bargain_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    public function product($active){
        if($active == 3) {
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" checked="checked" style="display: none;" id="active-3" class="inputC1" value="3"  >
                        <label for="active-3">砍价</label>
                    </div>';
        }else{
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" style="display: none;" id="active-3" class="inputC1" value="3" >
                        <label for="active-3">砍价</label>
                    </div>';
        }
        return $res;
    }

    public function activity_type($active){
        if($active == 3){
            $res = "<option selected value='3'>砍价</option>";
        }else{
            $res = "<option value='3'>砍价</option>";
        }
        return $res;
    }
    // 前端首页
    public function test($store_id,$user_id){
        $db = DBAction::getInstance();
        
        $sql = "select * from lkt_bargain_config where store_id = '$store_id'";
        $config = $db->select($sql);
        if($config){
            $status = $config[0]->status; // 插件是否启用
        }else{
            $status = 0;
        }
        $data = array('status'=>$status);
        return $data;
    }
    public function order($active){
        $res = 't3/砍价订单,';
        return $res;
    }
}

?>