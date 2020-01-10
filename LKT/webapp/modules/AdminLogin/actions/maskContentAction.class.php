<?php
require_once(MO_LIB_DIR . '/version.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class maskContentAction extends Action
{


    public function getDefaultView()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 接收信息
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $admin_id = $this->getContext()->getStorage()->read('admin_id');
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $group_id = $request->getParameter('group_id') ? $request->getParameter('group_id'):'-1';//分组ID

        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        $portrait = addslashes(trim($request->getParameter('portrait')));//头像
        $nickname = addslashes(trim($request->getParameter('name')));//昵称
//        $birthday = addslashes(trim($request->getParameter('birthday')));//生日
        $sex = addslashes(trim($request->getParameter('sex')));//性别（1.男 2. 女）
        $tel = addslashes(trim($request->getParameter('tel')));//手机号码
        $year = addslashes(trim($request->getParameter('year')));//手机号码
        $mouth = addslashes(trim($request->getParameter('mouth')));//手机号码
        $day = addslashes(trim($request->getParameter('day')));//手机号码

//        $storeImg = addslashes(trim($request->getParameter('storeImg')));//店铺头像
        $shop_name = addslashes(trim($request->getParameter('shop_name')));//店铺名称
        $shop_range = addslashes(trim($request->getParameter('shop_range')));//经营范围
        $shop_information = addslashes(trim($request->getParameter('shop_information')));//店铺信息
        // 根据id查询管理员信息
        $sql = "select * from lkt_admin where name = '$admin_name'";
        $r = $db->select($sql);
        if (!$r) {
            $res = array('status' => '1', 'info' => '没有该用户');
            echo json_encode($res);
            exit();
        }else{
            if($r[0]->birthday != ''){
                $arr = explode('-',$r[0]->birthday);
                $r[0]->year = $arr[0];
                $r[0]->mouth = $arr[1];
                $r[0]->day = $arr[2];
            }
            $admintype = $r[0]->type;


            $r[0]->portrait = ServerPath::getimgpath($r[0]->portrait,$store_id);

            if($store_id){
                if($admintype == 0 || $admintype == 1 || $admintype == 2){ // 商城店铺
                    $sql0 = "select shop_id from lkt_admin where store_id = '$store_id'";
                }else{
                    $sql0 = "select shop_id from lkt_admin where store_id = '$store_id' and id = '$admin_id'";
                }
                $r0 = $db->select($sql0);
                $shop_id = $r0[0]->shop_id;

                $sql1 = "select * from lkt_mch where store_id = '$store_id' and id = '$shop_id'";
                $r1 = $db->select($sql1);
                if($r1){
                    $shop_logo = $r1[0]->logo;
                    $r[0]->logo = ServerPath::getimgpath($r1[0]->logo,$store_id);
                    $r[0]->shop_name = $r1[0]->name;
                    $r[0]->shop_range = $r1[0]->shop_range;
                    $r[0]->shop_information = $r1[0]->shop_information;
                }else{
                    $shop_logo = '';
                    $r[0]->logo = '';
                    $r[0]->shop_name = '';
                    $r[0]->shop_range = '';
                    $r[0]->shop_information = '';
                }
            }
        }

        //进入正式添加---开启事物
        $db->begin();

        if($store_id ){ // 商城编辑基本信息
            if (!empty($shop_name) || !empty($shop_range) || !empty($shop_information)) {
                if(isset($_FILES['fileStoreImg'])){
                    $upserver = "2";
                    $sql0 = "select upserver from lkt_upload_set limit 1";
                    $r0 = $db->select($sql0);
                    if($r0){
                        $upserver = $r0[0]->upserver;
                    }else{
                        $upserver = '2';
                    }

                    $upload_mode = $upserver;
                    if($upserver == '1'){
                        $sql1 = "select attr,attrvalue from lkt_upload_set where type = '本地'";
                        $r1 = $db->select($sql1);
                        foreach ($r1 as $k => $v){
                            if($v->attr == 'uploadImg_domain'){
                                $uploadImg_domain = $v->attrvalue; // 图片上传域名
                            }else if($v->attr == 'uploadImg'){
                                $uploadImg = $v->attrvalue; // 图片上传位置
                            }
                        }

                        if($store_id){
                            $uploadImg = $uploadImg.'image_'.$store_id.'/';
                        }else{
                            $uploadImg = $uploadImg.'image_0/';
                        }

                        if(is_dir($uploadImg) == ''){ // 如果文件不存在
                            mkdir($uploadImg); // 创建文件
                        }

                        if(strpos($uploadImg,'./') === false){ // 判断字符串是否存在 ../
                            $img = $uploadImg_domain . $uploadImg; // 图片路径
                        }else{
                            $img = $uploadImg_domain . substr($uploadImg,1); // 图片路径
                        }

                        $imgURL_name = '';

                        if(isset($_FILES)){

                            $name = '';
                            foreach ($_FILES as $key => $value) {
                                $name = $key;
                            }
                            $error = $_FILES[$name]['error'];
                            switch($_FILES[$name]['error']){
                                case 0: $msg = ''; break;
                                case 1: $msg = '超出了php.ini中文件大小'; break;
                                case 2: $msg = '超出了MAX_FILE_SIZE的文件大小'; break;
                                case 3: $msg = '文件被部分上传'; break;
                                case 4: $msg = '没有文件上传'; break;
                                case 5: $msg = '文件大小为0'; break;
                                default: $msg = '上传失败'; break;
                            }
                            $upload_max_filesize = ini_get('upload_max_filesize');

                            if($_FILES[$name]['tmp_name']){
                                $imgURL=($_FILES[$name]['tmp_name']);
                                $type = str_replace('image/', '.', $_FILES[$name]['type']);
                                $imgURL_name=time().mt_rand(1,1000).$type;

                                move_uploaded_file($imgURL,$uploadImg.$imgURL_name);
                                $image = $uploadImg . $imgURL_name;
                                $url = $img.$imgURL_name;
                                $data = array('extension' => $type,'size' => $_FILES[$name]['size'] ,'type' => "image",'url' => $url);

                                $fsql = " INSERT INTO `lkt_files_record` ( `store_id`, `store_type`, `group`, `upload_mode`, `image_name`) VALUES ('$store_id', '$store_type', '$group_id', '$upload_mode', '$imgURL_name') ";
                                $res = $db->insert($fsql);
                            }else{
                                $imgURL_name = $shop_logo;
                            }
                        }else{
                            $data = [];
                            $error = 5;$image = '';$msg = '文件大小为0';
                        }
                        $storeImg = $imgURL_name;
                    }else if($upserver == '2'){
                        $storeImg = $this -> OSSupload();
                        if($storeImg == ''){
                            $storeImg = $shop_logo;
                        }

                    }
                }

                $sql02_1 = "select * from lkt_mch where store_id = '$store_id' and id = '$shop_id'";
                $r02_1 = $db->select($sql02_1);
                if($r02_1){
                    $sql02 = "update lkt_mch set logo = '$storeImg',name = '$shop_name',shop_range = '$shop_range',shop_information = '$shop_information' where store_id = '$store_id' and id = '$shop_id'";
                    $r02 = $db->update($sql02);
                }else{
                    $sql0 = "select name from lkt_admin where store_id = '$store_id' and type = 1";
                    $r0 = $db->select($sql0);
                    $user_id = $r0[0]->name; // 客户账号

                    $sql02 = "insert into lkt_mch(store_id,user_id,name,shop_range,shop_information,logo,review_status,add_time) values ('$store_id','$user_id','$shop_name','$shop_range','$shop_information','$storeImg',1,CURRENT_TIMESTAMP)";
                    $r02 = $db->insert($sql02, 'last_insert_id'); // 得到添加数据的id

                    $this->getContext()->getStorage()->write('mch_id',$r02);//写入缓存

                    $sql03 = "update lkt_admin set shop_id = '$r02' where store_id = '$store_id' and type = 1";
                    $r03 = $db->update($sql03);
                }
                if ($r02 == -1) {
                    $db->admin_record($store_id, $admin_name, '修改基本信息失败', 2);

                    $db->rollback();

                    $res = array('status' => '2', 'info' => '未知原因，修改失败!', 're' => $r);
                    echo json_encode($res);
                    exit();
                } else {

                    $sql = "select admin_id from lkt_customer where id = '$store_id'";
                    $rr = $db->select($sql);
                    if($rr){
                        if($rr[0]->admin_id == $r[0]->id){
                            $sql = "update lkt_customer set mobile = '$tel' where id = '$store_id'";
                            $db->update($sql);
                        }
                    }
                }
            }else {
                $res = array('re' => $r);
                echo json_encode($res);
                exit();
            }
        }

        if (!empty($portrait) || !empty($nickname) || !empty($birthday) || !empty($sex) || !empty($tel)) {
            $portrait = preg_replace('/.*\//','',$portrait);
            $birthday = $year . '-' . $mouth . '-' . $day;

            $sql01 = "update lkt_admin set portrait = '$portrait',nickname = '$nickname',birthday = '$birthday',sex = '$sex',tel = '$tel' where name ='$admin_name'";
            $r01 = $db->update($sql01);
            if ($r01 == -1 ) {
                $db->rollback();

                $db->admin_record($store_id, $admin_name, '修改基本信息失败', 2);
                $res = array('status' => '2', 'info' => '未知原因，修改失败!', 're' => $r);
                echo json_encode($res);
                exit();
            }

            $db->commit();

            $db->admin_record($store_id, $admin_name, '修改基本信息成功', 2);
            $res = array('status' => '3', 'info' => '修改成功！', 're' => $r);
            echo json_encode($res);
            exit();
        } else {
            $res = array('re' => $r);
            echo json_encode($res);
            exit();
        }



        return View :: INPUT;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        return;
    }

    public function getRequestMethods()
    {
        return Request :: NONE;
    }

    public function OSSupload(){
        $db = DBAction::getInstance();
        $group_id = $this->getContext()->getRequest()->getParameter('group_id') ? $this->getContext()->getRequest()->getParameter('group_id'):'-1';//分组ID
        //软件类型
        $store_type = $this->getContext()->getStorage()->read('store_type');
        // //用户id
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $store_id = $store_id != null?$store_id:1;
        $store_type = $store_type != null?$store_type:'0';
        $dir = $store_id . '/' . $store_type . '/';

        $ossClient = OSSCommon::getOssClient();
        $common = LKTConfigInfo::getOSSConfig();

        if(!empty($_FILES)){
            $name = '';
            foreach ($_FILES as $key => $value) {
                $name = $key;
            }

            $error = $_FILES[$name]['error'];
            switch($_FILES[$name]['error']){
                case 0: $msg = ''; break;
                case 1: $msg = '超出了php.ini中文件大小'; break;
                case 2: $msg = '超出了MAX_FILE_SIZE的文件大小'; break;
                case 3: $msg = '文件被部分上传'; break;
                case 4: $msg = '没有文件上传'; break;
                case 5: $msg = '文件大小为0'; break;
                default: $msg = '上传失败'; break;
            }
            if($_FILES[$name]['tmp_name']){
                $imgURL = $_FILES[$name]['tmp_name'];

                $type = str_replace('image/', '.', $_FILES[$name]['type']);
                $imgURL_name = time().mt_rand(1,1000).$type;
                $path = $dir . $imgURL_name;
                try {
                    $ossClient->uploadFile($common['bucket'], $path, $imgURL);
                } catch (OssException $e) {
                    printf(__FUNCTION__ . ": FAILED\n");
                    printf($e->getMessage() . "\n");
                    return;
                }

                $url = 'https://' . $common['bucket'] . '.' . $common['endpoint'] . '/' . $path;
                $data = array('extension' => $type,'size' => $_FILES[$name]['size'] ,'type' => "image",'url' => $url);

                $db = DBAction::getInstance();
                $fsql = " INSERT INTO `lkt_files_record` ( `store_id`, `store_type`, `group`, `upload_mode`, `image_name`) VALUES ('$store_id', '$store_type', '$group_id', '2', '$imgURL_name') ";
                $res = $db->insert($fsql);
            }else{
                $imgURL_name = '';
            }

            return $imgURL_name;

        }
    }
}

?>