<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/GETUI/igetui/template/notify/IGt.Notify.php');
require_once(MO_LIB_DIR . '/GETUI/IGt.Push.php');
require_once(MO_LIB_DIR . '/GETUI/igetui/IGt.AppMessage.php');
require_once(MO_LIB_DIR . '/GETUI/igetui/IGt.TagMessage.php');
require_once(MO_LIB_DIR . '/GETUI/igetui/IGt.APNPayload.php');
require_once(MO_LIB_DIR . '/GETUI/igetui/template/IGt.BaseTemplate.php');
require_once(MO_LIB_DIR . '/GETUI/IGt.Batch.php');
require_once(MO_LIB_DIR . '/GETUI/igetui/utils/AppConditions.php');
require_once(MO_LIB_DIR . '/GETUI/igetui/template/notify/IGt.Notify.php');
require_once(MO_LIB_DIR . '/GETUI/igetui/IGt.MultiMedia.php');
require_once(MO_LIB_DIR . '/GETUI/payload/VOIPPayload.php');

class LaikePushAction extends Action {

    public function getDefaultView() {
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();
        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));
        $this->$m();
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    /**
     * 单对象消息推送
     * @param $cid
     * @param $messageContent
     */
    public function singlePush(){

        define('APPKEY','swlmXLaMOl6y0mG3WBlf96');
        define('APPID','8dWPLuUuOPALivdOxL1Lb7');
        define('MASTERSECRET','NxOyin2qS98z16eDQu6NIA');
        define('HOST','http://sdk.open.api.igexin.com/apiex.htm');
        define('CID','c14edb2ace58ef152f5825c1bbe14629');

        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
        $template = $this->smsTemplate('{"title":"来客电商提示您","content":"正文内容","payload":"测试内容"}');
        //个推信息体
        $message = new IGtSingleMessage();
        $message->set_isOffline(true);//是否离线
        $message->set_offlineExpireTime(3600*12*1000);//离线时间
        $message->set_data($template);//设置推送消息类型
        //接收方
        $target = new IGtTarget();
        $target->set_appId(APPID);
        $target->set_clientId(CID);
        try {
            $rep = $igt->pushMessageToSingle($message, $target);
        }catch(RequestException $e){
            $requstId =$e->getRequestId();
            $rep = $igt->pushMessageToSingle($message, $target,$requstId);
        }
    }

    /**
     * @return IGtTransmissionTemplate 模板
     */
    public function smsTemplate($messageContent){
        $template =  new IGtTransmissionTemplate();
        $template->set_appId(APPID);//应用appid
        $template->set_appkey(APPKEY);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent($messageContent);//透传内容
        $lktmessageContent = htmlspecialchars_decode($messageContent);
        $lktmessageContent = json_decode($lktmessageContent);
        $smsMessage = new SmsMessage();
        $smsContent = array();
        $smsMessage->setSmsContent($smsContent);
        $smsMessage->setSmsTemplateId("1a0ad952756f4c679ca67f008bf37b5e");
        $smsMessage->setOfflineSendtime(5000000);
        $template->setSmsInfo($smsMessage);
        //APN推送
        $apn = new IGtAPNPayload();
        $alertmsg=new DictionaryAlertMsg();
        // $alertmsg->body="1111111";
        $alertmsg->body=$lktmessageContent->content;
        $alertmsg->actionLocKey="ActionLockey";
        $alertmsg->locKey="LocKey";
        $alertmsg->locArgs=array("locargs");
        $alertmsg->launchImage="launchimage";
        //IOS8.2 支持
        $alertmsg->title=$lktmessageContent->title;
        // $alertmsg->title='dfasdfd';
        $alertmsg->titleLocKey="TitleLocKey";
        $alertmsg->titleLocArgs=array("TitleLocArg");
        $apn->alertMsg=$alertmsg;
        $apn->badge=0;
        $apn->sound="";
        // $apn->add_customMsg("payload",$messageContent);
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);
        return $template;
    }

    /**
     * 获取用户状态 在线 离线
     */
    public function getUserStatus() {
        $igt = new IGeTui(HOST,APPKEY,MASTERSECRET);
        $rep = $igt->getClientIdStatus(APPID,CID);
    }

    public function IGtTransmissionTemplateDemo(){

        $template =  new IGtTransmissionTemplate();
        $template->set_appId(APPID);//应用appid
        $template->set_appkey(APPKEY);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent('{"title":"来客电商提示您","content":"正文内容","payload":"测试内容"}');//透传内容

        //APN简单推送
        $apn = new IGtAPNPayload();
        $alertmsg=new SimpleAlertMsg();
        $alertmsg->alertMsg="abcdefg3";
        $apn->alertMsg=$alertmsg;
        $apn->badge=2;
        $apn->sound="";
        $apn->add_customMsg("payload",'{"title":"来客电商提示您","content":"正文内容","payload":"测试内容"}');
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);

        //APN高级推送
        $apn = new IGtAPNPayload();
        $alertmsg=new DictionaryAlertMsg();
        $alertmsg->body="body";
        $alertmsg->actionLocKey="ActionLockey";
        $alertmsg->locKey="LocKey";
        $alertmsg->locArgs=array("locargs");
        $alertmsg->launchImage="launchimage";
        // IOS8.2 支持
        $alertmsg->title="Title";
        $alertmsg->titleLocKey="TitleLocKey";
        $alertmsg->titleLocArgs=array("TitleLocArg");

        $apn->alertMsg=$alertmsg;
        $apn->badge=7;
        $apn->sound="";
        $apn->add_customMsg("payload","payload");
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        // IOS多媒体消息处理
        $media = new IGtMultiMedia();
        $media -> set_url("http://docs.getui.com/start/img/pushapp_android.png");
        $media -> set_onlywifi(false);
        $media -> set_type(MediaType::pic);
        $medias = array();
        $medias[] = $media;
        $apn->set_multiMedias($medias);
        $template->set_apnInfo($apn);
        return $template;
    }

}
?>