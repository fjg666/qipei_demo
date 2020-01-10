<?php
require_once(MO_CONFIG_DIR . '/db_config.php');

class sign_pluginAction
{
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/28   20:48
     * @version 1.0
     */
    // 进入签到页面
    public function index($store_id,$user_id,$year,$month){
        $db = DBAction::getInstance();

        $time = date("Y-m-d H:i:s"); // 当前时间
        $start_1 = date("Y-m-d 00:00:00"); // 今天开始时间
        $startdate = date("$year-$month-01 00:00:00", strtotime(date("Y-m-d"))); // 月开始时间
        $enddate = date('Y-m-d 23:59:59', strtotime("$startdate +1 month -1 day")); // 月结束时间
        $num = 0;
        $day = date("Ymd", strtotime($enddate)) - date("Ymd", strtotime($startdate)) + 1; // 活动天数

        // 查询签到参数
        $sql = "select * from lkt_sign_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if ($r) {
            $is_status = $r[0]->is_status;
            $details = $r[0]->detail;
            $reset = $r[0]->reset; // 重置时间
            $reset = explode(':',$reset);
            if($is_status == 0){
                echo json_encode(array('code'=>222,'message'=>'该活动已结束！'));
                exit;
            }else{
                $reset_time = date("Y-m-d H:i:s", strtotime("+$reset[0] hours $reset[1] minute",strtotime($start_1))); // 今天重置时间
                $reset_time1 = date("Y-m-d H:i:s", strtotime("-1 day",strtotime($reset_time))); // 昨天重置时间
                // 根据商城ID、用户ID、签到时间>昨天重置时间、签到时间<今天重置时间、记录状态为签到，查询签到记录
                $sql = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and sign_time > '$reset_time1' and sign_time < '$reset_time' and type = 0";
                $r1 = $db->select($sql);
                if ($r1) { // 有数据,代表昨天已签到,循环查询连续签到几天
                    for ($i = 1; $i <= $day; $i++) {
                        $start = date("Y-m-d H:i:s", strtotime("-$i day",strtotime($reset_time1))); // 上一天重置时间
                        $end = date("Y-m-d H:i:s", strtotime("-$i day",strtotime($reset_time))); // 当天重置时间

                        if(strtotime($start) >= strtotime($startdate) && strtotime($end) <= strtotime($enddate)){
                            $sql = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and sign_time > '$start' and sign_time < '$end' and type = 0";
                            $r_num = $db->select($sql);
                            if (empty($r_num)) {
                                $num = $i;
                                break;
                            }
                        }else{
                            $num = $i;
                            break;
                        }
                    }
                }
                if($time >= $r[0]->starttime && $time <= $r[0]->endtime){ // 活动进行中
                    if($time >= $reset_time){
                        // 查询今天是否签到
                        $sql = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and sign_time > '$reset_time' and type = 0";
                        $r0 = $db->select($sql);
                        if($r0){
                            $sign_status = 0; // 签过了
                            $num = $num+1;
                        }else{
                            $num = $num;
                            $sign_status = 1; // 没签
                        }
                    }
                }else{ // 活动已结束
                    $sql = "update lkt_sign_config set is_status = 0 where store_id = '$store_id'";
                    $db->update($sql);

                    $num = $num;
                    $sign_status = 0; // 签过了
                }
            }
        }else{
            echo json_encode(array('code'=>109,'message'=>'未设置签到设置！'));
            exit;
        }

        $sign_time = [];
        // 查询当前月份的签到记录
        $sql = "select sign_time from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and sign_time >= '$startdate' and sign_time <= '$enddate' and type = 0";
        $r_2 = $db->select($sql);
        if ($r_2) {
            foreach ($r_2 as $k => $v) {
                $sign_time1 = date("Y-m-d 00:00:00", strtotime($v->sign_time));
                $sign_time2 = date("Y-m-d H:i:s", strtotime("+$reset[0] hours $reset[1] minute", strtotime($sign_time1))); // 今天重置时间
                if ($v->sign_time >= $sign_time2) {
                    $y = date("Y", strtotime($v->sign_time));
                    $m = date("m", strtotime($v->sign_time));
                    $d = date("d", strtotime($v->sign_time));
                } else {
                    $y = date("Y", strtotime($v->sign_time));
                    $m = date("m", strtotime($v->sign_time));
                    $d = date("d", strtotime("-1 day", strtotime($v->sign_time)));
                }

                if ($m < 10) {
                    $m = str_replace("0", "", $m);
                }
                if ($d < 10) {
                    $d = str_replace("0", "", $d);
                }
                $sign_time[$k] = $y .'-'. $m .'-'. $d;
            }
        }

        $data = array('sign_time' => $sign_time, 'num' => $num, 'details' => $details, 'sign_status' => $sign_status);
        return $data;
    }
    /**
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @author 段宏波
     * @date 2018/12/28  20:48
     * @version 1.0
     */
    // 签到
    public function sign($store_id,$user_id){
        $db = DBAction::getInstance();
        $year = date("Y"); // 年
        $month = date("m");  // 月
        $time = date("Y-m-d H:i:s"); // 当前时间
        $start_1 = date("Y-m-d 00:00:00"); // 今天开始时间
        $startdate = date("$year-$month-01 00:00:00", strtotime(date("Y-m-d"))); // 月开始时间
        $enddate = date('Y-m-d 23:59:59', strtotime("$startdate +1 month -1 day")); // 月结束时间
        $num = 0;
        $day = date("Ymd", strtotime($enddate)) - date("Ymd", strtotime($startdate)) + 1; // 活动天数

        // 查询签到参数
        $sql = "select * from lkt_sign_config where store_id = '$store_id' ";
        $r = $db->select($sql);
        if($r){
            $is_status = $r[0]->is_status;
            $sign_score = $r[0]->score; // 领取积分
            $continuity = $r[0]->continuity; // 连续设置
            $reset = $r[0]->reset; // 重置时间
            $reset = explode(':',$reset);
            if($time >= $r[0]->endtime){ // 当前时间 >= 签到有效期
                $sql = "update lkt_sign_config set is_status = 0 where store_id = '$store_id'";
                $db->update($sql);

                echo json_encode(array('code'=>222,'message'=>'该活动已结束！'));
                exit;
            }else{
                $reset_time = date("Y-m-d H:i:s", strtotime("+$reset[0] hours $reset[1] minute",strtotime($start_1))); // 今天重置时间
                $reset_time1 = date("Y-m-d H:i:s", strtotime("-1 day",strtotime($reset_time))); // 昨天重置时间
                // 根据商城ID、用户ID、签到时间>昨天重置时间、签到时间<今天重置时间、记录状态为签到，查询签到记录
                $sql = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and sign_time > '$reset_time1' and sign_time < '$reset_time' and type = 0";
                $r1 = $db->select($sql);
                if ($r1) { // 有数据,代表昨天已签到,循环查询连续签到几天
                    for ($i = 1; $i <= $day; $i++) {
                        $start = date("Y-m-d H:i:s", strtotime("-$i day",strtotime($reset_time1))); // 上一天重置时间
                        $end = date("Y-m-d H:i:s", strtotime("-$i day",strtotime($reset_time))); // 当天重置时间

                        if(strtotime($start) >= strtotime($startdate) && strtotime($end) <= strtotime($enddate)){
                            $sql = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and sign_time > '$start' and sign_time < '$end' and type = 0";
                            $r_num = $db->select($sql);
                            if (empty($r_num)) {
                                $num = $i;
                                break;
                            }
                        }else{
                            $num = $i;
                            break;
                        }
                    }
                }
                $num = $num + 1; // 连续签到次数 + 今天签到
                if($continuity != ''){
                    $continuity = unserialize($continuity);
                    foreach ($continuity as $k => $v){
                        foreach ($v as $ke => $va){
                            if($num == $ke){
                                $sign_score = $va;
                            }
                        }
                    }
                }
                $record = "会员" . $user_id . "签到领取" . $sign_score . "积分";
                $sql = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) value ('$store_id','$user_id','$sign_score','$record',CURRENT_TIMESTAMP,0)";
                $r_0 = $db->insert($sql);

                $msg_title = "签到成功！";
                $msg_content = "您已经连续签到".$num."天啦！奖励您".$sign_score."积分！";
                //给用户发送消息
                // $sql = "insert into `lkt_system_message` (`store_id`, `senderid`, `recipientid`, `title`, `content`, `time`) values ('".$store_id."', '', '".$user_id."', '".$msg_title."', '".$msg_content."', CURRENT_TIMESTAMP)";
                // $r_1 = $db->insert($sql);

                if ($r_0 > 0) {
                    require_once(MO_LIB_DIR . '/GETUI/LaikePushTools.class.php');
                    /**签到成功通知*/
                    $pusher = new LaikePushTools();
                    $pusher->pushMessage($user_id, $db, $msg_title, $msg_content);

                    $sql = "update lkt_user set score = score + '$sign_score' where store_id = '$store_id' and user_id = '$user_id'";
                    $db->update($sql);

                    $sql = "update lkt_sign_record set recovery = 0 where store_id = '$store_id' and user_id = '$user_id'";
                    $db->update($sql);
                }

            }
            $arr['is_status'] = $is_status;
            $arr['sign_score'] = $sign_score;
            $arr['num'] = $num;
            return $arr;
        }else{
            echo json_encode(array('code'=>109,'message'=>'未设置签到设置！'));
            exit;
        }
    }

    public function test($store_id,$user_id){
        $db = DBAction::getInstance();
        $time = date("Y-m-d H:i:s"); // 当前时间
        $time_start = date("Y-m-d H:i:s", mktime(0, 0, 0, date('m'), date('d'), date('Y'))); // 当前时间
        // 查询签到活动
        $sql = "select * from lkt_sign_config where store_id = '$store_id'";
        $r_activity = $db->select($sql);
        if($r_activity){
            $is_status = $r_activity[0]->is_status; // 签到插件是否启用
            $is_remind = $r_activity[0]->is_remind; // 是否提醒
            $starttime = $r_activity[0]->starttime; // 签到有效开始时间
            $endtime = $r_activity[0]->endtime; // 签到结束时间
            $reset = $r_activity[0]->reset; // 重置时间
            $reset = explode(':',$reset);
            $reset_time = date("Y-m-d H:i:s", strtotime("+$reset[0] hours $reset[1] minute",strtotime($time_start))); // 今天重置时间
            $reset_time1 = date("Y-m-d H:i:s", strtotime("-1 day",strtotime($reset_time))); // 昨天重置时间

            if($is_status == 0){ // 签到插件没开启
                $sign_status = 0; // 不用弹出签名框
            }else{
                if ($endtime <= $time || $starttime >= $time) { // 今天开始时间大于签到结束时间 或者 今天开始时间小于签到开始时间 签到还没进行
                    $sql = "update lkt_sign_config set is_status = 0 where store_id = '$store_id'";
                    $db->update($sql);
                    $sign_status = 0; // 不用弹出签名框
                    $is_status = 0;
                }else{ // 签到进行中
                    if($is_remind == 0){ // 不用提醒签到
                        $sign_status = 0; // 不用弹出签名框
                    }else{
                        $sql = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and sign_time > '$reset_time1' and sign_time < '$reset_time' and type = 0";
                        $r1 = $db->select($sql);
                        if ($r1) { // 有数据,就循环查询连续签到几天
                            $sign_status = 0; // 签过了
                        }else{
                            $sign_status = 1; // 没签
                        }
                        if($time >= $reset_time){
                            // 查询今天是否签到
                            $sql = "select * from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and sign_time > '$reset_time' and type = 0";
                            $r0 = $db->select($sql);
                            if($r0){
                                $sign_status = 0; // 有数据,代表当天签名了,不用弹出签名框
                            }else{
                                $sign_status = 1; // 没数据,代表当天还没签名,弹出签名框
                            }
                        }
                    }
                }
            }
            $is_sign_status = $is_status;
        }else {
            $is_sign_status = 0; // 签到插件没开启
            $sign_status = 2; // 没有设置签到活动
        }
        $data = array('is_sign_status'=>$is_sign_status,'sign_status'=>$sign_status);
        return $data;
    }
}

?>