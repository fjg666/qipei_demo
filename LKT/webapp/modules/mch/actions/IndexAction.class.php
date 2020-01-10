<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

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
        $button[5] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=See');
        $button[6] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Modify');
        $button[7] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=mch&action=Del');

        $is_open = trim($request->getParameter('is_open'));
        $name = trim($request->getParameter('name'));

        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        $time = date("Y-m-d H:i:s");
        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $condition = " m.store_id = '$store_id' and u.store_id = '$store_id' and m.review_status = 1 ";
        if($is_open != ''){
            $condition .= " and m.is_open = '$is_open'";
        }
        if(!empty($name)){
            $condition .= " and (m.user_id = '$name' OR m.name like '%$name%')";
        }

        $sql0 = "select m.*,u.user_name,u.headimgurl,u.source from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where $condition order by m.add_time desc";
        $r0 = $db -> select($sql0);
        $total = count($r0);

        $sql1 = "select m.*,u.user_name,u.headimgurl,u.source from lkt_mch as m left join lkt_user as u on m.user_id = u.user_id where $condition order by m.add_time desc limit $start,$pagesize";
        $r1 = $db -> select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $shop_id = $v->id;
                $user_id = $v->user_id;
                $v->logo = ServerPath::getimgpath($v->logo,$store_id);

                $sql2 = "select last_time from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
                $r2 = $db->select($sql2);
                if($r2){
                    $last_time = date("Y-m-d H:i:s",strtotime("+60 day",strtotime($r2[0]->last_time)));
                    if($time >= $last_time){
                        $v->status = true;
                    }else{
                        $v->status = false;
                    }
                }
            }
        }

        $pager = new ShowPager($total,$pagesize,$page);
        $url = "index.php?module=mch&action=Index&is_open=".urlencode($is_open)."&name=".urlencode($name)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute('button', $button);

        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute('list', $r1);
        $request->setAttribute('is_open', $is_open);
        $request->setAttribute('name', $name);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>