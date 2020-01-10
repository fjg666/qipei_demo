<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddgroupAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $tuanZ = json_decode($request->getParameter('tuanZ'));
        $gdata = json_decode($request->getParameter('gdata'));
        $goods_id = json_decode($request->getParameter('goods_id'));
        $glevel = $request->getParameter('glevel');
        $group_title = $request->getParameter('group_title');

        $db->begin();

        //首先根据商品id 查询出该商品的所有属性
        $sel_attr_sql = "select c.id from lkt_configure as c
                        left join lkt_product_list as p on c.pid = p.id
                        where c.pid = $goods_id and p.store_id = $store_id";
        $attr_res = $db->select($sel_attr_sql);

        //获取结束日期和开始日期 如果是长期活动，将结束时间设置为一年后
        if ($gdata->endtime == 'changqi') {
            $gdata->endtime = date("Y-m-d H:i:s", strtotime("+1years"));
        }
        $starttime = $gdata->starttime;
        $endtime = $gdata->endtime;

        //如果没有填写拼团名称 则默认为商品名称
        if ($group_title == '') {
            $goods_sql = "select product_title from lkt_product_list where id=$goods_id and store_id = $store_id";
            $goods_res = $db->select($goods_sql);
            $group_title = $goods_res[0]->product_title;
        }

        //设置拼团活动的版本号
        $sel_activity_sql = "SELECT max(activity_no) as activity_no FROM lkt_group_product WHERE 1";
        $activity_res = $db->select($sel_activity_sql);
        if ($activity_res) {
            $activity_no = $activity_res[0]->activity_no;

            if ($activity_no == null) {
                $activity_no = 1;
            } else {
                $activity_no++;
            }
        } else {
            $activity_no = 1;
        }

        //添加拼团活动数据
        $gdata = serialize($gdata);
        $glevel = serialize($glevel);
        $str = 'insert into lkt_group_product(store_id,attr_id,product_id,group_level,group_data,group_title,starttime,endtime,activity_no) values';
        foreach ($attr_res as $k => $v) {
            $attr_id = $v->id;
            $str .= "('$store_id',$attr_id,$goods_id,'$glevel','$gdata','$group_title','$starttime','$endtime','$activity_no'),";
        }
        $str = substr($str, 0, strlen($str) - 1);
        $respro = $db->insert($str);
        $lktlog = new LaiKeLogUtils("common/group.log");

        if ($respro < 0) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."添加拼团活动失败！sql:".$str);

            $db->rollback();
            echo json_encode(array('code' => 0));
            exit;
        } else {
            $lktlog->customerLog(__METHOD__.":".__LINE__."添加拼团活动成功！");

            $db->commit();
            echo json_encode(array('code' => 1));
            exit;
        }
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}

?>