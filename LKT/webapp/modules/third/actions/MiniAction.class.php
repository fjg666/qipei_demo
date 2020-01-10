<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

class miniAction extends Action{


	/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 小程序模板接口
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

 		
 		
 		$work = addslashes(trim($request->getParameter('work')));//操作名

 		if($work == 'all_mould'){//获取模板库中所有模板

 			$this->allMould();
 		}



	}

	public function allMould(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
 		$store_id = $this->getContext()->getStorage()->read('store_id');
 		$store_type = $this->getContext()->getStorage()->read('store_type');

 		//获取component_access_tokens

 		$componet_access_token = Third::updateComponentAccessToken();
 		$url = 'https://api.weixin.qq.com/wxa/gettemplatelist?access_token='.$componet_access_token;
 		$data = '';

 		$ret = json_decode(Third::https_post($url,$data,1),true);

 		if(@$ret['errcode'] == 0){

 			$template_list = $ret['template_list'];//全部模板信息

            //此处为对模板数据的加工处理，并渲染视图代码代码


 		}else{

 			$msg  = '获取小程序模板失败,错误码：为：'.$ret['errcode']."\r\n";
 			Third::thirdLog('./webapp/lib/third/third_mould.log',$msg);
 			echo json_encode(array('status'=>0,'info'=>'获取小程序模板失败'));
            exit;
 		}



	}


	public function execute(){

            //此处为接受模板id，并上传至微信代码
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $m = addslashes(trim($request->getParameter('m')));//操作名

        if($m == 'mouldUpload'){//模板上传

            $this->mouldUpload();
        }elseif ($m == 'miniCheck') {//微信审核上传的小程序模板代码
            
        }
	}
    
    //模板上传
    public function mouldUpload(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $t_id = addslashes(trim($request->getParameter('t_id')));//模板id

        //获取授权token
        $authorizer_access_token = Third::updateAuthorizerAccessToken($store_id);
        
        //post请求
        $url = 'https://api.weixin.qq.com/wxa/commit?access_token='.$authorizer_access_token;

        $ext_json = '{}';//第三方自定义配置
        $user_version = '';//代码版本号，开发者可自定义（长度不要超过64个字符）
        $user_desc = '';//代码描述，开发者可自定义

        $data = '{

            "template_id":"'.$t_id.'",
            "ext_json":"'.$ext_json.'",
            "user_version":"'.$user_version.'",
            "user_desc":"'.$user_desc.'"
        }';

        $ret = json_decode(Third::https_post($url,$data,1));

        if(@$ret->errcode == 0){

             //   
             echo json_encode(array('status'=>1,'info'=>'代码上传成功！'));
             exit;
        }else{

             echo json_encode(array('status'=>0,'info'=>'代码上传失败!'));
             exit;
        }


    }
    
    /*微信审核上传小程序处理
    *
    *1.获取授权小程序帐号已设置的类目
    *2.获取小程序的第三方提交代码的页面配置（仅供第三方开发者代小程序调用）
    *3.将第三方提交的代码包提交审核（仅供第三方开发者代小程序调用）
    */
    public function miniCheck(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');  
        $store_type = $this->getContext()->getStorage()->read('store_type');  

        //获取小程序token
        $authorizer_access_token = Third::updateAuthorizerAccessToken($store_id);


        //1.获取类目    
        $category =  $this->getCategory($authorizer_access_token);

        //2.获取页面配置
        $page_list =  $this->getPage($authorizer_access_token);

        $first_class = '';
        $second_class = '';
        $third_class = '';

        $first_id = 0;
        $second_id = 0;
        $third_id = 0;

        if(!empty($category)){
            $first_class = $category[0]->first_class ? $category[0]->first_class : '';
            $second_class = $category[0]->second_class ? $category[0]->second_class : '';
            $third_class = $category[0]->third_class ? $category[0]->third_class : '';

            $first_id = $category[0]->first_id ? $category[0]->first_id : 0;
            $second_id = $category[0]->second_id ? $category[0]->second_id : 0;
            $third_id = $category[0]->third_id ? $category[0]->third_id : 0;
        }

        $address = '';//小程序页面
        if(!empty($page_list) && isset($page_list[0])){

            $address = $page_list[0];
        }

        $url = 'https://api.weixin.qq.com/wxa/submit_audit?access_token='.$authorizer_access_token;
        $data ='{

              "address":"'.$address.'",
              "tag":"假数据",
              "first_class":"'.$first_class.'",
              "second_class":"'.$second_class.'",
              "third_class" :"'.$third_class.'",
              "first_id":"'.$first_id.'",
              "second_id":"'.$second_id.'.",
              "third_id":"'.$third_id.'",
              "title":"假数据"  
        }';//此处的tag,title暂时为假数据

        $ret = json_decode(Third::https_post($url,$data,1));
        if(@$ret->errcode == 0){
            //提交审核成功处理
            $auditid = $ret->auditid;//审核编号

            $sql = "update lkt_third_mini_info set auditid = '$auditid' where store_id = '$store_id'";
            $res = $db->update($sql);
            if($res < 0){

                $msg = '更新小程序审核编号失败！sql语句为：'.$sql."\r\n";
                Third::thirdLog('./webapp/lib/third/third_check.log',$msg);

            }else{
                //入库审核编号成功伪代码
                

            }

            return; 
        }else{

            //提交审核失败处理
            $msg = '提交审核失败，错误码为：'.$ret->errcode."\r\n";
            Third::thirdLog('./webapp/lib/third/third_check.log',$msg);
            return false;
        }



    }


    //获取类目函数
    public function getCategory($authorizer_access_token){

        $url = 'https://api.weixin.qq.com/wxa/get_category?access_token='.$authorizer_access_token;

        $data = '';
        $ret = json_decode(Third::https_post($url,$data,1));

        if(@$ret->errcode == 0){
            //

            return $ret->category_list;
        }else{

            $msg = '获取上传小程序已设置类目失败，错误码为：'.$$ret->errcode."\r\n";
            Third::thirdLog('./webapp/lib/third/third_check.log',$msg);
            return false;

        }
    }

    //获取页面配置函数
    public function getPage($authorizer_access_token){

        $url = 'https://api.weixin.qq.com/wxa/get_page?access_token='.$authorizer_access_token;

        $data = '';

        $ret = json_decode(Third::https_post($url,$data,1));

        if(@$ret->errcode == 0){
            //
            return $ret->page_list;
        }else{

            $msg = '获取小程序的第三方提交代码的页面配置失败,错误码为:'.$ret->errcode."\r\n";
            Third::thirdLog('./webapp/lib/third/third_mould.log',$msg);
            return false;
        }
    }

    //获取体验版二维码
    

	public function getRequestMethods(){

		return Request :: NONE;
	}


} 