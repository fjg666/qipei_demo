<?php
require_once (MO_CONFIG_DIR . '/db_config.php');
class freightAction {
    public function freight($freight,$num,$address,$db){
        $sql = "select * from lkt_freight where id = '$freight'";
        $r_1 = $db->select($sql);
        if($r_1){
            $rule = $r_1[0];
            $yunfei = 0;
            if(empty($address)){
                return 0;
            }else{
                $sheng = $address['sheng'];
                $sql2 = "select G_CName from admin_cg_group where GroupID = '$sheng'";
                $r_2 = $db->select($sql2);
                if($r_2){
                    $city = $r_2[0]->G_CName;
                    $rule_1 = $r_1[0]->freight;
                    $rule_2 = unserialize($rule_1);

                    foreach ($rule_2 as $key => $value) {
                        $citys_str = $value['name'];
                        $citys_array=explode(',',$citys_str);
                        $citys_arrays = [];
                        foreach ($citys_array as $k => $v) {
                            $citys_arrays[$v] = $v;
                        }
                        if(array_key_exists($city , $citys_arrays)){
                            if($num > $value['three']){
                                $yunfei += $value['two'];
                                $yunfei += ($num-$value['three'])*$value['four'];
                            }else{
                                $yunfei += $value['two'];
                            }
                        }
                    }
                    return $yunfei;
                }else{
                    return 0;
                }
            }
        }else{
            return 0;
        }
    }
}
?>