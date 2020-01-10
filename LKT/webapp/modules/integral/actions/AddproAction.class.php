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
        $id = intval($request->getParameter('id'));// 活动ID

        //获取顶级级分类
        $sql = "select cid,sid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 ";
        $res = $db->select($sql);

        // 获取分类
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

        $pro = '';
        if (!empty($id)) {
            $sql = "select * from lkt_integral_goods where id='$id'";
            $r = $db->select($sql);
            $pro = $r[0];
        }

        $request->setAttribute("id", $id);// 活动ID
        $request->setAttribute("pro", $pro);// 选中商品
        $request->setAttribute("class", $list);// 分类列表
        return View :: INPUT;
    }
    // 获取品牌
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

        // 查询此分类下品牌
        $sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%$cids%' order by sort desc";
        $res = $db -> select($sql);
        if(!empty($res)){
            $arr = array();
            foreach ($res as $key => $value) {
                if(in_array($value -> brand_id,$arr)){
                    unset($res[$key]);
                }else{
                    $arr[] = $value -> brand_id;
                }
            }
        }

        echo json_encode($res);exit;
    }
    // 获取商品列表
    public function getproattr_sel(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $where1 = $request->getParameter('where1');// 分类
        $where2 = $request->getParameter('where2');// 品牌
        $where3 = $request->getParameter('where3');// 关键字
        $id = intval($request->getParameter('id'));// 指定商品ID

        $where_str = " c.num>0 and p.active = 7 and p.status=2 ";
        if(!empty($where1)){
            $where_str.="and p.product_class like '$where1%'";
        }
        if(!empty($where2)){
            $where_str.="and p.brand_id = '$where2'";
        }
        if(!empty($where3)){
            $where_str.="and p.product_title like '%$where3%'";
        }
        if (intval($id) > 0) {
            $sql = "select attr_id from lkt_integral_goods where id='$id'";
            $r = $db->select($sql);
            $attr_id = $r[0]->attr_id;
            $where_str=" c.id='$attr_id'";
        }
        // 查询商品信息
        $sql = "select p.mch_id,p.imgurl,c.id,c.num,p.min_inventory,c.price,c.attribute,p.product_title,c.pid,c.img 
                from lkt_configure as c 
                left join lkt_product_list as p on c.pid=p.id 
                where ".$where_str;
        $res = $db -> select($sql);
        $attrtype = array();
        $result = [];
        if(!empty($res)){
            foreach ($res as $k => $v) {
                $attrtype = unserialize($v->attribute);
                $attrtype = array_values($attrtype);
                $attrtype = implode(',', $attrtype);
                $v->attrtype = $attrtype;
                $v->pro_img = ServerPath::getimgpath($v->img,$store_id);

                $mch_id = intval($v->mch_id);
                $sql = "select name from `lkt_mch` where id='$mch_id' and store_id=$store_id";
                $rrr = $db->select($sql);
                $v->mchname = $rrr[0]->name;

                $sql = "select id from lkt_integral_goods where goods_id='".$v->pid."' and attr_id='".$v->id."' and is_delete=0";
                $r = $db->select($sql);
                if (intval($id) > 0) {
                    if ($r && !empty($r)) {
                        $v->gou = 1;
                        $result[$k] = $v;
                    }
                }else{
                    if (!$r || empty($r)) {
                        $v->gou = 0;
                        $result[$k] = $v;
                    }
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
    // 添加商品活动
    public function insertpro(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');// 管理员
        // 接收信息
        $obj = json_decode($request->getParameter('obj')); // 数据
        $id = intval($obj->id);// 活动ID

        $log = new LaiKeLogUtils('common/integral.log');// 日志

        if (intval($obj->goodsid)>0) {
            $goods_id = $obj->goodsid;
        }else{
            $log -> customerLog(__LINE__.":操作积分商品失败：请选择正确的商品！\r\n");
            $db->admin_record($store_id,$admin_name,'添加积分商品失败！',1);
            echo json_encode(array('code' => 0, 'msg' => '请选择正确的商品！'));exit;
        }
        if (intval($obj->attrid)>0) {
            $attr_id = $obj->attrid;
        }else{
            $log -> customerLog(__LINE__.":操作积分商品失败：请选择正确的商品！\r\n");
            $db->admin_record($store_id,$admin_name,'添加积分商品失败！',1);
            echo json_encode(array('code' => 0, 'msg' => '请选择正确的商品！'));exit;
        }
        if (intval($obj->integral)>0) {
            $integral = intval($obj->integral);
        }else{
            $log -> customerLog(__LINE__.":操作积分商品失败：兑换所需积分需大于零！\r\n");
            $db->admin_record($store_id,$admin_name,'添加积分商品失败！',1);
            echo json_encode(array('code' => 0, 'msg' => '兑换所需积分需大于零！'));exit;
        }
        $money = floatval($obj->money)>0?floatval($obj->money):0;

        $sql = "select sort from lkt_integral_goods where store_id=$store_id and is_delete=0 order by sort desc limit 0,1";
        $rrr = $db->select($sql);
        $sort = !empty($rrr)?intval($rrr[0]->sort)+1:1;

        if ($id == 0) {
            $sql = "select id from lkt_integral_goods where store_id='$store_id' and attr_id='$attr_id' and is_delete=0";
            $r = $db->select($sql);
            if (count($r) > 0) {
                $log -> customerLog(__LINE__.":操作积分商品失败：请勿重复添加同一属性商品！\r\n");
                $db->admin_record($store_id,$admin_name,'添加积分商品失败！',1);
                echo json_encode(array('code' => 0, 'msg' => '请勿重复添加同一属性商品！'));exit;
            }
        }

        $sql = "select c.num 
                from lkt_configure as c 
                left join lkt_product_list as p on c.pid=p.id 
                where c.num>0 and p.active = 7 and p.status=2 and c.id='$attr_id'";
        $r = $db->select($sql);
        if (empty($r)) {
            $log -> customerLog(__LINE__.":操作积分商品失败：商品状态错误，请重新选择！\r\n");
            $db->admin_record($store_id,$admin_name,'添加积分商品失败！',1);
            echo json_encode(array('code' => 0, 'msg' => '商品状态错误，请重新选择！'));exit;
        }

        if ($id == 0) {
            $sql = "insert into lkt_integral_goods(store_id,goods_id,attr_id,integral,money,sort) values ('$store_id','$goods_id','$attr_id','$integral','$money','$sort')";
            $res = $db -> insert($sql);
            if($res > 0){
                $log -> customerLog(__LINE__.":添加积分商品成功！\r\n");
                $db->admin_record($store_id,$admin_name,'添加积分商品成功！',1);
                echo json_encode(array('code' => 1, 'msg' => '添加积分商品成功！'));exit;
            }else{
                $log -> customerLog(__LINE__.":添加积分商品失败：$sql \r\n");
                $db->admin_record($store_id,$admin_name,'添加积分商品失败！',1);
                echo json_encode(array('code' => 0, 'msg' => '添加积分商品失败！'));exit;
            }
        }else{
            $sql = "UPDATE `lkt_integral_goods` SET `goods_id`='$goods_id', `attr_id`='$attr_id', `integral`='$integral', `money`='$money' WHERE (`id`='$id')";
            $res = $db -> insert($sql);
            if($res >= 0){
                $log -> customerLog(__LINE__.":编辑积分商品成功！\r\n");
                $db->admin_record($store_id,$admin_name,'编辑积分商品成功！',2);
                echo json_encode(array('code' => 1, 'msg' => '编辑积分商品成功！'));exit;
            }else{
                $log -> customerLog(__LINE__.":编辑积分商品失败：$sql \r\n");
                $db->admin_record($store_id,$admin_name,'编辑积分商品失败！',2);
                echo json_encode(array('code' => 0, 'msg' => '编辑积分商品失败！'));exit;
            }
        }
    }
    // 置顶
    public function top(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');// 管理员
        $id = $request->getParameter('id');// 活动ID

        $log = new LaiKeLogUtils('common/integral.log');// 日志
        // 查询最大排序号
        $sql = "SELECT MAX(sort) as sort FROM `lkt_integral_goods`";
        $sortRes = $db->select($sql);
        if($sortRes){
            $sort = $sortRes[0]->sort;
            $sort = (int)$sort + 1;
            // 修改商品排序号
            $sql = "UPDATE `lkt_integral_goods` SET sort = $sort WHERE id = $id";
            $res = $db->update($sql);
            if($res){
                $log -> customerLog(__LINE__.":积分商品置顶成功！\r\n");
                $db->admin_record($store_id,$admin_name,'置顶ID为'.$id.'的积分商品成功！',2);
                echo json_encode(array('status' => 1,'info' => '操作成功!'));exit;
            }
            $log -> customerLog(__LINE__.":积分商品置顶失败：$sql \r\n");
            $db->admin_record($store_id,$admin_name,'置顶ID为'.$id.'的积分商品失败！',2);
            echo json_encode(array('status' => 0,'info' => '操作失败!'));exit;
        }
        $log -> customerLog(__LINE__.":积分商品置顶失败：$sql \r\n");
        $db->admin_record($store_id,$admin_name,'置顶ID为'.$id.'的积分商品失败！',2);
        echo json_encode(array('status' => 0,'info' => '操作失败!'));exit;

    }
    // 删除商品
    public function delpro(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');// 管理员
        $id = $request->getParameter('id');// 活动ID

        $log = new LaiKeLogUtils('common/integral.log');// 日志
        
        if (count(explode(',', $id)) > 1) {
            $id = substr($id, 0,-1);
        }

        $sql = "select id,goods_id from lkt_integral_goods where store_id='$store_id' and id in ($id)";
        $goods = $db->select($sql);
        foreach ($goods as $k => $v) {
            // $goodsid = $v->goods_id;
            // $sql = "select id from lkt_order_details where store_id = '$store_id' and p_id='$goodsid' and r_status in (0,1,2) and r_sNo like 'IN%'";
            $pid = $v->id;
            $sql = "select id from lkt_order where store_id = '$store_id' and p_sNo='$pid' and status in (0,1,2)";
            $r = $db->select($sql);
            if ($r) {
                $log -> customerLog(__LINE__.":积分商品删除失败：此商品还有订单未完成，不可删除！\r\n");
                $db->admin_record($store_id,$admin_name,'删除ID为'.$id.'的积分商品失败！',3);
                echo json_encode(array('status' => 2,'info' => '此商品还有订单未完成，不可删除!'));exit;
            }else{
                $sql = "update lkt_integral_goods set is_delete = 1 where id='$pid'";
                $res = $db -> update($sql);
                if($res < 0){
                    $log -> customerLog(__LINE__.":积分商品删除失败：$sql \r\n");
                    $db->admin_record($store_id,$admin_name,'删除ID为'.$id.'的积分商品失败！',3);
                    echo json_encode(array('status' => 2,'info' => '删除失败!'));exit;
                }
            }
        }
        $log -> customerLog(__LINE__.":积分商品删除成功！\r\n");
        $db->admin_record($store_id,$admin_name,'删除ID为'.$id.'的积分商品成功！',3);
        echo json_encode(array('status' => 1,'info' => '删除成功!'));exit;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>