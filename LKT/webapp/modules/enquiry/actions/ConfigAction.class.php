<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');


class ConfigAction extends Action
{

    public function getDefaultView()
    {
        $request = $this->getContext()->getRequest();

        $m = $request->getParameter('m');//请求类型

        if ($m != '' && !empty($m)) {
            $this->$m();
            exit;
        }
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $res = $db->select("select * from lkt_seconds_config where store_id = '$store_id'");
        if (!empty($res)) {
            $rule = $res[0]->rule;
            $imageurl = $res[0]->imageurl;
        } else {
            $rule = '';
            $imageurl = '';
        }

        $request->setAttribute("rule", $rule);
        $request->setAttribute("imageurl", $imageurl);
        return View :: INPUT;
    }

    public function execute()
    {
    }

    /**
     * 获取config数据
     */
    public function axios()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        //查询配置数据
        $sql = "select * from lkt_seconds_config where store_id = $store_id";
        $res = $db->select($sql);

        //给出默认值
        $ret['is_open'] = 0;
        $ret['buy_num'] = 1;
        $ret['remind'] = 10;
        $ret['imageurl'] = '';
        $ret['rule'] = '';

        //判断是否已经有配置数据，如果有：重新赋值
        if (!empty($res)) {
            $ret['is_open'] = $res[0]->is_open;
            $ret['buy_num'] = $res[0]->buy_num;
            $ret['remind'] = $res[0]->remind;
            $ret['imageurl'] = $res[0]->imageurl;
            $ret['rule'] = $res[0]->rule;
        }
        echo json_encode($ret);
    }

    /**
     * 存储config数据
     */
    public function save()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id


        $is_open = $request->getParameter('is_open');//是否开启 1是 0否
        $buy_num = $request->getParameter('buy_num');//限购数量
        $remind = $request->getParameter('remind');//秒杀提醒（单位：分钟）
        $rule = addslashes(trim($request->getParameter('rule')));//秒杀规则
        $imageurl = $request->getParameter('imageurl');//秒杀轮播图

        $lktlog = new LaiKeLogUtils("common/seconds.log");

        //查询配置数据
        $sql = "select * from lkt_seconds_config where store_id = $store_id";
        $res = $db->select($sql);
        $db->begin();
        //判断是否有数据，如果有做编辑操作，如果没有做添加操作
        if (!empty($res)) {
            //如果有数据，做修改操作
            $pd = false;
            if ($is_open == 1) {
                $pd = true;
            }

            if ($pd) {
                //如果想开启秒杀 查询时段是否大于5个 否则不允许开启
                $sel_time_num_sql = "SELECT COUNT(*) as sum FROM lkt_seconds_time WHERE is_delete = 0 and store_id = $store_id";
                $time_num_res = $db->select($sel_time_num_sql);
                if (!empty($time_num_res)) {
                    $sum = $time_num_res[0]->sum;
                    if ($sum >= 5) {
                    } else {
                        $db->rollback();
                        $ret['code'] = 0;
                        $ret['msg'] = '时段数量必须大于等于5个才能开启秒杀！';
                        echo json_encode($ret);
                        exit;
                    }
                }
            }
            //对数据做编辑操作
            $action_sql = "update lkt_seconds_config set is_open = $is_open ,buy_num = $buy_num,remind = $remind,rule = '$rule',imageurl = '$imageurl' where store_id = $store_id";
            $res1 = $db->update($action_sql);
            //判断编辑是否成功
            if ($res1 >= 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "秒杀配置编辑成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "秒杀配置编辑失败！sql:" . $action_sql);
            }

        } else {

            //如果没有数据，做添加操作
            $action_sql = "INSERT INTO `lkt_seconds_config`(`store_id`, `is_open`, `buy_num`, `imageurl`, `remind`, `rule`) VALUES ($store_id,$is_open,$buy_num,'$imageurl',$remind,'$rule')";
            $res1 = $db->insert($action_sql);
            //判断编辑是否成功
            if ($res1 >= 0) {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "秒杀配置添加成功！");
            } else {
                $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "秒杀配置添加失败！sql:" . $action_sql);
            }
        }

        $ret = array();
        if ($res1 >= 0) {
            $db->commit();
            $ret['code'] = 1;
            $ret['msg'] = '保存成功！';
        } else {
            $db->rollback();
            $ret['code'] = 0;
            $ret['msg'] = '保存失败！';
            $ret['sql'] = $action_sql;

        }
        echo json_encode($ret);
    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }

}

?>