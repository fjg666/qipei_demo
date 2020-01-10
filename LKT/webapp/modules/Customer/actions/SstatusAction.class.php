<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class SstatusAction extends Action
{
    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $lktlog = new LaiKeLogUtils("common/Customer.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $id = $request->getParameter("id");

        $time = date("Y-m-d H:i:s");

        $sql0 = "select status,end_date from lkt_customer where recycle = 0 and id = '$id' ";
        $r0 = $db->select($sql0);
        if($r0){
            $status = $r0[0]->status;
            $end_date = $r0[0]->end_date;
            if($status == 0){ // 当前商户为启用中
                // 根据商户ID，修改商户状态(锁定)
                $sql1 = "update lkt_customer set status = 2 where recycle = 0 and id = '$id' ";
                $db->update($sql1);

                $sql2 = "update lkt_admin set login_num = 3,status = 1 where store_id = '$id' ";
                $r2 = $db->update($sql2);
                if ($r2 == -1) {
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 锁定用户ID为'.$id.'失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    $r = array('status' => '2', 'info' => '锁定失败！');
                    echo json_encode($r);
                    exit;
                } else {
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 锁定用户ID为'.$id.'成功';
                    $lktlog->customerLog($Log_content);
                    $db->commit();

                    $r = array('status' => '1', 'info' => '锁定成功！');
                    echo json_encode($r);
                    exit;
                }
            }else if($status == 1){ // 当前商户为到期中
                // 根据商户ID，修改商户状态(启用)
                if($end_date <= $time){ // 过期
                    $r = array('status' => '2', 'info' => '已经过期！');
                    echo json_encode($r);
                    exit;
                }else{ // 未过期
                    $sql1 = "update lkt_customer set status = 0 where id = '$id' and recycle = 0";
                    $db->update($sql1);
                }
                $sql2 = "update lkt_admin set login_num = 0,status = 2 where store_id = '$id'";
                $r2 = $db->update($sql2);
                if ($r2 == -1) {
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 解锁用户ID为'.$id.'失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    $r = array('status' => '2', 'info' => '解锁失败！');
                    echo json_encode($r);
                    exit;
                } else {
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 解锁用户ID为'.$id.'成功';
                    $lktlog->customerLog($Log_content);
                    $db->commit();

                    $r = array('status' => '1', 'info' => '解锁成功！');
                    echo json_encode($r);
                    exit;
                }
            }else if($status == 2){ // 当前商户为锁定中
                // 根据商户ID，修改商户状态(启用)
                $sql1 = "update lkt_customer set status = 0 where recycle = 0 and id = '$id' ";
                $db->update($sql1);

                $sql2 = "update lkt_admin set login_num = 0,status = 2 where store_id = '$id'";
                $r2 = $db->update($sql2);
                if ($r2 == -1) {
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 锁定用户ID为'.$id.'失败';
                    $lktlog->customerLog($Log_content);
                    $db->rollback();

                    $r = array('status' => '2', 'info' => '解锁失败！');
                    echo json_encode($r);
                    exit;
                } else {
                    $Log_content = __METHOD__ . '->' . __LINE__ . ' 锁定用户ID为'.$id.'成功';
                    $lktlog->customerLog($Log_content);
                    $db->commit();

                    $r = array('status' => '1', 'info' => '解锁成功！');
                    echo json_encode($r);
                    exit;
                }
            }
        }
        return;
    }

    public function execute()
    {
        $this->getDefaultView();
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
}