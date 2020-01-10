<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class IndexAction extends Action{

    public function getDefaultView(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=comments&action=reply');
        $button[1] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=comments&action=modify');
        $button[2] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=comments&action=del');

        $otype = isset($_GET['otype']) && $_GET['otype'] !== '' ? $_GET['otype'] : false; // 好评，中评，差评
        $status = isset($_GET['status']) && $_GET['status'] !== '' ? $_GET['status'] : false;
        $ostatus = isset($_GET['ostatus']) && $_GET['ostatus'] !== '' ? $_GET['ostatus'] : false;
        $sNo = isset($_GET['sNo']) && $_GET['sNo'] !== '' ? $_GET['sNo'] : false;

        // 导出
        $pagesize = $request->getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize : 10;
        // 页码
        $page = $request->getParameter('page');
        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        $condition = " where c.store_id = '$store_id'";
        if ($otype) {
            if ($otype == 'GOOD') {
                $condition .= " and c.CommentType > '3' ";
            } elseif ($otype == 'NOTBAD') {
                $condition .= " and c.CommentType = '3' ";
            } else {
                $condition .= " and c.CommentType < '3' ";
            }
        }

        $startdate = $request->getParameter("startdate");
        $enddate = $request->getParameter("enddate");
        if ($startdate != '') {
            $condition .= " and c.add_time >= '$startdate 00:00:00' ";
        }
        if ($enddate != '') {
            $condition .= " and c.add_time <= '$enddate 23:59:59' ";
        }

        if (strlen($status) == 1) {
            if ($status !== false) {
                $cstatus = intval($status);
                $condition .= " and a.r_status=$cstatus";
            }
        } else if (strlen($status) > 1) {
            if ($status !== false) {
                $cstatus = intval(substr($status, 1));
                $condition .= " and a.ptstatus=$cstatus";
            }
        }
        if ($ostatus !== false) {
            $costatus = intval(substr($ostatus, 1));
            $condition .= " and a.r_status=$costatus";
        }
        if ($sNo !== false) $condition .= ' and a.r_sNo like "%' . $sNo . '%" ';


        $con = '';
        foreach ($_GET as $key => $value001) {
            $con .= "&$key=$value001";
        }

        $sql1 = 'select a.id as odid,a.r_sNo,a.p_price,a.p_name,a.r_status,c.*,o.otype,o.mch_id ,lm.name as shop_name
                    from lkt_order_details AS a 
                    LEFT JOIN lkt_comments AS c ON a.r_sNo = c.oid 
                    LEFT JOIN lkt_order as o on a.r_sNo = o.sNo
                    LEFT JOIN lkt_product_list as lpl on lpl.id = a.p_id
                    LEFT JOIN lkt_mch as lm on lm.id = lpl.mch_id
                    ' . $condition . ' and a.r_status in (5,12) AND a.sid = c.attribute_id order by c.add_time desc ';

        $total = $db->selectrow($sql1);

        $sql1 .= " limit $start,$pagesize ";
        $r = $db->select($sql1);

        $pager = new ShowPager($total, $pagesize, $page);
        $url = 'index.php?module=comments' . $con;
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');
        $res1 = $db->select($sql1);
        if ($res1) {
                foreach ($res1 as $k01 => $v01) {
                    if($v01 ->otype != 'pt'){
                        $v01 ->otype = substr($v01->r_sNo,0,2);
                    }
                    if ($v01->anonymous) {
                        $v01->anonymous = '匿名';
                    }else{
                        $v01->anonymous = $v01->uid;
                    }
                    $res1[$k01]->CommentType1 = $v01->CommentType;
                    if ($v01->CommentType == 5) {
                        $res1[$k01]->CommentType1 = 'GOOD';
                    } elseif ($v01->CommentType == 4) {
                        $res1[$k01]->CommentType1 = 'GOOD';
                    } elseif ($v01->CommentType == 3) {
                        $res1[$k01]->CommentType1 = 'NOTBAD';
                    } elseif ($v01->CommentType == 2) {
                        $res1[$k01]->CommentType1 = 'BAD';
                    } elseif ($v01->CommentType == 1) {
                        $res1[$k01]->CommentType1 = 'BAD';
                    } elseif ($v01->CommentType == 'GOOD') {
                        $res1[$k01]->CommentType1 = 'GOOD';
                    } elseif ($v01->CommentType == 'NOTBAD') {
                        $res1[$k01]->CommentType1 = 'NOTBAD';
                    } else {
                        $res1[$k01]->CommentType1 = 'BAD';
                    }

                    $tt_sql = "select * from lkt_reply_comments where cid = '$v01->id' and store_id = '$store_id' ";
                    $v01->rec = $db->select($tt_sql) ? 0:1;
                }

            $total = count($res1);
            $pager = new ShowPager($total, $pagesize, $page);
            $offset = $pager->offset;
            $request->setAttribute("otype", $otype);
            $request->setAttribute("status", $status);
            $request->setAttribute("ostatus", $ostatus);
            $request->setAttribute("sNo", $sNo);
            $request->setAttribute("startdate", $startdate);
            $request->setAttribute("enddate", $enddate);
            
            $request->setAttribute("order", $res1);
            $request->setAttribute("pages_show", $pages_show);
            $request->setAttribute('button', $button);
        }
        $comments_str = Tools::data_dictionary($db,'评价',$otype);

        $request->setAttribute("comments_str", $comments_str);
        return View :: INPUT;
    }

    public function execute(){

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }
}
?>