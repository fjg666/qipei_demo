<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class RecordAction extends Action {

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


        //接收活动参数
        $activity_id = $request->getParameter('activity_id');//活动id

        $request->setAttribute("activity_id",$activity_id);
        $request->setAttribute("pages_show",1);
        return View :: INPUT;
    }

    //获取时段列表数据
    public function axios(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $pages = $request->getParameter('pages');//页码
        $limit = $request->getParameter('limit');//容量
        $activity_id = $request->getParameter('activity_id');//活动id
        $proname = $request->getParameter('proname');//活动id
        $timename = $request->getParameter('timename');//活动id
        $userid = $request->getParameter('userid');//活动id


        if($pages == ''){
            $pages = 1;
        }

        if($limit == ''){
            $limit = 10;
        }

        $begin_limit = ($pages - 1)*10;

        $ret['code'] = 0;


        $whereStr = '';

        if($proname != ''){
            $whereStr.=" and pl.product_title like '%$proname%'";
        }

        if($timename != ''){
            $whereStr.=" and st.name like '%$timename%'";
        }

        if($userid != ''){
            $whereStr.=" and u.user_id = '$userid'";
        }

        $sql = "SELECT
                        sr.*, st.starttime,
                        st.endtime,
                        st.name,
                        pl.product_title,
                        u.user_name,
                        sa.starttime AS stime,
                        sa.endtime AS etime
                    FROM
                        `lkt_seconds_record` AS sr
                    LEFT JOIN lkt_seconds_time AS st ON st.id = sr.time_id
                    LEFT JOIN lkt_product_list AS pl ON sr.pro_id = pl.id
                    LEFT JOIN lkt_user AS u ON sr.user_id = u.user_id
                    LEFT JOIN lkt_seconds_activity AS sa ON sa.id = sr.activity_id
                    LEFT JOIN lkt_order as o on sr.sNo = o.sNo
                    WHERE
                        1 $whereStr
                    AND sr.store_id = $store_id
                    AND sr.activity_id = $activity_id
                    AND o.status != 0
                    AND (o.status != 6 and pay_time != 'null')
                    AND sr.is_delete = 0  
                    order by sr.add_time desc
                    limit $begin_limit,$limit";
        $res = $db->select($sql);


        $sql_count = "SELECT
                        sr.*
                    FROM
                        `lkt_seconds_record` AS sr
                    WHERE
                        1 $whereStr
                    AND sr.store_id = $store_id
                    AND sr.activity_id = $activity_id
                    AND o.status != 0
                    AND (o.status != 6 and pay_time != 'null')
                    AND sr.is_delete = 0  
                    AND sr.is_delete = 0";
        $count_res = $db->select($sql_count);
        if($res){
            foreach ($res as $k => $v){
                $stime_ = explode(' ',$v->stime);
                $etime_ = explode(' ',$v->etime);
                $v->stime = $stime_[0];
                $v->etime = $etime_[0];
                $starttime_ = explode(' ',$v->starttime);
                $endtime_ = explode(' ',$v->endtime);
                $v->starttime = $starttime_[1];
                $v->endtime = $endtime_[1];
                $starttime_ = explode(':',$v->starttime);
                $endtime_ = explode(':',$v->endtime);
                $v->starttime = $starttime_[0].':'. $starttime_[1];
                $v->endtime = $endtime_[0].':'.$endtime_[1];
            }

            $ret['list'] = $res;
            $ret['total'] = count($count_res);
        }else{
            $ret['list'] = array();
            $ret['total'] = 0;
        }
        echo json_encode($ret);
    }

    //删除秒杀记录
    public function del_record(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');//记录id

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        //事物开启
        $db->begin();

        //删除一条秒杀记录
        $up_sql = "UPDATE `lkt_seconds_record` SET `is_delete`= 1 
                    WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->update($up_sql);
        $lktlog = new LaiKeLogUtils("common/seconds.log");

        if($res > 0){
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除记录成功！");
            $ret['code'] = 1;
            $ret['msg'] = '删除记录成功！';
            $db->commit();
        }else{
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除记录失败！sql:".$up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '删除记录失败！';
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