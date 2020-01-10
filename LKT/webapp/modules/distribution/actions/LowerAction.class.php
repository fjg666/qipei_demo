<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class LowerAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $pid = trim($request->getParameter('id')); // 推荐人
        $pageto = $request->getParameter('pageto');// 导出
        $pagesize = $request->getParameter('pagesize');// 每页显示多少条数据
        $page = $request->getParameter('page');// 页码
        
        $con = " b.store_id = '$store_id' ";

        $sql = "select * from lkt_distribution_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);
        if($r_1){
            $re01 = unserialize($r_1[0]->sets);
        }

        if ($pid != '') {
            $con .= " and lud.pid='$pid' ";
        }

        $sql = "select lud.*,a.user_name,a.headimgurl as hdimg,b.user_name as r_name ,b.headimgurl,b.mobile,b.Register_data from lkt_user_distribution as lud left join lkt_user as a on lud.pid=a.user_id and lud.store_id=a.store_id left join lkt_user as b on lud.user_id=b.user_id and lud.store_id=b.store_id where $con and lud.level>0 ORDER BY add_date desc";

        $cons = '';
        $pages_show = '';
        foreach ($_GET as $key => $value) {
            $cons .= "&$key=$value";
        }

        $total = $db->selectrow($sql);
        // 导出
        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : 10;
        // 页码 $pagesize ? $pagesize:10
        $page = $request->getParameter('page');
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }
        if($pageto != 'all'){
            $sql .= " limit $start,$pagesize ";
        }
        $list = $db->select($sql);
        
        $pager = new ShowPager($total, $pagesize, $page);
        $url = 'index.php?module=distribution' . $cons;
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');
        
        if (!empty($list)) {
            foreach ($list as $key => $value) {
                $id = $value->user_id;
                $level = $value->level;//等级ID
                $lt = $value->lt;
                $rt = $value->rt;
                $uplevel = $value->uplevel;

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

                // 查询直推人数
                $sql = "select id from lkt_user_distribution where store_id='$store_id' and pid='$id'";
                $zhitui = $db->selectrow($sql);
                $list[$key]->zhitui = $zhitui;

                // 查询团队人数（不包括自己）
                $sql = "select id from lkt_user_distribution where store_id='$store_id' and lt>'$lt' and rt<'$rt'";
                $cont = $db->selectrow($sql);
                $list[$key]->cont = $cont;

                //查询 等级名称
                $sql001 = "select sets from lkt_distribution_grade where store_id = '$store_id' and id = '$level' ";
                $r001 = $db->select($sql001);
                if(!empty($r001)){
                    $re001 = unserialize($r001[0]->sets);
                    $list[$key]->s_dengjiname = $re001['s_dengjiname'];
                }

                unset($coun);
                $sql001 = "select sets from lkt_distribution_grade where store_id = '$store_id' and id = '$level' ";//查询  等级名称
                $r001 = $db->select($sql001);

                if(!empty($r001)){
                    $re001[] = unserialize($r001[0]->sets);
                    $list[$key]->s_dengjiname = $re001[0]['s_dengjiname'];
                }           
                unset($re001);//清除缓存
            }

        } else {
            $list = [];
        }

        $request->setAttribute("pages_show", $pages_show);
        $request->setAttribute('pageto', $pageto);
        $request->setAttribute("list", $list);
        $request->setAttribute("id", $pid);
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