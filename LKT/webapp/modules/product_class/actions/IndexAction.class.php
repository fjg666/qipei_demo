<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action
{

    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id
        $uploadImg = $this->getContext()->getStorage()->read('uploadImg');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=product_class&action=Add');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=product_class&action=Modify');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=product_class&action=Del');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id, $admin_name, $admin_type1, 'index.php?module=product_class&action=Stick');

        $cid = $request->getParameter("cid"); // 分类id
        $pname = addslashes(trim($request->getParameter('pname'))); // 分类名称
        $m = addslashes(trim($request->getParameter('m'))); // 分类名称

//        $array = ['一级', '二级', '三级', '四级', '五级', '六级', '七级'];
        $arr = array();
        $sql0_0 = "select value from lkt_data_dictionary where name = '商品分类' and status = 1";
        $r0_0 = $db->select($sql0_0);
        if($r0_0){
            foreach ($r0_0 as $k => $v){
                $value = $v->value;
                $value_arr = explode(',',$value);
                $arr[$value_arr[0]] =$value_arr[1];
            }
        }

        $pageto = $request->getParameter('pageto');

        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : '10';
        $page = $request->getParameter('page'); // 页码
        if($page == 'null'){
            $page = 1;
        }
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }
        $condition = " store_id = '$store_id' and recycle = 0 ";
        if($pageto == 'whole') { // 导出全部
            $db->admin_record($store_id,$admin_name,' 导出商品分类列表 ',4);

            $sql0 = "select * from lkt_product_class where store_id = '$store_id' and recycle = 0 order by sort desc";
        }else if($pageto == 'inquiry'){//导出查询
            $db->admin_record($store_id,$admin_name,' 导出商品分类全部查询数据！ ',4);
            if($pname != ''){
                $sql0 = "select * from lkt_product_class where store_id = '$store_id' and recycle = 0 and pname like '%$pname%' order by sort desc";
            }else{
                $sql0 = "select * from lkt_product_class where store_id = '$store_id' and recycle = 0 and pname = '' order by sort desc";
            }
        }else if($pageto == 'This_page'){//导出当前页
            $db->admin_record($store_id,$admin_name,' 导出商品分类当前页面数据 ',4);
            if($cid){
                $sql0 = "select * from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$cid' order by sort desc limit $start,$pagesize";
            }else{
                $sql0 = "select * from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc limit $start,$pagesize";
            }
        }else{
            $sql0 = "select * from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc limit $start,$pagesize";
        }
        $r1 = $db->select($sql0);
        if($r1){
            foreach ($r1 as $k => $v){
                foreach($arr as $ke => $va){
                    if($v->level+1 == $ke){
                        $v->level = $va;
                    }
                }
            }
        }
        if($cid){
            if($m == 'tc'){
                $sql = "select * from lkt_product_class where $condition and cid = '$cid' ";
                $rr = $db->select($sql);
                if($rr){
                    $cid = $rr[0]->sid;
                }
            }
            // 上级id
            // 根据分类id,查询所有下级
            $sql = "select * from lkt_product_class where $condition and sid = '$cid' order by sort desc limit $start,$pagesize";
            $rr = $db->select($sql);

            if ($rr) {
                // 有数据
                $level = $rr[0]->level;
                // 循环查询该分类是否有商品
                foreach ($rr as $k => $v) {
                    $product_class = '-' . $v->cid . '-';
                    $sql = "select id from lkt_product_list where $condition and product_class like '%$product_class%' order by sort desc";
                    $rr1 = $db->select($sql);
                    if ($rr1) {
                        $v->status = 1; // 有商品，隐藏删除按钮
                    } else {
                        $v->status = 0; // 没商品，显示删除按钮
                    }
                    $v->img = $v->img ? ServerPath::getimgpath($v->img, $store_id) : '';
                    foreach($arr as $ke => $va){
                        if($v->level+1 == $ke){
                            $v->level = $va;
                        }
                    }
                    $rr[$k] = $v;
                }
            } else { // 没数据，查询当前分类级别
                $sql = "select level from lkt_product_class where $condition and cid = '$cid' order by sort desc limit $start,$pagesize";
                $rrr = $db->select($sql);
                if($rrr){
                    $level = $rrr[0]->level;
                }else{
                    $level= 0;
                    $sql = "select * from lkt_product_class where $condition and sid = '$cid' order by sort desc limit 0,$pagesize";
                    $rr = $db->select($sql);
                    if($rr){
                        $level = $rr[0]->level;
                        $page = 1;
                        // 循环查询该分类是否有商品
                        foreach ($rr as $k => $v) {
                            $product_class = '-' . $v->cid . '-';
                            $sql = "select id from lkt_product_list where $condition and product_class like '%$product_class%' order by sort desc";
                            $rr1 = $db->select($sql);
                            if ($rr1) {
                                $v->status = 1; // 有商品，隐藏删除按钮
                            } else {
                                $v->status = 0; // 没商品，显示删除按钮
                            }
                            $v->img = $v->img ? ServerPath::getimgpath($v->img, $store_id) : '';
                            foreach($arr as $ke => $va){
                                if($v->level+1 == $ke){
                                    $v->level = $va;
                                }
                            }
                            $rr[$k] = $v;
                        }
                    }
                }
            }
            $sid_1 = $cid;
            $request->setAttribute("cid", $sid_1);
        } else if ($pname != '') {
            $condition .= " and pname like '%$pname%' ";
            $level = 0;

            // 查询分类表，根据sort顺序排列
            $sql = "select * from lkt_product_class where $condition order by sort desc limit $start,$pagesize";
            $rr = $db->select($sql);
            if ($rr) {
                foreach ($rr as $k => $v) {
                    $product_class = '-' . $v->cid . '-';
                    $sql = "select id from lkt_product_list where $condition and product_class like '%$product_class%' order by sort desc";
                    $rr1 = $db->select($sql);
                    if ($rr1) {
                        $v->status = 1;
                    } else {
                        $v->status = 0;
                    }
                    if ($v->img != '') {
                        $v->img = ServerPath::getimgpath($v->img, $store_id);
                    }
                    foreach($arr as $ke => $va){
                        if($v->level+1 == $ke){
                            $v->level = $va;
                        }
                    }

                    $rr[$k] = $v;
                }
            }
        } else {
            $level = 0;
            // 查询分类表，根据sort顺序排列
            $sql = "select * from lkt_product_class where $condition and sid = 0 order by sort desc limit $start,$pagesize";
            $rr = $db->select($sql);
            if($rr){
                foreach ($rr as $k => $v) {
                    $product_class = '-' . $v->cid . '-';
                    $sql = "select id from lkt_product_list where $condition and product_class like '%$product_class%' order by sort desc";
                    $rr1 = $db->select($sql);
                    if ($rr1) {
                        $v->status = 1;
                    } else {
                        $v->status = 0;
                    }
                    if ($v->img != '') {
                        $v->img = ServerPath::getimgpath($v->img, $store_id);
                    }
                    foreach($arr as $ke => $va){
                        if($v->level+1 == $ke){
                            $v->level = $va;
                        }
                    }
                    $rr[$k] = $v;
                }
            }
        }
        $sid = $cid ? $cid : 0;
        $total = $db->selectrow("select * from lkt_product_class where $condition and sid = '$sid'");
        $pager = new ShowPager($total, $pagesize, $page);

        $url = "index.php?module=product_class&pname=" . urlencode($pname) . "&pagesize=" . urlencode($pagesize) . '&cid=' . urlencode($cid);
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        $level = $level ? $level : 0;
        $sql0_0 = "select id from lkt_data_dictionary_name where name = '商品分类' and status = 1 and recycle = 0 ";
        $r0_0 = $db->select($sql0_0);
        if($r0_0){
            $id = $r0_0[0]->id;

            $sql0_1 = "select value,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id'";
            $r0_1 = $db->select($sql0_1);
            $level_num = count($r0_1) - 1;
        }else{
            $level_num = 0;
        }

        //删除商品分类页面跳转限制字段
        if (empty($page)) {
            $page = 1;
        }
        $del_arr = array();
        $del_arr['page'] = $page;
        $del_arr['pagesize'] = $pagesize;
        $del_arr['pname'] = $pname;
        $del_arr['cid'] = $cid;
        $del_str = json_encode($del_arr);


        $this->getContext()->getStorage()->write('del_str', $del_str);//写入缓存

        $request->setAttribute('pageto',$pageto);
        $request->setAttribute("pname", $pname);
        $request->setAttribute("level", $level);
        $request->setAttribute("list", $rr);
        $request->setAttribute("pages_show", $pages_show);
        $request->setAttribute("uploadImg", $uploadImg);
        $request->setAttribute('button', $button);
        $request->setAttribute('del_str', $del_str);
        $request->setAttribute("list1", $r1);
        $request->setAttribute("level_num", $level_num);


        //跳转限制字段

        return View :: INPUT;
    }

    public function execute()
    {
        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}
?>