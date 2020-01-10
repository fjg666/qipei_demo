<?php
require_once(MO_CONFIG_DIR . '/db_config.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');

class distribution
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=distribution&action=Index',
//            'index.php?module=distribution&action=Commission',
//            'index.php?module=distribution&action=Del',
//            'index.php?module=distribution&action=Distribution_add',
//            'index.php?module=distribution&action=Distribution_config',
//            'index.php?module=distribution&action=Distribution_del',
//            'index.php?module=distribution&action=Distribution_grade',
//            'index.php?module=distribution&action=Distribution_information',
//            'index.php?module=distribution&action=Distribution_modify',
//            'index.php?module=distribution&action=Distributor_details',
//            'index.php?module=distribution&action=Cash',
//            'index.php?module=distribution&action=Cash_del',
//            'index.php?module=distribution&action=Move',
//            'index.php?module=distribution&action=Lower',
//            'index.php?module=distribution&action=Set',
//            'index.php?module=distribution&action=See',
//            'index.php?module=distribution&action=Edit'
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select status from lkt_distribution_config where store_id = '$store_id' ";
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
        $sql0 = "insert into lkt_distribution_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_distribution_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }
    // 商品-类型
    public function product($store_id,$active,$distributor_id){
        $db = DBAction::getInstance();
        $res1 = '';
        $res2 = '';
        $sql02 = "select id,sets from lkt_distribution_grade where store_id = '$store_id' and is_ordinary = 0";
        $r02 = $db->select($sql02);
        if ($r02) {
            foreach ($r02 as $k => $v) {
                $sets = unserialize($v->sets);
                $name = $sets['s_dengjiname'];
                if($distributor_id == $v->id){
                    $res2 .= "<option selected='selected' value='$v->id'>$name</option>";
                }else{
                    $res2 .= "<option value='$v->id'>$name</option>";
                }
            }
        }

        if($active == 5) {
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" checked="checked" style="display: none;" id="active-5" class="inputC1" value="5" >
                        <label for="active-5">分销</label>
                    </div>';
            $res1 .= '<div class="form_address" id="xd_fx">
                    <span>等级绑定：</span>
                    <div class="form_new_r">
                     <select name="distributor_id" class="select ">
                     <option selected="selected" value="0">不绑定分销等级</option>  
                     '.$res2.'
                     </select>
                     </div>
                 </div>';
        }else{
            $res = '<div class="ra1">
                        <input name="active" onchange="active_select(this)" type="radio" style="display: none;" id="active-5" class="inputC1" value="5" >
                        <label for="active-5">分销</label>
                    </div>';
            $res1 .= '<div class="form_address" id="xd_fx" style="display: none;">
                    <span>等级绑定：</span>
                    <div class="form_new_r">
                     <select name="distributor_id" class="select ">
                     <option selected="selected" value="0">不绑定分销等级</option>  
                     '.$res2.'
                     </select>
                     </div>
                     <span style="color: #97A0B4;">（绑定分销等级后，只有绑定等级及以上等级才能购买此商品）</span>
                 </div>';
        }


        $list = array('res'=>$res,'res1'=>$res1);

        return $list;
    }

    public function activity_type($active){
        if($active == 5){
            $res = "<option selected value='5'>分销</option>";
        }else{
            $res = "<option value='5'>分销</option>";
        }
        return $res;
    }
    public function order($active){
        $res = 't5/分销订单,';
        return $res;
    }
}

?>