<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        // 接收信息
        $id = intval($request->getParameter("id")); // 产品id

        $sql = "select * from lkt_freight where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $sel_city_arr = array();
        if($r){
            $name = $r[0]->name; // 规则名称
            $type = $r[0]->type; // 规则类型
            $freight = unserialize($r[0]->freight); // 属性
            $res = '';
            if($freight){
                foreach ($freight as $k => $v){
                    $k1 = $k + 1;
                    $res .= "<tr class='tr_freight_num' id='tr_freight_$k1'>" .
                                "<td>".$v['one']."</td>" .
                                "<td>".$v['two']."</td>" .
                                "<td>".$v['three']."</td>" .
                                "<td>".$v['four']."</td>" .
                                "<td>".$v['name']."</td>" .
                                "<td><span class='btn btn-secondary radius' onclick='freight_del($k1)' >删除</span></td>" .
                            "</tr>";
                    $city_arr = explode('&nbsp;&nbsp;,&nbsp;&nbsp;',$v['name']);
                    $city_arr_str = "";

                    foreach ($city_arr as $k_ => $v_){
                        $city_arr_str .= $v_."','";
                    }

                    $city_arr_str = "'".substr($city_arr_str,0,-12)."'";

                    $sel_city_id_sql = "select GroupID from admin_cg_group where G_CName in ($city_arr_str)";
                    $sel_city_id_res = $db->select($sel_city_id_sql);

                    $sel_city_id_str = '';
                    foreach ($sel_city_id_res as $kk => $vv){
                        $sel_city_id_str .= $vv->GroupID.',';
                    }
                    if($sel_city_id_str != ''){
                        $sel_city_arr[$k] = $sel_city_id_str;
                    }
                }
                $freight = json_encode($freight);
            }
        }
        $sel_city_arr = json_encode($sel_city_arr);
        $request->setAttribute("sel_city_arr",$sel_city_arr);
        $request->setAttribute("id",$id);
        $request->setAttribute("name",$name);
        $request->setAttribute("type",$type);
        $request->setAttribute("freight",$freight);
        $request->setAttribute("list",$res);

        return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/freight.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收数据
        $id = addslashes(trim($request->getParameter('id'))); // 规则id
        $name = addslashes(trim($request->getParameter('name'))); // 规则名称
        $type = addslashes(trim($request->getParameter('type'))); // 类型
        $hidden_freight = $request->getParameter('hidden_freight'); // 运费信息

        if($hidden_freight){
            $freight_list = json_decode($hidden_freight,true);
            if(empty($freight_list)){
               echo json_encode(array('status' =>'运费规则不能为空！' ));exit;
            }
            foreach ($freight_list as $k => $v){
                if(strstr($v['name'], '&nbsp;')){

                }else{
                    $freight_list1 = explode(',',$v['name']);
                    $freight_list2 = array();
                    foreach ($freight_list1 as $k1 => $v1){
                        if($k1 == 0){
                            $freight_list2[] = substr($v1,0,-4);
                        }else{
                            $freight_list2[] = substr($v1,4,-4);
                        }
                    }
                    $freight_list[$k]['name'] = implode('&nbsp;&nbsp;,&nbsp;&nbsp;',$freight_list2);
                }
            }
            $freight = serialize($freight_list);
        }else{
            echo json_encode(array('status' =>'运费规则不能为空！' ));exit;
        }
        
        if($name == ''){
        	echo json_encode(array('status' => '规则名称不能为空！'));exit;
        }else{
            $sql = "select * from lkt_freight where store_id = '$store_id' and id != '$id' and name = '$name'";
            $r = $db->select($sql);
            if($r){
                echo json_encode(array('status' => '规则名称 {$name} 已经存在，请选用其他名称！'));exit;
            }
        }

        $sql = "update lkt_freight set name = '$name',type = '$type',freight = '$freight' where id = '$id'";
        $rr = $db->update($sql);
        if($rr == -1){
            $JurisdictionAction->admin_record($store_id,$admin_name,' 修改规则ID为 '.$id.' 失败 ',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . '  修改规则ID为 '.$id.' 失败 ';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' =>'未知原因，规则修改失败！' ));exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,' 修改规则ID为 '.$id.' 的信息 ',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改规则ID为 '.$id.' 的信息 ';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '规则修改成功！','suc'=>'1'));exit;
        }
		return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}
}
?>