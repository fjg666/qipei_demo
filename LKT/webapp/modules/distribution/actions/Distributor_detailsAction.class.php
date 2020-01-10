<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class Distributor_detailsAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = addslashes(trim($request->getParameter('id'))); // ID

        $sql = "select * from lkt_user_distribution where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id;// 用户ID
            $pid = $r[0]->pid;// 推荐人ID
            $level = $r[0]->level;//用户等级
            $lt = $r[0]->lt;
            $rt = $r[0]->rt;
            $upper_uplevel = $r[0]->uplevel; // 层级

            $sql002 = "select * from lkt_user_distribution where store_id = '$store_id' and lt >'$lt' and rt < '$rt' order by uplevel asc";
            $rr = $db->select($sql002);
            foreach ($rr as $k => $v){
                $user_id = $v->user_id;//用户id
                $v->uplevel = $v->uplevel - $upper_uplevel . '级';//层级
                $sql = "select user_name,headimgurl from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
                $r_1 = $db->select($sql);
                $v->user_name = $r_1[0]->user_name;// 用户名称
                $v->headimgurl = $r_1[0]->headimgurl;// 头像
                //查询  等级名称
                $sql001 ="select sets from lkt_distribution_grade where store_id = '$store_id' and id = '$level' ";
                $r001 = $db->select($sql001);
                $re001[]=unserialize($r001[0]->sets);
                $v->s_dengjiname = $re001[0]['s_dengjiname'];// 等级名称
            }
        }

        $request->setAttribute("re",$rr);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>