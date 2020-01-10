<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=sign&action=Config');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=sign&action=Record');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=sign&action=Del');

        $name = addslashes(trim($request->getParameter('name'))); //
        $source = addslashes(trim($request->getParameter('source'))); // 来源
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        $time = date("Y-m-d H:i:s"); // 当前时间
        $start_1 = date("Y-m-d 00:00:00"); // 今天开始时间
        $start_0 = date("Y-m-d 00:00:00",strtotime("-1 day",strtotime($start_1))); // 昨天开始时间

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        $condition = " b.store_id = '$store_id' and b.store_id = '$store_id' and a.type = 0 and a.recovery = 0";
        if($name != ''){
            $condition .= " and (b.user_name like '%$name%' or b.user_id = '$name' or b.mobile like '%$name%')";
        }
        if($source != '' || $source != 0){
            $condition .= " and b.source = '$source' ";
        }
        // 查询插件表
        $sql0 = "select a.*,b.user_name,b.mobile,b.source from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where $condition group by b.user_id ";
        $r0 = $db->select($sql0);
        $total = count($r0);

        $sql1 = "select max(a.sign_time) as sign_time1,a.*,b.user_name,b.mobile,b.source from lkt_sign_record as a left join lkt_user as b on a.user_id = b.user_id where $condition group by b.user_id order by sign_time1 desc limit $start,$pagesize";
        $r1 = $db->select($sql1);
        if($r1){
            $sql2 = "select * from lkt_sign_config where store_id = '$store_id' ";
            $r2 = $db->select($sql2);
            if($r2){
                $starttime = date("Ymd", strtotime($r2[0]->starttime)); // 开始时间
                $endtime = date("Ymd", strtotime($r2[0]->endtime)); // 结束时间
                $day = $endtime - $starttime; // 活动天数


                foreach ($r1 as $k => $v){
                    $user_id1 = $v->user_id;
                    $sql3 = "select sign_score from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id1' and type = 0 ";
                    $r3 = $db->select($sql3);
                    $score = 0;
                    if($r3){
                        foreach ($r3 as $ke => $va){
                            $score = $score + $va->sign_score;
                        }
                    }
                    $v->score = $score;
                    // 根据用户id, 查询昨天签到记录
                    $sql4 = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id1' and sign_time >= '$start_0' and sign_time < '$start_1' and type = 0 ";
                    $r4 = $db->select($sql4);
                    $num = 0;
                    if ($r4) { // 有数据,就循环查询连续签到几天
                        for ($i = 1; $i <= $day; $i++) {
                            $start = date("Y-m-d H:i:s", strtotime("-$i day",strtotime($start_0))); // 上一天重置时间
                            $end = date("Y-m-d H:i:s", strtotime("-$i day",strtotime($start_1))); // 当天重置时间

                            if(strtotime($start) >= strtotime($starttime) && strtotime($end) <= strtotime($endtime)){
                                $sql5 = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id1' and sign_time > '$start' and sign_time < '$end' and type = 0 ";
                                $r5 = $db->select($sql5);
                                if (empty($r5)) {
                                    $num = $i;
                                    break;
                                }
                            }else{
                                $num = $i;
                                break;
                            }
                        }
                    }
                    // 查询今天是否签到
                    $sql6 = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id1' and sign_time > '$start_1' and type = 0 ";
                    $r6 = $db->select($sql6);
                    if($r6){
                        $num = $num+1;
                    }else{
                        $num = $num;
                    }
                    $v->num = $num;
                }
            }
        }

        $pager = new ShowPager($total,$pagesize,$page);
        $url = "index.php?module=sign&action=Index&name=".urlencode($name)."&source=".urlencode($source)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $source_str = Tools::data_dictionary($db,'来源',$source);

        $request->setAttribute('button', $button);

        $request->setAttribute("name",$name);
        $request->setAttribute("source",$source_str);
        $request->setAttribute("list",$r1);
        $request -> setAttribute('pages_show', $pages_show);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>