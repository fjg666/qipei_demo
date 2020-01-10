<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once (MO_LIB_DIR . '/DBAction.class.php');
require_once (MO_LIB_DIR . '/ShowPager.class.php');
require_once (MO_LIB_DIR . '/Tools.class.php');

class JifenAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        // 接收参数
        $user_name = addslashes(trim($request->getParameter('user_name'))); // 用户名
        $mobile = addslashes(trim($request->getParameter('mobile'))); // 手机号码
        $startdate = $request->getParameter('startdate');//开始时间
        $enddate = $request->getParameter('enddate');//结束时间
        $pageto = $request->getParameter('pageto');// 导出
        $pagesize = $request->getParameter('pagesize');// 每页显示多少条数据
        $pagesize = $pagesize ? $pagesize:'10';
        $page = $request->getParameter('page');// 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        // 权限
        $button[0] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=Jifen_see');

        $condition = " store_id = '$store_id' ";
        if($user_name){
            $user_name = htmlspecialchars($user_name);

            $condition .= " and user_name like '%$user_name%' ";
        }
        if($mobile){
            $condition .= " and mobile like '%$mobile%' ";
        }

        if($startdate){
            $condition .= " and Register_data >= '$startdate' ";
        }
        if($enddate){
            $condition .= " and Register_data <= '$enddate' ";
        }

        $list = array();
        $sql = "select id from lkt_user where $condition";

        $r = $db->select($sql);
        $total = 0;

        if($r){
            $total = count($r);
            // 页码调整
            if ($start > $total) {$page = 1;$start = 0;}

            if($pageto == 'whole'){

                $db->admin_record($store_id,$admin_name,' 导出积分列表全部数据 ',4);
                $sql = "select user_id,user_name,mobile,source,score,Register_data from lkt_user where store_id = '$store_id' group by user_id order by Register_data desc";

            }else if($pageto == 'inquiry'){

                $db->admin_record($store_id,$admin_name,' 导出积分列表查询全部数据 ',4);
                $sql = "select user_id,user_name,mobile,source,score,Register_data from lkt_user where $condition group by user_id order by Register_data desc";

            }else if($pageto == 'This_page'){

                 $db->admin_record($store_id,$admin_name,' 导出积分列表查询当前页 ',4);
                 $sql = "select user_id,user_name,mobile,source,score,Register_data from lkt_user where $condition group by user_id order by Register_data desc limit $start,$pagesize ";

            }else{
                $sql = "select user_id,user_name,mobile,source,score,Register_data from lkt_user where $condition group by user_id order by Register_data desc limit $start,$pagesize ";
              
            }

            $list = $db->select($sql);
        }
        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=finance&action=Jifen&user_name=".urlencode($user_name)."&mobile=".urlencode($mobile)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$list);
        $request->setAttribute("mobile",$mobile);
        $request->setAttribute('pageto', $pageto);
        $request->setAttribute('button', $button);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("user_name",$user_name);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute('pages_show', $pages_show);

        return View::INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods() {
        return Request::NONE;
    }

}
?>