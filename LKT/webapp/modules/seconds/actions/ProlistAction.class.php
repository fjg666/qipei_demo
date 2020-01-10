<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');


class ProlistAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $m = $request->getParameter('m');//请求类型
        $activity_id = $request->getParameter('activity_id');//活动id
        $time_id = $request->getParameter('time_id');//时段id

        if($m != '' && !empty($m)){
            $this->$m();
            exit;
        }

        //查询活动列表数据

        $sql = "SELECT * FROM `lkt_seconds_activity` WHERE 1 and store_id = $store_id and is_delete = 0";
        $res = $db->select($sql);
        $res_str = json_encode($res);
        $request->setAttribute("list",$res_str);
        $request->setAttribute("activity_id",$activity_id);
        $request->setAttribute("time_id",$time_id);
        $request->setAttribute("pages_show",1);
        return View :: INPUT;
    }

    /**
     * 修改显示状态
     */
    public function edit_show(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $id = $request->getParameter('id');//活动id
        $is_show = $request->getParameter('is_show');//是否显示1是 0否

        //事物开启
        $db->begin();
        //修改秒杀商品显示状态
        $up_sql = "UPDATE `lkt_seconds_pro` SET `is_show`= $is_show 
                    WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->update($up_sql);
        $lktlog = new LaiKeLogUtils("common/seconds.log");

        if($res > 0){
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改商品显示状态成功！");

            $ret['code'] = 1;
            $ret['msg'] = '修改成功！';
            $db->commit();

        }else{
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "修改商品显示状态失败！sql:".$up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '修改失败！';
            $db->rollback();
        }
        echo json_encode($ret);
    }


    /*
     * 获取时段列表数据
     */
    public function axios(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $activity_id = $request->getParameter('activity_id');//活动id
        $time_id = $request->getParameter('time_id');//时段id

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


        //查询秒杀商品数据
        $sql = "SELECT sp.* , pl.product_title,c.price,sc.buy_num as b_num
                FROM `lkt_seconds_pro` as sp
                left join  lkt_product_list as pl on sp.pro_id = pl.id
				LEFT JOIN lkt_configure as c on c.pid = pl.id
				left join lkt_seconds_config as sc on sp.store_id = sc.store_id
                WHERE 1 and sp.store_id = 1 and sp.is_delete = 0 and sp.activity_id = $activity_id and sp.time_id = $time_id
                GROUP BY sp.pro_id
				ORDER BY c.price 
				limit $begin_limit,$limit";
        $res = $db->select($sql);
        $sql_count = "SELECT sp.id
                FROM `lkt_seconds_pro` as sp
                left join  lkt_product_list as pl on sp.pro_id = pl.id
				LEFT JOIN lkt_configure as c on c.pid = pl.id
                WHERE 1 and sp.store_id = 1 and sp.is_delete = 0 and sp.activity_id = $activity_id and sp.time_id = $time_id
                GROUP BY sp.pro_id";
        $count_res = $db->select($sql_count);
        if($res){
            $ret['list'] = $res;
            $ret['total'] = count($count_res);
        }
        echo json_encode($ret);
    }

    /**
     * 删除秒杀商品
     */
    public function del_pro(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $id = $request->getParameter('id');//商品id
        $activity_id = $request->getParameter('activity_id');//活动id
        $time_id = $request->getParameter('time_id');//时段id

        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        //查询是否已经生成了订单 如果生成则不可删除商品
        $sql_1 = "SELECT * FROM `lkt_seconds_record` WHERE 1 and activity_id = 45 and time_id = 25 and pro_id = 21";
        $res_1 = $db->select($sql_1);
        if(!empty($res_1)){
            $ret['code'] = 0;
            $ret['msg'] = '此商品已经产生订单，删除商品失败！';
            echo json_encode($ret);
            exit;
        }
        //事物开启
        $db->begin();

        //删除一条时段数据
        $up_sql = "UPDATE `lkt_seconds_pro` SET `is_delete`= 1  WHERE 1 and id = $id and store_id = $store_id and activity_id = $activity_id and time_id = $time_id";
        $res = $db->update($up_sql);
        $lktlog = new LaiKeLogUtils("common/seconds.log");
        if($res > 0){
            //秒杀数量 存入redis
            $redis = new RedisClusters();
            $re     = $redis->connect();

            $redis_name = "seconds_".$activity_id."_".$time_id."_".$id;

            //清除库存缓存
            $redis->remove($redis_name);
//
            $redis->close();
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除秒杀商品成功！");
            $ret['code'] = 1;
            $ret['msg'] = '删除商品成功！';
            $db->commit();
        }else{
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "删除秒杀商品失败！sql:".$up_sql);
            $ret['code'] = 0;
            $ret['msg'] = '删除商品失败！';
            $ret['sql'] = $up_sql;
            $db->rollback();
        }
        echo json_encode($ret);

    }

    /**
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
        //事物开启
        $db->begin();
        //编辑一条活动数据
        $up_sql = "UPDATE `lkt_seconds_time` SET `name`='$name',`starttime`='$starttime',`endtime`='$endtime'
                    WHERE 1 and id = $id and store_id = $store_id";
        $res = $db->update($up_sql);

        $lktlog = new LaiKeLogUtils("common/seconds.log");

        //判断是否执行成功
        if($res > 0){
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "编辑秒杀活动成功！");
            $ret['code'] = 1;
            $ret['msg'] = '修改时段成功！';
            $db->commit();
        }else{
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "编辑秒杀活动失败！sql:".$up_sql);
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