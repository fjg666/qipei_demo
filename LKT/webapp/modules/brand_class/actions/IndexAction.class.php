<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $brand_name = addslashes(trim($request->getParameter('brand_name'))); // 分类名称


        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=brand_class&action=Add');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=brand_class&action=Modify');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=brand_class&action=Del');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=brand_class&action=Status');

        // 导出
        $pageto = $request->getParameter('pageto');

        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:10;
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        $condition = " store_id = '$store_id' and recycle = 0 ";
        $condition1 = " store_id = '$store_id' and recycle = 0 ";
        if($brand_name != ''){
            $condition .=  " and brand_name = '$brand_name' ";
        }
        $sql = "select * from lkt_brand_class where $condition";
        $r_pager = $db->select($sql);
        if($r_pager){
            $total = count($r_pager);
        }else{
            $total = 0;
        }
        $pager = new ShowPager($total,$pagesize,$page);
        // 查询新闻分类表，根据sort顺序排列
        $sql1 = "select * from lkt_brand_class as a where ";
        if($pageto == 'This_page'){ // 导出本页
            $sql1 .= "$condition order by sort desc limit $start,$pagesize ";
        }else if($pageto == 'whole'){ // 导出全部
            $sql1 .= "$condition1 order by sort desc ";
        }else if($pageto == 'inquiry'){ // 导出查询
            $sql1 .= "$condition order by sort desc ";
        }else{
            $sql1 .= "$condition order by sort desc limit $start,$pagesize ";
        }
        $r = $db->select($sql1);
        if(!empty($r)){
            foreach ($r as $k => $v) {
                if($v->brand_pic != ''){
                    $v -> brand_pic = ServerPath::getimgpath($v->brand_pic,$store_id);
                }
                $categories = $v->categories; // 所属分类
                if($categories == '' || $categories == 'NULL'){
                    $v->class_name = '';
                }else{
                    $categories = trim($categories,',');
                    $res = explode(',',$categories);
                    $res1 = array();
                    $class_list = array();
                    foreach ($res as $k1 => $v1){
                        $sql0 = "select pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 and cid = '$v1'";
                        $r0 = $db->select($sql0);
                        if($r0){
                            $class_list[] = $r0[0]->pname ;
                            $res1[] = $v1;
                        }
                    }
                    $class_name = implode(',',$class_list);
                    $v->class_name = $class_name;
                }

                $r[$k] = $v;
            }
        }
        $url = "index.php?module=brand_class&action=Index&pagesize=".urlencode($pagesize)."&brand_name=".urlencode($brand_name);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$r);
        $request -> setAttribute('pages_show', $pages_show);
        $request->setAttribute('button', $button);
        $request->setAttribute('pageto', $pageto);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>