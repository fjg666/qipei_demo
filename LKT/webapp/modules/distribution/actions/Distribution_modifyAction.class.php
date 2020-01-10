<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class Distribution_modifyAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = $request->getParameter('id');
        $sql = "select * from lkt_distribution_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        $re01 = unserialize($r_1[0]->sets);
        $cengji = intval($re01['c_cengji']);
        $sql01 = "select * from lkt_distribution_grade where store_id = '$store_id' and id = '$id'";
        $r_101 = $db->select($sql01);
        $r_101 = $r_101[0];
        $re02 = unserialize($r_101->sets);
        $re02['length'] = count($re02['levelmoney']);
        $levelobj = $re02['levelobj'];
        if(isset($levelobj['manyyeji'])){
            $re02['levelobj']['manyyeji'] = explode(',',$levelobj['manyyeji']);
        }
        if(isset($levelobj['manypeople'])){
            $re02['levelobj']['manypeople'] = explode(',',$levelobj['manypeople']);
        }
        if(isset($levelobj['recomm'])){
            $re02['levelobj']['recomm'] = explode(',',$levelobj['recomm']);
        }

        $sql = "select * from lkt_distribution_grade where store_id = '$store_id' order by sort asc";
        $rrr = $db->select($sql);
        $levels = array();
        if ($rrr) {
            foreach ($rrr as $k => $v) {
                $levels[$v->id] = unserialize($v->sets)['s_dengjiname'];
            }
        }

        $request->setAttribute("re", $r_101);
        $request->setAttribute("re02", $re02);
        $request->setAttribute("cengji", $cengji);
        $request->setAttribute("id", $id);
        $request->setAttribute("levels", $levels);
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        $id = $request->getParameter('id');
        $data['s_dengjiname'] = $request->getParameter('s_dengjiname');//等级名称
        $data['zhekou'] = $request->getParameter('zhekou');//分销订单购买者详情
        $data['price_type'] = $request->getParameter('price_type');//分销比例发放模式
        $data['levelobj'] = $request->getParameter('levelobj');//升级条件参数
        $data['levelmoney'] = $request->getParameter('levelmoney');//等级佣金
        $data['different'] = $request->getParameter('different')?$request->getParameter('different'):0;//级差奖
        $data['sibling'] = $request->getParameter('sibling')?$request->getParameter('sibling'):0;//平级奖
        $member_proportion = trim($request->getParameter('member_proportion'));//会员专区比例
        $integral = trim($request->getParameter('integral'));//升级奖励积分
        $discount = trim($request->getParameter('discount'));//购物折扣

        $log = new LaiKeLogUtils('common/distribution.log');// 日志
        
        if (empty($data['s_dengjiname'])) {
            $log -> customerLog(__LINE__.":修改分销等级【".$id."】失败：等级名称不能为空！ \r\n");
            echo json_encode(array('status' => 0,'msg'=>'等级名称不能为空！'));exit;
        }
        
        $dengji = $db -> select("select sets from lkt_distribution_grade where store_id = '$store_id' where id!=$id");
        if(!empty($dengji)){
           foreach ($dengji as $k => $v) {
            $v = unserialize($v -> sets)["s_dengjiname"];
            $dengji[$k] = $v;
            }
            if(in_array($data['s_dengjiname'], $dengji)){
                $log -> customerLog(__LINE__.":修改分销等级【".$id."】失败：等级名称重复 \r\n");
                echo json_encode(array('status' => 0,'msg'=>'等级名称重复!'));exit;
            }
        }
        $info = serialize($data);

        $sql = "update lkt_distribution_grade set sets = '$info',integral='$integral',discount='$discount',member_proportion='$member_proportion' where store_id = '$store_id' and id='$id'";
        $r = $db->update($sql);
        if ($r >= 0) {
            $db->admin_record($store_id,$admin_name,'修改分销等级id为'.$id,2);
            $log -> customerLog(__LINE__.":修改分销等级【".$id."】成功！ \r\n");
            echo json_encode(array('status' => 1,'msg'=>'保存成功！'));exit;
        } else {
            $db->admin_record($store_id,$admin_name,'修改分销等级id为'.$id.'失败',2);
            $log -> customerLog(__LINE__.":修改分销等级【".$id."】失败：修改失败！ \r\n");
            echo json_encode(array('status' => 0,'msg'=>'修改失败！'));exit;
        }
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>