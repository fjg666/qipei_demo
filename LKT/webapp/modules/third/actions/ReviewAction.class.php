<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');
/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 总控制台发布接口
     * @date 2019年3月11日
     * @version v2.2.1
     */
class  ReviewAction extends Action{



	public function getDefaultView(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();


        $nick_name = addslashes(trim($request->getParameter('nick_name')));//小程序名称
        $status = addslashes(trim($request->getParameter('status')));//审核状态
        $issue_mark = addslashes(trim($request->getParameter('issue_mark')));//发布状态

        //分页参数
        $pagesize = addslashes(trim($request->getParameter('pagesize')));
        $page = addslashes(trim($request->getParameter('page')));

        $pagesize = $pagesize ? $pagesize : 10;
        
        if($page){
        	$start = ($page-1)*10;
        }else{
        	$page = 1;
        	$start = 0;
        }
        

        //初始化查询条件
        $condition = " a.store_id = b.id ";
        if($nick_name){

        	$condition .= " where a.nick_name = '$nick_name' ";
        }
        if($issue_mark){

        	$condition .= " and a.issue_mark = '$issue_mark' ";
        }

        $sql = "select COUNT(*) as num from lkt_third_mini_info as a inner join lkt_customer as b on ".$condition;
        $res = $db->select($sql);

        if($res){
        	$total = $res[0]->num;//总记录数
        }

        //实例化分页类
        $showpager = new ShowPager($total,$pagesize,$page);
        $offset = $showpager -> offset;

        $sql = "select a.id,nick_name,auditid,submit_time,issue_mark,head_img,b.name,b.id as store_id from lkt_third_mini_info as a inner join lkt_customer as b on ".$condition." order by a.id desc limit $offset,$pagesize ";
        $res = $db->select($sql);

        //如果查询字段的审核状态字段非空   
    
        if($res){
                foreach($res as $k => $v){

                    if(!empty($v->auditid)){//审核编号非空
                        $wx_status = $this->getStatus($v->auditid,$v->store_id);
                        $v->status = $wx_status; 
                        if($status !== ''){
                            //var_dump('非空');
                            if($status != $wx_status){
                                unset($res[$k]);
                            }
                                 
                        }
                    }else{//审核编号为空
                        $v->status = 4;
                        if($status !== ''){
                            if($status != $v->status){
                                unset($res[$k]);
                            }
                        }
                    }
                }
        }

        

		$url="index.php?module=third&action=Review&nick_name=".urlencode($nick_name)."&status=".urlencode($status)."&issue_mark=".urlencode($issue_mark);	
		$pages_show = $showpager->multipage($url,$total,$page,$pagesize,$start,$para='');

		$request->setAttribute('res',$res);
		$request->setAttribute('pages_show',$pages_show);
		$request->setAttribute('nick_name',$nick_name);
		$request->setAttribute('status',$status);
		$request->setAttribute('issue_mark',$issue_mark);

		return View :: INPUT;
	}

	public function execute(){//

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $auditid = addslashes(trim($request->getParameter('auditid')));//审核编号
        //根据审核编号，查询商城id
        $sql = "select store_id from lkt_third_mini_info where auditid = '$auditid'";
        $res = $db->select($sql);
        if(empty($res)){
            echo json_encode(array('msg'=>'发布失败，缺少商城信息！'));
            exit;
        }

        $store_id = $res[0]->store_id;
        $token  = Third::updateAuthorizerAccessToken($store_id);

        //因为设置模板消息的模板库中关键词，微信经常会更新所以导致顺序会不断改变，所以模板消息最好是用户自己设置
        // //获取用户所有模板消息，并清空
        // $list = $this->templateList($store_id,$token);//模板消息数组

        // if($list != ''){

        //     foreach($list as $k => $v){

        //         $template_id = $v->template_id;//小程序模板消息id
        //         $del_res =  $this->templateDel($store_id,$token,$template_id);
        //         if($del_res != 1){
        //             echo json_encode(array('msg'=>'初始化模板消息失败！'));
        //             exit;
        //         }
        //     }

        // }

        
        // //组合模板关键提交公众平台，并存入数据库
        // $res_add = $this->addTemplate($store_id,$token);
        
        // if($res_add != 1){
        //     echo json_encode(array('msg'=>'模板消息设置失败！'));
        //     exit;
        // }

        // 删除业务域名
        // $del_serve = $this->delServeDomain($store_id,$token);
        // die;

        //设置服务器域名
        // $res_serve = $this->setServeDomain($store_id,$token);
        // if($res_serve != 1){
        //     echo json_encode(array('msg'=>'设置服务器域名失败'));
        //     exit;
        // }


        //设置业务域名
        $res_work = $this->setWorkDomain($store_id,$token);
        if($res_work != 1){
            echo json_encode(array('msg'=>'设置业务域名失败'));
            exit;
        }

        $res = $this->relase($auditid,$token);
        if($res == 1){
            echo json_encode(array('suc'=>1,'msg'=>'发布小程序成功！'));
            exit;
        }else{
            echo json_encode(array('msg'=>'发布小程序失败！'));
            exit;
        }


	}

    //获取账号下20条模板消息
    public function templateList($store_id,$token){

        $data = '{
            "offset":0,
            "count":20
        }';
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token='.$token;

        $ret = json_decode(Third::https_post($url,$data,1));
        if(@$ret->errcode == 0){

            return $ret->list;
        }else{
            Third::thirdLog('./webapp/lib/third/check_template.log','获取模板消息列表失败，errmsg为：'.$ret->errmsg."\r\n");
            return false;
        }
    }
    //删除账号下模板消息
    public function templateDel($store_id,$token,$template_id){

        $data = '{
            "template_id":"'.$template_id.'"
        }';

        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/del?access_token='.$token;

        $ret = json_decode(Third::https_post($url,$data,1));

        if(@$ret->errcode == 0){
            return 1;
        }else{
            Third::thirdLog('./webapp/lib/third/check_template.log','删除模板消息失败，errmsg为：'.$ret->errmsg."\r\n");
            return false;
        }
    }

    //获取审核状态
    public function getStatus($auditid,$store_id){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
    
        $authorizer_access_token   = Third::updateAuthorizerAccessToken($store_id);

        $url = 'https://api.weixin.qq.com/wxa/get_auditstatus?access_token='.$authorizer_access_token;
        $data = '{
            "auditid":"'.$auditid.'"
        }';

        $ret = json_decode(Third::https_post($url,$data,1));

        if(@$ret->errcode == 0){//获取审核状态成功
            return @$ret->status;
        }else{//获取审核状态失败
            Third::thirdLog('./webapp/lib/third/check_template.log','获取审核状态失败，错误信息为：'.$ret->errmsg."\r\n");
            return '获取审核状态失败' ;
        }

    } 

    //发布小程序代码
    public function relase($auditid,$token){//发布

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $url = 'https://api.weixin.qq.com/wxa/release?access_token='.$token;
        $data = '{}';

        $ret = json_decode(Third::https_post($url,$data,1));
        if(@$ret->errcode == 0){

            $sql = "update lkt_third_mini_info set issue_mark = 3 where auditid = '$auditid'";
            $res = $db->update($sql);

            return 1;
        }else{
            $sql = "update lkt_third_mini_info set issue_mark = 1,auditid = '' where auditid = '$auditid'";
            $res = $db->update($sql);
            Third::thirdLog('./webapp/lib/third/check_template.log','后台发布小程序失败，errmsg：'.$ret->errmsg);
            return false;
        }   

    }

    /**
    * 第三方授权-模板消息自动配置
    * @param $store_id 商城id
    * @param $token 授权token
    */
    public function addTemplate($store_id,$token){


        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        //模板消息配置数据
        $sql = "select * from lkt_notice_config ";
        $res = $db->select($sql);
        if($res){
            $status = 1;//标识
            $template_id = '';
            foreach($res as $k =>$v){
                $e_name = $v->e_name;//对应模板消息库字段
                $stock_id = $v->stock_id;//微信模板库id
                $stock_key = $v->stock_key;//组合关键词
                $stock_key = '['.$stock_key.']';
                $template_id = $this->addWxTemplate($token,$stock_id,$stock_key);//提交公众平台，获取id
                
                if($template_id != ''){
                     //根据是否已有模板消息配置，选择更新，或者插入
                    $sql_s = "select id from lkt_notice where store_id = '$store_id'";
                    $res_s = $db->select($sql_s);

                    if(empty($res_s)){
                        $sql_0 = "insert lkt_notice (store_id,$e_name) values ('$store_id','$template_id')";
                        $res_0 = $db->insert($sql_0);

                    }else{
                        $sql_0 = "update lkt_notice set $e_name = '$template_id' where store_id = '$store_id'";
                        $res_0 = $db->update($sql_0); 
                    }   

                    
                }else{
                    $status = 0;
                    break;
                }
               
               
                if($res_0 < 0 ){
                    $status = 0;
                   break;
                }
            }
            if($status == 1) {
                return 1;
            }else{
                return false;
            }
        }

    }

     /**
    * 第三方授权-获取模板消息id
    * @param $token 授权token
    * @param $stock_id 微信模板库id
    * @param $stock_key 组合关键词
    */
    private function addWxTemplate($token,$stock_id,$stock_key){

        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token='.$token;

        $data = '{
            "id":"'.$stock_id.'",
            "keyword_id_list":'.$stock_key.'
        }';

        $ret = json_decode(Third::https_post($url,$data,1));
        
        if(@$ret->errcode == 0){

            return  $ret->template_id;
        }else{

            Third::thirdLog('./webapp/lib/third/check_template.log','获取模板消息id失败，错误信息为：'.$ret->errmsg."模板库id为：".$stock_id."\r\n");
            return false;
        }
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

    //删除业务域名
     public function delServeDomain($store_id,$token){


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
            $data['action'] = 'delete';
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

                Third::thirdLog('./webapp/lib/third/check_template.log','删除服务器域名失败，错误信息为：'.$ret->errmsg."\r\n");
                 return false;
            }


        }

    } 


    /**
    * 第三方授权-设置业务域名
    * @param $store_id 商城id
    * @param $token 授权token
    */
    public function setWorkDomain($store_id,$token){

        
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        //查询配置服务器域名
        $sql = "select work_domain from lkt_third where id = 1";
        $res = $db->select($sql); 

        if($res){
            $work_domain = $res[0]->work_domain;

            $work_arr = explode(',',$work_domain);

            $https = array();
            $wss = array();

            foreach($work_arr as $k => $v){
                $https[$k] = 'https://'.$v;
               
            }

            $data = array();
            $data['action'] = 'add';
            $data['webviewdomain'] = $https;

            $data = json_encode($data);//转json
            $url = 'https://api.weixin.qq.com/wxa/setwebviewdomain?access_token='.$token;

            $ret = json_decode(Third::https_post($url,$data,1));
            if($ret->errcode == 0){
                return 1;
            }else{
                Third::thirdLog('./webapp/lib/third/check_template.log','设置业务域名失败，err_msg：'.$ret->err_msg."\r\n");
                return false;
            }

            
        }
               
    }

	public function getRequestMethods(){

		return Request :: POST;
	}

}