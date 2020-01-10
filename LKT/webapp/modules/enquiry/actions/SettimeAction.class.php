<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class SettimeAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $m = $request->getParameter('m');//请求类型

        if($m != '' && !empty($m)){
            $this->$m();
            exit;
        }

        //查询活动列表数据

        $sql = "SELECT * FROM `lkt_seconds_activity` WHERE 1 and store_id = $store_id and is_delete = 0";
        $res = $db->select($sql);
        $res_str = json_encode($res);
        $request->setAttribute("list",$res_str);
        $request->setAttribute("pages_show",1);
        return View :: INPUT;
    }

    /**
     * 获取时段列表数据
     */
    public function axios(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $pages = $request->getParameter('pages');//页码
        $limit = $request->getParameter('limit');//容量

        if($pages == ''){
            $pages = 1;
        }

        if($limit == ''){
            $limit = 10;
        }

        $begin_limit = ($pages - 1)*10;

        $ret['code'] = 0;

        //查询秒杀时段
        $sql = "SELECT * FROM `lkt_seconds_time` WHERE 1 and store_id = $store_id and is_delete = 0 order by starttime limit $begin_limit,$limit";
        $res = $db->select($sql);
        //查询所有秒杀时段
        $sql1 = "SELECT * FROM `lkt_seconds_time` WHERE 1 and store_id = $store_id and is_delete = 0 order by starttime";
        $res1 = $db->select($sql1);
        //判断是否有数据
        if($res){
            //对时间做处理
            foreach ($res as $k => $v){
                $starttime_ = explode(' ',$v->starttime);
                $endtime_ = explode(' ',$v->endtime);
                $v->starttime = $starttime_[1];
                $v->endtime = $endtime_[1];
            }
            foreach ($res1 as $k1 => $v1){
                $starttime_ = explode(' ',$v1->starttime);
                $endtime_ = explode(' ',$v1->endtime);
                $v1->starttime = $starttime_[1];
                $v1->endtime = $endtime_[1];
            }

            //查询当前是否有进行中的活动
            $sql__1 = "SELECT * FROM lkt_seconds_activity WHERE 1 and store_id = $store_id and status = 2 and is_delete = 0";
            $res__1 = $db->select($sql__1);

            $ret['list'] = $res;
            $ret['all_list'] = $res1;
            $ret['total'] = count($res1);
            $ret['activity_total'] = count($res__1);
        }
        echo json_encode($ret);
    }

    /**
     * 添加时段名称
     */
    public function add_activity_time(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $name = $request->getParameter('name');//时段名称
        $starttime = $request->getParameter('starttime');//时段开始时间
        $endtime = $request->getParameter('endtime');//时段结束时间

        $starttime = '1970-01-01 '.$starttime;
        $endtime = '1970-01-01 '.$endtime;

        //查询时段是否有时间冲突
        $sqll = "select * from lkt_seconds_time where starttime < '$endtime' && endtime > '$starttime' and is_delete != 1";
        $ct_res = $db->select($sqll);
        if(!empty($ct_res)){

            $ret['code'] = 0;
            $ret['msg'] = '活动时间有冲突！';

            echo json_encode($ret);
            exit;
        }

        //查询时段名称是否重复
        $sql = "select * from lkt_seconds_time where  name = '$name' and is_delete != 1";
        $cn_res = $db->select($sql);
        if(!empty($cn_res)){

            $ret['code'] = 0;
            $ret['msg'] = '活动名称不能重复！';

            echo json_encode($ret);
            exit;
        }
        //事物开启
        $db->begin();
        //添加一条秒杀时段数据
        $add_sql = "INSERT INTO `lkt_seconds_time`( `name`,`store_id`, `starttime`, `endtime`) VALUES ('$name','$store_id','$starttime','$endtime')";
        $add_res = $db->insert($add_sql);
        $ret['sql'] = $add_sql;

        if($add_res > 0){
            $db->commit();
            $ret['code'] = 1;
            $ret['msg'] = '添加时段成功！';
        }else{
            $ret['code'] = 0;
            $ret['msg'] = '添加时段失败！';
            $db->rollback();
        }
        echo json_encode($ret);

    }

    /*
     * 删除活动时段
     */
    public function del_activity_time(){
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
        if($res > 0){
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除时段成功！");
            $ret['code'] = 1;
            $ret['msg'] = '删除时段成功！';
            $db->commit();
        }else{
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除时段失败！sql:" . $up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '删除时段失败！';
            $db->rollback();
        }
        echo json_encode($ret);

    }

    /*
     * 编辑时段
     */
    public function edit_activity_time(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');//时段id
        $name = $request->getParameter('name');//时段名称
        $starttime = $request->getParameter('starttime');//时段开始时间
        $endtime = $request->getParameter('endtime');//时段结束时间
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $starttime = '1970-01-01 '.$starttime;
        $endtime = '1970-01-01 '.$endtime;

        //查询时段是否有时间冲突
        $sqll = "select * from lkt_seconds_time where starttime < '$endtime' && endtime > '$starttime' and is_delete != 1 and id != $id";
        $ct_res = $db->select($sqll);
        if(!empty($ct_res)){
                $ret['code'] = 0;
                $ret['msg'] = '时段时间有冲突！';
            echo json_encode($ret);
            exit;
        }

        //事物开启
        $db->begin();
        //修改一条活动数据
        $up_sql = "UPDATE `lkt_seconds_time` SET `name`='$name',`starttime`='$starttime',`endtime`='$endtime' WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->update($up_sql);

        $lktlog = new LaiKeLogUtils("common/seconds.log");

        if($res >= 0){
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改时段成功！");
            $ret['code'] = 1;
            $ret['msg'] = '修改时段成功！';
            $db->commit();
        }else{
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改时段失败！sql:".$up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '修改时段失败！';
            $ret['sql'] = $up_sql;
            $db->rollback();
        }
        echo json_encode($ret);

    }
    public function execute() {
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>