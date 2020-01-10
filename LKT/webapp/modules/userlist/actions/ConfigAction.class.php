<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class ConfigAction extends Action{
	public function getDefaultView(){
    
        //初始化
		    $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $sql = "select * from lkt_user_rule where store_id = '$store_id' ";
        $res = $db->select($sql);

       	if($res){
       		$active = explode(',',$res[0]->active);//插件表示数组
          $wait = $res[0]->wait;
       		$rule = $res[0]->rule;
          $method = explode(',',$res[0]->method);
          $upgrade = explode(',',$res[0]->upgrade);
          $is_auto = $res[0]->is_auto;
          $auto_time = $res[0]->auto_time;
          $is_wallet = $res[0]->is_wallet;
          $is_birthday = $res[0]->is_birthday;
          $bir_multiple = $res[0]->bir_multiple;
          $is_product = $res[0]->is_product;
          $is_jifen = $res[0]->is_jifen;
          $jifen_m = $res[0]->jifen_m;
          $back = $res[0]->back;
          $back_scale = $res[0]->back_scale;
          $poster = ServerPath::getimgpath($res[0]->poster,$store_id);
          $is_limit = $res[0]->is_limit;
          $level = $res[0]->level;
          $distribute_l = $res[0]->distribute_l;
          $valid = $res[0]->valid;
          $score = $res[0]->score;
       	}else{
          $active = array();
          $wait = '';
          $rule = '';
          $method = array();
          $upgrade = array();
          $is_auto = '';
          $auto_time = '';
          $is_wallet = '';
          $is_birthday = '';
          $bir_multiple = '';
          $is_product = '';
          $is_jifen = '';
          $jifen_m = '';
          $back = '';
          $back_scale = '';
          $poster = '';
          $is_limit = '';
          $level = '';
          $distribute_l = '';
          $valid = '';
          $score = 0;
       	}

     
        //享受优惠的商品
        
        //开通方式
      
        if(in_array('1',$method)){
          $str_method = '<div class="ra1"><input name="method[]" type="checkbox" id="sex-1" class="inputC"  checked="checked"  value="1"><label for="sex-1">包月</label></div>';
        }else{
          $str_method = '<div class="ra1"><input name="method[]" type="checkbox" id="sex-1" class="inputC"   value="1"><label for="sex-1">包月</label></div>';
        }
        if(in_array('2',$method)){
          $str_method .= '<div class="ra1"><input name="method[]" type="checkbox" id="sex-2" class="inputC"  checked="checked"  value="2"><label for="sex-2">包季</label></div>';
        }else{
          $str_method .= '<div class="ra1"><input name="method[]" type="checkbox" id="sex-2" class="inputC"   value="2"><label for="sex-2">包季</label></div>';
        }
        if(in_array('3',$method)){
          $str_method .= '<div class="ra1"><input name="method[]" type="checkbox" id="sex-3" class="inputC"  checked="checked"  value="3"><label for="sex-3">包年</label></div>';
        }else{
          $str_method .= '<div class="ra1"><input name="method[]" type="checkbox" id="sex-3" class="inputC"   value="3"><label for="sex-3">包年</label></div>';
        }

        //会员默认头像和用户名
        $sql = "select wx_headimgurl,wx_name from lkt_config where store_id = $store_id";
        $res = $db->select($sql);
        if($res){
          $wx_name = $res[0]->wx_name;
          $wx_headimgurl = ServerPath::getimgpath($res[0]->wx_headimgurl,$store_id);
        }else{
          $wx_name = '';
          $wx_headimgurl = '';
        }

        //会员等级
        $sql_2 = "select id,name from lkt_user_grade where store_id = $store_id order by rate desc";
        $res_2 = $db->select($sql_2);

        if(!$res_2){
          $res_2  = array();
        }
        
        $request->setAttribute('active',$active);
        $request->setAttribute('str_method',$str_method);
        $request->setAttribute('wait',$wait);
        $request->setAttribute('rule',$rule);
        $request->setAttribute('score',$score);
        $request->setAttribute('wx_name',$wx_name);
        $request->setAttribute('wx_headimgurl',$wx_headimgurl);
        $request->setAttribute('upgrade',$upgrade);
        $request->setAttribute('is_auto',$is_auto);
        $request->setAttribute('auto_time',$auto_time);
        $request->setAttribute('is_wallet',$is_wallet);
        $request->setAttribute('is_birthday',$is_birthday);
        $request->setAttribute('bir_multiple',$bir_multiple);
        $request->setAttribute('is_product',$is_product);
        $request->setAttribute('is_jifen',$is_jifen);
        $request->setAttribute('jifen_m',$jifen_m);
        $request->setAttribute('back',$back);
        $request->setAttribute('back_scale',$back_scale);
        $request->setAttribute('poster',$poster);
        $request->setAttribute('is_limit',$is_limit);
        $request->setAttribute('level',$level);//会员等级的id
        $request->setAttribute('distribute_l',$distribute_l);//会员等级的id
        $request->setAttribute('valid',$valid);
        $request->setAttribute('grade',$res_2);

        return View :: INPUT;
	}
	public function execute(){

		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
    $store_id=$this->getContext()->getStorage()->read('store_id');
    $wx_headimgurl = addslashes(trim($request->getParameter('wx_headimgurl')));//默认头像
    $wx_name = addslashes(trim($request->getParameter('wx_name')));//默认昵称
    $is_auto = addslashes(trim($request->getParameter('is_auto')));//是否自动续费
    $auto_time = addslashes(trim($request->getParameter('auto_time')));//是否自动续费
    $method =$request->getParameter('method');//开通方式
    $active = $request->getParameter('active');//可支持活动  
    $is_wallet = addslashes(trim($request->getParameter('is_wallet')));//是否开启余额支付  
    $wait = addslashes(trim($request->getParameter('wait')));//会员权限持续时间
    $rate_now = addslashes(trim($request->getParameter('rate_now')));//基础折率
    $rule = addslashes(trim($request->getParameter('rule')));//规则详情
    $upgrade = $request->getParameter('upgrade');//晋升方式
    $is_birthday = addslashes(trim($request->getParameter('is_birthday')));//生日特权
    $bir_multiple = addslashes(trim($request->getParameter('bir_multiple')));//积分倍数
    $is_product = addslashes(trim($request->getParameter('is_product')));//商品赠送
    $is_jifen = addslashes(trim($request->getParameter('is_jifen')));//积分比例
    $jifen_m = addslashes(trim($request->getParameter('jifen_m')));//积分发送规则
    $back = addslashes(trim($request->getParameter('back')));//是否开启返现
    $back_scale = addslashes(trim($request->getParameter('back_scale')));//返现比例
    $poster = addslashes(trim($request->getParameter('poster')));//会员分享海报
    $is_limit = addslashes(trim($request->getParameter('is_limit')));//是否开启推荐限制
    $level = addslashes(trim($request->getParameter('level')));//会员等级的id
    $distribute_l = addslashes(trim($request->getParameter('distribute_l')));//会员等级的id
    $valid = addslashes(trim($request->getParameter('valid')));//兑换商品有效期
    $score = addslashes(trim($request->getParameter('score')));//积分有效时间
    $log = new LaiKeLogUtils('common/userlist.log');
    if($active){
      $active = implode(',',$active);
    }
    if($method){
      $method = implode(',', $method);
    }
    if($upgrade){
      $upgrade = implode(',',$upgrade);
    }
    //默认头像，用户名设置
    $sql = "select * from lkt_config where store_id = $store_id ";
    $res = $db->select($sql);
    if($res){
      if($wx_headimgurl){
            $wx_headimgurl = preg_replace('/.*\//','',$wx_headimgurl);//获取头像名称
      }
      $sql_0 = "update lkt_config set wx_headimgurl = '$wx_headimgurl',wx_name = '$wx_name' where store_id = $store_id";
      $res_0 = $db->update($sql_0);
      if($res_0 < 0){
          $log -> customerLog(__LINE__.':更新系统配置失败，sql为：'.$sql_0."\r\n");
          echo json_encode(array('code'=>0,'设置用户默认信息失败'));
          exit;
      }
    }else{
      echo json_encode(array('code'=>0,'msg'=>'请先完善系统设置'));
      exit;
    }

    if($poster){
      $poster = preg_replace('/.*\//','',$poster);//会员分享海报
    }
    if($is_product == 0){//重置每个会员等级赠送商品
      $sql = "update lkt_user_grade set pro_id = NULL where store_id = $store_id and pro_id is not NULL";
      $res = $db->update($sql);
      if($res < 0){
        $log -> customerLog(__LINE__.':会员等级赠送商品重置失败，sql为：'.$sql."\r\n");
        echo json_encode(array('code'=>0,'msg'=>'关闭会员赠送商品失败'));
        exit;
      }
    }

    //查询是否有配置
    $sql = "select id from lkt_user_rule where store_id = '$store_id'";
    $res = $db->select($sql);
    if($res){
      $sql_0 = "update lkt_user_rule set is_auto = $is_auto,auto_time = $auto_time,method = '$method',active = '$active',is_wallet = $is_wallet,upgrade = '$upgrade',is_birthday = '$is_birthday',bir_multiple = '$bir_multiple',is_product = '$is_product',rule = '$rule',is_jifen = '$is_jifen',jifen_m = '$jifen_m',back = '$back',back_scale = '$back_scale',poster = '$poster',is_limit = '$is_limit',level = '$level',distribute_l = '$distribute_l',valid = '$valid',score='$score'   where store_id = '$store_id' ";
      $res_0 = $db->update($sql_0);
    }else{
      $sql_0 = "insert into lkt_user_rule (is_auto,auto_time,method,active,is_wallet,upgrade,is_birthday,bir_multiple,is_product,rule,is_jifen,jifen_m,back,back_scale,poster,is_limit,level,distribute_l,valid,store_id,score) values ('$is_auto','$auto_time','$method','$active','$is_wallet','$upgrade','$is_birthday','$bir_multiple','$is_product','$rule','$is_jifen','$jifen_m','$back','$back_scale','$poster','$is_limit','$level','$distribute_l',$valid,'$store_id','$score')";
      $res_0 = $db->insert($sql_0);
    }
    if($res_0 < 0){
      $log -> customerLog(__LINE__.':更新会员规则失败，sql为：'.$sql_0."\r\n");
      echo json_encode(array('code'=>0,'msg'=>'设置等级规则失败'));
      exit;
    }else{
      echo json_encode(array('code'=>1,'msg'=>'设置等级规则成功'));
      exit;
    }
       
		return;
	}
	public function getRequestMethods(){
		return Request :: POST;
	}
}