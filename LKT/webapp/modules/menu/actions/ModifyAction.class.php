<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ModifyAction extends Action {

	public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $id = $request->getParameter("id");

        // 根据id，查询菜单
        $sql = "select * from lkt_core_menu where recycle = 0 and id = '$id'";
        $r_1 = $db->select($sql);
        if($r_1){
            $s_id = $r_1[0]->s_id; // 上级id
            $title = $r_1[0]->title; // 菜单名称
            $image = $r_1[0]->image; // 图片
            $image1 = $r_1[0]->image1; // 图片
            $url = $r_1[0]->url; // 路径
            $sort = $r_1[0]->sort; // 排序
            $type = $r_1[0]->type; // 类型
            $is_core = $r_1[0]->is_core; // 是否是核心
            $is_plug_in = $r_1[0]->is_plug_in; // 是否是插件
            $level = $r_1[0]->level; // 等级
            $list = "";
            if($level == 1){ // 当为一级菜单时
                $list = $this->menu($level,$s_id);
                $cid = 0;
            }else if($level == 2){ // 当为二级菜单时
                /** 二级 **/
                $list1 = "";
                // 根据一级菜单ID，查询二级菜单
                $sql = "select * from lkt_core_menu where recycle = 0 and s_id = '$s_id' order by sort,id";
                $rr = $db->select($sql);
                if($rr){
                    foreach ($rr as $k => $v){
                        $list1 .= "<option value='$v->id'>$v->title</option>";
                    }
                }
                /** 一级 **/
                $list = $this->menu($level,$s_id);

                $cid = $s_id;

                $request->setAttribute("list1",$list1);
            }else if($level == 3){ // 当为三级菜单时
                $list1 = "";
                $list2 = "";
                /** 三级 **/
                // 根据上级菜单ID，查询三级菜单
                $sql = "select * from lkt_core_menu where recycle = 0 and s_id = '$s_id'";
                $rrr = $db->select($sql);
                if($rrr){
                    foreach ($rrr as $k => $v){
                        $list2 .= "<option value='$v->id'>$v->title</option>";
                    }
                }
                /** 二级 **/
                // 根据该菜单的上级ID，查询上级菜单
                $sql = "select * from lkt_core_menu where recycle = 0 and id = '$s_id'";
                $r2 = $db->select($sql);
                if($r2){
                    $id2 = $r2[0]->id; // 二级菜单id
                    $s_id2 = $r2[0]->s_id; // 一级菜单id
                    // 根据一级菜单ID，查询二级菜单
                    $sql = "select * from lkt_core_menu where recycle = 0 and s_id = '$s_id2' order by sort,id";
                    $r = $db->select($sql);
                    if($r){ // 存在
                        foreach ($r as $k => $v){
                            if($id2 == $v->id){
                                $list1 .= "<option value='$v->id' selected='true' >$v->title</option>";
                            }else{
                                $list1 .= "<option value='$v->id'>$v->title</option>";
                            }
                        }
                    }
                }
                /** 一级 **/
                $list = $this->menu($level,$s_id2);

                $cid = $s_id;

                $request->setAttribute("list1",$list1);
                $request->setAttribute("list2",$list2);
            }else{ // 当为四级菜单时
                $list1 = "";
                $list2 = "";
                /** 三级 **/
                // 根据上级菜单ID，查询三级菜单
                $sql = "select * from lkt_core_menu where recycle = 0 and id = '$s_id'";
                $rrr = $db->select($sql);
                if($rrr){
                    $id3 = $rrr[0]->id; // 三级菜单id
                    $s_id3 = $rrr[0]->s_id; // 二级菜单id
                    // 根据二级菜单ID，查询三级菜单
                    $sql = "select * from lkt_core_menu where recycle = 0 and s_id = '$s_id3' order by sort,id";
                    $rrr1 = $db->select($sql);
                    foreach ($rrr1 as $k => $v){
                        if($id3 == $v->id){
                            $list2 .= "<option value='$v->id' selected='true' >$v->title</option>";
                        }else{
                            $list2 .= "<option value='$v->id'>$v->title</option>";
                        }
                    }
                }
                /** 二级 **/
                // 根据二级菜单ID，查询二级菜单
                $sql = "select * from lkt_core_menu where recycle = 0 and id = '$s_id3'";
                $r2 = $db->select($sql);
                if($r2){
                    $id2 = $r2[0]->id; // 二级菜单id
                    $s_id2 = $r2[0]->s_id; // 一级菜单id
                    // 根据一级菜单ID，查询二级菜单
                    $sql = "select * from lkt_core_menu where recycle = 0 and s_id = '$s_id2' order by type,sort,id";
                    $r = $db->select($sql);
                    if($r){ // 存在
                        foreach ($r as $k => $v){
                            if($id2 == $v->id){
                                $list1 .= "<option value='$v->id' selected='true' >$v->title</option>";
                            }else{
                                $list1 .= "<option value='$v->id'>$v->title</option>";
                            }
                        }
                    }
                }
                /** 一级 **/
                $list = $this->menu($level,$s_id2);

                $cid = $s_id;

                $request->setAttribute("list1",$list1);
                $request->setAttribute("list2",$list2);
            }
        }
        // 根据该菜单ID，查询下级菜单
        $sql = "select id from lkt_core_menu where recycle = 0 and s_id = '$id'";
        $r_1 = $db->select($sql);
        if($r_1){ // 存在下级，不能修改级别
            $status = 1;
        }else{ // 不存在下级，不能修改级别
            $status = 0;
        }
        $type = Tools::data_dictionary($db,'导航栏',$type);

        $request->setAttribute('id', $id);
        $request->setAttribute('title', $title );
        $request->setAttribute('url', $url );
        $request->setAttribute('sort', $sort );
        $request->setAttribute('type', $type );
        $request->setAttribute('is_core', $is_core );
        $request->setAttribute('is_plug_in', $is_plug_in );
        $request->setAttribute('level', $level );
        $request->setAttribute('image', $image );
        $request->setAttribute('image1', $image1 );
        $request->setAttribute('cid', $cid);
        $request->setAttribute("level",$level-1);
        $request->setAttribute("list",$list);
        $request->setAttribute("status",$status);

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
        $id = $request->getParameter("id");
        $title = addslashes(trim($request->getParameter('title'))); // 菜单名称
//        $s_id = addslashes(trim($request->getParameter('s_id'))); // 上级id
        $image = addslashes(trim($request->getParameter('image'))); // 图标
        $oldpic = addslashes(trim($request->getParameter('oldpic'))); // 产品图片
        $image1 = addslashes(trim($request->getParameter('image1'))); // 图标
        $oldpic1 = addslashes(trim($request->getParameter('oldpic1'))); // 产品图片

        $url = addslashes(trim($request->getParameter('url'))); // 路径
        $type = addslashes(trim($request->getParameter('type'))); // 类型
//        $is_core = addslashes(trim($request->getParameter('is_core'))); // 是否是核心
        $is_core = 0; // 是否是核心
        $sort = addslashes(trim($request->getParameter('sort'))); // 排序

        $s_id = $request->getParameter('val'); // 产品类别
        $level = $request->getParameter('level') + 1; // 级别

        if($title == ''){
            echo json_encode(array('status' => '菜单名称不能为空！'));
            exit;
        }else{
            $sql = "select id from lkt_core_menu where recycle = 0 and id != '$id' and title = '$title' and s_id = '$s_id' and type = '$type' and is_core = '$is_core'";
            $r_1 = $db->select($sql);
            if($r_1){
                echo json_encode(array('status' => '菜单名称'.$title.'已存在！'));
                exit;
            }
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
            $url = '';
            $module = '';
            $action = '';
        }
        if($image){
            if($image != $oldpic){
                @unlink ($oldpic);
            }
        }else{
            $image = $oldpic;
        }
        if($image1){
            if($image1 != $oldpic1){
                @unlink ($oldpic1);
            }
        }else{
            $image1 = $oldpic1;
        }

        $sql = "update lkt_core_menu set title = '$title',module = '$module',action = '$action',s_id = '$s_id',level = '$level',image = '$image',image1 = '$image1',url = '$url',is_core = '$is_core',type = '$type',sort = '$sort' where id = '$id'";
        $r = $db->update($sql);
        if($r == -1) {
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改菜单id为 '.$id.' 失败',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改菜单id为 '.$id.' 失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('status' => '未知原因，修改失败！'));
            exit;
        } else {
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改菜单id为 '.$id.' 成功',2);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改菜单id为 '.$id.' 成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('status' => '修改成功！', 'suc' => '1'));
            exit;
        }
		return;
	}

	public function getRequestMethods(){
		return Request :: POST;
	}

    // 获取一级菜单
	public function menu($level,$s_id){
        $db = DBAction::getInstance();
        $list = '';
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
                            if($level == 1){
                                if($v->is_core == 1){
                                    $list .= "<option value='$v->id'>$v->title(控制台)</option>";
                                }else{
                                    $list .= "<option value='$v->id'>$v->title</option>";
                                }
                            }else{
                                if($s_id == $v->id){
                                    if($v->is_core == 1){
                                        $list .= "<option value='$v->id' selected='true'>$v->title(控制台)</option>";
                                    }else{
                                        $list .= "<option value='$v->id' selected='true'>$v->title</option>";
                                    }
                                }else{
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
            }
        }
        return $list;
    }
}
?>