<?php
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Tools.class.php');

class addressAction extends Action {

    public function getDefaultView() {
        $this->execute();
    }

    public function execute(){
       $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/plain');

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $store_type = trim($request->getParameter('store_type'));
        $access_id = trim($request->getParameter('access_id'));
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

        //m指向具体操作方法
        $app = trim($request->getParameter('app')) ? addslashes(trim($request->getParameter('app'))):'index';

        $sql = "select user_id from lkt_user where store_id = '$store_id' and access_id = '$access_id'";
        $r = $db->select($sql);
        if($r){
            $user_id = $r[0]->user_id;
            $this->db = $db;
            $this->user_id = $user_id;
            $this->store_id = $store_id;
            $this->$app();
            exit;
        }else{
            echo json_encode(array('code' => 404, 'message' => '请登录！'));
            exit;
        }
        exit;
    }

    public function getRequestMethods(){
        return Request :: POST;
    }
    // 地址管理
    public function index(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $user_id = $this->user_id;
        // 根据用户id,查询地址表
        $sql = "select * from lkt_user_address where store_id = '$store_id' and uid = '$user_id'";
        $r = $db->select($sql);
        if($r){
            foreach ($r as $k => $v){
                $r[$k]->addr_id = $v->id;
            }
            echo json_encode(array('code'=>200,'adds'=>$r,'message'=>'成功！'));
            exit();
        }else{
            echo json_encode(array('code'=>108,'message'=>'暂无数据！'));
            exit;
        }

        return;
    }
    // 设置默认
    public function set_default(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $addr_id = $request->getParameter('addr_id'); // 地址id
        $user_id = $this->user_id;

        $sql = "update lkt_user_address set is_default = 0 where store_id = '$store_id' and uid = '$user_id'";
        $r = $db->update($sql);

        $sql = "update lkt_user_address set is_default = 1 where store_id = '$store_id' and uid = '$user_id' and id = '$addr_id'";
        $rr = $db->update($sql);
        if($rr > 0){
            echo json_encode(array('code'=>200,'message'=>'成功!'));
            exit();
        }else{
            echo json_encode(array('code'=>103,'message'=>'网络繁忙'));
            exit();
        }

        return;
    }

    // 删除地址
    public function del_adds(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        // 获取信息
        $store_id = trim($request->getParameter('store_id'));

        $addr_id = $request->getParameter('addr_id'); // 地址id
        $user_id = $this->user_id;

        $sql01= "select is_default from lkt_user_address where store_id = '$store_id' and id = '$addr_id'";
        $r01 = $db ->select($sql01);
        if(!empty($r01)){
            $is_default = $r01[0]->is_default;
            $sql = "delete from lkt_user_address where store_id = '$store_id' and uid = '$user_id' and id = '$addr_id'";
            $r = $db->delete($sql);
            if($is_default == 1){//默认
                $sql = "update lkt_user_address set is_default = 1 where store_id = '$store_id' and uid = '$user_id' order by id desc limit 1";
                $db->update($sql);
            }
            // 根据用户id,查询地址表

            if($r > 0){
                echo json_encode(array('code'=>200,'message'=>'成功!'));
                exit();
            }else{
                echo json_encode(array('code'=>103,'message'=>'网络繁忙'));
                exit();
            }
        }

        return;
    }

    // 修改地址
    public function up_adds(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $addr_id = $request->getParameter('addr_id'); // 地址id
        $user_name = $request->getParameter('user_name'); //  联系人
        $mobile = $request->getParameter('mobile'); // 联系电话
        $place = $request->getParameter('place'); // 地址
        $address = $request->getParameter('address'); // 详细地址
        $is_default1 = $request->getParameter('is_default'); // 地址状态

        $user_id = $this->user_id;

        $sql = "select * from lkt_user_address where store_id = '$store_id' and id = '$addr_id'"; //查询修改前的详细地址
        $r = $db->select($sql);
        $code = 0;//
        $uid = $r[0]->uid;//用户ID
        $is_default = $r[0]->is_default;//是否默认地址

        $place_array=explode('-',$place);

        $province = $place_array['0']; // 省
        $city =  $place_array['1']; // 市
        $county =  $place_array['2']; //县

        $address_xq = $province . $city . $county . $address; // 带省市县的详细地址
//        if(preg_match("/^1[34578]\d{9}$/", $mobile)){
        if(preg_match("/^(13[0-9]|14[579]|15[0-3,5-9]|16[6]|17[0135678]|18[0-9]|19[89])\\d{8}$/", $mobile)){

            if($is_default1 == 1){ // 当修改地址状态为默认时
                $sql = "update lkt_user_address set is_default = 0 where store_id = '$store_id' and uid = '$user_id'";
                $db->update($sql);

                $sql04 = "update lkt_user_address set name = '$user_name',tel= '$mobile',sheng='$province',city ='$city',quyu ='$county',address ='$address',address_xq ='$address_xq',code ='$code',uid ='$uid',is_default='$is_default1' where store_id = '$store_id' and id = '$addr_id'";
                $r04 = $db->update($sql04);
                if($r04 ==1){
                    echo json_encode(array('code'=>200,'message'=>'成功!'));
                }else{
                    echo json_encode(array('code'=>103,'message'=>'网络繁忙'));
                }
            }else{ // 当修改地址状态不为默认时
                if($is_default == 1){ // 该地址原来默认，而现在不为默认
                    $sql = "update lkt_user_address set is_default = 0 where store_id = '$store_id' and uid = '$user_id'";
                    $db->update($sql);

                    $sql = "update lkt_user_address set name = '$user_name',tel= '$mobile',sheng='$province',city ='$city',quyu ='$county',address ='$address',address_xq ='$address_xq',code ='$code',uid ='$uid',is_default = 1 where store_id = '$store_id' and uid = '$user_id' and id = '$addr_id'";
                    $rr = $db->update($sql);
                    if($rr > 0){
                        echo json_encode(array('code'=>200,'message'=>'成功!'));
                        exit();
                    }else{
                        echo json_encode(array('code'=>103,'message'=>'网络繁忙'));
                        exit();
                    }
                }else{ // 该地址原来不为默认，而现在也不为默认
                    $sql04 = "update lkt_user_address set name = '$user_name',tel= '$mobile',sheng='$province',city ='$city',quyu ='$county',address ='$address',address_xq ='$address_xq',code ='$code',uid ='$uid',is_default='$is_default' where store_id = '$store_id' and id = '$addr_id'";
                    $r04 = $db->update($sql04);
                    if($r04 >= 0){
                        echo json_encode(array('code'=>200,'message'=>'成功!'));
                    }else{
                        echo json_encode(array('code'=>103,'message'=>'网络繁忙'));
                    }
                }
            }
        }else{
            echo json_encode(array('code'=>117,'message'=>'手机号错误！'));
        }
        exit();

        return;
    }

    // 修改地址页面跳转显示
    public function up_addsindex(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        // 获取信息
        $addr_id = $request->getParameter('addr_id'); // 地址id

        $sql = "select * from lkt_user_address where store_id = '$store_id' and id = '$addr_id'"; //查询修改前的详细地址
        $r = $db->select($sql);
        $province = $r[0]->sheng;//省
        $city = $r[0]->city;//市
        $county = $r[0]->quyu;//县

        $data = array('address'=>$r[0],'province'=>$province,'city_id'=>$city,'county'=>$county);
        echo json_encode(array('code'=>200,'data'=>$data,'message'=>'成功!'));
        exit();
        return;
    }
    //显示省份
    public function AddressManagement(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        // 查询省
        $sql = "select  *  from admin_cg_group a  where a.G_ParentID=0";
        $rr = $db->select($sql);
        foreach ($rr as $k => $v) {
            $result = array();
            $result['GroupID'] = $v->GroupID; // 编号
            $result['G_CName'] = $v->G_CName; // 省名
            $result['G_ParentID'] = $v->G_ParentID; // 类型
            $sheng[] = $result;
            unset($result); // 销毁指定变量
        }
        echo json_encode(array('code'=>200,'sheng'=>$sheng,'message'=>'成功!'));
        exit();

        return;
    }
    // 根据省查询市
    public function getCityArr(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $GroupID = $request->getParameter('GroupID'); // 省ID

        if(empty($GroupID)){
            echo json_encode(array('code'=>109,'message'=>'参数错误'));
            exit;
        }

        if($GroupID == ''){
            $GroupID = 2;
        }else{
            $GroupID = $GroupID;
        }

        // 根据省查询市
        $sql = "select * from admin_cg_group a where a.G_ParentID='$GroupID'";
        $r = $db->select($sql);
        foreach ($r as $k => $v) {
            $result = array();
            $result['GroupID'] = $v->GroupID; // 编号
            $result['G_CName'] = $v->G_CName; // 市名
            $result['G_ParentID'] = $v->G_ParentID; // 类型
            $shi[] = $result;
            unset($result); // 销毁指定变量
        }
        echo json_encode(array('code'=>200,'shi'=>$shi,'message'=>'成功!'));
        exit();

    }
    // 根据省市获取县
    public function getCountyInfo(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));

        $GroupID = $request->getParameter('GroupID'); // 省ID

        if(empty($GroupID)){
            echo json_encode(array('code'=>109,'message'=>'参数错误'));
            exit;
        }

        // 根据市查询县
        $sql = "select * from admin_cg_group a where a.G_ParentID='$GroupID'";
        $r = $db->select($sql);
        foreach ($r as $k => $v) {
            $result = array();
            $result['GroupID'] = $v->GroupID; // 编号
            $result['G_CName'] = $v->G_CName; // 县名
            $result['G_ParentID'] = $v->G_ParentID; // 类型
            $xian[] = $result;
            unset($result); // 销毁指定变量
        }
        echo json_encode(array('code'=>200,'xian'=>$xian,'message'=>'成功!'));
        exit();

        return;
    }

    // 添加地址点击保存
    public function SaveAddress(){
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_id = trim($request->getParameter('store_id'));
        $user_name = addslashes(trim($request->getParameter('user_name'))); //  联系人
        $mobile = addslashes(trim($request->getParameter('mobile'))); // 联系电话
        
        $address =addslashes(trim($request->getParameter('address'))); // 详细地址
        $is_default1 = $request->getParameter('is_default'); // 地址状态
        $user_id = $this->user_id;

        $place = $request->getParameter('place');

        $place_array=explode('-',$place);

        $province = $place_array['0']; // 省
        $city =  $place_array['1']; // 市
        $county =  $place_array['2']; //县

        $address_xq = $province.$city.$county.$address;

        if(Tools::check_phone($mobile)){
            // 根据微信id,查询会员id
            $sql = "select id from lkt_user_address where store_id = '$store_id' and uid = '$user_id'";
            $r = $db->select($sql);
            if($r){
                if($is_default1 == 1){
                    $sql = "update lkt_user_address set is_default = 0 where store_id = '$store_id' and uid = '$user_id'";
                    $db->update($sql);

                    $sql = "insert into lkt_user_address(store_id,name,tel,sheng,city,quyu,address,address_xq,uid,is_default) values('$store_id','$user_name','$mobile','$province','$city','$county','$address','$address_xq','$user_id',1)";
                    $rr = $db->insert($sql,'last_insert_id');
                }else{
                    $sql = "insert into lkt_user_address(store_id,name,tel,sheng,city,quyu,address,address_xq,uid,is_default) values('$store_id','$user_name','$mobile','$province','$city','$county','$address','$address_xq','$user_id',0)";
                    $rr = $db->insert($sql,'last_insert_id');
                }
            }else{
                $sql = "insert into lkt_user_address(store_id,name,tel,sheng,city,quyu,address,address_xq,uid,is_default) values('$store_id','$user_name','$mobile','$province','$city','$county','$address','$address_xq','$user_id',1)";
                $rr = $db->insert($sql,'last_insert_id');
            }
            if($rr >= 0){
                echo json_encode(array('code'=>200,'address_id'=>$rr,'message'=>'成功'));
                exit();
            } else {
                echo json_encode(array('code'=>101,'message'=>'未知错误！'));
                exit();
            }
        }else{
            echo json_encode(array('code'=>117,'message'=>'手机号错误！'));
            exit();
        }
        return;
    }

}
?>

