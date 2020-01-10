<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class ConfigAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //查询是否已经配置 如果没有配置则取默认值
        $res = $db->select("select * from lkt_group_config where store_id = '$store_id'");
        if ($res && !empty($res[0]->open_num)) {
            $group_time = $res[0]->group_time;
            $open_num = $res[0]->open_num;
            $can_num = $res[0]->can_num;
            $can_again = $res[0]->can_again;
            $open_discount = $res[0]->open_discount;
            $image = $res[0]->image;
            $rule = $res[0]->rule;
        } else {
            $group_time = 10;
            $open_num = 10;
            $can_num = 10;
            $can_again = 1;
            $open_discount = 1;
            $image = '';
            $rule = '';
        }

        $request->setAttribute("res", $res);
        $request->setAttribute("group_time", $group_time);
        $request->setAttribute("open_num", $open_num);
        $request->setAttribute("can_num", $can_num);
        $request->setAttribute("can_again", $can_again);
        $request->setAttribute("open_discount", $open_discount);
        $request->setAttribute("image", $image);
        $request->setAttribute("rule", $rule);
        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $retype = $request->getParameter('retype');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $group_time = $request->getParameter('group_time');//拼团时限
        $open_num = $request->getParameter('open_num');//开团数量
        $can_num = $request->getParameter('can_num');//参团数量
        $can_again = $request->getParameter('can_again');//是否重复参团 1 是 0 否
        $open_discount = $request->getParameter('open_discount');//团长优惠 1 是 0 否
        $image = $request->getParameter('image');//轮播图
        $rule = $request->getParameter('rule');//规则

        $db->begin();

        //查询是否已有设置
        $sel_sql = "select * from lkt_group_config where store_id = $store_id";
        $sel_res = $db->select($sel_sql);
        if (empty($sel_res)) {
            //如果已经设置 对数据进行修改
            $action_sql = "INSERT INTO `lkt_group_config`(`store_id`, `refunmoney`, `group_time`, `open_num`, `can_num`, `can_again`, `open_discount`, `image`, `rule`) 
                                                VALUES ($store_id,1,$group_time,$open_num,$can_num,$can_again,$open_discount,'$image','$rule')";
            $res = $db->insert($action_sql);
        } else {
            //如果没有设置新增一条设置数据
            $action_sql = "UPDATE `lkt_group_config` SET `group_time`=$group_time,`open_num`=$open_num,`can_num`=$can_num,`can_again`=$can_again,`open_discount`=$open_discount,`image`='$image',`rule`='$rule' WHERE store_id = $store_id";
            $res = $db->update($action_sql);
        }
        $ret['code'] = 0;
        $ret['msg'] = "设置失败！";
        $lktlog = new LaiKeLogUtils("common/group.log");
        if ($res >= 0) {
            $ret['code'] = 1;
            $ret['msg'] = "设置成功！";
            $db->commit();
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改拼团配置成功！");
        }else{
            $db->rollback();
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改拼团配置失败！，sql:".$action_sql);

        }
        echo json_encode($ret);
        exit;


    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>