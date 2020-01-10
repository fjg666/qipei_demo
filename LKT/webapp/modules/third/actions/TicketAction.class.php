<?php

require_once(MO_LIB_DIR . '/third/authorize/wxBizMsgCrypt.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');
class TicketAction extends Action
{  

    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 接收微信凭据接口
     * @date 2019年3月1日
     * @version v2.2.1
     */
    public function getDefaultView()
    {
    
              
            return ;
    }

    public function execute()
    {
    	
         $db = DBAction::getInstance();
         $this->ticket();

    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
    
    /*
    *接受官方凭据
    *微信每隔10分钟，请求一次该地址
    *官方文档：https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/
    res_list&verify=1&id=open1419318479&token=&lang=zh_CN
    */
    public function ticket(){

            $db = DBAction::getInstance();

            // require_once(MO_LIB_DIR . '/third/authorize/Third_Authorize.Config.php');
            // $token = ThirdConfig::THIRD_TOKEN;//消息校验Token
            // $encodingAesKey = ThirdConfig::ENCODINGAESKEY;
            // $appid = ThirdConfig::THIRD_APPID;

            $sql_0 = "select appid,appsecret,check_token,encrypt_key from lkt_third where 1=1";
            $res_0 = $db->select($sql_0);
            if($res_0){
                
                $appid = $res_0[0]->appid;
                $token = $res_0[0]->check_token;
                $encodingAesKey = $res_0[0]->encrypt_key;
            }
            $pc = new WXBizMsgCrypt($token,$encodingAesKey,$appid);

            //接收微信传来参数
            $timeStamp =  empty($_GET['timestamp']) ? "" : trim($_GET['timestamp']) ;
            $nonce = empty($_GET['nonce']) ? "" : trim($_GET['nonce']);
            $msg_sign = empty($_GET['msg_signature']) ? "" : trim($_GET['msg_signature']);
            $encryptMsg = file_get_contents('php://input'); 

            //生成临时文件
            $str = '时间戳'.$timeStamp.'随机数'.$nonce.'签名'.$msg_sign.'--------end';
             

            //$this->thirdLog('./webapp/lib/third/thirdTicket.log','appid为'.$appid.'token:'.$token.'encodingAesKey:'.$encodingAesKey."\r\n");
            Third::thirdLog('./webapp/lib/third/thirdTicket.log','获取微信发送的ticket的信息'.$str);

             
            $msg='';    

            //解密xml中的数据，获取
            $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $encryptMsg, $msg);
            if($errCode == 0){

                $config_0 = array();
                $data = $this->_xmlToArr($msg);
                if(isset($data['ComponentVerifyTicket'])){
                    $component_verify_ticket = $data['ComponentVerifyTicket'];
                    $create_time = date("Y-m-d H:i:s");
                }
                $db = DBAction::getInstance();
                $sql = "update lkt_third set ticket = '$component_verify_ticket' ,ticket_time = '$create_time' where id = 1";
                $res =$db->update($sql); 

                $this->updateAccessToken($component_verify_ticket);//若凭据过期，则component_access_token必定过期

               if (ob_get_level() == 0) ob_start();

                 ob_implicit_flush(true);
                 ob_clean();
                 header("Content-type: text/plain");
              
                 echo("success");
                 ob_flush();
                 flush();
                 ob_end_flush();

                 die();
                 exit();
            }else{

                Third::thirdLog('./webapp/lib/third/thirdTicket.log','解密ComponentVerifyTicket失败'."\r\n".'errcode为：'.$errCode);

                echo '解密失败'.$errCode;

            }

    }
    
    /**
    * 更新component_access_token
    * @param $component_verify_ticket
    */
    private  function updateAccessToken($component_verify_ticket){

        $db = DBAction::getInstance();

        $sql = "select token,token_expires,appid,appsecret from lkt_third where id = 1";
        $res = $db->select($sql);

        if($res){

            $token = $res[0]->token;
            $token_expires = $res[0]->token_expires;
          

            $component_appid = $res[0]->appid;//第三方平台appid
            $component_appsecret = $res[0]->appsecret;//第三方平台appsecret
           
            if($token_expires < time() || empty($token)){//component_access_token过期

                $url = 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
                $data = '{"component_appid":"'.$component_appid.'","component_appsecret":"'.$component_appsecret.'","component_verify_ticket":"'.$component_verify_ticket.'"}';

                $res_json = Third::https_post($url,$data,1);//json格式
                $res_arr = json_decode($res_json);
               
                if(isset($res_arr->component_access_token)){

                    $token_expires = time()+3600;//失效时间戳
                    $component_access_token = $res_arr->component_access_token;
                    $sql = "update lkt_third set token = '$component_access_token' ,token_expires = '$token_expires' where id = 1";
                    $res = $db->update($sql);

                    $msg = '更新component_access_token成功'."\r\n";
                    Third::thirdLog('./webapp/lib/third/third_component_token.log',$msg);
                    return ;
                } 

            }
        }    

    } 


    public static function _xmlToArr($xml) {
        $res = @simplexml_load_string ( $xml,NULL, LIBXML_NOCDATA );
        $res = json_decode ( json_encode ( $res), true );
        return $res;
    }



}

?>