<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

class KeyAction extends Action{

	public function getDefaultView(){

		$db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        
        
        
        echo '关键词已设置完成，请前往代码设置模板id';die;
        //获取账号下已存在的消息模板
        $authorizer_access_token   = Third::update_authorizer_access_token(1);
        $ret  = $this->get_word($authorizer_access_token,'AT0551');
        echo '<pre>';
        print_r($ret);die;
	}

	public function execute(){

	}

	public function getRequestMethods(){

		 return Request :: POST;
	}

	/**
    * 第三方授权模板消息关键词库获取函数
    * @param $token   授权token
    */
	public function get_word($token,$id){
        $third = new Third();
		$url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token='.$token;
		$data = '{
			"id":"'.$id.'"
		}';

		$ret = json_decode($third->https_post($url,$data,1));
		if(@$ret->errcode == 0){
			return $ret;
		}else{
			return false;
		}
	}


}