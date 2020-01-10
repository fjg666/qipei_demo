<?php
/**
 * [Laike System] Copyright (c) 2018 laiketui.com
 * Laike is not a free software, it under the license terms, visited http://www.laiketui.com/ for more details.
 */
require_once(MO_LIB_DIR . '/DBAction.class.php');
require_once(MO_LIB_DIR . '/Navbar.class.php');

class indexflexAction extends Action
{

    public $store_id;
    public $userAuth;
    public $db;

    public function getContent($name)
    {
        $content = false;
        switch ($name) {
            case 'banner':
                {
                    $content = '<div class="home-block">
    <div class="block-content">
        <div class="block-name">幻灯片</div>
    </div>
    <img class="block-img" src="style/diy_img/banner-bg.png">
</div>';
                    break;
                }
            case 'search':
                {
                    $content = '<div style="text-align: center;position: relative">
    <div style="position: absolute;left: 0;top: 0;width: 100%;height: 100%;z-index:1;padding: 6px">
        <div style="color: #fff;text-shadow: 0 0 1px rgba(0,0,0,.8);font-weight: bold"></div>
    </div>
    <img src="style/diy_img/search-bg.png" style="width: 100%;height: auto">
</div>';
                    break;
                }
            case 'nav':
                {
                    $content = '<div class="home-block">
    <div class="block-content">
        <div class="block-name">导航图标</div>
    </div>
    <img class="block-img" src="style/diy_img/nav-bg.png">
</div>';
                    break;
                }
            case 'coupon':
                {
                    $content = '<div class="home-block">
    <div class="block-content">
        <div class="block-name">领券中心</div>
    </div>
    <img class="block-img" src="style/diy_img/coupon-bg.png" style="width: 100%;height: auto">
</div>';
                    break;
                }
            case 'topic':
                {
                    $content = '<div class="home-block">
    <div class="block-content">
        <div class="block-name">专题</div>
    </div>
    <img class="block-img" src="style/diy_img/topic-bg.png">
</div>';
                    break;
                }
            case 'pintuan':
                {
                    $content = '<div class="home-block">
    <div class="block-content">
        <div class="block-name">拼团</div>
    </div>
    <img class="block-img" src="style/diy_img/pintuan-bg.png">
</div>';
                    break;
                }
            case 'notice':
                {
                    $content = '<div class="home-block">
    <div class="block-content">
        <div class="block-name">公告</div>
    </div>
    <img class="block-img" src="style/diy_img/notice-bg.png">
</div>';
                    break;
                }
            case 'cat':
                {
                    $content = '<div class="home-block">
 <div class="block-content">
                     <div class="block-name">分类</div>
             </div>
    <img class="block-img" src="style/diy_img/cat-bg.png">
 </div>';
                    break;
                }
            default:
                {

                    $names = explode('-', $name);
                    $name = $names[0];
                    $id = $names[1];
                    $content = '<div style="padding: 1rem;text-align: center;color: #888">无内容</div>';
                    if ($name == 'block') {//自定义首页板块
                        $block = $this->HomeBlock_findOne($id);
                        $content = '<div class="home-block"><div class="block-content"><div class="block-name">版块：' . $block . '</div></div><img class="block-img" src="style/diy_img/block-bg.png"></div>';
                    }

                    if ($name == 'single_cat') {//单个分类
                        $cat = $this->Cat_findOne($id);
                        $content = '<div class="home-block"><div class="block-content"><div class="block-name">分类:' . $cat . '</div> </div><img class="block-img" src="style/diy_img/cat-bg.png"></div>';
                    }

                    break;
                }
        }
        return $content;
    }

    public function HomeBlock_findOne($id)
    {
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql_c = "select name from lkt_index_page where store_id = '$store_id' and id = '$id' ";
        $r_c = $this->db->select($sql_c);
        return $r_c ? $r_c[0]->name : '';
    }

    public function Cat_findOne($cid)
    {
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql_c = "select cid,pname from lkt_product_class where store_id = '$store_id' and recycle = 0 and cid= '$cid' ";
        $r_c = $this->db->select($sql_c);
        return $r_c ? $r_c[0]->pname : '';
    }

    public function search($module_list = false)
    {
        if (!$module_list) {
            $module_list = $this->getModuleList();
        }
        foreach ($module_list as $i => $item) {
            $content = $this->getContent($item['name']);
            $module_list[$i]['content'] = $content ? $content : '<div style="padding: 1rem;text-align: center;color: #888">无内容</div>';
        }
        return $module_list;
    }


    public function getModuleList()
    {
        $mustModule = Navbar::module_list('mustModule');
        // $this->module_list['mustModule']; $authModule = $this->module_list['authModule'];
        $authModule = Navbar::module_list('authModule');

        $db = DBAction::getInstance();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        //查询分类 顶级
        $sql_c = 'select cid,pname from lkt_product_class where store_id= ' . $store_id . ' and recycle = 0 and sid=0 order by sort desc';
        $r_c = $db->select($sql_c);
        foreach ($r_c as $key => $value) {
            $arrayName = array('name' => 'single_cat-' . $value->cid, 'display_name' => '分类:' . $value->pname);
            array_push($mustModule, $arrayName);
        }

        //自定义模块
        $sql = "select id,name from lkt_index_page where store_id = '$store_id' and `store_type` = '$store_type' ";
        $r_index = $db->select($sql);
        foreach ($r_index as $key => $value) {
            $arrayName = array('name' => 'block-' . $value->id, 'display_name' => '版块：' . $value->name);
            array_push($mustModule, $arrayName);
        }

        $newArr = [];
        foreach ($authModule as $item) {
            $newArr[] = $item;
        }

        $module = array_merge($mustModule, $newArr);

        return $module;
    }


    public function getDefaultView()
    {

        $db = DBAction::getInstance();
        $this->db = $db;
        $request = $this->getContext()->getRequest();
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');
        // 根据插件id，查询插件信息

        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'home_page_data'";
        $home_page_data_res = $db->select($sql);

        // 查询小程序配置
        $sql = "select * from lkt_config where store_id = '$store_id'";
        $r = $db->select($sql);

        if ($r) {
            $this->config = $r[0];
            $uploadImg_domain = $r[0]->uploadImg_domain; // 图片上传域名
            $uploadImg = $r[0]->uploadImg; // 图片上传位置
            if (strpos($uploadImg, '../') === false) { // 判断字符串是否存在 ../
                $img = $uploadImg_domain . $uploadImg; // 图片路径
            } else {
                $img = $uploadImg_domain . substr($uploadImg, 2); // 图片路径
            }
        }
        $home_page_datas = [];
        if ($home_page_data_res) {
            $raes = json_decode($home_page_data_res[0]->value);
            foreach ($raes as $key => $value) {
                $aaa = (array)$value;
                array_push($home_page_datas, array('name' => $aaa['name']));
            }
        }

        $home_page_data = json_encode($this->search($home_page_datas));
        $module_list = json_encode($this->search());
        $request->setAttribute("module_list", $module_list);
        $request->setAttribute("home_page_data", $home_page_data);
        return View :: INPUT;

    }


    public function execute()
    {
        $db = DBAction::getInstance();
        $this->db = $db;
        $request = $this->getContext()->getRequest();
        $module_list = trim($request->getParameter('module_list'));
        $store_type = $this->getContext()->getStorage()->read('store_type');
        $store_id = $this->getContext()->getStorage()->read('store_id');

        $sql = "select * from lkt_option where store_id = '$store_id' and `group` = '$store_type' and name = 'home_page_data'";
        $hres = $db->select($sql);

        if ($hres) {
            $sql_update_listr = "update lkt_option set value = '$module_list' where store_id = '$store_id' and `group` = '$store_type' and name = 'home_page_data' ";
            $res_update_list = $db->update($sql_update_listr);
        } else {
            $sql_update_listr = "INSERT INTO `lkt_option` (`store_id`, `group`, `name`, `value`) VALUES ('$store_id', '$store_type', 'home_page_data', '$module_list') ";
            $res_update_list = $db->insert($sql_update_listr);
        }

        if ($res_update_list) {
            echo json_encode(array('code' => 0, 'msg' => '修改成功！'));
            exit();
        } else {
            echo json_encode(array('code' => 0, 'msg' => '修改失败！'));
            exit();
        }

    }


    public function getRequestMethods()
    {

        return Request :: POST;

    }


}


?>