<?php
class IndexAction extends LaiKeAction {

    // getContext() 检索当前应用程序上下文。
    // getRequest() 检索请求。
    // getUser() 检索用户。
    // setAuthenticated() 设置该用户的身份验证状态。
    // setAttribute() 设置一个属性。
    // strtolower() 把所有字符转换为小写
    // getParameter() 获取参数
    // unserialize() 从已存储的表示中创建 PHP 的值
    // getStorage() 检索存储。
    // write() 将数据写入此存储。
    // redirect() 将请求重定向到另一个URL。
    // isset() 检测变量是否设置
    // trim() 去除字符串首尾处的空白字符
    public function getDefaultView() {
        $db=DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $this->getContext()->getUser()->setAuthenticated(false);
        $request->setAttribute("name",$request->getParameter("name"));
        $request->setAttribute("password",$request->getParameter("password"));

        $sql = "select * from lkt_system_tell where id=(select max(id) as id from lkt_system_tell)";
        $res = $db -> select($sql);

        if(!empty($res)){
            $res = $res[0];

            $request->setAttribute("res", $res);
        }
        return View :: INPUT;
    }

    public function getClientIp($type = 0,$client=true)
    {
        $type = $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($client){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // 防止IP伪造
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    public function execute(){
        $db=DBAction::getInstance();
        // 获取输入的信息
        $request = $this->getContext()->getRequest();

        // 获取输入的客户编号
        $customer_number = addslashes(trim($request->getParameter("customer_number")));
        // 获取输入的用户名
        $name = addslashes(trim($request->getParameter("login")));
        // 获取输入的密码
        $password = md5($request->getParameter("pwd"));

        if($name == '' || $password == ''){
            echo json_encode(array('status'=>0,'info'=>'请输入账号和密码！'));
            exit();
        };
        $day = '';
        if($customer_number != ''){ // 客户编号不为空，不是系统管理员
            // 查询客户编号是否存在
            $sql = "select id from lkt_customer where customer_number = '$customer_number'";
            $r = $db->select($sql);
            if(empty($r)){
                echo json_encode(array('status'=>0,'info'=>'请输入正确客户编号！'));
                exit();
            }else{
                $store_id1 = $r[0]->id; // 商城id
                // 根据商城id、管理员账号，查询管理员信息
                $sql = "select id,name,password,admin_type,permission,type,status,store_id,login_num,shop_id from lkt_admin where name = '$name' and recycle = 0 and store_id = '$store_id1'";
                $result = $db->select($sql);
                if($result == false){
                    echo json_encode(array('status'=>0,'info'=>'账号错误！'));
                    exit();
                }
            }
        }else{ // 客户编号为空,系统管理员
            // 根据管理员账号，查询管理员信息
            $sql = "select id,name,password,admin_type,permission,type,status,store_id,login_num,shop_id from lkt_admin where name = '$name' and recycle = 0 and store_id = 0 ";
            $result = $db->select($sql);

            if($result == false){
                echo json_encode(array('status'=>0,'info'=>'账号错误！'));
                exit();
            }
        }
        $admin_id = $result[0]->id; // 管理员id
        $admin_name = $result[0]->name; // 管理员账号
        $login_password = $result[0]->password; // 管理员密码
        $admin_type = $result[0]->admin_type; // 管理类型
        $admin_permission = $result[0]->permission; // 许可
        $admin_type1 = $result[0]->type; // 类型 0:系统管理员 1:客户 2:商城管理员 3:店主
        $shop_id = $result[0]->shop_id; // 店主id
        $status = $result[0]->status; // 状态 1:禁用 2：启用
        $login_num = $result[0]->login_num; // 登录次数
        if($admin_type == 1){
            $store_id = 0;
        }else{
            $store_id = $result[0]->store_id;
            if($store_id == 0){

            }else{
                $sql = "select * from lkt_customer where id = '$store_id'";
                $r = $db->select($sql);
                $end_date = $r[0]->end_date; // 到期时间
                $time = date('Y-m-d H:i:s'); // 当前时间
                $time1 = date("Y-m-d",strtotime("$end_date -1 week")); // 还有7天到期
                if($end_date <= $time){ // 当前时间 大于等于 到期时间 禁止登陆
                    echo json_encode(array('status'=>0,'info'=>'您的授权已到期，请联系客服完成续费再使用，谢谢！'));
                    exit();
                }
                if($time >= $time1){ // 当前时间 大于等于 7天到期时间  提醒客户
                    $day =  bcdiv(strtotime($end_date)-strtotime($time),(60 * 60 * 24));
                }
            }
        }
        if($login_password == $password){
            if($login_num >= 3){
                echo json_encode(array('status'=>0,'info'=>'账号已锁定，请联系客服！'));
                exit();
            }
            if($status == 1){
                echo json_encode(array('status'=>0,'info'=>'账号已被禁止！'));
                exit();
            }
            $sql = "update lkt_admin set login_num = 0 where name = '$name'";
            $db->update($sql);
        }else{
            if($admin_type != 1){
                $sql = "update lkt_admin set login_num = login_num+1 where name = '$name'";
                $db->update($sql);
            }
            if($login_num + 1 >= 3){
                $sql = "update lkt_admin set status = 1 where name = '$name'";
                $db->update($sql);

                echo json_encode(array('status'=>0,'info'=>'账号已锁定，请联系客服！'));
                exit();
            }
            // 没有查询到匹配值就在lkt_record表里添加一组数据
            $sql="insert into lkt_record (store_id,user_id,event) values ('$store_id','$name','登录密码错误') ";
            $r= $db -> update($sql);
            echo json_encode(array('status'=>0,'info'=>'密码错误！'));
            exit();
        }

        // 生成session_id
        $access_token = session_id();
        //修改token
        $ip = $this->getClientIp();

        $aid = $result[0]->id;
        $sql = "update lkt_admin set token = '$access_token',ip = '$ip' where id = '$aid'";
        $db -> update($sql);

        $db->admin_record($store_id,$name,' 登录成功 ',0);

        $serversql = "select * from lkt_upload_set where attr in ('Bucket','Endpoint')";
        $serverres = $db -> select($serversql);


        $serverURL = array(
            'OSS' => 'https://',
            'qiniu' => 'https://',
            'tenxun' => 'https://'
        );

        if(!empty($serverres)) {
            foreach ($serverres as $k => $v) {
                if($v -> type == '阿里云OSS'){
                    if($v -> attr == 'Bucket'){
                        $OSS['Bucket'] = $v -> attrvalue;
                        $serverURL['OSS'] .= $OSS['Bucket'] ;
                    }
                    if($v -> attr == 'Endpoint'){
                        $OSS['Endpoint'] = $v -> attrvalue;
                        $serverURL['OSS'] .= '.' . $OSS['Endpoint'];
                    }

                }
                if($v -> type == '七牛云'){
                    if($v -> attr == 'Bucket'){
                        $qiniu['Bucket'] = $v -> attrvalue;
                        $serverURL['qiniu'] .= $qiniu['Bucket'];
                    }
                    if($v -> attr == 'Endpoint'){
                        $qiniu['Endpoint'] = $v -> attrvalue;
                        $serverURL['qiniu'] .= '.' . $qiniu['Endpoint'];
                    }
                }
                if($v -> type == '腾讯云'){
                    if($v -> attr == 'Bucket'){
                        $tenxun['Bucket'] = $v -> attrvalue;
                        $serverURL['tenxun'] .= $tenxun['Bucket'];
                    }
                    if($v -> attr == 'Endpoint'){
                        $tenxun['Endpoint'] = $v -> attrvalue;
                        $serverURL['tenxun'] .= '.' . $tenxun['Endpoint'];
                    }

                }
            }
            $this->getContext()->getStorage()->write('serverURL',$serverURL);
        }

        $this->getContext()->getStorage()->write('serverURL',$serverURL);

        // 设置该用户为登录状态
        $this->getContext()->getUser()->setAuthenticated(true);

        $login_time = time();
        $store_type1 = '';
        $this->getContext()->getStorage()->write('login_time',$login_time);
        $this->getContext()->getStorage()->write('store_id',$store_id);
        $this->getContext()->getStorage()->write('store_type',$store_type1);

        $this->getContext()->getStorage()->write('admin_id',$admin_id);
        $this->getContext()->getStorage()->write('admin_name',$admin_name);
        $this->getContext()->getStorage()->write('admin_type',$admin_type);
        $this->getContext()->getStorage()->write('admin_type1',$admin_type1);
        $this->getContext()->getStorage()->write('mch_id',$shop_id);
        $this->getContext()->getStorage()->write('admin_permission',$admin_permission);
        // 登录成功后跳转地址
        if($day == ''){
            echo json_encode(array('status'=>1,'info'=>'登录成功！'));
            exit();
        }else{
            if($day == 0){
                $day = '今';
            }
            echo json_encode(array('status'=>1,'info'=>'您的账号还有'.$day.'天到期，请及时续费！'));
            exit();
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}

?>