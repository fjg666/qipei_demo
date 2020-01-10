<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

class CheckTemplateAction extends Action{


	/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 小程序选择模板接口
     * @date 2019年3月5日
     * @version v2.2.1
     */
    private $laike_url = '';//后台请求地址
    private $kefu_url = '';//客服地址

	public function getDefaultView(){

		$db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
      
        //获取小程序模板信息
        $sql = "select template_id,trade_data,img_url,title from lkt_third_template ";
        $res = $db->select($sql);

        if($res){

          foreach($res as $k => $v){

                $v->image = ServerPath::getimgpath($v->img_url,1);//总控制台上穿模板的图片的store_id 为1

          }
        }
        
        $status ='';
        //1.判断是否有审核编号
        $sql_s = "select auditid,issue_mark from lkt_third_mini_info where store_id = '$store_id'";
        $res_s = $db->select($sql_s);
         
        //2.根据审核编号，判断审核状态
        if(!empty($res_s)){
            $auditid = $res_s[0]->auditid;
            if( $auditid){
                 $status = $this->getStatus($auditid,$store_id);
            }
           
            $issue_mark = $res_s[0]->issue_mark;//发布状态

            //已发布状态下，不可设计小程序，请删除小程序，重新授权
            // if($issue_mark == 3){
            //     header("Content-type:text/html;charset=utf-8");
            //     echo "<script type='text/javascript'>".
            //          "alert('已发布状态下，要重新设计小程序，请先删除小程序，并重新授权');".
            //          "location.href='index.php?module=third&action=Index'</script>";
            //          return ;
            // }

        }
        $auditid = $auditid ? $auditid : '';



        //获取数据字典中全部行业内容
        $trade_all = $this->getAllTrade();


        $request->setAttribute('auditid',$auditid);
        $request->setAttribute('status',$status);//审核状态
        $request->setAttribute('issue_mark',$issue_mark);//发布状态
        $request->setAttribute('res',$res);
       
        $request->setAttribute('trade_all',$trade_all);//所有行业内容


      
        return View :: INPUT;


	}

	public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $template_id = addslashes(trim($request->getParameter('template_id')));//微信模板id
    
        //小程序接口请求地址，客服接口请求地址
        $sql_0 = "select mini_url,kefu_url from lkt_third where 1 = 1";
        $res_0 = $db->select($sql_0);

        $this->laike_url = $res_0[0]->mini_url.'?store_id='.$store_id.'&';//小程序接口请求地址
        $this->kefu_url = $res_0[0]->kefu_url.'&store_id='.$store_id;//客服接口请求地址
        //查询出授权的小程序appid
        $sql = "select authorizer_appid from lkt_third_mini_info where store_id = '$store_id'";
        $res = $db->select($sql);
        
        if($res){
            $extAppid = $res[0]->authorizer_appid;
        }
       
        //1.代码提交
        $res1 =  $this->uploadCode($template_id,$extAppid,$this->laike_url,$this->kefu_url);

        //设置服务器域名
        $token  = Third::updateAuthorizerAccessToken($store_id);
        $res_serve = $this->setServeDomain($store_id,$token);
        if($res_serve != 1){
            echo json_encode(array('msg'=>'设置服务器域名失败'));
            exit;
        }    

        //2.代码审核
        if($res1 ==  1){//提交成功则审核

            $res_check = $this->submitReview();
        }else{
            echo json_encode(array('suc'=>0,'info'=>'提交审核失败，请查看审核日志'));
            exit;
        }
        //3.代码发布

        if($res_check == 1){

            echo json_encode(array('suc'=>1,'info'=>'提交审核成功！'));
            exit;
        }else{

            echo json_encode(array('suc'=>0,'info'=>'提交审核失败'));
            exit;
        }


	}

    /**
     * 为授权的小程序帐号上传小程序代码
     * @param int $template_id : 模板ID
     * @param json $ext_json : 小程序配置文件，json格式
     * @param string $user_version : 代码版本号
     * @param string $user_desc : 代码描述
     * */

    public function uploadCode($template_id,$extAppid,$laike_url,$kefu_url){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //获取授权token

        $authorizer_access_token = Third::updateAuthorizerAccessToken($store_id);

        //post请求
        $url = 'https://api.weixin.qq.com/wxa/commit?access_token='.$authorizer_access_token;

        $user_version = 'v1.0.0';
        $user_desc = '来客官方授权';
        $ext_json = '{
            "extEnable": true,
            "extAppid":"'.$extAppid.'",
            "ext":{
                "url":"'.$laike_url.'",
                "kefu_url":"'.$kefu_url.'"
            }
        }';

        $data = json_encode(array(
            'template_id'=>$template_id,
            'ext_json'=>$ext_json,
            'user_version'=>$user_version,
            'user_desc'=>$user_desc
        ));
        Third::thirdLog('./webapp/lib/third/check_template.log',"data数据为：".$data."\r\n");

        $ret = json_decode(Third::https_post($url,$data,1));

        if(@$ret->errcode == 0){

             //  
             Third::thirdLog('./webapp/lib/third/check_template.log',"url覆盖成功，url为".$laike_url."\r\n");
             return 1; 
           
        }else{

            Third::thirdLog('./webapp/lib/third/check_template.log','代码上传失败，错误码为：'.$ret->errcode.'错误为：'.$ret->errmsg."\r\n");
            return false;
        }

        
    }


    /**
     * 提交审核
     *1.获取授权小程序帐号已设置的类目
     *2.获取小程序的第三方提交代码的页面配置（仅供第三方开发者代小程序调用）
     *3.将第三方提交的代码包提交审核（仅供第三方开发者代小程序调用）
     * */
    public function submitReview(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');


        //获取小程序token
        $authorizer_access_token = Third::updateAuthorizerAccessToken($store_id);


        //1.获取类目    
        $category =  $this->getCategory($authorizer_access_token);

        //2.获取页面配置
        $page_list =  $this->getPage($authorizer_access_token);


        $first_class = '';
        $second_class = '';
      

        $first_id = 0;
        $second_id = 0;
       

        if(!empty($category)){
            $first_class = $category[0]->first_class ? $category[0]->first_class : '';
            $second_class = $category[0]->second_class ? $category[0]->second_class : '';
           

            $first_id = $category[0]->first_id ? $category[0]->first_id : 0;
            $second_id = $category[0]->second_id ? $category[0]->second_id : 0;
           
        }

        $address = '';//小程序页面
        if(!empty($page_list) && isset($page_list[0])){

            $address = $page_list[0];
        }
    
        $url = 'https://api.weixin.qq.com/wxa/submit_audit?access_token='.$authorizer_access_token;
        $data ='{
                "item_list":[

                    {

                      "address":"'.$address.'",
                      "tag":"电商",
                      "first_class":"'.$first_class.'",
                      "second_class":"'.$second_class.'",
                      "first_id":"'.$first_id.'",
                      "second_id":"'.$second_id.'",
                      "title":"来客授权"   
                    }

                ]

        }';//此处的tag,title暂时为假数据

        $ret = json_decode(Third::https_post($url,$data,1));
        if(@$ret->errcode == 0){
            //提交审核成功处理
            $auditid = $ret->auditid;//审核编号

            Third::thirdLog('./webapp/lib/third/check_template.log','审核编号为：'.$auditid."\r\n");
            $sql = "update lkt_third_mini_info set auditid = '$auditid',issue_mark = 1 where store_id = '$store_id'";//提交审核，将发布转态置为1
            $res = $db->update($sql);
            if($res < 0){

                $msg = '更新小程序审核编号失败！sql语句为：'.$sql."\r\n";
                Third::thirdLog('./webapp/lib/third/check_template.log',$msg);
                return false;

            }else{
                return 1;
                

            }
        }else{

            //提交审核失败处理
            $msg = '提交审核失败，错误为：'.$ret->errcode.'错误为：'.$ret->errmsg."\r\n";
            Third::thirdLog('./webapp/lib/third/check_template.log',$msg);
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

            $msg = '获取上传小程序已设置类目失败，错误码为：'.$ret->errcode.'错误为：'.$ret->errmsg."\r\n";
            Third::thirdLog('./webapp/lib/third/check_template.log',$msg);
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

            $msg = '获取小程序的第三方提交代码的页面配置失败,错误码为:'.$ret->errcode.'错误为：'.$ret->errmsg."\r\n";
            Third::thirdLog('./webapp/lib/third/check_template.log',$msg);
            return false;
        }
    }

	public function getRequestMethods(){

		return Request :: POST;
	}
    /**
    * 第三方授权-设置服务器域名
    * @param $store_id 商城id
    * @param $token 授权token
    */
    public function setServeDomain($store_id,$token){


        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        //查询配置服务器域名
        $sql = "select serve_domain from lkt_third where id = 1";
        $res = $db->select($sql);

        if($res){
            $serve_domain = $res[0]->serve_domain;

            $https = array();
            $wss = array();
            $serve_arr = explode(',',$serve_domain);
            foreach($serve_arr as $k => $v){
                   
               $https[$k] = 'https://'.$v;
               $wss[$k] = 'wss://'.$v;
            }

            $data = array();
            $data['action'] = 'set';
            $data['requestdomain'] = $https;
            $data['wsrequestdomain'] = $wss;
            $data['uploaddomain'] = $https;
            $data['downloaddomain'] = $https;


            $data = json_encode($data);


            $url = 'https://api.weixin.qq.com/wxa/modify_domain?access_token='.$token;

            $ret = json_decode(Third::https_post($url,$data,1));

            if(@$ret->errcode == 0){

                return 1;
            }else{

                Third::thirdLog('./webapp/lib/third/check_template.log','设置服务器域名失败，错误信息为：'.$ret->errmsg."\r\n");
                 return false;
            }


        }

    } 

    //获取审核状态
    public function getStatus($auditid,$store_id){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
    
        $authorizer_access_token  = Third::updateAuthorizerAccessToken($store_id);

        $url = 'https://api.weixin.qq.com/wxa/get_auditstatus?access_token='.$authorizer_access_token;
        $data = '{
            "auditid":"'.$auditid.'"
        }';

        $ret = json_decode(Third::https_post($url,$data,1));

        if(@$ret->errcode == 0){//获取审核状态成功
            return $ret->status;
        }else{//获取审核状态失败
            Third::thirdLog('./webapp/lib/third/check_template.log','获取审核状态失败，错误信息为：'.$ret->errmsg."\r\n");
            return '获取审核状态失败' ;
        }

    } 

    //获取数据字典中的全部行业数据
    private function getAllTrade(){


        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
   

        //查询数据字典的模板行业
        $sql_data = "select code,value from lkt_data_dictionary where name = '小程序模板行业' and status = 1 and recycle = 0";
        $res_data = $db->select($sql_data);

        $trade_arr = array();
        if($res_data){

            foreach($res_data as $k => $v){

                $value = $v->value;//键,值
                $value_arr = explode(',',$value);

                $my_obj = new stdClass();
                $my_obj->trade_text = $value_arr[1];//显示的行业
                $my_obj->trade_code = $v->code;//对应数据编码

                $trade_arr[$k] = $my_obj;

            }

        }  
        return $trade_arr;
    }

}