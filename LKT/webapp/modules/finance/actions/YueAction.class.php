<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class YueAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        // 接收数据
        $name = addslashes(trim($request->getParameter('name'))); // 用户名称
        $source = addslashes(trim($request->getParameter('source'))); // 用户来源
        $starttime = $request->getParameter('startdate');//开始时间
        $group_end_time = $request->getParameter('enddate');//结束时间
        $pageto = $request->getParameter('pageto');// 导出
        $pagesize = $request->getParameter('pagesize');// 每页显示多少条数据
        $pagesize = $pagesize ? $pagesize:'10';
        $page = $request->getParameter('page');// 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        $button[0] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=finance&action=Yue_see');

        $condition = " store_id = '$store_id' ";
        if($name){
            $name = htmlspecialchars($name);
            $condition .= " and user_name like '%$name%' ";
        }
        if($source){
            $condition .= " and source = '$source' ";
        }
        if($starttime){
            $condition .= " and Register_data >= '$starttime' ";
        }
        if($group_end_time){
            $condition .= " and Register_data <= '$group_end_time' ";
        }
        $list = array();

        $sql = "select id from lkt_user where $condition";
        $r = $db->select($sql);
        $list = array();
        $total = 0;
        if($r){
            $total = count($r);
            // 页码调整
            if ($start > $total) {$page = 1;$start = 0;}

            if($pageto == 'whole') { // 导出全部

                 $db->admin_record($store_id,$admin_name,' 导出余额列表 ',4);
                 $sql = "select user_id,user_name,source,money,Register_data from lkt_user where store_id = '$store_id' group by user_id order by Register_data desc";
              
            }else if($pageto == 'inquiry'){//导出全部查询

                 $db->admin_record($store_id,$admin_name,' 导出余额列表全部查询 ',4);
                 $sql = "select user_id,user_name,source,money,Register_data from lkt_user where $condition group by user_id order by Register_data desc";

            }else if($pageto == 'This_page'){//导出查询当前页

                $db->admin_record($store_id,$admin_name,' 导出余额列表当前页 ',4);
                $sql = "select user_id,user_name,source,money,Register_data from lkt_user where $condition group by user_id order by Register_data desc limit $start,$pagesize ";

            }else{
                $sql = "select user_id,user_name,source,money,Register_data from lkt_user where $condition group by user_id order by Register_data desc limit $start,$pagesize ";
                
            }
            $list = $db->select($sql);
        }
        $pager = new ShowPager($total,$pagesize,$page);

        $url = "index.php?module=finance&action=Yue&name=".urlencode($name)."&source=".urlencode($source)."&starttime=".urlencode($starttime)."&group_end_time=".urlencode($group_end_time)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $source_str = Tools::data_dictionary($db,'来源',$source);

        $request->setAttribute("name",$name);
        $request->setAttribute("list",$list);
        $request->setAttribute('pageto',$pageto);
        $request->setAttribute('button', $button);
        $request->setAttribute("source",$source_str);
        $request->setAttribute("starttime",$starttime);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute("group_end_time",$group_end_time);

        return View :: INPUT;
    }

    public function execute() {

    }


    public function getRequestMethods(){
         return Request :: POST;
    }

}

?>