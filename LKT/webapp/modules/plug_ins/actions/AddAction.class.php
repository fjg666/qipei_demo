<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/plug_ins.log");
        // 1.开启事务
        $db->begin();

		$request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收数据 
        $name = addslashes(trim($request->getParameter('name'))); // 插件名称
        $Identification = addslashes(trim($request->getParameter('Identification'))); // 标识
        $sort = trim($request->getParameter('sort')); // 排序

        if($name){
            // 根据插件名称查询插件表
            $sql = "select * from lkt_plug_ins where name = '$name'";
            $r = $db->select($sql);
            if($r){
                echo json_encode(array('status' =>'插件'.$name.'已存在！' ));exit;
            }
        }else{
            echo json_encode(array('status' =>'插件名称不能为空！' ));exit;
        }
        if($Identification){
            // 根据插件名称查询插件表
            $sql = "select * from lkt_plug_ins where Identification = '$Identification'";
            $r = $db->select($sql);
            if($r){
                echo json_encode(array('status' =>'插件标识'.$Identification.'已存在！' ));exit;
            }
        }else{
            echo json_encode(array('status' =>'插件标识不能为空！' ));exit;
        }
        if(floor($sort) == $sort){
            // 添加插件
            $sql = "insert into lkt_plug_ins(name,Identification,add_time,sort) " .
                "values('$name','$Identification',CURRENT_TIMESTAMP,'$sort')";
            $r = $db->insert($sql);
            if($r == -1){
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加插件 '.$name.'失败',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加插件 '.$name.'失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;
            }else{
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加插件 '.$name.'成功',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加插件 '.$name.'成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '添加成功！','suc'=>'1'));exit;
            }
        }else{
            echo json_encode(array('status' =>'排序不为整数！' ));exit;
        }

	    return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}

}

?>