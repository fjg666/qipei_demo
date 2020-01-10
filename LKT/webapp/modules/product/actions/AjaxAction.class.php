<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class AjaxAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  14:35
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $m = addslashes(trim($request->getParameter('m'))); // 属性
        $class_str = addslashes(trim($request->getParameter('class_str'))); // 分类ID
        $brand_id = addslashes(trim($request->getParameter('brand_str'))); // 品牌ID

        if($m){
            if($m == 'attribute'){

                $strArr = $request->getParameter('strArr'); // 属性
                $attribute = Tools::attribute($db, '属性名');

                $rew = array();
                $arr = array();
                $arr2 = array();
                $arr3 = array();
                if($strArr != ''){
                    // 获取属性名和属性值
                    foreach ($strArr as $k => $v){
                        foreach ($v['attr_list'] as $k1 => $v1){
                            $arr2[] = array($v['attr_group_name'],$v1['attr_name']);
                        }
                    }

                    // 将二维数组某一个字段相同的数组合并起来的方法
                    foreach ($arr2 as $k => $v) {
                        $arr3[$v[0]][] = $v[1];
                    }
                    // 去重
                    foreach ($arr3 as $k => $v) {
                        $arr[$k] = array_unique($v);
                    }
                    foreach ($arr as $k => $v) {
                        $rew[$k] = Tools::attribute_name($db, '属性值',$k,$v);
                    }
                    echo json_encode(array('attribute'=>$attribute,'rew'=>$rew));
                    exit;
                }else{
                    echo json_encode(array('attribute'=>$attribute));
                    exit;
                }
            }else if($m == 'attribute_name'){
                $attribute_name = addslashes(trim($request->getParameter('attribute_name'))); // 属性名

                $attribute_value = Tools::$m($db, '属性值',$attribute_name);

                echo json_encode(array('attribute_value'=>$attribute_value));
                exit;
            }
        }
        $list = array();
        $id = 0;
        if($class_str == '0'){ // 没有选择分类
            // 获取产品类别
            $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc";
            $r0 = $db->select($sql0);
            if($r0){
                foreach ($r0 as $k => $v){
                    if($k == 0){
                        $r0[$k]->status = true;
                    }else{
                        $r0[$k]->status = false;
                    }
                }
                $list[] = $r0;
                $id = $r0[0]->cid;
            }
        }else{ // 选择了分类
            $list1 = array();
            // 获取产品类别
            $sql0_0 = "select cid,sid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$class_str' order by sort desc";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                $sid = $r0_0[0]->sid; // 上级ID
            }
            // 根据分类ID，查询下级
            $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$class_str' order by sort desc";
            $r0 = $db->select($sql0);
            if($r0){ // 有下级
                foreach ($r0 as $k => $v){
                    $r0[$k]->status = false;
                }
                $list1[] = $r0;
            }else{ // 没有下级
                // 根据分类上级ID查询同级
                $sql1 = "select cid,sid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$sid' order by sort desc";
                $r1 = $db->select($sql1);
                $id = $class_str;
                if($r1){
                    foreach ($r1 as $k => $v){
                        if($v->cid == $class_str){
                            $r1[$k]->status = true;
                        }else{
                            $r1[$k]->status = false;
                        }
                    }
                }
                $list1[] = $r1;
            }
            $res = $this->superior($sid,$list1);
            if($res != array()){
                $num = count( $res['list']) - 1;
                $list[] = $res['list'][$num];
                $id = $res['id'];
            }else{
                $list = $list1;
                $id = $class_str;
            }
        }
        $brand_list1 = array('brand_id'=>'0','brand_name'=>'请选择商品品牌');
        $brand_sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%,$id,%' order by sort desc";
        $brand_list = $db->select($brand_sql);
        array_unshift($brand_list,(object)$brand_list1);

        if($brand_id != 0 || $brand_id != ''){
            foreach($brand_list as $k => $v){
                if($brand_id == $v->brand_id){
                    $brand_list[$k]->status = true;
                }else{
                    $brand_list[$k]->status = false;
                }
            }
        }

        echo json_encode(array('class_list'=>$list,'brand_list'=>$brand_list));
        exit;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

//        $level = addslashes(trim($request->getParameter('level'))); // 级别
        $cid = addslashes(trim($request->getParameter('cid'))); // 参数
        $brand_id = addslashes(trim($request->getParameter('brand_str'))); // 品牌ID

        $list = array();
        $id = 0;
        $pname = '';
        // 查询下级
        $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$cid' order by sort desc";
        $r0 = $db->select($sql0);
        if($r0){ // 有下级
            foreach ($r0 as $k => $v){
                $r0[$k]->status = false;
            }
            $list[] = $r0;
        }else{ // 没有下级
            $sql1 = "select cid,sid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid'";
            $r1 = $db->select($sql1);
            if($r1){
                $id = $r1[0]->cid;
                $pname = $r1[0]->pname;
            }
        }

        $sql2 = "select sid,cid from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid'";
        $r2 = $db->select($sql2);
        if($r2){
            $sid = $r2[0]->sid; // 上级ID
            if($sid == 0){
                $cid = $r2[0]->cid;
            }else{
                $Tools = new Tools($db, $store_id, 1);
                $res = $Tools->str_option($sid);
                $res = explode('-',trim($res,'-'));
                $cid = $res[0];
            }
        }
        $brand_list1 = array('brand_id'=>'0','brand_name'=>'请选择商品品牌');
        $brand_sql = "select brand_id,brand_name from lkt_brand_class where store_id = '$store_id' and recycle = 0 and status = 0 and categories like '%,$cid,%' order by sort desc";
        $brand_list = $db->select($brand_sql);
        array_unshift($brand_list,(object)$brand_list1);
        if($brand_id != 0 || $brand_id != ''){
            foreach($brand_list as $k => $v){
                if($brand_id == $v->brand_id){
                    $brand_list[$k]->status = true;
                }else{
                    $brand_list[$k]->status = false;
                }
            }
        }

        echo json_encode(array('class_list'=>$list,'class_id'=>$id,'class_name'=>$pname,'brand_list'=>$brand_list));
        exit;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 查询分类上级
    public function superior($cid,$list){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $arr = array();
        // 根据id，查询分类
        $sql0 = "select cid,sid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid = '$cid' ";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->cid;
            $sid = $r0[0]->sid;
            $pname = $r0[0]->pname;
            $level = $r0[0]->level;
            $arr['id'] = $id;
            if($level != 0){ // 当不是1级分类
                // 获取产品类别
                $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = '$sid' order by sort desc";
                $r0 = $db->select($sql0);
                if($r0){
                    foreach ($r0 as $k => $v){
                        if($v->cid == $cid){
                            $r0[$k]->status = true;
                        }else{
                            $r0[$k]->status = false;
                        }
                    }
                    array_unshift($list,$r0);
                }
                $res = $this->superior($sid,$list);
                $arr['id'] = $res['id'];
                $arr['list'] = $res['list'];
            }else{ // 当是1级分类
                // 获取产品类别
                $sql0 = "select cid,pname,level from lkt_product_class where store_id = '$store_id' and recycle = 0 and sid = 0 order by sort desc";
                $r0 = $db->select($sql0);
                if($r0){
                    foreach ($r0 as $k => $v){
                        if($v->cid == $cid){
                            $r0[$k]->status = true;
                        }else{
                            $r0[$k]->status = false;
                        }
                    }
                    array_unshift($list,$r0);
                }
                $arr['list'] = $list;
            }
        }
        return $arr;
    }
}
?>