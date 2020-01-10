<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
class Distribution_gradeAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_distribution_config where store_id = '$store_id'";
        $re = $db->select($sql);
        if(!empty($re)){
             $re01=unserialize($re[0]->sets);
        }else{
             $re01=array();
        }

        // 拼接链接
        $con = '';
        foreach ($_GET as $k => $v) {
            $con .= "&$k=$v";
        }
        // 查询插件表
        $sql01 = "select * from lkt_distribution_grade where store_id = '$store_id' order by sort,id asc";
        $re02 = $db->select($sql01);

        $total = $db->selectrow($sql01);
        // 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:10;
        // 页码
        $page = $request -> getParameter('page');
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        if ($start > $total) {
            $page = 1;
            $start = 0;
        }
        $sql01 .= " limit $start,$pagesize ";

        $pager = new ShowPager($total,$pagesize,$page);
        $url = 'index.php?module=distribution&action=Distribution_grade'.$con;
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $re02 = $db->select($sql01);
        if(!empty($re02)){
            foreach ($re02 as $key => $value) {
                $sets = unserialize($value->sets);
                $value -> sets = $sets;
                $levelobj = $sets['levelobj'];
                if(isset($levelobj['manyyeji'])){
                    $levelobj['manyyeji'] = explode(',',$levelobj['manyyeji']);
                }
                if(isset($levelobj['manypeople'])){
                    $levelobj['manypeople'] = explode(',',$levelobj['manypeople']);
                }
                if(isset($levelobj['manyyeji'])){
                    $levelobj['manyyeji'] = $levelobj['manyyeji'][0];
                }
                if(isset($levelobj['recomm'])){
                    $levelobj['recomm'] = explode(',',$levelobj['recomm']);
                    if (intval($levelobj['recomm'][1]) > 0){
                        $id = intval($levelobj['recomm'][1]);
                        $sql = "select sets from lkt_distribution_grade where store_id = '$store_id' and id='$id'";
                        $r = $db->select($sql);
                        $levelobj['recomm'][1] = unserialize($r[0]->sets)['s_dengjiname'];
                    }
                }
                $value->levelobj = $levelobj;
            }
        }else{
             $re02=[];
        }
        $request->setAttribute("pages_show",$pages_show);
        $request->setAttribute("re",$re01);
        $request->setAttribute("re02",$re02);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}
?>