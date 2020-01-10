<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=taobao&action=See');

        $pageto = $request->getParameter('pageto');// 导出
        $pagesize = $request -> getParameter('pagesize');// 页码
        $pagesize = $pagesize ? $pagesize:'10';// 每页显示多少条数据
        $page = $request -> getParameter('page');// 页码

        if ($page) {
            $start = ($page - 1) * $pagesize;
        } else {
            $start = 0;
        }

        $sql0 = "select * from lkt_taobao where store_id = '$store_id' order by creattime desc";
        $r0 = $db->select($sql0);
        if ($r0) {
            $total = count($r0);
        } else {
            $total = 0;
        }
        $pager = new ShowPager($total, $pagesize, $page);

        $sql = "select * from lkt_taobao where store_id='$store_id' order by creattime desc limit $start,$pagesize";
        $list = $db->select($sql);

        $url = "index.php?module=taobao&action=Index&pagesize=" . urlencode($pagesize);
        $pages_show = $pager->multipage($url, $total, $page, $pagesize, $start, $para = '');

        $request->setAttribute("list", $list);
        $request->setAttribute('pages_show', $pages_show);
        $request->setAttribute('button', $button);

        return View :: INPUT;
    }

    public function execute() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $title = addslashes(trim($request->getParameter('title'))); // 任务标题
        $cid = addslashes(trim($request->getParameter('cid'))); // 分类名称
        $brand_id = addslashes(trim($request->getParameter('brand_id'))); // 品牌id
        $link = $request->getParameter('link');// 淘宝链接

        $Tools = new Tools($db, $store_id, 1);
        $cid = $Tools->str_option($cid);// 分类ID

        $log = new LaiKeLogUtils('common/taobao.log');// 日志

        foreach ($link as $k => $v) {
            $lll = trim($v);
            if (!empty($lll)) {
                // 截取出域名
                preg_match('|\.(.*).com|isU',$lll, $type);
                $type = $type?$type[1]:'';
                // 截取出淘宝商品ID
                preg_match('/id\=(\d+)/i', $lll, $matches);
                if (isset($matches[1])) {
                    $itemid = $matches?$matches[1]:'';
                }
                // 当地址为taobao，并且商品ID不为空时加入任务
                if($type == 'taobao' && !empty($itemid)){
                    $sql = "select id from lkt_taobao where store_id='$store_id' and itemid='$itemid' and status=0";
                    $r = $db->select($sql);
                    if (!$r) {
                        $sql = "insert into `lkt_taobao` (`store_id`, `link`, `itemid`, `creattime`, `cid`, `brand_id`,`title`) VALUES ('$store_id', '$lll', '$itemid', CURRENT_TIMESTAMP, '$cid', '$brand_id', '$title')";
                        $r = $db->insert($sql);
                        if ($r > 0) {
                            $log -> customerLog(__LINE__.":新增淘宝任务成功：链接地址为：$lll\r\n");
                        }else{
                            $log -> customerLog(__LINE__.":新增淘宝任务失败：$sql\r\n");
                        }
                        $db->admin_record($store_id,$admin_name,' 添加淘宝任务成功 淘宝ID为：$itemid',1);
                    }
                }else{
                    $log -> customerLog(__LINE__.":新增淘宝任务失败：链接地址为：$lll\r\n");
                    $db->admin_record($store_id,$admin_name,' 添加淘宝任务失败 地址为：$lll',1);
                }
            }
        }
        echo json_encode(array('msg' => '加入任务列表成功！', 'suc' => '1'));exit;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}

?>