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

    public function execute()
    {
        $request = $this->getContext()->getRequest();

        $m = $request->getParameter('m');
        $this->$m();
    }

    /**
     * 获取首页列表数据
     */
    public function axios()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $pages = $request->getParameter('pages');//页码
        $limit = $request->getParameter('limit');//容量
        $mstype = $request->getParameter('mstype');//活动类型
        $activityname = $request->getParameter('activityname');// 活动名称
        $msstatus = $request->getParameter('msstatus');// 活动状态

        $content = "";

        if ($mstype != '') {
            $content .= " and type = $mstype";
        }
        if ($activityname != '') {
            $content .= " and name like '%$activityname%'";
        }
        if ($msstatus != '') {
            $content .= " and status = $msstatus";
        }

        if ($pages == '') {
            $pages = 1;
        }

        if ($limit == '') {
            $limit = 10;
        }

        $begin_limit = ($pages - 1) * 10;


        $ret['code'] = 0;

        //查询分页秒杀活动
        $sql = "SELECT * FROM `lkt_seconds_activity` WHERE 1 $content and store_id = $store_id and is_delete = 0 ORDER BY status  limit $begin_limit,$limit";
        $res = $db->select($sql);
//        查询所有秒杀活动
        $sql_count = "SELECT * FROM `lkt_seconds_activity` WHERE 1 $content and store_id = $store_id and is_delete = 0";
        $count_res = $db->select($sql_count);
        //如果有数据，对数据做处理
        if (!empty($res)) {
            foreach ($res as $k => $v) {
                $starttime = $v->starttime;
                $endtime = $v->endtime;
                $start_time = explode(' ', $starttime);
                $end_time = explode(' ', $endtime);
                $v->starttime = $start_time[0];
                $v->endtime = $end_time[0];
            }
        }

        //查询设置的时段
        $sql_time_count = "SELECT * FROM `lkt_seconds_time` WHERE 1  and store_id = $store_id and is_delete = 0";
        $time_count = $db->select($sql_time_count);
        $time_count = count($time_count);
        //判断是否查询到数据
        if ($res) {
            $ret['list'] = $res;
            $ret['total'] = count($count_res);
            $ret['msstatus'] = $msstatus;
            $ret['activityname'] = $activityname;
            $ret['mstype'] = $mstype;
            $ret['time_count'] = $time_count;
        } else {
            $ret['list'] = array();
            $ret['total'] = 0;
            $ret['msstatus'] = $msstatus;
            $ret['activityname'] = $activityname;
            $ret['mstype'] = $mstype;
            $ret['time_count'] = $time_count;
        }
        echo json_encode($ret);
    }

    /**
     * 添加一条活动数据
     */
    public function add_activity()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $name = $request->getParameter('name');//活动名称
        $type = $request->getParameter('type');//活动类型
        $starttime = $request->getParameter('starttime');//活动开始时间
        $endtime = $request->getParameter('endtime');//活动结束时间
        $isshow = $request->getParameter('isshow');//是否显示 1 是 0 否
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $starttime = $starttime . ' 00:00:00';
        $endtime = $endtime . ' 00:00:00';

        //查询活动是否有时间冲突
        $sqll = "select * from lkt_seconds_activity where starttime <= '$endtime' && endtime >= '$starttime' and is_delete != 1 ";
        $ct_res = $db->select($sqll);

        //如果有数据，表示有此时间的活动
        if (!empty($ct_res)) {

            $ret['code'] = 0;
            $ret['msg'] = '活动时间有冲突！';

            echo json_encode($ret);
            exit;
        }


        //查询活动名称是否有重复
        $sqll = "select * from lkt_seconds_activity where name = '$name' and is_delete != 1 ";
        $ct_res = $db->select($sqll);

        if (!empty($ct_res)) {

            $ret['code'] = 0;
            $ret['msg'] = '活动名称不能重复！';

            echo json_encode($ret);
            exit;
        }

        //事物开启
        $db->begin();

        //添加一条活动数据
        $ist_sql = "INSERT INTO `lkt_seconds_activity`( `name`,`store_id`, `type`, `starttime`, `endtime`, `isshow`) VALUES ('$name','$store_id','$type','$starttime','$endtime','$isshow')";
        $res = $db->insert($ist_sql);
        $lktlog = new LaiKeLogUtils("common/seconds.log");

        if ($res > 0) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加秒杀活动成功！");
            $db->commit();
            $ret['code'] = 1;
            $ret['msg'] = '添加活动成功！';
        } else {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加秒杀活动失败！sql:".$ist_sql);
            $ret['code'] = 0;
            $ret['msg'] = '添加活动失败！';
            $db->rollback();
        }
        echo json_encode($ret);

    }

    /**
     * 修改显示状态
     */
    public function edit_show()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $id = $request->getParameter('id');//活动id
        $isshow = $request->getParameter('isshow');//是否显示1是 0否

        //事物开启
        $db->begin();

        //修改活动显示
        $up_sql = "  `lkt_seconds_activity` SET `isshow`= $isshow 
                    WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->update($up_sql);
        $lktlog = new LaiKeLogUtils("common/seconds.log");

        //判断是否执行成功
        if ($res > 0) {

            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改活动显示状态成功！");

            $ret['code'] = 1;
            $ret['msg'] = '修改成功！';
            $db->commit();

        } else {

            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改活动显示状态失败！sql：".$up_sql);

            $ret['code'] = 0;
            $ret['msg'] = '修改失败！';
            $db->rollback();
        }
        echo json_encode($ret);
    }

    /**
     * 删除活动
     */
    public function del_activity()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');//活动id

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        //事物开启
        $db->begin();

        //删除一条活动数据
        $up_sql = "UPDATE `lkt_seconds_activity` SET `is_delete`=1 
                    WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->update($up_sql);

        $lktlog = new LaiKeLogUtils("common/seconds.log");

        //判断是否执行成功
        if ($res > 0) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除活动成功！");
            $ret['code'] = 1;
            $ret['msg'] = '删除活动成功！';
            $db->commit();
        } else {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除活动失败！sql:".$up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '删除活动失败！';
            $db->rollback();
        }
        echo json_encode($ret);

    }

    /**
     * 编辑活动
     */
    public function edit_activity()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');//活动id
        $name = $request->getParameter('name');//活动名称
        $type = $request->getParameter('type');//活动类型
        $starttime = $request->getParameter('starttime');//活动开始时间
        $endtime = $request->getParameter('endtime');//活动结束时间
        $isshow = $request->getParameter('isshow');//是否显示 1 是 0 否
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $starttime = $starttime . ' 00:00:00';
        $endtime = $endtime . ' 00:00:00';

        //查询活动是否有时间冲突
        $sqll = "select * from lkt_seconds_activity where starttime <= '$endtime' && endtime >= '$starttime' and is_delete != 1 and id != $id";
        $ct_res = $db->select($sqll);
        //判断是否有冲突数据
        if (!empty($ct_res)) {

            $ret['code'] = 0;
            $ret['msg'] = '活动时间有冲突！';

            echo json_encode($ret);
            exit;
        }

        //查询活动名称是否有重复
        $sqll = "select * from lkt_seconds_activity where name = '$name' and is_delete != 1 and id != $id";
        $ct_res = $db->select($sqll);
        //判断是否有重复名字活动
        if (!empty($ct_res)) {

            $ret['code'] = 0;
            $ret['msg'] = '活动名称不能重复！';

            echo json_encode($ret);
            exit;
        }

        //事物开启
        $db->begin();
        //删除一条活动数据
        $up_sql = "UPDATE `lkt_seconds_activity` SET `name`='$name',`type`='$type',`starttime`='$starttime',`endtime`='$endtime',`isshow`='$isshow' 
                    WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->delete($up_sql);

        $lktlog = new LaiKeLogUtils("common/seconds.log");

        //判断修改数据是否成功
        if ($res >= 0) {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除秒杀活动成功！");
            $ret['code'] = 1;
            $ret['msg'] = '修改活动成功！';
            $db->commit();
        } else {
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除秒杀活动失败！sql:".$up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '修改活动失败！';
            $db->rollback();
        }
        echo json_encode($ret);

    }


    public function getRequestMethods()
    {
        return Request :: POST;
    }

}

?>