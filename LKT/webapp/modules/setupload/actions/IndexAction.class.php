<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $res = $db -> select("select * from lkt_upload_set ");

        $local = array();
        $oss = array();
        $qiniu = array();
        $tenxun = array();
        if(!empty($res)){
            $upserver = $res[0]->upserver;
            foreach ($res as $k => $v) {
                if($v -> type == '本地'){
                    $local[$v -> attr] = $v -> attrvalue;
                }else if($v -> type == '阿里云OSS'){
                    $oss[$v -> attr] = $v -> attrvalue;
                }else if($v -> type == '七牛云'){
                    $qiniu[$v -> attr] = $v -> attrvalue;
                }else if($v -> type == '腾讯云'){
                    $tenxun[$v -> attr] = $v -> attrvalue;
                }
            }
        }else{
            $upserver = 2;
        }
        
        $request->setAttribute('upserver', isset($upserver) ? $upserver : '');

        $request->setAttribute("local",$local);
        $request->setAttribute("oss",$oss);
        $request->setAttribute("qiniu",$qiniu);
        $request->setAttribute("tenxun",$tenxun);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/setupload.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $param = $_POST;

        $db -> delete("delete from lkt_upload_set where id > 0");

        $upserver = '1';
        if($param['upserver'] == 'local'){
            $upserver = '1';
            if(empty($param['uploadImg_domain'])){
                echo json_encode(array('status' => '请填写图片上传域名！'));exit;
            }
            if(empty($param['uploadImg'])){
                echo json_encode(array('status' => '请填写本地存储位置！'));exit;
            }
        }else if($param['upserver'] == 'OSS'){
            $upserver = '2';
            if(empty($param['OSSBucket'])){
                echo json_encode(array('status' => '请填写存储空间名称！'));exit;
            }
            if($param['OSSzidingyi'] == 1){
                if(empty($param['OSSEndpoint'])){
                    echo json_encode(array('status' => '请填写Endpoint！'));exit;
                }
            }
            if(empty($param['OSSAccessKey'])){
                echo json_encode(array('status' => '请填写Access Key ID！'));exit;
            }
            if(empty($param['OSSAccessSecret'])){
                echo json_encode(array('status' => '请填写Access Key Secret！'));exit;
            }

            $config = str_replace('AccessId', $param['OSSAccessKey'], $config);
            $config = str_replace('AccessKey', $param['OSSAccessSecret'], $config);
            $config = str_replace('Endpoint', $param['OSSEndpoint'], $config);
            $config = str_replace('bucket', $param['OSSBucket'], $config);
            file_put_contents(MO_LIB_DIR . '/aliyun-oss-php-sdk-2.3.0/samples/Config.php', $config);
        }else if($param['upserver'] == 'tenxun'){
            $upserver = '3';
        }else if($param['upserver'] == 'qiniu'){
            $upserver = '4';
        }

        $sql0 = "update lkt_config set upserver = '$upserver' ";
        $db->update($sql0);

//        $sql = "insert into lkt_upload_set(upserver,type,attr,attrvalue)
//            values ('$upserver','本地','uploadImg_domain','" . $param['uploadImg_domain'] . "'),
//            ('$upserver','本地','uploadImg','" . $param$param['uploadImg'] . "'),
//            ('$upserver','阿里云OSS','Bucket','" . $param['OSSBucket'] . "'),
//            ('$upserver','阿里云OSS','Endpoint','" . $param['OSSEndpoint'] . "'),
//            ('$upserver','阿里云OSS','isopenzdy','" . $param['OSSzidingyi'] . "'),
//            ('$upserver','阿里云OSS','AccessKeyID','" . $param['OSSAccessKey'] . "'),
//            ('$upserver','阿里云OSS','AccessKeySecret','" . $param['OSSAccessSecret'] . "'),
//            ('$upserver','阿里云OSS','imagestyle','" . $param['OSSimgstyleapi'] . "'),
//            ('$upserver','腾讯云','Bucket','" . $param['tenxunBucket'] . "'),
//            ('$upserver','腾讯云','Endpoint','" . $param['tenxunEndpoint'] . "'),
//            ('$upserver','腾讯云','zidingyi','" . $param['tenxunzidingyi'] . "'),
//            ('$upserver','腾讯云','SecretId','" . $param['tenxunAccessKey'] . "'),
//            ('$upserver','腾讯云','SecretKey','" . $param['tenxunAccessSecret'] . "'),
//            ('$upserver','七牛云','Bucket','" . $param['qiniuBucket'] . "'),
//            ('$upserver','七牛云','Endpoint','" . $param['qiniuEndpoint'] . "'),
//            ('$upserver','七牛云','AccessKey','" . $param['qiniuAccessKey'] . "'),
//            ('$upserver','七牛云','SecretKey','" . $param['qiniuAccessSecret'] . "'),
//            ('$upserver','七牛云','imagestyle','" . $param['qiniuimgstyleapi'] . "')";
        $sql = "insert into lkt_upload_set(upserver,type,attr,attrvalue) 
            values ('$upserver','本地','uploadImg_domain','" . $param['uploadImg_domain'] . "'),
            ('$upserver','本地','uploadImg','" . $param['uploadImg'] . "'),
            ('$upserver','阿里云OSS','Bucket','" . $param['OSSBucket'] . "'),
            ('$upserver','阿里云OSS','Endpoint','" . $param['OSSEndpoint'] . "'),
            ('$upserver','阿里云OSS','isopenzdy','" . $param['OSSzidingyi'] . "'),
            ('$upserver','阿里云OSS','AccessKeyID','" . $param['OSSAccessKey'] . "'),
            ('$upserver','阿里云OSS','AccessKeySecret','" . $param['OSSAccessSecret'] . "'),
            ('$upserver','阿里云OSS','imagestyle','" . $param['OSSimgstyleapi'] . "')";
        $res = $db -> insert($sql);

        $patharr = array(
            'OSS' => 'https://' . $param['OSSBucket'] . '.' . $param['OSSEndpoint'],
            'tenxun' => 'https://' . $param['tenxunBucket'] . '.' . $param['tenxunEndpoint'],
            'qiniu' => 'https://' . $param['qiniuBucket'] . '.' . $param['qiniuEndpoint']
        );
        $this->getContext()->getStorage()->write('serverURL',$patharr);

        if($res > 0){
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改图片管理成功',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改图片管理成功';
            $lktlog->customerLog($Log_content);
            $db->commit();

            echo json_encode(array('code' => 1));exit;
        }else{
            $JurisdictionAction->admin_record($store_id,$admin_name,'修改图片管理失败',1);
            $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改图片管理失败';
            $lktlog->customerLog($Log_content);
            $db->rollback();

            echo json_encode(array('code' => 0));exit;
        }
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
}
?>