<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/RedisClusters.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');



class ModifyAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $m = $request->getParameter('m');//请求类型
        $activity_id = $request->getParameter('activity_id');//活动id
        $time_id = $request->getParameter('time_id');//时段id
        if($m != '' && !empty($m)){
            $this->$m();
            exit;
        }
        //查询活动列表数据

        $sql = "SELECT * FROM `lkt_seconds_activity` WHERE 1 and store_id = $store_id and is_delete = 0";
        $res = $db->select($sql);
        $res_str = json_encode($res);
        $request->setAttribute("list",$res_str);
        $request->setAttribute("activity_id",$activity_id);
        $request->setAttribute("time_id",$time_id);
        $request->setAttribute("pages_show",1);
        return View :: INPUT;
    }

    /**
     * 获取时段列表数据
     */
    public function axios(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $activity_id = $request->getParameter('activity_id');//活动id
        $time_id = $request->getParameter('time_id');//时段id

        //查询商品分类
        $sql01 = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 ";
        $rr = $db->select($sql01);
        $res_ = '';
        $k = 0;
        $res = array();
        $ress = array();
        //循环商品分类
        foreach ($rr as $key => $value) {
            $c = '-' . $value->cid . '-';
            //判断所属类别 添加默认标签

            array_push($ress,array('name'=>$value->pname,'value'=>$c,'k'=>$k));
            //循环第一层
            $sql_e = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = $value->cid";
            $r_e = $db->select($sql_e);
            if ($r_e) {
                $hx = '-----';
                foreach ($r_e as $ke => $ve) {
                    $cone = $c . $ve->cid . '-';
                    //判断所属类别 添加默认标签

                    array_push($ress,array('name'=>$hx .$ve->pname,'value'=>$cone,'k'=>$k));

                    //循环第二层
                    $sql_t = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = $ve->cid";
                    $r_t = $db->select($sql_t);
                    if ($r_t) {
                        $hxe = $hx . '-----';
                        foreach ($r_t as $k => $v) {
                            $ctow = $cone . $v->cid . '-';
                            //判断所属类别 添加默认标签

                            array_push($ress,array('name'=>$hxe . $v->pname,'value'=>$ctow,'k'=>$k));

                        }
                    }
                }
            }
        }

        //查询商品属性
        $prosql = "select b.num,b.min_inventory,a.attribute,min(a.price) as price,a.id as attr_id,b.id,b.product_title,b.imgurl,c.name 
                from lkt_configure as a 
                left join lkt_product_list as b on a.pid = b.id 
                left join lkt_mch as c on b.mch_id = c.id  
                where  b.active = 8 and b.status = 2 and b.recycle = 0  
                and b.id not in (SELECT pro_id from lkt_seconds_pro where store_id = 1 and is_delete = 0 and activity_id = $activity_id and time_id = $time_id)
                group by b.id
                order by a.price desc";
        $proattr = $db -> select($prosql);
        //判断是否有数据
        if(!empty($proattr)){
            foreach ($proattr as $k => $v) {
                $attrtype1 = unserialize($v -> attribute);
                $attrtype1 = array_values($attrtype1);
                $attrtype1 = implode(',', $attrtype1);

                $proattr[$k] -> attrtype = $attrtype1;
                $proattr[$k]->imgurl = ServerPath::getimgpath($v->imgurl);
                //查询是否有这个属性
                $sel_hava_attr_sql = "select * from lkt_group_product where store_id = $store_id and is_delete = 0 and attr_id = $v->attr_id";
                $sel_hava_attr_res = $db->select($sel_hava_attr_sql);
                if($sel_hava_attr_res){
                    $proattr[$k]->select = true;
                }else{
                    $proattr[$k]->select = false;
                }
            }
        }

        $ret['classList'] = $ress;
        $ret['prolist'] = $proattr;

        echo json_encode($ret);
    }

    /*
     * 查询商品分类
     */
    public function pro_brand1(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = $this->getContext()->getStorage()->read('store_id');
        $cid = addslashes(trim($request->getParameter('cid')));//产品分类id
        $activity_id = $request->getParameter('activity_id');//活动id
        $time_id = $request->getParameter('time_id');//时段id

        //查询品牌
        $sql = "select b.brand_id,b.brand_name 
        from lkt_brand_class as b 
        right join lkt_product_list as p on p.brand_id=b.brand_id 
        where p.store_id='$store_id' and p.status=2 and p.active = 8 and p.product_class like '%$cid%'
        ";
//        and b.id not in (SELECT pro_id from lkt_seconds_pro where store_id = 1 and is_delete = 0 and activity_id = $activity_id and time_id = $time_id)

        $res = $db->select($sql);
        if (!empty($res)) {
            $arr = array();
            foreach ($res as $key => $value) {
                if (in_array($value -> brand_id, $arr)) {
                    unset($res[$key]);
                } else {
                    $arr[] = $value -> brand_id;
                }
            }
        }else{
            $res = array();
        }

        echo json_encode($res);
        exit;

    }

    // 获取品牌
    public function pro_brand(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $cid = $request->getParameter('cid');// 分类ID

        $cid = explode('-',$cid);
        $cids = '';
        foreach ($cid as $k => $v) {
            if(!empty($v)){
                $cids .= $v.',';
            }
        }

        // 查询此分类下品牌
        $sql = "select brand_id,brand_name 
        from lkt_brand_class 
        where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%$cids%' 
        order by sort desc";
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

    /**
     * 查询出拼团商品
     */
    public function pro_query(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_id = $this->getContext()->getStorage()->read('store_id');
        $my_class = addslashes(trim($request->getParameter('my_class')));
        $my_brand = addslashes(trim($request->getParameter('my_brand')));
        $pro_name = addslashes(trim($request->getParameter('pro_name')));
        $activity_id = $request->getParameter('activity_id');//活动id
        $time_id = $request->getParameter('time_id');//时段id


        $condition = ' and b.recycle = 0 ';
        if($my_class){
            $condition .= " and b.product_class like '%{$my_class}%' ";
        }
        if($my_brand){
            $condition .= " and b.brand_id = '$my_brand' ";
        }
        if($pro_name){
            $condition .= " and b.product_title like '%{$pro_name}%' ";
        }


        //查询商品属性数据
        $sql = "select b.num,b.min_inventory,a.attribute,min(a.price) as price,a.id as attr_id,b.id,b.product_title,b.imgurl,c.name 
                from lkt_configure as a 
                left join lkt_product_list as b on a.pid = b.id 
                left join lkt_mch as c on b.mch_id = c.id  
                where  b.active = 8 and b.status = 2 and b.recycle = 0  ".$condition  ."
                and b.id not in (SELECT pro_id from lkt_seconds_pro where store_id = 1 and is_delete = 0 and activity_id = $activity_id and time_id = $time_id)
                group by b.id
                order by a.price desc";
        $res = $db->select($sql);
        //循环处理数据
        foreach($res as $k =>$v){
            $v->imgurl = ServerPath::getimgpath($v->imgurl,$store_id);
            $attr = unserialize($v->attribute);
            $attr = array_values($attr);
            if($attr){
                if (gettype($attr[0]) != 'string') unset($attr[0]);
            }
        }

        echo json_encode(array('res'=>$res));exit;

    }

    /*
     * 添加商品数据
     */
    public function save(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $price = $request->getParameter('price');//秒杀价格
        $num = $request->getParameter('num');//秒杀数量
        $proid = $request->getParameter('proid');//商品id
        $activity_id = $request->getParameter('activity_id');//活动id
        $time_id = $request->getParameter('time_id');//时段id
        $is_show = $request->getParameter('is_show');//是否显示 1显示 0不显示


        //事物开启
        $db->begin();
        $time =  date('Y-m-d 00:00:00', time());
        $ist_sql = "INSERT INTO `lkt_seconds_pro`( `store_id`,`pro_id`, `seconds_price`, `num`,`max_num`,`buy_num`,`activity_id`,`time_id`,`is_show`,`add_time`) VALUES ('$store_id','$proid','$price','$num','$num','1','$activity_id','$time_id','$is_show','$time')";
        $add_res = $db->insert($ist_sql);
//        $ret['sql'] = $ist_sql;
        $lktlog = new LaiKeLogUtils("common/seconds.log");

        //判断是否添加成功
        if($add_res > 0){
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加秒杀商品成功！");

            //秒杀数量 存入redis
            $redis = new RedisClusters();
            $re     = $redis->connect();

            $redis_name = "seconds_".$activity_id."_".$time_id."_".$proid;

            //清除之前的库存缓存
            $redis->remove($redis_name);

            for($i = 0;$i<$num;$i++){

                $aa = $redis->lpush($redis_name,1);

            }
            $redis->close();

            $db->commit();
            $ret['code'] = 1;
            $ret['msg'] = '添加商品成功！';
            $ret['redis_name'] = $redis_name;
            $ret['aa'] =$aa;
        }else{
            $lktlog->customerLog(__METHOD__ . ":" . __LINE__ . "添加秒杀商品失败！sql:".$ist_sql);
            $ret['code'] = 0;
            $ret['msg'] = '添加商品失败！';

            $db->rollback();
        }
        echo json_encode($ret);

    }

    public function execute() {
    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>