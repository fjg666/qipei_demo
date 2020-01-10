<?php
require_once(MO_LIB_DIR.'DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/Apimiddle.class.php');

/**
 * [Laike System] Copyright (c) 2019 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */


 class auctionAction extends Apimiddle{

 	/**
     * <p>Copyright (c) 2019-2020</p>
     * <p>Company: www.laiketui.com</p>
     * @author 凌烨棣
     * @content 小程序的竞拍接口
     * @date 2019年1月7日
     * @version 1.0
     */

 	public function getDefaultView(){

 		echo json_encode('code'=>200,'msg'=>404);

 	}

 	public function execute(){

 		//初始化
 		$db = DBAction::getInstance();
 		$request = $this->getContext()->getRequest();


 		//接受参数
 		$store_id = addslashes(trim($request->getParameter('store_id')));
 		$openid = addslashes(trim($request->getParmaeter('openid')));
 		$m = addslashes(trim($request->getParameter('m')));
 		$m = $m ? $m : 'getDefaultView';


 		//查用户基本信息
 		$sql = "select user_id,money from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
 		$res = $db->select($sql);

 		$user_id = $res[0]->user_id;
 		$user_money = $res[0]->user_money;

 		$user_id = $user_id ? $user_id : '';

 		if(empty($openid)||empty($user_id)||empty($store_id)){

 			echo json_encode(array('code'=>200,'msg'=>'参数缺少！','status'=>1));

 		}


 		//增加该类中的公共属性，调用到各方法

 		$this->db = $db;
    $this->request = $request;
 		$this->user_id = $user_id;
 		$this->openid = $openid;
 		$this->user_money = $user_money;


 		//跳转具体的方法
 		$this->$m();

 		return ;


 	}

 }

   //竞拍首页

 public function index(){

       		//获取类属性
      	 	$db = $this->db;
      	 	$store_id = $this->store_id;
      	 	$openid = $this->openid;
      	 	$user_id = $this->user_id;
          $request = $this->request;
          $type = addslashes(trim($request->getParameter('type')));

          //未开始的竞拍
          if($type == 'ready'){

               $sql = "select id,title,imgurl,starttime,price,add_price,pepole,status from lkt_auction_product where store_id = '$store_id'";
               $res = $db->select($sql);

               if($res){

                    echo json_encode(array('code'=>200,'res'=>$res,));
                    exit;
               }else{

                    echo json_encode(array(,'code'=>200,'info'=>'暂无拍品！'));
                    exit;
               }

          }

          //热拍
          if($type == 'running'){

                $now_time = date('Y-m-d h:i:s');

                $sql = "select id,title,starttime,endtime,price,status,invalid_time,pepole,is_buy from lkt_auction_product where store_id = '$store_id' and status != 0 and invalid_time < '$now_time'";
                $res = $db->select($sql);

                if(!$res){

                    echo json_encode('code'=>200,'info'=>'暂无热拍商品');
                    exit;
                }

                //在拍中
                $sql_1 = "select id,title,starttime,endtime,price,status,invalid_time,pepole,is_buy from lkt_auction_product where store_id = '$store_id' and status = 1 and invalid_time < '$now_time' order by id desc";
                $res_1 = $db->select($sql_1);

                if($res_1){

                    foreach($res_1 as $k => $v){

                          $v->mark = 1;//在拍中
                          array_push($list,$v);
                    }
                }

                //已结束，不是得主
                $sql_2 = "select id,title,starttime,endtime,price,status,invalid_time,pepole,is_buy form lkt_auction_product where store_id = '$store_id' and status = 2 and invalid_time < '$now_time' and user_id != '$user_id' order by id desc ";
                $res_2 = $db->select($sql_2);

                if($res_2){

                    foreach($res_2 as $k =>$v){

                        $v->mark = 2; //已结束，不是得主
                        array_push($list, $v);
                    }
                }

                //已结束，是得主未付款
                $sql_3 = "select id,title,starttime,endtime,price,status,invalid_time,pepole,is_buy from lkt_auction_product where store_id = '$store_id' and status = 2 and invalid_time < '$now_time' and user_id = '$user_id' and is_buy = 0 ";
                $res_3 = $db->select($sql_3);

                if($res_3){

                    foreach($res_3 as $k => $v){

                        $v->mark = 3//已结束，是得主未付款
                        array_push($list,$v);
                    }
                }

                //已结束，是得主已付款
                $sql_4 = "select id,title,starttime,endtime,price,status,invalid_time,pepole,is_buy from lkt_auction_product where store_id = '$store_id' and status = 2 and invalid_time < '$now_time' and user_id != '$user_id' and is_buy = 1";
                $res_4 = $db->select($sql_4);

                if($res_4 as $k => $v){

                    $v->mark = 4;//已结束，是得主已付款
                    array_push($list,$v);
                }

                echo json_encode(aray('code'=>200,'res'=>$list));
                exit;
                
          }


          //我的竞拍
          //mark（1-继续竞拍 2-已结束，不是得主  3.已结束，是得主未付款 4.已结束，是得主已付款） 
          if($type == 'my'){
              
              //是否有我的拍品
              $now_time = date('Y-m-d h:i:s');

              $sql = "select id,title from lkt_auction_product as a left join lkt_auction_promise as b on a.id = b.a_id where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status != 0 and a.invalid_time < '$now_time' and b.user_id = '$user_id'";
              $res = $db->select($sql);

              if(!$res){

                  echo json_encode(array('code'=>200,'info'=>'暂无我的拍品！'));
                  exit;
              }

              $list = [];
              //1.继续竞拍 
              $sql_1 = "select  a.id,a.title,a.starttime,a.endtime,a.price,a.status,a.invalid_time,a.pepole,a.is_buy from lkt_auction_product as a left join lkt_auction_promise as b on a.id = b.a_id  where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 1 and a.invalid_time < '$now_time' and b.user_id = '$user_id' order by a.id desc";
              $res_1 = $db->select($sql_1);

              if($res){

                  foreach($res_1 as $k =>$v){
                      $v->mark = 1;
                      array_push($list, $v);
                  }
              }

              //2.已结束，不是得主
              $sql_2 = "select a.id,a.title,a.starttime,a.endtime,a.price,a.status,a.invalid_time,a.pepole,a.is_buy from lkt_auction_product as a left join lkt_auction_promise as b on a.id = b.a_id where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 2 and b.user_id = '$user_id' and a.invalid_time < '$now_time' and a.user_id != '$user_id' order by a.id desc";
              $res_2 = $db->select($sql_2);

              if($res_2){

                  foreach ($res_2 as $k => $v) {
                      $v->mark = 2;
                      array_push($list,$v);
                  }
              }

              //3.已结束，是得主未付款
              $sql_3 = "select a.id,a.title,a.starttime,a.endtime,a.price,a.status,a.invalid_time,a.pepole,a.is_buy from lkt_auction_product as a left join lkt_auction_promise as b on a.id = b.a_id where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 2 and a.invalid_time < '$now_time' and a.user_id = '$user_id' and b.user_id = '$user_id' and a.is_buy = 0 order by a.id desc";
              $res_3 = $db->select($sql_3);

              if($res_3){
                 
                  foreach($res_3 as $k => $v){
                       $v->mark = 3;
                       array_push($list, $v);

                  }
              }

              //4.已结束，是得主已付款
              $sql_4 = "select a.id,a.title,a.starttime,a.endtime,a.price,a.status,a.invalid_time,a.pepole,a.is_buy from lkt_auction_product as a left join lkt_auction_promise as b on a.id = b.a_id where a.store_id = '$store_id' and b.store_id = '$store_id' and a.status = 2 and a.invalid_time < '$now_time' and a.user_id = '$user_id' and b.user_id = '$user_id' and a.is_buy = 1 order by a.id desc";
              $res_4 = $db->select($sql_4);

              if($res_4){

                  foreach($res_4 as $k => $v){

                      $v->mark = 4;
                      array_push($list,$v);
                  }
              }

              echo json_encode(array('code'=>200,'res'=>$list));
              exit;

          }
         


 }

 
 //(未开始和正在竞拍)要请求的接口方法
 public function detail(){

    //初始化
     $db = DBAction::getInstance();
     $request = $this->getContext()->getRequest();

    //接收参数
     $store_id = $this->store_id;
     $openid = $this->openid;
     $user_id = $this->user_id;
     $user_money = $this->user_money;

     $a_id = addslashes(trim($request->getParameter('id')));
    
      $sql = "select id,title,starttime,endtime,content,price,add_price,current_price,pepole,promise,imgurl,status,user_id from lkt_auction_product where store_id = '$store_id' and id = '$a_id' ";
      $res = $db->select($sql);

      if(!$res){

          echo json_encode(array('code'=>109,'info'=>'参数错误！'));
          exit;
      }

      $status = $res[0]->status;
      if($status == 0){
        $type = 0; //未开始
      }

      if($status == 1){

          $type = 1; //进行中
      }
     

      
      echo json_encode(array('code'=>200,'res'=>$res,'type'=>$type));
      exit;



 }

 //已结束(无论是否为得主)请求的接口
 public function  end_detail(){

    //初始化
     $db = DBAction::getInstance();
     $request = $this->getContext()->getRequest();

    //接收参数
     $store_id = $this->store_id;
     $openid = $this->openid;
     $user_id = $this->user_id;
     $user_money = $this->user_money;
     $a_id = addslashes(trim($request->getParameter('id')));
     $category = addslashes(trim($request->getParameter('category'))); //0-已结束，1-未付款，2-已付款

     //查询出用户名
     $sql_name = "select user_name from lkt_user where store_id = '$store_id' and user_id = '$user_id'";
     $res_name = $db->select($sql_name);
     $user_name = $res[0]->user_name;

     if($category == 0){

          $sql = "select id,title,starttime,endtime,content,price,add_price,current_price,pepole,imgurl,status,user_id,is_buy from lkt_auction_product where store_id = '$store_id' and id = '$a_id'";
          $res = $db->select($sql);

          if(!$res){

              echo json_encode(array('code'=>108,'info'=>'获取已结束竞拍产品，参数错误！'));
              exit;
          }
          $type = 0;//已结束
     }

     if($category == 1){

          $sql = "select id,title,starttime,endtime,content,price,add_price,current_price,pepole,imgurl,status,user_id,is_buy from lkt_auction_product where store_id = '$store_id' and id = '$a_id' and is_buy = 0";
          $res = $db->select($sql);
          if(!$res){

              echo json_encode(array('code'=>108,'info'=>'获取未付款竞拍产品，参数错误！'));
              exit;
          }
          $res[0]->user_name = $user_name;
          $type = 1;// 未付款


     }

     if($category == 2){

        $sql = "select id,title,starttime,endtime,content,price,add_price,current_price,pepole,imgurl,status,user_id,is_buy from lkt_auction_product where store_id = '$store_id' and id = '$a_id' and is_buy = 1";
        $res = $db->select($sql);

        if(!$res){

           echo json_encode(array('code'=>108,'info'=>'获取已付款竞拍产品，参数错误！'));
           exit;
        }
        $res[0]->user_name = $user_name;
        $type = 2; //已付款

     }

     echo json_encode(array('code'=>200,'res'=>$res,'type'=>$type));
     exit;




 }

//出价记录表
 public function record(){

    //初始化
     $db = DBAction::getInstance();
     $request = $this->getContext()->getRequest();

    //接收参数
     $store_id = $this->store_id;
     $openid = $this->openid;
     $user_id = $this->user_id;
     $user_money = $this->user_money;

     $a_id = addslashes(trim($request->getParameter('id')));

     $sql = "select * from lkt_auction_record where store_id = '$store_id' and auction_id = '$a_id'";
     $res = $db->select($sql);

     if(!$res){

          echo json_encode(array('code'=>108,'info'=>'暂无竞拍记录！'));
          exit;
     }

     echo json_encode(array('code'=>200,'res'=>$res));
     exit;
 }
 
//生成微信订单所需信息，去微信支付

 public function go_pay(){

    //初始化
    $db = DBAction::getInstance();
    $request = $this->getContext()->getRequest();

    $user_id = $this->user_id;

    //接受参数
    $store_id = addslashes(trim($request->getParameter('store_id')));
    $openid = addslashes(trim($request->getParmaeter('openid')));
    $a_id = addslashes(trim($request->getParmaeter('id'))); //竞拍商品id

    //生成订单号
    $pay = 'JP';

    // 商户订单号
    $dingdanhao = $pay.date("ymdhis").rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);

    //title,产品标题
    $title = '竞拍押金';

    //total ,总金额
    $sql = "select promise from lkt_auction_product where store_id = '$store_id' and id = '$a_id'";
    $res = $db->select($sql);
    if($res){
         $total = $res[0]->promise;
    }
   
    $datetime = date("Y-m-d h:i:s");
    //插入一条押金记录，is_pay = 0,
    $sql_1 = "insert into lkt_auction_promise (store_id,user_id,promise,add_time,a_id,trade_no,is_pay) values ('$store_id','$user_id','$total','$datetime','$a_id','$dingdanhao',0)";
    $res_1 = $db->insert($sql_1);

    if($res_1 < 0){

        echo json_encode(array('code'=>110,'info'=>'插入押金记录失败'));
        exit;
    }else{

        echo json_encode(array('code'=>200,'title'=>$title,'trade_no'=>$trade_no,'total'=>$total));
        exit;  
    }




 }

 //出价
 public function add_price(){

  
 }





