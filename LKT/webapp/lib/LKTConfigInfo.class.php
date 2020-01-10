<?php

require_once ('DBAction.class.php');

/**
 * LKT 来客推配置信息获取类
 */
class LKTConfigInfo
{



    function __construct()
    {

    }

    /**
     * 阿里云OSS配置信息
     */
    public static function getOSSConfig(){//oss配置为所有商户使用，store_id为1 

        $db = DBAction::getInstance();
        $sql = "select attr,attrvalue from lkt_upload_set where type = '阿里云OSS'";
        $res = $db->select($sql);

        $oss = array();

        if($res){
           
            // $oss['bucket'] = $attrvalue[5]->attrvalue;
            // $oss['endpoint'] = $attrvalue[4]->attrvalue;
            // $oss['accessKeyId'] = $attrvalue[3]->attrvalue;
            // $oss['accessKeySecret'] = $attrvalue[1]->attrvalue;
            foreach ($res as $k => $v) {
                $attr = $v->attr;
                $attrvalue = $v->attrvalue;
              
                switch ($attr) {
                    case 'AccessKeySecret':
                         $oss['accessKeySecret'] = $attrvalue;
                        break;

                    case 'AccessKeyID':
                         $oss['accessKeyId'] = $attrvalue;
                       break; 
                    case 'Endpoint':
                     $oss['endpoint'] = $attrvalue;
                        break;   
                    case 'Bucket':
                     $oss['bucket'] = $attrvalue;
                     break;           
                 
                }
            }
        }

       return $oss;
    }

    /**
     * 支付配置信息
     */
    public static function getPayConfig($store_id,$type){

        $db = DBAction::getInstance();
        $sql = "select a.config_data from lkt_payment_config a left join lkt_payment b on a.pid=b.id where a.store_id='$store_id' and b.class_name='$type'";
        $res = $db->select($sql);

        $config = array();

        if ($res) {
            if ($type == 'baidu_pay') {
                $list = unserialize($res[0]->config_data);
            }else{
                $list = json_decode($res[0]->config_data);
            }
            if (!empty($list) && count($list) > 0) {
                $config = (array)$list;
            }
        }

        return $config;

    }

    /**
     * 系统配置信息
     */
    public static function getSysConfig(){

    }

    /**
     * 获取拼团配信息
     */
    public static function  getPTconfig(){

    }

    /**
     * 获取插件配置信息
     */
    public static function  getPluginConfig(){

    }


}

?>