<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class AddproAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $m = $request->getParameter('m');//请求类型
        $activity_id = $request->getParameter('activity_id');//请求类型
        if ($m != '' && !empty($m)) {
            $this->$m();
            exit;
        }

        //查询活动列表数据

        $sql = "SELECT * FROM `lkt_seconds_activity` WHERE 1 and store_id = $store_id and is_delete = 0";
        $res = $db->select($sql);
        $res_str = json_encode($res);
        $request->setAttribute("list", $res_str);
        $request->setAttribute("activity_id", $activity_id);
        $request->setAttribute("pages_show", 1);
        return View :: INPUT;
    }

    /**
     * 获取时段列表数据
     */
    public function axios()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $pages = $request->getParameter('pages');//页码
        $limit = $request->getParameter('limit');//容量


        if ($pages == '') {
            $pages = 1;
        }

        if ($limit == '') {
            $limit = 10;
        }

        $begin_limit = ($pages - 1) * 10;

        $ret['code'] = 0;
        //查询数据分页数据
        $sql = "SELECT * FROM `lkt_seconds_time` WHERE 1 and store_id = $store_id and is_delete = 0 order by starttime limit $begin_limit,$limit";
        $res = $db->select($sql);
        //查询所有数据
        $sql_count = "SELECT * FROM `lkt_seconds_time` WHERE 1 and store_id = $store_id and is_delete = 0 ";
        $count_res = $db->select($sql_count);

        //如果有数据，对数据做处理，赋值
        if ($res) {
            foreach ($res as $k => $v) {
                $starttime_ = explode(' ', $v->starttime);
                $endtime_ = explode(' ', $v->endtime);
                $v->starttime = $starttime_[1];
                $v->endtime = $endtime_[1];
            }
            $ret['list'] = $res;
            $ret['total'] = count($count_res);
        }
        echo json_encode($ret);
    }

    /**
     * 添加时段名称
     */
    public function add_activity_time()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $name = $request->getParameter('name');//时段名称
        $starttime = $request->getParameter('starttime');//时段开始时间
        $endtime = $request->getParameter('endtime');//时段结束时间
        //事物开启
        $db->begin();

        //添加一条时段数据
        $add_sql = "INSERT INTO `lkt_seconds_time`( `name`,`store_id`, `starttime`, `endtime`) VALUES ('$name','$store_id','$starttime','$endtime')";
        $add_res = $db->insert($add_sql);
        $ret['sql'] = $add_sql;

        $lktlog = new LaiKeLogUtils("common/seconds.log");

        //判断是否添加成功
        if ($add_res > 0) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加时段成功！");
            $db->commit();
            $ret['code'] = 1;
            $ret['msg'] = '添加时段成功！';
        } else {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加时段失败！sql:" . $add_sql);
            $ret['code'] = 0;
            $ret['msg'] = '添加时段失败！';
            $db->rollback();
        }
        echo json_encode($ret);

    }

    /**
     * 删除活动时段
     */
    public function del_activity_time()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');//活动id

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        //事物开启
        $db->begin();

        //删除一条时段数据
        $up_sql = "UPDATE `lkt_seconds_time` SET `is_delete`= 1 
                    WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->update($up_sql);

        $lktlog = new LaiKeLogUtils("common/seconds.log");
        //判断是否删除成功
        if ($res > 0) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除秒杀时段成功！");
            $ret['code'] = 1;
            $ret['msg'] = '删除时段成功！';
            $db->commit();
        } else {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除秒杀时段失败！sql:" . $up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '删除时段失败！';
            $db->rollback();
        }
        echo json_encode($ret);

    }

    /**
     * 编辑一条时段数据
     */
    public function edit_activity_time()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');//时段id
        $name = $request->getParameter('name');//时段名称
        $starttime = $request->getParameter('starttime');//时段开始时间
        $endtime = $request->getParameter('endtime');//时段结束时间
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        //事物开启
        $db->begin();
        //修改一条活动数据
        $up_sql = "UPDATE `lkt_seconds_time` SET `name`='$name',`starttime`='$starttime',`endtime`='$endtime'
                    WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->update($up_sql);
        $lktlog = new LaiKeLogUtils("common/seconds.log");

        //判断是否编辑成功
        if ($res > 0) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "编辑秒杀时段失败！");
            $ret['code'] = 1;
            $ret['msg'] = '修改时段成功！';
            $db->commit();
        } else {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "编辑秒杀时段失败！sql:" . $up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '修改时段失败！';
            $ret['sql'] = $up_sql;
            $db->rollback();
        }
        echo json_encode($ret);

    }

    public function execute()
    {
    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }

}

?>