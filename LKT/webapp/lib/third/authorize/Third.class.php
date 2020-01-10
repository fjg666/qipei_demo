<?php
require_once( dirname(dirname(dirname(__FILE__))).'/DBAction.class.php' );
/**
 * <p>Copyright (c) 2019-2020</p>
 * <p>Company: www.laiketui.com</p>
 * @author 凌烨棣
 * @content 第三方授权处理类
 * @date 2019年3月1日
 * @version v2.2.1
 */
class Third
{
    /**
     * @title   更新授权token的component_access_token
     */

    public static function updateComponentAccessToken(){

        $db = DBAction::getInstance();

        $sql = "select token,token_expires,appid,appsecret,ticket from lkt_third where id = 1";
        $res = $db->select($sql);

        $appid = $res[0]->appid;
        $appsecret = $res[0]->appsecret;
        $component_ticket = $res[0]->ticket;//凭据

        $invalid_time = $res[0]->token_expires;//token失效时间戳
        $component_access_token = $res[0]->token;

       
        if($invalid_time < time()){//失效
            $url = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";

            $data = '{

                "component_appid":"'.$appid.'" ,

                "component_appsecret": "'.$appsecret.'",

                "component_verify_ticket": "'.$component_ticket.'"

            }';

            $ret = json_decode(self::https_post($url,$data,1));
          

            if(@$ret->errcode == 0){

                if(isset($ret->component_access_token)){

                    $token_expires = time()+3600;//失效时间
                    $component_access_token = $ret->component_access_token;
                    $sql = "update lkt_third set token = '$component_access_token' ,token_expires = '$token_expires' where id = 1";
                    $res = $db->update($sql);

                }

                return $ret->component_access_token;

            }else{
                self::thirdLog('./webapp/lib/third/check_template.log','获取component_access_token失败！errmsg为:'.$ret->errmsg."\r\n");
                return $ret->errcode;

            }
        }else{//未失效
            
            return $component_access_token ;
        }

    }

    /**
     * @title   更新授权小程序的authorizer_access_token
     * @version 2.2
     */
    public static function updateAuthorizerAccessToken($store_id){

        $db = DBAction::getInstance();
        $now_time = time();


        //第三方平台基本信息
        $sql = "select appid,ticket,appsecret from lkt_third where id = 1";
        $res = $db->select($sql);

        if($res){
            $component_appid = $res[0]->appid;
            $component_verify_ticket = $res[0]->ticket;
            $component_appsecret = $res[0]->appsecret;
        }

        //授权小程序基本信息
        $sql = "select authorizer_appid,authorizer_refresh_token,authorizer_access_token,expires_time,authorizer_expires from lkt_third_mini_info where store_id = '$store_id'";
        $res = $db->select($sql);


        $authorizer_access_token = $res[0]->authorizer_access_token;
        $expires_time = $res[0]->expires_time;//过期时间戳
        $authorizer_expires = $res[0]->authorizer_expires;//有效期
        $appid = $res[0]->authorizer_appid;
        $refresh_token = $res[0]->authorizer_refresh_token;

        if($now_time < $expires_time){
            self::thirdLog('./webapp/lib/third/check_template.log','走入时间未失效');
            return $authorizer_access_token;
        }else{
             self::thirdLog('./webapp/lib/third/check_template.log','走入时间失效');     
            $url = 'https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token='.self::updateComponentAccessToken();
            $data = '{"component_appid":"' . $component_appid . '",
                      "authorizer_appid":"' . $appid . '",
                      "authorizer_refresh_token":"' . $refresh_token . '"
                     }';
            $ret = json_decode(self::https_post($url, $data,1));
           
           
            if(isset($ret->authorizer_access_token)){

                $sql = "update lkt_third_mini_info set authorizer_access_token = '".$ret->authorizer_access_token."', authorizer_expires = ".$ret->expires_in.", authorizer_refresh_token =  '".$ret->authorizer_refresh_token."' where store_id = '$store_id'";
                $res = $db->update($sql);
                if($res < 0 ){

                    self::thirdLog('./webapp/lib/third/check_template.log','数据库入库失败');

                }else{

                    return $ret->authorizer_access_token;
                }
            }else{
                 self::thirdLog('./webapp/lib/third/check_template.log','获取authorizer_access_token失败！errmsg为:'.$ret->errmsg."\r\n");
            }

        }

    }

    /**
     * @title   http网络请求
     * @param string $url : 网络地址
     * @param json $data ： 发送的json格式数据
     * @param type： 1-普通post请求，以文件流返回而不是直接输出  2-处理图片post请求,且为直接输出
     * @param $header： 请求头设置
     */
    public static function https_post($url,$data,$type = 1,$header=null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        if($type == 1){
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        }else{
             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);
        }

        //设置头信息
        if(!empty($header)){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * @title   http网络请求
     * @param string $url : 网络地址
     * @param type： 1-普通get请求，以文件流返回而不是直接输出  2-处理图片get请求,且为直接输出
     */
    public static function https_get($url,$type = 1)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if($type == 1){
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); 
        }else{
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, FALSE); 
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($curl, CURLOPT_HEADER, FALSE) ; 
        curl_setopt($curl, CURLOPT_TIMEOUT,60);
       
        if (curl_errno($curl)) {
            return 'Errno'.curl_error($curl);
        }else{
            $result=curl_exec($curl);
        }
        curl_close($curl);
        return $result;
    }

     /**
     * 第三方授权日志生成函数
     * @param $file 生成日志文件路径
     * @param $msg  日志内容
     */
    public static  function thirdLog($file,$msg){

        $fp = fopen($file,'a');
        flock($fp,LOCK_EX);
        fwrite($fp,"生成日期：".date("Y-m-d H:i:s")."\r\n".$msg."\r\n");
        flock($fp,LOCK_UN);
        fclose($fp);
    }
    
}