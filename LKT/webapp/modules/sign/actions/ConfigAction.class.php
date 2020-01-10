<?php

/**

 * [Laike System] Copyright (c) 2018 laiketui.com

 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.

 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/JurisdictionAction.class.php');
require_once(MO_LIB_DIR . '/LaiKeLogUtils.class.php');

class ConfigAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $time = date("Y-m-d H:i:s");
        $status = 0; // 可以修改签到设置
        $sql = "select * from lkt_sign_config where store_id = '$store_id'";
        $r = $db->select($sql);
        $reset_h = '00';
        $reset_i = '00';
        if($r){
            $is_status = $r[0]->is_status; // 签到插件是否启用
            $score_num = $r[0]->score_num; // 签到次数
            $starttime = $r[0]->starttime; //签到有效开始时间
            $endtime = $r[0]->endtime; // 签到有效结束时间
            $is_remind = $r[0]->is_remind; // 是否提醒
            $reset = $r[0]->reset; // 间隔时间
            $score = $r[0]->score; // 领取积分
            $continuity = unserialize($r[0]->continuity); // 连续设置
            $detail = $r[0]->detail; // 签到详情
            $Instructions = $r[0]->Instructions; // 积分使用说明
            $is_many_time = $r[0]->is_many_time; // 是否允许多次 0:不允许  1:允许
            $num  = count($continuity);

            $reset_h = floor($reset/3600);
            $reset_i = floor(($reset-3600*$reset_h)/60);

        }
        $request->setAttribute('is_status', isset($is_status) ? $is_status : 0);
        $request->setAttribute('score_num', isset($score_num) ? $score_num : 1);
        $request->setAttribute('starttime', isset($starttime) ? $starttime : '');
        $request->setAttribute('endtime', isset($endtime) ? $endtime : '');
        $request->setAttribute('is_remind', isset($is_remind) ? $is_remind : 0);
        $request->setAttribute('reset_h', isset($reset_h) ? $reset_h : '');
        $request->setAttribute('reset_i', isset($reset_i) ? $reset_i : '');
        $request->setAttribute('score', isset($score) ? $score : '');
        $request->setAttribute('continuity', isset($continuity) ? $continuity : '');
        $request->setAttribute('detail', isset($detail) ? $detail : '');
        $request->setAttribute('Instructions', isset($Instructions) ? $Instructions : '');
        $request->setAttribute('is_many_time', isset($is_many_time) ? $is_many_time : 0);
        $request->setAttribute('num', isset($num) ? $num : 2);
        return View :: INPUT;
    }

    public function execute() {
        $db = DBAction::getInstance();
        $JurisdictionAction = new JurisdictionAction();
        $lktlog = new LaiKeLogUtils("common/sign.log");
        // 1.开启事务
        $db->begin();

        $request = $this->getContext()->getRequest();
        $admin_name = $this->getContext()->getStorage()->read('admin_name');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        // 接收信息
        $is_status = addslashes($request->getParameter('is_status')); // 签到插件是否启用
        $score_num = addslashes($request->getParameter('score_num')); // 签到次数
        $starttime = addslashes(trim($request->getParameter('starttime'))); // 签到有效开始时间
        $endtime = addslashes(trim($request->getParameter('endtime'))); // 签到有效结束时间
        $is_remind = addslashes($request->getParameter('is_remind')); // 是否提醒
        $is_many_time = addslashes($request->getParameter('is_many_time')); // 是否允许多次 0:不允许  1:允许
        $reset_h = addslashes($request->getParameter('reset_h')); // 签到重置时间 小时
        $reset_i = addslashes($request->getParameter('reset_i')); // 新活动图片 分钟
        $score = addslashes(trim($request->getParameter('score'))); // 领取积分
        $continuity_num = $request->getParameter('continuity_num'); // 连续签到次数
        $continuity_score = $request->getParameter('continuity_score'); // 连续签到奖励
        $detail = $request->getParameter('detail'); // 签到详情
        $Instructions = $request->getParameter('Instructions'); // 积分使用说明

        if(empty($starttime)){
            echo json_encode(array('status' =>'请选择签到有效开始时间!' ));exit;
        }else{
            $starttime = date("Y-m-d 00:00:00",strtotime($starttime));
        }
        if(empty($endtime)){
            echo json_encode(array('status' =>'请选择签到有效结束时间!' ));exit;
        }else{
            if($endtime <= $starttime){
                echo json_encode(array('status' =>'签到有效时间错误!' ));exit;
            }
            if($endtime == date("Y-m-d 00:00:00",strtotime($endtime))){
                $endtime = date("Y-m-d 23:59:59",strtotime($endtime));
            }else{
                $endtime = $endtime;
            }
        }

        if($is_many_time == 1){
            if(empty($score_num)){
                echo json_encode(array('status' =>'请填写每天签到有效次数!' ));exit;
            }else{
                if(floor($score_num) != $score_num){
                    echo json_encode(array('status' =>'每天签到有效次数请填写整数!' ));exit;
                }
                if($score_num <= 0){
                    echo json_encode(array('status' =>'每天签到有效次数请填写大于0的整数!' ));exit;
                }else if($score_num > 6){
                    echo json_encode(array('status' =>'每天可签到次数最多不能超过6次!' ));exit;
                }

                if($reset_h == ''){
                    echo json_encode(array('status' =>'间隔小时不能为空!' ));exit;
                }else{
                    if(floor($reset_h) != $reset_h){
                        echo json_encode(array('status' =>'间隔小时请填写整数!' ));exit;
                    }
                }
                if($reset_i == ''){
                    echo json_encode(array('status' =>'间隔分钟不能为空!' ));exit;
                }else{
                    if(floor($reset_i) != $reset_i){
                        echo json_encode(array('status' =>'间隔分钟请填写整数!' ));exit;
                    }
                }

                $reset = $reset_h*3600 + $reset_i*60; // 间隔时间转换成秒
                $interval_time = $reset * $score_num; // 间隔时间*签到次数 所需总时间
                if($interval_time >= 24*3600){
                    echo json_encode(array('status' =>'间隔时间设置超出限制，请重新设置!' ));exit;
                }
            }
        }else{
            $reset = 24*3600;
        }
        if(empty($score)){
            echo json_encode(array('status' =>'领取积分不能为空!' ));exit;
        }else{
            if(floor($score) != $score){
                echo json_encode(array('status' =>'领取积分请填写整数!' ));exit;
            }
            if($score <= 0){
                echo json_encode(array('status' =>'领取积分请填写大于0的整数!' ));exit;
            }
        }

        foreach ($continuity_num as $k => $v){
            if($continuity_num[$k] != '' && $continuity_score[$k] != ''){
                if($k == 0){

                }else{
                    if($continuity_num[$k] <= $continuity_num[$k-1]){
                        echo json_encode(array('status' =>'次数没有依次递增!' ));exit;
                    }
                    if($continuity_score[$k] <= $continuity_score[$k-1]){
                        echo json_encode(array('status' =>'奖励积分没有依次递增!' ));exit;
                    }
                }
                if($continuity_num[$k] != 0  && $continuity_num[$k] > 0 && $continuity_score[$k] > 0){
                    $continuity[][$continuity_num[$k]] = $continuity_score[$k];
                }
            }
        }
        $continuity = serialize($continuity);

        $sql = "select * from lkt_sign_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $sql = "update lkt_sign_config set is_status = '$is_status',score_num = '$score_num',starttime = '$starttime',endtime = '$endtime',is_remind = '$is_remind',reset = '$reset',score='$score',continuity='$continuity',detail = '$detail',Instructions = '$Instructions',modify_date = CURRENT_TIMESTAMP,is_many_time = '$is_many_time' where store_id = '$store_id'";
            $r_1 = $db->update($sql);
            if($r_1 == -1) {
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改签到设置失败',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改签到设置失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'未知原因，签到设置修改失败！' ));exit;
            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,'修改签到设置成功',2);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 修改签到设置成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' =>'签到设置修改成功！' ,'suc'=>'1'));exit;
            }
        }else{
            $sql = "insert into lkt_sign_config(store_id,is_status,score_num,starttime,endtime,is_remind,reset,score,continuity,detail,Instructions,modify_date,is_many_time) values('$store_id','$is_status','$score_num','$starttime','$endtime','$is_remind','$reset','$score','$continuity','$detail','$Instructions',CURRENT_TIMESTAMP,'$is_many_time')";
            $r_1 = $db->insert($sql);
            if($r_1 == -1) {
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加签到设置失败',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加签到设置失败';
                $lktlog->customerLog($Log_content);
                $db->rollback();

                echo json_encode(array('status' =>'未知原因，签到设置添加失败！' ));exit;
            } else {
                $JurisdictionAction->admin_record($store_id,$admin_name,'添加签到设置成功',1);
                $Log_content = __METHOD__ . '->' . __LINE__ . ' 添加签到设置成功';
                $lktlog->customerLog($Log_content);
                $db->commit();

                echo json_encode(array('status' => '签到设置添加成功！','suc'=>'1'));exit;
            }
        }
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

}

?>