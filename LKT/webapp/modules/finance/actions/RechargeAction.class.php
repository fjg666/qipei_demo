<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class RechargeAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收参数
        $name = addslashes(trim($request->getParameter('name'))); // 用户名
        $mobile = addslashes(trim($request->getParameter('mobile'))); // 联系电话
        $startdate = $request->getParameter('startdate');//开始时间
        $enddate = $request -> getParameter('enddate');//结束时间
        $pageto = $request -> getParameter('pageto');// 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';// 每页显示多少条数据
        $page = $request -> getParameter('page');// 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        // 权限
        $button[0] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=Recharge_see');

		$condition = " c.store_id = '$store_id' and (a.type = 1 or a.type = 14) ";
        if($name){
            $name = htmlspecialchars($name);
            $condition .= " and c.user_name like '%$name%' ";
        }
        if($mobile){
            $condition .= " and c.mobile like '%$mobile%' ";
        }
        if($startdate){
            $condition .= " and a.add_date >= '$startdate' ";
        }
        if($enddate){
            $condition .= " and a.add_date <= '$enddate' ";
        }
        $sql = "select a.user_id,c.user_name,c.mobile,c.source,c.Register_data from lkt_record as a left join lkt_user as c on c.user_id = a.user_id  where $condition group by user_id order by c.Register_data desc";
        $r = $db->select($sql);

        $list = array();
        $total = 0;
        if($r){
            $total = count($r);
            // 页码调整
            if ($start > $total) {$page = 1;$start = 0;}

            if($pageto == 'whole') { // 导出全部

                $db->admin_record($store_id,$admin_name,' 导出全部充值管理列表 ',4);
                $sql = "select a.user_id,a.type,a.add_date,c.user_name,c.mobile,c.source from lkt_record as a left join lkt_user as c on a.user_id = c.user_id where c.store_id = '$store_id' and (a.type = 1 or a.type = 14)  group by user_id order by c.Register_data desc";
               
            }else if($pageto == 'inquiry'){//导出查询

                 $db->admin_record($store_id,$admin_name,' 导出充值管理列表全部查询数据 ',4);
                 $sql = "select a.user_id,a.type,a.add_date,c.user_name,c.mobile,c.source from lkt_record as a left join lkt_user as c on a.user_id = c.user_id where  $condition  group by user_id order by c.Register_data desc";

            }else if($pageto == 'This_page'){

                $db->admin_record($store_id,$admin_name,' 导出当前页充值管理列表 ',4);
                $sql = "select a.user_id,a.type,a.add_date,c.user_name,c.mobile,c.source from lkt_record as a left join lkt_user as c on a.user_id = c.user_id where  $condition  group by user_id order by c.Register_data desc limit $start,$pagesize";
            }else{  

                $sql = "select a.user_id,a.type,a.add_date,c.user_name,c.mobile,c.source from lkt_record as a left join lkt_user as c on a.user_id = c.user_id where $condition group by user_id order by c.Register_data desc limit $start,$pagesize";
              
            }
            $list = $db->select($sql);

            if($list){
                foreach ($list as $k => $v){
                    $user_id1 = $v->user_id;
                    $sql = "select money from lkt_record where store_id = '$store_id' and user_id = '$user_id1' and (type = 1 or type = 14)";
                    $r2 = $db->select($sql);
                    $money = 0;
                    if($r2){
                        foreach ($r2 as $ke => $va){
                            $money = $money + $va->money;
                        }
                    }
                    $v->r_money = $money;
                }
            }
        }

        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=finance&action=Recharge&name=".urlencode($name)."&mobile=".urlencode($mobile)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&pagesize=".urlencode($pagesize);

        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("name",$name);
        $request->setAttribute("mobile",$mobile);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("list",$list);
        $request->setAttribute('pageto',$pageto);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('pagesize', $pagesize);
        $request -> setAttribute('button', $button);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>