<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class AddAction extends Action
{
	public function getDefaultView(){
	    $db = DBAction::getInstance();
      $request = $this->getContext()->getRequest();
      $store_id = $this->getContext()->getStorage()->read('store_id');

      //默认头像 和 昵称
      $sql = "select wx_headimgurl,wx_name from lkt_config where store_id = '$store_id'";
      $res = $db->select($sql);
      if($res){
        $wx_name = $res[0]->wx_name;
        $wx_headimgurl = ServerPath::getimgpath($res[0]->wx_headimgurl,$store_id);
      }else{
        $wx_name = '';
        $wx_headimgurl = '';
      }
      //会员级别
      $sql = "select *  from lkt_user_grade where store_id = $store_id order by rate desc ";
      $res = $db->select($sql);
      $str_grade = '<option value="0">普通会员</option>';
      if($res){
        foreach ($res as $k => $v) {
          $str_grade .= '<option value="'.$v->id.'">'.$v->name.'</option>';
        }
      }
      //充值时长
      $sql = "select method  from lkt_user_rule where store_id = '$store_id'";
      $res = $db->select($sql);
      $str_method = '';
      if($res){
        $method = explode(',',$res[0]->method);
        foreach($method as $k => $v){
          if($v == 1){
            $str_method .= '<option value="'.$v.'">包月</option>';
          }else if($v == 2){
            $str_method .= '<option value="'.$v.'">包季</option>';
          }else if($v == 3){
            $str_method .= '<option value="'.$v.'">包年</option>';
          }

        }
      }



      $request -> setAttribute('wx_name', $wx_name);
      $request -> setAttribute('wx_headimgurl', $wx_headimgurl);
      $request -> setAttribute('str_grade', $str_grade);
      $request -> setAttribute('str_method', $str_method);
      return View :: INPUT;
	}
	public function execute(){
  		$db = DBAction::getInstance();
  		$request = $this->getContext()->getRequest();
  		$store_id = $this->getContext()->getStorage()->read('store_id');
      $wx_headimgurl = addslashes(trim($request->getParameter('wx_headimgurl')));//用户头像
      $wx_name = addslashes(trim($request->getParameter('wx_name')));//用户名
      $grade = addslashes(trim($request->getParameter('grade')));//会员级别
      $method = addslashes(trim($request->getParameter('method')));//续费时长
      $zhanghao = addslashes(trim($request->getParameter('zhanghao')));//账号
      $mima = addslashes(trim($request->getParameter('mima')));//密码
      $mima2 = addslashes(trim($request->getParameter('mima2')));//确认密码
      $mobile = addslashes(trim($request->getParameter('mobile')));//手机号
      $source = addslashes(trim($request->getParameter('source')));//来源
      $log = new LaiKeLogUtils('common/userlist.log');
      //根据选择充值时长，继续到期时间
      if($method == 1){//包月
          $grade_end = date("Y-m-d H:i:s",strtotime("+1 months"));
      }else if($method == 2){//包季
          $grade_end = date("Y-m-d H:i:s",strtotime("+3 months"));
      }else if($method == 3){//包年
          $grade_end = date("Y-m-d H:i:s",strtotime("+1 years"));
      }else{
        $grade_end = '';
      }
     
      $user_zhanghao =  $zhanghao;//用户账号
      $user_mobile = $mobile;//用户手机号

      //密码判断
      if(strlen($mima) < 6){
        echo json_encode(array('code'=>0,'msg'=>'密码不能低于六位数'));
        exit;
      }
      if($mima){
        if($mima != $mima2){
          echo json_encode(array('code'=>0,'msg'=>'确认密码不一致'));
          exit;
        }else{
          $mima = $db->lock_url($mima);
        }
      }
      //账号唯一性判断
      $sql_1 = "select id from lkt_user where store_id = '$store_id' and zhanghao = '$user_zhanghao'";
      $res_1 = $db->select($sql_1);
      if($res_1){
        echo json_encode(array('code'=>0,'msg'=>'该账号已存在'));
        exit;
      }

      //手机号唯一判定
      $sql_m = "select user_name,mobile,zhanghao from lkt_user where store_id = '$store_id' ";
      $res_m = $db->select($sql_m);
      if($res_m){
        
        foreach($res_m as $k => $v){
          $all_zhanghao = $v->zhanghao;
          $all_mobile = $v->mobile;
          if($user_zhanghao == $mobile){
              if($mobile == $all_mobile || $mobile == $all_zhanghao){
                $r = array('code'=>0,'msg'=>'手机号已被注册！');
                echo json_encode($r);
                exit;
              }
          }else{
            if($mobile == $all_mobile || $mobile == $all_zhanghao){
                $r = array('code'=>0,'msg'=>'手机号已被注册！');
                echo json_encode($r);
                exit;
            }
          }
        }
      }
      //事务开启
      $db->begin();
      $code = true;
      if($grade == 0){//普通会员
        $sql = "insert into lkt_user (headimgurl,user_name,grade,grade_end,zhanghao,mobile,mima,source,store_id) values ('$wx_headimgurl','$wx_name','$grade',NULL,'$zhanghao','$mobile','$mima','$source','$store_id')";
      }else{
        $sql = "insert into lkt_user (headimgurl,user_name,grade,grade_end,zhanghao,mobile,mima,source,store_id) values ('$wx_headimgurl','$wx_name','$grade','$grade_end','$zhanghao','$mobile','$mima','$source','$store_id')";
      }
      $res = $db->insert($sql);
   
      if($res < 0){
        $log -> customerLog(__LINE__.':插入用户记录失败，sql为：'.$sql."\r\n");
        $code = false;
        echo json_encode(array('code'=>0,'msg'=>'添加失败'));
        exit;
      }

      $sql0 = "select * from lkt_config where store_id = '$store_id'";
      $r0 = $db->select($sql0);
      if($r0){
        $user_id1 = $r0[0]->user_id; //默认用户名ID前缀
      }else{
        $code = false;
        $log -> customerLog(__LINE__.'没有配置后台用户的系统设置'."\r\n");
        echo json_encode(array('code'=>0,'msg'=>'添加失败，请先配置好系统设置'));
        exit;
      }

      //更新user_id
      $sql = "select max(id) as userid from lkt_user where 1=1";
      $r = $db->select($sql);
      $rr = $r[0]->userid;
      $user_id = $user_id1.($rr+1);//新注册的用户user_id 

      $sql_0 = "select id from  lkt_user where store_id = '$store_id' and mobile = '$mobile'";
      $res_0 = $db->select($sql_0); 
      $new_id = $res_0[0]->id;//要修改的用户id

      $sql_1 = "update lkt_user set user_id = '$user_id' where id = '$new_id' and store_id = '$store_id'";
      $res_1 = $db->update($sql_1);
      if($res_1 < 0){
        $log -> customerLog(__LINE__.':更新用户user_id失败，sql为：'.$sql_1."\r\n");
        $code = false;
        echo json_encode(array('code'=>0,'msg'=>'添加用户失败'));
        exit;
      }

      $event = '会员' . $user_id . '注册成功';
      // 在操作列表里添加一条会员登录信息
      $sql = "insert into lkt_record (store_id,user_id,event,type) values ('$store_id','$user_id','$event',0)";
      $r01 = $db->insert($sql);
      if($r01 < 0){
        $log -> customerLog(__LINE__.':添加会员登录消息失败，sql为：'.$sql."\r\n");
        $code = false;
      }

      if($code){
        $db->commit();
        echo json_encode(array('code'=>1,'msg'=>'添加会员成功'));
        exit;
      }else{
        $db->rollback();
        echo json_encode(array('code'=>0,'msg'=>'添加失败'));
        exit;
      }

  		
  		return;
	}
	public function getRequestMethods(){
		return Request :: POST;
	}
}