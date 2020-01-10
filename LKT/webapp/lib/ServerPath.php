<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');

class ServerPath{
	 public static $serverURL = null;
     public static $imgpath = null;

     public static function getimgpath($img){
        $db = DBAction::getInstance();
        //$request = $this->getContext()->getRequest();
        $store_id = isset($_GET['store_id'])?$_GET['store_id']:1;

        $sql = "select * from lkt_files_record where store_id = '$store_id' and image_name='$img'";
        $res = $db -> select($sql);

        // 查询系统参数
        if(self::$imgpath == null){
            $sql1 = "select * from lkt_config where store_id = '$store_id'";
            $r_1 = $db->select($sql1);
            $uploadImg_domain = $r_1[0]->uploadImg_domain; // 图片上传域名
            $uploadImg = $r_1[0]->uploadImg; // 图片上传位置
            if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
                $imgpath = $uploadImg_domain . $uploadImg; // 图片路径
            }else{ // 不存在
                $imgpath = $uploadImg_domain . substr($uploadImg,2); // 图片路径
            }
            self::$imgpath = $imgpath;
            
        }
        $serverURL = array(
                'OSS' => 'https://',
                'qiniu' => 'https://',
                'tenxun' => 'https://'
            );
        if(self::$serverURL == null){
            $serversql = "select * from lkt_upload_set where and attr in ('Bucket','Endpoint')";
            $serverres = $db -> select($serversql);
            
            if(!empty($serverres)) {
                foreach ($serverres as $k => $v) {
                    if($v -> type == '阿里云OSS'){
                        if($v -> attr == 'Bucket'){
                            $OSS['Bucket'] = $v -> attrvalue;
                        }
                        if($v -> attr == 'Endpoint'){
                            $OSS['Endpoint'] = $v -> attrvalue;
                        }
                    }
                    if($v -> type == '七牛云'){
                        if($v -> attr == 'Bucket'){
                            $qiniu['Bucket'] = $v -> attrvalue;
                        }
                        if($v -> attr == 'Endpoint'){
                            $qiniu['Endpoint'] = $v -> attrvalue;
                        }
                    }
                    if($v -> type == '腾讯云'){
                        if($v -> attr == 'Bucket'){
                            $tenxun['Bucket'] = $v -> attrvalue;
                        }
                        if($v -> attr == 'Endpoint'){
                            $tenxun['Endpoint'] = $v -> attrvalue;
                        }
                    }
                }
                $serverURL['OSS'] .= $OSS['Bucket'] . '.' . $OSS['Endpoint'];
                $serverURL['qiniu'] .= $qiniu['Bucket'] . '.' . $qiniu['Endpoint'];
                $serverURL['tenxun'] .= $tenxun['Bucket'] . '.' . $tenxun['Endpoint'];
            }
            
            self::$serverURL = $serverURL;
        }
        
        if($img == ''){
            return $img;
        }

        if(!empty($res)){
            $store_type = $res[0] -> store_type;
            $upload_mode = $res[0] -> upload_mode;
            if($upload_mode == 2){
                $image = self::$serverURL['OSS'] . '/' . $store_id . '/' . $store_type . '/' .$img;
            }else if($upload_mode == 3){
                $image = self::$serverURL['tenxun'] . '/' . $store_id . '/' . $store_type . '/' .$img;
            }else if($upload_mode == 4){
                $image = self::$serverURL['qiniu'] . '/' . $store_id . '/' . $store_type . '/' .$img;
            }else{
                $image = self::$imgpath . $img;
            }
        }else{
            $image = self::$imgpath . $img;
        }

        return $image;
    }
    
}



?>
