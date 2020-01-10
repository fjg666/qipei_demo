<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/Plugin/sign.class.php');

class signAction extends Action {
    /*
    时间2018年06月19日
    修改内容：签到
    修改人：段宏波
    主要功能：进入app签到页面、点击签到、进入积分页面
    公司：湖南壹拾捌号网络技术有限公司
     */
    public function getDefaultView() {
        return;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $access_id = trim($request->getParameter('access_id')); // 授权id

        $this->$app();
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 点击签到
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        if(empty($access_id)){
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }

        // 根据微信id,查询用户id
        $sql = "select user_id,score from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $rr = $db->select($sql);
        if($rr){
            $user_id = $rr[0]->user_id;
            $score = $rr[0]->score;

            $sign = new sign();
            $sign_arr = $sign->click_sign($store_id,$user_id);

            if($sign_arr['is_status'] == 0){
                echo json_encode(array('code'=>222,'message'=>'该活动已结束'));
                exit();
            }else{
                if($sign_arr['sign_score'] == 0){
                    echo json_encode(array('code'=>103,'message'=>'网络繁忙'));
                    exit();
                }else{
                    $score = $score + $sign_arr['sign_score'];

                    echo json_encode(array('code'=>200,'sign_score' => $sign_arr['sign_score'],'score'=>$score,'num' => $sign_arr['num'],'message'=>'成功'));
                    exit;
                }
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
    }
    // 进入签到页面
    public function sign(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $year = trim($request->getParameter('year')); // 年
        $month = trim($request->getParameter('month')); // 月
        if(empty($access_id)){
            $user_id = '';
            $score = 0;
            $sql0 = "select wx_headimgurl from lkt_config where store_id = '$store_id'";
            $r0 = $db->select($sql0);
            if($r0){
                $wx_headimgurl = $r0[0]->wx_headimgurl;//默认微信用户头像
                $headimgurl = ServerPath::getimgpath($wx_headimgurl);//默认微信用户头像
            }
        }else{
            // 根据授权id,查询用户id
            $sql = "select user_id,headimgurl,score from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
            $rr = $db->select($sql);
            if($rr){
                $user_id = $rr[0]->user_id;
                $score = $rr[0]->score;
                $headimgurl = $rr[0]->headimgurl;
            }else{
                $user_id = '';
                $score = 0;
                $sql0 = "select wx_headimgurl from lkt_config where store_id = '$store_id'";
                $r0 = $db->select($sql0);
                if($r0){
                    $wx_headimgurl = $r0[0]->wx_headimgurl;//默认微信用户头像
                    $headimgurl = ServerPath::getimgpath($wx_headimgurl);//默认微信用户头像
                }
            }
        }
        $sign = new sign();
        $sign_arr = $sign->index($store_id,$user_id,$year,$month);

        echo json_encode(array('code'=>200,'sign_time' => $sign_arr['sign_time'], 'imgurl' => $headimgurl, 'num' => $sign_arr['num'], 'details' => $sign_arr['details'], 'sign_status' => $sign_arr['sign_status'],'score'=>$score,'message'=>'成功'));
        exit();
    }
    // 进入积分页面
    public function integral(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id

        // 查询系统参数
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);
        $uploadImg_domain = $r[0]->uploadImg_domain; // 图片上传域名
        $uploadImg = $r[0]->uploadImg; // 图片上传位置

        if(strpos($uploadImg,'../') === false){ // 判断字符串是否存在 ../
            $img = $uploadImg_domain . $uploadImg; // 图片路径
        }else{ // 不存在
            $img = $uploadImg_domain . substr($uploadImg,2); // 图片路径
        }
        $logo = ServerPath::getimgpath($r[0]->logo);
        // 根据微信id,查询用户id、积分
        $sql = "select user_id,score from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r_1 = $db->select($sql);
        if($r_1){
            $user_id = $r_1[0]->user_id; // 用户id
            $score = $r_1[0]->score; // 用户积分
            // 根据用户id、签到类型,查询积分表信息
            $sql = "select sign_score,sign_time,type,sNo from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' order by sign_time desc limit 20";
            $r_2 = $db->select($sql);
            if($r_2){
                foreach ($r_2 as $k => $v){
                    if($v->type == 1 || $v->type == 3 || $v->type == 5 || $v->type == 7 || $v->type == 10){
                        $v->status = false;
                    }else{
                        $v->status = true;
                    }
                    if($v->type == 0){
                        $v->name = '签到领积分';
                    }else if($v->type == 1){
                        $v->name = '购物抵扣积分';
                    }else if($v->type == 2){
                        $v->name = '首次关注得积分';
                    }else if($v->type == 4){
                        $v->name = '好友转积分';
                    }else if($v->type == 5){
                        $v->name = '系统扣除';
                    }else if($v->type == 6){
                        $v->name = '系统充值';
                    }else if($v->type == 8){
                        $v->name = '会员购物积分';
                    }else if($v->type == 9){
                        $v->name = '分销升级奖励积分';
                    }else if($v->type == 10){
                        $v->name = '积分过期';
                    }
                }
            }
            // 根据用户id、签到类型,查询积分表信息
            $sql = "select sign_score,sign_time,type,sNo from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and (type = 0 or type = 2 or type = 4 or type = 6 or type = 8) order by sign_time desc limit 20";
            $r_3 = $db->select($sql);
            if($r_3){
                foreach ($r_3 as $k => $v) {
                    if($v->type == 0){
                        $v->name = '签到领积分';
                    }else if($v->type == 1){
                        $v->name = '购物抵扣积分';
                    }else if($v->type == 2){
                        $v->name = '首次关注得积分';
                    }else if($v->type == 4){
                        $v->name = '好友转积分';
                    }else if($v->type == 5){
                        $v->name = '系统扣除';
                    }else if($v->type == 6){
                        $v->name = '系统充值';
                    }else if($v->type == 8){
                        $v->name = '会员购物积分';
                    }else if($v->type == 9){
                        $v->name = '分销升级奖励积分';
                    }else if($v->type == 10){
                        $v->name = '积分过期';
                    }
                }
            }
            // 根据用户id、消费类型,查询积分表信息
            $sql = "select sign_score,sign_time,type,sNo from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and (type = 1 or type = 3 or type = 5 or type = 7) order by sign_time desc limit 20";
            $r_4 = $db->select($sql);
            if($r_4){
                foreach ($r_4 as $k => $v) {
                    if($v->type == 0){
                        $v->name = '签到领积分';
                    }else if($v->type == 1){
                        $v->name = '购物抵扣积分';
                    }else if($v->type == 2){
                        $v->name = '首次关注得积分';
                    }else if($v->type == 4){
                        $v->name = '好友转积分';
                    }else if($v->type == 5){
                        $v->name = '系统扣除';
                    }else if($v->type == 6){
                        $v->name = '系统充值';
                    }else if($v->type == 8){
                        $v->name = '会员购物积分';
                    }else if($v->type == 9){
                        $v->name = '分销升级奖励积分';
                    }else if($v->type == 10){
                        $v->name = '积分过期';
                    }
                }
            }
            $data = array('logo'=>$logo,'score'=>$score,'whole'=>$r_2,'sign'=>$r_3,'consumption'=>$r_4);
            echo json_encode(array('code'=>200,'data'=>$data,'message'=>'成功'));
            exit();
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }
    // 积分页面——加载更多
    public function load_integral(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $type = trim($request->getParameter('type')); // 授权id
        $page = trim($request->getParameter('page')); // 加载次数

        $kaishi = $page * 20;
        $jieshu = 20;

        // 根据微信id,查询用户id、积分
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r_1 = $db->select($sql);
        if($r_1){
            $user_id = $r_1[0]->user_id; // 用户id
            if($type == 1){
                // 根据用户id、签到类型,查询积分表信息
                $sql = "select sign_score,sign_time,type from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and (type = 0 or type = 2 or type = 4 or type = 6) order by sign_time desc limit $kaishi,$jieshu";
            }else if($type == 2){
                // 根据用户id、消费类型,查询积分表信息
                $sql = "select sign_score,sign_time,type from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' and (type = 1 or type = 3 or type = 5 or type = 7) order by sign_time desc limit $kaishi,$jieshu";
            }else{
                // 根据用户id、签到类型,查询积分表信息
                $sql = "select sign_score,sign_time,type from lkt_sign_record where store_id = '$store_id' and user_id = '$user_id' order by sign_time desc limit $kaishi,$jieshu";
            }
            $r = $db->select($sql);
            if($r){
                foreach ($r as $k => $v) {
                    if($v->type == 0){
                        $v->name = '签到领积分';
                    }else if($v->type == 1){
                        $v->name = '购物抵扣积分';
                    }else if($v->type == 2){
                        $v->name = '首次关注得积分';
                    }else if($v->type == 4){
                        $v->name = '好友转积分';
                    }else if($v->type == 5){
                        $v->name = '系统扣除';
                    }else if($v->type == 6){
                        $v->name = '系统充值';
                    }else if($v->type == 8){
                        $v->name = '会员购物积分';
                    }else if($v->type == 9){
                        $v->name = '分销升级奖励积分';
                    }else if($v->type == 10){
                        $v->name = '积分过期';
                    }
                }
            }

            echo json_encode(array('code'=>200,'list'=>$r,'message'=>'成功'));
            exit();
        }else{
            echo json_encode(array('code'=>115,'message'=>'非法入侵！'));
            exit;
        }
    }
    // 积分使用说明
    public function Instructions(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $Instructions = '';
        $sql = "select Instructions from lkt_sign_config where store_id = '$store_id'";
        $r = $db->select($sql);
        if($r){
            $Instructions = $r[0]->Instructions;
        }
        echo json_encode(array('code'=>200,'Instructions' => $Instructions,'message'=>'成功'));
        exit;
    }
}

?>