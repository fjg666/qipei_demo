<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');

header('Access-Control-Allow-Origin:*');
class LoginFilter extends Filter {

    public $effect;
    public $candirect = array("Default","Login","api","api_news","app","third") ;

    public function execute ($filterChain) {
        if($this->effect == false){
            $filterChain->execute();
            return;
        }

        //取得第一个访问模块的名称
        // 检索当前应用程序控制器
        $controller = $this->getContext()->getController();
        /* 小程序过滤设置 开始 */
        $request = $this->getContext()->getRequest();
        // $res =$request ->parameters; // 获取参数
        // if($res){ // 存在
        // 	$module = $res['module']; // 获取module值
        // 	if($module == 'api'){ // 当值为api时
        // 		$action = $res['action']; // 获取action值
        // 		if($action != 'app'  && $action != 'Index'){ // 当值不为app时,做过滤处理
        // 			$token = $res['token']; // 获取密钥
        // 			if(empty($token)){ // 当密钥不存在时, 非法入侵
        // 				echo json_encode(array('status'=>0,'err'=>'非法入侵！'));
        //           			exit();
        // 	        }
        // 		}
        // 	}
        // }
        /* 小程序过滤设置 结束 */

        // 检索这个模块动作堆线
        $actionstack = $controller->getActionStack();
        // 检索第一个条目
        $first = $actionstack->getFirstEntry();
        // 检索此条目的模块名
        $firstmodule = $first->getModuleName();
        // 搜索数组中是否存在指定的值,存在
        if(in_array($firstmodule,$this->candirect)){
            // 执行此链中的下一个筛选器
            foreach ($request->parameters as $k => $v){
                if(is_array($request->getParameter($k))){ // 是数组
                    foreach ($request->getParameter($k) as $key => $value) {
                        $typeArr[$key] = $value;
                    }
                }else if(is_string($v)){ // 是字符串
                    $v = htmlspecialchars($request->getParameter($k));
                    $v = addslashes($v);
                    $request->parameters[$k] = $v;
                }
            }
            $filterChain->execute();
        } else {
            if($this->getContext()->getUser()->isAuthenticated()){
                $name = $this->getContext()->getStorage()->read('admin_name'); // 获取管理员账号
                $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
                $store_id = $this->getContext()->getStorage()->read('store_id'); // 商城id
                $store_type = $this->getContext()->getStorage()->read('store_type');
                $mch_id = $this->getContext()->getStorage()->read('mch_id'); //店铺id
                $login_time = $this->getContext()->getStorage()->read('login_time'); // 登录时间
                $caozuo_time = $login_time + 10 * 60;
                $time = time();
                $db = DBAction::getInstance();

                $sql0 = "select product_number from lkt_product_number where store_id = '$store_id' and mch_id = '$mch_id' and operation = '$name' order by addtime desc limit 1";
                $r0 = $db->select($sql0);
                if($r0){
                    $product_number = $r0[0]->product_number;
                    $sql1 = "select id from lkt_product_list where store_id = '$store_id' and mch_id = '$mch_id' and product_number = '$product_number' ";
                    $r1 = $db->select($sql1);
                    if(empty($r1)){ // 不存在
                        $sql = "update lkt_product_number set status = 2 where store_id = '$store_id' and mch_id = '$mch_id' and operation = '$name' and product_number = '$product_number'";
                        $db->update($sql);
                    }
                }

                if($time > $caozuo_time){
//                    $sql = "select domain from lkt_config where id = 1";
//                    $rr = $db->select($sql);
//                    $domain = $rr[0]->domain;
//                    echo "<script language=JavaScript> parent.location.href='$domain';</script>";
//                    return;
                }else{
                    $this->getContext()->getStorage()->write('login_time',$time);
                }
                $permission_1 = array();
                $permission = array();
                $ara = array();
                if(empty($store_id)){
                    $sql = "select * from lkt_admin where name ='$name' and recycle = 0";
                }else{
                    if($admin_type1 != 2){
                        $sql = "select * from lkt_admin where store_id = '$store_id' and type = 1 and recycle = 0";
                    }else{
                        $sql = "select * from lkt_admin where name ='$name' and store_id = '$store_id' and recycle = 0";
                    }
                }
                if($admin_type1 == 0){ // 类型 0:系统管理员 1:客户 2:商城管理员
                    $sql = "select * from lkt_admin where name ='$name'";
                }else{
                    $sql = "select * from lkt_admin where name ='$name' and store_id = '$store_id'";
                }

                $r = $db->select($sql);
                if($r){
                    $admin_type = $r[0]->admin_type;
                    $token = $r[0]->token;
                    $role = explode (',',$r[0]->role); // 角色
                    if($token == '' && $admin_type1 != 0){
                        echo "<script>parent.location.href='index.php?module=Login&action=Logout';</script>";
                        return;
                    }
                }
                if($admin_type != 1){
                    foreach ($role as $k => $v){
                        $sql1 = "select b.id,b.type,b.url from lkt_role_menu as a left join lkt_core_menu as b on a.menu_id = b.id where a.role_id = '$v' and b.recycle = 0 ";
                        $r1 = $db->select($sql1);
                        if($r1){
                            foreach ($r1 as $k1 => $v1){
                                if($v1->type != '0') {
                                    $v1->title_name = Tools::header_data_dictionary($db, '导航栏', $v1->type);
                                    $role_list1[] = (array)$v1;
                                }
                                $permission_1[] = $v1->id;
                            }
                            foreach ($permission_1 as $k => $v){
                                // 查询模块表(模块名称、模块标识、模块描述)
                                $sql = "select url from lkt_core_menu where is_core = 0 and recycle = 0 and id = '$v' ";
                                $r_0 = $db->select($sql);
                                if($r_0 && $r_0[0]->url != ''){
                                    $ara[] = $r_0[0]->url;
                                }
                            }
                        }
                    }
                }

                foreach ($ara as $K => $v){
                    if(strpos($v,'?') !== false){
                        $permission[] = substr($v,17);
                    }else{
                        $permission[] = $v->url;
                    }
                }

                $permission[]="AdminLogin&action=Index";
                $permission[]="AdminLogin&action=maskContent";
                $permission[]="AdminLogin&action=changePassword";
                $permission[]="index&action=Index";
                $permission[]="end&action=Index";
                $permission[]="permission&action=Index";
                $permission[]="freight&action=Province";
                $permission[]="Customer&action=Index";
                $permission[]="go_group&action=addproduct";
                $permission[]="product&action=Ajax";
                $permission[]="product&action=Stick";
                $permission[]="product_class&action=Ajax";
                $permission[]="brand_class&action=Ajax";
                $permission[]="system&action=UploadImg";
                $permission[]="system&action=Fupload";
                $permission[]="software&action=group";
                $permission[]="seconds&action=member";
                $permission[]="invoice&action=ajax";
                $rew = $this->getContext()->getModuleName();
                $res =$request ->parameters; // 获取参数
                if($res){ // 存在
                    $module = $res['module']; // 获取module值
                    if(!empty($res['action'])){
                        $action = $res['action'];
                        $rew .= '&action=' . $res['action'];
                    }else{
                        $action = 'Index';
                        $rew .= '&action=Index';
                    }
                }
                if($r[0]->admin_type!=1 && !in_array($rew,$permission)){
                    header("Location: index.php?module=permission");
                    return;
                }else{
                    $urlt = 'index.php?module='.$rew;
                    $pages_nav1 = [];
                    //查找页面路径
                    $pages_nav = $this->find_pages($module,$action,$db,$store_id,$store_type);
                    foreach ($pages_nav as $k => $v){
                        $pages_nav1[] = (object)$v;
                    }
                    $_SESSION['pages_nav'] = $pages_nav1;

                    $filterChain->execute();
                }

            } else {
                $controller->redirect("index.php?module=Login");
            }
        }
        return;
    }

    public function initialize ($context, $params = null) {

        if($params['effect']){
            $this->effect = true;
        } else {
            $this->effect = false;
        }

        // initialize parent
        parent::initialize($context, $params);

        return true;

    }

    public function find_pages($module,$action,$db,$store_id,$m,$pages_nav = []){
        if($store_id){
            if(empty($m) || $m == ''){
                $sql = "select id,s_id,title,module,action,url from lkt_core_menu where module = '$module' and action = '$action' and is_core = 0 and recycle = 0 order by level asc";
            }else{
                $sql = "select id,s_id,title,module,action,url from lkt_core_menu where module = '$module' and action = '$action' and is_core = 0 and recycle = 0 and type = '$m' order by level asc";
            }
        }else{
            $sql = "select id,s_id,title,module,action,url from lkt_core_menu where module = '$module' and action = '$action' and is_core = 1 and recycle = 0 order by level asc";
        }
        $r = $db->select($sql);
        if($r){
            if(count($r) == 1){
                array_unshift($pages_nav,(array)$r[0]);
            }else{
                $pages_nav1 = array();
                foreach ($r as $k => $v){
                    if($v->title != '浏览' && $v->title != '查看'){
                        $pages_nav1[] = (array)$v;
                    }
                }
                $pages_nav = array_merge($pages_nav1,$pages_nav);
            }

            $sid = $r[0]->s_id;
            $sql = "select id,s_id,title,module,action,url from lkt_core_menu where id = '$sid'";
            $rr = $db->select($sql);

            if($rr[0]->module != '' && $rr[0]->action != ''){
                return $this->find_pages($rr[0]->module,$rr[0]->action,$db,$store_id,$m,$pages_nav);
            }else{
                array_unshift($pages_nav,(array)$rr[0]);

                return $pages_nav;
            }
        }else{
            return $pages_nav;
        }
    }


}

?>