<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/ShowPager.class.php');
require_once(MO_LIB_DIR . '/resultAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');
require_once(MO_LIB_DIR . '/upload.php');
require_once(MO_LIB_DIR . '/ServerPath.class.php');
require_once(MO_LIB_DIR . '/WxPush.class.php');
require_once(MO_LIB_DIR . '/Plugin/Plugin.class.php');
require_once(MO_LIB_DIR . '/Plugin/sign.class.php');
require_once(MO_LIB_DIR . '/Plugin/bargain.class.php');
require_once(MO_LIB_DIR . '/Plugin/coupon.class.php');
require_once(MO_LIB_DIR . '/Plugin/auction.class.php');

class userorderAction extends Action {
    public function getDefaultView() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        // get请求走这
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();

        return ;
    }

    public function execute(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        // post请求走这
        $app = addslashes(trim($request->getParameter('app')));
        $this->$app();

        return;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }

    //用户提交询价
    public function user_add_enquiry(){
        $db = DBAction::getInstance();
        $output = New Result;
        $request = $this->getContext()->getRequest();

        $store_id   =  addslashes(trim($request->getParameter('store_id'))); // 商城id

        $user_id  = $request->getParameter('user_id'); //用户id
        $token    = $request->getParameter('token'); //用户token
        $car_model_id  = $request->getParameter('car_model_id'); //车型id
        $car_model    = $request->getParameter('car_model'); //车型名称
        $parts_name  = $request->getParameter('parts_name'); //配件名称
        $parts_name = explode(",",$parts_name);

        //对token进行验证签名,如果过期返回false,成功返回数组
        $getPayload_test = Tools::userToken($token);
        if($getPayload_test == false){ // 过期
            $output->_jsonError('-1','请先登录！');
        }

        //添加询价表
        $create_data = date('Y-m-d H:i:s');
        $sql = "insert into lkt_enquiry( user_id, car_model_id, car_model, create_date) values($user_id, '$car_model_id', '$car_model', '$create_data')";
        $eid = $db->insert($sql, 'last_insert_id');

        //配件照片
        if(!empty($_FILES)){

            // 图片上传位置
            $uploadImg = "../LKT/images/upload/";

            //读取文件
            $image = $_FILES['parts_image'];

            $type=array('image/jpeg','image/jpg','image/png','image/gif');
            //循环上传
            for ($i=0,$len=count($image['name']);$i<$len;$i++){
                $file=array(
                    'name'=>$image['name'][$i],
                    'type'=>$image['type'][$i],
                    'tmp_name'=>$image['tmp_name'][$i],
                    'error'=>$image['error'][$i],
                    'size'=>$image['size'][$i]
                );
                //调用文件上传函数
                $res = ServerPath::fileUpload($file,$uploadImg,$error,$type);
                if ($res){
                    //添加询价配件表
                    $sql2 = "insert into lkt_enquiry_parts(eid, parts_name, parts_image) values($eid, '$parts_name[$i]', '$res')";
                    $db->insert($sql2);
                    //echo '文件上传成功，对应的文件名是：'.$res.'<br>';
                }
                else{
                    $output->_jsonError('-1',$error);
                }
            }

            //用户询价成功 推送给商家微信
            $sql3 = "select user_id from lkt_mch where review_status = 1";
            $userinfo = $db->select($sql3);
            $userinfo = json_decode(json_encode($userinfo), true);
            if($userinfo){
                foreach($userinfo as $key => $val){
                    $sql4 = "select wx_id from lkt_user where user_id = '".$val['userid']."'";
                    $wx = $db->select($sql4);

                    //微信推送消息
                    WxPush::send_notice($val['userid'],$wx[0]->wx_id,$parts_name);
                }
            }
            $output->_jsonResult('提交成功！');
        }else{
            $output->_jsonError('-1','请上传配件照片！');
        }
    }

    //用户询价列表
    public function user_offer(){
        $db = DBAction::getInstance();
        $output = New Result;

        $request = $this->getContext()->getRequest();

        $store_id = addslashes(trim($request->getParameter('store_id'))); // 商城id
        $user_id  = $request->getParameter('user_id'); //用户id
        $token    = $request->getParameter('token'); //用户token

        //对token进行验证签名,如果过期返回false,成功返回数组
        $getPayload_test = Tools::userToken($token);
        if($getPayload_test == false){ // 过期
            $output->_jsonError('-1','请先登录！');
        }

        //查询用户询价列表
        $sql = "select * from lkt_enquiry where user_id = ".$user_id;
        $enquiry = $db->select($sql);
        $data['enquiry'] = json_decode(json_encode($enquiry),true);


        //根据用户询价查询配件列表
        foreach($data['enquiry'] as $key => $val){
            $sql2  = "select * from lkt_enquiry_parts where eid = ".$val['id'];
            $parts = $db->select($sql2);
            $data['enquiry'][$key]['parts'] = json_decode(json_encode($parts),true);
        }

        $output->_jsonResult('',$data);
    }
}



