<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class IndexAction extends Action {

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id

        $sql = "select * from lkt_hotkeywords where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $is_open = $r[0]->is_open; // 是否开启
            $num = $r[0]->num; // 关键词上限
            $keyword = $r[0]->keyword; // 关键词
            $mch_keyword = $r[0]->mch_keyword; // 店铺关键词
        }
       
        $request->setAttribute("is_open", isset($is_open) ? $is_open : '');
        $request->setAttribute('num', isset($num) ? $num : '');
        $request->setAttribute('keyword', isset($keyword) ? $keyword : '');
        $request->setAttribute('mch_keyword', isset($mch_keyword) ? $mch_keyword : '');
        return View :: INPUT;
    }

    public function execute(){

        $request = $this->getContext()->getRequest();
        $db = DBAction::getInstance();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        //取得参数
        $is_open= addslashes($request->getParameter('is_open')); // 是否开启
        $num = addslashes(trim($request->getParameter('num'))); // 关键词上限
        $keyword = addslashes(trim($request->getParameter('keyword'))); // 关键词

        $log = new LaiKeLogUtils('common/search_config.log');// 日志

        $mch_keyword = '';
        if($is_open == ''){// 如果开启插件为空
            $is_open = 0;
        }

        // 正则，防止使用人员用中文逗号
        $keyword = preg_replace("/(\n)|(\s)|(\t)|(\')|(')|(，)/" ,',' ,$keyword);

        $sql0 = "select id from lkt_hotkeywords where store_id = '$store_id' ";
        $r0 = $db->select($sql0);
        if($r0){
            // 更新
            $sql = "update lkt_hotkeywords set is_open = '$is_open',num = '$num',keyword = '$keyword',mch_keyword = '$mch_keyword' where store_id = '$store_id'";
            $r = $db->update($sql);

            if($r == -1) {
                $db->admin_record($store_id,$admin_name,'修改搜索配置失败',2);
                $log -> customerLog(__LINE__.":修改搜索配置失败：$sql\r\n");
                echo json_encode(array('status' => '未知原因，修改失败！！'));exit;
            } else {
                $db->admin_record($store_id,$admin_name,'修改搜索配置',2);
                $log -> customerLog(__LINE__.":修改搜索配置成功！\r\n");
                echo json_encode(array('status' => '修改成功！','suc'=>'1'));exit;
            }
        }else{
            $sql = "insert into lkt_hotkeywords(store_id,is_open,num,keyword,mch_keyword) values ('$store_id','$is_open','$num','$keyword','$mch_keyword')";
            $r = $db->insert($sql);
            if($r > 0){
                $db->admin_record($store_id,$admin_name,'添加搜索配置',1);
                $log -> customerLog(__LINE__.":修改搜索配置成功！\r\n");
                echo json_encode(array('status' => '添加成功！','suc'=>'1'));exit;
            }else{
                $db->admin_record($store_id,$admin_name,'添加搜索配置失败',2);
                $log -> customerLog(__LINE__.":修改搜索配置失败：$sql\r\n");
                echo json_encode(array('status' => '未知原因，添加失败！！'));exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>