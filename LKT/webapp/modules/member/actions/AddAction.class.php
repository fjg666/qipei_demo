<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {
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
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员id
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $customer_number = '';
        $sql0 = "select customer_number from lkt_customer where id = '$store_id'";
        $r0 = $db->select($sql0);
        if($r0){
            $customer_number = $r0[0]->customer_number;
        }
        $rew = "<option value='0'>请选择</option>";
        // 查询角色
        $sql = "select * from lkt_role where status = 0 and store_id = '$store_id'";
        $r_1 = $db->select($sql);

        if($r_1){
            foreach ($r_1 as $k => $v){
                $rew .= "<option value='$v->id'>$v->name</option>";
            }
        }
        $request->setAttribute("customer_number",$customer_number);
        $request->setAttribute("list",$rew);
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
        // 接收数据
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $mch_id = $this->getContext()->getStorage()->read('mch_id'); // 店铺ID

        $name = addslashes(trim($request->getParameter('name'))); // 管理员账号
        $password = MD5(addslashes(trim($request->getParameter('password')))); // 密码
        $password1 = MD5(addslashes(trim($request->getParameter('password1')))); // 确认密码
        $role = addslashes(trim($request->getParameter('role'))); // 角色
        $log = new LaiKeLogUtils('common/member.log');
        if($name == ''){
            echo json_encode(array('status' =>'管理员名称不能为空！' ));exit;
        }

        //检查是否重复
        $s = "select * from lkt_admin where store_id = '$store_id' and name = '$name' and recycle = 0";
        $sr = $db->insert($s);
        if($sr && count($sr) > 0){
            echo json_encode(array('status' =>'管理员名称已经存在！' ));exit;
        }else{
            if(strlen(addslashes(trim($request->getParameter('password')))) < 6){
                echo json_encode(array('status' =>'管理员密码不能低于6位！' ));exit;
            }
            if($password == $password1){
                if ($role == 0) {
                    echo json_encode(array('status' =>'请选择角色！' ));exit;
                } else {
                    if($store_id == ''){
                        $sql = "insert into lkt_admin(sid,name,password,role,type,store_id,shop_id,status,add_date,recycle) values('$admin_id','$name','$password','$role',0,'$store_id','$mch_id',2,CURRENT_TIMESTAMP,0)";
                    }else{
                        $sql = "insert into lkt_admin(sid,name,password,role,type,store_id,shop_id,status,add_date,recycle) values('$admin_id','$name','$password','$role',2,'$store_id','$mch_id',2,CURRENT_TIMESTAMP,0)";
                    }
                    $r = $db->insert($sql);
                    if ($r == -1) {
                        $log -> customerLog(__LINE__.':添加管理员失败，sql为：'.$sql."\r\n");
                        $db->admin_record($store_id,$admin_name,'添加管理员失败',1);
                        echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;
                    } else {
                        $db->admin_record($store_id,$admin_name,'添加管理员'.$name,1);

                        echo json_encode(array('status' =>'添加成功！' ,'suc'=>'1'));exit;
                    }
                }
            }else{
                echo json_encode(array('status' =>'确认密码不正确！' ));exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>