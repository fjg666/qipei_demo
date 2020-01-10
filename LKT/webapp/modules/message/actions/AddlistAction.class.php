<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddlistAction extends Action {
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

        $type = addslashes($request->getParameter('type')); // 短信模板类型
        if($type != ''){
            $select2 = Tools::get_message_data_dictionary($db,'短信模板类别',$type,'');

            echo json_encode(array('select2' =>$select2));exit;
            return;
        }

        $select1 = Tools::data_dictionary($db,'短信模板类型','');

        $request->setAttribute('select1', $select1);

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

        $SignName = addslashes(trim($request->getParameter('SignName'))); // 短信签名
        $name = addslashes(trim($request->getParameter('name'))); // 短信模板名称
        $type = addslashes(trim($request->getParameter('type'))); // 类型
        $type1 = addslashes(trim($request->getParameter('type1'))); // 类别
        $TemplateCode = addslashes(trim($request->getParameter('TemplateCode'))); // 短信模板Code
        $PhoneNumbers = addslashes(trim($request->getParameter('PhoneNumbers'))); // 短信接收号码
        $content = addslashes(trim($request->getParameter('content'))); // 发送内容

        $log = new LaiKeLogUtils('common/message.log');// 

        if($SignName == ''){
            $log -> customerLog(__LINE__.":修改短信配置失败：短信签名不能为空！");
            echo json_encode(array('status' =>'短信签名不能为空！' ));exit;
        }
        if($name == ''){
            $log -> customerLog(__LINE__.":添加短信模版失败：短信模板名称不能为空！");
            echo json_encode(array('status' =>'短信模板名称不能为空！' ));exit;
        }else{
            $sql = "select * from lkt_message where store_id = '$store_id' and name = '$name'";
            $r = $db->select($sql);
            if($r){
                $log -> customerLog(__LINE__.":添加短信模版失败：短信模板名称".$name."已存在！");
                echo json_encode(array('status' =>'短信模板名称'.$name.'已存在！' ));exit;
            }
        }
        if($TemplateCode == ''){
            $log -> customerLog(__LINE__.":添加短信模版失败：短信模板Code不能为空！");
            echo json_encode(array('status' =>'短信模板Code不能为空！' ));exit;
        }else{
            $sql = "select * from lkt_message where store_id = '$store_id' and TemplateCode = '$TemplateCode'";
            $r = $db->select($sql);
            if($r){
                $log -> customerLog(__LINE__.":添加短信模版失败：短信模板Code".$TemplateCode."已存在！");
                echo json_encode(array('status' =>'短信模板Code'.$TemplateCode.'已存在！' ));exit;
            }
        }
        if($PhoneNumbers == ''){
            $log -> customerLog(__LINE__.":添加短信模版失败：短信接收号码不能为空！");
            echo json_encode(array('status' =>'短信接收号码不能为空！' ));exit;
        }
        if($content == ''){
            $log -> customerLog(__LINE__.":添加短信模版失败：发送内容不能为空！");
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
                $sql = "insert into lkt_message(store_id,SignName,name,type,type1,TemplateCode,content,add_time) values ('$store_id','$SignName','$name','$type','$type1','$TemplateCode','$content',CURRENT_TIMESTAMP)";
                $rr = $db->insert($sql);
                if ($rr == -1) {
                    $db->admin_record($store_id,$admin_name,'添加短信模板失败',1);
                    $log -> customerLog(__LINE__.":添加短信模版失败：$sql");
                    echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;
                } else {
                    $db->admin_record($store_id,$admin_name,'添加短信模板'.$name,1);
                    $log -> customerLog(__LINE__.":添加短信模版成功!");
                    echo json_encode(array('status' =>'添加成功！' ,'suc'=>'1'));exit;
                }
            }else{
                $db->admin_record($store_id,$admin_name,'添加短信模板有误：'.$Tools_arr->Code,1);
                $log -> customerLog(__LINE__.":添加短信模版失败：".$Tools_arr->Code." ");
                echo json_encode(array('status'=>'修改','verification'=>$Tools_arr->Code));
            }
        }else{
            $log -> customerLog(__LINE__.":添加短信模版失败：请先配置核心设置");
            echo json_encode(array('status' =>'请先配置核心设置' ));exit;
        }

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>