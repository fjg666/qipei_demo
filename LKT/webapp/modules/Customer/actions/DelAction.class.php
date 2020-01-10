<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class DelAction extends Action{
	public function getDefaultView(){
        $db=DBAction::getInstance();
        $lktlog = new LaiKeLogUtils("common/Customer.log");
        // 1.开启事务
        $db->begin();

        $request=$this->getContext()->getRequest();
        $id = $request->getParameter("id");

        $sql0 = "update lkt_customer set recycle = 1 where id = '$id' ";
        $r0 = $db->update($sql0);
        if($r0 > 0){
            $sql1 = "update lkt_admin set recycle = 1 where store_id = '$id' ";
            $r1 = $db->update($sql1);

            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除商户ID为'.$id.'成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            $r=array('status'=>'1','info'=>'删除成功！');
            echo json_encode($r);
            exit;
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 删除商户ID为'.$id.'失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            $r=array('status'=>'2','info'=>'删除失败！');
            echo json_encode($r);
            exit;
        }
        return ;
	}
	public function execute(){
        $this->getDefaultView();
	}
	public function getRequestMethods(){
        return Request :: POST;
	}
}