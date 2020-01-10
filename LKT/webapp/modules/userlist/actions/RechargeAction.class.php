<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');
class RechargeAction extends Action {

    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id=$this->getContext()->getStorage()->read('store_id');
        $admin_name=$this->getContext()->getStorage()->read('admin_name');
        $log = new LaiKeLogUtils('common/userlist.log');
        
        $user_id = addslashes(trim($request->getParameter('user_id'))); // 用户user_id
        $types = trim($request->getParameter('m'));
        $price = trim($request->getParameter('price'));

        $sql = "select $types from lkt_user where user_id = '$user_id' and store_id = '{$store_id}'";
        $rs = $db->select($sql);
        $rprice = $rs[0]->$types; // 原来的
        if($price < 0){
            if($rprice + $price >= 0){
                $sql = "update lkt_user set $types = $types + '$price' where user_id = '$user_id' and store_id = '{$store_id}'";
                $res = $db -> update($sql);
                //添加日志
                if($res >= 0){
                    if($types == 'money'){
                        $event = '系统扣除' . $price . '余额';

                        $db->admin_record($store_id,$admin_name,' 扣除user_id为'.$user_id.' '.$price.'余额',2);

                        $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,add_date,event,type) values ('$store_id','$user_id','$price','$rprice',CURRENT_TIMESTAMP,'$event',11)";
                        $rr = $db -> insert($sqll);
                        if($rr < 0){
                            $log -> customerLog(__LINE__.':插入余额记录失败，sql为：'.$sqll."\r\n");
                        }
                    }else if($types == 'consumer_money'){
                        $event = '系统扣除' . $price . '消费金';

                        $db->admin_record($store_id,$admin_name,' 扣除user_id为'.$user_id.' '.$price.'消费金',2);

                        $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,add_date,event,type) values ('$store_id','$user_id','$price','$rprice',CURRENT_TIMESTAMP,'$event',18)";
                        $rr = $db -> insert($sqll);
                        if($rr < 0){
                            $log -> customerLog(__LINE__.':插入消费金记录失败，sql为：'.$sqll."\r\n");
                        }
                        $event1 = '系统扣除' . $price . '消费金';

                        $sql = "insert into lkt_distribution_record(store_id,user_id,from_id,money,level,event,type,add_date) values ('$store_id','$user_id',0,'$price',0,'$event1',6,CURRENT_TIMESTAMP)";
                        $r = $db->insert($sql);
                        if($r < 0){
                            $log -> customerLog(__LINE__.':插入分销记录失败，sql为：'.$sql."\r\n");
                        }
                    }else{
                        $event = '系统扣除' . $price . "积分";

                        $db->admin_record($store_id,$admin_name,' 扣除'.$user_id.' '.$price.'积分',2);

                        $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,add_date,event,type) values ('$store_id','$user_id','$price','$rprice',CURRENT_TIMESTAMP,'$event',17)";
                        $rr = $db -> insert($sqll);
                        if($rr < 0){
                            $log -> customerLog(__LINE__.':插入积分记录失败，sql为：'.$sqll."\r\n");
                        }

                        $event1 = "系统扣除" . $price . "积分";
                        $sql = "insert into lkt_sign_record ('store_id',user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$price','$event1',CURRENT_TIMESTAMP,5)";
                        $r = $db->insert($sql);
                        if($r < 0){
                            $log -> customerLog(__LINE__.':插入积分记录失败，sql为：'.$sql."\r\n");
                        }
                    }

                }else{
                    $log -> customerLog(__LINE__.':更新会员余额失败，sql为：'.$sql."\r\n");
                }
            }else{
                $res = 0;
            }
        }else{
            $sql = "update lkt_user set $types = $types + '$price' where user_id = '$user_id' and store_id = '{$store_id}'";
            $res = $db -> update($sql);
            //添加日志 类型 0:登录/退出 1:充值 2:提现 3:分享4:余额消费 5:退款 6红包提现 7佣金 8管理佣金 9 待定 10 消费金 11 系统扣款
            if($res >= 0){
                if($types == 'money'){
                    $event = $user_id . '系统充值' . $price .'余额';

                    $db->admin_record($store_id,$admin_name,'给'.$user_id.'充值'.$price.'余额',2);

                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$price','$rprice','$event',14)";
                    $rr = $db -> insert($sqll);
                    if($rr < 0){
                        $log -> customerLog(__LINE__.':插入充值记录失败，sql为：'.$sqll."\r\n");
                    }
                }else if($types == 'consumer_money'){
                    $event = $user_id . '系统充值' . $price .'消费金';

                    $db->admin_record($store_id,$admin_name,'给'.$user_id.'充值'.$price.'消费金',2);

                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$price','$rprice','$event',16)";
                    $rr = $db -> insert($sqll);
                    if($rr < 0){
                        $log -> customerLog(__LINE__.':插入消费金记录失败，sql为：'.$sqll."\r\n");
                    }

                    $event1 = '系统充值' . $price . '消费金';
                    $sql = "insert into lkt_distribution_record(store_id,user_id,from_id,money,level,event,type,add_date) values ('$store_id','$user_id',0,'$price',0,'$event1',13,CURRENT_TIMESTAMP)";
                    $r = $db->insert($sql);
                    if($r < 0){
                        $log -> customerLog(__LINE__.':插入分销记录失败，sql为：'.$sql."\r\n");
                    }
                }else{
                    $event = $user_id . '系统充值' . $price ."积分";

                    $db->admin_record($store_id,$admin_name,'给'.$user_id.'充值'.$price.'积分',2);

                    $sqll = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$price','$rprice','$event',15)";
                    $rr = $db -> insert($sqll);
                    if($rr){
                        $log -> customerLog(__LINE__.':插入积分记录失败，sql为：'.$sqll."\r\n");
                    }
                    $event1 = "系统充值" . $price . "积分";
                    $sql = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$price','$event1',CURRENT_TIMESTAMP,6)";
                    $r = $db->insert($sql);
                    if($r < 0){
                        $log -> customerLog(__LINE__.':插入积分记录失败，sql为：'.$sql."\r\n");
                    }
                }
            }else{
                $log -> customerLog(__LINE__.':更新用户余额失败，sql为：'.$sql."\r\n");
                $res = 0;
            }
        }
        echo $res;
        return;
    }

    public function execute() {

    }

    public function getRequestMethods(){
        return Request :: NONE;
    }

}

?>