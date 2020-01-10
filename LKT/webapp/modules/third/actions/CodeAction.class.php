<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 体验版二维码
     * @date 2019年3月5日
     * @version v2.2.1
     */
class CodeAction extends Action{

	public function getDefaultView(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $sql = "select nick_name,head_img,auditid from lkt_third_mini_info where store_id = '$store_id'";
        $res = $db->select($sql);

        if($res){
        	$nick_name = $res[0]->nick_name;
        	$head_img = $res[0]->head_img;
            $auditid = $res[0]->auditid;//提交审核时获得的审核id

        }

        $this->getQrCode();

        return View :: INPUT;


	}

	public function execute(){

	}

	public function getRequestMethods(){

		return Request :: POST;
	}


	//获取体验版二维码
    public function getQrCode(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        header("Content-type: image/jpeg");
        $authorizer_access_token = Third::updateAuthorizerAccessToken($store_id);


        $url = 'https://api.weixin.qq.com/wxa/get_qrcode?access_token='.$authorizer_access_token;

        
        $ret = Third::https_get($url,2);
       
      
        return $ret;

      
        
    }

}