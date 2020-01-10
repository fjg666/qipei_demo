<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class SeeAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  17:50
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = addslashes(trim($request->getParameter('id'))); // 商品属性id
        $pid = addslashes(trim($request->getParameter('pid'))); // 商品id

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

        $sql0 = "select a.product_number,a.product_title,a.imgurl,a.status,a.mch_id,c.price,c.attribute,c.total_num,c.num,b.flowing_num,b.user_id,b.type,b.add_date from lkt_stock as b left join lkt_product_list as a on b.product_id = a.id left join lkt_configure as c on b.attribute_id = c.id where a.store_id = '$store_id' and a.recycle = 0 and b.product_id = '$pid' and b.attribute_id = '$id' order by b.add_date desc";
        $r0 = $db->select($sql0);
        $total = count($r0);

        $sql1 = "select a.product_number,a.product_title,a.imgurl,a.status,a.mch_id,c.price,c.attribute,c.total_num,c.num,b.flowing_num,b.user_id,b.type,b.add_date from lkt_stock as b left join lkt_product_list as a on b.product_id = a.id left join lkt_configure as c on b.attribute_id = c.id where a.store_id = '$store_id' and a.recycle = 0 and b.product_id = '$pid' and b.attribute_id = '$id' order by b.add_date desc limit $start,$pagesize";
        $r1 = $db->select($sql1);
        if($r1){
            foreach ($r1 as $k => $v){
                $mch_id = $v->mch_id;
                $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
                $attribute = unserialize($v->attribute);
                $specifications = '';
                foreach ($attribute as $ke => $va){
                    $specifications .= $ke .':'.$va.',';
                }
                $v->specifications = rtrim($specifications, ",");

                $sql0_0 = "select name from lkt_mch where store_id = '$store_id' and id = '$mch_id' and review_status = 1";
                $r0_0 = $db->select($sql0_0);
                if($r0_0){
                    $v->shop_name = $r0_0[0]->name;
                }else{
                    $v->shop_name = '';
                }
            }
        }
        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=stock&action=see&id=".urlencode($id)."&pid=".urlencode($pid)."&pagesize=".urlencode($pagesize);
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