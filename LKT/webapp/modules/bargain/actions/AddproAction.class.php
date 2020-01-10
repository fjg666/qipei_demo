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

class AddproAction extends Action {
    
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //获取顶级分类
        $sql = "select cid,sid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 ";
        $res = $db->select($sql);

        //商品分类
        $list = '';
        if($res){
            foreach ($res as $k => $v) {
                
                $cid_1 = '-'.$v->cid.'-';
                $list .= '<option value="'.$cid_1.'">'.$v->pname.'</option>';

                //查找一级分类数据
                $sql_1 = "select cid,sid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = {$v->cid}";
                $res_1 = $db->select($sql_1);
                if($res_1){
                    foreach($res_1 as $k2 => $v2){
                        $cid_2 = $cid_1.$v2->cid.'-';
                        $list .= '<option value="'.$cid_2.'">'.'-----'.$v2->pname.'</option>';
                        //查找二级分类数据
                        $sql_2 = "select sid,cid,pname from lkt_product_class where store_id = $store_id and recycle = 0 and sid = {$v2->cid}";
                        $res_2 = $db->select($sql_2);
                        if($res_2){
                            foreach($res_2 as $k3 => $v3){
                                $cid_3 = $cid_2.$v3->cid.'-';
                                $list .= '<option value="'.$cid_3.'">'.'----------'.$v3->pname.'</option>';
                            }
                        }
                    }
                }
            }
        }

        $sp_type = Tools::s_type($db, '商品类型');// 活动标签

        $request->setAttribute("class", $list);
        $request->setAttribute('sp_type',$sp_type);
        return View :: INPUT;
    }

    // 获取产品品牌
    public function getbrand(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $cid = $request->getParameter('cid');// 分类ID

        $cid = explode('-',$cid);
        $cids = '';
        foreach ($cid as $k => $v) {
            if(!empty($v) && empty($cids)){
                $cids .= $v.',';
            }
        }

        $sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%$cids%' order by sort desc";
        $res = $db -> select($sql);
        if(!empty($res)){
            $arr = array();
            foreach ($res as $key => $value) {
                if(in_array($value->brand_id,$arr)){
                    unset($res[$key]);
                }else{
                    $arr[] = $value->brand_id;
                }
            }
        }
        echo json_encode($res);exit;
    }

    // 获取商品信息
    public function getproattr_sel(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $where1 = $request->getParameter('where1');// 分类
        $where2 = $request->getParameter('where2');// 品牌
        $where3 = $request->getParameter('where3');// 关键字

        $where_str = "";
        if(!empty($where1)){
            $where_str.="and p.product_class like '$where1%'";
        }
        if(!empty($where2)){
            $where_str.="and p.brand_id = '$where2'";
        }
        if(!empty($where3)){
            $where_str.="and p.product_title like '%$where3%'";
        }
        // 查询商品
        $sql = "select p.min_inventory,p.mch_id,c.img,c.id,c.num,c.price,c.attribute,p.product_title,c.pid 
                from lkt_configure as c 
                left join lkt_product_list as p on c.pid=p.id 
                where c.num>0 and p.active = 3 and p.status=2 ".$where_str;
        $res = $db -> select($sql);
        $attrtype = array();
        $result = [];
        if(!empty($res)){
            foreach ($res as $k => $v) {
                $attrtype = unserialize($v->attribute);
                $attrtype = array_values($attrtype);
                $attrtype = implode(',', $attrtype);
                $res[$k]->attrtype = $attrtype;
                $res[$k]->pro_img = ServerPath::getimgpath($v->img,$store_id);

                $mch_id = intval($v->mch_id);
                $sql = "select name from `lkt_mch` where id='$mch_id' and store_id=$store_id";
                $rrr = $db->select($sql);
                $res[$k]->mchname = $rrr[0]->name;

                $sql = "select id from lkt_bargain_goods where goods_id='".$v->pid."' and attr_id='".$v->id."' and is_delete=0 and status!=2";
                $r = $db->select($sql);
                if (!$r || empty($r)) {
                    $result[$k] = $v;
                }
            }
        }else{
            $result = [];
        }
        echo json_encode($result);exit;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $m = $request->getParameter('m');

        $this -> $m();
    }

    // 添加活动
    public function insertpro(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 接收信息
        $min_price = trim($request->getParameter('min_price'));// 砍价最低价
        $attrid = trim($request->getParameter('attrid'));// 商品属性ID
        $obj = json_decode($request->getParameter('obj')); // 砍价方式数据
        $status_data = json_decode($request->getParameter('status_data'));// 砍价方式数据

        $log = new LaiKeLogUtils('common/bargain.log');// 日志

        $status_data = serialize($status_data);// 压缩砍价方式数据
        $time = date('Y-m-d H:i:s');

        // 活动标签
        if (!empty($obj->is_type)) {
            $obj->is_type = substr($obj->is_type, 0,strlen($obj->is_type)-1);
        }else{
            $obj->is_type = '';
        }

        // 获取排序
        $sql = "select sort from lkt_bargain_goods where store_id=$store_id order by sort desc limit 0,1";
        $rrr = $db->select($sql);
        $sort = !empty($rrr)?intval($rrr[0]->sort)+1:1;

        // 获取砍价结算时间
        $sel_cfg_sql = "select buy_time from lkt_bargain_config where 1";
        $cfg_res = $db->select($sel_cfg_sql);
        $buytime = $cfg_res?$cfg_res[0]->buy_time:0;

        // 添加
        $sql = "insert into lkt_bargain_goods(store_id,goods_id,attr_id,min_price,begin_time,end_time,buytime,man_num,status_data,addtime,is_show,is_type,sort) values ($store_id,$obj->goodsid,$attrid,'$min_price','$obj->startdate','$obj->enddate',$buytime,$obj->barginman,'$status_data','$time','$obj->is_show','$obj->is_type','$sort')";
        $res = $db -> insert($sql);
        if($res > 0){
            $log -> customerLog(__LINE__.":添加砍价活动成功！\r\n");
            echo json_encode(array('code' => 1, 'msg' => '添加砍价活动成功！'));exit;
        }else{
            $log -> customerLog(__LINE__.":添加砍价活动失败：$sql \r\n");
            echo json_encode(array('code' => 0, 'msg' => '添加砍价活动失败！'));exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>