<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_CONFIG_DIR . '/db_config.php');
require_once(MO_LIB_DIR . '/phpqrcode.php');

class mch
{
//    public function is_Plugin(){
//        $arr = array(
//            'index.php?module=mch&action=Index',
//            'index.php?module=mch&action=List',
//            'index.php?module=mch&action=Set',
//            'index.php?module=mch&action=Examine',
//            'index.php?module=mch&action=See',
//            'index.php?module=mch&action=Modify',
//            'index.php?module=mch&action=Del',
//            'index.php?module=mch&action=Product',
//            'index.php?module=mch&action=Product_see',
//            'index.php?module=mch&action=Product_shelves',
//            'index.php?module=mch&action=Withdraw',
//            'index.php?module=mch&action=Withdraw_examine',
//            'index.php?module=mch&action=Withdraw_list',
//        );
//        return $arr;
//    }

    // 获取插件状态
    public function is_Plugin($store_id){
        $db = DBAction::getInstance();
        $sql0 = "select * from lkt_mch_config where store_id = '$store_id' ";
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
        $sql0 = "insert into lkt_mch_config(store_id) values ('$store_id')";
        $db->insert($sql0);
        return;
    }
    // 删除插件设置
    public function del($store_id){
        $db = DBAction::getInstance();
        $sql0 = "delete from lkt_mch_config where store_id = '$store_id' ";
        $db->delete($sql0);
        return;
    }

    // 自提结算
    public function Settlement($db,$store_id,$products,$res=''){
        $shop_status = 0;
        $extraction_code = '';
        $extraction_code_img = '';
        $time_end = strtotime("+30 minutes");
        $time = date('Y-m-d H:i:s');
        if(count($products) > 1){
            $shop_status = 0;
        }else{
            $mch_id = $products[0]['shop_id'];
            $sql0 = "select * from lkt_mch_store where store_id = '$store_id' and mch_id = '$mch_id'";
            $r0 = $db->select($sql0);
            if($r0){
                $business_hours = explode('~',$r0[0]->business_hours);

                $start = date('Y-m-d H:i:s',strtotime($business_hours[0])); // 门店开门时间
                $end1 = date('Y-m-d H:i:s',strtotime($business_hours[1])); // 门店关门时间
                $end = date('Y-m-d H:i:s',strtotime("-30 minutes",strtotime($end1))); // 门店关门时间前半小时
                if($start <= $time && $time < $end){
                    $shop_status = 1;
                    if($res == 'payment'){
                        $extraction_code = $this->extraction_code() .','.time().','.$time_end;
                        $extraction_code_img = $this->extraction_code_img($extraction_code,'images/extraction_code_img',5);

                        $sql1 = "select endurl from lkt_third where id = 1";
                        $r1 = $db->select($sql1);
                        if($r1){
                            $endurl = $r1[0]->endurl;//根目录路径
                        }else{
                            $endurl = '../';//根目录路径
                        }
                        $extraction_code_img = $endurl . $extraction_code_img;
                    }
                }else{
                    $shop_status = 0;
                }
            }else{
                $shop_status = 0;
            }
        }
        $arr = array('shop_status'=>$shop_status,'extraction_code'=>$extraction_code,'extraction_code_img'=>$extraction_code_img);

        return $arr;
    }
    // 根据门店ID，查询门店信息
    public function Settlement1($db,$store_id,$shop_address_id){
        $list = array();
        $sql0 = "select * from lkt_mch_store where store_id = '$store_id' and id = '$shop_address_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $list['id'] = $r0[0]->id;
            $list['name'] = $r0[0]->name;
            $list['mobile'] = $r0[0]->mobile;
            $list['address'] = $r0[0]->sheng . $r0[0]->shi . $r0[0]->xian . $r0[0]->address;
        }
        return $list;
    }

    public function Settlement2($db,$store_id,$id){
        $time_end = strtotime("+30 minutes");

        $extraction_code = $this->extraction_code() .','.time().','.$time_end;
        $extraction_code_img = $this->extraction_code_img($extraction_code,'images/extraction_code_img',5);

        $sql1 = "select endurl from lkt_third where id = 1";
        $r1 = $db->select($sql1);
        if($r1){
            $endurl = $r1[0]->endurl;//根目录路径
        }else{
            $endurl = '../';//根目录路径
        }
        $extraction_code_img = $endurl . $extraction_code_img;

        $sql2 = "update lkt_order set extraction_code = '$extraction_code',extraction_code_img = '$extraction_code_img' where store_id = '$store_id' and id = '$id'";
        $r2 = $db->update($sql2);

        $arr = array('extraction_code'=>$extraction_code,'extraction_code_img'=>$extraction_code_img);

        return $arr;
    }
    // 定时修改提取码问题
    public function up_extraction_code(){
        $db = DBAction::getInstance();

        $sql0 = "select id,store_id,extraction_code from lkt_order where self_lifting = '1' ";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id;
            $store_id = $r0[0]->store_id;
            $rew = explode(',',$r0[0]->extraction_code);
            if($rew[2] <= time()){ // 提货码有效时间 小于等于 当前时间
                $shop = $this->Settlement2($db,$store_id,$id);
            }
        }
        return;
    }
    // 生成提取码
    private function extraction_code(){
        $db = DBAction::getInstance();
        $arr1 = range('a','z');
        $arr2 = range('A','Z');
        $arr3 = range(0,9);
        $arr = array_merge($arr1,$arr2,$arr3); // 把多个数组合并为一个数组
        shuffle($arr); // 把数组中的元素按随机顺序重新排序
        $code = $arr[0].$arr[1].$arr[2].$arr[3].$arr[4].$arr[5];
        $sql = "select * from lkt_order where extraction_code = '$code' and status in (0,2)";
        $res = $db->select($sql);
        if($res){
            $this->extraction_code();
        }else{
            return $code;
        }
    }
    // 生成提取码-二维码
    private function extraction_code_img($extraction_code,$uploadImg, $size = 5){
        $db = DBAction::getInstance();
        $qrcode_name = md5(time() . rand(1000, 9999));

        $value = $extraction_code;                  //二维码内容
        $errorCorrectionLevel = 'L';    //容错级别
        $matrixPointSize = $size;           //生成图片大小
        $filename = $uploadImg . '/' . $qrcode_name . '.png';

        QRcode::png($value, $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        return $filename;
    }
    // 满减日志
    public function mchLog($content){
        $lktlog = new LaiKeLogUtils("app/mch.log");
        $lktlog->customerLog($content);
        return;
    }
    // 买家确认收货,店主收入
    public function parameter($db,$store_id,$sNo,$payment_money,$allow=0){
        $db->begin();

        $sql0 = "select mch_id from lkt_order where store_id = '$store_id' and sNo = '$sNo'";
        $r0 = $db->select($sql0);
        if($r0){
            $mch_id = $r0[0]->mch_id;
            $mch_id = substr($mch_id,1,strlen($mch_id)-2);
            $sql1 = "update lkt_mch set account_money = account_money + '$payment_money',integral_money=integral_money+'$allow' where store_id = '$store_id' and id = '$mch_id'";
            $r1 = $db->update($sql1);
            if ($r1 < 1) {
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败1!'));
                exit;
            }
            $sql2 = "select account_money,integral_money from lkt_mch where store_id = '$store_id' and id = '$mch_id'";
            $r2 = $db->select($sql2);
            $account_money = $r2[0]->account_money;
            $integral_money = $r2[0]->integral_money;

            $sql3 = "insert into lkt_mch_account_log(store_id,mch_id,price,integral,integral_money,account_money,type,addtime) values ('$store_id','$mch_id','$payment_money','$allow','$integral_money','$account_money',1,CURRENT_TIMESTAMP)";
            $r3 = $db->insert($sql3);
            if($r3 <= 0){
                $db->rollback();
                echo json_encode(array('code' => 0, 'err' => '操作失败2!'));
                exit;
            }
            $db->commit();
        }
        return;
    }
}

?>