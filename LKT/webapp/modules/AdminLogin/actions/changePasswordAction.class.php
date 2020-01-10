<?php
require_once(MO_LIB_DIR . '/version.php');

class changePasswordAction extends Action
{


    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员账号
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $y_password = md5(addslashes(trim($request->getParameter('oldPW'))));//原密码
        $password = md5(addslashes(trim($request->getParameter('newPW'))));//新密码

        // 根据id查询管理员信息
        $sql = "select * from lkt_admin where id = '$admin_id' and password = '$y_password'";
        $r = $db->select($sql);
        if (!$r) {
            $res = array('status' => '1', 'info' => '密码不正确！');
            echo json_encode($res);
            exit();
        }
        if (!empty($password) && $password != $y_password) {
            $sql01 = "update lkt_admin set password = '$password' where id = '$admin_id' ";

            $r01 = $db->update($sql01);
            if ($r01 == -1) {
                $db->admin_record($store_id, $admin_id, '修改管理员id为 '.$admin_id.'的密码失败', 2);

                $res = array('status' => '2', 'info' => '未知原因，修改失败!');
                echo json_encode($res);
                exit();
            } else {

                $db->admin_record($store_id, $admin_id, '修改管理员id为 '.$admin_id.'密码成功', 2);
                $res = array('status' => '3', 'info' => '修改成功！');
                echo json_encode($res);
                exit();
            }
        }

        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        return;
    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }

}

?>