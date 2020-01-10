<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class Withdraw_listAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $this->db = $db;
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=List');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Set');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Product');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Withdraw');
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Withdraw_list');

        $name = addslashes(trim($request->getParameter('name'))); // 用户名
        $mobile = addslashes(trim($request->getParameter('mobile'))); // 联系电话
        $startdate = $request->getParameter('startdate');//开始时间
        $enddate = $request -> getParameter('enddate');//结束时间

        $pageto = $request -> getParameter('pageto');
        // 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $condition1 = " w.store_id = '$store_id' and m.store_id = '$store_id' and m.review_status = 1 and w.status != 0 and w.is_mch = 1 ";
        $condition = " w.store_id = '$store_id' and m.store_id = '$store_id' and m.review_status = 1 and w.status != 0 and w.is_mch = 1 ";

        if($name){
            $name = htmlspecialchars($name);
            $condition .= " and (m.id = '$name' OR m.name like '%$name%')";
        }
        if($mobile){
            $condition .= " and w.mobile like '%$mobile%' ";
        }
        if($startdate){
            $condition .= " and w.add_date >= '$startdate' ";
        }
        if($enddate){
            $condition .= " and w.add_date <= '$enddate' ";
        }

        $list = array();
        $sql = "select w.id,w.user_id,w.name,w.add_date,w.money,w.s_charge,w.mobile,w.status,w.refuse,b.Cardholder,b.Bank_name,b.Bank_card_number,m.id as mch_id,m.name as mch_name,m.logo from lkt_withdraw as w left join lkt_user_bank_card as b on w.Bank_id = b.id left join lkt_mch as m on m.user_id = w.user_id where $condition";
        $r = $db->select($sql);
        $total = count($r);

        if($r){
            if($pageto == 'whole') { // 导出全部
                $db->admin_record($store_id,$admin_name,' 导出店主全部提现记录列表 ',4);
                $sql = "select w.id,w.user_id,w.name,w.add_date,w.money,w.s_charge,w.mobile,w.status,w.refuse,b.Cardholder,b.Bank_name,b.Bank_card_number,m.id as mch_id,m.name as mch_name,m.logo from lkt_withdraw as w left join lkt_user_bank_card as b on w.Bank_id = b.id left join lkt_mch as m on m.user_id = w.user_id where $condition1 order by w.add_date desc ";
            }else if($pageto == 'inquiry'){//导出查询
                $db->admin_record($store_id,$admin_name,' 导出店主提现记录列表全部查询数据！ ',4);
                $sql = "select w.id,w.user_id,w.name,w.add_date,w.money,w.s_charge,w.mobile,w.status,w.refuse,b.Cardholder,b.Bank_name,b.Bank_card_number,m.id as mch_id,m.name as mch_name,m.logo from lkt_withdraw as w left join lkt_user_bank_card as b on w.Bank_id = b.id left join lkt_mch as m on m.user_id = w.user_id where $condition order by w.add_date desc ";
            }else if($pageto == 'This_page'){//导出当前页
                $db->admin_record($store_id,$admin_name,' 导出店主当前页提现记录列表 ',4);
                $sql = "select w.id,w.user_id,w.name,w.add_date,w.money,w.s_charge,w.mobile,w.status,w.refuse,b.Cardholder,b.Bank_name,b.Bank_card_number,m.id as mch_id,m.name as mch_name,m.logo from lkt_withdraw as w left join lkt_user_bank_card as b on w.Bank_id = b.id left join lkt_mch as m on m.user_id = w.user_id where $condition order by w.add_date desc limit $start,$pagesize ";
            }else{
                $sql = "select w.id,w.user_id,w.name,w.add_date,w.money,w.s_charge,w.mobile,w.status,b.Cardholder,b.Bank_name,b.Bank_card_number,m.id as mch_id,m.name as mch_name,m.logo from lkt_withdraw as w left join lkt_user_bank_card as b on w.Bank_id = b.id left join lkt_mch as m on m.user_id = w.user_id where $condition order by w.add_date desc limit $start,$pagesize ";
            }
            $r1 = $db->select($sql);
            if($r1){
                foreach ($r1 as $k => $v){
                    $v->logo = ServerPath::getimgpath($v->logo,$store_id);
                }
            }
            $list = $r1;
        }
        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=mch&action=Withdraw_list&name=".urlencode($name)."&mobile=".urlencode($mobile)."&startdate=".urlencode($startdate)."&enddate=".urlencode($enddate)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute('button', $button);

        $request->setAttribute("name",$name);
        $request->setAttribute("mobile",$mobile);
        $request->setAttribute("startdate",$startdate);
        $request->setAttribute("enddate",$enddate);
        $request->setAttribute("list",$list);
        $request->setAttribute('pageto',$pageto);
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