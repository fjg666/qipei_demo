<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

/**
* <p>Copyright (c) 2019-2020</p>
* <p>Company: www.laiketui.com</p>
* @author 凌烨棣
* @content 小程序模板消息自动配置及展示
* @date 2019年3月5日
* @version v2.2.1
*/


class TemplateInfoAction extends Action
{

	public function getDefaultView(){

		$db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = addslashes(trim($request->getParameter('store_id')));
        //获取账号下已存在的消息模板
		
        $authorizer_access_token   = Third::updateAuthorizerAccessToken($store_id);

        $res_list = $this->getList($authorizer_access_token);//模板消息数组

      
       

        $request->setAttribute('res_list',$res_list);


        


		return View :: INPUT;
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
	public function getWord($token){
		$url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token='.$token;
		$data = '{
			"id":"AT0009"
		}';
		$ret = json_decode(Third::https_post($url,$data,1));
		if(@$ret->errcode == 0){
			return $ret;
		}else{
			return false;
		}
	}

	/**
    * 第三方授权模板消息列表获取函数
    * @param $token   授权token
    */
	public function getList($token){

		$url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token='.$token;
		$data = '{
			"offset":0,
			"count":20
		}';
		$ret = json_decode(Third::https_post($url,$data,1));

		if(@$ret->errcode == 0){//请求成功

			return $ret->list;
		}else{//请求失败
			Third::thirdLog('./webapp/lib/third/check_template.log','获取小程序模板消息列表失败,errmsg:'.$ret->errmsg."\r\n");
			return false;
		}
	}

	 


}