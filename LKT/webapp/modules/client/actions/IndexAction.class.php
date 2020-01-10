<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

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

        // 查询客户端信息
        $sql0 = "select * from lkt_role where status = 1";
        $r0 = $db->select($sql0);
        $total = count($r0);
        $pager = new ShowPager($total,$pagesize,$page);

        // 查询客户端信息
        $sql1 = "select * from lkt_role where status = 1 order by add_date desc limit $start,$pagesize";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k1 => $v1) {
                $id = $v1->id;
                $sql2 = "select b.name from lkt_admin as a left join lkt_customer as b on a.store_id = b.id where a.type = 1 and a.role = '$id' and a.recycle = 0";
                $r2 = $db->select($sql2);
                if($r2){
                    foreach ($r2 as $k2 => $v2){
                        $v1->name_list[] = $v2->name;
                    }
                }
            }
        }
        $url = "index.php?module=client&action=Index&pagesize=".urlencode($pagesize);;
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$r1);
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