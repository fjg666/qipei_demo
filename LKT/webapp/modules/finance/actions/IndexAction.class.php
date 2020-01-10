<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        // 接收参数
        $name = addslashes(trim($request->getParameter('name'))); // 用户名
        $mobile = addslashes(trim($request->getParameter('mobile'))); // 联系电话
        $startdate = $request->getParameter('startdate');//开始时间
        $enddate = $request -> getParameter('enddate');//结束时间
        $pageto = $request -> getParameter('pageto');// 导出
        $page = $request -> getParameter('page');// 页码
        $pagesize = $request -> getParameter('pagesize');// 每页显示多少条数据
        $pagesize = $pagesize ? $pagesize:'10';
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        // 权限
        $JurisdictionAction = new JurisdictionAction();
        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=Index');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=List');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=Config');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=Del');

        $condition = " a.store_id = '$store_id' and c.store_id = '$store_id' and a.status = 0 and a.is_mch = 0 ";
        $condition1 = " a.store_id = '$store_id' and c.store_id = '$store_id' and a.status = 0 and a.is_mch = 0 ";

		if($name){
            $name = htmlspecialchars($name);
            $condition .= " and a.name like '%$name%' ";
		}
        if($mobile){
            $condition .= " and a.mobile like '%$mobile%' ";
        }
        if($startdate){
            $condition .= " and a.add_date >= '$startdate' ";
        }
        if($enddate){
            $condition .= " and a.add_date <= '$enddate' ";
        }

        $list = array();
        $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.Bank_card_number,c.source from lkt_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition1";
        $r = $db->select($sql);
        $total = 0;
        if($r){
            $total = count($r);
            // 页码调整
            if ($start > $total) {$page = 1;$start = 0;}

            if($pageto == 'whole') { // 导出全部

                $db->admin_record($store_id,$admin_name,' 导出全部提现待审核列表 ',4);
                $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.Bank_card_number,c.source from lkt_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition order by a.add_date desc ";

            }else if($pageto == 'inquiry'){//导出查询

                $db->admin_record($store_id,$admin_name,' 导出提现待审核列表全部查询数据！ ',4);
                $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.Bank_card_number,c.source from lkt_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition order by a.add_date desc";    
            }else if($pageto == 'This_page'){//导出当前页

                $db->admin_record($store_id,$admin_name,' 导出当前页提现待审核列表 ',4);
                $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.Bank_card_number,c.source from lkt_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition order by a.add_date desc limit $start,$pagesize ";

            }else{
                $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.Bank_card_number,c.source from lkt_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition order by a.add_date desc limit $start,$pagesize ";
            }   

            $r1 = $db->select($sql);
            $list = $r1;
        }
        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=finance&action=Index&name=".urlencode($name)."&mobile=".urlencode($mobile)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("name",$name);
        $request->setAttribute("mobile",$mobile);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("list",$list);
        $request->setAttribute('pageto',$pageto);
        $request -> setAttribute('pages_show', $pages_show);
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