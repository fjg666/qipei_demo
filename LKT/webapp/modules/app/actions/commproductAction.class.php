<?php

/**
 * <p>Copyright (c) 2019-2020</p>
 * <p>Company: www.laiketui.com</p>
 * @author 熊孔钰
 * @content 分销商城接口
 * @date 2019年9月29日
 * @version 1.0
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class commproductAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();
        return;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 第一次加载
    public function getstart(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        
        // 查询出所有分销等级
        $sql_1 = "select id,sets from lkt_distribution_grade where store_id = '$store_id' order by sort asc";
        $list = $db->select($sql_1);
        foreach ($list as $k => $v) {// 循环分销等级
            $sets = unserialize($v->sets);
            $list[$k]->levelname = $sets['s_dengjiname'];// 等级名称
            // 查询出当前等级分销商品
            $sql_2 = "select a.id,a.product_title,a.subtitle,a.imgurl,volume,min(c.price) as price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.is_distribution=1 and a.distributor_id=".$v->id." and a.status = 2 and a.mch_status = 2 group by c.pid  order by a.add_date desc LIMIT 0,10";
            $r_2 = $db->select($sql_2);
            foreach ($r_2 as $kk => $vv) {
                $imgurl = ServerPath::getimgpath($vv->imgurl);// 商品图
                $r_2[$kk] = array('id' => $vv->id,'name' => $vv->product_title,'subtitle'=>$vv->subtitle,'price' => $vv->yprice,'price_yh' => $vv->price,'imgurl' => $imgurl,'size'=>$vv->sizeid,'volume' => $vv->volume,'s_type' => $vv->s_type);// 存数据
            }
            $list[$k]->sonlist = $r_2;
        }

        // 查询普通会员商品
        $list2[0] = (object)array('id' => 0, 'levelname' => '会员商品');
        $sqll = "select a.id,a.product_title,a.subtitle,a.imgurl,volume,min(c.price) as price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.is_distribution=1 and a.distributor_id=0 and a.status = 2 and a.mch_status = 2 group by c.pid  order by a.add_date desc LIMIT 0,10";
        $rr = $db->select($sqll);
        foreach ($rr as $k => $v) {
            $imgurl = ServerPath::getimgpath($v->imgurl);// 商品图
            $rr[$k] = array('id' => $v->id,'name' => $v->product_title,'subtitle'=>$v->subtitle,'price' => $v->yprice,'price_yh' => $v->price,'imgurl' => $imgurl,'size'=>$v->sizeid,'volume' => $v->volume,'s_type' => $v->s_type);// 存数据
        }
        $list2[0]->sonlist = $rr;

        // 普通会员商品数据与分销等级数组合并
        $list = array_merge($list2,$list);

        echo json_encode(array('code'=>200,'pro'=>$list,'message'=>'成功'));
        exit;
    }
    // 后续加载
    public function listdetail(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        // 接收参数
        $distributor_id = trim($request->getParameter('distributor_id'));// 查询分销等级ID
        $paegr = trim($request->getParameter('page')); // 页码
        $pagesize = 10;
        if(!$paegr || intval($paegr) < 1){$paegr = 1;}
        $start = ($paegr-1)*$pagesize;

        $c = '';
        if (!empty($distributor_id) || $distributor_id == 0) {
            $c = " and a.distributor_id = ".$distributor_id;
        }
        // 查询相应等级下商品
        $sql = "select a.id,a.product_title,a.subtitle,a.imgurl,volume,min(c.price) as price,c.yprice,c.img,c.name,c.color,c.size,a.s_type,c.id AS sizeid from lkt_product_list AS a RIGHT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.is_distribution=1 and a.status = 2 and a.mch_status = 2 ".$c." group by c.pid  order by a.add_date desc LIMIT $start,$pagesize ";
        $r = $db->select($sql);
        if($r){
            $product = [];
            foreach ($r as $k => $v) {
                $imgurl = ServerPath::getimgpath($v->imgurl);// 商品图
                $product[$k] = array('id' => $v->id,'name' => $v->product_title,'subtitle'=>$v->subtitle,'price' => $v->yprice,'price_yh' => $v->price,'imgurl' => $imgurl,'size'=>$v->sizeid,'volume' => $v->volume,'s_type' => $v->s_type);
            }
            echo json_encode(array('code'=>200,'pro'=>$product,'message'=>'成功'));
            exit;
        }else{
            echo json_encode(array('code'=>102,'message'=>'没有更多商品了！'));
            exit;
        }
    }
}

?>