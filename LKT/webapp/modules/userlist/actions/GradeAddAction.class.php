<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class GradeAddAction extends Action
{
	public function getDefaultView(){
		$db = DBAction::getInstance();
    $request = $this->getContext()->getRequest();
    $store_id = $this->getContext()->getStorage()->read('store_id');

    //查询会员配置中的基本信息
    $sql = "select upgrade,method,is_product from lkt_user_rule where store_id = $store_id";
    $res = $db->select($sql);
    if($res){
      $upgrade = explode(',',$res[0]->upgrade);
      $method = explode(',',$res[0]->method);
      $is_product = $res[0]->is_product;
    }else{
      $upgrade = array();
      $method = array();
      $is_product = 0;
    }

    $request -> setAttribute('upgrade', $upgrade);
    $request -> setAttribute('method', $method);
    $request -> setAttribute('is_product', $is_product);
    
    return View :: INPUT;
	}
	public function execute(){
  		$db = DBAction::getInstance();
  		$request = $this->getContext()->getRequest();
  		$store_id = $this->getContext()->getStorage()->read('store_id');
  		$name = addslashes(trim($request->getParameter('name')));//名称
  		$rate = addslashes(trim($request->getParameter('rate')));//折率
      $imgurl_my = addslashes(trim($request->getParameter('imgurl_my')));//我的背景图
      $imgurl = addslashes(trim($request->getParameter('imgurl')));//会员(充值)背景图
      $imgurl_s = addslashes(trim($request->getParameter('imgurl_s')));//小图标
      // $level = addslashes(trim($request->getParameter('level')));//级别标识
      $money = addslashes(trim($request->getParameter('money')));//包月
      $money_j = addslashes(trim($request->getParameter('money_j')));//包季
  		$money_n = addslashes(trim($request->getParameter('money_n')));//包年
      $remark = addslashes(trim($request->getParameter('remark')));//备注
      $pro_id = addslashes(trim($request->getParameter('pro_id')));//产品id
      $font_color = addslashes(trim($request->getParameter('font_color')));//会员字体颜色
      $date_color = addslashes(trim($request->getParameter('date_color')));//日期字体颜色
      $log = new LaiKeLogUtils('common/userlist.log');
  		//判断是否设置的等级规则
  		$sql = "select id from lkt_user_rule where store_id = '$store_id'";
  		$res = $db->select($sql);
  		if(!$res){
  			echo json_encode(array('code'=>0,'msg'=>'请先设置会员等级规则'));
  			exit;
  		}
      //查询会员规则
      $sql1 = "select method from lkt_user_rule where store_id = $store_id";
      $res1 = $db->select($sql1);
      $method = $res1[0]->method ? explode(',',$res1[0]->method) : array();
      //名称唯一性判断
      $sql = "select id from lkt_user_grade where store_id = '$store_id' and name = '$name'";
      $res = $db->select($sql);
      if($res){
        echo json_encode(array('code'=>0,'msg'=>'名称重复'));
        exit;
      }
      //会员等级金额合理性
      //比上一级便宜
      $sql_0 = "select money,money_j,money_n from lkt_user_grade where store_id = $store_id and rate < '$rate' order by rate desc limit 1";
      $res_0 = $db->select($sql_0);
      if($res_0){
        $money_h  = $res_0[0]->money;
        $money_j_h = $res_0[0]->money_j;
        $money_n_h = $res_0[0]->money_n;

        if(bccomp($money,$money_h,2) >= 0 && in_array(1,$method)){
          echo json_encode(array('code'=>0,'msg'=>'包月金额应比上一级等级小'));
          exit;
        }else if(bccomp($money_j,$money_j_h,2) >= 0 && in_array(2,$method)){
          echo json_encode(array('code'=>0,'msg'=>'包季金额应比上一级等级小'));
          exit;
        }else if(bccomp($money_n,$money_n_h,2) >= 0 && in_array(3,$method)){
          echo json_encode(array('code'=>0,'msg'=>'包年金额应比上一级等级小'));
          exit;
        }

      }
      //比下一级贵
      $sql_1 = "select money,money_j,money_n from lkt_user_grade where store_id = $store_id and rate > '$rate' order by rate asc limit 1";
      $res_1 = $db->select($sql_1);
      if($res_1){
        $money_l = $res_1[0]->money;
        $money_j_l = $res_1[0]->money_j;
        $money_n_l = $res_1[0]->money_n;

        if(bccomp($money_l,$money,2) >= 0 && in_array(1,$method)){
          echo json_encode(array('code'=>0,'msg'=>'包月金额应比下一级等级大'));
          exit;
        }else if(bccomp($money_j_l,$money_j,2) >= 0 && in_array(2,$method)){
          echo json_encode(array('code'=>0,'msg'=>'包季金额应比下一级等级大'));
          exit;
        }else if(bccomp($money_n_l,$money_n,2) >= 0 && in_array(3,$method)){
          echo json_encode(array('code'=>0,'msg'=>'包年金额应比下一级等级大'));
          exit;
        }
      }
      

      //截取图片名称
      if($imgurl){
        $imgurl = preg_replace('/.*\//','',$imgurl);
      }
      if($imgurl_my){
        $imgurl_my = preg_replace('/.*\//','',$imgurl_my);
      }
      if($imgurl_s){
        $imgurl_s = preg_replace('/.*\//','',$imgurl_s);
      }
     	$sql = "insert into lkt_user_grade (name,imgurl_my,imgurl,imgurl_s,rate,money,money_j,money_n,remark,pro_id,font_color,date_color,store_id) values ('$name','$imgurl_my','$imgurl','$imgurl_s','$rate','$money','$money_j','$money_n','$remark','$pro_id','$font_color','$date_color','$store_id')";
     	$res = $db->insert($sql);
     	if($res > 0){
     		echo json_encode(array('code'=>1,'msg'=>'添加成功'));
     		exit;
     	}else{
        $log -> customerLog(__LINE__.':添加会员等级失败，sql为：'.$sql."\r\n");
     		echo json_encode(array('code'=>0,'msg'=>'添加失败'));
     		exit;
     	}
  		return;
	}
	public function getRequestMethods(){
		return Request :: POST;
	}
}