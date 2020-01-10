<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
class IndexAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $admin_type1 = $this->getContext()->getStorage()->read('admin_type1');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $button[0] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=userlist&action=Recharge');
        $button[1] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=userlist&action=View');
        $button[2] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=userlist&action=Del');
        $button[3] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=userlist&action=Grade');
        $button[4] = $db->Jurisdiction($store_id,$admin_name,$admin_type1,'index.php?module=userlist&action=Config');

        $user_id = addslashes(trim($request->getParameter('user_id'))); // user_id
        $user_name = addslashes(trim($request->getParameter('user_name'))); // 用户名
        $grade = addslashes(trim($request->getParameter('grade')));//会员等级
        $source = addslashes(trim($request->getParameter('source'))); // 来源
        $is_out = addslashes(trim($request->getParameter('is_out')));//是否过期
        $tel = addslashes(trim($request->getParameter('tel'))); // 联系电话

        //判读用户权限
        if($admin_type1 != 2 && $admin_type1 != 3) { // 不是商城管理员 并且 不是店主
            $sql0 = "select * from lkt_admin where store_id = '$store_id' and type = 1";
        }else{
            $sql0 = "select * from lkt_admin where name ='$admin_name' and store_id = '$store_id'";
        }
        $r0 = $db->select($sql0);
        $mch_id = $r0[0]->shop_id;
        $role = $r0[0]->role; // 角色
        $sql1 = "select b.id,b.type,b.url from lkt_role_menu as a left join lkt_core_menu as b on a.menu_id = b.id where a.role_id = '$role' and b.recycle = 0 ";
        $r1 = $db->select($sql1);
        $role_list1 = array();
        if($r1){
            foreach ($r1 as $k1 => $v1){
                if($v1->type != '0') {
                    $role_list1[] = Tools::header_data_dictionary($db, '导航栏', $v1->type);
                    // $role_list1[] = (array)$v1;
                }
                
            }
        }

        $role_list1 = array_unique($role_list1); // 一维数组去重
        if(in_array('APP',$role_list1)){
            $is_app = 1;
        }else{
            $is_app = 0;
        }
        
        


        // 导出
        $pageto = $request -> getParameter('pageto');
        // 每页显示多少条数据
        $pagesize = $request -> getParameter('pagesize');
        $pagesize = $pagesize ? $pagesize:'10';
        // 页码
        $page = $request -> getParameter('page');
        if($page){
            $page = $page;
            $start = ($page-1)*10;
        }else{
            $page = 1;
            $start = 0;
        }
       
		$condition = " a.store_id = '$store_id' ";
        if($user_id != ''){
            $condition .= " and a.user_id like '%$user_id%' ";
        }
		if($user_name != ''){
            $user_name = htmlspecialchars($user_name);
			$condition .= " and user_name like '%$user_name%' ";
		}
        if($grade !== ''){
            $condition .= "and grade = $grade ";
        }
		if($is_out !== ''){
            $condition .= "and is_out = $is_out ";
        }
		if($tel != ''){
			$condition .= " and mobile like '%{$tel}%' ";
		}
		if($source != 0){
            $condition .= " and source = '$source' ";
        }
		


        $sql = "select * from lkt_user as a where  " . $condition;
        $r_pager = $db->select($sql);
        

		$total = count($r_pager);
        $pager = new ShowPager($total, $pagesize, $page);
       
		if($pageto == 'whole'){//全部
            $db->admin_record($store_id,$admin_name,' 导出用户列表全部数据 ',4);
            $sql = "select a.id,a.user_id,headimgurl,user_name,grade,is_out,grade_end,money,score,Register_data,mobile,zhanghao,share_num,source,b.level from lkt_user as a left join lkt_user_distribution as b on a.user_id = b.user_id and a.store_id = b.store_id where 1 = 1 order by Register_data desc";

        }else if($pageto == 'This_page'){//当前页
            $db->admin_record($store_id,$admin_name,' 导出用户列表第'.$page.'页'.$pagesize.'条数据 ',4);
            $sql = "select a.id,a.user_id,headimgurl,user_name,grade,is_out,grade_end,money,score,Register_data,mobile,zhanghao,share_num,source,b.level  from lkt_user as a left join lkt_user_distribution as b on a.user_id = b.user_id  and a.store_id = b.store_id where " . $condition . "order by Register_data desc limit $start,$pagesize";
        }else if($pageto == 'inquiry'){
            $db->admin_record($store_id,$admin_name,'导出用户列表全部查询数据',4);
            $sql = "select a.id,a.user_id,headimgurl,user_name,grade,is_out,grade_end,money,score,Register_data,mobile,zhanghao,share_num,source,b.level from lkt_user as a left join lkt_user_distribution as b on a.user_id = b.user_id and a.store_id = b.store_id where ".$condition." order by Register_data desc ";

        }else{//
            $sql = "select a.id,a.user_id,headimgurl,user_name,grade,is_out,grade_end,money,score,Register_data,mobile,zhanghao,share_num,source,b.level from lkt_user as a left join lkt_user_distribution as b on a.user_id = b.user_id and a.store_id = b.store_id where " . $condition . "order by Register_data desc limit $start,$pagesize";
        }
      
        $r = $db -> select($sql);
    
		//查询订单数以及会员等级
		foreach ($r as $key => $value) {
	        $sql = "select SUM(z_price) as z_price from lkt_order where store_id = '$store_id' and user_id='$value->user_id' and status > 0 and status not in (4,7,11) and pay_time != ''";
	        $r1 = $db->select($sql);
          
	        if($r1[0]->z_price){
	        	$r[$key]->z_price = $r1[0]->z_price;
	        }else{
	        	$r[$key]->z_price = 0;
	        }
	        $sql = "select id from lkt_order where store_id = '$store_id' and user_id='$value->user_id' and status > 0 and status not in (4,7,11) and pay_time != ''";
           
	        $r[$key]->z_num = $db->selectrow($sql);

            $sql_0 = "select name from lkt_user_grade where store_id = '$store_id' and id = '$value->grade'";
            $res_0 = $db->select($sql_0);
            if($res_0){
                $r[$key]->grade = $res_0[0]->name;
            }else{
                $r[$key]->grade = '普通会员';
            }
		}
        $url = "index.php?module=userlist&action=Index&user_id=".urlencode($user_id)."&user_name=".urlencode($user_name)."&tel=".urlencode($tel)."&source=".urlencode($source)."&grade=".urlencode($grade)."&is_out=".urlencode($is_out);
        $pages_show = $pager->multipage($url,$total,$page,$pagesize,$start,$para = '');

       
        //会员等级下拉框
        $sql_3 = "select id,name from lkt_user_grade where store_id = '$store_id'";
        $res_3 = $db->select($sql_3);
        if($grade === '0'){
            $grade_str = '<option value = "0" selected>普通会员</option>';
        }else{
            $grade_str = '<option value = "0">普通会员</option>';
        }
        if($res_3){
            foreach ($res_3 as $k => $v) {
                if($v->id == $grade){
                    $grade_str .= '<option selected value = "'.$v->id.'" >'.$v->name.'</option>';
                }else{
                    $grade_str .= '<option value = "'.$v->id.'" >'.$v->name.'</option>';
                }
               
            }
        }
        //充值时长
        $sql = "select method  from lkt_user_rule where store_id = '$store_id'";
        $res = $db->select($sql);
        $method_str = '';
        if($res){
            $method = explode(',',$res[0]->method);
            foreach($method as $k => $v){
              if($v == 1){
                $method_str .= '<option value="'.$v.'">包月</option>';
              }else if($v == 2){
                $method_str .= '<option value="'.$v.'">包季</option>';
              }else if($v == 3){
                $method_str .= '<option value="'.$v.'">包年</option>';
              }

            }
        }
       
        $request ->setAttribute('pageto', $pageto);
        $request->setAttribute("user_name",$user_name);
		$request->setAttribute("user_id",$user_id);
        $request->setAttribute("tel",$tel);
        $request->setAttribute("is_out",$is_out);
        $request->setAttribute("source",$source);//来源下拉框
        $request->setAttribute("grade",$grade_str);//会员等级下拉框
        $request->setAttribute("method_str",$method_str);//充值时长下拉框
        $request->setAttribute("list",$r);
        $request->setAttribute("is_app",$is_app);
        $request ->setAttribute('pages_show', $pages_show);
        $request -> setAttribute('pagesize', $pagesize);
        $request -> setAttribute('button', $button);

        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = $request->getParameter('m');
        $this->$m();//执行m方法
        return;
    }

    public function getGrade(){
        
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $user_id = addslashes(trim($request->getParameter('user_id')));//用户id

        $sql0 = "select grade from lkt_user where store_id = $store_id and user_id = '$user_id'";
        $res0 = $db->select($sql0);
        if(!$res0){
            echo json_encode(array('code'=>109,'msg'=>'参数错误'));
            exit;
        }
        $grade = $res0[0]->grade;
         //会员等级下拉框
        $sql_3 = "select id,name from lkt_user_grade where store_id = '$store_id'";
        $res_3 = $db->select($sql_3);
        if($grade === '0'){
            $grade_str = '<option value = "0" selected>普通会员</option>';
        }else{
            $grade_str = '<option value = "0">普通会员</option>';
        }
        if($res_3){
            foreach ($res_3 as $k => $v) {
                if($v->id == $grade){
                    $grade_str .= '<option selected value = "'.$v->id.'" >'.$v->name.'</option>';
                }else{
                    $grade_str .= '<option value = "'.$v->id.'" >'.$v->name.'</option>';
                }
               
            }
        }
        //充值时长
        $sql = "select method  from lkt_user_rule where store_id = '$store_id'";
        $res = $db->select($sql);
        $method_str = '';
        if($res){
            $method = explode(',',$res[0]->method);
            foreach($method as $k => $v){
              if($v == 1){
                $method_str .= '<option value="'.$v.'">包月</option>';
              }else if($v == 2){
                $method_str .= '<option value="'.$v.'">包季</option>';
              }else if($v == 3){
                $method_str .= '<option value="'.$v.'">包年</option>';
              }

            }
        }
        echo json_encode(array('code'=>200,'grade'=>$grade,'grade_str'=>$grade_str,'time_str'=>$method_str));
        exit;


    }

    public function modifyGrade(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');
        $user_id = addslashes(trim($request->getParameter('user_id')));//用户id
        $grade = addslashes(trim($request->getParameter('grade')));//要改成的用户级别
        $method = addslashes(trim($request->getParameter('method')));//充值时长
        $now = date("Y-m-d H:i:s");
        //用户原来级别 
        $sql = "select grade, from lkt_user where store_id = '$store_id' and user_id = $user_id";
        $res = $db->select($sql);
        if($res){
            $grade_ago = $res[0]->grade;
        }
        //根据选择充值时长，继续到期时间
        if($method == 1){//包月
            $grade_end = date("Y-m-d H:i:s",strtotime("+1 months"));
        }else if($method == 2){//包季
            $grade_end = date("Y-m-d H:i:s",strtotime("+3 months"));
        }else if($method == 3){//包年
            $grade_end = date("Y-m-d H:i:s",strtotime("+1 years"));
        }
        //根据选择的会员级别修改
        if($grade !== 0){
            $sql_0 = "update lkt_user set grade = $grade , grade_add = '$now' , grade_end = '$grade_end' ,is_out = 0 where store_id = $store_id and user_id = '$user_id'";
        }else{
            $sql_0 = "update lkt_user set grade = $grade , grade_end = NULL , grade_add = NULL , is_out = 0 where store_id = $store_id and user_id = '$user_id'";
        }
        $res_0 = $db->update($sql_0);
        if($res_0 > 0){//成功
            echo json_encode(array('code'=>200,'msg'=>'修改成功'));
            exit;
        }else{//失败
            echo json_encode(array('code'=>109,'msg'=>'修改失败'));
            exit;
        }

    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>