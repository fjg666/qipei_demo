<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');

require_once(MO_LIB_DIR . '/version.php');
class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $login_time = $this->getContext()->getStorage()->read('login_time');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $mch_id = $this->getContext()->getStorage()->read('mch_id');
        $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
        $store_id1 = $request->getParameter("store_id1"); // 是否退出

        if(!empty($store_id1)){ // 当为退出时
            $store_id = '';
            $mch_id = '';

            $this->getContext()->getStorage()->write('store_id',$store_id);
            $this->getContext()->getStorage()->write('mch_id',$mch_id);
            echo 1;
            exit;
        }else{
            if(empty($store_id)){
                $store_id = $request->getParameter("store_id"); // 商城id
            }
        }

        $type = intval($request->getParameter("type"));
        if($type == ""){
            $type = 0;
        }else{
            $type = $type;
        }

        $sql = "select * from lkt_admin where id = '$admin_id'";
        $r = $db->select($sql);
        $admin_type = $r[0]->admin_type;
        $list = array();
        $list1 = array();
        $ara = array();
        $ara1 = array();

        if(empty($store_id)){ // 控制台
            $sql0_0 = "select * from lkt_core_menu where s_id = 0 and recycle = 0 and is_core = 1 order by sort,id";
            $r0_0 = $db->select($sql0_0);
            if($r0_0){
                foreach ($r0_0 as $k => $v){
                    $sql0_1 = "select * from lkt_core_menu where s_id = '$v->id' and is_core = 1 and recycle = 0 order by sort,id";
                    $r0_1 = $db->select($sql0_1);
                    if($r0_1){
                        foreach ($r0_1 as $ke => $va){
                            $v->res[] = $va;
                        }
                    }
                    $list[] = $v;
                }
            }
        }else{ // 商城
            $role_list = array();
            $role_list1 = array();
            $permission1 = array();
            $permission_1 = array();
            $permission_2 = array();
            if($admin_type1 != 2 && $admin_type1 != 3) { // 不是商城管理员 并且 不是店主
                $sql0 = "select * from lkt_admin where store_id = '$store_id' and type = 1";
            }else{
                $sql0 = "select * from lkt_admin where name ='$admin_name' and store_id = '$store_id'";
            }
            $r0 = $db->select($sql0);
            $mch_id = $r0[0]->shop_id;
            $role = $r0[0]->role; // 角色
            $sql1 = "select b.id,b.type,b.url from lkt_role_menu as a left join lkt_core_menu as b on a.menu_id = b.id where a.role_id = '$role' and b.recycle = 0 ";
            $r1 = $db->select($sql1);
            if($r1){
                foreach ($r1 as $k1 => $v1){
                    if($v1->type != '0') {
                        $v1->title_name = Tools::header_data_dictionary($db, '导航栏', $v1->type);
                        $role_list1[] = (array)$v1;
                    }
                    $permission_1[] = $v1->id;
                }
            }
            $permission_1 = array_unique($permission_1); // 一维数组去重

            $role_list1 = Tools::assoc_unique($role_list1, 'title_name'); // 二维数组去重
            // 二维数组根据type顺序排列
            $last_names = array_column($role_list1,'type');
            array_multisort($last_names,SORT_ASC,$role_list1);
            $role_list2 = array();
            foreach ($role_list1 as $k => $v){
                if($v['title_name'] == '报表'){
                    $role_list2 = (object)$v;
                }else{
                    $role_list[] = (object)$v;
                }
            }
            // 把报表添加在最后
            if($role_list2 != array()){
                $role_list[] = $role_list2;
            }
            $permission_2 = $permission_1;
            foreach ($permission_2 as $k => $v){
                // 查询模块表(模块名称、模块标识、模块描述)
                $sql = "select * from lkt_core_menu where type = '$type' and s_id = 0 and is_core = 0 and recycle = 0 and id = '$v' order by sort,id";
                $r_0 = $db->select($sql);
                if($r_0){
                    $ara[] = (array)$r_0[0];
                }
            }

            $ara = Tools::assoc_unique($ara, 'title'); // 二维数组去重

            $volume = array();
            $edition = array();
            foreach ($ara as $key => $row)
            {
                $volume[$key]  = $row['sort'];
                $edition[$key] = $row['id'];
            }

            array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $ara); // 排序

            $ara = (object)$ara;

            foreach ($ara as $k => $v) {
                $ara1[] = (object)$v;
            }
            $ara1 = (object)$ara1;

            foreach ($ara1 as $k => $v){
                $id_1 = $v->id;

                $res = array();
                foreach ($permission_2 as $ke => $va){
                    $sql = "select * from lkt_core_menu where type = '$type' and s_id = '$id_1' and is_core = 0 and recycle = 0 and id = '$va' order by sort,id";
                    $r_1 = $db->select($sql);
                    if($r_1){
                        $r_1[0]->url = $r_1[0]->url;
                        $res[] = (array)$r_1[0];
                    }
                }
                $last_names = array_column($res,'sort','id'); // 返回输入数组中某个单一列的值。
                array_multisort($last_names,SORT_ASC,$res); // 排序
                foreach ($res as $k1 => $v1){
                    $v->res[] = (object)$v1;
                }
                $list[] = $v;
            }

            $request->setAttribute('role_list',$role_list);
        }

        $sql = "select domain,uploadImg from lkt_config where store_id = '$store_id'";
        $rr = $db->select($sql);
        if($rr){
            $domain = $rr[0]->domain;
            $uploadImg = $rr[0]->uploadImg . 'image_'.$store_id.'/'; // 图片上传位置
        }else{
            $domain = '';
            $uploadImg = '';
        }

        $version = LKT_VERSION;

        $this->getContext()->getStorage()->write('store_id',$store_id);
        $this->getContext()->getStorage()->write('type',$type);
        $this->getContext()->getStorage()->write('uploadImg',$uploadImg);
        $this->getContext()->getStorage()->write('store_type',$type);

        $request->setAttribute('store_id',$store_id);
        $request->setAttribute('mch_id',$mch_id);
        $request->setAttribute('version',$version);
        $request->setAttribute('list',$list);
        $request->setAttribute('admin_name',$admin_name);
        $request->setAttribute('admin_type',$admin_type);
        $request->setAttribute('type',$type);
        $request->setAttribute('login_time',$login_time);
        $request->setAttribute('domain',$domain);
        $sql02 = "select * from lkt_express ";
        $express = $db->select($sql02);
        $request->setAttribute("express", $express);

        return View :: INPUT;
    }

    //校验登入时间和异地登入
    public function execute(){
        $db = DBAction::getInstance();
        $name = $this->getContext()->getStorage()->read('admin_name');
        $mch_id = $this->getContext()->getStorage()->read('mch_id');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $login_time = $this->getContext()->getStorage()->read('login_time');
        $caozuo_time = $login_time + 10 * 60;
        $time = time();

        $code = 0;


        if($time > $caozuo_time){
            $code = 1;
        }

        $sql = "select token,status from lkt_admin where name ='$name'";
        $r = $db->select($sql);
        $admin_token = $r[0]->token;
        $status = $r[0]->status;
        if($admin_token != session_id()){
            $code = 2;
        }
        $time1 = date('Y-m-d 00:00:00');
        $time2 = date('Y-m-d 23:59:59');
        $sql001 = "select count(o.id) as id from lkt_order as o left join lkt_user as lu on o.user_id = lu.user_id where o.store_id = '$store_id' and lu.store_id = '$store_id' and o.readd = '0' and (o.status = 0 or o.status = 1) and o.mch_id = ',$mch_id,' and (o.otype = '' or o.otype = 'KJ') and o.add_time >= '$time1' and o.add_time <= '$time2'";
        $re001 = $db ->select($sql001);//新订单
        $sql002 = "select count(o.id) as id from lkt_order as o left join lkt_user as lu on o.user_id = lu.user_id where o.store_id = '$store_id' and lu.store_id = '$store_id' and o.readd = '0' and o.status = 1 and o.mch_id = ',$mch_id,' and (o.otype = '' or o.otype = 'KJ')";
        $re002 = $db ->select($sql002);//待发货

        $sql003 = "select count(b.id) as id from lkt_order_details as b left join lkt_order as a on b.r_sNo = a.sNo where b.store_id = '$store_id' and a.mch_id = ',$mch_id,' and (b.r_status = 4 OR b.r_type > 0) and b.r_type != 100";
        $re003 = $db->select($sql003);//退货

        $sql004 = "select count(o.id) as id from lkt_order as o left join lkt_user as lu on o.user_id = lu.user_id where o.store_id = '$store_id' and lu.store_id = '$store_id' and (o.otype = '' or o.otype = 'KJ') and o.readd = '0' and o.status = 1 and o.delivery_status = '1' and o.mch_id = ',$mch_id,' ";
        $re004 = $db ->select($sql004);//提醒发货

        $re['xin']= $re001[0]->id;
        $re['dai'] = $re002[0]->id;
        $re['tui'] = $re003[0]->id;
        $re['delivery_status'] = $re004[0]->id;

        echo json_encode(array('code' =>$code,'re' =>$re,'status'=>$status));
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}
?>