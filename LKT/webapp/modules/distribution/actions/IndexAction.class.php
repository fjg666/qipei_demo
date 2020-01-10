<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class IndexAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $level = trim($request->getParameter('level')); // 分销商等级
        $user_name = trim($request->getParameter('user_name')); // 分销商名称/手机号码
        $r_name = trim($request->getParameter('r_name')); // 用户名/手机
        $p_name = trim($request->getParameter('p_name')); // 推荐人
        $startdate = trim($request->getParameter('startdate')); // 开始时间
        $enddate = trim($request->getParameter('enddate')); // 结束时间
        $pageto = $request->getParameter('pageto');// 导出
        $pagesize = $request->getParameter('pagesize');// 每页显示多少条数据
        $page = $request->getParameter('page');// 页码

        // 查询分销设置 没有则自动添加
        $sql = "select * from lkt_distribution_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        if (!$r_1) {
            $sets = 'a:27:{s:8:"c_cengji";s:1:"1";s:9:"c_uplevel";s:1:"1";s:8:"c_neigou";s:1:"1";s:5:"c_pay";s:1:"2";s:10:"c_yjjisuan";s:1:"0";s:10:"s_tiaojian";N;s:9:"s_shengji";N;s:8:"s_ziliao";N;s:8:"s_shenhe";N;s:8:"s_fukuan";N;s:7:"w_jibie";s:12:"默认级别";s:9:"w_fenname";N;s:9:"w_dingdan";N;s:10:"w_zhongxin";N;s:6:"w_kehu";N;s:9:"w_tuandui";N;s:8:"w_dengji";N;s:12:"partner_burn";N;s:9:"cash_type";N;s:9:"cash_bank";N;s:8:"cash_min";s:0:"";s:8:"cash_max";s:0:"";s:11:"cash_charge";s:0:"";s:3:"one";a:2:{i:0;i:0;i:1;i:0;}s:4:"team";a:2:{i:0;i:0;i:1;i:0;}s:6:"re_mch";i:0;s:7:"content";s:0:"";}';
            $db->insert("insert into `lkt_distribution_config` (`store_id`, `sets`) VALUES ('$store_id', '$sets')");
        }
        // 查询分销设置 没有则自动添加 end

        $con = " b.store_id = '$store_id' ";
        if (!empty($level)) {
            $con .= " and lud.level = '$level' ";
        }
        if ($user_name != '') {
            $con .= " and (b.user_name like '%$user_name%' or b.mobile like '%$user_name%') ";
        }
        if (!empty($r_name)) {
            $con .= " and a.user_name like '%$r_name%' ";
        }
        if ($p_name != '') {
            $con .= " and lud.pid like '%$p_name%' ";
        }
        if (!empty($startdate)) {
            $con .= " and lud.add_date > '$startdate' ";
        }
        if (!empty($enddate)) {
            $con .= " and lud.add_date < '$enddate' ";
        }


        if($pageto == 'whole') { // 导出全部

            $db->admin_record($store_id,$admin_name,' 导出全部充值管理列表 ',4);
            $sql = "select lud.*,a.user_name,a.headimgurl as hdimg,b.user_name as r_name ,b.headimgurl,b.mobile,b.Register_data from lkt_user_distribution as lud left join lkt_user as a on lud.pid=a.user_id and lud.store_id=a.store_id left join lkt_user as b on lud.user_id=b.user_id and lud.store_id=b.store_id where b.store_id = '$store_id' and lud.level>0 ORDER BY add_date desc";
           
        }else if($pageto == 'inquiry'){//导出查询

             $db->admin_record($store_id,$admin_name,' 导出充值管理列表全部查询数据 ',4);
             $sql = "select lud.*,a.user_name,a.headimgurl as hdimg,b.user_name as r_name ,b.headimgurl,b.mobile,b.Register_data from lkt_user_distribution as lud left join lkt_user as a on lud.pid=a.user_id and lud.store_id=a.store_id left join lkt_user as b on lud.user_id=b.user_id and lud.store_id=b.store_id where $con and lud.level>0 ORDER BY add_date desc";

        }else if($pageto == 'This_page'){//导出当前页面

            $db->admin_record($store_id,$admin_name,' 导出当前页充值管理列表 ',4);
            $sql = "select lud.*,a.user_name,a.headimgurl as hdimg,b.user_name as r_name ,b.headimgurl,b.mobile,b.Register_data from lkt_user_distribution as lud left join lkt_user as a on lud.pid=a.user_id and lud.store_id=a.store_id left join lkt_user as b on lud.user_id=b.user_id and lud.store_id=b.store_id where $con and lud.level>0 ORDER BY add_date desc";
        }else{  

            $sql = "select lud.*,a.user_name,a.headimgurl as hdimg,b.user_name as r_name ,b.headimgurl,b.mobile,b.Register_data from lkt_user_distribution as lud left join lkt_user as a on lud.pid=a.user_id and lud.store_id=a.store_id left join lkt_user as b on lud.user_id=b.user_id and lud.store_id=b.store_id where $con and lud.level>0 ORDER BY add_date desc";

        }

        // 拼接链接
        $cons = '';
        $pages_show = '';
        foreach ($_GET as $key => $value001) {
            $cons .= "&$key=$value001";
        }
        $total = $db->selectrow($sql);

        $pagesize = $pagesize ? $pagesize : 10;
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }
        if ($start > $total) {
            $page = 1;
            $start = 0;
        }

        $pager = new ShowPager($total, $pagesize, $page);
        $url = 'index.php?module=distribution' . $cons;
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        if($pageto == 'This_page' || empty($pageto)){
            $sql .= " limit $start,$pagesize ";
        }
        $list = $db->select($sql);
        
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $id = $value->user_id;
                $level = $value->level;// 等级ID
                $lt = $value->lt;
                $rt = $value->rt;
                $uplevel = $value->uplevel;// 层级
                
                // 到账佣金
                $sql33 = "select sum(a.money) as dkyj from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.type=1 and a.user_id='$id' and a.status=1 and b.status in (1,2,3,5,7)";
                $dkyj = $db->select($sql33);
                if ($dkyj[0]->dkyj) {
                    $list[$key]->dkyj = $dkyj[0]->dkyj;
                } else {
                    $list[$key]->dkyj = 0;
                }

                // 预计佣金
                $sql44 = "select sum(a.money) as yjyj from lkt_distribution_record a left join lkt_order b on a.sNo=b.sNo where a.store_id='$store_id' and a.type=1 and a.status=0 and a.user_id='$id' and b.status in (1,2,3,5,7)";
                
                $yjyj = $db->select($sql44);
                if ($yjyj[0]->yjyj) {
                    $list[$key]->yjyj = $yjyj[0]->yjyj;
                } else {
                    $list[$key]->yjyj = 0;
                }

                // 已提现佣金
                $sql44 = "select sum(money) as txyj from lkt_distribution_withdraw where store_id = '$store_id' and user_id = '$id' and status in (0,1)";
                $txyj = $db->select($sql44);
                if ($txyj[0]->txyj) {
                    $list[$key]->txyj = $txyj[0]->txyj;
                } else {
                    $list[$key]->txyj = 0;
                }

                //查询 等级名称
                $sql001 = "select sets from lkt_distribution_grade where store_id = '$store_id' and id = '$level' ";
                $r001 = $db->select($sql001);
                if(!empty($r001)){
                    $re001 = unserialize($r001[0]->sets);
                    $list[$key]->s_dengjiname = $re001['s_dengjiname'];
                }

                //清除缓存
                unset($re001);
            }

        } else {
            $list = [];
        }

        // 所有分销商等级
        $sql02 = "select id,sets from lkt_distribution_grade where store_id = '$store_id'";
        $r02 = $db->select($sql02);
        $distributors = [];
        foreach ($r02 as $k => $v) {
            $sets = unserialize($v->sets);
            $name = $sets['s_dengjiname'];
            $distributors[$k] = (object)array('id' => $v->id, 'name' => $name);
        }

        $request->setAttribute("pages_show", $pages_show);
        $request->setAttribute("level", $level);
        $request->setAttribute("distributors", $distributors);
        $request->setAttribute("user_name", $user_name);
        $request->setAttribute("r_name", $r_name);
        $request->setAttribute("p_name", $p_name);
        $request->setAttribute("startdate", $startdate);
        $request->setAttribute("enddate", $enddate);
        $request->setAttribute('pageto', $pageto);
        $request->setAttribute("list", $list);
        return View :: INPUT;
    }

    public function execute()
    {

    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }

}

?>