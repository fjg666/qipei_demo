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

class IndexAction extends Action
{

    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 竞拍商品首页
     * @date 2019年1月7日
     * @version 1.0
     */

    public function getDefaultView()
    {

        
        //初始化
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        

        //接受分页参数
        $title = addslashes(trim($request->getParameter('title')));
        $status = addslashes(trim($request->getParameter('status')));
        $pagesize = addslashes(trim($request->getParameter('pagesize')));
        $page = addslashes(trim($request->getParameter('page')));

        $pagesize = $pagesize ? $pagesize : 10;
        if ($page) {
            $start = ($page-1)*$pagesize;
        } else {
            $page = 1;
            $start = 0;
        }

        //初始化分页查询条件
        $condition = "where a.store_id = '$store_id' and b.store_id = '$store_id'";
        if ($title != '') {
            $condition .= " and a.title like '%{$title}%'";
        }
        if ($status != '') {
            if ($status == 2 || $status ==3) {
                $condition .= " and a.status in (2,3)";
            } else {
                $condition .= " and a.status = '$status'";
            }
        }

        $sql = "select a.id from lkt_auction_product as a left join lkt_mch as b on a.mch_id = b.id ".$condition." and a.recycle = 0 order by a.id desc";
        $total = $db->selectrow($sql);

        //初始化分页类
        $showpager=new ShowPager($total, $pagesize, $page);
        $offset=$showpager -> offset;//设置开始查询位置

        $sql = "select a.id,a.title,a.imgurl,a.price,a.add_price,a.current_price,a.starttime,a.endtime,a.status,a.pepole,a.is_buy,a.s_type, a.is_show,b.name  from lkt_auction_product as a left join lkt_mch as b on a.mch_id = b.id ".$condition." and a.recycle = 0  order by a.status asc , a.id desc limit $offset,$pagesize";
        $res = $db->select($sql);

        //拼接图片路径
        if ($res) {
            foreach ($res as $k => $v) {
                $v->image = ServerPath::getimgpath($v->imgurl, $store_id);
                //拼接每个商品的活动标签
                $tag = '';
                $arr = array();
                $s_type = $v->s_type;//字符串
                $s_type_arr = explode(',', $s_type);//数组
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
    
        $url="index.php?module=auction&action=Index&title=".urlencode($title)."&status=".urlencode($status);
        $pages_show = $showpager->multipage($url, $total, $page, $pagesize, $start, $para='');

        $num = count($res);

        $request->setAttribute('num', $num);
        $request->setAttribute('list', $res);
        $request->setAttribute('title', $title);
        $request->setAttribute('status', $status);
        $request->setAttribute('pages_show', $pages_show);




        

        //



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
