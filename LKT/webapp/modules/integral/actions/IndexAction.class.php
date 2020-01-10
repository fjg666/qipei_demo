<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class IndexAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg'); // 图片上传路径
        $serverURL = $this->getContext()->getStorage()->read('serverURL');
        
        $proname = trim($request->getParameter('proname')); // 分类名称
        $bstatus = $request->getParameter('bstatus'); // 标题
        
        $pageto = $request->getParameter('pageto');
        // 导出
        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : 10;
        // 每页显示多少条数据
        $page = $request->getParameter('page');

        // 查询积分商城设置是否设置
        $sql = "select * from lkt_integral_config where store_id='$store_id'";
        $r = $db->select($sql);
        if (empty($r)) {
            $db->insert("INSERT INTO `lkt_integral_config` (`store_id`,`status`) VALUES ('$store_id','0')");
        }

        // 页码
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        $condition = " a.store_id = '$store_id' and b.is_delete=0 ";
        if ($proname != '') {
            $condition .= " and a.product_title like '%$proname%' ";
        }

        $sql = "select b.id from lkt_integral_goods as b left join lkt_product_list as a on b.goods_id=a.id left join lkt_configure as c on b.attr_id=c.id where $condition order by b.sort desc";
        $total = $db->selectrow($sql);
        if ($start > $total) {
            $page = 1;
            $start = 0;
        }

        //初始化分页类
        $showpager=new ShowPager($total,$pagesize,$page);
        $offset=$showpager->offset;//设置开始查询位置
        $url="index.php?module=integral&action=Index&proname=".urlencode($proname)."&pagesize=".urlencode($pagesize);
        $pages_show = $showpager->multipage($url,$total,$page,$pagesize,$start,$para='');

        $sql = "select b.goods_id,c.price,b.id,b.goods_id,b.integral,b.money,b.sort,a.product_title,a.imgurl,a.product_class,c.num,c.min_inventory,c.img
        from lkt_integral_goods as b 
        left join lkt_product_list as a on b.goods_id=a.id 
        left join lkt_configure as c on b.attr_id=c.id where $condition order by b.sort desc limit $offset,$pagesize";
        $r_pager = $db->select($sql);

        if(!empty($r_pager)){
            foreach ($r_pager as $k => $v) {
                $v->imgurl = ServerPath::getimgpath($v->img,$store_id);
                $type = explode('-',$v->product_class);            
                $typeid = $type[1];
                $typesql = "select pname from lkt_product_class where cid=$typeid and store_id = '$store_id'";
                $typename = $db -> select($typesql);
                $v->typename= $typename[0]->pname;
                if (intval($v->min_inventory) < intval($v->num)) {
                    $v->inventory = 1;
                }else{
                    $v->inventory = 0;
                }
                $v->candel = 1;

                // $goodsid = $v->goods_id;
                // $sql = "select id from lkt_order_details where store_id = '$store_id' and p_id='$goodsid' and r_status in (0,1,2) and r_sNo like 'IN%'";
                $id = $v->id;
                $sql = "select id from lkt_order where store_id = '$store_id' and p_sNo='$id' and status in (0,1,2)";
                $can = $db->select($sql);
                if ($can) {
                    $v->candel = 0;
                }
            }

        }
        
        if($bstatus === '0'){
          $bstatus = intval($bstatus);
        }
        
        $request->setAttribute("num", count($r_pager));
        $request->setAttribute("list", $r_pager);
        $request->setAttribute("bstatus", $bstatus);
        $request->setAttribute("proname", $proname);
        $request->setAttribute("pages_show", $pages_show);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>