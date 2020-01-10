<?php

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class ModifyAction extends Action{
		public function getDefaultView(){
			

			$db = DBAction::getInstance();
	        $request = $this->getContext()->getRequest();
	        $store_id = $this->getContext()->getStorage()->read('store_id');

	        $id = $request->getParameter("id"); //值为传递过来的user_id
	        $sql = "select * from lkt_user where store_id = '$store_id' and user_id = '$id'";
	        $r = $db->select($sql);
	        if(!$r){
		        $sql = "select * from lkt_user where store_id = '$store_id' and id = '$id'";
		        $r = $db->select($sql);
	        }
	        //获取用户密码的明文
	        $mima  = $r[0]->mima;
	        if($mima){
	        	 $mima = $db->unlock_url($mima);
	            $r[0]->mima_1 = $mima;
	        }
	       

	        //该用户有效订单数
	        $sql_1 = "select id from lkt_order where store_id = '$store_id' and user_id='$id' and status > 0 and status not in (4,7,11) and pay_time != ''";
	        $res_1 = $db->selectrow($sql_1);
	        $r[0]->z_num = $res_1;

	        //该用户交易金额
	        $sql_2 = "select SUM(z_price) as z_price from lkt_order where store_id = '$store_id' and user_id='$id' and status > 0 and status not in (4,7,11) and pay_time != ''";

	        $res_2 = $db->select($sql_2);

	        if(empty($res_2[0]->z_price)){
	        	
	        		$r[0]->z_price = 0;
	        	
	        }else{
	        	
	        	$r[0]->z_price = $res_2[0]->z_price;
	        }
	        //会员等级
	        $grade = $r[0]->grade;
	        $sql_3 = "select id,name,rate from lkt_user_grade where store_id = '$store_id'";
	        $res_3 = $db->select($sql_3);

	        if($grade == 0){
				$r[0]->grade1 = '<option value = "0" selected = "selected">普通会员</option>';
				
 			}else{
				$r[0]->grade1 = '<option value = "0">普通会员</option>';
				
 			}
 			if($res_3){
 				foreach ($res_3 as $k => $v) {
 					if($grade == $v->id){
 						$r[0]->grade1 .= '<option value = "'.$v->id.'" selected = "selected">'.$v->name.'</option>';
 					}else{
 						$r[0]->grade1 .= '<option value = "'.$v->id.'" >'.$v->name.'</option>';
 					}
 				}

 			}
 			//会员折扣
 			$sql_4 = "select name,rate from lkt_user_grade where store_id = '$store_id' and id = '$grade'";
 			$res_4 = $db->select($sql_4);
 			if($res_4){
 				$r[0]->rate = $res_4[0]->rate;
 			}else{
 				$r[0]->rate = '暂无折扣';
 			}

 			$end = $r[0]->grade_end;
          
	        $request->setAttribute('user', $r);
	        $request->setAttribute('end', $end);

	        return View :: INPUT;
		}

		public function execute(){
			$db=DBAction::getInstance();
			$request=$this->getContext()->getRequest();
			 $admin_id = $this->getContext()->getStorage()->read('admin_id');
			 $store_id=$this->getContext()->getStorage()->read('store_id');
			//1.接受用户传来的修改数据
			$id=$request->getParameter("id");

			$user_name=$request->getParameter("user_name");
			$mobile=$request->getParameter("mobile");
			// $is_lock = $request->getParameter('is_lock');//是否冻结
			$mima = addslashes($request->getParameter("mima"));//登录密码
			$password = addslashes($request->getParameter('password'));//支付密码
			$grade = addslashes($request->getParameter('grade'));//会员等级
			$money = addslashes($request->getParameter('money'));//余额
			$score = addslashes($request->getParameter('score'));//积分
			$birthday = addslashes($request->getParameter('birthday'));//会员生日日期
			$log = new LaiKeLogUtils('common/userlist.log');
			$now = date("Y-m-d H:i:s");//单前时间
			//根据会员等级获取到期时间
			if($grade === '0'){
				$grade_end = 'NULL';
			}else{
				$grade_end = addslashes($request->getParameter('grade_end'));//到期时间
			}
			$sql="select source,zhanghao,password,mobile from lkt_user where id = '$id'";
			$r=$db->select($sql);
			$user_zhanghao = $r[0]->zhanghao;//用户账号
			$user_mobile = $r[0]->mobile;//用户手机号
			$password_db = $r[0]->password;//数据库中的密码

            if($password != ''){
                if($password != $password_db){
                    if(strlen($password) != 6){
                        $r = array('status'=>'支付密码请设置6位数！');
                        echo json_encode($r);
                        exit;
                    }else{
                        $password = md5($password);
                    }
                }
            }

			if(empty($user_name)){
				$user_name = '来客电商粉丝';
			}


			//手机号唯一判定
			$sql_m = "select user_name,mobile,zhanghao from lkt_user where store_id = '$store_id' and id != '$id'";
			$res_m = $db->select($sql_m);
			if($res_m){
				
				foreach($res_m as $k => $v){
					$all_zhanghao = $v->zhanghao;
					$all_mobile = $v->mobile;
                    if($user_zhanghao == $mobile){
                    		if($mobile == $all_mobile || $mobile == $all_zhanghao){
								$r = array('status'=>'手机号已被注册！');
								echo json_encode($r);
								exit;
                    	    }
					}else{
						if($mobile == $all_mobile || $mobile == $all_zhanghao){
								$r = array('status'=>'手机号已被注册！');
								echo json_encode($r);
								exit;
                    	}
					}
				}
			}
			if(strlen($mima) < 6){
                $r = array('status'=>'密码低于6位数！');
                echo json_encode($r);
                exit;
            }
            $mima = $db->lock_url($mima);

            if($user_zhanghao != $user_mobile){
				//2.根据数据对数据库操作
				if(!$birthday){
					$sql="update lkt_user set mima = '$mima',user_name = '$user_name',mobile = '$mobile',password = '$password',grade = '$grade',grade_end = '$grade_end',grade_add = '$now',money = $money,score = $score,birthday = NULL where id='$id' and store_id='{$store_id}'";
				}else{
					$sql="update lkt_user set mima = '$mima',user_name = '$user_name',mobile = '$mobile',password = '$password',grade = '$grade',grade_end = '$grade_end',grade_add = '$now',money = $money,score = $score,birthday = '$birthday' where id='$id' and store_id='{$store_id}'";
				}
				$res=$db->update($sql);
			}else{
				if(!$birthday){
					$sql = "update lkt_user set mima = '$mima',user_name = '$user_name',mobile = '$mobile',zhanghao = '$mobile',password = '$password',grade = '$grade',grade_end = '$grade_end',grade_add = '$now',money = $money,score = $score,birthday = NULL where id='$id' and store_id='{$store_id}'";
				}else{
					$sql = "update lkt_user set mima = '$mima',user_name = '$user_name',mobile = '$mobile',zhanghao = '$mobile',password = '$password',grade = '$grade',grade_end = '$grade_end',grade_add = '$now',money = $money,score = $score,birthday = '$birthday' where id='$id' and store_id='{$store_id}'";
				}
				$res = $db->update($sql);
			}	
			
			//3.根据操作结果，提示修改成功或失败
			
			if($res < 0){
				$log -> customerLog(__LINE__.':更新用户信息失败，sql为：'.$sql."\r\n");
				$r=array('status'=>'修改用户失败！');
				echo json_encode($r);exit;
			}else{
				
			    $db->admin_record($store_id,$admin_id,'修改用户'.$id.'成功',2);
				$r=array('status'=>'修改用户成功！','suc'=>1);

				echo json_encode(array('status'=>'修改用户成功！','suc'=>1));exit;

			}
			return ;

		}
		public function getRequestMethods(){

			return Request :: POST;
		}

} 