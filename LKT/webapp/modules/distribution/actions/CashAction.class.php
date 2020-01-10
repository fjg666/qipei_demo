<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class CashAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $button = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=distribution&action=Cash_del');

        $name = addslashes(trim($request->getParameter('name'))); // 分销商名称/手机号码
        $mobile = addslashes(trim($request->getParameter('mobile'))); // 持卡人姓名
        $source = intval(trim($request->getParameter('source'))); // 审核状态
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

        $condition = " a.store_id = '$store_id' and c.store_id = '$store_id' and a.is_mch = 0 ";

        if($name){
            $name = htmlspecialchars($name);
            $condition .= " and (a.name like '%$name%' or a.mobile like '%$name%') ";
        }
        if($mobile){
            $condition .= " and b.Cardholder like '%$mobile%' ";
        }
        if($startdate){
            $condition .= " and a.add_date >= '$startdate' ";
        }
        if($enddate){
            $condition .= " and a.add_date <= '$enddate' ";
        }
        if ($source) {
            $sourcee = $source-1;
            $condition .= " and a.status = '$sourcee' ";
        }

        $list = array();
        $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.branch,b.Bank_card_number,c.source from lkt_distribution_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition";
        $r = $db->select($sql);
        $total = 0;
        if($r){
            $total = count($r);

            if ($start > $total) {
                $page = 1;
                $start = 0;
            }

            if($pageto == 'whole') { // 导出全部

                $db->admin_record($store_id,$admin_name,' 导出全部提现待审核列表 ',4);
                $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.branch,b.Bank_card_number,c.source from lkt_distribution_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition order by a.add_date desc ";

            }else if($pageto == 'inquiry'){//导出查询

                $db->admin_record($store_id,$admin_name,' 导出提现待审核列表全部查询数据！ ',4);
                $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.branch,b.Bank_card_number,c.source from lkt_distribution_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition order by a.add_date desc";    
            }else if($pageto == 'This_page'){//导出当前页

                $db->admin_record($store_id,$admin_name,' 导出当前页提现待审核列表 ',4);
                $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.branch,b.Bank_card_number,c.source from lkt_distribution_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition order by a.add_date desc limit $start,$pagesize ";

            }else{
                $sql = "select a.id,a.user_id,a.name,a.add_date,a.money,a.s_charge,a.mobile,a.status,b.Cardholder,b.Bank_name,b.branch,b.Bank_card_number,c.source from lkt_distribution_withdraw as a left join lkt_user_bank_card as b on a.Bank_id = b.id right join lkt_user as c on a.user_id = c.user_id where $condition order by a.add_date desc limit $start,$pagesize ";
            }   

            $r1 = $db->select($sql);
            $list = $r1;
        }

        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=distribution&action=Cash&name=".urlencode($name)."&mobile=".urlencode($mobile)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&pagesize=".urlencode($pagesize)."&source=".urlencode($source);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("mobile",$mobile);
        $request->setAttribute("name",$name);
        $request->setAttribute("source",$source);
        $request->setAttribute("list",$list);
        $request->setAttribute('pageto',$pageto);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('pagesize', $pagesize);
        $request -> setAttribute('button', $button);
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