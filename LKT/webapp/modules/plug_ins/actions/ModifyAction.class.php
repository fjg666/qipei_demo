<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $id = intval($request->getParameter("id")); // 插件id

        // 根据插件id，查询插件信息
        $sql = "select * from lkt_plug_ins where id = '$id'";
        $r = $db->select($sql);
        if($r){
            $name = $r[0]->name; // 插件名称
            $Identification = $r[0]->Identification; // 标识
            $sort = $r[0]->sort ; // 排序
        }

        $request->setAttribute('id', $id);
        $request->setAttribute('name', $name);
        $request->setAttribute('Identification', $Identification);
        $request->setAttribute('sort', $sort);
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

        // 接收信息
        $id = intval($request->getParameter('id'));
        $name = addslashes(trim($request->getParameter('name'))); // 插件名称
        $Identification = addslashes(trim($request->getParameter('Identification'))); // 标识
        $sort = trim($request->getParameter('sort')); // 排序


        if($name){
            $sql = "select * from lkt_plug_ins where name = '$name' and id != '$id'";
            $r = $db->select($sql);
            if($r){
                echo json_encode(array('status' =>'插件'.$name.'已存在！' ));exit;
            }
        }else{
            echo json_encode(array('status' =>'插件名称不能为空！' ));exit;
        }
        if($Identification){
            $sql = "select * from lkt_plug_ins where Identification = '$Identification' and id != '$id'";
            $r = $db->select($sql);
            if($r){
                echo json_encode(array('status' =>'插件标识'.$Identification.'已存在！' ));exit;
            }
        }else{
            echo json_encode(array('status' =>'插件标识不能为空！' ));exit;
        }

        if(floor($sort) == $sort){
            //更新数据表
            $sql = "update lkt_plug_ins set name = '$name',Identification='$Identification',add_time = CURRENT_TIMESTAMP,sort = '$sort' where id = '$id'";
            $r = $db->update($sql);

            if($r == -1) {
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改插件id为 '.$id.' 的信息失败',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改插件id为 '.$id.' 的信息失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'未知原因，修改失败！' ));exit;
            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改插件id为 '.$id.' 的信息成功',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改插件id为 '.$id.' 的信息成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '修改成功！','suc'=>'1'));exit;
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