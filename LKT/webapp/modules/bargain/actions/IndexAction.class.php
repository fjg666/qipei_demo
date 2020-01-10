<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class IndexAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        // 接收参数
        $proname = trim($request->getParameter('proname')); // 商品名称
        $bstatus = $request->getParameter('bstatus'); // 活动状态
        $pageto = $request->getParameter('pageto');// 导出
        $pagesize = $request->getParameter('pagesize');// 每页显示多少条数据
        $pagesize = $pagesize ? $pagesize : 10;
        $page = $request->getParameter('page');// 页码
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        $log = new LaiKeLogUtils('common/bargain.log');// 日志

        // 拼接查询条件
        $condition = " a.store_id = '$store_id' and a.recycle = 0 and b.is_delete=0 ";
        if ($bstatus != '') {
            $condition .= " and b.status=$bstatus ";
        }
        if ($proname != '') {
            $condition .= " and a.product_title like '%$proname%' ";
        }

        $sql = "select b.id from lkt_bargain_goods as b left join lkt_product_list as a on b.goods_id=a.id left join lkt_configure as c on b.attr_id=c.id where $condition order by b.sort desc";
        $total = $db->selectrow($sql);
        if ($start > $total) {
            $page = 1;
            $start = 0;
        }

        //初始化分页类
        $showpager=new ShowPager($total,$pagesize,$page);
        $offset=$showpager->offset;//设置开始查询位置
        $url="index.php?module=bargain&action=Index&bstatus=".urlencode($bstatus)."&proname=".urlencode($proname)."&pagesize=".urlencode($pagesize);
        $pages_show = $showpager->multipage($url,$total,$page,$pagesize,$start,$para='');

        // 查询活动
        $sql = "select c.price,b.id,b.goods_id,b.min_price,b.begin_time,b.end_time,b.status as b_status,b.is_show,b.is_type,b.sort,a.product_title,a.imgurl,a.product_class,c.num,c.img
        from lkt_bargain_goods as b 
        left join lkt_product_list as a on b.goods_id=a.id 
        left join lkt_configure as c on b.attr_id=c.id where $condition order by b.status asc limit $offset,$pagesize";
        $r_pager = $db->select($sql);

        if(!empty($r_pager)){
            foreach ($r_pager as $k => $v) {
                $v->imgurl = ServerPath::getimgpath($v->img,$store_id);// 商品图片
                $start_time = strtotime($v->begin_time);// 开始时间
                $end_time = strtotime($v->end_time);// 结束时间

                if($end_time<time()){// 判断结束活动
                    $v->b_status = 2;
                    if ($v->b_status==0 || $v->b_status==1) {
                        $sql = 'update lkt_bargain_goods SET status = 2 where id = '.$v->id;
                        $upd = $db->update($sql);
                        $log -> customerLog(__LINE__.":结束砍价活动：【".$v->id."】\r\n");
                    }
                }else if($start_time<time() && $end_time>time()){// 判断开始活动
                    $v->b_status = 1;
                    if ($v->b_status==0) {
                        $sql = 'update lkt_bargain_goods SET status = 1 where id = '.$v->id;
                        $upd = $db->update($sql);
                        $log -> customerLog(__LINE__.":开始砍价活动：【".$v->id."】\r\n");
                    }
                }else{
                    $v->b_status = 0;
                }

                // 获取活动标签
                $tag = '';
                $s_type_arr = explode(',', $v->is_type);//数组
                $sql_0 = "select value from lkt_data_dictionary where name = '商品类型' and status = 1";
                $res_0 = $db->select($sql_0);
                if ($res_0) {
                    foreach ($res_0 as $k1 => $v1) {
                        $arr_0 = array();
                        $arr_0 = explode(',', $v1->value);
                        $arr[$arr_0[0]] = $arr_0[1];
                    }
                }
                foreach ($s_type_arr as $k2 => $v2) {
                    if (array_key_exists($v2, $arr)) {
                        $tag .= $arr[$v2].'|';
                    }
                }
                $v->tag = substr($tag, 0, -1);

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