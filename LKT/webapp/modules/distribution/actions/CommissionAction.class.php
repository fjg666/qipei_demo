<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class CommissionAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sNo = addslashes(trim($request->getParameter('sNo'))); // 订单
        $phone = addslashes(trim($request->getParameter('phone'))); // 手机号
        $name = addslashes(trim($request->getParameter('name'))); // 用户名
        $startdate = $request -> getParameter("startdate");// 开始时间
        $enddate = $request -> getParameter("enddate");// 结束时间
        $pageto = $request -> getParameter('pageto');// 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';// 每页显示多少条数据
        $page = $request -> getParameter('page');// 页码
        if($page){
            $start = ($page-1)*10;
        }else{
            $start = 0;
        }

		$condition = " a.store_id = '$store_id' ";
		if($sNo){
			$condition .= " and a.sNo = '$sNo' ";
		}
        if($phone){
            $condition .= " and c.user_id = '$phone' ";
        }
        if($name || $name =='0'){ // 分销员
            $condition .= " and (c.user_name like '%$name%' or c.mobile ='$name')";
        }
        if ($startdate != '') {
            $condition .= " and a.add_date >= '$startdate 00:00:00' ";
        }
        if ($enddate != '') {
            $condition .= " and a.add_date <= '$enddate 23:59:59' ";
        }
        $sql = "select a.id,a.user_id as gm_id,a.from_id as fx_id,a.status,a.type,a.money,a.sNo,a.event,a.level,a.type,a.add_date,c.user_name as fx_name,c.mobile from lkt_distribution_record as a left join lkt_user as c on a.user_id = c.user_id where $condition and a.type in(1,3,8) order by a.add_date desc ";
        $r = $db->select($sql);
        $total = count($r); // 总数
        $pager = new ShowPager($total,$pagesize,$page);

        if ($start > $total) {
            $page = 1;
            $start = 0;
        }

        if($pageto == 'whole') { // 导出全部

            $db->admin_record($store_id,$admin_name,' 导出全部佣金明细 ',4);
            $sql = "select a.id,a.user_id as gm_id,a.from_id as fx_id,a.status,a.type,a.money,a.sNo,a.event,a.level,a.type,a.add_date,c.user_name as gm_name,c.mobile from lkt_distribution_record as a left join lkt_user as c on a.user_id = c.user_id where a.store_id = '$store_id' and a.type in(1,3,8) order by a.add_date desc";
           
        }else if($pageto == 'inquiry'){//导出查询

             $db->admin_record($store_id,$admin_name,' 导出佣金明细全部查询数据 ',4);
             $sql = "select a.id,a.user_id as gm_id,a.from_id as fx_id,a.status,a.type,a.money,a.sNo,a.event,a.level,a.type,a.add_date,c.user_name as gm_name,c.mobile from lkt_distribution_record as a left join lkt_user as c on a.user_id = c.user_id where $condition and a.type in(1,3,8) order by a.add_date desc";

        }else if($pageto == 'This_page'){//导出当前页面

            $db->admin_record($store_id,$admin_name,' 导出当前页佣金明细 ',4);
            $sql = "select a.id,a.user_id as gm_id,a.from_id as fx_id,a.status,a.type,a.money,a.sNo,a.event,a.level,a.type,a.add_date,c.user_name as gm_name,c.mobile from lkt_distribution_record as a left join lkt_user as c on a.user_id = c.user_id where $condition and a.type in(1,3,8) order by a.add_date desc limit $start,$pagesize";
        }else{  

            $sql = "select a.id,a.user_id as gm_id,a.from_id as fx_id,a.status,a.type,a.money,a.sNo,a.event,a.level,a.type,a.add_date,c.user_name as gm_name,c.mobile from lkt_distribution_record as a left join lkt_user as c on a.user_id = c.user_id where $condition and a.type in(1,3,8) order by a.add_date desc limit $start,$pagesize";

        }
        $list = $db->select($sql);

        $z_price = 0;
        foreach ($list as $k => $v){
            $user_id = $v->gm_id; // 购买员id
            $from_id = $v->fx_id; // 分销员id

            $level = $v->level;
            $list[$k]->level = $level . '级';
            $z_price += $v->money;
            $sql = "select z_price from lkt_order where store_id = '$store_id' and sNo = '" . $v->sNo."'";
            $r = $db->select($sql);
            if($r){
                $list[$k]->order_price = $r[0]->z_price;
            }else{
                $list[$k]->order_price = '';
            }

            $sql = "select user_id,user_name from lkt_user where store_id = '$store_id' and user_id = '$from_id'";
            $r_1 = $db->select($sql);
            if($from_id == '0' || !$r_1){
                $list[$k]->fx_name = '总店'; // 分销员
            }else{
                $list[$k]->fx_name = $r_1[0]->user_name; // 分销员
            }

            $sql = "select b.sets from lkt_user_distribution as a left join lkt_distribution_grade as b on a.level = b.id where a.store_id = '$store_id' and a.user_id = '$user_id' ";
            $r_2 = $db->select($sql);
            if(!empty($r_2)){
                $r_2_1=unserialize($r_2[0]->sets);
                $v->typename = $r_2_1['s_dengjiname'];
            }else{
                $v->typename = '';
            }
        }

        $url = "index.php?module=distribution&action=Commission&sNo=".urlencode($sNo)."&phone=".urlencode($phone)."&name=".urlencode($name)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("sNo",$sNo);
        $request->setAttribute("phone",$phone);
        $request->setAttribute("name",$name);
        $request->setAttribute("list",$list);
        $request->setAttribute('pageto',$pageto);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('pagesize', $pagesize);
        $request -> setAttribute('z_price', $z_price);
        $request -> setAttribute('startdate', $startdate);
        $request -> setAttribute('enddate', $enddate);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}

?>