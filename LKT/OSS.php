<?php

require_once(dirname(__FILE__) . '/DBAction.php');
require_once(dirname(__FILE__) . '/aliyun-oss-php-sdk/samples/Common.php');


$store_id = isset($_GET['store_id']) && $_GET['store_id'] != null?$_GET['store_id']:1;
$store_type = isset($_GET['store_type']) && $_GET['store_type'] != null?$_GET['store_type']:'app';
$dir = $store_id . '/' . $store_type . '/';

$config = file_get_contents(__DIR__ . '/aliyun-oss-php-sdk/samples/Configtpl.php');
$db = DBAction::getInstance();
        $sql = "select attr,attrvalue from lkt_upload_set where type='阿里云OSS'";
        $res = $db -> select($sql);
        
        if (!empty($res)) {
            foreach ($res as $k => $v) {
                if($v -> attr == 'AccessKeyID'){
                    $AccessId = $v -> attrvalue;
                }
                if($v -> attr == 'AccessKeySecret'){
                    $AccessKey = $v -> attrvalue;
                }
                if($v -> attr == 'Bucket'){
                    $bucket = $v -> attrvalue;
                }
                if($v -> attr == 'Endpoint'){
                    $Endpoint = $v -> attrvalue;
                }
            }           
        }

$config = str_replace('AccessId', $AccessId, $config);
$config = str_replace('AccessKey', $AccessKey, $config);
$config = str_replace('Endpoint', $Endpoint, $config);
$config = str_replace('bucket', $bucket, $config);
file_put_contents(__DIR__ . '/aliyun-oss-php-sdk/samples/Config.php', $config);

$ossClient = Common::getOssClient();


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
    try {
        $ossClient->uploadFile(Common::bucket, $path, $imgURL);
    } catch (OssException $e) {
        printf(__FUNCTION__ . ": FAILED\n");
        printf($e->getMessage() . "\n");
        return;
    }
    
    $url = 'https://' . $bucket . '.' . $Endpoint . '/' . $path;
    $data = array('extension' => $type,'size' => $_FILES[$name]['size'] ,'type' => "image",'url' => $url);

    $db = DBAction::getInstance();
    $fsql = " INSERT INTO `lkt_files_record` ( `store_id`, `store_type`, `group`, `upload_mode`, `image_name`) VALUES ('$store_id', '$store_type', '1', '2', '$imgURL_name') ";
    $res = $db->insert($fsql);
    
    echo json_encode(array("error"=>$error,"url"=>$url,'data'=>$data,'message'=>$msg,'name'=>$imgURL_name));
        return;
    
}
 
?>