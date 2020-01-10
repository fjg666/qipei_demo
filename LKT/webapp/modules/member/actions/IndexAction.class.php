<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');

class IndexAction extends Action {
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/12  17:50
     * @version 1.0
     */
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();

        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id'); // 管理员id
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员id
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');

        $button[0] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=member&action=Add');
        $button[1] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=member&action=Status');
        $button[2] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=member&action=Modify');
        $button[3] = $JurisdictionAction->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=member&action=Del');

        // 导出
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 每页显示多少条数据
        $page = $request -> getParameter('page');

        // 页码
        if($page){
            $start = ($page-1)*$pagesize;
        }else{
            $start = 0;
        }
        // 根据管理员id,查询管理员信息(是否是客户或商城管理员)
        $sql = "select * from lkt_admin where id = '$admin_id'";
        $r0 = $db->select($sql);
        $store_type = 0; // 允许查看该商城所有管理员
        if($r0[0]->type == 0 || $r0[0]->type == 1){ // 允许查看该商城所有管理员
            $store_type = 0; // 允许查看该商城所有管理员
        }else{
            $store_type = 1; // 不允许查看该商城所有管理员
        }
        $sql = "select customer_number from lkt_customer where id = '$store_id'";
        $r0 = $db->select($sql);
        $customer_number = $r0[0]->customer_number;

        if($store_type == 0){
            $sql = "select * from lkt_admin where recycle = 0 and type = 2 and store_id = '$store_id'";
        }else{
            $sql = "select * from lkt_admin where recycle = 0 and type = 2 and id = '$admin_id'";
        }
        // 查询管理员信息
        $r = $db->select($sql);
        if($r){
            $total = count($r);
        }else{
            $total = 0;
        }
        $pager = new ShowPager($total,$pagesize,$page);

        if($store_type == 0) {
            $sql = "select * from lkt_admin where recycle = 0 and type = 2 and store_id = '$store_id' order by add_date desc limit $start,$pagesize";
        }else{
            $sql = "select * from lkt_admin where recycle = 0 and type = 2 and id = '$admin_id' order by add_date desc limit $start,$pagesize";
        }
        // 查询管理员信息
        $rr = $db->select($sql);
        if($rr){
            foreach ($rr as $k1 => $v1) {
                $list_3[$k1] = '';
                $sid = $v1->sid;
                $role = $v1->role;
                $sql = "select name,permission from lkt_role where id = '$role'";
                $r_role = $db->select($sql);
                if($r_role){
                    $v1->role_name = $r_role[0]->name;
                    $v1->permission = $r_role[0]->permission;
                    $permission = unserialize($v1->permission);
                    $arr_1 = [];
                    $arr_2 = [];
                    $arr_3 = [];
                    $sql = "select name from lkt_admin where id = '$sid'";
                    $r_admin_name = $db->select($sql);
                    if($r_admin_name){
                        $v1->admin_name = $r_admin_name[0]->name;
                    }else{
                        $v1->admin_name = '';
                    }
                    if($permission){
                        foreach ($permission as $a => $b){
                            $res = substr($b,0,strpos($b, '/')); // 截取第一个'/'之前的内容
                            $rew = substr($b,strpos($b,'/')+1); // 截取第一个'/'之后的内容
                            if($res == 1){
                                $arr_1[] = explode('/',$rew); // 第一级数组
                            }else if($res == 2){
                                $arr_2[] = explode('/',$rew); // 第二级数组
                            }else if($res == 3){
                                $arr_3[] = explode('/',$rew); // 第三级数组
                            }
                        }
                        foreach ($arr_1 as $k => $v){
                            $list_1 = '';
                            $list_2 = '';
                            // 查询模块表(模块名称、模块标识、模块描述)
                            $sql = "select id,title from lkt_core_menu where s_id = 0 and name = '$v[0]' order by sort,id";
                            $r_1 = $db->select($sql);
                            if($r_1){
                                $list_1 .= $r_1[0]->title . '('; // 一级菜单名称拼接
                                $id_1 = $r_1[0]->id;
                                foreach ($arr_2 as $ke => $va){
                                    // 根据上级id、权限信息，查询菜单名称
                                    $sql = "select id,title from lkt_core_menu where s_id = '$id_1' and name = '$va[0]' and module = '$va[1]' and action = '$va[2]' order by sort,id";
                                    $r_2 = $db->select($sql);
                                    if($r_2){
                                        $list_2 .= $r_2[0]->title . ','; // 二级菜单名称拼接
                                    }
                                }
                                $list_1 .= rtrim($list_2,','); // 一级菜单名称拼接
                                $list_1 .= ')'; // 一级菜单名称拼接
                                $list_3[$k1] .= $list_1 . ',';
                            }
                        }
                    }
                    $v1->permission = rtrim($list_3[$k1], ',');
                }
            }
        }

        $url = "index.php?module=member&action=Index&pagesize=".urlencode($pagesize);;
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

        $request->setAttribute("list",$rr);
        $request -> setAttribute('pages_show', $pages_show);
        $request -> setAttribute('store_type', $store_type);
        $request -> setAttribute('customer_number', $customer_number);
        $request->setAttribute('button', $button);

        return View :: INPUT;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>