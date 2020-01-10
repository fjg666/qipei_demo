<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {

    //递归找上级
    public function str_option($level,$sid,$str_option,$num)
    {
        if($num > 0){
            $db = DBAction::getInstance();
            $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

            $sqlc = "select * from lkt_product_class where recycle = 0 and store_id = '$store_id' and cid = '$sid' order by sort desc";;
            $res = $db->select($sqlc);
            if($res){
                $sidc = $res[0]->sid; // 上级id
                $sqlcd = "select * from lkt_product_class where recycle = 0 and store_id = '$store_id' and sid = '$sidc' order by sort desc";
                $resc = $db->select($sqlcd);
                $str_option[$res[0]->cid] = $resc;
                $cnum = $num-1;
                return $this->str_option($level,$sidc,$str_option,$cnum);
            }else{
                return $str_option;
            }
        }else{
            return $str_option;
        }
    }

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

        // 接收分类id
        $cid = intval($request->getParameter("cid")); // 分类id

        // 根据分类id,查询产品分类表
        $sql = "select * from lkt_product_class where recycle = 0 and store_id = '$store_id' and cid = '$cid'";
        $r = $db->select($sql);
        $class = (object)array();
        if($r){
            $sid = $r[0]->sid; // 上级id
            $pname = $r[0]->pname; // 上级id
            $level = $r[0]->level; // 当前级别
            $r[0]->img = $r[0]->img ? ServerPath::getimgpath($r[0]->img,$store_id):'';
            $class = $r[0];
        }

        $str_option = array();
        $str_option1 = array();
        if($level >= 1){
            $str_option = $this->str_option($level,$sid,$str_option,$level);
            foreach ($str_option as $k => $v){
                foreach ($v as $ke => $va){
                    if($pname == $va->pname){
                        unset($str_option[$k][$ke]);
                    }else{
                        $str_option1[$k][] = $va;
                    }
                }
            }
        }else{
            $sqlcd = "select * from lkt_product_class where recycle = 0 and store_id = '$store_id' and sid = '0' order by sort desc";
            $resc = $db->select($sqlcd);
            $str_option[0] = $resc;
            foreach ($str_option[0] as $k => $v){
                if($pname == $v->pname){
                    unset($str_option[0][$k]);
                }else{
                    $str_option1[0][] = $v;
                }
            }
        }

        $level_list = Tools::data_dictionary($db,'商品分类',$level+1);
        $del_str = $this->getContext()->getStorage()->read('del_str');

        $request->setAttribute("str_option",json_encode($str_option1));
        $request->setAttribute("class",$class);
        $request->setAttribute('level_list', $level_list);
        $request->setAttribute("del_str",$del_str);
        return View :: INPUT;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/product_class.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

        $cid = intval($request->getParameter('cid')); // 分类id
        $level = $request->getParameter('level');
        $class = $request->getParameter('class');
        $sid = $class['sid'];

        if($class['pname'] == ''){
            echo json_encode(array('status' =>'产品分类名称不能为空！' ));exit;
        }else{
           $class['pname'] = addslashes($class['pname']); 
        }
        
        if($class['img']){
            $class['img'] = preg_replace('/.*\//','',$class['img']);
        }

        $pname = $class['pname'];

        $select =  $request->getParameter('select');

        if($level == 0){
            echo json_encode(array('status' =>'请选择分类级别！' ));exit;
        }else if($level == 1){
            $class['sid'] = '0';
            $class['level'] = '0';
        }else{
            if($select){
                foreach ($select as $k => $v) {
                    if($select[$k] == 0){
                        echo json_encode(array('status' =>'请选择上级分类！' ));exit;
                    }
                    $class['sid'] = $select[$k];
                }
            }
            $class['level'] = $level-1;
        }
        if($cid == $sid){
            echo json_encode(array('status' =>'产品分类不能选择自己！' ));exit;
        }

        if($class['level'] == 0){
            $class['sid'] = '0';
        }

        //检查分类名是否重复
        $sql = "select cid from lkt_product_class where recycle = 0 and store_id = '$store_id' and pname = '$pname' and cid <> '$cid' and sid='".$class['sid']."' order by sort desc";
        $r = $db->select($sql);
        if ($r) {
            echo json_encode(array('status' => "同级分类中已存在此分类(".$pname.")，请选用其他名称修改！"));exit;
        }

        $theme_data = $db->modify($class, 'lkt_product_class', " `store_id` = '$store_id' and `cid` = '$cid'");

        if($theme_data == -1) {
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改商品分类ID为'.$cid.'失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品分类ID为'.$cid.'失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>'未知原因，修改产品分类失败！' ));exit;
        } else {
            $this->found();
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改商品分类ID为'.$cid.'成功',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改商品分类ID为'.$cid.'成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '修改产品分类成功！','suc'=>'1'));exit;
        }
        return;
    }

    public function found($sid = 0,$level = 0){
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

        $sql = "select * from lkt_product_class where recycle = 0 and store_id = '$store_id' and sid = '$sid' order by sort desc ";
        $rr = $db->select($sql);
        foreach ($rr as $k => $v){
            $cid = $v->cid;
            $sql = "update lkt_product_class set level='$level' where recycle = 0 and store_id = '$store_id' and cid = '$cid' order by sort desc";
            $db->update($sql);
            $uplevel = $level+1;
            $this->found($cid,$uplevel);
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>