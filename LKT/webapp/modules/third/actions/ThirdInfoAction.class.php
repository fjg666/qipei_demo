<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

/**
* <p>Copyright (c) 2019-2020</p>
* <p>Company: www.laiketui.com</p>
* @author 凌烨棣
* @content  第三平台参数设置
* @date 2019年4月4日
* @version v2.2.1
*/

class ThirdInfoAction extends Action 
{

	public function getDefaultView(){



		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();

		$sql = "select id,appid,appsecret,check_token,encrypt_key,serve_domain,work_domain,redirect_url,mini_url,kefu_url,qr_code,H5,endurl from lkt_third where id = 1";
		$res = $db->select($sql);
		if($res){
			$id = $res[0]->id;
			$appid = $res[0]->appid;//第三方平台appid
			$appsecret = $res[0]->appsecret;//第三方平台秘钥
			$check_token = $res[0]->check_token;//消息检验Token，第三方平台设置
			$encrypt_key = $res[0]->encrypt_key;//消息加减密key
			$serve_domain = $res[0]->serve_domain;//服务器域名
			$work_domain = $res[0]->work_domain;//业务域名
			$redirect_url = $res[0]->redirect_url;//授权回调地址
			$mini_url = $res[0]->mini_url;//小程序接口地址
			$kefu_url = $res[0]->kefu_url;//客服接口url
			$qr_code = $res[0]->qr_code;//体验二维码url
			$H5 = $res[0]->H5;//H5页面地址
			$endurl = $res[0]->endurl;//根目录路径
		}else{
			return View :: INPUT;
		}	


		$request->setAttribute('appid',$appid);	
		$request->setAttribute('id',$id);	

		$request->setAttribute('appsecret',$appsecret);	
		$request->setAttribute('check_token',$check_token);	
		$request->setAttribute('encrypt_key',$encrypt_key);	
		$request->setAttribute('serve_domain',$serve_domain);	
		$request->setAttribute('work_domain',$work_domain);
		$request->setAttribute('redirect_url',$redirect_url);
		$request->setAttribute('mini_url',$mini_url);
		$request->setAttribute('kefu_url',$kefu_url);
		$request->setAttribute('qr_code',$qr_code);	
		$request->setAttribute('H5',$H5);
		$request->setAttribute('endurl',$endurl);

		return View :: INPUT;
	}

	public function execute(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$admin_name = $this->getContext()->getStorage()->read('admin_name');

		$id = addslashes(trim($request->getParameter('id')));
		$appid = addslashes(trim($request->getParameter('appid')));
		$appsecret = addslashes(trim($request->getParameter('appsecret')));
		$check_token = addslashes(trim($request->getParameter('check_token')));
		$encrypt_key = addslashes(trim($request->getParameter('encrypt_key')));
		$serve_domain = addslashes(trim($request->getParameter('serve_domain')));
		$work_domain = addslashes(trim($request->getParameter('work_domain')));
		$redirect_url = trim($request->getParameter('redirect_url'));
		$redirect_url = htmlspecialchars_decode($redirect_url);//转换amp;实体
		$mini_url = addslashes(trim($request->getParameter('mini_url')));
		$kefu_url = addslashes(trim($request->getParameter('kefu_url')));
		$qr_code = trim($request->getParameter('qr_code'));
		$qr_code =  htmlspecialchars_decode($qr_code);//转换amp;实体
		$H5 = addslashes(trim($request->getParameter('H5')));
		$endurl = addslashes(trim($request->getParameter('endurl')));
        
		if(empty($appid)){

			echo json_encode(array('suc'=>0,'msg'=>'appid不能为空'));
			exit;
		}else if(empty($appsecret)){
			echo json_encode(array('suc'=>0,'msg'=>'秘钥不能为空'));
			exit;
		}
		//判断是否有参数配置
		$sql_1 = "select * from lkt_third where 1= 1";
		$res_1 = $db->select($sql_1);
		if($res_1){
			$sql = "update lkt_third set appid = '$appid',appsecret = '$appsecret',check_token = '$check_token',encrypt_key = '$encrypt_key',serve_domain = '$serve_domain',work_domain = '$work_domain',redirect_url = '$redirect_url',mini_url = '$mini_url',kefu_url = '$kefu_url',qr_code = '$qr_code',H5 = '$H5',endurl = '$endurl' where id = '$id'";
			$res = $db->update($sql);
		}else{
			$sql = "insert into lkt_third (appid,appsecret,check_token,encrypt_key,serve_domain,work_domain,redirect_url,mini_url,kefu_url,qr_code,H5,endurl) values ('$appid','$appsecret','$check_token','$encrypt_key','$serve_domain','$work_domain','$redirect_url','$mini_url','$kefu_url','$qr_code','$H5','$endurl')";
			$res = $db->insert($sql);
		}

		


		if($res >= 0){

			$db->admin_record(1,$admin_name,'修改第三平台配置成功',5);
			echo json_encode(array('suc'=>1,'msg'=>'修改配置成功'));
			exit;
		}else{
			$db->admin_record(1,$admin_name,'修改第三平台配置失败',5);
			echo json_encode(array('suc'=>0,'msg'=>'修改配置失败'));
			exit;
		}


	}

	public function getRequestMethods(){

		return Request :: POST;
	}
}