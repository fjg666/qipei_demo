<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');
class AuthAction extends Action
{

    /**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 授权处理接口
     * @date 2019年3月1日
     * @version v2.2.1
     */

    private $appid;            //第三方平台应用appid
    private $appsecret;     //第三方平台应用appsecret
    private $encodingAesKey;      //第三方平台应用Key（消息加解密Key）
    private $component_ticket;   //微信后台推送的ticket,用于获取第三方平台接口调用凭据
    private $redirect_url;    //第三方授权回调地址

    public function getDefaultView()
    {


        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');


        $sql = "select appid,appsecret,ticket,redirect_url from lkt_third where id = 1";
        $res = $db->select($sql);
        if (empty($res)) {
            return View::INPUT;
        }
        $this->appid = $res[0]->appid;
        $this->appsecret = $res[0]->appsecret;
        $this->component_ticket = $res[0]->ticket;
        $this->redirect_url = $res[0]->redirect_url; //授权回调地址



        //已经授权,进入已授权页

        $sql = "select user_name from lkt_third_mini_info where store_id = '$store_id'";

        $res = $db->select($sql);

        if (!empty($res)) {

            $user_name = $res[0]->user_name; //小程序原始id

            echo "<script type='text/javascript'>" .
                "location.href='index.php?module=third&action=Index'</script>";
            return;
        } else {

            $url = $this->startAuth($this->redirect_url,$store_id,2); //扫码授权

            $request->setAttribute('url', $url);
        }
        //未授权

        return View::INPUT;
    }

    public function execute()
    { }

    public function getRequestMethods()
    {
        return Request::NONE;
    }

    /**
     * 扫码授权，注意此URL必须放置在页面当中用户点击进行跳转，不能通过程序跳转，否则将出现“请确认授权入口页所在域名，与授权后回调页所在域名相同....”错误
     * @param string $redirect_uri : 扫码成功后的回调地址
     * @param int $auth_type : 授权类型，1公众号，2小程序，3公众号/小程序同时展现。不传参数默认都展示    
     */
    public function startAuth($redirect_uri,$store_id, $auth_type = 2)
    { //授权回调地址 - get获取
        
        $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=" . $this->appid . "&pre_auth_code=" . $this->getPreAuthCode($store_id) . "&redirect_uri=" . urlencode($redirect_uri) . "&auth_type=" . $auth_type;

        return $url;
    }
   
    /*
    *  第三方平台方获取预授权码pre_auth_code
    */

    private function getPreAuthCode($store_id)
    {
        $db = DBAction::getInstance();
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=" . Third:: updateComponentAccessToken();
        $data = '{"component_appid":"' . $this->appid . '"}';
        $ret = json_decode(Third::https_post($url, $data,1));
        if (@$ret->errcode == 0) {

            return @$ret->pre_auth_code;
        } else {

            Third::thirdLog('./webapp/lib/third/third_pre_auth_code.log', '获取预授权码失败！errmsg为：' . @$ret->errmsg . "\r\n");
            return @$ret->errcode;
        }
    }

}
