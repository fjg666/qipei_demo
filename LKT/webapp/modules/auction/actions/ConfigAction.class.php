<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

/**
 * [Laike System] Copyright (c) 2019 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class ConfigAction extends Action
{

    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 竞拍配置
     * @date 2019年5月6日
     * @version 2.5
     */

    public function getDefaultView()
    {

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select  * from lkt_auction_config where store_id = '$store_id'";
        $res = $db->select($sql);

        if ($res) {
            $low_pepole = $res[0]->low_pepole;
            $wait_time = $res[0]->wait_time;
            $days = $res[0]->days;
            $content = $res[0]->content;
            $is_open = $res[0]->is_open;
        } else {
            $low_pepole = '';
            $wait_time = '';
            $days = 7;
            $content = '';
            $is_open = '';
        }
        


        $request->setAttribute('low_pepole', $low_pepole);
        $request->setAttribute('wait_time', $wait_time);
        $request->setAttribute('days', $days);
        $request->setAttribute('content', $content);
        $request->setAttribute('is_open', $is_open);
        
        return View :: INPUT;
    }

    public function execute()
    {

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $low_pepole = addslashes($request->getParameter('low_pepole'));
        $wait_time = addslashes($request->getParameter('wait_time'));
        $days = addslashes($request->getParameter('days'));
        $content = addslashes($request->getParameter('content'));
        $is_open = addslashes($request->getParameter('is_open'));
        $log = new LaiKeLogUtils('common/auction.log');
        if (is_numeric($low_pepole) && !strpos($low_pepole, '.')) {
            if ($low_pepole <= 0) {
                echo json_encode(array('msg'=>'最低人数不能小于0','err'=>1));
                die;
            }
        } else {
            echo json_encode(array('msg'=>'最低人数要为整数','err'=>1));
            exit;
        }

        if (is_numeric($wait_time) && !strpos($wait_time, '.')) {
            if ($wait_time <= 0) {
                echo json_encode(array('msg'=>'等待时间不能小于0','err'=>1));
                exit;
            }
        } else {
            echo json_encode(array('msg'=>'等待时间要为整数','err'=>1));
            exit;
        }

        if (is_numeric($days) && !strpos($days, '.')) {
            if ($days <= 0) {
                echo json_encode(array('msg'=>'保留天数不能小于0','err'=>1));
                exit;
            }
        } else {
            echo json_encode(array('msg'=>'保留天数要为整数','err'=>1));
            exit;
        }

        //查看是否有之前的竞拍规则

        $sql = "select id from lkt_auction_config where store_id = '$store_id'";
        $res = $db->select($sql);


        if ($res) {//存在竞拍配置则更新

            $id = $res[0]->id;
            $sql_0 = "update lkt_auction_config set low_pepole = '$low_pepole',wait_time = '$wait_time',days = '$days',content = '$content',is_open = '$is_open' where store_id = '$store_id' and id = '$id'";
            $res_0 = $db->update($sql_0);
        } else {//不存在竞拍配置则添加
            $sql_0 = "insert into lkt_auction_config (low_pepole,wait_time,days,content,store_id,is_open) values ('$low_pepole','$wait_time','$days','$content','$store_id','$is_open')";
            $res_0 = $db->insert($sql_0);
        }

        if ($res_0 < 0) {
            echo json_encode(array('msg'=>'设置竞拍规则失败','err'=>1));
            exit;
        } else {
            $log -> customerLog(__LINE__.':更新竞拍规则失败失败，sql为：'.$sql_0."\r\n");
            echo json_encode(array('suc'=>1,'msg'=>'设置成功'));
            exit;
        }
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}
