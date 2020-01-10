<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class addAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $name = trim($request -> getParameter('name'));
        $tel = trim($request -> getParameter('tel'));
        $code = trim($request -> getParameter('code'));
        $address = trim($request -> getParameter('address'));
        $is_default = trim($request -> getParameter('is_default'));
        $sheng = trim($request -> getParameter('sheng'));
        $shi = trim($request -> getParameter('shi'));
        $xian = trim($request -> getParameter('xian'));
        $Select1 = trim($request -> getParameter('Select1'));
        $Select2 = trim($request -> getParameter('Select2'));
        $Select3 = trim($request -> getParameter('Select3'));
        $address_xq = $sheng.$shi.$xian.$address;

        if($name == ''){
            echo json_encode(array('status' =>'联系人不能为空！' ));exit;
        }
        if($tel == ''){
            echo json_encode(array('status' =>'联系电话不能为空！' ));exit;
        }

        if(strlen($tel) >15){
            echo json_encode(array('status' =>'联系电话格式错误！' ));exit;
        }else{
            $sql = "select * from lkt_service_address where store_id = '$store_id' and uid = 'admin' and tel = '$tel'";
            $r0 = $db->select($sql);
            if($r0){
                echo json_encode(array('status' =>'该联系电话已存在！' ));exit;
            }
        }
        if($Select1 == ''){
            echo json_encode(array('status' =>'请选择省/市辖区！' ));exit;
        }
        if($Select2 == '' || $Select3 == ''){
            echo json_encode(array('status' =>'请选择区县！' ));exit;
        }
        if($address == ''){
            echo json_encode(array('status' =>'详细地址不能为空！' ));exit;
        }
        if($code == ''){
            echo json_encode(array('status' =>'邮政编码不能为空！' ));exit;
        }else{
            if(strlen($code) != 6){
                echo json_encode(array('status' =>'邮政编码为6位数字！' ));exit;
            }
        }

        if (intval($is_default) == 1) {
            $sql = "update lkt_service_address set is_default = '0' where store_id = '$store_id'";
            $db->update($sql);
        }

        $sql1 = "select id from lkt_service_address where store_id = '$store_id' and uid = 'admin'";
        $r1 = $db->select($sql1);
        if($r1){
            $sqll = "insert into lkt_service_address (store_id,name,tel,code,sheng,shi,xian,address,address_xq,uid) values ('$store_id','$name','$tel','$code','$sheng','$shi','$xian','$address','$address_xq','admin')";
            $r = $db -> insert($sqll);
        }else{
            $sqll = "insert into lkt_service_address (store_id,name,tel,code,sheng,shi,xian,address,address_xq,uid,is_default) values ('$store_id','$name','$tel','$code','$sheng','$shi','$xian','$address','$address_xq','admin',$is_default)";
            $r = $db -> insert($sqll);
        }
        
        if($r == -1) {
            $db->admin_record($store_id,$admin_name,'添加地址失败',1);

            echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;
        } else {
            $db->admin_record($store_id,$admin_name,'添加地址成功',1);

            echo json_encode(array('status' => '添加成功！','suc'=>'1'));exit;
        }

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>