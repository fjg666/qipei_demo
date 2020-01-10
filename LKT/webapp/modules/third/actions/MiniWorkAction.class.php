<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class MiniWorkAction extends Action{


	/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 代小程序业务
     * @date 2019年2月28日
     * @version 2.2.1
     */
	private $component_appid;//第三方平台appid

	private $authorizer_appid;//小程序appid
	private $authorizer_access_token;//令牌


	public function getDefaultView(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
 		$store_id = $this->getContext()->getStorage()->read('store_id');

 		
 		$mini_appid = addslashes(trim($request->getParameter('appid')));//小程序appid
 		$work = addslashes(trim($request->getParameter('work')));//操作名

 		$authorizer_access_token =  $this->updateAuthorizerAccessToken($store_id);//获取authorizer_access_token
 		$this->authorizer_access_token = $authorizer_access_token;

 		if($work == 'setServerDomain'){
 		   //设置小程序服务器域名地址
 			$res = $this->setServerDomain($this->authorizer_access_token);

 		}elseif($work == 'setBusinessDomain'){
 			//设置小程序业务域名

 		}elseif($work == 'bindMember'){
 			//绑定体验者
 		}elseif($work == ''){

 		}



	}

	private function setServerDomain($authorizer_access_token){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
 		$store_id = $this->getContext()->getStorage()->read('store_id');
 		$store_type = $this->getContext()->getStorage()->read('store_type');
 		$type = addslashes(trim($request->getParameter('type')));//add,set,get,delete

 		$url = 'https://api.weixin.qq.com/wxa/modify_domain?access_token='.$authorizer_access_token;
 		if($type = 'get'){

 			$data = '{
 			  "action":"add"
 			}';

 		}else{//伪数据

 			$data = '{

 				"action":"'.$type.'",
 				"requestdomain":["https://www.qq.com","https://www.qq.com"],
		        "wsrequestdomain":["wss://www.qq.com","wss://www.qq.com"],
		        "uploaddomain":["https://www.qq.com","https://www.qq.com"],
		        "downloaddomain":["https://www.qq.com","https://www.qq.com"],
 			}';
 		}	

 		$ret = json_decode(Third::https_post($url,$data,1));

 		if($ret->errcode == 0){

 			echo json_encode(array('status'=>1,'info'=>'设置小程序服务器域名成功'));
 			exit;
 		}else{

			Third::thirdLog('./webapp/lib/third/mini_work.log','设置小程序服务器域名失败！errcode为：'.$ret->errcode."\r\n");
 			echo json_encode(array('status'=>0,'info'=>'设置小程序服务器域名失败！'));
 			exit;
 		}

	}

	public function execute(){

	}

	public function getRequestMethods(){

		return Request :: NONE;
	}

	 
} 