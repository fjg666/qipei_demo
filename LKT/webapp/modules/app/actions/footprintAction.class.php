<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');

class footprintAction extends Action {
    public function getDefaultView() {
        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $app = addslashes(trim($request->getParameter('app')));
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id')); // 授权id
        if(!empty($access_id)){ // 存在
            $getPayload_test = Tools::verifyToken($db,$store_id,$store_type,$access_id); //对token进行验证签名,如果过期返回false,成功返回数组
            if($getPayload_test == false){ // 过期
                echo json_encode(array('code' => 404, 'message' => '请登录！'));
                exit;
            }
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
        $this->$app();
        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 获取我的历史记录
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id

        // 根据微信id,查询用户id
        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        $user_id = $r[0]->user_id;
        $start_time_1=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d'),date('Y'))); // 今天开始时间
        $end_time_1=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1); // 今天结束时间

        $start_time_2=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')-1,date('Y'))); // 昨天开始时间
        $end_time_2=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d'),date('Y'))-1); // 昨天结束时间
        
        $start_time_3=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')-2,date('Y'))); // 前天开始时间
        $end_time_3=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')-1,date('Y'))-2); // 前天结束时间
        // 根据用户id,查询今天足迹
        $sql = "select * from lkt_user_footprint where store_id = '$store_id' and user_id = '$user_id' and add_time > '$start_time_1' and add_time < '$end_time_1' ";
        $r_1 = $db->select($sql);
        if($r_1){
            $time_1 = date('Y年m月d日',strtotime($r_1[0]->add_time));
            foreach ($r_1 as $k_1 => $v_1) {
                $p_id = $v_1->p_id;
                $sql ="select a.product_title,c.img,c.price,a.id from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where store_id = '$store_id' and a.id = '$p_id'";
                $rr_1 = $db->select($sql);
                if($rr_1){
                    foreach ($rr_1 as $key_1 => $value_1) {
                        $value_1->imgurl = ServerPath::getimgpath($value_1->img); // 拼图片路径
                        $value_1->footprint_id = $v_1->id;
                        $res_1[] = $value_1;
                    }
                }
            }
            $rew_1 = $res_1;
            $list_1 = array('time'=>$time_1,'list'=>$rew_1); 
        }else{
            $list_1 = ''; 
        }
        // 根据用户id,查询昨天足迹
        $sql = "select * from lkt_user_footprint where store_id = '$store_id' and user_id = '$user_id' and add_time > '$start_time_2' and add_time < '$end_time_2' ";
        $r_2 = $db->select($sql);
        if($r_2){
            $time_2 = date('Y年m月d日',strtotime($r_2[0]->add_time));
            foreach ($r_2 as $k_2 => $v_2) {
                $p_id = $v_2->p_id;
                $sql ="select a.product_title,c.img,c.price,a.id from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = '$p_id' ";
                $rr_2 = $db->select($sql);
                if($rr_2){
                    foreach ($rr_2 as $key_2 => $value_2) {
                        $value_2->imgurl = ServerPath::getimgpath($value_2->img); // 拼图片路径
                        $value_2->footprint_id = $v_2->id;
                        $res_2[] = $value_2;
                    }
                }
            }
            $rew_2 = $res_2;
            $list_2 = array('time'=>$time_2,'list'=>$rew_2); 
        }else{
            $list_2 = ''; 
        }
        // 根据用户id,查询前天足迹
        $sql = "select * from lkt_user_footprint where store_id = '$store_id' and user_id = '$user_id' and add_time > '$start_time_3' and add_time < '$end_time_3' ";
        $r_3 = $db->select($sql);
        if($r_3){
            $time_3 = date('Y年m月d日',strtotime($r_3[0]->add_time));
            foreach ($r_3 as $k_3 => $v_3) {
                $p_id = $v_3->p_id;
                $sql ="select a.product_title,c.img,c.price,a.id from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = '$p_id' ";
                $rr_3 = $db->select($sql);
                if($rr_3){
                    foreach ($rr_3 as $key_3 => $value_3) {
                        $value_3->imgurl = ServerPath::getimgpath($value_3->img); // 拼图片路径
                        $value_3->footprint_id = $v_3->id;
                        $res_3[] = $value_3;
                    }
                }
            }
            $rew_3 = $res_3;
            $list_3 = array('time'=>$time_3,'list'=>$rew_3); 
        }else{
            $list_3 = ''; 
        }
        // 查询更早的历史记录
        $sql = "select * from lkt_user_footprint where store_id = '$store_id' and user_id = '$user_id' and add_time < '$start_time_3'";
        $r_4 = $db->select($sql);
        if($r_4){
            $time_4 = '更早时间';
            foreach ($r_4 as $k_4 => $v_4) {
                $p_id = $v_4->p_id;
                $sql ="select a.product_title,c.img,c.price,a.id from lkt_product_list AS a LEFT JOIN lkt_configure AS c ON a.id = c.pid where a.store_id = '$store_id' and a.id = '$p_id' ";
                $rr_4 = $db->select($sql);
                if($rr_4){
                    foreach ($rr_4 as $key_4 => $value_4) {
                        $value_4->imgurl = ServerPath::getimgpath($value_4->img); // 拼图片路径
                        $value_4->footprint_id = $v_4->id;
                        $res_4[] = $value_4;
                    }
                }
            }
            $rew_4 = $res_4;
            $list_4 = array('time'=>$time_4,'list'=>$rew_4); 
        }else{
            $list_4 = ''; 
        }
        if($list_1 != '' || $list_2 != '' || $list_3 != '' || $list_4 != ''){
            echo json_encode(array('code'=>200,'data'=>array($list_1,$list_2,$list_3,$list_4),'message'=>'成功'));
            exit();
        }else{
            echo json_encode(array('code'=>108,'message'=>'暂无！'));
            exit();
        }
        return;
    }
    // 删除我的历史记录
    public function alldel(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $access_id = trim($request->getParameter('access_id')); // 授权id
        $str = $request->getParameter('time'); // 时间
        $footprint_id = $request->getParameter('footprint_id'); // 足迹id
        $sql_user = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r_user = $db->select($sql_user);
        $userid = $r_user['0']->user_id;
        if($footprint_id){
            $sql = "delete from lkt_user_footprint where store_id = '$store_id' and user_id = '$userid' and id = '$footprint_id' ";
        }else{
            if($str == '更早时间'){
                $start_time_3=date("Y-m-d H:i:s",mktime(0,0,0,date('m'),date('d')-2,date('Y'))); // 前天开始时间
                $sql = "delete from lkt_user_footprint where store_id = '$store_id' and user_id = '$userid' and add_time < '$start_time_3' ";
            }else{
                $arr = date_parse_from_format('Y年m月d日',$str);  
                $time = mktime(0,0,0,$arr['month'],$arr['day'],$arr['year']);  
                $start_time = date('Y-m-d 0:0:0',$time);
                $end_time = date('Y-m-d 23:59:59',$time);
                $sql = "delete from lkt_user_footprint where store_id = '$store_id' and user_id = '$userid' and add_time >= '$start_time' and add_time < '$end_time'";
            }
        }
        $r = $db->delete($sql);
        if ($r){
            echo json_encode(array('code'=>200,'succ'=>'删除成功！'));
            exit(); 
        }else{
            echo json_encode(array('code'=>101,'err'=>'未知错误！'));
            exit(); 
        }
    }
}
?>