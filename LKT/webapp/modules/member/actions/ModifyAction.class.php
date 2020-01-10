<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  16:07
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员id
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = $request->getParameter("id");

        $customer_number = '';
        $sql0 = "select customer_number from lkt_customer where id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $customer_number = $r0[0]->customer_number;
        }

        // 根据id查询管理员信息
        $sql = "select * from lkt_admin where id = '$id'";
        $r = $db->select($sql);
        $name = $r[0]->name; // 管理员名称
        $admin_type = $r[0]->admin_type;
        $role = $r[0]->role; // 角色id
        $type = $r[0]->type; // 类型
        $rew = '';
        $r_id = 0;
        if($store_id != ''){
            // 根据角色id,查询角色信息
            $sql = "select * from lkt_role where id = '$role' and status = 0 and store_id = '$store_id'";
            $r_1 = $db->select($sql);
            $r_id = $r_1[0]->id; // 角色id
            $r_name = $r_1[0]->name; // 角色名称

            $rew = "<option selected='selected' value='$r_id'>$r_name</option>";
            // 查询角色
            $sql = "select * from lkt_role where id != '$role' and status = 0 and store_id = '$store_id'";
            $r_2 = $db->select($sql);
            if($r_2){
                foreach ($r_2 as $r_k => $r_v){
                    $rew .= "<option value='$r_v->id'>$r_v->name</option>";
                }
            }
        }

        $request->setAttribute('id', $id);
        $request->setAttribute("customer_number",$customer_number);
        $request->setAttribute('name', $name );
        $request->setAttribute('admin_type', $admin_type );
        $request->setAttribute('type', $type );
        $request->setAttribute('list', $rew);
        $request->setAttribute('role_id', $r_id);

        return View :: INPUT;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  16:07
     * @version 1.0
     */
    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $log = new LaiKeLogUtils('common/member.log');
        // 接收数据 
        $id = $request->getParameter("id");
        $name = addslashes(trim($request->getParameter('name')));
        $x_password = md5(addslashes(trim($request->getParameter('x_password'))));
//        $password = md5(addslashes(trim($request->getParameter('password'))));
        $role = addslashes(trim($request->getParameter('role'))); // 角色
        $role_id = addslashes(trim($request->getParameter('role_id'))); // 角色
        if($role == ''){
            $role = $role_id;
        }

        if(addslashes(trim($request->getParameter('x_password'))) != ''){ // 输入了新密码
            // 根据商城ID、管理员ID、管理员账号，查询管理员密码
            $sql = "select password from lkt_admin where store_id = '$store_id' and name='$name' and id = '$id'";
            $rr = $db->select($sql);
            if(empty($rr)){
                echo json_encode(array('status' =>'参数错误！' ));exit;
            }
            $password = $rr[0]->password;
            if($password == $x_password){
                echo json_encode(array('status' =>'新密码与原密码相同！' ));exit;
            }
            $sql = "update lkt_admin set password = '$x_password',role = '$role' where store_id = '$store_id' and name='$name' and id ='$id'";
        }else{
            //更新数据表
            $sql = "update lkt_admin set name='$name',role = '$role' where id ='$id'";
        }
        $r = $db->update($sql);
        if($r == -1) {
            $log -> customerLog(__LINE__.':删除管理员信息失败，sql为：'.$sql."\r\n");
            $db->admin_record($store_id,$admin_name,'修改管理员id为 '.$id.' 失败',2);

            echo json_encode(array('status' =>'未知原因，修改失败！' ));exit;

        } else {
            $db->admin_record($store_id,$admin_name,'修改管理员id为 '.$id.' 的信息',2);

            echo json_encode(array('status' =>'修改成功！' ,'suc'=>'1'));exit;
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>