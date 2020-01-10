<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $con = '';
        foreach ($_GET as $key => $value001) {
            $con .= "&$key=$value001";
        }
        // 查询插件表
        $sql = "select * from lkt_plug_ins where id <> 6";  //去除红包插件，如有需要去除条件
        $total = $db->selectrow($sql);
        // 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:10;
        // 页码
        $page = $request -> getParameter('page');
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        $sql .= " order by add_time desc limit $start,$pagesize ";
        $r = $db->select($sql);
        $pager = new ShowPager($total,$pagesize,$page);
        $url = 'index.php?module=plug_ins'.$con;
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("pages_show",$pages_show);
        $request->setAttribute("list",$r);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>