<?php

/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */

require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');


class navigationAction extends Action {

    public $userAuth;
    //公用权限
    /**
     * [getDefaultView description]
     * <p>Copyright (c) 2018-2019</p>
     * <p>Company: www.laiketui.com</p>
     * @Author  苏涛
     * @version 2.0
     * @date    2018-12-28T10:43:46+0800
     * @return  小程序底部导航栏设置
     */
    public function getDefaultView() {
        $request = $this->getContext()->getRequest();
        $m = $request->getParameter('m');
        if($m){
            if($m == 'getNavbar'){
                $this->getNavbar();
            }else if($m == 'show_pages'){
                $this->show_pages();
            }

            exit;
        }
        return View :: INPUT;
    }

    public function show_pages()
    {
        $app_json = file_get_contents(MO_LIB_DIR.'/app.json');
        $pages_json = json_decode($app_json);

        $request = $this->getContext()->getRequest();
        $type = $request->getParameter('type');
        if($type){
            $this->getPickLink();
        }else{
            $this->getNavPickLink();
        }
        exit;
    }


    /**
     * 小程序菜单跳转链接
     * @return mixed|string
     */
    public function getPickLink()
    {
        $nav = new Navbar();
        $link = $nav->link();

        $pickLink = $nav->resetPickLink($link, $this->userAuth);

        echo json_encode($pickLink);
    }

    /**
     * 小程序底部导航链接
     */
    public function getNavPickLink()
    {
        $nav = new Navbar();

        $navLink = $nav->navLink();

        $navPickLink = $nav->resetPickLink($navLink, $this->userAuth);

        echo json_encode($navPickLink);
    }

    public function setNavbar($navbar)
    {
        if(isset($navbar['navs'])){
            foreach ($navbar['navs'] as $index => $value) {
                if ($value['open_type'] == 'web') {
                    $navbar['navs'][$index]['web'] = urlencode($value['web']);
                }
            }
        }
        return json_encode($navbar,JSON_UNESCAPED_UNICODE);
    }


    public function getNavbar() {
        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');

        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 根据插件id，查询插件信息

        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'navbar'";
        $Navbar_res = $db->select($sql);

        // 查询小程序配置
        $sql1 = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql1);

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

        $Nav_bar = new Navbar();
		// var_dump($Navbar_res);
        if($Navbar_res){
            $Navbar = json_decode($Navbar_res[0]->value);
        }else{
            $Navbar = $Nav_bar->getNavbar($db,$img);
        }
        $sql_navigation_bar_color = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'navigation_bar_color'";
        $res_navigation_bar_color = $db->select($sql_navigation_bar_color);
        if($res_navigation_bar_color){
            $navigation_bar_color = $res_navigation_bar_color[0]->value;
        }else{
            $navigation_bar_color =  '{"frontColor":"#000000","backgroundColor":"#ffffff","bottomBackgroundColor":"#ffffff"}';
        }
        $data = array('navbar'=>$Navbar,'navigation_bar_color'=>json_decode($navigation_bar_color));
        echo json_encode(array('code'=>0,'data'=>$data));
        exit();
    }

    public function execute(){

        $db = DBAction::getInstance();
        $request = $this->getContext()->getRequest();

        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $navigation_bar_color = $request->getParameter('navigation_bar_color');
        $navbar = $request->getParameter('navbar');

        if (empty($navbar['navs'])) {
            $navbar['navs'] = [];
        }
        $new_navs = [];
        foreach ($navbar['navs'] as $i => $nav) {
            $nav['active_icon'] = $nav['active_icon'] ? $nav['active_icon'] : $nav['icon'];
            $nav['active_color'] = $nav['active_color'] ? $nav['active_color'] : $nav['color'];
            $new_navs[] = $nav;
        }

        $navbar['navs'] = $new_navs;

        // 接收信息
        $Nav_bar = new Navbar();
        $v_navbar = $Nav_bar->encode($navbar);
        $sql_navbar = "update lkt_option set value = '$v_navbar' where store_id = '$store_id' and `group` = '$store_type' and name = 'navbar' ";
        $v_navigation_bar_color = $Nav_bar->encode($navigation_bar_color);
        //判断是否存在  存在则修改 不存在则添加

        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'navbar'";
        $Navbar_res = $db->select($sql);
        if($Navbar_res){
            $sql_navigation_bar_color = "update lkt_option set value = '$v_navigation_bar_color' where store_id = '$store_id' and `group` = '$store_type' and name = 'navigation_bar_color' ";
            $res_navigation_bar_color=$db->update($sql_navigation_bar_color);
            $res_navbar=$db->update($sql_navbar);
        }else{
            $sql_navigation_bar_color = "INSERT INTO `lkt_option` (`store_id`, `group`, `name`, `value`) VALUES ('$store_id', '$store_type', 'navbar', '$v_navbar') ";
            $sql_navbar = " INSERT INTO `lkt_option` (`store_id`, `group`, `name`, `value`) VALUES ('$store_id', '$store_type', 'navigation_bar_color', '$v_navigation_bar_color')";

            $res_navigation_bar_color=$db->insert($sql_navigation_bar_color);
            $res_navbar=$db->insert($sql_navbar);
        }

        if($res_navigation_bar_color || $res_navbar){
            echo json_encode(array('code'=>0,'msg'=>'操作成功！'));
            exit();
        }else{
            echo json_encode(array('code'=>0,'msg'=>'操作失败！'));
            exit();
        }

    }



    public function getRequestMethods(){

        return Request :: POST;

    }



}



?>