<?php
/**
 * [check_phone description]
 * <p>Copyright (c) 2018-2019</p>
 * <p>Company: www.laiketui.com</p>
 * @Author  熊孔钰
 * @version 2.2.1
 * @date    2019-03-28T19:16:19+0800
 */
require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class Commission
{

    //用户升级
    //$up_0 -> 商品绑定等级  $up_1 -> 会员id
    public function uplevel($db,$store_id,$up_1,$up_0=0)
    {
        $log = new LaiKeLogUtils('common/lib_commission.log');// 日志

        $this->store_id = $store_id;
        $db->begin();
        // 查询配置参数
        $sql = "select sets from lkt_distribution_config where store_id = '$store_id' ";
        $r_1 = $db->select($sql);
        $c_pay = 2;
        $c_cengji = 0;
        if($r_1){
            $sets = unserialize($r_1[0]->sets);
            if(array_key_exists('c_pay', $sets)){
                $c_pay = $sets['c_pay'];//规则统计方式  1.付款后 2.收货后
            }
            $c_cengji = array_key_exists('c_cengji', $sets)?$sets['c_cengji']:0;
        }

        //统一升级
        $up_3 = $this->getlevels($db);//获取所有分销等级
        if (!empty($up_3) && count($up_3)>0) {//有分销等级时
            $up_4 = $up_1;//会员id
            $i = 0;
            while ($i < $c_cengji) {//循环升级
                $up_sql_2 = "select * from lkt_user_distribution where store_id = '$store_id' and user_id = '$up_4' limit 0,1";
                $up_res_2 = $db->select($up_sql_2);//查询分销商信息
                if (!$up_res_2) {break;}

                $up_5 = $this->get_nextlevel($db,$up_4);// 获取下一分销等级

                $c = " and b.r_status in (3,5,7)";//默认为查询确认收货订单
                if ($c_pay == 1) {
                    $c = " and b.r_status in (1,2,3,5,7)";//查询已付款订单
                }
                // 如果用户为分销商，并且还能继续升级
                if ($up_res_2 && $up_5) {

                    $up_6 = $up_3[$up_5['id']];//下一等级配置信息
                    $up_7 = count($up_6);//下一等级升级条件数
                    $ok = 0;//升级条件满足数

                    //一次性消费
                    if(array_key_exists("onebuy",$up_6)){

                        $sql = "select max(c.z_price) as z_price from lkt_product_list a left join lkt_order_details b on a.id=b.p_id left join lkt_order c on b.r_sNo=c.sNo where a.is_distribution=1 and b.user_id='$up_4' $c limit 0,1";
                        $r = $db->select($sql);
                        $sum = $r?floatval($r[0]->z_price):0;
                        if ($sum >= floatval($up_6['onebuy'])) {
                            $ok++;
                        }
                    }

                    //推荐指定等级会员
                    if(array_key_exists("recomm",$up_6)){
                        $up_14 = explode(',', $up_6['recomm']);
                        if (array_key_exists('1', $up_14)) {

                            $sql = "select id from lkt_distribution_grade where store_id='$store_id' and sort>=(select sort from lkt_distribution_grade where store_id='$store_id' and id='".$up_14[1]."')";
                            $r = $db->select($sql);
                            if ($r) {
                                $levels = '';
                                foreach ($r as $k => $v) {
                                    $levels .= $v->id.',';
                                }
                                $levels = substr($levels,0,strlen($levels)-1);
                                if (!empty($levels)) {
                                    $sql = "select count(id) as count from lkt_user_distribution where store_id = '$store_id' and pid='$up_4' and level in ($levels)";
                                    $r = $db->select($sql);
                                    if (intval($r[0]->count) >= intval($up_14[0])) {
                                        $ok++;
                                    }
                                }
                            }
                        }
                    }

                    //累计消费升级
                    if(array_key_exists("manybuy",$up_6)){
                        $up_8 = intval($up_6['manybuy']);
                        if (intval($up_res_2[0]->onlyamount) >= $up_8) {
                            $ok++;
                        }
                    }

                    //累计业绩升级
                    if(array_key_exists("manyyeji",$up_6)){
                        $up_8 = $up_6['manyyeji'][0];
                        if (intval($up_res_2[0]->allamount) >= $up_8[0]) {
                            $ok++;
                        }
                    }

                    //团队人数升级
                    if(array_key_exists("manypeople",$up_6)){
                        $up_8 = explode(',', $up_6['manypeople']);
                        //直推人数
                        $up_sql_3 = "select count(id) as count from lkt_user_distribution where store_id = '$store_id' and level>0 and pid='$up_4'";
                        $up_res_3 = $db->select($up_sql_3);
                        //团队人数
                        $up_sql_4 = "select count(id) as count from lkt_user_distribution where store_id = '$store_id' and level>0 and lt >= '".$up_res_2[0]->lt."' and rt <= '".$up_res_2[0]->rt."'";
                        $up_res_4 = $db->select($up_sql_4);
                        if (intval($up_res_3[0]->count) >= intval($up_8[0]) && intval($up_res_4[0]->count) >= intval($up_8[1])) {
                            $ok++;
                        }
                    }
                    
                    $uplevel = false;//升级开关
                    if ($up_7 > 0) {//如果升级条件数大于0
                        if ($sets['c_uplevel'] == 1 && $ok > 0) {//分销等级晋升设置满足任意一项
                            $uplevel = true;//开启升级
                        }else if ($sets['c_uplevel'] == 2 && $ok == $up_7) {//分销等级晋升设置满足所有选项
                            $uplevel = true;
                        }
                    }
                    //升级
                    if ($uplevel) {
                        // 修改用户分销等级
                        $dis_sql_9 = "update lkt_user_distribution set level = '".$up_5['id']."' where store_id = '$store_id' and user_id = '$up_4'";
                        $beres = $db->update($dis_sql_9);
                        if ($beres < 1) {
                            $db->rollback();
                            $log->customerLog(__LINE__.":分销统一升级失败:$dis_sql_9 \r\n");
                            echo json_encode(array('status' => 0, 'err' => '参数错误 code:c3', 'sql' => $dis_sql_9));
                            exit;
                        }
                        $log->customerLog(__LINE__.":会员【".$up_4."】分销统一升级到等级[".$up_5['id']."]成功！ \r\n");
                        $up_12 = $this->getsets($db,$up_5['id']);
                        //升级奖励积分
                        if (intval($up_12['integral']) > 0) {
                            $this->up_put($db,$up_12,$up_4);
                        }
                        //升级奖励积分 end
                        if (empty($up_res_2[0]->pid)) {
                            break;
                        }else{
                            $up_4 = $up_res_2[0]->pid;
                            $i++;
                        }
                    }else{
                        break;
                    }
                }else{
                    break;
                }
            }
        }
        //统一升级 end
        //事务提交
        $db->commit();
        
        return;
    }

    //升级赠送积分
    public function up_put($db,$up_12,$up_4)
    {
        $log = new LaiKeLogUtils('common/lib_commission.log');// 日志

        $store_id = $this->store_id;

        $integral = intval($up_12['integral']);

        $sql = "update lkt_user set score = score+'$integral' where store_id = '$store_id' and user_id = '$up_4'";
        $beres = $db->update($sql);
        if ($beres < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":【".$up_4."】升级赠送积分[".$integral."]失败:$sql \r\n");
            echo json_encode(array('status' => 0, 'err' => '参数错误 code:c2', 'sql' => $sql));
            exit;
        }
        $event = "会员" . $up_4 . "升级获得了" . $integral . "积分.";
        //类型 1:转入(收入) 2:提现 3:管理佣金 4:使用消费金 5收入消费金 6 系统扣款 7:充值积分 8使用积分
        $sNo = 'CZ'.date("ymdhis").rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
        $sqlldr = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$up_4','$up_4','$integral','$sNo','0','$event','8',CURRENT_TIMESTAMP)";
        $beres = $db->insert($sqlldr);
        if ($beres < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":【".$up_4."】升级赠送积分[".$integral."]失败:$sqlldr \r\n");
            echo json_encode(array('status' => 0, 'err' => '参数错误 code:42', 'sql' => $sqlldr));
            exit;
        }

        $sqll = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$up_4','$integral','$event',CURRENT_TIMESTAMP,9)";
        $beres = $db->insert($sqll);                              //事务
        if ($beres < 1) {
            $db->rollback();
            $log->customerLog(__LINE__.":【".$up_4."】升级赠送积分[".$integral."]失败:$sqll \r\n");
            echo json_encode(array('status' => 0, 'err' => '参数错误 code:43', 'sql' => $sqll));
            exit;
        }

        //发送消息给用户
        $msg_title = "恭喜您升级为".$up_12['s_dengjiname']."!";
        $msg_content = "特别赠送您".$integral."积分！";
        //给用户发送消息
        // $sql1 = "insert into `lkt_system_message` (`store_id`, `senderid`, `recipientid`, `title`, `content`, `time`) values ('".$store_id."', '', '".$up_4."', '".$msg_title."', '".$msg_content."', CURRENT_TIMESTAMP)";
        // $beres = $db->insert($sql1);
        // if ($beres < 1) {
        //     $db->rollback();
        //     $log->customerLog(__LINE__.":【".$up_4."】升级赠送积分[".$integral."]失败:$sql1 \r\n");
        //     echo json_encode(array('status' => 0, 'err' => '参数错误 code:c11', 'sql' => $sql1));
        //     exit;
        // }
        $log->customerLog(__LINE__.":【".$up_4."】升级赠送积分[".$integral."]成功！ \r\n");

        /**升级赠送积分通知*/
        $pusher = new LaikePushTools();
        $pusher->pushMessage($up_4, $db, $msg_title, $msg_content,$store_id);

        return;
    }

    //获取所有分销等级
    public function getlevels($db)
    {
        $store_id = $this->store_id;

        $dis_sql_0 = "select * from lkt_distribution_grade where store_id = '$store_id' order by sort asc";
        $res_0 = $db->select($dis_sql_0);
        $res_1 = array();
        if ($res_0) {
            foreach ($res_0 as $k => $v) {
                $sets = unserialize($v->sets);
                $res_1[$v->id] = $sets['levelobj'];
            }
        }
        return $res_1;
    }

    //创建分销等级和会员信息
    //$cl_0 -> 会员id  $cl_1 -> 会员等级  $cl_2 -> 推荐人id
    public function create_level($db, $cl_0, $cl_1, $cl_2='',$store_id='')
    {
        $log = new LaiKeLogUtils('common/lib_commission.log');// 日志

        if (empty($store_id)) {
            $store_id = $this->store_id;
        }

        $cl_sql_0 = "select id from lkt_user_distribution where store_id = '$store_id' and user_id = '$cl_0'";
        $cl_res_0 = $db->select($cl_sql_0);
        if ($cl_res_0) {
            return;
        }

        $cl_sql_1 = "select rt,level,uplevel from lkt_user_distribution where store_id = '$store_id' and user_id = '$cl_2'";
        $cl_res_1 = $db->select($cl_sql_1);
        //分销推荐
        if ($cl_res_1) {
            $cl_sql_2 = "select user_id from lkt_user_distribution where store_id = '$store_id' and user_id = '$cl_0'";
            $cl_res_2 = $db->select($cl_sql_2);
            if (!$cl_res_2) {
                $rt = $cl_res_1[0]->rt;
                $level = $cl_1;
                $uplevel = intval($cl_res_1[0]->uplevel)+1;
                $cl_sql_3 = "update lkt_user_distribution set lt = lt + 2 where store_id = '$store_id' and lt>='$rt'";
                $cl_sql_4 = "update lkt_user_distribution set rt = rt + 2 where store_id = '$store_id' and rt>='$rt'";
                $lrt = $rt + 1;
                $cl_sql_5 = "INSERT INTO lkt_user_distribution ( `store_id`,`user_id`, `pid`, `level`, `lt`, `rt`, `uplevel`, `add_date`) VALUES ( '$store_id','$cl_0', '$cl_2', '$level', '$rt', '$lrt', '$uplevel', CURRENT_TIMESTAMP)";
                $cl_res_3 = $db->update($cl_sql_3);
                $cl_res_4 = $db->update($cl_sql_4);
                $cl_res_5 = $db->insert($cl_sql_5);
                //事务
                if ($cl_res_5 != 1 || $cl_res_3 < 0 || $cl_res_4 < 0) {
                    $db->rollback();
                    $log->customerLog(__LINE__.":创建分销等级[".$level."]和会员【".$cl_0."】信息失败: $cl_res_5 \r\n $cl_res_4 \r\n $cl_res_3 \r\n");
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:30', 'sql' => $cl_sql_3 . $cl_sql_4 . $cl_sql_5));
                    exit;
                }
            }
        }else{//当推荐人不存在时
            $cl_sql_6 = "select * from lkt_user_distribution where store_id = '$store_id' order by rt desc";
            $cl_res_6 = $db->select($cl_sql_6);
            if ($cl_res_6) {

                $sql = "update lkt_user_distribution SET rt=rt+2 WHERE store_id='$store_id' and user_id ='".$cl_res_6[0]->user_id."'";
                $r = $db->update($sql);
                if ($r < 0) {
                    $db->rollback();
                    $log->customerLog(__LINE__.":创建会员【".$cl_0."】信息失败: $sql \r\n");
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:31', 'sql' => $sql));
                    exit;
                }
                $rt = $cl_res_6[0]->rt;
                $lrt = intval($rt) + 1;
                $uplevel = intval($cl_res_6[0]->uplevel)+1;
                $pid = $cl_res_6[0]->user_id;
            }else{
                $rt = 0;
                $lrt = 1;
                $uplevel = 0;
                $pid = '';
            }
            $level = $cl_1;
            $cl_sql_5 = "INSERT INTO lkt_user_distribution ( `store_id`,`user_id`, `pid`, `level`, `lt`, `rt`, `uplevel`, `add_date`) VALUES ( '$store_id','$cl_0', '$pid', '$level', '$rt', '$lrt', '$uplevel', CURRENT_TIMESTAMP)";
            $cl_res_5 = $db->insert($cl_sql_5);
            //事务
            if ($cl_res_5 < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":创建分销等级[".$level."]和会员【".$cl_0."】信息失败: $cl_sql_5 \r\n");
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:30', 'sql' => $cl_sql_5));
                exit;
            }
        }
        return;
    }

    //获取下一分销等级
    //$nl_0 -> 会员id
    public function get_nextlevel($db,$nl_0)
    {
        $store_id = $this->store_id;

        $nl_sql_1 = "select level from lkt_user_distribution where store_id = '$store_id' and user_id = '$nl_0'";
        $nl_res_1 = $db->select($nl_sql_1);

        $nl_1 = !empty($nl_res_1)?intval($nl_res_1[0]->level):0;
        if ($nl_1 > 0) {

            $nl_sql_2 = "select sort from lkt_distribution_grade where store_id = '$store_id' and id = '$nl_1'";
            $nl_res_2 = $db->select($nl_sql_2);
            if ($nl_res_2) {

                $nl_2 = intval($nl_res_2[0]->sort);

                $nl_sql_3 = "select * from lkt_distribution_grade where store_id = '$store_id' and id>'$nl_1' and sort>='$nl_2' order by sort asc limit 0,1";
            }else{
                $nl_sql_3 = "select * from lkt_distribution_grade where store_id = '$store_id' order by sort asc limit 0,1";
            }

        }else{

            $nl_sql_3 = "select * from lkt_distribution_grade where store_id = '$store_id' order by sort asc limit 0,1";

        }

        $nl_res_3 = $db->select($nl_sql_3);
        if ($nl_res_3) {
            $res = (array)$nl_res_3[0];
        }else{
            $res = '';
        }

        return $res;
    }

    //佣金发放
    //$put_0 -> sNo     $put_3 -> 推广业绩
    public function putcomm($db,$store_id,$put_0,$put_3)
    {
        $log = new LaiKeLogUtils('common/lib_commission.log');// 日志

        $put_sql_0 = "select user_id from lkt_order_details where store_id = '$store_id' and r_sNo = '$put_0' limit 0,1";
        $put_res_0 = $db->select($put_sql_0);
        
        if (!$put_res_0) {
            return;
        }

        $put_4 = $put_res_0[0]->user_id;

        $put_sql_1 = "select * from lkt_distribution_record where store_id = '$store_id' and sNo='$put_0' and status=0";
        $put_res_1 = $db->select($put_sql_1);
        if (count($put_res_1) > 0) {
            foreach ($put_res_1 as $k => $v) {
                $put_1 = $v->money;

                //修改佣金表状态
                $put_sql_2 = "update lkt_distribution_record set status = 1 where store_id = '$store_id' and id = '".$v->id."'";
                $beres = $db->update($put_sql_2);
                if ($beres < 1) {
                    $db->rollback();
                    $log->customerLog(__LINE__.":佣金[".$put_1."]发放【".$put_4."】失败: $put_sql_2 \r\n");
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:c4', 'sql' => $put_sql_2));
                    exit;
                }

                //修改用户佣金
                $put_sql_3 = "update lkt_user_distribution set commission = commission+'$put_1' where store_id = '$store_id' and user_id = '".$v->user_id."'";
                $beres = $db->update($put_sql_3);
                if ($beres < 1) {
                    $db->rollback();
                    $log->customerLog(__LINE__.":佣金[".$put_1."]发放【".$put_4."】失败: $put_sql_3 \r\n");
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:c5', 'sql' => $put_sql_3));
                    exit;
                }

                //金额记录表
                $put_2 = $v->event."[".$v->sNo."]";
                $put_sql_4 = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','".$v->user_id."','$put_1','0','$put_2',7)";
                $beres = $db->insert($put_sql_4);
                if ($beres < 1) {
                    $db->rollback();
                    $log->customerLog(__LINE__.":佣金[".$put_1."]发放【".$put_4."】失败: $put_sql_4 \r\n");
                    echo json_encode(array('status' => 0, 'err' => '参数错误 code:c6', 'sql' => $put_sql_4));
                    exit;
                }

                //发送消息给用户
                $msg_title = "佣金到账啦！";
                $msg_content = "您通过订单【".$put_0."】获得佣金".$put_1."元！";
                //给用户发送消息
                // $sql = "insert into `lkt_system_message` (`store_id`, `senderid`, `recipientid`, `title`, `content`, `time`) values ('".$store_id."', '', '".$v->user_id."', '".$msg_title."', '".$msg_content."', CURRENT_TIMESTAMP)";
                // $r = $db->insert($sql);
                // if ($r < 1) {
                //     $db->rollback();
                //     $log->customerLog(__LINE__.":佣金[".$put_1."]发放【".$put_4."】失败: $sql \r\n");
                //     echo json_encode(array('status' => 0, 'err' => '参数错误 code:c11', 'sql' => $sql));
                //     exit;
                // }
                /**佣金到账通知*/
                $pusher = new LaikePushTools();
                $pusher->pushMessage($v->user_id, $db, $msg_title, $msg_content,$store_id);
            }
        }

        $sql = "select is_put from lkt_order where store_id = '$store_id' and sNo = '$put_0'";
        $r = $db->select($sql);
        if ($r && $r[0]->is_put == 0) {
                    
            //业绩增加
            $put_sql_5 = "update lkt_user_distribution set onlyamount = onlyamount+$put_3 where store_id = '$store_id' and user_id = '$put_4'";
            $beres = $db->update($put_sql_5);
            if ($beres < 0) {
                $db->rollback();
                $log->customerLog(__LINE__.":佣金[".$put_1."]发放【".$put_4."】失败: $put_sql_5 \r\n");
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:c7', 'sql' => $put_sql_5));
                exit;
            }

            // 查询配置参数
            $c_cengji = 0;
            $sql = "select sets from lkt_distribution_config where store_id = '$store_id' ";
            $r_1 = $db->select($sql);
            if($r_1){
                $sets = unserialize($r_1[0]->sets);
                $c_cengji = array_key_exists('c_cengji', $sets)?$sets['c_cengji']:0;
            }

            //上级业绩增加
            $put_5 = $put_4;
            $i = 0;
            while ($i < $c_cengji) {

                $put_sql_6 = "select pid from lkt_user_distribution where store_id = '$store_id' and user_id = '$put_5' limit 0,1";
                $put_res_6 = $db->select($put_sql_6);
                if ($put_res_6 && !empty($put_res_6[0]->pid)) {

                    $put_5 = $put_res_6[0]->pid;

                    $put_sql_7 = "update lkt_user_distribution set allamount = allamount+'$put_3' where store_id = '$store_id' and user_id = '$put_5'";
                    $beres = $db->update($put_sql_7);
                    if ($beres < 1) {
                        $db->rollback();
                        $log->customerLog(__LINE__.":佣金[".$put_1."]发放【".$put_4."】失败: $put_sql_7 \r\n");
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:c8', 'sql' => $put_sql_7));
                        exit;
                    }

                    $i++;
                }else{
                    break;
                }
            }

            // 修改发放状态
            $sql = "update lkt_order set is_put=1 where store_id = '$store_id' and sNo = '$put_0'";
            $r = $db->update($sql);
            if ($beres < 0) {
                $db->rollback();
                $log->customerLog(__LINE__.":佣金[".$put_1."]发放【".$put_4."】失败: $put_sql_5 \r\n");
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:c99', 'sql' => $sql));
                exit;
            }

            $log->customerLog(__LINE__.":佣金[".$put_1."]发放【".$put_4."】成功！ \r\n");
            //个人进货奖结算
            $this->one($db,$store_id,$put_4);
        }
    

        $this->uplevel($db,$store_id,$put_4);

        return;
    }

    //获取等级配置
    //$set_0->获取等级id
    public function getsets($db,$set_0)
    {
        $store_id = $this->store_id;
        $set_1 = array();
        if (intval($set_0) > 0) {
            
            $set_sql_0 = "select * from lkt_distribution_grade where store_id = '$store_id' and id='$set_0' limit 0,1";
            $set_res_0 = $db->select($set_sql_0);
            if ($set_res_0) {
                $set_1 = unserialize($set_res_0[0]->sets);
                $set_1['integral'] = $set_res_0[0]->integral;
            }
        }
        return $set_1;
    }

    //个人进货奖结算
    public function one($db,$store_id,$user_id)
    {
        $log = new LaiKeLogUtils('common/lib_commission.log');// 日志

        $sql = "select * from lkt_distribution_config where store_id = '$store_id'";
        $re = $db->select($sql);
        if(!empty($re)){
            $comm_config=unserialize($re[0]->sets);
        }else{
            return;
        }

        if (!array_key_exists("one",$comm_config) || empty($comm_config['one'])) {
            return;
        }
        if (empty($comm_config['one'][0]) || empty($comm_config['one'][1])) {
            return;
        }

        //查询分销信息
        $sql = "select * from lkt_user_distribution where store_id = '$store_id' and user_id='$user_id'";
        $comm_user = $db->select($sql);

        //个人进货奖
        $canon = 0;
        $canput = 0;
        $one_on = explode(",", $comm_config['one'][0]);
        $one_put = explode(",", $comm_config['one'][1]);
        // 循环进货要求
        foreach ($one_on as $k => $v) {
            // 如果用户累计消费大于这个条件，存储信息
            if (floatval($comm_user[0]->onlyamount) >= floatval($v) && floatval($v)>0) {
                $canon = $v;
                $canput = floatval($one_put[$k]);
            }
        }
        //如果达到的条件大于上次达到的条件，发放奖金
        if (floatval($canon) > floatval($comm_user[0]->one_put) && floatval($canput) > 0) {

            //插入佣金记录
            $event = "会员" . $user_id . "获得" . $canput . "个人进货奖";
            $dis_sql_6 = "insert into lkt_distribution_record (store_id,user_id,from_id,money,sNo,level,event,type,add_date) values ('$store_id','$user_id','$user_id','$canput','','0','$event','3',CURRENT_TIMESTAMP)";
            $dis_res_6 = $db->insert($dis_sql_6);
            if ($dis_res_6 < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":【".$user_id."】个人进获奖[".$canput."]结算失败: $dis_sql_6 \r\n");
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:on1', 'sql' => $dis_sql_6));
                exit;
            }

            //修改用户佣金
            $put_sql_3 = "update lkt_user_distribution set one_put='$canon',commission=commission+'$canput' where store_id = '$store_id' and user_id = '$user_id'";
            $beres = $db->update($put_sql_3);
            if ($beres < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":【".$user_id."】个人进获奖[".$canput."]结算失败: $put_sql_3 \r\n");
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:on2', 'sql' => $put_sql_3));
                exit;
            }

            //金额记录表
            $put_sql_4 = "insert into lkt_record (store_id,user_id,money,oldmoney,event,type) values ('$store_id','$user_id','$canput','0','$event',7)";
            $beres = $db->insert($put_sql_4);
            if ($beres < 1) {
                $db->rollback();
                $log->customerLog(__LINE__.":【".$user_id."】个人进获奖[".$canput."]结算失败: $put_sql_4 \r\n");
                echo json_encode(array('status' => 0, 'err' => '参数错误 code:on3', 'sql' => $put_sql_4));
                exit;
            }

            //发送消息给用户
            $msg_title = "个人进货奖到账啦！";
            $msg_content = "恭喜您累计消费达到".$canon."元，特此赠送您".$canput."元！";
            //给用户发送消息
            // $sql = "insert into `lkt_system_message` (`store_id`, `senderid`, `recipientid`, `title`, `content`, `time`) values ('".$store_id."', '', '".$user_id."', '".$msg_title."', '".$msg_content."', CURRENT_TIMESTAMP)";
            // $r = $db->insert($sql);
            // if ($r < 1) {
            //     $db->rollback();
            //     $log->customerLog(__LINE__.":【".$user_id."】个人进获奖[".$canput."]结算失败: $sql \r\n");
            //     echo json_encode(array('status' => 0, 'err' => '参数错误 code:on4', 'sql' => $sql));
            //     exit;
            // }
            /**佣金到账通知*/
            $pusher = new LaikePushTools();
            $pusher->pushMessage($user_id, $db, $msg_title, $msg_content,$store_id);
        }


        if (!array_key_exists("team",$comm_config) || empty($comm_config['team'])) {
            return;
        }
        if (empty($comm_config['team'][0]) || empty($comm_config['team'][1])) {
            return;
        }

        //团队业绩奖
        $canon = 0;
        $canput = 0;
        $team_on = explode(",", $comm_config['team'][0]);
        $team_put = explode(",", $comm_config['team'][1]);
        $c_cengji = 0;
        $sql = "select sets from lkt_distribution_config where store_id = '$store_id' ";
        $r_1 = $db->select($sql);
        if($r_1){
            $sets = unserialize($r_1[0]->sets);
            $c_cengji = array_key_exists('c_cengji', $sets)?$sets['c_cengji']:0;
        }

        $userid = $user_id;
        $i = 0;
        while ($i < $c_cengji) {

            $put_sql_6 = "select * from lkt_user_distribution where store_id = '$store_id' and user_id = '$userid' limit 0,1";
            $put_res_6 = $db->select($put_sql_6);
            if ($put_res_6 && count($put_res_6) > 0) {

                foreach ($team_on as $k => $v) {
                    if (floatval($put_res_6[0]->allamount) >= floatval($v) && floatval($v)>0) {
                        $canon = $v;
                        $canput = floatval($team_put[$k]);
                    }
                }

                if (floatval($canput) > floatval($put_res_6[0]->team_put)) {
                    //修改用户提成比例
                    $put_sql_3 = "update lkt_user_distribution set team_put='$canput' where store_id = '$store_id' and user_id = '$userid'";
                    $beres = $db->update($put_sql_3);
                    if ($beres < 1) {
                        $db->rollback();
                        $log->customerLog(__LINE__.":【".$user_id."】个人进获奖[".$canput."]结算失败: $put_sql_3 \r\n");
                        echo json_encode(array('status' => 0, 'err' => '参数错误 code:on6', 'sql' => $put_sql_3));
                        exit;
                    }
                }
                
                if (!empty($put_res_6[0]->pid)) {

                    $userid = $put_res_6[0]->pid;
                    $i++;
                }else{
                    break;
                }
            }else{
                break;
            }
        }
        $log->customerLog(__LINE__.":【".$user_id."】个人进获奖[".$canput."]结算成功！ \r\n");
        return;
    }

}

?>