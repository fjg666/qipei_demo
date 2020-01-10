<?php

class UploadImgAction extends Action {

    public function getDefaultView() {
        return View :: INPUT;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        //软件类型
        $group_id = $request->getParameter('group_id') ? $request->getParameter('group_id'):'-1';//分组ID

        $log = new LaiKeLogUtils('common/system.log');// 日志

        $sql0 = "select upserver from lkt_upload_set limit 1";
        $r0 = $db->select($sql0);
        if($r0){
            $upload_mode = $r0[0]->upserver;// 上传服务器:1,本地　2,阿里云 3,腾讯云 4,七牛云
        }else{
            $upload_mode = '2';
        }

        if($upload_mode == '1'){// 本地
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
                $store_id = 0;
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
                $imgURL=($_FILES[$name]['tmp_name']);

                $type = str_replace('image/', '.', $_FILES[$name]['type']);
                $imgURL_name=time().mt_rand(1,1000).$type;

                move_uploaded_file($imgURL,$uploadImg.$imgURL_name);
                $image = $uploadImg . $imgURL_name;
                $url = $img.$imgURL_name;
                $data = array('extension' => $type,'size' => $_FILES[$name]['size'] ,'type' => "image",'url' => $url);

                // 上传文件记录表
                $fsql = " INSERT INTO `lkt_files_record` ( `store_id`, `store_type`, `group`, `upload_mode`, `image_name`) VALUES ('$store_id', '$store_type', '$group_id', '$upload_mode', '$imgURL_name') ";
                $res = $db->insert($fsql);
                $log -> customerLog(__LINE__.":上传文件【".$res."】: $fsql \r\n");

            }else{
                $data = array();
                $error = 5;$image = '';$msg = '文件大小为0';
            }
        }else if($upload_mode == '2'){
            $this -> OSSupload();
            return;
        }

        echo json_encode(array("error"=>$error,"url"=>$image,'data'=>$data,'message'=>$msg,'name'=>$imgURL_name));
        return;
    }

    public function OSSupload(){
        $admin_name = $this->getContext()->getStorage()->read('admin_name'); // 管理员账号
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $group_id = $this->getContext()->getRequest()->getParameter('group_id') ? $this->getContext()->getRequest()->getParameter('group_id'):'-1';//分组ID
        $log = new LaiKeLogUtils('common/system.log');// 日志
        $store_id = $store_id != null?$store_id:0;
        $store_type = $store_type != null?$store_type:'0';
        $dir = $store_id . '/' . $store_type . '/';

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

            $imgURL = $_FILES[$name]['tmp_name'];
            $type = str_replace('image/', '.', $_FILES[$name]['type']);
            $imgURL_name = time().mt_rand(1,1000).$type;
            $path = $dir . $imgURL_name;
            $common = LKTConfigInfo::getOSSConfig();
            try {
                $ossClient = OSSCommon::getOSSClient();
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
            $log -> customerLog(__LINE__.":上传文件【".$res."】: $fsql \r\n");
            echo json_encode(array("error"=>$error,"url"=>$url,'data'=>$data,'message'=>$msg,'name'=>$imgURL_name));
            return;
        }
    }

    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 周文
     * @date 2019年1月7日
     * @version 2.0
     * @$file string 图片临时存放路径
     * @$bili float 图片宽高比例参数
     */
    public function checkimg($file,$bili = 1024/768){
        if(file_exists($file)){
            $images = getimagesize($file);
            if(!empty($images)){
                $imgwh = $images[0]/$images[1];   //获得图片真实宽高比
                if($imgwh == $bili){
                    return true;                 //图片尺寸合格
                }
            }
        }
        return false;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}
?>