<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class ConfigAction extends Action {
    
    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        // 权限
        $JurisdictionAction = new JurisdictionAction();
        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=Index');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=List');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=Config');

        // 查询钱包配置
        $sql = "select * from lkt_finance_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $min_cz = $r[0]->min_cz;// 最小充值金额
            $min_amount = $r[0]->min_amount;// 最少提现金额
            $max_amount = $r[0]->max_amount;// 最大提现金额
            $service_charge = $r[0]->service_charge;// 手续费
            $unit = $r[0]->unit;// 小程序钱包单位
            $multiple = $r[0]->multiple;// 提现倍数
            $transfer_multiple = $r[0]->transfer_multiple;// 转账倍数
            $cz_multiple = $r[0]->cz_multiple;// 充值倍数
        }else{
            $min_cz = 50;
            $min_amount = 50;
            $max_amount = 100;
            $service_charge = '0.05';
            $unit = '元';
            $multiple = 0;
            $transfer_multiple = 0;
            $cz_multiple = 100;
        }
        $request->setAttribute('button', $button);
        $request->setAttribute('min_cz', $min_cz);
        $request->setAttribute('cz_multiple', $cz_multiple);
        $request->setAttribute('min_amount', $min_amount);
        $request->setAttribute('max_amount', $max_amount);
        $request->setAttribute('service_charge', $service_charge);
        $request->setAttribute('multiple', $multiple);
        $request->setAttribute('transfer_multiple', $transfer_multiple);
        $request->setAttribute('unit', $unit);
        return View :: INPUT;
    }

    public function execute() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收信息
        $min_cz = addslashes(trim($request->getParameter('min_cz'))); // 最小充值金额
        $min_amount = addslashes(trim($request->getParameter('min_amount'))); // 最小提现金额
        $max_amount = addslashes($request->getParameter('max_amount')); // 最大提现金额
        $service_charge = addslashes($request->getParameter('service_charge')); // 手续费
        $unit = addslashes($request->getParameter('unit')); // 单位
        $multiple = trim($request->getParameter('multiple'));//提现倍数
        $transfer_multiple = trim($request->getParameter('transfer_multiple'));//转账倍数
        $cz_multiple = trim($request->getParameter('cz_multiple'));//充值倍数

        $log = new LaiKeLogUtils('common/finance.log');// 日志

        if(is_numeric($min_cz) == false){
            $log -> customerLog(__LINE__.":钱包配置修改失败：最小充值金额请输入数字！ \r\n");
        	echo json_encode(array('status' =>'最小充值金额请输入数字！' ));exit;
        }else{
            if($min_cz <= 0){
                $log -> customerLog(__LINE__.":钱包配置修改失败：最小充值金额不能小于等于0！ \r\n");
            	echo json_encode(array('status' => '最小充值金额不能小于等于0！'));exit;
            }
        }

        if(is_numeric($min_amount) == false){
            $log -> customerLog(__LINE__.":钱包配置修改失败：最小提现金额请输入数字！ \r\n");
        	echo json_encode(array('status' =>'最小提现金额请输入数字！' ));exit;
        }else{
            if($min_amount <= 0){
                $log -> customerLog(__LINE__.":钱包配置修改失败：最小提现金额不能小于等于0！ \r\n");
            	echo json_encode(array('status' =>'最小提现金额不能小于等于0！' ));exit;
            }
        }
        if(is_numeric($max_amount) == false){
            $log -> customerLog(__LINE__.":钱包配置修改失败：最大提现金额请输入数字！ \r\n");
        	echo json_encode(array('status' => '最大提现金额请输入数字！'));exit;
        }else{
            if($max_amount <= 0){
                $log -> customerLog(__LINE__.":钱包配置修改失败：最大提现金额不能小于等于0！ \r\n");
            	echo json_encode(array('status' =>'最大提现金额不能小于等于0！' ));exit;
            }
        } 
        if($min_amount <= $service_charge){
            $log -> customerLog(__LINE__.":钱包配置修改失败：最小提现金额不能小于等于手续费！ \r\n");
        	echo json_encode(array('status' =>'最小提现金额不能小于等于手续费！' ));exit;
        }else if ($min_amount >= $max_amount) {
            $log -> customerLog(__LINE__.":钱包配置修改失败：最小提现金额不能大于等于最大提现金额！ \r\n");
        	echo json_encode(array('status' => '最小提现金额不能大于等于最大提现金额！'));exit;
        }else{
            if($unit == ''){
                $unit = '元';
            }
            $sql = "select * from lkt_finance_config where store_id = '$store_id'";
            $r = $db->select($sql);
            if($r){
                $sql = "update lkt_finance_config set min_cz = '$min_cz',min_amount = '$min_amount',max_amount = '$max_amount',multiple = '$multiple',transfer_multiple = '$transfer_multiple',service_charge = '$service_charge',unit = '$unit',cz_multiple ='$cz_multiple',modify_date = CURRENT_TIMESTAMP where store_id = '$store_id'";
               $r_1 = $db->update($sql);
                if($r_1 == -1) {
                    $log -> customerLog(__LINE__.":钱包配置修改失败：$sql \r\n");
                    $db->admin_record($store_id,$admin_name,'钱包配置修改失败！',2);
                	echo json_encode(array('status' => '未知原因，参数修改失败！'));exit;
                } else {
                    $log -> customerLog(__LINE__.":钱包配置修改成功！ \r\n");
                    $db->admin_record($store_id,$admin_name,'钱包配置修改成功！',2);
                	echo json_encode(array('status' =>'参数修改成功！','suc'=>'1' ));exit;
                }
            }else{
                $sql = "insert into lkt_finance_config(store_id,min_cz,min_amount,max_amount,service_charge,unit,modify_date,multiple,transfer_multiple,cz_multiple) values('$store_id','$min_cz','$min_amount','$max_amount','$service_charge','$unit',CURRENT_TIMESTAMP,'$multiple','$transfer_multiple','$cz_multiple')";
                $r_1 = $db->insert($sql);
                if($r_1 == -1) {
                    $log -> customerLog(__LINE__.":钱包配置修改失败：$sql \r\n");
                    $db->admin_record($store_id,$admin_name,'钱包配置修改失败！',1);
                    echo json_encode(array('status' => '未知原因，参数修改失败！'));exit;
                } else {
                    $log -> customerLog(__LINE__.":钱包配置修改成功！ \r\n");
                    $db->admin_record($store_id,$admin_name,'钱包配置修改成功！',1);
                    echo json_encode(array('status' =>'参数修改成功！','suc'=>'1' ));exit;
                }
            }
        }
        
        echo json_encode(array('status' => '未知原因，参数修改失败！'));exit;

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>