<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');

class userflexAction extends Action {

    public $store_id;
    public $userAuth;
    public $db;

    public function getDefaultView() {

        $db = DBAction::getInstance();
        $this->db = $db;
        $request = $this->getContext()->getRequest();  
        $m = trim($request->getParameter('m'));
        if($m){
            //软件类型
            $store_type = $this->getContext()->getStorage()->read('store_type');
            // //用户id
            $store_id = $this->getContext()->getStorage()->read('store_id');
            $Navbar = new Navbar;

            $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'user_page_data'";
            $res = $db->select($sql);
                    
            // 查询小程序配置
            // $store_id = $this->getContext()->getStorage()->read('store_id');
            $sql= "select * from lkt_config where store_id = '$store_id'";
            $r = $db->select($sql);
                    
            if($r){
                $this->config = $r[0];
                $uploadImg_domain = $r[0]->uploadImg_domain; // 图片上传域名
                $uploadImg = $r[0]->uploadImg; // 图片上传位置
                if(strpos($uploadImg,'./') === false){ // 判断字符串是否存在 ../
                        $img = $uploadImg_domain . $uploadImg; // 图片路径
                }else{
                        $img = $uploadImg_domain . substr($uploadImg,1); // 图片路径
                }
            }
            $user_page_data = $res ? $res[0]->value:json_encode($Navbar->get_user_pages());
            $data = json_decode($user_page_data);

            $menu_list = $Navbar->link();

            foreach ($menu_list as $key => $value) {
                $menu_list[$key]['icon'] = 'https://web-1252524862.cos.ap-guangzhou.myqcloud.com/icon/'.$value['icon'];
            }

            echo json_encode(array('data' => $data,'menu_list' =>$menu_list,'code'=>0));
            exit;

        }
        return View :: INPUT;

    }



    public function execute() {
        $db = DBAction::getInstance();
        $this->db = $db;
        $request = $this->getContext()->getRequest();  
        $module_list = trim($request->getParameter('data'));
        //软件类型
        $store_type = $this->getContext()->getStorage()->read('store_type');
        // //用户id
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // var_dump($_POST);  
        // exit; 
        // $store_type = '1';
        // $store_id = '1';


        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'user_page_data'";
        $hres = $db->select($sql);

        if($hres){
            $sql_update_listr = "update lkt_option set value = '$module_list' where store_id = '$store_id' and `group` = '$store_type' and name = 'user_page_data' ";
            $res_update_list=$db->update($sql_update_listr);
        }else{
            $sql_update_listr = "INSERT INTO `lkt_option` (`store_id`, `group`, `name`, `value`) VALUES ('$store_id', '$store_type', 'user_page_data', '$module_list') ";
            $res_update_list=$db->insert($sql_update_listr);
        }

        if($res_update_list){
            echo json_encode(array('code'=>0,'msg'=>'修改成功！'));
            exit();
        }else{
            echo json_encode(array('code'=>0,'msg'=>'修改失败！'));
            exit();
        }

    }



    public function getRequestMethods(){

        return Request :: POST;

    }




}



?>