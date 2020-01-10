<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ResetAction extends Action{
	public function getDefaultView(){
        $db=DBAction::getInstance();
        $lktlog = new LaiKeLogUtils("common/Customer.log");
        // 1.开启事务
        $db->begin();

        $request=$this->getContext()->getRequest();

        $id = $request->getParameter("id");
        $password = md5($request->getParameter("password"));

        //根据id将管理员的密码重置
        $sql="update lkt_admin set password='$password',token = '' where id='$id'";
        $res=$db->update($sql);
        if($res == -1){
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 重置用户ID为'.$id.'密码失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            $r=array('status'=>'2','info'=>'重置用户ID为'.$id.'密码失败！');
            echo json_encode($r);exit;
        }else{
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 重置用户ID为'.$id.'密码成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            $r=array('status'=>'1','info'=>'重置密码成功！');
            echo json_encode($r);exit;
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