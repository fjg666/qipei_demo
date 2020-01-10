<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

/**
 * <p>Copyright (c) 2019-2020</p>
 * <p>Company: www.laiketui.com</p>
 * @author 凌烨棣
 * @content 授权回调处理接口
 * @date 2019年3月1日
 * @version v2.2.1
 */

class AuthInfoAction extends Action
{

	/*
	* 1.通过回调地址，获取授权码
	* 2.通过授权码换取小程序的接口调用凭据和授权信息并保存
	* 3.根据获取的授权信息 去获取授权小程序的基出信息
	*/

	private $appid;            //第三方平台应用appid

	private $appsecret;     //第三方平台应用appsecret

	private $component_ticket;   //微信后台推送的ticket,用于获取第三方平台接口调用凭据

	public function getDefaultView()
	{

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$store_id = $this->getContext()->getStorage()->read('store_id');

		//获取第三方平台appid
		$sql = "select appid,appsecret,ticket from lkt_third where id = 1";
		$res = $db->select($sql);
		$appid = $res[0]->appid;

		$appsecret = $res[0]->appsecret;

		$this->appid = $appid;
		$this->appsecret = $appsecret;
		$this->component_ticket = $res[0]->ticket;
		$res_auth =  $this->getAuthCode(); //授权信息存储结果

		if ($res_auth != false) { //授权成功

			header("Content-type:text/html;charset=utf-8");
			echo "<script type='text/javascript'>" .
				"alert('授权成功！');" .
				"location.href='index.php?module=third&acton=Index';</script>";
			return;
		} else {


			header("Content-type:text/html;charset=utf-8");
			echo "<script type='text/javascript'>" .
				"alert('授权失败！');" .
				"location.href='index.php?module=third&action=Auth';</script>";
			return;
		}

		return View::INPUT;
	}

	public function execute()
	{ }

	public  function getAuthCode()
	{

		//获取授权基本信息
		$auth_code = $_GET['auth_code'];

		if ($auth_code) {

			$msg = '获取授权码成功！' . "\r\n" . '授权码为：' . $auth_code . "\r\n";
			Third::thirdLog('./webapp/lib/third/third_auth_code.log', $msg);
			$mini_appid = $this->getAuthInfo($auth_code);

			//获取授权小程序的基础信息
			if ($mini_appid) {
				$base = $this->getBaseInfo($mini_appid);
				if ($base != false) {
					//页面跳转如已授权的页面
					return true;
				} else {
					//提示授权失败
					return false;
				}
			}
		} else {

			return false;
		}
	}

	public  function getAuthInfo($auth_code)
	{ //获取授权信息数据

		$data = '{
					"component_appid":"' . $this->appid . '" ,
					"authorization_code": "' . $auth_code . '"
				}'; //post请求数据

		$component_access_token	= 	Third::updateComponentAccessToken();

		$url = 'https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=' . $component_access_token;

		$ret = json_decode(Third::https_post($url, $data,1), true);

		if ($ret) {

			$authorizer_appid = $this->setAuthInfo($ret['authorization_info']);
			return $authorizer_appid;
		}
	}


	private function setAuthInfo($data)
	{ //将授权信息存入对应商户数据库 ---   store_id

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();

		$store_id = $this->getContext()->getStorage()->read('store_id');




		if (!empty($data['authorizer_appid']) && !empty($data['authorizer_access_token']) && !empty($data['expires_in']) && !empty($data['authorizer_refresh_token']) && !empty($data['func_info'])) {

			//未授权

			$update_time = date("Y-m-d H:i:s"); //更新时间
			$expires_time = time() + $data['expires_in']; //失效时间戳


			$sql = "insert into lkt_third_mini_info(authorizer_appid,authorizer_access_token,authorizer_expires,authorizer_refresh_token,update_time,func_info,expires_time,store_id) " . "values('" . $data['authorizer_appid'] . "','" . $data['authorizer_access_token'] . "','" . $data['expires_in'] . "','" . $data['authorizer_refresh_token'] . "','" . $update_time . "','" . json_encode($data['func_info']) . "'," . $expires_time . "," . $store_id . ")";
			$res = $db->insert($sql);


			if ($res > 0) {
				//返回授权小程序的appid，用于获取小程序的基本信息
				$msg = '授权信息入库成功！' . "\r\n";
				Third::thirdLog('./webapp/lib/third/third_auth_code.log', $msg);
				return $data['authorizer_appid'];
			} else {
				return false;
			}
		}

		return false;
	}

	//获取授权方小程序的基本信息 
	private function getBaseInfo($mini_appid)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=' . Third::updateComponentAccessToken();
		$data = '{
			"component_appid":"' . $this->appid . '",
			"authorizer_appid": "' . $mini_appid . '"
		}';

		$ret = json_decode(Third::https_post($url, $data,1));

		if (@$ret->errcode == 0) {

			$res =  $this->setBaseInfo($ret, $mini_appid);
			return $res;
		} else {

			return false;
		}
	}

	//将获得的小程序基本信息存入商户对应数据库  --  store_id   并设置初始模板消息的store_id
	private function setBaseInfo($data, $mini_appid)
	{

		$db = DBAction::getInstance();
		$store_id = $this->getContext()->getStorage()->read('store_id');

		$authorizer_info = $data->authorizer_info;
		$authorization_info = $data->authorization_info;

		$nick_name = $authorizer_info->nick_name; //授权方昵称

		$head_img = $authorizer_info->head_img; //授权方头像
		$verify_type_info = json_encode($authorizer_info->verify_type_info); //授权方认证类型，-1代表未认证，0代表微信认证
		$user_name = $authorizer_info->user_name; //小程序的原始ID
		$signature = $authorizer_info->signature; //帐号介绍
		$principal_name = $authorizer_info->principal_name; //小程序的主体名称
		$business_info = json_encode($authorizer_info->business_info); //开通状况（0代表未开通，1代表已开通）
		$qrcode_url = $authorizer_info->qrcode_url; //二维码图片的URL
		$miniprograminfo = json_encode($authorizer_info->MiniProgramInfo); //可根据这个字段判断是否为小程序类型授权

		$sql = "update lkt_third_mini_info set nick_name = '$nick_name',head_img = '$head_img',verify_type_info = '$verify_type_info',user_name = '$user_name',signature = '$signature',principal_name = '$principal_name' ,business_info = '$business_info' ,qrcode_url = '$qrcode_url' ,miniprograminfo = '$miniprograminfo' where authorizer_appid = '$mini_appid' and store_id = '$store_id'";
		$res = $db->update($sql);



		if ($res > 0) {
			$msg = '授权方小程序信息入库成功！' . "\r\n";
			Third::thirdLog('./webapp/lib/third/third_auth_code.log', $msg);
			return true;
		} else {
			return false;
		}
	}

	
	public function getRequestMethods()
	{
		return Request::NONE;
	}
}
