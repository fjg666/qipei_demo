<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class XiaofeijinAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        // 接收参数
        $group_end_time = $request -> getParameter('group_end_time');   //结束时间
        $name = addslashes(trim($request->getParameter('name')));       // 用户名
        $starttime = $request->getParameter('starttime');               //开始时间
        $type = $request->getParameter('otype');                        // 类型
        $pageto = $request->getParameter('pageto');                     // 导出
        $pagesize = $request->getParameter('pagesize');                 // 每页显示多少条数据
        $pagesize = $pagesize ? $pagesize:'10';
        $page = $request->getParameter('page');                         // 页码
        if($page){
            $start = ($page-1)*10;
        }else{
            $start = 0;
        }

        $condition = 'a.user_id = b.user_id and a.type !=1 and a.type !=2 and a.type !=3 and a.type !=8 and a.type !=9';
        if($name){
            $condition .= " and a.user_id = '$name' ";
        }
        if($type && $type!='all'){
            $condition .= " and a.type = '$type' ";
        }
        if($starttime){
            $condition .= " and a.add_date >= '$starttime' ";
        }
        if($group_end_time){
            $condition .= " and a.add_date <= '$group_end_time' ";
        }

        $sql005 = "select a.*,b.user_name,b.mobile from lkt_distribution_record as a ,lkt_user as b where $condition order by add_date desc";
        $r005 = $db->select($sql005);
        $total = count($r005);
        // 页码调整
        if ($start > $total) {$page = 1;$start = 0;}
        $pager = new ShowPager($total,$pagesize,$page);
        $offset = $pager->offset;

        if($pageto == 'whole') { // 导出全部

            $db->admin_record($store_id,$admin_name,' 导出全部消费金列表 ',4);
            $sql = "select a.*,b.user_name,b.mobile from lkt_distribution_record as a ,lkt_user as b where $condition order by add_date";

        }else if($pageto == 'inquiry'){//导出查询

            $db->admin_record($store_id,$admin_name,' 导出消费金列表全部查询数据！ ',4);
            $sql = "select a.*,b.user_name,b.mobile from lkt_distribution_record as a ,lkt_user as b where $condition order by add_date desc ";
        }else if($pageto == 'This_page'){//导出当前页

            $db->admin_record($store_id,$admin_name,' 导出当前页消费金列表 ',4);
            $sql = "select a.*,b.user_name,b.mobile from lkt_distribution_record as a ,lkt_user as b where $condition order by add_date desc limit $start,$pagesize";

        }else{
            $sql = "select a.*,b.user_name,b.mobile from lkt_distribution_record as a ,lkt_user as b where $condition order by add_date desc limit $start,$pagesize";
        }
        $r = $db->select($sql);
        if(!empty($r)){
            foreach ($r as $key => $value) {
                $user_id = $value->user_id;
                $sql021 = "select sets from lkt_user_distribution as a ,lkt_distribution_grade as b where a.level = b.id  and user_id = '$user_id' ";
                $r021 = $db->select($sql021);
                if(!empty($r021)){
                    $re01=unserialize($r021[0]->sets);
                    $value->typename = $re01['s_dengjiname'];
                }else{
                    $value->typename = '';
                }
                $from_id = $value->from_id;
                $sql001 = "select user_name from lkt_user where user_id = '$from_id'";
                $r001 = $db->select($sql001);
                if(!empty($r001)){
                     $r[$key]->name = $r001[0]->user_name;
                 }else{
                     $r[$key]->name = '';
                 }
            }
        }

        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$r);
        $request->setAttribute("name",$name);
        $request->setAttribute('pageto',$pageto);
        $request->setAttribute("starttime",$starttime);
        $request -> setAttribute('pages_show', $pages_show);
        $request->setAttribute("group_end_time",$group_end_time);
        
        return View :: INPUT;
    }
    
    public function execute() {

    }


    public function getRequestMethods(){
         return Request :: POST;
    }

}

?>