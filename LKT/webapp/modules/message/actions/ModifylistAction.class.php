<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifylistAction extends Action {
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
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $id = $request->getParameter("id");

        // 根据id查询管理员信息
        $sql = "select * from lkt_message where store_id = '$store_id' and id = '$id'";
        $r = $db->select($sql);
        $SignName = isset($r)?$r[0]->SignName:'';
        $name = isset($r)?$r[0]->name:'';
        $type = isset($r)?$r[0]->type:'';
        $type1 = isset($r)?$r[0]->type1:'';
        $TemplateCode = isset($r)?$r[0]->TemplateCode:'';
        $content = isset($r)?$r[0]->content:'';

        $select1 = Tools::data_dictionary($db,'短信模板类型',$type);
        $select2 = Tools::get_message_data_dictionary($db,'短信模板类别',$type,$type1);

        $request->setAttribute('id', $id);
        $request->setAttribute('SignName', $SignName );
        $request->setAttribute('name', $name );
        $request->setAttribute('TemplateCode', $TemplateCode);
        $request->setAttribute('content', $content);
        $request->setAttribute('select1', $select1);
        $request->setAttribute('select2', $select2);

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

        // 接收数据 
        $id = $request->getParameter("id");
        $SignName = addslashes(trim($request->getParameter('SignName'))); // 短信签名
        $name = addslashes(trim($request->getParameter('name'))); // 短信模板名称
        $type = addslashes(trim($request->getParameter('type'))); // 类型
        $type1 = addslashes(trim($request->getParameter('type1'))); // 类别
        $TemplateCode = addslashes(trim($request->getParameter('TemplateCode'))); // 短信模板Code
        $PhoneNumbers = addslashes(trim($request->getParameter('PhoneNumbers'))); // 短信接收号码
        $content = addslashes(trim($request->getParameter('content'))); // 发送内容

        $log = new LaiKeLogUtils('common/message.log');
        if($SignName == ''){
            $log -> customerLog(__LINE__.":修改短信配置失败：短信签名不能为空！");
            echo json_encode(array('status' =>'短信签名不能为空！' ));exit;
        }
        if($name == ''){
            $log->customerLog(__LINE__.":修改短信模版失败：短信模板名称不能为空！\r\n");
            echo json_encode(array('status' =>'短信模板名称不能为空！' ));exit;
        }else{
            $sql = "select * from lkt_message where store_id = '$store_id' and name = '$name' and id != '$id'";
            $r = $db->select($sql);
            if($r){
                $log->customerLog(__LINE__.":修改短信模版失败：短信模板名称".$name."已存在！\r\n");
                echo json_encode(array('status' =>'短信模板名称'.$name.'已存在！' ));exit;
            }
        }
        if($TemplateCode == ''){
            $log->customerLog(__LINE__.":修改短信模版失败：短信模板Code不能为空！\r\n");
            echo json_encode(array('status' =>'短信模板Code不能为空！' ));exit;
        }else{
            $sql = "select * from lkt_message where store_id = '$store_id' and TemplateCode = '$TemplateCode' and id != '$id'";
            $r = $db->select($sql);
            if($r){
                $log->customerLog(__LINE__.":修改短信模版失败：短信模板Code".$TemplateCode."已存在！\r\n");
                echo json_encode(array('status' =>'短信模板Code'.$TemplateCode.'已存在！' ));exit;
            }
        }
        if($PhoneNumbers == ''){
            $log->customerLog(__LINE__.":修改短信模版失败：短信接收号码不能为空！\r\n");
            echo json_encode(array('status' =>'短信接收号码不能为空！' ));exit;
        }
        if($content == ''){
            $log->customerLog(__LINE__.":修改短信模版失败：发送内容不能为空！\r\n");
            echo json_encode(array('status' =>'发送内容不能为空！' ));exit;
        }
        if($type == 1){
            preg_match_all("/(?<={)[^}]+/",$content, $result);
            foreach ($result[0] as $k => $v){
                $TemplateParam[$v] = $v;
            }
        }else{
            $code = rand(100000,999999);
            $TemplateParam = array('code'=>$code);
        }
        if($type1 == ''){
            echo json_encode(array('status' =>'请选择类型！' ));exit;
        }
        $Tools = new Tools($db, $store_id, 1);
        $Tools_arr = $Tools->message($SignName,$PhoneNumbers,$TemplateCode,$TemplateParam);
        if($Tools_arr != ''){
            if($Tools_arr->Code == 'OK'){
                $sql = "update lkt_message set SignName = '$SignName',name = '$name',type = '$type',type1 = '$type1',TemplateCode = '$TemplateCode',content = '$content',add_time = CURRENT_TIMESTAMP where store_id = '$store_id' and id = '$id'";
                $rr = $db->update($sql);
                if ($rr == -1) {
                    $db->admin_record($store_id,$admin_name,'修改短信模板失败',1);
                    $log->customerLog(__LINE__.":修改短信模版失败：$sql\r\n");
                    echo json_encode(array('status' =>'未知原因，修改失败！' ));exit;
                } else {
                    $db->admin_record($store_id,$admin_name,'修改短信模板'.$name,1);
                    $log->customerLog(__LINE__.":修改短信模版成功！\r\n");
                    echo json_encode(array('status' =>'修改成功！' ,'suc'=>'1'));exit;
                }
            }else{
                $db->admin_record($store_id,$admin_name,'修改短信模板有误：'.$Tools_arr->Code,1);
                $log->customerLog(__LINE__.":修改短信模版失败：".$Tools_arr->Code."\r\n");
                echo json_encode(array('status'=>'未知原因，修改失败','verification'=>$Tools_arr->Code));
            }
        }else{
            $log->customerLog(__LINE__.":修改短信模版失败：请先配置核心设置！\r\n");
            echo json_encode(array('status' =>'请先配置核心设置' ));exit;
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>