<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员id
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=role&action=Add');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=role&action=See');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=role&action=Modify');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=role&action=Del');

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
        // 根据管理员id,查询管理员信息(是否是客户或商城管理员)
        $sql = "select * from lkt_admin where id = '$admin_id'";
        $r0 = $db->select($sql);
        $store_type = 0; // 允许查看该商城所有管理员
        if($r0[0]->type == 0 || $r0[0]->type == 1){ // 允许查看该商城所有管理员
            $store_type = 0; // 允许查看该商城所有管理员
        }else{
            $store_type = 1; // 不允许查看该商城所有管理员
        }

        // 查询商城角色信息
        $sql = "select * from lkt_role where store_id = '$store_id'";
        $r = $db->select($sql);
        $total = count($r);
        $pager = new ShowPager($total,$pagesize,$page);

        // 查询商城角色信息
        $sql = "select * from lkt_role where store_id = '$store_id' order by add_date desc limit $start,$pagesize";
        $rr = $db->select($sql);
        if($rr){
            foreach ($rr as $k1 => $v1) {
                $rew = Tools::menu_name($db,$v1->id);
                $v1->permission = rtrim($rew, ',');
            }
        }
        $url = "index.php?module=role&action=Index&pagesize=".urlencode($pagesize);;
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$rr);
        $request -> setAttribute('pages_show', $pages_show);
        $request->setAttribute("store_id",$store_id);
        $request -> setAttribute('store_type', $store_type);
        $request->setAttribute('button', $button);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>