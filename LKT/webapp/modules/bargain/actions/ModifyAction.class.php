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

class ModifyAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $id = trim($request->getParameter('id'));// 活动ID

        $sql = "select b.*,c.price,c.num,c.attribute,p.min_inventory,p.product_title,p.product_class,p.brand_id from lkt_bargain_goods as b left join lkt_configure as c on b.attr_id=c.id left join lkt_product_list as p on b.goods_id=p.id where b.id=$id and b.store_id='$store_id'";
        $res = $db->select($sql);
        foreach ($res as $k => $v) {
            $attrtype = unserialize($v->attribute);// 商品属性
            if (!empty($v->attribute)) {
                $attrtype = array_values($attrtype);
                $attrtype = implode(',', $attrtype);                        
                $res[$k]->attrtype = $attrtype;
            }else{
                $res[$k]->attrtype = '';
            }
        }
        $goodsid = $res[0]->goods_id;// 商品ID
        $attr_id = $res[0]->attr_id;// 属性ID
        $product_class = $res[0]->product_class;// 商品分类
        $brand_id = $res[0]->brand_id;// 品牌ID
        $msg = $res[0];

        $sss = $msg->status!=0?false:true;
        $s_type = explode(',',$msg->is_type);
        $sp_type =  Tools::s_type($db, '商品类型', $s_type, $sss);// 活动类型
        $status_data = unserialize($msg->status_data);

        $prosql = "select c.id,p.id as pid,p.imgurl,p.mch_id,c.img,c.id as attr_id,c.price,c.num,c.attribute,p.min_inventory,p.product_title from lkt_configure as c left join lkt_product_list as p on c.pid=p.id where c.pid=$goodsid and c.id='$attr_id' and p.store_id='$store_id'";
        $proattr = $db->select($prosql);
        $result = [];
        if(!empty($proattr)){
            foreach ($proattr as $k => $v) {
                $attrtype1 = unserialize($v->attribute);
                $attrtype1 = array_values($attrtype1);
                $attrtype1 = implode(',', $attrtype1);                        
                $proattr[$k]->attrtype = $attrtype1;
                $proattr[$k]->pro_img = ServerPath::getimgpath($v->img,$store_id);

                $sql = "select name from lkt_mch where store_id='$store_id' and id='".$v->mch_id."'";
                $r = $db->select($sql);
                $proattr[$k]->mchname = $r?$r[0]->name:'';

                $sql = "select id from lkt_bargain_goods where goods_id='".$v->pid."' and attr_id='".$v->id."' and is_delete=0 and status!=2";
                $r = $db->select($sql);
                if (!$r || empty($r)) {
                    $result[$k] = $v;
                }else{
                    if (intval($r[0]->id) == intval($id)) {
                        $result[$k] = $v;
                    }
                }
            }
        }

        // 获取商品分类
        $sql01 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 ";
        $rr = $db->select($sql01);
        $res_ = '';
        foreach ($rr as $key => $value) {
            $c = '-' . $value->cid . '-';
            //判断所属类别 添加默认标签
            if ($product_class == $c) {
                $res_ .= '<option selected="selected" value="' . $c . '">' . $value->pname . '</option>';
            } else {
                $res_ .= '<option  value="' . $c . '">' . $value->pname . '</option>';
            }
            //循环第一层
            $sql_e = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = $value->cid";
            $r_e = $db->select($sql_e);
            if ($r_e) {
                $hx = '-----';
                foreach ($r_e as $ke => $ve) {
                    $cone = $c . $ve->cid . '-';
                    //判断所属类别 添加默认标签
                    if ($product_class == $cone) {
                        $res_ .= '<option selected="selected" value="' . $cone . '">' . $hx . $ve->pname . '</option>';
                    } else {
                        $res_ .= '<option  value="' . $cone . '">' . $hx . $ve->pname . '</option>';
                    }
                    //循环第二层
                    $sql_t = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = $ve->cid";
                    $r_t = $db->select($sql_t);
                    if ($r_t) {
                        $hxe = $hx . '-----';
                        foreach ($r_t as $k => $v) {
                            $ctow = $cone . $v->cid . '-';
                            //判断所属类别 添加默认标签
                            if ($product_class == $ctow) {
                                $res_ .= '<option selected="selected" value="' . $ctow . '">' . $hxe . $v->pname . '</option>';
                            } else {
                                $res_ .= '<option  value="' . $ctow . '">' . $hxe . $v->pname . '</option>';
                            }
                        }
                    }
                }
            }
        }

        $request->setAttribute("class",$res_);
        $request->setAttribute("msg",$msg);
        $request->setAttribute("list",$res);
        $request->setAttribute("proattr",$result);
        $request->setAttribute("status_data",$status_data);
        $request->setAttribute("goods_id",$id);
        $request->setAttribute("sp_type",$sp_type);
        return View :: INPUT;
    }

    public function execute() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        // 接收信息
        $min_price = trim($request->getParameter('min_price'));// 砍价最低价
        $attrid = trim($request->getParameter('attrid'));// 商品属性ID
        $obj = json_decode($request->getParameter('obj')); // 砍价方式数据
        $status_data = json_decode($request->getParameter('status_data'));// 砍价方式数据
        $goods_id = $request->getParameter('goods_id');// 活动ID

        $log = new LaiKeLogUtils('common/bargain.log');// 日志

        $status_data = serialize($status_data);// 压缩砍价方式数据

        $id = $obj->id;
        if (!empty($obj->is_type)) {
            $obj->is_type = substr($obj->is_type, 0,strlen($obj->is_type)-1);
        }else{
            $obj->is_type = '';
        }
        
        $time = date('Y-m-d H:i:s');

        // 获取砍价结算时间
        $sel_cfg_sql = "select buy_time from lkt_bargain_config where 1";
        $cfg_res = $db->select($sel_cfg_sql);
        $buytime = $cfg_res[0]->buy_time;

        if (intval($attrid) > 0 && intval($min_price) > 0) {
            $sql = "update `lkt_bargain_goods` SET `goods_id`='$obj->goodsid', `attr_id`='$attrid', `is_type`='$obj->is_type', `min_price`='$min_price', `begin_time`='$obj->startdate', `end_time`='$obj->enddate', `buytime`='$buytime', `man_num`='$obj->barginman', `status_data`='$status_data', `is_show`='$obj->is_show', `addtime`='$time' WHERE `id`='$id' and store_id='$store_id'";
            $r = $db->update($sql);
            if ($r <= 0) {
                $log -> customerLog(__LINE__.":修改ID为【".$id."】的砍价活动失败：！$sql \r\n");
                $db->admin_record($store_id,$admin_name,'修改ID为【'.$id.'】的砍价活动失败！',2);
                echo json_encode(array('code' => 0));exit;
            }else{
                $log -> customerLog(__LINE__.":修改ID为【".$id."】的砍价活动成功！\r\n");
                $db->admin_record($store_id,$admin_name,'修改ID为【'.$id.'】的砍价活动成功！',2);
                echo json_encode(array('code' => 1));exit;
            }
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>