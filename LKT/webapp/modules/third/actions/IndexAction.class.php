<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/third/authorize/Third.class.php');

/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 管理小程序页接口
     * @date 2019年3月5日
     * @version v2.2.1
     */
class IndexAction extends Action{

    
	public function getDefaultView(){
             
			$db = DBAction::getInstance();
    		$request = $this->getContext()->getRequest();
            $store_id = $this->getContext()->getStorage()->read('store_id');
            $m = addslashes(trim($request->getParameter('m')));//操作名
            if($m == 'del'){
                $this->del();
            }else if($m == 'downPtCode'){//普通二维码
               
                $this->downPtcode();
            }else if($m == 'downMiniCode'){//小程序码

                $this->downMiniCode();
            }
 
            //小程序基本信息及发布状态

            $sql = "select nick_name,head_img,auditid,issue_mark from lkt_third_mini_info where store_id = '$store_id'";

            $res = $db->select($sql);
            if($res){
            	$nick_name = $res[0]->nick_name;
            	$head_img = $res[0]->head_img;
                $auditid = $res[0]->auditid;//提交审核时获得的审核id
                $issue_mark = $res[0]->issue_mark;//发布状态

            }else{

            	header("Content-type:text/html;charset=utf-8");
            	echo "<script type='text/javascript'>".
            	 	 "alert('未授权，请返回授权页');".
            	 	 "location.href='index.php?module=third&action=Auth';</script>";
            	return ; 	 
            }
            $condition = 0;
            
           
         

            $status = 4;//未审核状态
            $reason = '';
            
            //获取审核状态
             if(!empty($auditid)){

                 $res = $this->getStatus($auditid);//0为审核成功，1为审核失败，2为审核中，3已撤回
                
                 if(is_array($res)){
                     $status = $res['status'];//审核失败状态值
                     $reason = $res['reason'];//审核失败reason

                 }else{

                     $status = $res;//状态值
                  
                 }

             }
            
            // $this->undo();

             //体验版二维码接口地址
             $sql = "select qr_code from lkt_third where 1=1";
             $res = $db->select($sql);
             if($res){
                $qr_code = $res[0]->qr_code;
             }
           
            
            $request->setAttribute('status',$status);
            $request->setAttribute('reason',$reason);
            $request->setAttribute('nick_name',$nick_name);
            $request->setAttribute('head_img',$head_img);
            $request->setAttribute('issue_mark',$issue_mark);
            $request->setAttribute('qr_code',$qr_code);

           


            return View :: INPUT;

	}
    
    //取消审核
    public function undo(){

         $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $authorizer_access_token   = Third::updateAuthorizerAccessToken($store_id);

        $url = 'https://api.weixin.qq.com/wxa/undocodeaudit?access_token='.$authorizer_access_token;

        $ret = json_decode(Third::https_get($url,1));
        if($ret->errcode == 0){

            Third::thirdLog('./webapp/lib/third/check_template.log','取消审核成功'."\r\n");
        }else{
            Third::thirdLog('./webapp/lib/third/check_template.log','取消审核失败，errmsg为：'.$ret->errmsg."\r\n");
        }

    }

    public function del(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //$sql = "delete from lkt_third_mini_info where store_id = '$store_id'";
        $sql = "update lkt_third_mini_info set issue_mark = 1, auditid = NULL  where store_id = '$store_id'";
        $res = $db->delete($sql);

        if($res > 0){

              echo json_encode(array('status'=>1,'info'=>'删除小程序成功'));
              exit;
        }else{

            echo json_encode(array('status'=>0,'info'=>'删除小程序失败'));
            exit;
        }
    }

    //获取审核状态
    public function getStatus($auditid){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $authorizer_access_token   = Third::updateAuthorizerAccessToken($store_id);
       
        $url = 'https://api.weixin.qq.com/wxa/get_auditstatus?access_token='.$authorizer_access_token;

        $data = '{
            "auditid":"'.$auditid.'"
        }';
        
        $msg_arr=array();
        $ret = json_decode(Third::https_post($url,$data,1));

        
        if(@$ret->errcode == 0){//获取审核状态成功
            
            if($ret->status == 1){//审核失败
                $msg_arr['status'] = $ret->status;
                $msg_arr['reason'] = $ret->reason;
                return $msg_arr;

            }else{
                 return $ret->status;
            }
          
        }else{//获取审核状态失败
            Third::thirdLog('./webapp/lib/third/check_template.log','获取审核状态失败，错误信息为：'.$ret->errmsg."\r\n");
            return '获取审核状态失败' ;
        }

    } 



    //下载普通二维码
    public function downPtCode(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');  
        $width = addslashes(trim($request->getParameter('width')));//二维码宽度
        header("Content-type: image/jpeg");
        $authorizer_access_token = Third::updateAuthorizerAccessToken($store_id);//授权token

        $data = array();
        $data['width'] = $width;
        $data['path'] = 'pages/index/index';

        $data = json_encode($data);
        $url = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token='.$authorizer_access_token;      
        $ret = json_decode(Third::https_post($url,$data,2));

        if(@$ret->errcode == 0){
            return $ret;
        }else{
            Third::thirdLog('./webapp/lib/third/check_template.log','下载普通二维码失败，errmsg为：'.$ret->errmsg."\r\n");
            return false;
        }

    }

    //下载小程序码
    public function downMiniCode(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');  
           header("Content-type: image/jpeg");
        $width = addslashes(trim($request->getParameter('width')));//小程序码宽度

        $authorizer_access_token = Third::updateAuthorizerAccessToken($store_id);//授权token

        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$authorizer_access_token;

        $data = array();
        $data['path'] = 'pages/index/index';
        $data['width'] = $width;

        $data = json_encode($data);

        $ret = json_decode(Third::https_post($url,$data,2));
        if($ret->errcode == 0){

            return $ret;
        }else{
            
            Third::thirdLog('./webapp/lib/third/check_template.log','下载小程序码失败，errmsg为：'.$ret->errmsg."\r\n");
            return false;
        }
    }


	public function execute(){

	}

	public function getRequestMethods()
    {
        return Request :: NONE;
    }

}