<?php

require_once dirname(dirname(__DIR__))."/vendor/autoload.php";

/**
 * 阿里云OSS帮助类
 * Class OSSCommon
 */
class OSSCommon
{

    /**
     * 获取OSS 配置信息
     * @return array
     */
    public static function getOSSConfig(){
        return LKTConfigInfo::getOSSConfig();
    }

    /**
     * 获取OSS 客户端
     * @return OssClient
     * @throws Exception
     */
    public static function getOSSClient(){
        $ossconfig = OSSCommon::getOSSConfig();
        if(empty($ossconfig)){
            throw new Exception("获取OSS客户端失败!");
        }
        $accessKeyId = $ossconfig['accessKeyId'];
        $accessKeySecret = $ossconfig['accessKeySecret'];
        $endpoint = $ossconfig['endpoint'];
        try {
            $ossClient = new OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
            return $ossClient;
        } catch (OssException $e) {
            throw new Exception($e->getMessage());
        }
    }
}