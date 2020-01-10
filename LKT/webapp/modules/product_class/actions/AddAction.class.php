<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {
    //递归找上级
    public function str_option($level,$sid,$str_option,$num){
        if($num >= 0){
            $db = DBAction::getInstance();
            $store_id = $this->getContext()->getStorage()->read('store_id'); // 项目id

            $sqlc = "select sid,cid,pname from lkt_product_class where recycle = 0 and store_id = '$store_id' and cid = '$sid'";
            $res = $db->select($sqlc);
            if($res){
                $sidc = $res[0]->sid; // 上级id
                $sqlcd = "select sid,cid,pname from lkt_product_class where recycle = 0 and store_id = '$store_id' and sid = '$sidc'";
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
        $superCid = intval($request->getParameter("superCid")); // 父分类id
        $level = 0;
        // 根据分类id,查询产品分类表
        $sql = "select * from lkt_product_class where recycle = 0 and store_id = '$store_id' and cid = '$cid'";
        $r = $db->select($sql);
        if($r){
            $sid = $r[0]->sid; // 上级id
            $level = $r[0]->level+2;
        }

        $str_option = array();
        if($level >= 1){
            $str_option = $this->str_option($level,$cid,$str_option,$level);
        }else{
            $sqlcd = "select * from lkt_product_class where recycle = 0 and store_id = '$store_id' and sid = '0'";
            $resc = $db->select($sqlcd);
            $str_option[$cid] = $resc;
        }
        $level_list = Tools::data_dictionary($db,'商品分类',$level);
        $json = json_encode($str_option);

        $request->setAttribute('cid', $cid);
        $request->setAttribute("str_option",$json);
        $request->setAttribute('level', $level);
        $request->setAttribute('superCid', $superCid);
        $request->setAttribute('level_list', $level_list);
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
        // 获取分类名称和排序号
        $cid = intval($request->getParameter("cid")); // 分类id
        $level = $request->getParameter('level');
        $level_1 = $request->getParameter('level_1');
        $class = $request->getParameter('class');
        $select = $request->getParameter('select');
        if($cid != 0){
            $level = $level_1;
        }
        if($class['pname'] == ''){
            echo json_encode(array('status' =>'产品分类名称不能为空！' ));exit;
        }else{
            $class['pname'] = addslashes($class['pname']);
        }

        if($class['img']){
            $class['img'] = preg_replace('/.*\//','',$class['img']);
        }

        $pname = $class['pname'];

        if($level == 0){
            echo json_encode(array('status' =>'请选择分类级别！' ));exit;
        }else if($level == 1){
            $class['sid'] = 0;
            $class['level'] = 0;
        }else{
            if($select){
                foreach ($select as $k => $v) {
                    if($select[$k] == 0){
                        echo json_encode(array('status' =>'请选择上级分类！' ));exit;
                    }
                    $class['sid'] = $select[$k];
                }
            }else{
                $class['sid'] = $cid;
            }
            $class['level'] = $level-1;
        }
        if($class['level'] == 0){
            $class['sid'] = 0;
        }

        //检查分类名是否重复
        $sql = "select cid from lkt_product_class where recycle = 0 and store_id = '$store_id' and pname = '$pname' and sid='".$class['sid']."' order by sort desc";
        $r = $db->select($sql);
        if ($r) {
            echo json_encode(array('status' => "同级分类中已存在此分类(".$pname.")，请选用其他名称修改！"));exit;
        }

        $class['store_id'] = $store_id;
        $class_res = $db->insert_array($class, 'lkt_product_class');

        if($class_res == -1) {
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加商品分类失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商品分类失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>'未知原因，添加产品分类失败！' ));exit;
        } else {
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加商品分类成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加商品分类成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' =>'添加产品分类成功！','suc'=>"1" ));exit;
        }
        return;
    }


    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>