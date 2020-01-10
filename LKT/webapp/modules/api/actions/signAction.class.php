<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/sign_pluginAction.class.php');
require_once('Apimiddle.class.php');

class signAction extends Apimiddle
{
    /*
    时间2018年03月13日
    修改内容：修改首页商品及分类请求数据
    修改人：苏涛
    主要功能：处理小程序首页请求结果
    公司：湖南壹拾捌号网络技术有限公司
     */
    public function getDefaultView()
    {
        return;
    }

    public function execute()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $m = addslashes(trim($request->getParameter('m')));

        $this->$m();

        return;
    }

    public function getRequestMethods()
    {
        return Request :: POST;
    }

    // 点击签到
    public function index()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('openid')); // 微信id

        // 根据微信id,查询用户id,用户积分
        $sql = "select user_id,score from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $rr = $db->select($sql);
        if($rr){
            $user_id = $rr[0]->user_id;
            $score = $rr[0]->score;

            $sign = new sign_pluginAction();
            $sign_arr = $sign->sign($store_id,$user_id);
            if($sign_arr == 0){
                echo json_encode(array('status' => 0, 'err' => '系统繁忙！'));
                exit;
            }else{
                $score = $score + $sign_arr;
                echo json_encode(array('status' => 1, 'sign_score' => $sign_arr,'score'=>$score));
                exit;
            }

        }else{
            echo json_encode(array('status' => 0, 'err' => '系统繁忙！'));
            exit;
        }
    }

    // 进入签到页面
    public function sign()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('openid')); // 微信id
        $year = trim($request->getParameter('year')); // 年
        $month = trim($request->getParameter('month')); // 月

        // 根据微信id,查询用户id,用户积分
        $sql = "select user_id from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $rr = $db->select($sql);
        $user_id = $rr[0]->user_id;

        $sign = new sign_pluginAction();
        $sign_arr = $sign->index($store_id,$user_id,$year,$month);

        if($sign_arr['sign_time'] == array()){
            echo json_encode(array('status' => 0,'sign_time' => $sign_arr['sign_time'], 'imgurl' => $sign_arr['imgurl'], 'num' => $sign_arr['num'], 'details' => $sign_arr['details'], 'sign_status' => $sign_arr['sign_status'], 'err' => '暂无签到记录！'));
            exit;
        }else{
            echo json_encode(array('status' => 1,'sign_time' => $sign_arr['sign_time'], 'imgurl' => $sign_arr['imgurl'], 'num' => $sign_arr['num'], 'details' => $sign_arr['details'], 'sign_status' => $sign_arr['sign_status']));
            exit;
        }
    }

    // 进入积分页面
    public function integral()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $openid = trim($request->getParameter('openid')); // 微信id
        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r_1 = $db->select($sql);

        $logo = ServerPath::getimgpath($r_1[0]->logo);
        // 根据微信id,查询用户id、积分
        $sql = "select user_id,score from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
        $r_2 = $db->select($sql);
        $user_id = $r_2[0]->user_id; // 用户id
        $score = $r_2[0]->score; // 用户积分


        $sql01 = "select sign_score,sign_time,type from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' order by sign_time desc";
        $list_1 = $db->select($sql01);
        $r_3 = [];
        if ($list_1) {
            foreach ($list_1 as $k => $v) {
                if ($v->type == 0 || $v->type == 2 || $v->type == 4 || $v->type == 6 || $v->type == 7) {
                    $v->sign_time = date("Y-m-d", strtotime($v->sign_time));
                    $r_3[] = $v;
                }
            }
        }
        $r_4 = [];
        if ($list_1) {
            foreach ($list_1 as $k => $v) {
                if ($v->type == 1 || $v->type == 3 || $v->type == 5) {
                    $v->sign_time = date("Y-m-d", strtotime($v->sign_time));
                    $r_4[] = $v;
                }
            }
        }
        $sql01 = "select switch from lkt_software_jifen where store_id = '$store_id' ";
        $r01 = $db->select($sql01);
        $switch = $r01[0]->switch;

        $sql = "select * from lkt_software_jifen where store_id = '$store_id' ";
        $rules = $db->select($sql);
        $rule = $rules[0]->rule;

        echo json_encode(array('status' => 1, 'logo' => $logo, 'rule' => $rule, 'score' => $score, 'sign' => $r_3, 'consumption' => $r_4, 'switch' => $switch));
        exit;
    }

    public function transfer_jifen()
    {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $user_id = $_POST['user_id'];
        $openid = $_POST['openid'];
        $jifen = $_POST['jifen'];
        $date_time = date('Y-m-d H:i:s', time());
        if ($jifen <= 0 || $jifen == '') {
            // print_r(0);die;
            echo json_encode(array('status' => 1, 'err' => '正确填写转账金额'));
            exit();
        } else {
            $sql001 = "select user_id,money from lkt_user where store_id = '$store_id' and wx_id = '$openid'";
            $r001 = $db->select($sql001);//本人
            $user_id001 = $r001[0]->user_id;

            $sql01 = "update lkt_user set score = score - '$jifen' where store_id = '$store_id' and wx_id = '$openid'";
            $r01 = $db->update($sql01);//本人
            $sql02 = "update lkt_user set score = score + '$jifen'  where store_id = '$store_id' and user_id = '$user_id'";
            $r02 = $db->update($sql02);//好友
            $sql0001 = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id001','$jifen','转积分给好友','$date_time','3')"; //本人
            $r0001 = $db->insert($sql0001);
            $sql0002 = "insert into lkt_sign_record (store_id,user_id,sign_score,record,sign_time,type) values ('$store_id','$user_id','$jifen','好友转积分','$date_time','4')";//好友
            $r0002 = $db->insert($sql0002);
            if ($r01 > 0 && $r02 > 0) {
                echo json_encode(array('status' => 1, 'err' => '转账成功！'));
                exit();
            } else {
                echo json_encode(array('status' => 0, 'err' => '转账失败！'));
                exit();
            }
        }


    }

}

?>