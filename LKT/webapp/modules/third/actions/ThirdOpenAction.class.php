<?php

require_once(MO_LIB_DIR . '/third/authorize/wxBizMsgCrypt.php');
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

class ThirdOpenAction extends Action
{

	   public function getDefaultView()
    {
    
              var_dump('1231');
            return ;
    }
    // https://ashop.ylpin.cn/index.php?module=third&action=thirdOpen&appid=$APPID$
    public function execute()
    {
    	
         $db = DBAction::getInstance();
         $this->callback();

    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }
    public function callback(){

    	$db = DBAction::getInstance();
    	$sql_0 = "select appid,appsecret,check_token,encrypt_key from lkt_third where 1=1";
        $res_0 = $db->select($sql_0);
        if($res_0){
            
            $appid_third = $res_0[0]->appid;
            $token = $res_0[0]->check_token;
            $encodingAesKey = $res_0[0]->encrypt_key;
    	}
    	$appid = $_GET['appid'];
        $msg_sign = $_GET['msg_signature'];
        $timeStamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
 
        $encryptMsg = file_get_contents ( 'php://input' );
 
        //trace($encryptMsg,'php://input');
 
        //解密
        $pc = new WXBizMsgCrypt($token,$encodingAesKey,$appid_third);
        $msg = '';
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $encryptMsg, $msg);
 
       // trace($msg,"3解密后: " );
        $response = json_decode(json_encode(simplexml_load_string($msg, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
 
        //生成返回公众号的消息
        $res_msg = $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";
 
        //判断事件
 
        //2模拟粉丝发送文本消息给专用测试公众号
 
        if ($response['MsgType']=="text") {
            $needle ='QUERY_AUTH_CODE:';
            $tmparray = explode($needle,$response['Content']);
            if(count($tmparray)>1){
                //trace($response,"解密后: " );
                //3、模拟粉丝发送文本消息给专用测试公众号，第三方平台方需在5秒内返回空串
                //表明暂时不回复，然后再立即使用客服消息接口发送消息回复粉丝
                $contentx = str_replace ($needle,'',$response['Content']);//将$query_auth_code$的值赋值给API所需的参数authorization_code
                $this->authorization_code = $contentx;//authorization_code
               // trace($contentx,'authorization_code');
 
 
                //使用授权码换取公众号或小程序的接口调用凭据和授权信息
                $postdata = array(
                    "component_appid"=>$appid_third,
                    "authorization_code"=>$this->authorization_code,
                );
 
                $this->component_access_token = Third::updateComponentAccessToken();
 
               // trace($this->component_access_token,'access_token');
                //使用授权码换取公众号的授权信息的APIa
 				$this->authorizer_access_token_url = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=";
                $component_return = Third::https_post($this->authorizer_access_token_url.$this->component_access_token,$postdata,1);
 
                $component_return = json_decode($component_return,true);
                //trace($component_return,'$component_return');
                $this->authorizer_access_token = $test_token = $component_return['authorization_info']['authorizer_access_token'];
                $content_re = $contentx."_from_api";
                echo '';
 
                //調用客服接口
 
                $data = array(
                    "touser"=>$response['FromUserName'],
                    "msgtype"=>"text",
                    "text" => array(
                                "content" =>$content_re
                    )
                );
                $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$test_token;
                $ret = Third::https_post($url, $data,1);
                //trace($ret,'客服消息');
 
            } else{
                //2、模拟粉丝发送文本消息给专用测试公众号
                $contentx = "TESTCOMPONENT_MSG_TYPE_TEXT_callback";
 
 
 
                //trace($response,"2模拟粉丝发送文本消息给专用测试公众号: " );
                $responseText = sprintf( $textTpl, $response[ 'FromUserName' ], $response[ 'ToUserName' ], $response[ 'CreateTime' ],  $contentx );
//                echo $responseText;
                $echo_msg='';
                $errCode = $pc->encryptMsg($responseText, $timeStamp, $nonce, $echo_msg);
               // trace($responseText,"2222转数组: " );
                echo $echo_msg;
            }
        }
 
        //1、模拟粉丝触发专用测试公众号的事件
 
        if ($response['MsgType'] == 'event'){
            $content = $response['Event']."from_callback";
 
            //trace($response,"111转数组: " );
            $responseText = sprintf( $textTpl, $response[ 'FromUserName' ], $response[ 'ToUserName' ], $response[ 'CreateTime' ],  $content );
            //trace($responseText,"111: " );
//            echo $responseText;
            $errCode = $pc->encryptMsg($responseText, $timeStamp, $nonce, $echo_msg);
 
            echo $echo_msg;
        }
 
 
    }

   


}