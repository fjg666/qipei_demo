<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');



class MemberAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg'); // 图片上传路径
        $serverURL = $this->getContext()->getStorage()->read('serverURL');


    }

    /**
     * 删除拼团活动方法
     */
    public function delpro()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');
        $activity_no = $request->getParameter('activity_no');
        if (strpos($id, ',')) {
            $id = substr($id, 0, -1);
        }
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $sql = "UPDATE `lkt_group_product` SET `is_delete`= '1' WHERE product_id in($id) and activity_no = '$activity_no' and store_id='$store_id'";
        $res = $db->update($sql);
        $lktlog = new LaiKeLogUtils("common/group.log");
        if ($res <= 0) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."删除拼团活动失败！sql:".$sql);

            echo json_encode(array('status' => 0, 'info' => '删除失败!'));
            exit;
        } else {
            $lktlog->customerLog(__METHOD__.":".__LINE__."删除拼团活动成功！");
            echo json_encode(array('status' => 1, 'info' => '删除成功!'));
            exit;
        }
    }

    /**
     * 删除拼团活动方法
     */
    public function del_all_pro()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $db->begin();
        $sql = "UPDATE `lkt_group_product` SET `is_delete`= '1' WHERE activity_no in($id) and store_id='$store_id'";
        $res = $db->update($sql);
        $lktlog = new LaiKeLogUtils("common/group.log");

        if ($res <= 0) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."删除拼团活动失败！sql:".$sql);
            $db->rollback();
            echo json_encode(array('status' => 0, 'info' => '删除失败!'));
            exit;
        } else {
            $lktlog->customerLog(__METHOD__.":".__LINE__."删除拼团活动成功！");
            $db->commit();
            echo json_encode(array('status' => 1, 'info' => '删除成功!'));
            exit;
        }
    }

    /**
     * 开启、结束拼团活动
     */
    public function is_market()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');
        $type = $request->getParameter('type');    //停止或开始产品砍价
        $activity_no = $request->getParameter('activity_no');    //活动编号
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        //开启事物
        $db->begin();

        $lktlog = new LaiKeLogUtils("common/group.log");

        //查询拼团活动
        $sql = "select * from lkt_group_product where store_id = $store_id and product_id = $id and activity_no = '$activity_no'";
        $res = $db->select($sql);
        //获取活动数据
        $group_data = $res[0]->group_data;
        $group_data_obj = unserialize($group_data);

        $starttime = date("Y-m-d H:i:s", time());
        $group_data = serialize($group_data_obj);
        $str = '';
        if ($type == 2) {

            //开启活动
            if (strtotime($res[0]->starttime) <= 0 && strtotime($res[0]->endtime) <= 0) {
                //复制活动，没有重新编辑
                echo json_encode(array('status' => 0, 'info' => '请先编辑设置活动商品！'));
                exit;
            }

            $starttime = date("Y-m-d H:i:s", time());
            $group_data_obj->starttime = $starttime;
            $group_data = serialize($group_data_obj);
            $str .= ",is_show = 1,group_data = '$group_data'";
        } else if ($type == 3) {
            //结束活动

            $endtime = date("Y-m-d H:i:s", time());
            $group_data_obj->endtime = $endtime;
            $group_data = serialize($group_data_obj);
            $str .= ",is_show = 1,group_data = '$group_data'";
            //修改开团结束时间
            $up_open_sql = "update lkt_group_open set endtime = '$endtime'  where ptgoods_id=$id and store_id = $store_id and (ptstatus =0 or ptstatus =1)";
            $db->update($up_open_sql);

            $lktlog->customerLog(__METHOD__.":".__LINE__."结束活动操作。sql：".$up_open_sql);

        }

        //修改活动状态等 一些参数
        $sql = "update lkt_group_product set g_status=$type  $str where product_id=$id and store_id='$store_id' and is_delete = 0 and activity_no = '$activity_no'";

        $res = $db->update($sql);
        if ($res < 0) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改拼团活动状态失败！sql：".$sql);

            $db->rollback();
            echo json_encode(array('status' => 0, 'info' => '操作失败!'));
            exit;
        } else {
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改拼团活动状态成功！");

            $db->commit();
            echo json_encode(array('status' => 1, 'info' => '操作成功!'));
            exit;
        }
    }

    //活动复制
    public function copy()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $activity_no = intval($request->getParameter("activity_no")); // 活动id


        //查询被复制的活动
        $sel_sql = "select * from lkt_group_product where store_id = $store_id and activity_no = $activity_no";
        $res = $db->select($sel_sql);
        $db->begin();
        //设置版本号
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
            echo json_encode(array('code' => 0));
            exit;
        }

        $def_time = date('Y-m-d H:i:s', 0);
        //循环被复制的活动

        $str = 'insert into lkt_group_product(store_id,attr_id,product_id,group_level,group_data,group_title,starttime,endtime,activity_no,g_status,is_copy) values';
        foreach ($res as $k => $v) {
            $attr_id = $v->attr_id;
            $goods_id = $v->product_id;
            $glevel = $v->group_level;

            $gdata = $v->group_data;
            $gdata_ = unserialize($gdata);
            $gdata_->starttime = $def_time;
            $gdata_->endtime = $def_time;
            $gdata = serialize($gdata_);
            $str .= "('$store_id',$attr_id,$goods_id,'$glevel','$gdata','','$def_time','$def_time','$activity_no',1,1),";
        }

        $str = substr($str, 0, strlen($str) - 1);

        //数据添加
        $respro = $db->insert($str);
        $lktlog = new LaiKeLogUtils("common/group.log");

        if ($respro < 0) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."复制拼团失败！sql:".$str);
            echo json_encode(array('status' => 0, 'info' => '复制失败!'));
            $db->rollback();
            exit;
        } else {
            $lktlog->customerLog(__METHOD__.":".__LINE__."复制拼团成功！");
            echo json_encode(array('status' => 1, 'info' => '复制完成!','activity_no'=>$activity_no,'id'=>$goods_id));
            $db->commit();
            exit;
        }
    }

    /**
     * 显示、隐藏操作方法
     */
    public function contpro()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $type = $request->getParameter('type');
        $activity_no = $request->getParameter('activity_no');
        $id = intval($request->getParameter("id")); // 商品id
        $db->begin();
        $lktlog = new LaiKeLogUtils("common/group.log");

        $sql = "update lkt_group_product set is_show=$type where product_id=$id and store_id='$store_id' and activity_no = '$activity_no'";
        $res = $db->update($sql);
        if ($res < 0) {
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改拼团显示状态失败！sql:".$sql);
            $db->rollback();
            echo json_encode(array('status' => 0, 'info' => '操作失败!'));
            exit;
        } else {
            $lktlog->customerLog(__METHOD__.":".__LINE__."修改拼团显示状态成功！");
            $db->commit();
            echo json_encode(array('status' => 1, 'info' => '操作成功!'));
            exit;
        }
    }

    public function execute()
    {
        $request = $this->getContext()->getRequest();
        $m = $request->getParameter('m');
        $this->$m();
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>