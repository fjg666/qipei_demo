<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/phpqrcode.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class Distribution_configAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 查村配置
        $sql = "select * from lkt_distribution_config where store_id = '$store_id'";
        $re = $db->select($sql);
        if(!empty($re)){
             $re01=unserialize($re[0]->sets);// 配置参数
             $status = $re[0]->status;// 是否开启插件
        }else{
             $re01=1;
             $status = 0;
        }
        $request->setAttribute("re",$re01);
        $request->setAttribute("status",$status);
        return View :: INPUT;
    }

    public function execute() {
       $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $status = $request->getParameter('status');//是否开启插件

        $data['c_cengji'] = $request->getParameter('c_cengji');//分销层级（0.不开启分销机制  1.一级分销 2.二级分销  3.三级分销  4.四级分销 5.五级分销 
        $data['c_uplevel'] = $request->getParameter('c_uplevel');//等级晋升设置（1.满足任意一项升级，2.满足所有项升级）
        $data['c_neigou'] = $request->getParameter('c_neigou');//分销内购（1.关闭  2.开启）c_neigou
        $data['c_pay'] = $request->getParameter('c_pay');//规则统计方式（1.付款后  2.完成后
        $data['c_yjjisuan'] = $request->getParameter('c_yjjisuan');//佣金计算方式（0.默认佣金计算方式商品现价）

        $data['cash_type'] = $request->getParameter('cash_type');//提现方式
        $data['cash_bank'] = $request->getParameter('cash_bank');//可提现银行
        $data['cash_min'] = $request->getParameter('cash_min');//最低额度
        $data['cash_max'] = $request->getParameter('cash_max');//最高额度
        $data['cash_charge'] = $request->getParameter('cash_charge');//手续费

        $data['one'][0] = empty($request->getParameter('one_on'))?0:$request->getParameter('one_on');//个人进货奖条件
        $data['one'][1] = empty($request->getParameter('one_put'))?0:$request->getParameter('one_put');//个人进货奖奖励
        $data['team'][0] = empty($request->getParameter('team_on'))?0:$request->getParameter('team_on');//团队业绩奖条件
        $data['team'][1] = empty($request->getParameter('team_put'))?0:$request->getParameter('team_put');//团队业绩奖奖励
        $data['re_mch'] = empty($request->getParameter('re_mch'))?0:$request->getParameter('re_mch');//推荐店铺奖

        $data['content'] = empty($request->getParameter('content'))?'':$request->getParameter('content');//分销规则

        $log = new LaiKeLogUtils('common/distribution.log');// 日志

        // 删除原本配置
        $sql = "delete from lkt_distribution_config where store_id = '$store_id'";
        $db->delete($sql);
        $info=serialize($data);

        // 添加新配置
        $sql01 = "insert into lkt_distribution_config(store_id,sets,status) values('$store_id','$info','$status')";
        $rr = $db->insert($sql01);

        if($rr>0){
            $db->admin_record($store_id,$admin_name,'修改分销设置成功！',2);
            $log -> customerLog(__LINE__.":修改分销设置成功！\r\n");
        	echo json_encode(array('status'=>'保存成功！','suc'=>'1'));
        }else{
            $db->admin_record($store_id,$admin_name,'修改分销设置失败！',2);
            $log -> customerLog(__LINE__.":修改分销设置失败：$sql01\r\n");
            echo json_encode(array('status'=>'未知原因，保存失败！'));
        }
    }

    public function getRequestMethods(){
        return Request ::POST;
    }
    
}
?>