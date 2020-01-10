<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/version.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

/**
 * [Laike System] Copyright (c) 2019 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class RecordAction extends Action
{
    public function getDefaultView()
    {

        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //接收分页参数
        $id =  addslashes(trim($request->getParameter('id')));
        $user_name = addslashes(trim($request->getParameter('user_name')));
        $page = addslashes(trim($request->getParameter('page')));
        $pagesize = addslashes(trim($request->getParameter('pagesize')));

        $pagesize = $pagesize ? $pagesize :10;
        if ($page) {
            $start = ($page-1)*$pagesize;
        } else {
            $page = 1;
            $start = 0;
        }

        //初始化分页查询条件
        $condition = " where a.store_id = {$store_id}  and b.store_id = {$store_id} and c.store_id = {$store_id}";
        if ($user_name != '') {
            $condition .= " and c.user_name like '%{$user_name}%'";
        }
        
        //根据查询条件确定总记录数
        $sql = "select b.id from (lkt_auction_product as a left join lkt_auction_record as b on a.id = b.auction_id) left join lkt_user as c on b.user_id = c.user_id ".$condition." and a.id = '$id' order by a.id desc";
        $total = $db->selectrow($sql);

        $showpager=new ShowPager($total, $pagesize, $page);
        $offset=$showpager -> offset;//设置开始查询位置

        //根据分页，查询竞拍记录
        $sql = "select @i := @i+1 as my_no,$offset as offset,a.id as a_id,a.title,a.price,a.imgurl,a.current_price as c_price,a.status,a.is_buy,b.id as id,b.price as user_price,b.add_time,c.user_name,b.id as r_id,c.headimgurl from (lkt_auction_product as a left join lkt_auction_record as b on a.id = b.auction_id) left join lkt_user as c on b.user_id = c.user_id left join (select @i := $offset) as r on 1 = 1 ".$condition." and a.id = '$id' order by b.price desc,b.add_time desc,b.id desc limit $offset,$pagesize";
        $res = $db->select($sql);
        //拼接图片全路径
        if ($res) {
            foreach ($res as $k => $v) {
                $v->image = ServerPath::getimgpath($v->imgurl, $store_id);
            }
        }

        //查询出竞拍商品状态，以及是否付款
        $sql_1 = "select status,is_buy,pepole,low_pepole from lkt_auction_product where id = '$id' and store_id = '$store_id'";
        $res_1 = $db->select($sql_1);
        if ($res_1) {
            $status = $res_1[0]->status;
            $is_buy = $res_1[0]->is_buy;
            $pepole = $res_1[0]->pepole;
            $low_pepole = $res_1[0]->low_pepole;
        }
        //查询出最高价id
        $sql_0 = "select id as first_id from lkt_auction_record where store_id = '$store_id' and auction_id = '$id' order by price desc,add_time desc,id desc limit 1";
        $res_0 = $db->select($sql_0);
        if ($res_0) {
            $first_id = $res_0[0]->first_id;
            $request -> setAttribute('first_id', $first_id);
        }
        //返回分页类的分页内容
        $url="index.php?module=auction&action=Record&id=".urlencode($id)."&user_name=".urlencode($user_name);
        $pages_show=$showpager->multipage($url, $total, $page, $pagesize, $start, $para='');
        $count = count($res);//出价记录条数
        $request -> setAttribute('id', $id);
        $request -> setAttribute('$user_name', $user_name);
        $request -> setAttribute('list', $res);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('status', $status);
        $request -> setAttribute('is_buy', $is_buy);
        $request -> setAttribute('pepole', $pepole);
        $request -> setAttribute('low_pepole', $low_pepole);
        $request -> setAttribute('count', $count);


        return View :: INPUT;
    }

    public function execute()
    {
    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }
}
