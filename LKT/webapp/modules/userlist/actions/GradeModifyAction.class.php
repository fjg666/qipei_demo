<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class GradeModifyAction extends Action
{
	public function getDefaultView(){
		$db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $id = addslashes(trim($request->getParameter('id')));//主键id
        $sql = "select * from lkt_user_grade where store_id = '$store_id' and id = '$id'";
        $res = $db->select($sql);

        if($res){
        	$name = $res[0]->name;
          $imgurl = $res[0]->imgurl ? ServerPath::getimgpath($res[0]->imgurl,$store_id) : '';
          $imgurl_my = $res[0]->imgurl_my ? ServerPath::getimgpath($res[0]->imgurl_my,$store_id) : '';
          $imgurl_s = $res[0]->imgurl_s ? ServerPath::getimgpath($res[0]->imgurl_s,$store_id) : '';
        	$rate = $res[0]->rate;
        	$money = $res[0]->money;
          $money_j = $res[0]->money_j;
          $money_n = $res[0]->money_n;
          $remark = $res[0]->remark;
        	$id = $res[0]->id;
          $pro_id = $res[0]->pro_id;
          $font_color = $res[0]->font_color;
          $date_color = $res[0]->date_color;
          if($pro_id){
            //查询产品名称
            $sql1 = "select product_title from lkt_product_list where store_id = $store_id and id = '$pro_id'";
            $res1 = $db->select($sql1);
            if($res1){
              $pro_name = $res1[0]->product_title;
            }else{
              $pro_name = '';
            }
          }else{
            $pro_id = '';
            $pro_name = '';
          }
        }
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

        $request -> setAttribute('name', $name);
        $request -> setAttribute('imgurl', $imgurl);
        $request -> setAttribute('imgurl_my', $imgurl_my);
        $request -> setAttribute('imgurl_s', $imgurl_s);
        $request -> setAttribute('rate', $rate);
        $request -> setAttribute('money', $money);
        $request -> setAttribute('money_j', $money_j);
        $request -> setAttribute('money_n', $money_n);
        $request -> setAttribute('remark', $remark);
        $request -> setAttribute('id',$id);
        $request -> setAttribute('upgrade',$upgrade);
        $request -> setAttribute('method',$method);
        $request -> setAttribute('pro_id',$pro_id);
        $request -> setAttribute('pro_name',$pro_name);
        $request -> setAttribute('font_color',$font_color);
        $request -> setAttribute('date_color',$date_color);
        $request -> setAttribute('is_product',$is_product);
        
        return View :: INPUT;
	}
	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$store_id = $this->getContext()->getStorage()->read('store_id');
		$name = addslashes(trim($request->getParameter('name')));
    $imgurl = addslashes(trim($request->getParameter('imgurl')));//充值背景图
    $imgurl_my = addslashes(trim($request->getParameter('imgurl_my')));//会员(充值)背景图
    $imgurl_s = addslashes(trim($request->getParameter('imgurl_s')));//小图标
		$rate = addslashes(trim($request->getParameter('rate')));
		$money = addslashes(trim($request->getParameter('money')));
    $money_j = addslashes(trim($request->getParameter('money_j')));
    $money_n = addslashes(trim($request->getParameter('money_n')));
    $remark = addslashes(trim($request->getParameter('remark')));
		$id = addslashes(trim($request->getParameter('id')));
    $pro_id = addslashes(trim($request->getParameter('pro_id')));//产品id
    $font_color = addslashes(trim($request->getParameter('font_color')));//会员字体颜色
    $date_color = addslashes(trim($request->getParameter('date_color')));//产品id
    $log = new LaiKeLogUtils('common/userlist.log');
    // 名称唯一性判断
    $sql = "select id from lkt_user_grade where store_id = '$store_id' and name = '$name' and id != $id";
    $res = $db->select($sql);
    if($res){
      echo json_encode(array('code'=>0,'msg'=>'名称重复'));
      exit;
    }
    //查询会员规则
    $sql1 = "select method from lkt_user_rule where store_id = $store_id";
    $res1 = $db->select($sql1);
    $method = $res1[0]->method ? explode(',',$res1[0]->method) : array();
    //会员等级金额合理性
    //比上一级便宜
    $sql_0 = "select money,money_j,money_n from lkt_user_grade where store_id = $store_id and id != $id and rate < '$rate' order by rate desc limit 1";
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
    $sql_1 = "select money,money_j,money_n from lkt_user_grade where store_id = $store_id and id != $id  and rate > '$rate' order by rate asc limit 1";
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
   	
   	$sql = "update lkt_user_grade set name = '$name',imgurl_my = '$imgurl_my', imgurl = '$imgurl',imgurl_s = '$imgurl_s',rate = '$rate',money = '$money',money_j = '$money_j',money_n = '$money_n',remark = '$remark',pro_id = '$pro_id',font_color = '$font_color',date_color = '$date_color' where store_id = '$store_id' and id = '$id'";
   	$res = $db->update($sql);
   	if($res >= 0){
   		echo json_encode(array('code'=>1,'msg'=>'编辑成功'));
   		exit;
   	}else{
      $log -> customerLog(__LINE__.':更新会员等级失败，sql为：'.$sql."\r\n");
   		echo json_encode(array('code'=>0,'msg'=>'编辑失败'));
   		exit;
   	}
		return;
	}
	public function getRequestMethods(){
		return Request :: POST;
	}
}