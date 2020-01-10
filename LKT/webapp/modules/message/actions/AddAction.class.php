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

        $type = $request->getParameter('type'); // 类型
        $type1 = $request->getParameter('type1'); // 类别
        $tid = $request->getParameter('tid'); // 模板id

        $select1 = Tools::data_dictionary($db,'短信模板类型','');

        $list = array();
        if($type != ''){
            if($type1 != ''){
                $sql = "select id,name from lkt_message where store_id = '$store_id' and type = '$type' and type1 = '$type1'";
                $r = $db->select($sql);
                if($r){
                    $list[] = array('id'=>"0","name"=>"请选择短信模块",'status'=>true);
                    foreach ($r as $k => $v){
                        $v->status = false;
                        $list[] = $v;
                    }
                }else{
                    $list[] = array('id'=>"0","name"=>"暂无模板",'status'=>true);
                }
                echo json_encode(array('list'=>$list));exit;
                return;
            }else{
                $select2 = Tools::get_message_data_dictionary($db,'短信模板类别',$type,'');

                $sql = "select id,name from lkt_message where store_id = '$store_id' and type = '$type' ";
                $r = $db->select($sql);
                if($r){
                    $list[] = array('id'=>"0","name"=>"请选择短信模块",'status'=>true);
                    foreach ($r as $k => $v){
                        $v->status = false;
                        $list[] = $v;
                    }
                }else{
                    $list[] = array('id'=>"0","name"=>"暂无模板",'status'=>true);
                }
                echo json_encode(array('select2' =>$select2,'list'=>$list));exit;
                return;
            }
        }

        if($tid){
            // 查询模板
            $sql = "select type,content from lkt_message where store_id = '$store_id' and id = '$tid'";
            $r = $db->select($sql);
            if($r){
                $content = $r[0]->content;
                if($r[0]->type == 1){
                    $res1 = "<input type='text' class='input-text' name='content[]' style='width: 100px;'>";
                    $res = preg_replace('/\$.*?\}/', $res1, $content);
                    $res .= "<input type='hidden' class='input-text' name='content1' value='$content'>";
                }else{
                    $res = '<label class="col-6" style="font-size: 14px;color:#97A0B4;tex;text-align: left;">'.$content.'</label>'.
                        '<input type="hidden" name="content[]" value="">'.
                        '<input type="hidden" name="content1" value="'.$content.'">';
                }
                echo json_encode($res);exit;
            }
        }

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
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $type = addslashes(trim($request->getParameter('type'))); // 类型
        $type1 = addslashes(trim($request->getParameter('type1'))); // 类型
        $tid = addslashes(trim($request->getParameter('tid'))); // 模板id
        $content = $request->getParameter('content'); // 发送内容
        $content1 = $request->getParameter('content1'); // 发送内容
        $log = new LaiKeLogUtils('common/message.log');// 日志
        
        if($tid == 0){
            $log -> customerLog(__LINE__.":添加短信失败：请选择短信模板！\r\n");
            echo json_encode(array('status' =>'请选择短信模板！' ));exit;
        }

        if($type == '0'){
            $code = rand(100000,999999);
            $TemplateParam = array('code'=>$code);
        }else if($type == '1'){
            if(in_array('', $content)){
                $log -> customerLog(__LINE__.":添加短信失败：请填写短信内容！\r\n");
                echo json_encode(array('status' =>'请填写短信内容！' ));exit;
            }
            preg_match_all("/(?<={)[^}]+/",$content1, $result);
            $TemplateParam = array_combine($result[0],$content);
        }
        $TemplateParam = serialize($TemplateParam);
        // 根据商城id、管理员id、短信模板，查询该管理员是否重复添加该短信模板
        $sql = "select id from lkt_message_list where store_id = '$store_id' and type = '$type' and type1 = '$type1'";
        $r0 = $db->select($sql);
        if($r0){
            $log -> customerLog(__LINE__.":添加短信失败：该类短信模板已添加,请勿重复添加！\r\n");
            echo json_encode(array('status' =>'该类短信模板已添加,请勿重复添加！' ));exit;
        }else{
            $sql = "insert into lkt_message_list(store_id,type,type1,Template_id,content,add_time) values ('$store_id','$type','$type1','$tid','$TemplateParam',CURRENT_TIMESTAMP)";
            $r1 = $db->insert($sql);
            if ($r1 < 1) {
                $db->admin_record($store_id,$admin_name,'添加短信失败',1);
                $log -> customerLog(__LINE__.":添加短信失败：$sql\r\n");
                echo json_encode(array('status' =>'未知原因，添加失败！' ));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'添加短信成功',1);
                $log -> customerLog(__LINE__.":添加短信成功！\r\n");
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