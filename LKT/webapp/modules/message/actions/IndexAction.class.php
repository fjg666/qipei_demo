<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  17:50
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员id
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=message&action=List');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=message&action=Config');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=message&action=Add');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=message&action=Modify');
        $button[4] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=message&action=Del');

        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';// 每页显示多少条数据
        $page = $request -> getParameter('page');// 页码

        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
       
        $sql = "select * from lkt_message_list where store_id = '$store_id'";
        $r = $db->select($sql);
        $total = count($r);

        $sql = "select a.*,b.name,b.content as content1 from lkt_message_list as a left join lkt_message as b on a.Template_id = b.id where a.store_id = '$store_id' order by a.add_time desc limit $start,$pagesize";
        $rr = $db->select($sql);
        if($rr){
            foreach($rr as $k => $v){
                $content1 = unserialize($v->content);
                $content2 = $v->content1;
                if($v->type == 0){
                    $v->content = $content2;
                }else if($v->type == 1){
                    foreach ($content1 as $ke => $va){
                        $content2 = str_replace('${'.$ke.'}', $va, $content2);
                    }
                    $v->content = $content2;
                }
            }
        }
        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=message&action=Index&pagesize=".urlencode($pagesize);;
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$rr);
        $request -> setAttribute('pages_show', $pages_show);
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