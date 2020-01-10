<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

class templateAction extends Action
{

    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  周文
     * @version 2.0
     * @date    2019-2-22
     * @return  订单发货
     */
    public function getDefaultView()
    {
        $db = DBAction::getInstance();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');       

        $name = addslashes(trim($request->getParameter('name')));
        $type = trim($request -> getParameter('type'));
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');
        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }

        // 查询平台店铺id
        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r?$r[0]->shop_id:1;

        $c = " store_id='$store_id' and mch_id='$shop_id' and type='$type' ";
        if ($name != '') {
            $c .= "and name like '%$name%'";
        }
        // 查询平台单据模版
        $sql = "select * from lkt_mch_template where $c";
        $r = $db->select($sql);
        $total = count($r);
        $sql = "select * from lkt_mch_template where $c limit $start,$pagesize";
        $tpl = $db->select($sql);

        $pager = new ShowPager($total,$pagesize,$page);
        $url = "index.php?module=invoice&action=template&name=".urlencode($name)."&type=".urlencode($type)."&pagesize=".urlencode($pagesize);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        // 查询公共模版
        $sql = "select * from lkt_template where type='$type'";
        $all_tpl = $db->select($sql);

        $request->setAttribute("tpl", $tpl);
        $request->setAttribute("type", $type);
        $request->setAttribute("all_tpl", $all_tpl);
        $request->setAttribute("name", $name);
        return View :: INPUT;

    }


    /**
     * [execute description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-25T10:57:43+0800
     * @return  操作订单详情
     */
    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        //m指向具体操作方法
        $m = trim($request->getParameter('m')) ? addslashes(trim($request->getParameter('m'))):'getDefaultView';
        //m指向具体操作方法
        $this->$m();
        exit;
    }

    public function del()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = trim($request->getParameter('id'));
        $del = $db->delete("delete from lkt_mch_template where id='$id'");
        if ($del > 0) {
            echo json_encode(array('code' => 1,'msg'=>'操作成功！'));exit;
        }else{
            echo json_encode(array('code' => 0,'msg'=>'操作失败！'));exit;
        }
        
    }

    public function addtpl()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $name = trim($request->getParameter('tplname'));
        $imgs = trim($request -> getParameter('imgs'));
        $e_name = trim($request -> getParameter('e_name'));
        $width = trim($request -> getParameter('width'));
        $height = trim($request -> getParameter('height'));

        $sql = "select id from lkt_template where store_id='$store_id' and e_name='$e_name'";
        $r = $db->select($sql);
        if (!empty($r)) {
            echo json_encode(array('code' => 0,'msg'=>'区别名称不允许重复！'));exit;
        }

        $sql = "insert into `lkt_template` (`store_id`, `image`, `type`, `name`, `e_name`, `add_date`, `width`, `height`) VALUES ('$store_id', '$imgs', '1', '".$name."', '".$e_name."', CURRENT_TIMESTAMP, '".$width."', '".$height."')";
        $r = $db->insert($sql);
        if ($r > 0) {
            echo json_encode(array('code' => 1,'msg'=>'模版添加成功！'));exit;
        }else{
            echo json_encode(array('code' => 0,'msg'=>'添加失败请重试！'));exit;
        }
        
    }

    public function add()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $id = trim($request->getParameter('id'));
        $type = trim($request -> getParameter('type'));

        // 查询平台店铺id
        $sql = "select shop_id from lkt_admin where store_id='$store_id' and type=1";
        $r = $db->select($sql);
        $shop_id = $r?$r[0]->shop_id:1;

        $sql = "select * from lkt_template where id='$id'";
        $ttt = $db->select($sql);
        if ($ttt) {

            $sql = "select id from lkt_mch_template where store_id='$store_id' and mch_id='$shop_id' and e_name='".$ttt[0]->e_name."'";
            $r = $db->select($sql);
            if ($r) {
                echo json_encode(array('code' => 0,'msg'=>'请勿重复添加！'));exit;
            }

            $sql = "insert into `lkt_mch_template` (`store_id`, `mch_id`, `image`, `type`, `name`, `e_name`, `add_date`, `width`, `height`) VALUES ('$store_id', '$shop_id', '".$ttt[0]->image."', '".$ttt[0]->type."', '".$ttt[0]->name."', '".$ttt[0]->e_name."', CURRENT_TIMESTAMP, '".$ttt[0]->width."', '".$ttt[0]->height."')";
            $r = $db->insert($sql);
            if ($r > 0) {
                echo json_encode(array('code' => 1,'msg'=>'模版添加成功！'));exit;
            }else{
                echo json_encode(array('code' => 0,'msg'=>'添加失败请重试！'));exit;
            }
        }else{
            echo json_encode(array('code' => 0,'msg'=>'模版不存在，请重新添加！'));exit;
        }
        
    }

    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>