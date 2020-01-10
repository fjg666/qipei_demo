<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class AddAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $list = "";

        // 根据参数，查询数据字典名称
        $sql0 = "select id from lkt_data_dictionary_name where name = '导航栏' and status = 1 and recycle = 0";
        $r0 = $db->select($sql0);
        if($r0){
            $id = $r0[0]->id;

            $sql1 = "select value,text from lkt_data_dictionary_list where status = 1 and recycle = 0 and sid = '$id' order by value ";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $key => $val){
                    $type = $val->value;
                    $text = $val->text;
                    $sql = "select * from lkt_core_menu where s_id = 0 and recycle = 0 and type = '$type' order by sort,id";
                    $r = $db->select($sql);
                    if($r){
                        if($type != 0){
                            $list .= "<option disabled='disabled'>---".$text."---</option>";
                        }

                        foreach ($r as $k => $v){
                            if($v->is_core == 1){
                                $list .= "<option value='$v->id'>$v->title(控制台)</option>";
                            }else{
                                $list .= "<option value='$v->id'>$v->title</option>";
                            }
                        }
                    }
                }
            }
        }
        $type = Tools::data_dictionary($db,'导航栏','');

        $request->setAttribute("list",$list);
        $request->setAttribute("type",$type);

        return View :: INPUT;
	}

	public function execute(){
		$db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/menu.log");
        // 1.开启事务
        $db->begin();

		$request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name');

        // 接收数据 
        $title = addslashes(trim($request->getParameter('title'))); // 菜单名称
        $image = addslashes(trim($request->getParameter('image'))); // 图标
        $image1 = addslashes(trim($request->getParameter('image1'))); // 图标
        $url = addslashes(trim($request->getParameter('url'))); // 路径
        $type = addslashes(trim($request->getParameter('type'))); // 类型
//        $is_core = addslashes(trim($request->getParameter('is_core'))); // 是否是核心
//        $is_plug_in = addslashes(trim($request->getParameter('is_plug_in'))); // 是否是插件
        $is_core = 0; // 是否是核心
        $is_plug_in = 0; // 是否是插件
        $sort = addslashes(trim($request->getParameter('sort'))); // 排序
        $s_id = $request->getParameter('val'); // 产品类别
        $level = intval($request->getParameter('level')) + 1; // 级别

        if($title == ''){
            echo json_encode(array('status' => '菜单名称不能为空！'));
            exit;
        }

        if(is_numeric($sort)){
            if($sort <= 0){
                echo json_encode(array('status' => '排序不能小于等于0！'));
                exit;
            }
        }else{
            echo json_encode(array('status' => '排序请填写数字！'));
            exit;
        }
        $sql = "select id from lkt_core_menu where recycle = 0 and title = '$title' and s_id = '$s_id' and is_core = '$is_core' and type = '$type'";
        $rr = $db->select($sql);
        if($rr){
            echo json_encode(array('status' => '菜单名称'.$title.'已存在！'));
            exit;
        }
        if($level != 1){
            if($url){
                if(count(explode('?',$url)) < 2){
                    $url = 'index.php?' . $url;
                }
                $res = substr($url,strpos($url,'?')+1);
                if(strpos($res,"&") > 0){
                    $rew = explode('&',$res);

                    $module = substr($rew[0],strpos($rew[0],'=')+1);
                    $action = substr($rew[1],strpos($rew[1],'=')+1);
                    if($action == 'index'){
                        $action = 'Index';
                    }

                }else{
                    $module = substr($url,strpos($url,'=')+1);
                    $action = 'Index';
                    $url = $url . '&action=' . $action;
                }
            }else{
                echo json_encode(array('status' => '路径不能为空'));
                exit;
            }

        }else{
            $module = '';
            $action = '';
        }
        $sql = "insert into lkt_core_menu(s_id,title,module,action,level,url,image,image1,sort,is_core,is_plug_in,type,add_time) value('$s_id','$title','$module','$action','$level','$url','$image','$image1','$sort','$is_core','$is_plug_in','$type',CURRENT_TIMESTAMP)";
        $r = $db->insert($sql,'last_insert_id');
        if($r > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加菜单'.$title.'成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加菜单成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '添加成功！', 'suc' => '1'));
            exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'添加菜单失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加菜单失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '未知原因，添加失败！'));
            exit;
        }
	}

	public function getRequestMethods(){
		return Request :: POST;
	}

}

?>