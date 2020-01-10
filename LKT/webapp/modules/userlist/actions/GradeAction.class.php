<?php
/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class GradeAction extends Action{
	public function getDefaultView(){
		$db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //接受分页参数
        $pagesize = addslashes(trim($request->getParameter('pagesize')));
		$page = addslashes(trim($request->getParameter('page')));
		$pagesize = $pagesize ? $pagesize : 10;
		if($page){
			$start = ($page-1)*$pagesize;
		}else{
			$page = 1;
			$start = 0;
		}

		//记录总条数
		$sql = "select id from lkt_user_grade where store_id = '$store_id'";
		$total = $db->selectrow($sql);
		
		//初始化分页类
        $showpager=new ShowPager($total,$pagesize,$page);
		$offset=$showpager -> offset;//设置开始查询位置

		//查询
		$sql = "select * from lkt_user_grade where store_id = '$store_id' order by rate desc limit $offset,$pagesize";
		$res = $db->select($sql);
		
		$url = 'index.php?module=userlist&action=Grade';
		$pages_show = $showpager->multipage($url,$total,$page,$pagesize,$start,$para='');

		//查询会员配置中的基本信息
	    $sql1 = "select upgrade,method from lkt_user_rule where store_id = $store_id";
	    $res1 = $db->select($sql1);
	    if($res1){
	      $upgrade = explode(',',$res1[0]->upgrade);
	      $method = explode(',',$res1[0]->method);
	    }else{
	    	$upgrade = array();
	    }

		$request->setAttribute('list',$res);
		$request->setAttribute('pages_show',$pages_show);
		$request->setAttribute('upgrade',$upgrade);
        return View :: INPUT;
	}
	public function execute(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
        $m = $request->getParameter('m');
        $this->$m();//执行m方法
		return;
	}
	//删除会员等级
	public function del(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$id = addslashes(trim($request->getParameter('id')));
		$store_id = $this->getContext()->getStorage()->read('store_id');
		$log = new LaiKeLogUtils('common/userlist.log');
		//判断该等级下是否有会员
		$sql_0 = "select user_id from lkt_user where store_id = $store_id and grade = $id";
		$res_0 = $db->select($sql_0);
		if($res_0){
			echo json_encode(array('status'=>2,'info'=>'已有用户为该等级会员，不可删除'));
			exit;
		}

		$sql = "delete from lkt_user_grade where store_id = '$store_id' and id = '$id'";
		$res = $db->delete($sql);
		if($res > 0 ){
			echo json_encode(array('status'=>1,'info'=>'操作成功'));
			exit;
		}else{
			$log -> customerLog(__LINE__.':删除会员等级失败，sql为：'.$sql."\r\n");
			echo json_encode(array('status'=>2,'info'=>'操作失败'));
		}
	}
	//选择商品
	public function getPro(){
		$db = DBAction::getInstance();
		$request = $this->getContext()->getRequest();
		$id = addslashes(trim($request->getParameter('id')));
		$store_id = $this->getContext()->getStorage()->read('store_id');

		//查询商品
		$sql = "select b.id,b.product_title from lkt_configure as a left join lkt_product_list as b on a.pid = b.id left join lkt_mch as c on b.mch_id = c.id  where b.store_id = '$store_id' and c.store_id = '$store_id' and b.active = 1 and b.status = 2  and a.num > 0  group by b.id ";
		$res = $db->select($sql);

		if($res){
			echo json_encode(array('code'=>200,'data'=>$res));
			exit;
		}else{
			echo json_encode(array('code'=>109,'data'=>[]));
			exit;
		}


	}
	public function getRequestMethods(){
		return Request :: POST;
	}
}