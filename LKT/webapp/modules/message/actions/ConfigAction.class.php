<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class ConfigAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  16:07
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=message&action=List');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=message&action=Config');

        $sql = "select accessKeyId,accessKeySecret,SignName from lkt_message_config where store_id = '$store_id'";
        $r = $db->select($sql);

        $request->setAttribute("list",isset($r) ? $r : '');
        $request->setAttribute('button', $button);

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
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $accessKeyId = addslashes(trim($request->getParameter('accessKeyId'))); // accessKeyId
        $accessKeySecret = addslashes(trim($request->getParameter('accessKeySecret'))); // accessKeySecret

        $log = new LaiKeLogUtils('common/message.log');

        if($accessKeyId == ''){
            $log -> customerLog(__LINE__.":修改短信配置失败：accessKeyId不能为空！");
            echo json_encode(array('status' =>'accessKeyId不能为空！' ));exit;
        }
        if($accessKeySecret == ''){
            $log -> customerLog(__LINE__.":修改短信配置失败：accessKeySecret不能为空！");
            echo json_encode(array('status' =>'accessKeySecret不能为空！' ));exit;
        }
        // 根据商城id, 查询短信配置
        $sql = "select * from lkt_message_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){ // 存在 修改
            $sql = "update lkt_message_config set accessKeyId = '$accessKeyId',accessKeySecret = '$accessKeySecret',SignName = '$SignName',add_time = CURRENT_TIMESTAMP where store_id = '$store_id'";
            $rr = $db->update($sql);
            if($rr > 0){
                $db->admin_record($store_id,$admin_name,'修改短信设置成功',1);
                $log -> customerLog(__LINE__.":修改短信配置成功！");
                echo json_encode(array('status' =>'修改成功！' ,'suc'=>'1'));exit;
            }else{
                $db->admin_record($store_id,$admin_name,'修改短信设置失败',1);
                $log -> customerLog(__LINE__.":修改短信配置失败：$sql");
                echo json_encode(array('status' =>'未知原因，修改失败！' ));exit;
            }
        }else{ // 不存在 插入
            $sql = "insert into lkt_message_config(store_id,accessKeyId,accessKeySecret,add_time) values ('$store_id','$accessKeyId','$accessKeySecret',CURRENT_TIMESTAMP)";
            $rr = $db->insert($sql);
            if ($rr == -1) {
                $db->admin_record($store_id,$admin_name,'添加短信设置失败',1);
                $log -> customerLog(__LINE__.":添加短信配置失败：$sql");
                echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'添加短信设置成功',1);
                $log -> customerLog(__LINE__.":添加短信配置成功！");
                echo json_encode(array('status' =>'添加成功！' ,'suc'=>'1'));exit;
            }
        }

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>