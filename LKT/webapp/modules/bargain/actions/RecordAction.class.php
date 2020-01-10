<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class RecordAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $username = trim($request->getParameter('username'));// 用户名称
        $type = $request->getParameter('type');// all- 全部 0-砍价中 1-砍价成功 2-砍价失败
        $bargain_id = $request->getParameter('goodsid');// 活动ID
        $pagesize = $request->getParameter('pagesize');// 每页显示多少条数据
        $pagesize = $pagesize ? $pagesize : 10;
        $page = $request->getParameter('page');// 页码
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        $where_str1 = "And o.store_id = '$store_id' and o.bargain_id='$bargain_id'";
        if ($username != '') {
            //查询名字类似的用户信息
            $sql = "select user_id from lkt_user where user_name LIKE '%$username%'";
            $uu_res = $db->select($sql);
            if($uu_res){
                $wherein = '';
                foreach ($uu_res as $k => $v){
                    $wherein.="'".$v->user_id."',";
                }

                $wherein = substr($wherein,0,strlen($wherein)-1);
                $where_str1 .= " and user_id in ($wherein) ";
            }else{
                $where_str1 .= " and user_id = '' ";
            }
        }

        $time = date("Y-m-d H:i:s",time());
        if($type == 'all'){
            //查询所有
        }elseif ($type == '0'){
            //查询砍价中
            $where_str1 .= " and o.status=0 ";
        }elseif ($type == '1'){
            //查询砍价完成 砍到最低价的
            $where_str1 .= " and o.status in (1,2) ";
        }elseif ($type == '2'){
            //查询砍价失败,超过活动时间且未砍到最低价的,或超过时间没有付款的
            $where_str1 .= " and o.status=-1 ";
        }

        $sql = "select o.id from lkt_bargain_order as o LEFT JOIN lkt_product_list as p on o.goods_id = p.id LEFT JOIN lkt_bargain_goods as g on g.goods_id = o.goods_id LEFT JOIN lkt_configure as c  on  c.id = o.attr_id where 1 = 1 ".$where_str1." group by o.addtime desc";
        $total = $db->selectrow($sql);
        if ($start > $total) {
            $page = 1;
            $start = 0;
        }

        //初始化分页类
        $showpager=new ShowPager($total,$pagesize,$page);
        $offset=$showpager->offset;//设置开始查询位置
        $url = "index.php?module=bargain&action=Record&username=".$username."&goodsid=".$bargain_id."&type=".$type."&pagesize=" . urlencode($pagesize);
        $pages_show = $showpager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        $sql = "select o.*,p.product_title,g.begin_time,g.end_time,c.price 
                from lkt_bargain_order as o  
                LEFT JOIN lkt_product_list as p on o.goods_id = p.id 
                LEFT JOIN lkt_bargain_goods as g on g.goods_id = o.goods_id 
                LEFT JOIN lkt_configure as c  on  c.id = o.attr_id 
                where 1 = 1 ".$where_str1." group by  o.addtime desc limit $start,$pagesize";
        $o_res = $db->select($sql);

        $sql = "select 1 
                from lkt_bargain_order as o  
                LEFT JOIN lkt_product_list as p on o.goods_id = p.id 
                LEFT JOIN lkt_bargain_goods as g on g.goods_id = o.goods_id 
                LEFT JOIN lkt_configure as c  on  c.id = o.attr_id 
                where 1 = 1 ".$where_str1." group by  o.addtime desc ";
        $c_res = $db->select($sql);
        foreach ($o_res as $k => $v){
            $user_id = $v->user_id;
            $sql = "select user_name from lkt_user where user_id = '$user_id'";
            $u_res = $db->select($sql);
            if($u_res){// 用户名称
                $v->user_name = $u_res[0]->user_name;
            }else{
                $v->user_name = '未知用户';
            }
            $sql = "select COUNT(*) as count from lkt_bargain_record where order_no = '$v->order_no'";
            $r_res = $db->select($sql);
            $v->count = $r_res[0]->count;// 参与人次
            $v->addtime = date('Y-m-d H:i',$v->addtime);// 参与时间
        }

        $request->setAttribute("list", $o_res);
        $request->setAttribute("goodsid", $bargain_id);
        $request->setAttribute("username", $username);
        $request->setAttribute("pages_show", $pages_show);
        $request->setAttribute("type", $type);
        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>